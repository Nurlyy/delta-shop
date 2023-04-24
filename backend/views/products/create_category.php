<?php

// print_r($characteristics);exit;

?>

<h2 class="text-center">Create Category</h2>
<hr>
<div class="mb-3">
    <label for="category_name" class="form-label">Category Name</label>
    <input type="text" class="form-control" id="category_name" name="category_name">
</div>
<button type="submit" class="btn btn-primary" onclick="save()">Save</button>
</div>


<script>
    function save(){
        var data = {
            category_name : $("#category_name").val(),
        }
        console.log(data);
        $.ajax({
            url: '/products/create-category',
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