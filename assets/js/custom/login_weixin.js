/**
 * Created by Administrator on 7/4/2017.
 */

$(window).load(function () {
    if (setUserInfo() != '') {
        getUserInfo(setUserInfo());
        return;
    }
});

$('a').each(function (idx, elem) {
    var that = $(elem);
    that.attr('data-target', that.attr('href'));
    that.attr('href', "javascript:;");
    if (that.attr('onclick')) return;
    that.off('click');
    that.on('click', function () {
        location.replace(that.attr('data-target'));
    });
});