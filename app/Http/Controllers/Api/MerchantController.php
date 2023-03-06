<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\MerchantMoodResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\MenuFood;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\Mood;
use App\Models\UserFavourite;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    use Helpers;

    public function randomList(Request $request)
    {

        $merchants = Merchant::active()->inRandomOrder()->limit($request->get('limit') ?? 5)->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $merchants,
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
            $list->merchants ?? [],
        );
    }

    public function detail(Request $request, $id)
    {
        $merchant = Merchant::where('id', $id)->firstOrFail();
        return $this->__apiSuccess(
            'Retrieve Successful.',
            $merchant,
        );
    }

    public function favourite(Request $request, $id)
    {
        $if_exist = UserFavourite::where('favouritable_type', Merchant::class)->where('favouritable_id', $id)->where('user_id', auth()->user()->id)->first();

        if ($if_exist) {
            $if_exist->delete();
            return $this->__apiSuccess(
                'Unfavourite successfully !',
            );
        } else {
            $favourite = new UserFavourite();
            $favourite->favouritable_type = Merchant::class;
            $favourite->favouritable_id = $id;
            $favourite->user_id = auth()->user()->id;
            $favourite->save();

            return $this->__apiSuccess(
                'Favourite successfully !',
            );
        }
    }

    public function dishes(Request $request, $id)
    {
        $dishes = MenuFood::active()->where('merchant_id', $id)->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $dishes,
        );
    }

    public function galleries(Request $request, $id)
    {
        $galleries = MerchantGallery::active()->where('merchant_id', $id)->orderBy('sequence')->get();
        return $this->__apiSuccess(
            'Retrieve Successful.',
            $galleries,
        );
    }
}
