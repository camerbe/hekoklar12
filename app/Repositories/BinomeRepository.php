<?php

namespace App\Repositories;

use App\Http\Resources\BinomeResource;
use App\IRepositories\IBinomeRepository;
use App\Models\Binome;
use Carbon\Carbon;

class BinomeRepository extends Repository implements IBinomeRepository
{

    public function __construct(Binome $binome)
    {
        parent::__construct($binome);
    }

    function create(array $input)
    {
        $input['datereception']=Carbon::parse($input['datereception'])->format('Y-m-d');
        return parent::create($input);
    }

    function delete($id)
    {
        return parent::delete($id);
    }

    function findById($id)
    {
        return new BinomeResource(parent::findById($id)) ;
    }

    function update(array $input, $id)
    {
        $current=$this->findById($id);
        $input['membre_1']= $input['membre_1'] ?? $current->membre_1;
        $input['membre_2']= $input['membre_2'] ?? $current->membre_2;
        $input['datereception']=isset($input['datereception'])  ? Carbon::parse($input['datereception'])->format('Y-m-d')
            : $current->datereception;
        return parent::update($input, $id); //
    }

    function index()
    {
        return BinomeResource::collection(parent::index()) ;
    }

    function getMonthBinome()
    {
        $binome=Binome::with(['membre1','membre2'])
            ->where('datereception','>=',now())
            ->orderBy('datereception','asc')
            ->first();
        return new BinomeResource($binome);
    }
}
