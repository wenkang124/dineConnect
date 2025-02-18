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
        // $topReviews = Merchant::with('reviews.views')->get()->map(function ($merchant) {
        //     $merchant->total_rating = $merchant->reviews->avg('rating');
        //     $merchant->total_views = $merchant->reviews->sum('read_count');
        //     return $merchant;
        // })->sortByDesc('total_rating')->take(5)->values();


        $topMerchants = Merchant::select('merchants.*')
            ->selectRaw('COUNT(views.id) as total_views')
            ->join('views', function ($join) {
                $join->on('merchants.id', '=', 'views.itemable_id')
                    ->where('views.itemable_type', Merchant::class);
            })
            ->groupBy('merchants.id')
            ->orderByDesc('total_views')
            ->withCount('reviews as total_reviews')
            ->withAvg('reviews as avg_rating', 'rating')
            ->take(5)
            ->get();


        return $this->__apiSuccess('Retrieve Successful.', [
            "banners" => $banners,
            "categories" => $categories,
            "moods" => $moods,
            "featured_categories" => $featuredCategories,
            "top_reviews" => $topMerchants,
        ]);
    }
}
