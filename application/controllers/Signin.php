<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('frontend', $language);
        $this->load->library("pagination");
        $this->load->model("users_m");
        $this->load->model("signin_m");
        $this->load->library("session");
        $this->load->library('form_validation');
    }

    public function index()
    {

        $this->signin_m->loggedin() == FALSE || redirect(base_url('home/index'));
        $this->data['form_validation'] = 'No';
        $this->data['wxStatus'] = $this->signin_m->getWxStatus();
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data['form_validation'] = validation_errors();
                $this->data["subview"] = "signin/login";
                $this->load->view('middle/_layout_main', $this->data);
            } else {
                if ($this->signin_m->signin() == TRUE) {
                    $user_id = $this->session->userdata("loginuserID");
                    $arr = array();
                    $arr['last_login'] = date('Y-m-d H:i:s');
                    $arr['ip_addr'] = $this->get_client_ip();

                    $this->users_m->update_user($arr, $user_id);
                    $this->users_m->update_user_login_num($user_id);

                    if ($this->session->userdata("target"))
                        redirect(base_url($this->session->userdata("target")));
                    else
                        redirect(base_url('home/index'));
                } else {
                    $this->session->set_flashdata("errors", "That user does not signin");
                    $this->data['form_validation'] = "Incorrect Signin";
                    $this->data["subview"] = "signin/login";
                    $this->load->view('middle/_layout_main', $this->data);
                }
            }
        } else {
            $this->data["subview"] = "signin/login";
            $this->load->view('middle/_layout_main', $this->data);
        }
    }

    public function register()
    {
        $this->signin_m->loggedin() == FALSE || redirect(base_url('home/index'));
        $this->data['form_validation'] = 'No';
        $ret = [
            'status' => 'fail',
            'data' => '信息无效'
        ];
        if ($_POST) {
            $arr = $_POST;
            $userInfo = $this->users_m->get_where(array('username' => $arr['username']));
            if ($userInfo != null) {
                $ret['data'] = '用户已存在';
                echo json_encode($ret);
                return;
            }
            unset($arr['cpassword']);
            $arr['nickname'] = $arr['username'];
            $arr['fullname'] = $arr['username'];
            $arr['reg_time'] = date('Y-m-d H:i:s');
            $arr['login_num'] = 0;
            $arr['buycourse_arr'] = '{}';
            $arr['class'] = '';
            $arr['sex'] = '男';
            $arr['user_type_id'] = 2;
            $arr['publish'] = 1;
            $pass = $arr['password'];
            $arr['password'] = $this->users_m->hash($arr['password']);
            $this->users_m->insert($arr);
            $_POST['password'] = $pass;
            $ret['status'] = 'success';
            $ret['data'] = 'signin/index';
            echo json_encode($ret);
            return;
            if ($this->signin_m->signin($arr['username'], $pass) == TRUE) {
                $user_id = $this->session->userdata("loginuserID");
                $arr = array();
                $arr['last_login'] = date('Y-m-d H:i:s');
                $arr['ip_addr'] = $this->get_client_ip();

                $this->users_m->update_user($arr, $user_id);
                $this->users_m->update_user_login_num($user_id);

                $ret['status'] = 'success';
                $ret['data'] = 'home/index';
                echo json_encode($ret);
            } else {
                $ret['data'] = '注册失败';
                echo json_encode($ret);
            }
        } else {
            $this->data["subview"] = "signin/register";
            $this->load->view('middle/_layout_main', $this->data);
        }
    }

    // get request from mobile
    // input: token, nickname, avatar
    // operation: if nickname exist, then get user info from db,
    //              else add user to token record.
    // return : user info
    public function setUserInfo()
    {

        $ret = array(
            'status' => 'error',
            'data' => ''
        );

        if ($_GET) {
            $param = [];
            if (empty($_GET['nickname'])) {
                $ret['data'] = 'nickname empty!';///nickName empty
                echo json_encode($ret);
                return;
            }
            $param['nickname'] = $_GET['nickname'];

            if (empty($_GET['token'])) {
                $ret['data'] = 'token empty!';///username empty
                echo json_encode($ret);
                return;
            }
            $param['user_token'] = $_GET['token'];

            if (empty($_GET['avatar'])) {
                $ret['data'] = 'avatar empty!';///password empty
                echo json_encode($ret);
                return;
            }
            $param['avatar'] = $_GET['avatar'];

            if (!isset($_GET['sex'])) {
                $ret['data'] = 'sex empty!';///password empty
                echo json_encode($ret);
                return;
            }
            $sex = $_GET['sex'];
            if ($sex == 0) $param['sex'] = '男';
            else $param['sex'] = '女';


            if (empty($_GET['openId'])) {
                $ret['data'] = 'openid empty!';///password empty
                echo json_encode($ret);
                return;
            }
            $param['open_id'] = $_GET['openId'];

            $param['user_type_id'] = '3';
            $param['username'] = $this->lang->line('weixin') . ' - ' . $param['nickname'];

            $userInfo = $this->users_m->getUserInfoByNickName($param['nickname']);

            if ($userInfo == null) {
                $param['buycourse_arr'] = '{}';
                $param['login_num'] = 0;
                $param['publish'] = 1;
                $param['reg_time'] = date('Y-m-d H:i:s');
                $param['ip_addr'] = $this->get_client_ip();
            }

            $userInfo = $this->users_m->addWeixinAccount($param);
            $ret['status'] = 'success';
            $ret['data'] = $userInfo;
            echo json_encode($ret);
        } else {
            $ret['data'] = 'Request invalid';
            echo json_encode($ret);
        }
    }

    public function signin_weixin()
    {
        $this->signin_m->loggedin() == FALSE || redirect(base_url('home/index'));

        if ($_POST) {
            $ret = array(
                'status' => 'error',
                'data' => ''
            );
            $param = [];
            if (empty($_POST['user_token'])) {
                $ret['data'] = 'Token empty!';///nickName empty
                echo json_encode($ret);
                return;
            }
            $param['user_token'] = $_POST['user_token'];
//            $param['user_token'] = 'oVjButhYSdaizrD';

            $param['user_type_id'] = '3';

            $userInfo = $this->users_m->get_where($param);

            if ($userInfo == null) {
                $ret['data'] = 'user is not exist.';
                echo json_encode($ret);
                return;
            }

            if ($this->signin_m->signin_weixin($userInfo[0]->nickname) == TRUE) {
                $user_id = $this->session->userdata("loginuserID");
                $arr = array();
                $arr['last_login'] = date('Y-m-d H:i:s');
                $arr['ip_addr'] = $this->get_client_ip();

                $this->users_m->update_user($arr, $user_id);
                $this->users_m->update_user_login_num($user_id);
                //redirect(base_url('home/index'));
            } else {
                $ret['data'] = "Incorrect Signin";
                echo json_encode($ret);
                return;
            }
            $ret['status'] = 'success';
            $ret['data'] = $userInfo;
            echo json_encode($ret);
        } else {
            $this->data["subview"] = "signin/signin_weixin";
            $this->load->view('middle/_layout_main', $this->data);
        }
    }

