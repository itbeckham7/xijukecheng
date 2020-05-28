<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backendcourses_m extends MY_Model {

    protected $_table_name = 'backend_courses';
    protected $_primary_key = 'bcw_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "bcw_id asc";

    function __construct() {
        parent::__construct();
    }

    public function get_all()
    {
        return parent::get(NULL);
    }

    public function get_ncw()
    {
        $this->db->select('*');
        $this->db->from('backend_courses');
        $this->db->join('courses', 'backend_courses.course_id = courses.course_id','inner');
        $query = $this->db->get();
        return $query->result();
    }
	
    public function get_bcwSets($user_id)
    {
        $this->db->select('*');
        $this->db->from('backend_courses');
        $this->db->join('course_permissions', 'backend_courses.bcw_id = course_permissions.course_id and backend_courses.course_id = course_permissions.course_type','inner');
        $this->db->where('course_permissions.user_id',$user_id);
        $query = $this->db->get();
        return $query->result();
    }
    function get_ncwByChildCourseId($id)
    {
        $this->db->select('*');
        $this->db->from('backend_courses');
        $this->db->where('backend_courses.bcw_id',$id);
        $this->db->join('courses', 'backend_courses.course_id = courses.course_id','inner');
        $query = $this->db->get();
        return $query->result();
    }
    function edit($param,$ncw_id)
    {
        parent::update($param,$ncw_id);
        return $this->get_ncw();
    }
    public function add($param)
    {
        return parent::insert($param);

    }
    public function delete($delete_ncw_id)
    {
        parent::delete($delete_ncw_id);
        return $this->get_ncw();
    }
}
