<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentMethod\PaymentMethodServiceContract;
use App\Http\Requests\PaymentMethodRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PaymentMethodController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentMethodServiceContract $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->paymentService->getAllPaymentMethods());
    }


    public function store(PaymentMethodRequest $request): JsonResponse
    {
        $paymentData = $request->validated();

        return response()->json(
            $this->paymentService->createPaymentMethod($paymentData),
            Response::HTTP_CREATED
        );
    }


    public function show($id): JsonResponse
    {
        return response()->json($this->paymentService->getPaymentMethodsById($id));
    }


    public function update($id, PaymentMethodRequest $request): JsonResponse
    {
        $data = $request->validated();

        return response()->json($this->paymentService->updatePaymentMethod($id, $request->all()));
    }


    public function destroy($id): JsonResponse
    {
        $this->paymentService->deletePaymentMethod($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
