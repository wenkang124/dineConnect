<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable, HasGlobalScope;
    const ACTIVE = 1;
    const INACTIVE = 0;
    const PATH_TO_STORAGE = "storage/files/users/";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'occupation',
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

    /** Relation */
    public function otp()
    {
        return $this->hasMany(UserOtp::class);
    }

    public function preferences()
    {
        return $this->belongsToMany(Preference::class, 'user_preferences');
    }


    /** Custom Function */

    public function getLatestOtp($type = UserOtp::type['ForgotPassword'])
    {
        return $this->otp()->where('type', $type)->whereNull('otp_at')->latest()->first();
    }
}
