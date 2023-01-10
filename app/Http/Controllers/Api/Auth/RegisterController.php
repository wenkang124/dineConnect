<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\Helpers;
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_prefix_id' => ['required'],
            'phone' => ['required', 'unique:users'],
            'passcode' => ['required', 'max:4'],
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }


        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);
        $tokenResult = $user->createToken('Mobile Access Token', ['access:api']);
        $accessToken = $tokenResult->plainTextToken;

        return $this->__apiSuccess('Registered Successful.', [
            "token" => $accessToken,
        ]);
        // if ($response = $this->registered($request, $user)) {
        //     return $response;
        // }
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
