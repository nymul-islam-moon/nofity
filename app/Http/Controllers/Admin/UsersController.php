<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\RegistrationMail;
use Mail;

class UsersController extends Controller
{
    protected $title;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->title = 'Faculties';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $query = DB::table('users');

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

        $users = $query->orderByDesc('id')
                ->where('id', '!=', auth()->id())
                ->where( 'is_admin', '!=', 1 )
                ->get();


        if ( $request->ajax() ) {
            return DataTables::of( $users )
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
                        $html .='<li><a class="dropdown-item" href="'. route('admin.users.edit', $row->id) .'" id="edit_btn">Edit</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('admin.users.destroy', $row->id) .'" id="delete_btn">Delete</a></li>';
                    } else {
                        $html .='<li><a class="dropdown-item" href="'. route('admin.users.restore', $row->id) .'" id="restore_btn">Restore</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('admin.users.forcedelete', $row->id) .'" id="force_delete_btn">Hard Delete</a></li>';
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
                            '<input class="form-check-input" href="'.route('admin.users.deactive', $row->id).'" type="checkbox" role="switch" id="deactive_btn" '.($row->status == 1 ? 'checked' : '').'>&nbsp;'.
                            '<label class="form-check-label" for="SwitchCheck4"> Active</label>'.
                            '</div>';

                    if ($row->status != 1) {
                        $html = '<div class="form-check form-switch">'.
                                '<input class="form-check-input" type="checkbox" href="'.route('admin.users.active', $row->id).'" role="switch" id="active_btn">&nbsp;'.
                                '<label class="form-check-label" for="SwitchCheck4"> De-active</label>'.
                                '</div>';
                    }

                    return $html;
                })
                ->editColumn( 'type', function ( $row )  {

                    if ( $row->is_admin == 1 ) {
                        return 'Super Admin';
                    } elseif ( $row->is_admin == 2 ) {
                        return 'Admin';
                    } else {
                        return 'Reader';
                    }

                })
                ->editColumn( 'gender', function ( $row )  {

                    if ( $row->gender == 1 ) {
                        return 'Male';
                    } else {
                        return 'Female';
                    }

                })

                ->rawColumns(['action', 'status', 'checkbox', 'type'])
                ->make(true);
        }

        $title = $this->title;

        return view( 'admin.user.index', compact( 'title' ) );
    }

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
   {
        $title = $this->title;

        $user = User::where( 'status', 1 )->get();

        return view('admin.user.create', compact( 'title', 'user' ));
   }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest $request
     * @return \Illuminate\Http\Response
     */
   public function store( StoreUsersRequest $request, User $users )
   {
        $formData                   = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old profile picture if it exists
            if ($users->profile_picture && file_exists(public_path('uploads/faculty/' . $users->profile_picture))) {
                unlink(public_path('uploads/faculty/' . $users->profile_picture));
            }

            // Upload the new profile picture
            $profilePicture = $request->file('image');
            $profilePictureName = $users->id . '__' . uniqid() . '.' . $profilePicture->getClientOriginalExtension();
            $profilePicture->move(public_path('uploads/faculty'), $profilePictureName);

            // Update the student's profile picture
            $formData['image'] = $profilePictureName;
        }

        $password                   = 'admin@12345';
        $formData['password']       = Hash::make($password);


        $users->create( $formData );

        $mailData = [
            'title'     => env('APP_NAME', 'Default Title'),
            'email'     => $formData['email'],
            'type'      => $formData['is_admin'] == 1 ? 'Faculty Head' : 'Faculty Member',
            'password'  => $password,
            'admin_url' => config('app.url') . 'admin/home',
            'url'       => config('app.url')
        ];

        Mail::to($formData['email'])->send(new RegistrationMail( $mailData ) );

        return response()->json("$this->title created successfully");
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit( User $users )
    {
        $title = $this->title;

        return view( 'admin.user.edit', compact( 'users', 'title' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Users $users
     * @return \Illuminate\Http\Response
     */
    public function update( UpdateUsersRequest $request, User $users )
    {
        $formData                   = $request->validated();

        if ( isset( $formData['image'] ) ) {

            $imgFile            = $request->file('image')->getClientOriginalName();
            $imgFileArr         = explode('.', $imgFile);
            $imgOriginalName    = $imgFileArr[0];
            $imgName            = $imgOriginalName .'.'. $request->image->extension();

            // unlink img
            try {
                unlink( 'uploads/user/' . $users->img );
            } catch ( Exception $ex ) {

            }

            $request->image->move( public_path('uploads/user/img/'), $imgName );
            $formData['image']    = $imgName;
        }

        $users->update($formData);

        // return
        return response()->json("$this->title Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Users $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $users)
    {
        $users->delete();

        return response()->json("$this->title Deleted Successfully");
    }

    /**
     * Active the specified resource from storage.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function active(User $users)
    {
        $users->status = 1;
        $users->save();
        return response()->json("$this->title activated successfully");
    }

    /**
     * De-active the specified resource from storage.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function deactive(User $users)
    {
        $users->status = 0;
        $users->save();
        return response()->json("$this->title de-activated successfully");
    }

    /**
     * Restore the soft deleted data.
     *
     * @param  \App\Models\Users $users
     * @return \Illuminate\Http\Response
     */

    public function restore($users)
    {
        User::where('id', $users)->withTrashed()->restore();

        return response()->json("$this->title restored successfully");
    }

    /**
     * Force Delete the soft deleted data.
     *
     * @param  \App\Models\Users $users
     * @return \Illuminate\Http\Response
     */

    public function forceDelete($users)
    {
        User::where('id', $users)->withTrashed()->forceDelete();

        return response()->json('Product Category Permanently Deleted Successfully');
    }

    /**
     * Force Delete the soft deleted data.
     *
     * @param  \App\Models\Users $users
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $users = User::where('id', $id)->first();
            $users->status = 0;
            $users->save();
            $users->delete();
        }
        return response()->json("$this->title Deleted Successfully");
    }

    /**
     * Restore all the soft deleted data
     *
     * @param  \App\Models\Users $users
     * @return \Illuminate\Http\Response
     */
    public function restoreAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = ( array ) $ids;

        foreach ( $idArr as $key=> $id ) {
            $users = User::where( 'id', $id )->withTrashed()->restore();
        }

        return response()->json("$this->title restored successfully");
    }


    /**
     * Permanently Delete all the soft deleted data
     *
     * @param  \App\Models\Users $users
     * @return \Illuminate\Http\Response
     */
    public function permanentDestroyAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = ( array ) $ids;

        foreach ($idArr as $key=> $id) {
            $users = User::where('id', $id)->withTrashed()->forceDelete();
        }

        return response()->json("$this->title permanently deleted successfully");
    }
}
