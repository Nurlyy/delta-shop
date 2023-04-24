<?php

// print_r($characteristics);exit;

?>

<h2 class="text-center">Edit Manufacturer</h2>
<hr>
<div class="mb-3">
    <label for="manufacturer_name" class="form-label">Manufacturer Name</label>
    <input type="text" class="form-control" id="manufacturer_name" name="manufacturer_name" value="<?= $manufacturer->manufacturer_name ?>">
</div>
<button type="submit" class="btn btn-primary" onclick="save()">Save</button>
</div>


<script>
    function save(){
        var data = {
            manufacturer_name : $("#manufacturer_name").val(),
        }
        console.log(data);
        $.ajax({
            url: '/products/update-manufacturer/<?= $manufacturer->manufacturer_id ?>',
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