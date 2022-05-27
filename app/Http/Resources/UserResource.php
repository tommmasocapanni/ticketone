<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class UserResource extends BaseResource{
    public function toArray($request){
        return[
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'birthDate' => $this->birthDate,
            'city' => $this->city,
            
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}