<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsApiTest extends TestCase
{
    use RefreshDatabase;

    public function testProductList()
    {
        // create products with quantity greater than 1
        factory(Product::class, 7)->create([
            'quantity' => rand(2, 8),
        ]);

        // create products with quantity 0 or 1
        factory(Product::class, 4)->create([
            'quantity' => rand(0, 1),
        ]);

        // should only return products with quantity > 1
        $this->getJson(route('products.index'))
            ->assertStatus(200)
            ->assertJsonCount(7, 'data');
    }

    public function testProductDetail()
    {
        $product = factory(Product::class)->create([
            'name' => 'test name',
            'quantity' => 11,
            'dimensions' => [
                'weight' => 11.0,
                'length' => 10.0,
                'width' => 10.2,
            ],
        ]);

        $this->getJson(route('products.show', $product->id))
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => 'test name',
                    'quantity' => 11,
                    'dimensions' => [
                        'weight' => 11.0,
                        'length' => 10.0,
                        'width' => 10.2,
                    ],
                ]
            ]);
    }

    public function testProductUpdate()
    {
        $product = factory(Product::class)->create([
            'quantity' => 0,
        ]);

        $this->putJson(route('products.update', $product->id))
            ->assertJsonValidationErrors(['quantity']);

        $this->putJson(route('products.update', $product->id), [
            'quantity' => 9
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'quantity' => 9,
                ],
            ]);

        // check in database, quantity should be updated to 9
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity' => 9,
        ]);
    }
}
