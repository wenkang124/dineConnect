<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $appends = [
        'display_date'
    ];

    protected $casts = [
        'data' => 'array',
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'type',
        'data',
    ];

    /** Relation */
    public function notifiable()
    {
        $morth = $this->morphTo();

        try {
            return $morth->withTrashed();
        } catch (\Exception $e) {
            return $morth;
        }
    }


    /** Get Attribute */
    public function getCreatedAtYmdHiaAttribute()
    {
        return date('Y-m-d H:i A', strtotime($this->created_at));
    }

    public function getDisplayDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
