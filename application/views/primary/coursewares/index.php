<?php

$listCount = sizeof($cwSets);
$userRole = '0';
if ($this->session->userdata("loggedin") != FALSE) {
    $course_permission = $this->session->userdata('course_permission');
//    if ($course_permission !== NULL) {
//        $userRole = $course_permission->kebenju;
//    }
}
$loged_In_user_id = $this->session->userdata("loginuserID");
if (!isset($loged_In_user_id)) $loged_In_user_id = '';
$imageAbsDir = base_url() . 'assets/images/frontend/';
$user_type = $this->session->userdata("user_type");
$myworkURL = 'primary/work';
$hd_menu_img_path = '';
if ($user_type == '2') {
    $myworkURL = 'primary/work';
    $hd_menu_img_path = $imageAbsDir . 'coursewares/';
} else {
    $hd_menu_img_path = $imageAbsDir.'coursewares/stu_';
}
?>
<style>
    body, html {
        height: 100%;
        margin: 0;
    }

    .background_image {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: contain;
        z-index: -1;
    }

    .switch {
        position: absolute;
        left: 38.8%;
        top: 0.9%;
        width: 21.61%;
        height: 7.87%;
    }

    .switch img {
        width: 100%;
        height: 100%
    }

    .switch a {
        display: block;
        position: absolute;
        cursor: pointer
    }

    .back-btn {
        position: absolute;
        left: 93.84%;
        top: 1.37%;
        width: 4.31%;
        height: 7.8%;
    }

    .back-btn img {
        width: 100%;
        height: 100%
    }

    .coursewarelist-wrapper {
        position: absolute;
        left: 11.72%;
        top: 15%;
        width: 77.34%;
        height: 72.22%;
    }

    .coursewarelist-wrapper .courseware-list {
        width: 30.5%;
        height: 48.97%;
        display: inline-block;
        float: left;
        margin-right: 2.6%;
        margin-bottom: 1.15%;
        position: relative
    }

    .coursewarelist-wrapper .courseware-list img {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
    }

    .coursewarelist-wrapper .courseware-list img.courseware-image-item {
        width: 100%;
        height: 100%;
        left: 0%;
        top: 0%;
    }

    /*.coursewarelist-wrapper .courseware-list img.courseware-image-item{ width: 94.5%; height: 89.52%; left: 2.6%; top: 3.66%; }*/

    .coursewarelist-prevpage {
        position: absolute;
        left: 2.4%;
        top: 46.48%;
        width: 5.15%;
        height: 9.7%;
    }

    .coursewarelist-prevpage img {
        width: 100%;
        height: 100%
    }

    .coursewarelist-nextpage {
        position: absolute;
        left: 92.34%;
        top: 46.48%;
        width: 5.15%;
        height: 9.7%;
    }

    .coursewarelist-nextpage img {
        width: 100%;
        height: 100%
    }

    .page-num {
        position: fixed;
        top: 90%;
        left: 45%;
        width: auto;
        height: auto;
        font-size: calc(1.5vw);
        font-weight: bold;
        color: #00a2ff;
        text-shadow: 1px 1px 3px #ffffff;
    }

</style>
<div class="bg">
    <img src="<?= $imageAbsDir . 'coursewares/bg.jpg'; ?>" class="background_image">
    <a target="_blank"
       href="https://shop18725122.m.youzan.com/wscgoods/detail/2flgensdaskq2">
        <img src="<?= $imageAbsDir . 'coursewares/home-bottom.png'; ?>" class="background_image"
             style="top:15%;left: 87.5%;width:12%;height:6.5%;">
    </a>
    <div class="page-num">第<span class="page-cur">1</span>页/共<span class="page-total">2</span>页</div>
</div>

<div class="switch">
    <div style="position: relative; height: 100%; display: none">
        <img src="<?= $imageAbsDir . 'coursewares/country_cn.png'; ?>" id="select_country_img"
             data-baseurl="<?= base_url('assets/images/frontend/coursewares') ?>" data-country="cn">
        <a onclick="selectOnChina()" style="top: 0%; left: 0%; width: 50%; height: 100%;"></a>
        <a onclick="selectWestern()" style="top: 0%; left: 50%; width: 50%; height: 100%;"></a>
    </div>
