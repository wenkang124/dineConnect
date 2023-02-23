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

    public function search(Request $request)
    {
        $mechants = Merchant::where('name', 'LIKE', '%' . $request->keyword . '%')->Active()->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $mechants,
        );
    }

    public function filter(Request $request)
    {

        $mechants = Merchant::when($request->get('distance') > 0 && $request->get('lat') && $request->get('lng'), function ($query) use ($request) {
            $query->select(DB::raw("*, ( 3959 * acos( cos( radians(" . $request->get('lat') . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $request->lng . ") ) + sin( radians(" . $request->lat . ") ) * sin( radians( lat ) ) ) ) AS distance"))->havingRaw('distance < ' . $request->distance)->orderBy('distance');
        })->when($request->get('price_range')[1] > 0, function ($query) use ($request) {
            $query->whereHas('menuFoods', function ($query2) use ($request) {
                $query2->select('*', DB::raw('MAX(price) as max_price'))
                    ->havingRaw('max_price BETWEEN ' . $request->get('price_range')[0] . ' AND ' . $request->get('price_range')[1]);
            });
        })->when($request->get('mood_id'), function ($query) use ($request) {
            $query->whereHas('moods', function ($query2) use ($request) {
                $query2->where('mood_id', $request->mood_id);
            });
        })->when($request->get('category_id'), function ($query) use ($request) {
            $query->whereHas('categories', function ($query2) use ($request) {
                $query2->where('category_id', $request->category_id);
            });
        })->Active()->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $mechants,
        );
    }

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

        if ($request->get('id') != "all") {
            UserSearch::where('user_id', auth()->user()->id)->delete();
        }

        UserSearch::whereIn('id', json_decode($request->get('id')))->where('user_id', auth()->user()->id)->delete();

        return $this->__apiSuccess('Delete Successful.');
    }
}
