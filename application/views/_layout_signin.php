<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Video</title>
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />

    <!-- Style Sheets -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- Font Icons -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/ionicons.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/socicon-styles.css') ?>">
    <!-- Font Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/css/hover-min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/animate.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/css-menu.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/owl.carousel.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/loader.css') ?>" />

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/responsive.css') ?>">

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/extra.css') ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .form-error{
            color: #f66;
        }
    </style>
</head>
<body>
<div id="wrapper toggled">
    <div>
        <?php $this->load->view($subview); ?>
    </div>
</div>

<script src="<?= base_url('assets/js/wow.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery-1.12.3.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/css-menu.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.validate.js') ?>"></script>
<script src="<?= base_url('assets/js/owl.carousel.min.js') ?>"></script>
<!--<script src="--><?//= base_url('assets/js/custom.js') ?><!--"></script>-->

</body>
</html>

