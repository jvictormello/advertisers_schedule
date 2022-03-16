<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepositoryContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;


class ProductService implements ProductServiceContract
{

    protected $productRepository;

    public function __construct(ProductRepositoryContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id)
    {
        $this->productRepository->delete($id);
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAll();
    }

    public function getProductsWithStock()
    {
        Cache::forget('ProductsWithStock');
        return Cache::rememberForever('ProductsWithStock', function () {
            return $this->productRepository->getWithStock();
        });
    }

    public function clearProductsWithStockCache()
    {
        Cache::forget('ProductsWithStock');
    }

    public function getTotalAmount()
    {
        return $this->getProductsWithStock()->sum(function ($product) {
            return $product->price;
        });
    }

    public function decrementProductsQuantity()
    {
        $this->productRepository->getWithStock()->map(function ($product) {
            $product->decrement('quantity');
        });
    }

    public function getProductById(int $id)
    {
        return $this->productRepository->getById($id);
    }
}
