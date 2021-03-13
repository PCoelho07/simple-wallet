<?php

return [
    'default' => env('TRANSACTION_AUTHORIZER', 'custom_authorizer'),


    'drivers' => [
        'custom_authorizer' => [
            'class' => 'Default',
            'options' => []
        ]
    ],
];
