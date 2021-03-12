<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Repositories\WalletRepository;

class WalletService
{
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

        $userSource = $transaction->from();
        $userTarget = $transaction->to();
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
        return true;
    }
}
