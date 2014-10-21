<?php if (!defined('BASEPATH')) exit('No direct scripts access allowed');

class Attendance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Common');
        $this->load->library('Permission');
        $this->load->model('attendance_model');
        $this->load->model('class_model');
    }

    public function index()
    {
        $this->permission->requireLogin();

        $this->submit();
    }

    /**
     * Submit attendance
     */
    public function submit($error_msg = '')
    {
        $this->permission->requireLogin();

        $data['selected_date'] = isset($_POST['txtDateReport']) ? $_POST['txtDateReport'] : date("Y-m-d");
        $data['class_list'] = $this->class_model->get($this->session->userdata('CURRENT_USER_CAMPUS'));

        if (isset($error_msg) && $error_msg != "") {
            $data['error_msg'] = $error_msg;
        }

        $this->load->view(CURRENT_THEME.'/attendance_submit_form', $data);
    }

    public function do_submit()
    {
        $this->common->writeLog('Attendance', 'Start submitting..');
        $this->permission->requireLogin();

        // Validate input data
        if ($this->input->post('select_class') == '') {
            echo 'No class selected.';
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

            $this->common->writeLogDb('Submit attendance','CID:'.$objAttendDaily['class_id'],'Fully attended on'.$objAttendDaily['date']);

            $redirect_url = base_url(URL_ATTENDANCE_REPORT_DAILY . '?date=' . $objAttendDaily['date']);
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
            $this->common->writeLogDb('Report student as absent',$stu_id,'Absent on '.$objAttendDaily['date']);
        }

//        $this->common->writeLog('Attendance', 'Class is absent');
        $this->common->writeLogDb('Attendance submit','for class','ClassID: '.$objAttendDaily['class_id'],'','Absent on '.$objAttendDaily['date']);

        $this->db->insert_batch('attendance_absent', $listAbsentObjects);
//        $this->common->callbackAlert('Submitted successfully!', base_url(URL_ATTENDANCE_REPORT_DAILY . '?date=' . $objAttendDaily['date']));
        $redirect_url = base_url(URL_ATTENDANCE_REPORT_DAILY . '?date=' . $objAttendDaily['date']);
        redirect($redirect_url);
    }

    public function submit_admin()
    {
        $this->permission->requireLogin();

        $selected_date = isset($_POST['txtDateReport']) ? $_POST['txtDateReport'] : date("Y-m-d");
        $data['selected_date'] = $selected_date;

        $camid = $this->session->userdata('CURRENT_USER_CAMPUS');
        $data['class_list'] = $this->class_model->get($camid);
        $data['student_list'] = $this->attendance_model->get_absent_list('', $selected_date);

        $data['all_classes_attendance'] = $this->attendance_model->getClassesForDailyAttendance($selected_date);
        $data['count_submitted'] = $this->count_submitted($selected_date);
        $data['count_absent'] = $this->count_absent($selected_date);

        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/attendance_submit_form_admin', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');
    }

    function do_submit_full($class, $date)
    {
        $this->permission->requireLogin();
        $this->common->writeLog('Attendance', 'Admin submit');

        if ($class == '' || $date == '') {
            echo 'Error!';
            return;
        }

        $objAttendDaily['has_absent'] = 0;
        $objAttendDaily['date'] = $date;
        $objAttendDaily['class_id'] = $class;
        $objAttendDaily['updated_by'] = $this->session->userdata('CURRENT_USER_ID');

        $this->attendance_model->update_class_daily_attendance($objAttendDaily);

        $this->common->writeLogDb('Submit attendance','CID:'.$objAttendDaily['class_id'],'Fully attended on'.$objAttendDaily['date']);

        redirect('attendance/submit_admin');
    }

    /**
     * Notify student came
     * Completed
     * Fixed: when student came, check total absent students of that class, if = 0, update class status to FULLY ATTENDED
     */
    public function came_already($student_id, $absent_date)
    {
        $this->common->writeLog('Attendance', 'Came already');

        $this->permission->requireLogin();

        // Delete the absent records for student: $student_id
        $this->db->where('student_id', $student_id);
        $this->db->where('absent_date', $absent_date);
        $this->db->delete('attendance_absent');

        // Check if classes has no absent -> update table attendance_classes, set [has_absent] = 0

        // 1. Get class_id by student_id
        $this->db->select('class_id');
        $this->db->where('id', $student_id);
        $query = $this->db->get('students');
        $student = $query->result();
        $class_id = $student[0]->class_id;

        // 2. Count absent records
        $absent_list = $this->attendance_model->get_absent_list($class_id, $absent_date);
        $count_absent_list = count($absent_list);

        // 3. If class has no student absent, update as FULLY ATTENDED
        if ($count_absent_list == 0) {

            $this->db->where('date', $absent_date);
            $this->db->where('class_id', $class_id);
            $this->db->set('has_absent', 0);
            $this->db->update('attendance_classes');
        }

        redirect(base_url('attendance/report_daily?date=' . $absent_date));
    }

    /**
     * Attendance Reports
     */
    public function report_daily()
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

        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/reports/attendance_report_daily', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');
    }

    public function report_daily_export()
    {
        $this->permission->requireLogin();
        $selected_date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
        $reportColumns = array('','CLASS NAME','REPORT FOR DATE','ABSENT','UPDATED ON','(dont care)','UPDATED BY');
        $reportData = $this->attendance_model->getClassesForDailyAttendance($selected_date);
        $this->common->export_csv($reportData,'attendance.csv',$reportColumns,'');
    }

    public function report_absent($by_class = '')
    {
        $this->permission->requireLogin();

        $class_id = isset($_POST['select_class']) ? $_POST['select_class'] : $by_class;
        $data['selected_class'] = $class_id;

        $selected_date = isset($_POST['txtDateReport']) ? $_POST['txtDateReport'] : date("Y-m-d");
        $data['selected_date'] = $selected_date;

        $data['class_list'] = $this->class_model->get($this->session->userdata('CURRENT_USER_CAMPUS'));
        $data['student_list'] = $this->attendance_model->get_absent_list($class_id, $selected_date);

        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/reports/attendance_report_absent', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');
    }

    /*    public function report_by_student($student_id)
    {
        $query = $this->attendance_model->get_student_report($student_id);
        $data['report_list'] = ($query != '') ? $query->result() : null;

        $this->load->view(CURRENT_THEME.'/reports/attendance_report_by_student', $data);
        $this->common->writeLog('AdminStaff', 'Report by student');
    }*/

    public function report_by_student($studentId = '')
    {
        $this->permission->requireLogin();

        if ($studentId == '') {
            return;
        }

        $input_data = $this->input->get();
//        $data['input_data'] = $input_data;
//        $data['class_list'] = $this->class_model->get();

        $query = $this->attendance_model->get_student_report($studentId);
        $data['report_list'] = ($query != '') ? $query->result() : null;

        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/reports/attendance_report_by_student', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');
    }

    public function report_by_student_export($studentId = '')
    {
        $this->permission->requireLogin();

        if ($studentId == '') {
            return;
        }

        $query = $this->attendance_model->get_student_report($studentId);
        $reportData = ($query != '') ? $query->result() : null;

        $reportColumns = array('ID','STUDENT NAME','CLASS NAME','ABSENT DATES');
        $this->common->export_csv($reportData,'attendance.csv',$reportColumns,'Report absent dates of student');

        $this->common->writeLog('Attendance', 'Export Student Absent Report ');
    }

    public function report_custom_time()
    {
        $this->permission->requireLogin();

        $input_data = $this->input->get();
        $data['input_data'] = $input_data;
        $data['class_list'] = $this->class_model->get();

        $query = $this->attendance_model->get_term_report($input_data);
        $data['report_list'] = ($query != '') ? $query->result() : null;
        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/reports/attendance_report_custom', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');

        $this->common->writeLog('Attendance', 'Report custom');
    }

    public function report_custom_time_export()
    {
        $this->permission->requireLogin();

        $input_data = $this->input->get();
        $query = $this->attendance_model->get_term_report($input_data);
        $reportData = ($query != '') ? $query->result() : null;

        $reportColumns = array('ID','STUDENT NAME','CLASS NAME','TOTAL ABSENT TIMES');
        $this->common->export_csv($reportData,'attendance.csv',$reportColumns,'');

        $this->common->writeLog('Attendance', 'Export Custom Report ');
    }

