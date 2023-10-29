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


    public function states()
    {
        //list of malaysia states
        $states = [
            [
                'name' => 'Johor',
                'label' => 'Johor',
            ],
            [
                'name' => 'Kedah',
                'label' => 'Kedah',
            ],
            [
                'name' => 'Kelantan',
                'label' => 'Kelantan',
            ],
            [
                'name' => 'Kuala Lumpur',
                'label' => 'Kuala Lumpur',
            ],
            [
                'name' => 'Labuan',
                'label' => 'Labuan',
            ],
            [
                'name' => 'Melaka',
                'label' => 'Melaka',
            ],
            [
                'name' => 'Negeri Sembilan',
                'label' => 'Negeri Sembilan',
            ],
            [
                'name' => 'Pahang',
                'label' => 'Pahang',
            ],
            [
                'name' => 'Perak',
                'label' => 'Perak',
            ],
            [
                'name' => 'Perlis',
                'label' => 'Perlis',
            ],
            [
                'name' => 'Pulau Pinang',
                'label' => 'Pulau Pinang',
            ],
            [
                'name' => 'Putrajaya',
                'label' => 'Putrajaya',
            ],
            [
                'name' => 'Sabah',
                'label' => 'Sabah',
            ],
            [
                'name' => 'Sarawak',
                'label' => 'Sarawak',
            ],
            [
                'name' => 'Selangor',
                'label' => 'Selangor',
            ],
            [
                'name' => 'Terengganu',
                'label' => 'Terengganu',
            ],

        ];

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $states
        );
    }

    public function occupations()
    {
        $occupations = [
            [
                'name' => 'Student',
                'label' => 'Student',
            ],
            [
                'name' => 'Employed',
                'label' => 'Employed',
            ],
            [
                'name' => 'Self Employed',
                'label' => 'Self Employed',
            ],
            [
                'name' => 'Unemployed',
                'label' => 'Unemployed',
            ],
            [
                'name' => 'Retired',
                'label' => 'Retired',
            ]

        ];

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $occupations
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

    public function annoucmentPopUp()
    {
        return $this->__apiSuccess(
            'Retrieve Successful.',
            true
        );
    }
}
