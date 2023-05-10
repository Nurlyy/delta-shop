<?php 

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class OrdersController extends Controller {
    public function behaviors(){
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                'allow' => true,
                ''
            ]
        ];
    }
}