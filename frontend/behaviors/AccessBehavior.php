<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\web\Controller;
use yii\filters\AccessControl;

class AccessBehavior extends Behavior
{
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        $accessControl = new AccessControl([
            'rules' => [
                [
                    'allow' => false,
                    'roles' => ['?'], // Deny access to unauthorized users
                ],
            ],
        ]);

        return $accessControl->beforeAction($event);
    }
}
