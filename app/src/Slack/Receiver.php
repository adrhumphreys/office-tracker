<?php

namespace App\Slack;

use App\Action;
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

        // Always record the actions
        Action::create([
            'PostContent' => var_export($datum, true)
        ])->write();

        if (!isset($datum['actions'])) {
            //yikes
            return;
        }

        // You never know, maybe slack will send two actions for the one user :shrug:
        foreach ($datum['actions'] as $action) {
            if (in_array($action['action_id'], UserState::STATES)) {
                $userState = UserState::create();
                $userState->UserID = $datum['user']['id'];
                $userState->Name = $datum['user']['name'];
                $userState->Username = $datum['user']['username'];
                $userState->State = $action['action_id'];
                $userState->write();

                Service::sayThanks($userState->Username, $action['action_id']);
            }
        }

    }

}