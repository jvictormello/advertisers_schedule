<?php

namespace App\Repositories\PaymentMethod;

use App\Models\PaymentMethod;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;

class PaymentMethodRepositoryEloquent implements PaymentMethodRepositoryContract
{

    protected $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getAllPaymentMethods()
    {
        return $this->paymentMethod->get();
    }

    public function getPaymentMethodsById(int $id)
    {
        return $this->paymentMethod->whereId($id)->first();
    }

    public function createPaymentMethod(array $data) 
    {
        return $this->paymentMethod->create($data);
    }

    public function updatePaymentMethod(int $id, array $data)
    {
        return $this->paymentMethod->whereId($id)->update($data);
    }

    public function deletePaymentMethod(int $paymentMethodId) 
    {
        $this->paymentMethod->destroy($paymentMethodId);
    }


}