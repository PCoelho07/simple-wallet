<?php

namespace App\Modules\TransactionAuthorizer\Adapters;

use App\Modules\TransactionAuthorizer\Contracts\AuthorizerInterface;
use GuzzleHttp\Client;

class DefaultAuthorizer implements AuthorizerInterface
{

    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function authorize(): bool
    {
        $url = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

        $request = $this->httpClient->get($url);
        $response = $request->getBody();

        $responseDecoded = json_decode($response, true);

        return $responseDecoded['message'] === 'Autorizado';
    }
}
