<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
<!--        <h1 class="page-title">--><?php //echo $this->lang->line('sub_panel_title_datastatistics');?>
<!--            <small></small>-->
<!--        </h1>-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="table-toolbar">
                        <!-------Table tool parts----------------->
                        <a class="btn btn-md yellow" href="<?= base_url('admin/statistics/index') ?>" ><?php echo $this->lang->line('LoginStatistics');?></a>
                        <a class="btn btn-md green"  href="<?= base_url('admin/statistics/coursewares') ?>"><?php echo $this->lang->line('CoursewareAccessStatistics');?></a>
                        <a class="btn btn-md green"  href="<?= base_url('admin/statistics/subwares') ?>"><?php echo $this->lang->line('SubwareAccessStatistics');?></a>
                        <!-------Table tool parts----------------->
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="loginInfo_tbl">
                            <thead>
                            <tr>
                                <th style="width:5%"><?php echo $this->lang->line('Account');?></th>
                                <th style="width:5%" ><?php echo $this->lang->line('Name');?></th>
                                <th style="width:7%"><?php echo $this->lang->line('SerialNumber');?></th>
                                <th style="width:4%"><?php echo $this->lang->line('Gender');?></th>
                                <th style="width:8%"><?php echo $this->lang->line('Grade');?></th>
                                <th style="width:12%"><?php echo $this->lang->line('School');?></th>
                                <th style="width:8%"><?php echo $this->lang->line('UserType');?></th>
                                <th style="width:12%"><?php echo $this->lang->line('LoginTime');?></th>
                                <th style="width:12%">IP</th>
                                <th style="width:6%"><?php echo $this->lang->line('LoginNum');?></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($loginSets as $loginItem ):?>
                                    <tr>
                                        <td><?php echo $loginItem->username;?></td>
                                        <td><?php echo $loginItem->fullname?></td>
                                        <td><?php echo $loginItem->user_id;?></td>
                                        <td><?php echo $loginItem->sex;?></td>
                                        <?php if($loginItem->user_type_id=='2'){?>
                                        <td><?php echo $loginItem->class;?></td>
                                        <?php }else{ ?>
                                        <td></td>
                                        <?php } ?>
                                        <td><?php echo $loginItem->school_name;?></td>
                                        <td><?php echo $loginItem->user_type_name;?></td>
                                        <td><?php echo $loginItem->last_login;?></td>
                                        <td><?php echo $loginItem->ip_addr;?></td>
                                        <td><?php echo $loginItem->login_num;?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <div id="loginInfoPageNavPosition"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<style>
    #loginInfo_tbl thead tr th,#loginInfo_tbl tbody tr td
    {
        text-align:center;vertical-align: middle;
    }
</style>
<script>
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
    var pager = new Pager('loginInfo_tbl', showedItems);
    pager.init();
    pager.showPageNav('pager', 'loginInfoPageNavPosition');
    pager.showPage(currentShowedPage);

</script>