<?php

namespace App;

use App\Slack\Channels;
use App\Slack\Message;
use App\Slack\PresetMessages;
use App\Slack\Users;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\BuildTask;

class SyncUsers extends BuildTask
{
    private static $segment = 'sync-users';
    protected $title = 'Sync the users to send messages to';

    /**
     * @param HTTPRequest|mixed $request
     */
    public function run($request): void
    {
        $staffMembers = [
            [
                'staff_name' => 'Adrian Humphreys',
                'email' => 'adrian.humphreys@silverstripe.com',
                'office' => 'Auckland',
            ],
        ];

        foreach ($staffMembers as $staffMember) {
            $slackuser = Users::lookupByEmail($staffMember['email']);

            // Check if the staff member doesn't exist etc
            if (isset($slackuser['error'])) {
                Logger::log('Couldn\'t add ' . $staffMember['staff_name'] . ' - ' . $slackuser['error']);

                continue;
            }

            $user = User::get()->filter('email', $staffMember['email'])->first();

            if ($user === null || !$user->exists()) {
                $user = User::create();
            }

            $user->Name = $staffMember['staff_name'];
            $user->Email = $staffMember['email'];
            $user->UserID = $slackuser['user']['id'];
            $user->Username = $slackuser['user']['name'];
            $user->Office = $staffMember['office'];
            $user->write();

            Logger::log('Added user: ' . $user->Name);
        }
    }
}
