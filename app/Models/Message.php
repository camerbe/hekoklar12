<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function incrementHits(): void
    {
        $this->increment('hit');
    }
    public function scopeMsgAG(Builder $query):Builder
    {
        return $query->where('fktypemessage ',1)
                    ->where('datearticle','>=',now());
    }

    public function typemsg():BelongsTo{
        return $this->belongsTo(Typemessage::class,'fktypemessage');
    }


}
