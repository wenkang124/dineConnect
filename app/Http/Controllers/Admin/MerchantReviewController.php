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
        $merchant = Merchant::find($merchant_id);
        return view('admin.merchants.reviews.index', compact('merchant','merchant_id'));
    }

    public function dataTable($merchant_id)
    {
        $merchant = Merchant::where('id', $merchant_id)->first();
        $items = $merchant->reviews();

        return Datatables::of($items)
                ->addColumn('user', function ($item) {
                    return $item->user_name;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->editColumn('active', function ($item) {
                    return $item->status_name;
                })
                ->addColumn('total_views', function ($item) {
                    return $item->views()->count();
                })
                ->addColumn('actions', function ($item)  use ($merchant){
                    return '<a href="'.route('admin.merchant_reviews.show', ['merchant_id'=>$merchant->id,'item'=>$item]).'" class="btn btn-xs btn-primary mx-1 my-1"><i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.merchant_reviews.destroy', ['review'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this review?" data-redirect="'.route('admin.merchant_reviews.index', ['merchant_id'=>$merchant->id]).'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
    }

    public function show($merchant_id, Review $item) {
        $merchant = Merchant::find($merchant_id);
        return view('admin.merchants.reviews.show', compact('merchant','merchant_id','item'));
    }

    public function destroy(Review $review) {
        //
        if(empty($review)){
            return response()->json(['success' => false, 'message' => 'Review not found.']);
        }
 
        $review->delete();

        Session::flash("success", "Review has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