//    function get_daily_attendance($class_id = '', $date_absent = '')
//    {
//        $query = $this->db->get('attendance_daily');
//        return $query->result();
//    }

    /**
     * Load students list with attendance status
     * Used for ajax call from Submit Form
     */
    function loadStudentList()
    {
        $class_id = $_POST['class_id'];
        $submit_date = $_POST['submit_date'];
        $data['student_list'] = $this->attendance_model->get_student_list_with_attendance($class_id, $submit_date);
        $this->load->view(CURRENT_THEME.'/ajax/attendance_select_absent', $data);
    }

    function query_absent_list_by_date($date_absent = '', $class_id = '')
    {
        $query = "select classes.name as class_name, students.name, absent_date, comment, updated_by,updated_on
        from students join
        (select attendance.student_id, staff.name as updated_by,updated_on,absent_date,comment from attendance
          join staff on attendance.updated_by=staff.id";
        if ($date_absent != "") {
            $query .= " where absent_date='" . $date_absent . "'";
        }
        $query .= " ) as list_absent_today
        on students.id = list_absent_today.student_id
        join classes on classes.id = students.class_id";
        if ($class_id != "") {
            $query .= " where class_id=" . $class_id;
        }
        $query .= " order by grade asc, class_name asc";
        $query = $this->db->query($query);
        return $query;
    }

    function get_attendance($date)
    {
        $this->attendance_model->get($date);
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


//    function count_submitted($date) {
//        $this->db->where('date', $date);
//        $query = $this->db->get('attendance_classes');
//        $data = $query->result();
//        return count($data);
//    }
//    function count_absent($date) {
//        $this->db->where('absent_date', $date);
//        $query = $this->db->get('attendance_absent');
//        $data = $query->result();
//        return count($data);
//    }
}