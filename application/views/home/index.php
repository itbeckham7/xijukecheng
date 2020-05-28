<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/home.css') ?>">
<div class="bg" style="">
    <img src="<?= base_url('assets/images/middle/home.jpg') ?>" class="background_image">
</div>

<a href="<?= base_url('xiaoxueapp'); ?>" class="btn home-nav" data-type="primary"></a>

<a href="<?= base_url('middle'); ?>" class="btn home-nav" data-type="middle"></a>

<?php if ($this->session->userdata("loggedin") != FALSE) { ?>
    <a href="<?= base_url('signin/signout'); ?>" class="btn home-login">退出</a>
<?php } else { ?>
    <a href="<?= base_url('signin/'); ?>" class="btn home-login">登录</a>
    <a href="<?= base_url('signin/register'); ?>" class="btn home-login" data-type="register">注册</a>
<?php } ?>
<a href="javascript:;" class="btn home-profile"></a>
<script src="<?= base_url('assets/js/custom/home.js') ?>"></script>


<style>   .teacher-reference-btn {
        display: none;
    } </style>
