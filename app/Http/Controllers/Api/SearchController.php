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

        $search_history = new UserSearch();
        $search_history->user_id = auth()->user()->id;
        $search_history->keyword = $request->keyword;
        $search_history->save();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $mechants,
        );
    }

    public function filter(Request $request)
    {

        $mechants = Merchant::when($request->get('distance') > 0 && $request->get('lat') && $request->get('lng'), function ($query) use ($request) {
            $query->select(DB::raw("*, ( 3959 * acos( cos( radians(" . $request->get('lat') . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $request->lng . ") ) + sin( radians(" . $request->lat . ") ) * sin( radians( lat ) ) ) ) AS distance"))->havingRaw('distance < ' . $request->distance)->orderBy('distance');
        })->when($request->get('min_price_range') > 0, function ($query) use ($request) {
            $query->whereHas('menuFoods', function ($query2) use ($request) {
                $query2->select('*', DB::raw('MAX(price) as max_price'))
                    ->havingRaw('max_price BETWEEN ' . $request->get('max_price_range') . ' AND ' . $request->get('min_price_range'));
            });
        })->when($request->get('mood_id'), function ($query) use ($request) {
            $query->whereHas('moods', function ($query2) use ($request) {
                $query2->where('mood_id', $request->mood_id);
            });
        })->when($request->get('category_id'), function ($query) use ($request) {
            $query->whereHas('categories', function ($query2) use ($request) {
                $query2->where('category_id', $request->category_id);
            });
        })->when($request->get('state'), function ($query) use ($request) {
            $query->where('state', $request->state);
        })->Active()->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $mechants,
        );
    }

    public function histories()
    {
        $histories = auth()->user()->searchHistories()->latest()->take(10)->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $histories,
        );
    }

    public function suggestionByLatLng(Request $request)
    {
        $merchants = Merchant::select(DB::raw("*, ( 3959 * acos( cos( radians(" . $request->get('lat') . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $request->get('lng') . ") ) + sin( radians(" . $request->get('lat') . ") ) * sin( radians( lat ) ) ) ) AS distance"))->orderby('distance', 'desc')->orderBy('distance')
            ->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $merchants
        );
    }

    public function historiesDelete(Request $request, $id)
    {
        if ($id == "all") {
            UserSearch::where('user_id', auth()->user()->id)->delete();
        } else {
            UserSearch::where('id', $id)->where('user_id', auth()->user()->id)->delete();
        }


        return $this->__apiSuccess('Delete Successful.');
    }
}
