<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes, HasGlobalScope;

    const ACTIVE = 1;
    const INACTIVE = 0;
    const ACTIVE_NAME = 'Active';
    const INACTIVE_NAME = 'Inactive';

    const MODULE = "review";
    const IMAGE_ASSET_PATH = 'storage/images/' . self::MODULE . 's';
    const MEDIA_ASSET_PATH = 'storage/media/' . self::MODULE . 's';

    const STATUS_LIST = [
        self::ACTIVE => self::ACTIVE_NAME,
        self::INACTIVE => self::INACTIVE_NAME,
    ];

    protected $fillable = [
        'user_id',
        'itemable_type',
        'itemable_id',
        'message',
        'rating',
        'active'
    ];

    public function itemable()
    {
        return $this->morphTo();
    }


    public function comments()
    {
        return $this->morphMany(Comment::class, 'itemable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'itemable')->latest();
    }

    public function getStatusNameAttribute()
    {
        return self::STATUS_LIST[$this->active] ?? '';
    }
}
