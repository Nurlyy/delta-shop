<?php
// var_dump($ordersProducts[21]);exit;
// foreach ($ordersProducts['18'] as $oP) {
// var_dump($oP);exit;
// }
use yii\helpers\Html;
?>

<div class="container p-5 m-0">
    <div class="row">
        <div class="col-md-12">
            <h2>Your Orders</h2>
            <div class="card card-body">
                <?php foreach ($orders as $order) { ?>
                    <ul class="list-group">
                        <?php foreach ($ordersProducts[$order->order_id] as $oP) {
                            // var_dump($oP);exit;
                            foreach ($oP['products'] as $product) {
                        ?>
                                <li class="list-group-item" style="background-color:honeydew;">
                                    <div class="row">
                                        <div class="col-md-4">
                                        <?= Html::img(isset($images[$product['product_id']]) ? "http://backend.test.localhost:8080/uploads/{$images[$product['product_id']]->path}" : "https://via.placeholder.com/150", ['class' => 'card-img']) ?>
                                        </div>
                                        <div class="col-md-8">
                                            <h4 class="list-group-item-heading"><?= $product['product_name'] ?></h4>
                                            <p class="list-group-item-text"><?= $product['description'] ?></p>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="list-group-item-text">Quantity: <?= $product['count'] ?></p>
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="list-group-item-text">Price: $<?= $product['price'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                        <?php }
                        } ?>
                    </ul>
                    <br>
                <?php } ?>
            </div>

        </div>
    </div>
</div>