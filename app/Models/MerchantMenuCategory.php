<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantMenuCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'menu_category_id',
    ];

    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    public function menuSubCategories()
    {
        return $this->hasMany(MenuSubCategory::class);
    }
}
