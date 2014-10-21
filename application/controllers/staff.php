<?php if (!defined('BASEPATH')) exit('No direct scripts access allowed');

class Staff extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Common');
        $this->load->library('Permission');
        $this->load->model('staff_model');
        $this->load->model('class_model');
        $this->load->model('campus_model');
    }

    public function index()
    {
        $this->permission->requireLogin();
        $data['position_list'] = $this->staff_model->get_departments();
        $data['campus_list'] = $this->campus_model->get();
        $data['staff_list'] = $this->staff_model->get('', 1);
        $data['former_staff_list'] = $this->staff_model->get('', 0);
        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/staff_home', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');

        $this->common->writeLog('Staff', 'home');
    }

    /*
     * List former staff
     */
    public function former()
    {
        $this->permission->requireLogin();
        $data['position_list'] = $this->staff_model->get_departments();
        $data['campus_list'] = $this->campus_model->get();
        $data['staff_list'] = $this->staff_model->get('', '0');
        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/staff_home', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');
    }

    public function filter()
    {
        $this->permission->requireLogin();
        $department = trim($_GET['department']);

        if ($department=='') {$this->index();return;}

        $data['staff_list'] = $this->staff_model->get_staff_by_department($department);
        $data['position_list'] = $this->staff_model->get_departments();
        $data['campus_list'] = $this->campus_model->get();
        $data['department'] = $department;
        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/staff_home', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');
    }

    // for ajax call
    public function details($staff_id)
    {
        $data['staff_info'] = $this->staff_model->get($staff_id);
        if (count($data['staff_info']) > 0) {
            $data['classes_assigned']=$this->class_model->get_classes_by_staff($staff_id);
            $this->load->view(CURRENT_THEME.'/ajax/staff_details', $data);
        } else {
            echo "No data";
        }
    }

    /*
     * Load teachers of a selected class
     * Use with ADMIN STAFF permission only (as it returns staff's m no.)
     * This function is for AJAX calls so it doesn't load any view
     */
    public function teachers_by_class_a()
    {
        $class_id = $_POST['class_id'];
        $data['staff_list'] = $this->staff_model->get_staff_by_class($class_id);

        if (count($data['staff_list'])) {
            foreach ($data['staff_list'] as $staff) {
                echo "<label>" . $staff->staff_name . '</label> - ' . $staff->mobile . "<br/><br/>";
            }
        } else {
            echo "Sorry. No information yet.";
        }
    }

    /*
     * Load teachers of a selected class
     * This function is for AJAX calls so it doesn't load any view
     */
    public function teachers_by_class()
    {
        $class_id = $_POST['class_id'];
        $data['staff_list'] = $this->staff_model->get_staff_by_class($class_id);

        if (count($data['staff_list']) > 0) {
            foreach ($data['staff_list'] as $staff) {
                echo "<label>" . $staff->staff_name . '</label>' . "<br/><br/>";
            }
        } else {
            echo "Sorry! No information yet.";
        }
    }

    /*
    * Load classes of a selected teacher
    * This function is for AJAX calls so it doesn't load any view
    */
    public function classes_by_teacher($staff_id)
    {
        $data['class_list']=$this->class_model->get_classes_by_staff($staff_id);
        if (count($data['class_list']) > 0) {
            foreach ($data['class_list'] as $class) {
                echo "<label>" . $class->class_name . '</label>' . "<br/><br/>";
            }
        } else {
            echo "No information.";
        }
    }

}

/* End of file student.php */
/* Location: ./application/controllers/student.php */


