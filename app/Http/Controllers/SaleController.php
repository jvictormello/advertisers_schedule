<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\SaleRequest;
use App\Services\Sale\SaleServiceContract;
use App\Http\Resources\Sale\SaleCollection;
use Illuminate\Http\Response;

class SaleController extends Controller
{

    protected $saleService;
    protected $saleRepository;

    public function __construct(
        SaleServiceContract $saleService
    ) {
        $this->saleService = $saleService;
    }

    public function index(): JsonResponse
    {
        $response = new SaleCollection($this->saleService->getAllSales());
        return response()->json($response);
    }

    public function listCostomerSales(int $userId): JsonResponse
    {
        $response = new SaleCollection($this->saleService->getSalesByUserId($userId));
        return response()->json($response);
    }

    public function store(SaleRequest $request): JsonResponse
    {
        $data = $request->toSnakeCase();
        if($this->saleService->createSale($data)) {
            return response()->json(
                ['message' => 'Operation success'], 
                Response::HTTP_CREATED)
            ;
        }
        return response()->json(
            ['message' => 'Operation fail'], 
            response::HTTP_BAD_REQUEST
        );
    }
}