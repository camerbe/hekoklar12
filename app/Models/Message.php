<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasUuids;
    protected $primaryKey  = 'id';

    protected $table='messages';
    //public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'message',
        'datefin',
        'typemessage_id',

    ];

    // --- Helpers ---
    protected static function boot()
    {
        parent::boot(); //
        Message::creating(function ($model){
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
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
        return $query->where('typemessage_id','019d494d-501f-70a0-989a-34ac5a129707')
                    ->where('datefin','>=',now());
    }

    public function typemsg():BelongsTo{
        return $this->belongsTo(Typemessage::class,'typemessage_id');
    }

}
