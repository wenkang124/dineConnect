<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\Category;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class CategoryController extends Controller
{
    use MediaTrait;
    
    public function index()
    {
        return view('admin.categories.index');
    }

    public function dataTable()
    {
        $items = Category::query();

        return Datatables::of($items)
                ->editColumn('active', function ($item) {
                    return $item->status_name;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->addColumn('action', function ($item) {
                    return '<a href="'.route('admin.categories.show', [$item]).'" class="btn btn-xs btn-primary mx-1"><i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.categories.edit', [$item]).'" class="btn btn-xs btn-warning mx-1"><i class="fa fa-edit"></i></a>
                            <a href="'.route('admin.categories.destroy', ['category'=>$item]).'" class="btn btn-xs btn-danger mx-1 delete-btn" data-confirm="Are you sure you want to delete this category?" data-redirect="'.route('admin.categories.index').'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function show(Category $item) {
        return view('admin.categories.show', compact('item'));
    }

    public function create() {
        return view('admin.categories.create');
    }

    public function store(Request $request) {
        $request->merge([
            'new_phone' => str_replace('-', '', str_replace(" ", "", $request->get('phone'))),
        ]);

        $this->validate($request, [
            'create_img' => 'nullable',
            'name' => 'required',
            'password' => 'required|min:4|max:4',
            'confirmation_password' => 'required|min:4|max:4|same:password',
            'mobile_prefix_id' => 'required',
            'new_phone' => 'required',
            'email' => 'required|email|unique:categories,email,NULL,id,deleted_at,NULL',
            'active' => 'required',
        ]);

        $phoneCodeCountry = Country::where('phonecode', $request->get('mobile_prefix_id'))->first();
        $exist = Category::where('mobile_prefix_id', $phoneCodeCountry->id)->where('phone', $request->get('new_phone'))->exists();

        if($exist) {
            return redirect()->back()->withErrors('Mobile number is already exists.');
        }

        DB::beginTransaction();

        try {

            $category = new Category();

            $category->name = $request->get('name');
            $category->email = $request->get('email');
            $category->phone = $request->get('new_phone');
            $category->mobile_prefix_id = $phoneCodeCountry? $phoneCodeCountry->id : 129;
            $category->occupation = $request->get('occupation');
            $category->password = bcrypt($request->get('password'));
            $category->active = $request->get('active');

            if($request->get('profile_image')) {
                $data = $request->get('create_img');
                $img = Image::make($data);
                $img->resize(600, 600);
                $file_name = "profile_" . time() . '.png';
                $upload_path = public_path(Category::IMAGE_ASSET_PATH);

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0755, true);
                }
        
                $img->save($upload_path .'/'. $file_name);
        
                $category->profile_image = Category::IMAGE_ASSET_PATH . '/' .$file_name;  
            }    
            $category->save();

            DB::commit();
            Session::flash("success", "New category successfully created.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    
    public function edit(Category $item) {
        return view('admin.categories.edit', compact('item'));
    }

    public function update(Category $item, Request $request) {
        $request->merge([
            'new_phone' => str_replace('-', '', str_replace(" ", "", $request->get('phone'))),
        ]);

        $this->validate($request, [
            'create_img' => 'nullable',
            'name' => 'required',
            'password' => 'nullable|min:4|max:4',
            'confirmation_password' => 'nullable|min:4|max:4|same:password',
            'mobile_prefix_id' => 'required',
            'new_phone' => 'required',
            'email' => 'required|email',
            'active' => 'required',
        ]);

        $phoneCodeCountry = Country::where('phonecode', $request->get('mobile_prefix_id'))->first();
        if($phoneCodeCountry && ($item->mobile_prefix_id != $phoneCodeCountry->id || $item->phone != $request->get('new_phone'))) {
            
            $exist = Category::where('mobile_prefix_id', $phoneCodeCountry->id)->where('phone', $request->get('new_phone'))->exists();
    
            if($exist) {
                return redirect()->back()->withErrors('Mobile number is already exists.');
            }    
        }

        if($item->email != $request->get('email')) {
            $exist = Category::where('email', $request->get('email'))->exists();
    
            if($exist) {
                return redirect()->back()->withErrors('Email is already exists.');
            }    
        }

        DB::beginTransaction();

        try {

            $item->name = $request->get('name');
            $item->email = $request->get('email');
            $item->phone = $request->get('new_phone');
            $item->mobile_prefix_id = $phoneCodeCountry? $phoneCodeCountry->id : 129;
            $item->occupation = $request->get('occupation');
            $item->active = $request->get('active');

            if($item->password) {
                $item->password = bcrypt($request->get('password'));
            }

            if($request->get('profile_image')) {
                $temp_path = $item->profile_image;
                $data = $request->get('create_img');
                $img = Image::make($data);
                $img->resize(600, 600);
                $file_name = "profile_" . time() . '.png';
                $upload_path = public_path(Category::IMAGE_ASSET_PATH);

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0755, true);
                }
        
                $img->save($upload_path .'/'. $file_name);
        
                $item->profile_image = Category::IMAGE_ASSET_PATH . '/' .$file_name;  
                if($temp_path) {
                    unlink($temp_path);
                }
            }    
            $item->save();

            DB::commit();
            Session::flash("success", "Category details successfully updated.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to update. '.$e->getMessage(),
            ]]);
        } 
    }

    public function destroy(Category $category) {
        //
        if(empty($category)){
            return response()->json(['success' => false, 'message' => 'Category not found.']);
        }
 
        $category->delete();
 
        Session::flash("success", "Category has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
