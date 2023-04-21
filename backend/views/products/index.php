<?php

use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Html;

?>
<div style="display:flex; flex-direction:row; justify-content:space-between;">
<h2>Products</h2>
<a href="/products/create" class="btn btn-primary" style="height:fit-content;" ><i class="bi bi-plus"> </i>Create</a>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'product_id',
        'product_name',
        'price',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'width:120px'],
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-pencil-square"></i>', "/products/{$model->product_id}/update", [
                        'title' => Yii::t('app', 'Edit'),
                        'class' => 'btn btn-sm btn-outline-secondary',
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-trash"></i>', "/products/{$model->product_id}/delete", [
                        'title' => Yii::t('app', 'Delete'),
                        'class' => 'btn btn-sm btn-outline-secondary',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]);
                },
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-eye"></i>', "/products/{$model->product_id}", [
                        'title' => Yii::t('app', 'View'),
                        'class' => 'btn btn-sm btn-outline-secondary',
                    ]);
                },
            ],
        ],
    ],
]); ?>