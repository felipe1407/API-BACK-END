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

            if(Categoria::where('name', request()->name)->exists()){
                return response()->json([
                    'status' => false,
                    'message' => 'Categoria já registrada.'
                ], Response::HTTP_UNAUTHORIZED, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
            
            $categoria = Categoria::create($fields);
            
            return response()->json([
                'status' => true,
                'message' => 'Categoria criada com sucesso',
                
            ], Response::HTTP_CREATED);

 
            // return reponse([
            //     'status' => false,
            //     'message' => 'Impossível cadastrar essa categoria'
            // ], Response::HTTP_BAD_REQUEST);
        }


        public function subCategoria (Request $request){
                $fields = $request->validate([
                    'name' => 'required|string',
                    'id_category' => 'required|exists:categorias,id'
                ]);

                if(subCategoria::where('name', request()->name)->exists()){
                    return response()->json([
                        'status' => false,
                        'message' => 'SubCategoria já registrada.'
                    ], Response::HTTP_UNAUTHORIZED, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }

                $subCategoria = SubCategoria::create($fields);

                return response()->json([
                    'status' => true,
                    'messagem' => 'SubCategoria criada com sucesso',
                    'data' => $subCategoria
                ], Response::HTTP_CREATED);
        }

        public function destroy(Request $request){

             $id = $request->id;

            if(Categoria::where('id', $id)->exists()){
                $categoria = Categoria::find($id);
                $categoria->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Categoria deletada com sucesso.'
                ], Response::HTTP_OK, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
          
                return response()->json([
                    'status' => false,
                    'message' => 'Categoria não encontrada.'
                ], Response::HTTP_OK, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

           
    }
        
            
    }