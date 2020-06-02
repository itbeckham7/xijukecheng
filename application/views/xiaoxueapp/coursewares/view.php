<?php

$login_status =  $this->session->userdata("loggedin");
$loged_In_user_id = $this->session->userdata("loginuserID");

$imageAbsDir =  base_url().'assets/images/frontend/';
$myworkURL = 'xiaoxueapp/work/student';
$hd_menu_img_path = '';
if($this->session->userdata('loggedin')) {
    $user_type = $this->session->userdata("user_type");
    if($user_type!='1'){
        $myworkURL = 'xiaoxueapp/work/script/'.$loged_In_user_id;
        $hd_menu_img_path = $imageAbsDir.'coursewares/';
    }else{
        $hd_menu_img_path = $imageAbsDir.'coursewares/';
    }
}
?>
<script>
    function isParentExist(){
        return true;
    }
</script>
<style>
    body, html {
        height: 100%;
        margin: 0;
    }
    .background_image {
        position: absolute;
        top: 0;left: 0;
        width:100%;height:100%;
        background-size: contain;
        z-index: -1;
    }

    .back-btn{ position: absolute; left: 93.84%; top: 1.37%; width: 4.31%; height: 7.8%; }
    .back-btn img{ width: 100%; height: 100% }

    .subware-script{ position: absolute;left: 2.61%; top: 1.73%; width: 8.5%; height: 7%; }
    .subware-script img{ width: 100%; height: 100% }
    .subware-script a{ display: block; height: 100%; cursor: pointer; }

    .subware-dubbing{ position: absolute; left: 13.34%; top: 1.73%; width: 8.5%; height: 7%; }
    .subware-dubbing img{ width: 100%; height: 100% }
    .subware-dubbing a{ display: block; height: 100%; cursor: pointer; }

    .subware-flash{ position: absolute; left: 24.16%; top: 0.73%; width: 8.02%; height: 9.3%; }
    .subware-flash img{ width: 100%; height: 100% }
    .subware-flashg a{ display: block; height: 100%; cursor: pointer; }

    .subware-shooting{ position: absolute; left: 35.14%; top: 0.73%; width: 8.02%; height: 9.65%; }
    .subware-shooting img{ width: 100%; height: 100% }
    .subware-shooting a{ display: block; height: 100%; cursor: pointer; }

    .script-content{ position: absolute; left: 0%; top: 10.83%; width: 100%; height: 88.5%; }
    .script-content iframe{ width: 100%; height: 100% }

    .nosubware_msg {
        display:none;position: absolute;top:50%;left:39%;z-index;10000;font-family: 华康方圆体W7;font-weight: bold;color:#984806;font-size:40px;
    }

    body{ overflow: hidden }

</style>
<input type="hidden" id="base_url" value="<?= base_url('xiaoxueapp/')?>">
<div class="bg">
    <img src="<?= base_url('assets/images/xiaoxueapp/coursewares/view/bg.jpg')?>" class="background_image">
</div>


<div class="hdmenu">
    <?php if($this->session->userdata("loggedin") != FALSE): ?>
        <div style="position: relative; height: 100%">
            <img id="course_menu_img" src="<?= $hd_menu_img_path.'profile.png';?>">
<!--            <a onmouseover="hover_work()" onmouseout="out_work()" href="<?= base_url($myworkURL);?>" style="top: 27.2%; left: 1.1%; width: 31.9%; height: 48.5%;"></a>-->
            <a onmouseover="hover_profile()" onmouseout="out_profile()" href="<?= base_url().'xiaoxueapp/users/profile/'.$loged_In_user_id;?>"
               style="top: 3.9%; left: 0%; width: 100%; height: 93%;"></a>
<!--            <a onmouseover="hover_comm()" onmouseout="out_comm()" href="<?= base_url().'community/index';?>" style="top: 27.2%; left: 67%; width: 31.9%; height: 48.5%;"></a>-->
        </div>
    <?php endif; ?>
</div>

<?php if(true || $wxStatus == '1') {?>
<?php if($this->session->userdata("loggedin") == FALSE): ?>
    <a class="register-btn" href="<?= base_url('signin/index')?>"></a>
<?php else: ?>
    <a class="exit-btn" href="<?= base_url('signin/signout')?>"></a>
<?php endif; ?>

<?php }?>
<div class="back-btn">
    <a onmouseover="hover_back()" onmouseout="out_back()" href="#"  onclick="return_back('xiaoxueapp/coursewares/index');">
        <img id="back_btn_image" src="<?= base_url('assets/images/frontend/community/script/back.png')?>">
    </a>
</div>


<?php $subware_isexist = array(
    'script' => 0,
    'flash' => 0,
    'dubbing' => 0,
    'shooting' => 0,
    'song' => 0,
);?>

