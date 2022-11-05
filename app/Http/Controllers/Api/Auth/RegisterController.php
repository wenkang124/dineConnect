<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
// use Local\CMS\Traits\Helpers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_code' => ['required'],
            'nationality' => ['required'],
            'phone' => ['required'],
            'dob' => ['required','date_format:m/d/Y'],
            'gender' => ['required'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required_with:password', 'min:8', 'same:password'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);
        $tokenResult = $user->createToken('Mobile Access Token');
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
            'phone_code' => $data['phone_code'],
            'phone' => $data['phone'],
            'nationality' => $data['nationality'],
            'dob' => Carbon::parse($data['dob']),
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function checkExistEmail(Request $request)
    {

        $this->validate($request,[
            'email' => 'required | email'
        ]);

        $user = User::where('email',$request->get('email'))->first();
        if($user){
            return $this->__apiFailed('Email existed');
        }


        return $this->__apiSuccess('Email valid. Kindly proceed');
    }
}
