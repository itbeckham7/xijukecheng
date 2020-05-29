<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (APPPATH.'pdfmaker/autoload.php');

class Contents extends CI_Controller {

    function __construct() {
        parent::__construct();
        $language = 'english';
        
        $this->load->model("contents_m");
        $this->load->model("ncontents_m");
        $this->load->model("ncoursewares_m");
        $this->load->model("signin_m");
        $this->load->library("pagination");
        $this->load->library("session");
    }
    public function upload(){

        $user_id = 1;
        if(!($this->signin_m->loggedin()))
        {
            return;
        }else{
            $user_id = $this->session->userdata("loginuserID");
        }
        if(!($_POST)){
            $error = 'File Type or file name is mistake.';
            $output = array(
                'status' => 'fail',
                'error' => $error
            );
            echo json_encode($output);
            return;
        }
        $type = $_POST['type'];
        $new_filename = $_POST['new_filename'];
        $coursewareId = $_POST['coursewareId'];
        if( $type == 'script' ){
            $this->script_upload( $user_id, $coursewareId, $new_filename );
        } else if( $type == 'head' ){
            $this->head_upload( $user_id, $coursewareId, $new_filename );
        } else if( $type == 'shooting' ){
            $this->shooting_upload( $user_id, $coursewareId, $new_filename );
        } else if( $type == 'record' ){
            $this->record_upload( $user_id, $coursewareId, $new_filename );
        } else if( $type == 'dubbing-read' ){
            $this->dubbing_read_upload( $user_id, $coursewareId, $new_filename );
        } else if( $type == 'dubbing-song' ){
            $this->dubbing_song_upload( $user_id, $coursewareId, $new_filename );
        } else if( $type == 'dubbing-script' ){
            $this->dubbing_script_upload( $user_id, $coursewareId, $new_filename );
        } else if( $type == 'note' ){
            $this->new_note_upload( $user_id, $coursewareId, $new_filename );
        }

    }

    public function view( $id ){

        $this->data['content_id'] = $id;
        $this->data['subwares'] = $this->subwares_m->get_where( array('content_id'=>$id) );

        $this->data["subview"] = "middle/contents/view";
        $this->load->view('middle/_layout_main', $this->data);
    }
    function duplication_process($content_title,$content_type)///$content_type {script, dubbing,head,shooting}
    {

      $dupliData = $this->contents_m->isDuplication($content_title);
      if($dupliData['status']==='EXIST')
      {
          ///delete content
          if(!(unlink($dupliData['content_path']))){///file remove
           echo 'Can not delete previous work with current title';
          }
          ///delete all record with current content title
          $this->contents_m->delete($dupliData['content_id']);
      }
    }

    function nduplication_process($ncontent_title,$ncontent_type)///$content_type {script, dubbing,head,shooting}
    {

        $dupliData = $this->ncontents_m->isDuplication($ncontent_title);
        if($dupliData['nstatus']==='EXIST')
        {
            ///delete content
            if(!(unlink($dupliData['ncontent_path']))){///file remove
                echo 'Can not delete previous work with current title';
            }
            ///delete all record with current content title
            $this->ncontents_m->delete($dupliData['ncontent_id']);
        }
    }

