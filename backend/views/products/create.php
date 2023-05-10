<?php

// print_r($characteristics);exit;

?>


<h2 class="text-center">Create Product</h2>
<hr>
<div class="mb-3">
    <label for="imageFiles" class="form-label">Select Images:</label>
    <input type="file" id="imageFiles" name="imageFiles[]" class="form-control" multiple onchange="previewImages(event)">
    <div class="mt-2" id="imagePreviewContainer"></div>
</div>
<div class="mb-3">
    <label for="product_name" class="form-label">Product Name</label>
    <input type="text" required class="form-control" id="product_name" name="product_name">
</div>
<div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input type="number" required class="form-control" id="price" name="price">
</div>
<div class="mb-3">
    <label for="manufacturer_id" class="form-label">Manufacturer</label>
    <select class="form-select" id="manufacturer_id" name="manufacturer_id">
        <?php foreach ($manufacturers as $manufacturer) : ?>
            <option value="<?= $manufacturer->manufacturer_id ?>"><?= $manufacturer->manufacturer_name ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3">
    <label for="rubrik_id" class="form-label">Rubrik</label>
    <select class="form-select" id="rubrik_id" name="rubrik_id">
        <?php foreach ($rubriks as $rubrik) : ?>
            <option value="<?= $rubrik->rubrik_id ?>"><?= $rubrik->rubrik_name ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mt-3">
    <label>Characteristics</label>
    <div class="row mb-2 mt-1">
        <div class="col-4">
            <input type="text" class="form-control" placeholder="Characteristic name" id="char-name">
        </div>
        <div class="col-4">
            <input type="text" class="form-control" placeholder="Value" id="char-value">
        </div>
        <div class="col-4">
            <button class="btn btn-primary" id="add-char-btn" onclick="addCharacteristic();">Add</button>
        </div>
    </div>
    <div id="characteristics_div">
    </div>

</div>
<div class="mb-3 mt-3">
    <label for="count" class="form-label">Quantity</label>
    <input type="number" required class="form-control" id="count" name="count">
</div>
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" name="description"></textarea>
</div>
<button type="submit" class="btn btn-primary" onclick="save()">Save</button>
</div>
<style>
    #imagePreviewContainer {
        display: flex;
        flex-wrap: wrap;
    }

    .image-preview {
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .image-preview img {
        display: block;
        height:250px !important;
    }
</style>

<script>
    var formData = new FormData();
    function previewImages(event) {
        var container = document.getElementById('imagePreviewContainer');
        container.innerHTML = '';
        if (event.target.files) {
            for (var i = 0; i < event.target.files.length; i++) {
                formData.append('imageFiles[]', event.target.files[i]);
                var reader = new FileReader();
                reader.onload = function(e) {
                    var image = document.createElement('img');
                    image.src = e.target.result;
                    image.className = 'image-preview';
                    image.style.display = 'block';
                    image.style.height = '150px';
                    image.style.marginBottom = '10px';
                    image.style.marginRight = '10px';
                    image.style.borderRadius = '5px';
                    container.appendChild(image);
                };
                reader.readAsDataURL(event.target.files[i]);
            }
        }
    }

    var characteristics = [];

    function addCharacteristic() {
        characteristics.push({
            key: $("#char-name").val(),
            value: $("#char-value").val()
        });
        $("#char-name").value = '';
        $("#char-key").value = '';
        refreshCharacteristics();
    }

    function refreshCharacteristics() {
        $("#characteristics_div").html('');
        characteristics.forEach(function(item, index) {

            $("#characteristics_div").append(`<ul class="list-group mt-2" id="char-list">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                ${item.key}
                                <span class="badge bg-secondary rounded-pill">${item.value}</span>
                                <button onclick="deleteCharacteristic(${index})" type="button" class="btn btn-danger btn-sm remove-char-btn"><i class="bi bi-trash"></i></button>
                            </li>
                        </ul>`)
        });
    }

    function deleteCharacteristic(index) {
        characteristics.splice(index, 1);
        refreshCharacteristics();
    }


    function save() {
        // console.log(characteristics);
        formData.append('product_name', $("#product_name").val());
        formData.append('price', $("#price").val());
        formData.append('manufacturer_id', $("#manufacturer_id").val());
        formData.append('rubrik_id', $("#rubrik_id").val());
        formData.append('characteristics', characteristics);
        formData.append('count', $("#count").val());
        formData.append('description', $('#description').val());
        // var data = {
        //     product_name: $("#product_name").val(),
        //     price: $("#price").val(),
        //     manufacturer_id: $("#manufacturer_id").val(),
        //     rubrik_id: $("#rubrik_id").val(),
        //     characteristics: characteristics,
        //     count: $("#count").val(),
        //     description: $('#description').val(),
        //     images: formData,
        // }
        console.log(formData);
        $.ajax({
            url: '/products/create/',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }


    refreshCharacteristics();
</script>