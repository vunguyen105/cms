<?php if (!defined('BASEPATH')) exit('No direct scripts access allowed');
define('STUDENT_STATUS_ACTIVE',1);
define('STUDENT_STATUS_DEACTIVATED',0);
class Admin extends CI_Controller
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
        $this->load->model('staff_model');
        $this->load->model('campus_model');
        $this->load->model('class_model');
        $this->load->model('student_model');
        $this->load->model('cms_model');
    }

    public function index()
    {
        if ($this->permission->canAccessAdminPanel()) {
            $this->load->view('admin/index_before');
            $this->student_chart_grade_ratio();
            $this->load->view('admin/index_after');
        } else {
            redirect(base_url());
        }
    }

    /**
     * Re-route and direct
     */
    public function attendance($act=''){
        $this->common->writeLog($act);
        $this->load->view('admin/index_before');
        switch ($act){
            case 'report-daily': $this->report_daily_admin();break;
            case 'report-custom': $this->attendance_report_custom();break;
            case 'report-student': $this->attendance_report_by_student();break;
            case 'report-absence': $this->attendance_chart_absence();break;
            case 'report-absence-by-days': $this->attendance_chart_absence_daily();break;
            default : $this->student_home();break;
        }
        $this->load->view('admin/index_after');
    }

    public function student($act='', $id=''){
        $modRequiredRoles = array(ROLE_SCHOOL_ENROLLMENT,ROLE_SYSTEM);
        if (!$this->permission->hasRoles($modRequiredRoles)) {$this->no_permission();return;}

        $this->load->view('admin/index_before');
        switch ($act){
            case 'details': $this->student_details($id);break;
            case 'list':case 'search': $this->student_home();break;
            case 'do-search': $this->student_do_search();break;
            case 'add': $this->student_add();break;
            case 'do-add': $this->student_do_add();break;
            case 'edit': $this->student_edit($id);break;
            case 'do-edit': $this->student_do_edit($id);break;
            case 'transfer': $this->student_transfer($id);break;
            case 'withdraw': $this->student_deactivate($id);break;
            case 'overall': $this->student_chart1();break;
            case 'grade-ratio': $this->student_chart_grade_ratio();break;
            case 'gender-ratio': $this->student_chart_gender();break;
            case 'delete': $this->student_delete($id);break;
            default : $this->student_home();break;
        }
        $this->load->view('admin/index_after');
        $this->common->writeLog($act);
    }

    public function campus($act='', $id=''){
        $modRequiredRoles = array(ROLE_SYSTEM);
        if (!$this->permission->hasRoles($modRequiredRoles)) {$this->no_permission();return;}

        $this->load->view('admin/index_before');
        switch ($act){
            case 'list': $this->campus_home();break;
            case 'add': $this->campus_add();break;
            case 'do-add': $this->campus_do_add();break;
            case 'edit': $this->campus_edit($id);break;
            case 'do-edit': $this->campus_do_edit();break;
            case 'delete': $this->campus_delete($id);break;
            default : $this->campus_home();break;
        }
        $this->load->view('admin/index_after');
        $this->common->writeLog($act);
    }

    public function classes($act='', $id=''){
        $modRequiredRoles = array(ROLE_SYSTEM);
        if (!$this->permission->hasRoles($modRequiredRoles)) {$this->no_permission();return;}

        $this->load->view('admin/index_before');
        switch ($act){
            case 'list': $this->class_home();break;
            case 'class-list': $this->class_class_list($id);break;
            case 'add': $this->class_add();break;
            case 'do-add': $this->class_do_add();break;
            case 'edit': $this->class_edit($id);break;
            case 'do-edit': $this->class_do_edit($id);break;
            case 'delete': $this->class_delete($id);break;
            default : $this->class_home();break;
        }
        $this->load->view('admin/index_after');
        $this->common->writeLog($act);
    }

    public function staff($act='', $id=''){
        $modRequiredRoles = array(ROLE_SYSTEM,ROLE_CORP_OFFICE);
        if (!$this->permission->hasRoles($modRequiredRoles)) {$this->no_permission();return;}

        $this->load->view('admin/index_before');
        switch ($act){
            case 'list': $this->staff_home();break;
            case 'add': $this->staff_add();break;
            case 'do-add': $this->staff_do_add();break;
            case 'edit': $this->staff_edit($id);break;
            case 'do-edit': $this->staff_do_edit($id);break;
            case 'reset-password': $this->staff_reset_password($id);break;
            case 'assign': $this->staff_assign();break;
            case 'quit': $this->staff_quit($id);break;
            case 'delete': $this->staff_delete($id);break;
            default : {
                if ($id!='') {
                    $this->staff_detail($id);
                }
                else {
                    $this->staff_home();
                }
                break;
            }
        }
        $this->load->view('admin/index_after');
        $this->common->writeLog($act);
    }

    public function cms($act='', $id=''){
        $modRequiredRoles = array(ROLE_SYSTEM);
        if (!$this->permission->hasRoles($modRequiredRoles)) {$this->no_permission();return;}

        $this->load->view('admin/index_before');
        switch ($act){
            case 'add': $this->cms_add();break;
            case 'do-add': $this->cms_do_add();break;
            case 'edit': $this->cms_edit($id);break;
            case 'do-edit': $this->cms_do_edit();break;
            case 'delete': $this->cms_delete($id);break;
            default : $this->cms_home();break;
        }
        $this->load->view('admin/index_after');
        $this->common->writeLog($act);
    }

    public function export($sourceList, $filename='report.csv'){
//        $list = array (
//            array('aaa', 'bbb', 'ccc', 'dddd'),
//            array('123', '456', '789'),
//            array('"aaa"', '"bbb"')
//        );

        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment;filename='.$filename);
//        $fp = fopen('php://output', 'w');

        $fp = fopen($filename, 'w');

        foreach ($sourceList as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);

        // send response headers to the browser

        echo 'Export finished.';
        //$this->common->writeLog('Export data');
    }

    public function cms_home(){
        $data['guide_list'] = $this->cms_model->get('feedback');
        $this->load->view('admin/ajax/cms_home',$data);
    }
    public function cms_add(){
        $this->load->view('admin/ajax/cms_add');
    }
    public function cms_do_add(){
        $inputObject = $this->input->post();
        $inputObject['type'] = 'guide';

        if ($this->cms_model->add($inputObject) > 0) {
            $this->common->callbackConfirm('Successfully added!\nAdd one more?',base_url('admin/cms/add'),base_url('admin/student/list'));
        } else {
            $this->common->callbackConfirm('Add failed!\nWant to try again?',base_url('admin/cms'),base_url('admin/student/list'));
        }
    }
    public function cms_edit(){}
    public function cms_do_edit(){}
    public function cms_delete(){}

    /**
     * Functions
     */
    public function home(){
        $data['student_count_by_grade'] = $this->student_model->get_report_grade();
        $this->load->view('admin/ajax/dashboard', $data);
    }

    /**
     * Manage Attendance Functions
     */
    function attendance_chart_absence_obsolete(){
        $this->load->view('admin/charts/attendance_absence');
    }
    function attendance_chart_absence() {
        // Get list of MONTHS with respective enrollment data
        $query = "select month(absent_date) as month_no, monthname(absent_date) as month_name, count(*) as total from attendance_absent";
        $query .= sprintf(" where year(absent_date)='%s' group by month_no order by month_no asc", date('Y'));

        $query = $this->db->query($query);
        $result = $query->result();

        // In case no valid data
        if ($result==null) {echo "No data! ";}
        else {
            if ($result[0]->month_no == '0') {
                $result[0]->month_name = 'N/A';
            }
            $data['chart_data'] = $result;
            $this->load->view('admin/charts/attendance_absence', $data);
        }
    }
    function attendance_chart_absence_daily() {
        $this->load->view('admin/charts/attendance_absence_by_days');
    }


    /**
     * Student functions
     */
    function student_home() {
        $data['keywords'] = $this->input->get();
        $data['class_list'] = $this->class_model->get();
        $data['student_list'] = null;
        $data['view'] = 'admin/student';

        $this->load->view('admin/ajax/student_home', $data);
    }
    function student_search() {
        $data['keywords'] = $this->input->post();
        $data['class_list'] = $this->class_model->get();
        $this->load->view('admin/ajax/student_search', $data);
    }
    function student_do_search() {
        $data['keywords'] = $this->input->post();
        $data['class_list'] = $this->class_model->get();
        $query = $this->student_model->search($data['keywords']);
        $data['student_list'] = $query->result();

        $this->load->view('admin/ajax/student_home', $data);
    }
    function student_add() {
        $class_id = isset($_POST['select_class']) ? $_POST['select_class'] : -1;
        $data['selected_class'] = $class_id;
        $data['class_list'] = $this->class_model->get();
        $this->load->view('admin/ajax/student_add', $data);
    }
    function student_do_add() {
        $student['name'] = $this->input->post('name');
        $student['gender'] = $this->input->post('radGender');
        $student['class_id'] = $this->input->post('select_class');
        $student['dob'] = $this->input->post('dob');
        $student['doe'] = $this->input->post('doe');
        $student['status'] = $this->input->post('radStatus');
        $student['nation'] = $this->input->post('nationality');
        $student['mconline'] = $this->input->post('mconline');
        $student['code'] = $this->input->post('student_code');
        if (!empty($_FILES['photo']['name'])){
            $student['img'] = $this->common->upload_photo('students');
        }
//        $student['home_number'] = $this->input->post('home_number');
//        $student['district'] = $this->input->post('district');
//        $student['father_name'] = $this->input->post('father');
//        $student['mother_name'] = $this->input->post('mother');

        // Validate
        if (!$student['name'] || !$student['class_id'])
        {$this->common->callbackAlert('Student name & class are required!', base_url('admin/student/add'));return;}

        if ($this->student_model->add($student) > 0) {
            $this->common->callbackConfirm('Successfully added!\nAdd one more?',base_url('admin/student/add'),base_url('admin/student/list'));
        } else {
            $this->common->callbackConfirm('Add failed!\nWant to try again?',base_url('admin/student/add'),base_url('admin/student/list'));
        }
    }
    function student_edit($student_id) {
        $data['class_list'] = $this->class_model->get();
        $data['student_list'] = $this->student_model->get_by_id($student_id);
        $this->load->view('admin/ajax/student_edit', $data);
    }
    function student_do_edit($student_id) {
        $student['id'] = $student_id;
        $student['name'] = $this->input->post('name');
        $student['gender'] = $this->input->post('radGender');
        $student['class_id'] = $this->input->post('select_class');
        $student['dob'] = $this->input->post('dob');
        $student['doe'] = $this->input->post('doe');
        $student['status'] = $this->input->post('radStatus');
        $student['nation'] = $this->input->post('nationality');
        $student['modified_on'] = date('Y-m-d H:i:s');
        $student['modified_by'] = $this->session->userdata('CURRENT_USER_ID');
        $student['mconline'] = $this->input->post('mconline');
        $student['code'] = $this->input->post('student_code');
        if (!empty($_FILES['photo']['name'])){
            $student['img'] = $this->common->upload_photo('students');
        }
//        $student['home_number'] = $this->input->post('home_number');
//        $student['district'] = $this->input->post('district');
//        $student['father_name'] = $this->input->post('father');
//        $student['mother_name'] = $this->input->post('mother');

        if ($this->student_model->update_info($student)) {
            $this->common->callbackAlert('Successfully updated!',base_url('admin/student/edit/'.$student_id));
        } else {
            $this->common->callbackAlert('Update nothing!',base_url('admin/student/edit/'.$student_id));
        }
    }
    function student_deactivate($student_id) {
        if ($this->student_model->update_status($student_id, STUDENT_STATUS_DEACTIVATED)) {
            echo "Successfully updated! ";
            echo '<a href="' . base_url('admin/student') . '">Back to list</a>';
        } else {
            echo "Update nothing!";
            echo '<a href="' . base_url('admin/student') . '">Back to list</a>';
        }
    }
    function student_transfer($student_id) {
        $data['campus_list'] = $this->campus_model->get();
        $data['class_list'] = $this->class_model->get();
        $data['student_list'] = $this->student_model->get_by_id($student_id);
        $this->load->view('admin/ajax/student_transfer', $data);
    }
    function student_do_transfer($student_id) {
        $student['id'] = $student_id;
        $student['class_id'] = $this->input->post('select_class');

        if ($this->student_model->update_info($student)) {
            $this->common->callbackAlert('Transferred successfully!',base_url('admin/student/details/'.$student_id));
        } else {
            $this->common->callbackAlert('Update nothing!',base_url('admin/student'));
        }
    }
    function student_details($student_id) {
        $data['class_list'] = $this->class_model->get();

        $student_name = isset($_POST['txtStudentName']) ? $_POST['txtStudentName'] : "";
        $data['student_name'] = $student_name;

        $class_id = isset($_POST['select_class']) ? $_POST['select_class'] : $data['class_list'][0]->id;
        $data['selected_class'] = $class_id;

        $data['student_list'] = $this->student_model->get_by_id($student_id);
        $this->load->view('admin/ajax/student_details', $data);
    }
    function student_delete($id) {
        if ($id > 0) {
            $this->db->where('id', $id);

            if ($this->db->delete('students')) {
                $this->common->callbackAlert('Deleted successfully!',base_url('admin/student'));
            } else {
                $this->common->callbackAlert('Cannot delete!',base_url('admin/student/details/'.$id));
            }
        } else {
            $this->common->callbackAlert('Cannot delete!',base_url('admin/student/details/'.$id));
        }
    }
    function student_chart1() {
        $this->load->view('admin/charts/student_chart');
    }
    function student_chart_grade_ratio() {
        $query= $this->db->query("select count(*) as total from students where status=".STUDENT_STATUS_ACTIVE);
        $result = $query->result();
        $data['total_students_count'] = $result[0]->total;
        $data['student_count_by_grade'] = $this->student_model->get_report_grade();
        $this->load->view('admin/charts/student_ratio_by_grade', $data);
    }
    function student_chart_gender() {
        $data['chartData'] = $this->student_model->get_chart_gender();
        $this->load->view('admin/charts/student_gender', $data);
    }

    /**
     * Campus functions
     */
    function campus_home() {
        $data['campus_list'] = $this->campus_model->get();
        $this->load->view('admin/ajax/campus_home', $data);
    }
    function campus_add() {
        $this->load->view('admin/ajax/campus_add');
    }
    function campus_do_add() {
        $input = $this->input->post();

        // Validate input data
        if ($input['name'] == '') {
            echo 'Campus name is required!';
            return false;
        }

        // Init object to insert
        $objCampus['name'] = $input['name'];
        $objCampus['address'] = $input['address'];
        $objCampus['tel'] = $input['tel'];

        if ($this->campus_model->add($objCampus) > 0) {
            redirect(base_url('admin/campus'));
        } else {
            echo "Add failed!";
        }
    }
    function campus_edit($id) {

    }
    function campus_do_edit() {}
    function campus_delete($id) {
        if ($id > 0) {
            $this->db->where('id', $id);

            if ($this->db->delete('campuses')) {
                $result = 'Deleted successfully!';
                echo $result;
            } else {
                $result = 'Not deleted!';
                echo $result;
            }
        } else {
            $result['msg'] = 'Error!';
            echo json_encode($result);
        }
    }

    /**
     * Class functions
     */
    function class_home() {
        $data['class_list'] = $this->class_model->get();
        $data['campus_list'] = $this->campus_model->get();
        $this->load->view('admin/ajax/class_home', $data);
    }
    function class_add() {
        $data['campus_list'] = $this->campus_model->get();
        $this->load->view('admin/ajax/class_add', $data);
    }
    function class_do_add() {
        $input = $this->input->post();

        // Validate input data
        if ($input['class_name'] == '') {
            echo 'Class name is required!';
            return false;
        } else if ($input['campus'] == '') {
            echo 'Campus is required!';
            return false;
        }

        // Init object to insert
        $objClass['cam_id'] = $input['campus'];
        $objClass['grade'] = $input['grade'];
        $objClass['class_name'] = $input['class_name'];
        $objClass['programme'] = $input['programme'];

        if ($this->class_model->add($objClass) > 0) {
            redirect(base_url('admin/classes'));
        } else {
            echo "Add failed!";
        }
    }
    function class_edit($id) {
        $data['class'] = $this->class_model->get($id);
        $this->load->view('admin/ajax/class_edit', $data);
    }
    function class_do_edit() {}
    function class_delete($id) {
        if ($id > 0) {
            $this->db->where('id', $id);

            if ($this->db->delete('classes')) {
                $result = 'Deleted successfully!';
                echo $result;
            } else {
                $result = 'Not deleted!';
                echo $result;
            }
        } else {
            $result['msg'] = 'Error!';
            echo json_encode($result);
        }
    }
    function class_class_list() {
        $input = $this->input->post(); //var_dump($input);die;
        $data['keywords'] = $input;

        $id="";
        if(isset($input['select_class'])) {
            $id = $input['select_class'];
        }
        $data['class_list'] = $this->class_model->get();
        $data['campus_list'] = $this->campus_model->get();
        $data['student_list'] = $this->student_model->get_by_class($id);
        $data['student_list_all'] = $this->student_model->search_simple($data['keywords']);
        $this->load->view('admin/ajax/class_classlist', $data);
    }

    /**
     * Staff functions
     */
    function staff_home() {
        $data['staff_list'] = $this->staff_model->get('',1);
        $data['campus_list'] = $this->campus_model->get();
        $this->load->view('admin/ajax/staff_admin', $data);
    }
    function staff_detail($staff_id) {
        $data['campus_list'] = $this->campus_model->get();
        $listStaff = $this->staff_model->get($staff_id);
        if (count($listStaff) > 0) {
            $data['staff'] = $listStaff[0];
            $this->load->view('admin/ajax/staff_detail', $data);
        } else {
            $this->common->callbackAlert('ID is not existing.',base_url('admin/staff'));
        }
    }
    function staff_add() {
        $data['campus_list'] = $this->campus_model->get();
        $this->load->view('admin/ajax/staff_add', $data);
    }
    function staff_do_add() {
        $input = $this->input->post();

        // Validate input data
        if ($input['name'] == '') {
            echo 'Staff name is required!';
            return false;
        }

        // Init object to insert
        $objStaff['staff_code'] = $input['staff_code'];
        $objStaff['cam_id'] = $input['cam_id'];
        $objStaff['name'] = $input['name'];
        $objStaff['gender'] = $input['gender'];
        $objStaff['email'] = $input['email'];
        $objStaff['password'] = md5($input['password']);
        $objStaff['nation'] = $input['nation'];
        if (!empty($_FILES['photo']['name'])){
            $objStaff['img'] = $this->common->upload_photo('staff');
        }
        $objStaff['department'] = $input['department'];
        $objStaff['job_title'] = $input['job_title'];
        $objStaff['mobile'] = $input['mobile'];
		if ($input['joined_on']) {$objStaff['joined_on'] = $input['joined_on'];}
        $objStaff['status'] = $input['status'];
        if ($this->staff_model->add($objStaff) > 0) {
            $this->common->callbackConfirm('Successfully added!\nAdd one more?',base_url('admin/staff/add'),base_url('admin/staff/list'));
        } else {
            $this->common->callbackAlert('Adding failed.',base_url('admin/staff/add'));
        }
    }
    function staff_edit($staff_id) {
        $data['campus_list'] = $this->campus_model->get();
        $listStaff = $this->staff_model->get($staff_id);
        if (count($listStaff) > 0) {
            $data['staff'] = $listStaff[0];
            $this->load->view('admin/ajax/staff_edit', $data);
        } else {
            $this->common->callbackAlert('ID is not existing.',base_url('admin/staff'));
        }
    }
    function staff_do_edit() {
        $input = $this->input->post();

        // Validate input data
        if ($input['name'] == '') {
            echo 'Staff name is required!';
            return false;
        }

        // Init object to insert
        $objStaff['id'] = $input['staff_id'];
        $objStaff['staff_code'] = $input['staff_code'];
        $objStaff['cam_id'] = $input['cam_id'];
        $objStaff['name'] = $input['name'];
        $objStaff['gender'] = $input['gender'];
        $objStaff['email'] = $input['email'];
        if (!empty($input['password'])){
            $objStaff['password'] = md5($input['password']);
        }
        $objStaff['nation'] = $input['nation'];
        if (!empty($_FILES['photo']['name'])){
            $objStaff['img'] = $this->common->upload_photo('staff');
        }
        $objStaff['department'] = $input['department'];
        $objStaff['job_title'] = $input['job_title'];
        $objStaff['mobile'] = $input['mobile'];
        //if ($input['joined_on']) {$objStaff['joined_on'] = $input['joined_on'];}
        //if ($input['left_on']) {$objStaff['left_on'] = $input['left_on'];}
        $objStaff['joined_on'] = $input['joined_on'];
        $objStaff['left_on'] = $input['left_on'];
        $objStaff['status'] = $input['status'];
        if ($this->staff_model->update($objStaff)) {
            $this->common->callbackConfirm('Edited Successfully!\nBack to staff list?',base_url('admin/staff/list'),base_url('admin/staff/edit/'.$objStaff['id']));
        } else {
            echo "Edit failed!";
        }
    }
    function staff_reset_password($id) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->set('password', md5(STAFF_DEFAULT_PASSWORD));

            if ($this->db->update('staff')) {
                $this->common->callbackAlert('Password reset successfully!', base_url('admin/staff/list'));
            } else {
                $this->common->callbackAlert('Action failed!', base_url('admin/staff/list'));
            }
        } else {
            $this->common->callbackAlert('Unknown error! Maybe Staff ID is not valid!', base_url('admin/staff/list'));
        }
    }
    function staff_quit($id,$left_date='') {
        if ($id > 0) {
            $this->db->where('id', $id);
            
			if ($left_date==''){
				$left_on = date('Y-m-d');
			} else {
				$left_on = $left_date;
			}
			
			$this->db->set('status', STT_STAFF_QUITED);
			$this->db->set('left_on', $left_on);
			
            if ($this->db->update('staff')) {
                $this->common->callbackAlert('Staff edited successfully!', base_url('admin/staff/list'));
            } else {
                $this->common->callbackAlert('Action failed!', base_url('admin/staff/list'));
            }
        } else {
            $this->common->callbackAlert('Unknown error! Maybe Staff ID is not valid!', base_url('admin/staff/list'));
        }
    }
    function staff_delete($id) {
        if ($id > 0) {
            $this->db->where('id', $id);

            if ($this->db->delete('staff')) {
                $this->common->callbackAlert('Deleted successfully!', base_url('admin/staff/list'));
            } else {
                $this->common->callbackAlert('Action failed!', base_url('admin/staff/list'));
            }
        } else {
            $this->common->callbackAlert('Unknown error! Maybe Staff ID is not valid!', base_url('admin/staff/list'));
        }
    }
    function staff_assign() {
        $class_id = isset($_POST['select_class']) ? $_POST['select_class'] : -1;
        $data['selected_class'] = $class_id;
        $data['class_list'] = $this->class_model->get();
        $data['staff_list'] = $this->staff_model->get_by_class_for_assign($class_id);
        $this->load->view('admin/ajax/staff_assignclass', $data);
    }
    function staff_assign2() {
        $class_id = isset($_POST['select_class']) ? $_POST['select_class'] : -1;
        $data['selected_class'] = $class_id;
        $data['class_list'] = $this->class_model->get();
        $data['staff_list'] = $this->staff_model->get_by_class_for_assign($class_id);
        $this->load->view('admin/ajax/staff_assignclassv2', $data);
    }
    function staff_do_assign() {
        $re_class_teacher = $this->input->post();

        if ($re_class_teacher['cid'] > 0 && $re_class_teacher['sid'] > 0) {
            if ($this->db->insert('re_class_teacher', $re_class_teacher)) {
                $result = 'Assigned successfully!';
                echo $result;
            } else {
                $result = 'Assigned already!';
                echo $result;
            }
        } else {
            $result['msg'] = 'Not select any class!';
            echo json_encode($result);
        }
    }
    function staff_do_unassign() {
        $re_class_teacher = $this->input->post();

        if ($re_class_teacher['cid'] > 0 && $re_class_teacher['sid'] > 0) {
            $this->db->where('cid', $re_class_teacher['cid']);
            $this->db->where('sid', $re_class_teacher['sid']);

            if ($this->db->delete('re_class_teacher')) {
                $result = 'Deleted successfully!';
                echo $result;
            } else {
                $result = 'Not unassigned!';
                echo $result;
            }
        } else {
            $result['msg'] = 'Error!';
            echo json_encode($result);
        }
    }

    function no_permission() {
        if ($this->permission->canAccessAdminPanel()){
            $this->load->view('admin/index_before');
            $this->load->view('ajax/no_permission');
            $this->load->view('admin/index_after');
        } else {
            redirect(base_url());
        }
    }
    function all_to_md5(){
        $staff_list = $this->staff_model->get();
        $update_query="update staff set password = '%s' where id=%s;";
        foreach ($staff_list as $staff){
            echo sprintf($update_query,md5($staff->password),$staff->id);
            echo '<br/>';
        }
    }
}

/* End of file student.php */
/* Location: ./application/controllers/student.php */