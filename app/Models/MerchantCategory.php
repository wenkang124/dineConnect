<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'category_id',
    ];
}
