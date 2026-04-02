<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembreResource extends JsonResource
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
            'nom'=>$this->nom,
            'prenom'=>$this->prenom,
            'email'=>$this->email,
            'tel'=>$this->tel,
            'statut'=>$this->statut,
            'datefinstage'=>$this->datefinstage,
            'dateinscription'=>$this->dateinscription ,
            'civilite'=>$this->civilite,

        ];
    }
}
