<?php

namespace App\Services;

use App\Jobs\TransferReceivedNotification;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;

class TransactionService
{
    protected $repositoryInstance;
    protected $walletService;

    public function __construct(TransactionRepository $transactionRepository, WalletService $walletService)
    {
        $this->repositoryInstance = $transactionRepository;
        $this->walletService = $walletService;
    }

    /**
     *  Create a transaction with default status FAILED and
     *  change to SUCCESS if transfer was successfull
     *
     *  @param array $attributes
     *  @return Transaction|null
     */
    public function create(array $attributes)
    {
        $transaction = $this->repositoryInstance->store($attributes);

        if (!$transaction) {
            return null;
        }

        $wallet = $this->walletService->transfer($transaction);

        if (!$wallet) {
            return null;
        }

        $transaction->status = Transaction::SUCCESS;
        $transaction->update();

        dispatch(new TransferReceivedNotification($transaction->from()->first()));

        return $transaction;
    }
}
