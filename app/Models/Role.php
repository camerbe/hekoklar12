<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $primaryKey  = 'idrole';

    protected $table='roles';
    public $timestamps = false;
    protected $fillable = [
        'idrole',
        'role',


    ];
    public function membres():HasMany
    {
        return $this->hasMany(Membre::class,'fkrole');
    }
}
