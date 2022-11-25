<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavourite extends Model
{
    use HasFactory;
    const MORPHABLE = "favouritable";

    protected $fillable = [
        'favouritable_type',
        'favouritable_id',
    ];

    public function favouritable()
    {
        return $this->morphTo();
    }
}