//    public function user_register_request()
//    {
//        $this->signin_m->loggedin() == FALSE || redirect(base_url('home/index'));
//
//        if ($_POST) {
//            $ret = array(
//                'status' => 'error',
//                'data' => ''
//            );
//            $param = [];
//            if (empty($_POST['nickname'])) {
//                $ret['data'] = 'nickname empty!';///nickName empty
//                echo json_encode($ret);
//                return;
//            }
//            $param['nickname'] = $_POST['nickname'];
//
//            $userInfo = $this->users_m->getUserInfoByNickName($param['nickname']);
//
//            $param['user_type_id'] = '3';
//            $param['username'] = '';
//            $param['nickname'] = '';
//            $param['sex'] = '';
//
//            if (count($userInfo) == 0) {
//                $param['buycourse_arr'] = '{}';
//                $param['login_num'] = 0;
//                $param['publish'] = 1;
//                $param['reg_time'] = date('Y-m-d H:i:s');
//                $param['ip_addr'] = $this->get_client_ip();
//                $userInfo = $this->users_m->addWeixinAccount($param);
//            }
//            if ($this->signin_m->signin_weixin() == TRUE) {
//                $user_id = $this->session->userdata("loginuserID");
//                $arr = array();
//                $arr['last_login'] = date('Y-m-d H:i:s');
//                $arr['ip_addr'] = $this->get_client_ip();
//
//                $this->users_m->update_user($arr, $user_id);
//                $this->users_m->update_user_login_num($user_id);
//                $ret['status'] = 'success';
//                $ret['data'] = $param['user_token'];
//                echo json_encode($ret);
//                //redirect(base_url('home/index'));
//            } else {
////                $this->session->set_flashdata("errors", "That user does not signin");
////                $this->data['form_validation'] = "Incorrect Signin";
////                $this->data["subview"] = "signin/login_select";
////                $this->load->view('_layout_main', $this->data);
//                $ret['data'] = $param['user_token'];
//                echo json_encode($ret);
//            }
//        } else {
//            $this->data["subview"] = "signin/login_select";
//            $this->load->view('_layout_main', $this->data);
//        }
//    }

    public function snaps_login()
    {
        if (!empty($_GET['token'])) {
            ///check user with token
            $userInfo = $this->db->get_where('users', array('user_token' => $_GET['token']));
            $user_data = $userInfo->row();
            if (!empty($user_data)) {
                $coursePermission = json_decode($user_data->buycourse_arr);
                $lang = 'chinese';
                $data = array(
                    "loginuserID" => $user_data->user_id,
                    "username" => $user_data->username,
                    "user_type" => $user_data->user_type_id,
                    "lang" => $lang,
                    "course_permission" => $coursePermission,
                    "loggedin" => TRUE
                );
                $this->session->set_userdata($data);
                $user_id = $this->session->userdata("loginuserID");
                $arr = array();
                $arr['last_login'] = date('Y-m-d H:i:s');
                $arr['ip_addr'] = $this->get_client_ip();
                $this->users_m->update_user($arr, $user_id);
                $this->users_m->update_user_login_num($user_id);
            }

        }
        redirect(base_url());

    }

    public function signout()
    {
        $this->signin_m->signout();
        redirect(base_url("home/index"));
    }

    protected function rules()
    {
        $rules = array(
            array(
                'field' => 'username',
                'label' => "Username",
                'rules' => 'trim|required|max_length[30]'
            ),
            array(
                'field' => 'password',
                'label' => "Password",
                'rules' => 'trim|required|max_length[30]'
            )
        );
        return $rules;
    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

?>