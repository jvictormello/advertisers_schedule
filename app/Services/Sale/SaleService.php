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
        return $this->saleRepository->create($data);
    }

    public function updateSale(int $id, array $data)
    {
        return $this->saleRepository->update($id, $data);
    }

    public function deleteSale(int $id)
    {
        $this->saleRepository->delete($id);
    }

    public function getAllSales()
    {
        return $this->saleRepository->getAll();
    }

    public function getSalesById(int $id)
    {
        return $this->saleRepository->getById($id);
    }

    public function getSalesByUserId(int $id)
    {
        return $this->saleRepository->getByUserId($id);
    }
}
