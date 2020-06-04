<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>中西文化面对面</title>
	
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="呼啦啦教育出版社">
	<meta name="keywords" content="课本剧,呼啦啦,教育,小学,中学,高中,宫菲,ExIdeaTech"/>
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">

    <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico')?>" type="image/x-icon">

    <style>
	body, html{
        height: 100%;
        margin: 0;
		position:fixed;
		width:100%
    }
    </style>

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

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/xiaoxueapp/styles.css') ?>">

    <script src="<?= base_url('assets/js/jquery-1.12.3.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom/my_lib.js') ?>"></script>

    <script type="text/javascript">
        var base_url = "<?= base_url() ?>";
        var baseURL = "<?= base_url() ?>";
		document.ontouchmove = function(event){
				event.preventDefault();
			}

        function checkBrowser(){
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf('MSIE ');
            var trident = ua.indexOf('Trident/');
            var edge = ua.indexOf('Edge/');

            if (msie > 0 || trident > 0 || edge > 0) {
                location.replace(base_url + 'assets/360.html')
                return;
            }

            var chrome = ua.indexOf('Chrome/');
            if( chrome > 0 ){
                var version = parseInt(ua.substring(chrome+7, ua.indexOf('.', chrome)), 10)
                if( version < 78 ){
                    // alert('-- version : ' + version)
                    // location.replace(base_url + 'assets/360.html')
                    return;
                }
            }
        }
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <script src="<?= base_url('assets/js/jquery-1.12.3.min.js') ?>"></script>
    <![endif]-->
</head>
<body onload="checkBrowser()">


<?php

$user_type = $this->session->userdata("user_type");
if($user_type=='1'&&$this->session->userdata("loggedin")){ ?>
    <a data-url="<?= base_url('assets/pdf/teacher_reference.pdf');?>" target="_blank" class="teacher-reference-btn" style="display: none;"></a>
    <?php

}
?>
<div class="teacher_reference_pdf">
    <object data="../../../assets/pdf/teacher_reference.pdf"></object>
</div>

<script>
    var isShowingPDF = true;
    var initailHeight = $(window).height();
    $(window).resize(function()
    {
        $(window).height(initailHeight);

    });

    $('.teacher-reference-btn').click(function () {
        var pdfURL = $(this).attr('data-url');
        if (!executeCMD('show_reference_pdf', pdfURL))
            window.open(pdfURL);
    });

</script>