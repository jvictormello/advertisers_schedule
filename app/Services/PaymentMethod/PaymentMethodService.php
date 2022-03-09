<?php

namespace App\Services\PaymentMethod;

use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;

class PaymentMethodService implements PaymentMethodServiceContract
{

    protected $paymentMethodRepository;

    public function __construct(PaymentMethodRepositoryContract $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function createPaymentMethod(array $data)
    {
        return $this->paymentMethodRepository->create($data);
    }

    public function updatePaymentMethod(int $id, array $data)
    {
        return $this->paymentMethodRepository->update($id, $data);
    }

    public function deletePaymentMethod(int $id)
    {
        $this->paymentMethodRepository->delete($id);
    }

    public function getAllPaymentMethods()
    {
        return $this->paymentMethodRepository->getAll();
    }

    public function getPaymentMethodsById(int $id)
    {
        return $this->paymentMethodRepository->getById($id);
    }
}
