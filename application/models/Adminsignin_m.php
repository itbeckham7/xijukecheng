<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminsignin_m extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function signin() {

        $lang = 'chinese';
        $admin_name = $this->input->post('username');
        $admin_pass = $this->hash($this->input->post('password'));

        $admin_data = '';
        $adminInfo = $this->db->get_where('admins', array("admin_name" => $admin_name, "admin_pass" =>$admin_pass));
        $admin_data = $adminInfo->row();
        if( !empty($admin_data) ){
            $data = array(
                "admin_loginuserID" => $admin_data->admin_id,
                "admin__name" => $admin_data->admin_name,
                "admin_user_type" => $admin_data->permission,
                "adminlang" => $lang,
                "admin_loggedin" => TRUE
            );
            $this->session->set_userdata($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function signout() {
        //$this->session->sess_destroy();
        $this->session->unset_userdata('admin_loginuserID');
        $this->session->unset_userdata('admin__name');
        $this->session->unset_userdata('admin_user_type');
        $this->session->unset_userdata('adminlang');
        $this->session->unset_userdata('admin_loggedin');
    }
    public function loggedin() {
        return (bool) $this->session->userdata("admin_loggedin");
    }
    public function hash($string) {
        return parent::hash($string);
    }
}
/* End of file signin_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/signin_m.php */
