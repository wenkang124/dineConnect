<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavourite extends Model
{
    use HasFactory;
    const MORPHABLE = "favouritable";

    protected $fillable = [
        'user_id',
        'favouritable_type',
        'favouritable_id',
    ];

    public function favouritable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