</div>
<div class="hdmenu">
    <?php if ($this->session->userdata("loggedin") != FALSE) { ?>
        <div style="position: relative; height: 100%">
            <img class = "hdmenu_img" src="<?= $hd_menu_img_path.'hdmenu_normal.png';?>">
            <a id = "hdmenu_studentwork" href="<?= base_url($myworkURL);?>" style="top: 27.2%; left: 1.1%; width: 31.9%; height: 48.5%;"></a>
            <a id = "hdmenu_profile" href="<?= base_url('primary/').'users/profile/'.$loged_In_user_id;?>" style="top: 3.9%; left: 37.1%; width: 26.1%; height: 90.4%;"></a>
            <a id = "hdmenu_community" href="<?= base_url('primary/').'community/index';?>" style="top: 27.2%; left: 67%; width: 31.9%; height: 48.5%;"></a>
        </div>
    <?php } ?>
</div>
<?php if (true || $wxStatus == '1') { ?>
    <?php if ($this->session->userdata("loggedin") == FALSE): ?>
        <a class="register-btn" href="<?= base_url('signin/index') ?>"></a>
    <?php else: ?>
        <a class="exit-btn" href="<?= base_url('signin/signout') ?>" onclick="setUserInfo('')"></a>
    <?php endif; ?>
<?php } ?>
<div class="back-btn">
    <a onmouseover="hover_back()" onmouseout="out_back()" href="javascript:;"  onclick="location.replace('<?= base_url(); ?>')">
        <img id="back_btn_image" src="<?= $imageAbsDir.'community/script/back.png';?>">
    </a>
</div>

<div class="coursewarelist-wrapper">
    <?php foreach ($cwSets as $cw): ?>
        <?php
        $imageUrl = $cw->courseware_photo;
        if ($cw->publish != 1) continue;
        foreach ($paidCourse as $item) {
            if ($cw->courseware_id == $item->courseware_id) {
                $cw->price = -1;
                break;
            }
        }
        ?>
        <a href="<?= base_url() ?>primary/coursewares/view/<?= $cw->courseware_id ?>"
           class="courseware-list"
           unit_course_id="<?= $cw->courseware_id ?>"
           unit_type_id="<?= $cw->unit_type_id ?>"
           free_course="<?= ($cw->price == 0) ? "1" : "0"; ?>"
           isfreeaccount="<?= $cw->price; ?>"
           isvalid="<?= $cw->isvalid; ?>"
           style="display:none">
            <img src="<?= base_url() . $imageUrl ?>" class="courseware-image-item">
            <img src="<?= $imageAbsDir . 'coursewares/frame.png' ?>">
            <?php
            if ($cw->price == 0) {
                echo '<img src="' . $imageAbsDir . 'coursewares/free.png" style="width:30%;height:auto;">';
            } else if ($cw->price == -1) {
                echo '<img src="' . $imageAbsDir . 'coursewares/paid.png" style="width:30%;height:auto;">';
            }
            ?>
        </a>
    <?php endforeach; ?>
</div>
<div class="coursewarelist-prevpage">
    <a onclick="prevPageElems();" onmouseover="hover_prev()" onmouseout="out_prev()">
        <img id="prev_image" src="<?= $imageAbsDir . 'coursewares/prev.png' ?>">
    </a>
</div>
<div class="coursewarelist-nextpage">
    <a onclick="nextPageElems();" onmouseover="hover_next()" onmouseout="out_next()">
        <img id="next_image" src="<?= $imageAbsDir . 'coursewares/next.png'; ?>"">
    </a>
