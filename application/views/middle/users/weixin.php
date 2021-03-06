<?php $loged_In_user_id = $this->session->userdata("loginuserID");
$student_id = $student->user_id;
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/menu_manage.css') ?>"
      xmlns="http://www.w3.org/1999/html">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/profile_teacher.css') ?>">
<style>

</style>
<div class="bg" style="background-color: #e8f9ff;">
    <img src="<?= base_url('assets/images/middle/profile/bg-weixin.png') ?>" class="background_image">
</div>
<a href="javascript:;" onclick="history.back();" class="btn-main back-btn"></a>

<div class="profile_bg">
    <img src="<?= base_url('assets/images/middle/profile/profile_bg.png') ?>" class="profile_image">
</div>

<a href="javascript:;" class="btn-profile edit_personal_info">编辑资料</a>
<!-----------------------------------Student personal Info Field--------------------------------------------------------------->
<div class="static_info_fields" >
    <div class="student_username_lbl">
        <p id="username_p"><?php echo $student->username;?></p>
    </div>

    <div class="student_nianji_lbl">
        <p id="nianji_p"><?php echo $student->serial_no; ?></p>
    </div>
    <div class="student_banji_lbl" style="display: none">
        <p id="banji_p"><?php echo substr($student->class,9);?></p>
    </div>
    <div class="student_gender_lbl">
        <p id="gender_p"><?php echo $student->sex;?></p>
    </div>
    <div class="student_fullname_lbl">
        <p id="fullname_p"><?php echo $student->fullname;?></p>
    </div>
    <div class="student_school_lbl" style="display: none">
        <p id="school_p"><?php echo $student->school_name;?></p>
    </div>
    <div class="student_nickname_lbl">
        <p id="nickname_p"><?php echo $student->nickname;?></p>
    </div>
    <div class="student_serialnum_lbl" style="display: none">
        <p id="serialnum_p"><?php echo $student->serial_no;?></p>
    </div>
</div>

<div class="hidden_edit_fields" style="display: none">
    <div class="student_nianji_edit">
        <input class="form-control" id="nianji_select" value="<?php echo $student->serial_no; ?>"/>
    </div>
    <div class="student_banji_edit" style="display: none">
        <select class="form-control" id="banji_select">
        </select>
     </div>
   <div class="student_gender_edit" style="display: none;">
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
    <div class="student_fullname_edit">
        <input type="text" class="form-control" id="fullname_input"  value="<?php echo $student->fullname; ?>">
    </div>
    <div class="student_nickname_edit" style="display: none">
        <input type="text" class="form-control" id="nickname_input"  value="<?php echo $student->nickname;?>">
    </div>
    <div class="student_serialnum_edit" style="display: none">
        <input type="text" class="form-control" id="serialno_input"  value="<?php echo $student->serial_no;?>">
    </div>
</div>

<!-----------------------------------Student personal Info Field--------------------------------------------------------------->
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

