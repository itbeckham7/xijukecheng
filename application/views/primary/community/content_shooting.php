<?php
$logged_In_user_id = $this->session->userdata("loginuserID");
$user_type = $this->session->userdata("user_type");
$imageAbsDir =  base_url().'assets/images/frontend/';
$myworkURL = 'primary/work/student';
$returnURL = 'primary/work/shooting/'.$user_id;
$hd_menu_img_path = '';
if($user_type!='1'){
    $myworkURL = 'primary/work/script/'.$logged_In_user_id;
    $hd_menu_img_path = $imageAbsDir.'studentwork/';
}else{
    $hd_menu_img_path = $imageAbsDir.'studentwork/stu_';
}
?>

<link rel="stylesheet" href="<?= base_url('assets/css/frontend/community_view_dubbing.css')?>">
<!-----------------------------Vplayer------------------------->
<link rel="stylesheet" href="<?= base_url('assets/css/video/style_video.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/css/video/vplayer.css') ?>" />
<script  src="<?= base_url('assets/js/video/vplayer.js')?>"></script>

<!-----------------------------Vplayer------------------------->
<input type="hidden" id="base_url" value="<?= base_url()?>">

<div class="bg">
    <img src="<?= base_url('assets/images/frontend/community/shooting/bg.jpg')?>" class="background_image">
</div>

<div class="hdmenu">
    <div style="position: relative; height: 100%">
        <img class = "hdmenu_img" src="<?= $hd_menu_img_path.'hdmenu_normal.png';?>" usemap="#hdmenu_map">
        <a id = "hdmenu_studentwork" href="<?= base_url($myworkURL);?>" style="top: 27.2%; left: 1.1%; width: 31.9%; height: 48.5%;"></a>
        <a id = "hdmenu_profile" href="<?= base_url('primary/').'users/profile/'.$logged_In_user_id;?>" style="top: 3.9%; left: 37.1%; width: 26.1%; height: 90.4%;"></a>
        <a id = "hdmenu_community" href="<?= base_url('primary/').'community/index';?>" style="top: 27.2%; left: 67%; width: 31.9%; height: 48.5%;"></a>
    </div>
</div>

<?php if($this->session->userdata("loggedin") == FALSE): ?>
    <a class="register-btn" href="<?= base_url('signin/index')?>"></a>
<?php else: ?>
    <a class="exit-btn" href="<?= base_url('signin/signout')?>"></a>
<?php endif; ?>

<div class="back-btn">
    <a href="#" onclick="history.back()">
        <img id ="back-btn-img" src="<?= base_url('assets/images/frontend/studentwork/back.png')?>">
    </a>
</div>

<div class="avatar-frame">
    <div style="position: relative; height: 100%">
        <img src="<?= base_url().'assets/images/frontend/contents-profile.jpg'?>" class="avatar-img" style="z-index: -1">
        <img src="<?= base_url('assets/images/frontend/community/script/avatar_frame.png')?>">
        <label class="user-name"><?= $user_nickname;?></label>
        <label class="school-name"><?= $user_school;?></label>
    </div>
</div>

<div class="shooting-frame">
    <img src="<?= base_url().'assets/images/frontend/community/shooting/video_frame.png'?>">
</div>

<div class="shooting-content">
    <video controls id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" style="background:#343434;object-fit: fill;" autoplay>
        <source src="<?php echo base_url($videoPath)?>" type="video/mp4">
    </video>
    <script>
        var vplayer = videojs('videoPlayer',{controls:true,width:1280,height:712,nativeControlsForTouch:false,preload:'auto',loop:false},function(){
            vplayer.on('play', function(){
            });
            vplayer.on("pause",function(){
                console.log('stop');
            });
            vplayer.on("ended",function(){
                console.log('stop');
            });
        });
    </script>
</div>

