<?php

// echo "hello world";
?>

<div class="container px-4 px-lg-5 mt-5 ">
    <h2>Set Up your account</h2>
    <br>
    <div class="row">
        <div class="col-3">
            <div class="list-group">
                <button onclick="get_account(1)" type="button" class="list-group-item list-group-item-action active" aria-current="true">
                    Основная информация
                </button>
                <button onclick="get_account(2)" type="button" class="list-group-item list-group-item-action">Мои адреса</button>
                <button onclick="get_account(3)" type="button" class="list-group-item list-group-item-action">Мои данные</button>
                <hr>
                <button onclick="get_account(4)" type="button" class="list-group-item list-group-item-action">Изменить пароль</button>
                <button onclick="get_account(5)" type="button" class="list-group-item list-group-item-action">Изменить номер телефона</button>
                <button onclick="get_account(6)" type="button" class="list-group-item list-group-item-action">Изменить email</button>
                <hr>
                <button onclick="user_logout();" type="button" class="btn btn-danger">Выйти</button>
            </div>
        </div>
        <div class="col-9">
            <div class="card" id="account-card-changes">

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        get_account(1);
    });

    function get_account(type) {
        response = getAccount(type, function(received_data) {
            $('#account-card-changes').html(received_data);
        });
    }
</script>