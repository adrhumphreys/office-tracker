<?php

namespace App\Slack;

class Users
{
    private const USERS_LIST = 'users.list';
    private const USERS_LOOKUP_BY_EMAIL = 'users.lookupByEmail';

    public static function list(): ?array
    {
        return Sender::singleton()->get(self::USERS_LIST);
    }

    public static function lookupByEmail(string $email): ?array
    {
        return Sender::singleton()->get(self::USERS_LOOKUP_BY_EMAIL, ['email' => $email]);
    }
}
