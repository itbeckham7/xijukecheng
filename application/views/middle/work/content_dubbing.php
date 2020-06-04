<?php
$logged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir = base_url() . 'assets/images/middle/';
$myworkURL = 'middle/work';
$returnURL = 'middle/work/dubbing/' . $user_id;
$course_menu_img_path = '';
if ($user_type != '1') {
    $myworkURL = 'middle/work';
    $hd_menu_img_path = $imageAbsDir . 'studentwork/';
} else {
    $hd_menu_img_path = $imageAbsDir . 'studentwork/stu_';
}
?>
<!--------------------Player-------------------->
<link rel="stylesheet" href="<?= base_url('assets/css/video/style_video.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/video/vplayer.css') ?>"/>
<!--------------------Player-------------------->
<!-----------------------------Vplayer------------------------->
<script src="<?= base_url('assets/js/video/vplayer.js') ?>"></script>
<!-----------------------------Vplayer------------------------->

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/menu_manage.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/middle/work_view.css') ?>">
<div class="bg" style="background-color: #f4f4f4;" ondragstart="false;">
    <?php if ($content_type_id == '4') { ?>
        <img src="<?= $imageAbsDir . 'mywork/bg-dubbing-image.png'; ?>" class="background_image">
    <?php } else { ?>
        <img src="<?= $imageAbsDir . 'mywork/bg-dubbing.png'; ?>" class="background_image">
    <?php } ?>
</div>
<!--<div class="page-main-menu">-->
<?php if ($this->session->userdata("loggedin") != FALSE) { ?>
    <a class="btn-main mywork" href="<?= base_url($myworkURL); ?>"
    ><span><?= ($user_type != '1') ? '我的' : '学生'; ?>作品</span></a>
    <a class="btn-main community" href="<?= base_url('middle/') . 'community/index'; ?>"
    ><span>戏剧社区</span></a>
    <a class="btn-main profile"
       href="<?= base_url('middle/') . 'users/profile/' . $logged_In_user_id; ?>"
    ><span>个人中心</span></a>
<?php } else if ($this->session->userdata("loggedin") == FALSE) { ?>
    <a class="btn-main register-btn" href="<?= base_url('signin/index') ?>"><span>登录</span></a>
<?php } ?>
<a href="javascript:;" onclick="history.back();" class="btn-main back-btn"></a>

<?php if ($user_id == $logged_In_user_id){ ?><!---------if visitor is user that wrote content..------------->
    <a href="#" id="shareContent_Btn" class="share_content_btn"
       style="background:url(<?= base_url('assets/images/middle/mywork/workshare.png') ?>) no-repeat;background-size: 100% 100%;">
    </a>
<?php } ?>


<div class="player" style="display: <?php if ($content_type_id != '4') echo "none"; else echo 'block'; ?>">
    <audio id="music" preload="true">
        <source src="">
    </audio>
    <a id="pButton" class="play"></a>
    <div id="timeline"></div>
    <div id="playhead"></div>
</div>

<div class="dubbing-content">
    <div style="height: 100%;width:100%">
        <?php if ($content_type_id == '4') { ?>
        <img src="<?= base_url($bgPath); ?>">
        <?php } else { ?>
            <video controls id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered"
                   style="background:#000;object-fit: fill;position: absolute;width: 100%;height:100%">
                <source src="<?= base_url($bgPath); ?>" type="video/mp4">
            </video>
            <script>
                var music = document.getElementById('music'); // id for audio element

                var timeInfo = JSON.parse('<?= $info; ?>')['dubbing'];
                var wavInfo = '<?= $wavPath; ?>';
                if (wavInfo.substr(0, 1) == '[') wavInfo = JSON.parse(wavInfo);
                else music.src = baseURL + wavInfo;
                var isWavPlaying = false;

                var vplayer = videojs('videoPlayer', {
                    controls: true,
                    width: 1280,
                    height: 712,
                    nativeControlsForTouch: false,
                    preload: 'auto',
                    loop: false,
                    autoplay: false
                }, function () {
                    vplayer.on('play', function () {
                        console.log('play');
                        var wavIdx = -1;
                        isWavPlaying = false;
                        vplayer.volume(1);
                        var vidTime = vplayer.currentTime();
                        for (var i = 0; i < timeInfo.length; i++) {
                            var item = timeInfo[i];
                            if (vidTime > item.start && vidTime < item.end) {
                                wavIdx = i;
                                break;
                            }
                        }
                        if (wavIdx > -1) {
                            music.src = baseURL + wavInfo[wavIdx];
                            music.currentTime = vidTime - timeInfo[wavIdx].start;
                            music.play();
                            vplayer.volume(0);
                            isWavPlaying = true;
                        }
                    });
                    vplayer.on("pause", function () {
                        console.log('stop');
                        music.pause();
                        isWavPlaying = false;
                    });
                    vplayer.on("ended", function () {
                        console.log('stop');
                        music.pause();
                        isWavPlaying = false;
                    });
                    vplayer.on("timeupdate", function (e) {
                        var wavIdx = -1;
                        vplayer.volume(1);
                        var vidTime = vplayer.currentTime();
                        for (var i = 0; i < timeInfo.length; i++) {
                            var item = timeInfo[i];
                            if (vidTime > item.start && vidTime < item.end) {
                                wavIdx = i;
                            }
                        }
                        if (!isWavPlaying && wavIdx > -1) {
                            music.src = baseURL + wavInfo[wavIdx];
                            music.currentTime = vidTime - timeInfo[wavIdx].start;
                            music.play();
                            vplayer.volume(0);
                            isWavPlaying = true;
                        } else if (wavIdx == -1) {
                            isWavPlaying = false;
                            music.pause();
                        }
                    });
                    // vplayer.volume(0);
                    // vplayer.play();
                });
            </script>
        <?php } ?>
    </div>
