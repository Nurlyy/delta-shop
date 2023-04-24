<?php

use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Html;

?>
<div style="display:flex; flex-direction:row; justify-content:space-between;">
<h2>Products</h2>
<a href="/products/create-category/" class="btn btn-primary" style="height:fit-content;" ><i class="bi bi-plus"> </i>Create</a>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'category_name',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'width:120px'],
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-pencil-square"></i>', "/products/update-category/{$model->category_id}", [
                        'title' => Yii::t('app', 'Edit'),
                        'class' => 'btn btn-sm btn-outline-secondary',
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-trash"></i>', "", [
                        'title' => Yii::t('app', 'Delete'),
                        'class' => 'btn btn-sm btn-outline-secondary',
                        'onclick' => "delete_item($model->category_id)",
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]);
                }
            ],
        ],
    ],
]); ?>

<script>
    function delete_item(id){
        $.ajax({
            url: `/products/delete-category/${id}`,
            type: "POST",
            data: {category_id: id},
            success: function (data){

            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(errorThrown);
            }
        })
    }
</script>