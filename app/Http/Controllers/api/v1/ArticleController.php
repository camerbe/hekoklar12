<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    protected $articleService;

    /**
     * @param $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles=$this->articleService->index();
        if ($articles){
            return response()->json([
                'success'=>true,
                'data'=>$articles,
                'message'=>"Liste des articles"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas d'article trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $article=$this->articleService->create($request->all());
        if ($article){
            return response()->json([
                'success'=>true,
                'data'=>$article ,
                'message'=>"Article ajouté"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Problème survenu lors de l'insertion  de l'article"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article=$this->articleService->find($id);
        if ($article){
            return response()->json([
                'success'=>true,
                'data'=>$article ,
                'message'=>"Article trouvé"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas d'article trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article=$this->articleService->update($request->all(),$id);
        if ($article){
            return response()->json([
                'success'=>true,
                'data'=>$article ,
                'message'=>"Article mis à jour"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la mise à jour du l'article"
        ],Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article=$this->articleService->delete($id);
        if ($article){
            return response()->json([
                'success'=>true,
                'data'=>$article ,
                'message'=>"Article supprimé"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la suppression de l'article"
        ],Response::HTTP_NO_CONTENT);
    }

    public function getNews(){
        $articles=$this->articleService->getNews();
        if ($articles){
            return response()->json([
                'success'=>true,
                'data'=>$articles,
                'message'=>"Liste des articles"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas d'article trouvé"
        ],Response::HTTP_NOT_FOUND);
    }
}
