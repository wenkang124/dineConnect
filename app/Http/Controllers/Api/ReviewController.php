<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Review;
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
            'type' => 'required',
            'id' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        $model = app()->make('App\Models\\' . $request->type);

        $review = new Review();
        $review->user_id = Auth::user()->id;
        $review->itemable_type  = $model::class;
        $review->itemable_id   = $request->id;
        $review->message = $request->message;
        $review->rating = $request->rating;
        $review->save();

        // foreach ($request->file('images') ?? [] as $image) {
        //     $this->upload($image, Review::class);
        // $file_original_name = $file->getClientOriginalName();
        // $extension = strtolower($file->getClientOriginalExtension());
        // $path = Review::UPLOAD_PATH;
        // $prefix_name = Review::FILE_PREFIX;
        // $mime_type = $file->getMimeType();

        // $destination_path = app()->make('path.public') . "/" . $path;

        // $new_filename = $prefix_name . time() . '-' . Str::random(5);
        // $new_filename_with_extension = $new_filename . "." . $extension;

        // $upload_success = $file->move($destination_path, $new_filename_with_extension);
        // }

        $review->save();


        return $this->__apiSuccess(
            'Review Successful.',
            $review,
        );
    }

    public function detail(Request $request, $id)
    {
        $review = Review::where('id', $id)->with('comments.likes')->firstOrFail();
        
        return $this->__apiSuccess(
            'Retrieve Successful.',
            $review,
        );
    }

    public function comment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'type' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        $model = app()->make('App\Models\\' . $request->type);

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->itemable_type  = $model::class;
        $comment->itemable_id   = $request->id;
        $comment->message = $request->message;
        $comment->save();

        return $this->__apiSuccess(
            'Comment Successful.',
            $comment,
        );
    }

    public function like(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        $model = app()->make('App\Models\\' . $request->type);

        $like = Like::where('user_id', Auth::user()->id)->where('itemable_type', $model::class)->where('itemable_id', $request->id)->first();

        if ($like) {
            $like->delete();
        } else {
            $like = new Like();
            $like->user_id = Auth::user()->id;
            $like->itemable_type  = $model::class;
            $like->itemable_id   = $request->id;
            $like->save();
        }

        return $this->__apiSuccess(
            'Like Successful.'
        );
    }
}
