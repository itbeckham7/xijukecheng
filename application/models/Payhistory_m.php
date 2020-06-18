<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payhistory_m extends MY_Model
{

    protected $_table_name = 'payhistory';
    protected $_primary_key = 'trans_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "trans_id asc";

    function __construct()
    {
        parent::__construct();
    }

    public function getItems()
    {
        $users_data = array();
        $SQL = "SELECT  coursewares.courseware_id,coursewares.courseware_name,users.username,users.fullname,user_types.user_type_name,
                        coursewares.price, paid_time, payhistory.user_id, payhistory.sender                        
                FROM payhistory
                LEFT JOIN coursewares ON payhistory.courseware_id = coursewares.courseware_id
                LEFT JOIN users ON users.user_id = payhistory.user_id 
                LEFT JOIN user_types ON users.user_type_id = user_types.user_type_id
                ORDER By users.user_id ASC 
                ;";
        $query = $this->db->query($SQL);
        $users_data = $query->result();


        return $users_data;
    }

    public function getItemsFromUser($user_id)
    {
        if ($user_id == '') return array();

        $SQL = 'SELECT  payhistory.courseware_id, coursewares.courseware_name, 
                        payhistory.user_id, payhistory.sender
                FROM payhistory
                LEFT JOIN coursewares ON payhistory.courseware_id = coursewares.courseware_id
                WHERE payhistory.user_id = ' . $user_id . ' 
                ORDER BY payhistory.courseware_id
                ;';
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function edit($param)
    {
        $school_id = $this->getSchoolIdFromName($param['school_name']);
        $arr = array(
            'fullname' => $param['fullname'],
            'sex' => $param['sex'],
            'school_id' => $school_id,
            'user_type_id' => $param['user_type_id'],
            'reg_time' => $param['reg_time'],
            'class' => $param['class'],
            'buycourse_arr' => $param['buycourse_arr']
        );
        if ($param['password_status'] == '1') {
            $arr['password'] = $this->hash($param['password']);
        }
        $this->db->where('user_id', $param['user_id']);
        $this->db->update('users', $arr);
        return $this->get_users();
    }

    function update_user($data, $id = NULL)///for update session of login time
    {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }

    function update_user_login_num($id)///for update session of login time
    {
        $this->db->set('login_num', 'login_num+1', FALSE);
        $this->db->where('user_id', $id);
        $this->db->update('users');
    }

    function insert($array)
    {
        return parent::insert($array); // TODO: Change the autogenerated stub
    }

    public function add($param)
    {
        $school_id = $this->getSchoolIdFromName($param['school_name']);
        //$user_type_id = $this->get_userTypeIdFromName($param['user_type_name']);
        $user_type_id = $param['user_type_id'];

        $arr = array(
            'fullname' => $param['fullname'],
            'username' => $param['username'],
            'password' => $this->hash($param['password']),
            'sex' => $param['sex'],
            'school_id' => $school_id,
            'user_type_id' => $user_type_id,
            'reg_time' => $param['reg_time'],
            'class' => $param['user_class_name'],
            'buycourse_arr' => $param['buycourse_arr'],
            'publish' => '0'
        );
        if ($user_type_id == '1')///this is teacher and don't add class field when register user account
            $arr['class'] = '';

        $this->db->insert('users', $arr);
        return $this->get_users();

    }

    public function delete($delete_user_id)
    {
        $this->db->where('user_id', $delete_user_id);
        $this->db->delete('users');
    }

    public function publish($user_id, $publish_st)//$pub_st==1 then publish state, $pub_sd == 0 then unpublish
    {
        $this->db->set('publish', $publish_st);
        $this->db->where('user_id', $user_id);
        $this->db->update('users');
    }

    public function user_search($arr, $buycsname, $startTime, $endTime)
    {
        if (!empty($arr)) {

            $this->db->select()->from('payhistory')->like($arr);
            $query = $this->db->get();
            $middleData = $query->result();
            return $this->searchByTime($arr, $buycsname, $middleData, $startTime, $endTime);
        }
        return NULL;
    }

    public function getSchoolIdFromName($school_name)
    {
        $this->db->select('school_id')->from('schools')->where('school_name', $school_name);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->school_id;
    }

    public function getSchoolNameFromID($school_id)
    {
        $this->db->select('school_name')->from('schools')->where('school_id', $school_id);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->school_name;
    }

    public function get_userTypeIdFromName($user_type_name)
    {
        $this->db->select('user_type_id')->from('user_types')->where('user_type_name', $user_type_name);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->user_type_id;
    }

    public function get_userTypeNameFromID($user_type_id)
    {
        $this->db->select('user_type_name')->from('user_types')->where('user_type_id', $user_type_id);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->user_type_name;
    }

    public function getSchoolIdFromUserId($userId)
    {
        $arr = array('user_id' => $userId);
        $query = parent::get_single($arr);
        return $query->school_id;
    }

    public function getFullNameFromUserId($userId)
    {
        $arr = array('user_id' => $userId);
        $query = parent::get_single($arr);
        return $query->fullname;
    }

    public function bulkAddUsers($arr)
    {
        if (!empty($arr)) {
            $this->db->insert_batch('users', $arr);
        }
        return $this->get_users();
    }

    public function searchByTime($queryData, $buycsname, $middleData, $startTime, $endTime)
    {
        $ret = array();
        foreach ($middleData as $user):

            $reg_time = new DateTime($user->reg_time);
            $before_time = new DateTime($startTime);
            $after_time = new DateTime($endTime);
            $buycs = json_decode($user->buycourse_arr, true);

            if ($buycsname != '') {
                if ($buycs[$buycsname] == '0') continue;
                if ($before_time < $reg_time && $reg_time < $after_time) ;
                {
                    $tempArr['user_id'] = $user->user_id;
                    $tempArr['username'] = ($queryData['username'] != '') ? $queryData['username'] : $user->username;
                    $tempArr['fullname'] = ($queryData['fullname'] != '') ? $queryData['fullname'] : $user->fullname;
                    $tempArr['fullname'] = ($queryData['fullname'] != '') ? $queryData['fullname'] : $user->fullname;
                    $tempArr['sex'] = ($queryData['sex'] != '') ? $queryData['sex'] : $user->sex;
                    $tempArr['reg_time'] = $user->reg_time;
                    $tempArr['school_name'] = $this->getSchoolNameFromID($user->school_id);
                    $tempArr['user_type_id'] = $user->user_type_id;
                    $tempArr['user_type_name'] = $this->get_userTypeNameFromID($user->user_type_id);
                    $tempArr['class'] = $user->class;
                    $tempArr['buycourse_arr'] = $user->buycourse_arr;
                    $tempArr['publish'] = $user->publish;

                    array_push($ret, $tempArr);
                }
            } else {
                if ($before_time < $reg_time && $reg_time < $after_time) ;
                {
                    $tempArr['user_id'] = $user->user_id;
                    $tempArr['username'] = ($queryData['username'] != '') ? $queryData['username'] : $user->username;
                    $tempArr['fullname'] = ($queryData['fullname'] != '') ? $queryData['fullname'] : $user->fullname;
                    $tempArr['sex'] = ($queryData['sex'] != '') ? $queryData['sex'] : $user->sex;
                    $tempArr['reg_time'] = $user->reg_time;
                    $tempArr['school_name'] = $this->getSchoolNameFromID($user->school_id);
                    $tempArr['user_type_id'] = $user->user_type_id;
                    $tempArr['user_type_name'] = $this->get_userTypeNameFromID($user->user_type_id);
                    $tempArr['class'] = $user->class;
                    $tempArr['buycourse_arr'] = $user->buycourse_arr;
                    $tempArr['publish'] = $user->publish;

                    array_push($ret, $tempArr);
                }

            }

        endforeach;
        return $ret;
    }

    public function hash($string)
    {
        return parent::hash($string);
    }

    public function get_where($array = NULL)
    {
        return parent::get_where($array); // TODO: Change the autogenerated stub
    }

    public function hasContents($content_user_id, $contentTypeId)
    {
        $arr = array(
            'content_user_id' => $content_user_id,
            'content_type_id' => $contentTypeId
        );
        $this->db->select()->from('contents')->where($arr);
        $query = $this->db->get();
        $ret = $query->row();
        if (empty($ret)) return false;
        return true;

    }

}
