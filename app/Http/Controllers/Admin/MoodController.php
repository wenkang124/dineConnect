<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\Mood;
use App\Models\Merchant;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;
use Image;

class MoodController extends Controller
{
    use MediaTrait;
    
    public function index()
    {
        return view('admin.merchants.moods.index');
    }

    public function dataTable()
    {
        $items = Mood::query();

        return Datatables::of($items)
                ->editColumn('image', function ($item) {
                    return "<img src='".$item->image."' width='250' class='p-4' />";
                })
                ->editColumn('active', function ($item) {
                    return $item->status_name;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->addColumn('actions', function ($item) {
                    return '<a href="'.route('admin.merchants.moods.show', [$item]).'" class="btn btn-xs btn-primary mx-1"><i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.merchants.moods.edit', [$item]).'" class="btn btn-xs btn-warning mx-1"><i class="fa fa-edit"></i></a>
                            <a href="'.route('admin.merchants.moods.destroy', ['mood'=>$item]).'" class="btn btn-xs btn-danger mx-1 delete-btn" data-confirm="Are you sure you want to delete this mood?" data-redirect="'.route('admin.merchants.moods.index').'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['image','actions'])
                ->make(true);
    }

    public function show(Mood $item) {
        $merchants = Merchant::where('active', 1)->get();
        return view('admin.merchants.moods.show', compact('item', 'merchants'));
    }

    public function create() {
        $merchants = Merchant::where('active', 1)->get();
        return view('admin.merchants.moods.create', compact('merchants'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required|file|mimes:jpg,jpeg,png,gif,webp',
            'active' => 'required|numeric',
            'merchants' => 'nullable',
        ]);

        DB::beginTransaction();

        try {

            $item = new Mood();

            $item->name = $request->get('name');
            $item->active = $request->get('active');

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = Mood::UPLOAD_PATH;
                $prefix_name = Mood::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $item->image = rtrim($path, '/') . "/" . $new_filename_with_extension;
            }    
            $item->save();

            
            $merchant_ids = [];
            if($request->get('merchants')) {
                foreach($request->get('merchants') as $merchant) {
                    $exist_merchant = Merchant::find($merchant);
                    if($exist_merchant) {
                        $merchant_ids[] = $merchant;
                    }
                }
            }
            $item->merchants()->sync($merchant_ids);

            DB::commit();
            Session::flash("success", "New Merchant Mood successfully created.");

            return redirect()->route('admin.merchants.moods.index');

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    
    public function edit(Mood $item) {
        $merchants = Merchant::where('active', 1)->get();
        return view('admin.merchants.moods.edit', compact('item', 'merchants'));
    }

    public function update(Mood $item, Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp',
            'active' => 'required|numeric',
            'merchants' => 'nullable',
        ]);

        DB::beginTransaction();

        try {

            $item->name = $request->get('name');
            $item->active = $request->get('active');

            if($request->hasFile('image')) {
                $temp_path = $item->image;

                $file = $request->file('image');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = Mood::UPLOAD_PATH;
                $prefix_name = Mood::FILE_PREFIX;
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

            $merchant_ids = [];
            if($request->get('merchants')) {
                foreach($request->get('merchants') as $merchant) {
                    $exist_merchant = Merchant::find($merchant);
                    if($exist_merchant) {
                        $merchant_ids[] = $merchant;
                    }
                }
            }
            $item->merchants()->sync($merchant_ids);

            DB::commit();
            Session::flash("success", "Mood details successfully updated.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to update. '.$e->getMessage(),
            ]]);
        } 
    }

    public function destroy(Mood $mood) {
        //
        if(empty($mood)){
            return response()->json(['success' => false, 'message' => 'Mood not found.']);
        }
 
        $mood->delete();
 
        Session::flash("success", "Mood has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
