<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\User\ForgotPassword;
use App\Http\Controllers\Api\Controller;
use App\Models\UserOtp;
use App\Traits\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use Helpers;

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ], [
            'email.exists' => 'The email is invalid'
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        $user = User::where('email', $request->get('email'))->firstOrFail();

        UserOtp::create([
            'otp' => $this->__generateRandomIntCode(4),
            'type' => UserOtp::type['ForgotPassword'],
            'user_id' => $user->id,
        ]);

        $user->notify(new ForgotPassword);



        return $this->__apiSuccess('OTP code has been sent to your email.', [
            'email' => $user->email
        ]);
    }

    public function resetPassword(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'otp' => 'required',
            'passcode' => 'required',
        ], [
            'email.exists' => 'The email is invalid'
        ]);


        $user = User::where('email', $request->get('email'))->firstOrFail();
        $latest_otp = $user->getLatestOtp();

        if ($request->otp === $latest_otp->otp) {

            if (Carbon::parse($latest_otp->created_at)->diffInMinutes(Carbon::now()) > 60) {
                return $this->__apiFailed('Otp expired !');
            }

            $user->password = Hash::make($request->passcode);
            $user->save();

            UserOtp::find($latest_otp->id)->update(['otp_at' => Carbon::now()]);

            return $this->__apiSuccess('Reset successfully !');
        } else {
            return $this->__apiFailed('Otp wrong !');
        }
    }
}
