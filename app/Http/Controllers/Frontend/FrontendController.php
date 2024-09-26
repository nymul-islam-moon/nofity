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
use Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::with('rel_to_tags')->where('status', 1);

        // Filter by search term (name or short description)
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('short_description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by tag id
        if ($request->has('tag_id') && $request->tag_id != 0) {
            $query->whereHas('rel_to_tags', function ($q) use ($request) {
                $q->where('tag_id', $request->tag_id);
            });
        }

        $tags = Tag::where('status', 1)->get();
        $notifications = $query->simplePaginate(10);

        return view('frontend.index', compact('notifications', 'tags'));
    }



    public function important(Request $request)
    {
        // Base query to filter notifications with status 1 and tag ID 1
        $query = Notification::with('rel_to_tags')
                            ->where('status', 1)
                            ->whereHas('rel_to_tags', function($q) {
                                $q->where('tag_id', 1); // Ensure filtering by tag ID 1
                            });

        // Filter by search term for title and short_description
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('short_description', 'LIKE', '%' . $search . '%');
            });
        }

        // Filter by tag ID from the dropdown selection
        if ($request->has('tag') && $request->input('tag') != 0) {
            $tagId = $request->input('tag');
            $query->whereHas('rel_to_tags', function ($q) use ($tagId) {
                $q->where('tag_id', $tagId);
            });
        }

        $tags = Tag::where('status', 1)->get();
        $notifications = $query->orderBy('id', 'desc')->simplePaginate(10);

        return view('frontend.important', compact('notifications', 'tags'));
    }


    public function favoriteNotifications(Request $request)
    {
        $studentId = auth('student')->id(); // Get the authenticated student's ID

        // Fetch favorite tag IDs for the current student
        $favoriteTagIds = FavoriteTags::where('student_id', $studentId)
            ->pluck('tag_id')
            ->toArray();

        // If there are no favorite tags, return an empty result set
        if (empty($favoriteTagIds)) {
            $tags = [];
            $notifications = collect(); // Return an empty collection
            return view('frontend.favorite_notification', compact('notifications', 'tags'));
        }

        // Retrieve tags that are in the favorite tag IDs
        $tags = Tag::whereIn('id', $favoriteTagIds)->get();

        $query = Notification::where('status', 1)
            ->whereHas('rel_to_tags', function ($query) use ($favoriteTagIds) {
                $query->whereIn('tag_id', $favoriteTagIds);
            });

        // Filter by search term (title or short description)
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('short_description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by tag ID from the dropdown selection
        if ($request->has('tag_id') && $request->tag_id != 0) {
            $query->whereHas('rel_to_tags', function ($q) use ($request) {
                $q->where('tag_id', $request->tag_id);
            });
        }

        // Paginate the results
        $notifications = $query->orderBy('id', 'desc')->simplePaginate(10);

        return view('frontend.favorite_notification', compact('notifications', 'tags'));
    }




    public function profile() {
        $studentId = auth('student')->id();
        $student = Student::where('id', $studentId)->first();
        return view('frontend.profile', compact('student'));
    }

    public function profile_update(Request $request)
    {
        $studentId = auth('student')->id(); // Get the authenticated student's ID

        // Validate the request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $studentId,
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other', // Adjust options based on your requirements
        ]);

        // Find the student
        $student = Student::find($studentId);

        // Update the student's profile
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->address = $request->address;
        $student->gender = $request->gender;

        // Handle the profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($student->profile_picture && file_exists(public_path('uploads/student/' . $student->profile_picture))) {
                unlink(public_path('uploads/student/' . $student->profile_picture));
            }

            // Upload the new profile picture
            $profilePicture = $request->file('profile_picture');
            $profilePictureName = $studentId . '__' . uniqid() . '.' . $profilePicture->getClientOriginalExtension();
            $profilePicture->move(public_path('uploads/student'), $profilePictureName);

            // Update the student's profile picture
            $student->profile_picture = $profilePictureName;
        }

        // Save the updated student record
        $student->save();

        // Return a success response
        return response()->json(['message' => 'Profile updated successfully!'], 200);
    }


    public function password_update(Request $request)
    {
        $studentId = auth('student')->id(); // Get the authenticated student's ID

        // Validate the request data
        $formData = $request->validate([
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Find the student
        $student = Student::find($studentId);

        // Check if the current password matches
        if (!Hash::check($request->current_password, $student->password)) {
            return response()->json(['message' => 'The current password is incorrect.'], 422);
        }

        // Update the student's password
        $student->password = Hash::make($request->new_password);
        $student->save();

        // Return a success response
        return response()->json(['message' => 'Password updated successfully!'], 200);
    }




    public function tags(Request $request)
    {
        $studentId = auth('student')->id(); // Assuming 'student' guard is used

        // Get search term from the request
        $search = $request->input('search', '');

        // Fetch all tags with search functionality and excluding tag with ID 1
        $tags = Tag::where('status', 1)
            ->where('id', '!=', 1) // Exclude tag with ID 1
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            })
            ->orderBy('name', 'asc')
            ->get();

        // Fetch favorite tag IDs for the current student
        $favoriteTagIds = FavoriteTags::where('student_id', $studentId)
            ->pluck('tag_id')
            ->toArray();

        return view('frontend.tags', compact('tags', 'favoriteTagIds', 'search'));
    }




    public function storeFavoriteTag($favoriteTagId, Request $request)
    {
        $studentId = auth('student')->id(); // Get the authenticated student's ID
        $student = Student::find($studentId);

        $formData = [
            'student_id' => $student->id,
            'tag_id'    => $favoriteTagId,
        ];

        $favoriteTag = new FavoriteTags();

        $favoriteTag->create($formData);

        return response()->json(['success' => true, 'message' => 'Tag added to favorites']);
    }

    public function removeFavoriteTag($favoriteTagId, Request $request)
    {
        $studentId = auth('student')->id(); // Get the authenticated student's ID

        // Find the favorite tag record based on student_id and tag_id
        $favoriteTag = FavoriteTags::where([
            'student_id' => $studentId,
            'tag_id' => $favoriteTagId
        ])->first();

        if ($favoriteTag) {
            // Delete the favorite tag record
            $favoriteTag->delete();
            return response()->json(['success' => true, 'message' => 'Tag removed from favorites']);
        }

        // Return an error response if the record was not found
        return response()->json(['success' => false, 'message' => 'Favorite tag not found']);
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
        if (Auth::guard('student')->attempt([
            'student_id' => 'UG' . $request->student_id,
            'password' => $request->password
        ], $request->get('remember'))) {
            // If successful, redirect to the intended location
            return redirect()->intended(route('frontend.student.index'))->with('success', 'Student Login Successful');
        }

        // If unsuccessful, redirect back with form data and errors
        return back()
            ->withErrors(['student_id' => 'These credentials do not match our records.'])
            ->withInput($request->only('student_id', 'remember'));
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
            'phone'         => 'required|string|max:15|unique:students',
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

    // SteadFast
    public function short_url() {
        $urls = shortUrl::all();
        return view('frontend.short_url', compact('urls'));
    }

    public function destroy_url($url) {

    }
}
