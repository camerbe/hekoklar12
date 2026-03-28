<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Typemessage extends Model
{
    //
    protected $primaryKey  = 'idtypemessage';

    protected $table='typemessages';
    public $timestamps = false;
    protected $fillable = [
        'idtypemessage',
        'typemessage',

    ];
    protected static function boot()
    {
        parent::boot(); //
        Typemessage::created(function ($model){
            static::clearArticleCache($model);
        });
        Typemessage::deleted(function ($model){
            static::clearArticleCache($model);
        });
        Typemessage::updated(function ($model){
            static::clearArticleCache($model);
        });
    }

    protected static function clearArticleCache(self $model): void{

        Cache::forget('typemessages');

    }
    public function messages():HasMany
    {
        return $this->hasMany(Message::class,'fktypemessage');
    }
}
