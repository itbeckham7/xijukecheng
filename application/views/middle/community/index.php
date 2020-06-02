<?php
$loged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir = base_url() . 'assets/images/middle/';
$myworkURL = 'middle/work';
$returnURL = 'middle/work';
$course_menu_img_path = '';
if ($user_type != '1') {
    $myworkURL = 'middle/work';
    $returnURL = 'middle/coursewares/index';
    $hd_menu_img_path = $imageAbsDir . 'community/';
} else {
    $hd_menu_img_path = $imageAbsDir . 'community/stu_';
}
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/menu_manage.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/community_manage.css') ?>">
<div class="bg" style="background-color: #f4f4f4;">
    <img src="<?= base_url('assets/images/middle/community/bg-index.png') ?>" class="background_image">
</div>
<!--  page main menu part -->
<?php if ($this->session->userdata("loggedin") != FALSE) { ?>
    <a class="btn-main mywork" href="<?= base_url($myworkURL); ?>"
    ><span><?= ($user_type != '1') ? '我的' : '学生'; ?>作品</span></a>
    <a class="btn-main community" href="<?= base_url('middle/') . 'community/index'; ?>"
    ><span>戏剧社区</span></a>
    <a class="btn-main profile"
       href="<?= base_url('middle/') . 'users/profile/' . $loged_In_user_id; ?>"
    ><span>个人中心</span></a>
<?php } else if ($this->session->userdata("loggedin") == FALSE) { ?>
    <a class="btn-main register-btn" href="<?= base_url('signin/index') ?>"><span>登录</span></a>
<?php } ?>
<a href="javascript:;" onclick="location.replace('<?= base_url('/middle/coursewares') ?>');" class="btn-main back-btn"></a>


<a href="javascript:;" class="orderByCreateTime_Btn"
   style="background:url(<?= base_url('assets/images/middle/community/latestpub.png') ?>) no-repeat;background-size: 100% 100%;display: none;">
</a>
<div class="latestlist" style="display:none">
    <div style="position: relative; height: 100%">
        <img class="latestlist_img" src="<?= base_url('assets/images/middle/community/latestlist_none.png') ?>"
             usemap="#latestlist_map">
        <a id="latestlist_btn0" href="javascript:;" style="top:0; left:0; width:100%; height: 29%;"></a>
        <a id="latestlist_btn1" href="javascript:;" style="top:32.14%; left:13.04%; width: 81.3%; height: 29%;"></a>
        <a id="latestlist_btn2" href="javascript:;" style="top:64.28%; right:13.04%; width: 81.3%; height: 29%;"></a>
    </div>
</div>

<a href="javascript:;" class="orderByMaxReviews_Btn"
   style="background:url(<?= base_url('assets/images/middle/community/maxreview.png') ?>) no-repeat;background-size: 100% 100%;display:none"></a>
<div class="maxreviewslist" style="display:none">
    <div style="position: relative; height: 100%">
        <img class="maxreviewslist_img" src="<?= base_url('assets/images/middle/community/maxreviewslist_none.png') ?>"
             usemap="#maxreviewslist_map">
        <a id="maxreviewslist_btn0" href="javascript:;" style="top:0; left:0; width:100%; height: 29%;"></a>
        <a id="maxreviewslist_btn1" href="javascript:;" style="top:32.14%; left:13.04%; width: 81.3%; height: 29%;"></a>
        <a id="maxreviewslist_btn2" href="javascript:;"
           style="top:64.28%; right:13.04%; width: 81.3%; height: 29%;"></a>
    </div>
</div>
<!----------------------------------------------------------Filter Buttons By Work Types--------------------------------------------------------------------------->

<div class="course_type_menu">
    <a href="javascript:;" class="filterByScript_Btn" data-type="script"><span>剧本作品</span></a>
    <a href="javascript:;" class="filterByDubbing_Btn" data-type="dubbing"><span>配音作品</span></a>
    <!--    <a href="--><? //= base_url('middle/work/head') . '/' . $user_id; ?><!--" class="filterByHead_Btn" ></a>-->
    <a href="javascript:;" class="filterByShooting_Btn" data-type="shooting"><span>表演作品</span></a>
</div>

<!----------------------------------------------------------Content Area--------------------------------------------------------------->

<div class="community_list_wrapper" id="community_list_area"></div>
<!----------------------------------------------------------Content Area--------------------------------------------------------------->
<!----------------------------------------------------------Pagination BUTTONS--------------------------------------------------------------------------->
<a href="javascript:;" class="btn-work previous_Btn">上一页</a>
<a href="javascript:;" class="btn-work next_Btn">下一页</a>

<script>
    var cur_workstatus = '1';
    var initStatus = 'NOCLICKEDTYPE';
    var contentSets = '<?php echo json_encode($contentList);?>';
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
</script>
<script src="<?= base_url('assets/js/custom/middle/community_manage.js') ?>" type="text/javascript"></script>