<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use App\Modules\TransactionAuthorizer\Contracts\AuthorizerInterface;

class WalletService
{
    protected $repositoryInstance;
    protected $authorizer;

    public function __construct(WalletRepository $repositoryInstance, AuthorizerInterface $authorizer)
    {
        $this->repositoryInstance = $repositoryInstance;
        $this->authorizer = $authorizer;
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
        return $this->authorizer->authorize();
    }
}
