/**
 * Created by Administrator on 6/12/2017.
 */
var registerBtn = $('#sh_register_btn');
var exitBtn = $('#sh_exit_btn');
var imageDir = baseURL + "assets/images/sandapian/";
registerBtn.mouseover(function () {
    registerBtn.css({"background":"url("+imageDir+"base/login_hover.png) no-repeat",'background-size' :'100% 100%'});
});
registerBtn.mouseout(function () {
    registerBtn.css({"background":"url("+imageDir+"base/login.png) no-repeat","background-size" : "100% 100%"});
});
exitBtn.mouseover(function () {
    exitBtn.css({"background":"url("+imageDir+"base/exit_hover.png) no-repeat","background-size" : "100% 100%"});
});
exitBtn.mouseout(function () {
    exitBtn.css({"background":"url("+imageDir+"base/exit.png) no-repeat","background-size" : "100% 100%"});
});
// $('#sh_kebenju_btn').mouseover(function(){
//    $(this).css({width:'31.02%',height:'71.44%',top:'19.28%',left:'10.7%'});
// });
// $('#sh_kebenju_btn').mouseout(function(){
//     $(this).css({width:'29.2%',height:'69.44%',top:'20.78%',left:'11.7%'});
// });
// $('#sh_sandapian_btn').mouseover(function(){
//     $(this).css({width:'31.2%',height:'71.51%',top:'19.87%',left:'56.88%'});
// });
// $('#sh_sandapian_btn').mouseout(function(){
//     $(this).css({width:'29.2%',height:'69.51%',top:'20.87%',left:'57.88%'});
// });

function hover_back() {
    $('#back_btn_image').attr('src', baseURL + 'assets/images/frontend/studentwork/back_hover.png');
}

function out_back() {
    $('#back_btn_image').attr('src', baseURL + 'assets/images/frontend/studentwork/back.png');
}


$('a').each(function (idx, elem) {
    var that = $(elem);
    that.attr('data-target', that.attr('href'));
    that.attr('href', "javascript:;");
    if (that.attr('onclick')) return;
    that.off('click');
    that.on('click', function () {
        var type = that.attr('data-type');
        if(type == 'logout') setUserInfo('');
        location.replace(that.attr('data-target'));
    });
});

function showPlatform(elem) {
    var that = $(elem);
    // var urls = {primary: 'xiaoxueapp', middle : 'middle'};
    var urls = {primary: 'primary/coursewares', middle : 'middle'};
    if(executeCMD()) urls = { primary: 'xiaoxueapp', middle: 'middle'};
    var type = that.attr('data-type');
    window.open(baseURL + urls[type], '_self');
}