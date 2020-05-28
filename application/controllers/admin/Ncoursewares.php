<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ncoursewares extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';

        $this->load->model("nchildcourses_m");
        $this->load->model("nunits_m");
        $this->load->model("ncoursewares_m");
        $this->load->model("users_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");

    }

    public function index()
    {
        $this->data['menu'] = '23';
        $this->data['pageTitle'] = '课件管理';
        $this->data['ncwSets'] = $this->ncoursewares_m->get_ncw();
        $this->data['nccsSets'] = $this->nchildcourses_m->get_nchild_courses();
        $this->data['nunitSets'] = $this->nunits_m->get_nunits();
        $this->data["subview"] = "admin/ncoursewares/index";
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
            'data' => '',
            'status' => 'fail'
        );
        $config['upload_path'] = "./uploads/images";
        $config['allowed_types'] = 'bmp|gif|jpg|png|zip';
        $this->load->library('upload', $config);
        if ($_POST) {
            $ncw_name = $this->input->post('add_ncw_name');
            $ncw_sn = $this->input->post('add_ncw_sn');
            $nunit_id = $this->input->post('add_nunit_name');
            $isFree = $this->input->post('free_option');
            $add_ncw_image_path = '';
            $add_ncw_package_path = '';
            //image uploading
            if ($this->upload->do_upload('add_file_name')) {
                $data = $this->upload->data();
                $add_ncw_image_path = 'uploads/images/' . $data["file_name"];
            } else {
                $ret['data'] = 'Select image file!';
                $ret['status'] = 'fail';
                echo json_encode($ret);
                return;
            }
            //At first insert new coureware information to the database table
            $param = array(
                'ncw_sn' => $ncw_sn,
                'ncw_name' => $ncw_name,
                'nunit_id' => $nunit_id,
                'ncw_photo' => $add_ncw_image_path,
                'nfree' => $isFree
            );
            $ncwId = $this->ncoursewares_m->add($param);
            ///Package file uploading.......
            if (isset($_FILES['add_package_file_name']['name'])) {
                $uploadPath = 'uploads/newunit/' . $nunit_id . '/' . $ncwId;
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $configPackage['upload_path'] = './' . $uploadPath;
                $configPackage['allowed_types'] = 'zip';
                $this->load->library('upload', $configPackage);
                if ($this->upload->do_upload('add_package_file_name')) {
                    $zipData = $this->upload->data();
                    $zip = new ZipArchive;
                    $file = $zipData['full_path'];
                    chmod($file, 0777);
                    if ($zip->open($file) === TRUE) {
                        $zip->extractTo($configPackage['upload_path']);
                        $zip->close();
                        unlink($file);
                    } else {
                        echo 'failed';
                    }
                    $add_ncw_package_path = $uploadPath;
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    $ret['data'] = $this->upload->display_errors();
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }
            }
            $ncwsets = $this->ncoursewares_m->edit(array('ncw_file' => $add_ncw_package_path), $ncwId);
            $ret['data'] = $this->output_content($ncwsets);;
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
        $config['allowed_types'] = 'bmp|gif|jpg|png|zip';
        $this->load->library('upload', $config);

        if ($_POST) {
            $ncw_id = $this->input->post('ncw_id');
            $ncw_name = $this->input->post('edit_ncw_name');
            $ncw_sn = $this->input->post('edit_ncw_sn');
            $nunit_id = $this->input->post('edit_nunit_name');
            $isFree = $this->input->post('free_option');
            $ncw_image_path = '';
            $param = array(
                'ncw_sn' => $ncw_sn,
                'ncw_name' => $ncw_name,
                'nunit_id' => $nunit_id,
                'nfree' => $isFree
            );
            if ($_FILES["edit_file_name"]["name"] != '') {
                //image uploading
                if ($this->upload->do_upload('edit_file_name')) {
                    $data = $this->upload->data();
                    $ncw_image_path = 'uploads/images/' . $data["file_name"];
                }
            }
            if ($ncw_image_path != '') $param['ncw_photo'] = $ncw_image_path;

            $oldNcwInfo = $this->ncoursewares_m->get_single(array('ncw_id' => $ncw_id));
            $oldPath = $oldNcwInfo->ncw_file;
            $newPath = 'uploads/newunit/' . $nunit_id . '/' . $ncw_id;
            $uploadFile = $_FILES["edit_package_file_name"]["name"];
            if ($uploadFile == '') {
                if ($oldPath != $newPath) {
                    $this->rrmdir($newPath);
                    mkdir($newPath, 0755, true);
                    $this->rcopy($oldPath, $newPath);
                    $this->rrmdir($oldPath);
                    $param['ncw_file'] = $newPath;
                }

            } else {
                $this->rrmdir($oldPath);
                mkdir($newPath, 0755, true);
                $configPackage['upload_path'] = './' . $newPath;
                $configPackage['allowed_types'] = 'zip';
                $this->load->library('upload', $configPackage);
                if ($this->upload->do_upload('edit_package_file_name'))///this process is success then we have to move current subware to new position
                {

                    ///---1----. At first New zip file upload and Extract
                    $zipdata = $this->upload->data();
                    $zip = new ZipArchive;
                    $file = $zipdata['full_path'];
                    chmod($file, 0777);
                    if ($zip->open($file) === TRUE) {
                        $zip->extractTo($configPackage['upload_path']);
                        $zip->close();
                        unlink($file);

                        $param['ncw_file'] = $newPath;
                    } else {
                        echo 'can not extract zip file ';
                    }

                } else {///show error message

                    $error = array('error' => $this->upload->display_errors());
                    $ret['data'] = $error;
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }

            }
            $ncwsets = $this->ncoursewares_m->edit($param, $ncw_id);
            $ret['data'] = $this->output_content($ncwsets);;
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
            $delete_ncw_id = $_POST['delete_ncw_id'];
            $ncwInfo = $this->ncoursewares_m->get_single(array('ncw_id' => $delete_ncw_id));
            $ncwPath = $ncwInfo->ncw_file;
            $this->rrmdir($ncwPath);
            $ncwSets = $this->ncoursewares_m->delete($delete_ncw_id);
            $ret['data'] = $this->output_content($ncwSets);
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
            $ncw_id = $_POST['ncw_id'];
            $publish_ncw_st = $_POST['publish_state'];
            $ncwSets = $this->ncoursewares_m->publish($ncw_id, $publish_ncw_st);
            //$ret['data'] = $this->output_content($this->data['cwsets']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_content($ncwsets)
    {
        $output = '';
        foreach ($ncwsets as $ncw):
            $pub = '';
            if ($ncw->ncw_publish == '1') $pub = $this->lang->line('UnPublish');
            else   $pub = $this->lang->line('Publish');
            $output .= '<tr>';
            $output .= '<td>' . $ncw->ncw_sn . '</td>';
            $output .= '<td>' . $ncw->ncw_name . '</td>';
            $output .= '<td>' . $ncw->nunit_name . '</td>';
            $output .= '<td>' . $ncw->childcourse_name . '</td>';
            $output .= '<td>' . $ncw->school_type_name . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm btn-success" onclick = "edit_ncw(this);" ncw-free="' . $ncw->nfree . '" ncw_photo = "' . $ncw->ncw_photo . '" ncw_id = ' . $ncw->ncw_id . '>' . $this->lang->line('Modify') . '</button>';
            $output .= '<button class="btn btn-sm btn-warning" onclick = "delete_ncw(this);" ncw_id = ' . $ncw->ncw_id . '>' . $this->lang->line('Delete') . '</button>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-danger" onclick = "publish_ncw(this);" ncw_id = ' . $ncw->ncw_id . '>' . $pub . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

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
            $accessInfo = $permissionData[0]->cs_pro_st;
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }
}
