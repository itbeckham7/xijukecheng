/**
 * Created by ITbeckham7 on 6/4/2017.
 */
var itemSelectState = false;

/*
 Bulk Select and Delete functions
 */
function selectAllItem() {
    var userSelChkBox = $('.user-select-chk');
    if (!itemSelectState) {
        userSelChkBox.prop('checked', true);
        userSelChkBox.attr('checkSt', 'checked');
        itemSelectState = true;
    } else {

        itemSelectState = false;
        userSelChkBox.prop('checked', false);
        userSelChkBox.attr('checkSt', 'unchecked');
    }
}

function selectEachItem(self) {
    var checkSt = self.getAttribute('checkSt');
    if (checkSt === 'checked') {
        self.setAttribute('checkSt', 'unchecked');
    } else {

        self.setAttribute('checkSt', 'checked');
    }
}

function deleteSelectedItem() {
    var selectedRows = [];
    var userSelChkBox = $('.user-select-chk');
    userSelChkBox.each(function () {
        var st = ($(this).attr('checkSt'));
        if (st === 'checked') {
            selectedRows.push(($(this).attr('user_id')));
        }
    });
    if (selectedRows.length > 0)///bulk delete operation
    {
        deleteItems(selectedRows)
    }
}

function deleteItems(deleteUserIds)///ajax function
{
    $.ajax({
        type: "post",
        url: baseURL + "admin/users/delete",
        dataType: "json",
        data: {userIds: deleteUserIds},
        success: function (res) {
            if (res.status == 'success') {
                var table = document.getElementById("userInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = res.data;
            }
            else//failed
            {
                alert("Cannot delete CourseWare Item.");
            }
        }
    });
}

function initAddModal() {
    $('#add_fullname').val('');
    $('#add_username').val('');
    $('#add_userpassword').val('');
    $('#add_userrepeatpassword').val('');

    $(".buycourse_chk").prop('checked', false);
    $('.buycourse_chk_kebenju').prop('checked',false);
    $('.buycourse_chk_sandapian').prop('checked',false);
    $('.buycourse_chk_grammar').prop('checked',false);
}

function add_user_click() {
    initAddModal();
    $('#add_user_modal').modal({backdrop: 'static', keyboard: false})
}

function getBuyCourses() {
    var purCss = {'kebenju': 0, 'sandapian': 0, 'grammar': 0};
    $('.buycourse_chk:checked').each(function () {
        var csSlug = $(this).attr('data-slug');
        purCss[csSlug] = 1;
    });
    return JSON.stringify(purCss);
}

$('#add_user_submit_form').submit(function (e) {

    var purCsList = getBuyCourses();
    var purKbCss = [];
    var kebenjuCwList = $('.buycourse_chk_kebenju');
    kebenjuCwList.each(function (index) {
        if ($(kebenjuCwList[index]).prop('checked')) {
            purKbCss.push($(kebenjuCwList[index]).data('id'));
        }
    });

    var purSDCss = [];
    var sandapianCwList = $('.buycourse_chk_sandapian');
    sandapianCwList.each(function (index) {
        if ($(sandapianCwList[index]).prop('checked')) {
            purSDCss.push($(sandapianCwList[index]).data('id'));
        }
    });

    var purGRCss = [];
    var grammarCwList = $('.buycourse_chk_grammar');
    grammarCwList.each(function (index) {
        if ($(grammarCwList[index]).prop('checked')) {
            purGRCss.push($(grammarCwList[index]).data('id'));
        }
    });

    e.preventDefault();
    var formdata = new FormData(this);
    formdata.append('buycourse_arr', purCsList);
    formdata.append('buycourse_kb', JSON.stringify(purKbCss));
    formdata.append('buycourse_sd', JSON.stringify(purSDCss));
    formdata.append('buycourse_gr', JSON.stringify(purGRCss));

    jQuery.ajax({
        url: baseURL + "admin/users/add",
        type: "post",
        data: formdata,
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        success: function (res) {
            var ret = JSON.parse(res);
            if (ret.status == 'success') {
                var table = document.getElementById("userInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = ret.data;
                executionPageNation();
            }
            else//failed
            {
                alert(ret.data);

                alert("Cannot add user data.");
            }
        }
    });
    $('#add_user_modal').modal('toggle');
});

$('#edit_user_submit_form').submit(function (e) {

    e.preventDefault();

    var purCss = {'kebenju': 0, 'sandapian': 0};
    $('.edit_buycourse_chk:checked').each(function () {
        var csSlug = $(this).attr('data-slug');
        purCss[csSlug] = 1;
    });
    var purlistObjStr = JSON.stringify(purCss);

    var purKbCss = [];
    var kebenjuCwList = $('.edit_buycourse_chk_kebenju');
    kebenjuCwList.each(function (index) {
        if ($(kebenjuCwList[index]).prop('checked')) {
            purKbCss.push($(kebenjuCwList[index]).data('id'));
        }
    });

    var purSDCss = [];
    var sandapianCwList = $('.edit_buycourse_chk_sandapian');
    sandapianCwList.each(function (index) {
        if ($(sandapianCwList[index]).prop('checked')) {
            purSDCss.push($(sandapianCwList[index]).data('id'));
        }
    });
	
    var purGRCss = [];
    var grammarCwList = $('.edit_buycourse_chk_grammar');
    grammarCwList.each(function (index) {
        if ($(grammarCwList[index]).prop('checked')) {
            purGRCss.push($(grammarCwList[index]).data('id'));
        }
    });
    ////////////var purlistObjStr = JSON.stringify(purCss);
    var user_id = $('#user_info_id').val();
    var fdata = new FormData(this);
    fdata.append('user_id', user_id);
    fdata.append('buycourse_kb', JSON.stringify(purKbCss));
    fdata.append('buycourse_sd', JSON.stringify(purSDCss));
    fdata.append('buycourse_gr', JSON.stringify(purGRCss));
    fdata.append('buycourse_arr', purlistObjStr);
    var password_status = '0';
    if (showeNewPassBox) {
        password_status = '1';
    }
    fdata.append('password_status', password_status);
    jQuery.ajax({
        url: baseURL + "admin/users/edit",
        type: "post",
        data: fdata,
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        success: function (res) {
            var ret = JSON.parse(res);
            if (ret.status == 'success') {
                var table = document.getElementById("userInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = ret.data;
                executionPageNation();
            }
            else//failed
            {
                alert("Cannot modify user Data.");
            }
        }
    });
    jQuery('#edit_user_modal').modal('toggle');
});
$('#delete_user_btn').click(function () {
    var user_id = $("#delete_user_btn").attr("user_id");
    $.ajax({
        type: "post",
        url: baseURL + "admin/users/delete_single",
        dataType: "json",
        data: {user_id: user_id},
        success: function (res) {
            if (res.status == 'success') {
                var table = document.getElementById("userInfo_tbl");
                var tbody = table.getElementsByTagName("tbody")[0];
                tbody.innerHTML = res.data;
                executionPageNation();
            }
            else//failed
            {
                alert("Cannot delete CourseWare Item.");
            }
        }
    });
    $('#user_delete_modal').modal('toggle');
});



