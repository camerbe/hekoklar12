<?php

namespace App\Repositories;

use App\Http\Resources\BinomeResource;
use App\IRepositories\IBinomeRepository;
use App\Models\Binome;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

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
        $cacheKey = 'month_binome';
        //Cache::forget($cacheKey) ;
        $cacheExpiry = now()->addDay();
        $binomeId=Cache::remember($cacheKey , $cacheExpiry, function () {
            return Binome::ComingSoonBinome()
                ->with(['membre1','membre2'])
                ->orderBy('datereception','asc')
                ->value('id');
        });
        $binome = Binome::with(['membre1', 'membre2'])->find($binomeId);
        return new BinomeResource($binome);
    }
}
