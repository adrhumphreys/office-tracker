<?php

namespace App;

use App\Slack\Channels;
use App\Slack\Message;
use App\Slack\Service;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\BuildTask;

class MessageTask extends BuildTask
{
    private static $segment = 'message-task';
    protected $title = 'Message task';

    /**
     * @param HTTPRequest|mixed $request
     */
    public function run($request): void
    {
//        Service::askIfUserIsWorkingFromHome();
        Message::send('@adrhumphreys', 'hey');
    }

}