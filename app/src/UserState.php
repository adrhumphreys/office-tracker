<?php

namespace App;

use SilverStripe\ORM\DataObject;

/**
 * @property string UserID
 * @property string Username
 * @property string Name
 * @property string State
 */
class UserState extends DataObject
{
    public const WORK_FROM_HOME = 'record_work_from_home';
    public const WORK_FROM_OFFICE = 'record_work_from_office';
    public const THE_GREAT_UNKNOWN = 'record_work_from_elsewhere';

    public const STATES = [
        self::WORK_FROM_OFFICE,
        self::WORK_FROM_HOME,
        self::THE_GREAT_UNKNOWN,
    ];

    private static $table_name = 'user_state';

    private static $db = [
        'UserID' => 'Varchar',
        'Username' => 'Varchar',
        'Name' => 'Varchar',
        'State' => 'Varchar(25)'
    ];
}