</div>


<!-----------Share content Modal------------>
<style type="text/css">
    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000;
        opacity: .0;
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
<div class="custom-modal" id="share_content_modal">
    <div class="share_modal_content">
        <a href="#" id="content_share_btn" content_id="<?php echo $content_id; ?>"></a>
        <a href="#" class="share_close_btn"></a>
    </div>
</div>

<script>
    var contentTitle = '<?php echo $content_title;?>';
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
    var music = document.getElementById('music'); // id for audio element
    var duration = music.duration; // Duration of audio clip, calculated here for embedding purposes
    var pButton = document.getElementById('pButton'); // play button
    var playhead = document.getElementById('playhead'); // playhead
    var timeline = document.getElementById('timeline'); // timeline

    // timeline width adjusted for playhead
    var timelineWidth = timeline.offsetWidth - playhead.offsetWidth;

    // play button event listenter
    pButton.addEventListener("click", play);

    // timeupdate event listener
    music.addEventListener("timeupdate", timeUpdate, false);

    // makes timeline clickable
    timeline.addEventListener("click", function (event) {
        moveplayhead(event);
        music.currentTime = duration * clickPercent(event);
    }, false);

    // returns click as decimal (.77) of the total timelineWidth
    function clickPercent(event) {
        return (event.clientX - getPosition(timeline)) / timelineWidth / window._scaleX;
    }

    // makes playhead draggable
    playhead.addEventListener('mousedown', mouseDown, false);
    window.addEventListener('mouseup', mouseUp, false);

    // Boolean value so that audio position is updated only when the playhead is released
    var onplayhead = false;

    // mouseDown EventListener
    function mouseDown() {
        onplayhead = true;
        window.addEventListener('mousemove', moveplayhead, true);
        music.removeEventListener('timeupdate', timeUpdate, false);
    }

    // mouseUp EventListener
    // getting input from all mouse clicks
    function mouseUp(event) {
        if (onplayhead == true) {
            moveplayhead(event);
            window.removeEventListener('mousemove', moveplayhead, true);
            // change current time
            music.currentTime = duration * clickPercent(event);
            music.addEventListener('timeupdate', timeUpdate, false);
        }
        onplayhead = false;
    }

    // mousemove EventListener
    // Moves playhead as user drags
    function moveplayhead(event) {
        var newMargLeft = (event.clientX - getPosition(timeline)) / window._scaleX;

        if (newMargLeft >= 0 && newMargLeft <= timelineWidth) {
            playhead.style.marginLeft = newMargLeft + "px";
        }
        if (newMargLeft < 0) {
            playhead.style.marginLeft = "0px";
        }
        if (newMargLeft > timelineWidth) {
            playhead.style.marginLeft = timelineWidth + "px";
        }
    }

    // timeUpdate
    // Synchronizes playhead position with current point in audio
    function timeUpdate() {
        timelineWidth = timeline.offsetWidth - playhead.offsetWidth;
        if (music.paused) {
            pButton.className = "";
            pButton.className = "play";
        } else {
            pButton.className = "";
            pButton.className = "pause";
        }
        var playPercent = timelineWidth * (music.currentTime / duration);
        playhead.style.marginLeft = playPercent + "px";
        if (music.currentTime == duration) {
            pButton.className = "";
            pButton.className = "play";
        }
    }

    //Play and Pause
    function play() {
        // start music
        if (music.paused) {
            music.play();
            // remove play, add pause
            pButton.className = "";
            pButton.className = "pause";
        } else { // pause music
            music.pause();
            // remove pause, add play
            pButton.className = "";
            pButton.className = "play";
        }
    }

    // Gets audio file duration
    music.addEventListener("canplaythrough", function () {
        duration = music.duration;
    }, false);

    // getPosition
    // Returns elements left position relative to top-left of viewport
    function getPosition(el) {
        return el.getBoundingClientRect().left;
    }

    function showCustomModal() {
        $('.modal-backdrop, .custom-modal').animate({'opacity': '.8'}, 300, 'linear');
        $('#share_content_modal').animate({'opacity': '1.00'}, 300, 'linear');
        $('.modal-backdrop, .custom-modal').css('display', 'block');
    }

    function close_modal() {
        $('.modal-backdrop, .custom-modal').animate({'opacity': '0'}, 300, 'linear', function () {
            $('.modal-backdrop, .custom-modal').css('display', 'none');
        });
    }
</script>
<script src="<?= base_url('assets/js/custom/middle/menu_manage.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/custom/middle/work_view.js') ?>" type="text/javascript"></script>

