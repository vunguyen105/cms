<?php if (!defined('BASEPATH')) exit('No direct scripts access allowed');

class Ad extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Common');
        $this->load->library('Permission');
    }

    public function index()
    {
        $this->permission->requireLogin();
        //$this->login();
        $this->search();
        $this->common->writeLog('AD', 'Index');
    }


    public function login($error='')
    {
	    //$this->permission->requireLogin();
        $data['current_user'] = $this->session->userdata('CURRENT_USER_AD_USER');
        $data['current_pwd'] = $this->session->userdata('CURRENT_USER_AD_PWD');

        $data['error'] = $error;
        $this->load->view('admin/index_before');
        $this->load->view('admin/ajax/ldap_login', $data);
        $this->load->view('admin/index_after');
        $this->common->writeLog('AD', 'Login');
    }

    public function do_login(){
		//$this->permission->requireLogin();
        $this->common->writeLog('AD', 'Login Do Login');

        error_reporting(E_ALL ^ E_WARNING);
        $username = trim($_POST['current_user_us']);
        $password = trim($_POST['current_user_pwd']);

		if ($username == '' || $password == '') {
            $this->login("Username/Password cannot be blank!");
            return;
        }
		
        // Connect to LDAP Server
        $host = $this->config->item('ldap_host');
        $domain = $this->config->item('ldap_domain');

        $ldap = ldap_connect("ldap://{$host}.{$domain}");
        if (!$ldap) {
            $this->login("Cannot connect Active Directory Server");
            return;
        }

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $obj_ldap = ldap_bind($ldap, "{$username}@{$domain}", $password);

        if (!$obj_ldap) {
            $this->login("Login failed. Cannot bind user");
            return;
        }

        $this->session->set_userdata('CURRENT_USER_AD_USER', $username);
        $this->session->set_userdata('CURRENT_USER_AD_PWD', $password);
        redirect(base_url('ad/search'));
    }

    public function ldap_is_authenticated_user()
    {
        error_reporting(E_ALL ^ E_WARNING);
        $username = trim($_POST['current_user_us']);
        $password = trim($_POST['current_user_pwd']);

        if ($username == '' || $password == '') {
            echo "Username/Password cannot be blank!";
            return false;
        }

        // Connect to LDAP Server
        $host = $this->config->item('ldap_host');
        $domain = $this->config->item('ldap_domain');
        $ldap = ldap_connect("ldap://{$host}.{$domain}");

        // Use port is OK too
        //$ldap = ldap_connect("{$host}.{$domain}",389);

        if (!$ldap) {
            echo "Cannot connect LDAP Server";
            return false;
        }

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $obj_ldap = ldap_bind($ldap, "{$username}@{$domain}", $password);

        if ($obj_ldap) {
            $this->session->set_userdata('CURRENT_USER_AD_USER', $username);
            $this->session->set_userdata('CURRENT_USER_AD_PWD', $password);
            echo "Logged in successfully";
            return true;
        }

        echo "Username/Password is not correct";
        return false;
    }

    public function search($error = '')
    {
        $params = $this->input->post();
        $data['current_user'] = $this->session->userdata('CURRENT_USER_AD_USER');
        $data['current_pwd'] = $this->session->userdata('CURRENT_USER_AD_PWD');

        if ($data['current_user']=='') {
            $this->login();
            return;
        }

        $data['params'] = $params;
        $data['error'] = $error;
        $this->load->view('admin/index_before');
        $this->load->view('admin/ajax/ldap_search', $data);
        $this->load->view('admin/index_after');
        $this->common->writeLog('AD', 'Search Homepage');
    }

    /*
     * LDAP do search
     */
    public function do_search()
    {
        error_reporting(E_ALL ^ E_WARNING);

        // Connect to LDAP Server
        $host = $this->config->item('ldap_host');
        $domain = $this->config->item('ldap_domain');
        $base_dn = 'DC=kinderworldgroup,DC=com';

        $ldap = ldap_connect("ldap://{$host}.{$domain}");
        if (!$ldap) {
            $this->search("Cannot connect Active Directory Server");
            return;
        }

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $username = $this->session->userdata('CURRENT_USER_AD_USER');
        $password = $this->session->userdata('CURRENT_USER_AD_PWD');

        $obj_ldap = ldap_bind($ldap, "{$username}@{$domain}", $password);

        if (!$obj_ldap) {
            $this->search("Login failed. Cannot bind user");
            return;
        }

        // Get search params
        $params = $this->input->post();
        $filters = $this->get_filter_params($params);
        if ($filters == '') {
            $this->search("You must input some keywords to search");
            return;
        }

        $ldap_query = "(&(objectClass=user)" . $filters . ")";

        // Do search LDAP
        // limit attributes we want to look for
        $attributes_ad = array("displayName", "description", "samaccountname", "givenName", "sn", "mail", "physicaldeliveryofficename", "whencreated", "company", "title");
        $sr = ldap_search($ldap, $base_dn, $ldap_query, $attributes_ad);

        // Sort
        if ($params['sort']!='')
        {ldap_sort($ldap, $sr, $params['sort']);}

        $data = ldap_get_entries($ldap, $sr);

        //Convert result to array to display in table
        $key = false;
        for ($entry = ldap_first_entry($ldap, $sr);
             $entry != false;
             $entry = ldap_next_entry($ldap, $entry)) {
            $user = array();
            $attributes = ldap_get_attributes($ldap, $entry);
            for ($i = $attributes['count']; $i--> 0;) {
                $user[strtolower($attributes[$i])] = $attributes[$attributes[$i]][0];
            }
            if ($key && $user[$key])
                $users[strtolower($user[$key])] = $user;
            else
                $users[] = $user;
        }
        ldap_unbind($ldap);

        // Load view
        $data['current_user'] = $this->session->userdata('CURRENT_USER_AD_USER');
        $data['current_pwd'] = $this->session->userdata('CURRENT_USER_AD_PWD');
        $data['params'] = $params;
        $data['list_ad_user'] = isset($users)?$users:null;
        $this->load->view('admin/index_before');
        $this->load->view('admin/ajax/ldap_search', $data);
        $this->load->view('admin/index_after');
        $this->common->writeLog('AD', 'Search Do search');
    }

    function get_filter_params($params)
    {
/*        $user['givenname'] = trim($params['firstname']);
        $user['sn'] = trim($params['lastname']);*/
        $user['displayname'] = trim($params['fullname']);
        $user['title'] = trim($params['title']);
        $user['mail'] = trim($params['email']);
        $user['samaccountname'] = trim($params['code']);

        $query_filter = "";

        /*if ($user['givenname'] != '') {
            $query_filter .= "(givenname=*" . $user['givenname'] . "*)";
        }
        if ($user['sn'] != '') {
            $query_filter .= "(sn=*" . $user['sn'] . "*)";
        }*/
        if ($user['displayname'] != '') {
            $query_filter .= "(displayname=*" . $user['displayname'] . "*)";
        }
        if ($user['title'] != '') {
            $query_filter .= "(title=*" . $user['title'] . "*)";
        }
        if ($user['mail'] != '') {
            $query_filter .= "(mail=*" . $user['mail'] . "*)";
        }
        if ($user['samaccountname'] != '') {
            $query_filter .= "(samaccountname=*" . $user['samaccountname'] . "*)";
        }

        return $query_filter;
    }
}