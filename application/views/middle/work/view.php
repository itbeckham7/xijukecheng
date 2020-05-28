<?php
$loggedIn_UserID = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$ownerSt = TRUE;
$imageAbsDir = base_url() . 'assets/images/middle/';
$bac_img_path = $imageAbsDir . 'mywork/bg-view.png';
if ($loggedIn_UserID != $user_id)//if current user is not owner of work.
{
    $ownerSt = FALSE;
    $bac_img_path = $imageAbsDir . 'mywork/bg-view.png';
}
$myworkURL = 'middle/work';
$returnURL = 'middle/coursewares/index';
$hd_menu_img_path = '';
if ($user_type == '2') {
    $myworkURL = 'middle/work';
    $returnURL = 'middle/coursewares/index';
    $hd_menu_img_path = $imageAbsDir . 'mywork/';
} else {
    $hd_menu_img_path = $imageAbsDir . 'mywork/stu_';
}
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/work_list_view.css') ?>"/>
<style>
    .list_title {
        position: absolute;
        left: 10%;
        width: 1079px;
        height: 70px;
        font-size: 30px;
        border-radius: 25px;
        background-color: #bbdffe;
        background-size: 100% 100%;
        padding-top: 12px;
        padding-left: 20px;
        text-decoration: none !important;
        color: #153c63;
    }

    .list_title:hover, .list_title:focus{
        color: #30a4ff;
    }

    .list_title2 {
        position: absolute;
        left: 6.67%;
        width: 58.5%;
        height: 100%;
        font-size: 20px;
        background: url(<?= $imageAbsDir.'mywork/item_bg.png';?>);
        background-size: 100% 100%;
        padding-top: 12px;
        padding-left: 5%;
        text-decoration: none !important;
    }

    .list_upload {
        position: absolute;
        left: 76.5%;
        width: 11%;
        height: 100%;
        background-size: 100% 100%;
    }

    .list_delete {
        position: absolute;
        right: 6.2%;
        width: 4.43%;
        height: 100%;
        background: url(<?= $imageAbsDir.'mywork/delete.png';?>);
        background-size: 100% 100%;
    }

    .list_delete_tech {
        position: absolute;
        right: 21%;
        width: 4.43%;
        height: 100%;
        background: url(<?= $imageAbsDir.'mywork/delete.png';?>);
        background-size: 100% 100%;
    }

    .list_delete2 {
        position: absolute;
        right: 18%;
        width: 4.43%;
        height: 100%;
        background: url(<?= $imageAbsDir.'mywork/delete.png';?>);
        background-size: 100% 100%;
    }

    .list_share {
        position: absolute;
        right: 0;
        width: 4.43%;
        height: 100%;
        background: url(<?= $imageAbsDir.'mywork/share.png';?>);
        background-size: 100% 100%;
    }

    .list_share_tech {
        position: absolute;
        right: 15%;
        width: 4.43%;
        height: 100%;
        background: url(<?= $imageAbsDir.'mywork/share.png';?>);
        background-size: 100% 100%;
    }
</style>
<div class="bg" style="background-color: #f4f4f4;">
    <img src="<?= $bac_img_path ?>" class="background_image">
</div>
<div class="course_type_menu">
    <a href="<?= base_url('middle/work/script') . '/' . $user_id; ?>" data-type="script"><span>剧本作品</span></a>
    <a href="<?= base_url('middle/work/dubbing') . '/' . $user_id; ?>" data-type="dubbing"><span>配音作品</span></a>
    <!--    <a href="--><? //= base_url('middle/work/head') . '/' . $user_id; ?><!--"></a>-->
    <a href="<?= base_url('middle/work/shooting') . '/' . $user_id; ?>" data-type="shooting"><span>表演作品</span></a>
</div>

<?php if ($this->session->userdata("loggedin") != FALSE) { ?>
    <a class="btn-main mywork" href="<?= base_url($myworkURL); ?>"
    ><span><?= ($user_type=='2')?'我的':'学生'; ?>作品</span></a>
    <a class="btn-main community" href="<?= base_url('middle/') . 'community/index'; ?>"
    ><span>戏剧社区</span></a>
    <a class="btn-main profile"
       href="<?= base_url('middle/') . 'users/profile/' . $loggedIn_UserID; ?>"
    ><span>个人中心</span></a>
<?php } else if ($this->session->userdata("loggedin") == FALSE) { ?>
    <a class="btn-main register-btn" href="<?= base_url('signin/index') ?>"><span>登录</span></a>
<?php } ?>
<a href="javascript:;" onclick="location.replace('<?= base_url('/middle/work') ?>');" class="btn-main back-btn"></a>


