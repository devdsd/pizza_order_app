<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pizza extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        // define spicic format of the data
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'type' => $this->type,
            'crust' => $this->crust
        ];
    }

    public function with($request) {
        return [
            'message' => 'Retrieved successfully!',
            'author' => 'Diether Dayondon'
        ];
    }
}
