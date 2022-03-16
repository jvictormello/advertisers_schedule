<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Product\ProductRepositoryEloquent;
use App\Repositories\Sale\SaleRepositoryContract;
use App\Repositories\Sale\SaleRepositoryEloquent;
use App\Services\Product\ProductService;
use App\Services\Sale\SaleService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     * @dataProvider sales_quantities_data_provider
     * @return void
     */
    public function geting_sales($salesQuantity)
    {
        Transaction::factory()->count($salesQuantity)->create();

        $productRepository = new ProductRepositoryEloquent(new Product());
        $productServices = new ProductService($productRepository);
        
        $saleRepository = new SaleRepositoryEloquent(new Transaction());
        $saleService = new SaleService($saleRepository, $productServices);
        $salesQuantityFounded = $saleService->getAllSales()->count();

        $this->assertEquals($salesQuantity, $salesQuantityFounded);
    }

    /**
     * @test
     * @dataProvider sales_quantities_data_provider
     * @return void
     */
    public function geting_sales_by_user_id($salesQuantity)
    {
        $userId = User::factory()->create()->id;

        Transaction::factory()->create();
        Transaction::factory()->count($salesQuantity)->create([
            'user_id' => $userId
        ]);

        $productRepository = new ProductRepositoryEloquent(new Product());
        $productServices = new ProductService($productRepository);
        
        $saleRepository = new SaleRepositoryEloquent(new Transaction());
        $saleService = new SaleService($saleRepository, $productServices);
        $salesQuantityFounded = $saleService->getSalesByUserId($userId)->count();

        $this->assertEquals($salesQuantity, $salesQuantityFounded);
    }

    public function sales_quantities_data_provider()
    {
        return [
            'Should be equals when found 0 Sales' => [
                'salesQuantity' => 0,
            ],
            'Should be equals when found 10 Sales' => [
                'salesQuantity' => 10,
            ]
        ];
    }
}
