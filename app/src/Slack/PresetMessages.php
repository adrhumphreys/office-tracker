<?php

namespace App\Slack;

use App\UserState;

class PresetMessages
{
    public static function askIfUserIsWorkingFromHome(): void
    {
        $channel = Channels::getID('general');

        $questionSection = [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => 'Howdy 👋, are you working from the office today?',
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
                        'text' => 'Neither :awkward-grimace:',
                    ],
                    'action_id' => UserState::THE_GREAT_UNKNOWN,
                ],
            ],
        ];

        Message::sendBlocks($channel, [
            $questionSection,
            $actions,
        ]);
    }

    public static function sayThanks(string $username, string $state): void
    {
        if ($state === UserState::WORK_FROM_OFFICE) {
            $message = <<<TEXT
Thanks for keeping us up to date, we've set you as *working from the office*.
_If this is incorrect, or you later work from home, please feel free to click the button again to correct it_
TEXT;

            Message::sendToUser($username, $message);
        }

        if ($state === UserState::WORK_FROM_HOME) {
            $message = <<<TEXT
Thanks for keeping us up to date, we've set you as *working from home*.
_If this is incorrect, or you later come into the office please click the button for in the office_
TEXT;

            Message::sendToUser($username, $message);
        }

        if ($state === UserState::THE_GREAT_UNKNOWN) {
            $message = <<<TEXT
Please manually update your status, we haven't a clue what you're doing :sad-panda:
TEXT;

            Message::sendToUser($username, $message);
        }
    }
}
