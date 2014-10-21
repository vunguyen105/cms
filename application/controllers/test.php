<?php if (!defined('BASEPATH')) exit('No direct scripts access allowed');

class Test extends CI_Controller
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
        $username = trim($_POST['txtUsername']);
        $password = $_POST['txtPassword'];

        // Validate with database info
        $data = $this->get_user_by_username($username);

        if (count($data) == 1) {
            if ($data[0]->password == $password) {
				// For android
				$response["success"] = 1;
				$response["message"] = "Logged in successfully";
				echo json_encode($response);
                
            } else {
                // user not found
				// echo json with error = 1
				$response["error"] = 1;
				$response["error_msg"] = "Incorrect password!";
				echo json_encode($response);
            }
        } else {
            $response["error"] = 1;
			$response["error_msg"] = "Incorrect email!";
			echo json_encode($response);
        }

    }
	
    public function ldap()
    {
        $user = 'vnp1976v';
		$password = 'sms.vanphuc';
		$host = 'vp-ads-s01';
		$domain = 'kinderworldgroup.com';
		$basedn = 'dc=kinderworldgroup,dc=com';
		$group = 'kinderworldgroup.com';

		$ad = ldap_connect("ldap://{$host}.{$domain}") or die('Could not connect to LDAP server.');
		ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);

		if ($bind = ldap_bind($ad, "{$user}@{$domain}", $password)){
			// limit attributes we want to look for
			$attributes_ad = array("displayName","description","cn","givenName","sn","mail","co","mobile","company","memberof");
			$sr = ldap_search($ad, "DC=kinderworldgroup,DC=com", "givenname=huy",$attributes_ad);
			$data = ldap_get_entries($ad, $sr);
			
			// SHOW ALL DATA
			echo '<h1>Dump all data</h1><pre>';
			echo 'Found: '.$data["count"].' records';
			//print_r($data);    
			echo '</pre>';
			
			
			// iterate over array and print data for each entry
			for ($i=0; $i<$data["count"];$i++) {
				for ($j=0;$j<$data[$i]["count"];$j++){
					echo "<strong>".$data[$i][$j]."</strong>: ".$data[$i][$data[$i][$j]][0]."<br/>";
				}
				echo "<br /><br />";
			}
		}
		echo "Finished";		
		
		/*
		@ldap_bind($ad, "{$user}@{$domain}", $password) or die('Could not bind to AD.');
		$userdn = $this->getDN($ad, $user, $basedn);
		if ($this->checkGroupEx($ad, $userdn, $this->getDN($ad, $group, $basedn))) {
		//if (checkGroup($ad, $userdn, getDN($ad, $group, $basedn))) {
			echo "You're authorized as ".getCN($userdn);
		} else {
			echo 'Authorization failed';
		}*/
		ldap_unbind($ad);
    }

    public function test_report()
    {
        $this->permission->requireLogin();

        $input_data = $this->input->get();
        $data['input_data'] = $input_data;
        $data['class_list'] = $this->class_model->get();

        $query = $this->attendance_model->get_monthly_report_nice($input_data);
        $data['report_list'] = ($query != '') ? $query->result() : null;
//        $this->load->view(CURRENT_THEME.'/reports/report_header');
        $this->load->view(CURRENT_THEME.'/reports/test_nice_report', $data);
        $this->load->view(CURRENT_THEME.'/reports/report_footer');

        $this->common->writeLog('Attendance', 'Report custom');
    }

    public function upload($error = '')
    {
        $data['error'] = $error;
//        $this->load->view(CURRENT_THEME.'/upload_image', $data);
        $this->load->view(CURRENT_THEME.'/upload_ajax', $data);
    }

    function do_upload()
    {
        // Prepare for upload
        $config['upload_path'] = './' . $this->config->item('upload_folder_photo');
        $config['allowed_types'] = $this->config->item('upload_allowed_types');
        $config['max_size'] = '500';
        $config['max_width'] = '2000';
        $config['max_height'] = '1600';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view(CURRENT_THEME.'/upload_image', $error);
        } else {
            // Do upload
            $data['upload_data'] = $this->upload->data();

            /* Process image */
            $source_img = $data['upload_data']['full_path'];
            $thumb_img = $config['upload_path'] . 'thumbs/' . $data['upload_data']['file_name'];

            $this->load->library('image_lib');
            $this->resize_image($source_img);
            $this->generate_thumb($source_img, $thumb_img);

            $status = "success";
            $msg = "File successfully uploaded";

            //$this->load->view(CURRENT_THEME.'/upload_success', $data);
            echo json_encode(array('status' => $status, 'msg' => $msg));
        }
    }

    function resize_image($source_image_url)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image_url;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 800;
