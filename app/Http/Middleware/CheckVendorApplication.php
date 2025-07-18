<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckVendorApplication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        
        // Only apply this check to vendors
        if ($user->role === 'vendor') {
            // Skip the check for application-related routes
            $excludedRoutes = [
                'vendor.applications.create',
                'vendor.applications.store',
                'vendor.applications.show',
                'vendor.applications.index',
                'vendor.dashboard', // Allow access to dashboard to see application status
                'vendor.reports', // Allow access to reports page
                'vendor.reports.download', // Allow access to download report
            ];
            
            if (!in_array($request->route()->getName(), $excludedRoutes)) {
                $hasValidApplication = \App\Models\VendorApplication::where('user_id', $user->id)
                    ->whereNotNull('pdf_document_path')
                    ->where('status', '!=', 'rejected')
                    ->exists();
                
                if (!$hasValidApplication) {
                    return redirect()->route('vendor.applications.create')
                        ->with('warning', 'You must submit a vendor application with a PDF document before accessing this area.');
                }
            }
        }
        
        return $next($request);
    }
} 