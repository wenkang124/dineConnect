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

        $notification = Notification::where('id', $id)->firstOrFail();
        $data = json_decode($notification->data);
        $data->display_date = $notification->display_date;

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $data,
        );
    }
}
