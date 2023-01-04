<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Preference;
use App\Traits\Helpers;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    use Helpers;

    public function getAllList()
    {
        $list = Preference::Active()->get();

        return $this->__apiSuccess('Retrieve Successful.', [
            "preferences" => $list,
        ]);
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'preferences' => 'required',
        ]);

        auth()->user()->preferences()->sync(json_decode($request->preferences));

        return $this->__apiSuccess(
            'Submit Successful.',
            auth()->user()->preferences,
        );
    }
}
