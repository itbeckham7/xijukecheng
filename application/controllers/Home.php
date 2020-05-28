<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller {

	function __construct() {
		parent::__construct();

		$language = 'chinese';
        $this->load->model("signin_m");
		$this->lang->load('frontend', $language);
		$this->load->library("pagination");
		$this->load->library("session");
	}

	public function index(){
        $user_type = $this->session->userdata("user_type");
        $user_id = $this->session->userdata("loginuserID");
        if ($this->signin_m->loggedin()) {
            $this->data['user_type'] = $user_type;
            $this->data['user_id'] = $user_id;

        }
        $this->data["subview"] = "home/index";
        $this->load->view('middle/_layout_main', $this->data);
	}
}
?>