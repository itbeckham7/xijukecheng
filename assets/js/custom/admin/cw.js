/**
 * Created by Administrator on 7/18/2017.
 */
jQuery("#delete_cw_item_btn").click(function () {
    var delete_cw_id = jQuery("#delete_cw_item_btn").attr("delete_cw_id");
    jQuery.ajax({
        type: "post",
        url: baseURL+"admin/coursewares/delete",
        dataType: "json",
        data: {delete_cw_id: delete_cw_id, delete_cw_type: '0'},
        success: function(res) {
            if(res.status=='success') {
                location.reload();
                return;
                var table = document.getElementById("cwInfo_tbl");
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
    jQuery('#cw_delete_modal').modal('toggle');
});
jQuery("#cw_addNew_submit_form").submit(function (e) {
    $(".uploading_backdrop").toggle();
    $(".progressing_area").toggle();
    e.preventDefault();
    jQuery.ajax({
        url:baseURL+"admin/coursewares/add",
        type:"post",
        data:new  FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
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
    }).done(function(res) { //
        var ret;
        try {
            ret = JSON.parse(res);
        } catch (e) {
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            alert('File Uploading has been failed');
            // jQuery('#cw_addNew_modal').modal('toggle');
            console.log('file uploading has been failed');
        }
        if(ret.status=='success') {
            location.reload();
            return;

            var table = document.getElementById("cwInfo_tbl");
            var tbody = table.getElementsByTagName("tbody")[0];
            tbody.innerHTML = ret.data;
            executionPageNation();
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
        }
        else//failed
        {
            alert('File Uploading has been failed. Operation failed');
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            alert(ret.data);
        }
        jQuery('#cw_addNew_modal').modal('toggle');
    });

});
jQuery("#cw_edit_submit").submit(function (e) {
    $(".uploading_backdrop").show();
    $(".progressing_area").show();
    e.preventDefault();
    var cw_id = jQuery("#cw_info_id").val();
    var fdata = new  FormData(this);
    fdata.append("cw_id",cw_id);
    jQuery.ajax({
        url:baseURL+"admin/coursewares/edit",
        type:"post",
        data:fdata,
        processData:false,
        contentType:false,
        cache:false,
        async:false,
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
    }).done(function(res){
        var ret;
        try{
            ret = JSON.parse(res);
        }catch(e){
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            jQuery('#cw_modify_modal').modal('toggle');
            alert('File uploading has been failed.');
            console.log(res);
            return;
        }
        if(ret.status=='success') {
            location.reload();
            return;
            var table = document.getElementById("cwInfo_tbl");
            var tbody = table.getElementsByTagName("tbody")[0];
            tbody.innerHTML = ret.data;
            executionPageNation();
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
        }
        else//failed
        {
            $(".uploading_backdrop").hide();
            $(".progressing_area").hide();
            alert('File uploading has been failed');
            console.log(ret.data)
        }
        jQuery('#sw_modify_modal').modal('toggle');
    })
});