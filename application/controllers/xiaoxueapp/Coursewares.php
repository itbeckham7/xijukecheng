<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Coursewares extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('frontend', $language);
        $this->load->model('coursewares_m');
        $this->load->model('subwares_m');
        $this->load->model("coursepermissions_m");
        $this->load->model('statistics_m');
        $this->load->model('payhistory_m');
        $this->load->model('units_m');
        $this->load->model('signin_m');
        $this->load->library("pagination");
        $this->load->library("session");

        $this->load->library("PDF_AutoPrint");

    }

    public function index()
    {
        $user_type = $this->session->userdata("user_type");
        $user_id = $this->session->userdata("loginuserID");
        if ($this->signin_m->loggedin()) {
            $this->data['user_type'] = $user_type;
            $this->data['user_id'] = $user_id;

            $this->data['cws_permissions'] = $this->coursepermissions_m->get_where(array(
                'user_id' => $user_id, 'course_type' => '1'
            ));
        } else {
            $this->data['cws_permissions'] = [];
        }
        $this->data['cws_permissions'] = $this->getUserCws($this->data['cws_permissions']);
        $this->data['wxStatus'] = $this->signin_m->getWxStatus();
        $this->data['cwSets'] = $this->coursewares_m->get_where(array(
            'platform_type' => 1, 'school_type_id' => 1));
        $this->data['paidCourse'] = $this->payhistory_m->get_where(array('user_id'=>$user_id));
        $this->data['unitSets'] = $this->units_m->get_units();
        $this->data["subview"] = "xiaoxueapp/coursewares/index";
        $this->load->view('xiaoxueapp/_layout_main', $this->data);
    }

    public function view($id = NULL)
    {
        //whenever this function is called..
        ///we have to add access time and update curseware_access table of database.
        $courseware = $this->coursewares_m->getCoursewareById($id);
        $isFree = (($courseware->price == 0 && $courseware->free == 1) ? true : false);
        if (!$isFree && !($this->signin_m->loggedin()))
            redirect(base_url('xiaoxueapp/coursewares'));
        if (!is_numeric($id) || $id == NULL) {
            show_404();
            return;
        }
        $arr = array(
            'cw_id' => $id,
            'cw_access_time' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('courseware_accesses', $arr);
        $this->data['courseware_id'] = $id;
        $this->data['subwares'] = $this->subwares_m->get_swForFrontend($id);
        $this->data["subview"] = "xiaoxueapp/coursewares/view";
        $this->data['wxStatus'] = $this->signin_m->getWxStatus();
        $this->load->view('xiaoxueapp/_layout_main', $this->data);

    }

    function update_SW_Access()
    {

        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $swTypeId = $_POST['subware_type_id'];
            $arr = array(
                'sw_type_id' => $swTypeId,
                'sw_access_time' => date('Y-m-d H:i:s')
            );
            $this->db->insert('subware_accesses', $arr);
            $ret['status'] = 'success';
            $ret['data'] = 'success';
        }
        echo json_encode($ret);

    }

    function pdfDownLoad()
    {
        if (!empty($_GET)) {
            $pdfUrl = $_GET['pdfUrl'];
            $pdf = new PDF_AutoPrint();///https://stackoverflow.com/questions/33254679/print-pdf-in-firefox
            $pageCnt = $pdf->setSourceFile("uploads/courseware/" . $pdfUrl);

            for ($i = 1; $i <= $pageCnt; $i++) {
                $tplIdx = $pdf->importPage($i, '/MediaBox');
                $pdf->addPage();
                $pdf->useTemplate($tplIdx);
            }
            $pdf->AutoPrint(true);
            $pdf->Output();
        }
    }

    function iosReadTextHandler()
    {

        $ret = array(
            'status' => 'fail',
            'data' => ''
        );
        if (!empty($_GET)) {

            $cur_readText = $_GET['cur_text'];
            $text_id = $_GET['text_id'];

            $this->session->set_userdata('cur_read_text', $cur_readText);
            $this->session->set_userdata('read_text_id', $text_id);

            $ret['status'] = 'success';
            $ret['data'] = 'Transmitted read text to server';
        }
        echo json_encode($ret);
    }

    function iosCheckReadText()
    {

        $ret = array(
            'status' => 'fail',
            'data' => ''
        );
        if (!empty($_POST)) {
            $textID = $_POST['text_id'];
            if (isset($_SESSION['cur_read_text']) && isset($_SESSION['read_text_id'])) {

                $readTxtID = $this->session->userdata('read_text_id');
                if ($readTxtID !== $textID) {

                    $ret['data'] = "Can't find current text information from server!";
                    echo json_encode($ret);
                    return;
                }
                $readText = $this->session->userdata('cur_read_text');
                if (!isset($readText) || empty($readText)) $readText = '';
                $ret['status'] = 'success';
                $ret['data'] = $readText;

                $this->session->unset_userdata('cur_read_text');

                echo json_encode($ret);
                return;
            }

        }
        echo json_encode($ret);
    }

    function getUserCws($cwPermissions)
    {
        $ret = array();
        foreach ($cwPermissions as $value):
            array_push($ret, $value->course_id);
        endforeach;
        return $ret;
    }
}

?>