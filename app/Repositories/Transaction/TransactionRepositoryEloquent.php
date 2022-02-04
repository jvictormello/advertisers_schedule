<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryContract;

class TransactionRepositoryEloquent implements TransactionRepositoryContract {

    public function createTransaction($userId, $cardNumber, $holder, $expirationDate, $securityCode, $brand) {
        return Transaction::create($userId, $cardNumber, $holder, $expirationDate, $securityCode, $brand);
    }

    public function updateTransaction($transactionId, $holder, $expirationDate, $brand, $securityCode) {
        return Transaction::whereId($transactionId)->update($holder, $expirationDate, $brand, $securityCode);
    }

    public function deleteTransaction($transactionId) {
        Transaction::destroy($transactionId);
    }

    public function getAllTransactions() {
        return Transaction::all();
    }

}