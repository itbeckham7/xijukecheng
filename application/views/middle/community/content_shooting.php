<?php
$logged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir = base_url() . 'assets/images/middle/';
$myworkURL = 'middle/work';
$returnURL = 'middle/work/shooting/' . $user_id;
$hd_menu_img_path = '';
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
<input type="hidden" id="base_url" value="<?= base_url() ?>">

<div class="bg" style="background-color: #f4f4f4;">
    <img src="<?= base_url('assets/images/middle/community/dubbing/bg.png'); ?>" class="background_image">
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
        <img src="<?= base_url() . 'assets/images/middle/contents-profile.jpg' ?>" class="avatar-img"
             style="z-index: -1">
        <img src="<?= base_url('assets/images/middle/community/script/avatar_frame.png') ?>">
        <label class="user-name"><?= $user_nickname; ?></label>
        <label class="school-name"><?= $user_school; ?></label>
    </div>
</div>

<div class="shooting-frame"></div>

<div class="shooting-content">
    <video controls id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered"
           style="background:#343434;object-fit: fill;" autoplay>
        <source src="<?php echo base_url($videoPath) ?>" type="video/mp4">
    </video>
    <script>
        var vplayer = videojs('videoPlayer', {
            controls: true,
            width: 1280,
            height: 712,
            nativeControlsForTouch: false,
            preload: 'auto',
            loop: false
        }, function () {
            vplayer.on('play', function () {
            });
            vplayer.on("pause", function () {
                console.log('stop');
            });
            vplayer.on("ended", function () {
                console.log('stop');
            });
        });
    </script>
</div>

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
        var base_url = $('#base_url').val();
        var voteStatus = '0';
        console.log(base_url);

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

    });

</script>
<script src="<?= base_url('assets/js/custom/middle/menu_manage.js') ?>" type="text/javascript"></script>

