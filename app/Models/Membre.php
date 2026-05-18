<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
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
    protected static function booted()
    {
        static::creating(function ($membre) {
            $membre->id = (string) Str::uuid();
            //$binome->annee = date('Y', strtotime($binome->datereception));
        });

        Membre::created(function ($model){

            static::clearMembreCache($model);
        });
        Membre::deleted(function ($model){
            static::clearMembreCache($model);
        });
        Membre::updated(function ($model){
            static::clearMembreCache($model);
        });
    }
    /*public function acces():BelongsTo{
        return $this->belongsTo(Role::class,'fkrole');
    }*/
    public function scopeActiveMember(Builder $query):Builder
    {
        return $query->where('statut','Actif');
    }
    protected static function clearMembreCache(self $model): void{

        Cache::forget('stats');

    }
}
