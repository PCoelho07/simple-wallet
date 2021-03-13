<?php

namespace App\Modules\TransactionAuthorizer\Adapters;

use App\Modules\TransactionAuthorizer\Contracts\AuthorizerInterface;

class DefaultAuthorizer implements AuthorizerInterface
{
    public function authorize(): bool
    {
        return true;
    }
}
