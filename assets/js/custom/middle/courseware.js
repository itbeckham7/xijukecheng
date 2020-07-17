$(window).load(function () {

    if (window.addEventListener) {
        window.addEventListener('message', receiveMessage, false);
    } else {
        window.attachEvent('onmessage', receiveMessage);
    }
    switch (curr_sw) {
        case 'script_sw':
            $('#script').click();
            break;
        case 'dubbing_sw':
            $('#dubbing').click();
            break;
        case 'shooting_sw':
            $('#shooting').click();
            break;
        case 'flash_sw':
            $('.flash-tab a[data-type="' + setMediaType() + '"]').click();
            break;
    }
});

function updateSubwareAccessTime(swTypeId) {
    $.ajax({
        type: "post",
        url: base_url + 'middle/coursewares/update_SW_Access',
        dataType: 'json',
        data: {subware_type_id: swTypeId},
        success: function (res) {
            if (res.status == 'success') {

            } else {
            }
        }
    });
}

if (login_status == '0') {
    $('.subware-nav').each(function (idx, elem) {
        var that = $(elem);
        that.attr('data-disabled', '1');
    });
    $('#script').parent().removeAttr('data-disabled');
}

function receiveMessage(event) {
    var iframe = document.getElementById('courseware_iframe').contentWindow;
    var message = event.data; //this is the message
    message = JSON.parse(message);
    if (message.type == 'get-courseware-id') {
        var courseware_id = $('#script').data('courseware_id');
        var response = {
            type: 'courseware-id',
            value: courseware_id,
            login_status: login_status,
            login_username: login_username,
            base_URL: base_url
        };
        iframe.postMessage(JSON.stringify(response), '*');
    }
}

$('#script').on('click', function () {
    setBackStatus(true);
    if (curr_sw == 'flash_sw') {
        curr_sw = 'script_sw';
        setSubwareNavId(curr_sw);
        var courseware_id = $(this).attr('data-courseware_id');
        location.replace(baseURL + 'middle/coursewares/view/' + courseware_id);
        return;
    }
    curr_sw = 'script_sw';
    setSubwareNavId(curr_sw);
    var subware_path = $(this).attr('subware_path');
    var sw_publish = $('#script').attr('subware_publish');
    if (sw_publish != '1') return;
    if (subware_path != 'nosubware') {
        $('iframe').attr('src', baseURL + subware_path);
        $('iframe').attr('height', '800px');
    } else {
        $('.nosubware_msg').show();
        updateSubwareAccessTime('1');
    }

    $('.subware-nav').removeAttr('data-sel');
    $(this).parent().attr('data-sel', 1);

});

$('#flash_contents').on('click', function () {
    if (login_status == '0') return;
    setBackStatus(true);
    setSubwareNavId(curr_sw);
    if (userType == '1') setMediaType('teaching');
    else setMediaType('demovideo');
    var courseware_id = $(this).attr('data-courseware_id');
    location.replace(baseURL + 'middle/coursewares/flash/' + courseware_id);
    return;

    curr_sw = 'flash_sw';
    var subware_path = $(this).attr('subware_path');
    var sw_publish = $(this).attr('subware_publish');
    if (sw_publish != '1') return;
    if (subware_path != 'nosubware') {
        $('iframe').attr('src', baseURL + subware_path);
        $('iframe').attr('height', '800px');
    } else {
        $('.nosubware_msg').show();
        updateSubwareAccessTime('2');
    }

    $('.subware-nav').removeAttr('data-sel');
    $(this).parent().attr('data-sel', 1);

});

$('#dubbing').on('click', function () {
    if (login_status == '0') return;
    setBackStatus(true);
    if (curr_sw == 'flash_sw') {
        curr_sw = 'dubbing_sw';
        setSubwareNavId(curr_sw);
        var courseware_id = $(this).attr('data-courseware_id');
        location.replace(baseURL + 'middle/coursewares/view/' + courseware_id);
        return;
    }
    curr_sw = 'dubbing_sw';
    setSubwareNavId(curr_sw);
    var subware_path = $(this).attr('subware_path');
    var sw_publish = $(this).attr('subware_publish');
    if (sw_publish != '1') return;
    if (subware_path != 'nosubware') {
        $('iframe').attr('src', baseURL + subware_path);
        $('iframe').attr('height', '800px');
    } else {
        $('.nosubware_msg').show();
        updateSubwareAccessTime('3');
    }

    $('.subware-nav').removeAttr('data-sel');
    $(this).parent().attr('data-sel', 1);

});

