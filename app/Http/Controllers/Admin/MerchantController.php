<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Country;
use App\Models\Merchant;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class MerchantController extends Controller
{
    use MediaTrait;
    
    public function index()
    {
        return view('admin.merchants.index');
    }

    public function dataTable()
    {
        $items = Merchant::query();

        return Datatables::of($items)
                ->editColumn('active', function ($item) {
                    return $item->status_name;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->editColumn('thumbnail', function ($item) {
                    return "<img src='".$item->thumbnail."' width='250' class='p-4' />";
                })
                ->addColumn('actions', function ($item) {
                    return '<a href="'.route('admin.merchants.show', [$item]).'" class="btn btn-xs btn-primary mx-1 my-1">View <i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.merchants.edit', [$item]).'" class="btn btn-xs btn-warning mx-1 my-1">Edit <i class="fa fa-edit"></i></a>                           
                            <a href="'.route('admin.merchants.destroy', ['merchant'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this merchant?" data-redirect="'.route('admin.merchants.index').'">Delete <i class="fa fa-trash"></i></a>
                            <div class="dropdown">
                                <button class="btn btn-xs btn-secondary dropdown-toggle mx-1 my-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    More Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>';
                })
                ->rawColumns(['thumbnail', 'actions'])
                ->make(true);
    }

    public function show(Merchant $item) {
        return view('admin.merchants.show', compact('item'));
    }

    public function create() {
        $categories = Category::where('active', Category::ACTIVE)->get();

        return view('admin.merchants.create', compact('categories'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png,gif',
            'lng' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
            'active' => 'required|numeric',
            'categories' => 'required'
        ]);

        DB::beginTransaction();

        try {

            $item = new Merchant();

            $item->name = $request->get('name');
            $item->description = $request->get('description');
            $item->lng = $request->get('lng');
            $item->lat = $request->get('lat');
            $item->active = $request->get('active');

            if($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = Merchant::UPLOAD_PATH;
                $prefix_name = Merchant::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $item->thumbnail = rtrim($path, '/') . "/" . $new_filename_with_extension;
            }      

            $item->save();
            
            if($request->get('categories')) {
                $category_ids = [];
                foreach($request->get('categories') as $category) {
                    $exist_category = Category::find($category);
                    if(!$exist_category) {
                        $new_category = Category::create([
                            'name' => $category,
                            'image' => 'https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg',
                            'active' => Category::ACTIVE
                        ]);
                        $category_ids[]= $new_category->id;
                    } else {
                        $category_ids[] = $category;
                    }
                }

                $item->categories()->sync($category_ids);
            }

            DB::commit();
            Session::flash("success", "New merchant successfully created.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    
    public function edit(Merchant $item) {
        return view('admin.merchants.edit', compact('item'));
    }

    public function update(Merchant $item, Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'lng' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            $item->name = $request->get('name');
            $item->description = $request->get('description');
            $item->lng = $request->get('lng');
            $item->lat = $request->get('lat');
            $item->active = $request->get('active');

            if($request->hasFile('thumbnail')) {
                $temp_path = $item->thumbnail;

                $file = $request->file('thumbnail');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = Merchant::UPLOAD_PATH;
                $prefix_name = Merchant::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $item->thumbnail = rtrim($path, '/') . "/" . $new_filename_with_extension;

                if($temp_path && $temp_path != "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg") {
                    unlink($temp_path);
                }
            }    
            $item->save();

            DB::commit();
            Session::flash("success", "Merchant details successfully updated.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    public function destroy(Merchant $merchant) {
        //
        if(empty($merchant)){
            return response()->json(['success' => false, 'message' => 'Merchant not found.']);
        }
 
        $merchant->delete();
 
        Session::flash("success", "Merchant has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
