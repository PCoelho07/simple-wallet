<?php

namespace App\Repositories;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletRepository
{
    /**
     * Transfer money between two wallets
     * @param Wallet $walletSource
     * @param Wallet $walletTarget
     * @param float $value
     *
     * @return bool
     */
    public function transfer(Wallet $walletSource, Wallet $walletTarget, $value)
    {
        DB::beginTransaction();

        try {
            $walletSource->debit($value);
            $walletTarget->credit($value);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return false;
    }
}
