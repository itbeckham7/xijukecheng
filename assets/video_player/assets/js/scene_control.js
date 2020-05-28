var vplayer;

var videoWrapper = $('.sf-video-wrapper');

var video_isplaying = true;
var _currentTime = 0;
var _duration = 0;

$(document).ready(function () {

    var options = {};
    var sceneH = window.innerHeight;
    var sceneW = window.innerWidth;

	var ratio = 1;

	var scale_x = Math.min(sceneW / 1280, sceneW / 1280) * ratio;
	var scale_y = Math.min(sceneH / 720, sceneH / 720) * ratio;

    if (!isMobile) {

    }
    $('body').css({
        'width': sceneW,
        'height': sceneH,
        left: 0
    });
    $('video').css({
        'width': sceneW,
        'width': sceneH
    });
        
    //
    // setTimeout(function () {
    //     $('.start-video-page').hide();
    // }, 3000);
    //
    $('.start-video-page').hide();
    //$('.loading-img-wrapper').show();
    vplayer = videojs('video-player', {
        controls: false,
        preload: 'auto',
		nativeControlsForTouch: false,
        width: sceneW,
        height: sceneH,
        loop: false,
        autoplay: true
    }, function () {
			
		$('.vjs-control').css({height: '3em'});
		$('.vjs-control-bar').css({height: '3em', bottom: 0});
        //$('.video-js .vjs-play-control').css({'font-size':22,'width':'2em'})
        //$('.video-js .vjs-volume-menu-button').css({'font-size':22})

		if(start_play_status!=''){
	        video_isplaying=true;
		}else{
			video_isplaying=false;
		}
        play_pause();
		vplayer.on('playing', function () {
            $('.loading-img-wrapper').hide();
            // video_isplaying=true;
        });
		
		vplayer.on("ended", function(){
			video_isplaying = false;
		});
		vplayer.on("timeupdate", function(){
			_currentTime = $('video')[0].currentTime;
			_duration = $('video')[0].duration;
		})
    });
    // resizeWindow();
	$('.loading-img-wrapper').on('click',function(){
		video_isplaying=false;
		play_pause();
	});
	if(status !='stop'){
    video_isplaying=false;
		play_pause();
	}
});

function switchVideo(st) {

    if (st) {//True then show video and hide content page area
        videoWrapper.show();
        verticalWrapper.hide();
        if (initStatus === 0) {
            $('.prev-page-btn-1').css('display', 'none');
        } else {
            $('.prev-page-btn-1').css('display', 'block');
        }

    } else {//False then video hide and show content page
        videoWrapper.hide();
        verticalWrapper.show();
        $('.prev-page-btn-1').css('display', 'none');
    }
}

function showVideo(vfile, onComplete) {
    switchVideo(true);
    Inheritance("play");
    vplayer.src({type: 'video/mp4', src: ''});
	vplayer.on('canplaythrough', function(){
		_duration = vplayer.duration;
		vplayer.play();		
		vplayer.off('canplaythrough', arguments.callee);
	})	
    vplayer.src({type: 'video/mp4', src: vfile});
	var callback = function () {
		vplayer.pause();		
		video_isplaying = false;
		vplayer.off("ended", arguments.callee);
		vplayer.off("timeupdate", arguments.callee);
		if (onComplete) {
			onComplete();
		}
	};
	vplayer.on("ended", callback);
	vplayer.on("timeupdate", function(){
        _currentTime = vplayer.currentTime;
		_duration = vplayer.duration;
		if(_currentTime > _duration - 0.3) callback();		
	})
    resizeWindow();
}

function play_pause() {
    if (video_isplaying) {
        video_isplaying = false;
        vplayer.pause();
    } else {
        video_isplaying = true;
        vplayer.play();
    }
}

function changeVolume(a) {
    vplayer.volume(a);
}

function setVolumeMute(flag) {
    vplayer.muted(flag);
}

function getVolumeMuted() {
    return vplayer.muted();
}

$(window).resize(function () {
    resizeWindow();

})

function setSeekbar(curTime){
	curTime = parseFloat(curTime);
	$('video')[0].currentTime = curTime;
	_currentTime = curTime;
	
}

function getSeekbarInfo(){
	return {
		_currentTime: _currentTime,
		_duration: _duration
	}
}

function resizeWindow(rate) {
    var sceneH = window.innerHeight;
    var sceneW = window.innerWidth;

    if (rate == undefined) rate = sceneH / sceneW;

    var width = sceneW;
    var height = sceneW * rate;
    var top = (sceneH - height) / 2;
    var left = 0;
    if (sceneH < sceneW * rate) {
        width = sceneH / rate;
        height = sceneH;
        top = 0;
        left = (sceneW - width) / 2;
    }
    $('body').css({
        width: width,
        height: height,
        top: top,
        left: left,
        background: 'transparent'
    });
    $('video').css({
        width: width,
        height: height,
        top: top,
        left: left
    });
    $('.sf-video-wrapper .video-js .custom-video-contain').css({
        width: width,
        height: height,
        top: 0,
        left: 0
    })
    $('.sf-video-wrapper .video-js').css({
        width: width,
        height: height,
        top: 0,
        left: 0
    })
    var w = width;
    var h = height;

    var scale_x = Math.min(w / 1280, w / 1280);
    var scale_y = Math.min(h / 720, h / 720);
    var vsx = 1;
    var vsy = 1;
    if(w > h * 1280/720) vsx = (scale_x) / scale_y;
    else vsy = (scale_y) / scale_x;
    var scaleStr = 'scale('+vsx.toFixed(4)+','+vsy.toFixed(4)+')';
    vplayer.width(w);
    vplayer.height(h);
    $('video').css({
        "object-fit": "contain",
        "-webkit-transform": scaleStr,
        "-moz-transform": scaleStr,
        "-ms-transform": scaleStr,
        "-o-transform": scaleStr,
        "transform": scaleStr
    })

}