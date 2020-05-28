<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ncoursewares_m extends MY_Model {

    protected $_table_name = 'new_coursewares';
    protected $_primary_key = 'ncw_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "ncw_id asc";

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
        $this->db->from('new_coursewares');
        $this->db->join('new_units', 'new_coursewares.nunit_id = new_units.nunit_id','inner');
        $this->db->join('new_childcourses', 'new_units.childcourse_id = new_childcourses.childcourse_id','inner');
        $this->db->join('school_types', 'new_childcourses.school_type_id = school_types.school_type_id','inner');
        $this->db->join('courses', 'new_childcourses.course_id = courses.course_id','inner');
        $query = $this->db->get();
        return $query->result();
    }
    function get_ncwByChildCourseId($id)
    {
        $this->db->select('*');
        $this->db->from('new_coursewares');
        $this->db->where('new_childcourses.childcourse_id',$id);
        $this->db->join('new_units', 'new_coursewares.nunit_id = new_units.nunit_id','inner');
        $this->db->join('new_childcourses', 'new_units.childcourse_id = new_childcourses.childcourse_id','inner');
        $this->db->join('school_types', 'new_childcourses.school_type_id = school_types.school_type_id','inner');
        $this->db->join('courses', 'new_childcourses.course_id = courses.course_id','inner');
        $query = $this->db->get();
        return $query->result();
    }
    function edit($param,$ncw_id)
    {
        parent::update($param,$ncw_id);
        return $this->get_ncw();
    }
    function getBelongTitleByCwId($ncwId)
    {
        $this->db->select('*');
        $this->db->from('new_coursewares');
        $this->db->where('new_coursewares.ncw_id',$ncwId);

        $this->db->join('new_units', 'new_coursewares.nunit_id = new_units.nunit_id','inner');
        $this->db->join('new_childcourses', 'new_units.childcourse_id = new_childcourses.childcourse_id','inner');

        $query = $this->db->get();
        $cwInfo = $query->row();

        return $cwInfo->childcourse_name.'-'.$cwInfo->ncw_name;
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
    public function publish($ncw_id,$publish_cw_st)//$pub_st==1 then publish state, $pub_sd == 0 then unpublish
    {
        $this->db->set('ncw_publish', $publish_cw_st);
        $this->db->where('ncw_id', $ncw_id);
        $this->db->update('new_coursewares');
        return $this->get_ncw();
    }
}
