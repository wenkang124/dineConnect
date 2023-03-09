<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantOperationDaySetting extends Model
{
    use HasFactory, HasGlobalScope;

    const ACTIVE = 1;
    const INACTIVE = 0;
    const ACTIVE_NAME = 'Active';
    const INACTIVE_NAME = 'Inactive';

    const STATUS_LIST = [
        self::ACTIVE => self::ACTIVE_NAME,
        self::INACTIVE => self::INACTIVE_NAME,
    ];

    const DAY_LABEL = [
        0 => "Sunday",
        1 => "Monday",
        2 => "Tuesday",
        3 => "Wednesday",
        4 => "Thursday",
        5 => "Friday",
        6 => "Saturday",
    ];

    protected $appends = [
        'day_label',
    ];

    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'active',
    ];

    /** Get Attribute */
    public function getDayLabelAttribute()
    {
        return self::DAY_LABEL[$this->day];
    }
}
