<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Comments extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $language = 'chinese';
        $this->load->model("comments_m");
        $this->load->model("users_m");
        //$language = $this->session->userdata('lang');
        $this->lang->load('community', $language);
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
    }

    public function index()
    {
        $this->data['menu'] = '32';
        $this->data['pageTitle'] = '评论管理';
        $this->data['comments'] = $this->comments_m->get_comments();
        $this->data["subview"] = "admin/comments/index";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        if (!$this->checkRole()) {

            $this->load->view('errors/html/access_denied.php', $this->data);

        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function delete()
    {

        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $commentId = $_POST['comment_id'];
            $this->comments_m->delete($commentId);
            $this->data['comments'] = $this->comments_m->get_comments();
            $ret['data'] = $this->output_content($this->data['comments']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_content($comments)
    {
        $output = '';
        $deleteStr = $this->lang->line('Delete');
        foreach ($comments as $comment):
            $output .= '<tr>';
            $output .= '<td>' . $comment->comment_id . '</td>';
            $output .= '<td>' . $comment->content_title . '</td>';
            $output .= '<td>' . $comment->comment_desc . '</td>';
            $output .= '<td>';
            $output .= $comment->username;
            $output .= '<span style="color: #f90;">' . $comment->fullname . '</span>';
            $output .= '</td>';
            $output .= '<td>' . $comment->create_time . '</td>';
            $output .= '<td>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-warning" onclick = "delete_comment(this);" comment_id = ' . $comment->comment_id . '>' . $deleteStr . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    function checkRole()
    {

        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permisData = json_decode($permission);
            $communityInfo = $permisData[2]->comment_st;
            if ($communityInfo == '1') return true;
            else return false;
        }
        return false;
    }

}

?>