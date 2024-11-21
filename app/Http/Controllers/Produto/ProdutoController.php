<?php

namespace App\Http\Controllers\Produto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProdutoController extends Controller
{
    public function register_product(Request $request)
    {
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

        DB::beginTransaction();

        try {

            $createdProducts = [];

            foreach ($fields['products'] as $productData) {
                if (Produto::where('name_product', $productData['name_product'])->exists()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Produto"' . $productData['name_product'] . '" já registrado.'
                    ], Response::HTTP_UNAUTHORIZED, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }
                $produto = Produto::create($productData);
                $createdProducts[] = $produto;
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Produtos criados com sucesso',
                'data' => $createdProducts
            ], Response::HTTP_OK, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            DB::rollBack();

            // Retorna uma resposta de erro
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar produtos: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(Request $request)
    {
        $produtos = Produto::orderBy('id_category')->get(); //Posso usar paginate(2)
        if (Auth::user()->admin) {
            return response()->json([
                'status' => 'true',
                'produtos' => $produtos,
            ], Response::HTTP_OK);
        }
        return response()->json([
            'status' => 'false',
            'message' => 'Você não tem autorização para acessar os produtos'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function show(Produto $produto)
    {

        if (Auth::user()->admin) {

            return response()->json([
                'status' => 'true',
                'messagem' => $produto,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => 'false',
            'message' => 'Você não tem autorização para acessar o produto'
        ], Response::HTTP_UNAUTHORIZED);
    }

    // public function store(Request $request){
    //     DB::beginTransaction();

    //     try{
    //         Produto::create([
    //             'products' => 'required|array',
    //             'products.*.name_product' => 'required|string',
    //             'products.*.description' => 'required|string',
    //             'products.*.price' => 'required|numeric',
    //             'products.*.mark' =>  'required|string',
    //             'products.*.id_user' => 'required|exists:users,id',
    //             'products.*.id_category' => 'required|exists:categorias,id',
    //             'products.*.id_subCategory' => 'required|exists:sub_categorias,id'
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'status' => 'true',
    //             'messagem' => 'Produto cadastrado com sucesso!',
    //         ], Response::HTTP_OK);

    //     }catch(Exception $e){
    //         DB::rollBack();
    //         return response()->json([
    //             'status' => 'false',
    //             'messagem' => 'Produto não cadastrado. Erro:' . $e->getMessage(),
    //         ], Response::HTTP_OK);

    //     }
    // }

    public function update(Request $request, Produto $produto)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:produtos,id',
            'name_product' => 'sometimes',
            'description' => 'sometimes',
            'mark' => 'sometimes',
            'price' => 'sometimes',
            'imagem' => 'sometimes',
            'id_user' => 'sometimes',
            'id_category' => 'sometimes',
            'id_subCategory' => 'sometimes'
        ]);


        try{
        if (!Auth::user()->admin) {
            return response()->json([
                'status' => 'false',
                'message' => 'Você não tem autorização para editar esse Produto'
            ], Response::HTTP_FORBIDDEN);
        }

            $produto = Produto::find($request->id);
        if(!$produto) {
            return response()->json([
                'status' => 'false',
                'message' => 'Produto não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        $produto->update($request->all());

        return response()->json([
            'status' => 'true',
            'product' => $produto,
            'message' => 'Produto Atualizado com sucesso!'
        ], Response::HTTP_OK);

    }   catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Erro ao editar produto',
            'error' => $e->getMessage()
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
}
