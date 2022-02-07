<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentMethodService;
use App\Http\Requests\PaymentMethodRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PaymentMethodController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentMethodService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->paymentService->getAllPaymentMethods()
        ]);
    }

    
    public function store(PaymentMethodRequest $request): JsonResponse
    {
        $paymentData = $request->validated();

        return response()->json([
                'data' => $this->paymentService->createPaymentMethod($paymentData)
            ],
            Response::HTTP_CREATED
        );
    }

    
    public function show($id): JsonResponse
    {
        return response()->json([
            'data' => $this->paymentService->getPaymentMethodsById($id)
        ]);
    }


    public function update($id, PaymentMethodRequest $request): JsonResponse
    {
        $data = $request->validated();

        return response()->json([
                'data' => $this->paymentService->updatePaymentMethod($id, $data)
            ],
        );
    }


    public function destroy($id): JsonResponse 
    {
        $this->paymentService->deletePaymentMethod($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
