<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\FeatureCategory;
use App\Models\Merchant;
use App\Models\Mood;
use App\Models\Review;
use App\Traits\Helpers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Helpers;

    public function getAllHomeData(Request $request)
    {
        $banners = Banner::Active()->get();
        $categories = Category::Active()->get();
        $moods = Mood::Active()->get();
        $featuredCategories = FeatureCategory::with('merchants')->Active()->paginate($request->get('per_page', 10));
        $topReviews = Merchant::with(['reviews' => function ($query) {
            $query->select('merchant_id', 'rating', 'read_count');
        }])
            ->withCount(['reviews as total_reviews'])
            ->withAvg('reviews as avg_rating', 'rating')
            ->withSum('reviews as total_views', 'read_count')
            ->orderByDesc('avg_rating')
            ->take(5)
            ->get();

        return $this->__apiSuccess('Retrieve Successful.', [
            "banners" => $banners,
            "categories" => $categories,
            "moods" => $moods,
            "featured_categories" => $featuredCategories,
            "top_reviews" => $topReviews,
        ]);
    }
}
