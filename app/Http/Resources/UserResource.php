<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => asset($this->profile_image),
            'name' => $this->name,
            'email' => $this->email,
            'occupation' => $this->occupation,
            'active' => $this->active,
            'mobile_prefix_label' => $this->prefixNumber->phonecode,
            'phone' => $this->prefixNumber->phonecode . $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'email_verified_at' => $this->email_verified_at,
            'preferences' => $this->preferences,
        ];
    }
}
