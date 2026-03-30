<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membre extends Model
{
    protected $primaryKey  = 'idmembre';

    protected $table='membres';
    public $timestamps = false;
    protected $fillable = [
        'idmembre',
        'nom',
        'prenom',
        'dateinscription',
        'email',
        'tel',
        'fkrole',

        'civilite',


    ];

    public function acces():BelongsTo{
        return $this->belongsTo(Role::class,'fkrole');
    }
    public function scopeActiveMember(Builder $query):Builder
    {
        return $query->where('actif',1);
    }
}
