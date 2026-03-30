<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Message extends Model
{
    protected $primaryKey  = 'idmessage';

    protected $table='messages';
    public $timestamps = false;
    protected $fillable = [
        'idmessage',
        'message',
        'datefin',
        'fktypemessage',

    ];

    // --- Helpers ---
    protected static function boot()
    {
        parent::boot(); //
        Message::created(function ($model){
            static::clearArticleCache($model);
        });
        Message::deleted(function ($model){
            static::clearArticleCache($model);
        });
        Message::updated(function ($model){
            static::clearArticleCache($model);
        });
    }

    protected static function clearArticleCache(self $model): void{

        Cache::forget('current-ag');

    }
    public function scopeMsgAG(Builder $query):Builder
    {
        return $query->where('fktypemessage',1)
                    ->where('datefin','>=',now());
    }

    public function typemsg():BelongsTo{
        return $this->belongsTo(Typemessage::class,'fktypemessage');
    }

}
