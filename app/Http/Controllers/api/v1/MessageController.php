<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    protected $messageService;

    /**
     * @param $messageService
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages=$this->messageService->index();
        if ($messages){
            return response()->json([
                'success'=>true,
                'data'=>$messages ,
                'message'=>"Liste des messages"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de message trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        $message=$this->messageService->create($request->all());
        if ($message){
            return response()->json([
                'success'=>true,
                'data'=>$message ,
                'message'=>"Message ajouté"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Problème survenu lors de l'insertion  du message"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message=$this->messageService->find($id);
        if ($message){
            return response()->json([
                'success'=>true,
                'data'=>$message ,
                'message'=>"Message trouvé"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de message trouvé"
        ],Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message=$this->messageService->update($request->all(),$id);
        if ($message){
            return response()->json([
                'success'=>true,
                'data'=>$message ,
                'message'=>"Message mis à jour"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la mise à jour de message"
        ],Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message=$this->messageService->delete($id);
        if ($message){
            return response()->json([
                'success'=>true,
                'data'=>$message ,
                'message'=>"Message supprimé"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Erreur lors de la suppression du message"
        ],Response::HTTP_NO_CONTENT);
    }

    public function getCurrentAGMessage(){
        $message=$this->messageService->getCurrentAGMessage();
        if ($message){
            return response()->json([
                'success'=>true,
                'data'=>$message ,
                'message'=>"Message trouvé"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "success"=>false,
            "message"=>"Pas de message trouvé"
        ],Response::HTTP_NOT_FOUND);
    }
}
