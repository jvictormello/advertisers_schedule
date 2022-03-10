<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentMethod\PaymentMethodServiceContract;
use App\Http\Requests\PaymentMethodRequest;
use App\Http\Resources\Product\PaymentMethodCollection;
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
        $response = new PaymentMethodCollection(
            $this->paymentService->getAllPaymentMethods()
        );
        return response()->json($response);
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
        $response = new PaymentMethodCollection(
            $this->paymentService->getPaymentMethodsById($id)
        );
        return response()->json($response);
    }


    public function update($id, PaymentMethodRequest $request): JsonResponse
    {
        $data = $request->validated();

        return response()->json(
            $this->paymentService->updatePaymentMethod($id, $request->all())
        );
    }


    public function destroy($id): JsonResponse
    {
        $this->paymentService->deletePaymentMethod($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
