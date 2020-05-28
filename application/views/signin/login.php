<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/login.css') ?>">

<img src="<?= base_url('assets/images/frontend/login/bg.jpg') ?>" class="background_image">
<form method="post" class="custom_login_form"
      action="<?= base_url('signin/index') ?>">
    <input type="text" name="username" id="username" placeholder="请输入账号">
    <input type="password" name="password" id="password" placeholder="请输入密码">
    <button type="submit" class="btn-login" border="0">登录</button>
    <a href="<?= base_url('/'); ?>" class="btn-back"></a>
    <a href="<?= base_url('signin/register'); ?>" class="btn-register">注册</a>
    <a href="<?= base_url('signin/signin_weixin'); ?>" class="btn-weixin"
       style="display:<?= ($wxStatus == '1') ? 'block' : 'none'; ?>">
        <img src="<?= base_url('assets/images/frontend/login/weixin_btn.png') ?>">
    </a>
</form>
<script src="<?= base_url('assets/js/custom/login.js') ?>"></script>
