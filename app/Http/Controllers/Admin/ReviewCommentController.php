<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\Comment;
use App\Models\Merchant;
use App\Models\Report;
use App\Models\Review;
use App\Models\User;
use App\Traits\MediaTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Image;

class ReviewCommentController extends Controller
{
    use MediaTrait;
    
    public function index($review_id)
    {
        return view('admin.merchants.reviews.comments.index', compact('review_id'));
    }

    public function dataTable($review_id)
    {
        $review = Review::where('id', $review_id)->first();
        $items = $review->comments();

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
                ->addColumn('actions', function ($item)  use ($review){
                    return '<a href="'.route('admin.review_comments.show', ['review_id'=>$review->id,'item'=>$item]).'" class="btn btn-xs btn-primary mx-1 my-1"><i class="fa fa-eye"></i></a>
                            <a href="'.route('admin.review_comments.destroy', ['comment'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this comment?" data-redirect="'.route('admin.merchant_reviews.show', ['merchant_id'=>$review->itemable_id,'item'=>$review]).'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
    }

    
    public function reportDataTable($comment)
    {
        $comment = Comment::where('id', $comment)->first();
        $items = $comment->reports();

        return Datatables::of($items)
                ->addColumn('user', function ($item) {
                    return $item->user_name;
                })
                ->addColumn('reason_name', function ($item) {
                    return $item->reason;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at_ymd_hia;
                })
                ->editColumn('active', function ($item) {
                    return $item->status_name;
                })
                ->addColumn('actions', function ($item)  use ($comment){
                    return '<a href="'.route('admin.review_comments.reports.destroy', ['report'=>$item]).'" class="btn btn-xs btn-danger mx-1 my-1 delete-btn" data-confirm="Are you sure you want to delete this report?" data-redirect="'.route('admin.review_comments.show', ['review_id'=>$comment->itemable_id,'item'=>$comment]).'"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
    }


    public function show($review_id, Review $item) {
        $review = Review::where('id', $review_id)->first();
        return view('admin.merchants.reviews.comments.show', compact('review','item'));
    }

    public function destroy(Comment $comment) {
        //
        if(empty($comment)){
            return response()->json(['success' => false, 'message' => 'Comment not found.']);
        }
 
        $comment->delete();

        Session::flash("success", "Comment has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }
    

    public function reportDestroy(Report $report) {
        //
        if(empty($report)){
            return response()->json(['success' => false, 'message' => 'Report not found.']);
        }
 
        $report->delete();

        Session::flash("success", "Report has been successfully deleted.");
 
        return response()->json(['success' => true]);
    }

}
