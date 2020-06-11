<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coursewaresub extends Admin_Controller
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
        $this->data['menu'] = '14';
        $this->data['pageTitle'] = 'Web趣表演内容管理';
        $this->data['platformType'] = 0;

        $this->data['subwares'] = $this->subwares_m->get_sw(
            "subwares.platform_type = {$this->data['platformType']} and subwares.subware_type_id > 5"
        );
        $this->data['subware_type_names'] = $this->subwares_m->getSWTypeNames();
        $this->data['school_types'] = $this->schooltypes_m->getItems();
        $this->data['cwsets'] = $this->coursewares_m->get_cw(
            "coursewares.platform_type = {$this->data['platformType']}"
            . " and coursewares.school_type_id = 2"
        );
        $this->data["subview"] = "admin/coursewaresub/index";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        if (!$this->checkRole()) {
            $this->load->view('errors/html/access_denied.php', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function add()
    {
        $ret = array(
            'data' => '操作失败',
            'status' => 'fail'
        );
        if ($_POST) {
            ///update courseware table
            $id = $this->input->post('id');
            $title = $this->input->post('title');
            $platformType = $this->input->post('platform_type');
            $subwareTypeId = $this->input->post('subware_type_id');
            $coursewareId = $this->input->post('courseware_id');
            $fileType = $this->input->post('fileType');

            $fileSlug = $this->subwaretypes_m->get($subwareTypeId);
            ///getSWTypeSlugFromName
            $fileSlug = $fileSlug->subware_type_slug;
            $add_sw_file_path = '';
            if ($_FILES["file_name"]["name"] != '') {
                $fileId = $this->subwares_m->get_new_id()[0]->fileId + 1;
                $filename = $coursewareId . '_' . $fileSlug . $fileId . '.' . $fileType;
                if ($id != 0) {
                    $fileId = $this->subwares_m->get_where(array('subware_id' => $id))[0]->subware_file;
                    if ($fileId) {
                        $fileId = explode('/', $fileId);
                        $fileId = $fileId[count($fileId) - 1];
                        $filename = $fileId;
                    } else {
                        $filename = $coursewareId . '_' . $fileSlug . $id . '.' . $fileType;
                    }
                }
                $uploadPath = 'teachingdemo';
                $dirPath = 'uploads/' . $uploadPath;
                $config['file_name'] = $filename;
                if (!is_dir($dirPath)) {
                    mkdir($dirPath, 0755, true);
                } else if (file_exists($dirPath . '/' . $config['file_name'])) {
                    unlink($dirPath . '/' . $config['file_name']);
                }
                $config['upload_path'] = './uploads/' . $uploadPath . '/';
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);

                //***************************file uploading**************************//
                if ($this->upload->do_upload('file_name')) {
                    $file = $this->upload->data()['full_path'];
                    $add_sw_file_path = $dirPath . '/' . $config['file_name'];
                } else {///show error message
                    $error = array('error' => $this->upload->display_errors());
                    $ret['data'] = $error;
                    echo json_encode($ret);
                    return;
                }
                //***************************file uploading**************************//
            }
            $param = array(
                'title' => $title,
                'platform_type' => $platformType,
                'subware_type_id' => $subwareTypeId,
                'courseware_id' => $coursewareId,
                'view_num' => 0,
            );
            if ($add_sw_file_path) $param['subware_file'] = $add_sw_file_path;

            if ($subwareTypeId == '6') {
                $oldSW = $this->subwares_m->get_where(array(
                    'courseware_id' => $coursewareId,
                    'platform_type' => $platformType,
                    'subware_type_id' => $subwareTypeId,
                ));
                if ($oldSW != null) $id = $oldSW[0]->subware_id;
            }

            if ($id == 0) {
                $param['publish'] = 1;
                $this->data['swsets'] = $this->subwares_m->add($param);
            } else {
                $this->data['swsets'] = $this->subwares_m->edit($param, $id);
            }
            $ret['data'] = '操作成功';//$this->output_content($this->data['swsets']);
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
            $delete_sw_id = $_POST['delete_sw_id'];

            $oldSubware = $this->subwares_m->get_single(array('subware_id' => $delete_sw_id));
            $oldSWPath = $oldSubware->subware_file;
            $this->rrmdir($oldSWPath);

            $this->data['swsets'] = $this->subwares_m->delete($delete_sw_id);

            $ret['data'] = '操作成功';//$this->output_content($this->data['swsets']);

            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function publish()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $publish_sw_id = $_POST['publish_sw_id'];
            $publish_sw_st = $_POST['publish_state'];
            $this->data['swsets'] = $this->subwares_m->publish($publish_sw_id, $publish_sw_st);
            $ret['data'] = '操作成功';//$this->output_content($this->data['swsets']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_content($swsets)
    {
        $output = '';
        foreach ($swsets as $sw):
            $pub = '';
            if ($sw->publish == '1') $pub = $this->lang->line('UnPublish');
            else   $pub = $this->lang->line('Publish');
            $output .= '<tr>';
            $output .= '<td align="center">' . $sw->courseware_num . '</td>';
            $output .= '<td align="center">' . $sw->subware_type_name . '</td>';
            $output .= '<td align="center">' . $sw->course_name . '</td>';
            $output .= '<td align="center">' . $sw->unit_type_name . '</td>';
            $output .= '<td align="center">' . $sw->courseware_name . '</td>';
            $output .= '<td align="center">' . $sw->school_type_name . '</td>';
            $output .= '<td align="center">';
            $output .= '<button class="btn btn-sm btn-success" onclick = "edit_sw(this);" sw_id = ' . $sw->subware_id . '>' . $this->lang->line('Modify') . '</button>';
            $output .= '<button class="btn btn-sm btn-warning" onclick = "delete_sw(this);" sw_id = ' . $sw->subware_id . '>' . $this->lang->line('Delete') . '</button>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-danger" onclick = "publish_sw(this);" sw_id = ' . $sw->subware_id . '>' . $pub . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
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
