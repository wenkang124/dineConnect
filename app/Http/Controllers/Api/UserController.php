<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\UserResource;
use App\Models\Feedback;
use App\Models\User;
use App\Models\UserFavourite;
use App\Traits\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use Helpers;


    public function me(Request $request)
    {

        return $this->__apiSuccess(
            'Retrieve Successful.',
            new UserResource(auth()->user())
        );
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:users,phone,' . auth()->user()->id . 'id,deleted_at,NULL',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id . 'id,deleted_at,NULL',
            'name' => 'required',
            'mobile_prefix_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

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


        $user->mobile_prefix_id = $request->mobile_prefix_id;
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->occupation = $request->occupation;
        $user->save();


        return $this->__apiSuccess(
            'Update Successful.',
            new UserResource($user)
        );
    }

    public function updatePasscode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_passcode' => 'required|max:4',
            'new_passcode' => 'required|max:4',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

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

    public function favourites(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 10;

        $favourites = UserFavourite::where('user_id', $request->user()->id)->with('favouritable')->limit($limit)->offset(($page - 1) * $limit)->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $favourites
        );
    }

    public function favourite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }


        if ($request->get('status')) {
            auth()->user()->favourites()->create([
                'favouritable_id' => $request->id,
                'favouritable_type' => 'App\Models\\' . $request->get('type')
            ]);
        } else {
            UserFavourite::where('user_id', $request->user()->id)->where('favouritable_id', $request->get('id'))->where('favouritable_type', 'App\Models\\' . $request->get('type'))->delete();
        }

        $favourites = UserFavourite::where('user_id', $request->user()->id)->with('favouritable')->get();
        return $this->__apiSuccess(
            'Submit Successful.',
            $favourites
        );
    }

    public function feedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }


        $feedback = new Feedback();
        $feedback->user_id = $request->user()->id;
        $feedback->message = $request->get('message');
        $feedback->save();

        return $this->__apiSuccess('Submit Successful.');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->where('name', 'Mobile Access Token')->delete();
        // $user->tokens()->where('name','Personal Access Token')->delete();
        return $this->__apiSuccess('Logout Successful.');
    }
}
