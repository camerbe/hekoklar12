<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $userService;

    /**
     * @param $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=$this->userService->index();
        if ($users){
            return response()->json([
                'success'=>true,
                'data'=>$users ,
                'message'=>"Utilisateur ajouté"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Problème survenu lors de l'insertion  de l'utilisateur"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user=$this->userService->create($request->all());
        if ($user){
            return response()->json([
                'success'=>true,
                'data'=>$user ,
                'message'=>"Utilisateur ajouté"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Problème survenu lors de l'insertion  de l'utilisateur"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user=$this->userService->find($id);
        if ($user){
            return response()->json([
                'success'=>true,
                'data'=>$user ,
                'message'=>"Utilisateur trouvé"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas d'utilisateur trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user=$this->userService->update($request->all(),$id);
        if ($user){
            return response()->json([
                'success'=>true,
                'data'=>$user ,
                'message'=>"Utilisateur mis à jour"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la mise à jour du l'utilisateur"
        ],Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=$this->userService->delete($id);
        if ($user){
            return response()->json([
                'success'=>true,
                'data'=>$user ,
                'message'=>"Utilisateur supprimé"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la suppression de l'utilisateur"
        ],Response::HTTP_NO_CONTENT);
    }
}
