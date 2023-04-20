<?php

$subtotal = 0.0;
$shipping = 0.0

?>

<div class="container p-5 m-0">
    <div class="row">
        <div class="col-md-8">
            <h2>Your Cart</h2>
            <ul class="list-group">
                <?php foreach($products as $product){ 
                    $subtotal += $product['price'] * $product['quantity'] ?>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="https://via.placeholder.com/150" alt="Product image">
                            </div>
                            <div class="col-md-8">
                                <h4 class="list-group-item-heading"><?= $product['product_name'] ?></h4>
                                <p class="list-group-item-text"><?= $product['description'] ?></p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="list-group-item-text">Quantity: <?= $product['quantity'] ?></p>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <p class="list-group-item-text">$<?= $product['price'] * $product['quantity'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php } ?>

                <!-- Repeat this li element for each product in the cart -->
            </ul>
        </div>
        <div class="col-md-4">
            <h2>Summary</h2>
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="list-group-item-text">Subtotal:</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="list-group-item-text">$<?= $subtotal ?></p>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="list-group-item-text">Shipping:</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="list-group-item-text">$<?= $shipping ?></p>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="list-group-item-text">Total:</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="list-group-item-text">$<?= $subtotal + $shipping ?></p>
                        </div>
                    </div>
                </li>
            </ul>
            <a href="#" class="btn btn-primary btn-block mt-5">Checkout</a>
        </div>
    </div>
</div>