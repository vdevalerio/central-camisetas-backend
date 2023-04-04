<?php

namespace Tests\Unit\Product;

use App\Http\Controllers\Api\Admin\ProductController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\QueryBuilder\AllowedFilter;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'price',
                    'size',
                    'type',
                    'type_formatted',
                    'model',
                    'tissue',
                    'color',
                    'pocket',
                    'collar',
                    'collar_formatted',
                    'cuff',
                    'cuff_formatted',
                    'vivo',
                    'faixa',
                    'faixa_formatted',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function testIndexFilters()
    {
        $filters = (new Product)->getAllowedFilters();
        $user = User::factory()->create();
        $products = Product::factory(3)->create();

        $minPriceProduct = $products->min('price');
        $maxPriceProduct = $products->max('price');

        foreach($filters as $filter)
        {
            foreach($products as $product)
            {
                if($filter instanceof AllowedFilter)
                {
                    $prices = (string) $minPriceProduct . ',' . (string) $maxPriceProduct;

                    $response = $this->actingAs($user)->json('GET', '/api/products?filter[price_between][]=' . $prices);
                }
                else
                {
                    $response = $this->actingAs($user)->json('GET', '/api/products?filter[' . $filter . ']=' . $product[$filter]);
                }

                $response->assertOk()
                    ->assertJsonStructure([
                        'data' => [
                            '*' => [
                                'id',
                                'name',
                                'price',
                                'size',
                                'type',
                                'type_formatted',
                                'model',
                                'tissue',
                                'color',
                                'pocket',
                                'collar',
                                'collar_formatted',
                                'cuff',
                                'cuff_formatted',
                                'vivo',
                                'faixa',
                                'faixa_formatted',
                                'created_at',
                                'updated_at',
                            ]
                        ]
                    ])
                    ->assertJsonFragment([
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'size' => $product->size,
                        'type' => (string) $product->type,
                        'type_formatted' => $product->type_formatted,
                        'model' => $product->model,
                        'tissue' => $product->tissue,
                        'color' => $product->color,
                        'pocket' => $product->pocket,
                        'collar' => (string) $product->collar,
                        'collar_formatted' => $product->collar_formatted,
                        'cuff' => (string) $product->cuff,
                        'cuff_formatted' => $product->cuff_formatted,
                        'vivo' => $product->vivo,
                        'faixa' => (string) $product->faixa,
                        'faixa_formatted' => $product->faixa_formatted,
                        'created_at' => $product->created_at->toISOString(),
                        'updated_at' => $product->updated_at->toISOString(),
                    ]);

                $notExpectedData = [];

                foreach($products as $notExpected)
                {
                    if($product != $notExpected)
                    {
                        $notExpectedData[] = [
                            'id' => $notExpected->id,
                            'name' => $notExpected->name,
                            'price' => $notExpected->price,
                            'size' => $notExpected->size,
                            'type' => (string) $notExpected->type,
                            'type_formatted' => $notExpected->type_formatted,
                            'model' => $notExpected->model,
                            'tissue' => $notExpected->tissue,
                            'color' => $notExpected->color,
                            'pocket' => $notExpected->pocket,
                            'collar' => (string) $notExpected->collar,
                            'collar_formatted' => $notExpected->collar_formatted,
                            'cuff' => (string) $notExpected->cuff,
                            'cuff_formatted' => $notExpected->cuff_formatted,
                            'vivo' => $notExpected->vivo,
                            'faixa' => (string) $notExpected->faixa,
                            'faixa_formatted' => $notExpected->faixa_formatted,
                            'created_at' => $notExpected->created_at->toISOString(),
                            'updated_at' => $notExpected->updated_at->toISOString(),
                        ];
                    }
                }

                $response->assertOk()->assertJsonMissing(['data' => $notExpectedData]);
            }
        }

    }
}
