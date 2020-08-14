<?php

namespace App\Slack;

/*
 * Not used currently, but can be handy when wanting to send a message to a channel rather than a user
 */
class Channels
{
    private const LIST_CHANNELS = 'conversations.list';

    private static $channelList;

    public static function list(): array
    {
        if (!self::$channelList) {
            self::$channelList = Sender::singleton()->get(self::LIST_CHANNELS)['channels'] ?? [];
        }

        return self::$channelList;
    }

    /*
     * Get the ID for a channel based on the normalised name
     */
    public static function getIDByNormalisedName(string $channelNameNormalised): ?string
    {
        foreach (self::list() as $channel) {
            if (isset($channel['name_normalized'])
                && $channel['name_normalized'] === $channelNameNormalised)
            {
                return $channel['id'];
            }
        }

        return null;
    }
}
