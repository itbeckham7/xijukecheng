//
//   Project Name : Video
//   Author Company : Ewebcraft
//   Project Date: 5 May, 2016
//   Author Website : http://www.ewebcraft.com
//   Author Email : ewebcraft@gmail.com
//
var isMobile = false;
var isZhong = '0';
var GLOBAL = {
    'packageName': ""
};

GLOBAL.osStatus = getMobileOperatingSystem();

if (GLOBAL.osStatus === 'Android' || GLOBAL.osStatus === 'iOS') isMobile = true;

function GetURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}

$(window).resize(function () {
    resize();
});
$(function () {
    setTimeout(function () {
        resize();
    },10);
});

function resize() {
    var w = window.innerWidth;
    var h = window.innerHeight;
    if(GLOBAL.osStatus === 'iOS') {
        w = screen.height;
        h = screen.width * .885;
    }

    var scale_x = Math.min(w / 1920, w / 1920);
    var scale_y = Math.min(h / 840, h / 840);

    $('body').css({
        width: 1920,
        height: 840,
        transform: 'scale(' + scale_x + ',' + scale_y + ')'
    })

    var token = GetURLParameter('token');
    if (token != '091') {
        $('body').html('');
    }
	$('html').css({
		'position':'fixed',
		'overflow':'hidden',
		'background':'black'
	});
	$('body').css({
		'position':'fixed',
		'overflow':'hidden',
		'user-select':'none'
	});
	$('body').find('div').css({
		'user-select':'none'
	})
	
	

    // isZhong = GetURLParameter('isZhong');
    // if(isZhong == '1'){
    //     setTimeout(function () {
    //         changeToTranslate();
    //     },100);
    // }
};
