<style>
    #ncwInfo_tbl th, td{
        text-align: center;
        vertical-align: middle;
    }

</style>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?php echo $this->lang->line('sub_panel_title_courseware');?>
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
                                            <label class="col-md-4 control-label"><?php echo $this->lang->line('CoursewareName');?>:</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id = "ncw_name_search" placeholder="">
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
                                                <input type="text" class="form-control" id = "keyword_ncw_search" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-offset-5 col-md-1">
                                <div class="btn-group">
                                    <button  class=" btn blue" id="add_new_ncw_btn"><i class="fa fa-plus"></i>&nbsp&nbsp<?php echo $this->lang->line('AddNew');?>
                                    </button>
                                </div>
                            </div>
                            <!-------Table tool parts----------------->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="ncwInfo_tbl">
                            <thead>
                            <tr>
                                <th style="width:10%;"><?php echo $this->lang->line('SerialNumber');?></th>
                                <th style="width:15%;"><?php echo $this->lang->line('CoursewareName');?></th>
                                <th style="width:30%;"><?php echo $this->lang->line('UnitName');?></th>
                                <th style="width:10%;"><?php echo $this->lang->line('ChildCourseName');?></th>
                                <th style="width:10%;"><?php echo $this->lang->line('ApplicationUnit');?></th>
                                <th style="width:25%;"><?php echo $this->lang->line('Operation');?></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($ncwSets as $ncw):
                                    $pub = '';
                                    if($ncw->ncw_publish=='1')  $pub = $this->lang->line('UnPublish');
                                    else   $pub = $this->lang->line('Publish');
                                    ?>
                                    <tr>
                                        <td><?= $ncw->ncw_sn;?></td>
                                        <td><?= $ncw->ncw_name;?></td>
                                        <td><?= $ncw->nunit_name;?></td>
                                        <td><?= $ncw->childcourse_name;?></td>
                                        <td><?= $ncw->school_type_name;?></td>
                                        <td>
                                            <button class="btn btn-sm btn-success" ncw-free="<?= $ncw->nfree;?>" ncw_photo="<?= $ncw->ncw_photo;?>" onclick="edit_ncw(this);"    ncw_id =  <?= $ncw->ncw_id;?>><?php echo $this->lang->line('Modify');?></button>
                                            <button class="btn btn-sm btn-warning" onclick="delete_ncw(this);"  ncw_id = <?= $ncw->ncw_id;?>><?php echo $this->lang->line('Delete');?></button>
                                            <button style="width:70px;" class="btn btn-sm btn-danger"  onclick="publish_ncw(this);" ncw_id = <?= $ncw->ncw_id;?>><?php echo $pub;?></button>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
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
<style>
    .uploading_backdrop
    {
        display: none;
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #000;
        opacity: 0.9;
        z-index: 12000;
    }
    #wait_ajax_loader
    {
        position: absolute;
        top: 41%;
        left: 50%;
        z-index:15000
    }
    #progress_percent
    {
        position: absolute;
        top:43%;
        left: 56.5%;
        font-size:18px;
        color: #fff;
        z-index: 17000
    }
</style>
<div class="uploading_backdrop"></div>
<div class="progressing_area" style="display: none">
    <img id="wait_ajax_loader" src='<?php echo base_url('assets/images/frontend/ajax-loader-1.gif');?>'/>
    <span style="position: absolute;top: 43%;left: 53.5%;font-size:18px;color: #fff;z-index: 16000"><?= $this->lang->line('uploading')?></span>
    <span id="progress_percent">0%</span>
