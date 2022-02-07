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
        $paymentData = $request->all();

        return response()->json([
                'data' => $this->paymentService->createPaymentMethod($paymentData)
            ],
            Response::HTTP_CREATED
        );
    }

    
    public function show(Request $request): JsonResponse
    {
        $paymentId = $request->route('id');
        return response()->json([
            'data' => $this->paymentService->getPaymentMethodsById($paymentId)
        ]);
    }


    public function update(Request $request): JsonResponse
    {
        $paymentId = $request->route('id');
        $data = $request->only([
            'card_number',
            'holder',
            'expiration_date',
            'security_code',
            'brand'
        ]);

        return response()->json([
                'data' => $this->paymentService->updatePaymentMethod($paymentId, $data),
                'id' => $paymentId
            ],
        );
    }


    public function destroy(Request $request): JsonResponse 
    {
        $paymentMethodId = $request->route('id');
        $this->paymentService->deletePaymentMethod($paymentMethodId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
