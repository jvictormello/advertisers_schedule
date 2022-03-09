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

    public function getAll()
    {
        return $this->paymentMethod->get();
    }

    public function getById(int $id)
    {
        return $this->paymentMethod->whereId($id)->first();
    }

    public function create(array $data)
    {
        return $this->paymentMethod->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->paymentMethod->whereId($id)->update($data);
    }

    public function delete(int $id)
    {
        $this->paymentMethod->destroy($id);
    }
}
