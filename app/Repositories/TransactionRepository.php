<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{

    public function store(array $attributes)
    {
        DB::beginTransaction();
        try {

            $payer = User::firstOrFail($attributes['payer']);
            $payee = User::firstOrFail($attributes['payee']);
            $value = $attributes['value'];
            $status = $attributes['status'] ?? Transaction::FAILED;

            $transaction = Transaction::create([
                'user_source' => $payer->id,
                'user_target' => $payee->id,
                'value' => $value,
                'status' => $status
            ]);

            DB::commit();

            return $transaction;
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return null;
    }
}
