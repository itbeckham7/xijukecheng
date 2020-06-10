<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller {

	function __construct() {
		parent::__construct();

		$language = 'chinese';
        $this->load->model("coursepermissions_m");
        $this->load->model("backendcourses_m");
        $this->load->model("signin_m");
		$this->lang->load('frontend', $language);
		$this->load->library("pagination");
		$this->load->library("session");
	}

	public function index(){
//	    redirect(base_url('primary/coursewares'));
//	    return;
        $user_type = $this->session->userdata("user_type");
        $user_id = $this->session->userdata("loginuserID");
        if ($this->signin_m->loggedin()) {
            $this->data['user_type'] = $user_type;
            $this->data['user_id'] = $user_id;

            $this->data['grammar_permissions'] = $this->coursepermissions_m->get_where(array('user_id' => $user_id, 'course_type' => '3'));
        } else {
            $this->data['grammar_permissions'] = array();
        }
        $this->data["subview"] = "primary/home/index";
        $this->session->set_userdata(array('target' => $this->data["subview"]));
        $this->load->view('primary/_layout_main', $this->data);
	}

	public function grammar(){
        $user_type = $this->session->userdata("user_type");
        $user_id = $this->session->userdata("loginuserID");
        if ($this->signin_m->loggedin()) {
            $this->data['user_type'] = $user_type;
            $this->data['user_id'] = $user_id;
            $this->data['grammar_permissions'] = $this->coursepermissions_m->get_where(array('user_id' => $user_id, 'course_type' => '3'));
        } else {
            $this->data['grammar_permissions'] = [];
        }
        $this->data['bcwSets'] = $this->backendcourses_m->get_bcwSets($user_id);

        $this->data["subview"] = "primary/home/grammar";

        $this->load->view('primary/_layout_main', $this->data);
	}
}
?>