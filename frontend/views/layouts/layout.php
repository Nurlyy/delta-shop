<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use common\models\CartProduct;
use common\models\Cart;
use common\models\Orders;
use common\models\OrdersProduct;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="/"><strong>Delta Shop</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                </ul>

                <?php if (!Yii::$app->user->isGuest) { ?>

                    <form class="d-flex">
                        <?php $order = Orders::find()->where(['customer_id' => Yii::$app->user->id])->one();
                        if ($order != null && OrdersProduct::find()->where(['order_id' => $order->order_id])->count() > 0) { ?>
                            <button class="button-signin btn btn-dark btn-outline-dark" style="margin-right:15px;" type="submit">
                                <i class="bi-box"></i>
                                <a class="a-signin" href="/orders/index">Заказы</a>
                            </button>
                        <?php } ?>

                        <button class="button-signup btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            <a href="/cart/" class="a-signup">Cart</a>
                            <span class="badge bg-dark text-white ms-1 rounded-pill" id="cart_count">0</span>
                        </button>

                        <div class="dropdown">
                            <a class="button-signin btn btn-dark btn-outline-dark dropdown-toggle" style="margin-left:15px;" onclick="event.preventDefault();" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-person"></i>
                                <?= Yii::$app->user->identity->username ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <?php if(Yii::$app->user->identity->status == 10) { ?><li><a class="dropdown-item" href="http://backend.test.localhost:8080/">Go to admin panel</a></li><?php } ?>
                                <li><a class="dropdown-item" href="/account/index">Profile</a></li>
                                <hr>
                                <li><a class="dropdown-item" onclick="logout()">Log Out</a></li>
                            </ul>
                        </div>
                    </form>

                <?php } else { ?>
                    <!-- <form class="d-flex"> -->
                    <button class="button-signup btn btn-outline-dark" type="submit">
                        <a class="a-signup" href="/site/signup">Зарегистрироваться</a>
                    </button>
                    <button class="button-signin btn btn-dark btn-outline-dark" style="margin-left:15px;" type="submit">
                        <a class="a-signin" href="/site/login">Войти</a>
                    </button>
                    <!-- </form> -->
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container" style="padding: 0; padding-bottom: 80px;">
        <!-- Header-->
        <!-- <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Delta Shop</h1>
                <p class="lead fw-normal text-white-50 mb-0">Welcome</p>
            </div>
        </div>
    </header> -->

        <?= $content ?>



        <!-- <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center"> -->

    </div>
    <!-- Footer-->
    <footer class="bg-dark">
        <div class="container m-3">
            <p class="m-0 text-center text-white">Copyright &copy; Delta Shop 2023 </p>
        </div>
    </footer>

    <?php $this->endBody() ?>

    <script>
        function get_cart_count() {
            $.ajax({
                url: '/api/get-cart-count',
                method: "GET",
                data: {},
                success: function(data) {
                    document.getElementById('cart_count').innerHTML = data
                }
            });
        }
        document.addEventListener("DOMContentLoaded", function() {
            get_cart_count();
        });

        function logout(){
            $.ajax({
                url: '/site/logout',
                type: "POST",
                success: function(data){
                    window.location.reload();
                },
                error: function(xhr, status, error){
                    console.log(xhr);
                }
            });
        }
    </script>
</body>

</html>
<?php $this->endPage();
