<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Announcement;
use App\Traits\Helpers;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use Helpers;

    public function getAllList(Request $request)
    {

        $announcements = Announcement::Active()->orderBy('created_at')->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $announcements,
        );
    }


    public function detail(Request $request, $id)
    {

        $announcement = Announcement::where('id', $id)->firstOrFail();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $announcement,
        );
    }
}