<?php foreach ($subwares as $subware):?>
    <?php
    $subwareExist = '0';
    $subwarePath = 'nosubware';
    if(file_exists($subware->subware_file.'/index.html'))
    {
        $subwarePath = $subware->subware_file;
    }
    if( $subware->subware_type_slug == 'script' ) : ?>
        <?php $subware_isexist['script'] = 1;?>
        <div class="subware-script">
            <a id="<?= $subware->subware_type_slug ?>"
               data-courseware_id = "<?= $courseware_id ?>"
               subware_path = "<?= $subwarePath.'/index.html?token=091&isZhong=0' ?>"
               subware_publish="<?= $subware->publish;?>">
                <img id="script_image" src="<?= base_url('assets/images/xiaoxueapp/coursewares/view/script.png')?>">
            </a>
        </div>
		<?php elseif( $subware->subware_type_slug == 'song' ) : ?>
        <?php $subware_isexist['song'] = 1; ?>
        <div class="subware-dubbing">
            <a id="<?= $subware->subware_type_slug ?>"
               data-courseware_id = "<?= $courseware_id ?>"
               subware_path = "<?= $subwarePath.'/song.html?token=091' ?>"
               subware_publish="<?= $subware->publish;?>">
                <img id="dubbing_image" src="<?= base_url('assets/images/xiaoxueapp/coursewares/view/dubbing.png')?>">
            </a>
        </div>
    <?php endif; ?>
<?php endforeach;?>

<?php if($subware_isexist['script'] == 0) : ?>
    <div class="subware-script">
        <a id="script" subware_path = "nosubware"><img src="<?= base_url('assets/images/xiaoxueapp/coursewares/view/script.png')?>"></a>
    </div>
<?php endif;?>

<?php if($subware_isexist['song'] == 0) : ?>
    <div class="subware-dubbing">
        <a id="dubbing" subware_path = "nosubware"><img src="<?= base_url('assets/images/xiaoxueapp/coursewares/view/dubbing.png')?>"></a>
    </div>
<?php endif; ?>

<!--
<?php if($subware_isexist['dubbing'] == 0) : ?>
    <div class="subware-dubbing">
        <a id="dubbing" subware_path = "nosubware"><img src="<?= base_url('assets/images/xiaoxueapp/coursewares/view/dubbing.png')?>"></a>
    </div>
<?php endif; ?>

<?php if($subware_isexist['flash'] == 0) : ?>
    <div class="subware-flash" style="display: none;">
        <a id="flash" subware_path = "nosubware"><img src="<?= base_url('assets/images/frontend/coursewares/view/flash.png')?>"></a>
    </div>
<?php endif; ?>

<?php if($subware_isexist['shooting'] == 0) : ?>
    <div class="subware-shooting" style="display: none;">
        <a id="shooting" subware_path = "nosubware"><img src="<?= base_url('assets/images/frontend/coursewares/view/shooting.png')?>"></a>
    </div>
<?php endif; ?>
-->

<div class="script-content">
    <iframe src="" id="courseware_iframe" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" style="border:none"></iframe>
</div>

<p class="nosubware_msg">
    <?= $this->lang->line('CourseDeveloping');?>
</p>

<script>
    var login_status = '<?php if(isset($login_status) && $login_status == true) echo '1' ;else echo '0';?>';
    var login_username = '<?php if(isset($loged_In_user_id)) echo $loged_In_user_id ;else echo '';?>';
    var imageDir = baseURL + "assets/images/frontend";
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
    var curr_sw = 'scrpt_sw';
    function hover_work() { $('#course_menu_img').attr('src',hdmenuImgPath+'hdmenu_mywork_sel.png'); }
    function out_work() { $('#course_menu_img').attr('src',hdmenuImgPath+'hdmenu_normal.png'); }
    function hover_profile() { $('#course_menu_img').attr('src',hdmenuImgPath+'profile_hover.png'); }
    function out_profile() { $('#course_menu_img').attr('src',hdmenuImgPath+'profile.png'); }
    function hover_comm() { $('#course_menu_img').attr('src',hdmenuImgPath+'hdmenu_comm_sel.png'); }
    function out_comm() { $('#course_menu_img').attr('src',hdmenuImgPath+'hdmenu_normal.png');}

    function hover_exit() { $('#exit_image').attr('src',imageDir+'/studentwork/exit_hover.png'); }
    function out_exit() { $('#exit_image').attr('src',imageDir+'/studentwork/exit.png');}

    function hover_register() { $('#register_image').attr('src',imageDir+'/studentwork/register_sel.png'); }
    function out_register() { $('#register_image').attr('src',imageDir+'/studentwork/register.png');}

    function hover_back() { $('#back_btn_image').attr('src',imageDir+'/studentwork/back_hover.png'); }
    function out_back() { $('#back_btn_image').attr('src',imageDir+'/studentwork/back.png');}

    function  return_back(url) {

        if(curr_sw=='script_sw')
        {
            window.location.replace(baseURL+url);
        }else{
            window.location.replace(baseURL+url);
//            history.back();
        }
    }
</script>
<script src="<?= base_url() ?>assets/js/custom/xiaoxueapp/courseware.js"></script>

