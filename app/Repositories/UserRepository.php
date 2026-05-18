<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Str;

class UserRepository extends Repository
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    function create(array $input)
    {
        return parent::create($input);
    }

    function delete($id)
    {
        return parent::delete($id);
    }

    function findById($id)
    {
        return new UserResource(parent::findById($id));
    }

    function update(array $input, $id)
    {
        $current=$this->findById($id);
        $input['nom']=isset($input['nom'])? Str::upper($input['nom']):$current->nom;
        $input['prenom']=isset($input['prenom'])? Str::title($input['prenom']):$current->prenom;
        $input['email']= $input['email'] ?? $current->prenom;
        $input['role']= $input['role'] ?? $current->role;

        return parent::update($input, $id);
    }

    function index()
    {
        return UserResource::collection(parent::index()->sortBy('nom')->values());
    }
}
