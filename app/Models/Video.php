<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasUuids;
    protected $primaryKey  = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table='videos';

    protected $fillable = [
        'titre',
        'video',

    ];
    protected static function booted()
    {
        parent::boot(); //
        Video::creating(function ($model){
            if (!$model->id) {
                $model->id = Str::uuid();
            }

        });
        Video::created(function ($model){

            static::clearArticleCache($model);
        });
        Video::deleted(function ($model){
            static::clearArticleCache($model);
        });
        Video::updated(function ($model){
            static::clearArticleCache($model);
        });


    }
    public function scopeVideoList(Builder $query):Builder
    {
        return $query->orderByDesc('created_at');
    }

    protected static function clearArticleCache(self $model): void{

        Cache::forget('random_videos_pool');


    }

}
