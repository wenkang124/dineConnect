<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /** Relation */
    public function notifiable()
    {
        return $this->morphTo();
    }


    /** Get Attribute */
    public function getCreatedAtYmdHiaAttribute()
    {
        return date('Y-m-d H:i A', strtotime($this->created_at));
    }

    public function getCreatedAtAttribute()
    {
        return $this->created_at_ymd_hia;
    }
}