<a href="javascript:;" class="btn-work previous_Btn">上一页</a>

<a href="javascript:;" class="btn-work next_Btn">下一页</a>

<div class="content_list_wrapper"></div>

<style type="text/css">
    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000;
        opacity: 0;
        filter: alpha(opacity=0);
        z-index: 50;
        display: none;
    }

    .custom-modal {
        position: absolute;
        top: 30%;
        left: 35%;
        width: 30.5%;
        height: 31.2%;
        background: #ffffff;
        z-index: 51;
        display: none;
        border-radius: 10%;
    }

    .share_modal_content {
        background: url(<?= $imageAbsDir.'mywork/share_confirmbg1.png'?>);
        background-size: 100% 100%;
        width: 100%;
        height: 100%;
    }

    #content_share_btn {
        position: absolute;
        background: url(<?= $imageAbsDir.'mywork/yes.png'?>) no-repeat;
        background-size: 100% 100%;
        width: 20%;
        height: 20%;
        left: 14%;
        top: 68%;
    }

    .share_close_btn {
        position: absolute;
        background: url(<?= $imageAbsDir.'mywork/no.png'?>) no-repeat;
        background-size: 100% 100%;
        width: 20%;
        height: 20%;
        left: 67%;
        top: 68%;
    }
</style>
<div class="modal-backdrop"></div>
<!-----------delete modal------------------>
<div class="modal fade" id="delete_contentItem_modal">
    <div class="modal-dialog modal-sm" role="document">
        <form action="" method="post" id="content_delete_form">
            <div class="modal-content">
                <div class="modal-header"
                     style="padding-right:20px;padding-top: 3px;padding-bottom: 10px;text-align: center">
                    <h5 class="modal-title"
                        style="margin-top: 5px;font-weight: bold"></h5>
                </div>
                <?php if ($loggedIn_UserID == $user_id) {///current logged in user is student?>
                    <div class="modal-body" style="text-align: center">
                        <h3 class="modal-title"
                            style="margin: 30px 0;font-weight: bold"><?php
                            if ($user_type == '1') echo $this->lang->line('DeleteConfirmMsg_Teacher');
                            else echo "确定删除该作品内容？";
                            ?></h3>
                        <label class="checkbox-inline" style="display: none;">
                            <input type="checkbox" value="1" hidden
                                   id="localfile_chk"><?php echo $this->lang->line('LocalFile'); ?>
                        </label>
                        <label class="checkbox-inline" style="display: none;">
                            <input type="checkbox" value="0" hidden
                                   id="cloudfile_chk"><?php echo $this->lang->line('CloudFile'); ?>
                        </label>
                    </div>
                <?php } ?>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="submit" class="btn btn-red"
                                    id="content_delete_btn"><?php echo $this->lang->line('Yes'); ?></button>
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
<!-----------Share content Modal------------>
<div class="modal fade" id="share_content_modal">
    <div class="modal-dialog modal-sm" role="document">
        <form action="" method="post" id="content_share_form">
            <div class="modal-content">
                <div class="modal-header"
                     style="padding-right:20px;padding-top: 3px;padding-bottom: 10px;text-align: center">
                    <h5 class="modal-title"
                        style="margin-top: 5px;font-weight: bold"></h5>
                </div>
                <?php if ($loggedIn_UserID == $user_id) {///current logged in user is student?>
                    <div class="modal-body" style="text-align: center">
                        <h3 class="modal-title"
                            style="margin: 30px 0;font-weight: bold">确认分享到戏剧社区？</h3>
                    </div>
                <?php } ?>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center">
                            <button type="submit" class="btn btn-red"
                                    id="content_delete_btn"><?php echo $this->lang->line('Yes'); ?></button>
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
<!-----------share content Modal------------>

