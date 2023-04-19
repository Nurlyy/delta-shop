<?php

// echo "hello world";
?>

<div class="container px-4 px-lg-5 mt-5 ">
    <h2>Set Up your account</h2>
    <br>
    <div class="row">
        <div class="col-3">
            <div class="list-group">
                <button onclick="getAccount(1)" type="button" class="list-group-item list-group-item-action active" aria-current="true">
                    Основная информация
                </button>
                <button type="button" class="list-group-item list-group-item-action">Мои адреса</button>
                <button type="button" class="list-group-item list-group-item-action">Мои карты</button>
                <hr>
                <button type="button" class="list-group-item list-group-item-action">Изменить пароль</button>
                <button type="button" class="list-group-item list-group-item-action">Изменить номер телефона</button>
                <button type="button" class="list-group-item list-group-item-action">Изменить email</button>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <h4>Изменить основную информацию</h4>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <form>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" value="<?= Yii::$app->user->identity->username ?>" placeholder="Enter your name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input disabled type="email" class="form-control" id="email" value="<?= Yii::$app->user->identity->email ?>" placeholder="Enter your email">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input disabled type="tel" class="form-control" id="phone" value="<?= Yii::$app->user->identity->phone ?>" placeholder="Enter your phone number">
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>