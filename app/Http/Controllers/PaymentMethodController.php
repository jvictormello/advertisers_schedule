<?php

namespace App\Http\Controllers;

use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;
use App\Models\Paymentmethod;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PaymentMethodController extends Controller
{
    private PaymentMethodRepositoryContract $paymentRepository;

    public function __construct(PaymentMethodRepositoryContract $paymentRepository) {
        $this->$paymentRepository = $paymentRepository;
    }

    public function index(): JsonResponse {
        return response()->json([
            'data' => $this->$paymentRepository->getAllPaymentRepositories()
        ]);
    }

    
    public function store(Request $request): JsonResponse {
        $paymentData = $request->all();

        return response()->json([
                'data' => $this->paymentMethodRepository->createPaymentMethod($userId, $cardNumber, $holder, $expirationDate, $securityCode, $brand)
            ],
            Response::HTTP_CREATED
        );
    }

    
    public function show(PaymentMethodRepositoryContract $paymentRepository): JsonResponse {
        return response()->json([
            'data' => $this->paymentRepository->getAllPaymentMethods()
        ]);
    }


    public function update(Request $request, PaymentMethodRepositoryContract $paymentRepository): JsonResponse {
        $paymentMethodId = $request->route('id');
        $paymentData = $request->all();

        return response()->json([
                'data' => $this->paymentMethodRepository->updatePaymentMethod($userId, $cardNumber, $holder, $expirationDate, $securityCode, $brand)
            ],
        );
    }


    public function destroy(Request $request): JsonResponse {
        $paymentMethodId = $request->route('id');
        $this->paymentRepository->deletePaymentMethods($paymentMethodId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
