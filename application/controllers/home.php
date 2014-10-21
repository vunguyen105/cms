<?php if (!defined('BASEPATH')) exit('No direct scripts access allowed');

class Home extends CI_Controller
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
    }

    public function index()
    {
		$this->landing();

        /*$this->load->library('user_agent');
        $agent = $this->agent->mobile();
        if ($this->agent->is_mobile()) {
            redirect(base_url('m/index'));
        } else {
            $this->landing();
        }*/
    }

    public function landing()
    {
        $this->permission->requireLogin();
        $this->load->view(CURRENT_THEME.'/index');
    }

    public function home()
    {
        $this->permission->requireLogin();
        $this->load->view(CURRENT_THEME.'/index');
    }

    public function author()
    {
        $this->load->view('admin/author');
    }

    public function gallery()
    {
        $this->load->view(CURRENT_THEME.'/gallery1');
    }

    public function login($error = '')
    {
        $refer_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();

        // If user logged in, redirect to previous page
        if ($this->session->userdata('CURRENT_USER_ID') != '') {
            redirect($refer_url);
        }

        $data['error'] = $error;
        $data['referrer_url'] = $refer_url;

        $this->load->view(CURRENT_THEME.'/login3', $data);
//        $this->load->view(CURRENT_THEME.'/includes/footer');
    }

    public function do_login()
    {
        $username = trim($_POST['txtUsername']);
        $password = md5($_POST['txtPassword']);

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
                redirect(base_url());
            } else {
                $this->login("Password is not correct!");
                $this->common->writeLog('Login failed', 'Wrong password.' . ' U:' . $username . '. P:' . $password);
            }
        } else {
            $this->login("Username/ Email is not found!");
            $this->common->writeLog('Login failed', 'Username not found.' . 'U:' . $username . '. P:' . $password);
        }
    }

    public function userguide($id = '')
    {
        $this->common->writeLog('User guide', 'view');
        if ($id == '') {
            $data['guide_list'] = $this->cms_model->get('guide');
            $this->load->view(CURRENT_THEME.'/userguide', $data);
        } else {
            $data['guide_details'] = $this->cms_model->get('guide', $id);
            $this->load->view(CURRENT_THEME.'/userguide_details', $data);
        }
    }

    public function feedback()
    {
        $this->load->view(CURRENT_THEME.'/feedback');
        $this->common->writeLog('Feedback', 'view');
    }

    public function do_feedback()
    {
        $this->common->writeLog('Feedback', 'Sending');
        $inputObject = $this->input->post();
        $inputObject['type'] = 'feedback';

        if ($this->cms_model->add($inputObject) > 0) {
            $this->common->callbackAlert('Thanks a lot for your feedback!\nHave a nice day :)', base_url());
        } else {
            $this->common->callbackConfirm('Sorry, sending failed!\nPlease kindly click OK to try again \nor send me an email: huy.nguyenkim@vanphuc.sis.edu.vn. Thanks!', base_url('admin/cms'), base_url('admin/student/list'));
        }
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

        //$this->session->set_userdata('CURRENT_USER_AD_USER', $user_data[0]->staff_code);
        //$this->session->set_userdata('CURRENT_USER_AD_PWD', "");
		$this->session->set_userdata('CURRENT_USER_AD_USER', 'vnp1976v');
        $this->session->set_userdata('CURRENT_USER_AD_PWD', 'sms.vanphuc');
//        if ($this->permission->canAccessAdminPanel()) {
//            $this->session->set_userdata('VIEW_ADMIN_PANEL', true);
//        }
    }

    public function logout()
    {
        $this->common->writeLog('Logged out', 'successfully!');
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function change_password($error = '')
    {
        $this->permission->requireLogin();

        $data['error'] = $error;
        $this->load->view(CURRENT_THEME.'/ajax/change_password', $data);
    }

    public function do_change_password()
    {
        $this->permission->requireLogin();

        $password = $_POST['txtPassword'];
        $password1 = $_POST['txtPassword1'];
        if ($password == '') {
            $this->change_password('Password must not be blank!');
            return;
        } else if ($password != $password1) {
            $this->change_password('Passwords do not match. Please try again!');
            return;
        }

        $id = $this->session->userdata('CURRENT_USER_ID');
        $this->db->where('id', $id);
        $this->db->set('password', md5($password));
        $this->db->update('staff');
        $this->common->writeLog('Changed password', 'Changed to: ' . $password);

        echo "<br/><br/><br/><br/><br/><br/><p style='font-size: 20pt;text-align: center; font-weight: bold; color: blue;'>Password changed!</p>";
        echo "<head><meta http-equiv=\"refresh\" content=\"1; URL=" . base_url() . "\"></head>";
    }

    public function isMobile()
    {

    }

    function auto_update_password($id, $old_pwd, $new_pwd)
    {
        $this->db->where('id', $id);
        $this->db->set('password', $new_pwd);
        $this->db->update('staff');
        $this->common->writeLog('Auto Update Password', 'Updated from:' . $old_pwd . ' to: ' . $new_pwd);
    }

    function remind_change_password()
    {
        echo "<br/><br/><br/><br/><br/><br/><p style='font-size: 20pt;text-align: center; font-weight: bold; color: red;'>Please update your password right now!</p>";
        echo "<head><meta http-equiv=\"refresh\" content=\"2; URL=" . base_url('change-password') . "\"></head>";
        $this->common->writeLog('Remind to change password', 'Message shown!');
    }
}

/* End of file student.php */
/* Location: ./application/controllers/student.php */