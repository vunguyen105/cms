<?php if (!defined('BASEPATH')) exit('No direct scripts access allowed');

class M extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Common');
        $this->load->library('Permission');
        $this->load->model('cms_model');
        $this->load->model('class_model');
        $this->load->model('attendance_model');
    }

    public function index()
    {
        $this->authenticate();
        $this->load->view(CURRENT_THEME.'/m/index');
//        $this->attendance_submit();
    }

    public function login($error = '')
    {
        $data['error'] = $error;
        $this->load->view(CURRENT_THEME.'/m/login', $data);
    }

    public function do_login()
    {
        $username = trim($_POST['txtUsername']);
        $password = $_POST['txtPassword'];

        // Validate basic
        if ($username == '') {
            $this->login("Username cannot be blank!");
            return;
        }

        // Validate with database info
        $data = $this->get_user_by_username($username);

        if (count($data) == 1) {
            if ($data[0]->password == $password) {
                $this->init_session($data);
                $this->common->writeLog('Logged in', 'U:' . $username . '. P:' . $password);
                redirect(base_url('m/attendance_submit'));
            } else {
                $this->login("Password is not correct!");
                $this->common->writeLog('Login failed', 'Wrong password.' . ' U:' . $username . '. P:' . $password);
            }
        } else {
            $this->login("Username/ Email is not found!");
            $this->common->writeLog('Login failed', 'Username not found.' . 'U:' . $username . '. P:' . $password);
        }
    }

    function attendance_submit()
    {
        $this->authenticate();

        $data['selected_date'] = isset($_POST['txtDateReport']) ? $_POST['txtDateReport'] : date("Y-m-d");
        $data['class_list'] = $this->class_model->get($this->session->userdata('CURRENT_USER_CAMPUS'));

        if (isset($error_msg) && $error_msg != "") {
            $data['error_msg'] = $error_msg;
        }

        $this->load->view(CURRENT_THEME.'/m/attendance_submit', $data);
    }

    /*
     * This is exactly the same as function do_submit(), except for the redirect address after finishing submission
     * This is targeted to mobile devices
     * 26/04/2013
     */
    public function attendance_do_submit()
    {
        // Validate input data
        if ($this->input->post('select_class') == '') {
            echo '<h4>No class selected.</h4>';
            return;
        }

        $hasAbsent = $this->input->post('radHasAbsent');
        if ($hasAbsent == '') {
            echo 'Full or Absent?';
            return;
        }

        // Validate done. Get input data
        $input = $this->input->post();

        $objAttendDaily['date'] = $input['txtDateReport'];
        $objAttendDaily['class_id'] = $input['select_class'];
        $objAttendDaily['updated_by'] = $this->session->userdata('CURRENT_USER_ID');

        // If class is Fully Attended
        if ($hasAbsent == 0) {
            $this->common->writeLog('Attendance', 'Class is full');

            $objAttendDaily['has_absent'] = 0;

            // check if there is already submitted students in table [attendance] -> delete all
            $this->attendance_model->update_class_daily_attendance($objAttendDaily);
            $this->common->callbackAlert('Submitted successfully!', base_url(URL_ATTENDANCE_REPORT_DAILY_MOBILE . '?date=' . $objAttendDaily['date']));
            $redirect_url = base_url(URL_ATTENDANCE_REPORT_DAILY_MOBILE . '?date=' . $objAttendDaily['date']);
            redirect($redirect_url);
            return;
        }

        // If class has absent students, validate absent list:
        if (!isset($_POST['ckbIsAbsent']) || (count($_POST['ckbIsAbsent']) < 1)) {
            echo 'No students selected!';
            return;
        }

        // Step 1. Submit class as Is Absent
        $objAttendDaily['has_absent'] = 1;
        $this->attendance_model->update_class_daily_attendance($objAttendDaily);

        // Step 2. Get the absent student list to insert to attendance_absent
        $list_selected_checkboxes = $_POST['ckbIsAbsent'];
        $listAbsentObjects = "";
        for ($iCount = 0; $iCount < count($list_selected_checkboxes); $iCount++) {
            $stu_id = $list_selected_checkboxes[$iCount];
            $listAbsentObjects[$iCount]['student_id'] = $stu_id;
            $listAbsentObjects[$iCount]['comment'] = $_POST['txtComment'][$stu_id];
            $listAbsentObjects[$iCount]['absent_date'] = $objAttendDaily['date'];
            $listAbsentObjects[$iCount]['updated_by'] = $this->session->userdata('CURRENT_USER_ID');
        }

        $this->common->writeLog('Attendance', 'Class is absent');
        $this->db->insert_batch('attendance_absent', $listAbsentObjects);
        $this->common->callbackAlert('Submitted successfully!', base_url(URL_ATTENDANCE_REPORT_DAILY_MOBILE . '?date=' . $objAttendDaily['date']));
    }

    function attendance_loadStudentList()
    {
        $class_id = $_POST['class_id'];
        $submit_date = $_POST['submit_date'];
        $data['student_list'] = $this->attendance_model->get_student_list_with_attendance($class_id, $submit_date);
        $this->load->view(CURRENT_THEME.'/m/attendance_ajax_select_absent', $data);
    }

    function attendance_daily()
    {
        $this->permission->requireLogin();

        $camid = $this->session->userdata('CURRENT_USER_CAMPUS');

        $selected_date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");

        $data['selected_date'] = $selected_date;
        $data['class_list'] = $this->class_model->get($camid);
        $data['student_list'] = $this->attendance_model->get_absent_list('', $selected_date);
        $data['all_classes_attendance'] = $this->attendance_model->getClassesForDailyAttendance($selected_date);
        $data['count_submitted'] = $this->count_submitted($selected_date);
        $data['count_absent'] = $this->count_absent($selected_date);

        $this->load->view(CURRENT_THEME.'/m/attendance_report_daily', $data);
    }

    function count_submitted($date)
    {
        $this->db->where('date', $date);
        $query = $this->db->get('attendance_classes');
        $data = $query->result();
        return count($data);
    }

    function count_absent($date)
    {
        $this->db->where('absent_date', $date);
        $query = $this->db->get('attendance_absent');
        $data = $query->result();
        return count($data);
    }

    /*
    * Find related info in database
    */
    function get_user_by_username($username)
    {
        $where_clause = "staff_code = '" . $username . "' OR email = '" . $username . "'";
        $this->db->where($where_clause);
        $this->db->select('id, cam_id, staff_code, name, email, password');
        $query = $this->db->get('staff');
        return $query->result();
    }

    function init_session($user_data)
    {
        if ($user_data[0]->cam_id) {
            $campus = $user_data[0]->cam_id;
        } else {
            $campus = -1;
        }

        $this->session->set_userdata('CURRENT_USER_CAMPUS', $campus);
        $this->session->set_userdata('CURRENT_USER_ID', $user_data[0]->id);
        $this->session->set_userdata('CURRENT_USER_NAME', $user_data[0]->name);
//        if ($this->permission->canAccessAdminPanel()) {
//            $this->session->set_userdata('VIEW_ADMIN_PANEL', true);
//        }
    }

    public function authenticate()
    {
        if ($this->session->userdata('CURRENT_USER_ID') == "") {
            redirect(base_url('m/login'));
        }
    }

    public function logout()
    {
        $this->common->writeLog('Logged out', 'successfully!');
        $this->session->sess_destroy();
        redirect(base_url('m'));
    }
}
