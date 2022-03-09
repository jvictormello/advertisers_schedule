<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Transaction;
use App\Services\Sale\SaleServiceContract;
use Illuminate\Http\JsonResponse;

class SaleController extends Controller
{
    private $saleService;

    public function __construct(SaleServiceContract $saleService)
    {
        $this->saleService = $saleService;
    }
    public function listAllSales(): JsonResponse
    {
        return response()->json($this->saleService->getAllSales());
    }

    public function listSalesByUserId($userId): JsonResponse
    {
        return response()->json($this->saleService->getAllSales());
    }
}
