<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Membre extends Model
{
    use HasUuids;
    protected $primaryKey  = 'id';

    protected $table='membres';
    //public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'nom',
        'prenom',
        'dateinscription',
        'datefinstage',
        'email',
        'tel',
        'statut',
        'civilite',


    ];
    protected $casts = [
        'dateinscription' => 'date',
        'datefinstage' => 'date',
    ];
    protected static function boot()
    {
        parent::boot(); //
        Membre::creating(function ($model){
            if (!$model->id) {
                $model->id = Str::uuid();
            }

        });

    }
    /*public function acces():BelongsTo{
        return $this->belongsTo(Role::class,'fkrole');
    }*/
    public function scopeActiveMember(Builder $query):Builder
    {
        return $query->where('statut','Actif');
    }
}
