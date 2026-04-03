<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Binome extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'datereception',
        'annee',
        'membre1_id',
        'membre2_id',
    ];

    protected static function booted()
    {
        static::creating(function ($binome) {
            $binome->id = (string) Str::uuid();
            $binome->annee = date('Y', strtotime($binome->datereception));
        });
        static::updating(function ($binome) {
            $binome->annee = date('Y', strtotime($binome->datereception));
        });
        Binome::created(function ($model){

            static::clearArticleCache($model);
        });
        Binome::deleted(function ($model){
            static::clearArticleCache($model);
        });
        Binome::updated(function ($model){
            static::clearArticleCache($model);
        });
    }
    protected static function clearArticleCache(self $model): void{

        Cache::forget('month_binome');

    }
    public function membre1()
    {
        return $this->belongsTo(Membre::class, 'membre1_id');
    }

    public function membre2()
    {
        return $this->belongsTo(Membre::class, 'membre2_id');
    }

    public function scopeComingSoonBinome(Builder $query):Builder
    {
        return $query->where('datereception','>=',now());
    }
}
