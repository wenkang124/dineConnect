<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Models\MediaFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait MediaTrait
{
    public function upload($file, $entity, $zone = 'default') {
        $ext = strtolower($file->getClientOriginalExtension());
        $filename = time().'_'.Str::random(10);

        $imageExts = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief', 'jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];
        if (in_array(strtolower($file->getClientOriginalExtension()), $imageExts)) {
            $path = $entity::IMAGE_ASSET_PATH."/{type}/$filename.$ext";
            $ogPath = $entity::IMAGE_ASSET_PATH."/og/";
            $fsPath = $entity::IMAGE_ASSET_PATH."/fs/";
            $tnPath = $entity::IMAGE_ASSET_PATH."/tn/";

            if(config('filesystems.default') == 'local') {
                $this->checkFolderExist([$ogPath, $fsPath, $tnPath]);
            }

            $this->makeOriginalSizeImage($file, $ext, $filename, $ogPath);
            $this->makeFullSizeImage($file, $ext, $filename, $fsPath);
            $this->makeThumbnailSizeImage($file, $ext, $filename, $tnPath);
        } else {
            $path = $entity::MEDIA_ASSET_PATH . "/$filename.$ext";
            Storage::putFileAs($entity::MEDIA_ASSET_PATH, $file, "$filename.$ext");
        }

        return MediaFile::create([
            'fileable_type' => is_string($entity) ? $entity : get_class($entity),
            'fileable_id' => $entity->id,
            'disk' => config('filesystems.default'),
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'extension' => $ext,
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'zone' => $zone,
        ]);
    }

    public function checkFolderExist($paths) {
        foreach($paths as $path) {
            $folder = public_path("../public/$path");

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0775, true, true);
            }
        }
    }

    public function makeOriginalSizeImage($file, $ext, $filename, $path) {
        $image = Image::make($file->getRealPath())
            ->orientate()
            ->stream();

        Storage::put($path . "$filename.$ext", $image->__toString());
    }

    public function makeFullSizeImage($file, $ext, $filename, $path) {
        $image = Image::make($file->getRealPath())
        ->orientate();
        $width = $image->width() > 2400 ? 2400 : $image->width();
        $height = $image->height() > 1600 ? 1600 : $image->height();

        $image = $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })
        ->stream();

        Storage::put($path . "$filename.$ext", $image->__toString());
    }

    public function makeThumbnailSizeImage($file, $ext, $filename, $path) {
        $image = Image::make($file->getRealPath())
        ->orientate()
        ->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        })
        // ->fit(110, 150, function ($constraint) {
        //     $constraint->upsize();
        // })
        ->stream();

        Storage::put($path . "$filename.$ext", $image->__toString());
    }

    public function getTempFile($path) {
        $path_info = pathinfo($path);
        $file = new UploadedFile($path, $path_info['basename']);

        return $file;
    }
}
