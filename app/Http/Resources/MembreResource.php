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
            'id'=>$this->idmembre,
            'nom'=>$this->nom,
            'prenom'=>$this->prenom,
            'email'=>$this->email,
            'tel'=>$this->tel,
            'actif'=>$this->actif,
            'datefinstage'=>$this->datefinstage,
            'fkrole'=>$this->fkrole ,
            'haslogged'=>$this->haslogged,
            'iseligibleforfond'=>$this->iseligibleforfond,
            'civilite'=>$this->civilite,
            'roles'=>$this->acces,
        ];
    }
}
