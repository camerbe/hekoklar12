<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Typemessage extends Model
{
    use HasUuids;
    //
    protected $primaryKey  = 'id';

    protected $table='typemessages';
    //public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'typemessage',
        'slug',

    ];
    protected static function boot()
    {
        parent::boot(); //
        Typemessage::creating(function ($model){
            if (!$model->id) {
                $model->id = Str::uuid();
            }

        });
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
        return $this->hasMany(Message::class,'typemessage_id');
    }
}
