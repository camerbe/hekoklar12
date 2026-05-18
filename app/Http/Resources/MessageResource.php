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
            'id'=>$this->id,
            'message'=>$this->message,
            'datefin'=>$this->datefin,
            'typemessage_id'=>$this->typemessage_id,
            'typemessages' => $this->typemsg
                ? (new TypeMessageResource($this->typemsg))->toArray($request)
                : null,
            


        ];
    }
}
