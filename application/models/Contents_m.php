<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contents_m extends MY_Model
{


    protected $_table_name = 'contents';
    protected $_primary_key = 'content_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "content_id asc";

    function __construct()
    {
        parent::__construct();
    }

    function get_contents($arr = NULL)
    {
        $this->db->select('*');
        $this->db->from('contents');
        if ($arr != NULL) {
            $this->db->where($arr);
        }
        $this->db->join('content_types', 'contents.content_type_id = content_types.content_type_id', 'inner');
        $this->db->join('users', 'content_user_id = user_id', 'inner');
        $this->db->join('schools', 'schools.school_id = users.school_id', 'inner');
        $this->db->order_by('contents.share_time', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }

    function insert_contents($array)
    {
        $error = parent::insert($array);
        return TRUE;
    }

    function update_contents($data, $id = NULL)
    {
        parent::update($data, $id); // TODO: Change the autogenerated stub
        return $id;
    }

    function update_contents_view_num($content_id)
    {
        $this->db->set('view_num', 'view_num+1', FALSE);
        $this->db->where('content_id', $content_id);
        $this->db->update('contents');
    }

    function update_vote_num($content_id, $voteSt)///for incresement of content vote num
    {
        if ($voteSt == '1') $this->db->set('vote_num', 'vote_num+1', FALSE);
        else $this->db->set('vote_num', 'vote_num-1', FALSE);

        $this->db->where('content_id', $content_id);
        $this->db->update('contents');

        $updatedInfo = parent::get_single(array('content_id' => $content_id));
        return $updatedInfo->vote_num;
    }

    function delete($content_id)
    {
        parent::delete($content_id);
    }

    function get_work($user_id, $content_type_id)
    {
        $arr = 'content_user_id = ' . $user_id . ' AND';

        if ($content_type_id == 2) {
            $arr .= ' content_types.content_type_id = 2 OR content_types.content_type_id = 3 OR content_types.content_type_id = 4';
        } else {
            $arr .= ' content_types.content_type_id = ' . $content_type_id;
        }
        $selList = 'content_id,content_title,content_user_id,view_num,contents.content_type_id,fullname,local,contents.public,contents.publish';
        $this->db->select($selList);
        $this->db->from('contents');
        $this->db->where($arr);
        $this->db->join('content_types', 'contents.content_type_id = content_types.content_type_id', 'inner');
        $this->db->join('users', 'contents.content_user_id = users.user_id', 'inner');
        $this->db->order_by('content_id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_where($array = NULL)
    {
        return parent::get_where($array); // TODO: Change the autogenerated stub
    }

    function get_single($array = NULL)
    {
        return parent::get_single($array); // TODO: Change the autogenerated stub
    }

    function get_contentByTimeAndViewNum($orderByField)//
    {
        $this->db->select('*');
        $this->db->from('contents');
        $this->db->where('contents.publish', '1');
        $this->db->order_by($orderByField, 'DESC');
        $this->db->join('content_types', 'contents.content_type_id = content_types.content_type_id', 'inner');
        $this->db->join('users', 'content_user_id = user_id', 'inner');
        $this->db->join('schools', 'schools.school_id = users.school_id', 'inner');
        $query = $this->db->get();
        return $query->result();
    }

    function get_contentByContentType($orderByField, $contentTyeId)
    {
        $arr = 'contents.publish = 1 AND';

        if ($contentTyeId == 2) {
            $arr .= ' content_types.content_type_id = 2 OR content_types.content_type_id = 3 OR content_types.content_type_id = 4';
        } else {
            $arr .= ' content_types.content_type_id = ' . $contentTyeId;
        }

        $this->db->select('*');
        $this->db->from('contents');
        $this->db->where($arr);
        $this->db->order_by($orderByField, 'DESC');
        $this->db->join('content_types', 'contents.content_type_id = content_types.content_type_id', 'inner');
        $this->db->join('users', 'content_user_id = user_id', 'inner');
        $this->db->join('schools', 'schools.school_id = users.school_id', 'inner');
        $query = $this->db->get();
        return $query->result();
    }

    function isDuplication($content_title)
    {
        $query = $this->db->get_where('contents', array('content_title' => $content_title));
        $results = $query->row();
        $count = $query->num_rows(); //counting result from query
        if ($count === 0) {
            return array('status' => 'NOEXIST', 'content_path' => '', 'content_id' => '');
        }
        return array('status' => 'EXIST', 'content_id' => $results->content_id, 'content_path' => $results->file_name);
    }
}

?>