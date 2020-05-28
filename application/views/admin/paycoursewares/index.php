<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?= $pageTitle; ?>
            <small></small>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!-------Table tool parts----------------->
                        <div class="row">
                            <div class="col-md-3">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><?php echo $this->lang->line('CoursewareName'); ?>
                                                :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="cw_name_search"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="#" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><?php echo $this->lang->line('keyword'); ?>
                                                :</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="keyword_cw_search"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-offset-5 col-md-1">
                                <div class="btn-group">
                                    <button class=" btn blue" id="add_new_cw_btn"><i
                                                class="fa fa-plus"></i>&nbsp&nbsp<?php echo $this->lang->line('AddNew'); ?>
                                    </button>
                                </div>
                            </div>
                            <!-------Table tool parts----------------->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="cwInfo_tbl">
                            <thead>
                            <tr>
                                <th style="width:80px;"><?php echo $this->lang->line('SerialNumber'); ?></th>
                                <th><?php echo $this->lang->line('CoursewareName'); ?></th>
                                <th><?php echo $this->lang->line('CourseName'); ?></th>
                                <th style="width:100px;"><?php echo $this->lang->line('Price'); ?></th>
                                <th style="width:100px;"><?php echo $this->lang->line('ApplicationUnit'); ?></th>
                                <th style="width:270px;"><?php echo $this->lang->line('Operation'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?= $courseware_content; ?>
                            </tbody>
                        </table>
                        <div id="pageNavPosition"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!------->
<div id="cw_addNew_modal" class="modal fade" tabindex="-1" data-width="750">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewCourseWare'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="cw_addNew_submit_form" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName'); ?>:</label>
                    <div class="col-md-4">
                        <input class="form-control input-inline " type="text" name="add_cw_name" id="add_cw_name"
                               value="">
                    </div>
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CourswareSN'); ?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="add_cw_sn" id="add_cw_sn" value="">
                    </div>
                </div>
                <input type="hidden" id="add_unit_type_name" name="add_unit_type_name" value="<?php echo $this->lang->line('China');?>">
                <input type="hidden" id="add_school_type_id" name="add_school_type_id" value="1">
                <input type="hidden" id="add_courseware_type" name="add_cw_type" value="1">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CourseName'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="add_course_name" name="add_course_name">
                            <?php foreach ($courses as $course) : ?>
                                <option value="<?= $course->course_id ?>" data-school-type-id="<?= $course->school_type_id ?>"><?= $course->course_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('IsFree'); ?>:</label>
                    <div class="col-md-4">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" value="1"><?= $this->lang->line('Free') ?>
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" value="0" checked><?= $this->lang->line('Unfree') ?>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group price_group" style="margin-bottom: 0; display: none">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('Price'); ?>:</label>
                    <div class="col-md-3">
                        <input type="number" class="form-control input-inline" name="add_cw_price" id="add_cw_price"
                               value="0.00" step="0.01">
                        <label class="control-label"><?php echo $this->lang->line('UnitPrice'); ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cwImageUpload"
                           class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareImage'); ?></label>
                    <div class="col-md-3">
                        <input type="file" id="add_cw_upload_img" name="add_file_name" onchange="add_upload_image();">
                        <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription'); ?></p>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                        <img width="220" height="150" src="#" class="img-rounded " alt="Image 300x300"
                             id="add_cw_preview_image">
                    </div>
                </div>
            </div>
    </div>
    <div class="form-actions">
        <div class="form-group">
            <div class="col-md-2" style="padding-bottom: 15px;text-align: -webkit-center;">
                <input type="text" hidden id="add_cw_info_id" value=""><!--this is unit_id-->
                <input type="text" hidden id="add_unit_info_type_id" value=""><!--this is unite_type_id-->
                <button type="submit" class="btn green"
                        id="add_cw_save"><?php echo $this->lang->line('Save'); ?></button>
            </div>
        </div>
    </div>
    </form>
