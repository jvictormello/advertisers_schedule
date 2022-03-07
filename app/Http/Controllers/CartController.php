<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\Product\ProductServiceContract;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    private $productService;

    public function __construct(ProductServiceContract $productService)
    {
        $this->productService = $productService;
    }
    public function index(): JsonResponse
    {
        return response()->json($this->productService->getProductsWithStock());
    }
}
