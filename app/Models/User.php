<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PDO;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable, HasGlobalScope;
    const ACTIVE = 1;
    const INACTIVE = 0;
    const ACTIVE_NAME = 'Active';
    const INACTIVE_NAME = 'Inactive';

    const MODULE = "user";
    const IMAGE_ASSET_PATH = 'storage/images/' . self::MODULE . 's';
    const MEDIA_ASSET_PATH = 'storage/media/' . self::MODULE . 's';
    const PROFILE_PICTURE = "profile_picture";

    const PATH_TO_STORAGE = "storage/files/users/";

    const STATUS_LIST = [
        self::ACTIVE => self::ACTIVE_NAME,
        self::INACTIVE => self::INACTIVE_NAME,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile_prefix_id',
        'phone',
        'email',
        'password',
        'occupation',
        'profile_image',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $appends = [
        'status_name', 'image'
    ];


    /** Relation */
    public function otp()
    {
        return $this->hasMany(UserOtp::class);
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->latest();
    }

    public function preferences()
    {
        return $this->belongsToMany(Category::class, 'user_preferences', 'user_id','preference_id');
    }

    public function prefixNumber()
    {
        return $this->belongsTo(Country::class, 'mobile_prefix_id', 'id');
    }

    public function searchHistories()
    {
        return $this->hasMany(UserSearch::class);
    }

    public function favourites()
    {
        return $this->hasMany(UserFavourite::class);
    }

    /** Get Attribute */
    public function getStatusNameAttribute()
    {
        return self::STATUS_LIST[$this->active] ?? '';
    }
    public function getCreatedAtYmdHiaAttribute()
    {
        return date('Y-m-d H:i A', strtotime($this->created_at));
    }
    public function getImageAttribute()
    {
        return $this->profile_image ? asset($this->profile_image) : $this->profile_image;
    }


    /** Custom Function */

    public function getLatestOtp($type = UserOtp::type['ForgotPassword'])
    {
        return $this->otp()->where('type', $type)->whereNull('otp_at')->latest()->first();
    }
}
