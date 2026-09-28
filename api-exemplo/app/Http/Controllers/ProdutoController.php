<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Http\Resources\ProdutoResource;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //OLA ANDRE DO FUTURO ESSE É O GET
    public function index()
    {
        return ProdutoResource::collection(Produto::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    //OLA ANDRE DO FUTURO ESSE É O POST
    public function store(StoreProdutoRequest $request)
    {
        $produto = Produto::create($request->validated());
        return new ProdutoResource($produto);
    }

    /**
     * Display the specified resource.
     */
    //OLA ANDRE DO FUTURO ESSE É O GET COM ID
    public function show(Produto $produto)
    {
        return new ProdutoResource($produto);
    }


    /**
     * Update the specified resource in storage.
     */
    //OLA ANDRE DO FUTURO ESSE É O PUT
    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        $produto->update($request->validated());
        return new ProdutoResource($produto);
    }

    /**
     * Remove the specified resource from storage.
     */
    //OLA ANDRE DO FUTURO ESSE É O DELETE
    public function destroy(Produto $produto)
    {
        $produto->delete();
        return response()->noContent();
    }
}
