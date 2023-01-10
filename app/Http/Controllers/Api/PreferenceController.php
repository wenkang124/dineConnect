<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Preference;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PreferenceController extends Controller
{
    use Helpers;

    public function getAllList()
    {
        $list = Preference::Active()->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $list,
        );
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'preferences' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }


        auth()->user()->preferences()->sync(json_decode($request->preferences));

        return $this->__apiSuccess(
            'Submit Successful.',
            auth()->user()->preferences,
        );
    }
}
