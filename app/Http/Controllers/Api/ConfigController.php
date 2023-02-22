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
        $filterOptions = FilterOption::all();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $filterOptions
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
