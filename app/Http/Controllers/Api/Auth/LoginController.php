<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Models\User;
use App\Traits\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers, Helpers;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "mobile_prefix_id" => 'required',
            "phone" => 'required|string',
            'passcode' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        $user = User::where('mobile_prefix_id', $request->mobile_prefix_id)->where('phone', $request->phone)->first();

        if ($user) {
            if ($user->active == User::INACTIVE) {
                return $this->__apiFailed('Error', ['message' => 'Your account has not been inactive by Admin. Please try again later.']);
            }
        } else {
            return $this->sendFailedLoginResponse($request);
        }


        Auth::setDefaultDriver('web');

        if (Auth::attempt(['phone' => $request->get('phone'), 'password' => $request->get('passcode')])) {
            return $this->sendLoginResponse($request);
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }


    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $user = Auth::user();

        $tokenResult = $user->createToken('Mobile Access Token', ['access:api']);

        // Sanctum
        $accessToken = $tokenResult->plainTextToken;
        
        $user->fcm_token = $request->get('fcm_token');
        $user->save();

        $this->clearLoginAttempts($request);

        return $this->__apiSuccess('Login Successful.', [
            "token" => $accessToken,
        ]);
    }


    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        // $provider_name = ucwords($request->get('third_party_type'));
        // $provider_id = $request->get('third_party_id');
        $error_msg = "Login Failed.";

        // Third Party Login
        // if ($request->filled('third_party_type') && $request->filled('third_party_type')) {
        //     $account = SocialIdentity::whereProviderName($provider_name)
        //         ->whereProviderId($provider_id)
        //         ->first();

        //     if ($request->get('device_type') == "web") {
        //         if (empty($account)) {
        //             return $this->__apiFailed("Invalid login");
        //         }
        //         if (Carbon::now()->isAfter($account->token_expired_at)) {
        //             return $this->__apiFailed(Str::__label('Login_Is_Expired', [$provider_name], 'call-center'));
        //         }
        //     }

        //     $error_msg = Str::__label('Social_First_Time_Logged_In', [$provider_name], 'call-center');
        //     return $this->__apiFailed($error_msg, $account, 100001);
        // }

        return $this->__apiFailed('Login Failed.');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    public function username()
    {
        return 'phone';
    }
}
