<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Annoucement;
use App\Traits\Helpers;
use Illuminate\Http\Request;

class AnnoucementController extends Controller
{
    use Helpers;

    public function getAllList(Request $request)
    {

        $annoucements = Annoucement::Active()->orderBy('created_at')->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $annoucements,
        );
    }


    public function detail(Request $request, $id)
    {

        $annoucement = Annoucement::where('id', $id)->firstOrFail();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $annoucement,
        );
    }
}
