<?php

namespace App\Traits;

// Models

use App\Events\BroadcastNotification;
use App\Models\Booking;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Product;

// API Resource
use App\Models\Voucher;
use App\Models\Platform;
// Laravel
use Monolog\Logger as Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log as DefaultLog;
use Illuminate\Support\Facades\DB;

// Package
// use Local\CMS\Http\Resources\Response as JsonResponse;
// use Exception;
// use Illuminate\Support\Facades\Redis;
// use Local\CMS\Models\File;
// use Symfony\Component\HttpFoundation\Response as HttpResponse;
// use Nexmo\Client as NexmoClient;
// use Nexmo\Client\Credentials\Basic as NexmoBasic;

trait Helpers
{

    function __apiSuccess($message, $data = null, int $code = 200, array $debug = null)
    {
        return new JsonResponse($this->__api($debug, true, $message, $code, $data));
    }

    function __apiFailed($message, $data = null, int $code = 500, array $debug = null)
    {
        return response()->json(new JsonResponse($this->__api($debug, false, $message, $code, $data)), $code);
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
}
