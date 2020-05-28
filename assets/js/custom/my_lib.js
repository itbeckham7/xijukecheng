function makeId() {
    var idLength = 5;
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < idLength; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    // Windows Phone must come first because its UA also contains "Android"
    if (/windows phone/i.test(userAgent)) {
        return "Windows Phone";
    }
    if (/android/i.test(userAgent)) {
        return "Android";
    }
    // iOS detection from: http://stackoverflow.com/a/9039885/177710
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "iOS";
    }
    if (/JavaFX/.test(userAgent)) {
        return 'JavaFx';
    }
    return "unknown";
}

var osStatus = getMobileOperatingSystem();

function is_weixin() {
    var ua = navigator.userAgent.toLowerCase();
    if (ua.match(/MicroMessenger/i) == "micromessenger") {
        return true;
    } else {
        return false;
    }
}

var loginTmr = 0;

function weixin_login() {
    var user_token = generateRandomString(15);
    if (setUserInfo() != '') user_token = setUserInfo();
    setUserInfo(user_token);
    window.ReactNativeWebView.postMessage(JSON.stringify({
        cmd: 'weixin_login',
        data: {
            userToken: user_token
        }
    }))
    clearInterval(loginTmr);
    loginTmr = setInterval(getUserInfo, 1000);
}

function pay_weixin(element) {
    var price = $(element).attr('price');
    var openId = $(element).attr('open_id');
    setUserId(loginUserId);
    console.log('current price is '+ price);
    var ordercode = price;
    var out_trade_no = '1507842611' + Date.now() + (10000 + Math.floor(Math.random() * 90000));
    //var openId = '';

    console.log(openId);
	console.log(out_trade_no);

    window.ReactNativeWebView.postMessage(JSON.stringify({
        cmd: 'waiting_indicator',
        data: { visible: true }
    }))

    $.ajax({
        type: 'post',
        url: base_url + 'api/pay',
        dataType: 'json',
        data: {
            id: openId,//要去换取openid的登录凭证
            fee: ordercode,
            user_id: loginUserId,
            out_trade_no: out_trade_no,
            courseware_id: setCourseId()
        },
        success: function (res) {
            console.log(res);
            window.ReactNativeWebView.postMessage(JSON.stringify({
                cmd: 'weixin_payment',
                data: {
                    partnerid: res.partnerid,
                    timestamp: res.timestamp,
                    noncestr: res.noncestr,
                    prepayid: res.prepayid,
                    type: 'MD5',
                    sign: res.sign,
                }
            }))
            loginTmr = setInterval(checkPaidCourse,1000);
        }
    });
}

function checkPaidCourse(course_id) {
    console.log('user->' + setUserId() + ',course->' + setCourseId());
    jQuery.ajax({
        url: baseURL + "/api/checkPaidCourse",
        type: "post",
        data: {
            user_id: setUserId(),
            course_id: setCourseId()
        },
        // processData:false,
        // // contentType:false,
        // cache:false,
        // async:false,
        success: function (res) {
            console.log(res);
            res = JSON.parse(res);
            if (res.status == 'success') {
                clearInterval(loginTmr);
                location.href = baseURL + "coursewares/index";
            } else {
                // console.log(res.data);
            }
        }
    });
}

function setUserInfo(token) {
    var key = 'token';
    var user_token = localStorage.getItem(key);
    if (user_token == undefined) localStorage.setItem(key, '');
    user_token = localStorage.getItem(key);
    if (token == undefined) return user_token;
    localStorage.setItem(key, token);
    return token;
}

function setUserId(param) {
    var key = 'user_id';
    var param_val = localStorage.getItem(key);
    if (param_val == undefined) localStorage.setItem(key, '');
    param_val = localStorage.getItem(key);
    if (param == undefined) return param_val;
    localStorage.setItem(key, param);
    return param;
}

function setCourseId(param) {
    var key = 'course_id';
    var param_val = localStorage.getItem(key);
    if (param_val == undefined) localStorage.setItem(key, '');
    param_val = localStorage.getItem(key);
    if (param == undefined) return param_val;
    localStorage.setItem(key, param);
    return param;
}

function setSubwareNavId(param) {
    var key = 'courseware_nav_id';
    var param_val = sessionStorage.getItem(key);
    if (param_val == undefined) sessionStorage.setItem(key, '');
    param_val = sessionStorage.getItem(key);
    if (param == undefined) return param_val;
    sessionStorage.setItem(key, param);
    return param;
}

function setMediaType(param) {
    var key = 'subware_media_type';
    var param_val = sessionStorage.getItem(key);
    if (param_val == undefined) sessionStorage.setItem(key, '');
    param_val = sessionStorage.getItem(key);
    if (param == undefined) return param_val;
    sessionStorage.setItem(key, param);
    return param;
}

function getUserInfo(token) {
    jQuery.ajax({
        url: baseURL + "/signin/signin_weixin",
        type: "post",
        data: {
            user_token: setUserInfo()
        },
        // processData:false,
        // // contentType:false,
        // cache:false,
        // async:false,
        success: function (res) {
            console.log(res);
            res = JSON.parse(res);
            if (res.status == 'success') {
                clearInterval(loginTmr);
                location.replace(baseURL);
            } else {
//                console.log(res.data, setUserInfo());
            }
        }
    });

}

function generateRandomString(len) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < len; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function getFilenameFromURL(str) {
    if (str == '') return '';
    str = str.split('/');
    if (str[str.length - 1] == '') return str[str.length - 2].toLowerCase();
    return str[str.length - 1].toLowerCase();
}

function getFiletypeFromURL(str) {
    if (str == '') return '';
    str = str.split('.');
    return str[str.length - 1].toLowerCase();
}

function removeExtFromFilename(str) {
    if (str == '') return '';
    str = str.split('.');
    if (str.length == 1) return str[0].toLowerCase();
    return str[str.length - 2].toLowerCase();
}


function executeCMD(command, data) {
    if (osStatus === 'Android' || osStatus === 'iOS') {
        switch (command) {
            case 'show_reference_pdf':
                window.ReactNativeWebView.postMessage(JSON.stringify({
                    cmd: 'show_reference_pdf',
                    data: {
                        pdfURL: data
                    }
                }));
                break;
            case '':
                break;
        }
        return true;
    }
    return false;
}