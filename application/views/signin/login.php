<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/login.css') ?>">
<div class="bg">
    <img src="<?= base_url('assets/images/frontend/login/back_image.jpg')?>" class="background_image">
</div>
<style>

</style>
<form method="post" class="custom_login_form"
      action="<?= base_url('signin/index') ?>">
    <div class="form-group" style="">
        <input type="text" name="username" id="username" placeholder="请输入账号">
    </div>
    <div class="form-group">
        <input type="password" name="password" id="password" placeholder="请输入密码">
    </div>
    <div class="login_button_wrapper">
        <input type="image" name="submit" value="login"
               class="login_button_image"
               src="<?= base_url('assets/images/frontend/login/login.png') ?>"
               border="0" alt="Submit">
    </div>
    <a href="<?= base_url();?>" class="back_home_btn" style="">
            <img src="<?= base_url('assets/images/frontend/login/back_home.png')?>" id="back_image">
    </a>
</form>
<script src="<?= base_url('assets/js/custom/login.js') ?>"></script>
