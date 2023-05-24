<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Orders;
use common\models\OrdersProduct;
use common\models\Products;
use common\models\Images;

class OrdersController extends Controller
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
        $orders = Orders::find()->where(['customer_id' => \Yii::$app->user->id])->all();
        $ordersProducts  = [];
        foreach ($orders as $order) {
            $ops = OrdersProduct::find()->where(['order_id' => $order->order_id])->asArray()->all();
            foreach ($ops as &$op) {
                $op['products'] = [];
            }
            $images = [];
            foreach ($ops as &$oP) {
                $product = Products::find()->where(['product_id' => $oP['product_id']])->asArray()->one();
                $product['count'] = $oP['product_count'];
                array_push($oP['products'], $product);

                $temp_images = Images::find()->where(['prod_id' => $product['product_id']])->one();
                if (!empty($temp_images)) {
                    $images[$product['product_id']] = $temp_images;
                }
            }

                

            $ordersProducts[$order->order_id] = $ops;
        }
        // $products = [];
        // foreach($ordersProducts as &$oP){
        //     $oP['products'] = [];
        // }

        // foreach($ordersProducts as &$oP){

        // }

        return $this->render('index', ['orders' => $orders, 'ordersProducts' => $ordersProducts, 'images' => $images]);
    }
}
