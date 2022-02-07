<?php

namespace App\Repositories\PaymentMethod;

interface PaymentMethodRepositoryContract 
{
    public function getAllPaymentMethods();
    public function getPaymentMethodsById(int $id);
    public function createPaymentMethod(array $data);
    public function updatePaymentMethod(int $id, array $data);
    public function deletePaymentMethod(int $paymentMethodId);
 
}