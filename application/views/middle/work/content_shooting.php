<?php
$logged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir = base_url() . 'assets/images/middle/';
$myworkURL = 'middle/work';
$returnURL = 'middle/work/shooting/' . $user_id;
$course_menu_img_path = '';
if ($user_type != '1') {
    $myworkURL = 'middle/work';
    $hd_menu_img_path = $imageAbsDir . 'studentwork/';
} else {
    $hd_menu_img_path = $imageAbsDir . 'studentwork/stu_';
}
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/menu_manage.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/work_view.css') ?>">

<!--------------------Player-------------------->
<link rel="stylesheet" href="<?= base_url('assets/css/video/style_video.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/video/vplayer.css') ?>"/>
<!--------------------Player-------------------->
<!-----------------------------Vplayer------------------------->
<script src="<?= base_url('assets/js/video/vplayer.js') ?>"></script>
<!-----------------------------Vplayer------------------------->

<div class="bg" style="background-color: #f4f4f4;">
    <img src="<?= base_url('assets/images/middle/mywork/bg-shooting.png') ?>" class="background_image">
</div>
<!--<div class="page-main-menu">-->
<?php if ($this->session->userdata("loggedin") != FALSE) { ?>
    <a class="btn-main mywork" href="<?= base_url($myworkURL); ?>"
    ><span><?= ($user_type != '1') ? '我的' : '学生'; ?>作品</span></a>
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
    <a href="#" id="shooting_share_content"
       class="shooting_share_content"
       style="background:url(<?= base_url('assets/images/middle/mywork/workshare.png') ?>) no-repeat;background-size: 100% 100%;">
    </a>
<?php } ?>
<div class="shooting-content">
    <video controls id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered"
           style="background:#000;object-fit: fill;position: absolute;width: 100%;height:100%" autoplay>
        <source src="<?php echo base_url() . $videoPath; ?>" type="video/mp4">
    </video>
    <script>
        $(function () {
            var vplayer = videojs('videoPlayer', {
                controls: true,
                width: 1280,
                height: 712,
                nativeControlsForTouch: false,
                preload: 'auto',
                loop: false
            }, function () {
                vplayer.on('play', function () {
                    console.log('play');
                });
                vplayer.on("pause", function () {
                    console.log('stop');
                });
                vplayer.on("ended", function () {
                    console.log('stop');
                });
            });
        })
    </script>
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
        background: url(<?= $imageAbsDir.'mywork/yes.png'?>) no-repeat;
        background-size: 100% 100%;
        width: 20%;
        height: 20%;
        left: 14%;
        top: 68%;
    }

    .share_close_btn {
        position: absolute;
        background: url(<?= $imageAbsDir.'mywork/no.png'?>) no-repeat;
        background-size: 100% 100%;
        width: 20%;
        height: 20%;
        left: 67%;
        top: 68%;
    }
</style>
<div class="modal-backdrop"></div>
<div class="custom-modal" id="share_content_modal">
    <div class="share_modal_content">
        <a href="#" id="content_share_btn" content_id="<?php echo $content_id; ?>"></a>
        <a href="#" class="share_close_btn"></a>
    </div>
</div>
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
