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
        return $this->productRepository->createProduct($data);
    }

    public function updateProduct(int $paymentId, array $data)
    {
        return $this->productRepository->updateProduct($paymentId, $data);
    }

    public function deleteProduct($productId)
    {
        $this->productRepository->deleteProduct($productId);
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function getProductsWithStock()
    {
        return Cache::rememberForever('ProductsWithStock', function () {
            return $this->productRepository->getProductsWithStock();
        });
    }

    public function getTotalAmount()
    {
        return $this->getProductsWithStock()->sum(function ($product) {
            return $product->price;
        });
    }

    public function clearProductsWithStockCache()
    {
        Cache::forget('ProductsWithStock');
    }

    public function getProductsById(int $id)
    {
        return $this->productRepository->getProductById($id);
    }
}
