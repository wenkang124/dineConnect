<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
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
        'name',
        'image',
        'active',
    ];

    const FILE_PREFIX = "sub_category";
    const MODULE = "sub_category";
    const UPLOAD_PATH = 'storage/images/' . self::MODULE . 's';

    protected $appends = [
        'image_full_path',
    ];


    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_sub_categories');
    }

    public function getCreatedAtYmdHiaAttribute()
    {
        return date('Y-m-d H:i A', strtotime($this->created_at));
    }

    public function getStatusNameAttribute()
    {
        return self::STATUS_LIST[$this->active] ?? '';
    }

    public function getImagePathAttribute()
    {
        return $this->image ? "/" . $this->image : "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg";
    }

    public function getImageFullPathAttribute()
    {
        return asset($this->image ? "/" . $this->image : "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg");
    }
}
