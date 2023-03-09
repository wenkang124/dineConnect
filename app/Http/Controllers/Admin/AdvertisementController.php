<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advertisement;
use App\Models\User;
use App\Traits\MediaTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class AdvertisementController extends Controller
{
    use MediaTrait;
    
    public function index()
    {
        return view('admin.advertisements.index');
    }

    public function dataTable()
    {
        $items = Advertisement::query();
        
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
                    return '<a href="'.route('admin.advertisements.show', [$item]).'" class="btn btn-xs btn-primary mx-1 my-1"><i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.advertisements.edit', [$item]).'" class="btn btn-xs btn-warning mx-1 my-1"><i class="fa fa-edit"></i></a>
                            <a href="'.route('admin.advertisements.destroy', ['advertisement'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this advertisement?" data-redirect="'.route('admin.advertisements.index').'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
    }

    public function show(Advertisement $item) {
        return view('admin.advertisements.show', compact('item'));
    }

    public function create() {
        return view('admin.advertisements.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|file|mimes:jpg,jpeg,png,gif',
            'description' => 'required',
            'sequence' => 'required|numeric|min:1',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            $item = new Advertisement();

            $item->title = $request->get('title');
            $item->description = $request->get('description');
            $item->sequence = $request->get('sequence');
            $item->active = $request->get('active');

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = Advertisement::UPLOAD_PATH;
                $prefix_name = Advertisement::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $item->image = rtrim($path, '/') . "/" . $new_filename_with_extension;
            }    
            $item->save();

            DB::commit();
            Session::flash("success", "New Advertisement successfully created.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    
    public function edit(Advertisement $item) {
        return view('admin.advertisements.edit', compact('item'));
    }

    public function update(Advertisement $item, Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'description' => 'required',
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
                $path = Advertisement::UPLOAD_PATH;
                $prefix_name = Advertisement::FILE_PREFIX;
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
            Session::flash("success", "Advertisement details successfully updated.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    public function destroy(Advertisement $advertisement) {
        //
        if(empty($advertisement)){
            return response()->json(['success' => false, 'message' => 'Advertisement not found.']);
        }
 
        $advertisement->delete();

        Session::flash("success", "Advertisement has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}