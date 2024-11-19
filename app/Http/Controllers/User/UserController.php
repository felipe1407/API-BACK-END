<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register (Request $request) {
        //  dd($request->all());
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'admin' => 'required'
        ]);
        

        if(User::where('email', request()->email)->exists()){
            return response([
                'status' => false,
                'message' => 'Email já registrado.'
            ], Response::HTTP_UNAUTHORIZED);
        }


        
        $user = User::create($fields);
        
        return response([
            'status' => true,
            'message' => 'Usuário cadastrado com sucesso'
        ], Response::HTTP_OK);
    }


}
