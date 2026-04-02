<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\BinomeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BinomeController extends Controller
{
    protected $binomeService;

    /**
     * @param $binomeService
     */
    public function __construct(BinomeService $binomeService)
    {
        $this->binomeService = $binomeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $binomes=$this->binomeService->index();
        if ($binomes){
            return response()->json([
                'success'=>true,
                'data'=>$binomes ,
                'message'=>"Liste des binômes"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de binôme trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $binome=$this->binomeService->create($request->all());
        if ($binome){
            return response()->json([
                'success'=>true,
                'data'=>$binome ,
                'message'=>"Binône ajouté"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Problème survenu lors de l'insertion  du binôme"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $binome=$this->binomeService->find($id);
        if ($binome){
            return response()->json([
                'success'=>true,
                'data'=>$binome ,
                'message'=>"Binôme trouvé"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de binôme trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $binome=$this->binomeService->update($request->all(),$id);
        if ($binome){
            return response()->json([
                'success'=>true,
                'data'=>$binome ,
                'message'=>"Binôme mis à jour"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la mise à jour du binôme"
        ],Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $binome=$this->binomeService->delete($id);
        if ($binome){
            return response()->json([
                'success'=>true,
                'data'=>$binome ,
                'message'=>"Binôme supprimé"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la suppression du binôme"
        ],Response::HTTP_NO_CONTENT);
    }
}
