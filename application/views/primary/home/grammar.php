
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/frontend/grammar_course.css') ?>">
<div class="bg" style="">
    <img src="<?= base_url('assets/images/frontend/grammar_course/home/frame.png')?>" class="background_image" >
</div>
<?php /*var_dump($bcwSets);*/?>
<a class="logout_btn" href="<?= base_url('signin/signout');?>"></a>
<a class="back_btn" href="<?= base_url('home/index');?>"></a>
<div class="left_menu_container">
    <div class="scroll_up_btn" onclick="scrollUP()"></div>
    <div class="video_list_container">
        <?php
            foreach($bcwSets as $item){
                //echo '<div class="video_item" style="background: url('.base_url().$item->bcw_photo.');" onclick="showVideo(\''.base_url().$item->bcw_file.'\')"></div>';
                echo '<div class="video_item" style="opacity:0.6;background: url('.base_url().$item->bcw_photo.');" onclick="showVideo(\''.$item->bcw_id.'\')"></div>';
            }
        ?>
    </div>
    <div class="scroll_down_btn" onclick="scrollDown()"></div>
</div>
<div class="right_container">
    <iframe class="video_iframe"></iframe>
    <div class="video_controller">
        <div class="video_pause_btn" onclick="playOrPause()"></div>
        <div class="video_next_btn" onclick="nextVideo()"></div>
        <div class="video_volume_btn" onclick="setMute()"></div>
        <div class="video_seek_bar">
            <input type="range" step="1" data-type="seek" min="0" max="100" value="0"/>
        </div>
        <div class="video_volume_bar">
            <input type="range" step="1" data-type="volume" min="0" max="100" value="100"/>
        </div>		
    </div>
</div>
<script src="<?= base_url('assets/js/custom/primary/grammar_course.js') ?>"></script>
<script>
    allCourses = JSON.parse('<?= json_encode($bcwSets);?>');
</script>
<style>   .teacher-reference-btn { display: none;} </style>
