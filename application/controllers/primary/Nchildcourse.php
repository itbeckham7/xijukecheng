<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Nchildcourse extends CI_Controller {

	function __construct() {
		parent::__construct();

		$language = 'chinese';
		$this->lang->load('frontend', $language);
		$this->load->model('coursewares_m');
		$this->load->model('coursepermissions_m');
		$this->load->model('signin_m');
        $this->load->model('nchildcourses_m');
		$this->load->library("session");
	}
	public function index(){

        $user_type = $this->session->userdata("user_type");
        $user_id = $this->session->userdata("loginuserID");
        if($this->signin_m->loggedin())
        {
            $this->data['user_type'] = $user_type;
            $this->data['user_id'] = $user_id;
            $this->data['cws_permissions'] = $this->coursepermissions_m->get_where(array('user_id' => $user_id, 'course_type' => '2'));
        } else {
            $this->data['cws_permissions'] = [];
        }
        $this->data['cws_permissions'] = $this->getUserCws($this->data['cws_permissions']);
        $this->data['nccsSet'] = $this->nchildcourses_m->get_nchild_publish();
        $this->data["subview"] = "primary/nchildcourse/index";
        $this->load->view('primary/_layout_main', $this->data);
    }
    public function view($id)
    {
        //whenever this function is called..
        ///we have to add access time and update curseware_access table of database.
        $arr = array(
          'cw_id'=>$id,
          'cw_access_time'=>date('Y-m-d H:i:s'),
        );
        $this->db->insert('courseware_accesses',$arr);

        $this->data['courseware_id'] = $id;
        $this->data['subwares'] = $this->subwares_m->get_swForFrontend($id);
        $this->data["subview"] = "primary/coursewares/view";
        $this->load->view('primary/_layout_main', $this->data);

    }
    function update_SW_Access(){

        $ret = array(
            'data'=>'',
            'status'=>'fail'
        );
        if($_POST){
            $swTypeId = $_POST['subware_type_id'];
            $arr = array(
                'sw_type_id'=>$swTypeId,
                'sw_access_time'=>date('Y-m-d H:i:s')
            );
            $this->db->insert('subware_accesses',$arr);
           $ret['status'] = 'success';
           $ret['data']='success';
        }
        echo json_encode($ret);

    }
    function getUserCws($cwPermissions) {
        $ret = array();
        foreach ($cwPermissions as $value):
            array_push($ret,$value->course_id);
        endforeach;
        return $ret;
    }
}
?>