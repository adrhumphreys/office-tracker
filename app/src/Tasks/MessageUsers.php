<?php

namespace App\Tasks;

use App\Slack\PresetMessages;
use App\User;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\BuildTask;

class MessageUsers extends BuildTask
{
    private static $segment = 'message-users';
    protected $title = 'Send daily message to users';

    /**
     * @param HTTPRequest|mixed $request
     */
    public function run($request): void
    {
        /** @var User $user */
        foreach (User::get() as $user) {
            PresetMessages::askIfUserIsWorkingFromHome($user->Username);
        }
    }
}
