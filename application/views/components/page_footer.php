<?php

?>
<script src="<?= base_url('assets/js/wow.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/css-menu.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.validate.js') ?>"></script>
<script src="<?= base_url('assets/js/owl.carousel.min.js') ?>"></script>
<!-------------------Pdf generator------------------------------------------>
<!--<script src="--><? //= base_url('assets/js/pdf/jspdf.js')?><!--"></script>-->
<!--<script src="--><? //= base_url('assets/js/pdf/pdf_generator.js')?><!--"></script>-->
<!--<script src="--><? //= base_url('assets/js/pdf/jspdf.debug.js')?><!--"></script>-->
<!--<!--<script src="--><? ////= base_url('assets/js/pdf/libs/require/require.js')?><!--<!--"></script>-->
<!--<script src="--><? //= base_url('assets/js/pdf/libs/png_support/zlib.js')?><!--"></script>-->
<!--<script src="--><? //= base_url('assets/js/pdf/libs/png_support/png.js')?><!--"></script>-->
<!--<script src="--><? //= base_url('assets/js/pdf/libs/deflate.js')?><!--"></script>-->
<!--<script src="--><? //= base_url('assets/js/pdf/js/basic.js')?><!--"></script>-->
<!--<script src="--><? //= base_url('assets/js/pdf/plugins/standard_fonts_metrics.js')?><!--"></script>-->
<!---->
<!--<script src="--><? //= base_url('assets/js/pdf/plugins/from_html.js')?><!--"></script>-->
<!--<script src="--><? //= base_url('assets/js/pdf/plugins/split_text_to_size.js')?><!--"></script>-->

<!--<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>-->
<!--<link rel = "stylesheet" type="text/css" href="https://printjs-4de6.kxcdn.com/print.min.css">-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>-->

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/printjs/print.min.css') ?>">
<script src="<?= base_url('assets/js/printjs/print.min.js') ?>"></script>
<script src="<?= base_url('assets/js/html2canvas/html2canvas.js') ?>"></script>

<script src="<?= base_url('assets/js/chinesepdf/jspdf.js') ?>"></script>
<script src="<?= base_url('assets/js/chinesepdf/plugins/FileSaver.js') ?>"></script>
<script src="<?= base_url('assets/js/chinesepdf/plugins/from_html.js') ?>"></script>
<script src="<?= base_url('assets/js/chinesepdf/plugins/addimage.js') ?>"></script>
<script src="<?= base_url('assets/js/chinesepdf/plugins/split_text_to_size.js') ?>"></script>

<script src="<?= base_url('assets/js/chinesepdf/plugins/png_support.js') ?>"></script>
<script src="<?= base_url('assets/js/pdf/libs/png_support/zlib.js') ?>"></script>
<script src="<?= base_url('assets/js/pdf/libs/png_support/png.js') ?>"></script>

<script src="<?= base_url('assets/js/chinesepdf/plugins/standard_fonts_metrics.js') ?>"></script>
<script src="<?= base_url('assets/js/chinesepdf/customfonts.js') ?>"></script>
<!--<script src="<?= base_url('assets/js/chinesepdf/vfs_fonts.js') ?>"></script>-->
<script src="<?= base_url('assets/js/chinesepdf/plugins/autoprint.js"') ?>"></script>

<script>
    $(function () {
        _resize();
    })
    // document.addEventListener("fullscreenchange", _resize);
    // document.addEventListener("webkitfullscreenchange", _resize);
    // document.addEventListener("mozfullscreenchange", _resize);
    // document.addEventListener("MSFullscreenChange", _resize);
    // document.addEventListener("orientationchange", _resize);
    // window.addEventListener('resize', _resize);
    // document.addEventListener('resize', _resize);
    //
    function _resize() {
    //     var bgW = 1920;
    //     var bgH = 1080;
    //     var w = window.innerWidth;
    //     var h = window.innerHeight;
    //     // if (w > bgW) w = bgW;
    //     var scaleX = w / bgW;
    //     var scaleY = h / bgH;
    //     window._scaleX = scaleX;
    //     window._scaleY = scaleY;
    //     // scale = 1;
    //     var transformStr = 'scale(' + scaleX.toFixed(3) + ',' + scaleY.toFixed(3) + ')';
    //     $('body > div').css({
    //         position: 'absolute',
    //         'transform': transformStr,
    //         '-webkit-transform': transformStr,
    //         '-moz-transform': transformStr,
    //         '-ms-transform': transformStr,
    //         '-o-transform': transformStr,
    //         overflow: 'hidden'
    //     });
        $('body').show('fast');
        // return scaleX;
    }

    $('body > div').find('script').remove();
</script>
<!--</div>-->
</body>
</html>