<div class="modal fade" id="change_pass_modal">
    <div class="modal-dialog modal-sm" role="document">
        <form action="" method="post" class="form-horizontal" id="change_pass_form">
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
                            <input type="password" class="form-control" id="old_pass"
                                   pattern="[a-zA-Z0-9!@#$%^*_|]{6,25}" placeholder="请输入旧密码"
                                   name="old_pass" onkeyup="checkOldPass();">
                        </div>
                    </div>
                    <p id="pass_warning_msg"
                       style="color: #f00;display:none"><?php echo $this->lang->line('LimitPassword'); ?></p>
                    <p id="pass_incorrect_msg"
                       style="color: #f00;display:none"><?php echo $this->lang->line('OldPassIncorrect'); ?></p>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <img src="<?= base_url('assets/images/middle/profile/input-password.png') ?>">
                            <input type="password" class="form-control" id="new_pass"
                                   name="new_pass" placeholder="请输入新密码"
                                   onkeyup="check_NewPass()">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <img src="<?= base_url('assets/images/middle/profile/input-password.png') ?>">
                            <input type="password" class="form-control" id="confirm_pass"
                                   name="confirm_pass" placeholder="请重新输入新密码"
                                   onkeyup="check_NewPass()">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="button" class="btn btn-red"
                                    teacher_id="<?php echo $student->user_id; ?>"
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
<!---------------------My commented content modal------------------------------->
<input hidden class="_paidList" value='<?= json_encode($paidLists); ?>'/>
<script>
    var deleteStr = '<?php echo $this->lang->line('Delete')?>';
    var classArr = '<?php echo $student->class_arr;?>';
    var paidList = $('._paidList').val();
    var student_id = '<?php echo $student_id;?>';
    var imageDir = baseURL + "assets/images/middle/profile/";
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
    /*******************Static Info Fields wrapper*************************/
    var fullnameLblWrap = $('.student_fullname_lbl');
    var nanjiLblWrap = $('.student_nianji_lbl');
    var banjiLblWrap = $('.student_banji_lbl');
    var genderLblWrap = $('.student_gender_lbl');
    var nicknameLblWrap = $('.student_nickname_lbl');
    var serialLblNumWarp = $('.student_serialnum_lbl');
    /*******************Static Info Fields*************************/
    var fullname_lbl = $('#fullname_p');
    var grade_lbl = $('#nianji_p');
    var nianclass_lbl = $('#banji_p');
    var nickname_lbl = $('#nickname_p');
    var sex_lbl = $('#gender_p');
    var serial_no_lbl = $('#serialnum_p');
    /*******************Editable Info Fields wrapper***********************/
    var nanjiEditWrap = $('.student_nianji_edit');
    var banjiEditWrap = $('.student_banji_edit');
    var genderEditWrap = $('.student_gender_edit');
    var fullNameEditWrap = $('.student_fullname_edit');
    var serialEditWrap = $('.student_serialnum_edit');
    /*******************Editable Info Fields***********************/
    var fullname_edit = $('#fullname_input');
    var grade_select = $('#nianji_select');
    var nianclass_select = $('#banji_select');
    var nickname_edit = $('#nickname_input');
    var sex_options = $('#gender_options');
    var serial_no_edit = $('#serialno_input');
    /*********************End********************************************/
    var maleStr = '<?php echo $this->lang->line('Male')?>';
    var femaleStr = '<?php echo $this->lang->line('Female')?>';
    var curSexStr = '';

    var oneStr = '<?php echo $this->lang->line('0');?>';
    var twoStr = '<?php echo $this->lang->line('1');?>';
    var threeStr = '<?php echo $this->lang->line('2');?>';
    var fourStr = '<?php echo $this->lang->line('3');?>';
    var fiveStr = '<?php echo $this->lang->line('4');?>';
    var totalNumberList = {
        1: oneStr,
        2: twoStr,
        3: threeStr,
        4: fourStr,
        5: fiveStr
    };
    var classChineseStr = '<?php echo $this->lang->line('Class');?>';
    var gradeChineseStr = '<?php echo $this->lang->line('NianGrade');?>';

    function shareItemDelete(self) {
        var contentId = self.getAttribute('content_id');

        var vHeight = window.innerHeight;
        var dlgHeight = $('#my_shared_content_del_modal .modal-dialog').height();
        $('#my_shared_content_del_modal .modal-dialog').css({'margin-top': (vHeight - dlgHeight - 100) / 2});

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
    function showEditInfoFields()
    {
       nanjiLblWrap.hide();
//        banjiLblWrap.hide();
//        serialLblNumWarp.hide();
//        nicknameLblWrap.hide();
//        genderLblWrap.hide();
        fullnameLblWrap.hide();
        editFieldsWrapper.show();
    }
    function hideEditInfoFields()
    {
       nanjiLblWrap.show();
//        banjiLblWrap.show();
//        serialLblNumWarp.show();
//        nicknameLblWrap.show();
//        genderLblWrap.show();
        fullnameLblWrap.show();
        editFieldsWrapper.hide();
    }
    function updateClassListFromGradeNo(gradeStr){
        var classNumOfGrade = $('#grade-'+gradeStr).attr('class_num');
        var classListHtml = '';
        for(var i = 0;i<classNumOfGrade;i++){
            var tmpStr = totalNumberList[i+1]+classChineseStr;
            classListHtml +='<option>'+tmpStr+'</option>';
        }
        nianclass_select.html(classListHtml);
    }
    function initEditableFields(){
        var sexStr = sex_lbl.text();
        curSexStr = sexStr;
        if(sexStr!='') $('#'+sexStr).prop('checked',true);
        ///get grade/class information
        var gradeAndClassStr = grade_lbl.text();
        var real_grade = gradeAndClassStr.substring(0,5);///student's grade number

        var gradeObjList = [];//$.parseJSON(classArr);
        ///At first add all grades in a school to grade select option
        ///-----------------------------------------add grade list of select input box
        var gradeList = '';
        for(var i = 0 ;i<gradeObjList.length;i++)
        {
            var gradeObj = gradeObjList[i];
            var gradeNo = gradeObj['grade'];
            var gradeItem = totalNumberList[gradeNo]+gradeChineseStr;
            gradeList += '<option class_num = "'+gradeObj['class'] +'" id = "grade-'+gradeItem+'">'+gradeItem+'</option>';
        }
        grade_select.html(gradeList);
        ///------------------------------------------select real grade number of grade list
        grade_select.find('option').filter(function (){
            return ( ($(this).val() == real_grade) || ($(this).text() == real_grade) )
        }).prop('selected',true);
        ///init class list of selected grade
        updateClassListFromGradeNo(real_grade);
        ///select class at class list
        var real_class = nianclass_lbl.html();
        nianclass_select.find('option').filter(function (){
            return ( ($(this).val() == real_class) || ($(this).text() == real_class) )
        }).prop('selected',true);
    }
    initEditableFields();
    grade_select.on('change',function(){
        updateClassListFromGradeNo(this.value);
    });

    function updateStudentProfile(){

        var changedClassStr = grade_select.val() + nianclass_select.val() ;
        if(!changedClassStr) changedClassStr = '';
        var sexStr = '', fullname = '', nickname = '', serialNo = '';
        fullname = fullname_edit.val();
        nickname = nickname_edit.val();
        serialNo = grade_select.val();
        var changedInfo = {
            user_id: student_id,
            fullname: fullname,
            serialno: serialNo
        };
        $.ajax({
            type: "post",
            url: baseURL + "middle/users/update_weixin_person",
            dataType: "json",
            data: changedInfo,
            success: function (res) {
                if (res.status == 'success') {
                    ///res.data is updated information
                    var ret = res.data;
                    grade_lbl.text(grade_select.val());
                    nianclass_lbl.text(nianclass_select.val());
                    sex_lbl.text(ret['sex']);
                    fullname_lbl.text(ret['fullname']);
                    nickname_lbl.text(ret['nickname']);
                    serial_no_lbl.text(ret['serial_no']);
                } else//failed
                {
                    alert("Cannot Save Teacher Profile Information.");
                }
            }

        });
    }

    infoEditBtn.click(function () {
        if (saveButtonStatus) {//current button str is "Save" status
            ///1. update of profile information in table
            updateStudentProfile();
            hideEditInfoFields();
            saveButtonStatus = false;
            infoEditBtn.html('编辑资料');
            ///2. hide edit fields
        } else {
            ///set button text into 'Save'
            showEditInfoFields();
            saveButtonStatus = true;
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
        $('#pass_incorrect_msg').hide();
        var letterNumber = /^[0-9a-zA-Z]+$/;
        if (inputtxt.match(letterNumber)) {
            return true;
        } else {
            return false;
        }
    }

    function checkOldPass() {
        var oldPass = $('#old_pass').val();
        if (!alphanumeric(oldPass)) {
            $('#pass_warning_msg').show();
        } else {
            $('#pass_warning_msg').hide();
        }
    }

    function check_NewPass() {
        var newPassBox = $('#new_pass');
        var confirmPassBox = $('#confirm_pass');
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
        var oldPassBox = $('#old_pass');
        var newPassBox = $('#new_pass');
        var studentId = $('#content_delete_btn').attr('student_id');
        var old_pass = oldPassBox.val();
        var new_pass = newPassBox.val();
        var changedInfo = {user_id: studentId, old_pass: old_pass, new_pass: new_pass};
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
                    $('#pass_incorrect_msg').show();
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
<script src="<?= base_url('assets/js/custom/middle/profile_weixin.js') ?>" type="text/javascript"></script>