<?php

namespace App\Repositories;

use App\Http\Resources\MessageResource;
use App\IRepositories\IMessageRepository;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class MessageRepository extends Repository implements IMessageRepository
{
    public function __construct(Message $message)
    {
        parent::__construct($message);
    }

    function create(array $input)
    {
        $input['datefin']=Carbon::parse($input['datefin'])->format('Y-m-d');
        return parent::create($input);
    }

    function delete($id)
    {
        return parent::delete($id);
    }

    function findById($id)
    {
        return new MessageResource(parent::findById($id)) ;
    }

    function update(array $input, $id)
    {
        $current=$this->findById($id);
        $input['typemessage_id']= $input['typemessage_id'] ?? $current->typemessage_id;
        $input['message']= $input['message'] ?? $current->message;
        $input['datefin']= isset($input['datefin'])? Carbon::parse($input['datefin'])->format('Y-m-d')
            : $current->datefin;
        return parent::update($input, $id);
    }

    function index()
    {
        return  MessageResource::collection(parent::index()) ;
    }

    function getCurrentAGMessage()
    {
        $cacheKey = 'current-ag';
        //Cache::forget($cacheKey);
        //$cacheExpiry = now()->addDay();
        $messageData= Cache::remember($cacheKey , now()->addDay() , function () {
            $message= Message::MsgAG()
                ->with(['typemsg'])
                ->orderBy('datefin','asc')
                ->first();
            //dd($message);
            if(!$message) return null;
            return (new MessageResource($message))->toArray(request());
        });
        //dd($articles);
        return $messageData;
    }
}
