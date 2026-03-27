<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Typearticle extends Model
{
    //
    protected $primaryKey  = 'idtypearticle';

    protected $table='typearticles';
    public $timestamps = false;
    protected $fillable = [
        'idtypearticle',
        'typearticle',

    ];
    protected static function boot()
    {
        parent::boot(); //
        Typearticle::created(function ($model){
            static::clearArticleCache($model);
        });
        Typearticle::deleted(function ($model){
            static::clearArticleCache($model);
        });
        Typearticle::updated(function ($model){
            static::clearArticleCache($model);
        });
    }

    protected static function clearArticleCache(self $model): void{

        Cache::forget('typearticles');

    }
    public function articles():HasMany
    {
        return $this->hasMany(Article::class,'fktypearticle');
    }
}
