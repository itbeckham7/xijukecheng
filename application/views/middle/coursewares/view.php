<?php

$login_status = $this->session->userdata("loggedin");
$loged_In_user_id = $this->session->userdata("loginuserID");

$imageAbsDir = base_url() . 'assets/images/middle/';
$myworkURL = 'middle/work';
$hd_menu_img_path = '';
$user_type = '0';
if ($this->session->userdata('loggedin')) {
    $user_type = $this->session->userdata("user_type");
    if ($user_type == '2') {
        $myworkURL = 'middle/work';
        $hd_menu_img_path = $imageAbsDir . 'coursewares/';
    } else {
        $hd_menu_img_path = $imageAbsDir . 'coursewares/stu_';
    }
}
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/courseware.css') ?>"/>

<input type="hidden" id="base_url" value="<?= base_url('middle/') ?>">
<div class="bg">
    <div class="left-tab"></div>
    <?php
    if ($courseware != null) {
        echo "<img class='courseware-preview' src='" . base_url($courseware[0]->courseware_photo) . "'/>";
        echo "<div class='courseware-preview-title'>" . $courseware[0]->courseware_name . "</div>";
    }
    ?>
</div>


<!--<div class="page-main-menu">-->
<?php if ($this->session->userdata("loggedin") != FALSE) { ?>
    <a class="btn-main mywork" href="<?= base_url($myworkURL); ?>"
    ><span><?= ($user_type == '2') ? '我的' : '学生'; ?>作品</span></a>
    <a class="btn-main community" href="<?= base_url('middle/') . 'community/index'; ?>"
    ><span>戏剧社区</span></a>
    <a class="btn-main profile"
       href="<?= base_url('middle/') . 'users/profile/' . $loged_In_user_id; ?>"
    ><span>个人中心</span></a>
<?php } else if ($this->session->userdata("loggedin") == FALSE) { ?>
    <a class="btn-main register-btn" href="<?= base_url('signin/index') ?>"><span>登录</span></a>
<?php } ?>
<a href="javascript:;" onclick="location.replace('<?= base_url('middle/coursewares') ?>')"
   class="btn-main back-btn"></a>
<!--</div>-->

<?php $subware_isexist = array(
    'script' => 0,
    'flash' => 0,
    'dubbing' => 0,
    'shooting' => 0
); ?>

<div class="subware-nav subware-flash">
    <a id="flash_contents" data-courseware_id="<?= $courseware_id ?>">
        <img id="flash_image" src="<?= base_url('assets/images/middle/coursewares/view/flash.png') ?>">
        <span>趣表演</span>
    </a>
</div>
<?php foreach ($subwares as $subware): ?>
    <?php
    $subwareExist = '0';
    $subwarePath = 'nosubware';
    if (file_exists($subware->subware_file . '/index.html')) {
        $subwarePath = $subware->subware_file;
    }
    if ($subware->subware_type_slug == 'script') : ?>
        <?php $subware_isexist['script'] = 1; ?>
        <div class="subware-nav subware-script">
            <a id="<?= $subware->subware_type_slug ?>"
               data-courseware_id="<?= $courseware_id ?>"
               subware_path="<?= $subwarePath ?>" subware_publish="<?= $subware->publish; ?>">
                <img id="script_image" src="<?= base_url('assets/images/middle/coursewares/view/script.png') ?>">
                <span>剧本学习</span>
            </a>
        </div>
    <?php elseif ($subware->subware_type_slug == 'dubbing') : ?>
        <?php $subware_isexist['dubbing'] = 1; ?>
        <div class="subware-nav subware-dubbing">
            <a id="<?= $subware->subware_type_slug ?>"
               data-courseware_id="<?= $courseware_id ?>"
               subware_path="<?= $subwarePath ?>" subware_publish="<?= $subware->publish; ?>">
                <img id="dubbing_image" src="<?= base_url('assets/images/middle/coursewares/view/dubbing.png') ?>">
                <span>趣配音</span>
            </a>
        </div>
    <?php elseif ($subware->subware_type_slug == 'shooting') : ?>
        <?php $subware_isexist['shooting'] = 1; ?>
        <div class="subware-nav subware-shooting">
            <a id="<?= $subware->subware_type_slug ?>"
               data-courseware_id="<?= $courseware_id ?>"
               subware_path="<?= $subwarePath ?>" subware_publish="<?= $subware->publish; ?>">
                <img id="shooting_image" src="<?= base_url('assets/images/middle/coursewares/view/shooting.png') ?>">
                <span>趣拍摄</span>
            </a>
        </div>
    <?php endif; ?>

<?php endforeach; ?>

<?php if ($subware_isexist['script'] == 0) : ?>
    <div class="subware-nav subware-script">
        <a id="script" subware_path="nosubware"><img
                    src="<?= base_url('assets/images/middle/coursewares/view/script.png') ?>"></a>
    </div>
<?php endif; ?>

<?php if ($subware_isexist['dubbing'] == 0) : ?>
    <div class="subware-nav subware-dubbing">
        <a id="dubbing" subware_path="nosubware"><img
                    src="<?= base_url('assets/images/middle/coursewares/view/dubbing.png') ?>"></a>
    </div>
<?php endif; ?>

<?php if ($subware_isexist['shooting'] == 0) : ?>
    <div class="subware-nav subware-shooting">
        <a id="shooting" subware_path="nosubware"><img
                    src="<?= base_url('assets/images/middle/coursewares/view/shooting.png') ?>"></a>
    </div>
<?php endif; ?>

<div class="script-content">
    <iframe src="" id="courseware_iframe" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"
            style="border:none"></iframe>
</div>

<p class="nosubware_msg">
    <?= $this->lang->line('CourseDeveloping'); ?>
</p>

<script>
    var login_status = '<?php if (isset($login_status) && $login_status == true) echo '1'; else echo '0';?>';
    var login_username = '<?php if (isset($loged_In_user_id)) echo $loged_In_user_id; else echo '';?>';
    var imageDir = baseURL + "assets/images/middle";
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
    var curr_sw = setSubwareNavId();
    var userType = '<?= $user_type; ?>';

    function return_back() {
        if (curr_sw == 'script_sw') {
            window.location.replace(baseURL + 'middle/coursewares/index');
        } else {
            //history.back();
            window.location.replace(baseURL + 'middle/coursewares/index');

        }
    }

    function showShootingContents(isEntering) {
        if (isEntering) {
            $('.script-content').css({
                left: 0, top: 0, width: 1920, height: 1080
            });
            $('.subware-nav').hide();
            $('.btn-main').hide();
            $('.btn-main.back-btn').attr('onclick', 'showShootingContents()');
            $('.btn-main.back-btn').show();
        } else {
            location.reload();
        }
    }
</script>
<script src="<?= base_url() ?>assets/js/custom/middle/courseware.js"></script>