<script>
    var prev_btn = $('.previous_Btn');
    var next_btn = $('.next_Btn');
    var localStr = '<?= $this->lang->line('Local');?>';
    var cloudStr = '<?= $this->lang->line('Cloud');?>';

    function hiddenImageMark(self) {

    }

    function showImageMark(self) {
    }

    function hiddenImageMarkCloud(self) {
    }

    function showImageMarkCloud(self) {
    }

    function changeUploadOver(self) {
    }

    function changeUploadOut(self) {
    }

    function changeDeleteImgOver(self) {
    }

    function changeDeleteImgOut(self) {
    }

    function changeShareImgOver(self) {
    }

    function changeShareImgOut(self) {
    }
</script>
<script>
    ///at first mouseover effects

    var content_type_id = '<?php echo $content_type_id;?>';
    var loggedUserId = '<?php echo $loggedIn_UserID;?>';
    var contentUserId = '<?php echo $user_id;?>';
    var logedInUsertype = '<?php if ($loggedIn_UserID != $user_id) echo '1'; else echo '2' ?>';
    var userType = '<?= $user_type; ?>';//This value can be student or teacher(1=>teacher, 2=>student)

    var studentId = '<?php echo $user_id;?>';
    var contentListStr = '<?php echo json_encode($contents);?>';
    var contentList = JSON.parse(contentListStr);
    var imageDir = base_url + 'assets/images/middle/';
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';


    function contentPager(conentList, listWrapper) {
        this.perPage = 7;
        this.curPageNo = 0;
        this.PageCount = 0;
        this.conList = conentList;
        this.listWrapper = listWrapper;
        this.init = function () {
            var output_html = '';
            var modeVar = 0;
            var availableCount = -1;
            for (var i = 0; i < this.conList.length; i++) {
                var tempObj = this.conList[i];

                if (logedInUsertype == '1') {
                    if (tempObj['public'] == '1') availableCount++;
                } else {
                    availableCount++;
                }
                modeVar = availableCount % this.perPage;
                var pageNo = (availableCount - modeVar) / this.perPage;
                this.PageCount = pageNo;
                if (modeVar == 0) {
                    if (pageNo != 0) output_html += '</div>';
                    output_html += '<div class = "list_page_' + pageNo + '" style="display: none">';
                    output_html += this.make_item(modeVar, tempObj);

                } else {
                    output_html += this.make_item(modeVar, tempObj);
                }

            }
            output_html += '</div>';
            $('.' + this.listWrapper).html(output_html);
        };
        this.make_item = function (orderNo, contentInfo) {
            var interHieght = 3.5;
            var itemHeight = 10.2;
            var topVal = orderNo * itemHeight + interHieght * (orderNo + 1);
            var topValStr = topVal + '%';
            var output_html = '';
            if (logedInUsertype == '2') {

                if (userType == '1') {//if user is teacher and teacher see his information
                    output_html += '<div class="list_item_wrapper" style="top:' + topValStr + '">';
                    output_html += '<a class = "local_mark"';
                    if (contentInfo['local'] == '1') {
                        output_html += 'href="javascript:;" ';
                        output_html += 'style="background:url(' + imageDir + 'mywork/localmark.png);background-size: 100% 100%;left:4%;" >' + '<span class="local_tooltiptext">' + localStr + '</span></a>'
                    } else {
                        output_html += '></a>';
                    }
                    output_html += '<a class = "list_title" href="' + base_url + 'middle/work/view/' + contentInfo['content_id'] + '">';
                    output_html += contentInfo['content_title'] + '</a>';
                    output_html += '<a class = "list_delete" href="javascript:;"';
                    output_html += 'onclick="deleteContentItem(this)" content_id="' + contentInfo['content_id'] + '" content_local=' + contentInfo['local'] + ' content_cloud = ' + contentInfo['public'] + '></a>';
                    output_html += '<a class = "list_share" href="javascript:;" ';
                    output_html += 'onclick="shareContentModal(this)" content_id=' + contentInfo['content_id'] + '></a>';

                    output_html += '</div>';
                } else {
                    output_html += '<div class="list_item_wrapper" style="top:' + topValStr + '">';
                    output_html += '<a class = "local_mark" ';
                    if (contentInfo['local'] == '1') {
                        output_html += 'href="javascript:;" onmouseover="hiddenImageMark(this)" onmouseout="showImageMark(this)"';
                        output_html += 'style="background:url(' + imageDir + 'mywork/localmark.png);background-size: 100% 100%" >' + '<span class="local_tooltiptext">' + localStr + '</span></a>'
                    } else {
                        output_html += '></a>';
                    }
                    // output_html += '<a class = "cloud_mark" ';
                    // if (contentInfo['public'] == '1') {
                    //     output_html += 'href="javascript:;" onmouseover="hiddenImageMarkCloud(this)" onmouseout="showImageMarkCloud(this)"';
                    //     output_html += 'style="background:url(' + imageDir + 'mywork/cloudmark.png);background-size: 100% 100%;">' + '<span class="cloud_tooltiptext">' + cloudStr + '</span></a>'
                    // } else {
                    //     output_html += '></a>';
                    // }
                    output_html += '<a class = "list_title" href="' + base_url + 'middle/work/view/' + contentInfo['content_id'] + '">';
                    output_html += contentInfo['content_title'] + '</a>';

                    // output_html += '<a class = "list_upload" ';
                    // if (contentInfo['public'] == '0') {
                    //     output_html += 'href="javascript:;" content_id="' + contentInfo['content_id'] + '" onmouseover="changeUploadOver(this)" onmouseout="changeUploadOut(this)" ';
                    //     output_html += 'onclick="uploadWork(this)" style="background:url(' + imageDir + 'mywork/upload.png);background-size: 100% 100%">' + '</a>'
                    // } else {
                    //     output_html += '></a>';
                    // }
                    output_html += '<a class = "list_delete" href="javascript:;" ';
                    output_html += 'onclick="deleteContentItem(this)" content_id="' + contentInfo['content_id'] + '" content_local=' + contentInfo['local'] + ' content_cloud = ' + contentInfo['public'] + '></a>';
                    output_html += '<a class = "list_share" href="javascript:;" ';
                    output_html += 'onclick="shareContentModal(this)" content_id=' + contentInfo['content_id'] + '></a>';

                    output_html += '</div>';
                }
            } else {
                if (contentInfo['public'] == '1') {
                    output_html += '<div class="list_item_wrapper" style="top:' + topValStr + '">';
                    // output_html += '<a class = "cloud_mark2" ';
                    // if (contentInfo['public'] == '1') {
                    //     output_html += 'href="javascript:;" onmouseover="hiddenImageMarkCloud(this)" onmouseout="showImageMarkCloud(this)"';
                    //     output_html += 'style="background:url(' + imageDir + 'mywork/cloudmark.png);background-size: 100% 100%">' + '<span class="cloud2_tooltiptext">' + cloudStr + '</span></a>'
                    // } else {
                    //     output_html += '></a>';
                    // }
                    output_html += '<a class = "list_title" href="' + base_url + 'middle/work/view/' + contentInfo['content_id'] + '">';
                    output_html += contentInfo['content_title'] + '</a>';
                    // output_html += '<a class = "list_delete" href="javascript:;" ';
                    // output_html += 'onclick="deleteContentItem(this)" content_id="' + contentInfo['content_id'] + '" content_local=' + contentInfo['local'] + ' content_cloud = ' + contentInfo['public'] + '></a>';
                    output_html += '</div>';
                }
            }
            return output_html;
        };
        this.showPage = function () {
            var classStr = '.list_page_' + this.curPageNo;
            $(classStr).show('slow');
        };
        this.hidePage = function () {
            var classStr = '.list_page_' + this.curPageNo;
            $(classStr).hide();
        };
        this.nextPage = function () {
            if (this.curPageNo > this.PageCount - 1) return;
            this.hidePage(this.curPageNo);
            this.curPageNo++;
            this.showPage(this.curPageNo);

        };
        this.prevPage = function () {
            if (this.curPageNo < 1) return;
            this.hidePage(this.curPageNo);
            this.curPageNo--;
            this.showPage(this.curPageNo);
        }
    }

    var pager = new contentPager(contentList, 'content_list_wrapper');
    pager.init();

    pager.showPage();

    prev_btn.click(function () {
        pager.prevPage();
    });
    next_btn.click(function () {
        pager.nextPage();
    });

    function uploadWork(self) {
        var content_id = self.getAttribute('content_id');
        ///set status of cloud in content table as 1 and hide "UploadJob"
        jQuery.ajax({
            type: "post",
            url: baseURL + "middle/work/uploadJob",
            dataType: "json",
            data: {student_id: studentId, content_type_id: content_type_id, content_id: content_id},
            success: function (res) {
                if (res.status == 'success') {
                    pager.conList = res.data;
                    pager.init();
                    pager.showPage();
                } else//failed
                {
                    alert("Cannot Upload work.");
                }
            }
        });
    }

    $('#content_share_btn').click(function () {

        var content_id = $(this).attr('content_id');
        shareContentItem(content_id);
    });
    jQuery('#content_delete_form').submit(function (e) {
        e.preventDefault();

        var contentDelBtn = $('#content_delete_btn');
        var contentId = contentDelBtn.attr('content_id');
        var contentLocal = contentDelBtn.attr('content_local');
        var contentCloud = contentDelBtn.attr('content_cloud');

        var ajaxURL = '';
        var ajaxData = {student_id: studentId, content_type_id: content_type_id, content_id: contentId};
        ajaxData.content_local = contentLocal;
        ajaxData.content_cloud = contentCloud;

        if (userType == '1') {
            ajaxData.content_cloud = '0';
            ajaxData.content_local = '0';
            ajaxURL = baseURL + "middle/work/delete_content";
        } else {
            if (logedInUsertype == '2') {///this mean current user is student
                if ($('#localfile_chk').is(':checked')) contentLocal = '0';
                if ($('#cloudfile_chk').is(':checked')) contentCloud = '0';

                if (contentLocal == '0' && contentCloud == '0') {
                    ajaxURL = baseURL + "middle/work/delete_content";
                } else {
                    ajaxURL = baseURL + "middle/work/update_content";
                    ajaxData.content_local = contentLocal;
                    ajaxData.content_cloud = contentCloud;
                }
            } else {
                ajaxData.content_cloud = '0';
                ajaxData.content_local = contentLocal;
                ajaxURL = baseURL + "middle/work/update_content";
                if (contentLocal == '0') {
                    ajaxURL = baseURL + "middle/work/delete_content";
                }
            }
        }
        jQuery.ajax({
            type: "post",
            url: ajaxURL,
            dataType: "json",
            data: ajaxData,
            success: function (res) {
                if (res.status == 'success') {
                    pager.conList = res.data;
                    pager.init();
                    pager.showPage();
                    $('#delete_contentItem_modal').modal('toggle');
                } else//failed
                {
                    alert("Cannot Delete work.");
                }
            }
        });
    });

    function deleteContentItem(self) {
        var contentDelBtn = $('#content_delete_btn');
        var content_id = self.getAttribute('content_id');
        var content_local = self.getAttribute('content_local');
        var content_cloud = self.getAttribute('content_cloud');

        contentDelBtn.attr('content_id', content_id);
        contentDelBtn.attr('content_local', content_local);
        contentDelBtn.attr('content_cloud', content_cloud);

        $('#localfile_chk').prop('checked', true);
        $('#cloudfile_chk').prop('checked', false);

        if (userType == '1') {
            // $('#delete_contentItem_modal .modal-body').hide();
        }

        $('#delete_contentItem_modal').modal({
            backdrop: 'static', keyboard: false
        });
    }

    jQuery('#content_share_form').submit(function(e) {
        var content_id = $(this).attr('content_id');
        jQuery.ajax({
            type: "post",
            url: baseURL + "middle/work/share_content",
            dataType: "json",
            data: {student_id: studentId, content_type_id: content_type_id, content_id: content_id},
            success: function (res) {
                if (res.status == 'success') {
                    pager.conList = res.data;
                    pager.init();
                    pager.showPage();
                    close_modal();
                    fitwindow();
                } else//failed
                {
                    alert("Cannot Upload work.");
                }
            }
        });
    });

    function shareContentModal(self) {
        var content_id = self.getAttribute('content_id');
        jQuery('#content_share_form').attr('content_id', content_id);
        jQuery('#share_content_modal').modal({
            backdrop: 'static', keyboard: false
        });
    }
</script>
<script src="<?= base_url('assets/js/custom/middle/work_list_view.js') ?>" type="text/javascript"></script>
