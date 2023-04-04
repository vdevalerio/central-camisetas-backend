<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
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
            ->allowedFilters((new Product)->getAllowedFilters())
            ->allowedSorts((new Product)->getAllowedSorts());

        $products = $query->paginate(min($request->per_page ?? 50, 200));

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->only((new Product)->getFillable());

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

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->only((new Product)->getFillable());

        foreach($validated as $key => $value)
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
