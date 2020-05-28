<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Admins extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $language = 'chinese';
        $this->load->model("admins_m");
        $this->load->model("users_m");
        //$language = $this->session->userdata('lang');
        $this->lang->load('accounts', $language);
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
    }

    public function index()
    {
        $this->data['menu'] = '61';
        $this->data['pageTitle'] = '角色管理';
        $this->data['admins'] = $this->admins_m->get_admin();
        $this->data["subview"] = "admin/admins/index";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function add()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $fullname = $_POST['add_admin_fullname'];
            $password = $_POST['add_admin_password'];
            $label = $_POST['add_admin_label'];
            $arr = array(
                'admin_name' => $fullname,
                'admin_pass' => $this->admins_m->hash($password),
                'admin_label' => $label
            );
            $midData = $this->admins_m->add($arr);
            $ret['data'] = $this->output_content($midData);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function edit()
    {

        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $admin_id = $_POST['admin_id'];
            $admin_label = $_POST['edit_admin_label'];
            $admin_pass = $_POST['edit_admin_password'];

            $arr = array(
                'admin_pass' => $this->admins_m->hash($admin_pass),///mush encrypt this text
                'admin_label' => $admin_label
            );
            $this->data['admins'] = $this->admins_m->edit($arr, $admin_id);
            $ret['data'] = $this->output_content($this->data['admins']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);

    }

    public function delete()
    {

        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $admin_id = $_POST['admin_id'];
            $this->admins_m->delete($admin_id);
            $this->data['admins'] = $this->admins_m->get_admin();
            $ret['data'] = $this->output_content($this->data['admins']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function assign()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $admin_id = $_POST['admin_id'];
            $role_arr = $_POST['role_info'];
            $arr = array(
                'permission' => json_encode($role_arr)
            );
            $this->data['admins'] = $this->admins_m->edit($arr, $admin_id);
            $ret['data'] = $this->output_content($this->data['admins']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_content($admins)
    {
        $modifyStr = $this->lang->line('Modify');
        $deleteStr = $this->lang->line('Delete');
        $assignStr = $this->lang->line('AssignMenu');
        $output = '';
        foreach ($admins as $admin):

            $output .= '<tr>';
            $output .= '<td>' . $admin->admin_id . '</td>';
            $output .= '<td>' . $admin->admin_name . '</td>';
            $output .= '<td hidden>' . $admin->admin_pass . '</td>';
            $output .= '<td>' . $admin->admin_label . '</td>';
            $output .= '<td hidden>' . $admin->permission . '</td>';
            $output .= '<td>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-success" onclick = "edit_admin(this);" admin_id = ' . $admin->admin_id . '>' . $modifyStr . '</button>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-warning" onclick = "delete_admin(this);" admin_id = ' . $admin->admin_id . '>' . $deleteStr . '</button>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-danger" onclick = "assign_admin(this);" admin_id = ' . $admin->admin_id . '>' . $assignStr . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }
}

?>