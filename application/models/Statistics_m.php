<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics_m extends MY_Model {

    function __construct() {
        parent::__construct();
    }
    public function get_loginInfo()
    {
        $users_data = array();
        $SQL = "SELECT  user_id,fullname,username,school_name,users.user_type_id,
                        user_type_name,class,sex,last_login,login_num,ip_addr
                FROM users
                INNER JOIN user_types ON users.user_type_id = user_types.user_type_id
                INNER JOIN schools ON users.school_id = schools.school_id ORDER By user_id ASC 
                ;";
        $query = $this->db->query($SQL);
        $users_data = $query->result();
        return $users_data;
    }
    ///courseware statistics for access num
    public function get_cwAccessInfo()
    {
        $query = $this->db->get('coursewares');
        return $this->getCwUsingCount($query->result());
    }
    public function getCwUsingCount($cwSets)
    {
        $ret = array();
        foreach ($cwSets as $cw)
        {
            $tmpArr = array(
                'cw_name' =>'',
                'visit_num'=>'0'
            );
            $cw_id = $cw->courseware_id;
            $tmpArr['cw_name'] = $cw->courseware_name;
            ///get total time from courseware_access table
            $this->db->select('*')->from('courseware_accesses')->where('cw_id',$cw_id);
            $query = $this->db->get();
            $tmpArr['visit_num'] = $query->num_rows();
            array_push($ret,$tmpArr);
        }
        return $ret;
    }
    public function cw_accessInfo_search($arr,$startTime,$endTime)
    {
        if(!empty($arr)){
            $this->db->select('*')->from('coursewares')->like($arr);
            $query = $this->db->get();
            $middleData = $query->result();
            return $this->searchByTimeOfCw($middleData,$startTime,$endTime);
        }
        return NULL;
    }
    public function searchByTimeOfCw($middleData,$startTime,$endTime)
    {
        $ret = array();
        foreach ($middleData as $cw)
        {
            $tmpArr = array(
                'cw_name' =>'',
                'visit_num'=>'0'
            );
            $cw_id = $cw->courseware_id;
            $tmpArr['cw_name'] = $cw->courseware_name;
            $visit_num = 0;
            ///get total time from courseware_access table
            $this->db->select('*')->from('courseware_accesses')->where('cw_id',$cw_id);
            $query = $this->db->get();
            foreach ($query->result() as $cw_access)
            {
                $access_time = $cw_access->cw_access_time;
                $visit_num += $this->calculateDiff($startTime,$endTime,$access_time);
            }
            $tmpArr['visit_num'] = $visit_num;
            array_push($ret,$tmpArr);
        }
        return $ret;

    }
    public function calculateDiff($searchStartTime,$searchEndTime,$accessTime)
    {
        $a = new DateTime($searchStartTime);//search time
        $b = new DateTime($searchEndTime);
        $c = new DateTime($accessTime);///access time

        $belowState = $a<$c && $c<$b;
        if($belowState){
            return 1;
        }
        return 0;

    }
    ///subware statistics for access num
    public function get_swAccessInfo()
    {
        $query = $this->db->get('subware_types');
        return $this->getSwUsingCount($query->result());
    }
    public function getSwUsingCount($swSets)
    {
        $ret = array();
        foreach ($swSets as $sw)
        {
            $tmpArr = array(
                'sw_type_name' =>'',
                'visit_num'=>'0'
            );
            $sw_type_id = $sw->subware_type_id;
            $tmpArr['sw_type_name'] = $sw->subware_type_name;
            ///get total visit num from courseware_access table
            $this->db->select('*')->from('subware_accesses')->where('sw_type_id',$sw_type_id);
            $query = $this->db->get();
            $tmpArr['visit_num'] = $query->num_rows();
            array_push($ret,$tmpArr);
        }
        return $ret;
    }
    public function sw_accessInfo_search($arr,$startTime,$endTime)
    {
        if(!empty($arr)){
            $this->db->select('*')->from('subware_types')->like($arr);
            $query = $this->db->get();
            $middleData = $query->result();
            return $this->searchByTimeOfSw($middleData,$startTime,$endTime);
        }
        return NULL;
    }
    public function searchByTimeOfSw($middleData,$startTime,$endTime)
    {
        $ret = array();
        foreach ($middleData as $sw)
        {
            $tmpArr = array(
                'sw_type_name' =>'',
                'visit_num'=>'0'
            );
            $sw_type_id = $sw->subware_type_id;
            $tmpArr['sw_type_name'] = $sw->subware_type_name;
            $visit_num = 0;
            ///get total count from subware table
            $this->db->select('*')->from('subware_accesses')->where('sw_type_id',$sw_type_id);
            $query = $this->db->get();
            foreach ($query->result() as $sw_access)
            {
                $access_time = $sw_access->sw_access_time;
                $visit_num += $this->calculateDiff($startTime,$endTime,$access_time);
            }
            $tmpArr['visit_num'] = $visit_num;
            array_push($ret,$tmpArr);
        }
        return $ret;
    }

}
