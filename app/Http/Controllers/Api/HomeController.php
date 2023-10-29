<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\FeatureCategory;
use App\Models\Merchant;
use App\Models\Mood;
use App\Traits\Helpers;

class HomeController extends Controller
{
    use Helpers;

    public function getAllHomeData()
    {
        $banners = Banner::Active()->get();
        $categories = Category::Active()->get();
        $moods = Mood::Active()->get();
        $featuredCategories = FeatureCategory::with('merchants')->Active()->get();
        $topReviews = Merchant::with('reviews')->get()->map(function ($merchant) {
            $merchant->total_rating = $merchant->reviews->avg('rating');
            return $merchant;
        })->sortByDesc('total_rating')->take(5);


        return $this->__apiSuccess('Retrieve Successful.', [
            "banners" => $banners,
            "categories" => $categories,
            "moods" => $moods,
            "featured_categories" => $featuredCategories,
            "top_reviews" => $topReviews,
        ]);
    }
}
