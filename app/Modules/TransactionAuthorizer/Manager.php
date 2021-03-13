<?php

namespace App\Modules\TransactionAuthorizer;


class Manager
{
    public static function make(string $authorizer)
    {
        $studlyAuthorizer = config("transaction_authorizer.drivers.{$authorizer}.class");
        $class = "App\\Modules\\TransactionAuthorizer\\Adapters\\{$studlyAuthorizer}Authorizer";

        if (class_exists($class)) {
            return app($class);
        }
    }
}
