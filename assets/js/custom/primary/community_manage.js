/**
 * Created by Administrator on 7/7/2017.
 */

$(window).ready(function(){

    var contentList = JSON.parse(contentSets);
    var cur_pageNo = 0;
    var totalPageCount  = 0;

    var imageDir = baseURL + "assets/images/frontend/community/";
    var orderByTimeBtn = $('.orderByCreateTime_Btn');
    var orderByReviewsBtn =$('.orderByMaxReviews_Btn');

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

    $('#hdmenu_studentwork').mouseout(function(){
        $('.hdmenu_img').attr('src',hdmenuImgPath+'hdmenu_comm_sel.png');
    });
    $('#hdmenu_studentwork').mouseover(function(){
        $('.hdmenu_img').attr('src',hdmenuImgPath+'hdmenu_work_sel.png');
    });
    $('#hdmenu_profile').mouseout(function(){
        $('.hdmenu_img').attr('src',hdmenuImgPath+'hdmenu_comm_sel.png');
    });
    $('#hdmenu_profile').mouseover(function(){
        $('.hdmenu_img').attr('src',hdmenuImgPath+'hdmenu_profile_sel.png');
    });

    $('.return_btn').mouseover(function(){
        $(this).css({"background":"url("+baseURL + "assets/images/frontend/studentwork/back_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.return_btn').mouseout(function(){
        $(this).css({"background":"url("+baseURL + "assets/images/frontend/studentwork/back.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.home_btn').mouseover(function(){
        $(this).css({"background":"url("+baseURL + "assets/images/frontend/home/home_btn_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.home_btn').mouseout(function(){
        $(this).css({"background":"url("+baseURL + "assets/images/frontend/home/home_btn.png) no-repeat",'background-size' :'100% 100%'});
    });

    $('.exit-btn').mouseout(function(){
        $('.exit_btn_img').attr('src',baseURL + "assets/images/frontend/studentwork/exit.png");
    });
    $('.exit_btn_img').mouseover(function(){
        $('.exit_btn_img').attr('src',baseURL + "assets/images/frontend/studentwork/exit_hover.png");
    });

    orderByTimeBtn.mouseover(function(){ $(this).css({"background":"url("+imageDir+"latestpub_hover.png) no-repeat",'background-size' :'100% 100%'}); });
    orderByTimeBtn.mouseout(function(){ $(this).css({"background":"url("+imageDir+"latestpub.png) no-repeat",'background-size' :'100% 100%'}); });
    orderByTimeBtn.click(function(){ orderByTimeBtn.hide(); latestListDiv.show(); });
    latestListBtn0.click(function(){ orderByTimeBtn.show();  latestListDiv.hide();});
    latestListBtn1.mouseover(function(){ latestListImg.attr('src',imageDir+'latestlist_hover2.png');});
    latestListBtn2.mouseover(function(){ latestListImg.attr('src',imageDir+'latestlist_hover1.png'); });
    latestListBtn1.mouseout(function(){ latestListImg.attr('src',imageDir+'latestlist_none.png'); });
    latestListBtn2.mouseout(function(){ latestListImg.attr('src',imageDir+'latestlist_none.png'); });
    /*********************/
    latestListBtn1.click(function(){
        latestListDiv.hide();
        orderByTimeBtn.show();
        cur_workstatus = '1';
        if(initStatus=='NOCLICKEDTYPE'){///search by lasted creation date
            orderByWorkStatus('1');
        }else{
            filterByWorkType(initStatus);

        }
    });
    latestListBtn2.click(function(){
        latestListDiv.hide();
        orderByTimeBtn.hide();//////hide this button and show button with max reviewed image
        orderByReviewsBtn.show();
        cur_workstatus = '2';
        if(initStatus=='NOCLICKEDTYPE'){///search by max revies
            orderByWorkStatus('2');
        }else{
            filterByWorkType(initStatus);
        }
    });
    /****************************review button********************************/
    orderByReviewsBtn.mouseover(function(){ $(this).css({"background":"url("+imageDir+"maxreview_hover.png) no-repeat",'background-size' :'100% 100%'});});
    orderByReviewsBtn.mouseout(function(){ $(this).css({"background":"url("+imageDir+"maxreview.png) no-repeat",'background-size' :'100% 100%'});});
    orderByReviewsBtn.click(function(){ orderByReviewsBtn.hide(); maxreviewListDiv.show();});
    maxreviewListBtn0.click(function(){ orderByReviewsBtn.show(); maxreviewListDiv.hide();});
    maxreviewListBtn1.mouseover(function(){ maxreviewImg.attr('src',imageDir+'maxreviewslist_hover2.png');});
    maxreviewListBtn2.mouseover(function(){ maxreviewImg.attr('src',imageDir+'maxreviewslist_hover1.png');});
    maxreviewListBtn1.mouseout(function(){  maxreviewImg.attr('src',imageDir+'maxreviewslist_none.png'); });
    maxreviewListBtn2.mouseout(function(){  maxreviewImg.attr('src',imageDir+'maxreviewslist_none.png'); });
   /*********************/
    maxreviewListBtn1.click(function(){
        maxreviewListDiv.hide();
        orderByTimeBtn.show();
        orderByReviewsBtn.hide();
        cur_workstatus = '1';
        if(initStatus=='NOCLICKEDTYPE'){///search by lasted creation date
            orderByWorkStatus('1');

        }else{
            filterByWorkType(initStatus);
        }
    });
    maxreviewListBtn2.click(function(){
        maxreviewListDiv.hide();
        orderByTimeBtn.hide();
        orderByReviewsBtn.show();
        cur_workstatus = '2';
        if(initStatus=='NOCLICKEDTYPE'){///search by max revies
            orderByWorkStatus('2');
        }else{
            filterByWorkType(initStatus);
        }

    });
   /***************************Filter Buttons Manage**************************************************/
   filterScriptBtn.click(function(){
       $(this).css({"background":"url("+imageDir+"scriptwork_hover.png) no-repeat",'background-size' :'100% 100%'});
       filterDubbingBtn.css({"background":"url("+imageDir+"dubbingwork.png) no-repeat",'background-size' :'100% 100%'});
       filterHeadBtn.css({"background":"url("+imageDir+"headwork.png) no-repeat",'background-size' :'100% 100%'});
       filterShootingBtn.css({"background":"url("+imageDir+"shootingwork.png) no-repeat",'background-size' :'100% 100%'});
       initStatus = '1';
       filterByWorkType(initStatus);

   });
   filterDubbingBtn.click(function(){
       $(this).css({"background":"url("+imageDir+"dubbingwork_hover.png) no-repeat",'background-size' :'100% 100%'});
       filterScriptBtn.css({"background":"url("+imageDir+"scriptwork.png) no-repeat",'background-size' :'100% 100%'});
       filterHeadBtn.css({"background":"url("+imageDir+"headwork.png) no-repeat",'background-size' :'100% 100%'});
       filterShootingBtn.css({"background":"url("+imageDir+"shootingwork.png) no-repeat",'background-size' :'100% 100%'});
       initStatus = '2';
       filterByWorkType(initStatus);

   });
   filterHeadBtn.click(function(){
       $(this).css({"background":"url("+imageDir+"headwork_hover.png) no-repeat",'background-size' :'100% 100%'});
       filterScriptBtn.css({"background":"url("+imageDir+"scriptwork.png) no-repeat",'background-size' :'100% 100%'});
       filterDubbingBtn.css({"background":"url("+imageDir+"dubbingwork.png) no-repeat",'background-size' :'100% 100%'});
       filterShootingBtn.css({"background":"url("+imageDir+"shootingwork.png) no-repeat",'background-size' :'100% 100%'});
       initStatus = '5';
       filterByWorkType(initStatus);

   });
   filterShootingBtn.click(function(){
       $(this).css({"background":"url("+imageDir+"shootingwork_hover.png) no-repeat",'background-size' :'100% 100%'});
       filterScriptBtn.css({"background":"url("+imageDir+"scriptwork.png) no-repeat",'background-size' :'100% 100%'});
       filterDubbingBtn.css({"background":"url("+imageDir+"dubbingwork.png) no-repeat",'background-size' :'100% 100%'});
       filterHeadBtn.css({"background":"url("+imageDir+"headwork.png) no-repeat",'background-size' :'100% 100%'});
       initStatus = '6';
       filterByWorkType(initStatus);

   });
   function make_item(orderNo,contentInfo)
   {
       var output_html = '';
       var interVal = 3.2;
       var itemHight = 9.2;
       var topVal = orderNo*itemHight+(orderNo+1)*interVal;
       var topValStr = topVal+"%";
       output_html += '<div class="comm_item_wrapper" style = "top:'+topValStr+'">';
       output_html += '<a class="comm_title" href="'+contentInfo['content_url']+'">'+contentInfo['title']+'</a>';
       output_html += '<a class="comm_author" href="'+contentInfo['profile_url']+'">'+contentInfo['author']+'</a>';
       output_html += '<a class="comm_school">'+contentInfo['school']+'</a>';
       output_html += '<a class="comm_viewNum">'+contentInfo['view_num']+'</a>';
       output_html += '<a class="comm_shareTime">'+contentInfo['share_time']+'</a>';
       output_html += '</div>';
       return output_html;
   }
   function comm_init_pager(contentlist)
   {
        var output_html = '';
        for(var i=0;i<contentlist.length;i++)
        {
            var tempObj = contentlist[i];
            var modeVar = i%8;
            var pageNo = (i-modeVar)/8;
            totalPageCount  = pageNo;
            if(modeVar==0)
            {
                if(pageNo!=0)  output_html += '</div>';
                output_html += '<div class = "comm_page_'+pageNo+'" style="display: none">';
                output_html += make_item(modeVar,tempObj);
            }else{
                output_html += make_item(modeVar,tempObj);
            }

        }
        output_html += '</div>';
        $('#community_list_area').html(output_html);
   }
   function comm_show_page(pageNo)
   {
       var classStr = '.comm_page_'+pageNo;
       $(classStr).show('slow');
   }
   function comm_hide_page(pageNo)
   {
       var classStr = '.comm_page_'+pageNo;
       $(classStr).hide('slow');
   }
   function comm_next_page()
   {
       if(cur_pageNo>totalPageCount-1) return;
       else {
           comm_hide_page(cur_pageNo);
           cur_pageNo++;
           comm_show_page(cur_pageNo);

       }
   }
   function comm_prev_page()
   {
       console.log('current Page No:'+cur_pageNo);
       if(cur_pageNo<1) return;
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
            url: baseURL + "primary/community/orderByContentType",
            dataType: "json",
            data: {orderBySelect:cur_workstatus,content_type_id:contentType},
            success: function (res) {
                if (res.status == 'success') {
                    comm_init_pager(res.data);
                    comm_show_page(0);
                    fitWindow();
                }
                else//failed
                {
                    alert("can not filter by content type");
                }
            }
        })
    }
   function orderByWorkStatus(orderBySelect_Id){
        cur_pageNo = 0;
        $.ajax({
            type: "post",
            url: baseURL + "primary/community/orderBySelect",
            dataType: "json",
            data: {orderBySelect:orderBySelect_Id},
            success: function (res) {
                if (res.status == 'success') {
                    comm_init_pager(res.data);
                    comm_show_page(0);
                    fitWindow();
                }
                else//failed
                {
                    alert("can not order by work status");
                }
            }
        })
    }
    var prev_btn = $('.previous_Btn');
    var next_btn = $('.next_Btn');

    prev_btn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"prev_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    prev_btn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"prev.png) no-repeat",'background-size' :'100% 100%'});
    });
    next_btn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"next_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    next_btn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"next.png) no-repeat",'background-size' :'100% 100%'});
    });
    prev_btn.click(function(){
        comm_prev_page();
    });
    next_btn.click(function(){
        comm_next_page();
    });
    function fitWindow()
    {
       var fontHRate = 0.0185;
       var fontWRate = 0.01;
       var realFHSize = (window.innerHeight)*fontHRate;
       var realFWSize = (window.innerWidth)*fontWRate;
       var realFSize = (realFHSize>realFWSize)? realFWSize:realFHSize;

       var topVal = (20-realFSize)*1.3+17;

       $('.comm_title').css('font-size',realFSize);
       $('.comm_author').css('font-size',realFSize);
       $('.comm_school').css('font-size',realFSize);
       $('.comm_viewNum').css('font-size',realFSize);
       $('.comm_shareTime').css('font-size',realFSize);

        $('.comm_title').css('top',topVal+'%');
        $('.comm_author').css('top',topVal+'%');
        $('.comm_school').css('top',topVal+'%');
        $('.comm_viewNum').css('top',topVal+'%');
        $('.comm_shareTime').css('top',topVal+'%');

    }
    fitWindow();
    $(window).resize(function(){
        fitWindow();
    });

});
