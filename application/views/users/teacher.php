<?php $loged_In_user_id = $this->session->userdata("loginuserID");
$teacher_id = $teacher->user_id;
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/menu_manage.css')?>"
      xmlns="http://www.w3.org/1999/html">
<link rel = "stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/profile_teacher.css')?>">
<style>
    .teacher-reference-btn {
        display: none;
    }
    .share_item_title
    {
        background:url(<?= base_url('assets/images/frontend/profile/item_bg.png')?>) no-repeat;
        background-size: 100% 100%;
    }
    .share_item_delete_btn
    {
        background:url(<?= base_url('assets/images/frontend/profile/delete.png')?>) no-repeat;
        background-size: 100% 100%;
    }
    .comment_item_title
    {
        background:url(<?= base_url('assets/images/frontend/profile/item_bg.png')?>) no-repeat;
        background-size: 100% 100%;
    }
    .comment_item_delete_btn
    {
        background:url(<?= base_url('assets/images/frontend/profile/delete.png')?>) no-repeat;
        background-size: 100% 100%;
    }
</style>
<style>
    .custom-checkbox > [type="checkbox"],
    .custom-checkbox > label{
        margin-bottom:0px !important;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .custom-checkbox > [type="checkbox"]:not(:checked),
    .custom-checkbox > [type="checkbox"]:checked {
        position: absolute;
        left: -9999px;
    }
    .custom-checkbox > [type="checkbox"]:not(:checked) + label,
    .custom-checkbox > [type="checkbox"]:checked + label {
        position: relative;
        padding-left: 22px;
        cursor: pointer;
    }
    .custom-checkbox > [type="checkbox"]:not(:checked) + label:before,
    .custom-checkbox > [type="checkbox"]:checked + label:before {
        content: '';
        position: absolute;
        left:0;
        top: 50%;
        margin-top:-9px;
        width: 17px;
        height: 17px;
        border: 1px solid #ddd;
        background: #ffffff;
        border-radius: 2px;
    }
    .custom-checkbox > [type="checkbox"]:not(:checked) + label:after,
    .custom-checkbox > [type="checkbox"]:checked + label:after {
        font: normal normal normal 12px/1 'Glyphicons Halflings';
        content: '\e013';
        position: absolute;
        top: 50%;
        margin-top:-7px;
        left: 2px;
        color: #94C947;
        xtransition: all .2s;
    }

    .custom-checkbox > [type="checkbox"]:not(:checked) + label:after {
        opacity: 0;
        transform: scale(0);
    }
    .custom-checkbox > [type="checkbox"]:checked + label:after {
        opacity: 1;
        transform: scale(1);
    }

    .custom-checkbox > [type="checkbox"][data-indeterminate] + label:after,
    .custom-checkbox > [type="checkbox"][data-indeterminate] + label:after {
        content: '\2212';
        left: 2px;
        opacity: 1;
        transform: scale(1);
    }

    .custom-checkbox > [type="checkbox"]:disabled:not(:checked) + label:before,
    .custom-checkbox > [type="checkbox"]:disabled:checked + label:before {
        box-shadow: none;
        background-color: #eeeeee;
        border-color: #eeeeee;
        cursor: not-allowed;
        opacity: 1;
        color: #dadada;
    }
    .custom-checkbox > [type="checkbox"]:disabled:checked + label:after {
        color: #dadada; cursor: not-allowed;
    }
    .custom-checkbox > [type="checkbox"]:disabled + label {
        color: #aaa; cursor: not-allowed;
    }
    .custom-checkbox > [type="checkbox"]:checked:focus + label:before,
    .custom-checkbox > [type="checkbox"]:not(:checked):focus + label:before {
        border: 1px solid #66afe9;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
    }
    .custom-checkbox > label:hover:before {
        border: 1px solid #88D2FF !important;
    }
    .custom-checkbox > [type="checkbox"]:disabled:not(:checked) + label:hover:before,
    .custom-checkbox > [type="checkbox"]:disabled:checked + label:hover:before{
        border: 1px solid #E4E4E4 !important;
    }
</style>
<div class="bg">
    <img src="<?= base_url('assets/images/frontend/profile/empty_bg1.png')?>" class="background_image">
</div>
<a  onclick="history.back()"
    class="return_btn"
    style="background:url(<?= base_url('assets/images/frontend/studentwork/back.png')?>) no-repeat;background-size: 100% 100%;">
</a>

<div class="profile_bg">
    <img src="<?= base_url('assets/images/frontend/profile/profile_bg.png')?>" class="profile_image">
</div>

<a  href="#" class="change_password_btn"
    style="background:url(<?= base_url('assets/images/frontend/profile/pass_change.png')?>) no-repeat;background-size: 100% 100%;">
</a>

<a  href="#" class="edit_personal_info"
    style="background:url(<?= base_url('assets/images/frontend/profile/info_edit.png')?>) no-repeat;background-size: 100% 100%;">
</a>
<!-----------------------------------teacher personal Info Field--------------------------------------------------------------->
<div class="static_info_fields" >
    <div class="teacher_username_lbl">
        <p id="username_p"><?php echo $teacher->username;?></p>
    </div>
    <div class="teacher_school_lbl">
        <p id="school_p"><?php echo $teacher->school_name;?></p>
    </div>
    <div class="teacher_gender_lbl">
        <p id="gender_p"><?php echo $teacher->sex;?></p>
    </div>
    <div class="teacher_fullname_lbl">
        <p id="fullname_p"><?php echo $teacher->fullname;?></p>
    </div>
    <div class="teacher_nickname_lbl">
        <p id="nickname_p"><?php echo $teacher->nickname;?></p>
    </div>
</div>
<div class="hidden_edit_fields"  style="display:none">
    <div class="teacher_gender_edit">
        <div  id="gender_options">
            <label class="radio-inline" onclick="chooseMale(this);">
                <input type="radio" name="male_radio_btn" class="male_radio_btn"
                       id="<?php echo $this->lang->line('Male')?>">
                <?php echo $this->lang->line('Male')?>
            </label>
            <label class="radio-inline" onclick="chooseFemale(this);">
                <input type="radio" name="female_radio_btn" class="female_radio_btn" id="<?php echo $this->lang->line('Female')?>">
                <?php echo $this->lang->line('Female')?>
            </label>
        </div>
    </div>
    <div class="teacher_fullname_edit">
        <input type="text" class="form-control" id="fullname_input" style="width:80%;" value="<?php echo $teacher->fullname; ?>">
    </div>
    <div class="teacher_nickname_edit">
        <input type="text" class="form-control" id="nickname_input" style="width:80%;" value="<?php echo $teacher->nickname;?>">
    </div>
</div>
<!-----------------------------------class manage Info Field--------------------------------------------------------------------------->
<a  href="#" class="class_manage_btn"
    style="background:url(<?= base_url('assets/images/frontend/profile/classmanage.png')?>) no-repeat;background-size: 100% 100%;">
</a>

<div id="class_list_chks" style="display: none;font-size:16px;transform: scale(1.1);">
    <?php echo $totalclasslist;?>
</div>
<!-----------------------------------Pagination Buttons-------------------------------------------------------------------------------->
<a  href="#" class="share_prev_btn"
    style="background:url(<?= base_url('assets/images/frontend/profile/prev.png')?>) no-repeat;background-size: 100% 100%;">
</a>
<a  href="#" class="share_next_btn"
    style="background:url(<?= base_url('assets/images/frontend/profile/next.png')?>) no-repeat;background-size: 100% 100%;">
</a>
<a  href="#" class="comment_prev_btn"
    style="background:url(<?= base_url('assets/images/frontend/profile/prev.png')?>) no-repeat;background-size: 100% 100%;">
</a>
<a  href="#" class="comment_next_btn"
    style="background:url(<?= base_url('assets/images/frontend/profile/next.png')?>) no-repeat;background-size: 100% 100%;">
</a>
<!-----------------------------------Pagination Buttons---------------------------------------------------------------------------------->
<div class="share_list_wrapper" id="shared_list_area">
</div>
<div class="comment_list_wrapper" id="commented_content_list_area">
</div>
<!---------------------my shared content modal-------------------------------->
<div class="modal fade" id="my_shared_content_del_modal">
    <div class="modal-dialog modal-sm" role="document" style="margin-top:300px">
        <form action="" method="post" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-body" style="text-align: center;padding-left;margin-top:30px;">
                    <p><?php echo $this->lang->line('DeleteConfirmMsg');?></p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-primary"
                                    id="shared_content_delete_btn">
                                <?php echo $this->lang->line('Yes');?></button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="submit" class="btn btn-secondary"  data-dismiss="modal"><?php echo $this->lang->line('No');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!---------------------My Commented content model------------------------------>
<div class="modal fade" id="my_commented_content_del_modal">
    <div class="modal-dialog modal-sm" role="document" style="margin-top: 300px">
        <form action="" method="post" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-body" style="text-align: center;padding-left;margin-top:30px;">
                    <p><?php echo $this->lang->line('DeleteConfirmMsg');?></p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-primary"
                                    id="commented_content_delete_btn">
                                <?php echo $this->lang->line('Yes');?></button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="submit" class="btn btn-secondary"  data-dismiss="modal"><?php echo $this->lang->line('No');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!---------------------Change Password Modal---------------------------------->
<div class="modal fade" id="change_pass_modal">
    <div class="modal-dialog modal-sm" role="document" style="margin-top:200px">
        <form action="" method="post" class="form-horizontal" id="change_password_form">
            <div class="modal-content">
                <div class="modal-body" style="text-align: center;padding-left;margin-top:30px;">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="pwd"><?php echo $this->lang->line('OldPassword');?>:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="old_password" pattern="[a-zA-Z0-9!@#$%^*_|]{6,25}" name="old_password" onkeyup="checkOldPass();">
                        </div>
                    </div>
                    <p id="password_warning_msg" style="color: #f00;display:none"><?php echo $this->lang->line('LimitPassword');?></p>
                    <p id="password_incorrect_msg" style="color: #f00;display:none"><?php echo $this->lang->line('OldPassIncorrect');?></p>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="pwd"><?php echo $this->lang->line('NewPassword');?>:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="new_password"  name="new_password" onkeyup="check_NewPass()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="pwd"><?php echo $this->lang->line('ConfirmPassword');?>:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="confirm_password"  name="confirm_password" onkeyup="check_NewPass()">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-primary"
                                    id="content_delete_btn"
                                    teacher_id = "<?php echo $teacher->user_id;?>"
                                    onclick="updatePassword();">
                                <?php echo $this->lang->line('Save');?></button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="submit" class="btn btn-secondary"  data-dismiss="modal"><?php echo $this->lang->line('No');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>

    var imageDir = baseURL + "assets/images/frontend/profile/";
    var sharedList = '<?php echo json_encode($sharedLists);?>';
    var commentedList = '<?php echo json_encode($commentedLists);?>';
    var teacherId = '<?php echo $teacher_id;?>';
    var classOfTeacher = '<?php echo $teacherclasslist;?>';
    var showedClassListStatus = false;

    var maleStr = '<?php echo $this->lang->line('Male')?>';
    var femaleStr = '<?php echo $this->lang->line('Female')?>';
    var curSexStr = '';
    var classManBtn = $('.class_manage_btn');
    var passEditBtn = $('.change_password_btn');
    var infoEditBtn = $('.edit_personal_info');
    var sharePrevBtn = $('.share_prev_btn');
    var shareNextBtn = $('.share_next_btn');
    var commentPrevBtn = $('.comment_prev_btn');
    var commentNextBtn = $('.comment_next_btn');
    var deleteShareBtn = $('.share_item_delete_btn');

    var saveButtonStatus = false;
    var staticFieldWrapper = $('.static_info_fields');
    var editFieldsWrapper = $('.hidden_edit_fields');

    var maleRadioBtn = $('#male_radio_btn');
    var femaleRadioBtn = $('#female_radio_btn');
    /*******************Static Info Fields wrapper*************************/
    var fullnameLblWrap = $('.teacher_fullname_lbl');
    var genderLblWrap = $('.teacher_gender_lbl');
    var nicknameLblWrap = $('.teacher_nickname_lbl');
    /*******************Static Info Fields*************************/
    var fullname_lbl = $('#fullname_p');
    var nickname_lbl = $('#nickname_p');
    var sex_lbl = $('#gender_p');
    /*******************Editable Info Fields***********************/
    var fullname_edit = $('#fullname_input');
    var nickname_edit = $('#nickname_input');
    var sex_options = $('#gender_options');
    /*********************End********************************************/

    function shareItemDelete(self) {
        var contentId = self.getAttribute('content_id');
        $('#shared_content_delete_btn').attr('content_id',contentId);

        var vHeight = window.innerHeight;
        var dlgHeight = $('#my_shared_content_del_modal .modal-dialog').height();

        $('#my_shared_content_del_modal .modal-dialog').css({'margin-top':(vHeight-dlgHeight)/2});

        $('#my_shared_content_del_modal').modal({backdrop: 'static',keyboard: false});
    }
    function del_hover_btn(self) { self.style.backgroundImage   = "url("+imageDir+"delete_hover.png)"; }
    function del_out_btn(self)  {  self.style.backgroundImage   = "url("+imageDir+"delete.png)"; }
    function commentItemDelete(self) {
        var contentId = self.getAttribute('content_id');
        $('#commented_content_delete_btn').attr('content_id',contentId);

        var vHeight = window.innerHeight;
        var dlgHeight = $('#my_commented_content_del_modal .modal-dialog').height();
        $('#my_commented_content_del_modal .modal-dialog').css({'margin-top':(vHeight-dlgHeight-100)/2});

        $('#my_commented_content_del_modal').modal({backdrop: 'static',keyboard: false});
    }
    function saveProfileInfo(teacherId,teacher_fullname,teacher_nickname,teacher_sex){
        var changedInfo  = {
            user_id:teacherId,
            user_fullname:teacher_fullname,
            user_nickname:teacher_nickname,
            user_sex:teacher_sex
        };
        $.ajax({
            type: "post",
            url: baseURL+"users/update_teacher_personal",
            dataType: "json",
            data: changedInfo,
            success: function(res) {
                if(res.status=='success') {
                    var ret = res.data;
                    sex_lbl.text(ret['sex']);
                    fullname_lbl.text(ret['fullname']);
                    nickname_lbl.text(ret['nickname']);
                    fullnameLblWrap.show();
                    genderLblWrap.show();
                    nicknameLblWrap.show();
                    editFieldsWrapper.hide();
                    saveButtonStatus = false;
                }
                else//failed
                {
                    alert("Cannot Save Teacher Profile Information.");
                }
            }
        })
    }
    infoEditBtn.click(function(){
        if(saveButtonStatus){//current button str is "Save" status
            var teacher_fullname = fullname_edit.val();
            var teacher_nickname = nickname_edit.val();
            saveProfileInfo(teacherId,teacher_fullname,teacher_nickname,curSexStr);
            infoEditBtn.css({"background":"url("+imageDir+"info_edit_hover.png) no-repeat",'background-size' :'100% 100%'});
            ///2. hide edit fields
        }else{
            ///set button text into 'Save'
            saveButtonStatus = true;
            fullnameLblWrap.hide();
            genderLblWrap.hide();
            nicknameLblWrap.hide();
            curSexStr = sex_lbl.text();
            if(curSexStr==maleStr)$('.male_radio_btn').prop('checked',true);
            if(curSexStr==femaleStr)    $('.female_radio_btn').prop('checked',true);
            editFieldsWrapper.show();
            infoEditBtn.css({"background":"url("+imageDir+"save_hover.png) no-repeat",'background-size' :'100% 100%'});
        }
    });
    function chooseMale(self){
        $('.male_radio_btn').prop('checked',true);
        $('.female_radio_btn').prop('checked',false);
        curSexStr = maleStr;
    }
    function chooseFemale(self){
        $('.male_radio_btn').prop('checked',false);
        $('.female_radio_btn').prop('checked',true);
        curSexStr = femaleStr;
    }
    function alphanumeric(inputtxt){
        $('#password_incorrect_msg').hide();
        var letterNumber = /^[0-9a-zA-Z]+$/;
        if(inputtxt.match(letterNumber))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function checkOldPass() {
        var oldPass = $('#old_password').val();
        if(!alphanumeric(oldPass)){
            $('#password_warning_msg').show();
        }else{
            $('#password_warning_msg').hide();
        }
    }
    function check_NewPass(){
        var newPassBox = $('#new_password');
        var confirmPassBox = $('#confirm_password');
        var new_pass = newPassBox.val();
        var confirm_Pass = confirmPassBox.val();

        if(new_pass!=confirm_Pass)
        {
            confirmPassBox.css('border-style','solid');
            confirmPassBox.css('border-color','#f00');
            confirmPassBox.css('border-width','2px');
            $('#content_delete_btn').prop('disabled',true);

        }else{
            confirmPassBox.css('border-style','solid');
            confirmPassBox.css('border-color','#ccc');
            confirmPassBox.css('border-width','1px');
            $('#content_delete_btn').prop('disabled',false);
        }
    }
    function updatePassword(){
        var oldPassBox = $('#old_password');
        var newPassBox = $('#new_password');
        var teacherId = $('#content_delete_btn').attr('teacher_id');
        var old_pass = oldPassBox.val();
        var new_pass = newPassBox.val();
        var changedInfo = {user_id:teacherId,old_pass:old_pass,new_pass:new_pass};
        $.ajax({
            type: "post",
            url: baseURL+"users/update_password",
            dataType: "json",
            data: changedInfo,
            success: function(res) {
                if(res.status=='success') {
                    $('#change_pass_modal').modal('toggle');
                }
                else//failed
                {
                    $('#password_incorrect_msg').show();
                }
            }
        })
    }
    passEditBtn.click(function(){

        $('#old_pass').val('');
        $('#confirm_pass').val('');
        $('#new_pass').val('');
        $('#pass_warning_msg').hide();
        $('#pass_incorrect_msg').hide();

        var vHeight = window.innerHeight;
        var dlgHeight = $('#change_pass_modal .modal-dialog').height();
        $('#change_pass_modal .modal-dialog').css({'margin-top':(vHeight-dlgHeight-130)/2});

        $('#change_pass_modal').modal({
            backdrop: 'static',keyboard: false
        });
    })
</script>
<script src="<?= base_url('assets/js/frontend/menu_manage.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/frontend/profile_teacher.js') ?>" type="text/javascript"></script>