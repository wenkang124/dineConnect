<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Country;
use App\Traits\Helpers;

class ConfigController extends Controller
{
    use Helpers;

    public function countries()
    {
        $countries = Country::all();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $countries
        );
    }
}
