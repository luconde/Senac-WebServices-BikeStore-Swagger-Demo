<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/categorias",
     *      operationId="getCategoriasList",
     *      tags={"Categorias"},
     *      summary="Retorna a lista de Categorias",
     *      description="Retorna o JSON da lista de Categorias",
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso"
     *       )
     *     )
     */
    public function index()
    {
        $categorias = Categoria::all();

        return response() -> json([
            'status' => 200,
            'mensagem' => 'Lista de categorias retornada',
            'categorias' => CategoriaResource::collection($categorias)
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/categorias",
     *      operationId="storeCategoria",
     *      tags={"Categorias"},
     *      summary="Cria uma nova Categoria",
     *      description="Retorna o JSON com os dados da nova Categoria",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreCategoriaRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/Categoria")
     *       )
     * )
     */
    public function store(StoreCategoriaRequest $request)
    {
        // Cria o objeto 
        $categoria =new Categoria();

        // Transfere os valores
        $categoria->nomedacategoria = $request->nome_da_categoria;

        // Salva
        $categoria->save();

        // Retorna o resultado
        return response() -> json([
            'status' => 200,
            'mensagem' => 'Categoria criada',
            'categoria' => new CategoriaResource($categoria)
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/categorias/{id}",
     *      operationId="getCategoriaById",
     *      tags={"Categorias"},
     *      summary="Retorna a informação de uma categoria",
     *      description="Retorna o JSON da Categoria requisitada",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Categoria",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso"
     *       )
     * )
     */
    public function show(Categoria $categoria)
    {
        $categoria = Categoria::find($categoria->pkcategoria);

        return response() -> json([
            'status' => 200,
            'mensagem' => 'Categoria retornada',
            'categoria' => new CategoriaResource($categoria)
        ]);
    }
    
    /**
     * @OA\Patch(
     *      path="/api/categorias/{id}",
     *      operationId="updateCategoria",
     *      tags={"Categorias"},
     *      summary="Atualiza uma Categoria existente",
     *      description="Retorna o JSON da Categoria atualizada",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Categoria",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreCategoriaRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso"
     *       )
     * )
     */
    public function update(StoreCategoriaRequest $request, Categoria $categoria)
    {
        $categoria = Categoria::find($categoria->pkcategoria);
        $categoria->nomedacategoria = $request->nome_da_categoria;
        $categoria->update();

        return response() -> json([
            'status' => 200,
            'mensagem' => 'Categoria atualizada'
        ], 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/categorias/{id}",
     *      operationId="deleteCategoria",
     *      tags={"Categorias"},
     *      summary="Apaga uma Categoria existente",
     *      description="Apaga uma Categoria existente e não há retorno de dados",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Categoria",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso",
     *          @OA\JsonContent()
     *       )
     * )
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return response() -> json([
            'status' => 200,
            'mensagem' => 'Categoria apagada'
        ], 200);
    }
}
