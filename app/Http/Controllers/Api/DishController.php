<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\MerchantMoodResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\MenuFood;
use App\Models\MenuSubCategory;
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

    public function detail(Request $request, $id)
    {

        $dish = MenuFood::with(['flavours', 'portions'])->where('id', $id)->firstOrFail();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $dish,
        );
    }

    public function getAllListBySubCategoryId(Request $request, $sub_category_id)
    {

        $dishes = MenuSubCategory::find($sub_category_id)->menu_foods()->active()->get();


        return $this->__apiSuccess(
            'Retrieve Successful.',
            $dishes,
        );
    }

    public function menuCategories(Request $request, $merchant_id)
    {
        $menu_categories = Merchant::find($merchant_id)->merchantMenuCategories;
        return $this->__apiSuccess(
            'Retrieve Successful.',
            $menu_categories,
        );
    }

    public function subCategories(Request $request, $menu_category_id)
    {
        $sub_categories = MenuSubCategory::where('merchant_menu_category_id', $menu_category_id)->Active()->get();
        return $this->__apiSuccess(
            'Retrieve Successful.',
            $sub_categories,
        );
    }
}
