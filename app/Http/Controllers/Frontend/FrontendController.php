<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\StudentVerificationMail;
use App\Models\Notification;
use App\Models\Student;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::where('status', 1);

        if ($request->has('search') && !is_null($request->input('search'))) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('short_description', 'LIKE', '%' . $search . '%')
                ->orWhereJsonContains('tags', $search);
            });
        }

        if ($request->has('tag') && $request->input('tag') != 0) {
            $tagId = $request->input('tag');

            $query->whereJsonContains('tags', $tagId);
        }

        $tags = Tag::where('status', 1)->get();

        $notifications = $query->simplePaginate(10);

        $notifications->each(function ($notification) {
            $tagIds = json_decode($notification->tags);
            $notification->tagNames = Tag::whereIn('id', $tagIds)->pluck('name')->toArray();
        });

        return view('frontend.index', compact('notifications', 'tags'));
    }


    public function important(Request $request)
    {
        $query = Notification::where('status', 1)
                            ->whereJsonContains('tags', 1); // Ensure we are filtering by tag ID 1

        if ($request->has('search') && !is_null($request->input('search'))) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('short_description', 'LIKE', '%' . $search . '%')
                ->orWhereJsonContains('tags', $search);
            });
        }

        if ($request->has('tag') && $request->input('tag') != 0) {
            $tagId = $request->input('tag');

            $query->whereJsonContains('tags', $tagId);
        }

        $tags = Tag::where('status', 1)->get();

        $notifications = $query->simplePaginate(10);

        $notifications->each(function ($notification) {
            $tagIds = json_decode($notification->tags);
            $notification->tagNames = Tag::whereIn('id', $tagIds)->pluck('name')->toArray();
        });

        return view('frontend.important', compact('notifications', 'tags'));
    }

    public function tags() {

        $tags = Tag::where('status', 1)->orderBy('name', 'asc')->get();

        return view('frontend.tags', compact('tags'));
    }

    public function show(Notification $notification) {
        $tagIds = json_decode($notification->tags);
        $notification->tagNames = Tag::whereIn('id', $tagIds)->pluck('name')->toArray();

        return view('frontend.show', compact('notification'));
    }


    public function login() {
        // Check if the student is already authenticated
        if (Auth::guard('student')->check()) {
            // Redirect the student to the main page
            return redirect()->route('frontend.student.index');
        }

        // If not authenticated, show the login view
        return view('frontend.auth.login');
    }

    public function login_store(Request $request) {
        // Validate the form data
        $request->validate([
            'student_id' => 'required|string',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in
        if (Auth::guard('student')->attempt(['student_id' => 'UG' . $request->student_id, 'password' => $request->password], $request->get('remember'))) {
            // If successful, redirect to the intended location
            return redirect()->intended(route('frontend.student.index'))->with('success', 'Student Login Successful');
        }

        // If unsuccessful, redirect back with form data
        return back()->withErrors(['email' => 'These credentials do not match our records.'])->withInput($request->only('email', 'remember'));
    }

    public function registration() {

        // Check if the student is already authenticated
        if (Auth::guard('student')->check()) {
            // Redirect the student to the main page
            return redirect()->route('frontend.student.index');
        }

        return view('frontend.auth.registration');
    }

    public function registration_store(Request $request) {
        // Validate the incoming request data
        // Custom validation rule definition
        Validator::extend('student_id_format', function ($attribute, $value, $parameters, $validator) {
            // Define your regex pattern to match the required format
            return preg_match('/^\d{2}-\d{2}-\d{2}-\d{3}$/', $value);
        });

        // Use the validator in your controller method
        $formData = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:students',
            'student_id'    => 'required|string|max:255|unique:students|student_id_format', // Apply the custom rule here
            'phone'         => 'required|string|max:15',
            'address'       => 'required|string|max:255',
            'password'      => 'required|string|min:8|confirmed',
        ]);

        // Hash the password before storing it
        $formData['password'] = Hash::make($formData['password']);

        $formData['status'] = false;
        $formData['student_id'] = 'UG' . $formData['student_id'];
        // Create a new student
        $student = Student::create($formData);

        // Generate a verification token
        $verificationToken = Str::random(60);
        $student->verification_token = $verificationToken;
        $student->save();

        // Generate verification URL
        $verificationUrl = route('frontend.student.verify', ['token' => $verificationToken]);

        // Send the verification email
        Mail::to($student->email)->send(new StudentVerificationMail($student, $verificationUrl));

        // Redirect to a specific route with a success message
        return redirect()->route('frontend.student.registration')->with('success', 'Student Registration successful. Please Confirm the email');
    }

    public function verifyStudent($token) {
        $student = Student::where('verification_token', $token)->firstOrFail();

        $student->email_verified_at = Carbon::now();
        $student->verification_token = null;
        $student->save();

        return redirect()->route('frontend.student.login')->with('success', 'Email verified successfully. Please contact authority to active your account');
    }


    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        return redirect()->route('frontend.student.login')->with('success', 'Student Logout Successfully');
    }
}
