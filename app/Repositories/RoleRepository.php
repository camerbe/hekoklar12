<?php

namespace App\Repositories;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleRepository extends Repository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    function create(array $input)
    {
        $input['role']=Str::upper($input['role']);
        return parent::create($input);
    }

    function delete($id)
    {
        return parent::delete($id);
    }

    function findById($id)
    {
        return new RoleResource(parent::findById($id));
    }

    function update(array $input, $id)
    {
        $current=$this->findById($id);
        $input['role']= isset($input['role'])?Str::upper($input['role']):$current->role;
        return parent::update($input, $id);
    }

    function index()
    {
        return RoleResource::collection(parent::index());
    }

}
