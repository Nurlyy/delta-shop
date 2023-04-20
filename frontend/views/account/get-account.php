<?php

switch ($type) {
    case 1:
?>
        <div class="card-header">
            <h4>Изменить основную информацию</h4>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Name</label>
                                <input type="text" class="form-control" id="username" value="<?= Yii::$app->user->identity->username ?>" placeholder="Enter your name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input disabled type="email" class="form-control" id="email" value="<?= Yii::$app->user->identity->email ?>" placeholder="Enter your email">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input disabled type="tel" class="form-control" id="phone" value="<?= Yii::$app->user->identity->phone ?>" placeholder="Enter your phone number">
                            </div>

                            <button onclick="change_main_information()" type="submit" class="btn btn-primary mt-3">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
        break;
    case 2:
    ?>
        <div class="card-header">
            <h4>Ваши адреса</h4>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <?php foreach ($addresses as $address) { ?>
                        <div class="col-6 mt-3">
                            <div class="card card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Country</label>
                                        <input onchange="inputchanged(<?= $address->id ?>);" type="text" class="form-control" id="country_<?= $address->id ?>" value="<?= $address->country ?>" placeholder="Country name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">State</label>
                                        <input onchange="inputchanged(<?= $address->id ?>);" type="text" class="form-control" id="state_<?= $address->id ?>" value="<?= $address->state ?>" placeholder="State name">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">City</label>
                                        <input onchange="inputchanged(<?= $address->id ?>);" type="text" class="form-control" id="city_<?= $address->id ?>" value="<?= $address->city ?>" placeholder="City name">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Street</label>
                                        <input onchange="inputchanged(<?= $address->id ?>);" type="text" class="form-control" id="street_<?= $address->id ?>" value="<?= $address->street ?>" placeholder="Street name">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Building</label>
                                        <input onchange="inputchanged(<?= $address->id ?>);" type="text" class="form-control" id="building_<?= $address->id ?>" value="<?= $address->building ?>" placeholder="Building number or name">
                                    </div>
                                    <button onclick="save_address(<?= $address->id ?>)" type="submit" id="btn_create_new_address_<?= $address->id ?>" class="btn btn-primary mt-3">Save changes</button>
                                    <button onclick="delete_address(<?= $address->id ?>)" id="btn_delete_address_<?= $address->id ?>" class="btn btn-danger mt-3">Delete</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="col-6 mt-3">
                        <div class="card card-body">
                            <div class="col-md-12">
                                <form>
                                    <div class="form-group">
                                        <label for="name">Country</label>
                                        <input onchange="inputchanged('new');" type="text" class="form-control" id="country_new" placeholder="Country name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">State</label>
                                        <input onchange="inputchanged('new');" type="test" class="form-control" id="state_new" placeholder="State name">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">City</label>
                                        <input onchange="inputchanged('new');" type="text" class="form-control" id="city_new" placeholder="City name">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Street</label>
                                        <input onchange="inputchanged('new');" type="text" class="form-control" id="street_new" placeholder="Street name">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Building</label>
                                        <input onchange="inputchanged('new');" type="text" class="form-control" id="building_new" placeholder="Building number or name">
                                    </div>
                                    <button onclick="save_address('new')" id="btn_save_address_new" type="submit" disabled class="btn btn-primary mt-3">Create new address</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
        break;
}

?>
<script>
    var addresses = <?= json_encode($addresses) ?>;
    console.log(addresses);

    function inputchanged(id) {
        if ($('#street_' + id).val().length > 0 && $('#building_' + id).val().length > 0 && $('#city_' + id).val().length > 0 && $('#state_' + id).val().length > 0 && $('#country_' + id).val().length > 0) {
            $('#btn_save_address_' + id).prop("disabled", false);
        }
    }

    function save_address(id) {
        event.preventDefault();
        country = $('#country_' + id).val();
        state = $('#state_' + id).val();
        city = $('#city_' + id).val();
        street = $('#street_' + id).val();
        building = $('#building_' + id).val();

        data = {
            Address: {
                country: country,
                state: state,
                city: city,
                street: street,
                building: building
            }
        };

        if(Number.isInteger(id)){
            data['Address']['id'] = id;
        }

        console.log(data);

        $.ajax({
            url: '/account/save-address',
            type: "POST",
            data: data,
            success: function(data) {
                // location.reload();
                console.log(data);
            },
            error: function(xhr, status, error) {
                console.error(error); // handle error response
            }
        })
    }

    function delete_address($id) {
        event.preventDefault();
        $.ajax({
            url: '/account/delete-address',
            type: 'POST',
            data: {
                id: $id
            },
            success: function(data) {
                // location.reload();
            },
            error: function(xhr, status, error) {
                console.log(xhr);
            }
        });
    }

    function change_main_information(){
        username = $('#username').val();
        $.ajax({
            url: '/account/change-name',
            type: 'POST',
            data: {username: username, id:<?= Yii::$app->user->id ?>},
            success: function(data){
                location.reload();
            },
            error: function(xhr, status ,error){
                console.log(xhr);
            }
        });
    }
</script>