<div class="comment-write">
    <div style="position: relative; height: 100%">
        <img src="<?= base_url('assets/images/frontend/community/script/comment_write_bg.png')?>">
        <textarea class="form-control" rows="3" id="comment"></textarea>
    </div>
</div>

<a class="like-btn"></a>

<div class="like-count" style="background: url(<?= base_url('assets/images/frontend/community/script/like_countbg.png')?>);background-size:100% 100%">
    <label id="vote_number_lbl"><?php if(strlen($vote_num)<2) echo '0'.$vote_num;else echo $vote_num; ?></label>
</div>

<a class="comment-btn"></a>

<div class="comment-list">
    <div class="" id="totalCommentArea" style="text-align: left;">
        <?php foreach ($commentSets as $comemntItem):?>
            <div class="comment_item_area">
                <p style="font-weight: bold"><?= $comemntItem->fullname.'&nbsp&nbsp&nbsp&nbsp&nbsp'.$comemntItem->create_time;?></p>
                <p style="color:#6cc"><?= $comemntItem->comment_desc;?></p>
            </div>
        <?php endforeach;?>
    </div>
</div>
<script>
    var hdmenuImgPath = '<?= $hd_menu_img_path;?>';
    window.addEventListener('load', function(){
        var logedIn_UserId = '<?php echo $logged_In_user_id;?>';
        var contentId = '<?php echo $content_id;?>';
        var base_url = $('#base_url').val();
        var voteStatus = '0';
        console.log(base_url);

        $('.like-btn img').mouseenter(function(){
            $(this).attr('src', base_url + '/assets/images/frontend/community/script/like_btn_hover.png');
        });
        $('.like-btn img').mouseout(function(){
            $(this).attr('src', base_url + '/assets/images/frontend/community/script/like_btn.png');
        });
        $('.comment-btn img').mouseenter(function(){
            $(this).attr('src', base_url + '/assets/images/frontend/community/script/comment_btn_hover.png');
        });
        $('.comment-btn img').mouseout(function(){
            $(this).attr('src', base_url + '/assets/images/frontend/community/script/comment_btn.png');
        });
        var vote_lbl = $('#vote_number_lbl');
        $('.like-btn').click(function () {
            if(voteStatus=='0') voteStatus='1';
            else voteStatus='0';
            $.ajax({
                type:'post',
                url:base_url+'primary/community/update_voteNum',
                dataType:'json',
                data:{content_id:contentId,vote_status:voteStatus},
                success:function(res){
                    if(res.status=='success'){
                        var realvoteStr = (res.data.length<2)? ('0'+res.data):res.data;
                        vote_lbl.text(realvoteStr);
                    }else{
                        alert('Can not give vote numbers');
                    }
                }
            });
        });

        $('.comment-btn').click(function () {

            var comment_desc = $('#comment').val();
            $.ajax({
                type:"post",
                url:base_url+'primary/community/add_comment',
                dataType:"json",
                data:{content_id:contentId,comment_user_id:logedIn_UserId,comment_desc:comment_desc},
                success:function(res){
                    if(res.status=='success'){
                        $('#totalCommentArea').html(res.data);
                        $('#comment').val('');
                    }else{

                        alert('Can not add comment');

                    }
                }

            });
        });

    });
    $('.back-btn').mouseover(function(){
        $('#back-btn-img').attr('src',base_url+"assets/images/frontend/studentwork/back_hover.png");
    });
    $('.back-btn').mouseout(function(){
        $('#back-btn-img').attr('src',base_url+"assets/images/frontend/studentwork/back.png");
    });
    $('.exit-btn').mouseout(function(){
        $('.exit_btn_img').attr('src',base_url+'assets/images/frontend/studentwork/exit.png');
    });
    $('.exit_btn_img').mouseover(function(){
        $('.exit_btn_img').attr('src',base_url+'assets/images/frontend/studentwork/exit_hover.png');
    });

</script>
<script src="<?= base_url('assets/js/custom/primary/menu_manage.js') ?>" type="text/javascript"></script>

