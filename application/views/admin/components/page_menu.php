<?php
//$usertype = $this->session->userdata("user_type");
if (!isset($menu)) $menu = "";
?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="true" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!----------Course Manage Side Menu------------>
            <li class="nav-item parent" data-id="1" data-expand="0">
                <a href="javascript:;" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="title">内容管理</span>
                </a>
            </li>
            <li class="nav-item" data-parent="1" data-menu="11">
                <a href="<?= base_url('admin/courses/index') ?>" class="nav-link">
                    <i class="icon-docs"></i>
                    <span class="title">课程管理</span>
                </a>
            </li>
            <!--<li class="nav-item" data-parent="1">
                <a href="<? /*= base_url('admin/units/index') */ ?>" class="nav-link" id="unit_menu">
                    <i class="fa fa-tasks"></i>
                    <span class="title"><?php /*echo $this->lang->line('sub_panel_title_unit'); */ ?></span>
                </a>
            </li>-->
            <li class="nav-item" data-parent="1" data-menu="12">
                <a href="<?= base_url('admin/coursewares/index') ?>" class="nav-link">
                    <i class="icon-layers"></i>
                    <span class="title">Web课件管理</span>
                </a>
            </li>
            <li class="nav-item" data-parent="1" data-menu="14">
                <a href="<?= base_url('admin/coursewaresub/index')  ?>" class="nav-link " id="subware_menu">
                    <i class="icon-link"></i>
                    <span class="title">Web趣表演内容管理</span>
                </a>
            </li>
            <li class="nav-item" data-parent="1" data-menu="13">
                <a href="<?= base_url('admin/paycoursewares') ?>" class="nav-link">
                    <i class="icon-layers"></i>
                    <span class="title">APP课件管理</span>
                </a>
            </li>
            <li class="nav-item" data-parent="1" data-menu="15">
                <a href="<?= base_url('admin/paycoursewaresub/index')  ?>" class="nav-link " id="subware_menu">
                    <i class="icon-link"></i>
                    <span class="title">APP趣表演内容管理</span>
                </a>
            </li>
            <!----------New course manage-------------------->
            <li class="nav-item parent" data-id="2" data-expand="0">
                <a href="javascript:;" class="nav-link" id="newcourse_menu">
                    <i class="icon-docs"></i>
                    <span class="title">三大篇管理</span>
                </a>
            </li>
            <li class="nav-item " data-parent="2" data-menu="21">
                <a href="<?= base_url('admin/nchildcourses/index') ?>" class="nav-link" id="newchildcourse_menu">
                    <i class="icon-link"></i>
                    <span class="title">子课程管理</span>
                </a>
            </li>
            <li class="nav-item  " data-parent="2" data-menu="22">
                <a href="<?= base_url('admin/nunits/index') ?>" class="nav-link" id="newunit_menu">
                    <i class="fa fa-tasks"></i>
                    <span class="title">单元管理</span>
                </a>
            </li>
            <li class="nav-item  " data-parent="2" data-menu="23">
                <a href="<?= base_url('admin/ncoursewares/index') ?>" class="nav-link " id="newcourseware_menu">
                    <i class="icon-layers"></i>
                    <span class="title">课件管理</span>
                </a>
            </li>
            <!----------Community Manage------------------->
            <li class="nav-item parent" data-id="3">
                <a href="javascript:;" class="nav-link ">
                    <i class="fa fa-object-group"></i>
                    <span class="title">社区管理</span>
                </a>
            </li>
            <li class="nav-item  " data-parent="3" data-menu="31">
                <a href="<?= base_url('admin/contents/index') ?>" class="nav-link " id="content_menu">
                    <i class="icon-notebook"></i>
                    <span class="title">内容管理</span>
                </a>
            </li>
            <li class="nav-item" data-parent="3" data-menu="32">
                <a href="<?= base_url('admin/comments/index') ?>" class="nav-link " id="comment_menu">
                    <i class="fa fa-commenting-o"></i>
                    <span class="title">评论管理</span>
                </a>
            </li>
            <!----------Account Manage Menu---------------->
            <li class="nav-item parent" data-id="4" data-expand="0">
                <a href="javascript:;" class="nav-link ">
                    <i class="icon-user"></i>
                    <span class="title">用户管理</span>
                </a>
            </li>
            <li class="nav-item" data-parent="4" data-menu="41">
                <a href="<?= base_url('admin/schools/index') ?>" class="nav-link " id="school_menu">
                    <i class="fa fa-university"></i>
                    <span class="title">学校管理</span>
                </a>
            </li>
            <li class="nav-item" data-parent="4" data-menu="42">
                <a href="<?= base_url('admin/users/index') ?>" class="nav-link " id="user_menu">
                    <i class="icon-users"></i>
                    <span class="title">用户管理</span>
                </a>
            </li>
            <!----------Account Manage Menu---------------->
            <li class="nav-item parent" data-id="5" data-expand="0">
                <a href="javascript:;" class="nav-link ">
                    <i class="fa fa-line-chart"></i>
                    <span class="title">数据统计</span>
                </a>
            </li>
            <li class="nav-item" data-parent="5" data-menu="51">
                <a href="<?= base_url('admin/statistics/subwares') ?>" class="nav-link">
                    <i class="fa fa-line-chart"></i>
                    <span class="title">订单统计</span>
                </a>
            </li>
            <li class="nav-item" data-parent="5" data-menu="52">
                <a href="<?= base_url('admin/statistics/coursewares') ?>" class="nav-link " id="statistics_menu">
                    <i class="fa fa-line-chart"></i>
                    <span class="title">课件数据统计</span>
                </a>
            </li>
            <li class="nav-item" data-parent="5" data-menu="53">
                <a href="<?= base_url('admin/statistics/index') ?>" class="nav-link " id="statistics_menu">
                    <i class="fa fa-line-chart"></i>
                    <span class="title">用户登录情况统计</span>
                </a>
            </li>
            <!----------Account Manage Menu---------------->
            <li class="nav-item parent" data-id="6" data-expand="0">
                <a href="javascript:;" class="nav-link ">
                    <i class="icon-users"></i>
                    <span class="title">权限</span>
                </a>
            </li>
            <li class="nav-item" data-parent="6" data-menu="61">
                <a href="<?= base_url('admin/admins/index') ?>" class="nav-link " id="admin_menu">
                    <i class="icon-users"></i>
                    <span class="title">角色管理</span>
                </a>
            </li>
            <!----------Account Manage Menu---------------->
            <li class="nav-item parent" data-id="7" data-expand="0">
                <a href="javascript:;" class="nav-link ">
                    <i class="fa fa-wechat"></i>
                    <span class="title">微信管理</span>
                </a>
            </li>
            <li class="nav-item" data-parent="7" data-menu="71">
                <a href="<?= base_url('admin/wxmanage') ?>" class="nav-link " id="admin_menu">
                    <i class="fa fa-wechat"></i>
                    <span class="title">微信开关</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
