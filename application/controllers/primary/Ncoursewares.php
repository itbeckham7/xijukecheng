<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ncoursewares extends CI_Controller {

	function __construct() {
		parent::__construct();

		$language = 'chinese';
		$this->lang->load('frontend', $language);
        $this->load->model('nchildcourses_m');
        $this->load->model('ncoursewares_m');
        $this->load->model('coursepermissions_m');
        $this->load->model('nunits_m');
        $this->load->model('signin_m');

        $this->load->library("session");
	}
	function view($nccsId){/*new child course id*/

        $this->data['ncwsSet'] = $this->ncoursewares_m->get_ncwByChildCourseId($nccsId);///New courseware
        $this->data['nccsName'] = $this->nchildcourses_m->get_single(array('childcourse_id'=>$nccsId))->childcourse_name;
        $this->data['nunitSet'] = $this->nunits_m->get_nunitByChildCourseId($nccsId);
        $this->data["subview"] = "primary/ncoursewares/view";

        $this->data["cur_cs_id"] = $nccsId;

        $user_id = $this->session->userdata("loginuserID");
        if($this->signin_m->loggedin())
        {
            $this->data['user_id'] = $user_id;
            $this->data['cws_permissions'] = $this->coursepermissions_m->get_where(array('user_id' => $user_id, 'course_type' => '2'));
        } else {
            $this->data['cws_permissions'] = [];
        }
        $this->data['cws_permissions'] = $this->getUserCws($this->data['cws_permissions']);
        $this->load->view('primary/_layout_main', $this->data);
    }
    function getUserCws($cwPermissions) {
        $ret = array();
        foreach ($cwPermissions as $value):
            array_push($ret,$value->course_id);
        endforeach;
        return $ret;
    }
    function textwav_upload()
    {

        $ret = array('data'=>'','status'=>'fail');
        if($_REQUEST)
        {
            $upload_path =  'uploads/nwork';

            $filename = $_REQUEST['filename'];

            $fp = fopen($upload_path."/".$filename.".wav", "wb");

            fwrite($fp, file_get_contents('php://input'));

            fclose($fp);

            exit('done');
        }

    }
}
?>