<?php

namespace App\Services\BrasilAPI;

use GuzzleHttp\Client;

class BrasilAPIService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.brasilapi.url'),
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function searchZipCodeV1($cep)
    {
        $response = $this->client->get('/api/cep/v1/' . $cep);
        return json_decode($response->getBody(), true);
    }

    public function searchZipCodeV2($cep)
    {
        $response = $this->client->get('/api/cep/v2/' . $cep);
        return json_decode($response->getBody(), true);
    }
}
