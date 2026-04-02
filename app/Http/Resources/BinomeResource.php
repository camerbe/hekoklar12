<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BinomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'datereception'=>$this->datereception,
            'annee'=>$this->annee,
            'membre1_id'=>$this->membre1_id,
            'membre2_id'=>$this->membre2_id,
            'membre1'=>$this->membre1->nom.' '.$this->membre1->prenom,
            'membre2'=>$this->membre2->nom.' '.$this->membre2->prenom,
        ];
    }
}
