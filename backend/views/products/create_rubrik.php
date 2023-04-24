<?php

// print_r($characteristics);exit;

?>

<h2 class="text-center">Create Rubrik</h2>
<hr>
<div class="mb-3">
    <label for="rubrik_name" class="form-label">Rubrik Name</label>
    <input type="text" class="form-control" id="rubrik_name" name="rubrik_name">
</div>
<button type="submit" class="btn btn-primary" onclick="save()">Save</button>
</div>


<script>
    function save(){
        var data = {
            rubrik_name : $("#rubrik_name").val(),
            subcategory_id: <?= $subcategory_id ?>,
        }
        console.log(data);
        $.ajax({
            url: 'create-rubrik',
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