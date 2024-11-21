<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register (UserRequest $request) {
        //  dd($request->all());
        

        if(User::where('email', request()->email)->exists()){
            return response([
                'status' => false,
                'message' => 'Email já registrado.'
            ], Response::HTTP_UNAUTHORIZED);
        }


        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
            'admin' => $request->admin,
        ]);
        
        
        return response([
            'status' => true,
            'message' => 'Usuário cadastrado com sucesso'
        ], Response::HTTP_OK);
    }


}
