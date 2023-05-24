<?php

/** @var yii\web\View $this */

use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Html;

$this->title = 'My Yii Application';
// var_dump($categories);exit;
?>
<div class="container px-4 px-lg-5 my-5 ">

    <div class="dropdown" data-bs-auto-close="false">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            Категории
        </button>

        <ul class="dropdown-menu" data-bs-auto-close="false" aria-labelledby="dropdownMenuButton1" id="AppDropDownId">
            <?php foreach ($categories as $category) { ?>

                <li data-bs-auto-close="false">
                    <div class="btn-group dropend dropdown-item" data-bs-auto-close="false">
                        <a style="text-decoration:none; color:black; margin-right:7px;" type="button" href="/categories/<?= $category->category_id ?>">
                            <?= $category->category_name ?>
                        </a>
                        <a style="background-color:lightgray; border-radius:5px; width:30px; text-align:center;" type="button" id="dropdownMenuButton12" data-bs-auto-close="false" class="dropdown-item dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            
                        </a>
                        <ul class="dropdown-menu" data-bs-auto-close="false" data-bs-auto-close="false" aria-labelledby="dropdownMenuButton12" id="AppDropDownId2">
                            <?php foreach ($subcategories as $subcategory) {
                                if ($subcategory->category_id == $category->category_id) { ?>
                                    <li data-bs-auto-close="false">
                                        <div class="btn-group dropend dropdown-item" data-bs-auto-close="false">
                                            <a style="text-decoration:none; color:black; margin-right:7px;" type="button" href="/categories/<?= $category->category_id ?>/<?= $subcategory->subcategory_id ?>">
                                                <?= $subcategory->subcategory_name ?>
                                            </a>
                                            <a style="background-color:lightgray; border-radius:5px; width:30px; text-align:center;" type="button" data-bs-auto-close="false" class="dropdown-item dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                
                                            </a>
                                            <ul class="dropdown-menu">
                                                <?php foreach ($rubrics as $rubric) {
                                                    if ($rubric->subcategory_id == $subcategory->subcategory_id) { ?>
                                                        <li>
                                                            <a style="text-decoration:none; color:black; margin-right:7px;" class="dropdown-item" href="/categories/<?= $category->category_id ?>/<?= $subcategory->subcategory_id ?>/<?= $rubric->rubrik_id ?>">
                                                                <?= $rubric->rubrik_name ?>
                                                            </a>
                                                        </li>
                                                <?php }
                                                } ?>

                                            </ul>
                                        </div>
                                    </li>
                            <?php }
                            } ?>

                        </ul>
                    </div>
                </li>

            <?php } ?>
        </ul>
    </div>
</div>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5 ">

        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach ($models as $model) {
                if ($model->count > 0) { ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <?= Html::img(isset($images[$model->product_id]) ? "http://backend.test.localhost:8080/uploads/{$images[$model->product_id]->path}" : "/assets/images/placeholder.png", ['class' => 'card-img-top']) ?>
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><a style="text-decoration:none; color: black;" href="product/<?= $model->product_id ?>"><?= $model->product_name ?></a></h5>
                                    <!-- Product price-->
                                    $<?= $model->price ?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product/<?= $model->product_id ?>">Посмотреть</a></div>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>


        </div>
    </div>
</section>