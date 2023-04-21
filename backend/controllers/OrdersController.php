<?php 

namespace backend\controllers;

use common\models\Orders;
use common\models\OrdersProduct;
use common\models\Products;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;

class OrdersController extends Controller{

    public $layout = 'layout';

    public function behaviors(){
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
        $orders = Orders::find()->all();
        $orderProducts = [];
        foreach($orders as $order){
            array_push($orderProducts, OrdersProduct::find()->where(['order_id'=> $order->order_id])->all());
        }
        $products = [];
        foreach($orderProducts as $orderProduct){
            array_push($products, Products::find()->where(['product_id'=> $orderProduct->product_id])->all());
        }
        return $this->render('index', ['orders' => $orders, 'orderProducts' => $orderProducts, 'products' => $products]);
    }

}