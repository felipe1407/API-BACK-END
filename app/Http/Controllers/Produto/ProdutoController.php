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
                
            ]);
            
            $createdProducts = [];

            

             foreach ($fields['products'] as $productData) {
            $produto = Produto::create($productData);
            $createdProducts[] = $produto;
        }
            
            return response([
                'status' => true,
                'message' => 'Produto criado com sucesso',
                'data' => $createdProducts
            ], Response::HTTP_OK);
        }

        
            
    }

