<?php

namespace App\Services\Sale;

use App\Repositories\Sale\SaleRepositoryContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;


class SaleService implements SaleServiceContract
{

    protected $saleRepository;

    public function __construct(SaleRepositoryContract $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function createSale(array $data)
    {
        return $this->saleRepository->createSale($data);
    }

    public function updateSale(int $paymentId, array $data)
    {
        return $this->saleRepository->updateSale($paymentId, $data);
    }

    public function deleteSale($SaleId)
    {
        $this->saleRepository->deleteSale($SaleId);
    }

    public function getAllSales()
    {
        return $this->saleRepository->getAllSales();
    }

    public function getSalesById(int $id)
    {
        return $this->saleRepository->getSaleById($id);
    }

    public function getSalesByUserId(int $id)
    {
        return $this->saleRepository->getSaleByUserId($id);
    }
}
