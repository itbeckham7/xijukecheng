<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nwork extends CI_Controller {

	function __construct() {
		parent::__construct();

		$language = 'chinese';
		$this->lang->load('frontend', $language);
		$this->load->model('ncontents_m');
		$this->load->model('users_m');
        $this->load->model('signin_m');
		$this->load->library("pagination");
		$this->load->library("session");
	}
	function view($userId)////$id is content id
    {
        if($this->signin_m->loggedin()) {

            $this->data['userId'] = $userId;
            $this->data['nContents']= $this->ncontents_m->get_ncontents(array('ncontent_type_slug'=>'course','ncontent_user_id'=>$userId));
            $this->data["subview"] = "middle/nwork/view";
            $this->load->view('middle/_layout_main', $this->data);
        }else{
            redirect(base_url().'signin/index');
        }
    }
    function mynote($userId)
    {
        if($this->signin_m->loggedin()) {

            $loginUserId = $this->session->userdata("loginuserID");
            if($userId!=$loginUserId)
            {
                $this->load->view('errors/html/access_denied.php');
            }
            else{
                $this->data["subview"] = "middle/nwork/index";
                $this->load->view('middle/_layout_main', $this->data);
            }

        }else{
            redirect(base_url().'signin/index');
        }
    }
    function teacher($teacherId)
    {
        if($this->signin_m->loggedin()) {

            $user_type = $this->session->userdata("user_type");
            if($user_type!='1')
            {
                /********Access denined Page*************/
                $this->load->view('errors/html/access_denied.php');
            }else{
                $this->data['userId'] = $teacherId;
                $techerInfo = $this->users_m->get_single_user($teacherId);
                $this->data['classlists'] = $this->getClassList($techerInfo->class);
                $this->data['nContents']= $this->ncontents_m->get_ncontents(array('ncontent_type_slug'=>'course','ncontent_user_id'=>$teacherId));
                $this->data["subview"] = "middle/nwork/teacher";
                $this->load->view('middle/_layout_main', $this->data);
            }
        }else{
            redirect(base_url().'signin/index');
        }
    }
    function upload_content()
    {
        $ret = array('data'=>'','status'=>'fail');
        if($_POST)
        {
            $contentId = $_POST['contentId'];
            $content_type_slug = $_POST['content_type'];
            $userId = $_POST['userId'];
            $this->ncontents_m->update(array('ncontent_cloud'=>'1'),$contentId);
            $ncontents = $this->ncontents_m->get_ncontents(array('ncontent_type_slug'=>$content_type_slug,'ncontent_user_id'=>$userId));
            $ret['data'] = $this->output_html($ncontents,$content_type_slug);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }
    function delete_content()
    {
        $ret = array('data'=>'','status'=>'fail');
        if($_POST)
        {
            $user_type = $this->session->userdata("user_type");
            $contentId = $_POST['contentId'];
            $content_type_slug = $_POST['content_type'];
            $userId = $_POST['userId'];
            $this->ncontents_m->delete($contentId);
            ///And we have to delete file too;
            $ncontents = $this->ncontents_m->get_ncontents(array('ncontent_type_slug'=>$content_type_slug,'ncontent_user_id'=>$userId));
            if($user_type=='1') $ret['data'] = $this->outputContentForTeacher($ncontents,$content_type_slug);
            else $ret['data'] = $this->output_html($ncontents,$content_type_slug);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }
    function update_contentToDelete()
    {
        $ret = array('data'=>'','status'=>'fail');
        if($_POST)
        {
            $contentId = $_POST['contentId'];
            $content_type_slug = $_POST['content_type'];
            $userId = $_POST['userId'];
            $localst  = $_POST['content_local'];
            $cloudst = $_POST['content_cloud'];

            $this->ncontents_m->update(array('ncontent_cloud'=>$cloudst,'ncontent_local'=>$localst),$contentId);
            $ncontents = $this->ncontents_m->get_ncontents(array('ncontent_type_slug'=>$content_type_slug,'ncontent_user_id'=>$userId));
            $ret['data'] = $this->output_html($ncontents,$content_type_slug);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }
    function change_table()
    {
        $ret = array('data'=>'','status'=>'fail');
        if($_POST)
        {
            $content_type_slug = $_POST['content_type'];
            $userId = $_POST['userId'];
            $ncontents = $this->ncontents_m->get_ncontents(array('ncontent_type_slug'=>$content_type_slug,'ncontent_user_id'=>$userId));
            $ret['data'] = $this->output_html($ncontents,$content_type_slug);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }
    function output_html($ncontents,$content_type_slug)
    {
        $output_html = '';
        $firstStr = '';
        $imageAbsDir = base_url().'assets/images/sandapian/';
        if($content_type_slug!='note'){
            foreach ($ncontents as $ncontent):
                $output_html .='<tr>';
                $output_html .= '<td class="qualified_field">';
                if($ncontent->ncontent_cloud=='1'){
                    $output_html .= '<img class="img-responsive" src="'.$imageAbsDir.'workview/level'.$ncontent->ncontent_qualify.'.png'.'">';
                }
                $includeStr = $ncontent->ncontent_belong_title;

                if(strlen($includeStr)>20){
                    $firstStr = substr($includeStr,0,20);
                    $firstStr = $firstStr.'...';
                }else $firstStr = $includeStr;

                $output_html .= '</td>';
                $output_html .= '<td class="notename_field"> <a href="#" class="content_title_link" onclick="show_content(this);" data-contentUrl="'.$ncontent->ncontent_file.'">'. $ncontent->ncontent_title.' </a></td>';
                $output_html .= '<td style="width:30%;">'.$includeStr.'</td>';
                $output_html .= '<td style="width:15%;">'. $ncontent->ncontent_createtime.'</td>';
                $output_html .= '<td  class="operation_field">';
                $output_html .= '<a class="op_delete_btn btn" 
                                    data-contentid="'.$ncontent->ncontent_id.'" 
                                    local_st="'.$ncontent->ncontent_local.'"
                                    cloud_st="'.$ncontent->ncontent_cloud.'"
                                    onclick="content_delete(this)" onmouseover="hover_delete(this)" onmouseout="out_delete(this)"></a>';
                $output_html .= '<a class="op_download_btn btn"  download href="'.base_url('middle/').$ncontent->ncontent_file.'" onmouseover="hover_download(this)" onmouseout="out_download(this)"></a>';
                if($ncontent->ncontent_cloud=='0'){
                    $output_html .= '<a class="op_upload_btn btn" data-contentid="'.$ncontent->ncontent_id.'" onclick="content_upload(this)" onmouseover="hover_upload(this)" onmouseout="out_upload(this)"></a>';
                }
                $output_html .= '</td>';
            endforeach;
        }else{
            foreach ($ncontents as $ncontent):

                $includeStr = $ncontent->ncontent_belong_title;

                if(strlen($includeStr)>20){
                    $firstStr = substr($includeStr,0,20);
                    $firstStr = $firstStr.'...';
                }else $firstStr = $includeStr;

                $output_html .='<tr>';
                $output_html .= '<td class="notename_filed_note"> <a href="#" class="content_title_link" onclick="show_content(this);" data-contentUrl="'.$ncontent->ncontent_file.'">'. $ncontent->ncontent_title.' </td>';
                $output_html .= '<td style="width:32%;">'. $includeStr.'</td>';
                $output_html .= '<td style="width:15.5%;text-align: center">'. $ncontent->ncontent_createtime.'</td>';
                $output_html .= '<td  class="operation_field_note">';
                $output_html .= '<a class="op_delete_note_btn btn" 
                                          data-contentid="'.$ncontent->ncontent_id.'"
                                          local_st="'.$ncontent->ncontent_local.'"
                                          cloud_st="'.$ncontent->ncontent_cloud.'" 
                                          onclick="content_delete(this)" onmouseover="hover_delete(this)" onmouseout="out_delete(this)"></a>';
                $output_html .= '<a class="op_download_note_btn btn" download href="'.base_url('middle/').$ncontent->ncontent_file.'"  onmouseover="hover_download(this)" onmouseout="out_download(this)"></a>';
                $output_html .= '</td>';
            endforeach;
        }
        return $output_html;
    }
    function getClassList($classListStr)///this function will be used for teachers
    {
        $ret = array();
        if($classListStr!='')
        {
            $classStr = $this->lang->line('Class');
            $nianStr = $this->lang->line('Nian');
            $gradeStr = $this->lang->line('Grade');
            $classArr =json_decode($classListStr,true);
            foreach ($classArr as $class_info):
                $classNo =  $class_info['class'];
                $gradeNo =  $class_info['grade'];
                $realGradeStr =  $this->lang->line($gradeNo-1);
                $realClassStr =  $this->lang->line($classNo-1);
                $fullClassName = $realGradeStr.$nianStr.$realClassStr.$classStr;
                $attrClassName = $realGradeStr.$gradeStr.$realClassStr.$classStr;
                $tempObj = new stdClass();
                $tempObj->attr_name = $attrClassName;
                $tempObj->class_name =$fullClassName;
                $tempObj->image_name =  $gradeNo.'-'.$classNo;
                array_push($ret,$tempObj);
            endforeach;
        }
        return $ret;

    }
    function getMembers()
    {
        $ret = array(
            'data'=>'',
            'totalPageCount'=>'0',
            'status'=>'fail'
        );
        if($_POST)
        {
            if($this->session->userdata()) {
                $teacherid = $this->session->userdata("loginuserID");
                $users = array();
                $className = $_POST['class_name'];
                $content_type_slug = $_POST['content_type_slug'];

                $school_id = $this->users_m->getSchoolIdFromUserId($teacherid);
                if($className!='')
                {
                    $users = $this->users_m->get_where(array('school_id'=>$school_id,'class'=>$className));
                }
                $ret['data'] = $this->output_members($users);
                $ret['totalPageCount'] = $this->data['totalPageNum'];
                $ret['status'] = 'success';
                echo json_encode($ret);
            }else{
                redirect(base_url().'signin/index');
            }
        }
    }
    function output_members($users)
    {
        $user_id = $this->session->userdata('loginuserID');///this filed is for student of user id
        $output = '';
        $serialNo = 0;
        $countPerPage = 16;
        $pageNo = 0;

        $output .= '<div class="left-block-member member_list_page0" style="display:none;position: absolute">';
        $output .=     '<div class="member_item_wrapper">';
        $output .=         '<a href="#" onclick="changePage(this)" data-userid="'.$user_id.'" class="member_item">'.'&nbsp&nbsp'.$this->lang->line('Me').'</a>';
        $output .=      '</div>';

        foreach ($users as $user):
            $serialNo++;
            $extraCounts = $serialNo%$countPerPage;
            $onePageState = $serialNo%($countPerPage/2);

            $pageNo = ($serialNo-$extraCounts)/$countPerPage;
            $symbolClassStr = "member_list_page".$pageNo;
            if($extraCounts==0){

                if($pageNo!=0) {///page is more than one
                    $output .= '</div>';
                }
                $output .= '<div class="left-block-member '.$symbolClassStr.'" style="display:none;position: absolute">';
                $output .=     '<div class="member_item_wrapper">';
                $output .=         '<a href="#"  onclick="changePage(this)" data-userid="'.$user->user_id.'" class="member_item" >'.($serialNo+1).'&nbsp'.$user->fullname.'</a>';
                $output .=      '</div>';
            }else if($onePageState==0){
                $output .= '</div><div class="right-block-member '.$symbolClassStr.'"  style="display:none;position: absolute">';
                $output .=     '<div class="member_item_wrapper">';
                $output .=         '<a href="#"  onclick="changePage(this)" data-userid="'.$user->user_id.'" class="member_item">'.($serialNo+1).'&nbsp'.$user->fullname.'</a>';
                $output .=      '</div>';
            }else{
                $output .=     '<div class="member_item_wrapper">';
                $output .=         '<a href="#" onclick="changePage(this)" data-userid="'.$user->user_id.'" class="member_item">'.($serialNo+1).'&nbsp'.$user->fullname.'</a>';
                $output .=      '</div>';
            }
            //}
        endforeach;
        $this->data['totalPageNum'] =  $pageNo;
        $output .= '</div>';
        return $output;
    }
    function getContents()
    {
        $ret = array(
            'data'=>'',
            'status'=>'fail'
        );
        if($_POST)
        {
            $userId = $_POST['userid'];
            $content_type_slug = $_POST['content_slug'];
            $arr = array('ncontent_type_slug'=>$content_type_slug,'ncontent_user_id'=>$userId);
            $ncontents = $this->ncontents_m->get_ncontents($arr);
            $ret['data'] = $this->outputContentForTeacher($ncontents,$content_type_slug);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }
    function outputContentForTeacher($ncontents,$content_type_slug)
    {
        $output_html = '';

        $firstStr = '';

        $loginUserId = $this->session->userdata('loginuserID');///this filed is for student of user id
        $user_type = $this->session->userdata("user_type");
        if($content_type_slug!='note')
        {
            foreach ($ncontents as $ncontent):

                $includeStr = $ncontent->ncontent_belong_title;

                if(strlen($includeStr)>20){
                    $firstStr = substr($includeStr,0,20);
                    $firstStr = $firstStr.'...';
                }else $firstStr = $includeStr;

                $output_html .=  '<tr>';
                $output_html .=  '<td class="content_name">';
                $output_html .=  '<a href="#" class="ncontent_title" onclick = "showNContent(this)" data-file="'.$ncontent->ncontent_file.'">'.$ncontent->ncontent_title.'</a>';
                $output_html .=  '</td>';
                $output_html .=  '<td class="include_course">'.$includeStr.'</td>';

                if($loginUserId!=$ncontent->ncontent_user_id) $output_html .=  '<td class="author_name">'.$ncontent->fullname.'</td>';
                else $output_html .=  '<td class="author_name">'.$this->lang->line('Me').'</td>';
                $output_html .=  '<td class="save_time">'.$ncontent->ncontent_createtime.'</td>';
                $output_html .=  '<td  class="evaluation_field"  style="position: relative">';
                if($ncontent->user_type_id=='1')
                {
                    $output_html .= '<a class="op_delete_btn btn" data-contentid="'.$ncontent->ncontent_id.'" onclick="content_delete(this)" onmouseover="hover_delete(this)" onmouseout="out_delete(this)"></a>';
                    $output_html .= '<a class="op_download_btn btn" download href="'.base_url('middle/').$ncontent->ncontent_file.'" onmouseover="hover_download(this)" onmouseout="out_download(this)"></a>';
                }else{

                    for($i = 0;$i<4;$i++)
                    {
                        $output_html .= '<a hef="#" class="op-level-btn ';
                        if((string)$i===$ncontent->ncontent_qualify) $output_html .= 'op-level-btn-sel'.$i.' "';
                        else $output_html .= 'op-level-btn'.$i.' "';
                        $output_html .= 'onclick="changeContentEval('.$ncontent->ncontent_user_id.','.$ncontent->ncontent_id.','.$i.')" </a>';

                    }
                }
                $output_html .=  '</td>';
                $output_html .=  '</tr>';
            endforeach;
        }else{
            foreach ($ncontents as $ncontent):

                $includeStr = $ncontent->ncontent_belong_title;

                if(strlen($includeStr)>20){
                    $firstStr = substr($includeStr,0,20);
                    $firstStr = $firstStr.'...';
                }else $firstStr = $includeStr;

                $output_html .='<tr>';
                $output_html .= '<td class="notename_filed_note"> <a href="#" class="content_title_link" onclick="showNContent(this);" data-file="'.$ncontent->ncontent_file.'">'. $ncontent->ncontent_title.' </td>';
                $output_html .= '<td style="width:25%;">'. $includeStr.'</td>';
                $output_html .= '<td style="width:9.5%;">'. $ncontent->ncontent_createtime.'</td>';
                $output_html .= '<td  class="operation_field_note">';
                $output_html .= '<a class="op_delete_note_btn btn" data-contentid="'.$ncontent->ncontent_id.'" onclick="content_delete(this)" onmouseover="hover_delete(this)" onmouseout="out_delete(this)"></a>';
                $output_html .= '<a class="op_download_note_btn btn" download href="'.base_url('middle/').$ncontent->ncontent_file.'" data-contentUrl="'.$ncontent->ncontent_file.'" onmouseover="hover_download(this)" onmouseout="out_download(this)"></a>';
                $output_html .= '</td>';
            endforeach;
        }
        return $output_html;
    }
    function changedContentEval()
    {
        $ret = array('data'=>'','status'=>'fail');
        if($_POST)
        {
            $contentId = $_POST['contentId'];
            $hegeVal = $_POST['hegeVal'];
            $userid = $_POST['userid'];
            $content_type_slug = $_POST['content_slug'];
            $arr = array('ncontent_qualify'=>$hegeVal);
            $this->ncontents_m->update($arr,$contentId);
            $arr = array('ncontent_type_slug'=>$content_type_slug,'ncontent_user_id'=>$userid);
            $ncontents = $this->ncontents_m->get_ncontents($arr);
            $ret['data'] = $this->outputContentForTeacher($ncontents,$content_type_slug);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }
    function get_NoteDetails()
    {
        $ret = array('data'=>'','status'=>'fail');
        if($_POST)
        {
            $filePath = $_POST['filePath'];
            $scriptLines = array();
            $scriptFile = fopen($filePath, "r") or die("Unable to open file!");
            while(!feof($scriptFile)) {
                $eachLine = fgets($scriptFile);
                array_push($scriptLines,$eachLine);
            }
            fclose($scriptFile);
            $ret['data'] = $this->output_note($scriptLines);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);

    }
    function output_note($scriptLines)
    {
        $output_html = '';
        foreach ($scriptLines as $scriptLine):
         $output_html .= '<p>'.$scriptLine.'</p>';
        endforeach;
        return $output_html;
    }
}
?>