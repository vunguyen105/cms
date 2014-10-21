<?php if (!defined('BASEPATH')) exit('No direct scripts access allowed');

/*
 * Web Services for integrating with other components
 * HuyNK
 * 2013/06
 */
class Ws extends CI_Controller
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
        $this->load->model('staff_model');
    }

    public function index()
    {
        $response_json["success"] = 1;
        $response_json["message"] = "This is Web Services of School Management System\nNguyen Kim Huy\n2013";
        echo json_encode($response_json);
    }

    /*
     * Authenticate user by username & password
     * Return JSON: login status
     */
    public function do_login()
    {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $username = "huy";
        $password = "sms.vanphuc";

        // Validate with database info
        $data = $this->staff_model->get_user_by_username($username);

        if (count($data) == 1) {
            if ($data[0]->password == $password) {
				$user = $data[0];
                $response["success"] = 1;
				$response["message"] = "Logged in successfully";
				$response["user"]["id"] = $user->id;
				$response["user"]["staff_code"] = $user->staff_code;
				$response["user"]["email"] = $user->email;
				$response["user"]["password"]= $user->password;
				$response["user"]["name"]= $user->name;
				$response["user"]["job_title"] = $user->job_title;
				$response["user"]["mobile"] = $user->mobile;
				$response["user"]["img"] = $user->img;
				$response["user"]["username_ad"] = "vnp1976v";
				$response["user"]["password_ad"] = "sms.vanphuc";
            } else {
                $response["error"] = 1;
                $response["message"] = "Password is incorrect!";
            }
        } else {
            $response["error"] = 1;
            $response["message"] = "Username/Email does NOT exist!";
        }

        echo json_encode($response);
    }

    /*
     * Get all staff list
     */
    public function get_all_staff()
    {
        //$data['staff_list'] = $this->staff_model->get('', 1);
        $data['former_staff_list'] = $this->staff_model->get('', 0);
        echo json_encode($data['former_staff_list']);
    }

	/*
	* Get image being uploaded from Android
	*/
	public function do_upload(){
		
		if (!isset($_REQUEST['image']) || !isset($_POST['staff_id'])) 
		{
			$response["error"] = 1;
            $response["message"] = "Update photo failed";
			echo json_encode($response);
			return;
		}
		
		if (isset($_POST['filename']) || $_POST['filename']=='') 
		{
			$filename=date("Unknown_dmY_His.")."JPG";
		}
		
		$base=$_REQUEST['image'];
		$filename=$_POST['filename'];
		$photodir="photos/staff/";
		//$fullpath=$photodir.$filename;
		
		// Append x if existed
		if (file_exists($photodir.$filename)) {
			$array_name = explode(".", $filename);
			$filename = $array_name[0].date("_dmY_His").".".$array_name[1];
		}
		
		$binary=base64_decode($base);
		header('Content-Type: bitmap; charset=utf-8');
		$file = fopen($photodir.$filename, 'wb');
		fwrite($file, $binary);
		fclose($file);
		
		// Update staff photo
        $objStaff['id'] = $_POST['staff_id'];
		$objStaff['img'] = $filename;
        
		if ($this->staff_model->update($objStaff)) {
            $response["success"] = 1;
			$response["message"] = "Profile updated";
			echo json_encode($response);
        } else {
            $response["error"] = 1;
            $response["message"] = "Update photo failed";
			echo json_encode($response);
        }
		
		$response["success"] = 1;
		$response["message"] = "Image upload complete!";
		$response["file"] = base_url($photodir.$filename);
		echo json_encode($response);
	}
	
	/**
	* Return list of classes which haven't submitted attendance on ref_date
	* Param: $ref_date: the date you want to get the list
	*/
	function get_unsubmitted_classes($ref_date=''){
		if ($ref_date=='') {$ref_date=date('Y-m-d');}
	
		$data = $this->attendance_model->get_unsubmitted_classes($ref_date);
		$data = $data->result();
		
		// Return HTML ready for email content
		$content = "<table>";
		foreach ($data as $cls){
			$content .= '<tr><td>'.$cls->class_name.'</td></tr>';
		}
		$content.="</table>";
		echo $content;
	}
	
}