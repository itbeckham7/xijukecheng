<?php
$loggedIn_UserID = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$ownerSt = TRUE;
$imageAbsDir = base_url() . 'assets/images/middle/';
$bac_img_path = $imageAbsDir . 'mywork/bg-view.png';
if (false)//if current user is not owner of work.
{
    $ownerSt = FALSE;
    $bac_img_path = $imageAbsDir . 'mywork/bg-view.png';
}
$myworkURL = 'middle/work';
$returnURL = 'middle/coursewares/index';
$hd_menu_img_path = '';
if ($user_type == '2') {
    $myworkURL = 'middle/work';
    $returnURL = 'middle/coursewares/index';
    $hd_menu_img_path = $imageAbsDir . 'mywork/';
} else {
    $hd_menu_img_path = $imageAbsDir . 'mywork/stu_';
}
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/student_work.css') ?>">
<div class="bg" style="background-color: #f4f4f4;">
    <img src="<?= base_url('assets/images/middle/studentwork/bg-student.png') ?>" class="background_image">
</div>
<!-----------Course type Menu for teacher work--------------------------------->

<div class="course_type_menu">
    <a href="javascript:;" id="script_ATag_Btn" data-type="script"><span>剧本作品</span></a>
    <a href="javascript:;" id="dubbing_ATag_Btn" data-type="dubbing"><span>配音作品</span></a>
    <!--    <a href="--><? //= base_url('middle/work/head') . '/' . $user_id; ?><!--"></a>-->
    <a href="javascript:;" id="shooting_ATag_Btn" data-type="shooting"><span>表演作品</span></a>
</div>

<!--<div class="page-main-menu">-->
<?php if ($this->session->userdata("loggedin") != FALSE) { ?>
    <a class="btn-main mywork" href="<?= base_url($myworkURL); ?>"
    ><span><?= ($user_type == '2') ? '我的' : '学生'; ?>作品</span></a>
    <a class="btn-main community" href="<?= base_url('middle/') . 'community/index'; ?>"
    ><span>戏剧社区</span></a>
    <a class="btn-main profile"
       href="<?= base_url('middle/') . 'users/profile/' . $loggedIn_UserID; ?>"
    ><span>个人中心</span></a>
<?php } else if ($this->session->userdata("loggedin") == FALSE) { ?>
    <a class="btn-main register-btn" href="<?= base_url('signin/index') ?>"><span>登录</span></a>
<?php } ?>
<a href="javascript:;" onclick="location.replace('<?= base_url('/middle/work') ?>');" class="btn-main back-btn"></a>


<!-------------------Class list area--------------------------------------------->


<div class="teacher_assign_class">
    <?php foreach ($classlists as $classlist): ?>
        <div class="class_name_btn_wrapper" id="<?= $classlist->image_name; ?>">
            <button type="button"
                    data-class_name="<?= $classlist->attr_name; ?>"
                    data-image_name="<?= $classlist->image_name; ?>"
                    class="custom_classlist_btn"><?= $classlist->class_name; ?></button>
        </div>
    <?php endforeach; ?>
</div>
<div id="class_member_area" style="position: absolute;">
    <div class="class_member_tbl_area">
        <div class="left-block-member">
            <div class="member_item_wrapper">
            </div>
        </div>
        <div class="right-block-member">
        </div>
    </div>
</div>
<a heft="javascript:;" class="btn-work previous_Btn">上一页</a>
<a heft="javascript:;" class="btn-work next_Btn">下一页</a>

<script>
    var content_type_id = '1';
    var current_className = '';
    var current_classbgname = '';
    var curPageNo = 0;
    var totalPageCount = 0;
    var prev_btn = $('.previous_Btn');
    var next_btn = $('.next_Btn');
    var imageDir = base_url + 'assets/images/middle/mywork/';

</script>
<script src="<?= base_url('assets/js/custom/middle/personal_teacher.js') ?>" type="text/javascript"></script>
