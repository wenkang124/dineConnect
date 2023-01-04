<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait Helpers
{

    function __apiSuccess($message, $data = null, int $code = 200, array $debug = null)
    {
        return new JsonResponse($this->__api($debug, true, $message, $code, $data));
    }

    function __apiFailed($message, $data = null, int $code = 500, array $debug = null)
    {
        return new JsonResponse($this->__api($debug, true, $message, $code, $data));
    }

    private function __api(array $debug = null, bool $status, $message, int $code = 0, $data = null): array
    {
        $response = [
            "status" => $status,
            "message" => $message,
            "code" => $code,
            "data" => $data
        ];

        if ($this->__isDebug()) {
            $response['debug'] = $debug;
        }

        return $response;
    }

    private function __isDebug()
    {
        return config('app.debug') && !$this->__isProduction();
    }

    private function __isProduction()
    {
        return config('app.env') == "production";
    }


    public function __generateRandomIntCode($digits)
    {
        return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }

    private function __directoryExist($directory, $target)
    {
        $all = Storage::allDirectories($directory);
        return in_array($target, $all);
    }

    function __storeImage($file, $path, $type = "file", $fullReso = false)
    {
        try {
            $file_name = mb_strtolower($type) . "_" . date("Ymdhis") . rand(11, 99);
            $ofile = Image::make($file);
            $ofile->orientate();
            $extension = str_replace("image/", '', $ofile->mime());
            $directory = str_replace('storage', 'public', $path);
            if (!$this->__directoryExist(storage_path(), $directory)) {
                Storage::makeDirectory($directory);
            }

            $ofile->save(public_path($path . $file_name . '.' . $extension), 100);

            if ($fullReso) {
                $this->__moveFile($file, $type, $file_name);
                $file->storeAs(str_replace('storage', 'public', $path), $file_name . '_high_resolution.' . $extension);
                $hfile = $file_name . '_high_resolution';

                $lfile = Image::make($file);
                $lfile->orientate();
                $lfile->crop($lfile->height(), $lfile->height());
                $lfile->save(public_path($path . $file_name . '_low_resolution.' . $extension), 50);
            }

            return $fullReso ? (object)[
                "original" => $ofile,
                "low_reso" => $lfile,
                "high_reso" => $hfile, // It's not an image class, just a `File Name` string
            ] : $ofile;
        } catch (\Throwable $th) {
            Log::info('Failed to upload: ' . var_export($th->getMessage() ?? '', true));
            return false;
        }
    }

    function __moveFile($file, $type = "file", $file_name = null)
    {
        try {
            $name = $file->getClientOriginalName();

            $file_name = $file_name ?: mb_strtolower(pathinfo($name, PATHINFO_FILENAME)) . "_" . date("Ymdhis") . rand(11, 99);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $file->storeAs("public/$type", $file_name . '.' . $extension);

            return public_path("storage/$type/$file_name.$extension");
        } catch (\Throwable $th) {
            Log::info('Failed to upload: ' . var_export($th->getMessage() ?? '', true));
            return;
        }
    }

    public function uploadImage($file, $request, $path = "storage/files/")
    {
        if ($file) {
            $uploadedFile = $this->__storeImage($file, $path);
            if (empty($uploadedFile)) {
                return [
                    'status' => false,
                ];
            }
            $oFile = $uploadedFile->original ?? $uploadedFile;
            dd($oFile);
            // $newImage =  File::create([
            //     "name" => $oFile->filename,
            //     'permission' => 'private',
            //     "original_name" => $this->__getFileOriginalName($file),
            //     "extension" => $oFile->extension,
            //     "mime" => $oFile->mime(),
            //     "size" => $oFile->filesize(),
            //     "path" => File::PATH_TO_STORAGE,
            //     "ip_address" => $request->ip()
            // ]);
        }
        // return [
        //     'status' => true,
        //     'file' => $newImage,
        // ];
    }
}
