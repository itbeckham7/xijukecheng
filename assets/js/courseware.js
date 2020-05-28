$(window).load(function(){

    if( window.addEventListener ){
        window.addEventListener( 'message', receiveMessage, false );
    } else {
        window.attachEvent( 'onmessage', receiveMessage );
    }

    //init for script work
    var subware_path  = $('#script').attr('subware_path');
    var sw_publish = $('#script').attr('subware_publish');

    if(sw_publish=='1'){
        if(subware_path!='nosubware')
        {
            $('iframe').attr( 'src', baseURL+subware_path);
            $('iframe').attr( 'height', '800px');
        }else{
            $('.nosubware_msg').show();
        }

    }
    
    function updateSubwareAccessTime(swTypeId){

        $.ajax({
            type:"post",
            url:base_url+'primary/coursewares/update_SW_Access',
            dataType:'json',
            data:{subware_type_id:swTypeId},
            success:function(res){
                if(res.status=='success'){

                }else{
                }
            }
        });
    }
    $('#script').click( function(){
        var subware_path  = $(this).attr('subware_path');
        if(subware_path!='nosubware')
        {
            $('iframe').attr( 'src', baseURL+subware_path);
            $('iframe').attr( 'height', '800px');
        }else{
            $('.nosubware_msg').show();
            updateSubwareAccessTime('1');
        }

        $('#script_image').attr('src',base_url+'assets/images/frontend/coursewares/view/script_hover.png');
        $('#flash_image').attr('src',base_url+'assets/images/frontend/coursewares/view/flash.png');
        $('#dubbing_image').attr('src',base_url+'assets/images/frontend/coursewares/view/dubbing.png');
        $('#shooting_image').attr('src',base_url+'assets/images/frontend/coursewares/view/shooting.png');

        curr_sw = 'script_sw';
    } );
    $('#flash').click( function(){
        var subware_path  = $(this).attr('subware_path');
        var sw_publish = $(this).attr('subware_publish');
        if(sw_publish!='1') return;
        if(subware_path!='nosubware')
        {
            $('iframe').attr( 'src', baseURL+subware_path);
            $('iframe').attr( 'height', '800px');
        }else{
            $('.nosubware_msg').show();
            updateSubwareAccessTime('2');
        }

        $('#script_image').attr('src',base_url+'assets/images/frontend/coursewares/view/script.png');
        $('#flash_image').attr('src',base_url+'assets/images/frontend/coursewares/view/flash_hover.png');
        $('#dubbing_image').attr('src',base_url+'assets/images/frontend/coursewares/view/dubbing.png');
        $('#shooting_image').attr('src',base_url+'assets/images/frontend/coursewares/view/shooting.png');

        curr_sw = 'flash_sw';

    } );

    $('#dubbing').click( function(){

        var subware_path  = $(this).attr('subware_path');
        var sw_publish = $(this).attr('subware_publish');
        if(sw_publish!='1') return;
        if(subware_path!='nosubware')
        {
            $('iframe').attr( 'src', baseURL+subware_path);
            $('iframe').attr( 'height', '800px');
        }else{
            $('.nosubware_msg').show();
            updateSubwareAccessTime('3');
        }

        $('#script_image').attr('src',base_url+'assets/images/frontend/coursewares/view/script.png');
        $('#flash_image').attr('src',base_url+'assets/images/frontend/coursewares/view/flash.png');
        $('#dubbing_image').attr('src',base_url+'assets/images/frontend/coursewares/view/dubbing_hover.png');
        $('#shooting_image').attr('src',base_url+'assets/images/frontend/coursewares/view/shooting.png');

        curr_sw = 'dubbing_sw';

    } );

    $('#shooting').click( function(){
        var subware_path  = $(this).attr('subware_path');
        var sw_publish = $(this).attr('subware_publish');
        if(sw_publish!='1') return;

        if(subware_path!='nosubware')
        {
            $('iframe').attr( 'src', baseURL+subware_path);
            $('iframe').attr( 'height', '800px');
        }else{
            $('.nosubware_msg').show();
            updateSubwareAccessTime('4');
        }

        $('#script_image').attr('src',base_url+'assets/images/frontend/coursewares/view/script.png');
        $('#flash_image').attr('src',base_url+'assets/images/frontend/coursewares/view/flash.png');
        $('#dubbing_image').attr('src',base_url+'assets/images/frontend/coursewares/view/dubbing.png');
        $('#shooting_image').attr('src',base_url+'assets/images/frontend/coursewares/view/shooting_hover.png');

        curr_sw = 'shooting_sw';

    } );

    function receiveMessage(event){

        var iframe = document.getElementById('courseware_iframe').contentWindow;
        var message = event.data; //this is the message
        message = JSON.parse(message);

        if( message.type == 'get-courseware-id' ){
            var courseware_id = $('#script').data('courseware_id');
            var response = {
                type: 'courseware-id',
                value: courseware_id,
                login_status:login_status,
                login_username:login_username,
                base_URL:base_url
            };
            iframe.postMessage(JSON.stringify(response), '*');
        }
    }


});