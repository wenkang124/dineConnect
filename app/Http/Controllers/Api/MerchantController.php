<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\MerchantMoodResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\Mood;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    use Helpers;

    public function randomList(Request $request)
    {

        $merchant = Merchant::active()->inRandomOrder()->limit($request->get('limit') ?? 5)->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $merchant,
        );
    }

    public function getMerchantList(Request $request)
    {

        if ($request->get('type') == "mode") {
            $list = Mood::Active()->where('id', $request->get('id'))->first();
        } else {
            $list = Category::Active()->where('id', $request->get('id'))->first();
        }


        return $this->__apiSuccess(
            'Retrieve Successful.',
            $list->merchants,
        );
    }

    public function detail(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:merchants',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        $merchant = Merchant::find($id);

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $merchant,
        );
    }
}
