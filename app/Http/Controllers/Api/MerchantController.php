<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\MerchantMoodResource;
use App\Http\Resources\UserResource;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\MenuFood;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\MerchantOperationDaySetting;
use App\Models\Mood;
use App\Models\UserFavourite;
use App\Traits\Helpers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

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
        $merchant = Merchant::with(['operationDaySettings', 'moods', 'categories', 'subCategories', 'merchantPdfMenus'])->where('id', $id)->firstOrFail();
        $operation = Carbon::now()->dayOfWeek;
        $opeation_setting = MerchantOperationDaySetting::where('merchant_id', $id)->where('day', $operation)->latest()->first();
        if (empty($opeation_setting)) {
            $merchant->operation = 'Closed';
            $merchant->is_open = 0;
        } else {
            if ($opeation_setting->end_time == '00:00:00') {
                $merchant->operation = 'Open 24 hours';
                $merchant->is_open = 1;
            } else if (Carbon::now()->format('H:i') < $opeation_setting->start_time) {
                $merchant->operation = 'Open at ' . Carbon::parse($opeation_setting->start_time)->format('h:i');
                $merchant->is_open = 0;
            } else if (Carbon::now()->format('H:i') > $opeation_setting->end_time) {
                $merchant->operation = 'Closed';
                $merchant->is_open = 0;
            } else {
                $merchant->operation = 'Open till ' . Carbon::parse($opeation_setting->end_time)->format('h:i');
                $merchant->is_open = 1;
            }
        }

        $merchant->share_url = route('api.merchant.detail', $id);

        $merchant->views()->create();
        $merchant->total_views = $merchant->views()->count();

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

    public function ads(Request $request, $id)
    {
        $ads = Merchant::find($id)->advertisements()->active()->orderBy('sequence')->get();
        return $this->__apiSuccess(
            'Retrieve Successful.',
            $ads,
        );
    }

    public function reviews(Request $request, $id)
    {
        $reviews = Merchant::find($id)->reviews()->when($request->get('limit'), function ($query) use ($request) {
            $query->limit($request->get('limit'));
        })->get();
        return $this->__apiSuccess(
            'Retrieve Successful.',
            $reviews,
        );
    }
}
