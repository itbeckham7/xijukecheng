<style>
    #nccsInfo_tbl th, td{
        text-align: center;
        vertical-align: middle;
    }

</style>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_childcourse');?>
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
                                            <label class="col-md-5 control-label"><?php echo $this->lang->line('ChildCourse');?>:</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id = "nccs_name_search" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><?php echo $this->lang->line('keyword');?>:</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id = "nccs_keyword_search" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-offset-5 col-md-1">
                                <div class="btn-group">
                                    <button  class=" btn sbold green" id="add_new_nccs_btn"> <i class="fa fa-plus"></i>&nbsp<?php echo $this->lang->line('AddNew');?>
                                    </button>
                                </div>
                            </div>
                            <!-------Table tool parts----------------->
                        </div>
                        <!------Tool bar parts (add button and search function------>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="nccsInfo_tbl">
                            <thead>
                            <tr>
                                <th style="width:10%;"><?php echo $this->lang->line('SerialNumber');?></th>
                                <th style="width:13%;"><?php echo $this->lang->line('ChildCourseName');?></th>
                                <th style="width:25%;"><?php echo $this->lang->line('CourseName');?></th>
                                <th style="width:10%;"><?php echo $this->lang->line('ApplicationUnit');?></th>
                                <th style="width:20%;"><?php echo $this->lang->line('Operation');?></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $sn = 0;foreach($nchildcourses as $nccs):
                                    $sn++;
                                    $pub = '';
                                    if($nccs->childcourse_publish=='1') $pub =  $this->lang->line('Disable');
                                    else $pub =  $this->lang->line('Enable');
                                    ?>
                                <tr>
                                    <td><?= $sn;?></td>
                                    <td><?= $nccs->childcourse_name;?></td>
                                    <td><?= $nccs->course_name;?></td>
                                    <td><?= $nccs->school_type_name;?></td>
                                    <td>
                                        <button class="btn btn-sm btn-success"  nccs_photo="<?= $nccs->childcourse_photo;?>" onclick="edit_nccs(this);"
                                                      nccs_id = <?php echo $nccs->childcourse_id;?>
                                                      nccs_free = <?php echo $nccs->childcourse_isfree;?>
                                        ><?php echo $this->lang->line('Modify');?></button>
                                        <button class="btn btn-sm btn-warning" onclick="delete_nccs(this);"  nccs_id = <?php echo $nccs->childcourse_id;?>><?php echo $this->lang->line('Delete');?></button>
                                        <button style="width:70px;" class="btn btn-sm btn-danger"  onclick="publish_nccs(this);" nccs_id = <?php echo $nccs->childcourse_id;?>><?php echo $pub;?></button>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <div id="nccspageNavPos"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!---nccs is new child course ---->
<div id="add_nccs_modal" class="modal fade" tabindex="-1" data-width="750">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewCourseWare');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action=""  id="add_nccs_submit_form" role="form" method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName');?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_cs_name" name="add_cs_name">
                            <?php foreach($courses as $cs):?>
                                <option value="<?= $cs->course_id;?>"><?= $this->lang->line('sandapian');?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('ApplicationUnit');?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_school_type_name" name="add_school_type_name">
                            <option><?php echo $this->lang->line('PrimarySchool');?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('ChildCourseName');?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="add_nccs_name" id = "add_nccs_name" value="">
                    </div>
                    <label class="col-md-2 control-label" ><?php echo $this->lang->line('IsFree');?>:</label>
                    <div class="col-md-4">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" value="1" checked><?= $this->lang->line('Yes')?>
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" value="0" ><?= $this->lang->line('No')?>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cwImageUpload" class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareImage');?></label>
                    <div class="col-md-3">
                        <input type="file" id="add_nccs_upload_img" name = "add_file_name" onchange="add_upload_image();">
                        <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription');?></p>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                        <img width="220" height="150" src="#"  class="img-rounded " alt="Image 300x300" id="add_nccs_preview_image">
                    </div>
                </div>
            </div>
    </div>
    <div class="form-actions">
        <div class="form-group">
            <div class="col-md-2" style="padding-bottom: 15px;text-align: -webkit-center;">
                <input type="text" hidden id="add_cw_info_id" value="" ><!--this is unit_id-->
                <input type="text" hidden id="add_unit_info_type_id" value=""><!--this is unite_type_id-->
                <button type = "submit" class="btn green" id="add_cw_save" ><?php echo $this->lang->line('Save');?></button>
            </div>
        </div>
    </div>
    </form>
