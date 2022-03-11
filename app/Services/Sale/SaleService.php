<?php

namespace App\Services\Sale;

use App\Jobs\DecrementProductStockJob;
use App\Jobs\LowStockJob;
use App\Models\Transaction;
use App\Services\Sale\SaleServiceContract;
use App\Repositories\Sale\SaleRepositoryContract;
use App\Repositories\Sale\SaleRepositoryEloquent;
use App\Services\Product\ProductServiceContract;

class SaleService implements SaleServiceContract
{

    protected $productService;
    protected $saleRepository;

    public function __construct(
        SaleRepositoryContract $saleRepository,
        ProductServiceContract $productService
    ) {
        $this->productService = $productService;
        $this->saleRepository = $saleRepository;
    }

    public function getAllSales()
    {
        return $this->saleRepository->getAll();
    }

    public function getSalesByUserId(int $id)
    {
        return $this->saleRepository->getByUserId($id);
    }

    public function getSaleById(int $id)
    {
        return $this->saleRepository->getById($id);
    }

    public function createSale(array $data)
    {
        $data['total_amount'] = $this->productService->getTotalAmount();

        if ($this->saleRepository->create($data)) {
            $this->productService->clearProductsWithStockCache();
            DecrementProductStockJob::dispatch()->onQueue('product');
            return true;
        }
        return false;
    }

    public function updateSale(int $id, array $data)
    {
        return $this->saleRepository->update($id, $data);
    }

    public function deleteSale(int $id)
    {
        $this->saleRepository->delete($id);
    }
}
