<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Country;
use App\Models\MenuCategory;
use App\Models\Merchant;
use App\Models\MerchantOperationDaySetting;
use App\Models\Mood;
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
                                    <a class="dropdown-item" href="'.route('admin.menu_sub_categories.index', ['merchant_id'=> $item->id]).'">Dishes Management</a>
                                    <a class="dropdown-item" href="'.route('admin.merchant_galleries.index', ['merchant_id'=> $item->id]).'">Galleries Management</a>
                                </div>
                            </div>';
                })
                ->rawColumns(['thumbnail', 'actions'])
                ->make(true);
    }

    public function show(Merchant $item) {
        $categories = Category::where('active', Category::ACTIVE)->get();
        $moods = Mood::where('active', Mood::ACTIVE)->get();
        $countries = Country::where('status', 1)->get();
        $advertisements = Advertisement::all();

        return view('admin.merchants.show', compact('item', 'categories', 'moods', 'countries', 'advertisements'));
    }

    public function create() {
        $categories = Category::where('active', Category::ACTIVE)->get();
        $moods = Mood::where('active', Mood::ACTIVE)->get();
        $countries = Country::where('status', 1)->get();
        $advertisements = Advertisement::all();

        return view('admin.merchants.create', compact('categories', 'moods', 'countries', 'advertisements'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png,gif,webp',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'state' => 'required',
            'country_id' => 'required',
            'lng' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
            'active' => 'required|numeric',
            'is_open' => 'required|numeric',
            'operation_days' => 'nullable',
            'start_times' => 'nullable',
            'end_times' => 'nullable',
            'categories' => 'required',
            'moods' => 'required',
            'advertisements' => 'nullable'
        ]);

        DB::beginTransaction();

        try {

            $item = new Merchant();

            // Details
            $item->name = $request->get('name');
            $item->description = $request->get('description');
            $item->address = $request->get('address');
            $item->city = $request->get('city');
            $item->postal_code = $request->get('postal_code');
            $item->state = $request->get('state');
            $item->country_id = $request->get('country_id');
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

            // Operation Details
            $item->is_open = $request->get('is_open');

            $item->save();

            //Operation Details
            foreach(MerchantOperationDaySetting::DAY_LABEL as $key => $value) {
                if($request->get('operation_days')) {
                    if(isset($request->get('operation_days')[$key])) {
                        $item->operationDaySettings()->updateOrCreate([
                            'day' => $key,
                            'merchant_id' => $item->id,
                        ], [
                            'start_time' => date('H:i:s', strtotime($request->get('start_times')[$key])),
                            'end_time' => date('H:i:s', strtotime($request->get('end_times')[$key])),
                            'active' => true,
                        ]);
                    } else {
                        $item->operationDaySettings()->updateOrCreate([
                            'day' => $key,
                            'merchant_id' => $item->id,
                        ], [
                            'active' => false,
                        ]);
                    }
                } else {      
                    $item->operationDaySettings()->updateOrCreate([
                        'day' => $key,
                        'merchant_id' => $item->id,
                    ], [
                        'active' => false,
                    ]);
                }
            }

            // Other Details
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
            
            if($request->get('moods')) {
                $mood_ids = [];
                foreach($request->get('moods') as $mood) {
                    $exist_mood = Mood::find($mood);
                    if(!$exist_mood) {
                        $new_mood = Mood::create([
                            'name' => $mood,
                            'image' => 'https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg',
                            'active' => Mood::ACTIVE
                        ]);
                        $mood_ids[]= $new_mood->id;
                    } else {
                        $mood_ids[] = $mood;
                    }
                }

                $item->moods()->sync($mood_ids);
            }

            $advertisement_ids = [];
            if($request->get('advertisements')) {
                foreach($request->get('advertisements') as $advertisement) {
                    $exist_advertisement = Advertisement::find($advertisement);
                    if($exist_advertisement) {
                        $advertisement_ids[] = $advertisement;
                    }
                }
            }
            $item->advertisements()->sync($advertisement_ids);

            //Merchant Menu Categories Default Food and Beverage
            $menu_categories = MenuCategory::pluck('id')->toArray();
            $item->menuCategories()->sync($menu_categories);

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
        $categories = Category::where('active', Category::ACTIVE)->get();
        $moods = Mood::where('active', Mood::ACTIVE)->get();
        $countries = Country::where('status', 1)->get();
        $advertisements = Advertisement::all();

        return view('admin.merchants.edit', compact('item', 'categories', 'moods', 'countries', 'advertisements'));
    }

    public function update(Merchant $item, Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'state' => 'required',
            'country_id' => 'required',
            'lng' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
            'active' => 'required|numeric',
            'is_open' => 'required|numeric',
            'operation_days' => 'nullable',
            'start_times' => 'nullable',
            'end_times' => 'nullable',
            'categories' => 'required',
            'moods' => 'required'
        ]);

        DB::beginTransaction();

        try {

            // Details
            $item->name = $request->get('name');
            $item->description = $request->get('description');
            $item->address = $request->get('address');
            $item->city = $request->get('city');
            $item->postal_code = $request->get('postal_code');
            $item->state = $request->get('state');
            $item->country_id = $request->get('country_id');
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
            
            // Operation Details
            $item->is_open = $request->get('is_open');

            $item->save();

            //Operation Details
            foreach(MerchantOperationDaySetting::DAY_LABEL as $key => $value) {
                if($request->get('operation_days')) {
                    if(isset($request->get('operation_days')[$key])) {
                        $item->operationDaySettings()->updateOrCreate([
                            'day' => $key,
                            'merchant_id' => $item->id,
                        ], [
                            'start_time' => date('H:i:s', strtotime($request->get('start_times')[$key])),
                            'end_time' => date('H:i:s', strtotime($request->get('end_times')[$key])),
                            'active' => true,
                        ]);
                    } else {
                        $item->operationDaySettings()->updateOrCreate([
                            'day' => $key,
                            'merchant_id' => $item->id,
                        ], [
                            'active' => false,
                        ]);
                    }
                } else {      
                    $item->operationDaySettings()->updateOrCreate([
                        'day' => $key,
                        'merchant_id' => $item->id,
                    ], [
                        'active' => false,
                    ]);
                }
            }

            // Other Details
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

            if($request->get('moods')) {
                $mood_ids = [];
                foreach($request->get('moods') as $mood) {
                    $exist_mood = Mood::find($mood);
                    if(!$exist_mood) {
                        $new_mood = Mood::create([
                            'name' => $mood,
                            'image' => 'https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg',
                            'active' => Mood::ACTIVE
                        ]);
                        $mood_ids[]= $new_mood->id;
                    } else {
                        $mood_ids[] = $mood;
                    }
                }

                $item->moods()->sync($mood_ids);
            }

            $advertisement_ids = [];
            if($request->get('advertisements')) {
                foreach($request->get('advertisements') as $advertisement) {
                    $exist_advertisement = Advertisement::find($advertisement);
                    if($exist_advertisement) {
                        $advertisement_ids[] = $advertisement;
                    }
                }

            }
            $item->advertisements()->sync($advertisement_ids);

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
 
        $merchant->menuFoods()->delete();
        $merchant->operationDaySettings()->delete();
        $merchant->categories()->detach();
        $merchant->moods()->detach();
        $merchant->delete();
 
        Session::flash("success", "Merchant has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
