<?php

namespace App\Http\Controllers\Produto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use Symfony\Component\HttpFoundation\Response;

class ProdutoController extends Controller
{
    public function register_products(Request $request){
            $fields = $request->validate([
                'name_product' => 'required',
                'description' => 'required',
                'category' => "required",
                'price' => 'required',
                'mark' =>  'required'
                
            ]);
            
            $produto = Produto::create($fields);
            
            return response([
                'status' => true,
                'message' => 'Usuário criado com sucesso'
            ], Response::HTTP_OK);
        }
    
    }

