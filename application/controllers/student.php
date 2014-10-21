<?php if (!defined('BASEPATH')) exit('No direct scripts access allowed');

class Student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Common');$this->load->library('Permission');
        $this->load->helper('form');
        $this->load->model('student_model');
    }

    function verifyPermission()
    {
        $hasPermission = array(1, 23, 46, 82);
        $current_user = $this->session->userdata('CURRENT_USER_ID');
        if ($current_user == "" || !in_array($current_user, $hasPermission)) {
            redirect(base_url('home'));
            echo '<br/><br/><br/><br/><br/><br/><p style="font-size: 16pt; text-align: center; font-weight: bold; color: red;">Sorry! You have no permission to access this area!</p>';
        }
    }

    public function index()
    {
        $this->permission->requireLogin();

        if ($this->common->isSuperAdminStaff()) {
            $this->home();
        } else {
            redirect(base_url('admin/no_permission'));
        }
    }


    public function export_excel()
    {
        $this->common->requireAdminStaff();

        echo count($this->input->get());
//        $this->common->export_excel($this->student_model->search($this->input->get()));
    }

    public function manage_class()
    {
        $data['class_list'] = $this->student_model->get_all_classes();

//        For search
        if (isset($_POST['txtStudentName'])) {
            $this->session->set_userdata('SEARCH_NAME', $_POST['txtStudentName']);
        }

        if (isset($_POST['select_class'])) {
            $this->session->set_userdata('SEARCH_CLASS', $_POST['select_class']);
        }

        if (isset($_POST['select_class_edit'])) {
            $this->session->set_userdata('CLASS_EDIT', $_POST['select_class_edit']);
        }

        $data['student_name'] = $this->session->userdata('SEARCH_NAME');
        $data['selected_class'] = $this->session->userdata('SEARCH_CLASS');
        $data['selected_class_edit'] = ($this->session->userdata('CLASS_EDIT')) ? $this->session->userdata('CLASS_EDIT') : $data['class_list'][0]->id;

        $data['student_list'] = $this->student_model->get_students($data['selected_class'], $data['student_name']);

//        For edit
        $this->load->model('class_model');
        $data['class_edit'] = $this->class_model->get_by_id($data['selected_class_edit']);
        $empty_class_obj = array('id' => '1', 'name' => '1', 'grade' => '1');
        $data['class_edit'] = count($data['class_edit']) > 0 ? $data['class_edit'][0] : $empty_class_obj;
        $this->load->view(CURRENT_THEME.'/class_home', $data);
    }

}

/* End of file student.php */
/* Location: ./application/controllers/student.php */