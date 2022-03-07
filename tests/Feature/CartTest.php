<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Repositories\Product\ProductRepositoryEloquent;
use App\Services\Product\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @test
     */
    public function get_products_cart_response()
    {
        $product = Product::factory()->create();

        $response = $this->get('api/v1/catestore/cart');

        $data = $response->getData();

        $response->assertStatus(200);

        $this->assertObjectHasAttribute('title', $data[0]);
        $this->assertObjectHasAttribute('price', $data[0]);
        $this->assertObjectHasAttribute('quantity', $data[0]);
        $this->assertObjectHasAttribute('image_url', $data[0]);
    }
}
