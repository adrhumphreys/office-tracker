<?php

namespace App;

use SilverStripe\ORM\DataObject;

/**
 * @property string PostContent
 */
class Action extends DataObject
{
    private static $table_name = 'action';

    private static $db = [
        'PostContent' => 'Text',
    ];
}