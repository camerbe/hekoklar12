<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fullName'=>$this->nom.' '.$this->prenom,
            'email'=>$this->email,
            'role'=>$this->role,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'email_verified_at'=>$this->email_verified_at,
            'two_factor_secret'=>$this->two_factor_secret,
            'two_factor_recovery_codes'=>$this->two_factor_recovery_codes,
            'two_factor_confirmed_at'=>$this->two_factor_confirmed_at,
        ];
    }
}
