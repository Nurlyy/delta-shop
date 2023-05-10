<?php

$subtotal = 0.0;
$shipping = 0.0;
$cartProducts = [];

// var_dump($products);exit;

?>

<div class="container p-5 m-0">
    <div class="row">
        <div class="col-md-8">
            <h2>Your Cart</h2>
            <ul class="list-group">
                <?php foreach ($products as $product) {
                    $subtotal += $product['price'] * $product['quantity'];
                    $cartProducts[$product['product_id']] = $product['quantity'];
                    ?>
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
            <br>
            <script src="https://www.paypal.com/sdk/js?client-id=Adw_mAEAhasbOEJuqtLsd_gO12BUghQyIMtR6RMsBD2KAQeRgXfFvAP_bALcacem7_7exF3V3BYnodmG&currency=USD"></script>
            <div id="paypal-button-container"></div>
            <script>
                paypal.Buttons({
                    // Order is created on the server and the order id is returned
                    createOrder() {
                        return fetch("/cart/create-paypal-order", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                // use the "body" param to optionally pass additional order information
                                // like product skus and quantities
                                body: JSON.stringify({
                                    cart: <?= json_encode($cartProducts) ?>
                                }),
                            })
                            // .then((response) => console.log(response));
                            .then((response) => response.json())
                            .then((order) => order.id);
                    },

                    onApprove(data) {
                        console.log(data);
                        return $.ajax({
                            url: "/cart/capture-paypal-order",
                            type: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            data: JSON.stringify({
                                orderID: data.orderID,
                                cart: <?= json_encode($cartProducts) ?>
                            }),
                            success: function(response) {
                                // console.log(response);
                                window.location.href = "frontend.test.localhost:8080/orders/index"
                            }
                        });
                        // .success(function(response){console.log(response)});
                        // .then((orderData) => {
                        //     // Successful capture! For dev/demo purposes:
                        //     console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                        //     const transaction = orderData.purchase_units[0].payments.captures[0];
                        //     alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                        //     // When ready to go live, remove the alert and show a success message within this page. For example:
                        //     // const element = document.getElementById('paypal-button-container');
                        //     // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                        //     // Or go to another URL:  window.location.href = 'thank_you.html';
                        // });
                    }
                }).render('#paypal-button-container');
            </script>
            <!-- <a href="#" class="btn btn-primary btn-block mt-5">Checkout</a> -->
        </div>
    </div>
</div>