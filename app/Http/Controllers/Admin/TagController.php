<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
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
        $this->title                    = 'Tags';
        $this->index_link               = route('faculty.tag.index');
        $this->create_link              = route('faculty.tag.create');
        $this->soft_delete              = route('faculty.tag.softDeleteAll');
        $this->restore_all_link         = route('faculty.tag.restore_all');
        $this->hard_delete_all_link     = route('faculty.tag.hard_delete_all');
        $this->store_link               = route('faculty.tag.store');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $query = DB::table('tags');

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

       $tags = $query->orderByDesc('id')->get();


        if ( $request->ajax() ) {
            return DataTables::of( $tags )
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
                        $html .='<li><a class="dropdown-item" href="'. route('faculty.tag.edit', $row->id) .'" id="edit_btn">Edit</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('faculty.tag.delete', $row->id) .'" id="delete_btn">Delete</a></li>';
                    } else {
                        $html .='<li><a class="dropdown-item" href="'. route('faculty.tag.restore', $row->id) .'" id="restore_btn">Restore</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('faculty.tag.hard_delete', $row->id) .'" id="force_delete_btn">Hard Delete</a></li>';
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
                            '<input class="form-check-input" href="'.route('faculty.tag.deactivate', $row->id).'" type="checkbox" role="switch" id="deactive_btn" '.($row->status == 1 ? 'checked' : '').'>&nbsp;'.
                            '<label class="form-check-label" for="SwitchCheck4"> Active</label>'.
                            '</div>';

                    if ($row->status != 1) {
                        $html = '<div class="form-check form-switch">'.
                                '<input class="form-check-input" type="checkbox" href="'.route('faculty.tag.activate', $row->id).'" role="switch" id="active_btn">&nbsp;'.
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
        return view('admin.tag.index', compact( 'title', 'create_link', 'index_link', 'soft_delete_link', 'restore_all_link', 'hard_delete_all_link' ));
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
        return view('admin.tag.create', compact('title', 'tags', 'store_link'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request, Tag $tag)
    {
        $formData = $request->validated();

        $tag->create( $formData );

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
    public function edit(Tag $tag)
    {
        $title = $this->title;
        $update_link = route('faculty.tag.update', $tag->id);
        return view('admin.tag.edit', compact('title', 'tag', 'update_link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $formData = $request->validated();

        $tag->update($formData);

        return response()->json("$this->title updated successfully");
    }


    /**
     * Active the specified resource from storage.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function activate(Tag $tag)
    {
        $tag->status = 1;
        $tag->save();
        return response()->json("$this->title activated successfully");
    }

    /**
     * De-active the specified resource from storage.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Tag $tag)
    {
        $tag->status = 0;
        $tag->save();
        return response()->json("$this->title de-activated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function softDelete(Tag $tag)
    {
        
        $tag->status = false;
        $tag->save();
        $tag->delete();
        return response()->json("$this->title Deleted Successfully");
    }

    /**
     * Hard Delete the soft deleted data.
     *
     * @param  \App\Models\Books $tag
     * @return \Illuminate\Http\Response
     */
     public function hardDelete( $tag )
     {
        Tag::where('id', $tag)->withTrashed()->forceDelete();

        return response()->json("$this->title Permanently Deleted Successfully");
     }

     /**
     * Restore the soft deleted data.
     *
     * @param  \App\Models\Books $tag
     * @return \Illuminate\Http\Response
     */
    public function restore( $tag )
    {
       Tag::where('id', $tag)->withTrashed()->restore();

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
            $tag = Tag::where('id', $id)->first();
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
            $books = Tag::where( 'id', $id )->withTrashed()->restore();
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
            $books = Tag::where('id', $id)->withTrashed()->forceDelete();
        }

        return response()->json("$this->title permanently deleted successfully");
    }
}
