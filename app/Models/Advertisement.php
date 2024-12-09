<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
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

    const FILE_PREFIX = "advertisement";
    const MODULE = "advertisement";
    const UPLOAD_PATH = 'storage/images/' . self::MODULE . 's';

    protected $appends = [
        'image_full_path',
    ];

    /** Relationship */
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_advertisements');
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

    public function getImagePathAttribute()
    {
        return $this->image ? "/" . $this->image : "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg";
    }

    public function getImageFullPathAttribute()
    {
        return asset($this->image ? "/" . $this->image :  "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg");
    }
}
