<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Merchant;
use App\Models\Category;
use App\Models\UserSearch;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    use Helpers;

    public function histories()
    {
        $histories = UserSearch::latest()->take(10)->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $histories,
        );
    }

    public function suggestionByLatLng(Request $request)
    {
        $merchant_categories = Category::active()->get();
        $merchants = Merchant::select(DB::raw("*, ( 3959 * acos( cos( radians(" . $request->get('lat') . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $request->get('lng') . ") ) + sin( radians(" . $request->get('lat') . ") ) * sin( radians( lat ) ) ) ) AS distance"))->havingRaw('distance < 50')->orderBy('distance')
            ->get();

        return $this->__apiSuccess('Retrieve Successful.', [
            "merchant_categories" => $merchant_categories,
            "merchants" => $merchants,
        ]);
    }

    public function historiesDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        UserSearch::whereIn('id', json_decode($request->get('id')))->delete();

        return $this->__apiSuccess('Delete Successful.');
    }
}
