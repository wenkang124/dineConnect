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

    function __apiFailed($message, $data = null, int $code = 200, array $debug = null)
    {
        return new JsonResponse($this->__api($debug, false, $message, $code, $data));
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

    function __sendFirebaseCloudMessagingToken($tokens, $type, $title, $text, $type_id = null, $flag = false, $picture = 1, $unique_id = null, $html = null, bool $silence = false, $sound = null)
    {

        if (!$flag) {
            $flag = false;
        }

        if (is_array($tokens)) {
            $tokens = array_values(array_filter(array_unique($tokens)));
            Log::info('Sending FCM Token: ' . implode(', ', $tokens));
        } else {
            Log::info('Sending FCM Token: ' . $tokens);
        }

        if (!config('others.fcm.enabled')) {
            return false;
        }

        /**
         * registration_ids: multiple token array
         * to: single token
         */
        $tokenName = is_array($tokens) ? 'registration_ids' : 'to';

        /**
         * For in apps handling
         */
        $extraNotificationData = [
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "type" => $type,
            "type_id" => $type_id,
            'flag' => $flag,
            'picture' => $picture,
            'unique_id' => $unique_id,
            'html' => $html,
            "silence" => (int)$silence
        ];

        $notification = [
            'title' => $title,
            "message" => $text
        ];

        $data = [
            "$tokenName" => $tokens,
            'data' => $extraNotificationData,
            'notification' => $notification,
            'priority' => 'high',
            'badge' => 1,
            // 'content_available' => $silence // set 'true' if need silent IOS notification
        ];

        if (!$silence) { // For Android silent notification
            $data = array_merge($data, [
                'notification' => [
                    'title' => $title,
                    // 'text' => $text,
                    'body' => $text, // body used for iOS
                    'android_channel_id' => 'push_noti_roger_squad',
                    'sound' => $sound != null ? $sound : true,
                    'icon' => asset('favicon.png')
                ]
            ]);
        }

        $url = config('others.fcm.url');

        $headers = [
            'Authorization: key=' . config('others.fcm.secret'),
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        curl_close($ch);

        Log::info("FCM Token Sent.(" . (is_array($tokens) ? implode(', ', $tokens) : $tokens) . ")" . json_encode($result) . json_encode($data));

        return true;
    }
}
