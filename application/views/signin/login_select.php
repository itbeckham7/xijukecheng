<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/login.css') ?>">
<div class="bg">
    <img src="<?= base_url('assets/images/frontend/login/back_image.jpg') ?>" class="background_image">
</div>
<style>
    .weixin_login{
        position: absolute;
        left:34.8%;
        top: 44.8%;
        /*top: 36.8%;*/
        width:calc(65.1% - 34.8%);
        height:calc(45.8% - 36.8%);
        transition: all .1s ease-in-out;
        background-size: 100% 100%!important;
        background:url(<?=base_url('assets/images/frontend/login/weixin.png')?>);
        cursor: pointer;
    }
    .weixin_login:hover{
        background:url(<?=base_url('assets/images/frontend/login/weixin_hover.png')?>);
    }
    .mobile_login{
        position: absolute;
        left:34.8%;
        top: 48.9%;
        width:calc(65.1% - 34.8%);
        height:calc(57.9% - 48.9%);
        transition: all .1s ease-in-out;
        background-size: 100% 100%!important;
        background:url(<?= base_url('assets/images/frontend/login/mobile.png')?>);
        cursor: pointer;
        display:none;
    }
    .mobile_login:hover{
        background:url(<?= base_url('assets/images/frontend/login/mobile_hover.png')?>);
    }
    .back_home_btn{
        position: absolute;
        top: 60%;
        left: 50%;
        width: 9%;
        height: 8%;

    }
    #back_image{
        position: absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
    }
</style>
<a class="weixin_login" onclick="weixin_login()"></a>
<a class="mobile_login"></a>
<a href="<?= base_url('home/index'); ?>" class="back_home_btn" style="">
    <img src="<?= base_url('assets/images/frontend/login/back_home.png') ?>" id="back_image">
</a>
<!--<form method="post" class="custom_login_form"-->
<!--      action="<?= base_url('signin/index') ?>">-->
<!--    <div class="form-group" style="">-->
<!--        <input type="text" name="username" id="username">-->
<!--    </div>-->
<!--    <div class="form-group">-->
<!--        <input type="password" name="password" id="password">-->
<!--    </div>-->
<!--</form>-->
<script src="<?= base_url('assets/js/custom/login_weixin.js') ?>"></script>