    private function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash="" ) {
        //usage:  if( substr( $img_src, 0, 5 ) === "data:" ) {  $filename=save_base64_image($base64_image_string, $output_file_without_extentnion, getcwd() . "/application/assets/pins/$user_id/"); }
        //
        //data is like:    data:image/png;base64,asdfasdfasdf
        $splited = explode(',', substr( $base64_image_string , 5 ) , 2);
        $mime=$splited[0];
        $data=$splited[1];

        $mime_split_without_base64=explode(';', $mime,2);
        $mime_split=explode('/', $mime_split_without_base64[0],2);
        if(count($mime_split)==2)
        {
            $extension=$mime_split[1];
            if($extension=='jpeg')$extension='jpg';
            //if($extension=='javascript')$extension='js';
            //if($extension=='text')$extension='txt';
            $output_file_with_extension=$output_file_without_extension.'.'.$extension;
        }
        file_put_contents( $path_with_end_slash . $output_file_with_extension, base64_decode($data) );
        return $output_file_with_extension;
    }

    private function script_upload( $user_id, $coursewareId, $new_filename ){
        $this->duplication_process($new_filename,'1');///duplication processing
        $uploadDirectory = FCPATH . 'uploads/work/script';
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
        $path = FCPATH . 'uploads/work/script/' . $new_filename . '.txt';
        $path1 = 'uploads/work/script/' . $new_filename . '.txt';
        $file = fopen($path,"w");
        fwrite($file, $_POST['content']);
        fclose($file);
        $data = array(
            'content_title' => $new_filename,
            'content_type_id' => '1',
            'content_user_id' => $user_id,
            'courseware_id'=>$coursewareId,
            'local' => '1',
            'public' => '0',
            'file_name' => $path1,
        );
        $this->contents_m->insert_contents($data);
        ///return success message
        $output = array(
            'status' => 'success',
            'error' => ''
        );
        echo json_encode($output);
        return;
    }

    private function head_upload( $user_id, $coursewareId, $new_filename ){
        $this->duplication_process($_POST['title'],'3');///duplication processing
        $uploadDirectory = FCPATH . 'uploads/work/head';
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
        $img = $_POST['imgBase64'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);

        $path = FCPATH . 'uploads/work/head/' . $new_filename . '.png';
        $path1 = 'uploads/work/head/' . $new_filename . '.png';
        file_put_contents($path, $fileData);

        $data = array(
            'content_title' => $_POST['title'],
            'content_type_id' => '5',
            'content_user_id' => $user_id,
            'courseware_id'=>$coursewareId,
            'local' => '1',
            'public' => '0',
            'file_name' => $path1,
        );

        $this->contents_m->insert_contents( $data );
    }

    private function shooting_upload( $user_id, $coursewareId, $new_filename ){
        if($_FILES["file"]['name'] !="") {
            $file_name = $_FILES["file"]['name'];
            $file_name_rename = $new_filename;

            $explode = explode('.', $file_name);
            if(count($explode) >= 2) {
                $uploadDirectory = FCPATH . 'uploads/work/shooting';
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                }
                $new_file = $file_name_rename.'.'.$explode[1];
                $config['upload_path'] = "./uploads/work/shooting";
                $config['allowed_types'] = "mp4|mov";
                $config['file_name'] = $new_file;

                $this->duplication_process($file_name_rename,'4');///duplication processing

                $this->load->library('upload', $config);
                if(!$this->upload->do_upload("file")) {
                    $error = $this->upload->display_errors();
                    echo $error;
                } else {
                    $path = FCPATH . 'uploads/work/shooting/' . $new_file;
                    $path1 = 'uploads/work/shooting/' . $new_file;
                    $data = array(
                        'content_title' => $file_name_rename,
                        'content_type_id' => '6',
                        'content_user_id' => $user_id,
                        'courseware_id'=>$coursewareId,
                        'local' => '1',
                        'public' => '0',
                        'file_name' => $path1,
                    );

                    $this->contents_m->insert_contents( $data );
                }
            } else {
                echo 'File type error.';
            }
        } else {
            echo 'File name error.';
        }
    }

    private function record_upload( $user_id, $coursewareId, $new_filename ){
        // if it is audio-blob
        if (isset($_FILES["video-blob"])) {
            $this->duplication_process($_POST['new_filename'],'4');///duplication processing

            $uploadDirectory = FCPATH . 'uploads/work/shooting';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $file_name_rename = $_POST['new_filename'];

            $uploadDirectory = 'uploads/work/shooting/'.$file_name_rename.'.mp4';
            if (!move_uploaded_file($_FILES["video-blob"]["tmp_name"], $uploadDirectory)) {
                $error = "Problem writing video file to disk!";

                $output = array(
                    'status' => 'fail',
                    'error' => $error
                );

                echo json_encode($output);
            }
            else {
                $data = array(
                    'content_title' => $file_name_rename,
                    'content_type_id' => '6',
                    'content_user_id' => $user_id,
                    'courseware_id'=>$coursewareId,
                    'local' => '1',
                    'public' => '0',
                    'file_name' => $uploadDirectory,
                );

                $this->contents_m->insert_contents( $data );

                $output = array(
                    'status' => 'success',
                    'filename' => $uploadDirectory
                );

                echo json_encode($output);
            }
        } else {
            $error = "no video blob";

            $output = array(
                'status' => 'fail',
                'error' => $error
            );
        }

    }

    private function dubbing_read_upload( $user_id, $coursewareId, $new_filename ){
        // if it is read-blob
        if (isset($_FILES["read-blob"]) && isset($_POST["read-bg-video"])) {
            $uploadDirectory = FCPATH . 'uploads/work/dubbing';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }
            $file_name_rename = $_POST['new_filename'];
            $this->duplication_process($file_name_rename,'2');///duplication processing
            ///
            $uploadFileName = 'uploads/work/dubbing/'.$file_name_rename.'.wav';
            if (!move_uploaded_file($_FILES["read-blob"]["tmp_name"], $uploadFileName)) {
                $error = "Problem writing read audio file to disk!";
                $output = array(
                    'status' => 'fail',
                    'error' => $error
                );

                echo json_encode($output);
            }
            else {
                $data = array(
                    'content_title' => trim($file_name_rename),
                    'content_type_id' => '2',
                    'courseware_id'=>$coursewareId,
                    'content_user_id' => $user_id,
                    'local' => '1',
                    'public' => '0',
                    'file_name' => $uploadFileName,
                    'bg_path' => $_POST["read-bg-video"],
                );

                $this->contents_m->insert_contents( $data );

                $output = array(
                    'status' => 'success',
                    'filename' => $uploadFileName
                );

                echo json_encode($output);
            }
        } else {
            $error = "There are no read audio file";

            $output = array(
                'status' => 'fail',
                'error' => $error
            );

            echo json_encode($output);
        }
    }
    private function dubbing_song_upload( $user_id, $coursewareId, $new_filename ){
        // if it is song-blob
        if (isset($_FILES["song-blob"]) && isset($_POST["song-bg-video"])) {
            $uploadDirectory = FCPATH . 'uploads/work/dubbing';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }
            $file_name_rename = $_POST['new_filename'];
            $this->duplication_process($file_name_rename,'3');///duplication processing
            ///
            $uploadFileName = 'uploads/work/dubbing/'.$file_name_rename.'.wav';
            if (!move_uploaded_file($_FILES["song-blob"]["tmp_name"], $uploadFileName)) {
                $error = "Problem writing song audio file to disk!";
                $output = array(
                    'status' => 'fail',
                    'error' => $error
                );

                echo json_encode($output);
            }
            else {
                $data = array(
                    'content_title' => $file_name_rename,
                    'content_type_id' => '3',
                    'courseware_id'=>$coursewareId,
                    'content_user_id' => $user_id,
                    'local' => '1',
                    'public' => '0',
                    'file_name' => $uploadFileName,
                    'bg_path' => $_POST["song-bg-video"],
                );

                $this->contents_m->insert_contents( $data );

                $output = array(
                    'status' => 'success',
                    'filename' => $uploadFileName
                );

                echo json_encode($output);
            }
        } else {
            $error = "There are no song audio file";

            $output = array(
                'status' => 'fail',
                'error' => $error
            );

            echo json_encode($output);
        }
    }
    private function dubbing_script_upload( $user_id, $coursewareId, $new_filename ){
        // if it is script-blob
        if (isset($_FILES["script-blob"]) && isset($_FILES["script-bg-blob"])) {
            $uploadDirectory = FCPATH . 'uploads/work/dubbing';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }
            $file_name_rename = $_POST['new_filename'];
            $this->duplication_process($file_name_rename,'2');///duplication processing
            ///
            $uploadFileName = 'uploads/work/dubbing/'.$file_name_rename.'.wav';
            $uploadFileName_bg = 'uploads/work/dubbing/'.$file_name_rename.'.png';
            if (!move_uploaded_file($_FILES["script-blob"]["tmp_name"], $uploadFileName)) {
                $error = "Problem writing script audio file to disk!";
                $output = array(
                    'status' => 'fail',
                    'error' => $error
                );

                echo json_encode($output);
            } else {
                if (!move_uploaded_file($_FILES["script-bg-blob"]["tmp_name"], $uploadFileName_bg)) {
                    $error = "Problem writing script image file to disk!";
                    $output = array(
                        'status' => 'fail',
                        'error' => $error
                    );

                    echo json_encode($output);
                } else {
                    $data = array(
                        'content_title' => $file_name_rename,
                        'content_type_id' => '4',
                        'courseware_id'=>$coursewareId,
                        'content_user_id' => $user_id,
                        'local' => '1',
                        'public' => '0',
                        'file_name' => $uploadFileName,
                        'bg_path' => $uploadFileName_bg,
                    );

                    $this->contents_m->insert_contents( $data );

                    $output = array(
                        'status' => 'success',
                        'filename' => $uploadFileName
                    );

                    echo json_encode($output);
                }
            }
        } else {
            $error = "There are no script audio file";

            $output = array(
                'status' => 'fail',
                'error' => $error
            );

            echo json_encode($output);
        }
    }

    public function new_course_upload(){

        $ret = array('data'=>'','status'=>'fail');
        if($_REQUEST)
        {
            $user_id = $_REQUEST['user_id'];
            $coursewareId = $_REQUEST['ncoursewareId'];
            $new_filename = $_REQUEST['filename'];

            $upload_path =  'uploads/nwork';
            $path = FCPATH . 'uploads/nwork/course/' . $new_filename . '.wav';
            $path1 = 'uploads/nwork/course/' . $new_filename . '.wav';

            $fp = fopen($path, "wb");

            fwrite($fp, file_get_contents('php://input'));

            fclose($fp);

            ///belong title(所属课程)

            $ncontent_belong_title = $this->ncoursewares_m->getBelongTitleByCwId($coursewareId);

            $dt = new DateTime("now", new DateTimeZone('Asia/Hong_Kong'));

            $data = array(
                'ncontent_title' => $new_filename,
                'ncontent_type_id' => '1',
                'ncontent_user_id' => $user_id,
                'ncontent_ncwid'=>$coursewareId,
                'ncontent_belong_title'=>$ncontent_belong_title,/// new added part on 2017.11.30
                'ncontent_local' => '1',
                'ncontent_cloud' => '0',
                'ncontent_file' => $path1,
                'ncontent_createtime' => $dt->format('Y-m-d H:i:s'),
            );
            $this->ncontents_m->insert_ncontents($data);

            exit('done');
        }
    }

    public function new_text_upload(){

        $ret = array('data'=>'','status'=>'fail');
        if($_REQUEST)
        {
            $user_id = $_REQUEST['user_id'];
            $coursewareId = $_REQUEST['ncoursewareId'];
            $new_filename = $_REQUEST['filename'];

            $upload_path =  'uploads/nwork';
            $path = FCPATH . 'uploads/nwork/text/' . $new_filename . '.wav';
            $path1 = 'uploads/nwork/text/' . $new_filename . '.wav';

            $fp = fopen($path, "wb");

            fwrite($fp, file_get_contents('php://input'));

            fclose($fp);

            $ncontent_belong_title = $this->ncoursewares_m->getBelongTitleByCwId($coursewareId);

            $dt = new DateTime("now", new DateTimeZone('Asia/Hong_Kong'));

            $data = array(
                'ncontent_title' => $new_filename,
                'ncontent_type_id' => '2',
                'ncontent_user_id' => $user_id,
                'ncontent_ncwid'=>$coursewareId,

                'ncontent_belong_title'=>$ncontent_belong_title,///new added part on 2017.11.30

                'ncontent_local' => '1',
                'ncontent_cloud' => '0',
                'ncontent_file' => $path1,
                'ncontent_createtime' => $dt->format('Y-m-d H:i:s'),
            );
            $this->ncontents_m->insert_ncontents($data);

            exit('done');
        }
    }

    private function new_note_upload( $user_id, $coursewareId, $new_filename ){
        $this->duplication_process($new_filename,'3');///duplication processing
        $uploadDirectory = FCPATH . 'uploads/nwork/note';
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
        $path = FCPATH . 'uploads/nwork/note/' . $new_filename . '.txt';
        $path1 = 'uploads/nwork/note/' . $new_filename . '.txt';
        $file = fopen($path,"w");
        fwrite($file, $_POST['content']);
        fclose($file);

        $ncontent_belong_title = $this->ncoursewares_m->getBelongTitleByCwId($coursewareId);

        $dt = new DateTime("now", new DateTimeZone('Asia/Hong_Kong'));

        $data = array(
            'ncontent_title' => $new_filename,
            'ncontent_type_id' => '3',
            'ncontent_user_id' => $user_id,
            'ncontent_ncwid'=>$coursewareId,

            'ncontent_belong_title'=>$ncontent_belong_title,///new added part on 2017.11.30

            'ncontent_local' => '1',
            'ncontent_cloud' => '0',
            'ncontent_file' => $path1,
            'ncontent_createtime' => $dt->format('Y-m-d H:i:s'),
        );
        $this->ncontents_m->insert_ncontents($data);
        ///return success message
        $output = array(
            'status' => 'success',
            'error' => ''
        );
        echo json_encode($output);
        return;
    }
    public function temp_duddingImage()
    {
        $output = array(
            'status' => 'success',
            'filename' => ''
        );
        ////first get user id and save blob data to temp directory......
        if($_POST)
        {
            $fileName = trim($_POST['file_name']);
            $userId = $_POST['user_id'];
            if (isset($_POST["head-base64"])) {

                $uploadDirectory = 'uploads/temp/'.$userId.'/';
                if(!is_dir($uploadDirectory))
                {
                    mkdir($uploadDirectory);
                }
                $this->save_base64_image($_POST['head-base64'], $uploadDirectory.$fileName );
                $path = $uploadDirectory.$fileName.'.png';
                $output['status '] = 'success';
                $output['filename'] =  $path;
                echo json_encode($output);
            }

        }
    }

    public function iosUploadVideo(){

        $ret = array(
            'status'=>'fail',
            'data'=>''
        );
        if(!empty($_POST)){

            $fileName = $_POST['file_name'];
            $cwId = $_POST['courseware_id'];

            $uploadPath = 'middle/work/shooting';
            $dirPath = 'uploads/'.$uploadPath;
            if(!is_dir($dirPath))
            {
                mkdir($dirPath,0755, true);
            }
            $config['upload_path']='./uploads/'.$uploadPath.'/';
            $config['allowed_types']='mp4';
            $this->load->library('upload',$config);

            $user_id = $this->session->userdata("loginuserID");

            if($this->upload->do_upload('video_file')){
                $data = $this->upload->data();
                $video_path = $dirPath.'/' . $data["file_name"];

                $data = array(
                    'content_title' => trim($fileName),
                    'content_type_id' => '6',
                    'content_user_id' => $user_id,
                    'courseware_id'=>$cwId,
                    'local' => '1',
                    'public' => '0',
                    'file_name' => $video_path,
                );

                $this->contents_m->insert_contents( $data );
                $ret['status'] = 'success';
                $ret['data'] = 'File uploading success';
            }else{
                $ret['data'] = 'Video uploading failed!';
                $ret['status'] = 'fail';
            }
        }
        echo json_encode($ret);
    }

    public function iosUploadDubbingAudio(){///For dubbing page of script audio uploading

        $error = "Post Parameter Invalid";
        $output = array(
            'status' => 'fail',
            'error' => $error
        );

        $user_id = $this->session->userdata("loginuserID");
        $coursewareId = $this->session->userdata('current_courseware_id');
        $dubbingType = $this->session->userdata('current_dubbing_type');

        if(!empty($_POST)){

            $file_name_rename = $_POST['new_filename'];
            $uploadFileName = 'uploads/work/dubbing/'.$file_name_rename.'.wav';
            $uploadFileName_bg = 'uploads/work/dubbing/'.$file_name_rename.'.png';
            $bgSongVideoPath = 'uploads/courseware/'.$coursewareId.'/dubbing/video/song.mp4';
            $bgReadVideoPath = 'uploads/courseware/'.$coursewareId.'/dubbing/video/dubbing.mp4';

            if (isset($_FILES["audio-blob"])) {
                $uploadDirectory = FCPATH . 'uploads/work/dubbing';
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                }

                $this->duplication_process($file_name_rename,'2');///duplication processing

                if (!move_uploaded_file($_FILES["audio-blob"]["tmp_name"], $uploadFileName)) {
                    $error = "Problem writing dubbing audio file to disk!";
                    $output = array(
                        'status' => 'fail',
                        'error' => $error
                    );
                    echo json_encode($output);
                    return;

                }else{

                    $data = array(
                        'content_title' => $file_name_rename,
                        'content_type_id' => $dubbingType,
                        'courseware_id'=> $coursewareId,
                        'content_user_id' => $user_id,
                        'local' => '1',
                        'public' => '0',
                        'file_name' => $uploadFileName,
                    );
                    switch ($dubbingType){
                        case '2'://dubbing-read
                            $data['bg_path'] = $bgReadVideoPath;
                            break;
                        case '3'://dubbing-song
                            $data['bg_path'] = $bgSongVideoPath;
                            break;
                        case '4'://dubbing-script
                            $data['bg_path'] = $uploadFileName_bg;
                            break;
                    }

                    $this->contents_m->insert_contents( $data );

                    $output = array(
                        'status' => 'success',
                        'filename' => $uploadFileName
                    );

                    echo json_encode($output);
                    return;

                }

            } else {
                $error = "There are no dubbing audio file";

                $output = array(
                    'status' => 'fail',
                    'error' => $error
                );
                echo json_encode($output);
                return;
            }
        }
        echo json_encode($output);
    }
    public function iosUploadDubbingBg(){

        $error = "Problem writing script image file to disk!";
        $output = array(
            'status' => 'fail',
            'error' => $error
        );
        if (isset($_FILES["script-bg-blob"])) {

            $file_name_rename = $_POST['new_filename'];
            $uploadFileName_bg = 'uploads/work/dubbing/'.$file_name_rename.'.png';

            if (!move_uploaded_file($_FILES["script-bg-blob"]["tmp_name"], $uploadFileName_bg)) {
                $error = "Problem writing script image file to disk!";
                $output = array(
                    'status' => 'fail',
                    'error' => $error
                );
                echo json_encode($output);
                return;
            }else{
                $error = "Image Uploading Success";
                $output = array(
                    'status' => 'success',
                    'error' => $error
                );
                echo json_encode($output);
                return;
            }
        }
        echo json_encode($output);
    }
    public function iosSetCwInfo(){///set current courseware information

        $ret = array(
            'status'=>'fail',
            'data'=>''
        );
        if(!empty($_POST)){
            $this->session->set_userdata('current_courseware_id',$_POST['current_cwid']);
            $this->session->set_userdata('current_dubbing_type',$_POST['current_dubbingType']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);


    }

    ///Pdf Uplaod function
    public function uploadPDF()
    {
        $ret = array(
            'status'=>'fail',
            'data'=>''
        );

        if(isset($_POST['filename']))
        {
            $mpdf = new \Mpdf\Mpdf();
log_message('info', '-- uploadPDF : 1');
            $styleStr = '<style>
                                .content-wrap textarea{ width: 100%; height: 100%; font-size: 24px; padding: 10px; resize: none; overflow: auto}
                                .content-wrap textarea, .content-wrap textarea:focus, .content-wrap textarea:hover{
                                    border: 5px solid #e9e6cf; background-color: #f8f8f1;border-radius: 15px;
                                }
                                .content-wrap textarea:focus{ outline: none; }
                                .content-wrap{ border: 5px solid #e9e6cf; background-color: #f8f8f1; border-radius: 15px; overflow: auto }
                                .content-elem{ padding: 10px; box-sizing: border-box}
                                .elem-img{ display: inline-block; width: 10%; float: left; position: relative}
                                .elem-img img{ width: 100%; }
                                .elem-txt{ display: inline-block; float: left; box-sizing: border-box; padding-left: 2%; width: 85%; font-size: 24px;font-family: \'Comic Sans MS\';}
                                .clearfix{clear: both}
                        </style>';
            log_message('info', '-- uploadPDF : 2');
            $finalPDFHTML = $styleStr.$_POST['pdfcontent'];

            $mpdf->WriteHTML($finalPDFHTML);
            log_message('info', '-- uploadPDF : 3');
            $tempPdfDir = 'uploads/temp/-1/';
            if(!is_dir($tempPdfDir))
            {log_message('info', '-- uploadPDF : 4');
                mkdir($tempPdfDir,0755, true);
            }
            log_message('info', '-- uploadPDF : 5');
            $filename = $_POST['filename'].'.pdf';
            log_message('info', '-- uploadPDF : 6');
            $mpdf->Output($tempPdfDir.$filename, \Mpdf\Output\Destination::FILE);
            log_message('info', '-- uploadPDF : 7');
            $ret['status'] = 'success';
            $ret['data'] = $tempPdfDir.$filename;

        }log_message('info', '-- uploadPDF : 8');
        echo json_encode($ret);

    }

}
?>