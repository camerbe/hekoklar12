<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Article extends Model
{
    //
    protected $primaryKey  = 'idarticle';

    protected $table='articles';

    protected $fillable = [
        'idarticle',
        'article',
        'fktypearticle',
        'fkpays',
        'titre' ,
        'datearticle' ,
        'auteur' ,
        'source' ,
        'image' ,
        'keyword' ,
        'hit' ,
    ];

    // --- Helpers ---
    public function incrementHits(): void
    {
        $this->increment('hit');
    }
    public function scopePublished(Builder $query):Builder
    {
        return $query->where('datearticle','<=',now());
    }
    public function scopeArticle(Builder $query):Builder
    {
        return $query->where('fktypearticle',2)
                    ->where('datearticle','<=',now());
    }
    public function countries():BelongsTo{
        return $this->belongsTo(Pays::class,'fkpays');
    }
    public function typenews():BelongsTo{
        return $this->belongsTo(Typearticle::class,'fktypearticle');
    }
}
