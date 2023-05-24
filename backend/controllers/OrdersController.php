<?php 

namespace backend\controllers;

use common\models\Orders;
use common\models\OrdersProduct;
use common\models\Products;
use common\models\User;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Images;

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
        $users = [];
        $orderProducts = [];
        foreach($orders as $order){
            array_push($orderProducts, OrdersProduct::find()->where(['order_id'=> $order->order_id])->all());
            array_push($users, User::find()->where(['id' => $order->customer_id])->one());
        }
        $products = [];
        foreach($orderProducts as $ordersProduct){
            foreach($ordersProduct as $orderProduct){
                array_push($products, Products::find()->where(['product_id'=> $orderProduct->product_id])->one());
            }
        }
        $t_products = [];
        foreach($products as $p){
            $t_products[$p->product_id] = $p;
        }
        $products = $t_products;

        $images = [];
        foreach($products as $product) {
            $temp_images = Images::find()->where(['prod_id' => $product->product_id])->one();
            if(!empty($temp_images)){
                $images[$product->product_id] = $temp_images;
            }
        }

        $t_users = [];
        foreach($users as $user){
            $t_users[$user->id] = $user;
        }
        $users = $t_users;
        // var_dump($products);exit;
        return $this->render('index', ['orders' => $orders, 'images' => $images, 'orderProducts' => $orderProducts, 'products' => $products, 'users' => $users]);
    }

}