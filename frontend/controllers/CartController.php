<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\CartProduct;
use common\models\Orders;
use common\models\PaymentInfo;
use common\models\Products;
use common\models\OrdersProduct;
use Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use GuzzleHttp\Psr7\Request;
use Yii;
use yii\web\NotFoundHttpException;

class CartController extends Controller
{
    private const PAYPAL_EMAIL =  'Your PayPal Business Email';
    private const RETURN_URL =  'https://www.your-website.com/return.php';
    private const CANCEL_URL =  'https://www.your-website.com/cancel.php';
    private const NOTIFY_URL =  'https://www.your-website.com/notify.php';
    private const CURRENCY =  'USD';
    private const SANDBOX =  TRUE; // TRUE or FA';
    private const LOCAL_CERTIFICATE =  FALSE; // TRUE or F';
    protected const PAYPAL_URL = self::SANDBOX ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr";

    public $layout = 'layout';
    public $enableCsrfValidation = false;

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

        return $this->render('index', ['cart' => $cart, 'cart_products' => $cart_products, 'products' => $products, 'paypal_url' => self::PAYPAL_URL]);
    }

    public function actionAddToCart()
    {
        // var_dump($_POST);exit;
        $product_id = htmlentities($_POST['product_id']);
        $product_quantity = htmlentities($_POST['product_quantity']);
        // var_dump($product_id);exit;
        $product = Products::find()->where(['product_id' => $product_id])->one();

        $cart = Cart::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
        if ($cart == null) {
            $cart = new Cart();
            $cart->user_id = Yii::$app->user->identity->id;
            $cart->save();
        }
        $cart_product = CartProduct::find()->where(['cart_id' => $cart->id, 'product_id' => $product->product_id])->one();
        if ($cart_product == null) {
            $cart_product = new CartProduct();
            $cart_product->cart_id = $cart->id;
            $cart_product->product_id = $product->product_id;
        }

        // return 'true';
        if ($product_quantity > $product->count) {
            return 'false';
        }
        $cart_product->product_count = isset($cart_product->product_count) ? $cart_product->product_count + $product_quantity : $product_quantity;
        if ($cart_product->product_count > $product->count) {
            return 'false';
        }
        if ($cart_product->save()) {
            return 'true';
        }
    }

    public function actionCreatePaypalOrder()
    {
        $this->enableCsrfValidation = false;
        $accessToken = $this->generateAccessToken();
        $url = "https://api-m.sandbox.paypal.com/v2/checkout/orders";
        $data = array(
            'intent' => 'CAPTURE',
            'purchase_units' => array(
                array(
                    'amount' => array(
                        'currency_code' => 'USD',
                        'value' => '1.00'
                    )
                )
            )
        );
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $headers
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // $response = json_decode($response, true);

            return $response;
        }
    }

    public function actionCapturePaypalOrder()
    {
        $post_data = json_decode(file_get_contents('php://input'), true);
        $orderID = $post_data['orderID'];
        $cart = $post_data['cart'];
        if (!isset($orderID) && empty($orderID)) {
            return 'error';
        }
        $this->enableCsrfValidation = false;
        $accessToken = $this->generateAccessToken();
        $url = "https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderID}/capture";
        $headers = [
            "Content-type: application/json",
            "Authorization: Bearer {$accessToken}"
        ];
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => $headers,
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "CURL ERROR #: " . $err;
        } else {
            $db= Yii::$app->db;
            $transaction = $db->beginTransaction();
            try{
                $response = json_decode($response, true);
                if (isset($response['status'])) {
                    if ($response['status'] == "COMPLETED") {
                        $order = new Orders();
                        $order->customer_id = Yii::$app->user->identity->id;
                        $order->total_price = 0;
                        $order->currency = "USD";
                        $order->order_date = date('Y-m-d H:i:s');
                        if($order->validate()){
                            $order->save();
                        }
                        foreach ($cart as $id => $quantity) {
                            $transaction->rollBack();
                            return $quantity;
                            $product = Products::find()->where(['product_id' => $id])->one();
                            if ($quantity <= $product->count) {
                                $orders_product = new OrdersProduct();
                                $orders_product->order_id = $order->id;
                                $orders_product->product_id = $product->product_id;
                                $orders_product->product_count = $product->price * $quantity;
                                $order->total_price += $product->price * $quantity;
                                if($orders_product->validate()){
                                    $orders_product->save();
                                }
                            }
                        }
                        if($order->validate()){
                            $order->save();
                        }
                    }
                }
                $transaction->commit();
                var_dump($response);exit;
            } catch(Exception $e){
                $transaction->rollBack();
                return $e->getMessage();
            }
            
            // return $response;
        }
    }

    private function generateAccessToken()
    {
        $encoded = base64_encode("Adw_mAEAhasbOEJuqtLsd_gO12BUghQyIMtR6RMsBD2KAQeRgXfFvAP_bALcacem7_7exF3V3BYnodmG:EIcavyp_x_yaNSTKj4mCepqENNFO4fvZSGFzgxlrxubq6UHCiGDqFVYzGZjS423wYovv0vqCw2G5R213");
        $url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";

        $data = array(
            'grant_type' => 'client_credentials'
        );

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic {$encoded}",
                "Content-Type: application/x-www-form-urlencoded"
            )
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($response);
        return $json->access_token;
    }
}
