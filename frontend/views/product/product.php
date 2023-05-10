<?php

?>


<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="https://dummyimage.com/600x700/dee2e6/6c757d.jpg" alt="..." /></div>
            <div class="col-md-6">

                <h1 class="display-5 fw-bolder"><?= $product->product_name ?></h1>
                <div class="fs-5 mb-3">
                    <!-- <span class="text-decoration-line-through">$1888</span> -->
                    <span>Price: <strong> $<?= $product->price ?></strong></span>
                </div>
                <div class="fs-5 mb-3">
                    <!-- <span class="text-decoration-line-through">$1888</span> -->
                    <span>In stock: <strong><?= $product->count ?></strong> pcs.</span>
                </div>
                <div class="fs-5 mb-3">
                    <!-- <span class="text-decoration-line-through">$1888</span> -->
                    <span>Category: <strong><?= $category->category_name ?></strong> / <strong><?= $subcategory->subcategory_name ?></strong> / <strong><?= $rubrik->rubrik_name ?></strong></span>
                </div>
                <div class="fs-5 mb-3">
                    <!-- <span class="text-decoration-line-through">$1888</span> -->
                    <span>Manufacturer: <strong><?= $manufacturer->manufacturer_name ?></strong></span>
                </div>
                <p class="lead"><?= $product->description ?></p>
                <div class="d-flex">
                    <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />
                    <button onclick="add_to_cart()" class="btn btn-outline-dark flex-shrink-0" type="button">
                        <i class="bi-cart-fill me-1"></i>
                        Add to cart
                    </button>
                </div>

            </div>
            <div class="col-md-12">

                <h4 class="display-5 fw-bolder text-center">Characteristics</h4>

                <div>
                    <?php foreach($characteristics as $ch){ ?>
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-6 text-center">
                                <?= $ch->key ?>
                            </div>
                            <div class="col-6 text-center">
                                <?= $ch->value ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Related items section-->
<?php if (!empty($products)) { ?>
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Related products</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach ($products as $p) { ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo $p->product_name ?></h5>
                                    <!-- Product price-->
                                    <?php echo $p->price ?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<!-- <section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 my-5">   
        <h2 class="fw-bolder mb-4">Product Reviews</h2>
        <div class="row">
            <div class="col-md-8">
                <div class="card-deck">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Great Product!</h4>
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Posted on January 1, 2023</small>
                                <div class="rating-stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                            </div>
                            <p class="card-text">I recently bought this product and it's amazing! It does exactly what it's supposed to do and more. I highly recommend it.</p>
                            <p class="card-text"><small class="text-muted">- John Smith</small></p>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="card-title">Not Impressed</h4>
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Posted on January 2, 2023</small>
                                <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                            </div>
                            <p class="card-text">I was really disappointed with this product. It didn't live up to my expectations at all.</p>
                            <p class="card-text"><small class="text-muted">- Jane Doe</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->



<script>
    function add_to_cart() {
        quantity = $('#inputQuantity').val();
        $.ajax({
            url: '/cart/add-to-cart',
            type: 'POST',
            data: {
                product_id: <?= $product->product_id ?>,
                product_quantity: quantity
            },
            success: function(data) {
                get_cart_count();
                // console.log(data);
            }
        });
    }
</script>