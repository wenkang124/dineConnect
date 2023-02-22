<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserOtp extends Model
{

    use HasFactory, SoftDeletes;


    protected $fillable = [
        'otp',
        'user_id',
        'otp_at',
        'type',
    ];

    const type = [
        'ForgotPassword' => 1,
        'Register' => 2,
    ];
}
