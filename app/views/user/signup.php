<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="<?= PATH ?>">Главная</a></li>
                <li>Регистрация</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12">
                <div class="product-one signup">
                    <div class="register-top heading">
                        <h2>REGISTER</h2>
                    </div>

                    <div class="register-main">
                        <div class="col-md-6 account-left">
                            <form method="post" action="user/signup" id="signup" role="form" data-toggle="validator">
                                <div class="form-group has-feedback">
                                    <label for="login">Login</label>
                                    <input type="text" name="login" value="<?=isset($data['login']) ? $data['login'] : ''?>" class="form-control" id="login" placeholder="Login" required>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="pasword">Password</label>
                                    <input type="password" name="password" class="form-control" id="pasword" placeholder="Password"
                                    data-error="Пароль должен включать не менее 6 символов" data-minlength="6" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="name">Имя</label>
                                    <input type="text" name="name" value="<?=isset($data['name']) ? $data['name'] : ''?>" class="form-control" id="name" placeholder="Имя" required>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" value="<?=isset($data['email']) ? $data['email'] : ''?>" class="form-control" id="email" placeholder="Email" required>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" value="<?=isset($data['address']) ? $data['address'] : ''?>" class="form-control" id="address" placeholder="Address" required>
                                </div>
                                <button type="submit" class="btn btn-default">Зарегистрировать</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--product-end-->