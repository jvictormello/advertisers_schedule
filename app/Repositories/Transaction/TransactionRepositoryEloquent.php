<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryContract;

class TransactionRepositoryEloquent implements TransactionRepositoryContract
{

    private $transaction;

    public function __construct(Transaction $paymentMethod)
    {
        $this->transaction = $transaction;
    }

    public function createTransaction($userId, $cardNumber, $holder, $expirationDate, $securityCode, $brand) 
    {
        return $this->transaction->create($userId, $cardNumber, $holder, $expirationDate, $securityCode, $brand);
    }

    public function updateTransaction($transactionId, $holder, $expirationDate, $brand, $securityCode) 
    {
        return $this->transaction->whereId($transactionId)->update($holder, $expirationDate, $brand, $securityCode);
    }

    public function deleteTransaction($transactionId) 
    {
        $this->transaction->destroy($transactionId);
    }

    public function getAllTransactions() 
    {
        return $this->transaction->all();
    }

}