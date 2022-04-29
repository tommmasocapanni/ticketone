<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;


class EventResource extends ResourceCollection{
    public function toArray($request){
        return[
            // Qui sto usando EventResorces utomaticamnte
            'data' => $this->collection,
            'error' => null,
        ];
    }
}