//        $config['height'] = 315;
        $config['master_dim'] = 'width';

        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            $this->error("Error in resizing..");
        }
        $this->image_lib->clear();
    }

    function generate_thumb($source_image_url, $thumb_url)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image_url;
        $config['new_image'] = $thumb_url;
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = '';
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 800;
//        $config['height'] = 200;
        $config['master_dim'] = 'width';

        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            $this->error("Error in generating thumb..");
        }
        $this->image_lib->clear();
    }

    // rename photo. use once only
    public function rename()
    {
//        $files = glob("photos/staff/*.{jpg,JPG}", GLOB_BRACE);
//        foreach ($files as $file) {
//            $file_url = base_url($file);
//
//            if (strpos($file))
//            echo $file.'<br/>';
//        }
    }

    public function batch_edit()
    {
        $files = glob("photos/staff/*.{jpg,JPG}", GLOB_BRACE);
        $data['photo_list'] = $files;
        $data['staff_list'] = $this->staff_model->get();


        foreach ($data['staff_list'] as $staff) {
            foreach ($files as $p) {
                echo $staff->img . '<br/>';
                if (strpos($p, $staff->img)) echo 'shit';
//                echo strpos($p, $staff->img);
            }
        }

        return;
        $this->load->view(CURRENT_THEME.'/staff_edit_batch', $data);
    }

    public function email()
    {
        include_once("Mail.php");

        $From = "Sender's name <huy.nguyenkim.ec@gmail.com>";
        $To = "Recipient's name <huy.ltv@gmail.com>";
        $Subject = "Send Email using SMTP authentication";
        $Message = "This example demonstrates how you can send email with PHP using SMTP authentication";

        $Host = "smtp.gmail.com";
        $Username = "huy.nguyenkim.ec@gmail.com";
        $Password = "thao@phuong";

// Do not change bellow

        $Headers = array('From' => $From, 'To' => $To, 'Subject' => $Subject);
        $SMTP = Mail::factory('smtp', array(
            'host' => $Host,
            'auth' => true,
            'port' => '465',
            'username' => $Username,
            'password' => $Password));

        $mail = $SMTP->send($To, $Headers, $Message);

        if (PEAR::isError($mail)) {
            echo($mail->getMessage());
        } else {
            echo("Email Message sent!");
        }

    }

    public function email1()
    {
//        echo phpinfo();

//        $config = Array(
//            'protocol' => 'smtp',
//            'smtp_host' => 'smtp.gmail.com',
//            'smtp_port' => '465',
//            'smtp_user' => 'huy.nguyenkim.ec@gmail.com',
//            'smtp_pass' => 'thao@phuong',
//            'mailtype'  => 'html',
//            'charset'   => 'iso-8859-1'
//        );
//        $this->load->library('email', $config);

        $this->load->library('email');

        $config['protocol'] = "smtp";
        $config['smtp_host'] = "smtp.gmail.com";
        $config['smtp_user'] = "huy.nguyenkim.ec@gmail.com";
        $config['smtp_pass'] = "thao@phuong";
        $config['smtp_port'] = 465;
        $config['smtp_timeout'] = 5;

        $this->email->initialize($config);

        $this->email->from('huy.nguyenkim.ec@gmail.com', 'Your Name');
        $this->email->to('huy.ltv@gmail.com');
        $this->email->cc('huy.nguyenkiM@vanphuc.sis.edu.vn');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();

        echo $this->email->print_debugger();
    }

    public function show_form($error_msg = '')
    {
        $this->permission->requireLogin();

        $class_id = (isset($_POST['select_class']) && $_POST['select_class'] != '') ? $_POST['select_class'] : -1;
        $data['selected_class'] = $class_id;

        $selected_date = isset($_POST['txtDateReport']) ? $_POST['txtDateReport'] : date("Y-m-d");
        $data['selected_date'] = $selected_date;

        $data['class_list'] = $this->get_all_classes();
        $data['student_list'] = $this->get_students_with_attendance($class_id, $selected_date);
        $data['selected_students'] = "";

        if (isset($error_msg) && $error_msg != "") {
            $data['error_msg'] = $error_msg;
        }
        $this->load->view(CURRENT_THEME.'/attendance_form_test', $data);
    }

    function check_class_was_submitted($class_id, $submit_date)
    {
        $this->db->where("class_id", $class_id);
        $this->db->where("class_id", $class_id);
        $this->db->get('attendance_daily');
    }

    public function do_submit_quick()
    {
        $this->permission->requireLogin();

        $error = "";

        // Get request data
        $request_data = $this->input->post();
        $selected_class_id = isset($request_data[""]) ? $request_data[""] : "";
        $submit_date = isset($request_data[""]) ? $request_data[""] : "";
        $absent_status = isset($request_data[""]) ? $request_data[""] : "";
        $absent_list = isset($request_data[""]) ? $request_data[""] : ""; //(Not required)
        $user_id = "";

        // Validate
        if ($selected_class_id == "" || $absent_status == "" || $submit_date == "") {
            $error = "Error. Must select class, absent, date";
        }

        // Has absent?
        if ($absent_status == 0) {
            // Check if class was submitted => Update with new status
            // Submit Attendance_daily
            // Get all absent students on the $submit_date. If count() > 0 -> delete all those records
        } else {
            if (count($absent_list) < 1) {
                // Error
            } else {
                // Check if class was submitted => Update with new status

                // Submit absent student list
            }

        }
        //

        if (!isset($_POST['txtSelectedClass'])) {
            $this->common->writeLog('Submit Attendance', 'Failed. Has not chosen any class!:');
            echo '<br/><br/><br/><br/><br/><br/><p style="font-size: 16pt; text-align: center; font-weight: bold; color: red;">You have to select class first!</p>';
            $url = '<p style="font-size: 16pt; text-align: center; font-weight: bold; color: red;"><a href="' . $_SERVER['HTTP_REFERER'] . '">Click here to go back.</a></p>';
            echo $url;
            return;
        }

        $hasAbsent = isset($_POST['radHasAbsent']) ? $_POST['radHasAbsent'] : '';
        if ($hasAbsent == '') {
            $this->common->writeLog('Submit Attendance', 'Failed. Has not selected any student!:');
            echo '<br/><br/><br/><br/><br/><br/><p style="font-size: 16pt; text-align: center; font-weight: bold; color: red;">You have to select Full or Absent!</p>';
            $url = '<p style="font-size: 16pt; text-align: center; font-weight: bold; color: red;"><a href="' . $_SERVER['HTTP_REFERER'] . '">Click here to go back.</a></p>';
            echo $url;
            return;
        }

        $selected_class = $_POST['txtSelectedClass'];
        $absent_date = $_POST['txtAbsentDate'];
        $current_user = ($this->session->userdata('CURRENT_USER_ID') != "") ? $this->session->userdata('CURRENT_USER_ID') : -1;

        $objAttendDaily['date'] = $absent_date;
        $objAttendDaily['class_id'] = $selected_class;
        $objAttendDaily['updated_by'] = $current_user;

        if ($hasAbsent == 0) {
            $objAttendDaily['has_absent'] = 0;

            // check if there is already submitted students in table [attendance] -> delete all
            $this->attendance_model->update_attendance_status($objAttendDaily);
            // end check.

            $this->common->writeLog('Submit Attendance', 'Successful. Class is fully attended. - Date:' . $absent_date);
            echo "<br/><br/><br/><br/><br/><br/><p style='font-size: 30pt;text-align: center; font-weight: bold; color: blue;'>Submitted successfully!</p>";
            echo "<br/><p style='font-size: 20pt;text-align: center; font-weight: bold; color: #ff4500;'>Thanks a lot and Have a nice day! :)</p>";
            //$report_url = "attendance/report_absent/" . $selected_class;
            $report_url = "attendance/report_daily";
            echo "<head><meta http-equiv=\"refresh\" content=\"1; URL=" . base_url($report_url) . "\"></head>";

        } else {
            if (isset($_POST['ckbIsAbsent']) && count($_POST['ckbIsAbsent']) > 0) {
                $objAttendDaily['has_absent'] = 1;

                // check if not exist -> insert, else update attendance_daily set has_absent = 1
                $this->attendance_model->update_attendance_status($objAttendDaily);
                // end check.

                $list_selected_checkboxes = $_POST['ckbIsAbsent'];
                $listAbsentObjects = "";
                for ($iCount = 0; $iCount < count($list_selected_checkboxes); $iCount++) {
                    $stu_id = $list_selected_checkboxes[$iCount];
                    $listAbsentObjects[$iCount]['student_id'] = $stu_id;
                    $listAbsentObjects[$iCount]['comment'] = $_POST['txtComment'][$stu_id];
                    $listAbsentObjects[$iCount]['absent_date'] = $absent_date;
                    $listAbsentObjects[$iCount]['updated_by'] = $current_user;
                    $this->common->writeLog('Submit absent', ' For student ID: ' . $stu_id . ' - Absent date:' . $absent_date);
                }

                $this->db->insert_batch('attendance', $listAbsentObjects);

                echo "<br/><br/><br/><br/><br/><br/><p style='font-size: 30pt;text-align: center; font-weight: bold; color: blue;'>Submitted successfully!</p>";
                echo "<br/><p style='font-size: 20pt;text-align: center; font-weight: bold; color: #ff4500;'>Thanks a lot and Have a nice day! :)</p>";
                //$report_url = "attendance/report_absent/" . $selected_class;
                $report_url = "attendance/report_daily";
                echo "<head><meta http-equiv=\"refresh\" content=\"1; URL=" . base_url($report_url) . "\"></head>";
            } else {
                echo '<br/><br/><br/><br/><br/><br/><p style="font-size: 16pt; text-align: center; font-weight: bold; color: red;">Please select at least 1 student!</p>';
            }
        }
    }


    function get_all_classes()
    {
        $this->db->order_by('grade', 'asc');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('classes');
        return $query->result();
    }

    function get_attendance($date)
    {
        $this->attendance_model->get($date);
    }

    function get_students_with_attendance($class_id, $absent_date)
    {
        $query = "select students.id, name, absent_date, comment from students
        left join (select * from attendance where absent_date=?) as list_absent_today
        on students.id = list_absent_today.student_id
        where class_id = ? order by absent_date desc, name asc";
        $query = $this->db->query($query, array($absent_date, $class_id));
        return $query->result();
    }

    function get_absent_list($class_id = '', $date_absent = '')
    {
        $query = "select students.id, students.name, absent_date, comment, updated_by,updated_on,classes.name as class_name
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
        return $query->result();
    }

    function get_daily_attendance($class_id = '', $date_absent = '')
    {
        $query = $this->db->get('attendance_daily');
//        $query = $this->db->query($query);
        return $query->result();
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

    function count_submitted($date)
    {
        $this->db->where('date', $date);
        $query = $this->db->get('attendance_daily');
        $data = $query->result();
        return count($data);
    }

    function count_absent($date)
    {
        $this->db->where('absent_date', $date);
        $query = $this->db->get('attendance');
        $data = $query->result();
        return count($data);
    }

    function count_submit_by_staff($staff_id = '')
    {
        $this->db->where('updated_by', $staff_id);
        return $this->db->count_all_results('attendance_daily');
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

}