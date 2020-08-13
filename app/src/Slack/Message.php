<?php

namespace App\Slack;

use Psr\Http\Message\ResponseInterface;

class Message
{
    private const POST_URL = 'chat.postMessage';

    public static function send(
        string $channel,
        string $message
    ): ResponseInterface
    {
        $package = [
            'channel' => $channel,
            'text' => $message,
        ];

        return Sender::singleton()->send(self::POST_URL, $package);
    }

    public static function sendBlocks(
        string $channel,
        array $blocks
    ): ResponseInterface
    {
        $package = [
            'channel' => $channel,
            'blocks' => json_encode($blocks),
        ];

        return Sender::singleton()->send(self::POST_URL, $package);
    }

    public static function sendToUser(string $username, string $message)
    {
        $username = strpos($username, "@") === 0 ? $username : "@" . $username;
        self::send($username, $message);
    }
}