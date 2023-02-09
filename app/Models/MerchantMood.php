<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantMood extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'merchant_id',
        'mood_id',
    ];
}
