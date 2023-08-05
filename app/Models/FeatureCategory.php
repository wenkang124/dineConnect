<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureCategory extends Model
{
    use HasFactory, HasGlobalScope;

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'feature_category_merchants', 'feature_category_id', 'merchant_id');
    }
}
