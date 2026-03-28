<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeArticleRequest;
use App\Http\Requests\TypeMessageRequest;
use App\Services\TypeMessageService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeMessageController extends Controller
{
    protected $typemessageService;

    /**
     * @param $typemessageService
     */
    public function __construct(TypeMessageService $typemessageService)
    {
        $this->typemessageService = $typemessageService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typemessages=$this->typemessageService->index();
        //dd($typemessages);
        if ($typemessages){
            return response()->json([
                'success'=>true,
                'data'=>$typemessages ,
                'message'=>"Liste des types de message"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de type d'de message trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeMessageRequest $request)
    {
        $typemessage=$this->typemessageService->create($request->all());
        if ($typemessage){
            return response()->json([
                'success'=>true,
                'data'=>$typemessage ,
                'message'=>"Type de message ajouté"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Problème survenu lors de l'insertion du type de message"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $typemessage=$this->typemessageService->find($id);
        if ($typemessage){
            return response()->json([
                'success'=>true,
                'data'=>$typemessage ,
                'message'=>"Type de message trouvé"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de type de message trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $typemessage=$this->typemessageService->update($request->all(),$id);
        if ($typemessage){
            return response()->json([
                'success'=>true,
                'data'=>$typemessage ,
                'message'=>"Type de message mis à jour"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la mise à jour de type de message"
        ],Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $typemessage=$this->typemessageService->delete($id);
        if ($typemessage){
            return response()->json([
                'success'=>true,
                'data'=>$typemessage ,
                'message'=>"Type de message supprimé"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la suppression de type de message"
        ],Response::HTTP_NO_CONTENT);
    }
}
