<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class BaseResource extends JsonResource{
    public function toArray($request){
        return[
            'error' => null
        ];
    }
}