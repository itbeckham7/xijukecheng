<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subwares_m extends MY_Model
{

    protected $_table_name = 'subwares';
    protected $_primary_key = 'subware_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "subware_id asc";

    function __construct()
    {
        parent::__construct();
    }

    public function get_sw($arr = array())
    {
        $sws_data = array();
        $this->db->select('subwares.*,'
            . 'courseware_num,subware_type_name,'
            . 'course_name,unit_type_name,'
            . 'courseware_name,school_type_name'
        );
        $this->db->from('subwares');
        if ($arr) $this->db->where($arr);
        $this->db->join('subware_types', 'subwares.subware_type_id = subware_types.subware_type_id', 'inner');
        $this->db->join('coursewares', 'subwares.courseware_id = coursewares.courseware_id', 'inner');
        $this->db->join('courses', 'coursewares.course_id = courses.course_id', 'inner');
        $this->db->join('unit_types', 'coursewares.unit_type_id = unit_types.unit_type_id', 'inner');
        $this->db->join('school_types', 'coursewares.school_type_id = school_types.school_type_id', 'inner');
        $this->db->order_by('subwares.courseware_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function edit($param, $id = 0)
    {
        if ($id != 0) parent::update($param, $id);
        return $this->db->affected_rows();
    }

    public function add($param)
    {
        ///At first check duplicated record(courseware_id, subware_type_id)
        if (true || $this->checkDuplicatedRecord(
                $param['courseware_id'], $param['subware_type_id'])
        ) {
            $error = parent::insert($param);
        }
        return $this->db->affected_rows();
    }

    public function delete($delete_sw_id)
    {
        parent::delete($delete_sw_id);
        return $this->get_sw();
    }

    public function publish($publish_sw_id, $publish_sw_st)//$pub_st==1 then publish state, $pub_sd == 0 then unpublish
    {
        $arr = array(
            'publish' => $publish_sw_st,
        );
        parent::update($arr, $publish_sw_id);
    }

    public function getSWTypeNames()
    {
        $query = $this->db->get('subware_types');
        return $query->result();
    }

    public function getSWTypeIdFromName($sw_type_name)//get subware type id from sub type name
    {
        $this->db->select('subware_type_id')
            ->from('subware_types')
            ->where('subware_type_name', $sw_type_name);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->subware_type_id;
    }

    public function getSWTypeSlugFromName($sw_type_name)//get subware type id from sub type name
    {
        $this->db->select('subware_type_slug')
            ->from('subware_types')
            ->where('subware_type_name', $sw_type_name);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->subware_type_slug;
    }

    public function getCWIdFromName($cw_name)//get courseware id from courseware name
    {
        $this->db->select('courseware_id')->from('coursewares')->where('courseware_name', $cw_name);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->courseware_id;
    }

    function checkDuplicatedRecord($cw_id, $sw_type_id)
    {
        $arr = array(
            'courseware_id' => $cw_id,
            'subware_type_id' => $sw_type_id
        );
        $swSets = parent::get_where($arr);
        if (count($swSets) != 0) return false;
        return true;
    }

    ////below function is used for frontend side.
    public function get_swForFrontend($cw_id)
    {
        $this->db->select(
            'subware_id,subware_file,' .
            'subwares.subware_type_id,' .
            'subwares.title,' .
            'subware_type_name,subware_type_slug,' .
            'courseware_num,course_name,' .
            'unit_type_name,courseware_name,' .
            'school_type_name,subwares.publish'
        );
        $this->db->from('subwares');
        $this->db->where('subwares.courseware_id', $cw_id);
        $this->db->join('subware_types', 'subwares.subware_type_id = subware_types.subware_type_id', 'inner');
        $this->db->join('coursewares', 'subwares.courseware_id = coursewares.courseware_id', 'inner');
        $this->db->join('courses', 'coursewares.course_id = courses.course_id', 'inner');
        $this->db->join('unit_types', 'coursewares.unit_type_id = unit_types.unit_type_id', 'inner');
        $this->db->join('school_types', 'coursewares.school_type_id = school_types.school_type_id', 'inner');
        $this->db->order_by('subwares.subware_type_id', 'ASC');
        $query = $this->db->get();
        return $query->result();

    }

    public function get_new_id($array = NULL)
    {
        $this->db->select('max(subware_id) as fileId');
        $this->db->from($this->_table_name);
        return $this->db->get()->result();
    }

    public function get_where($array = NULL)
    {
        return parent::get_where($array); // TODO: Change the autogenerated stub
    }

}