</div>
</div>
<!-------->
<!--edit modal-->
<div id="cw_modify_modal" class="modal fade" tabindex="-1" data-width="750">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('ModifyUnitInfo'); ?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action="" id="cw_edit_submit" role="form"
              method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName'); ?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="cw_name" id="cw_name" value="">
                    </div>
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CourswareSN'); ?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="cw_sn" id="cw_sn" value="">
                    </div>
                </div>
                <input type="hidden" id="edit_unit_type_name" name="unit_type_name" value="<?php echo $this->lang->line('China');?>">
                <input type="hidden" id="edit_school_type_id" name="school_type_id" value="1">
                <input type="hidden" id="edit_courseware_type" name="cw_type" value="1">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CourseName'); ?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="course_name" name="course_name">
                            <?php foreach ($courses as $course) : ?>
                                <option value="<?= $course->course_id ?>" data-school-type-id="<?= $course->school_type_id ?>"><?= $course->course_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label"><?php echo $this->lang->line('IsFree'); ?>:</label>
                    <div class="col-md-4">
                        <div class="mt-radio-inline">
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" value="1" id="free_yes_option" checked><?= $this->lang->line('Free') ?>
                                <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                                <input type="radio" name="free_option" value="0" id="free_no_option"><?= $this->lang->line('Unfree') ?>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group price_group" style="display: none;">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('Price'); ?>:</label>
                    <div class="col-md-3">
                        <input type="number" class="form-control input-inline" name="cw_price" id="cw_price"
                               value="0.00" step="0.01">
                        <label class="control-label"><?php echo $this->lang->line('UnitPrice'); ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cwImageUpload"
                           class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareImage'); ?></label>
                    <div class="col-md-3">
                        <input type="file" id="cw_upload_img" name="file_name" onchange="edit_upload_image();">
                        <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription'); ?></p>
                    </div>
                    <div class="col-md-offset-1 col-md-3">
                        <img width="220" height="150" src="#" class="img-rounded" alt="Image 300x300"
                             id="cw_preview_image">
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-1">
                            <input type="text" hidden id="cw_info_id" value=""><!--this is unit_id-->
                            <input type="text" hidden id="unit_info_type_id" value=""><!--this is unite_type_id-->
                            <button type="submit" class="btn green"
                                    id="cw_save"><?php echo $this->lang->line('Save'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--   edit modal  -->
<!----delete modal-->
<div id="cw_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message'); ?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage'); ?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" id="delete_cw_item_btn"><?php echo $this->lang->line('Yes'); ?></button>
        <button type="button" data-dismiss="modal"
                class="btn btn-outline dark"><?php echo $this->lang->line('No'); ?></button>
    </div>
</div>
<!----------pagenation-------->
<script type="text/javascript">
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

        this.showRecords = function (from, to) {
            var rows = document.getElementById(tableName).rows;
            // i starts from 1 to skip table header row
            for (var i = 1; i < rows.length; i++) {
                if (i < from || i > to)
                    rows[i].style.display = 'none';
                else
                    rows[i].style.display = '';
            }
        };

        this.showPage = function (pageNumber) {
            if (!this.inited) {
                alert("not inited");
                return;
            }
            var oldPageAnchor = document.getElementById('pg' + this.currentPage);
            if (oldPageAnchor) {
                oldPageAnchor.className = 'pg-normal';

                this.currentPage = pageNumber;
                var newPageAnchor = document.getElementById('pg' + this.currentPage);
                newPageAnchor.className = 'pg-selected';

                var from = (pageNumber - 1) * itemsPerPage + 1;
                var to = from + itemsPerPage - 1;
                this.showRecords(from, to);
            } else {

                return;
            }

        }

        this.prev = function () {
            if (this.currentPage > 1) {

                currentShowedPage = this.currentPage - 1;
                this.showPage(this.currentPage - 1);
            }

        }

        this.next = function () {
            if (this.currentPage < this.pages) {
                currentShowedPage = this.currentPage + 1;
                this.showPage(this.currentPage + 1);
            }
        }

        this.init = function () {
            var rows = document.getElementById(tableName).rows;
            var records = (rows.length - 1);
            this.pages = Math.ceil(records / itemsPerPage);
            this.inited = true;
        }
        this.showPageNav = function (pagerName, positionId) {
            if (!this.inited) {
                alert("not inited");
                return;
            }
            var element = document.getElementById(positionId);

            var pagerHtml = '<button class = "btn btn blue" onclick="' + pagerName + '.prev();" class="pg-normal">' + prevstr + '</button>  ';
            for (var page = 1; page <= this.pages; page++)
                pagerHtml += '<button hidden id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</button>  ';
            pagerHtml += '<button  class = "btn btn blue" onclick="' + pagerName + '.next();" class="pg-normal">' + nextstr + '</button>';

            element.innerHTML = pagerHtml;
        }
    }

    var pager = new Pager('cwInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'pageNavPosition');
    pager.showPage(1);
    //-->
</script>
<!---------pagenation module--------->
<script>
    function executionPageNation() {
        var pager = new Pager('cwInfo_tbl', showedItems);
        pager.init();
        pager.showPageNav('pager', 'pageNavPosition');
        pager.showPage(currentShowedPage);
    }

    $('input[type=radio]').on('click', function (object) {
        var item_selected = $(this).attr('value'); // 1=free, 0=unfree
        if (item_selected == '0') $('.price_group').show();
        else $('.price_group').hide();
    });

    function edit_cw(self) {
        var cw_id = self.getAttribute("cw_id");
        var isFree = self.getAttribute("cw-free");
        var cw_photo = baseURL + self.getAttribute("cw_photo");
        var tdtag = self.parentNode;
        var trtag = tdtag.parentNode;
        var cw_sn = trtag.cells[0].innerHTML;
        var cw_name = trtag.cells[1].innerHTML;
        var cw_price = trtag.cells[3].innerHTML;

        var course_id = trtag.cells[2].getAttribute("data-course-id");
        var school_type_id = trtag.cells[4].getAttribute("data-school-type-id");

        if (!parseFloat(cw_price)) {
            $('#free_yes_option').prop('checked', true);
            $('.price_group').hide();
            $('#cw_price').val('0.00');
        } else {
            $('#free_no_option').prop('checked', true);
            $('.price_group').show();
            $('#cw_price').val(cw_price);
        }
        jQuery("#cw_info_id").val(cw_id);
        jQuery("#cw_name").val(cw_name);
        jQuery("#cw_sn").val(cw_sn);
        jQuery("#course_name").val(course_id);
        jQuery("#edit_school_type_id").val(school_type_id);
        jQuery("#cw_preview_image").attr('src', cw_photo);

        jQuery("#cw_modify_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function edit_upload_image() {
        var preview = document.getElementById('cw_preview_image');
        var file = document.getElementById('cw_upload_img').files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        };
        if (file) {
            reader.readAsDataURL(file);//reads the data as a URL
        } else {
            preview.src = "";
        }
    }

    function add_upload_image() {
        var preview = document.getElementById('add_cw_preview_image');
        var file = document.getElementById('add_cw_upload_img').files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        };
        if (file) {
            reader.readAsDataURL(file);//reads the data as a URL
        } else {
            preview.src = "";
        }
    }

    function delete_cw(self) {
        var cw_id = self.getAttribute("cw_id");
        $("#cw_info_id").val(cw_id);
        $("#delete_cw_item_btn").attr("delete_cw_id", cw_id);
        $("#cw_delete_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function publish_cw(self) {
        var publish_cw_id = self.getAttribute("cw_id");
        var publish = "<?php echo $this->lang->line('Publish');?>";
        var unpublish = "<?php echo $this->lang->line('UnPublish');?>";
        var curBtnText = self.innerHTML;
        var pub_st = '1';
        if (publish == curBtnText) {
            self.innerHTML = unpublish;
        }
        else {
            self.innerHTML = publish;
            pub_st = '0';
        }
        ///ajax process for publish/unpublish
        $.ajax({
            type: "post",
            url: baseURL + "admin/coursewares/publish",
            dataType: "json",
            data: {publish_cw_id: publish_cw_id, publish_state: pub_st},
            success: function (res) {
                if (res.status == 'success') {
                    console.log('courseware publish has been successed!')
                }
                else//failed
                {
                    alert("Cannot delete CourseWare Item.");
                }
            }
        });
    }
    function validate_cw(self) {
        var publish_cw_id = self.getAttribute("cw_id");
        var publish = "开放";
        var unpublish = "取消开放";
        var curBtnText = self.innerHTML;
        var pub_st = '1';
        if (publish == curBtnText) {
            self.innerHTML = unpublish;
        }
        else {
            self.innerHTML = publish;
            pub_st = '0';
        }
        ///ajax process for publish/unpublish
        $.ajax({
            type: "post",
            url: baseURL + "admin/paycoursewares/validate",
            dataType: "json",
            data: {publish_cw_id: publish_cw_id, publish_state: pub_st},
            success: function (res) {
                if (res.status == 'success') {
                    console.log('courseware publish has been successed!')
                }
                else//failed
                {
                    alert("Cannot delete CourseWare Item.");
                }
            }
        });
    }

    jQuery("#course_name").change(function () {
        var course_id = jQuery(this).val();
        console.log('-- course_id : ', course_id);

        var ops = jQuery('#course_name').children();
        for( var i=0; i<ops.length; i++ ){
            var op = jQuery(ops[i]);
            if( op.attr('value') == course_id ){
                console.log('-- op : ', op.attr('data-school-type-id'))
                $('#edit_school_type_id').val(op.attr('data-school-type-id'))
            }
        }
    })

    jQuery("#add_course_name").change(function () {
        var course_id = jQuery(this).val();
        console.log('-- add course_id : ', course_id);

        var ops = jQuery('#add_course_name').children();
        for( var i=0; i<ops.length; i++ ){
            var op = jQuery(ops[i]);
            if( op.attr('value') == course_id ){
                console.log('-- op : ', op.attr('data-school-type-id'))
                $('#add_school_type_id').val(op.attr('data-school-type-id'))
            }
        }
    })

    //  add_new_cw_btn
    jQuery("#add_new_cw_btn").click(function () {

        $('#add_cw_name').val('');
        $('#add_cw_sn').val('');
        $('#add_cw_preview_image').attr('src', baseURL + 'assets/images/no_image.jpg');
        $('#add_cw_upload_img').val('');

        $('input[type=radio][value=0]').prop('checked', true);
        $('.price_group').show();
        $('#add_cw_price').val('0.00');

        jQuery("#cw_addNew_modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    jQuery("#cw_name_search").keyup(function () {

        var input, filter, table, tr, td, i;
        input = document.getElementById("cw_name_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("cwInfo_tbl");
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
    jQuery("#keyword_cw_search").keyup(function () {///search for keyword
        var input, filter, table, tr, td, i, tdCnt;
        input = document.getElementById("keyword_cw_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("cwInfo_tbl");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {

            var cmpst = 0;
            for (j = 0; j < 5; j++)//5 is search filed count
            {
                td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        cmpst++;
                    }
                }
            }
            if (cmpst > 0) {
                tr[i].style.display = "";
            }
            else tr[i].style.display = "none";
        }
    });
</script>
<script src="<?= base_url('assets/js/custom/admin/pcw.js') ?>"></script>



