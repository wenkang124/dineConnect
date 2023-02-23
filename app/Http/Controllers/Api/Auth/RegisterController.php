<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserOtp;
use App\Notifications\User\RegisterRequestOtp;
use App\Traits\Helpers;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers, Helpers;

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'mobile_prefix_id' => ['required'],
            'phone' => ['required', 'unique:users'],
            'passcode' => ['required', 'max:4'],
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }


        event(new Registered($user = $this->create($request->all())));

        UserOtp::create([
            'otp' => $this->__generateRandomIntCode(4),
            'type' => UserOtp::type['Register'],
            'user_id' => $user->id,
        ]);

        $user->notify(new RegisterRequestOtp);

        // $this->guard()->login($user);
        // $tokenResult = $user->createToken('Mobile Access Token', ['access:api']);
        // $accessToken = $tokenResult->plainTextToken;

        return $this->__apiSuccess('Registered Successful. Please verify you account.');
        // if ($response = $this->registered($request, $user)) {
        //     return $response;
        // }
    }

    public function registerResendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }


        $user = User::where('email', $request->get('email'))->firstOrFail();

        if ($user->email_verified_at) {
            return $this->__apiFailed('User already verifed.');
        }

        UserOtp::create([
            'otp' => $this->__generateRandomIntCode(4),
            'type' => UserOtp::type['Register'],
            'user_id' => $user->id,
        ]);

        $user->notify(new RegisterRequestOtp);

        return $this->__apiSuccess('Resend OTP Successful. Please verify you account.');
    }

    public function registerVerifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }


        $user = User::where('email', $request->get('email'))->firstOrFail();
        $latest_otp = $user->getLatestOtp(UserOtp::type['Register']);

        if ($request->otp === $latest_otp->otp) {

            if (Carbon::parse($latest_otp->created_at)->diffInMinutes(Carbon::now()) > 60) {
                return $this->__apiFailed('Otp expired !');
            }

            $user->email_verified_at = Carbon::now();
            $user->save();

            UserOtp::find($latest_otp->id)->update(['otp_at' => Carbon::now()]);

            return $this->__apiSuccess('Verified successfully !');
        } else {
            return $this->__apiFailed('Otp wrong !');
        }
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_prefix_id' => $data['mobile_prefix_id'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['passcode']),
            'occupation' => $data['occupation'],
        ]);
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}
