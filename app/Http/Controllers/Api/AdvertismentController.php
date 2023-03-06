<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Advertisement;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvertismentController extends Controller
{
    use Helpers;

    public function getAllList(Request $request)
    {

        $advertisments = Advertisement::Active()->orderBy('sequence')->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $advertisments,
        );
    }


    public function detail(Request $request, $id)
    {
        $advertisment = Advertisement::where('id', $id)->firstOrFail();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $advertisment,
        );
    }
}
