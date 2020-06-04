<?php $loged_In_user_id = $this->session->userdata("loginuserID");
$teacher_id = $teacher->user_id;
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/menu_manage.css') ?>"
      xmlns="http://www.w3.org/1999/html">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/profile_teacher.css') ?>">

<style>
    .custom-checkbox > [type="checkbox"],
    .custom-checkbox > label {
        margin-bottom: 0px !important;
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
        left: 0;
        top: 50%;
        margin-top: -9px;
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
        margin-top: -7px;
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
        color: #dadada;
        cursor: not-allowed;
    }

    .custom-checkbox > [type="checkbox"]:disabled + label {
        color: #aaa;
        cursor: not-allowed;
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
    .custom-checkbox > [type="checkbox"]:disabled:checked + label:hover:before {
        border: 1px solid #E4E4E4 !important;
    }
</style>
<div class="bg" style="background-color: #e8f9ff;">
    <img src="<?= base_url('assets/images/middle/profile/bg-teacher.png') ?>" class="background_image">
</div>
<a href="javascript:;" onclick="history.back();" class="btn-main back-btn"></a>

<div class="profile_bg">
    <img src="<?= base_url('assets/images/middle/profile/profile_bg.png') ?>" class="profile_image">
</div>

<a href="javascript:;" class="btn-profile change_password_btn">密码修改</a>
<a href="javascript:;" class="btn-profile edit_personal_info">编辑资料</a>
<!-----------------------------------teacher personal Info Field--------------------------------------------------------------->
<div class="static_info_fields">
    <div class="teacher_username_lbl">
        <p id="username_p"><?php echo $teacher->username; ?></p>
    </div>
    <div class="teacher_fullname_lbl">
        <p id="fullname_p"><?php echo $teacher->fullname; ?></p>
    </div>
    <div class="teacher_school_lbl">
        <p id="school_p"><?php echo $teacher->school_name; ?></p>
    </div>
    <div class="teacher_gender_lbl">
        <p id="gender_p"><?php echo $teacher->sex; ?></p>
    </div>
    <div class="teacher_nickname_lbl">
        <p id="nickname_p"><?php echo $teacher->nickname; ?></p>
    </div>
</div>
<div class="hidden_edit_fields" style="display:none">
    <div class="teacher_gender_edit">
        <div id="gender_options">
            <label class="radio-inline" onclick="chooseMale(this);">
                <input type="radio" name="male_radio_btn" class="male_radio_btn"
                       id="<?php echo $this->lang->line('Male');
                       ?>"><?php echo $this->lang->line('Male') ?></label>
            <label class="radio-inline" onclick="chooseFemale(this);">
                <input type="radio" name="female_radio_btn" class="female_radio_btn"
                       id="<?php echo $this->lang->line('Female');
                       ?>"><?php echo $this->lang->line('Female') ?></label>
        </div>
    </div>
    <div class="teacher_fullname_edit">
        <input type="text" class="form-control" id="fullname_input" style="width:80%;"
               value="<?php echo $teacher->fullname; ?>">
    </div>
    <div class="teacher_nickname_edit">
        <input type="text" class="form-control" id="nickname_input" style="width:80%;"
               value="<?php echo $teacher->nickname; ?>">
    </div>
</div>
<!-----------------------------------class manage Info Field--------------------------------------------------------------------------->
<a href="javascript:;" class="btn-profile class_manage_btn">班级管理</a>

<div id="class_list_chks" style="display: none;font-size:16px;transform: scale(1.1);">
    <?php echo $totalclasslist; ?>
</div>
<!-----------------------------------Pagination Buttons-------------------------------------------------------------------------------->
<a href="javascript:;" class="btn-profile share_prev_btn"></a>
<a href="javascript:;" class="btn-profile share_next_btn"></a>
<a href="javascript:;" class="btn-profile comment_prev_btn"></a>
<a href="javascript:;" class="btn-profile comment_next_btn"></a>
<!-----------------------------------Pagination Buttons---------------------------------------------------------------------------------->
<div class="share_list_wrapper" id="shared_list_area"></div>
<div class="comment_list_wrapper" id="commented_content_list_area"></div>
<!---------------------my shared content modal-------------------------------->
<div class="modal fade" id="my_shared_content_del_modal">
    <div class="modal-dialog modal-sm" role="document">
        <form action="" method="post" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header"
                     style="padding-right:20px;padding-top: 3px;padding-bottom: 10px;text-align: center">
                    <h5 class="modal-title"
                        style="margin-top: 5px;font-weight: bold"></h5>
                </div>
                <div class="modal-body" style="text-align: center">
                    <h3 class="modal-title"
                        style="margin: 30px 0;font-weight: bold"><?php echo $this->lang->line('DeleteConfirmMsg'); ?></h3>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-red"
                                    id="shared_content_delete_btn"><?php echo $this->lang->line('Yes'); ?></button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-blue"
                                    data-dismiss="modal"><?php echo $this->lang->line('No'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!---------------------My Commented content model------------------------------>
<div class="modal fade" id="my_commented_content_del_modal">
    <div class="modal-dialog modal-sm" role="document">
        <form action="" method="post" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header"
                     style="padding-right:20px;padding-top: 3px;padding-bottom: 10px;text-align: center">
                    <h5 class="modal-title"
                        style="margin-top: 5px;font-weight: bold"></h5>
                </div>
                <div class="modal-body" style="text-align: center">
                    <h3 class="modal-title"
                        style="margin: 30px 0;font-weight: bold"><?php echo $this->lang->line('DeleteConfirmMsg'); ?></h3>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-red"
                                    id="commented_content_delete_btn"
                            ><?php echo $this->lang->line('Yes'); ?></button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-blue"
                                    data-dismiss="modal"
                            ><?php echo $this->lang->line('No'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!---------------------Change Password Modal---------------------------------->
<div class="modal fade" id="change_pass_modal">
    <div class="modal-dialog modal-sm" role="document">
        <form action="" method="post" class="form-horizontal" id="change_password_form">
            <div class="modal-content" style="width: 480px;height: auto;">
                <div class="modal-header"
                     style="padding-right:20px;padding-top: 3px;padding-bottom: 10px;text-align: center">
                    <h5 class="modal-title"
                        style="margin-top: 5px;font-weight: bold"></h5>
                </div>
                <div class="modal-body" style="text-align: center;height: auto;padding: 30px 20px 15px;">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <img src="<?= base_url('assets/images/middle/profile/input-password.png') ?>">
                            <input type="password" class="form-control" id="old_password"
                                   pattern="[a-zA-Z0-9!@#$%^*_|]{6,25}" placeholder="请输入旧密码"
                                   name="old_password" onkeyup="checkOldPass();">
                        </div>
                    </div>
                    <p id="password_warning_msg"
                       style="color: #f00;display:none"><?php echo $this->lang->line('LimitPassword'); ?></p>
                    <p id="password_incorrect_msg"
                       style="color: #f00;display:none"><?php echo $this->lang->line('OldPassIncorrect'); ?></p>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <img src="<?= base_url('assets/images/middle/profile/input-password.png') ?>">
                            <input type="password" class="form-control" id="new_password"
                                   name="new_password" placeholder="请输入新密码"
                                   onkeyup="check_NewPass()">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <img src="<?= base_url('assets/images/middle/profile/input-password.png') ?>">
                            <input type="password" class="form-control" id="confirm_password"
                                   name="confirm_password" placeholder="请重新输入新密码"
                                   onkeyup="check_NewPass()">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-red"
                                    teacher_id="<?php echo $teacher->user_id; ?>"
                                    onclick="updatePassword();"
                                    id="content_delete_btn"><?php echo $this->lang->line('Save'); ?></button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-blue"
                                    data-dismiss="modal"><?php echo $this->lang->line('No'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<input hidden class="_sharedList" value='<?= json_encode($sharedLists); ?>'/>
<input hidden class="_commentedList" value='<?= json_encode($commentedLists); ?>'/>
<script>

    var imageDir = baseURL + "assets/images/middle/profile/";
    var sharedList = $('._sharedList').val();
    var commentedList = $('._commentedList').val();
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
        $('#shared_content_delete_btn').attr('content_id', contentId);

        $('#my_shared_content_del_modal').modal({backdrop: 'static', keyboard: false});
    }

    function del_hover_btn(self) {
    }

    function del_out_btn(self) {
    }

    function commentItemDelete(self) {
        var contentId = self.getAttribute('content_id');
        $('#commented_content_delete_btn').attr('content_id', contentId);
        $('#my_commented_content_del_modal').modal({backdrop: 'static', keyboard: false});
    }

    function saveProfileInfo(teacherId, teacher_fullname, teacher_nickname, teacher_sex) {
        var changedInfo = {
            user_id: teacherId,
            user_fullname: teacher_fullname,
            user_nickname: teacher_nickname,
            user_sex: teacher_sex
        };
        $.ajax({
            type: "post",
            url: baseURL + "middle/users/update_teacher_personal",
            dataType: "json",
            data: changedInfo,
            success: function (res) {
                if (res.status == 'success') {
                    var ret = res.data;
                    sex_lbl.text(ret['sex']);
                    fullname_lbl.text(ret['fullname']);
                    nickname_lbl.text(ret['nickname']);
                    fullnameLblWrap.show();
                    genderLblWrap.show();
                    nicknameLblWrap.show();
                    editFieldsWrapper.hide();
                    saveButtonStatus = false;
                } else//failed
                {
                    alert("Cannot Save Teacher Profile Information.");
                }
            }
        })
    }

    infoEditBtn.click(function () {
        if (saveButtonStatus) {//current button str is "Save" status
            var teacher_fullname = fullname_edit.val();
            var teacher_nickname = nickname_edit.val();
            saveProfileInfo(teacherId, teacher_fullname, teacher_nickname, curSexStr);
            infoEditBtn.html('编辑资料');
            ///2. hide edit fields
        } else {
            ///set button text into 'Save'
            saveButtonStatus = true;
            fullnameLblWrap.hide();
            genderLblWrap.hide();
            nicknameLblWrap.hide();
            curSexStr = sex_lbl.text();
            if (curSexStr == maleStr) $('.male_radio_btn').prop('checked', true);
            if (curSexStr == femaleStr) $('.female_radio_btn').prop('checked', true);
            editFieldsWrapper.show();
            infoEditBtn.html('保存');
        }
    });

    function chooseMale(self) {
        $('.male_radio_btn').prop('checked', true);
        $('.female_radio_btn').prop('checked', false);
        curSexStr = maleStr;
    }

    function chooseFemale(self) {
        $('.male_radio_btn').prop('checked', false);
        $('.female_radio_btn').prop('checked', true);
        curSexStr = femaleStr;
    }

    function alphanumeric(inputtxt) {
        $('#password_incorrect_msg').hide();
        var letterNumber = /^[0-9a-zA-Z]+$/;
        if (inputtxt.match(letterNumber)) {
            return true;
        } else {
            return false;
        }
    }

    function checkOldPass() {
        var oldPass = $('#old_password').val();
        if (!alphanumeric(oldPass)) {
            $('#password_warning_msg').show();
        } else {
            $('#password_warning_msg').hide();
        }
    }

    function check_NewPass() {
        var newPassBox = $('#new_password');
        var confirmPassBox = $('#confirm_password');
        var new_pass = newPassBox.val();
        var confirm_Pass = confirmPassBox.val();

        if (new_pass != confirm_Pass) {
            confirmPassBox.css('border-style', 'solid');
            confirmPassBox.css('border-color', '#f00');
            confirmPassBox.css('border-width', '2px');
            $('#content_delete_btn').prop('disabled', true);

        } else {
            confirmPassBox.css('border-style', 'solid');
            confirmPassBox.css('border-color', '#ccc');
            confirmPassBox.css('border-width', '1px');
            $('#content_delete_btn').prop('disabled', false);
        }
    }

    function updatePassword() {
        var oldPassBox = $('#old_password');
        var newPassBox = $('#new_password');
        var teacherId = $('#content_delete_btn').attr('teacher_id');
        var old_pass = oldPassBox.val();
        var new_pass = newPassBox.val();
        var changedInfo = {user_id: teacherId, old_pass: old_pass, new_pass: new_pass};
        $.ajax({
            type: "post",
            url: baseURL + "middle/users/update_password",
            dataType: "json",
            data: changedInfo,
            success: function (res) {
                if (res.status == 'success') {
                    $('#change_pass_modal').modal('toggle');
                } else//failed
                {
                    $('#password_incorrect_msg').show();
                }
            }
        })
    }

    passEditBtn.click(function () {

        $('#old_pass').val('');
        $('#confirm_pass').val('');
        $('#new_pass').val('');
        $('#pass_warning_msg').hide();
        $('#pass_incorrect_msg').hide();
        $('#change_pass_modal').modal({
            backdrop: 'static', keyboard: false
        });
    })
</script>
<script src="<?= base_url('assets/js/custom/middle/menu_manage.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/custom/middle/profile_teacher.js') ?>" type="text/javascript"></script>