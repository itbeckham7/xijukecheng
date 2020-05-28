<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nchildcourses_m extends MY_Model {


    protected $_table_name = 'new_childcourses';
    protected $_primary_key = 'childcourse_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "childcourse_id asc";

    function __construct() {
        parent::__construct();
    }
    public function get_all()
    {
        return parent::get(NULL);
    }
    public function get_nchild_courses()
    {
        $this->db->select('*');
        $this->db->from('new_childcourses');
        $this->db->join('school_types', 'new_childcourses.school_type_id = school_types.school_type_id','inner');
        $this->db->join('courses', 'new_childcourses.course_id = courses.course_id','inner');
        $query = $this->db->get();
        return $query->result();
    }
    function get_nchild_publish()
    {
        $this->db->select('*');
        $this->db->from('new_childcourses');
        $this->db->where('childcourse_publish','1');
        $this->db->join('school_types', 'new_childcourses.school_type_id = school_types.school_type_id','inner');
        $this->db->join('courses', 'new_childcourses.course_id = courses.course_id','inner');

        $query = $this->db->get();
        return $query->result();
    }
    function edit($arr,$id)
    {
        parent::update($arr,$id);
        return $this->get_nchild_courses();
    }
    function add($arr)
    {
        $error = parent::insert($arr);
        return $this->get_nchild_courses();
    }
    function delete($ncssId)
    {
        parent::delete($ncssId);
        return $this->get_nchild_courses();
    }
    public function publish($nccsid,$publish_cw_st)//$pub_st==1 then publish state, $pub_sd == 0 then unpublish
    {
        $this->db->set('childcourse_publish', $publish_cw_st);
        $this->db->where('childcourse_id', $nccsid);
        $this->db->update('new_childcourses');
        return $this->get_nchild_courses();
    }



}
