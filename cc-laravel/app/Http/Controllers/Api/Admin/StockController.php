<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Http\Requests\Stock\StoreStockRequest;
use App\Http\Requests\Stock\UpdateStockRequest;
use App\Http\Resources\StockResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QueryBuilder::for(Stock::class)
          ->defaultSort('id')
          ->allowedFilters(['quantity',
                            'product_id'
                            ])
          ->allowedSorts(['quantity']);
                                                               
        $stock = $query->paginate(min($request->per_page ?? 50, 200));
                                                               
        return StockResource::collection($stock);

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        $validated = $request->only('quantity', 'product_id');
        $stock = new Stock($stock);
        $stock->save();

        return new StockResource($stock);

    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        return new StockResource($stock);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        $validated = $request->only('quantity', 'product_id');
        $stock->quantity = $validated['quantity'] ?? $stock->quantity;
        $stock->product_id = $validated['product_id'] ?? $stock->product_id;
        $stock->save();
                                                                                                                  
        return new StockResource($stock);
         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();
                            
        return response(null, 204);

    }
}
