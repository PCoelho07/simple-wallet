<?php

namespace App\Modules\TransactionAuthorizer\Adapters;

use App\Modules\TransactionAuthorizer\Contracts\AuthorizerInterface;

class TestAuthorizerFalse implements AuthorizerInterface
{
    public function authorize(): bool
    {
        return false;
    }
}
