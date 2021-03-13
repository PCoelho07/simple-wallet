<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use App\Services\Concerns\HasTransactionAuthorizer;

class WalletService
{
    use HasTransactionAuthorizer;

    protected $repositoryInstance;

    public function __construct(WalletRepository $repositoryInstance)
    {
        $this->repositoryInstance = $repositoryInstance;
    }

    public function transfer(Transaction $transaction)
    {
        $hasAuthorization = $this->authorizeTransfer();

        if (!$hasAuthorization) {
            return false;
        }

        $userSource = $transaction->from()->first();
        $userTarget = $transaction->to()->first();
        $valueTransaction = $transaction->value;

        $walletUserSource = Wallet::where('user_id', $userSource->id)->first();
        $walletUserTarget = Wallet::where('user_id', $userTarget->id)->first();

        if (!$walletUserSource->canMakeTransfer($valueTransaction)) {
            return false;
        }

        return $this->repositoryInstance->transfer($walletUserSource, $walletUserTarget, $valueTransaction);
    }

    private function authorizeTransfer()
    {
        $authorizer = $this->transactionAuthorizer();

        return $authorizer->authorize();
    }
}
