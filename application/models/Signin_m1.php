<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signin_m extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function signin() {

        $lang = 'chinese';

        $username = $this->input->post('username');
        $user_pass = $this->hash($this->input->post('password'));

        $user_data = '';
        $userInfo = $this->db->get_where('users', array("username" => $username, "password" =>$user_pass,'publish'=>'1'));
        $user_data = $userInfo->row();

        if( !empty($user_data) ){
            $user_schoolSt = $this->getSchoolStatus($user_data->user_id);
            $coursePermission = json_decode($user_data->buycourse_arr);
            if($user_schoolSt!='0'){
                $data = array(
                    "loginuserID" => $user_data->user_id,
                    "username" => $user_data->username,
                    "user_type" => $user_data->user_type_id,
                    "lang" => $lang,
                    "course_permission"=>$coursePermission,
                    "loggedin" => TRUE
                );
                $this->session->set_userdata($data);
                return TRUE;
            }else{
                return FALSE;
            }

        } else {
            return FALSE;
        }
    }
    public function signout() {
        //$this->session->sess_destroy();
        $this->session->unset_userdata('loginuserID');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('lang');
        $this->session->unset_userdata('loggedin');
    }
    public function loggedin() {
        return (bool) $this->session->userdata("loggedin");
        //return TRUE;
    }
    public function hash($string) {
        return parent::hash($string);
    }
    public function getSchoolStatus($user_id)
    {
        $user_data = array();
        $SQL = 'SELECT  schools.stop FROM users
                INNER JOIN schools ON users.school_id = schools.school_id WHERE user_id = '.$user_id.';';
        $query = $this->db->query($SQL);
        $user_data = $query->row();
        if($user_data!=NULL)
        return $user_data->stop;
        else return '0';
    }
}
/* End of file signin_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/signin_m.php */
