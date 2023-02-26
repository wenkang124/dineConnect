<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuFoodFlavour extends Model
{
    use HasFactory, HasGlobalScope;
     
    const ACTIVE = 1;
    const INACTIVE = 0;
    const ACTIVE_NAME = 'Active';
    const INACTIVE_NAME ='Inactive';
    
    const STATUS_LIST = [
        self::ACTIVE => self::ACTIVE_NAME,
        self::INACTIVE => self::INACTIVE_NAME,
    ];

    protected $fillable = [
        'flavour_title',
        'flavour_percentage',
    ];
    
}
