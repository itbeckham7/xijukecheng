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
$('#sh_kebenju_btn').mouseover(function(){
   $(this).css({width:'31.02%',height:'71.44%',top:'19.28%',left:'10.7%'});
});
$('#sh_kebenju_btn').mouseout(function(){
    $(this).css({width:'29.2%',height:'69.44%',top:'20.78%',left:'11.7%'});
});
$('#sh_sandapian_btn').mouseover(function(){
    $(this).css({width:'31.2%',height:'71.51%',top:'19.87%',left:'56.88%'});
});
$('#sh_sandapian_btn').mouseout(function(){
    $(this).css({width:'29.2%',height:'69.51%',top:'20.87%',left:'57.88%'});
});