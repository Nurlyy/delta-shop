<?php

// print_r($characteristics);exit;

?>

<h2 class="text-center">Create Subcategory</h2>
<hr>
<div class="mb-3">
    <label for="subcategory_name" class="form-label">Subcategory Name</label>
    <input type="text" class="form-control" id="subcategory_name" name="subcategory_name">
</div>
<button type="submit" class="btn btn-primary" onclick="save()">Save</button>
</div>


<script>
    function save(){
        var data = {
            subcategory_name : $("#subcategory_name").val(),
            category_id: <?= $category_id ?>,
        }
        console.log(data);
        $.ajax({
            url: '/products/create-subcategory',
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