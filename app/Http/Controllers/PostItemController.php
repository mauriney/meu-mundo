<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class PostItemController extends Controller
{
    // Listar todoos os itens
    public function index()
    {
        $items = Item::all();
        
        return response()->json([
            'statusCode' => 200,
            'type' => 'Success',
            'message' => 'Itens listados com sucesso.',
            'data' => $items,
        ], 200);
    }

    //Mostrar um item específico
    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'statusCode' => 404,
                'type' => 'Not Found',
                'message' => 'O item solicitadooo não foi encontrado.',
            ], 404);
        }

        return response()->json([
            'statusCode' => 200,
            'type' => 'Success',
            'message' => 'Item encontrado com sucesso.',
            'data' => $item,
        ], 200);
    }

    //Criar um novo item
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $item = Item::create($validateData);

        return response()->json([
            'statusCode' => 201,
            'type' => 'Created',
            'message' => 'Item criado com sucesso.',
            'data' => $item,
        ], 201);
    }

    //Atualizar um item
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'statusCode' => 404,
                'type' => 'Not Found',
                'message' => 'O item que você está tentando atualizar não foi encontrado.',
            ], 404);
        }

        $validateData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'quantity' => 'sometimes|integer|min:0',
        ]);

        $item->update($validateData);

        return response()->json([
            'statusCode' => 200,
            'type' => 'Success',
            'message' => 'Item atualizado com sucesso.',
            'data' => $item,
        ], 200);
    }

    // Excluir um item
    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'statusCode' => 404,
                'type' => 'Not Found',
                'message' => 'O item que você está tentando excluir não foi encontrado.',
            ], 404);
        }

        $item->delete();

        return response()->json([
            'statusCode' => 200,
            'type' => 'Success',
            'message' => 'Item excluído com sucesso.',
            'data' => $item,
        ], 200);
    }
}
