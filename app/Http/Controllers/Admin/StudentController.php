<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Mail\AdminStudentVarificationMail;
use App\Mail\StudentVerificationMail;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Mail;

class StudentController extends Controller
{
    protected $title, $create_link, $index_link, $soft_delete, $restore_all_link, $hard_delete_all_link, $store_link;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->title                    = 'Students';
        $this->index_link               = route('admin.students.index');
        $this->create_link              = route('admin.students.create');
        $this->soft_delete              = route('admin.students.softDeleteAll');
        $this->restore_all_link         = route('admin.students.restore_all');
        $this->hard_delete_all_link     = route('admin.students.hard_delete_all');
        $this->store_link               = route('admin.students.store');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $query = DB::table('students');

        if (!empty($request->f_soft_delete)) {
            if ( $request->f_soft_delete == 1 ) {
                $query->where('deleted_at', '=', null);
            } else {
                $query->where('deleted_at', '!=', null);
            }
        }

        if ( !empty( $request->f_status ) ) {
            if ( $request->f_status == 1 ) {
                $query->where('status', 1);
            } else {
                $query->where('status', 0);
            }
        }

       $students = $query->orderByDesc('id')
                    ->where('email_verified_at', '!=', null)
                    ->get();


        if ( $request->ajax() ) {
            return DataTables::of( $students )
                ->addIndexColumn()
                ->addColumn( 'action', function ( $row ) {

                    $html = '';

                    $html .='<div class="btn-group" role="group" aria-label="Button group with nested dropdown">';
                    $html .='<div class="btn-group" role="group">';
                    $html .='<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">';
                    $html .='Action';
                    $html .='</button>';
                    $html .='<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                    if ($row->deleted_at == null) {
                        $html .='<li><a class="dropdown-item" href="'. route('admin.students.edit', $row->id) .'" id="edit_btn">Edit</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('admin.students.delete', $row->id) .'" id="delete_btn">Delete</a></li>';
                    } else {
                        $html .='<li><a class="dropdown-item" href="'. route('admin.students.restore', $row->id) .'" id="restore_btn">Restore</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('admin.students.hard_delete', $row->id) .'" id="force_delete_btn">Hard Delete</a></li>';
                    }
                    $html .='</ul>';
                    $html .='</div>';
                    $html .='</div>';

                    return $html;
                })
                ->addColumn( 'checkbox', function ( $row ) {
                    $html = '';

                    $html .= '<input type="checkbox" class="checkbox_ids" name="ids" value="'. $row->id .'">';

                    return $html;

                })
                ->editColumn( 'status', function ( $row ) {
                    $html = '<div class="form-check form-switch">'.
                            '<input class="form-check-input" href="'.route('admin.students.deactivate', $row->id).'" type="checkbox" role="switch" id="deactive_btn" '.($row->status == 1 ? 'checked' : '').'>&nbsp;'.
                            '<label class="form-check-label" for="SwitchCheck4"> Active</label>'.
                            '</div>';

                    if ($row->status != 1) {
                        $html = '<div class="form-check form-switch">'.
                                '<input class="form-check-input" type="checkbox" href="'.route('admin.students.activate', $row->id).'" role="switch" id="active_btn">&nbsp;'.
                                '<label class="form-check-label" for="SwitchCheck4"> De-active</label>'.
                                '</div>';
                    }

                    return $html;
                })
                ->rawColumns(['action', 'status', 'checkbox'])
                ->make(true);
        }

        $title = $this->title;
        $create_link            = $this->create_link;
        $index_link             = $this->index_link;
        $soft_delete_link       = $this->soft_delete;
        $restore_all_link       = $this->restore_all_link;
        $hard_delete_all_link   = $this->hard_delete_all_link;
        return view('admin.student.index', compact( 'title', 'create_link', 'index_link', 'soft_delete_link', 'restore_all_link', 'hard_delete_all_link' ));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $store_link = $this->store_link;
        return view('admin.student.create', compact('title', 'store_link'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request, Student $students)
    {
        $formData = $request->validated();
        $password = 'Student@12345';
        $formData['password'] = Hash::make($password);

        if ( $formData['status'] == 0 ) {
            $formData['status'] = false;
        } else {
            $formData['status'] = true;
        }

        // Create a new student
        $student = Student::create($formData);

        // Generate a verification token
        $verificationToken = Str::random(60);
        $student->verification_token = $verificationToken;
        $student->save();

        // Generate verification URL
        $verificationUrl = route('frontend.student.verify', ['token' => $verificationToken]);

        // Send the verification email
        Mail::to($student->email)->send(new AdminStudentVarificationMail($student, $verificationUrl, $password));

    
        return response()->json("$this->title created successfully");

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $students)
    {
        $title = $this->title;
        $update_link = route('faculty.tag.update', $students->id);
        return view('admin.student.edit', compact('title', 'students', 'update_link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, Student $students)
    {
        $formData = $request->validated();

        if ( $formData['status'] == 0 ) {
            $formData['status'] = false;
        } else {
            $formData['status'] = true;
        }

        $students->update($formData);

        return response()->json("$this->title updated successfully");
    }

    /**
     * Active the specified resource from storage.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function activate(Student $students)
    {
        // Update the status to 0 (inactive)
        $students->status = 1;
        $students->save();

        // Return a JSON response indicating success
        return response()->json("$this->title activated successfully");
    }

    /**
     * De-activate the specified resource from storage.
     *
     * @param  int  $id  // Assuming $id is the student's ID
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Student $students)
    {
        // Update the status to 0 (inactive)
        $students->status = 0;
        $students->save();

        // Return a JSON response indicating success
        return response()->json("Student de-activated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function softDelete(Student $students)
    {
        $students->status = false;
        $students->save();
        $students->delete();
        return response()->json("$this->title Deleted Successfully");
    }

    /**
     * Hard Delete the soft deleted data.
     *
     * @param  \App\Models\Books $tag
     * @return \Illuminate\Http\Response
     */
    public function hardDelete( $student )
    {
       Student::where('id', $student)->withTrashed()->forceDelete();

       return response()->json("$this->title Permanently Deleted Successfully");
    }

    /**
     * Restore the soft deleted data.
     *
     * @param  \App\Models\Books $tag
     * @return \Illuminate\Http\Response
     */
    public function restore( $student )
    {
       Student::where('id', $student)->withTrashed()->restore();

       return response()->json("$this->title Restore Successfully");
    }

    /**
     * Soft Delete all data.
     *
     * @param  \App\Models\Books $books
     * @return \Illuminate\Http\Response
     */
    public function softDeleteAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $tag = Student::where('id', $id)->first();
            $tag->status = 0;
            $tag->save();
            $tag->delete();
        }
        return response()->json("$this->title Deleted Successfully");
    }

    /**
     * Restore all the soft deleted data
     *
     * @param  \App\Models\Books $books
     * @return \Illuminate\Http\Response
     */
    public function restoreAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = ( array ) $ids;

        foreach ( $idArr as $key=> $id ) {
            $books = Student::where( 'id', $id )->withTrashed()->restore();
        }

        return response()->json("$this->title restored successfully");
    }

    /**
     * Hard Delete all the soft deleted data
     *
     * @param  \App\Models\Books $books
     * @return \Illuminate\Http\Response
     */
    public function hardDeleteAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = ( array ) $ids;
        foreach ($idArr as $key=> $id) {
            $books = Student::where('id', $id)->withTrashed()->forceDelete();
        }

        return response()->json("$this->title permanently deleted successfully");
    }

}
