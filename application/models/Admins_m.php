<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins_m extends MY_Model {

    protected $_table_name = 'admins';
    protected $_primary_key = 'admin_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "admin_id asc";

    function __construct() {
        parent::__construct();
    }
    function get_admin() {
        $query = $this->db->get('admins');
        return $query->result();
    }
    function get_single_admin($admin_id)
    {
        $arr = array(
            'admin_id'=>$admin_id
        );
        return parent::get_single($arr);
    }
    function add($arr) {

        $arr['admin_pass'] = $this->hash($arr['admin_pass']);
        $this->db->insert('admins', $arr);
        return $this->get_admin();
    }
    function edit($arr, $admin_id) {
        $this->db->where('admin_id', $admin_id);
        $this->db->update('admins', $arr);
        return $this->get_admin();
    }
    public function delete($delete_admin_id)
    {
        $this -> db -> where('admin_id', $delete_admin_id);
        $this -> db -> delete('admins');
    }
    public function hash($string) {
        return parent::hash($string);
    }
}
?>