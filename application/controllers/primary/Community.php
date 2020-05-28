<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Community extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('frontend', $language);
        $this->load->model('contents_m');
        $this->load->model('comments_m');
        $this->load->model('users_m');
        $this->load->model('signin_m');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index()
    {

        if ($this->signin_m->loggedin()) {
            $contentSets = $this->contents_m->get_contents(array('contents.publish' => '1'));
            $this->data['contentList'] = $this->output_custom_content($contentSets);
            $this->data["subview"] = "primary/community/index";
            $this->load->view('primary/_layout_main', $this->data);
        } else {
            redirect(base_url() . 'signin/index');
        }

    }

    public function view($content_id)//this function show comment page
    {

        $this->contents_m->update_contents_view_num($content_id);

        if ($this->signin_m->loggedin()) {

            ///get user id of content from content_id
            $contentInfo = $this->contents_m->get_single(array('content_id' => $content_id));
            $content_user_id = $contentInfo->content_user_id;
            $content_type_id = $contentInfo->content_type_id;
            $courseware_id = $contentInfo->courseware_id;

            $userInfo = $this->users_m->get_single_user($content_user_id);
            $user_nickname = $userInfo->nickname;
            $user_school = $userInfo->school_name;

            $this->data['user_id'] = $content_user_id;///current user id of content;
            $this->data['content_id'] = $content_id;
            $this->data['content_type_id'] = $content_type_id;
            $this->data['content_title'] = $contentInfo->content_title;
            $this->data['fullname'] = $this->users_m->getFullNameFromUserId($content_user_id);///current student name;
            $this->data['user_nickname'] = $user_nickname;
            $this->data['user_school'] = $user_school;
            $this->data['content_type_id'] = $content_type_id;
            $this->data['courseware_id'] = $courseware_id;
            $this->data['vote_num'] = $contentInfo->vote_num;

            if ($content_type_id == '1') {///script work

                $script_html = $this->get_scriptDetails($contentInfo->file_name);
                $this->data['scriptText'] = $this->script_img_replace($script_html, $courseware_id);
                $this->data["subview"] = "primary/community/content";

            } else if ($content_type_id == '5') {

                $this->data['headImagePath'] = $contentInfo->file_name;
                $this->data["subview"] = "primary/community/content";

            } else if ($content_type_id == '6') {

                $this->data['videoPath'] = $contentInfo->file_name;
                $this->data["subview"] = "primary/community/content_shooting";

            } else {

                $this->data['wavPath'] = $contentInfo->file_name;
                $this->data["bgPath"] = $contentInfo->bg_path;
                $this->data["subview"] = "primary/community/content_dubbing";
            }
            $this->data['commentSets'] = $commentsSets = $this->comments_m->get_where_full_comments(array('comments.content_id' => $content_id));
            $this->load->view('primary/_layout_main', $this->data);
        } else {
            redirect(base_url() . 'signin/index');
        }
    }

    public function get_scriptDetails($filePath)
    {
        $scriptLines = '';
        if (!file_exists($filePath)) {
            return $scriptLines;
        } else {
            $scriptFile = fopen($filePath, "r");
            $scriptLines = fread($scriptFile, filesize($filePath));
        }
        return $scriptLines;
    }

    public function orderBySelect()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            if ($_POST['orderBySelect'] == '1') {
                $contentSet = $this->contents_m->get_contentByTimeAndViewNum('share_time');
                $ret['data'] = $this->output_custom_content($contentSet);
                $ret['status'] = 'success';
            } else {
                $contentSet = $this->contents_m->get_contentByTimeAndViewNum('view_num');
                $ret['data'] = $this->output_custom_content($contentSet);
                $ret['status'] = 'success';
            }
        }
        echo json_encode($ret);
    }

    public function orderByContentType()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $selectedField = '';
            $content_type_id = $_POST['content_type_id'];

            if ($_POST['orderBySelect'] == '1') {
                $selectedField = 'share_time';
            } else {
                $selectedField = 'view_num';
            }
            $contentSet = $this->contents_m->get_contentByContentType($selectedField, $content_type_id);
            $ret['data'] = $this->output_custom_content($contentSet);
            $ret['status'] = 'success';

        }
        echo json_encode($ret);

    }

    public function add_comment()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = array(
                'content_id' => $_POST['content_id'],
                'comment_desc' => $_POST['comment_desc'],
                'comment_user_id' => $_POST['comment_user_id'],
                'create_time' => date('Y-m-d H:i:s')
            );
            $this->comments_m->insert($arr);
            $commentsSets = $this->comments_m->get_where_full_comments(array('comments.content_id' => $_POST['content_id']));
            $ret['data'] = $this->output_comments($commentsSets);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);

    }

    function update_voteNum()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $content_id = $_POST['content_id'];
            $voteSt = $_POST['vote_status'];
            $updatedVoteNum = $this->contents_m->update_vote_num($content_id, $voteSt);
            $ret['data'] = $updatedVoteNum;
            $ret['status'] = 'success';
        }
        echo json_encode($ret);

    }

    public function output_content($contents)
    {
        $daysAgoStr = $this->lang->line('DaysAgo');
        $monthAgoStr = $this->lang->line('MonthsAgo');
        $yearAgoStr = $this->lang->line('YearsAgo');
        $todayStr = $this->lang->line('Today');
        $ago = '';

        $output = '';
        foreach ($contents as $content):
            $output .= '<tr>';
            $output .= '<td>';
            $output .= '<a href = "' . base_url('primary/') . 'community/view/' . $content->content_id . '">';
            $output .= '【' . $content->content_type_name . '】' . $content->content_title;
            $output .= '</a></td>';
            $output .= '<td><a href = "';
            $output .= base_url('primary/') . 'users/profile/' . $content->content_user_id . '">';
            $output .= $content->fullname . '</a></td>';
            $output .= '<td>' . $content->school_name . '</td>';
            $output .= '<td>' . $content->view_num . '</td>';

            $date1 = new DateTime($content->share_time);
            $date2 = new DateTime("now");
            $interval = $date1->diff($date2);
            $years = $interval->format('%y');
            $months = $interval->format('%m');
            $days = $interval->format('%d');
            if ($years != 0) {
                $ago = $years . $yearAgoStr;
            } else {
                if ($months != 0) {
                    $ago = $months . $monthAgoStr;
                } else {
                    if ($days != 0) $ago = $days . $daysAgoStr;
                    else $ago = $todayStr;
                }
            }

            $output .= '<td>' . $ago . '</td>';////during time
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function output_custom_content($contents)
    {
        $daysAgoStr = $this->lang->line('DaysAgo');
        $monthAgoStr = $this->lang->line('MonthsAgo');
        $yearAgoStr = $this->lang->line('YearsAgo');
        $todayStr = $this->lang->line('Today');
        $ago = '';
        $returnArr = array();
        foreach ($contents as $content):
            $date1 = new DateTime($content->share_time);
            $date2 = new DateTime("now");
            $interval = $date1->diff($date2);
            $years = $interval->format('%y');
            $months = $interval->format('%m');
            $days = $interval->format('%d');
            if ($years != 0) {
                $ago = $years . $yearAgoStr;
            } else {
                if ($months != 0) {
                    $ago = $months . $monthAgoStr;
                } else {
                    if ($days != 0) $ago = $days . $daysAgoStr;
                    else $ago = $todayStr;
                }
            }
            $tempObj = new stdClass();
            $tempObj->title = '【' . $content->content_type_name . '】' . $content->content_title;
            $tempObj->content_url = base_url('primary/') . 'community/view/' . $content->content_id;
            $tempObj->profile_url = base_url('primary/') . 'users/profile/' . $content->content_user_id;
            $tempObj->author = $content->fullname;
            $tempObj->school = $content->school_name;
            $tempObj->view_num = $content->view_num;
            $tempObj->share_time = $ago;
            array_push($returnArr, $tempObj);
        endforeach;
        return $returnArr;
    }

    public function output_comments($comments)
    {

        $output = '';
        foreach ($comments as $comment):
            $output .= '<div class="comment_item_area">';
            $output .= '<p style="font-weight: bold">' . $comment->fullname . '&nbsp&nbsp&nbsp&nbsp&nbsp' . $comment->create_time . '</p>';
            $output .= '<p style="color:#6cc">' . $comment->comment_desc . '</p>';
            $output .= '</div>';
        endforeach;
        return $output;
    }

    private function script_img_replace($html, $courseware_id)
    {
        $path = base_url() . 'uploads/courseware/' . $courseware_id . '/script/images/characters';
        $ret = str_replace("images/characters", $path, $html);
        return $ret;
    }

}

?>