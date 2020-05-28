<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Units_m extends MY_Model {

    function __construct() {
        parent::__construct();
    }
    function get_units()
    {
        $this->db->select('*');
        $this->db->from('units');
        $this->db->join('courses', 'units.course_id = courses.course_id','inner');
        $this->db->join('school_types', 'units.school_type_id = school_types.school_type_id','inner');
        $this->db->join('unit_types', 'units.unit_type_id = unit_types.unit_type_id','inner');
        $query = $this->db->get();
        return $query->result();
    }
    function edit($unit_id,$unit_type_name,$unit_image_path)
    {
        $unit_type_id = $this->getUTypeIdFromName($unit_type_name);
        $this->db->set('unit_type_id', $unit_type_id);
        $this->db->set('unit_photo', $unit_image_path);
        $this->db->where('unit_id', $unit_id);
        $this->db->update('units');
        return $this->get_units();
    }
    function getUTypeIdFromName($unit_type_name)
    {
        $this->db->select('unit_type_id')->from('unit_types')->where('unit_type_name',$unit_type_name);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->unit_type_id;
    }
}
