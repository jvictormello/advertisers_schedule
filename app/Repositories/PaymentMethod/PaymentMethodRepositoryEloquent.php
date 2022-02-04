<?php

namespace App\Repositories\PaymentMethod;

use App\Models\PaymentMethod;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;

class PaymentMethodRepositoryEloquent implements PaymentMethodRepositoryContract 
{

    private $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function createPaymentMethod($userId, $cardNumber, $holder, $expirationDate, $securityCode, $brand) 
    {
        return $this->paymentMethod->create($userId, $cardNumber, $holder, $expirationDate, $securityCode, $brand);
    }

    public function updatePaymentMethod($paymentMethodId, $holder, $expirationDate, $brand, $securityCode) 
    {
        return $this->paymentMethod->($paymentMethodId)->update($holder, $expirationDate, $brand, $securityCode);
    }

    public function deletePaymentMethod($paymentMethodId) 
    {
        $this->paymentMethod->($paymentMethodId);
    }

    public function getAllPaymentMethods()
    {
        return $this->paymentMethod->all();
    }

}