</div>
<div id="edit_nccs_modal" class="modal fade" tabindex="-1" data-width="750">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('EditChildCourse');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action=""  id="edit_nccs_submit_form" role="form" method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName');?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_cs_name" name="edit_cs_name">
                            <?php foreach($courses as $cs):?>
                                <option value="<?= $cs->course_id;?>"><?= $this->lang->line('sandapian');?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('ApplicationUnit');?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_school_type_name" name="edit_school_type_name">
                            <option><?php echo $this->lang->line('PrimarySchool');?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('ChildCourseName');?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="edit_nccs_name" id = "edit_nccs_name" value="">
                    </div>
                    <label class="col-md-2 control-label" ><?php echo $this->lang->line('IsFree');?>:</label>
                    <div class="col-md-4">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" value="1" id="free_yes_option" checked><?= $this->lang->line('Yes')?>
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" id="free_no_option" value="0" ><?= $this->lang->line('No')?>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cwImageUpload" class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareImage');?></label>
                    <div class="col-md-3">
                        <input type="file" id="edit_nccs_upload_img" name = "edit_file_name" onchange="edit_upload_image();">
                        <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription');?></p>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                        <img width="220" height="150" src="#"  class="img-rounded " alt="Image 300x300" id="edit_nccs_preview_image">
                    </div>
                </div>
            </div>
    </div>
    <div class="form-actions">
        <div class="form-group">
            <div class="col-md-2" style="padding-bottom: 15px;text-align: -webkit-center;">
                <button type = "submit" class="btn green" id="edit_nccs_save" ><?php echo $this->lang->line('Save');?></button>
            </div>
        </div>
    </div>
    </form>
</div>
<div id="delete_nccs_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message');?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage');?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" id="delete_nccs_btn"><?php echo $this->lang->line('Yes');?></button>
        <button type="button" data-dismiss="modal"  class="btn btn-outline dark"><?php echo $this->lang->line('No');?></button>
    </div>
</div>

<script>

