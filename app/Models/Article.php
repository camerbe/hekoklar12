<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Article extends Model
{
    use HasUuids;
    //
    protected $primaryKey  = 'id';
    public $incrementing = false;
    protected $table='articles';
    //public $timestamps = false;
    protected $fillable = [
        'id',
        'article',
        'chapeau',
        'slug',
        'typearticle_id',
        'pays_id',
        'titre' ,
        'datearticle' ,
        'auteur' ,
        'source' ,
        'image' ,
        'keyword' ,
        'hit' ,
    ];

    protected static function boot()
    {
        parent::boot(); //
        Article::creating(function ($model){
            if (!$model->id) {
                $model->id = Str::uuid();
            }

        });
        Article::created(function ($model){

            static::clearArticleCache($model);
        });
        Article::deleted(function ($model){
            static::clearArticleCache($model);
        });
        Article::updated(function ($model){
            static::clearArticleCache($model);
        });
    }

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
        return $query->where('typearticle_id','019d494d-5210-7317-b25b-df9a383613cd')
                    ->where('datearticle','<=',now());
    }
    public function countries():BelongsTo{
        return $this->belongsTo(Pays::class,'pays_id');
    }
    public function typenews():BelongsTo{
        return $this->belongsTo(Typearticle::class,'typearticle_id');
    }

    protected static function clearArticleCache(self $model): void{

        Cache::forget('news_articles');

    }
    //protected $with = ['media'];
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
