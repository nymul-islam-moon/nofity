<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Student
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
        // Check if the student is authenticated
        if (Auth::guard('student')->check()) {
            // Get the authenticated student
            $student = Auth::guard('student')->user();

            // Check if email is verified and status is true
            if ($student->email_verified_at && $student->status) {
                return $next($request); // Proceed to the requested route
            } else {
                Auth::guard('student')->logout(); // Logout the student if conditions are not met
            }
        }

        // Redirect to login with error message if not authenticated or conditions not met
        return redirect()->route('frontend.student.login')->with('error', 'Please login with your varified Email and authenticate password.');
    }
}
