<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/home.css') ?>">
<div class="bg" style="">
    <img src="<?= base_url('assets/images/sandapian/home/home.png')?>" class="background_image" >
</div>

<a href="<?= base_url('primary/coursewares/index');?>"
   class="btn" id="sh_kebenju_btn"
   style="background:url(<?= base_url('assets/images/sandapian/home/kebenju.png');?>) no-repeat;
       background-size: 100% 100%">
</a>

<a href="<?= base_url('primary/nchildcourse/index');?>"
   class="btn" id="sh_sandapian_btn"
   style="background:url(<?= base_url('assets/images/sandapian/home/sandapian.png');?>) no-repeat;
           background-size: 100% 100%">
</a>
<?php
    if (count($grammar_permissions)>0){
        ?>
        <a href="<?= base_url('primary/home/grammar');?>"
           class="btn" id="sh_xiaochu_btn"
           style="background:url(<?= base_url('assets/images/frontend/grammar_course/index/xiaochu.png');?>) no-repeat;
                   background-size: 100% 100%">
        </a>
        <?php
    }
?>

<?php if($this->session->userdata("loggedin") != FALSE){?>
<a href="<?= base_url('signin/signout');?>"
   class="btn" id="sh_exit_btn"
   style="background:url(<?= base_url('assets/images/sandapian/base/exit.png');?>) no-repeat;
           background-size: 100% 100%">
</a>
<?php } else{?>
<a href="<?= base_url('signin/');?>"
   class="btn" id="sh_register_btn"
   style="background:url(<?= base_url('assets/images/sandapian/base/login.png');?>) no-repeat;
           background-size: 100% 100%">
</a>
<?php }?>
<script src="<?= base_url('assets/js/custom/home.js') ?>"></script>


<style>   .teacher-reference-btn { display: none;} </style>
