/**
 * Created by Administrator on 6/12/2017.
 */
$(window).ready(function () {

    var imageDir = baseURL + "assets/images/frontend";
    var course_menu_img = $('#course_menu_img');
    current_className = $('.custom_classlist_btn:first').attr('data-class_name');
    current_classbgname = $('.custom_classlist_btn:first').attr('data-image_name');
    $('#'+current_classbgname).attr('data-sel',1);
    clickClass();
    //$('.teacher_assign_class button:first-child').css('background','#ff0');
    $(".custom_classlist_btn").click(function () {
        $('.class_name_btn_wrapper').removeAttr('data-sel');
        current_className = $(this).attr('data-class_name');
        current_classbgname = $(this).attr('data-image_name');
        $(this).parent().attr('data-sel',1);
        clickClass();
    });
    $('#script_ATag_Btn').click(function () {
        curPageNo = 0;
        content_type_id = '1';
        course_menu_img.attr('src',imageDir+'/studentwork/scriptwork.png');
        clickClass();
        $('.course_type_menu a').removeAttr('data-sel');
        $(this).attr('data-sel',1);
    });
    $('#dubbing_ATag_Btn').click(function () {
        curPageNo = 0;
        totalPageCount = 0;
        content_type_id = '2';
        course_menu_img.attr('src',imageDir+'/studentwork/dubbingwork.png');
        clickClass();
        $('.course_type_menu a').removeAttr('data-sel');
        $(this).attr('data-sel',1);
    });
    $('#head_ATag_Btn').click(function () {
        curPageNo = 0;
        totalPageCount = 0;
        content_type_id = '3';
        course_menu_img.attr('src',imageDir+'/studentwork/headwork.png');
        clickClass();
        $('.course_type_menu a').removeAttr('data-sel');
        $(this).attr('data-sel',1);
    });
    $('#shooting_ATag_Btn').click(function () {
        curPageNo = 0;
        totalPageCount = 0;
        content_type_id = '4';
        course_menu_img.attr('src',imageDir+'/studentwork/shootingwork.png');
        clickClass();
        $('.course_type_menu a').removeAttr('data-sel');
        $(this).attr('data-sel',1);
    });

    $('.previous_Btn').click(function () {
        prevPage();
    });
    $('.next_Btn').click(function () {
        nextPage();
    });
    function hide_OldPage(pageNo){
        var newClassStr = '.member_list_page'+pageNo;
        $(newClassStr).hide();
    }
    function show_NewPage(pageNo) {
        var newClassStr = '.member_list_page'+pageNo;
        $(newClassStr).show();
    }
    function prevPage(){
        if(curPageNo == 0) return;
        hide_OldPage(curPageNo);
        curPageNo--;
        show_NewPage(curPageNo);
    }
    function nextPage(){
        if(curPageNo == totalPageCount) return;
        hide_OldPage(curPageNo);
        curPageNo++;
        show_NewPage(curPageNo);
    }
    function clickClass()
    {
        $.ajax({
            type: "post",
            url: baseURL + "middle/work/getMembers",
            dataType: "json",
            data: {class_name:current_className,content_type_id:content_type_id},
            success: function (res) {
                if (res.status == 'success') {
                    totalPageCount = parseInt(res.totalPageCount);
                    jQuery('.class_member_tbl_area').html(res.data);
                    show_NewPage(curPageNo);

                }
                else//failed
                {
                    alert("Cannot delete CourseWare Item.");
                }
            }
        });
    }
    /******************Pager for student list***************************/
});
