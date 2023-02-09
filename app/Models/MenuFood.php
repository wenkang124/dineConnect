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
    const INACTIVE_NAME ='Inactive';
    
    const STATUS_LIST = [
        self::ACTIVE => self::ACTIVE_NAME,
        self::INACTIVE => self::INACTIVE_NAME,
    ];

    protected $fillable = [
        'name',
        'image',
        'active',
    ];
    
    public function getStatusNameAttribute()
    {
        return self::STATUS_LIST[$this->active] ?? '';
    }
}
