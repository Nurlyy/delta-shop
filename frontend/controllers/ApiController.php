<?php 
namespace frontend\controllers;

use common\models\Cart;
use common\models\CartProduct;
use yii\rest\Controller;
use yii\filters\AccessControl;
use \Yii;

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

    public function actionGetCartCount(){
        $cart = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
        if($cart == null){
            return '0';
        }
        $cart_products = CartProduct::find()->where(['cart_id' => $cart->id])->all();
        $count = 0;
        if(!empty($cart_products)){
            foreach($cart_products as $cart_product){
                $count += $cart_product->product_count;
            }
        }
        return $count;
    }
}