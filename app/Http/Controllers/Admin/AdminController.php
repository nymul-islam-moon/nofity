<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function admin()
    {
        $title = 'Dashboard';
        return view('admin.home', compact( 'title' ));
    }

    /**
     * Admin Custome Logout
     */

     public function logout()
     {
        Auth::logout();

        $notification = array('message' => 'You are logged out!', 'alert-type' => 'success');

        return redirect()->route('admin.login')->with($notification);
     }
}