$('#shooting').on('click', function () {
    if (login_status == '0') return;
    setBackStatus(true);
    if (curr_sw == 'flash_sw') {
        curr_sw = 'shooting_sw';
        setSubwareNavId(curr_sw);
        var courseware_id = $(this).attr('data-courseware_id');
        location.replace(baseURL + 'middle/coursewares/view/' + courseware_id);
        return;
    }
    curr_sw = 'shooting_sw';
    setSubwareNavId(curr_sw);
    var subware_path = $(this).attr('subware_path');
    var sw_publish = $(this).attr('subware_publish');
    if (sw_publish != '1') return;

    if (subware_path != 'nosubware') {
        $('iframe').attr('src', baseURL + subware_path);
        $('iframe').attr('height', '800px');
    } else {
        $('.nosubware_msg').show();
        updateSubwareAccessTime('4');
    }

    $('.subware-nav').removeAttr('data-sel');
    $(this).parent().attr('data-sel', 1);
});

// flash page part

$('.flash-tab a').on('click', function () {
    setBackStatus(true);
    var that = $(this);
    var type = that.attr('data-type');
    $('.flash-tab a').removeAttr('data-sel');
    that.attr('data-sel', 1);
    var swList = _mainList.filter(function (a) {
        return (a.subware_type_slug == type &&
            a.subware_file != 'nosubware');
    });
    $('.nosubware_msg').hide();
    if (swList.length == 0) {
        $('.flash-content > iframe').hide();
        $('.flash-content > div').hide();
        $('.nosubware_msg').show();
        return;
    }
    switch (type) {
        case 'teaching':
            if (!$('.flash-content > iframe').attr('src')) {
                $('.flash-content > iframe').attr('src',
                    baseURL + 'assets/js/pdf/viewer/viewer.html?t=' + (new Date().getTime()));
            }
            $('.flash-content > iframe').show();
            $('.flash-content > div').hide();
            break;
        case 'demovideo':
        case 'demoimage':
            makeSubwareList(swList);
            $('.flash-content > div').show();
            $('.flash-content > iframe').hide();
            break;
    }
});

function playContent(elem, level) {
    var that = $(elem);
    if (level) that = that.parent();
    var id = that.parent().attr('data-id');
    setMediaType(that.parent().parent().attr('data-type'));
    location.href = baseURL + 'middle/coursewares/player/' + id;
}

function downloadContent(elem) {
    var that = $(elem);
    var id = that.parent().parent().attr('data-id');
    var item = _mainList.filter(function (a) {
        return a.subware_id == id;
    });
    if (!item.length) return;
    item = item[0];
    var link = document.createElement('a');
    link.setAttribute('download', item.title + '.png');
    var uri = baseURL + item.subware_file;
    if (typeof link.download == 'string') {
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        setTimeout(function () {
            document.body.removeChild(link);
            window.URL.revokeObjectURL(link.href);
        }, 10);
    } else {
        window.open(uri, '_blank');
    }
}

function makeSubwareList(list) {
    var content_html = '';
    var len = list.length;
    for (var kk = 0; kk < 1; kk++) {
        for (var i = 0; i < len; i++) {
            var item = list[i];
            var fileType = getFiletypeFromURL(item.subware_file);
            content_html += '<div data-type="' + item.subware_type_slug + '">' +
                '<div class="sItem" data-id="' + item.subware_id + '">';
            switch (fileType) {
                case 'mp4':
                    var poster = 'assets/images/middle/coursewares/preview-video.png';
                    if (item.subware_poster) poster = item.subware_poster;
                    content_html += '<div class="sItem-preview ' +
                        item.subware_type_slug + '" ' +
                        'style="background-image: url(' + baseURL + poster +
                        ')" ' + ' onclick="playContent(this);"' +
                        '><div></div></div>';
                    content_html += '<div class="sItem-title">' + item.title + '</div>';
                    break;
                case 'jpg':
                case 'jpeg':
                case 'bmp':
                case 'png':
                case 'gif':
                    content_html += '<div class="sItem-preview ' +
                        item.subware_type_slug + '"' +
                        'style="background-image: url(' + baseURL +
                        item.subware_file +
                        ')" ' + ' onclick="playContent(this);"' +
                        '></div>';
                    content_html += '<div class="sItem-ctrl">' +
                        '<div data-type="preview" onclick="playContent(this, 1);">预览</div>' +
                        '<div data-type="download" onclick="downloadContent(this, 1);">下载</div>' +
                        '</div>';
                    break;
            }
            content_html += '</div>' +
                '</div>';
        }
    }
    $('.subware-container').html(content_html);
}