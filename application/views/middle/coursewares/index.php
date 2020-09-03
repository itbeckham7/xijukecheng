<?php $listCount = sizeof($cwSets);
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
<style>
    .coursewarelist-wrapper {
        position: absolute;
        left: 3.72%;
        top: 15%;
        width: 94.34%;
        height: 78.22%;
    }

    .coursewarelist-wrapper .courseware-list {
        width: 22.2%;
        height: 45.97%;
        display: inline-block;
        float: left;
        margin-right: 2.6%;
        margin-bottom: 30px;
        position: relative;
    }

    .coursewarelist-wrapper .courseware-list img {
        position: absolute;
    }

    .coursewarelist-wrapper .courseware-list img.courseware-image-item {
        width: 100%;
        height: 98%;
        left: 11px;
        top: 15px;
        border: 5px solid white;
        border-radius: 40px;
        box-shadow: 10px 20px 0 0 #add7ed;
    }

    .coursewarelist-wrapper .courseware-list:hover img.courseware-image-item {
        border-color: #30a4ff;
    }

    .coursewarelist-wrapper .courseware-list > div.corner-flag {
        color: white;
        transform: rotate(-43deg);
        font-size: 40px;
        /*font-weight: bold;*/
        position: absolute;
        left: 20px;
        top: 40px;
    }

    .coursewarelist-wrapper .courseware-list > div.title-flag {
        position: absolute;
        color: white;
        background-color: #30a4ff;
        opacity: .8;
        left: 15px;
        bottom: -3px;
        width: 395px;
        height: 20%;
        border: none;
        border-radius: 0 0 35px 35px;
        font-size: 30px;
        line-height: 1;
        word-break: break-word;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
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

</style>
<div class="bg" style="width: 100%;height:100%;background-color: #e8f9ff;">
    <img src="<?= $imageAbsDir . 'coursewares/bg.png'; ?>" class="background_image">
</div>
<a href="https://shop18725122.m.youzan.com/wscgoods/detail/35wr17wjl4i2i" class="home-link" target="_blank">点击购买读本纸书</a>

<div class="switch">
    <div style="position: relative; height: 100%; display: none; ">
        <img src="<?= $imageAbsDir . 'coursewares/country_cn.png'; ?>" id="select_country_img"
             data-baseurl="<?= base_url('assets/images/middle/coursewares') ?>" data-country="cn">
        <a onclick="selectOnChina()" style="top: 0%; left: 0%; width: 50%; height: 100%;"></a>
        <a onclick="selectWestern()" style="top: 0%; left: 50%; width: 50%; height: 100%;"></a>
    </div>
</div>

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
<a href="javascript:;" onclick="location.replace('<?= base_url('/primary/') ?>');" class="btn-main back-btn"></a>

<!--</div>-->
<div class="coursewarelist-wrapper">
    <?php foreach ($cwSets as $cw): ?>
        <?php
        $imageUrl = $cw->courseware_photo;
        if ($cw->publish != 1) continue;
        foreach ($paidCourse as $item) {
            if ($cw->price > 0 && $cw->courseware_id == $item->courseware_id) {
                $cw->price = -1;
                break;
            }
        }
        ?>
        <a href="<?= base_url() ?>middle/coursewares/view/<?= $cw->courseware_id ?>"
           class="courseware-list"
           unit_course_id="<?= $cw->courseware_id ?>"
           unit_type_id="<?= $cw->unit_type_id ?>"
           free_course="<?= ($cw->price == 0) ? "1" : "0"; ?>"
           isfreeaccount="<?= $cw->price; ?>"
           isvalid="<?= $cw->isvalid; ?>"
           style="display:none">
            <img src="<?= base_url() . $imageUrl ?>" class="courseware-image-item">
            <?php
            if ($cw->price == 0) {
                echo '<img src="' . $imageAbsDir . 'coursewares/free.png" style="width:50%;height:auto;"/>';
                echo '<div class="corner-flag">FREE</div>';
            } else if ($cw->price == -1) {
                echo '<img src="' . $imageAbsDir . 'coursewares/free.png" style="width:50%;height:auto;"/>';
                echo '<div class="corner-flag" style="left:27px;">PAID</div>';
            }
            ?>
            <div class="title-flag"><?= $cw->courseware_name ?></div>
        </a>
    <?php endforeach; ?>
</div>
<!--<div class="coursewarelist-prevpage">-->
<!--    <a onclick="prevPageElems();" onmouseover="hover_prev()" onmouseout="out_prev()">-->
<!--        <img id="prev_image" src="--><? //= $imageAbsDir . 'coursewares/prev.png' ?><!--">-->
<!--    </a>-->
<!--</div>-->
<!--<div class="coursewarelist-nextpage">-->
<!--    <a onclick="nextPageElems();" onmouseover="hover_next()" onmouseout="out_next()">-->
<!--        <img id="next_image" src="--><? //= $imageAbsDir . 'coursewares/next.png'; ?><!--"">-->
<!--    </a>-->
<!--</div>-->
<style type="text/css">

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
        background: url(<?= base_url('assets/images/middle/base/warning.png')?>);
        background-size: 100% 100% !important;
        width: 100%;
        height: 100%;
    }

    .msg_modal_content[item_type="login"] {
        background: url(<?= base_url('assets/images/middle/base/paywarning.png')?>);
    }

    .msg_modal_content[item_type="pay"] {
        background: url(<?= base_url('assets/images/middle/base/payselect.png')?>);
    }

    .modal-register-btn {
        position: absolute;
        background-color: #ff8e85;
        background-size: 100% 100% !important;
        left: 50%;
        top: 70%;
        transform: translate(-50%, -50%);
        width: 26%;
        height: 18%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 10px;
    }

    .modal-register-btn:hover {
        background-color: #ff6a5b;
        text-decoration: none;
        color: white;
    }

    .modal-pay-btn {
        position: absolute;
        background-color: #ff8e85;
        background-size: 100% 100% !important;
        left: 50%;
        top: 78.5%;
        transform: translate(-50%, -50%);
        width: 25%;
        height: 20%;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 10px;
    }

    .modal-pay-btn:hover {
        background-color: #ff6a5b;
        text-decoration: none;
        color: white;
    }

    .modal-weixin-btn,
    .modal-zhifubao-btn {
        position: absolute;
        background: url(<?= base_url('assets/images/middle/base/weixin.png')?>);
        background-size: 100% 100% !important;
        left: 50%;
        top: 50%;
        /*top: 72.5%;*/
        transform: translate(-50%, -50%);
        width: 60%;
        height: 23%;
    }

    .modal-weixin-btn:hover {
        background: url(<?= base_url('assets/images/middle/base/weixin_hover.png')?>);
    }

    .modal-zhifubao-btn {
        background: url(<?= base_url('assets/images/middle/base/zhifubao.png')?>);
        top: 41%;
        display: none;
    }

    .modal-zhifubao-btn:hover {
        background: url(<?= base_url('assets/images/middle/base/zhifubao_hover.png')?> );
    }

    .modal-price {
        position: absolute;
        background: transparent;
        color: red;
        left: 50%;
        top: 50%;
        width: 20%;
        text-align: right;
        font-weight: 600;
        font-size: 40px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .modal-close-btn {
        position: absolute;
        background: url(<?= base_url('assets/images/middle/base/close.png')?>);
        background-size: 100% 100% !important;
        left: 92%;
        top: 9.5%;
        transform: translate(-50%, -50%);
        width: 7%;
        height: 11%;
        cursor: pointer;
    }

    .modal-close-btn:hover {
        /*background: url(*/
    <?//= base_url('assets/images/middle/base/close_hover.png')?> /*);*/
    }
</style>
<div class="modal-backdrop"></div>
<div class="custom-modal" id="warningmsg_content_modal">
    <div class="msg_modal_content" item_type="nologin">
        <a class="modal-close-btn" href="javascript:;" onclick="close_modal()"></a>
        <a class="modal-register-btn" href="<?= base_url('signin/index') ?>">登录</a>
    </div>
    <div class="msg_modal_content" item_type="login">
        <a class="modal-close-btn" href="javascript:;" onclick="close_modal()"></a>
        <div class="modal-price"></div>
        <a class="modal-pay-btn" href="javascript:;" onclick="pay_select(this);">确认购买</a>
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
        if (setUserInfo() != '' && !isLoggedIn) {
            clearInterval(loginTmr)
            loginTmr = setInterval(getUserInfo, 1000);
        }
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
                $('.modal-price').html((parseFloat(price)).toFixed(2));
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
    var elemsPerPage = 8;
    var totalElems = 0;
    var totalPages = 0;
    var imageDir = baseURL + "assets/images/middle";
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
    var userType = '<?php echo $user_type?>';

    // $('.courseware-list:first').attr('isFreeAccount', '1');

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

</script>
<script src="<?= base_url('assets/js/custom/middle/menu_manage.js') ?>" type="text/javascript"></script>
<script>
    var userRole = '<?= $userRole;?>';
    $('.courseware-list').click(function () {
        var free_course = $(this).attr('free_course');
        var free_account = $(this).attr('isfreeaccount');
        var courseware_id = $(this).attr('unit_course_id');
        setSubwareNavId('script_sw');
        if (userType == '') {
            if (typeof free_account !== typeof undefined && free_account !== false) ;
            else {
                alert('需要登录才能查看哦！');
                $(this).attr('href', 'javascript:;');
            }
        }
        if (free_course == '1' || free_account == '-1' /*|| userRole == '1'*/) {
            return 0;
        } else {
            showMsgModal(free_account);
            setCourseId(courseware_id);
            $(this).attr('href', 'javascript:;');
        }
    });
</script>
<!--
<img src="<?= base_url('assets/images/owner.png') ?>" style="left: 0;top:94%;width:24%;height:6%;position: absolute">
-->