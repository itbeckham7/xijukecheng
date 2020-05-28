<?php
$mediaType = explode('.', $subware->subware_file);
$mediaType = $mediaType[count($mediaType) - 1];
switch ($mediaType) {
    case 'mp4':
        $mediaType = 'video';
        break;
    case 'png':
    case 'jpg':
    case 'jpeg':
    case 'bmp':
    case 'gif':
        $mediaType = 'image';
        break;
}
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/courseware.css') ?>"/>
<!--------------------Player-------------------->
<link rel="stylesheet" href="<?= base_url('assets/css/video/style_video.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/video/vplayer.css') ?>"/>
<!--------------------Player-------------------->
<!-----------------------------Vplayer------------------------->
<script src="<?= base_url('assets/js/video/vplayer.js') ?>"></script>
<!-----------------------------Vplayer------------------------->

<input type="hidden" id="base_url" value="<?= base_url('middle/') ?>">

<!--<div class="page-main-menu">-->
<a href="javascript:;" onclick="goPreviousPage()"
   class="btn-main back-btn<?= $mediaType == 'image' ? '-img' : '' ?>"></a>
<!--</div>-->

<div class="media-content">
    <?php if ($mediaType == 'video') { ?>
        <video controls id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered"
               style="background:#000;object-fit: fill;position: absolute;width: 100%;height:100%" autoplay>
            <source src="<?php echo base_url($subware->subware_file); ?>" type="video/mp4">
        </video>
        <div class="_scripts">
            <script>
                $(function () {
                    var vplayer = videojs('videoPlayer', {
                        controls: true,
                        width: 1280,
                        height: 712,
                        nativeControlsForTouch: false,
                        preload: 'auto',
                        loop: false
                    }, function () {
                        vplayer.on('play', function () {
                            console.log('play');
                        });
                        vplayer.on("pause", function () {
                            console.log('stop');
                        });
                        vplayer.on("ended", function () {
                            console.log('stop');
                        });
                    });
                })
            </script>
        </div>
    <?php } else if ($mediaType == 'image') { ?>
        <img src="<?php echo base_url($subware->subware_file); ?>" style="width: 100%;">
    <?php } ?>
</div>

<div class="_scripts">
    <script>
        function goPreviousPage() {
            location.replace('<?= base_url('middle/coursewares/flash/' . $subware->courseware_id) ?>')
        }

        $('._scripts').remove();
    </script>
</div>

