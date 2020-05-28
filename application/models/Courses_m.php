    <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses_m extends MY_Model {


    protected $_table_name = 'courses';
    protected $_primary_key = 'course_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "course_id asc";

    function __construct() {
        parent::__construct();
    }
    public function get_courses($arr = array())
    {
        $this->db->select('*');
        $this->db->from('courses');
        $this->db->where($arr);
        $this->db->join('school_types', 'courses.school_type_id = school_types.school_type_id','inner');
        $query = $this->db->get();
        return $query->result();
    }
    function get_all_courses()
    {
        return parent::get(NULL);
    }
    public function edit($cs_id,$cs_desc,$cs_school_type_name)
    {
        $this->db->set('course_desc', $cs_desc);
        $this->db->where('course_id', $cs_id);
        $this->db->update('courses');
    }
    function add($arr)
    {
        $error = parent::insert($arr);
    }


}
