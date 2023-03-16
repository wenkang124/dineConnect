<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MediaFile extends Model
{
    use HasFactory, SoftDeletes;

    const ENTITLABLE_TYPES = [
        "vehicle" => Vehicle::class,
    ];

    protected $fillable = [
        'priority',
        'fileable_type',
        'fileable_id',
        'disk',
        'filename',
        'path',
        'extension',
        'mime',
        'size',
        'zone',
    ];

    public function sequence()
    {
        return [
            'fieldName' => 'priority',
            'orderFrom1' => true,
            'group' => ['fileable_type', 'fileable_id', 'zone']
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    //Relations
    public function fileable()
    {
        return $this->morphTo('fileable');
    }

    //Attributes
    public function getIsImageFileAttribute()
    {
        $imageExts = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief', 'jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];
        return in_array($this->extension, $imageExts);
    }

    public function getOgPathAttribute()
    {
        // dd($this->path,);
        $filesystemDisk = env('FILESYSTEM_DISK');
        
        switch ($filesystemDisk) {
            case 's3':
                // No longer using publicly accessible S3 links, instead using temporary URLs
                // with credentials from AWS keys
                // $imageUrl = env('AWS_URL') . "/" . urlencode($imageRelPath);
                $assetPath = Storage::disk('s3')->temporaryUrl( str_replace('{type}', 'og',$this->path), now()->addMinutes(5));
                break;
            case 'public':
                $assetPath = Storage::url("$this->path");
                break;
            default:
                $assetPath = Storage::url("$this->path");
        }

        return $this->is_image_file ? str_replace('{type}', 'og', $assetPath) : $assetPath;
    }

    public function getFsPathAttribute()
    {
        $filesystemDisk = env('FILESYSTEM_DISK');
        
        switch ($filesystemDisk) {
            case 's3':
                // No longer using publicly accessible S3 links, instead using temporary URLs
                // with credentials from AWS keys
                // $imageUrl = env('AWS_URL') . "/" . urlencode($imageRelPath);
                $assetPath = Storage::disk('s3')->temporaryUrl( str_replace('{type}', 'fs',$this->path), now()->addMinutes(5));
                break;
            case 'public':
                $assetPath = Storage::url("$this->path");
                break;
            default:
                $assetPath = Storage::url("$this->path");
        }

        return $this->is_image_file ? str_replace('{type}', 'fs', $assetPath) : $assetPath;
    }

    public function getTnPathAttribute()
    {
        $filesystemDisk = env('FILESYSTEM_DISK');
        
        switch ($filesystemDisk) {
            case 's3':
                // No longer using publicly accessible S3 links, instead using temporary URLs
                // with credentials from AWS keys
                // $imageUrl = env('AWS_URL') . "/" . urlencode($imageRelPath);
                $assetPath = Storage::disk('s3')->temporaryUrl( str_replace('{type}', 'fs',$this->path), now()->addMinutes(5));
                break;
            case 'public':
                $assetPath = Storage::url("$this->path");
                break;
            default:
                $assetPath = Storage::url("$this->path");
        }

        return $this->is_image_file ? str_replace('{type}', 'tn', $assetPath) : $assetPath;
    }

    public function getRawOgPathAttribute()
    {
        return $this->is_image_file ? str_replace('{type}', 'og', $this->path) : $this->path;
    }

    public function getRawFsPathAttribute()
    {
        return $this->is_image_file ? str_replace('{type}', 'fs', $this->path) : $this->path;
    }

    public function getRawTnPathAttribute()
    {
        return $this->is_image_file ? str_replace('{type}', 'fs', $this->path) : $this->path;
    }

    public function remove()
    {
        $this->delete();
        Storage::delete($this->raw_og_path);
        Storage::delete($this->raw_fs_path);
        Storage::delete($this->raw_tn_path);

    }
}
