<?php

namespace App\Vapourtape;

use GuzzleHttp\Client;
use SilverStripe\Core\Environment;

class Vapourtape
{
    private const ENDPOINT = 'VAPOURTAPE_END_POINT';
    private const API_KEY = 'VAPOURTAPE_API_KEY';

    public static function getUsers(): array
    {
        $client = new Client();
        $response = $client->get(self::getEndpoint(), [
            'headers' => [
                'X-Api-Key' => self::getAPIKey(),
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    private static function getEndpoint(): string
    {
        $key = Environment::getEnv(self::ENDPOINT);

        if ($key === false || !is_string($key) || strlen($key) === 0) {
            throw new \Exception(self::ENDPOINT . ' not set');
        }

        return $key;
    }

    private static function getAPIKey(): string
    {
        $key = Environment::getEnv(self::API_KEY);

        if ($key === false || !is_string($key) || strlen($key) === 0) {
            throw new \Exception(self::API_KEY . ' not set');
        }

        return $key;
    }
}
