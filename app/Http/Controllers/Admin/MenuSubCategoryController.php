<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Country;
use App\Models\MenuCategory;
use App\Models\MenuFood;
use App\Models\MenuSubCategory;
use App\Models\Merchant;
use App\Models\MerchantMenuCategory;
use App\Models\Mood;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class MenuSubCategoryController extends Controller
{
    use MediaTrait;
    
    public function index($merchant_id)
    {
        $merchant = Merchant::find($merchant_id);
        return view('admin.menu_sub_categories.index', compact('merchant', 'merchant_id'));
    }

    public function dataTable($merchant_id)
    {
        // $merchant = Merchant::find($merchant_id);        
        // $items = MenuSubCategory::query();

        $items = MenuSubCategory::query()->whereHas('merchant_menu_category', function ($query) use ($merchant_id) {
            $query->where('merchant_id', $merchant_id);
        });
        
        return Datatables::of($items)
                ->editColumn('active', function ($item) {
                    return $item->status_name;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->editColumn('thumbnail', function ($item) {
                    return "<img src='".$item->image_path."' width='250' class='p-4' />";
                })
                ->addColumn('category', function ($item) {
                    return $item->merchant_menu_category? $item->merchant_menu_category->menuCategory->name : '-';
                })
                ->addColumn('actions', function ($item) use ($merchant_id) {
                    return '<a href="'.route('admin.menu_sub_categories.show', ['merchant_id'=>$merchant_id, 'item'=>$item]).'" class="btn btn-xs btn-primary mx-1 my-1">View <i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.menu_sub_categories.edit', ['merchant_id'=>$merchant_id, 'item'=>$item]).'" class="btn btn-xs btn-warning mx-1 my-1">Edit <i class="fa fa-edit"></i></a>                           
                            <a href="'.route('admin.menu_sub_categories.destroy', ['menu_sub_category'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this data?" data-redirect="'.route('admin.menu_sub_categories.index', ['merchant_id'=> $merchant_id]).'">Delete <i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['thumbnail', 'actions'])
                ->make(true);
    }

    public function show($merchant_id, MenuSubCategory $item) {
        $merchant = Merchant::where('id', $merchant_id)->first();
        $categories = $merchant->merchantMenuCategories;

        return view('admin.menu_sub_categories.show', compact('merchant_id', 'item', 'categories'));
    }

    public function create($merchant_id) {
        $merchant = Merchant::where('id', $merchant_id)->first();
        $categories = $merchant->merchantMenuCategories;

        return view('admin.menu_sub_categories.create', compact('merchant_id', 'categories'));
    }

    public function store($merchant_id, Request $request) {
        $this->validate($request, [
            'merchant_menu_category' => 'required',
            'name' => 'required',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png,gif,webp',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $merchant = Merchant::where('id',$merchant_id)->first();

            if($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = MenuSubCategory::UPLOAD_PATH;
                $prefix_name = MenuSubCategory::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $thumbnail = rtrim($path, '/') . "/" . $new_filename_with_extension;
            }      

            $merchant_menu_category = MerchantMenuCategory::find($request->get('merchant_menu_category')[0]);

            $item = new MenuSubCategory([
                'name' => $request->get('name'),
                'active' => $request->get('active'),
                'image' => $thumbnail ?? null,
            ]);

            $merchant_menu_category->menuSubCategories()->save($item);

            DB::commit();
            Session::flash("success", "New menu sub category successfully created.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    
    public function edit($merchant_id, MenuSubCategory $item) {
        $merchant = Merchant::where('id', $merchant_id)->first();
        $categories = $merchant->merchantMenuCategories;

        return view('admin.menu_sub_categories.edit', compact('merchant_id', 'item', 'categories'));
    }

    public function update(MenuSubCategory $item, Request $request) {

        $this->validate($request, [
            'merchant_menu_category' => 'required',
            'name' => 'required',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            if($request->hasFile('thumbnail')) {
                $temp_path = $item->thumbnail;

                $file = $request->file('thumbnail');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = MenuSubCategory::UPLOAD_PATH;
                $prefix_name = MenuSubCategory::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $thumbnail = rtrim($path, '/') . "/" . $new_filename_with_extension;

                if($temp_path && $temp_path != "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg") {
                    unlink($temp_path);
                }
            }      
            
            $data = [
                'merchant_menu_category_id' => $request->get('merchant_menu_category')[0],
                'name' => $request->get('name'),
                'active' => $request->get('active'),
                'image' => $thumbnail ?? $item->image,
            ];

            $item->update($data);

            DB::commit();
            Session::flash("success", "Menu sub category successfully updated.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    public function destroy(MenuSubCategory $menu_sub_category) {
        //
        if(empty($menu_sub_category)){
            return response()->json(['success' => false, 'message' => 'Dish not found.']);
        }

        $menu_sub_category->delete();
 
        Session::flash("success", "Menu sub category has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
