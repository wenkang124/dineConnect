<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MerchantMenuCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $menu_category = $this->menuCategory;
        return [
            'id' => $menu_category->id,
            'name' => $menu_category->name,
            'image' => $menu_category->image,
            'sub_categories' => $this->menuSubCategories,
        ];
    }
}
