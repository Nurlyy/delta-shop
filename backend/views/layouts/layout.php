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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100 bg-light">
    <?php $this->beginBody() ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="/"><strong>Delta Shop</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                </ul>
                <form class="d-flex">

                    <button class="button-signin btn btn-dark btn-outline-dark" style="margin-left:15px;" type="submit">
                        <i class="bi-person"></i>
                        <a class="a-signin" href="/account/index"><?= Yii::$app->user->identity->username ?></a>
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container" style="padding: 0; padding-bottom: 80px;">
        <div class="container  px-4 px-lg-5 mt-5">
            <div class="row">
                <div class="col-2 card card-body">
                    <nav class="col-md-2 d-none d-md-block sidebar">
                        <div class="sidebar-sticky">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a style="text-decoration:none; color:black;" class="nav-link active" href="/">Главная</a>
                                </li>
                                <hr>
                                <li class="nav-item">
                                    <a style="text-decoration:none; color:black;" class="nav-link" href="/products">Продукты</a>
                                </li>
                                <hr>
                                <li class="nav-item">
                                    <a style="text-decoration:none; color:black;" class="nav-link" href="/orders">Заказы</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <div class="card card-body">
                        <?= $content ?>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <!-- Footer-->
    <footer class="bg-dark">
        <div class="container m-3">
            <p class="m-0 text-center text-white">Copyright &copy; Delta Shop 2023 </p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
