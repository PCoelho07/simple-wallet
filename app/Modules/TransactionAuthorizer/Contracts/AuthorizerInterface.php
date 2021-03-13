<?php

namespace App\Modules\TransactionAuthorizer\Contracts;

interface AuthorizerInterface
{
    public function authorize(): bool;
}
