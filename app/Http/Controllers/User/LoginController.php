<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login (Request $request){
        $login = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response([
                'status' => false,
                'message' => 'Login ou senha inválidos.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        $user = Auth::user();
        
        $expirate = Carbon::now();
        $token = $request->user()->createToken($user->email, ['USER'], $expirate->addMinutes(360));
        
        return response([
            'status' => true,
            'message' => 'Login efetuado',
            'data' => [
                'idUser' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token->plainTextToken,
                'accessUser' => $token->accessToken->abilities,
                'isBackoffice' => false,
                'expires_at' => $token->accessToken->expires_at,
                'step' => $buscaFluxo->etapaId ?? 1,
                'idPJ' => $idPJ->empresaId ?? 0
            ]

        ], Response::HTTP_OK);
        
    }

    public function check(Request $request){
        $user = Auth::user();
        dd($user);
    }
}
