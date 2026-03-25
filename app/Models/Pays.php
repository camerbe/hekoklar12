<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pays extends Model
{
    //
    protected $primaryKey  = 'code';
    protected $keyType = 'string';
    protected $table='pays';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'code', 'pays', 'country','code3',
    ];
    public function articles():HasMany
    {
        return $this->hasMany(Article::class,'fkpays');
    }

}
