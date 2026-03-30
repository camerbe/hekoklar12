<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    protected $roleService;

    /**
     * @param $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles=$this->roleService->index();
        if ($roles){
            return response()->json([
                'success'=>true,
                'data'=>$roles ,
                'message'=>"Liste des rôles"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de rôle trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $role=$this->roleService->create($request->all());
        if ($role){
            return response()->json([
                'success'=>true,
                'data'=>$role ,
                'message'=>"Rôle ajouté"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Problème survenu lors de l'insertion  du rôle"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role=$this->roleService->find($id);
        if ($role){
            return response()->json([
                'success'=>true,
                'data'=>$role ,
                'message'=>"Rôle trouvé"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de rôle trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role=$this->roleService->update($request->all(),$id);
        if ($role){
            return response()->json([
                'success'=>true,
                'data'=>$role ,
                'message'=>"Rôle mis à jour"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la mise à jour du rôle"
        ],Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role=$this->roleService->delete($id);
        if ($role){
            return response()->json([
                'success'=>true,
                'data'=>$role ,
                'message'=>"Rôle supprimé"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la suppression du rôle"
        ],Response::HTTP_NO_CONTENT);
    }
}
