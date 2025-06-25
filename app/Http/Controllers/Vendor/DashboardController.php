<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorApplication;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $application = VendorApplication::where('user_id', $user->id)->first();
        
        $stats = [
            'total_applications' => VendorApplication::count(),
            'pending_applications' => VendorApplication::pending()->count(),
            'approved_applications' => VendorApplication::approvedForVisit()->count(),
            'rejected_applications' => VendorApplication::rejected()->count(),
        ];

        $recentApplications = VendorApplication::with('user')
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
        $applications = VendorApplication::with('user', 'reviewer')
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
            'description' => 'required|string',
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
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
            $this->sendToValidationServer($application, $request->file('pdf_file'));

            return redirect()->route('vendor.applications.show', $application->id)
                ->with('success', 'Vendor application submitted successfully and sent for validation.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error submitting application: ' . $e->getMessage());
        }
    }

    private function sendToValidationServer($application, $pdfFile)
    {
        try {
            $response = Http::attach(
                'pdfFile',
                file_get_contents($pdfFile->getRealPath()),
                $pdfFile->getClientOriginalName()
            )->post('http://localhost:8081/vendor-validation/api/vendor-validation/validate', [
                'businessName' => $application->business_name,
                'businessType' => $application->business_type,
                'description' => $application->description,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['success']) {
                    $validatedApp = $data['application'];
                    \Log::info('Validation result:', $validatedApp);
                    // Update application with validation results
                    $application->update([
                        'status' => $validatedApp['status'],
                        'financial_score' => $validatedApp['financialScore'] ?? null,
                        'reputation_score' => $validatedApp['reputationScore'] ?? null,
                        'compliance_score' => $validatedApp['complianceScore'] ?? null,
                        'overall_score' => $validatedApp['overallScore'] ?? null,
                        'scheduled_visit_date' => $validatedApp['scheduledVisitDate'] ?? null,
                        'visit_status' => $validatedApp['visitStatus'] ?? 'pending',
                        'validated_at' => now(),
                    ]);

                    // Extract and store detailed validation data
                    $this->extractValidationData($application, $validatedApp);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error sending to validation server: ' . $e->getMessage());
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
        $stats = [
            'total_applications' => VendorApplication::count(),
            'pending_applications' => VendorApplication::pending()->count(),
            'approved_applications' => VendorApplication::where('status', 'approved')->count(),
            'rejected_applications' => VendorApplication::rejected()->count(),
            'visit_scheduled' => VendorApplication::visitScheduled()->count(),
            'visit_completed' => VendorApplication::visitCompleted()->count(),
        ];

        $applicationsByStatus = VendorApplication::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $applicationsByMonth = VendorApplication::selectRaw('MONTH(created_at) as month, count(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        return view('vendor.reports', [
            'stats' => $stats,
            'applicationsByStatus' => $applicationsByStatus,
            'applicationsByMonth' => $applicationsByMonth,
            'title' => 'Vendor Reports',
            'activePage' => 'reports',
            'activeButton' => 'laravel',
            'navName' => 'Vendor Reports',
        ]);
    }
}
