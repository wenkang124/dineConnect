<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Advertisement;
use App\Models\Review;
use App\Models\ReviewComment;
use App\Models\ReviewLike;
use App\Traits\Helpers;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    use Helpers, MediaTrait;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        $review = new Review();
        $review->user_id = Auth::user()->id;
        $review->merchant_id = $request->merchant_id;
        $review->message = $request->message;
        $review->rating = $request->rating;
        $review->save();

        foreach ($request->file('images') ?? [] as $image) {
            $this->upload($image, Review::class);
            // $file_original_name = $file->getClientOriginalName();
            // $extension = strtolower($file->getClientOriginalExtension());
            // $path = Review::UPLOAD_PATH;
            // $prefix_name = Review::FILE_PREFIX;
            // $mime_type = $file->getMimeType();

            // $destination_path = app()->make('path.public') . "/" . $path;

            // $new_filename = $prefix_name . time() . '-' . Str::random(5);
            // $new_filename_with_extension = $new_filename . "." . $extension;

            // $upload_success = $file->move($destination_path, $new_filename_with_extension);
        }

        $review->save();


        return $this->__apiSuccess(
            'Review Successful.',
            $review,
        );
    }

    public function detail(Request $request, $id)
    {
        $review = Review::where('id', $id)->firstOrFail();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $review,
        );
    }

    public function comment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        $review = Review::where('id', $id)->firstOrFail();

        $comment = new ReviewComment();
        $comment->user_id = Auth::user()->id;
        $comment->review_id = $review->id;
        $comment->message = $request->message;
        $comment->save();

        return $this->__apiSuccess(
            'Comment Successful.',
            $comment,
        );
    }

    public function like(Request $request, $id)
    {

        $review_like = ReviewLike::where('user_id', Auth::user()->id)->where('review_id', $id)->first();
        if ($review_like) {
            $review_like->delete();
        } else {
            $review_like = new ReviewLike();
            $review_like->user_id = Auth::user()->id;
            $review_like->review_id = $id;
            $review_like->save();
        }

        return $this->__apiSuccess(
            'Like Successful.'
        );
    }
}
