<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $language = 'chinese';
        $this->load->model("users_m");
        $this->load->model("schools_m");
        $this->load->model("courses_m");
        $this->load->model("coursewares_m");
        $this->load->model("nchildcourses_m");
        $this->load->model("backendcourses_m");
        $this->load->model("coursepermissions_m");
        $this->lang->load('accounts', $language);
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
    }

    public function index()
    {
        $this->data['menu'] = '42';
        $this->data['pageTitle'] = '用户管理';
        $this->data['schools'] = $this->schools_m->get_all_schools();
        $this->data['users'] = $this->users_m->get_users();
        $this->data['courses'] = $this->courses_m->get_all_courses();

        $this->data['kebenju_list'] = $this->coursewares_m->get_all();
        $this->data['sandapian_list'] = $this->nchildcourses_m->get_all();
        $this->data['backcourse_list'] = $this->backendcourses_m->get_all();

        $this->data["subview"] = "admin/users/index";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function normalize_permission()
    {
        $ret = array(
            'data' => '',
            'status' => 'success',
        );

        $users = $this->users_m->get(NULL);
        foreach ($users as $user):
            $purchaseInfo = json_decode($user->buycourse_arr);
            $this->coursepermissions_m->delete_where(array('user_id' => $user->user_id));
            if ($purchaseInfo->kebenju == '1') {
                $this->coursepermissions_m->insert(array('user_id' => $user->user_id, 'course_type' => '1', 'course_id' => 1));
            }
            if ($purchaseInfo->sandapian == '1') {
                $this->coursepermissions_m->insert(array('user_id' => $user->user_id, 'course_type' => '2', 'course_id' => 1));
            }
        endforeach;
        echo json_encode($ret);
    }

    public function add()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $fullname = $_POST['add_fullname'];
            $username = $_POST['add_username'];

            $userInfo = $this->db->get_where('users', array("username" => $username));
            if ($userInfo->result() != null) {
                $ret['status'] = 'fail';
                $ret['data'] = '当前用户名被其他用户使用。';
                echo json_encode($ret);
                return;
            }

            $password = $_POST['add_userpassword'];
            $sex_name = $_POST['add_user_sex'];
            $school_name = $_POST['add_user_school_name'];
            $user_type_id = $_POST['add_user_type_id'];
            $user_class = $_POST['add_grade_class'];
            $buycs_list = $_POST['buycourse_arr'];

            $dt = new DateTime();
            $currentTime = $dt->format('Y-m-d H:i:s');
            $param = array(
                'fullname' => $fullname,
                'username' => $username,
                'password' => $password,
                'sex' => $sex_name,
                'school_name' => $school_name,
                'user_type_id' => $user_type_id,
                'user_class_name' => $user_class,
                'reg_time' => $currentTime,
                'buycourse_arr' => $buycs_list,
                'publish' => '0'
            );

            $insertInfo = $this->users_m->add($param);
            $this->data['users'] = $insertInfo['users'];
            $ret['data'] = $this->output_content($this->data['users']);
            $ret['status'] = 'success';

            $buycs_kb_list = json_decode($_POST['buycourse_kb']);
            $buycs_sd_list = json_decode($_POST['buycourse_sd']);
            $buycs_gr_list = json_decode($_POST['buycourse_gr']);

            foreach ($buycs_kb_list as $kbp):
                $this->coursepermissions_m->insert(array('user_id' => $insertInfo['user_id'], 'course_type' => '1', 'course_id' => $kbp));
            endforeach;

            foreach ($buycs_sd_list as $sdp):
                $this->coursepermissions_m->insert(array('user_id' => $insertInfo['user_id'], 'course_type' => '2', 'course_id' => $sdp));
            endforeach;

            foreach ($buycs_gr_list as $sdp):
                $this->coursepermissions_m->insert(array('user_id' => $insertInfo['user_id'], 'course_type' => '3', 'course_id' => $sdp));
            endforeach;

        }
        echo json_encode($ret);
    }

    public function get_permissions()
    {
        $ret = array(
            'data' => 'None Data',
            'status' => 'success'
        );
        if ($_POST) {
            $userId = $_POST['user_id'];
            $ret['data'] = $this->coursepermissions_m->get_where(array('user_id' => $userId));
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function edit()
    {
        $ret = array(
            'data' => 'None Data',
            'status' => 'success'
        );
        if ($_POST) {
            $password = '';
            $userId = $_POST['user_id'];
            $fullname = $_POST['edit_fullname'];
            $sex = $_POST['edit_user_sex'];
            $school_name = $_POST['edit_user_school_name'];
            $user_type_id = $_POST['edit_user_type_id'];
            $user_class = $_POST['edit_grade_class'];
            $password_status = $_POST['password_status'];
            $buycs_list = $_POST['buycourse_arr'];

            $buycs_kb_list = json_decode($_POST['buycourse_kb']);
            $buycs_sd_list = json_decode($_POST['buycourse_sd']);
            $buycs_gr_list = json_decode($_POST['buycourse_gr']);

            //Delete All Previous Permissions
            $this->coursepermissions_m->delete_where(array('user_id' => $userId));
            foreach ($buycs_kb_list as $kbp):
                $this->coursepermissions_m->insert(array('user_id' => $userId, 'course_type' => '1', 'course_id' => $kbp));
            endforeach;

            foreach ($buycs_sd_list as $sdp):
                $this->coursepermissions_m->insert(array('user_id' => $userId, 'course_type' => '2', 'course_id' => $sdp));
            endforeach;
            foreach ($buycs_gr_list as $sdp):
                $this->coursepermissions_m->insert(array('user_id' => $userId, 'course_type' => '3', 'course_id' => $sdp));
            endforeach;

            $dt = new DateTime();
            $currentTime = $dt->format('Y-m-d H:i:s');

            if ($password_status === '1') {
                $password = $_POST['edit_usernewpassword'];
            }

            $param = array(
                'user_id' => $userId,
                'fullname' => $fullname,
                'sex' => $sex,
                'school_name' => $school_name,
                'user_type_id' => $user_type_id,
                'class' => $user_class,
                'password_status' => $password_status,
                'buycourse_arr' => $buycs_list,
                'password' => $password,
                'reg_time' => $currentTime
            );

            $this->data['users'] = $this->users_m->edit($param);
            $ret['data'] = $this->output_content($this->data['users']);
            $ret['status'] = 'success';

        }
        echo json_encode($ret);
    }

    public function delete()///this function is to delete multiple
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $userIds = $_POST['userIds'];
            foreach ($userIds as $userId):
                $this->users_m->delete($userId);
            endforeach;
            $this->data['users'] = $this->users_m->get_users();
            $ret['data'] = $this->output_content($this->data['users']);
            $ret['status'] = 'success';

        }
        echo json_encode($ret);
    }

    public function delete_single()//this function is to delete single items
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $user_id = $_POST['user_id'];
            $this->users_m->delete($user_id);
            $this->data['users'] = $this->users_m->get_users();
            $ret['data'] = $this->output_content($this->data['users']);
            $ret['status'] = 'success';

        }
        echo json_encode($ret);
    }

    public function publish()
    {
        $ret = array(
            'data' => '',
            'status' => 'success'
        );
        if ($_POST) {
            $user_id = $_POST['user_id'];
            $publish_st = $_POST['publish_st'];
            $this->users_m->publish($user_id, $publish_st);
            //$ret['data'] = $this->output_content($this->data['swsets']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function bulk_download()
    {
        if ($_POST) {
            $arr = $this->bulkAddUsers($_POST);

            //$this->users_m->bulkAddUsers($arr);

            $this->data['school_name'] = $this->schools_m->getSchoolNameIdFromId($_POST['add_bulk_school_id']);
            $this->data['user_type_name'] = $this->users_m->get_userTypeNameFromID($_POST['add_bulk_user_type']);
            $this->data['user_type_id'] = $_POST['add_bulk_user_type'];
            $this->data['users'] = $arr;
            $this->data["subview"] = "admin/users/bulk_download";
            $this->data["subscript"] = "admin/settings/script";
            $this->data["subcss"] = "admin/settings/css";
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function bulkAddUsers()
    {
        $dt = new DateTime();
        $currentTime = $dt->format('Y-m-d H:i:s');
        $userCounts = $_POST['add_bulk_quantity'];
        $buyCourseSt = array('kebenju' => '0', 'sandapian' => '0', 'grammar' => '0');
        $buyCourseSt['kebenju'] = ($this->input->post('kebenju') == 'on') ? '1' : '0';
        $buyCourseSt['sandapian'] = ($this->input->post('sandapian') == 'on') ? '1' : '0';
        $buyCourseSt['grammar'] = ($this->input->post('grammar') == 'on') ? '1' : '0';

        $kb_buy = $this->input->post('kb_buy');
        $sd_buy = $this->input->post('sd_buy');
        $gr_buy = $this->input->post('gr_buy');

        $bulkUsers = array();
        for ($j = 0; $j < $userCounts; $j++)///bulk users counts
        {
            $username = $this->getRandomString();
            $eachUser = array(
                'username' => $username,
                'password' => $this->users_m->hash('1'),
                'school_id' => $_POST['add_bulk_school_id'],
                'user_type_id' => $_POST['add_bulk_user_type'],
                'buycourse_arr' => json_encode($buyCourseSt),
                'reg_time' => $currentTime,
                'publish' => '1'
            );

            $insertID = $this->users_m->insert($eachUser);
			if($kb_buy !=null)
            foreach ($kb_buy as $key => $value):
                $csKey = intval($key);
                $csKey = $csKey + 1;
                $this->coursepermissions_m->insert(array('user_id' => $insertID, 'course_type' => '1', 'course_id' => $csKey));
            endforeach;
			if($sd_buy!=null)
            foreach ($sd_buy as $key => $value):
                $csKey = intval($key);
                $csKey = $csKey + 1;
                $this->coursepermissions_m->insert(array('user_id' => $insertID, 'course_type' => '2', 'course_id' => $csKey));
            endforeach;
			if($gr_buy!=null)
            foreach ($gr_buy as $key => $value):
                $csKey = intval($key);
                $csKey = $csKey + 1;
                $this->coursepermissions_m->insert(array('user_id' => $insertID, 'course_type' => '3', 'course_id' => $csKey));
            endforeach;

            array_push($bulkUsers, $eachUser);
        }
        return $bulkUsers;
    }

    public function userinfo_download()
    {
        if ($_POST) {
            $searchArr = array();
            $buyCsName = '';
            $defaultStr = $this->lang->line('PlaceChoose');
            $searchArr['username'] = (empty($_POST['username'])) ? '' : $_POST['username'];
            $searchArr['fullname'] = (empty($_POST['fullname'])) ? '' : $_POST['fullname'];

            $searchArr['sex'] = ($_POST['sex_search'] == $defaultStr) ? '' : $_POST['sex'];

            if ($_POST['school_search'] != $defaultStr) {
                $school_id = $this->schools_m->getSchoolIdFromName($_POST['school_search']);
                $searchArr['school_id'] = $school_id;
            } else {
                $searchArr['school_id'] = '';
            }
            if ($_POST['user_type_search'] != $defaultStr) {
                $searchArr['user_type_id'] = $this->users_m->get_userTypeIdFromName($_POST['user_type_search']);
            } else {
                $searchArr['user_type_id'] = '';
            }
            if ($_POST['grade_search'] != $defaultStr) {
                $searchArr['class'] = $_POST['grade_search'];
            } else {
                $searchArr['class'] = '';
            }
            if ($_POST['buycourse_search'] != $defaultStr) {
                $buyCsName = $_POST['buycourse_search'];
            }

            $startTime = (empty($_POST['startTime'])) ? '2000-00-00 00:00:00' : $_POST['startTime'];
            $endTime = (empty($_POST['endTime'])) ? '3000-00-00 00:00:00' : $_POST['endTime'];
            $this->data['users'] = $this->users_m->user_search($searchArr, $buyCsName, $startTime, $endTime);

            $this->data["subview"] = "admin/users/userinfo_download";
            $this->data["subscript"] = "admin/settings/script";
            $this->data["subcss"] = "admin/settings/css";
            $this->load->view('admin/_layout_main', $this->data);
        }

    }

    public function output_content($users)
    {
        $output = '';
        foreach ($users as $user):
            $pub = '';
            if ($user->publish == '1') $pub = $this->lang->line('UnPublish');
            else   $pub = $this->lang->line('Publish');
            $buyList = json_decode($user->buycourse_arr);
            $kebenju = $buyList->kebenju;
            $sandapian = $buyList->sandapian;
            $grammar = isset($buyList->grammar)?$buyList->grammar:'0';
			
			$buycourseStr = '';
			if ($kebenju == '1') {
				$buycourseStr .= $this->lang->line('kebenju');
			}
			if ($sandapian == '1') {
				if ($buycourseStr != '') $buycourseStr .= '<br/>';
				$buycourseStr .= $this->lang->line('sandapian');
			}
			if ($grammar == '1') {
				if ($buycourseStr != '') $buycourseStr .= '<br/>';
				$buycourseStr .= $this->lang->line('grammar');
			}

            $output .= '<tr>';
            $output .= '<td colspan="2">';
            $output .= '<label class="mt-checkbox mt-checkbox-outline">';
            $output .= '<input type="checkbox" onclick="selectEachItem(this);" class="user-select-chk" user_id=' . $user->user_id . ' checkSt = "unchecked" >';
            $output .= '<span></span>';
            $output .= '</label>';
            $output .= '</td>';
            $output .= '<td>' . $user->user_id . '</td>';
            $output .= '<td>' . $user->username . '</td>';
            $output .= '<td>' . $user->fullname . '</td>';
            $output .= '<td>' . $user->sex . '</td>';
            if ($user->user_type_id == '1') $output .= '<td></td>';
            else $output .= '<td>' . $user->class . '</td>';
            $output .= '<td>' . $user->school_name . '</td>';
            $output .= '<td>' . $user->user_type_name . '</td>';
            $output .= '<td>' . $user->reg_time . '</td>';
            $output .= '<td>' . $buycourseStr . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm btn-success" onclick = "edit_user(this);"
                         data-kebenju="' . $kebenju . '" data-sandapian="' . $sandapian . '" data-grammar="' . $grammar . '" user_id = ' . $user->user_id . '>' . $this->lang->line('Modify') . '</button>';
            $output .= '<button class="btn btn-sm btn-warning" onclick = "delete_user(this);" user_id = ' . $user->user_id . '>' . $this->lang->line('Delete') . '</button>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-danger" onclick = "publish_user(this);" user_id = ' . $user->user_id . '>' . $pub . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function getclass()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $school_name = $_POST['school_name'];
            $bulk_type = $_POST['bulk_type'];
            $this->data['classList'] = $this->schools_m->get_classLists($school_name);
            $classStr = $this->lang->line('Class');
            $gradeStr = $this->lang->line('Grade');
            $output = '';
            if ($bulk_type == 1) {///add bulk users for teachers
                foreach ($this->data['classList'] as $school):
                    $jsonStr = $school->class_arr;
                    $classArr = json_decode($jsonStr);
                    foreach ($classArr as $class_info):
                        $gradeNo = $class_info->grade;
                        $realStr = $this->lang->line($gradeNo - 1);
                        for ($i = 1; $i <= $class_info->class; $i++) {
                            $realClassStr = $this->lang->line($i - 1);
                            $output .= '<option>';
                            $output .= $realStr . $gradeStr . $realClassStr . $classStr;
                            $output .= '</option>';
                        }
                    endforeach;
                endforeach;
            } else {///add bulk users for student
                $marginValue = 15;
                foreach ($this->data['classList'] as $school):
                    $jsonStr = $school->class_arr;
                    $classArr = json_decode($jsonStr);
                    $ren = $this->lang->line('Ren');///(人)
                    //$marginValue = 180/(+1);
                    if (count($classArr) == 1) $marginValue = 0;
                    if (count($classArr) == 2) $marginValue = 80;
                    if (count($classArr) == 3) $marginValue = 70;
                    if (count($classArr) == 4) $marginValue = 25;
                    if (count($classArr) == 5) $marginValue = 10;
                    $output .= '<div style="text-align:center">';

                    foreach ($classArr as $class_info):
                        $gradeNo = $class_info->grade;
                        $realStr = $this->lang->line($gradeNo - 1);
                        $output .= '<div style="display: inline-block;vertical-align:top;margin-left:' . $marginValue . 'px;">';
                        for ($i = 1; $i <= $class_info->class; $i++) {
                            $output .= '<div style="margin-top:5px;">';
                            $output .= '<label>';
                            $output .= $realStr . $gradeStr . $i . $classStr . "&nbsp";
                            $output .= '</label>';
                            $output .= '<input type="text" style="width:25px;font-weight:bold;text-align:center;" value="" name ="' . $gradeNo . ',' . $i . '">';
                            $output .= '<label>' . '&nbsp' . $ren . '</label>';
                            $output .= '</label>';
                            $output .= '</br>';
                            $output .= '</div>';
                        }
                        $output .= '</div>';
                    endforeach;
                    $output .= '</div>';
                endforeach;
            }
            $ret['data'] = $output;
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function getRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function search()
    {
        $ret = array(
            'data' => 'No data to show',
            'status' => 'fail'
        );
        if ($_POST) {
            $searchArr = array();
            $buyCsName = '';
            $defaultStr = $this->lang->line('PlaceChoose');
            $searchArr['username'] = (empty($_POST['username'])) ? '' : $_POST['username'];
            $searchArr['fullname'] = (empty($_POST['fullname'])) ? '' : $_POST['fullname'];

            $searchArr['sex'] = ($_POST['sex'] == $defaultStr) ? '' : $_POST['sex'];

            if ($_POST['schoolname'] != $defaultStr) {
                $school_id = $this->schools_m->getSchoolIdFromName($_POST['schoolname']);
                $searchArr['school_id'] = $school_id;
            } else {
                $searchArr['school_id'] = '';
            }
            if ($_POST['usertype'] != $defaultStr) {
                $searchArr['user_type_id'] = $this->users_m->get_userTypeIdFromName($_POST['usertype']);
            } else {
                $searchArr['user_type_id'] = '';
            }
            if ($_POST['grade'] != $defaultStr) {
                $searchArr['class'] = $_POST['grade'];
            } else {
                $searchArr['class'] = '';
            }
            if ($_POST['buycoursename'] != $defaultStr) {
                $buyCsName = $_POST['buycoursename'];
            }


            $startTime = (empty($_POST['startTime'])) ? '2000-00-00 00:00:00' : $_POST['startTime'];
            $endTime = (empty($_POST['endTime'])) ? '3000-00-00 00:00:00' : $_POST['endTime'];
            $this->data['users'] = $this->users_m->user_search($searchArr, $buyCsName, $startTime, $endTime);
            $ret['data'] = $this->output_content($this->arrayToObject($this->data['users']));
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function array_to_obj($array, &$obj)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $obj->$key = new stdClass();
                $this->array_to_obj($value, $obj->$key);
            } else {
                $obj->$key = $value;
            }
        }
        return $obj;
    }

    public function arrayToObject($array)
    {
        $object = new stdClass();
        return $this->array_to_obj($array, $object);
    }
}
