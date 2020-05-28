<?php
$logged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir = base_url() . 'assets/images/middle/';
$myworkURL = 'middle/work';
$returnURL = 'middle/work/script';
$hd_menu_img_path = '';

if ($user_type == '2') {

    $myworkURL = 'middle/work';
    $hd_menu_img_path = $imageAbsDir . 'studentwork/';
    if ($content_type_id == '1') {
        $returnURL = $myworkURL;
    } else {///this mean $content_type_id is 3 , head work
        $returnURL = 'middle/work/head';
    }
} else {
    $hd_menu_img_path = $imageAbsDir . 'studentwork/stu_';
}

?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/menu_manage.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/work_view.css') ?>">
<div class="bg" style="background-color: #f4f4f4;">
    <img src="<?= base_url('assets/images/middle/mywork/bg-script.png') ?>" class="background_image">
</div>

<!--<div class="page-main-menu">-->
<?php if ($this->session->userdata("loggedin") != FALSE) { ?>
    <a class="btn-main mywork" href="<?= base_url($myworkURL); ?>"
    ><span><?= ($user_type == '2') ? '我的' : '学生'; ?>作品</span></a>
    <a class="btn-main community" href="<?= base_url('middle/') . 'community/index'; ?>"
    ><span>戏剧社区</span></a>
    <a class="btn-main profile"
       href="<?= base_url('middle/') . 'users/profile/' . $logged_In_user_id; ?>"
    ><span>个人中心</span></a>
<?php } else if ($this->session->userdata("loggedin") == FALSE) { ?>
    <a class="btn-main register-btn" href="<?= base_url('signin/index') ?>"><span>登录</span></a>
<?php } ?>
<a href="javascript:;" onclick="history.back();" class="btn-main back-btn"></a>


<?php if ($user_id == $logged_In_user_id){ ?><!---------if visitor is user that wrote content..------------->
    <a href="#" id="shareContent_Btn" class="share_content_btn"
       style="background:url(<?= base_url('assets/images/middle/mywork/workshare.png') ?>) no-repeat;background-size: 100% 100%;">
    </a>
<?php } ?>
<?php if ($content_type_id == '1') { ?>
    <a href="#" class="scriptPrint_Icon">打印</a>
<?php } else { ?>
    <a href="#" class="headImgPrint_Icon">打印</a>
<?php } ?>

<div class="work_view_area">
    <?php if ($content_type_id == '1') { ?>
        <div>
            <h1 class="scriptwork_title" style="font-weight: bold;"><?php echo $content_title; ?></h1>
        </div>
        </br>
        <div class="content-wrap" id="content_wrap">
            <?= $scriptText ?>
        </div>
        <?php
    } else if ($content_type_id == '5') { ?>
        <div id="headImage_wrapper">
            <img id="headImage" style="width:100%" src="<?= base_url() . $headImagePath; ?>">
        </div>
    <?php } ?>
</div>

<!-----------Share content Modal------------>
<style type="text/css">
    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000;
        opacity: .0;
        filter: alpha(opacity=0);
        z-index: 50;
        display: none;
    }

    .custom-modal {
        position: absolute;
        top: 30%;
        left: 35%;
        width: 30.5%;
        height: 31.2%;
        background: #ffffff;
        z-index: 51;
        display: none;
        border-radius: 10%;
    }

    .share_modal_content {
        background: url(<?= $imageAbsDir.'mywork/share_confirmbg1.png'?>);
        background-size: 100% 100%;
        width: 100%;
        height: 100%;
    }

    #content_share_btn {
        position: absolute;
        width: 20%;
        height: 20%;
        left: 14%;
        top: 68%;
        background: url(<?= $imageAbsDir.'mywork/yes.png'?>) no-repeat;
        background-size: 100% 100%;
    }

    .share_close_btn {
        position: absolute;
        width: 20%;
        height: 20%;
        left: 67%;
        top: 68%;
        background: url(<?= $imageAbsDir.'mywork/no.png'?>) no-repeat;
        background-size: 100% 100%;
    }
</style>
<div class="modal-backdrop"></div>
<div class="custom-modal" id="share_content_modal">
    <div class="share_modal_content">
        <a href="#" id="content_share_btn" content_id="<?php echo $content_id; ?>"></a>
        <a href="#" class="share_close_btn"></a>
    </div>
</div>
<!-----------share content Modal------------>
<script>
    var contentTitle = '<?php echo $content_title;?>';
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';

    function showCustomModal() {
        $('.modal-backdrop, .custom-modal').animate({'opacity': '.8'}, 300, 'linear');
        $('#share_content_modal').animate({'opacity': '1.00'}, 300, 'linear');
        $('.modal-backdrop, .custom-modal').css('display', 'block');
    }

    function close_modal() {
        $('.modal-backdrop, .custom-modal').animate({'opacity': '0'}, 300, 'linear', function () {
            $('.modal-backdrop, .custom-modal').css('display', 'none');
        });
    }
</script>
<script src="<?= base_url('assets/js/custom/middle/menu_manage.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/custom/middle/work_view.js') ?>" type="text/javascript"></script>
