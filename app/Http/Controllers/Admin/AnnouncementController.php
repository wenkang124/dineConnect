<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use App\Models\User;
use App\Traits\MediaTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class AnnouncementController extends Controller
{
    use MediaTrait;
    
    public function index()
    {
        return view('admin.announcements.index');
    }

    public function dataTable()
    {
        $items = Announcement::query();
        
        return Datatables::of($items)
                ->editColumn('image', function ($item) {
                    return "<img src='".$item->image."' width='250' class='p-4' />";
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->editColumn('active', function ($item) {
                    return $item->status_name;
                })
                ->addColumn('actions', function ($item) {
                    return '<a href="'.route('admin.announcements.show', [$item]).'" class="btn btn-xs btn-primary mx-1 my-1"><i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.announcements.edit', [$item]).'" class="btn btn-xs btn-warning mx-1 my-1"><i class="fa fa-edit"></i></a>
                            <a href="'.route('admin.announcements.destroy', ['announcement'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this announcement?" data-redirect="'.route('admin.announcements.index').'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
    }

    public function show(Announcement $item) {
        return view('admin.announcements.show', compact('item'));
    }

    public function create() {
        return view('admin.announcements.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|file|mimes:jpg,jpeg,png,gif,webp',
            'description' => 'nullable',
            'sequence' => 'required|numeric|min:1',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            $item = new Announcement();

            $item->title = $request->get('title');
            $item->description = $request->get('description');
            $item->sequence = $request->get('sequence');
            $item->active = $request->get('active');

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = Announcement::UPLOAD_PATH;
                $prefix_name = Announcement::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $item->image = rtrim($path, '/') . "/" . $new_filename_with_extension;
            }    
            $item->save();

            DB::commit();
            Session::flash("success", "New announcement successfully created.");

            return redirect()->route('admin.announcements.index');

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    
    public function edit(Announcement $item) {
        return view('admin.announcements.edit', compact('item'));
    }

    public function update(Announcement $item, Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp',
            'description' => 'nullable',
            'sequence' => 'required|numeric|min:1',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            $item->title = $request->get('title');
            $item->description = $request->get('description');
            $item->sequence = $request->get('sequence');
            $item->active = $request->get('active');

            if($request->hasFile('image')) {
                $temp_path = $item->image;

                $file = $request->file('image');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = Announcement::UPLOAD_PATH;
                $prefix_name = Announcement::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $item->image = rtrim($path, '/') . "/" . $new_filename_with_extension;

                if($temp_path && $temp_path != "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg") {
                    unlink($temp_path);
                }
            }    
            $item->save();

            DB::commit();
            Session::flash("success", "Announcement details successfully updated.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to update. '.$e->getMessage(),
            ]]);
        } 
    }

    public function destroy(Announcement $announcement) {
        //
        if(empty($announcement)){
            return response()->json(['success' => false, 'message' => 'Announcement not found.']);
        }
 
        $announcement->delete();

        Session::flash("success", "Announcement has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
