<?php

namespace App\Slack;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use SilverStripe\Core\Injector\Injectable;

class Sender
{
    use Injectable;

    private const BASE_URL = 'https://slack.com/api/';

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

    public function get(string $url)
    {
        $response = $this->client->get($url, [
            'headers' => $this->getDefaultHeaders(),
        ]);
        $contents = $response->getBody();
        $decoded = json_decode($contents);

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
        return 'xoxb-1323770295600-1299945084466-DkVmmBRgDagQZXPqe3kQTmnD';
    }
}
