<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->status === 'inactive') {
            auth()->logout();
            return back()->with('error', 'Your account is inactive. Please contact the administrator.');
        }

        // Promote vendor to supplier if they have an approved application
        if ($user->role === 'vendor' && \App\Models\VendorApplication::where('user_id', $user->id)->where('status', 'approved')->exists()) {
            $user->role = 'supplier';
            $user->save();
            session()->flash('success', 'You have been promoted to supplier! You now have access to supplier features.');
        }

        return redirect()->route($user->getDashboardRoute());
    }
}
