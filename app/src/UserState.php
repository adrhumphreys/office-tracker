<?php

namespace App;

use SilverStripe\ORM\DataObject;

/**
 * @property int UserID
 * @property string State
 */
class UserState extends DataObject
{
    public const WORK_FROM_HOME = 'record_work_from_home';
    public const WORK_FROM_OFFICE = 'record_work_from_office';
    public const ON_LEAVE = 'record_on_leave';
    public const SICK = 'record_sick';

    public const STATES = [
        self::WORK_FROM_OFFICE,
        self::WORK_FROM_HOME,
        self::ON_LEAVE,
        self::SICK,
    ];

    private static $table_name = 'user_state';

    private static $db = [
        'State' => 'Varchar(25)'
    ];

    private static $has_one = [
        'User' => User::class,
    ];
}
