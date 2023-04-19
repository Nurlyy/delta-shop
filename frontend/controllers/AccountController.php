<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;


class AccountController extends Controller
{
    public $layout = 'layout';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetAccount($type){
        return $this->renderAjax('get-account', ['type' => $type]);
    }
}
