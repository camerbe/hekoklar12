<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->idarticle,
            'info'=>$this->article,
            'chapeau'=>$this->chapeau,
            'slug'=>$this->slug,
            'fktypearticle'=>$this->fktypearticle,
            'fkpays'=>$this->fkpays,
            'titre'=>$this->titre,
            'datearticle'=>$this->datearticle,
            'auteur'=>$this->auteur,
            'source'=>$this->source,
            'image'=>$this->getImageUrl(),
            'photo'=>$this->image,
            'keyword'=>$this->keyword,
            'hit'=>$this->hit,
            'countries'=>$this->countries,
            'typearticles'=>$this->typenews,

        ];
    }
    protected function getImageUrl(){
        return Helper::extractImgSrc($this->image);

    }
}
