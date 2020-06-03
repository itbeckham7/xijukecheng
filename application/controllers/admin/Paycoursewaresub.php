<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paycoursewaresub extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->load->model("subwares_m");
        $this->load->model("coursewares_m");
        $this->load->model("subwaretypes_m");
        $this->load->model("schooltypes_m");
        $this->load->model("users_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");

    }

    public function index()
    {
        $this->data['menu'] = '15';
        $this->data['pageTitle'] = 'APP趣表演内容管理';
        $this->data['platformType'] = 1;

        $this->data['subwares'] = $this->subwares_m->get_sw(
            "subwares.platform_type = {$this->data['platformType']} and subwares.subware_type_id > 5"
        );
        $this->data['subware_type_names'] = $this->subwares_m->getSWTypeNames();
        $this->data['school_types'] = $this->schooltypes_m->getItems();
        $this->data['cwsets'] = $this->coursewares_m->get_cw(
            "coursewares.platform_type = {$this->data['platformType']}"
            ." and coursewares.school_type_id = 2"
        );
        $this->data["subview"] = "admin/paycoursewaresub/index";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        if (!$this->checkRole()) {
            $this->load->view('errors/html/access_denied.php', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    ////directory manager and file manager
    public function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
                if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
            rmdir($dir);
        } else if (file_exists($dir)) unlink($dir);
    }

    // Function to Copy folders and files
    public function rcopy($src, $dst)
    {
        if (file_exists($dst))
            $this->rrmdir($dst);
        if (is_dir($src)) {
            mkdir($dst);
            $files = scandir($src);
            foreach ($files as $file)
                if ($file != "." && $file != "..") {
                    $this->rcopy("$src/$file", "$dst/$file");

                }

        } else if (file_exists($src)) {
            copy($src, $dst);
        }
    }

    function checkRole()
    {

        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData[0]->unit_sub_st;
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }

}
