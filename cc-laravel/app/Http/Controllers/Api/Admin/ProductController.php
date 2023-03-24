<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QueryBuilder::for(Product::class)
            ->defaultSort('-id')
            ->allowedFilters(['name', 'size'])
            ->allowedSorts(['id', 'name', 'size']);

        $products = $query->paginate(min($request->per_page ?? 50, 200));

        return ProductResource::collection($products);
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

        $product = new Product($validated);
        $product->save();

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|max:255',
            'price' => 'sometimes',
            'size' => 'sometimes',
            'type' => 'sometimes',
            'model' => 'sometimes',
            'tissue' => 'sometimes',
            'color' => 'sometimes',
            'pocket' => 'sometimes',
            'collar' => 'nullable',
            'cuff' => 'nullable',
            'vivo' => 'nullable',
            'faixa' => 'nullable',
        ]);

        foreach($request->toArray() as $key => $value)
        {
            if(isset($key))
                $product[$key] = $value;
        }

        $product->save();

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response(null, 204);
    }
}
