<?php

namespace App\Slack;

class Channels
{
    private const LIST_CHANNELS = 'conversations.list';

    private static $channelList;

    public static function list(): array
    {
        if (!self::$channelList) {
            self::$channelList = Sender::singleton()->get(self::LIST_CHANNELS)->channels ?? [];
        }

        return self::$channelList;
    }

    public static function getID(string $channelNameNormalised): ?string
    {
        foreach (self::list() as $channel) {
            if (isset($channel->name_normalized)
                && $channel->name_normalized === $channelNameNormalised)
            {
                return $channel->id;
            }
        }

        return null;
    }
}