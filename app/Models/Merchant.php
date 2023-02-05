<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use HasFactory, SoftDeletes, HasGlobalScope;

    protected $appends = [
        'is_favourite',
    ];

    public function moods()
    {
        return $this->belongsToMany(Mood::class, 'merchant_moods');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'merchant_categories');
    }

    public function favourites()
    {
        return $this->morphMany(UserFavourite::class, 'favouritable');
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
}
