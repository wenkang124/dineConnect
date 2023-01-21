<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Banner;
use App\Models\MerchantCategory;
use App\Models\Mood;
use App\Traits\Helpers;

class HomeController extends Controller
{
    use Helpers;

    public function getAllHomeData()
    {
        $banners = Banner::Active()->get();
        $categories = MerchantCategory::Active()->get();
        $moods = Mood::Active()->get();

        return $this->__apiSuccess('Retrieve Successful.', [
            "banners" => $banners,
            "categories" => $categories,
            "moods" => $moods,
        ]);
    }
}
