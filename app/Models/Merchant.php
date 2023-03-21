<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use HasFactory, SoftDeletes, HasGlobalScope;

    const ACTIVE = 1;
    const INACTIVE = 0;
    const ACTIVE_NAME = 'Active';
    const INACTIVE_NAME = 'Inactive';

    const STATUS_LIST = [
        self::ACTIVE => self::ACTIVE_NAME,
        self::INACTIVE => self::INACTIVE_NAME,
    ];

    const FILE_PREFIX = "merchant";
    const MODULE = "merchant";
    const UPLOAD_PATH = 'storage/images/' . self::MODULE . 's';

    protected $appends = [
        'is_favourite', 'rating'
    ];

    public function moods()
    {
        return $this->belongsToMany(Mood::class, 'merchant_moods')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'merchant_categories')->withTimestamps();
    }

    public function advertisements()
    {
        return $this->belongsToMany(Advertisement::class, 'merchant_advertisements')->withTimestamps();
    }

    public function menuCategories()
    {
        return $this->belongsToMany(MenuCategory::class, 'merchant_menu_categories')->withTimestamps();
    }

    public function merchantMenuCategories()
    {
        return $this->hasMany(MerchantMenuCategory::class);
    }

    public function menuFoods()
    {
        return $this->hasMany(MenuFood::class);
    }

    public function merchantGallery()
    {
        return $this->hasMany(MerchantGallery::class);
    }

    public function operationDaySettings()
    {
        return $this->hasMany(MerchantOperationDaySetting::class);
    }

    public function favourites()
    {
        return $this->morphMany(UserFavourite::class, 'favouritable');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'itemable')->with(['comments.likes', 'images', 'likes', 'user','comments.user']);
    }

    public function getStatusNameAttribute()
    {
        return self::STATUS_LIST[$this->active] ?? '';
    }

    public function getCreatedAtYmdHiaAttribute()
    {
        return date('Y-m-d H:i A', strtotime($this->created_at));
    }

    public function getImagePathAttribute()
    {
        return $this->thumbnail != "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg" ? "/" . $this->thumbnail : $this->thumbnail;
    }

    public function getIsFavouriteAttribute()
    {
        if ($this->favourites()->where('user_id', auth()->user()->id)->first()) {
            return true;
        } else {
            return false;
        }
        // $favourites = UserFavourite::where('user_id', auth()->user()->id)->()->get();

    }

    public function getRatingAttribute()
    {
        $total_rating = $this->reviews()->count();
        $sumRatings = $this->reviews()->sum('rating');

        if ($total_rating > 0) {
            $average  = $sumRatings / ($total_rating * 5) * 5;
        } else {
            $average = 0;
        }
        return round($average, 2);
    }
}
