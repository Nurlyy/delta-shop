<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Address;
use Yii;

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
        $addresses = Address::find()->where(['user_id' => Yii::$app->user->id])->all();
        return $this->renderAjax('get-account', ['type' => $type, 'addresses' => $addresses]);
    }

    public function actionSaveAddress() {
        $address = new Address();
        $address->load($_POST);
        $address->user_id = Yii::$app->user->id;
        if($address->validate()){
            if($address->save()){
                return 'true';
            }
        }
    }

    public function actionDeleteAddress(){
        $id = $_POST['id'];
        if($id == null){
            return 'incorrect id';
        }
        $address = Address::find()->where(['id' => $id])->one();
        if($address->user_id != Yii::$app->user->id){
            return 'incorrect user';
        }
        return $address->delete();
    }
}
