<?php

namespace App\Services;

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

    public function create(array $attributes)
    {
        $transaction = $this->repositoryInstance->store($attributes);

        if (!$transaction) {
            return null;
        }

        $wallet = $this->walletService->transfer($transaction);

        if ($wallet) {
            $transaction->status = Transaction::SUCCESS;
            $transaction->update();
            // disptach do job de notificação
        }


        return $transaction;
    }
}
