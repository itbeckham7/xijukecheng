<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Work extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('frontend', $language);
        $this->load->model('contents_m');
        $this->load->model('users_m');
        $this->load->model('signin_m');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index()
    {
        if (!$this->signin_m->loggedin()) {
            redirect(base_url('signin/index'));
            return;
        }
        $this->data["subview"] = "middle/work/index";
        $this->load->view('middle/_layout_main', $this->data);
    }

    public function view($content_id)////$id is content id
    {
        ///we have to increase view num to contents.
        $this->contents_m->update_contents_view_num($content_id);
        ///get user id of content from content_id
        $contentInfo = $this->contents_m->get_single(array('content_id' => $content_id));

        if ($contentInfo == NULL) {
            $this->data['heading'] = $this->lang->line('PageNotFound');
            $this->data['message'] = $this->lang->line('WorkNotExist');
            $this->load->view('errors/html/error_404.php', $this->data);
            return;
        };

        $content_user_id = $contentInfo->content_user_id;
        $content_type_id = $contentInfo->content_type_id;
        $courseware_id = $contentInfo->courseware_id;

        $this->data['user_id'] = $content_user_id;///current user id of content;
        $this->data['content_id'] = $content_id;
        $this->data['content_type_id'] = $content_type_id;
        $this->data['content_title'] = $contentInfo->content_title;
        $this->data['courseware_id'] = $courseware_id;
        $this->data['fullname'] = $this->users_m->getFullNameFromUserId($content_user_id);///current student name;

        if ($content_type_id == '1') {///script work

            $script_html = $this->get_scriptDetails($contentInfo->file_name);
            $this->data['scriptText'] = $this->script_img_replace($script_html, $courseware_id);
            $this->data["subview"] = "middle/work/content";

        } else if ($content_type_id == '5') {//head mask work

            $this->data['headImagePath'] = $contentInfo->file_name;
            $this->data["subview"] = "middle/work/content";

        } else if ($content_type_id == '6') {////shooting

            $this->data['videoPath'] = $contentInfo->file_name;
            $this->data["subview"] = "middle/work/content_shooting";
        } else {///dubbing work

            $this->data['wavPath'] = $contentInfo->file_name;
            $this->data["bgPath"] = $contentInfo->bg_path;
            $this->data["subview"] = "middle/work/content_dubbing";
        }
        $this->load->view('middle/_layout_main', $this->data);

    }

    public function script($user_id)
    {
        if ($this->signin_m->loggedin()) {
            $this->data['user_id'] = $user_id;///current student id;
            $this->data['fullname'] = $this->users_m->getFullNameFromUserId($user_id);///current student name;
            $this->data['contents'] = $this->contents_m->get_work($user_id, '1');
            $this->data['content_type_id'] = '1';
            $this->data["subview"] = "middle/work/view";
            $this->data['menu_img_path'] = base_url('assets/images/frontend/studentwork/scriptwork.png');

            $this->load->view('middle/_layout_main', $this->data);
        } else {
            redirect(base_url() . 'signin/index');
        }
    }

    public function dubbing($user_id)
    {
        if ($this->signin_m->loggedin()) {
            $this->data['user_id'] = $user_id;
            $this->data['fullname'] = $this->users_m->getFullNameFromUserId($user_id);///current student name;
            $this->data['contents'] = $this->contents_m->get_work($user_id, '2');
            $this->data['content_type_id'] = '2';
            $this->data["subview"] = "middle/work/view";
            $this->data['menu_img_path'] = base_url('assets/images/frontend/studentwork/dubbingwork.png');
            $this->load->view('middle/_layout_main', $this->data);
        } else {
            redirect(base_url() . 'signin/index');
        }
    }

    public function head($user_id)
    {
        if ($this->signin_m->loggedin()) {
            $this->data['user_id'] = $user_id;
            $this->data['fullname'] = $this->users_m->getFullNameFromUserId($user_id);///current student name;
            $this->data['contents'] = $this->contents_m->get_work($user_id, '5');
            $this->data['content_type_id'] = '5';
            $this->data['menu_img_path'] = base_url('assets/images/frontend/studentwork/headwork.png');
            $this->data["subview"] = "middle/work/view";
            $this->load->view('middle/_layout_main', $this->data);
        } else {
            redirect(base_url() . 'signin/index');
        }

    }

    public function shooting($user_id)
    {
        if ($this->signin_m->loggedin()) {
            $this->data['user_id'] = $user_id;
            $this->data['fullname'] = $this->users_m->getFullNameFromUserId($user_id);///current student name;
            $this->data['contents'] = $this->contents_m->get_work($user_id, '6');
            $this->data['content_type_id'] = '6';
            $this->data['menu_img_path'] = base_url('assets/images/frontend/studentwork/shootingwork.png');
            $this->data["subview"] = "middle/work/view";
            $this->load->view('middle/_layout_main', $this->data);
        } else {
            redirect(base_url() . 'signin/index');
        }
    }

    public function student()///this function is for teacher of front end
    {
        if ($this->signin_m->loggedin()) {

            $teacherid = $this->session->userdata("loginuserID");
            $user_type = $this->session->userdata("user_type");
            if ($user_type != '1') return;

            $techerInfo = $this->users_m->get_single_user($teacherid);

            $this->data['classlists'] = $this->getClassList($techerInfo->class);
            $this->data["subview"] = "middle/work/student";
            $this->load->view('middle/_layout_main', $this->data);
        } else {
            redirect(base_url() . 'signin/index');
        }
    }

    public function getClassList($classListStr)///this function will be used for teachers
    {
        $ret = array();
        if ($classListStr != '') {
            $classStr = $this->lang->line('Class');
            $nianStr = $this->lang->line('Nian');
            $gradeStr = $this->lang->line('Grade');
            $classArr = json_decode($classListStr, true);
            foreach ($classArr as $class_info):
                $classNo = $class_info['class'];
                $gradeNo = $class_info['grade'];
                $realGradeStr = $this->lang->line($gradeNo - 1);
                $realClassStr = $this->lang->line($classNo - 1);
                $fullClassName = $realGradeStr . $nianStr . $realClassStr . $classStr;
                $attrClassName = $realGradeStr . $gradeStr . $realClassStr . $classStr;
                $tempObj = new stdClass();
                $tempObj->attr_name = $attrClassName;
                $tempObj->class_name = $fullClassName;
                $tempObj->image_name = $gradeNo . '-' . $classNo;
                array_push($ret, $tempObj);
            endforeach;
        }
        return $ret;

    }

    public function delete_content()
    {
        if ($this->signin_m->loggedin()) {
            $ret = array(
                'data' => '',
                'status' => 'fail'
            );
            if ($_POST) {
                $usingStatus = true;///if this filed is true student is using now page and false then student is using student page
                $contentId = $_POST['content_id'];
                $content_type_Id = $_POST['content_type_id'];
                $student_Id = $_POST['student_id'];
                $user_id = $this->session->userdata('loginuserID');
                $this->contents_m->delete($contentId);
                $this->data['contents'] = $this->contents_m->get_work($student_Id, $content_type_Id);
                if ($user_id != $student_Id) $usingStatus = false;
//              $ret['data'] = $this->output_content($this->data['contents'],$usingStatus);
                $ret['data'] = $this->data['contents'];
                $ret['status'] = 'success';
            }
            echo json_encode($ret);
        } else {
            redirect(base_url() . 'signin/index');
        }

    }

    public function update_content()
    {
        if ($this->signin_m->loggedin()) {
            $ret = array(
                'data' => '',
                'status' => 'fail'
            );
            if ($_POST) {
                $usingStatus = true;///if this filed is true student is using now page and false then student is using student page
                $contentId = $_POST['content_id'];
                $content_type_Id = $_POST['content_type_id'];
                $student_Id = $_POST['student_id'];
                $user_id = $this->session->userdata('loginuserID');///this filed is for student of user id

                $arr = array(
                    'local' => $_POST['content_local'],
                    'public' => $_POST['content_cloud']
                );
                $this->contents_m->update($arr, $contentId);
                $this->data['contents'] = $this->contents_m->get_work($student_Id, $content_type_Id);

                if ($user_id != $student_Id) $usingStatus = false;

                //$ret['data'] = $this->output_content($this->data['contents'],$usingStatus);
                $ret['data'] = $this->data['contents'];
                $ret['status'] = 'success';
            }
            echo json_encode($ret);
        } else {
            redirect(base_url() . 'signin/index');
        }
    }

    public function share_content()
    {
        if ($this->signin_m->loggedin()) {
            $ret = array(
                'data' => '',
                'status' => 'fail'
            );
            if ($_POST) {
                $usingStatus = true;///if this filed is true student is using now page and false then student is using student page
                $contentId = $_POST['content_id'];
                $content_type_Id = $_POST['content_type_id'];

                $student_Id = $_POST['student_id'];
                $user_id = $this->session->userdata('loginuserID');///this filed is for student of user id

                $arr = array(
                    'publish' => '1',
                );
                $this->contents_m->update($arr, $contentId);
                $this->data['contents'] = $this->contents_m->get_work($user_id, $content_type_Id);
                if ($user_id != $student_Id) $usingStatus = false;
//              $ret['data'] = $this->output_content($this->data['contents'],$usingStatus);
                $ret['data'] = $this->data['contents'];
                $ret['status'] = 'success';
            }
            echo json_encode($ret);
        } else {
            redirect(base_url() . 'signin/index');
        }
    }

    public function uploadJob()
    {
        if ($this->signin_m->loggedin()) {
            $ret = array(
                'data' => '',
                'status' => 'fail'
            );
            if ($_POST) {
                $usingStatus = true;///if this filed is true student is using now page and false then student is using student page
                $contentId = $_POST['content_id'];
                $content_type_Id = $_POST['content_type_id'];

                $student_Id = $_POST['student_id'];
                $user_id = $this->session->userdata('loginuserID');///this filed is for student of user id
                $arr = array(
                    'public' => '1'
                );
                $this->contents_m->update($arr, $contentId);
                $this->data['contents'] = $this->contents_m->get_work($student_Id, $content_type_Id);

                if ($user_id != $student_Id) $usingStatus = false;

                //$ret['data'] = $this->output_content($this->data['contents'],$usingStatus);
                $ret['data'] = $this->data['contents'];
                $ret['status'] = 'success';
            }
            echo json_encode($ret);
        } else {
            redirect(base_url() . 'signin/index');
        }
    }

    public function output_content($contents, $usingStatus)
    {
        $output = '';
        $recordcount = 0;
        foreach ($contents as $content):

            if ($usingStatus) {///current user is student

                if ($recordcount > 7) $output .= '<tr style="display: none">';
                else $output .= '<tr>';
                $output .= '<td style="width:6%;text-align: center;">';
                if ($content->local == '1') $output .= '<img class = "mark_img" src="' . base_url('assets/images/frontend/mywork/localmark.png') . '" onmouseover="hiddenImageMark(this)" onmouseleave="showImageMark(this)">';
                $output .= '</td>';

                $output .= '<td style="width:6%;"  >';
                if ($content->public == '1')
                    $output .= '<img class = "mark_img" src="' . base_url('assets/images/frontend/mywork/cloudmark.png') . '" onmouseover="hiddenImageMarkCloud(this)" onmouseleave="showImageMarkCloud(this)">';
                $output .= '</td>';

                $output .= '<td style="width:64%">';
                $output .= '<div class = "content_title" style="background: url(' . base_url('assets/images/frontend/mywork/item_bg.png') . ') no-repeat; background-size: 100% 100%;">';
                $output .= '<a href="' . base_url('middle/work/view') . $content->content_id . '">';
                $output .= $content->content_title;
                $output .= '</a>';
                $output .= '</div>';
                $output .= '</td>';

                $output .= '<td style="width: 15%;text-align: right;">';
                $output .= '<a href="#" onclick="uploadWork(this)"' . 'content_id = "' . $content->content_id . '">';
                if ($content->public == '0')
                    $output .= '<img class = "mark_img upload_image" src="' . base_url('assets/images/frontend/mywork/upload.png') . '" onmouseover="changeUploadOver(this)"  onmouseout ="changeUploadOut(this)">';
                $output .= '</a></td>';

                $output .= '<td style="width:6%;text-align: right">';
                $output .= '<a href="#" onclick="deleteContentItem(this)"' .
                    'content_id = "' . $content->content_id . '" ' .
                    'content_local = "' . $content->local . '" ' .
                    'content_cloud = "' . $content->public . '">';
                $output .= '<img class = "mark_img" src="' . base_url('assets/images/frontend/mywork/delete.png') . '" onmouseover="changeDeleteImgOver(this)" onmouseout= "changeDeleteImgOut(this)">';
                $output .= '</a></td>';

                $output .= '<td style="width:6%">';
                $output .= '<a href="#" onclick="shareContentModal(this)"' . 'content_id = "' . $content->content_id . '">';
                $output .= '<img class="mark_img" src="' . base_url('assets/images/frontend/mywork/share.png') . '"  onmouseover="changeShareImgOver(this)" onmouseout= "changeShareImgOut(this)">';
                $output .= '</a></td>';
                $output .= '</tr>';
                $recordcount++;
            } else {///current user is student
                if ($content->public == '1')///show only published contents
                {
                    $output .= '<tr>';
                    $output .= '<td style="width:6%" >';
                    $output .= '<img class = "mark_img" src="' . base_url('assets/images/frontend/mywork/cloudmark.png') . '" onmouseover="hiddenImageMarkCloud(this)" onmouseleave="showImageMarkCloud(this)">';
                    $output .= '</td>';
                    $output .= '<td style="width:59%">';
                    $output .= '<div class = "content_title" style="background: url(' . base_url('assets/images/frontend/mywork/item_bg.png') . ') no-repeat; background-size: 100% 100%;">';
                    $output .= '<a href="' . base_url('middle/work/view') . $content->content_id . '">';
                    $output .= $content->content_title;
                    $output .= '</a>';
                    $output .= '</div>';
                    $output .= '</td>';
                    $output .= '<td style="width:30%;text-align: center" >';
                    $output .= '<a href="#" onclick="deleteContentItem(this)"' .
                        'content_id = "' . $content->content_id . '" ' .
                        'content_local = "' . $content->local . '" ' .
                        'content_cloud = "' . $content->public . '">';
                    $output .= '<img class = "mark_img" src="' . base_url('assets/images/frontend/mywork/delete.png') . '" onmouseover="changeDeleteImgOver(this)" onmouseout= "changeDeleteImgOut(this)">';
                    $output .= '</a></td>';
                    $output .= '<td style="width:7%"></td>';
                    $output .= '</tr>';
                }
            }
        endforeach;
        return $output;
    }

    public function getMembers()
    {
        $ret = array(
            'data' => '',
            'totalPageCount' => '0',
            'status' => 'fail'
        );
        if ($_POST) {
            if ($this->session->userdata()) {
                $teacherid = $this->session->userdata("loginuserID");
                $users = array();
                $className = $_POST['class_name'];
                $content_type_id = $_POST['content_type_id'];

                $school_id = $this->users_m->getSchoolIdFromUserId($teacherid);
                if ($className != '') {
                    $users = $this->users_m->get_where(array('school_id' => $school_id, 'class' => $className));
                }
                $ret['data'] = $this->output_members_custom($users, $content_type_id);
                $ret['totalPageCount'] = $this->data['totalPageNum'];
                $ret['status'] = 'success';
                echo json_encode($ret);
            } else {
                redirect(base_url() . 'signin/index');
            }
        }
    }

    public function output_members($users, $content_type_id)
    {
        $user_id = $this->session->userdata('loginuserID');///this filed is for student of user id
        $studentURL = '';
        if ($content_type_id == '1') $studentURL = 'work/script/';
        if ($content_type_id == '2') $studentURL = 'work/dubbing/';
        if ($content_type_id == '3') $studentURL = 'work/head/';
        if ($content_type_id == '4') $studentURL = 'work/shooting/';

        $output = '';
        $output .= '<tr>';
        $output .= '<td><a href="' . base_url('middle/') . $studentURL . $user_id . '">' . $this->lang->line('Me');
        $output .= '</a>';
        $output .= '</td>';
        $output .= '</tr>';

        $serialNo = 0;
        foreach ($users as $user):
            if ($this->users_m->hasContents($user->user_id, $content_type_id)) {
                $serialNo++;
                $output .= '<tr>';
                $output .= '<td>&nbsp' . $serialNo . '.&nbsp</td>';
                $output .= '<td><a href="' . base_url('middle/') . $studentURL . $user->user_id . '">' . $user->fullname . '</a></td>';
                $output .= '</tr>';
            }
        endforeach;
        return $output;
    }

    public function output_members_custom($users, $content_type_id)
    {
        $user_id = $this->session->userdata('loginuserID');///this filed is for student of user id
        $studentURL = '';
        if ($content_type_id == '1') $studentURL = 'work/script/';
        if ($content_type_id == '2') $studentURL = 'work/dubbing/';
        if ($content_type_id == '3') $studentURL = 'work/head/';
        if ($content_type_id == '4') $studentURL = 'work/shooting/';

        $output = '';
        $serialNo = 0;
        $countPerPage = 16;
        $pageNo = 0;

        $output .= '<div class="left-block-member member_list_page0" style="display:none;position: absolute">';
        $output .= '<div class="member_item_wrapper">';
        $output .= '<a href="' . base_url('middle/') . $studentURL . $user_id . '" class="member_item">'
            . '&nbsp&nbsp' . $this->lang->line('Me') . '</a>';
        $output .= '</div>';
        foreach ($users as $user):
            //if($this->users_m->hasContents($user->user_id,$content_type_id)){
            $serialNo++;
            $extraCounts = $serialNo % $countPerPage;
            $onePageState = $serialNo % ($countPerPage / 2);

            $pageNo = ($serialNo - $extraCounts) / $countPerPage;
            $symbolClassStr = "member_list_page" . $pageNo;
            if ($extraCounts == 0) {

                if ($pageNo != 0) {///page is more than one
                    $output .= '</div>';
                }
                $output .= '<div class="left-block-member ' . $symbolClassStr . '" '
                    . 'style="display:none;position: absolute">';
                $output .= '<div class="member_item_wrapper">';
                $output .= '<a href="' . base_url('middle/') . $studentURL . $user->user_id . '" '
                    . 'class="member_item" >' . ($serialNo + 1) . '&nbsp' . $user->fullname . '</a>';
                $output .= '</div>';
            } else if ($onePageState == 0) {
                $output .= '</div><div class="right-block-member ' . $symbolClassStr . '" '
                    . 'style="display:none;position: absolute">';
                $output .= '<div class="member_item_wrapper">';
                $output .= '<a href="' . base_url('middle/') . $studentURL . $user->user_id . '" '
                    . 'class="member_item">' . ($serialNo + 1) . '&nbsp' . $user->fullname . '</a>';
                $output .= '</div>';
            } else {
                $output .= '<div class="member_item_wrapper">';
                $output .= '<a href="' . base_url('middle/') . $studentURL . $user->user_id . '" '
                    . 'class="member_item">' . ($serialNo + 1) . '&nbsp' . $user->fullname . '</a>';
                $output .= '</div>';
            }
            //}
        endforeach;
        $this->data['totalPageNum'] = $pageNo;
        $output .= '</div>';
        return $output;
    }

    public function get_scriptDetails($filePath)
    {
        $scriptLines = '';
        if (!file_exists($filePath)) {
            return $scriptLines;
        } else {
            $scriptFile = fopen($filePath, "r");
            $scriptLines = fread($scriptFile, filesize($filePath));
        }
        return $scriptLines;
    }

    public function share_work()
    {
        if ($this->signin_m->loggedin()) {
            $ret = array(
                'data' => '',
                'status' => 'fail'
            );
            if ($_POST) {
                $usingStatus = true;///if this filed is true student is using now page and false then student is using student page
                $contentId = $_POST['content_id'];
                $arr = array(
                    'publish' => '1',
                );
                $returnId = $this->contents_m->update_contents($arr, $contentId);
                $ret['data'] = $returnId;
                $ret['status'] = 'success';
            }
            echo json_encode($ret);
        } else {
            redirect(base_url() . 'signin/index');
        }
    }

    private function script_img_replace($html, $courseware_id)
    {
        $path = base_url() . 'uploads/courseware/' . $courseware_id . '/script/images/characters';
        $ret = str_replace("images/characters", $path, $html);
        return $ret;
    }
}

?>