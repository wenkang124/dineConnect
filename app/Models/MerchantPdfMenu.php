<?php

namespace App\Models;

use App\Traits\HasGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantPdfMenu extends Model
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

    const FILE_PREFIX = "merchant_pdf_menu";
    const MODULE = "merchant_pdf_menu";
    const UPLOAD_PATH = 'storage/pdfs/' . self::MODULE . 's';

    protected $fillable = [
        'name',
        'pdf',
        'sequence',
        'active',
    ];

    protected $appends = [
        'pdf_full_path',
    ];

    /** Get Attribute */
    public function getStatusNameAttribute()
    {
        return self::STATUS_LIST[$this->active] ?? '';
    }

    public function getCreatedAtYmdHiaAttribute()
    {
        return date('Y-m-d H:i A', strtotime($this->created_at));
    }

    public function getPdfPathAttribute()
    {
        return $this->pdf != "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg" ? "/" . $this->pdf : $this->pdf;
    }

    public function getPdfFullPathAttribute()
    {
        return asset($this->pdf != "https://www.shutterstock.com/image-vector/sample-red-square-grunge-stamp-260nw-338250266.jpg" ? "/" . $this->pdf : $this->pdf);
    }
}
