<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientRequest
{
    private HttpClientInterface $client;
    private string $endpoint;

    public function __construct(
        string $endpoint
    )
    {
        $this->endpoint = $endpoint;
        $this->client = HttpClient::create();
    }

    public function makeDataPartRequest(string $requestType, $formData)
    {
        try {
            return $this->client->request($requestType, $this->endpoint, [
                'headers' => $formData->getPreparedHeaders()->toArray(),
                'body' => $formData->bodyToIterable()
            ])->toArray();
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'not_found',
                'message' => 'problems with our services',
                'result' => null
            ]);
            die();
        }
    }

}