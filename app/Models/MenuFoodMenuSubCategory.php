<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuFoodMenuSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_food_id',
        'menu_sub_category_id',
    ];
}