</div>
<div id="ncw_addNew_modal" class="modal fade" tabindex="-1" data-width="750">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewCourseWare');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action=""  id="ncw_addNew_submit_form" role="form" method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName');?>:</label>
                    <div class="col-md-4">
                        <input class="form-control input-inline " type="text" name="add_ncw_name" id="add_ncw_name" value="">
                    </div>
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CourswareSN');?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="add_ncw_sn" id = "add_ncw_sn" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('UnitName');?>:</label>
                    <div class="col-md-3">
                        <select class="form-control " id="add_nunit_name" name="add_nunit_name">
                            <?php foreach($nunitSets as $nunit):?>
                                <option value="<?= $nunit->nunit_id;?>"><?= $nunit->nunit_name;?></option>
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
                <div class="form-group" style="margin-bottom: 0;">
                        <label class="col-md-2 control-label"><?php echo $this->lang->line('ChildCourseName');?>:</label>
                        <div class="col-md-3">
                            <select class="form-control" id="add_nccs_name" name="add_nccs_name">
                                <?php foreach($nccsSets as $nccs):?>
                                    <option value="<?= $nccs->childcourse_id;?>"><?= $nccs->childcourse_name;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <label class="col-md-offset-1 col-md-2 control-label" ><?php echo $this->lang->line('IsFree');?>:</label>
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
                    <label for="cwImageUpload" class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareImage');?>:</label>
                    <div class="col-md-3">
                        <input type="file" id="add_ncw_upload_img" class="form-control" name = "add_file_name" onchange="add_upload_image();">
                        <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription');?></p>
                    </div>

                </div>
                <div class="form-group">
                    <label for="ncwPackageUpload" class="col-md-2 control-label"><?php echo $this->lang->line('UploadSubwarePackage');?>:</label>
                    <div class="col-md-3">
                        <input type="file" id="add_ncw_upload_package"  class="form-control" name = "add_package_file_name">
                    </div>
                    <div style="position: absolute;top: 37%;left: 56%;width: 38%;height: 43%;">
                        <img width="220" height="150" src="#"  class="img-rounded " alt="Image 300x300" id="add_ncw_preview_image">
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="col-md-2" style="padding-bottom: 15px;text-align: -webkit-center;margin-top: 30px;">
                        <button type = "submit" class="btn green" id="add_ncw_save" ><?php echo $this->lang->line('Save');?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--   edit modal  -->
<div id="ncw_edit_modal" class="modal fade" tabindex="-1" data-width="750">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('AddNewCourseWare');?></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" action=""  id="ncw_edit_submit_form" role="form" method="post" accept-charset="utf-8">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CoursewareName');?>:</label>
                    <div class="col-md-4">
                        <input class="form-control input-inline " type="text" name="edit_ncw_name" id="edit_ncw_name" value="">
                    </div>
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('CourswareSN');?>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-inline" name="edit_ncw_sn" id = "edit_ncw_sn" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('UnitName');?>:</label>
                    <div class="col-md-3">
                        <select class="form-control " id="edit_nunit_name" name="edit_nunit_name">
                            <?php foreach($nunitSets as $nunit):?>
                                <option value="<?= $nunit->nunit_id;?>"><?= $nunit->nunit_name;?></option>
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
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="col-md-2 control-label"><?php echo $this->lang->line('ChildCourseName');?>:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_nccs_name" name="edit_nccs_name">
                            <?php foreach($nccsSets as $nccs):?>
                                <option value="<?= $nccs->childcourse_id;?>"><?= $nccs->childcourse_name;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <label class="col-md-offset-1 col-md-2 control-label" ><?php echo $this->lang->line('IsFree');?>:</label>
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
                        <input type="file" id="edit_ncw_upload_img" name = "edit_file_name" onchange="edit_upload_image();">
                        <p class="help-block"><?php echo $this->lang->line('ImageUploadDescription');?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ncwPackageUpload" class="col-md-2 control-label"><?php echo $this->lang->line('UploadSubwarePackage');?>:</label>
                    <div class="col-md-3">
                        <input type="file" class="form-control" name = "edit_package_file_name">
                    </div>
                    <div style="position: absolute;top: 37%;left: 56%;width: 38%;height: 43%;">
                        <img  src="#"  class="img-rounded " alt="Image 300x300" id="edit_ncw_preview_image" style="width:100%;height: 100%">
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="form-group">
                    <div class="col-md-2" style="padding-bottom: 15px;text-align: -webkit-center;margin-top: 30px;">
                        <button type = "submit" class="btn green" id="edit_ncw_save" ><?php echo $this->lang->line('Save');?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!----delete modal-->
