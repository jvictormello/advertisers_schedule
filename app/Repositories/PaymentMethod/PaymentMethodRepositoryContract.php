<?php

namespace App\Repositories\PaymentMethod;

interface PaymentMethodRepositoryContract {
  public function createPaymentMethod($userId, $cardNumber, $holder, $expirationDate, $brand, $securityCode);

  public function updatePaymentMethod($paymentMethodId, $holder, $expirationDate, $brand, $securityCode);

  public function deletePaymentMethod($paymentMethodId);

  public function getAllPaymentMethods();
  
}