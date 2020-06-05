<?php
$logged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir = base_url() . 'assets/images/middle/';
$myworkURL = 'middle/work';
$returnURL = 'middle/community/index';
$course_menu_img_path = '';
if ($user_type != '1') {
    $myworkURL = 'middle/work';
    $hd_menu_img_path = $imageAbsDir . 'studentwork/';
} else {
    $hd_menu_img_path = $imageAbsDir . 'studentwork/stu_';
}
?>
<link rel="stylesheet" href="<?= base_url('assets/css/middle/community_view.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/middle/community_view_dubbing.css') ?>">

<!-----------------------------Vplayer------------------------->
<link rel="stylesheet" href="<?= base_url('assets/css/video/style_video.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/video/vplayer.css') ?>"/>
<script src="<?= base_url('assets/js/video/vplayer.js') ?>"></script>

<!-----------------------------Vplayer------------------------->
<style>

</style>
<input type="hidden" id="base_url" value="<?= base_url() ?>">

<div class="bg" style="background-color: #f4f4f4;">
    <img src="<?=
    ($content_type_id == 4 || !$bgPath) ?
        base_url('assets/images/middle/community/dubbing/bg-image.png') :
        base_url('assets/images/middle/community/dubbing/bg.png');
    ?>" class="background_image">
</div>

<!--  page main menu part -->
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

<div class="avatar-frame" style="display: none;">
    <div style="position: relative; height: 100%">
        <img src="<?= $imageAbsDir . 'contents-profile.jpg' ?>" class="avatar-img" style="z-index: -1">
        <img src="<?= $imageAbsDir . 'community/script/avatar_frame.png' ?>">
        <label class="user-name"><?= $user_nickname; ?></label>
        <label class="school-name"><?= $user_school; ?></label>
    </div>
</div>

<div class="player" style="display: <?php if ($content_type_id == '4' || !$bgPath) echo "block"; else echo 'none'; ?>">
    <audio id="music" preload="true">
        <source src="">
    </audio>
    <a id="pButton" class="play"></a>
    <div id="timeline"></div>
    <div id="playhead"></div>
</div>

<?php if ($content_type_id == '4' || !$bgPath) { ?>
    <div class="dubbing-content">
        <div style="height: 100%; width:100%;">
        <?php if ($bgPath) { ?>
            <img src="<?= base_url($bgPath); ?>">
        <?php } else { ?>
            <div class="question-bg"></div>
            <?php } ?>
        </div>
        <script>
            var music = document.getElementById('music'); // id for audio element
            var wavInfo = '<?= $wavPath; ?>';
            if (wavInfo.substr(0, 1) == '[') wavInfo = JSON.parse(wavInfo);
            else music.src = baseURL + wavInfo;
            var qInfo = JSON.parse('<?= $info; ?>')['dubbing'];
            for (var i = 0; i < qInfo.length; i++) {
                var item = qInfo[i];
                if (item.question) {
                    $('.question-bg').html('Question<br><br>' + item.question);
                    music.src = baseURL + wavInfo[i];
                    break;
                }
            }
        </script>
    </div>
    <?php } else { ?>
        <div class="shooting-frame"></div>
        <div class="shooting-content">
            <video controls id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered"
                   style="background:#343434;object-fit: fill;" autoplay>
                <source src="<?php echo base_url($bgPath) ?>" type="video/mp4">
            </video>
            <script>
                var music = document.getElementById('music');

                var timeInfo = JSON.parse('<?= $info; ?>')['dubbing'];
                var wavInfo = '<?= $wavPath; ?>';
                if (wavInfo.substr(0, 1) == '[') wavInfo = JSON.parse(wavInfo);
                else music.src = baseURL + wavInfo;
                var isWavPlaying = false;

                var vplayer = videojs('videoPlayer', {
                    controls: true,
                    width: 1280,
                    nativeControlsForTouch: false,
                    height: 712,
                    preload: 'auto',
                    loop: false,
                    autoplay: false
                }, function () {
                    vplayer.on('play', function () {
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
                        music.pause();
                        isWavPlaying = false;
                    });
                    vplayer.on("ended", function () {
                        music.pause();
                        isWavPlaying = false;
                    });
                    vplayer.on("timeupdate", function (e) {
                        var wavIdx = -1;
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
                            vplayer.volume(1);
                        }
                    });
                });
            </script>
        </div>
    <?php } ?>

    <div class="comment-write">
        <div>
            <textarea class="form-control" rows="3" id="comment" placeholder="说点什么吧"></textarea>
        </div>
    </div>

    <a class="like-btn"></a>

    <div class="like-count">
        <label id="vote_number_lbl"><?php if (strlen($vote_num) < 2) echo '0' . $vote_num; else echo $vote_num; ?></label>
    </div>

    <a class="comment-btn">评论一下</a>

    <div class="comment-list">
        <div class="" id="totalCommentArea" style="text-align: left;">
            <?php foreach ($commentSets as $comemntItem): ?>
                <div class="comment_item_area">
                    <p style="font-weight: bold"><?= $comemntItem->fullname . '<span>' . $comemntItem->create_time . '</span>'; ?></p>
                    <p style="color:#6cc"><?= $comemntItem->comment_desc; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
        window.addEventListener('load', function () {
            var logedIn_UserId = '<?php echo $logged_In_user_id;?>';
            var contentId = '<?php echo $content_id;?>';
            var voteStatus = '0';
            var base_url = $('#base_url').val();

            var vote_lbl = $('#vote_number_lbl');
            $('.like-btn').click(function () {
                if (voteStatus == '0') voteStatus = '1';
                else voteStatus = '0';
                $.ajax({
                    type: 'post',
                    url: base_url + 'middle/community/update_voteNum',
                    dataType: 'json',
                    data: {content_id: contentId, vote_status: voteStatus},
                    success: function (res) {
                        if (res.status == 'success') {
                            var realvoteStr = (res.data.length < 2) ? ('0' + res.data) : res.data;
                            vote_lbl.text(realvoteStr);
                        } else {
                            alert('Can not give vote numbers');
                        }
                    }
                });
            });

            $('.comment-btn').click(function () {

                var comment_desc = $('#comment').val();
                $.ajax({
                    type: "post",
                    url: base_url + 'middle/community/add_comment',
                    dataType: "json",
                    data: {content_id: contentId, comment_user_id: logedIn_UserId, comment_desc: comment_desc},
                    success: function (res) {
                        if (res.status == 'success') {
                            $('#totalCommentArea').html(res.data);
                            $('#comment').val('');
                        } else {
                            alert('Can not add comment');
                        }
                    }

                });
            });

        })
    </script>

    <script>
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
            return (event.clientX - getPosition(timeline)) / timelineWidth;
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
            var newMargLeft = event.clientX - getPosition(timeline);

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
    </script>
    <script src="<?= base_url('assets/js/custom/middle/menu_manage.js') ?>" type="text/javascript"></script>
