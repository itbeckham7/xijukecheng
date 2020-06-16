<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Api extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('frontend', $language);
        $this->load->model('ncontents_m');
        $this->load->model('nchildcourses_m');
        $this->load->model('ncoursewares_m');

        $this->load->model('comments_m');

        $this->load->model('schools_m');
        $this->load->model('payhistory_m');
        $this->load->model('users_m');
        $this->load->model('signin_m');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function user_login()
    {
        $ret = array(
            'status' => 'error',
            'data' => ''
        );
        if (!empty($_POST)) {
            if (empty($_POST['nickName'])) {
                $ret['data'] = 'nickname empty!';///nickName empty
                echo json_encode($ret);
                return;
            }
            if (empty($_POST['userName'])) {
                $ret['data'] = 'username empty!';///username empty
                echo json_encode($ret);
                return;
            }
            if (empty($_POST['password'])) {
                $ret['data'] = 'password empty!';///password empty
                echo json_encode($ret);
                return;
            }
            if (empty($_POST['schoolName'])) {
                $ret['data'] = 'school information empty!';///full name empty
                echo json_encode($ret);
                return;
            } else {

                $schoolId = $this->schools_m->getSchoolIdFromName($_POST['schoolName']);
                if ($schoolId !== '-1') {
                    $schoolInfo = $this->schools_m->get($schoolId, TRUE);
                    if ($schoolInfo->stop !== '1') {
                        $ret['data'] = 'School has been blocked by admin!';
                        return;
                    }

                } else {
                    $ret['data'] = "You can't find school information";///full name empty
                    echo json_encode($ret);
                    return;
                }

            }

            $userType = (isset($_POST['userType'])) ? $_POST['userType'] : '2';

            ////1.check user has account in kebenju site
            $user_token = $this->checkUserInfo($_POST, $userType);
            if ($user_token === 'PASSWORD_INVALID') {
                $ret['data'] = "Password Incorrect, Please input correct password!";///full name empty
                echo json_encode($ret);
                return;
            }
            $ret['status'] = 'success';
            $ret['data'] = $user_token;
            echo json_encode($ret);
            return;

        }
        echo json_encode($ret);

    }

    function checkUserInfo($post_data, $userType)
    {

        $userName = $post_data['userName'];
        $password = $post_data['password'];
        $user_pass = $this->signin_m->hash($password);
        $user_token = $this->generateRandomString(16);
        $schoolId = $this->schools_m->getSchoolIdFromName($post_data['schoolName']);

        $userInfo = $this->db->get_where('users', array("username" => $userName));
        if ($userInfo->result() != null) {
            if ($user_pass !== $userInfo->row()->password) return 'PASSWORD_INVALID';
            $this->users_m->update_user(array('user_token' => $user_token), $userInfo->row()->user_id);
        } else {
            $sex_name = $this->lang->line('Male');
            $dt = new DateTime();
            $currentTime = $dt->format('Y-m-d H:i:s');
            $userData = array(
                'fullname' => $post_data['nickName'],
                'nickname' => $post_data['nickName'],
                'username' => $userName,
                'password' => $this->users_m->hash($password),
                'school_id' => $schoolId,
                'sex' => $sex_name,
                'user_type_id' => $userType,
                'class' => '',
                'reg_time' => $currentTime,
                'buycourse_arr' => '{"kebenju":0,"sandapian":1}',
                'publish' => '1',
                'user_token' => $user_token
            );
            $this->users_m->insert($userData);
        }
        return $user_token;
    }

    public function addPaidCourse()
    {
        $ret = array(
            'status' => 'error',
            'data' => ''
        );

        if ($_GET) {
            $param = [];
            if (empty($_GET['user_id'])) {
                $ret['data'] = 'userid empty!';///nickName empty
                echo json_encode($ret);
                return;
            }
            $param['user_id'] = $_GET['user_id'];
            $param['sender'] = $_GET['user_id'];

            if (empty($_GET['course_id'])) {
                $ret['data'] = 'courseid empty!';///username empty
                echo json_encode($ret);
                return;
            }
            $param['courseware_id'] = $_GET['course_id'];
            $result = $this->payhistory_m->get_where($param);
            if ($result != null) {
                $ret['data'] = 'course is already paid!';///username empty
                echo json_encode($ret);
                return;
            }
            $param['paid_time'] = date('Y-m-d H:i:s');

            $this->payhistory_m->insert($param);
            $ret['status'] = 'success';
            $ret['data'] = 0;
            echo json_encode($ret);
        } else {
            $ret['data'] = 'Request invalid';
            echo json_encode($ret);
        }
    }

    public function checkPaidCourse()
    {
        $ret = array(
            'status' => 'error',
            'data' => ''
        );

        if ($_POST) {
            $param = [];
            if (empty($_POST['user_id'])) {
                $ret['data'] = 'userid empty!';///nickName empty
                echo json_encode($ret);
                return;
            }
            $param['user_id'] = $_POST['user_id'];

            if (empty($_POST['course_id'])) {
                $ret['data'] = 'courseid empty!';///username empty
                echo json_encode($ret);
                return;
            }
            $param['courseware_id'] = $_POST['course_id'];

            $result = $this->payhistory_m->get_where($param);
            if ($result == null) {
                $ret['data'] = 'course is not paid';
                echo json_encode($ret);
                return;
            }
            $ret['status'] = 'success';
            $ret['data'] = $this->payhistory_m->getItemsFromUser($param['user_id']);
            echo json_encode($ret);
        } else {
            $ret['data'] = 'Request invalid';
            echo json_encode($ret);
        }
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function sandapian_content_upload()
    {
        ///get from POST Request
        $ret = array(
            'status' => 'fail',
            'data' => ''
        );
        if (isset($_POST)) {
            $required = array('userName', 'contentLink', 'contentTitle', 'belongTitle', 'contentType');
            $error = false;
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    $error = true;
                }
            }
            if ($error) {
                $ret['status'] = 'fail';
                $ret['data'] = 'All fields are required.';
                echo json_encode($ret);
                return;
            }
            $userName = $_POST['userName'];
            ///check user existing with $userName
            $userInfo = $this->db->get_where('users', array("username" => $userName));
            $user_data = $userInfo->row();
            if (!empty($user_data)) {
                if ($user_data->publish != '1') {
                    $ret['status'] = 'fail';
                    $ret['data'] = 'Your account has been blocked by adminstrator!';
                    echo json_encode($ret);
                    return;
                } else {
                    $dt = new DateTime("now", new DateTimeZone('Asia/Hong_Kong'));
                    $data = array(
                        'ncontent_title' => $_POST['contentTitle'],
                        'ncontent_type_id' => $_POST['contentType'],
                        'ncontent_user_id' => $user_data->user_id,
                        'ncontent_ncwid' => '0',
                        'ncontent_belong_title' => $_POST['belongTitle'],///new added part on 2017.11.30
                        'ncontent_local' => '1',
                        'ncontent_cloud' => '1',
                        'ncontent_file' => $_POST['contentLink'],
                        'ncontent_createtime' => $dt->format('Y:m:d'),
                    );
                    $this->ncontents_m->insert_ncontents($data);
                    $ret['status'] = 'success';
                    $ret['data'] = '';
                    echo json_encode($ret);
                    return;
                }

            } else {
                $ret['status'] = 'fail';
                $ret['data'] = 'Your account has been not registered on this site!';
                echo json_encode($ret);
                return;
            }

        }
        echo json_encode($ret);

    }

    public function get_course_audio()
    {
        $ret = array(
            'StudentRecords' => ''
        );
        if (!empty($_POST)) {
            $schoolName = (isset($_POST['SchoolName'])) ? $_POST['SchoolName'] : '';
            $studentAccounts = (isset($_POST['StudentAccount'])) ? $_POST['StudentAccount'] : '';
            if ($schoolName == '') {
                echo json_encode($ret);
                return;
            }
            if ($studentAccounts == '') {
                echo json_encode($ret);
                return;
            }
            $schoolId = $this->schools_m->getSchoolIdFromName($schoolName);
            $accountList = json_decode($studentAccounts);
            $retRecordList = array();
            foreach ($accountList as $st):
                $userList = $this->users_m->get_where(array('username' => $st));
                if ($userList == null) continue;
                if ($userList[0]->school_id != $schoolId) continue;
                $stRecords = $this->ncontents_m->searchStudentRecords($userList[0]->user_id);
                if ($stRecords != null) {
                    foreach ($stRecords as $sr):
                        $tmpArr = array();
                        $tmpArr['Account'] = $st;
                        $tmpArr['Url'] = base_url($sr->ncontent_file);
                        $tmpArr['Time'] = $sr->ncontent_createtime;
                        $tmpArr['CourseName'] = $sr->ncw_name;
                        $tmpArr['CourseType'] = $sr->childcourse_name;

                        array_push($retRecordList, $tmpArr);
                    endforeach;
                }
            endforeach;
            $ret['StudentRecords'] = $retRecordList;
            echo json_encode($ret);
            return;
        }
        echo json_encode($ret);
    }

    function get_course_link_info()
    {

        $ret = array(
            'CoverLink' => '',
            'CourseTypeLink' => array(),
            'CourseIdLink' => array()
        );
        $ret['CoverLink'] = "https://kebenju.hulalaedu.com/assets/images/sandapian/home/sandapian.png";
        ///Get Course Type Link from nchildcourses_m
        $csTypes = $this->nchildcourses_m->get_nchild_courses();
        foreach ($csTypes as $cst):
            array_push($ret['CourseTypeLink'], base_url() . $cst->childcourse_photo);
        endforeach;
        ///Get courseware image link
        $csIds = $this->ncoursewares_m->get_ncw();
        foreach ($csIds as $csId):
            array_push($ret['CourseIdLink'], base_url() . $csId->ncw_photo);
        endforeach;

        echo json_encode($ret);
    }

    public function getOpenid()
    {
        $book = $_GET;
        $code = $book['code'];//获取code
        $weixin = file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=wxb7532c0995b93389&secret=28f10dcf37b87840c0c3f538c8596251&js_code=" . $code . "&grant_type=authorization_code");//通过code换取网页授权access_token
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
//        $openid = $array['openid'];//输出openid
        echo json_encode(array('status' => true, 'data' => $array), 200);
    }

    /*
    * this function is used for payment
    */
    public function pay()
    {
        include 'WxPay.php';

        $book = $_POST;
        //$appid = 'wxb7532c0995b93389';
        //$mch_id = '1507842611';
        //$key = 'sjwjsjwj64822580sjwjsjwj64822580';

        $appid = 'wxb7532c0995b93389';
        $mch_id = '1507842611';
        $key = 'kebenjuzhifu1234kebenjuzhifu1234';

        $out_trade_no = $book['out_trade_no'];
        $openid = $book['id'];
        $total_fee = $book['fee'];
        $user_id = $book['user_id'];
        $courseware_id = $book['courseware_id'];
        if (empty($total_fee)) //押金
        {
            $body = "戏剧课程-充值押金";
            $total_fee = floatval(99 * 100);
        } else {
            $body = "戏剧课程-充值余额";
            $total_fee = floatval($total_fee * 100);
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,
            'http://xijvkecheng.hulalaedu.com/api/notify'
            . '?uId=' . $user_id . '&cId=' . $courseware_id
        );
        $return = $weixinpay->pay();
        echo json_encode($return);
    }


    /*
    * this function is used for payment
    */
    public function pay1()
    {
        include 'WxPay.php';

        $book = json_decode(file_get_contents("php://input"));
        $appid = 'wxea381fb0ca7c2a24';
        $mch_id = '1500220062';
        $key = 'fengtiWeixin17642518820android12';
        $out_trade_no = $book->{'out_trade_no'};
        $openid = $book->{'id'};
        $total_fee = $book->{'fee'};
        $user_id = $book->{'user_id'};
        $courseware_id = $book['courseware_id'];
        if (empty($total_fee)) //押金
        {
            $body = "英语课本剧-充值押金";
            $total_fee = floatval(99 * 100);
        } else {
            $body = "英语课本剧-充值余额";
            $total_fee = floatval($total_fee * 100);
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,
            'http://xijvkecheng.hulalaedu.com/application/controllers/notify'
            . '?uId=' . $user_id . '&cId=' . $courseware_id
        );
        $return = $weixinpay->pay();
        echo json_encode($return);
    }

    /*
    * this function is used for refund
    */
    public function refund()
    {
        include 'WinxinRefund.php';
        $book = json_decode(file_get_contents("php://input"));
        $appid = 'wxb7532c0995b93389';
        $openid = $book->{'id'};
        $mch_id = '1507842611';
        $key = 'sjwjsjwj64822580sjwjsjwj64822580';
        $out_refund_no = $book->{'out_refund_no'};
        $out_trade_no = $book->{'out_trade_no'};
        $total_fee = $book->{'fee'};
        if (empty($total_fee)) //押金
        {
            $body = "英语课本剧-退款押金";
            $total_fee = floatval(99 * 100);
        } else {
            $body = "英语课本剧-退款余额";
            $total_fee = floatval($total_fee * 100);
        }  //$openid,$outTradeNo,$totalFee,$outRefundNo,$refundFee
        $refund_fee = $total_fee;
        $weixinpay = new WinXinRefund($appid, $mch_id, $openid, $out_trade_no, $total_fee, $out_refund_no, $refund_fee, $key);
        $return = $weixinpay->refund();

        echo json_encode($return);
    }

    public function notify()
    {
        function post_data()
        {
            $receipt = $_REQUEST;
            if ($receipt == null) {
                $receipt = file_get_contents("php://input");
                if ($receipt == null) {
                    $receipt = $GLOBALS['HTTP_RAW_POST_DATA'];
                }
            }
            return $receipt;
        }

        $post = post_data();    //接受POST数据XML个数

        $post_data = $this->xml_to_array($post);   //微信支付成功，返回回调地址url的数据：XML转数组Array
        $postSign = $post_data['sign'];
        unset($post_data['sign']);

        /* 微信官方提醒：
        *  商户系统对于支付结果通知的内容一定要做【签名验证】,
        *  并校验返回的【订单金额是否与商户侧的订单金额】一致，
        *  防止数据泄漏导致出现“假通知”，造成资金损失。
        */
        ksort($post_data);// 对数据进行排序
        $str = $this->ToUrlParams($post_data);//对数组数据拼接成key=value字符串
        $user_sign = strtoupper(md5($post_data));   //再次生成签名，与$postSign比较

        $where['crsNo'] = $post_data['out_trade_no'];
        $order_status = M('home_order', 'xxf_witkey_')->where($where)->find();

        if ($post_data['return_code'] == 'SUCCESS' && $postSign) {
            /*
            * 首先判断，订单是否已经更新为ok，因为微信会总共发送8次回调确认
            * 其次，订单已经为ok的，直接返回SUCCESS
            * 最后，订单没有为ok的，更新状态为ok，返回SUCCESS
            */
            if ($order_status['order_status'] == 'ok') {
                $user_id = $_GET['uId'];
                $course_id = $_GET['cId'];
                $dbData = $this->payhistory_m->get_where(array('user_id' => $user_id, 'courseware_id' => $course_id));
                if ($dbData == null) {
                    $this->payhistory_m->insert(array(
                        'courseware_id' => $course_id,
                        'user_id' => $user_id,
                        'sender' => $user_id,
                        'paid_time' => date('Y-m-d H:i:s'),
                        'out_trade_no' => $post_data['out_trade_no']
                    ));
                }
                $this->return_success();
            } else {
                $updata['order_status'] = 'ok';
                if (M('home_order', 'xxf_witkey_')->where($where)->save($updata)) {
                    $this->return_success();
                }
            }
        } else {
            echo '微信支付失败';
        }
    }

    /*
    * 给微信发送确认订单金额和签名正确，SUCCESS信息 -xzz0521
    */
    private function return_success()
    {
        $return['return_code'] = 'SUCCESS';
        $return['return_msg'] = 'OK';
        $xml_post = '<xml>
                        <return_code>' . $return['return_code'] . '</return_code>
                        <return_msg>' . $return['return_msg'] . '</return_msg>
                    </xml>';
        echo $xml_post;
        exit;
    }


}

?>