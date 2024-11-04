<?php

namespace App\Http\Controllers\Produto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\SubCategoria;
use Symfony\Component\HttpFoundation\Response;

class CategoriaController extends Controller
{
    public function categoria(Request $request){
            $fields = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string'
                
                
            ]);
            
            $categoria = Categoria::create($fields);
            
            return response([
                'status' => true,
                'message' => 'Categoria criada com sucesso',
                'data' => $categoria
            ], Response::HTTP_CREATED);
        }


        public function subCategoria (Request $request){
                $fields = $request->validate([
                    'name' => 'required|string',
                    'id_category' => 'required|exists:categorias,id'
                ]);

                $subCategoria = SubCategoria::create($fields);

                return response([
                    'status' => true,
                    'messagem' => 'SubCategoria criada com sucesso',
                    'data' => $subCategoria
                ], Response::HTTP_CREATED);
        }
            
    }