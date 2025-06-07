<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RajaOngkirService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('rajaongkir.api_key');
        $this->baseUrl = config('rajaongkir.base_url');
    }

    public function getProvinces()
    {
        return $this->makeRequest('province');
    }

    public function getCities($provinceId = null)
    {
        $params = [];
        if ($provinceId) {
            $params['province'] = $provinceId;
        }
        return $this->makeRequest('city', $params);
    }

    public function getCost($origin, $destination, $weight, $courier)
    {
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ];

        return $this->makeRequest('cost', $params, 'POST');
    }

    private function makeRequest($endpoint, $params = [], $method = 'GET')
    {
        try {
            $options = [
                'headers' => [
                    'key' => $this->apiKey,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ];

            if ($method === 'GET') {
                $options['query'] = $params;
            } else {
                $options['form_params'] = $params;
            }

            $response = $this->client->request($method, $this->baseUrl . $endpoint, $options);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}
