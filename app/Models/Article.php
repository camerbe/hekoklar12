<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Article extends Model
{
    //
    protected $primaryKey  = 'idarticle';

    protected $table='articles';
    public $timestamps = false;
    protected $fillable = [
        'idarticle',
        'article',
        'chapeau',
        'slug',
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
    public function scopeNews(Builder $query):Builder
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

    protected $with = ['media'];
    public function registerMediaCollections():void{
        $this->addMediaCollection('article')
            ->registerMediaConversions(function(Media $media){
                $this
                    ->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100);
            } );
        $this
            ->addMediaCollection('article')
            ->withResponsiveImages();
    }
    public function getImagesAttribute()
    {
        return $this->getMedia('article')->map(function ($media) {
            return [
                'original' => $media->getUrl(),
                //'thumb' => $media->getUrl('thumb'), // Conversion
                'properties' => $media->custom_properties,
                'width' => $media->getCustomProperty('width'),
                'height'=> $media->getCustomProperty('height'),
            ];
        });
    }
}
