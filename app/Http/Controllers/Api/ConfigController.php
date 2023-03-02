<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\FilterOption;
use App\Models\Mood;
use App\Traits\Helpers;

class ConfigController extends Controller
{
    use Helpers;

    public function countries()
    {
        $countries = Country::orderBy('sequence')->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $countries
        );
    }

    public function filterOptions()
    {
        $filterPriceOptions = FilterOption::where('label', 'Price')->first();
        $filterDistanceOptions = FilterOption::where('label', 'Distance')->first();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            [
                'min_price' => $filterPriceOptions->min,
                'max_price' => $filterPriceOptions->max,
                'min_distance' => $filterDistanceOptions->min,
                'max_distance' => $filterDistanceOptions->max,
            ]
        );
    }

    public function moods()
    {
        $moods = Mood::Active()->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $moods
        );
    }

    public function categories()
    {
        $categpries = Category::Active()->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $categpries
        );
    }
}
