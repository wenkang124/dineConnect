<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes, HasGlobalScope;

    const ACTIVE = 1;
    const INACTIVE = 0;
    const ACTIVE_NAME = 'Active';
    const INACTIVE_NAME = 'Inactive';

    const STATUS_LIST = [
        self::ACTIVE => self::ACTIVE_NAME,
        self::INACTIVE => self::INACTIVE_NAME,
    ];

    protected $fillable = [
        'user_id',
        'itemable_type',
        'itemable_id',
        'message',
        'active'
    ];

    protected $appends = [
        'display_date', 'total_likes', 'total_reports'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'itemable');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'itemable')->latest();
    }

    public function getTotalLikesAttribute()
    {
        return $this->likes()->count();
    }
    
    public function getTotalReportsAttribute()
    {
        return $this->reports()->count();
    }

    public function getDisplayDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUserNameAttribute()
    {
        return $this->user? $this->user->name : '';
    }

    public function getStatusNameAttribute()
    {
        return self::STATUS_LIST[$this->active] ?? '';
    }
    
    public function getCreatedAtYmdHiaAttribute()
    {
        return date('Y-m-d H:i A', strtotime($this->created_at));
    }

}
