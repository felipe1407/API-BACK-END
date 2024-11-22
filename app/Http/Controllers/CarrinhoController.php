<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CarrinhoController extends Controller
{
    public function addCar(Request $request)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);


        

        if (Auth::check()) {
            $carrinhoItem = Carrinho::where('user_id', Auth::id())->where('produto_id', $validated['produto_id'])
                ->first();
        }
        if ($carrinhoItem) {
                
            $carrinhoItem->quantidade += $validated['quantidade'];
            $carrinhoItem->save();

        } else {
            
            Carrinho::create([
                
                'user_id' => Auth::id(),
                'produto_id' => $validated['produto_id'],
                'quantidade' => $validated['quantidade'],
            ]);

            
        }

        return Response()->json([
            'status' => 'true',
            'message' => 'Produto adicionado com sucesso!'
        ], Response::HTTP_OK);
    }

    public function removeCar(Request $request)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
        ]);

        if (Auth::check()) {
            $carrinhoItem = Carrinho::where('user_id', Auth::id())
                ->where('produto_id', $validated['produto_id'])
                ->first();

            if ($carrinhoItem) {
                $carrinhoItem->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Produto removido com sucesso.',
                ], Response::HTTP_OK);
            }

            return response()->json([
                'status' => false,
                'message' => 'Produto não encontrado no carrinho.',
            ], Response::HTTP_NOT_FOUND);  
        }

        return response()->json([
            'status' => false,
            'message' => 'Usuário não autenticado.',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function listCar(Request $request)
    {
        if (Auth::check()) {
            $carrinhoItens = Carrinho::where('user_id', Auth::id())->get();
       
            return response()->json([
                'status' => true,
                'data' => $carrinhoItens,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => false,
            'message' => 'Usuário não autenticado.',
        ], Response::HTTP_UNAUTHORIZED);

    }
}
