<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
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

    const FILE_PREFIX = "category";
    const MODULE = "category";
    const UPLOAD_PATH = 'storage/images/' . self::MODULE . 's';

    protected $appends = [
        'image_full_path',
    ];


    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_categories');
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
        return $this->image != "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg" ? "/" . $this->image : $this->image;
    }

    public function getImageFullPathAttribute()
    {
        return asset($this->image != "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg" ? "/" . $this->image : $this->image);
    }
}
