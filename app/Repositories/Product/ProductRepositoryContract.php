<?php

namespace App\Repositories\Product;

interface ProductRepositoryContract 
{
    public function getAllProducts();
    public function getProductsWithStock();
    public function getProductById(int $id);
    public function createProduct(array $data);
    public function updateProduct(int $id, array $data);
    public function deleteProduct(int $ProductId);
 
}