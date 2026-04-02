<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Typearticle extends Model
{
    use HasUuids;
    //
    protected $primaryKey  = 'id';

    protected $table='typearticles';
    //public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'typearticle',
        'slug',

    ];
    protected static function boot()
    {
        parent::boot(); //
        Typearticle::creating(function ($model){
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
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
        return $this->hasMany(Article::class,'typearticle_id');
    }
}
