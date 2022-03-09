<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryContract;

class TransactionRepositoryEloquent implements TransactionRepositoryContract
{

    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getById(int $id)
    {
        return $this->sale->whereId($id)->first();
    }

    public function create(array $data)
    {
        return $this->transaction->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->transaction->whereId($id)->update($data);
    }

    public function delete(int $id)
    {
        $this->transaction->destroy($id);
    }

    public function getAll()
    {
        return $this->transaction->all();
    }
}
