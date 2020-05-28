<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signin_m extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function signin($username = '', $user_pass = '')
    {

        $lang = 'chinese';
        if ($username == '')
            $username = $this->input->post('username');
        if ($user_pass == '')
            $user_pass = $this->input->post('password');
        $user_pass = $this->hash($user_pass);
        $user_data = '';
        $userInfo = $this->db->get_where('users', array("username" => $username, "password" => $user_pass, 'publish' => '1'));
        $user_data = $userInfo->row();

        if (!empty($user_data)) {
            $coursePermission = json_decode($user_data->buycourse_arr);
            if ($user_data->username) {
                $data = array(
                    "loginuserID" => $user_data->user_id,
                    "username" => $user_data->username,
                    "user_type" => $user_data->user_type_id,
                    "lang" => $lang,                   
                    "course_permission" => $coursePermission,
                    "loggedin" => TRUE
                );
                $this->session->set_userdata($data);
                return TRUE;
            } else {
                return FALSE;
            }

        } else {
            return FALSE;
        }
    }

    public function getWxStatus()
    {
        $this->db->select('*');
        $this->db->from('wxmanage');
        $query = $this->db->get();
        return $query->row()->wx_status;
    }

    public function setWxStatus($status)
    {
        $this->db->set('wx_status', $status);
        $this->db->update('wxmanage');
        return true;
    }

    public function signin_weixin($nickname)
    {

        $lang = 'chinese';

        $user_data = '';
        $userInfo = $this->db->get_where('users', array("nickname" => $nickname));
        $user_data = $userInfo->row();
        if (!empty($user_data)) {
            $coursePermission = json_decode($user_data->buycourse_arr);
            if ($user_data->nickname) {
                $data = array(
                    "loginuserID" => $user_data->user_id,
                    "username" => $user_data->nickname,
                    "user_type" => $user_data->user_type_id,
                    "lang" => $lang,
                    "open_id" => $user_data->open_id,
                    "course_permission" => $coursePermission,
                    "loggedin" => TRUE
                );
                $this->session->set_userdata($data);
                return TRUE;
            } else {
                return FALSE;
            }

        } else {
            return FALSE;
        }
    }

    public function signout()
    {
        //$this->session->sess_destroy();
        $this->session->unset_userdata('loginuserID');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('lang');
        $this->session->unset_userdata('open_id');
        $this->session->unset_userdata('loggedin');
    }

    public function loggedin()
    {
        return (bool)$this->session->userdata("loggedin");
        //return TRUE;
    }

    public function hash($string)
    {
        return parent::hash($string);
    }

    public function getSchoolStatus($user_id)
    {
        $user_data = array();
        $SQL = 'SELECT  schools.stop FROM users
                INNER JOIN schools ON users.school_id = schools.school_id WHERE user_id = ' . $user_id . ';';
        $query = $this->db->query($SQL);

        if (count($query->result()) === 0 || $query === Null) return '0';

        $user_data = $query->row();
        if ($user_data != NULL)
            return $user_data->stop;
        else return '0';
    }
}
/* End of file signin_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/signin_m.php */
