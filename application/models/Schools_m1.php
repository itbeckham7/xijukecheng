<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schools_m extends MY_Model {

    function __construct() {
        parent::__construct();
    }
    public function get_schools()
    {
         $this->db->select('*')->from('schools')->where('stop','1');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_all_schools()
    {
        $this->db->select('*')->from('schools');
        $query = $this->db->get();
        return $query->result();
    }
    public function edit($school_id,$school_name,$class_arr)
    {
        $arr = array(
            'school_name' => $school_name,
            'class_arr' => json_encode($class_arr),
        );
        $this->db->where('school_id', $school_id);
        $this->db->update('schools',$arr);
        return $this->get_all_schools();
    }
    public function add($school_name,$class_arr)
    {
        $arr = array(
            'school_name' => $school_name,
            'class_arr' => json_encode($class_arr),
            'stop' => '0'
        );
        $this->db->set($arr);
        $this->db->insert('schools');
        return $this->get_all_schools();

    }
    public function delete($school_id)
    {
        $this -> db -> where('school_id', $school_id);
        $this -> db -> delete('schools');
        return $this->get_all_schools();
    }
    public function publish($school_id,$stop_st)//$stop_st==1 then enabled state, $stop_st == 0 then Disabled
    {
        $this->db->set('stop', $stop_st);
        $this->db->where('school_id', $school_id);
        $this->db->update('schools');
    }
    public function get_classLists($school_name)
    {
        $this->db->select('class_arr, school_id')->from('schools')->where('school_name',$school_name);
        $query = $this->db->get();
        return $query->result();
    }
    public function getSchoolIdFromName($school_name)
    {
        $this->db->select('school_id')->from('schools')->where('school_name',$school_name);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->school_id;
    }
    public function getSchoolNameIdFromId($school_id)
    {
        $this->db->select('school_name')->from('schools')->where('school_id',$school_id);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->school_name;
    }
    public function  getSchoolTypeIdFromName($schoolTypeId)
    {
        $this->db->select('school_type_id')->from('school_types')->where('school_type_name',$schoolTypeId);
        $query = $this->db->get();
        $ret = $query->row();
        if($ret!=NULL)
        return $ret->school_type_id;
        else return 1;
    }

}
