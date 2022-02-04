<?php

namespace App\Repositories\PaymentMethod;

use App\Models\PaymentMethod;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;

class PaymentMethodRepositoryEloquent implements PaymentMethodRepositoryContract {

    public function createPaymentMethod($userId, $cardNumber, $holder, $expirationDate, $securityCode, $brand) {
        return PaymentMethod::create($userId, $cardNumber, $holder, $expirationDate, $securityCode, $brand);
    }

    public function updatePaymentMethod($paymentMethodId, $holder, $expirationDate, $brand, $securityCode) {
        return PaymentMethod::whereId($paymentMethodId)->update($holder, $expirationDate, $brand, $securityCode);
    }

    public function deletePaymentMethod($paymentMethodId) {
        PaymentMethod::destroy($paymentMethodId);
    }

    public function getAllPaymentMethods() {
        return PaymentMethod::all();
    }

}