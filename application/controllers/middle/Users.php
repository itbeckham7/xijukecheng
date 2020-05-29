<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('frontend', $language);
        $this->load->model('contents_m');
        $this->load->model('comments_m');
        $this->load->model('schools_m');
        $this->load->model('users_m');
        $this->load->model('signin_m');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function profile($user_id)
    {
        if ($this->signin_m->loggedin()) {///if user logged in the the site =>
            $this->data['user_id'] = $user_id;///current student id;
            $loggedIn_user_id = $this->session->userdata('loginuserID');
            $user_type = $this->session->userdata('user_type');
            if ($loggedIn_user_id == $user_id) {
                if ($user_type == 1) {///*********************************current user is teacher
                    $teacherInfo = $this->users_m->get_single_user($user_id);
                    $this->data['teacher'] = $teacherInfo;
                    $this->data['totalclasslist'] = $this->convertClassArrToHtml($teacherInfo->class_arr);
                    $this->data['teacherclasslist'] = $teacherInfo->class;
                    $this->data['sharedLists'] = $this->contents_m->get_where(array('content_user_id' => $user_id, 'publish' => '1'));
                    $this->data['commentedLists'] = $this->comments_m->get_where_comments(array('comment_user_id' => $user_id));

                    $this->data["subview"] = "middle/users/teacher";
                    $this->load->view('middle/_layout_main', $this->data);
                } else if(true){///********************************************current user is student
                    $studentInfo = $this->users_m->get_single_user($user_id);
                    if(!$studentInfo->class_arr) $studentInfo->class_arr = '[]';
                    $this->data['student'] = $studentInfo;
                    $this->data['sharedLists'] = $this->contents_m->get_where(array('content_user_id' => $user_id, 'publish' => '1'));
                    $this->data['commentedLists'] = $this->comments_m->get_where_comments(array('comment_user_id' => $user_id));
                    $this->data["subview"] = "middle/users/student";
                    $this->load->view('middle/_layout_main', $this->data);
                } else {
                    $studentInfo = $this->users_m->get_single_user($user_id); /// current user is weixin
                    $this->data['student'] = $studentInfo;
                    $this->data['paidLists'] = $this->payhistory_m->getItemsFromUser($user_id);
                    $this->data["subview"] = "middle/users/weixin";
                    $this->load->view('_layout_main', $this->data);
                }
            } else {//////*********************************************current user is logged in, but other user
                return;
                $userInfo = $this->users_m->get_single_user($user_id);
                $this->data['userInfo'] = $userInfo;
                $this->data['sharedLists'] = $this->contents_m->get_where(array('content_user_id' => $user_id, 'publish' => '1'));
                $this->data['commentedLists'] = $this->comments_m->get_where_comments(array('comment_user_id' => $user_id));

                $this->data["subview"] = "middle/users/visitor";
                $this->load->view('middle/_layout_main', $this->data);
            }
        } else {//*****************************************************current user is visistor
            return;
            $userInfo = $this->users_m->get_single_user($user_id);
            $this->data['userInfo'] = $userInfo;
            $this->data['sharedLists'] = $this->contents_m->get_where(array('content_user_id' => $user_id, 'publish' => '1'));
            $this->data['commentedcontentlists'] = $this->comments_m->get_where_comments(array('comment_user_id' => $user_id));
            $this->data["subview"] = "middle/users/visitor";
            $this->load->view('middle/_layout_main', $this->data);
        }
    }

    public function update_teacher_personal()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = array(
                'fullname' => $_POST['user_fullname'],
                'nickname' => $_POST['user_nickname'],
                'sex' => $_POST['user_sex']
            );
            $this->users_m->update_user($arr, $_POST['user_id']);
            $ret['data'] = $this->users_m->get_single_user($_POST['user_id']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_teacher_class()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = array(
                'class' => ''
            );
            if (isset($_POST['class_arr'])) {
                $arr['class'] = json_encode($_POST['class_arr']);
            }
            $this->users_m->update_user($arr, $_POST['user_id']);
            $ret['data'] = $this->users_m->get_single_user($_POST['user_id']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_password()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $realOldPass = $this->users_m->hash($_POST['old_pass']);
            $realNewPass = $this->users_m->hash($_POST['new_pass']);

            $arr = array(
                'user_id' => $_POST['user_id'],
                'password' => $realOldPass
            );
            ///at first check of fair(user_id,password)
            $retRecord = $this->users_m->get_where($arr);
            if ($retRecord == null) {
                $ret['status'] = 'fail';
            } else {
                $new_arr = array(
                    'password' => $realNewPass
                );
                $this->users_m->update_user($new_arr, $_POST['user_id']);
                $ret['data'] = $this->users_m->get_single_user($_POST['user_id']);
                $ret['status'] = 'success';
            }
        }
        echo json_encode($ret);
    }

    public function delete_shared_content()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = array(
                'publish' => '0'
            );
            $this->contents_m->update($arr, $_POST['content_id']);
            $sharedLists = $this->contents_m->get_where(array('content_user_id' => $_POST['user_id'], 'publish' => '1'));
            $ret['data'] = $sharedLists;
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function delete_commented_content()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = array(
                'content_id' => $_POST['content_id'],
                'comment_user_id' => $_POST['user_id']
            );
            $this->comments_m->delete_content($arr);
            $commentLists = $this->comments_m->get_where_comments(array('comment_user_id' => $_POST['user_id']));
            $ret['data'] = $commentLists;
            $ret['status'] = 'success';
        }
        echo json_encode($ret);

    }

    public function update_student_person()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {

            $arr = array(
                'fullname' => $_POST['fullname'],
                'sex' => $_POST['sex'],
                'class' => $_POST['class'],
                'nickname' => $_POST['nickname'],
                'serial_no' => $_POST['serialno']
            );
            $this->users_m->update_user($arr, $_POST['user_id']);
            $ret['data'] = $this->users_m->get_single_user($_POST['user_id']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    ///this function is used in teachers profile page
    public function convertClassArrToHtml($class_jsonStr)
    {
        $output = '';
        $classStr = $this->lang->line('Class');
        $gradeStr = $this->lang->line('Grade');
        $classArr = json_decode($class_jsonStr);
        $classCount = 1;
        foreach ($classArr as $class_info):
            $gradeNo = $class_info->grade;
            $realStr = $this->lang->line($gradeNo - 1);
            for ($i = 1; $i <= $class_info->class; $i++) {

                if ($classCount % 2 == 0) {
                    $output .= '<div class="col-md-6" style="text-align: right">';
                    $realClassStr = $this->lang->line($i - 1);
                    $output .= '<div class="custom-checkbox">';
                    $output .= '<input type="checkbox" class="grade-class-list-chk" id = "' . $gradeNo . '-' . $i . '" >';
                    $output .= '<label for="' . $gradeNo . '-' . $i . '">';
                    $output .= $realStr . $gradeStr . $realClassStr . $classStr;
                    $output .= '</label>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';

                } else {
                    $output .= '<div class="row">';
                    $output .= '<div class="col-md-6" style="text-align: right">';
                    $realClassStr = $this->lang->line($i - 1);
                    $output .= '<div class="custom-checkbox">';
                    $output .= '<input type="checkbox" class="grade-class-list-chk" id = "' . $gradeNo . '-' . $i . '" >';
                    $output .= '<label for="' . $gradeNo . '-' . $i . '">';
                    $output .= $realStr . $gradeStr . $realClassStr . $classStr;
                    $output .= '</label>';
                    $output .= '</div>';
                    $output .= '</div>';

                }
                $classCount++;
            }
        endforeach;
        if (count($classArr) > 0) $output .= '</div>';
        return $output;
    }

    public function output_shared_contents($sharedLists)
    {

        $delStr = $this->lang->line('Delete');
        $output = '';
        foreach ($sharedLists as $content):
            $output .= '<tr>';
            $output .= '<td style="width:60%;text-align: center;">';
            $output .= '<a href="' . base_url() . '/' . $content->file_name . '">';
            $output .= $content->content_title;
            $output .= '</a>';
            $output .= '</td>';
            $output .= '<td style="width:40%;text-align: center;">';
            $output .= '<a href="#" content_id = ' . $content->content_id . ' onclick ="deleteSharedContentShow(this);"' . '>';
            $output .= $delStr . '</a>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function output_comment_contents($commentLists)
    {

        $delStr = $this->lang->line('Delete');
        $output = '';
        foreach ($commentLists as $content):
            $output .= '<tr>';
            $output .= '<td style="width:60%;text-align: center;">';
            $output .= '<a href="' . base_url() . '/' . $content->file_name . '">';
            $output .= $content->content_title;
            $output .= '</a>';
            $output .= '</td>';
            $output .= '<td style="width:40%;text-align:center;">';
            $output .= '<a href="#" comment_id = ' . $content->comment_id . ' onclick ="deleteCommentShowModal(this);"' . '>';
            $output .= $delStr . '</a>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }
}

?>