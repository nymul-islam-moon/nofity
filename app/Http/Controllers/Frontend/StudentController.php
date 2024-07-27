<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    public function index() {
        return view('frontend.index');
    }

    public function login() {
        return view('frontend.auth.login');
    }

    public function login_store(Request $request) {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in
        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            // If successful, redirect to the intended location
            return redirect()->intended(route('frontend.student.index'))->with('success', 'Student Login Successful');
        }

        // If unsuccessful, redirect back with form data
        return back()->withErrors(['email' => 'These credentials do not match our records.'])->withInput($request->only('email', 'remember'));
    }


    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        return redirect()->route('frontend.student.login')->with('success', 'Student Logout Successfully');
    }

}
