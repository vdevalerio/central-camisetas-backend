<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\UserResource;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = QueryBuilder::for(Product::class)
            ->defaultSort('-id')
            ->allowedFilters(['name', 'size'])
            ->allowedSorts(['id', 'name', 'size']);

        $products = $query->paginate(min($request->per_page ?? 50, 200));

        return UserResource::collection($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'size' => 'required',
            'type' => 'required',
            'model' => 'required',
            'tissue' => 'required',
            'color' => 'required',
            'pocket' => 'required',
            'collar' => 'nullable',
            'cuff' => 'nullable',
            'vivo' => 'nullable',
            'faixa' => 'nullable',
        ]);
       
        Product::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
