<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\CartProduct;
use common\models\Products;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class CartController extends Controller
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
        $cart = Cart::find()->where(['user_id' => Yii::$app->user->id])->one();
        if ($cart == null) {
            $cart = new Cart();
            $cart->user_id = Yii::$app->user->id;
            $cart->validate();
            $cart->save();
        }
        $cart_products = CartProduct::find()->where(['cart_id' => $cart->id])->all();
        $products = [];
        if (!empty($cart_products)) {
            foreach ($cart_products as $cart_product) {
                $product = Products::find()->where(['product_id' => $cart_product->id])->asArray()->one();
                $product['quantity'] = $cart_product->product_count;
                array_push($products, ($product));
            }
        }

        return $this->render('index', ['cart' => $cart, 'cart_products' => $cart_products, 'products' => $products]);
    }

    public function actionAddToCart()
    {
        // var_dump($_POST);exit;
        $product_id = htmlentities($_POST['product_id']);
        $product_quantity = htmlentities($_POST['product_quantity']);
        // var_dump($product_id);exit;
        $product = Products::find()->where(['product_id' => $product_id])->one();

        $cart = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
        if($cart == null) {
            $cart = new Cart();
            $cart->user_id = Yii::$app->user->identity->id;
            $cart->save();
        }
        $cart_product = CartProduct::find()->where(['cart_id' => $cart->id, 'product_id' => $product->product_id])->one();
        if($cart_product == null){
            $cart_product = new CartProduct();
            $cart_product->cart_id = $cart->id;
            $cart_product->product_id = $product->product_id;
        }

        // return 'true';
        if($product_quantity > $product->count){
            return 'false';
        }
        $cart_product->product_count = isset($cart_product->product_count) ? $cart_product->product_count + $product_quantity : $product_quantity;
        if($cart_product->product_count > $product->count){
            return 'false';
        }
        if($cart_product->save()){
            return 'true';
        }
    }
}
