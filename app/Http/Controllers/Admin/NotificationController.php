<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Notification;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
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
        $this->title                    = 'Notifications';
        $this->index_link               = route('faculty.notification.index');
        $this->create_link              = route('faculty.notification.create');
        $this->soft_delete              = route('faculty.notification.softDeleteAll');
        $this->restore_all_link         = route('faculty.notification.restore_all');
        $this->hard_delete_all_link     = route('faculty.notification.hard_delete_all');
        $this->store_link               = route('faculty.notification.store');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $query = DB::table('notifications');

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

        $notifications = $query->orderByDesc('id')->get();


        if ( $request->ajax() ) {
            return DataTables::of( $notifications )
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
                        $html .='<li><a class="dropdown-item" href="'. route('faculty.notification.edit', $row->id) .'" id="edit_btn">Edit</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('faculty.notification.delete', $row->id) .'" id="delete_btn">Delete</a></li>';
                    } else {
                        $html .='<li><a class="dropdown-item" href="'. route('faculty.notification.restore', $row->id) .'" id="restore_btn">Restore</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('faculty.notification.hard_delete', $row->id) .'" id="force_delete_btn">Hard Delete</a></li>';
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
                            '<input class="form-check-input" href="'.route('faculty.notification.deactivate', $row->id).'" type="checkbox" role="switch" id="deactive_btn" '.($row->status == 1 ? 'checked' : '').'>&nbsp;'.
                            '<label class="form-check-label" for="SwitchCheck4"> Active</label>'.
                            '</div>';

                    if ($row->status != 1) {
                        $html = '<div class="form-check form-switch">'.
                                '<input class="form-check-input" type="checkbox" href="'.route('faculty.notification.activate', $row->id).'" role="switch" id="active_btn">&nbsp;'.
                                '<label class="form-check-label" for="SwitchCheck4"> De-active</label>'.
                                '</div>';
                    }

                    return $html;
                })
                ->editColumn('tags', function ($row) {
                    // Decode the JSON string to an array
                    $tagIds = json_decode($row->tags, true);

                    // Get the tag names
                    $tags = Notification::getTagNames($tagIds);

                    // Wrap each tag name in the desired HTML structure
                    $tagHtml = array_map(function($tag) {
                        return '<span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> ' . htmlspecialchars($tag) . '</span>';
                    }, $tags);
                    // Join all the HTML strings into one
                    return implode(' ', $tagHtml);


                })
                ->rawColumns(['action', 'status', 'checkbox', 'tags'])
                ->make(true);
        }

        $title = $this->title;
        $create_link            = $this->create_link;
        $index_link             = $this->index_link;
        $soft_delete_link       = $this->soft_delete;
        $restore_all_link       = $this->restore_all_link;
        $hard_delete_all_link   = $this->hard_delete_all_link;
        return view('admin.notification.index', compact( 'title', 'create_link', 'index_link', 'soft_delete_link', 'restore_all_link', 'hard_delete_all_link' ));
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
        $tags = Tag::where('status', 1)->get();
        return view('admin.notification.create', compact('title', 'tags', 'store_link'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request, Notification $notification)
    {
        $formData = $request->validated();
        $tags = $formData['tags'];
        $formData['tags'] = json_encode($formData['tags']);

        $createdNotify = $notification->create( $formData );

        $createdNotify->rel_to_tags()->sync($tags);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        $title = $this->title;
        $update_link = route('faculty.notification.update', $notification->id);
        $tags = Tag::where('status', 1)->get();
        $notificationTags = json_decode($notification->tags);
        return view('admin.notification.edit', compact('title', 'notification', 'update_link', 'tags', 'notificationTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationRequest  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $formData = $request->validated();
        $tags = $formData['tags'];

        // Encode tags to JSON format
        $formData['tags'] = json_encode($tags);

        // Update the notification with the form data
        $notification->update($formData);

        // Sync the tags in the pivot table
        $notification->rel_to_tags()->sync($tags);

        return response()->json("{$notification->title} updated successfully");
    }


    /**
     * Active the specified resource from storage.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function activate(Notification $notification)
    {
        $notification->status = 1;
        $notification->save();
        return response()->json("$this->title activated successfully");
    }

    /**
     * De-active the specified resource from storage.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Notification $notification)
    {
        $notification->status = 0;
        $notification->save();
        return response()->json("$this->title de-activated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function softDelete(Notification $notification)
    {
        $notification->status = false;
        $notification->save();
        $notification->delete();
        return response()->json("$this->title Deleted Successfully");
    }

    /**
     * Hard Delete the soft deleted data.
     *
     * @param  \App\Models\Books $notification
     * @return \Illuminate\Http\Response
     */
     public function hardDelete($notification)
     {
        Notification::where('id', $notification)->withTrashed()->forceDelete();

        return response()->json("$this->title Permanently Deleted Successfully");
     }

     /**
     * Restore the soft deleted data.
     *
     * @param  \App\Models\Books $notification
     * @return \Illuminate\Http\Response
     */
    public function restore($notification)
    {
       Notification::where('id', $notification)->withTrashed()->restore();

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
            $notification = Notification::where('id', $id)->first();
            $notification->status = 0;
            $notification->save();
            $notification->delete();
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
            $books = Notification::where( 'id', $id )->withTrashed()->restore();
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
            $books = Notification::where('id', $id)->withTrashed()->forceDelete();
        }

        return response()->json("$this->title permanently deleted successfully");
    }

}
