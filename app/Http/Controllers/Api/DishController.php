<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\MerchantMoodResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\MenuFood;
use App\Models\Merchant;
use App\Models\Mood;
use App\Models\UserFavourite;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DishController extends Controller
{
    use Helpers;

    public function getAllList(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 10;

        $dishes = MenuFood::active()->limit($limit)->offset(($page - 1) * $limit)->get();


        return $this->__apiSuccess(
            'Retrieve Successful.',
            $dishes,
        );
    }

    public function detail(Request $request,$id)
    {

        $dish = MenuFood::with(['flavours','portions'])->where('id', $id)->firstOrFail();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $dish,
        );
    }
}
