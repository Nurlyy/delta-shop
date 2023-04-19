<?php 
namespace frontend\controllers;

use yii\rest\Controller;
use yii\filters\AccessControl;

class ApiController extends Controller{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['get-account',],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ],
        ];
        return $behaviors;
    }

    public function actionGetAccount($type){
        return $type;
    }
}