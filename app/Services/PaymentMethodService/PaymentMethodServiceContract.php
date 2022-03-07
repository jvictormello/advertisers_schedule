<?php

namespace App\Services;

use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Response;


interface PaymentMethodService
{
    public function createPaymentMethod(array $data);
    public function updatePaymentMethod(int $paymentId, array $data);
    public function deletePaymentMethod($paymentMethodId);
    public function getAllPaymentMethods();
    public function getPaymentMethodsById(int $id);

}