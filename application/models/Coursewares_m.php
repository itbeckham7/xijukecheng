<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coursewares_m extends MY_Model
{

    protected $_table_name = 'coursewares';
    protected $_primary_key = 'courseware_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "courseware_id asc";

    function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        return parent::get(NULL);
    }

    public function get_cw($arr = array())
    {
        $this->db->select('*');
        if($arr) $this->db->where($arr);
        $this->db->from('coursewares');
        $this->db->join('unit_types', 'coursewares.unit_type_id = unit_types.unit_type_id', 'inner');
        $this->db->join('school_types', 'coursewares.school_type_id = school_types.school_type_id', 'inner');
        $this->db->join('courses', 'coursewares.course_id = courses.course_id', 'inner');
        $query = $this->db->get();
        return $query->result();
    }

    public function getCoursewareById($id=0)
    {
        $this->db->select('*');
        $this->db->from('coursewares');
        $this->db->join('unit_types', 'coursewares.unit_type_id = unit_types.unit_type_id','inner');
        $this->db->join('school_types', 'coursewares.school_type_id = school_types.school_type_id','inner');
        $this->db->join('courses', 'coursewares.course_id = courses.course_id','inner');
        $this->db->where('coursewares.courseware_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function edit($param)
    {
        $cwid = $param['cw_id'];
        $cwsn = $param['cw_sn'];
        $cwname = $param['cw_name'];
        $utname = $param['unit_type_name'];
        $stid = $param['school_type_id'];
        $csid = $param['course_name'];
        $imagepath = $param['cw_image_path'];
        $cwtype = $param['cw_type'];
        $cw_price = $cwtype == '1' ? $param['price'] : 0;
        $utid = $this->getUTypeIdFromName($utname);

        $arr = array(
            'courseware_name' => $cwname,
            'courseware_num' => $cwsn,
            'unit_type_id' => $utid,
            'school_type_id' => $stid,
            'course_id' => $csid,
            'platform_type' => $cwtype,
            'free' => $param['free'],
            'price'=>$cw_price
        );

        if ($imagepath != '') $arr['courseware_photo'] = $imagepath;

        $this->db->where('courseware_id', $cwid);
        $this->db->update('coursewares', $arr);
        return $this->get_cw(array('platform_type' => $cwtype));
    }

    public function add($param)
    {
        $utname = $param['unit_type_name'];
        $stid = $param['school_type_id'];
        $csid = $param['course_name'];
        $cwtype = $param['cw_type'];
        $utid = $this->getUTypeIdFromName($utname);
        $cw_price = $cwtype == '1' ? $param['price'] : 0;
        $arr = array(
            'courseware_name' => $param['cw_name'],
            'courseware_num' => $param['cw_sn'],
            'unit_type_id' => $utid,
            'school_type_id' => $stid,
            'course_id' => $csid,
            'courseware_photo' => $param['cw_image_path'],
            'platform_type' => $cwtype,
            'view_num' => '0',
            'publish' => '0',
            'free' => $param['free'],
            'price'=>$cw_price
        );
        $this->db->set($arr);
        $this->db->insert('coursewares');
        return $this->db->insert_id();
    }

    public function delete($delete_cw_id)
    {
        $this->db->where('courseware_id', $delete_cw_id);
        $this->db->delete('coursewares');
        return $this->get_cw();
    }

    public function publish($publish_cw_id, $publish_cw_st)//$pub_st==1 then publish state, $pub_sd == 0 then unpublish
    {
        $this->db->set('publish', $publish_cw_st);
        $this->db->where('courseware_id', $publish_cw_id);
        $this->db->update('coursewares');
        return $this->get_cw();
    }

    public function getUTypeIdFromName($unit_type_name)
    {
        $this->db->select('unit_type_id')->from('unit_types')->where('unit_type_name', $unit_type_name);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->unit_type_id;
    }

    public function getSTypeIdFromName($school_type_name)//get school type id
    {
        $this->db->select('school_type_id')->from('school_types')->where('school_type_name', $school_type_name);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->school_type_id;
    }

    public function getCSIdFromName($cs_name)
    {
        $this->db->select('course_id')->from('courses')->where('course_name', $cs_name);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->course_id;

    }

    public function getLastId(){
        return $this->db->insert_id();
    }

    public function get_where($arr = array())
    {
//        $array = array();
//        foreach ($arr as $key => $value) {
//            $array[$this->_table_name . '.' . $key] = $value;
//        }
        $this->db->from($this->_table_name);
        $this->db->where($arr)
            ->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->result();
    }

}
