<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'article'=>'required',
            'typearticle_id'=>'required',
            'pays_id' => 'required',
            'titre' => 'required',
            'datearticle' => 'required' ,
            'auteur' => 'required' ,
            'source' => 'required',
            'image'=> 'required' ,
            'keyword' => 'required',

        ];
    }
}
