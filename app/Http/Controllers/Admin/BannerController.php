<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\User;
use App\Traits\MediaTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class BannerController extends Controller
{
    use MediaTrait;
    
    public function index()
    {
        return view('admin.banners.index');
    }

    public function dataTable()
    {
        $items = Banner::query();
        
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
                ->addColumn('url_link', function ($item) {
                    return $item->action;
                })
                ->addColumn('actions', function ($item) {
                    return '<a href="'.route('admin.banners.show', [$item]).'" class="btn btn-xs btn-primary mx-1 my-1"><i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.banners.edit', [$item]).'" class="btn btn-xs btn-warning mx-1 my-1"><i class="fa fa-edit"></i></a>
                            <a href="'.route('admin.banners.destroy', ['banner'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this banner?" data-redirect="'.route('admin.banners.index').'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
    }

    public function show(Banner $item) {
        return view('admin.banners.show', compact('item'));
    }

    public function create() {
        return view('admin.banners.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'image' => 'required|file|mimes:jpg,jpeg,png,gif,webp',
            'description' => 'nullable',
            'action' => 'nullable',
            'sequence' => 'required|numeric|min:1',
            'type' => 'required|numeric',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            $item = new Banner();

            $item->description = $request->get('description');
            $item->action = $request->get('action');
            $item->sequence = $request->get('sequence');
            $item->type = $request->get('type');
            $item->active = $request->get('active');

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = Banner::UPLOAD_PATH;
                $prefix_name = Banner::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $item->image = rtrim($path, '/') . "/" . $new_filename_with_extension;
            }    
            $item->save();

            DB::commit();
            Session::flash("success", "New banner successfully created.");

            return redirect()->route('admin.banners.index');

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    
    public function edit(Banner $item) {
        return view('admin.banners.edit', compact('item'));
    }

    public function update(Banner $item, Request $request) {
        $this->validate($request, [
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp',
            'description' => 'nullable',
            'action' => 'nullable',
            'sequence' => 'required|numeric|min:1',
            'type' => 'required|numeric',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            $item->description = $request->get('description');
            $item->action = $request->get('action');
            $item->sequence = $request->get('sequence');
            $item->type = $request->get('type');
            $item->active = $request->get('active');

            if($request->hasFile('image')) {
                $temp_path = $item->image;

                $file = $request->file('image');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = Banner::UPLOAD_PATH;
                $prefix_name = Banner::FILE_PREFIX;
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
            Session::flash("success", "Banner details successfully updated.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to update. '.$e->getMessage(),
            ]]);
        } 
    }

    public function destroy(Banner $banner) {
        //
        if(empty($banner)){
            return response()->json(['success' => false, 'message' => 'Banner not found.']);
        }
 
        $banner->delete();

        Session::flash("success", "Banner has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
