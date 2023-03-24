<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QueryBuilder::for(User::class)
            ->defaultSort('name')
            ->allowedFilters(['id', 'name', 'email'])
            ->allowedSorts(['id', 'name']);

        $users = $query->paginate(min($request->per_page ?? 50, 200));

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->only('name', 'email', 'password');

        $user = new User($validated);
        $user->password = bcrypt($validated['password']);
        $user->save();

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->only('name', 'email', 'password');

        $user->name = $validated['name'] ?? $user->name;
        $user->email = $validated['email'] ?? $user->email;
        $user->password = isset($validated['password']) ? bcrypt($validated['password']) : $user->password;
        $user->save();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, 204);
    }
}
