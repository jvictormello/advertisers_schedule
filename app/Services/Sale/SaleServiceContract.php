<?php

namespace App\Services\Sale;

interface SaleServiceContract
{
    public function createSale(array $data);
    public function updateSale(int $paymentId, array $data);
    public function deleteSale($SaleId);
    public function getAllSales();
    public function getSalesById(int $id);
    public function getSalesByUserId(int $id);
    

}
