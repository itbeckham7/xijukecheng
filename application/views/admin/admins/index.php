<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('AdminManagement');?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!------Tool bar parts (add button and search function------>
                        <div class="row">
                            <div class="col-md-3">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><?php echo $this->lang->line('AccountName');?>:</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id = "account_name_search" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-offset-7 col-md-2" align="right">
                                <div class="btn-group">
                                    <button  class=" btn blue" id = "add_new_admin_btn"> <i class="fa fa-plus"></i>&nbsp<?php echo $this->lang->line('AddNewAdmin');?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!------Tool bar parts (add button and search function------>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="adminInfo_tbl">
                            <thead>
                            <tr>
                                <th style="width:16%;"><?php echo $this->lang->line('SerialNumber');?></th>
                                <th style="width:22%;"><?php echo $this->lang->line('AccountName');?></th>
                                <th style="width:22%;"><?php echo $this->lang->line('AdminLabel');?></th>
                                <th style="width:40%;"><?php echo $this->lang->line('Operation');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($admins as $admin):?>
                                <tr style="display: none">
                                <td><?php echo $admin->admin_id;?></td>
                                <td><?php echo $admin->admin_name;?></td>
                                <td hidden><?php echo $admin->admin_pass;?></td>
                                <td><?php echo $admin->admin_label;?></td>
                                <td hidden><?php echo $admin->permission;?></td>
                                <td>
                                    <button style="width:70px;" class="btn btn-sm btn-success" onclick="edit_admin(this);"    admin_id = <?php echo $admin->admin_id;?>><?php echo $this->lang->line('Modify');?></button>
                                    <button style="width:70px;" class="btn btn-sm btn-warning" onclick="delete_admin(this);"  admin_id = <?php echo $admin->admin_id;?>><?php echo $this->lang->line('Delete');?></button>
                                    <button style="width:70px;" class="btn btn-sm btn-danger"  onclick="assign_admin(this);" admin_id = <?php echo $admin->admin_id;?>><?php echo $this->lang->line('AssignMenu');?></button>
                                </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                      <div id="adminpageNavPosition"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!---add new admin modal--->
<div id="add_admin_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewUser');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action=""  id="add_admin_submit_form" role="form" method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-4 control-label" style="text-align:center;"><?php echo $this->lang->line('Name');?>:</label>
                    <div class="col-md-7" style="padding-left: 0">
                        <input type="text" class="form-control" name="add_admin_fullname" id="add_add_fullname" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" style="text-align:center;"><?php echo $this->lang->line('Password');?>:</label>
                    <div class="col-md-7" style="padding-left: 0">
                        <input type="password" class="form-control" name="add_admin_password" id="add_admin_password" value="" onkeyup="confirmPassword();">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" style="text-align:center;" ><?php echo $this->lang->line('RepetPassword');?>:</label>
                    <div class="col-md-7" style="padding-left: 0">
                        <input type="password" class="form-control"  onkeyup="confirmPassword();" name="add_admin_repeatpassword" id="add_admin_repeatpassword" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" style="text-align:center;"><?php echo $this->lang->line('AdminLabel');?>:</label>
                    <div class="col-md-7" style="padding-left: 0">
                        <input type="text" class="form-control" name="add_admin_label" id="add_admin_label" value="">
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-4">
                            <button type = "submit" class="btn green" id = 'add_admin_saveBtn'style="margin-top:10px;width:120%"><?php echo $this->lang->line('Save');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!---add new admin modal--->
<!----delete modal-->
<div id="admin_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message');?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage');?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" id="delete_admin_btn"><?php echo $this->lang->line('Yes');?></button>
        <button type="button" data-dismiss="modal"  class="btn btn-outline dark"><?php echo $this->lang->line('No');?></button>
    </div>
</div>
<!----edit admin modal--->
<div id="edit_admin_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('ModifyAdmin');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action=""  id="edit_admin_submit_form" role="form" method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-4 control-label" style="text-align:center;"><?php echo $this->lang->line('Name');?>:</label>
                    <label class="col-md-7 control-label" id="edit_admin_fullname" style="text-align:left;font-weight:bold;"><?php echo $this->lang->line('Name');?>:</label>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" style="text-align:center;"><?php echo $this->lang->line('Password');?>:</label>
                    <div class="col-md-7" style="pediting-left: 0">
                        <input type="password" class="form-control" name="edit_admin_password" id="edit_admin_password" value="" onkeyup="confirmEditPassword();">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" style="text-align:center;" ><?php echo $this->lang->line('RepetPassword');?>:</label>
                    <div class="col-md-7" style="pediting-left: 0">
                        <input type="password" class="form-control"   name="edit_admin_repeatpassword" id="edit_admin_repeatpassword" value="" onkeyup="confirmEditPassword();">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" style="text-align:center;"><?php echo $this->lang->line('AdminLabel');?>:</label>
                    <div class="col-md-7" style="pediting-left: 0">
                        <input type="text" class="form-control" name="edit_admin_label" id="edit_admin_label" value="">
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-4">
                            <button type = "submit" class="btn green" id = 'edit_admin_saveBtn'style="margin-top:10px;width:120%"><?php echo $this->lang->line('Save');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-------Modal to Assign Role to admin ---------->
<div id="assign_admin_modal" class="modal fade" tabindex="-1" data-width="580">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AdminAssignManage');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action=""  id="assign_admin_submit_form" role="form" method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4" style="text-align:center">
                            <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                <input type="checkbox" id="CourseManagement_chk"><?php echo $this->lang->line('CourseManagement');?>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10" style="text-align: center">
                            <table class="table custom_tbl_borderless">
                                <tr>
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                            <input type="checkbox" id="CourseProjectManagement_chk"><?php echo $this->lang->line('CourseProjectManagement');?>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                            <input type="checkbox" id="CourseUnitManagement_chk"><?php echo $this->lang->line('CourseUnitManagement');?>
                                            <span></span>

                                        </label>
                                    </td>
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                            <input type="checkbox" id="UnitSubwareManagement_chk"><?php echo $this->lang->line('UnitSubwareManagement');?>
                                            <span></span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4" style="text-align:center">
                            <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                <input type="checkbox" id="AccountManagement_chk"><?php echo $this->lang->line('AccountManagement');?>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10" style="text-align: center;padding-left: 0">
                            <table class="table custom_tbl_borderless">
                                <tr>
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                            <input type="checkbox" id="UserManagement_chk"><?php echo $this->lang->line('UserManagement');?>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                            <input type="checkbox" id="AdminManagement_chk"><?php echo $this->lang->line('AdminManagement');?>
                                            <span></span>

                                        </label>
                                    </td>
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                            <input type="checkbox" id="LogView_chk"><?php echo $this->lang->line('LogView');?>
                                            <span></span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4" style="text-align:center">
                            <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                <input type="checkbox" id="CommunityManagement_chk"><?php echo $this->lang->line('CommunityManagement');?>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10" style="text-align: center">
                            <table class="table custom_tbl_borderless">
                                <tr>
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                            <input type="checkbox" id="ContentManagement_chk"><?php echo $this->lang->line('ContentManagement');?>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td colspan="2" style="text-align: left;">
                                        <label class="mt-checkbox mt-checkbox-outline" style="font-weight:bold">
                                            <input type="checkbox" id="CommentManagement_chk"><?php echo $this->lang->line('CommentManagement');?>
                                            <span></span>

                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-4">
                            <button type = "submit" class="btn green" id = 'assign_admin_saveBtn' style="margin-top:10px"><?php echo $this->lang->line('Save');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-------Modal to Assign Role to admin ---------->
<script>
    //*************************pagenation module
    var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
    var nextstr = "<?php echo $this->lang->line('NextPage');?>";
    var currentShowedPage = 1;
    var showedItems = 20;
    function Pager(tableName, itemsPerPage) {

        this.tableName = tableName;
        this.itemsPerPage = itemsPerPage;
        this.currentPage = 1;
        this.pages = 0;
        this.inited = false;

        this.showRecords = function(from, to) {
            var rows = document.getElementById(tableName).rows;
            // i starts from 1 to skip table header row
            for (var i = 1; i < rows.length; i++) {
                if (i < from || i > to)
                    rows[i].style.display = 'none';
                else
                    rows[i].style.display = '';
            }
        }

        this.showPage = function(pageNumber) {
            if (! this.inited) {
                alert("not inited");
                return;
            }
            var oldPageAnchor = document.getElementById('pg'+this.currentPage);
            oldPageAnchor.className = 'pg-normal';

            this.currentPage = pageNumber;
            var newPageAnchor = document.getElementById('pg'+this.currentPage);
            newPageAnchor.className = 'pg-selected';

            var from = (pageNumber - 1) * itemsPerPage + 1;
            var to = from + itemsPerPage - 1;
            this.showRecords(from, to);
        }

        this.prev = function() {
            if (this.currentPage > 1){

                currentShowedPage = this.currentPage - 1;
                this.showPage(this.currentPage - 1);
            }

        }

        this.next = function() {
            if (this.currentPage < this.pages) {

                currentShowedPage = this.currentPage + 1;
                this.showPage(this.currentPage + 1);
            }
        }

        this.init = function() {
            var rows = document.getElementById(tableName).rows;
            var records = (rows.length - 1);
            this.pages = Math.ceil(records / itemsPerPage);
            this.inited = true;
        }
        this.showPageNav = function(pagerName, positionId) {
            if (! this.inited) {
                alert("not inited");
                return;
            }
            var element = document.getElementById(positionId);

            var pagerHtml = '<button class = "btn btn blue" onclick="' + pagerName + '.prev();" class="pg-normal">'+prevstr+ '</button>  ';
            for (var page = 1; page <= this.pages; page++)
                pagerHtml += '<button hidden id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</button>  ';
            pagerHtml += '<button  class = "btn btn blue" onclick="'+pagerName+'.next();" class="pg-normal">'+nextstr+'</button>';

            element.innerHTML = pagerHtml;
        }
    }
    var pager = new Pager('adminInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'adminpageNavPosition');
    pager.showPage(currentShowedPage);

    function executionPageNation()
    {
        pager.showPageNav('pager', 'adminpageNavPosition');
        pager.showPage(currentShowedPage);
    }
    //pagenation module

</script>
<script>



var cs_pro_st = '0';
var cs_unit_st = '0';
var unit_sub_st = '0';
var user_st = '0';
var admin_st = '0';
var logview_st = '0';
var content_st = '0';
var comment_st = '0';
var cs_chk = $("#CourseManagement_chk");
var cs_pro_chk = $("#CourseProjectManagement_chk");
var cs_unit_chk = $("#CourseUnitManagement_chk");
var unit_sub_chk = $("#UnitSubwareManagement_chk");
var account_chk = $("#AccountManagement_chk");
var user_chk = $("#UserManagement_chk");
var admin_chk = $("#AdminManagement_chk");
var logview_chk = $("#LogView_chk");
var community_chk = $("#CommunityManagement_chk");
var content_chk = $("#ContentManagement_chk");
var comment_chk = $("#CommentManagement_chk");

function delete_admin(self) {
    var admin_id = self.getAttribute("admin_id");
    $("#delete_admin_btn").attr("admin_id",admin_id);
    $("#admin_delete_modal").modal({
        backdrop: 'static',
        keyboard: false
    });
}
function  edit_admin(self){

    var admin_id = self.getAttribute('admin_id');
    $("#edit_admin_saveBtn").attr("admin_id",admin_id);
    var tdtag = self.parentNode;
    var trtag = tdtag.parentNode;
    var username = trtag.cells[1].innerHTML;
    var admin_pass = trtag.cells[2].innerHTML;
    var admin_label = trtag.cells[3].innerHTML;

    $('#edit_admin_fullname').text(username);
    $('#edit_admin_password').val('1');///old pass

    //$('#edit_admin_password').val(admin_pass);
    //$('#edit_admin_repeatpassword').val(admin_pass);///confirm pass

    $('#edit_admin_repeatpassword').val('1');///confirm pass

    $('#edit_admin_label').val(admin_label);

    $('#edit_admin_modal').modal({
        backdrop: 'static',
        keyboard: false
    });
}
function initAssignModal(permissionJSONStr){
    jsonArr = $.parseJSON(permissionJSONStr);
    $.each(jsonArr, function (i,perValueList)
    {
        for(var key in perValueList){
           var keyValue = perValueList[key];

           switch (key)
           {
               case 'cs_pro_st':
                   cs_pro_st = keyValue;
                   console.log(cs_pro_st);
                   break;
               case 'cs_unit_st':
                   cs_unit_st = keyValue;
                   break;
               case 'unit_sub_st':
                   unit_sub_st = keyValue;
                   break;
               case 'user_st':
                   user_st = keyValue;
                   break;
               case 'admin_st':
                   admin_st = keyValue;
                   break;
               case 'logview_st':
                   logview_st = keyValue;
                   break;
               case 'content_st':
                   content_st = keyValue;
                   break;
               case 'comment_st':
                   comment_st = keyValue;
                   break;
               default:
                   break;
           }
        }
    });
}
function initAllCheckBox(){
    if(cs_pro_st==1) cs_pro_chk.prop('checked',true);
    else cs_pro_chk.prop('checked',false);

    if(cs_unit_st==1) cs_unit_chk.prop('checked',true);
    else cs_unit_chk.prop('checked',false);

    if(unit_sub_st==1) unit_sub_chk.prop('checked',true);
    else unit_sub_chk.prop('checked',false);

    if(user_st==1) user_chk.prop('checked',true);
    else user_chk.prop('checked',false);

    if(admin_st==1) admin_chk.prop('checked',true);
    else admin_chk.prop('checked',false);

    if(logview_st==1) logview_chk.prop('checked',true);
    else logview_chk.prop('checked',false);

    if(content_st==1) content_chk.prop('checked',true);
    else content_chk.prop('checked',false);

    if(comment_st==1) comment_chk.prop('checked',true);
    else comment_chk.prop('checked',false);

    if(cs_unit_st==1&&cs_unit_st==1&&unit_sub_st==1) cs_chk.prop('checked',true);
    else cs_chk.prop('checked',false);

    if(user_st==1&&admin_st==1&&logview_st==1) account_chk.prop('checked',true);
    else account_chk.prop('checked',false);

    if(comment_st==1&&content_st==1) community_chk.prop('checked',true);
    else community_chk.prop('checked',false);

}
function  assign_admin(self){
    var admin_id = self.getAttribute('admin_id');
    var tdtag = self.parentNode;
    var trtag = tdtag.parentNode;

    var permissionJSONStr = trtag.cells[4].innerHTML;
    if(permissionJSONStr!=''){
        initAssignModal(permissionJSONStr);
    }else{
        cs_pro_st = '0';
        cs_unit_st = '0';
        unit_sub_st = '0';
        user_st = '0';
        admin_st = '0';
        logview_st = '0';
        content_st = '0';
        comment_st = '0';
    }
    initAllCheckBox();

    $('#assign_admin_saveBtn').attr('admin_id',admin_id);
    $("#assign_admin_modal").modal({
        backdrop: 'static',
        keyboard: false
    });
}
function initAddNewModal(){
    $('#add_add_fullname').val('');
    $('#add_admin_password').val('');
    $('#add_amin_repeatpassoword').val('');
}
function confirmPassword(){
    var addSaveButton = document.getElementById('add_admin_saveBtn');
    var userPassBox = document.getElementById("add_admin_password");
    var userpass = userPassBox.value;
    var userRepeatPassBox = document.getElementById("add_admin_repeatpassword");
    var userRepeatPass = userRepeatPassBox.value;
    if(userpass==userRepeatPass)
    {
        userRepeatPassBox.style.borderColor = '#c2cad8';
        userRepeatPassBox.style.borderWidth = '1px';
        userRepeatPassBox.style.borderStyle = 'solid';
        addSaveButton.disabled = false;
    }else{
        userRepeatPassBox.style.borderColor = '#f00';
        userRepeatPassBox.style.borderWidth = '2px';
        userRepeatPassBox.style.borderStyle = 'solid';
        addSaveButton.disabled = true;
    }

}
function confirmEditPassword(){
    var addSaveButton = document.getElementById('edit_admin_saveBtn');
    var userPassBox = document.getElementById("edit_admin_password");
    var userpass = userPassBox.value;
    var userRepeatPassBox = document.getElementById("edit_admin_repeatpassword");
    var userRepeatPass = userRepeatPassBox.value;
    if(userpass==userRepeatPass)
    {
        userRepeatPassBox.style.borderColor = '#c2cad8';
        userRepeatPassBox.style.borderWidth = '1px';
        userRepeatPassBox.style.borderStyle = 'solid';
        addSaveButton.disabled = false;
    }else{
        userRepeatPassBox.style.borderColor = '#f00';
        userRepeatPassBox.style.borderWidth = '2px';
        userRepeatPassBox.style.borderStyle = 'solid';
        addSaveButton.disabled = true;
    }

}
$("#delete_admin_btn").click(function () {

    var admin_id = $(this).attr('admin_id');
    $.ajax({
        type: "post",
        url: baseURL + "admin/admins/delete",
        dataType: "json",
        data: {admin_id: admin_id},
        success: function (res) {
            if (res.status == 'success') {
                var table = document.getElementById("adminInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = res.data;
                executionPageNation();
            }
            else//failed
            {
                alert("Cannot delete CourseWare Item.");
            }
        }
    });
    $('#admin_delete_modal').modal('toggle');

});
$("#add_new_admin_btn").click(function () {

    initAddNewModal();
    $('#add_admin_modal').modal({
        backdrop: 'static',
        keyboard: false
    });
});
$("#add_admin_submit_form").submit(function (e) {

    e.preventDefault();
    $.ajax({
        url:baseURL+"admin/admins/add",
        type:"post",
        data:new  FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        success: function(res){
            var ret = JSON.parse(res);
            if(ret.status=='success') {
                var table = document.getElementById("adminInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = ret.data;
                executionPageNation();
            }
            else//failed
            {
                alert("Cannot modify Unit Data.");
            }
        }
    });
    $('#add_admin_modal').modal('toggle');
});
$("#edit_admin_submit_form").submit(function (e) {

    e.preventDefault();
    var admin_id = $("#edit_admin_saveBtn").attr('admin_id');
    var fdata = new  FormData(this);
    fdata.append("admin_id",admin_id);
    jQuery.ajax({
        url:baseURL+"admin/admins/edit",
        type:"post",
        data:fdata,
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        success: function(res){
            var ret = JSON.parse(res);
            if(ret.status=='success') {
                var table = document.getElementById("adminInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = ret.data;
                executionPageNation();
            }
            else//failed
            {
                alert("Cannot modify Unit Data.");
            }
        }
    });
    jQuery('#edit_admin_modal').modal('toggle');
});
$("#account_name_search").keyup(function () {

    var input, filter, table, tr, td, i;
    input = document.getElementById("account_name_search");
    filter = input.value.toUpperCase();
    table = document.getElementById("adminInfo_tbl");
    tr = table.getElementsByTagName("tr");
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
});
</script>
<script src="<?= base_url('assets/js/custom/admin/admin.js') ?>" type="text/javascript"></script>




