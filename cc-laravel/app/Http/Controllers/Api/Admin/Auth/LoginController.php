<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAuthResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        if ($this->guard()->attempt($credentials)) {

            $user = $this->guard()->user();

            if (!$user) {
                return $this->internalServerError("Encontramos um erro ao tentar efetuar seu login. Tente novamente em instantes.");
            }

            $user->tokens()->delete();
            $user->accessToken = explode('|',$user->createToken($user->name . '-access_token')->plainTextToken)[1];

            return new UserAuthResource($user);
        } else {
            return Response::json(array(
                'code' => 401,
                'message' => 'Verifique seu email e sua senha e tente novamente.'
            ), 401);
        }
    }

    public function logout() 
    {
        if ($user = Auth::user()) {
            $user->tokens()->delete();
        } else {
            return Response::json(array(
                'code' => 200,
                'message' => 'Você já está deslogado.'
            ), 200);
        }

        return response()->noContent();
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}
