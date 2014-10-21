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
		$this->load->model('student_model');
		
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
//            $this->common->callbackAlert('Submitted successfully!', base_url(URL_ATTENDANCE_REPORT_DAILY . '?date=' . $objAttendDaily['date']));
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
        }

        $this->common->writeLog('Attendance', 'Class is absent');
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
        $selected_date = trim($selected_date);

        $data['selected_date'] = $selected_date;
        $data['class_list'] = $this->class_model->get($camid);
        $data['student_list'] = $this->attendance_model->get_absent_list('', $selected_date);
        $data['all_classes_attendance'] = $this->attendance_model->getClassesForDailyAttendance($selected_date);

        $data['best_staff'] = $this->attendance_model->getClassesForDailyAttendance_OrderBySubmitTime($selected_date);
        $data['worst_staff'] = $this->attendance_model->get_staff_of_last_submitted_classes($selected_date);

        $data['count_submitted'] = $this->count_submitted($selected_date);
        $data['count_absent'] = $this->count_absent($selected_date);

        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/reports/attendance_report_daily', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');
    }

    public function report_daily_v2()
    {
        $this->permission->requireLogin();

        $camid = $this->session->userdata('CURRENT_USER_CAMPUS');

        $selected_date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
        $selected_date = trim($selected_date);

        $data['selected_date'] = $selected_date;
        $data['class_list'] = $this->class_model->get($camid);
        $data['student_list'] = $this->attendance_model->get_absent_list('', $selected_date);
        $data['all_classes_attendance'] = $this->attendance_model->getClassesForDailyAttendance($selected_date);

        $data['best_staff'] = $this->attendance_model->getClassesForDailyAttendance_OrderBySubmitTime($selected_date);
        $data['worst_staff'] = $this->attendance_model->get_staff_of_last_submitted_classes($selected_date);

        $data['count_submitted'] = $this->count_submitted($selected_date);
        $data['count_absent'] = $this->count_absent($selected_date);

        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/reports/attendance_report_daily_v2', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');
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

    public function report_custom_time()
    {
        $this->permission->requireLogin();

        $input_data = $this->input->get();
        $data['input_data'] = $input_data;
		//echo "<pre>";var_dump( $data['input_data']);die;
        $data['class_list'] = $this->class_model->get();
        $query = $this->attendance_model->get_term_report($input_data);
		//echo "<pre>"; var_dump($query->result());die;
        $data['report_list'] = ($query != '') ? $query->result() : null;
        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/reports/attendance_report_custom', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');

        $this->common->writeLog('Attendance', 'Report custom');
    }
	
	/*
	ngay 26/9/14
	nguyen
	*/
    
	
	public function attendance_stats()
	{
		$this->permission->requireLogin();

        $input_data = $this->input->get();
		//if($input_data['day'] == '' || $input_data == 0)
		//	$input_data['day'] = 200;
			//var_dump($input_data);die;
        $data['input_data'] = $input_data;
		
		//echo "<pre>";var_dump( $data['input_data']);die;
        $data['class_list'] = $this->class_model->get_grade();
		
		if(isset($input_data['class']) || $input_data['class'] != "")
		{	
			$list_class = $this->class_model->get_class_by_grade($input_data['class']);
			foreach($list_class as $class) {
				$class_array[] = $class['id'];
			}
			$sum_student= $this->student_model->sum_class($class_array);
			$data['sum_student'] = (int)$sum_student[0]->sum_student;
		}
		
		
		//echo "<pre>";var_dump( $data['sum_student']);die;
		//echo "<pre>";var_dump( $input_data['class']);die;
		//$list_class = $this->class_model->get_class_by_grade($input_data['class']);
		//$class_array = array();
		//foreach($list_class as $class) {
		//	$class_array[] = $class['id'];
		//}
		//echo "<pre>";var_dump($class_array);die;
		$query = $this->attendance_model->get_term_report_stats($input_data);
        $count_attendance_absent = (!empty($query)) ? $query : null;
		//echo "<pre>";var_dump($data['report_list'] );die;
		$sum = 0;
		if($count_attendance_absent != null) {
			foreach($count_attendance_absent as $attendance_absent){
				$sum = $sum + $attendance_absent['count_absent_dates'];
			}
			$data['year'] = ($input_data['class'] != "") ? $input_data['class']:0;
		}
		//var_dump($data['year']);die;
		$data['sum'] = $sum;
		//echo "<pre>";var_dump($sum);die;
        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/reports/attendance_stats', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');

        $this->common->writeLog('Attendance', 'Report custom');
	}
    public function report_custom_time_export()
    {
    	$this->permission->requireLogin();
    	
    	$input_data = $this->input->get();
    	$query = $this->attendance_model->get_term_report_export($input_data);
    	$results = $query->result();
    	$list = array();
    	foreach ($results as $key => $obj){    		
    		$list[$obj->cid.",".$obj->class_name][$obj->sid.",".$obj->name][$obj->absent_date] = $obj->absent_date; 
    	}
    	$data = array();
    	$header = array('Class', 'Name of student');  
    	$this->excel_xml->addRow($header);
    	foreach ($list as $class=>$item){//Class    		
    		$classes = explode(',', $class);
    		$row = array($classes[1], '');
    		$date = $input_data['from']; $end_date = $input_data['to'];
	    	while (strtotime($date) <= strtotime($end_date)) {
	    		$objDate = new DateTime($date);
	    		$row[] = $objDate->format('d/m');
	    		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
	    	}
	    	$this->excel_xml->addRow($row);	    	   	
    		$i=1;foreach ($item as $student=>$subItem){//Student
    			$student_row = array();
    			$students = explode(',', $student);
    			$student_row[] = $i;$student_row[] = $students[1];
    			$absent_dates = array();
    			foreach($subItem as $key=>$subSubItem){//absent_date
    				$absent_dates[]=$subSubItem;
    			}
    			$date = $input_data['from']; $end_date = $input_data['to'];
    			while (strtotime($date) <= strtotime($end_date)) {
    				
    				if(in_array($date, $absent_dates)){
    					$student_row[] = 'A';
    				}else{
    					$student_row[] = '';
    				}
    				$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
    			}
    			$this->excel_xml->addRow($student_row);
    		$i++;}
    	}
    	$sheet = array();
    	$date = $input_data['from']; $end_date = $input_data['to'];
    	while (strtotime($date) <= strtotime($end_date)) {
    		$objDate = new DateTime($date);
    		$sheet[$objDate->format('m')] = $objDate->format('m');
    		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
    	}
    	$this->excel_xml->setWorksheetTitle(implode('-', array_keys($sheet)));
    	$this->excel_xml->generateXML();
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

    public function report_daily_export()
    {
        $this->permission->requireLogin();
        $selected_date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
        $reportColumns = array('', 'CLASS NAME', 'REPORT FOR DATE', 'ABSENT', 'UPDATED ON', '(dont care)', 'UPDATED BY');
        $reportData = $this->attendance_model->getClassesForDailyAttendance($selected_date);
        $this->common->export_csv($reportData, 'attendance.csv', $reportColumns, '');
    }

    public function report_by_student_export($studentId = '')
    {
        $this->permission->requireLogin();

        if ($studentId == '') {
            return;
        }

        $query = $this->attendance_model->get_student_report($studentId);
        $reportData = ($query != '') ? $query->result() : null;

        $reportColumns = array('ID', 'STUDENT NAME', 'CLASS NAME', 'ABSENT DATES');
        $this->common->export_csv($reportData, 'attendance.csv', $reportColumns, 'Report absent dates of student');

        $this->common->writeLog('Attendance', 'Export Student Absent Report ');
    }

//     public function report_custom_time_export()
//     {
//         $this->permission->requireLogin();

//         $input_data = $this->input->get();
//         $query = $this->attendance_model->get_term_report($input_data);
//         $reportData = ($query != '') ? $query->result() : null;

//         $reportColumns = array('ID', 'STUDENT NAME', 'CLASS NAME', 'TOTAL ABSENT TIMES');
//         $this->common->export_csv($reportData, 'attendance.csv', $reportColumns, '');

//         $this->common->writeLog('Attendance', 'Export Custom Report ');
//     }

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

    /*
    nguyen 9/10/14
    */
    public function teacher_comments()
    {
        if ($this->input->is_ajax_request()) {
            $post = $this->input->post();
            $id = $post['id'];
            $val = $post['val'];
            //var_dump($val);die;
            $this->load->model('student_model');
            $return = $this->student_model->save($id,$val);
            if($return == true){
                $list = array(
                    'very_good' =>'Very Good',
                    'good' => 'Good',
                    'satisfactory' => 'Satisfactory',
                    'needs_improvement' => 'Needs Improvement',
                    'others' =>'Others'
                );
                echo json_encode(array('list'=>$list));
                //echo "Cập nhật thành công";
            };
        }else {
            $this->permission->requireLogin();
            $input = $this->input->post();
            $data['keywords'] = $input;
            $id="";
            if(isset($input['select_class'])) {
                $id = $input['select_class'];
            }
            $data['class_list'] = $this->class_model->get();
            $data['student_list'] = $this->student_model->get_by_class($id);
            $data['student_list_all'] = $this->student_model->search_simple($data['keywords']);
            //var_dump($data['student_list']);die;
           
            $this->load->view(CURRENT_THEME.'/reports/report_header');
            $this->load->view(CURRENT_THEME.'/reports/teacher_comment', $data);
            $this->load->view(CURRENT_THEME.'/reports/report_footer');
        }    
    }





}