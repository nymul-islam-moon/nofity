<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\StudentVerificationMail;
use App\Models\FavoriteTags;
use App\Models\Notification;
use App\Models\shortUrl;
use App\Models\Student;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{

    public function profile() {
        $studentId = auth('student')->id();
        $student = Student::where('id', $studentId)->first();
        return view('frontend.profile', compact('student'));
    }

    public function profile_update(Request $request)
    {
        $studentId = auth('student')->id();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $studentId,
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $student = Student::find($studentId);

        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->address = $request->address;
        $student->gender = $request->gender;

        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture && file_exists(public_path('uploads/student/' . $student->profile_picture))) {
                unlink(public_path('uploads/student/' . $student->profile_picture));
            }

            $profilePicture = $request->file('profile_picture');
            $profilePictureName = $studentId . '__' . uniqid() . '.' . $profilePicture->getClientOriginalExtension();
            $profilePicture->move(public_path('uploads/student'), $profilePictureName);

            $student->profile_picture = $profilePictureName;
        }

        $student->save();

        return response()->json(['message' => 'Profile updated successfully!'], 200);
    }


    public function password_update(Request $request)
    {
        $studentId = auth('student')->id();

        $formData = $request->validate([
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $student = Student::find($studentId);

        if (!Hash::check($request->current_password, $student->password)) {
            return response()->json(['message' => 'The current password is incorrect.'], 422);
        }

        $student->password = Hash::make($request->new_password);
        $student->save();

        return response()->json(['message' => 'Password updated successfully!'], 200);
    }


    public function login() {
        if (Auth::guard('student')->check()) {
            return redirect()->route('frontend.student.index');
        }

        return view('frontend.auth.login');
    }

    public function login_store(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('student')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->get('remember'))) {
            return redirect()->intended(route('frontend.student.index'))->with('success', 'Student Login Successful');
        }

        return back()
            ->withErrors(['student_id' => 'These credentials do not match our records.'])
            ->withInput($request->only('student_id', 'remember'));
    }


    public function registration() {

        if (Auth::guard('student')->check()) {
            return redirect()->route('frontend.student.index');
        }

        return view('frontend.auth.registration');
    }

    public function registration_store(Request $request) {
        Validator::extend('student_id_format', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\d{2}-\d{2}-\d{2}-\d{3}$/', $value);
        });

        $formData = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:students',
            'phone'         => 'required|string|max:15|unique:students',
            'address'       => 'required|string|max:255',
            'password'      => 'required|string|min:8|confirmed',
        ]);

        $formData['password'] = Hash::make($formData['password']);

        $formData['status'] = false;

        $student = Student::create($formData);


        return redirect()->route('frontend.student.registration')->with('success', 'Registration successful.');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        return redirect()->route('frontend.student.login')->with('success', 'Logout Successfully');
    }

    // SteadFast
    public function short_url()
    {
        // Get the ID of the currently authenticated student
        $studentId = auth('student')->id();

        // Fetch URLs created by the logged-in student
        $urls = ShortUrl::where('created_by', $studentId)->get();

        return view('frontend.short_url', compact('urls'));
    }

    public function store_short_url(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'url' => 'required|url' // Ensure the input is a valid URL
        ]);

        // Get the last inserted ID or set to 0 if no records exist
        $lastShortUrl = ShortUrl::latest('id')->first();
        $lastId = $lastShortUrl ? $lastShortUrl->id : 0;
        $newId = $lastId + 1; // Increment the ID for the new record

        // Get the current date
        $currentDate = now();
        $year = $currentDate->year;
        $month = str_pad($currentDate->month, 2, '0', STR_PAD_LEFT); // Ensure 2 digits
        $day = str_pad($currentDate->day, 2, '0', STR_PAD_LEFT); // Ensure 2 digits

        // Get the currently authenticated student's ID
        $userId = auth('student')->id();

        // Construct the short URL string
        $shortUrl = "{$year}&{$month}&{$day}&{$userId}&{$newId}";

        // Create a new short URL record
        $shortUrlEntry = ShortUrl::create([
            'original_url' => $request->url,
            'short_url' => $shortUrl,
            'click_count' => 0, // Initialize click count to 0
            'created_by' => $userId, // Set the created_by field
        ]);

        // Optionally, return a response or redirect
        return redirect()->route('frontend.student.index')->with('success', 'Short URL created successfully: ' . $shortUrlEntry->short_url);
    }


    public function destroy_url($shortUrl) {
        $url = shortUrl::where('id', $shortUrl)->first();
        $url->delete();
        return redirect()->route('frontend.student.index')->with('success', 'URL deleted successfully');
    }

    public function redirect_url($shortUrl)
    {
        // Attempt to find the original URL using the short URL
        $urlEntry = ShortUrl::where('short_url', $shortUrl)->first();

        if ($urlEntry) {
            // Increment the click count
            $urlEntry->increment('click_count');

            // Redirect to the original URL
            return redirect()->to($urlEntry->original_url);
        }

        // If no URL is found, redirect to the main site
        return view('frontend.not_found');
    }
}
