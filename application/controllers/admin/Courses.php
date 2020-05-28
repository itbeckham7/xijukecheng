<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Courses extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();

		$language = 'chinese';

		$this->load->model("courses_m");
        $this->load->model("users_m");
        $this->load->model("schooltypes_m");
		$this->lang->load('courses',$language);
		$this->load->library("pagination");

	}
	public function index()
	{
//		$courses = $this->courses_m->get_courses(array('course_slug'=>'kebenju'));

		$courses = $this->courses_m->get_courses();
        $schoolTypes = $this->schooltypes_m->get_school_types();
		$this->data['menu'] = '11';
		$this->data['pageTitle'] = '课程管理';
        $this->data['courses'] = $courses;
        $this->data['schoolTypes'] = $schoolTypes;
		$this->data["subview"] = "admin/courses/index";
		$this->data["subscript"] = "admin/settings/script";
		$this->data["subcss"] = "admin/settings/css";
        $this->load->view('admin/_layout_main', $this->data);
	}
	public function edit()
	{
		$ret = array(
			'data'=>'I am ajax function.',
			'status'=>'success'
		);
		if($_POST)
		{
			$cs_id = $_POST['course_id'];
			$cs_desc = $_POST['course_desc'];
			$cs_school_type_name = $_POST['course_school_type_name'];
			///modify course description in courses table;
			$this->courses_m->edit($cs_id,$cs_desc,$cs_school_type_name);
			$cs_sets = $this->courses_m->get_courses(array('course_slug'=>'kebenju'));
			$ret['data'] = $this->output_content($cs_sets);
		}
		echo json_encode($ret);
	}
	function output_content($courses)
    {
        $output= '';
        $modifyStr = $this->lang->line('Modify');
        foreach($courses as $course):
            $output .= '<tr>';
            $output .= '<td align="center">'.$course->course_name.'</td>';
            $output .= '<td align="center">'.$course->course_desc.'</td>';
            $output .= '<td align="center">'.$course->school_type_name.'</td>';
            $output .= '<td>';
            $output .= '<button style ="width:70px" onclick= "edit_course(this);" class="btn btn-sm btn-success" course_id = '.$course->course_id.'>'.$modifyStr.'</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;

        return $output;
    }
    function checkRole(){

	    $permission = $this->session->userdata('admin_user_type');
	    if($permission!=NULL)
        {
            $permisData = json_decode($permission);
            $courseInfo = $permisData[0]->cs_pro_st;
            if($courseInfo=='1') return true;
            else return false;
        }
        return false;
    }

}
