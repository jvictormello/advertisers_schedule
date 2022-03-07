<?php

namespace App\Services\Product;

interface ProductServiceContract
{
    public function createProduct(array $data);
    public function updateProduct(int $paymentId, array $data);
    public function deleteProduct($productId);
    public function getAllProducts();
    public function getProductsWithStock();
    public function clearProductsWithStockCache();
    public function getProductsById(int $id);

}
