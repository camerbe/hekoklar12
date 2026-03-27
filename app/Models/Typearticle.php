<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Typearticle extends Model
{
    //
    protected $primaryKey  = 'idtypearticle';

    protected $table='typearticles';

    protected $fillable = [
        'idtypearticle',
        'typearticle',

    ];

    public function articles():HasMany
    {
        return $this->hasMany(Article::class,'fktypearticle');
    }
}
