<?php

namespace App;

use App\Slack\Channels;
use App\Slack\Message;
use App\Slack\PresetMessages;
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
        PresetMessages::askIfUserIsWorkingFromHome();
//        Message::send('@adrian.humphreys', '*hey* buddy');
    }

}
