<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paycoursewares extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';

        $this->load->model("courses_m");
        $this->load->model("units_m");
        $this->load->model("coursewares_m");
        $this->load->model("users_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");

    }

    public function index()
    {
        $this->data['menu'] = '13';
        $this->data['pageTitle'] = 'APP课件管理';
        $this->data['coursewares'] = $this->coursewares_m->get_cw(array('platform_type' => 1));
        $this->data['courses'] = $this->courses_m->get_all_courses();
        $this->data["subview"] = "admin/paycoursewares/index";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data['courseware_content'] = $this->output_content($this->data['coursewares']);;
        if (!$this->checkRole()) {

            $this->load->view('errors/html/access_denied.php', $this->data);

        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function add()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        $config['upload_path'] = "./uploads/images";
        $config['allowed_types'] = 'bmp|gif|jpg|png';
        //$config['max_size'] = '1024*8';
        //$config['max_width']  = '300';
        //$config['max_height']  = '300';
        $this->load->library('upload', $config);

        if (isset($_FILES["add_file_name"]["name"]) && $_POST) {
            $add_cw_image_path = '';
            //image uploading
            if ($this->upload->do_upload('add_file_name')) {
                $data = $this->upload->data();
                $add_cw_image_path = 'uploads/images/' . $data["file_name"];

            }
            ///update courseware table
            $add_cw_name = $this->input->post('add_cw_name');
            $add_cw_sn = $this->input->post('add_cw_sn');
            $add_unit_type_name = $this->input->post('add_unit_type_name');
            $add_school_type_id = $this->input->post('add_school_type_id');
            $add_course_name = $this->input->post('add_course_name');
            $add_cw_type = $this->input->post('add_cw_type');
            $isFree = $this->input->post('free_option');
            $add_cw_price = $this->input->post('add_cw_price');

            $param = array(
                'cw_sn' => $add_cw_sn,
                'cw_name' => $add_cw_name,
                'unit_type_name' => $add_unit_type_name,
                'school_type_id' => $add_school_type_id,
                'course_name' => $add_course_name,
                'cw_image_path' => $add_cw_image_path,
                'free' => $isFree,
                'cw_type' => $add_cw_type,
                'price' => $add_cw_price,
            );
            log_message('info', '-- $param : ' . var_export($param, true));
            $this->data['cwsets'] = $this->coursewares_m->add($param);
            $ret['data'] = '操作成功';//$this->output_content($this->data['cwsets']);;
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
        $config['upload_path'] = "./uploads/images";
        $config['allowed_types'] = 'bmp|gif|jpg|png';
        //$config['max_size'] = '500*8';
        //$config['max_width']  = '300';
        //$config['max_height']  = '300';
        $this->load->library('upload', $config);

        if ($_POST) {

            $cw_id = $this->input->post('cw_id');
            $cw_name = $this->input->post('cw_name');
            $cw_sn = $this->input->post('cw_sn');
            $unit_type_name = $this->input->post('unit_type_name');
            $school_type_id = $this->input->post('school_type_id');
            $course_name = $this->input->post('course_name');
            $isFree = $this->input->post('free_option');
            $cw_price = $this->input->post('cw_price');
            $cw_type = $this->input->post('cw_type');
            if ($isFree == '1') $cw_price = '0.00';

            $param = array(
                'cw_id' => $cw_id,
                'cw_sn' => $cw_sn,
                'cw_name' => $cw_name,
                'unit_type_name' => $unit_type_name,
                'school_type_id' => $school_type_id,
                'course_name' => $course_name,
                'free' => $isFree,
                'cw_type' => $cw_type,
                'price' => $cw_price
            );
            log_message('info', '-- $param : ' . var_export($param, true));
            $cw_image_path = '';
            //image uploading
            if ($_FILES["file_name"]["name"] != '') {
                if ($this->upload->do_upload('file_name')) {
                    $data = $this->upload->data();
                    $cw_image_path = 'uploads/images/' . $data["file_name"];
                    $param['cw_image_path'] = $cw_image_path;

                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $ret['data'] = $error;
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                }
            } else {
                $param['cw_image_path'] = '';
            }

            $this->data['cwsets'] = $this->coursewares_m->edit($param);
            $ret['data'] = $this->output_content($this->data['cwsets']);;
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
            //At first courseware directory with specified courseware id  in uploads directory
            $delete_cw_id = $_POST['delete_cw_id'];
            $this->rrmdir('uploads/courseware/' . $delete_cw_id);
            $this->data['cwsets'] = $this->coursewares_m->delete($delete_cw_id);
            $ret['data'] = $this->output_content($this->data['cwsets']);
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
            $publish_cw_id = $_POST['publish_cw_id'];
            $publish_cw_st = $_POST['publish_state'];
            $this->data['swsets'] = $this->coursewares_m->publish($publish_cw_id, $publish_cw_st);
            //$ret['data'] = $this->output_content($this->data['cwsets']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function validate()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $publish_cw_id = $_POST['publish_cw_id'];
            $publish_cw_st = $_POST['publish_state'];
            $this->data['swsets'] = $this->coursewares_m->validate($publish_cw_id, $publish_cw_st);
            //$ret['data'] = $this->output_content($this->data['cwsets']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_content($cwsets)
    {
        $output = '';
        foreach ($cwsets as $cw):

            $pub = '';
            if ($cw->publish == '1') $pub = $this->lang->line('UnPublish');
            else   $pub = $this->lang->line('Publish');
            $validStr = ['开放', '取消开放'];
            $output .= '<tr>';
            $output .= '<td align="center">' . $cw->courseware_num . '</td>';
            $output .= '<td align="center">' . $cw->courseware_name . '</td>';
            $output .= '<td align="center" data-course-id="' . $cw->course_id . '">' . $cw->course_name . '</td>';
            $output .= '<td align="center">' . (floatval($cw->price) == 0 ? $this->lang->line('Free') : $cw->price) . '</td>';
            $output .= '<td align="center" data-school-type-id="' . $cw->school_type_id . '">' . $cw->school_type_name . '</td>';
            $output .= '<td align="center">';
            $output .= '<button class="btn btn-sm btn-success" onclick = "edit_cw(this);" cw-free="' . $cw->free . '" cw_photo = "' . $cw->courseware_photo . '"cw_id = ' . $cw->courseware_id . '>' . $this->lang->line('Modify') . '</button>';
            $output .= '<button class="btn btn-sm btn-warning" onclick = "delete_cw(this);" cw_id = ' . $cw->courseware_id . '>' . $this->lang->line('Delete') . '</button>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-danger" onclick = "publish_cw(this);" cw_id = ' . $cw->courseware_id . '>' . $pub . '</button>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-danger" onclick = "validate_cw(this);" cw_id = ' . $cw->courseware_id . '>' . $validStr[$cw->isvalid] . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
                if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
            rmdir($dir);
        } else if (file_exists($dir)) unlink($dir);
    }

    function checkRole()
    {

        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData[0]->cs_pro_st;
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }
}
