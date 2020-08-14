<?php

namespace App\Slack;

use App\UserState;

class PresetMessages
{
    public static function askIfUserIsWorkingFromHome(string $username): void
    {
        $questionSection = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => '👋 Howdy, are you working from the office today?',
            ],
        ];

        $actions = [
            'type' => 'actions',
            'elements' => [
                [
                    'type' => 'button',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'Yes, I\'m in the office 🏢',
                    ],
                    'action_id' => UserState::WORK_FROM_OFFICE,
                    'style' => 'primary',
                ],
                [
                    'type' => 'button',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'No, I\'m at home 🏠',
                    ],
                    'action_id' => UserState::WORK_FROM_HOME,
                    'style' => 'danger',
                ],
                [
                    'type' => 'button',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'I\'m on leave',
                    ],
                    'action_id' => UserState::ON_LEAVE,
                ],
                [
                    'type' => 'button',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'I\'m sick',
                    ],
                    'action_id' => UserState::SICK,
                ],
            ],
        ];

        $username = strpos($username, "@") === 0 ? $username : "@" . $username;

        Message::sendBlocks($username, [
            $questionSection,
            $actions,
        ]);
    }

    public static function sayThanks(string $username, string $state): void
    {
        $username = strpos($username, "@") === 0 ? $username : "@" . $username;

        if ($state === UserState::WORK_FROM_OFFICE) {
            $message = <<<TEXT
Thanks for keeping us up to date, we've set you as *working from the office*.
_If this is incorrect, or you later work from home, please feel free to click the button again to correct it_
TEXT;
            Message::send($username, $message);
        }

        if ($state === UserState::WORK_FROM_HOME) {
            $message = <<<TEXT
Thanks for keeping us up to date, we've set you as *working from home*.
_If this is incorrect, or you later come into the office please click the button for in the office_
TEXT;
            Message::send($username, $message);
        }

        if ($state === UserState::ON_LEAVE) {
            $message = "_Have fun, we look forward to seeing you again :full_moon_with_face:_";
            Message::send($username, $message);
        }

        if ($state === UserState::SICK) {
            $message = "_Take care, hopefully you're feeling better soon :heart:_";

            Message::send($username, $message);

            $channel = Channels::getIDByNormalisedName('office-tracker');
            if ($channel !== null) {
                $message = ':wave:' . $username . ' is on sick leave today';

                Message::send($channel, $message);
            }
        }
    }
}
