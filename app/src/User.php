<?php

namespace App;

use SilverStripe\ORM\DataObject;

/**
 * @property string UserID
 * @property string Username
 * @property string Name
 * @property string Email
 * @property string Office
 */
class User extends DataObject
{
    private static $table_name = 'user';

    private static $db = [
        'UserID' => 'Varchar',
        'Username' => 'Varchar',
        'Name' => 'Varchar',
        'Email' => 'Varchar',
        'Office' => 'Varchar',
    ];

    private static $has_many = [
        'States' => UserState::class,
    ];

    public static function getBySlackUserID(string $userID): self
    {
        /** @var self $user */
        $user = User::get()->filter('UserID', $userID)->first();

        if ($user !== null && $user->exists()) {
            return $user;
        }

        $user = User::create();
        $user->UserID = $userID;
        $user->write();

        return $user;
    }
}
