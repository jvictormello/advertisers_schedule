<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Repositories\Product\ProductRepositoryContract;
use App\Repositories\Product\ProductRepositoryEloquent;
use App\Services\Product\ProductService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     * @dataProvider cases_product_stock_data_provider
     * @return void
     */
    public function product_stock_validation($quantity, $expected)
    {
        Product::factory()->create([
            'quantity' => $quantity
        ]);

        $productRepository = new ProductRepositoryEloquent(new Product());
        $productService = new ProductService($productRepository);
        $productService->clearProductsWithStockCache();
        $ProductsWithStock = $productService->getProductsWithStock()->count();

        $this->assertEquals($expected, $ProductsWithStock > 0);
    }

    public function cases_product_stock_data_provider()
    {
        return [
            'Should be false when quantity is less than or equal to zero' => [
                'quantity' => 0,
                'expected' => false
            ],
            'Should be true when quantity is big than zero' => [
                'quantity' => 1,
                'expected' => true
            ],
        ];
    }

    /**
     * @test
     * @return void
     */

    public function products_list_is_cached()
    {
        Product::factory()->create();

        $productRepository = new ProductRepositoryEloquent(new Product());
        $productService = new ProductService($productRepository);
        $productService->clearProductsWithStockCache();
        $cachedQuantity = $productService->getProductsWithStock()->count();

        Product::first()->delete();

        $afterDeleteCachedQuantity = $productService->getProductsWithStock()->count();

        $this->assertEquals($afterDeleteCachedQuantity, $cachedQuantity);
    }

    /**
     * @test
     * @return void
     */

    public function clear_cached_products_list()
    {
        Product::factory()->create();

        $productRepository = new ProductRepositoryEloquent(new Product());
        $productService = new ProductService($productRepository);
        $productService->clearProductsWithStockCache();
        $cachedQuantity = $productService->getProductsWithStock()->count();

        Product::first()->delete();

        $productService->clearProductsWithStockCache();
        $afterDeleteCachedQuantity = $productService->getProductsWithStock()->count();

        $this->assertNotEquals($afterDeleteCachedQuantity, $cachedQuantity);
    }

    /**
     * @test
     * @dataProvider cases_products_prices_and_total_data_provider
     * @return void
     */
    public function product_total_amount_validation($prices, $totalAmountExpected)
    {
        foreach ($prices as $price) {
            Product::factory()->create([
                'price' => $price
            ]);
        }

        $productRepository = new ProductRepositoryEloquent(new Product());
        $productService = new ProductService($productRepository);
        $productService->clearProductsWithStockCache();
        $totalAmountCachedCart = $productService->getTotalAmount();

        $this->assertEquals($totalAmountExpected, $totalAmountCachedCart);
    }

    public function cases_products_prices_and_total_data_provider()
    {
        return [
            'Should be equals when sum integer prices' => [
                'prices' => [10, 20, 30, 40],
                'totalAmountExpected' => 100
            ],
            'Should be equals when sum float prices' => [
                'prices' => [1.1, 2.2, 3.3, 4.4],
                'totalAmountExpected' => 11
            ],
            'Should be equals when sum only one product' => [
                'prices' => [123],
                'totalAmountExpected' => 123
            ],
            'Should be equals when sum no producs' => [
                'prices' => [],
                'totalAmountExpected' => 0
            ]
        ];
    }
}
