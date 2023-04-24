<?php

// print_r($characteristics);exit;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Html;

?>

<h2 class="text-center">Edit Subcategory</h2>
<hr>
<div class="mb-3">
    <label for="subcategory_name" class="form-label">Subcategory Name</label>
    <input type="text" class="form-control" id="subcategory_name" name="subcategory_name" value="<?= $subcategory->subcategory_name ?>">
</div>
<button type="submit" class="btn btn-primary" onclick="save()">Save</button>
</div>
<div class="card card-body mt-4">
<div style="display:flex; flex-direction:row; justify-content:space-between;">
<h2>Rubriks</h2>
<a href="/products/update-category/<?= $subcategory->category_id ?>/update-subcategory/<?= $subcategory->subcategory_id ?>/create-rubrik" class="btn btn-primary" style="height:fit-content;" ><i class="bi bi-plus"> </i>Create</a>
</div>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'rubrik_name',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'width:120px'],
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-pencil-square"></i>', "{$model->subcategory_id}/update-rubrik/{$model->rubrik_id}", [
                        'title' => Yii::t('app', 'Edit'),
                        'class' => 'btn btn-sm btn-outline-secondary',
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="bi bi-trash"></i>', null, [
                        'title' => Yii::t('app', 'Delete'),
                        'class' => 'btn btn-sm btn-outline-secondary',
                        'onclick' => "delete_item($model->rubrik_id, $model->subcategory_id)",
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
    function delete_item(id, subcategory_id){
        $.ajax({
            url: `${subcategory_id}/delete-rubrik/${id}`,
            type: "POST",
            data: {rubrik_id: id},
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
            subcategory_name : $("#subcategory_name").val(),
        }
        console.log(data);
        $.ajax({
            url: '/products/update-category/<?= $subcategory->category_id ?>/update-subcategory/<?= $subcategory->subcategory_id ?>',
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