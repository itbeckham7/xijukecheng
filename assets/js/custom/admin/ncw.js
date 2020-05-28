/**
 * Created by Administrator on 7/18/2017.
 */
jQuery("#delete_ncw_item_btn").click(function () {
    var delete_ncw_id = jQuery("#delete_ncw_item_btn").attr("delete_ncw_id");
    jQuery.ajax({
        type: "post",
        url: baseURL+"admin/ncoursewares/delete",
        dataType: "json",
        data: {delete_ncw_id: delete_ncw_id},
        success: function(res) {
            if(res.status=='success') {
                var table = document.getElementById("ncwInfo_tbl");
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
    jQuery('#ncw_delete_modal').modal('toggle');
});
jQuery("#ncw_addNew_submit_form").submit(function (e) {
    $(".uploading_backdrop").show();
    $(".progressing_area").show();
    e.preventDefault();
    $.ajax({
        url:baseURL+"admin/ncoursewares/add",
        type: "POST",
        data :new  FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        async:true,
        xhr: function(){
            //upload Progress
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function(event) {
                    var percent = 0;
                    var position = event.loaded || event.position;
                    var total = event.total;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);
                    }
                    $("#progress_percent").text(percent+'%');

                }, true);
            }
            return xhr;
        },
        mimeType:"multipart/form-data"
    }).done(function(res){ //
        var ret;
        try{
            ret = JSON.parse(res);
        }catch(e){
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            alert('File Uploading has been failed');
            console.log('file uploading has been failed');
            return;
        }
        if(ret.status=='success') {
            var table = document.getElementById("ncwInfo_tbl");
            var tbody = table.getElementsByTagName("tbody")[0];
            tbody.innerHTML = ret.data;
            executionPageNation();
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            jQuery('#ncw_addNew_modal').modal('toggle');
        }
        else//failed
        {
            alert('File Uploading has been failed. Operation failed');
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            jQuery('#ncw_addNew_modal').modal('toggle');
            alert(ret.data);
        }
    });

});
jQuery("#ncw_edit_submit_form").submit(function (e) {
    $(".uploading_backdrop").show();
    $(".progressing_area").show();
    e.preventDefault();
    var ncw_id = jQuery("#edit_ncw_save").attr('ncw_id');
    var fdata = new  FormData(this);
    fdata.append("ncw_id",ncw_id);
    $.ajax({
        url:baseURL+"admin/ncoursewares/edit",
        type: "POST",
        data :fdata,
        contentType: false,
        cache: false,
        processData:false,
        async:true,
        xhr: function(){
            //upload Progress
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function(event) {
                    var percent = 0;
                    var position = event.loaded || event.position;
                    var total = event.total;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);
                    }
                    $("#progress_percent").text(percent+'%');

                }, true);
            }
            return xhr;
        },
        mimeType:"multipart/form-data"
    }).done(function(res){ //
        var ret;
        try{
            ret = JSON.parse(res);
        }catch(e){
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            alert('File Uploading has been failed');
            console.log('file uploading has been failed');
            return;
        }
        if(ret.status=='success') {
            var table = document.getElementById("ncwInfo_tbl");
            var tbody = table.getElementsByTagName("tbody")[0];
            tbody.innerHTML = ret.data;
            executionPageNation();
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            jQuery('#ncw_edit_modal').modal('toggle');
        }
        else//failed
        {
            alert('File Uploading has been failed. Operation failed');
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            jQuery('#ncw_edit_modal').modal('toggle');
            alert(ret.data);
        }
    });

});