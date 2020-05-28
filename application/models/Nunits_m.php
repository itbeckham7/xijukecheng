<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nunits_m extends MY_Model {

    protected $_table_name = 'new_units';
    protected $_primary_key = 'nunit_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "nunit_id asc";
    function __construct() {
        parent::__construct();
    }
    function get_nunits()
    {
        $this->db->select('*');
        $this->db->from('new_units');
        $this->db->join('new_childcourses', 'new_units.childcourse_id = new_childcourses.childcourse_id','inner');
        $this->db->join('school_types', 'new_childcourses.school_type_id = school_types.school_type_id','inner');
        $this->db->join('courses', 'new_childcourses.course_id = courses.course_id','inner');
        $query = $this->db->get();
        return $query->result();
    }
    function get_nunitByChildCourseId($id)
    {
        return parent::get_where(array('childcourse_id'=>$id));
    }
    function add($arr)
    {
        $error = parent::insert($arr);
        return $this->get_nunits();
    }
    function edit($arr,$nunitId)
    {
        parent::update($arr,$nunitId);
        return $this->get_nunits();
    }
    function delete($nunitId)
    {
        parent::delete($nunitId);
        return $this->get_nunits();
    }
    function publish($nunitId,$publish_cw_st)//$pub_st==1 then publish state, $pub_sd == 0 then unpublish
    {
        $this->db->set('nunit_publish', $publish_cw_st);
        $this->db->where('nunit_id', $nunitId);
        $this->db->update('new_units');
        return $this->get_nunits();
    }
}
