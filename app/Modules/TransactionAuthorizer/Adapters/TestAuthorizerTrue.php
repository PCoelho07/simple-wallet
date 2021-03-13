<?php

namespace App\Modules\TransactionAuthorizer\Adapters;

use App\Modules\TransactionAuthorizer\Contracts\AuthorizerInterface;

class TestAuthorizerTrue implements AuthorizerInterface
{
    public function authorize(): bool
    {
        return true;
    }
}
