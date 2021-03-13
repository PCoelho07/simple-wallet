<?php

namespace App\Services\Concerns;

use App\Modules\TransactionAuthorizer\Contracts\AuthorizerInterface;
use App\Modules\TransactionAuthorizer\Manager;

trait HasTransactionAuthorizer
{
    /**
     * Get authorizer instance
     * @return AuthorizerInterface
     */
    public function transactionAuthorizer()
    {
        return Manager::make(config("transaction_authorizer.default"));
    }
}
