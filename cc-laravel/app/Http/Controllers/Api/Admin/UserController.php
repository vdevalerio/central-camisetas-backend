<?php

namespace App\Http\Controllers\Api\Admin;

use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = QueryBuilder::for(User::class)
            ->defaultSort('-id')
            ->allowedFilters(['name', 'email'])
            ->allowedSorts(['id', 'name']);

        $users = $query->paginate(min($request->per_page ?? 50, 200));

        return UserResource::collection($users);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);


        extract($request->except('id'));

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();
             
        return new UserResource($user);
    }
}
