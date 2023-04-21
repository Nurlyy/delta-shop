<?php 

?>


<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="https://dummyimage.com/600x700/dee2e6/6c757d.jpg" alt="..." /></div>
            <div class="col-md-6">

                <h1 class="display-5 fw-bolder"><?= $product->product_name ?></h1>
                <div class="fs-5 mb-5">
                    <!-- <span class="text-decoration-line-through">$1888</span> -->
                    <span>$<?= $product->price ?></span>
                </div>
                <div class="fs-5 mb-5">
                    <!-- <span class="text-decoration-line-through">$1888</span> -->
                    <span>In stock: <?= $product->count ?> pcs.</span>
                </div>
                <p class="lead"><?= $product->description ?></p>

            </div>
        </div>
    </div>
</section>