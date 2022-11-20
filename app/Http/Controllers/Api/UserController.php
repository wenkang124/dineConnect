<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\User;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use Helpers;


    public function me(Request $request)
    {
        return $this->__apiSuccess('Retrieve Successful.', [
            "user" => $request->user()
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|unique:users,phone,' . auth()->user()->id,
            'name' => 'required',
        ]);

        $user = auth()->user();

        //pending
        // if ($request->file('profile_image')) {
        //     $image = $this->uploadImage($request->file('profile_image'), $request, User::PATH_TO_STORAGE);
        //     if (!$image['status']) {
        //         return $this->__apiFailed('Something went wrong while upload image');
        //     }
        //     $user->files()->detach();
        //     $user->files()->attach([$image['file']['id'] => ['zone' => 'profile-image']]);
        // }


        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->occupation = $request->occupation;
        $user->save();


        return $this->__apiSuccess('Update Successful.', [
            "user" => $request->user()
        ]);
    }

    public function updatePasscode(Request $request)
    {
        $this->validate($request, [
            'old_passcode' => 'required|max:4',
            'new_passcode' => 'required|max:4',
        ]);

        $user = auth()->user();

        if (Hash::check($request->old_passcode, $user->password)) {
            $user->password = Hash::make($request->new_passcode);
            $user->save();

            return $this->__apiSuccess('Update Successful.');
        } else {
            return $this->__apiFailed('Old passcode is wrong !');
        }
    }

    public function delete(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $request->user()->tokens()->where('name', 'Mobile Access Token')->delete();
        $user->delete();
        return $this->__apiSuccess('Delete Successful.');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->where('name', 'Mobile Access Token')->delete();
        // $user->tokens()->where('name','Personal Access Token')->delete();
        return $this->__apiSuccess('Logout Successful.');
    }
}
