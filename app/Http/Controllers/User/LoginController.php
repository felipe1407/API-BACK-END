<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response([
                'status' => false,
                'message' => 'Email ou senha inválidos.'
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
                'admin' => $user->admin,
                'token' => $token->plainTextToken,
                'accessUser' => $token->accessToken->abilities,
                'isBackoffice' => false,
                'expires_at' => $token->accessToken->expires_at,
                'step' => $buscaFluxo->etapaId ?? 1,
                'idPJ' => $idPJ->empresaId ?? 0
            ]

        ], Response::HTTP_OK);
    }

    public function check(Request $request)
    {

        $user = Auth::user();

        if ($user->admin == true) {

            return response($user, Response::HTTP_OK);
        } else {
            return response(
                'Usuário não tem permissão para acessar esses dados',
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function show() //Deveria ser index
    {
        if (!auth::user()->admin) {
            return response()->json([
                'status' => false,
                'message' => 'Usuário não tem permissão'
            ], Response::HTTP_UNAUTHORIZED, [], JSON_PRETTY_PRINT);
        }

        $users = UserResource::collection(User::all());

        return response()->json([
            'status' => true,
            'message' => 'lista de usuários:',
            'data' => $users

        ], Response::HTTP_OK, [], JSON_PRETTY_PRINT);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'sometimes',
            'email' => 'sometimes',
            'admin' => 'sometimes|boolean'
        ]);


        if (Auth::user()->admin) {
            $user = User::find($request->id);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Usuário não encontrado.',
                ], Response::HTTP_NOT_FOUND, [], JSON_PRETTY_PRINT);
            }


            $user->update($request->only(['name', 'email', 'admin']));
        }
        return response()->json([
            'status' => true,
            'message' => 'Usuário atualizado com sucesso!',
        ], Response::HTTP_OK, [], JSON_PRETTY_PRINT);
    }

    public function destroy(Request $request)
    {
        if (Auth::user()->admin) {
            $user = User::find($request->id);
        }

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Usuário não encontrado.'
            ], Response::HTTP_NOT_FOUND, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        if ($user->admin) {
            return response()->json([
                'status' => false,
                'message' => 'Este usuário é um administrador e não pode ser excluído'
            ], Response::HTTP_BAD_REQUEST, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'Usuário excluído com sucesso'
        ], Response::HTTP_OK, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
