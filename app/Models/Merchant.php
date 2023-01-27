<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use HasFactory, SoftDeletes, HasGlobalScope;

    public function moods()
    {
        return $this->belongsToMany(Mood::class, 'merchant_moods');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'merchant_categories');
    }
}
