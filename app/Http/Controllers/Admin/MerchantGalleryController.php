<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\User;
use App\Traits\MediaTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class MerchantGalleryController extends Controller
{
    use MediaTrait;
    
    public function index($merchant_id)
    {
        return view('admin.merchants.galleries.index', compact('merchant_id'));
    }

    public function dataTable($merchant_id)
    {
        $items = MerchantGallery::query()->where('merchant_id', $merchant_id);
        
        return Datatables::of($items)
                ->editColumn('image', function ($item) {
                    return "<img src='".$item->image_path."' width='250' class='p-4' />";
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->editColumn('active', function ($item) {
                    return $item->status_name;
                })
                ->addColumn('actions', function ($item) {
                    return '<a href="'.route('admin.merchant_galleries.show', ['merchant_id'=>$item->merchant_id, 'item'=>$item]).'" class="btn btn-xs btn-primary mx-1 my-1"><i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.merchant_galleries.edit', ['merchant_id'=>$item->merchant_id, 'item'=>$item]).'" class="btn btn-xs btn-warning mx-1 my-1"><i class="fa fa-edit"></i></a>
                            <a href="'.route('admin.merchant_galleries.destroy', ['merchant_gallery'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this gallery?" data-redirect="'.route('admin.merchant_galleries.index', ['merchant_id'=>$item->merchant_id]).'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
    }

    public function show(MerchantGallery $item) {
        return view('admin.merchants.galleries.show', compact('item'));
    }

    public function create($merchant_id) {
        return view('admin.merchants.galleries.create', compact('merchant_id'));
    }

    public function store($merchant_id, Request $request) {
        $this->validate($request, [
            'image' => 'required|file|mimes:jpg,jpeg,png,gif,webp',
            'sequence' => 'required|numeric|min:1',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $merchant = Merchant::where('id',$merchant_id)->first();

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = MerchantGallery::UPLOAD_PATH;
                $prefix_name = MerchantGallery::FILE_PREFIX;
                $mime_type = $file->getMimeType();

                $destination_path = app()->make('path.public') . "/" . $path;

                $new_filename = $prefix_name . time() . '-' . Str::random(5);
                $new_filename_with_extension = $new_filename . "." . $extension;

                $upload_success = $file->move($destination_path, $new_filename_with_extension);
                $thumbnail = rtrim($path, '/') . "/" . $new_filename_with_extension;
            }    
            
            $item = new MerchantGallery([
                'sequence' => $request->get('sequence'),
                'active' => $request->get('active'),
                'image' => $thumbnail ?? null,
            ]);

            $merchant->merchantGallery()->save($item);

            DB::commit();
            Session::flash("success", "New Gallery successfully created.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    
    public function edit($merchant_id, MerchantGallery $item) {
        return view('admin.merchants.galleries.edit', compact('merchant_id', 'item'));
    }

    public function update(MerchantGallery $item, Request $request) {
        $this->validate($request, [
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp',
            'sequence' => 'required|numeric|min:1',
            'active' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            if($request->hasFile('image')) {
                $temp_path = $item->image;

                $file = $request->file('image');
                $file_original_name = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $path = MerchantGallery::UPLOAD_PATH;
                $prefix_name = MerchantGallery::FILE_PREFIX;
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
                'sequence' => $request->get('sequence'),
                'active' => $request->get('active'),
                'image' => $thumbnail ?? $item->image,
            ];

            $item->update($data);

            $item->save();

            DB::commit();
            Session::flash("success", "Gallery details successfully updated.");

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => [
                'error' => true,
                'message' => 'Failed to create. '.$e->getMessage(),
            ]]);
        } 
    }

    public function destroy(MerchantGallery $merchant_gallery) {
        //
        if(empty($merchant_gallery)){
            return response()->json(['success' => false, 'message' => 'Gallery not found.']);
        }
 
        $merchant_gallery->delete();

        Session::flash("success", "Gallery has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
