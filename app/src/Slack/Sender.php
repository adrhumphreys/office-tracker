<?php

namespace App\Slack;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Injector\Injectable;

class Sender
{
    use Injectable;

    private const BASE_URL = 'https://slack.com/api/';
    private const SLACK_TOKEN = 'SLACK_TOKEN';

    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => self::BASE_URL]);
    }

    public function send(string $url, array $package): ResponseInterface
    {
        $jsonBlob = json_encode($package);

        return $this->client->post($url, [
            'body' => $jsonBlob,
            'headers' => $this->getDefaultHeaders(),
        ]);
    }

    public function get(string $url, ?array $package = null)
    {
        $options = [
            'headers' => $this->getDefaultHeaders(),
        ];

        if ($package !== null) {
            $options['query'] = $package;
        }

        $response = $this->client->get($url, $options);

        $contents = $response->getBody();
        $decoded = json_decode($contents, true);

        return $decoded;
    }

    private function getDefaultHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->getToken(),
            'Content-type' => 'application/json; charset=UTF-8'
        ];
    }

    private function getToken(): ?string
    {
        $token = Environment::getEnv(self::SLACK_TOKEN);

        if ($token === false || $token === null || strlen($token) === 0) {
            throw new \Exception('SLACK_TOKEN has not been set');
        }

        return $token;
    }
}
