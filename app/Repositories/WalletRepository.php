<?php

namespace App\Repositories;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletRepository
{

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
