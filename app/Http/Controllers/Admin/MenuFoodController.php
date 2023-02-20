<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Country;
use App\Models\MenuCategory;
use App\Models\MenuFood;
use App\Models\MenuSubCategory;
use App\Models\Merchant;
use App\Models\Mood;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class MenuFoodController extends Controller
{
    use MediaTrait;
    
    public function index($merchant_id)
    {
        return view('admin.menu_foods.index', compact('merchant_id'));
    }

    public function dataTable($merchant_id)
    {
        $items = MenuFood::query()->where('merchant_id', $merchant_id);

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
                    return $item->menuCategories()? $item->menuCategories()->pluck('name')->first() : '-';
                })
                ->addColumn('actions', function ($item) {
                    return '<a href="'.route('admin.menu_foods.show', ['merchant_id'=>$item->merchant_id, 'item'=>$item]).'" class="btn btn-xs btn-primary mx-1 my-1">View <i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.menu_foods.edit', ['merchant_id'=>$item->merchant_id, 'item'=>$item]).'" class="btn btn-xs btn-warning mx-1 my-1">Edit <i class="fa fa-edit"></i></a>                           
                            <a href="'.route('admin.menu_foods.destroy', ['menu_food'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this food from menu?" data-redirect="'.route('admin.menu_foods.index', ['merchant_id'=> $item->merchant_id]).'">Delete <i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['thumbnail', 'actions'])
                ->make(true);
    }

    public function show($merchant_id, MenuFood $item) {
        $categories = Category::where('active', Category::ACTIVE)->get();
        $moods = Mood::where('active', Mood::ACTIVE)->get();

        return view('admin.menu_foods.show', compact('merchant_id', 'item', 'categories', 'moods'));
    }

    public function create($merchant_id) {
        $categories = MenuCategory::where('active', MenuCategory::ACTIVE)->get();
        $sub_categories = MenuSubCategory::where('active', MenuSubCategory::ACTIVE)->get();

        return view('admin.menu_foods.create', compact('merchant_id', 'categories', 'sub_categories'));
    }

    public function store($merchant_id, Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png,gif',
            'price' => 'nullable|numeric',
            'active' => 'required|numeric',
            'categories' => 'required',
            'sub_categories' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $merchant = Merchant::where('id',$merchant_id)->first();

            if($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = MenuFood::UPLOAD_PATH;
                $prefix_name = MenuFood::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $thumbnail = rtrim($path, '/') . "/" . $new_filename_with_extension;
            }      

            $item = new MenuFood([
                'name' => $request->get('name'),
                'short_description' => $request->get('short_description'),
                'description' => $request->get('description'),
                'price' => $request->get('price'),
                'active' => $request->get('active'),
                'thumbnail' => $thumbnail ?? null,
            ]);

            $merchant->menuFoods()->save($item);

            if($request->get('categories')) {
                $category_ids = [];
                foreach($request->get('categories') as $category) {
                    $exist_category = MenuCategory::find($category);
                    if(!$exist_category) {
                        $new_category = MenuCategory::create([
                            'name' => $category,
                            'image' => 'https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg',
                            'active' => MenuCategory::ACTIVE
                        ]);
                        $category_ids[]= $new_category->id;
                    } else {
                        $category_ids[] = $category;
                    }
                }
                //remove detach if multiple categories
                $item->menuCategories()->detach();

                $item->menuCategories()->sync($category_ids);
            }
            
            if($request->get('sub_categories')) {
                $sub_category_ids = [];
                foreach($request->get('sub_categories') as $sub_category) {
                    $exist_sub_category = MenuSubCategory::find($sub_category);
                    if(!$exist_sub_category) {
                        $new_sub_category = MenuSubCategory::create([
                            'name' => $sub_category,
                            'image' => 'https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg',
                            'active' => MenuSubCategory::ACTIVE
                        ]);
                        $sub_category_ids[]= $new_sub_category->id;
                    } else {
                        $sub_category_ids[] = $sub_category;
                    }
                }
                
                $item->menuSubCategories()->sync($sub_category_ids);
            }

            DB::commit();
            Session::flash("success", "New dish successfully created.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    
    public function edit($merchant_id, MenuFood $item) {
        $categories = MenuCategory::where('active', MenuCategory::ACTIVE)->get();
        $sub_categories = MenuSubCategory::where('active', MenuSubCategory::ACTIVE)->get();

        return view('admin.menu_foods.edit', compact('merchant_id', 'item', 'categories', 'sub_categories'));
    }

    public function update(MenuFood $item, Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'price' => 'nullable|numeric',
            'active' => 'required|numeric',
            'categories' => 'required',
            'sub_categories' => 'required'
        ]);

        DB::beginTransaction();

        try {

            if($request->hasFile('thumbnail')) {
                $temp_path = $item->thumbnail;

                $file = $request->file('thumbnail');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = MenuFood::UPLOAD_PATH;
                $prefix_name = MenuFood::FILE_PREFIX;
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
                'name' => $request->get('name'),
                'short_description' => $request->get('short_description'),
                'description' => $request->get('description'),
                'price' => $request->get('price'),
                'active' => $request->get('active'),
                'thumbnail' => $thumbnail ?? $item->thumbnail,
            ];

            $item->update($data);

            if($request->get('categories')) {
                $category_ids = [];
                foreach($request->get('categories') as $category) {
                    $exist_category = MenuCategory::find($category);
                    if(!$exist_category) {
                        $new_category = MenuCategory::create([
                            'name' => $category,
                            'image' => 'https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg',
                            'active' => MenuCategory::ACTIVE
                        ]);
                        $category_ids[]= $new_category->id;
                    } else {
                        $category_ids[] = $category;
                    }
                }
                //remove detach if multiple categories
                $item->menuCategories()->detach();

                $item->menuCategories()->sync($category_ids);
            }
            
            if($request->get('sub_categories')) {
                $sub_category_ids = [];
                foreach($request->get('sub_categories') as $sub_category) {
                    $exist_sub_category = MenuSubCategory::find($sub_category);
                    if(!$exist_sub_category) {
                        $new_sub_category = MenuSubCategory::create([
                            'name' => $sub_category,
                            'image' => 'https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg',
                            'active' => MenuSubCategory::ACTIVE
                        ]);
                        $sub_category_ids[]= $new_sub_category->id;
                    } else {
                        $sub_category_ids[] = $sub_category;
                    }
                }
                
                $item->menuSubCategories()->sync($sub_category_ids);
            }

            DB::commit();
            Session::flash("success", "Dish details successfully updated.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    public function destroy(MenuFood $menu_food) {
        //
        if(empty($menu_food)){
            return response()->json(['success' => false, 'message' => 'Dish not found.']);
        }

        $menu_food->menuCategories()->detach();
        $menu_food->menuSubCategories()->detach();
        $menu_food->delete();
 
        Session::flash("success", "Dish has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
