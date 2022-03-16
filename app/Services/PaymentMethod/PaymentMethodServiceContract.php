<?php

namespace App\Services\PaymentMethod;

interface PaymentMethodServiceContract
{
    public function createPaymentMethod(array $data);
    public function updatePaymentMethod(int $id, array $data);
    public function deletePaymentMethod(int $id);
    public function getAllPaymentMethods();
    public function getPaymentMethodsById(int $id);

}