/**
 * Created by Administrator on 6/12/2017.
 */

$(window).ready(function () {

    /***************************************Main Login Part***********************************************************/
    var content_List = JSON.parse(sharedList);
    var totalPageCount = 0;
    var curPageNum = 0;

    function Share_make_Item(orderNum, item_title, item_id) {
        var intervalOfItem = 7.9;
        var itemHeight = 13.9;

        var item_top = (orderNum + 1) * intervalOfItem + orderNum * itemHeight;
        var item_top_str = item_top + '%';

        var output_html = '';

        output_html += '<a href="' + baseURL + 'middle/community/view/' + item_id + '" class="share_item_title" style = "top:' + item_top_str + '">';
        output_html += item_title;
        output_html += '</a>';

        output_html += '<a href="#" content_id = "' + item_id + '" onclick="shareItemDelete(this)"';
        output_html += 'onmouseover="del_hover_btn(this)" onmouseout="del_out_btn(this)" class="share_item_delete_btn" style = "top:' + item_top_str + '">';
        output_html += '</a>';

        return output_html;
    }

    function Share_Init_Pager(content_list) {
        var output_html = '';
        for (var i = 0; i < content_list.length; i++) {
            var tempObj = content_list[i];
            var item_title = tempObj['content_title'];
            var item_id = tempObj['content_id'];
            var modeVar = i % 4;
            var pageNum = (i - modeVar) / 4;
            var pageStr = 'share_page_' + pageNum;
            if (modeVar == 0) {
                if (pageNum != 0) output_html += '</div>';
                output_html += '<div class = "' + pageStr + '" style="display:none">';
                output_html += Share_make_Item(modeVar, item_title, item_id);
            } else {
                output_html += Share_make_Item(modeVar, item_title, item_id);
            }
            totalPageCount = pageNum;
        }
        output_html += '</div>';
        $('#shared_list_area').html(output_html);
    }

    function Share_Show_Page(pageNo) {

        var left_block_class = '.share_page_' + pageNo;
        $(left_block_class).show('50');
    }

    Share_Init_Pager(content_List);
    Share_Show_Page('0');

    function Share_Hide_OldPage(pageNo) {
        var left_block_class = '.share_page_' + pageNo;
        $(left_block_class).hide('50');
    }

    function Prev_Shared_Content() {

        if (curPageNum == 0) return;
        Share_Hide_OldPage(curPageNum);
        curPageNum--;
        Share_Show_Page(curPageNum);

    }

    function Next_Shared_Content() {
        if (curPageNum == totalPageCount) return;
        Share_Hide_OldPage(curPageNum);
        curPageNum++;
        Share_Show_Page(curPageNum);
    }

    $('#shared_content_delete_btn').click(function () {

        var content_id = $(this).attr('content_id');
        $.ajax({
            type: 'post',
            url: baseURL + 'middle/users/delete_shared_content',
            dataType: "json",
            data: {user_id: student_id, content_id: content_id},
            success: function (res) {
                if (res.status == 'success') {
                    Share_Init_Pager(res.data);
                    Share_Show_Page(curPageNum);
                    $('#my_shared_content_del_modal').modal('toggle');
                } else {
                    alert('Can not Delete Shared Content!');
                }
            }
        });
    });
    var commented_list = JSON.parse(commentedList);
    var totalCommentPageCount = 0;
    var curCommentPageNo = 0;

    function comment_make_Item(orderNum, item_title, item_id) {

        var intervalOfItem = 7.9;
        var itemHeight = 13.9;

        var item_top = (orderNum + 1) * intervalOfItem + orderNum * itemHeight;
        var item_top_str = item_top + '%';

        var output_html = '';

        output_html += '<a href="' + baseURL + 'middle/community/view/' + item_id + '" class="comment_item_title" style = "top:' + item_top_str + '">';
        output_html += item_title;
        output_html += '</a>';

        output_html += '<a href="#" content_id = "' + item_id + '" onclick="commentItemDelete(this)"';
        output_html += 'onmouseover="del_hover_btn(this)" onmouseout="del_out_btn(this)" class="comment_item_delete_btn" style = "top:' + item_top_str + '">';
        output_html += '</a>';

        return output_html;
    }

    function Comment_Init_Pager(content_list) {
        var output_html = '';
        for (var i = 0; i < content_list.length; i++) {
            var tempObj = content_list[i];
            var item_title = tempObj['content_title'];
            var item_id = tempObj['content_id'];
            var modeVar = i % 4;
            var pageNum = (i - modeVar) / 4;
            var pageStr = 'comment_page_' + pageNum;
            if (modeVar == 0) {
                if (pageNum != 0) output_html += '</div>';
                output_html += '<div class = "' + pageStr + '" style="display:none">';
                output_html += comment_make_Item(modeVar, item_title, item_id);
            } else {
                output_html += comment_make_Item(modeVar, item_title, item_id);
            }
            totalCommentPageCount = pageNum;
        }
        output_html += '</div>';
        $('#commented_content_list_area').html(output_html);
    }

    function Comment_Show_Page(pageNo) {

        var left_block_class = '.comment_page_' + pageNo;
        $(left_block_class).show('50');
    }

    Comment_Init_Pager(commented_list);
    Comment_Show_Page('0');
    console.log(commented_list);

    function comment_Hide_OldPage(pageNo) {
        var left_block_class = '.comment_page_' + pageNo;
        $(left_block_class).hide('50');
    }

    function comment_Prev_Content() {

        if (curCommentPageNo == 0) return;
        comment_Hide_OldPage(curCommentPageNo);
        curCommentPageNo--;
        Comment_Show_Page(curCommentPageNo);
    }

    function comment_Next_Content() {
        if (curCommentPageNo == totalCommentPageCount) return;
        comment_Hide_OldPage(curCommentPageNo);
        curCommentPageNo++;
        Comment_Show_Page(curCommentPageNo);
    }

    $('#commented_content_delete_btn').click(function () {
        var content_id = $('#commented_content_delete_btn').attr('content_id');
        $.ajax({
            type: 'post',
            url: baseURL + 'middle/users/delete_commented_content',
            dataType: "json",
            data: {user_id: student_id, content_id: content_id},
            success: function (res) {
                if (res.status == 'success') {
                    Comment_Init_Pager(res.data);
                    Comment_Show_Page(curCommentPageNo);
                    $('#my_commented_content_del_modal').modal('toggle');
                } else {
                    alert('Can not Delete Shared Content!');
                }
            }
        });
    });
    /***********************************Button Manage*************************************/
    passEditBtn.click(function () {

    });

    /***************Pagination Button Event Manage********************/
    /*********share list event manage*************/
    /*********comment list event manage*************/
    sharePrevBtn.click(function () {
        Prev_Shared_Content();
    });
    shareNextBtn.click(function () {
        Next_Shared_Content();
    });
    //deleteShareBtn.click(function(){
    //    var content_id = $(this).attr('content_id');
    //
    //});
    commentPrevBtn.click(function () {
        comment_Prev_Content();
    });
    commentNextBtn.click(function () {
        comment_Next_Content();

    });


    /***********************************Button Manage*************************************/
});