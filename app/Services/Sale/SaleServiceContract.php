<?php

namespace App\Services\Sale;

interface SaleServiceContract
{
    public function createSale(array $data);
    public function updateSale(int $id, array $data);
    public function deleteSale(int $is);
    public function getAllSales();
    public function getSalesById(int $id);
    public function getSalesByUserId(int $id);
    

}