</div>
<style type="text/css">
    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000;
        opacity: .8;
        /*filter: alpha(opacity=0);*/
        z-index: 50;
        display: none;
    }

    .custom-modal {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 35%;
        height: 38%;
        z-index: 51;
        display: none;
        border-radius: 10%;
    }

    .msg_modal_content {
        position: absolute;
        background: url(<?= base_url('assets/images/frontend/base/warning.png')?>);
        background-size: 100% 100% !important;
        width: 100%;
        height: 100%;
    }

    .msg_modal_content[item_type="login"] {
        background: url(<?= base_url('assets/images/frontend/base/paywarning.png')?>);
    }

    .msg_modal_content[item_type="pay"] {
        background: url(<?= base_url('assets/images/frontend/base/payselect.png')?>);
    }

    .modal-register-btn {
        position: absolute;
        background: url(<?= base_url('/assets/images/frontend/base/login.png')?>);
        background-size: 100% 100% !important;
        left: 50%;
        top: 70%;
        transform: translate(-50%, -50%);
        width: 26%;
        height: 18%;
    }

    .modal-register-btn:hover {
        background: url(<?= base_url('assets/images/frontend/base/login_hover.png')?>);
    }

    .modal-pay-btn {
        position: absolute;
        background: url(<?= base_url('assets/images/frontend/base/pay.png')?>);
        background-size: 100% 100% !important;
        left: 50%;
        top: 81.5%;
        transform: translate(-50%, -50%);
        width: 21%;
        height: 16%;
    }

    .modal-pay-btn:hover {
        background: url(<?= base_url('assets/images/frontend/base/pay_hover.png')?>);
    }

    .modal-weixin-btn,
    .modal-zhifubao-btn {
        position: absolute;
        background: url(<?= base_url('assets/images/frontend/base/weixin.png')?>);
        background-size: 100% 100% !important;
        left: 50%;
        top: 50%;
        /*top: 72.5%;*/
        transform: translate(-50%, -50%);
        width: 60%;
        height: 23%;
    }

    .modal-weixin-btn:hover {
        background: url(<?= base_url('assets/images/frontend/base/weixin_hover.png')?>);
    }

    .modal-zhifubao-btn {
        background: url(<?= base_url('assets/images/frontend/base/zhifubao.png')?>);
        top: 41%;
        display: none;
    }

    .modal-zhifubao-btn:hover {
        /*background: url(
    <?= base_url('assets/images/frontend/base/zhifubao_hover.png')?> );*/
    }

    .modal-price {
        position: absolute;
        background: transparent;
        color: red;
        left: 50.5%;
        top: 57.5%;
        width: 20%;
        text-align: right;
        font-weight: 600;
        font-size: calc(2.2vw);
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .modal-close-btn {
        position: absolute;
        background: url(<?= base_url('assets/images/frontend/base/close.png')?>);
        background-size: 100% 100% !important;
        left: 91%;
        top: 14%;
        transform: translate(-50%, -50%);
        width: 8%;
        height: 12%;
    }

    .modal-close-btn:hover {
        background: url(<?= base_url('assets/images/frontend/base/close_hover.png')?>);
    }
</style>
<div class="modal-backdrop"></div>
<div class="custom-modal" id="warningmsg_content_modal">
    <div class="msg_modal_content" item_type="nologin">
        <a class="modal-close-btn" href="javascript:;" onclick="close_modal()"></a>
        <a class="modal-register-btn" href="<?= base_url('signin/index') ?>"></a>
    </div>
    <div class="msg_modal_content" item_type="login">
        <a class="modal-close-btn" href="javascript:;" onclick="close_modal()"></a>
        <div class="modal-price"></div>
        <a class="modal-pay-btn" href="javascript:;" onclick="pay_select(this);"></a>
    </div>
    <div class="msg_modal_content" item_type="pay">
        <a class="modal-close-btn" href="javascript:;" onclick="close_modal()"></a>
        <a class="modal-zhifubao-btn" href="javascript:;" onclick=""></a>
        <a class="modal-weixin-btn" href="javascript:;" onclick="pay_weixin(this)"></a>
    </div>
</div>
<!-----------Msg content Modal------------>
<script>
    var modal_tmr;
    var isLoggedIn = "<?=$this->session->userdata("loggedin")?>";
    var loginUserId = "<?=$loged_In_user_id?>";
    $(function () {
        // if (setUserInfo() != '' && !isLoggedIn) {
        //     clearInterval(loginTmr)
        //     loginTmr = setInterval(getUserInfo, 1000);
        // }
    });

    //    if(!isLoggedIn) setUserInfo('');
    function close_modal() {
        $('.modal-backdrop, .custom-modal').fadeOut('middle');
        $('#warningmsg_content_modal').fadeOut('middle');
//        $('.modal-backdrop, .custom-modal').animate({'opacity': '0'}, 1000, 'linear', function () {
//            $('.modal-backdrop, .custom-modal').css('display', 'none');
//        });
    }

    function showMsgModal(price) {

        $('.modal-backdrop, .custom-modal').fadeIn('fast');
        if (price != 0) {
            $('.msg_modal_content').hide();
            $('#warningmsg_content_modal').fadeIn('fast');
            if (!isLoggedIn) {
                $('.msg_modal_content[item_type="nologin"]').show();
                clearTimeout(modal_tmr);
                modal_tmr = setTimeout(function () {
//                close_modal();
                }, 2000);
            } else {
                $('.msg_modal_content[item_type="login"]').show();
                $('.modal-price').html((parseFloat(price)).toFixed(1));
                $('.modal-weixin-btn').attr('price', (parseFloat(price)).toFixed(2));
                $('.modal-weixin-btn').attr('open_id', '<?= $this->session->userdata('open_id') ?>');
            }
        } else {

        }
    }

    function pay_select(elem) {
        $('.msg_modal_content').fadeOut('fast');
        $('.msg_modal_content[item_type=pay]').fadeIn('fast');
    }

</script>
<!-------------------Border manage function --------------------------->
<script>

    //alert("Browser Width is" +window.innerWidth);
    //alert("Browser Height is" +window.innerHeight);

    var imgArr = new Array();
    var curPage = 0;
    var elemsPerPage = 6;
    var totalElems = 0;
    var totalPages = 0;
    var imageDir = baseURL + "assets/images/frontend";
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
    var userType = '<?php echo $user_type?>';

    //    $('.courseware-list:first').attr('isFreeAccount', '1');

    window.addEventListener('load', function () {
        var imageList = document.getElementsByClassName('courseware-list');
        initPage();
    });

    function selectOnChina() {
        var baseUrl = $('#select_country_img').data('baseurl');
        $('#select_country_img').attr('src', baseUrl + '/country_cn.png');
        $('#select_country_img').data('country', 'cn');

        initPage();
    }

    function selectWestern() {
        var baseUrl = $('#select_country_img').data('baseurl');
        $('#select_country_img').attr('src', baseUrl + '/country_eu.png');
        $('#select_country_img').data('country', 'eu');
        initPage();
    }

    function initPage() {
        var country = $('#select_country_img').data('country');
        var imageList = document.getElementsByClassName('courseware-list');
        imgArr = new Array();
        curPage = 0;

        country = (country == 'cn') ? '1' : '2';

        for (i = 0; i < imageList.length; i++) {
            var imgTag = imageList[i];
            if (imgTag.getAttribute('unit_type_id') == country) {
                imgArr.push(imgTag);
            }
        }

        totalElems = imgArr.length;
        totalPages = Math.ceil(imgArr.length / elemsPerPage);
        showPage(curPage);
    }

    function showPage(page) {
        $('.courseware-list').hide();
        for (var i = 0; i < totalElems; i++) {
            if (i >= page * elemsPerPage && i < (page + 1) * elemsPerPage) {
                var img = imgArr[i];
                $(img).show();
            }
        }
        $('.page-num .page-cur').html(page + 1);
        $('.page-num .page-total').html(totalPages);
    }

    function nextPageElems() {
        curPage++;
        if (curPage >= totalPages - 1)
            curPage = totalPages - 1;
        showPage(curPage);
    }

    function prevPageElems() {
        curPage--;
        if (curPage <= 0)
            curPage = 0;
        showPage(curPage);
    }

    function hover_prev() {
        $('#prev_image').attr('src', imageDir + '/coursewares/prev_sel.png');
    }

    function out_prev() {
        $('#prev_image').attr('src', imageDir + '/coursewares/prev.png');
    }

    function hover_next() {
        $('#next_image').attr('src', imageDir + '/coursewares/next_sel.png');
    }

    function out_next() {
        $('#next_image').attr('src', imageDir + '/coursewares/next.png');
    }

    function hover_back() {
        $('#back_btn_image').attr('src', imageDir + '/studentwork/back_hover.png');
    }

    function out_back() {
        $('#back_btn_image').attr('src', imageDir + '/studentwork/back.png');
    }

    function return_back(url) {
        location.href = baseURL + url;
    }

</script>
<script src="<?= base_url('assets/js/custom/primary/menu_manage.js') ?>" type="text/javascript"></script>
<script>
    var userRole = '<?= $userRole;?>';
    $('.courseware-list').click(function () {
        var free_course = $(this).attr('free_course');
        var free_account = $(this).attr('isfreeaccount');
        var courseware_id = $(this).attr('unit_course_id');

        if (userType == '') {
            if (typeof free_account !== typeof undefined && free_account !== false) ;
            else {
                alert('需要登录才能查看哦！');
                $(this).attr('href', 'javascript:;');
            }
        }
        if (free_course == '1' || userRole == '1' || free_account == '-1') {
            return 0;
        } else {
            showMsgModal(free_account);
            setCourseId(courseware_id);
            $(this).attr('href', 'javascript:;');
        }
    });
</script>

<img src="<?= base_url('assets/images/owner.png') ?>" style="left: 0;top:94%;width:24%;height:6%;position: absolute">
