<?php
$admin_id = $this->session->userdata("admin_loginuserID");
$admin = '';
if( !empty( $admin_id ) ){
    $admin = $this->admins_m->get_single_admin( $admin_id );
}
?>
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?= base_url('admin')?>">
                <img src="<?= base_url('assets/images/backend-logo.png') ?>" alt="logo" class="logo-default"> </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TITLE -->
        <div class="nav navbar-nav pull-left" style="color: white;font-size: 26px;line-height: 1.9;font-weight: bold;"><?= $this->lang->line('site_title'); ?></div>
        <!-- END TITLE -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <?php if( !empty( $admin_id ) ) : ?>
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="<?= base_url('assets/images/user-profile.png') ?>">
                        <span class="username username-hide-on-mobile"> <?php echo $admin->admin_name ?> </span>
<!--                        <i class="fa fa-angle-down"></i>-->
                    </a>
<!--                    <ul class="dropdown-menu dropdown-menu-default">-->
<!--                        <li>-->
<!--                            <a href="--><?//= base_url('users/view/' . $admin_id) ?><!--">-->
<!--                                <i class="icon-user"></i> My Profile </a>-->
<!--                        </li>-->
<!--                        <li class="divider"> </li>-->
<!---->
<!--                    </ul>-->
                </li>
                <li>
                    <a href="<?= base_url('admin/signin/signout') ?>">
                        <i class="icon-key"></i> 退出 </a>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<!--                <li class="dropdown dropdown-quick-sidebar-toggler">-->
<!--                    <a href="javascript:;" class="dropdown-toggle">-->
<!--                        <i class="icon-logout"></i>-->
<!--                    </a>-->
<!--                </li>-->
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
            <?php endif; ?>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
