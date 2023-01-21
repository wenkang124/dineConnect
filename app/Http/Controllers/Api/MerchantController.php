<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\Controller;
use App\Models\Merchant;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    use Helpers;

    public function randomList(Request $request)
    {

        $merchant = Merchant::active()->inRandomOrder()->limit($request->get('limit') ?? 5)->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $merchant,
        );
    }

    public function getAllList(Request $request)
    {
        // ->when($request->get('id'),function($query){
        //     if($request->get('type') == "mode"){
        //         $query->where()

        //     }else{

        //     }
        // })
        $list = Merchant::Active()->get();

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $list,
        );
    }

    public function detail(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:merchants',
        ]);

        if ($validator->fails()) {
            return $this->__apiFailed($validator->errors()->first(), $validator->errors());
        }

        $merchant = Merchant::find($id);

        return $this->__apiSuccess(
            'Retrieve Successful.',
            $merchant,
        );
    }
}
