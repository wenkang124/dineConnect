<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureCategory extends Model
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

    const FILE_PREFIX = "feature_category";
    const MODULE = "feature_category";
    const UPLOAD_PATH = 'storage/images/' . self::MODULE . 's';

    protected $appends = [
    ];

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'feature_category_merchants', 'feature_category_id', 'merchant_id');
    }

    public function getCreatedAtYmdHiaAttribute()
    {
        return date('Y-m-d H:i A', strtotime($this->created_at));
    }


    public function getStatusNameAttribute()
    {
        return self::STATUS_LIST[$this->active] ?? '';
    }
}