var prevstr = "<?php echo $this->lang->line('PrevPage');?>";
var nextstr = "<?php echo $this->lang->line('NextPage');?>";
var currentShowedPage = 1;
var showedItems = 15;
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
        if(oldPageAnchor){
            oldPageAnchor.className = 'pg-normal';

            this.currentPage = pageNumber;
            var newPageAnchor = document.getElementById('pg'+this.currentPage);
            newPageAnchor.className = 'pg-selected';

            var from = (pageNumber - 1) * itemsPerPage + 1;
            var to = from + itemsPerPage - 1;
            this.showRecords(from, to);
        }else{

            return;
        }

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
var pager = new Pager('nccsInfo_tbl', showedItems);
pager.init();
pager.showPageNav('pager', 'nccspageNavPos');
pager.showPage(1);
function executionPageNation()
{
    var pager = new Pager('nccsInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'nccspageNavPos');
    pager.showPage(currentShowedPage);
}
$('#add_new_nccs_btn').click(function(){
    $('#add_nccs_name').val('');
    $('#add_nccs_preview_image').attr('src',baseURL+'assets/images/no_image.jpg');
    $('#add_nccs_modal').modal({
        backdrop: 'static',
        keyboard: false
    });
});
$('#add_nccs_submit_form').submit(function(e){

    e.preventDefault();
    jQuery.ajax({
        url:baseURL+"admin/nchildcourses/add",
        type:"post",
        data:new  FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        success: function(res){
            var ret = JSON.parse(res);
            if(ret.status=='success') {
                var table = document.getElementById("nccsInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = ret.data;
                executionPageNation();
            }
            else//failed
            {
                alert(ret.data);
                console.log('Image uploading has been failed!')
            }
        }
    });
    jQuery('#add_nccs_modal').modal('toggle');
});
$('#edit_nccs_submit_form').submit(function(e){

    var nccsid = $('#edit_nccs_save').attr('nccs_id');
    var fdata = new FormData(this);
    fdata.append('nccs_id',nccsid);
    e.preventDefault();
    jQuery.ajax({
        url:baseURL+"admin/nchildcourses/edit",
        type:"post",
        data:fdata,
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        success: function(res){
            var ret = JSON.parse(res);
            if(ret.status=='success') {
                var table = document.getElementById("nccsInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = ret.data;
                executionPageNation();
            }
            else//failed
            {
                alert(ret.data);
                console.log('Image uploading has been failed!')
            }
        }
    });
    jQuery('#edit_nccs_modal').modal('toggle');
});
function edit_nccs(self)
{
    var nccsId = self.getAttribute('nccs_id');
    var nccsPhoto = self.getAttribute('nccs_photo');
    var isFree = self.getAttribute('nccs_free');

    var tdtag = self.parentNode;
    var trtag = tdtag.parentNode;
    var nccs_name = trtag.cells[1].innerHTML;

    if(isFree=='0'){
        $('#free_no_option').prop('checked',true);
    }else{
        $('#free_yes_option').prop('checked',true);
    }

    $('#edit_nccs_save').attr('nccs_id',nccsId);
    $('#edit_nccs_name').val(nccs_name);
    $('#edit_nccs_preview_image').attr('src',baseURL+nccsPhoto);
    $('#edit_nccs_modal').modal({
        backdrop: 'static',
        keyboard: false
    });

}
function add_upload_image()
{
    var preview = document.getElementById('add_nccs_preview_image');
    var file = document.getElementById('add_nccs_upload_img').files[0];
    var reader  = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (file) {
        reader.readAsDataURL(file);//reads the data as a URL
    } else {
        preview.src = "";
    }
}
function edit_upload_image()
{
    var preview = document.getElementById('edit_nccs_preview_image');
    var file = document.getElementById('edit_nccs_upload_img').files[0];
    var reader  = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (file) {
        reader.readAsDataURL(file);//reads the data as a URL
    } else {
        preview.src = "";
    }
}
function delete_nccs(self)
{
    var nccsId = self.getAttribute('nccs_id');
    $("#delete_nccs_btn").attr("nccs_id",nccsId);
    $("#delete_nccs_modal").modal({
        backdrop: 'static',
        keyboard: false
    });
}
jQuery("#delete_nccs_btn").click(function () {
    var nccsId = $(this).attr("nccs_id");
    jQuery.ajax({
        type: "post",
        url: baseURL+"admin/nchildcourses/delete",
        dataType: "json",
        data: {nccsId: nccsId},
        success: function(res) {
            if(res.status=='success') {
                var table = document.getElementById("nccsInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = res.data;
                executionPageNation();
            }
            else//failed
            {
                alert("Cannot delete Child Course Item.");
            }
        }
    });
    jQuery('#delete_nccs_modal').modal('toggle');
});
function publish_nccs(self)
{
    var nccsId = self.getAttribute("nccs_id");
    var enableStr = "<?php echo $this->lang->line('Enable');?>";
    var disableStr = "<?php echo $this->lang->line('Disable');?>";
    var curBtnText = self.innerHTML;
    var pub_st = '1';
    if(enableStr==curBtnText)
    {
        self.innerHTML = disableStr;
    }
    else{
        self.innerHTML = enableStr;
        pub_st = '0';
    }
    ///ajax process for publish/unpublish
    $.ajax({
        type: "post",
        url: baseURL+"admin/nchildcourses/publish",
        dataType: "json",
        data: {nccsId: nccsId,publish_state:pub_st},
        success: function(res) {
            if(res.status=='success') {
                console.log('child courseware publish has been successed!')
            }
            else//failed
            {
                alert("Cannot delete CourseWare Item.");
            }
        }
    });
}
jQuery("#nccs_name_search").keyup(function () {

    var input, filter, table, tr, td, i;
    input = document.getElementById("nccs_name_search");
    filter = input.value.toUpperCase();
    table = document.getElementById("nccsInfo_tbl");
    tr = table.getElementsByTagName("tr");
    // Loop through all table rows, and hide those who don't match the search query
    if(tr.length<2) return;
    for (i = 1; i < tr.length; i++) {
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
jQuery("#nccs_keyword_search").keyup(function () {///search for keyword
    var input, filter, table, tr, td, i,tdCnt;
    input = document.getElementById("nccs_keyword_search");
    filter = input.value.toUpperCase();
    table = document.getElementById("nccsInfo_tbl");
    tr = table.getElementsByTagName("tr");
    // Loop through all table rows, and hide those who don't match the search query
    if(tr.length<2) return;
    for (i = 1; i < tr.length; i++) {

        var cmpst = 0;
        for(j=0;j<3;j++)//5 is search filed count
        {
            td = tr[i].getElementsByTagName("td")[j];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    cmpst++;
                }
            }
        }
        if(cmpst>0)
        {
            tr[i].style.display = "";
        }
        else tr[i].style.display = "none";

    }
});
</script>
