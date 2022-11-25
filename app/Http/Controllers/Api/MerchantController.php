<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Merchant;
use App\Traits\Helpers;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    use Helpers;

    public function randomList(Request $request)
    {

        $merchant = Merchant::active()->inRandomOrder()->limit($request->get('limit') ?? 5)->get();

        return $this->__apiSuccess('Retrieve Successful.', [
            "merchant" => $merchant,
        ]);
    }
}
