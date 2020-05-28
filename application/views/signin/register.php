<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/login.css') ?>">
<div class="bg">
    <img src="<?= base_url('assets/images/frontend/login/bg-register.jpg') ?>" class="background_image">
</div>
<style>
    #username {
        top: 338px;
    }

    #password {
        top: 468px;
    }

    #cpassword {
        top: 592px;
    }

    .btn-register {
        left: 866px;
        top: 726px;
        width: 185px;
    }

    .btn-back{
        top: 287px;
        left: 516px;
    }

    input[item_type="1"] {
        border-radius: 5px;
        border: 1px solid red !important;
        -webkit-transition: all .1s ease-in-out;
        -moz-transition: all .1s ease-in-out;
        -ms-transition: all .1s ease-in-out;
        -o-transition: all .1s ease-in-out;
        transition: all .1s ease-in-out;
    }
</style>
<form method="post" class="form-register" id="custom_login_form"
      action="<?= base_url('signin/register'); ?>">
    <input type="text" name="username" id="username" placeholder="请输入账号">
    <input type="password" name="password" id="password" placeholder="请输入密码">
    <input type="password" name="cpassword" id="cpassword" placeholder="请重复输入密码">
    <button type="submit" class="btn-register" border="0">注册完成</button>
    <a href="<?= base_url('/'); ?>" class="btn-back"></a>
</form>
<div class="info-modal">
    <div>输入的信息不正确</div>
</div>
<script src="<?= base_url('assets/js/custom/register.js') ?>"></script>
