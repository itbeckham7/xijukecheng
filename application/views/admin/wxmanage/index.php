<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height: 1305px;">
        <h1 class="page-title"><?= $pageTitle ?>
            <small></small>
        </h1>
        <div class="row">
            <div class="form-group">
                <label class="col-md-2 control-label" style="width:100px;padding-top: 7px;">微信登录 :</label>
                <div class="col-md-3">
                    <div class="mt-radio-inline">
                        <label class="mt-radio mt-radio-outline">
                            <input type="radio" name="free_option" value="1"
                                   id="free_yes_option" <?= ($wxStatus == '1' ? 'checked="checked"' : '') ?>>开
                            <span></span>
                        </label>
                        <label class="mt-radio mt-radio-outline">
                            <input type="radio" name="free_option" value="0"
                                   id="free_no_option" <?= ($wxStatus != '1' ? 'checked="checked"' : '') ?>>关<span></span>
                        </label>
                    </div>
                </div>
                <div class="price_group" style="display: none;">
                    <label class="control-label">价格</label>
                    <input type="number" class="form-control input-inline" name="cw_price" id="cw_price" value="0.00">
                    <label class="control-label">元</label>
                </div>
            </div>
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<script>
    var baseURL = "<?php echo base_url();?>";

    $('input[type="radio"]').on('click', function (object) {
        var status = $(this).val();
        $.ajax({
            type: "post",
            url: baseURL + "admin/wxmanage/update_wxstatus",
            dataType: "json",
            data: {wx_status: status},
            success: function (res) {
                if (res.status == 'success') {
//                    $('input[type="radio"]')
                    console.log('courseware publish has been successed!')
                }
                else//failed
                {
                    alert("Cannot set Weixin Status.");
                }
            }
        });
    });
</script>


