<?php

namespace App\Services;

use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Response;


class PaymentMethodService
{

    protected $paymentMethodRepository;

    public function __construct(PaymentMethodRepositoryContract $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function createPaymentMethod(array $data) 
    {
        return $this->paymentMethodRepository->createPaymentMethod($data);
    }

    public function updatePaymentMethod(int $paymentId, array $data)
    {
        return $this->paymentMethodRepository->updatePaymentMethod($paymentId, $data);
    }

    public function deletePaymentMethod($paymentMethodId) 
    {
        $this->paymentMethodRepository->deletePaymentMethod($paymentMethodId);
    }

    public function getAllPaymentMethods()
    {
        return $this->paymentMethodRepository->getAllPaymentMethods();
    }

    public function getPaymentMethodsById(int $id)
    {
        return $this->paymentMethodRepository->getPaymentMethodsById($id);
    }

}