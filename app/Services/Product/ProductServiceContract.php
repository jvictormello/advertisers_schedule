<?php

namespace App\Services\Product;

interface ProductServiceContract
{
    public function createProduct(array $data);
    public function updateProduct(int $paymentId, array $data);
    public function deleteProduct(int $id);
    public function getAllProducts();
    public function getProductsWithStock();
    public function getTotalAmount();
    public function clearProductsWithStockCache();
    public function decrementProductsQuantity();
    public function getProductById(int $id);

}
