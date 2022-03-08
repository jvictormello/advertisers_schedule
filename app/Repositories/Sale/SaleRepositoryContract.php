<?php

namespace App\Repositories\Sale;

interface SaleRepositoryContract 
{
    public function getAllSales();
    public function getSaleById(int $id);
    public function getSaleByUserId(int $id);
    public function createSale(array $data);
    public function updateSale(int $id, array $data);
    public function deleteSale(int $SaleId);
 
}