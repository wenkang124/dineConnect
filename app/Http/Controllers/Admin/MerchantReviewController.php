<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\Merchant;
use App\Models\Review;
use App\Models\User;
use App\Traits\MediaTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class MerchantReviewController extends Controller
{
    use MediaTrait;
    
    public function index($merchant_id)
    {
        return view('admin.merchants.reviews.index', compact('merchant_id'));
    }

    public function dataTable($merchant_id)
    {
        $merchant = Merchant::where('id', $merchant_id)->first();
        $items = $merchant->reviews();

        return Datatables::of($items)
                ->addColumn('user', function ($item) {
                    return $item->user_name;
                })
                ->addColumn('total_likes', function ($item) {
                    return $item->total_likes;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->editColumn('active', function ($item) {
                    return $item->status_name;
                })
                ->addColumn('actions', function ($item)  use ($merchant){
                    return '<a href="'.route('admin.merchant_reviews.show', ['merchant_id'=>$merchant->id,'item'=>$item]).'" class="btn btn-xs btn-primary mx-1 my-1"><i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.merchant_reviews.destroy', ['review'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this review?" data-redirect="'.route('admin.merchant_reviews.index', ['merchant_id'=>$merchant->id]).'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
    }

    public function show($merchant_id, Review $item) {
        return view('admin.merchants.reviews.show', compact('merchant_id','item'));
    }

    public function destroy(Review $merchant_gallery) {
        //
        if(empty($merchant_gallery)){
            return response()->json(['success' => false, 'message' => 'Gallery not found.']);
        }
 
        $merchant_gallery->delete();

        Session::flash("success", "Gallery has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
