<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    use Helpers;

    public function getAllList(Request $request)
    {
        // $page = $request->get('page') ?? 1;
        // $limit = $request->get('limit') ?? 10;

        $notifications = Notification::where('notifiable_type', User::class)->where('notifiable_id', auth()->user()->id)->get();;

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $notifications,
        );
    }


    public function detail(Request $request, $id)
    {

        $notification = Notification::where('id', $id)->firstOrFail();
        $data = $notification->data;
        $data['display_date'] = $notification->display_date;

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $data,
        );
    }
}
