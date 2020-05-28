/**
 * Created by Administrator on 7/7/2017.
 */

$(window).ready(function () {

    var contentList = JSON.parse(contentSets);
    var cur_pageNo = 0;
    var totalPageCount = 0;

    var imageDir = baseURL + "assets/images/middle/community/";
    var orderByTimeBtn = $('.orderByCreateTime_Btn');
    var orderByReviewsBtn = $('.orderByMaxReviews_Btn');

    var latestListDiv = $('.latestlist');
    var latestListImg = $('.latestlist_img');
    var latestListBtn0 = $('#latestlist_btn0');
    var latestListBtn1 = $('#latestlist_btn1');
    var latestListBtn2 = $('#latestlist_btn2');

    var maxreviewListDiv = $('.maxreviewslist');
    var maxreviewImg = $('.maxreviewslist_img');
    var maxreviewListBtn0 = $('#maxreviewslist_btn0');
    var maxreviewListBtn1 = $('#maxreviewslist_btn1');
    var maxreviewListBtn2 = $('#maxreviewslist_btn2');

    var filterScriptBtn = $('.filterByScript_Btn');
    var filterDubbingBtn = $('.filterByDubbing_Btn');
    var filterHeadBtn = $('.filterByHead_Btn');
    var filterShootingBtn = $('.filterByShooting_Btn');


    orderByTimeBtn.click(function () {
        orderByTimeBtn.hide();
        latestListDiv.show();
    });
    latestListBtn0.click(function () {
        orderByTimeBtn.show();
        latestListDiv.hide();
    });
    /*********************/
    latestListBtn1.click(function () {
        latestListDiv.hide();
        orderByTimeBtn.show();
        cur_workstatus = '1';
        if (initStatus == 'NOCLICKEDTYPE') {///search by lasted creation date
            orderByWorkStatus('1');
        } else {
            filterByWorkType(initStatus);

        }
    });
    latestListBtn2.click(function () {
        latestListDiv.hide();
        orderByTimeBtn.hide();//////hide this button and show button with max reviewed image
        orderByReviewsBtn.show();
        cur_workstatus = '2';
        if (initStatus == 'NOCLICKEDTYPE') {///search by max revies
            orderByWorkStatus('2');
        } else {
            filterByWorkType(initStatus);
        }
    });
    /****************************review button********************************/
    orderByReviewsBtn.click(function () {
        orderByReviewsBtn.hide();
        maxreviewListDiv.show();
    });
    maxreviewListBtn0.click(function () {
        orderByReviewsBtn.show();
        maxreviewListDiv.hide();
    });
    /*********************/
    maxreviewListBtn1.click(function () {
        maxreviewListDiv.hide();
        orderByTimeBtn.show();
        orderByReviewsBtn.hide();
        cur_workstatus = '1';
        if (initStatus == 'NOCLICKEDTYPE') {///search by lasted creation date
            orderByWorkStatus('1');

        } else {
            filterByWorkType(initStatus);
        }
    });
    maxreviewListBtn2.click(function () {
        maxreviewListDiv.hide();
        orderByTimeBtn.hide();
        orderByReviewsBtn.show();
        cur_workstatus = '2';
        if (initStatus == 'NOCLICKEDTYPE') {///search by max revies
            orderByWorkStatus('2');
        } else {
            filterByWorkType(initStatus);
        }

    });
    /***************************Filter Buttons Manage**************************************************/
    filterScriptBtn.click(function () {
        initStatus = '1';
        filterByWorkType(initStatus);

    });
    filterDubbingBtn.click(function () {
        initStatus = '2';
        filterByWorkType(initStatus);

    });
    filterHeadBtn.click(function () {
        initStatus = '5';
        filterByWorkType(initStatus);

    });
    filterShootingBtn.click(function () {
        initStatus = '6';
        filterByWorkType(initStatus);

    });

    function make_item(orderNo, contentInfo) {
        var output_html = '';
        var interVal = 3.2;
        var itemHight = 9.2;
        var topVal = orderNo * itemHight + (orderNo + 1) * interVal;
        var topValStr = topVal + "%";
        output_html += '<div class="comm_item_wrapper" style = "top:' + topValStr + '">';
        output_html += '<a class="comm_title" href="' + contentInfo['content_url'] + '">' + contentInfo['title'] + '</a>';
        output_html += '<a class="comm_author" href="' + contentInfo['profile_url'] + '">' + contentInfo['author'] + '</a>';
        output_html += '<a class="comm_school">' + contentInfo['school'] + '</a>';
        output_html += '<a class="comm_viewNum">' + contentInfo['view_num'] + '</a>';
        output_html += '<a class="comm_shareTime">' + contentInfo['share_time'] + '</a>';
        output_html += '</div>';
        return output_html;
    }

    function comm_init_pager(contentlist) {
        var output_html = '';
        for (var i = 0; i < contentlist.length; i++) {
            var tempObj = contentlist[i];
            var modeVar = i % 8;
            var pageNo = (i - modeVar) / 8;
            totalPageCount = pageNo;
            if (modeVar == 0) {
                if (pageNo != 0) output_html += '</div>';
                output_html += '<div class = "comm_page_' + pageNo + '" style="display: none">';
                output_html += make_item(modeVar, tempObj);
            } else {
                output_html += make_item(modeVar, tempObj);
            }

        }
        output_html += '</div>';
        $('#community_list_area').html(output_html);
    }

    function comm_show_page(pageNo) {
        var classStr = '.comm_page_' + pageNo;
        $(classStr).show('fast');
    }

    function comm_hide_page(pageNo) {
        var classStr = '.comm_page_' + pageNo;
        $(classStr).hide('fast');
    }

    function comm_next_page() {
        if (cur_pageNo > totalPageCount - 1) return;
        else {
            comm_hide_page(cur_pageNo);
            cur_pageNo++;
            comm_show_page(cur_pageNo);

        }
    }

    function comm_prev_page() {
        console.log('current Page No:' + cur_pageNo);
        if (cur_pageNo < 1) return;
        else {
            comm_hide_page(cur_pageNo);
            cur_pageNo--;
            comm_show_page(cur_pageNo);
        }
    }

    comm_init_pager(contentList);
    comm_show_page(0);

    function filterByWorkType(contentType) {
        cur_pageNo = 0;
        $.ajax({
            type: "post",
            url: baseURL + "middle/community/orderByContentType",
            dataType: "json",
            data: {orderBySelect: cur_workstatus, content_type_id: contentType},
            success: function (res) {
                if (res.status == 'success') {
                    comm_init_pager(res.data);
                    comm_show_page(0);
                } else//failed
                {
                    alert("can not filter by content type");
                }
            }
        });
    }

    function orderByWorkStatus(orderBySelect_Id) {
        cur_pageNo = 0;
        $.ajax({
            type: "post",
            url: baseURL + "middle/community/orderBySelect",
            dataType: "json",
            data: {orderBySelect: orderBySelect_Id},
            success: function (res) {
                if (res.status == 'success') {
                    comm_init_pager(res.data);
                    comm_show_page(0);
                } else//failed
                {
                    alert("can not order by work status");
                }
            }
        });
    }

    var prev_btn = $('.previous_Btn');
    var next_btn = $('.next_Btn');

    prev_btn.click(function () {
        comm_prev_page();
    });
    next_btn.click(function () {
        comm_next_page();
    });

});
