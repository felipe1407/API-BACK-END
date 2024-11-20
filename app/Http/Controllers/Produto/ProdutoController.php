<?php

namespace App\Http\Controllers\Produto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use Symfony\Component\HttpFoundation\Response;

class ProdutoController extends Controller
{
    public function register_product(Request $request){
            $fields = $request->validate([
                'products' => 'required|array',
                'products.*.name_product' => 'required|string',
                'products.*.description' => 'required|string',
                'products.*.price' => 'required|numeric',
                'products.*.mark' =>  'required|string',
                'products.*.id_user' => 'required|exists:users,id',
                'products.*.id_category' => 'required|exists:categorias,id',
                'products.*.id_subCategory' => 'required|exists:sub_categorias,id'
                
            ]);

            
            
            $createdProducts = [];

            

             foreach ($fields['products'] as $productData) {
                if(Produto::where('name_product',$productData['name_product'])->exists()){
                    return response()->json([
                        'status' => false,
                        'message' =>'Produto"' . $productData['name_product'] . '" já registrado.'
                    ], Response::HTTP_UNAUTHORIZED, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }
            $produto = Produto::create($productData);
            $createdProducts[] = $produto;
        }
            
            return response()->json([
                'status' => true,
                'message' => 'Produtos criados com sucesso',
                'data' => $createdProducts
            ], Response::HTTP_OK, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        
            
    }

