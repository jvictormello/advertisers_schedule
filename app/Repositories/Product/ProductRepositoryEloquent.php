<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\ProductMethod;
use App\Repositories\Product\ProductRepositoryContract;

class ProductRepositoryEloquent implements ProductRepositoryContract
{

    protected $product;
    const MINIMAL_STOCK = 1;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getAllProducts()
    {
        return $this->product->paginate();
    }

    public function getProductsWithStock()
    {
        return $this->product->where('quantity', '>=', self::MINIMAL_STOCK)->get();
    }

    public function getProductById(int $id)
    {
        return $this->product->whereId($id)->first();
    }

    public function createProduct(array $data)
    {
        return $this->product->create($data);
    }

    public function updateProduct(int $id, array $data)
    {
        return $this->product->whereId($id)->update($data);
    }

    public function deleteProduct(int $productId)
    {
        $this->product->destroy($productId);
    }
}
