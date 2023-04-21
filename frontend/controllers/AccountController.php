<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Address;
use Yii;
use common\models\User;
use DateTime;

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

    public function actionGetAccount($type)
    {
        $addresses = Address::find()->where(['user_id' => Yii::$app->user->id])->all();
        return $this->renderAjax('get-account', ['type' => $type, 'addresses' => $addresses]);
    }

    public function actionSaveAddress()
    {
        if (isset($_POST['Address']['id'])) {
            $address = Address::find()->where(['id' => $_POST['Address']['id']])->one();
            if ($address->user_id != Yii::$app->user->id) {
                return "incorrect user";
            }
        } else {
            $address = new Address();
            $address->user_id = Yii::$app->user->id;
        }

        if (isset($_POST['Address']['country'])) {
            $address->country = $_POST['Address']['country'];
        }
        if (isset($_POST['Address']['state'])) {
            $address->state = $_POST['Address']['state'];
        }
        if (isset($_POST['Address']['city'])) {
            $address->city = $_POST['Address']['city'];
        }
        if (isset($_POST['Address']['street'])) {
            $address->street = $_POST['Address']['street'];
        }
        if (isset($_POST['Address']['building'])) {
            $address->building = $_POST['Address']['building'];
        }
        if ($address->validate()) {
            if ($address->save()) {
                return 'true';
            }
        }
    }

    public function actionDeleteAddress()
    {
        $id = $_POST['id'];
        if ($id == null) {
            return 'incorrect id';
        }
        $address = Address::find()->where(['id' => $id])->one();
        if ($address->user_id != Yii::$app->user->id) {
            return 'incorrect user';
        }
        return $address->delete();
    }

    public function actionChangeName()
    {
        if ($this->request->post()) {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                if (Yii::$app->user->identity->id = $id) {
                    $user = User::find()->where(['id' => $id])->one();
                    if(isset($_POST['date_of_birth'])){
                        $dob = DateTime::createFromFormat('Y-m-d', $_POST['date_of_birth']);
                        if($dob == null){
                            return 'false';
                        }
                        $user->birth_date = $dob->format('Y-m-d');
                    }
                    if (isset($_POST['username'])) {
                        $user->username = htmlentities($_POST['username']);
                    }
                    if(isset($_POST['sex'])){
                        // return $user->birth_date;
                        $user->sex = htmlentities($_POST['sex']);
                    }
                    if($user->validate()){
                        return $user->save();
                    }
                }
            }
        }
    }

    public function actionChangeEmail(){}

    public function actionChangePassword(){}
    
    public function actionChangePhoneNumber(){}
}
