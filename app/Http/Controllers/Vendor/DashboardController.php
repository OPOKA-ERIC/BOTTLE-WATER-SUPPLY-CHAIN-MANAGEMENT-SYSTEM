<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorApplication;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Rules\ValidPdfFile;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $application = VendorApplication::where('user_id', $user->id)->latest()->first();
        
        $stats = [
            'total_applications' => VendorApplication::where('user_id', $user->id)->count(),
            'approved_applications' => VendorApplication::where('user_id', $user->id)->where('status', 'approved')->count(),
            'rejected_applications' => VendorApplication::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        $recentApplications = VendorApplication::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('vendor.dashboard', [
            'stats' => $stats,
            'application' => $application,
            'recentApplications' => $recentApplications,
            'title' => 'BWSCMS',
            'activePage' => 'dashboard',
            'activeButton' => 'laravel',
        ]);
    }

    public function applications()
    {
        $user = auth()->user();
        $applications = VendorApplication::with('user', 'reviewer')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('vendor.applications.index', [
            'applications' => $applications,
            'title' => 'Vendor Applications',
            'activePage' => 'applications',
            'activeButton' => 'laravel',
            'navName' => 'Vendor Applications',
        ]);
    }

    public function showApplication($id)
    {
        $application = VendorApplication::with('user', 'reviewer')->findOrFail($id);
        
        return view('vendor.applications.show', [
            'application' => $application,
            'title' => 'Application Details',
            'activePage' => 'applications',
            'activeButton' => 'laravel',
            'navName' => 'Application Details',
        ]);
    }

    public function createApplication()
    {
        return view('vendor.applications.create', [
            'title' => 'Submit Vendor Application',
            'activePage' => 'applications',
            'activeButton' => 'laravel',
            'navName' => 'Submit Application',
        ]);
    }

    public function storeApplication(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'pdf_file' => ['required', 'file', new ValidPdfFile, 'max:10240'], // 10MB max, PDF only
        ], [
            'pdf_file.required' => 'A PDF document is required for vendor validation.',
            'pdf_file.file' => 'The uploaded file must be a valid file.',
            'pdf_file.max' => 'The PDF file size must not exceed 10MB.',
            'description.min' => 'Please provide a detailed business description (minimum 10 characters).',
        ]);

        try {
            // Store PDF file
            $pdfPath = $request->file('pdf_file')->store('vendor-applications', 'public');

            // Create application record
            $application = VendorApplication::create([
                'user_id' => auth()->id(),
                'business_name' => $request->business_name,
                'business_type' => $request->business_type,
                'description' => $request->description,
                'pdf_document_path' => $pdfPath,
                'status' => 'pending',
                'submitted_at' => now(),
            ]);

            // Send to Java validation server
            $validationResult = $this->sendToValidationServer($application, $request->file('pdf_file'));
            
            if ($application->status === 'approved') {
                $scoreMsg = 'Your validation scores - Financial: ' . ($application->financial_score === 1 ? '✔️' : '❌') . ', Reputation: ' . ($application->reputation_score === 1 ? '✔️' : '❌') . ', Compliance: ' . ($application->compliance_score === 1 ? '✔️' : '❌') . ', Overall: ' . ($application->overall_score !== null ? $application->overall_score : '❓');
                return redirect()->route('vendor.applications.show', $application->id)
                    ->with('success', 'Congratulations! Your application has been approved. You are now eligible to become a supplier. Please log out and log in again to access supplier features. ' . $scoreMsg);
            } elseif ($application->status === 'rejected') {
                return redirect()->route('vendor.applications.show', $application->id)
                    ->with('error', 'Application rejected: ' . ($application->rejection_reason ?? 'Validation failed.'));
            } else {
                return redirect()->route('vendor.applications.show', $application->id)
                    ->with('warning', 'Vendor application submitted successfully. Automatic validation is currently unavailable. Your application will be reviewed manually.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error submitting application: ' . $e->getMessage())->withInput();
        }
    }

    private function sendToValidationServer($application, $pdfFile)
    {
        \Log::info('sendToValidationServer called', ['application_id' => $application->id]);
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(30)->attach(
                'file',
                file_get_contents($pdfFile->getRealPath()),
                $pdfFile->getClientOriginalName()
            )->post('http://localhost:8081/api/vendor/validate');

            $data = null;
            $criteria = [];
            if ($response->header('Content-Type') && str_contains($response->header('Content-Type'), 'application/json')) {
                $data = $response->json();
                $criteria = $data['criteria'] ?? [];
            } else {
                // Try to decode body as JSON anyway
                $data = json_decode($response->body(), true);
                $criteria = $data['criteria'] ?? [];
            }
            // Log the raw response, parsed data, and criteria for debugging
            \Log::info('Validation server raw response', ['body' => $response->body()]);
            \Log::info('Validation server parsed data', ['data' => $data]);
            \Log::info('Validation server criteria', ['criteria' => $criteria]);
            
            
            // Always update scores from criteria, even if not successful
            $application->update([
                'financial_score' => array_key_exists('financial', $criteria) ? ($criteria['financial'] ? 1 : 0) : 0,
                'reputation_score' => array_key_exists('reputation', $criteria) ? ($criteria['reputation'] ? 1 : 0) : 0,
                'compliance_score' => array_key_exists('regulatory', $criteria) ? ($criteria['regulatory'] ? 1 : 0) : 0,
            ]);
            $application->update([
                'overall_score' => $application->financial_score + $application->reputation_score + $application->compliance_score,
            ]);
            // Debug log the updated scores
            \Log::info('Updated application scores', [
                'id' => $application->id,
                'financial_score' => $application->financial_score,
                'reputation_score' => $application->reputation_score,
                'compliance_score' => $application->compliance_score,
                'overall_score' => $application->overall_score,
            ]);

            if ($data && isset($data['status']) && $data['status'] === 'APPROVED') {
                // Update application as approved and schedule facility visit 3 days from now
                $application->update([
                    'status' => 'approved',
                    'validated_at' => now(),
                    'rejection_reason' => null,
                    'scheduled_visit_date' => now()->addDays(3),
                    'visit_status' => 'scheduled',
                ]);
                return true;
            } else if ($data) {
                // Rejected: update application with reason
                $application->update([
                    'status' => 'rejected',
                    'validated_at' => now(),
                    'rejection_reason' => 'Failed validation criteria',
                    'scheduled_visit_date' => null,
                    'visit_status' => null,
                ]);
                return false;
            }

            \Log::error('Validation server response not successful: ' . $response->body());
            return false;

        } catch (\Exception $e) {
            \Log::error('Error sending to validation server: ' . $e->getMessage());
            return false;
        }
    }

    private function extractValidationData($application, $validatedApp)
    {
        // Extract financial data
        if (isset($validatedApp['annualRevenue'])) {
            $application->update(['annual_revenue' => $validatedApp['annualRevenue']]);
        }
        if (isset($validatedApp['netWorth'])) {
            $application->update(['net_worth' => $validatedApp['netWorth']]);
        }
        if (isset($validatedApp['yearsInBusiness'])) {
            $application->update(['years_in_business' => $validatedApp['yearsInBusiness']]);
        }
        if (isset($validatedApp['creditRating'])) {
            $application->update(['credit_rating' => $validatedApp['creditRating']]);
        }
        if (isset($validatedApp['hasBankruptcy'])) {
            $application->update(['has_bankruptcy' => $validatedApp['hasBankruptcy']]);
        }
        if (isset($validatedApp['hasTaxLiens'])) {
            $application->update(['has_tax_liens' => $validatedApp['hasTaxLiens']]);
        }

        // Extract reputation data
        if (isset($validatedApp['averageRating'])) {
            $application->update(['average_rating' => $validatedApp['averageRating']]);
        }
        if (isset($validatedApp['totalReviews'])) {
            $application->update(['total_reviews' => $validatedApp['totalReviews']]);
        }
        if (isset($validatedApp['hasLegalIssues'])) {
            $application->update(['has_legal_issues' => $validatedApp['hasLegalIssues']]);
        }
        if (isset($validatedApp['hasComplaints'])) {
            $application->update(['has_complaints' => $validatedApp['hasComplaints']]);
        }

        // Extract compliance data
        if (isset($validatedApp['hasBusinessLicense'])) {
            $application->update(['has_business_license' => $validatedApp['hasBusinessLicense']]);
        }
        if (isset($validatedApp['hasTaxRegistration'])) {
            $application->update(['has_tax_registration' => $validatedApp['hasTaxRegistration']]);
        }
        if (isset($validatedApp['hasInsurance'])) {
            $application->update(['has_insurance' => $validatedApp['hasInsurance']]);
        }
        if (isset($validatedApp['hasEnvironmentalCompliance'])) {
            $application->update(['has_environmental_compliance' => $validatedApp['hasEnvironmentalCompliance']]);
        }
        if (isset($validatedApp['hasSafetyCertification'])) {
            $application->update(['has_safety_certification' => $validatedApp['hasSafetyCertification']]);
        }
    }

    public function scheduleVisit($id)
    {
        $application = VendorApplication::findOrFail($id);
        
        return view('vendor.applications.schedule-visit', [
            'application' => $application,
            'title' => 'Schedule Facility Visit',
            'activePage' => 'applications',
            'activeButton' => 'laravel',
            'navName' => 'Schedule Facility Visit',
        ]);
    }

    public function storeVisitResult(Request $request, $id)
    {
        $request->validate([
            'visit_passed' => 'required|boolean',
            'visit_notes' => 'required|string',
        ]);

        $application = VendorApplication::findOrFail($id);
        
        $application->update([
            'visit_passed' => $request->visit_passed,
            'visit_notes' => $request->visit_notes,
            'visit_status' => 'completed',
        ]);

        // Update application status based on visit result
        if ($request->visit_passed) {
            $application->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
            
            // Update user role to supplier
            $application->user->update(['role' => 'supplier']);
            
            return redirect()->route('vendor.applications.show', $application->id)
                ->with('success', 'Facility visit completed successfully. Vendor approved!');
        } else {
            $application->update([
                'status' => 'rejected',
                'rejection_reason' => 'Failed facility visit: ' . $request->visit_notes,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
            
            return redirect()->route('vendor.applications.show', $application->id)
                ->with('error', 'Facility visit failed. Application rejected.');
        }
    }

    public function downloadPdf($id)
    {
        $application = VendorApplication::findOrFail($id);
        
        if (!$application->pdf_document_path) {
            return back()->with('error', 'PDF document not found.');
        }

        $path = storage_path('app/public/' . $application->pdf_document_path);
        
        if (!file_exists($path)) {
            return back()->with('error', 'PDF file not found.');
        }

        return response()->download($path, 'vendor_application_' . $application->id . '.pdf');
    }

    public function reports()
    {
        $user = auth()->user();

        // Only this vendor's applications
        $applications = VendorApplication::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_applications' => $applications->count(),
            'approved_applications' => $applications->where('status', 'approved')->count(),
            'rejected_applications' => $applications->where('status', 'rejected')->count(),
        ];

        return view('vendor.reports', [
            'applications' => $applications,
            'stats' => $stats,
            'user' => $user,
            'title' => 'Vendor Reports',
            'activePage' => 'reports',
            'activeButton' => 'laravel',
            'navName' => 'Vendor Reports',
        ]);
    }

    public function downloadReport()
    {
        $user = auth()->user();
        $applications = VendorApplication::with('reviewer')
            ->where('user_id', $user->id)
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('created_at', 'desc')
            ->get();

        $html = view('vendor.report_pdf', [
            'user' => $user,
            'applications' => $applications,
        ])->render();

        // If barryvdh/laravel-dompdf is installed, use it. Otherwise, return HTML for now.
        if (class_exists('Barryvdh\\DomPDF\\Facade\\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            return $pdf->download('vendor_report_' . $user->id . '.pdf');
        } else {
            // Fallback: return HTML with a note
            return response($html)->header('Content-Type', 'text/html');
        }
    }
}
