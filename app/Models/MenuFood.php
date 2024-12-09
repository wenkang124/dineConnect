<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuFood extends Model
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

    const FILE_PREFIX = "menu_food";
    const MODULE = "menu_food";
    const UPLOAD_PATH = 'storage/images/' . self::MODULE . 's';

    protected $fillable = [
        'name',
        'short_description',
        'description',
        'price',
        'thumbnail',
        'active',
    ];

    protected $appends = [
        'image_full_path',
        'is_favourite'
    ];

    // public function menuCategories()
    // {
    //     return $this->belongsToMany(MenuCategory::class, 'menu_food_menu_categories')->withTimestamps();
    // }
    public function menuSubCategories()
    {
        return $this->belongsToMany(MenuSubCategory::class, 'menu_food_menu_sub_categories')->withTimestamps();
    }

    public function flavours()
    {
        return $this->hasMany(MenuFoodFlavour::class);
    }

    public function portions()
    {
        return $this->hasMany(MenuFoodPortion::class);
    }

    public function getCreatedAtYmdHiaAttribute()
    {
        return date('Y-m-d H:i A', strtotime($this->created_at));
    }

    public function getImagePathAttribute()
    {
        return $this->thumbnail ? "/" . $this->thumbnail : "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg";
    }

    public function getImageFullPathAttribute()
    {
        return asset($this->thumbnail ? "/" . $this->thumbnail : "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg");
    }

    public function getStatusNameAttribute()
    {
        return self::STATUS_LIST[$this->active] ?? '';
    }

    public function getIsFavouriteAttribute()
    {
        if (get_class(auth()->user()) === User::class) {
            return auth()->user()->favourites()->where('favouritable_type', MenuFood::class)->where('favouritable_id', $this->id)->get()->count() > 0 ? true : false;
        } else {
            return 0;
        }
    }

    public function views()
    {
        return $this->morphMany(View::class, 'itemable');
    }
}
