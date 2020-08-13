<?php

namespace App;

use SilverStripe\Control\Director;

class Logger
{
    public static function log(string $message): void
    {
        $newLine = Director::is_cli() ? PHP_EOL : '<br>';

        echo $message . $newLine;
    }
}
