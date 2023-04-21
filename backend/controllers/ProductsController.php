<?php

namespace backend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class ProductsController extends Controller
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

    public function actionIndex(){
        return $this->render('index');
    }
}
