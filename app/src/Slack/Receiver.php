<?php

namespace App\Slack;

use App\Action;
use App\StichData\StichData;
use App\User;
use App\UserState;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;

class Receiver extends Controller
{
    private static $allowed_actions = [
        'actions'
    ];

    public function actions(HTTPRequest $request)
    {
        $datum = json_decode($request->postVar('payload'), true);

        if (!isset($datum['actions'])) {
            //yikes
            return;
        }

        // You never know, maybe slack will send two actions for the one user :shrug:
        foreach ($datum['actions'] as $action) {
            if (in_array($action['action_id'], UserState::STATES)) {
                $user = User::getBySlackUserID($datum['user']['id'] ?? '-1');

                $userState = UserState::create();
                $userState->UserID = $user->ID;
                $userState->State = $action['action_id'];
                $userState->write();

                PresetMessages::sayThanks($user->Username, $action['action_id']);

//                StichData::recordForUser($);
            }
        }
    }
}
