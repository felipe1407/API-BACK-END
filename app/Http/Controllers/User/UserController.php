<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register (Request $request) {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        
        $user = User::create($fields);
        
        return response([
            'status' => true,
            'message' => 'Usuário cadastrado com sucesso'
        ], Response::HTTP_OK);
    }


}
