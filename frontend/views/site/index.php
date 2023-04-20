<?php

/** @var yii\web\View $this */

use yii\bootstrap5\LinkPager;

$this->title = 'My Yii Application';
// var_dump($categories);exit;
?>
<div class="container px-4 px-lg-5 mt-5 ">

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            Категории
        </button>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" id="AppDropDownId">
            <?php foreach ($categories as $category) { ?>

                <li>
                    <div class="btn-group dropend dropdown-item">
                        <a type="button" class="dropdown-item dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $category->category_name ?>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($subcategories as $subcategory) { 
                                if($subcategory->category_id == $category->category_id){?>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <?= $subcategory->subcategory_name ?>
                                    </a>
                                </li>
                            <?php }} ?>

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
            <?php foreach ($models as $model) { ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="<?= "/assets/images/placeholder.png" ?>" alt="..." />
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
            <?php } ?>


        </div>
    </div>
</section>
<?php echo LinkPager::widget([
    'pagination' => $pages,
]); ?>