<?php

namespace App\Services\PaymentMethod;

interface PaymentMethodServiceContract
{
    public function createPaymentMethod(array $data);
    public function updatePaymentMethod(int $paymentId, array $data);
    public function deletePaymentMethod($paymentMethodId);
    public function getAllPaymentMethods();
    public function getPaymentMethodsById(int $id);

}