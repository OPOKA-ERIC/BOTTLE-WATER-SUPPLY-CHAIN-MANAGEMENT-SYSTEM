<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // If user is trying to access a different role's route
            if ($request->is('admin/*') && !$user->isAdmin()) {
                return redirect()->route($user->getDashboardRoute());
            }
            if ($request->is('supplier/*') && !$user->isSupplier()) {
                return redirect()->route($user->getDashboardRoute());
            }
            if ($request->is('manufacturer/*') && !$user->isManufacturer()) {
                return redirect()->route($user->getDashboardRoute());
            }
            if ($request->is('retailer/*') && !$user->isRetailer()) {
                return redirect()->route($user->getDashboardRoute());
            }
        }

        return $next($request);
    }
} 