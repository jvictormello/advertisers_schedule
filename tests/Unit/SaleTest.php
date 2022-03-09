<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Sale\SaleRepositoryContract;
use App\Repositories\Sale\SaleRepositoryEloquent;
use App\Services\Sale\SaleService;
use Faker\Generator as Faker;
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

        $productRepository = new SaleRepositoryEloquent(new Transaction());
        $productService = new SaleService($productRepository);
        $salesQauntityFounded = $productService->getAllSales()->count();

        $this->assertEquals($salesQuantity, $salesQauntityFounded);
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

        $productRepository = new SaleRepositoryEloquent(new Transaction());
        $productService = new SaleService($productRepository);
        $salesQauntityFounded = $productService->getSalesByUserId($userId)->count();

        $this->assertEquals($salesQuantity, $salesQauntityFounded);
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