<script>
    $('li.nav-item[data-menu="<?= $menu?>"]').attr('data-sel', 1);
    // $(function () {
    var pMenuId = $('li.nav-item[data-sel="1"]').attr('data-parent');
    $('li.nav-item.parent[data-id="' + pMenuId + '"]').attr('data-expand', 1);
    $('li.nav-item.parent').on('click', function () {
        var that = $(this);
        var isExpanded = (that.attr('data-expand') == '1');
        var id = that.attr('data-id');
        $('li.nav-item.parent').attr('data-expand', 0);
        $('li.nav-item[data-parent]').slideUp(50);
        that.attr('data-expand', 1);
        $('li.nav-item[data-parent="' + id + '"]').slideDown();
    }).each(function (idx, elem) {
        var that = $(elem);
        var isExpanded = (that.attr('data-expand') == '1');
        var id = that.attr('data-id');
        if (isExpanded)
            $('li.nav-item[data-parent="' + id + '"]').show();
        else
            $('li.nav-item[data-parent="' + id + '"]').hide();
    });
    $('li.nav-item[data-parent]').on('click', function () {
        var that = $(this);
        var id = that.attr('data-id');
        $('li.nav-item[data-parent]').removeAttr('data-sel');
        that.attr('data-sel', 1);
    })
    // })
</script>


