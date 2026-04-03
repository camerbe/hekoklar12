<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
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
        Typemessage::creating(function ($model){
            if (!$model->id) {
                $model->id = Str::uuid();
            }

        });

    }

}
