<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembreRequest;
use App\Services\MembreService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MembreController extends Controller
{
    protected $membreService;

    /**
     * @param $membreService
     */
    public function __construct(MembreService $membreService)
    {
        $this->membreService = $membreService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $membres=$this->membreService->index();
        if ($membres){
            return response()->json([
                'success'=>true,
                'data'=>$membres ,
                'message'=>"Liste des membres"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de membre trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MembreRequest $request)
    {
        $membre=$this->membreService->create($request->all());
        if ($membre){
            return response()->json([
                'success'=>true,
                'data'=>$membre ,
                'message'=>"Membre ajouté"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Problème survenu lors de l'insertion  du membre"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $membre=$this->membreService->find($id);
        if ($membre){
            return response()->json([
                'success'=>true,
                'data'=>$membre ,
                'message'=>"Membre trouvé"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de membre trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $membre=$this->membreService->update($request->all(),$id);
        if ($membre){
            return response()->json([
                'success'=>true,
                'data'=>$membre ,
                'message'=>"Membre mis à jour"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la mise à jour du membre"
        ],Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $membre=$this->membreService->delete($id);
        if ($membre){
            return response()->json([
                'success'=>true,
                'data'=>$membre ,
                'message'=>"Membre supprimé"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la suppression du membre"
        ],Response::HTTP_NO_CONTENT);
    }

    public function getActiveMember(){
        $membres=$this->membreService->getActiveMember();
        if ($membres){
            return response()->json([
                'success'=>true,
                'data'=>$membres,
                'message'=>"Liste des membres actifs"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de membre actif trouvé"
        ],Response::HTTP_NOT_FOUND);
    }
}
