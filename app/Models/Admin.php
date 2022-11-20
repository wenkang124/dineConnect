<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    use  HasFactory, SoftDeletes;
}
