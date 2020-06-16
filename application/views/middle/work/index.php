<?php
$userRole = '0';
if ($this->session->userdata("loggedin") != FALSE) {
    $course_permission = $this->session->userdata('course_permission');
    if ($course_permission !== NULL) {
        $userRole = $course_permission->kebenju;
    }
}
$loged_In_user_id = $this->session->userdata("loginuserID");
$imageAbsDir = base_url() . 'assets/images/middle/';
$user_type = $this->session->userdata("user_type");
$myworkURL = 'middle/work';
$hd_menu_img_path = '';
if ($user_type != '1') {
    $myworkURL = 'middle/work';
    $hd_menu_img_path = $imageAbsDir . 'coursewares/';
} else {
    $hd_menu_img_path = $imageAbsDir . 'coursewares/stu_';
}
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/work.css') ?>">
<div class="bg" style="background-color: #f4f4f4;">
    <img src="<?= $imageAbsDir . 'mywork/bg-index.png' ?>">
</div>

<a href="<?php
if ($user_type == '1') echo base_url('middle/work/student');
else echo base_url('middle/work/script/') . $loged_In_user_id;
?>" class="btn home-nav" data-type="script"></a>
<a href="<?php
if ($user_type == '1') echo base_url('middle/work/student');
else echo base_url('middle/work/dubbing/') . $loged_In_user_id;
?>" class="btn home-nav" data-type="dubbing"></a>
<a href="<?php
if ($user_type == '1') echo base_url('middle/work/student');
else echo base_url('middle/work/shooting/') . $loged_In_user_id;
?>" class="btn home-nav" data-type="shooting"></a>

<!--<div class="page-main-menu">-->
<?php if ($this->session->userdata("loggedin") != FALSE) { ?>
    <a class="btn-main mywork" href="<?= base_url($myworkURL); ?>" data-type="<?= $user_type?>"
    ><span><?= ($user_type != '1') ? '我的' : '学生'; ?>作品</span></a>
    <a class="btn-main community" href="<?= base_url('middle/') . 'community/index'; ?>" data-type="<?= $user_type?>"
    ><span>戏剧社区</span></a>
    <a class="btn-main profile" data-type="<?= $user_type?>"
       href="<?= base_url('middle/') . 'users/profile/' . $loged_In_user_id; ?>"
    ><span>个人中心</span></a>
<?php } else if ($this->session->userdata("loggedin") == FALSE) { ?>
    <a class="btn-main register-btn" href="<?= base_url('signin/index') ?>"><span>登录</span></a>
<?php } ?>
<a href="javascript:;" onclick="location.replace('<?= base_url('/middle/coursewares') ?>');"
   class="btn-main back-btn"></a>

<script src="<?= base_url('assets/js/custom/home.js') ?>"></script>
<script>
    $('.home-nav').on('click', function () {
        var type = $(this).attr('data-type');
        setMediaType(type);
    });

</script>
