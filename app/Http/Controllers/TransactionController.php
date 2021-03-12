<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\User;
use App\Services\TransactionService;

class TransactionController extends Controller
{

    protected $serviceInstance;

    public function __contruct(TransactionService $serviceInstance)
    {
        $this->serviceInstance = $serviceInstance;
    }

    public function store(StoreTransactionRequest $request)
    {
        $this->authorize('transfer', User::class);

        $attributes = $request->all();

        if ($transaction = $this->serviceInstance->create($attributes)) {
            return $this->responseSuccess($transaction);
        }

        return $this->responseFailed('store');
    }
}
