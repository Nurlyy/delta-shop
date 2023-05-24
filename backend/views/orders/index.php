<?php

use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Html;

?>
<div style="display:flex; flex-direction:row; justify-content:space-between;">
    <h2>Orders</h2>
</div>
<nav aria-label="Page navigation example">
    <?php
    foreach ($orders as $order) {
    ?>
        <div class="card card-body">
            <div class="card-header">
                <p>Заказы пользователя <strong><?= $users[$order->customer_id]->id ?>:<?= $users[$order->customer_id]->username ?></strong></p>
                <p>Сумма <strong>$<?= $order->total_price ?></strong></p>
            </div>
            <?php
            foreach ($orderProducts as $_op) {
                foreach ($_op as $op) {
                    if ($op->order_id == $order->order_id) {
            ?>
                        <li class="list-group-item" style="background-color:honeydew;">
                            <div class="row">
                                <div class="col-md-4">
                                    <?= Html::img(isset($images[$op->product_id]) ? "http://backend.test.localhost:8080/uploads/{$images[$op->product_id]->path}" : "https://via.placeholder.com/150", ['class' => 'card-img']) ?>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="list-group-item-heading"><?= $products[$op->product_id]->product_name ?></h4>
                                    <p class="list-group-item-text"><?= $products[$op->product_id]->description ?></p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="list-group-item-text">Quantity: <?= $op->product_count ?></p>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="list-group-item-text">Price: $<?= $products[$op->product_id]->price ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

            <?php
                    }
                }
            } ?>
        </div>
    <?php
    } ?>
</nav>