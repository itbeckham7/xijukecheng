<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Schools extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->load->model("schools_m");
        $this->load->model("users_m");
        $this->lang->load('accounts', $language);
        $this->lang->load('courses', $language);
        $this->load->library("pagination");

    }

    public function index()
    {
        $this->data['menu'] = '41';
        $this->data['pageTitle'] = '学校管理';
        $this->data['schools'] = $this->schools_m->get_all_schools();
        $this->data["subview"] = "admin/schools/index";
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
            $school_name = $_POST['school_name'];
            $class_arr = $_POST['class_attr'];///Array
            $this->data['schools'] = $this->schools_m->add($school_name, $class_arr);
            $ret['data'] = $this->output_content($this->data['schools']);
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
            $school_id = $_POST['school_id'];
            $school_name = $_POST['school_name'];
            $class_arr = $_POST['class_attr'];
            $this->data['schools'] = $this->schools_m->edit($school_id, $school_name, $class_arr);
            $ret['data'] = $this->output_content($this->data['schools']);
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
            $school_id = $_POST['school_id'];
            $this->data['schools'] = $this->schools_m->delete($school_id);
            $ret['data'] = $this->output_content($this->data['schools']);
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
            $school_id = $_POST['school_id'];
            $stop_st = $_POST['stop_state'];
            $this->schools_m->publish($school_id, $stop_st);
            //$ret['data'] = $this->output_content($this->data['swsets']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_content($schools)
    {
        $output = '';
        foreach ($schools as $school):

            $stop = '';
            if ($school->stop == '1') $stop = $this->lang->line('Disabled');
            else   $stop = $this->lang->line('Enabled');
            $classStr = $this->lang->line('Class');
            $gradeStr = $this->lang->line('Grade');;

            $output .= '<tr>';
            $output .= '<td align="center" style=" vertical-align:middle" >' . $school->school_id . '</td>';
            $output .= '<td align="center" style=" vertical-align:middle">' . $school->school_name . '</td>';
            $output .= '<td align="center" style=" vertical-align:middle">';

            $jsonStr = $school->class_arr;
            $classArr = json_decode($jsonStr);
            foreach ($classArr as $class_info):
                $gradeNo = $class_info->grade;
                $realStr = $this->lang->line($gradeNo - 1);
                for ($i = 1; $i <= $class_info->class; $i++) {
                    $seperator = ",&nbsp&nbsp";
                    $realClassStr = $this->lang->line($i - 1);
                    if ($i == $class_info->class) {
                        $output .= $realStr . $gradeStr . $i . $classStr;
                        // $output .= $realStr.$gradeStr.$realClassStr.$classStr;
                    } else {
                        $output .= $realStr . $gradeStr . $i . $classStr . $seperator;
                        //$output .= $realStr.$gradeStr.$realClassStr.$classStr;
                    }
                }
                $output .= '<br/>';
            endforeach;
            $output .= '</td>';
            $output .= '<td align="center" style=" vertical-align:middle">';
            $output .= '<button class="btn btn-sm btn-success" onclick="edit_school(this);" data-class_arr=' . $school->class_arr . ' school_id = ' . $school->school_id . '>' . $this->lang->line('Modify') . '</button>';
            $output .= '<button class="btn btn-sm btn-warning" onclick="delete_school(this);" school_id = ' . $school->school_id . '>' . $this->lang->line('Delete') . '</button>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-danger" onclick="publish_school(this);" school_id = ' . $school->school_id . '>' . $stop . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

}
