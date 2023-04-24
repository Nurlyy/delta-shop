<?php

// print_r($characteristics);exit;

?>

<h2 class="text-center">Edit Rubrik</h2>
<hr>
<div class="mb-3">
    <label for="rubrik_name" class="form-label">Rubrik Name</label>
    <input type="text" class="form-control" id="rubrik_name" name="rubrik_name" value="<?= $rubrik->rubrik_name ?>">
</div>
<button type="submit" class="btn btn-primary" onclick="save()">Save</button>
</div>


<script>
    function save(){
        var data = {
            rubrik_name : $("#rubrik_name").val(),
        }
        console.log(data);
        $.ajax({
            url: '',
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