<?php

namespace App\StichData;

use SilverStripe\Core\Environment;
use Sminnee\StitchData\StitchApi;

class StichData
{
    private const CLIENT_ID = 'STITCHDATA_CLIENT_ID';
    private const ACCESS_TOKEN = 'STITCHDATA_ACCESS_TOKEN';
    private const TABLE_NAME = 'staff_location_records';

    public static function recordForUser(string $email, string $time, string $state): void
    {
        $clientID = Environment::getEnv(self::CLIENT_ID);
        $accessToken = Environment::getEnv(self::ACCESS_TOKEN);

        if ($clientID === false || $clientID === null || strlen($clientID) === 0) {
            throw new \Exception('STITCHDATA_CLIENT_ID has not been set');
        }

        if ($accessToken === false || $accessToken === null || strlen($accessToken) === 0) {
            throw new \Exception('ACCESS_TOKEN has not been set');
        }

        $api = new StitchApi($clientID, $accessToken);

        $api->validate();

        $api->pushRecords(
            self::TABLE_NAME,
            ['email', 'time', 'state'],
            [[
                'email' => $email,
                'time' => $time,
                'state' => $state,
            ]]
        );
    }
}
