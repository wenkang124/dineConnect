<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Notification;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    use Helpers;

    public function getAllList(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 10;

        $notifications = auth()->user()->notifications()->limit($limit)->offset(($page - 1) * $limit)->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $notifications,
        );
    }


    public function detail(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:notifications',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }


        $notification = Notification::where('id', $id)->firstOrFail();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $notification,
        );
    }
}
