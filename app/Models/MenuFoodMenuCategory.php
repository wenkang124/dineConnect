<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuFoodMenuCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_food_id',
        'menu_category_id',
    ];
}
