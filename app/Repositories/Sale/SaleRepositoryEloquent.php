<?php

namespace App\Repositories\Sale;

use App\Models\Transaction;
use App\Models\SaleMethod;
use App\Repositories\Sale\SaleRepositoryContract;

class SaleRepositoryEloquent implements SaleRepositoryContract
{

    protected $sale;
    const MINIMAL_STOCK = 1;

    public function __construct(Transaction $sale)
    {
        $this->sale = $sale;
    }

    public function getAllSales()
    {
        return $this->sale->all();
    }

    public function getSaleByUserId(int $id)
    {
        return $this->sale->where('user_id', '=', $id)->get();
    }

    public function getSaleById(int $id)
    {
        return $this->sale->whereId($id)->first();
    }

    public function createSale(array $data)
    {
        return $this->sale->create($data);
    }

    public function updateSale(int $id, array $data)
    {
        return $this->sale->whereId($id)->update($data);
    }

    public function deleteSale(int $saleId)
    {
        $this->sale->destroy($saleId);
    }
}
