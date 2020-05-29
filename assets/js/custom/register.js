/**
 * Created by Administrator on 7/4/2017.
 */

$(window).load(function () {

    if (setUserInfo() != '') {
        getUserInfo(setUserInfo());
        return;
    }
    $('#username').focus();

});

$('.form-register').on('submit', function (e) {
    e.preventDefault();
    var username = $('#username').val();
    var password = $('#password').val();
    var cpassword = $('#cpassword').val();
    var err = -1;
    var ctrls = ['#username', '#password', '#cpassword'];
    if (password != cpassword) err = 2;
    if (cpassword == '' || cpassword.length < 3 || cpassword.length > 18) err = 2;
    if (password == '' || password.length < 3 || password.length > 18) err = 1;
    if (username == '' || username.length < 3 || username.length > 18) err = 0;
    if (err != -1) {
        $(ctrls[err]).attr('item_type', '1');
        $('.info-modal').fadeIn('fast');
        $('.info-modal div').html('输入的信息不正确');
        setTimeout(function () {
            $(ctrls[err]).removeAttr('item_type');
            $('.info-modal').fadeOut('fast');
        }, 2000);
        return;
    }
    var submit_form = document.getElementById('custom_login_form');
    var fdata = new FormData(submit_form);
    $.ajax({
        url: baseURL + "signin/register",
        type: "POST",
        data: fdata,
        contentType: false,
        cache: false,
        processData: false,
        async: true,
        xhr: function () {
            //upload Progress
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function (event) {
                    var percent = 0;
                    var position = event.loaded || event.position;
                    var total = event.total;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);
                    }
                    $("#progress_percent").text(percent + '%');

                }, true);
            }
            return xhr;
        },
        mimeType: "multipart/form-data"
    }).done(function (res) { //
        var ret;
        try {
            ret = JSON.parse(res);
        } catch (e) {
            $('.info-modal').fadeIn('fast');
            $('.info-modal div').html('接口错误 : ' + e);
            setTimeout(function () {
                $('.info-modal').fadeOut('fast');
            }, 2000);
            return;
        }
        console.log(ret);
        if (ret.status == 'success') {
            location.replace(baseURL + ret.data);
        } else {//failed
            $('.info-modal').fadeIn('fast');
            $('.info-modal div').html('操作失败 : ' + ret.data);
            setTimeout(function () {
                $('.info-modal').fadeOut('fast');
            }, 2000);
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            // jQuery('#ncw_edit_modal').modal('toggle');
            // alert(ret.data);
        }
    });

})

$('a').each(function (idx, elem) {
    var that = $(elem);
    that.attr('data-target', that.attr('href'));
    that.attr('href', 'javascript:;');
    that.off('click');
    that.on('click', function () {
        location.replace(that.attr('data-target'));
    });
});