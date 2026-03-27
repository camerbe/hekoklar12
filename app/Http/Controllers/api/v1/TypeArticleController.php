<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeArticleRequest;
use App\Services\TypeArticleService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeArticleController extends Controller
{
    protected $typearticleService;

    /**
     * @param $typearticleService
     */
    public function __construct(TypeArticleService $typearticleService)
    {
        $this->typearticleService = $typearticleService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typearticles=$this->typearticleService->index();
        if ($typearticles){
            return response()->json([
                'success'=>true,
                'data'=>$typearticles ,
                'message'=>"Liste des types d'articles"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de type d'article trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeArticleRequest $request)
    {
        $typearticle=$this->typearticleService->create($request->all());
        if ($typearticle){
            return response()->json([
                'success'=>true,
                'data'=>$typearticle ,
                'message'=>"Type d'article ajouté"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Problème survenu lors de l'insertion  type d'article"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $typearticle=$this->typearticleService->find($id);
        if ($typearticle){
            return response()->json([
                'success'=>true,
                'data'=>$typearticle ,
                'message'=>"Type d'article trouvé"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de type d'article trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $typearticle=$this->typearticleService->update($request->all(),$id);
        if ($typearticle){
            return response()->json([
                'success'=>true,
                'data'=>$typearticle ,
                'message'=>"Type d'article mis à jour"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la mise à jour de type d'article"
        ],Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $typearticle=$this->typearticleService->delete($id);
        if ($typearticle){
            return response()->json([
                'success'=>true,
                'data'=>$typearticle ,
                'message'=>"Type d'article supprimé"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la suppression de type d'article"
        ],Response::HTTP_NO_CONTENT);
    }
}
