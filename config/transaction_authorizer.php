<?php

return [
    'default' => env('TRANSACTION_AUTHORIZER', 'custom_authorizer'),


    'drivers' => [
        'custom_authorizer' => [
            'class' => 'DefaultAuthorizer',
            'options' => []
        ],


        /**
         * Authorizers to use only when making tests
         */
        'test_authorizer_false' => [
            'class' => 'TestAuthorizerFalse',
            'options' => []
        ],
        'test_authorizer_true' => [
            'class' => 'TestAuthorizerTrue',
            'options' => []
        ],
    ],
];
