<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Contents extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $language = 'chinese';
        $this->load->model("contents_m");
        $this->load->model("users_m");
        //$language = $this->session->userdata('lang');
        $this->lang->load('community', $language);
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
    }

    public function index()
    {
        $this->data['menu'] = '31';
        $this->data['pageTitle'] = '内容管理';
        $this->data['contents'] = $this->contents_m->get_contents();
        $this->data["subview"] = "admin/contents/index";
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
            $contentId = $_POST['content_id'];
            $this->contents_m->delete($contentId);
            $this->data['contents'] = $this->contents_m->get_contents();
            $ret['data'] = $this->output_content($this->data['contents']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_content($contents)
    {
        $output = '';
        $deleteStr = $this->lang->line('Delete');
        foreach ($contents as $content):
            $output .= '<tr>';
            $output .= '<td>' . $content->content_id . '</td>';
            $output .= '<td><a hcref="#" style="text-decoration: none;" onclick="show_work_detail(this);">' . $content->content_title . '</a></td>';
            $output .= '<td>' . $content->content_type_name . '</td>';
            $output .= '<td>' . $content->username . '</td>';
            $output .= '<td>' . $content->school_name . '</td>';
            $output .= '<td>' . $content->share_time . '</td>';
            $output .= '<td>' . $content->view_num . '</td>';
            $output .= '<td>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-warning" onclick = "delete_content(this);" content_id = ' . $content->content_id . '>' . $deleteStr . '</button>';
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
            $communityInfo = $permisData[2]->content_st;
            if ($communityInfo == '1') return true;
            else return false;
        }
        return false;
    }

}

?>