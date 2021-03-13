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

            $payer = User::findOrFail($attributes['payer']);
            $payee = User::findOrFail($attributes['payee']);
            $value = $attributes['value'];
            $status = $attributes['status'] ?? Transaction::FAILED;

            if (!$payer->hasRole('user')) {
                throw new \Exception("This action is unauthorized.", 1);
            }

            $transaction = Transaction::create([
                'user_source_id' => $payer->id,
                'user_target_id' => $payee->id,
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
