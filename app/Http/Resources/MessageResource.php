<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->idmessage,
            'message'=>$this->message,
            'datefin'=>$this->datefin,
            'fktypemessage'=>$this->fktypemessage,
            'typemessage'=> $this->whenLoaded('typemsg', function () {
                return [
                    'id'  => $this->typemsg->idtypemessage,
                    'nom' => $this->typemsg->typemessage,
                ];
            }),


        ];
    }
}