<div id="ncw_delete_modal" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $this->lang->line('Message');?></h4>
    </div>
    <div class="modal-body" style="text-align:center;">
        <h4 class="modal-title"><?php echo $this->lang->line('DeleteConfirmMessage');?></h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green" id="delete_ncw_item_btn"><?php echo $this->lang->line('Yes');?></button>
        <button type="button" data-dismiss="modal"  class="btn btn-outline dark"><?php echo $this->lang->line('No');?></button>
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
    var pager = new Pager('ncwInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'pageNavPosition');
    pager.showPage(1);
    //-->
</script>
<!---------pagenation module--------->
<script>
  function executionPageNation()
  {
     var pager = new Pager('ncwInfo_tbl', showedItems);
     pager.init();
     pager.showPageNav('pager', 'pageNavPosition');
     pager.showPage(currentShowedPage);
  }
  function edit_ncw(self)
  {
      var ncw_id = self.getAttribute("ncw_id");
      var isFree  = self.getAttribute("ncw-free");
      var ncw_photo =  baseURL+self.getAttribute("ncw_photo");
      var tdtag = self.parentNode;
      var trtag = tdtag.parentNode;
      var ncw_sn = trtag.cells[0].innerHTML;
      var ncw_name = trtag.cells[1].innerHTML;

      var nunit_name = trtag.cells[2].innerHTML;

      $('#edit_nunit_name').find('option').filter(function (){
          return ( ($(this).val() == nunit_name) || ($(this).text() == nunit_name) )
      }).prop('selected',true);

      if(isFree=='0')
      {
          $('#free_no_option').prop('checked',true);
      }else{
          $('#free_yes_option').prop('checked',true);
      }
      jQuery("#edit_ncw_save").attr('ncw_id',ncw_id);
      jQuery("#edit_ncw_name").val(ncw_name);
      jQuery("#edit_ncw_sn").val(ncw_sn);
      jQuery("#edit_ncw_preview_image").attr('src',ncw_photo);

      jQuery("#ncw_edit_modal").modal({
          backdrop: 'static',
          keyboard: false
      });
  }
  function edit_upload_image()
  {
      var preview = document.getElementById('edit_ncw_preview_image');
      var file = document.getElementById('edit_ncw_upload_img').files[0];
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
  function add_upload_image()
  {
      var preview = document.getElementById('add_ncw_preview_image');
      var file = document.getElementById('add_ncw_upload_img').files[0];
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
  function delete_ncw(self)
  {
      var ncw_id = self.getAttribute("ncw_id");
       $("#delete_ncw_item_btn").attr("delete_ncw_id",ncw_id);
      $("#ncw_delete_modal").modal({
          backdrop: 'static',
          keyboard: false
      });
  }
  function publish_ncw(self){
      var ncw_id = self.getAttribute("ncw_id");
      var publish = "<?php echo $this->lang->line('Publish');?>";
      var unpublish = "<?php echo $this->lang->line('UnPublish');?>";
      var curBtnText = self.innerHTML;
      var pub_st = '1';
      if(publish==curBtnText)
      {
          self.innerHTML = unpublish;
      }
      else{
          self.innerHTML = publish;
          pub_st = '0';
      }
      ///ajax process for publish/unpublish
      $.ajax({
          type: "post",
          url: baseURL+"admin/ncoursewares/publish",
          dataType: "json",
          data: {ncw_id: ncw_id,publish_state:pub_st},
          success: function(res) {
              if(res.status=='success') {
                 console.log('courseware publish has been successed!')
              }
              else//failed
              {
                  alert("Cannot delete CourseWare Item.");
              }
          }
      });
  }
//  add_new_cw_btn
  jQuery("#add_new_ncw_btn").click(function () {

      $('#add_ncw_name').val('');
      $('#add_ncw_sn').val('');
      $('#add_ncw_preview_image').attr('src',baseURL+'assets/images/no_image.jpg');
      $('#add_ncw_upload_img').val('');

      jQuery("#ncw_addNew_modal").modal({
          backdrop: 'static',
          keyboard: false
      });
  });
  jQuery("#ncw_name_search").keyup(function () {

      var input, filter, table, tr, td, i;
      input = document.getElementById("ncw_name_search");
      filter = input.value.toUpperCase();
      table = document.getElementById("ncwInfo_tbl");
      tr = table.getElementsByTagName("tr");
      // Loop through all table rows, and hide those who don't match the search query
      if(tr.length<2) return;
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
  jQuery("#keyword_ncw_search").keyup(function () {///search for keyword
      var input, filter, table, tr, td, i,tdCnt;
      input = document.getElementById("keyword_ncw_search");
      filter = input.value.toUpperCase();
      table = document.getElementById("ncwInfo_tbl");
      tr = table.getElementsByTagName("tr");
      // Loop through all table rows, and hide those who don't match the search query
      if(tr.length<2) return;
      for (i = 1; i < tr.length; i++) {

          var cmpst = 0;
          for(j=0;j<5;j++)//5 is search filed count
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
<script src="<?= base_url('assets/js/custom/admin/ncw.js')?>"></script>



