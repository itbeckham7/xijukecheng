/**
 * Created by Administrator on 7/4/2017.
 */
var allCourses = [
    {
        bcw_id: 1,
        bcw_name: '第一讲',
        bcw_file: 'uploads/2nd_course/sjsyf01001.mp4',
        bcw_photo: 'uploads/2nd_course/sjsyf01001.png',
        bcw_type: '1', // 1- video
        bcw_publish: '1', // 1- enabled, 0-disabled
        bcw_permission: '1' // 1- enabled, 0-disabled
    }
]
var _tmr = 0;
var volumeVal = 100;
$(window).load(function () {

    $('input[type="range"]').on('input', function () {
		var type = $(this).attr('data-type');
		var val = ($(this).val() - $(this).attr('min')) / ($(this).attr('max') - $(this).attr('min')) *100;
		$(this).css('background-size', val.toFixed(3) + '% 100%');
		switch(type){
			case 'volume':
			volumeVal = ($(this).val() - $(this).attr('min')) / ($(this).attr('max') - $(this).attr('min'));
			setVolumeBar();
			break;
		case 'seek':
			$('.video_iframe')[0].contentWindow.setSeekbar($(this).val());
			break;
		}
    });
	$($('.video_item')[0]).trigger('click');
});

function setVolumeBar() {
    if (volumeVal === 0) {
        $('.video_iframe')[0].contentWindow.setVolumeMute(true);
    } else {
        $('.video_iframe')[0].contentWindow.setVolumeMute(false);
        $('.video_iframe')[0].contentWindow.changeVolume(volumeVal);
    }

    if ($('.video_iframe')[0].contentWindow.getVolumeMuted()) {
        $('.video_volume_btn').addClass('mute');
    } else $('.video_volume_btn').removeClass('mute');
}

function setMute() {
    var flag = $('.video_iframe')[0].contentWindow.getVolumeMuted();
    $('.video_iframe')[0].contentWindow.setVolumeMute(!flag);
    if ($('.video_iframe')[0].contentWindow.getVolumeMuted()) {
        $('.video_volume_btn').addClass('mute');
    } else $('.video_volume_btn').removeClass('mute');
}

var currentPlayID = '';

function showVideo(id) {
    currentPlayID = id;
    $('.video_item').css('opacity','0.6');
    for (var i = 0; i < allCourses.length; i++) {
        var item = allCourses[i];
        if (item.bcw_id === currentPlayID) {
			$('.video_iframe').off('load');
			$('.video_iframe').on('load',function(){
//				return;
				clearInterval(_tmr);
				_tmr = setInterval(function(){
					var seekInfo = $('.video_iframe')[0].contentWindow.getSeekbarInfo();
					console.log(seekInfo);
					var _duration = seekInfo._duration;
					var _currentTime = seekInfo._currentTime;
					$('.video_seek_bar input').attr('max',_duration);
					$('.video_seek_bar input').val(_currentTime);					
					var val = _currentTime / _duration *100;
					$('.video_seek_bar input').css('background-size', val.toFixed(3) + '% 100%');

				},1000);			
			})
            $('.video_iframe').attr("src", baseURL + "assets/video_player/vplayer.html?ncw_file=" + baseURL + allCourses[i].bcw_file);
            $($('.video_item')[i]).css('opacity','1.0');
            break;
        }
    }
}

function nextVideo() {
    $('.video_item').css('opacity','0.6');

    for (var i = 0; i < allCourses.length; i++) {
        var item = allCourses[i];
        if (item.bcw_id === currentPlayID) {
            var list_index = (i + 1) % allCourses.length;
            currentPlayID = allCourses[list_index].bcw_id;
			showVideo(currentPlayID);
            $('.video_list_container').animate({
                scrollTop: list_index * $('.video_item')[0].clientHeight
            })
            break;
        }
    }

}


function scrollUP() {
    var scroll = $('.video_list_container').scrollTop();
    $('.video_list_container').animate({
        scrollTop: scroll - $('.video_item')[0].clientHeight*1
    })
}

function scrollDown() {
    var scroll = $('.video_list_container').scrollTop();
    $('.video_list_container').animate({
        scrollTop: scroll + $('.video_item')[0].clientHeight*1
    })
}

function playOrPause() {
    $('.video_iframe')[0].contentWindow.play_pause();
    if ($('.video_iframe')[0].contentWindow.video_isplaying) {
        $('.video_pause_btn').removeClass('play');
    } else {
        $('.video_pause_btn').addClass('play');
    }
}

