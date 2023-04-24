<?php

// print_r($characteristics);exit;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Html;

?>

<h2 class="text-center">Edit category</h2>
<hr>
<div class="mb-3">
    <label for="category_name" class="form-label">category Name</label>
    <input type="text" class="form-control" id="category_name" name="category_name" value="<?= $category->category_name ?>">
</div>
<button type="submit" class="btn btn-primary" onclick="save()">Save</button>
</div>
<div class="card card-body mt-4">
<div style="display:flex; flex-direction:row; justify-content:space-between;">
<h2>Sub-categories</h2>
<a href="/products/update-category/<?= $category->category_id ?>/create-subcategory" class="btn btn-primary" style="height:fit-content;" ><i class="bi bi-plus"> </i>Create</a>
</div>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'subcategory_name',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'width:120px'],
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-pencil-square"></i>', "/products/update-category/{$model->category_id}/update-subcategory/{$model->subcategory_id}", [
                        'title' => Yii::t('app', 'Edit'),
                        'class' => 'btn btn-sm btn-outline-secondary',
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-trash"></i>', "", [
                        'title' => Yii::t('app', 'Delete'),
                        'class' => 'btn btn-sm btn-outline-secondary',
                        'onclick' => "delete_item($model->subcategory_id, $model->category_id)",
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
</div>

<script>
    function delete_item(id, category_id){
        $.ajax({
            url: `/products/update-category/${category_id}/delete-subcategory/${id}`,
            type: "POST",
            data: {subcategory_id: id},
            success: function (data){

            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(errorThrown);
            }
        })
    }
</script>


<script>
    function save(){
        var data = {
            category_name : $("#category_name").val(),
        }
        console.log(data);
        $.ajax({
            url: '/products/update-category/<?= $category->category_id ?>',
            type: 'POST',
            data: data,
            success:function(data){
                console.log(data);
            },
            error: function(xhr, status, error){
                console.log(xhr);
            }
        });
    }
</script>