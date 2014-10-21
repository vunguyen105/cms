<?php if (!defined('BASEPATH')) exit('No direct scripts access allowed');

class Ldap extends CI_Controller
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
        $this->ldap_search();
    }


    public function ldap_login()
    {
        $data['current_user'] = $this->session->userdata('CURRENT_USER_AD_USER');
        $data['current_pwd'] = $this->session->userdata('CURRENT_USER_AD_PWD');
        $this->load->view('admin/index_before');
        $this->load->view('admin/ajax/ldap_login', $data);
        $this->load->view('admin/index_after');
    }

    public function ldap_is_authenticated_user()
    {
        error_reporting(E_ALL ^ E_WARNING );
        $username = trim($_POST['current_user_us']);
        $password = trim($_POST['current_user_pwd']);

        if ($username==''||$password==''){
            echo "Username/Password cannot be blank!";
            return;
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

    public function ldap_search($error = '')
    {
        $data['current_user'] = $this->session->userdata('CURRENT_USER_AD_USER');
        $data['current_pwd'] = $this->session->userdata('CURRENT_USER_AD_PWD');
        $data['error'] = $error;
        $this->load->view('admin/index_before');
        $this->load->view('admin/ajax/ldap_search', $data);
        $this->load->view('admin/index_after');
    }

    public function ldap_do_search()
    {
        // Save binded user account for current session
        $username = trim($_POST['current_user_us']);
        $password = trim($_POST['current_user_pwd']);
        $this->session->set_userdata('CURRENT_USER_AD_USER', $username);
        $this->session->set_userdata('CURRENT_USER_AD_PWD', $password);

        // Get search params
        $user['givenname'] = trim($_POST['firstname']);
        $user['sn'] = trim($_POST['lastname']);
        $user['displayname'] = trim($_POST['fullname']);
        $user['title'] = trim($_POST['title']);
        $user['mail'] = trim($_POST['email']);
        $user['cn'] = trim($_POST['code']);

        $query_filter = "";

        if ($user['displayname'] != '') {
            $query_filter .= "(displayname=*" . $user['displayname'] . "*)";
        }
        ;
        if ($user['givenname'] != '') {
            $query_filter .= "(givenname=*" . $user['givenname'] . "*)";
        }
        ;
        if ($user['sn'] != '') {
            $query_filter .= "(sn=*" . $user['sn'] . "*)";
        }
        ;
        if ($user['title'] != '') {
            $query_filter .= "(title=*" . $user['title'] . "*)";
        }
        ;
        if ($user['mail'] != '') {
            $query_filter .= "(mail=*" . $user['mail'] . "*)";
        }
        ;
        if ($user['cn'] != '') {
            $query_filter .= "(cn=*" . $user['cn'] . "*)";
        }
        ;

        if ($query_filter == '') {
            $this->ldap_search("You must input some keywords to search");
            return;
        }

        $ldap_query = "(&(objectClass=user)";
        $ldap_query .= $query_filter;
        $ldap_query .= ")";

        // Connect to LDAP Server
        $host = $this->config->item('ldap_host');
        $domain = $this->config->item('ldap_domain');
        $base_dn = 'DC=kinderworldgroup,DC=com';

        $ldap = ldap_connect("ldap://{$host}.{$domain}");
        if (!$ldap) {
            echo "Cannot connect LDAP Server";
            return;
        }

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $obj_ldap = ldap_bind($ldap, "{$username}@{$domain}", $password);

        if (!$obj_ldap) {
            echo "Cannot bind user";
            return;
        }

        // Do search LDAP

        // limit attributes we want to look for
        $attributes_ad = array("displayName", "description", "cn", "givenName", "sn", "mail", "co", "mobile", "company", "title");
        //$attributes_ad = array();
        $sr = ldap_search($ldap, $base_dn, $ldap_query, $attributes_ad);
        $data = ldap_get_entries($ldap, $sr);


        // DUMP ALL DATA
        /*echo 'Found: ' . $data["count"] . ' records';

        // iterate over array and print data for each entry
        for ($i = 0; $i < $data["count"]; $i++) {
            for ($j = 0; $j < $data[$i]["count"]; $j++) {
                echo "<strong>" . $data[$i][$j] . "</strong>: " . $data[$i][$data[$i][$j]][0] . "<br/>";
            }
            echo "<br /><br />";
        }
        //echo json_encode($data);
        echo "Finished";*/

        $key=false;

        for ($entry=ldap_first_entry($ldap,$sr);
             $entry!=false;
             $entry=ldap_next_entry($ldap,$entry)) {
            $user = array();
            $attributes = ldap_get_attributes($ldap,$entry);
            for($i=$attributes['count'];$i-- >0;) {
                $user[strtolower($attributes[$i])] = $attributes[$attributes[$i]][0];
            }
            if( $key && $user[$key] )
                $users[strtolower($user[$key])] = $user;
            else
                $users[] = $user;
        }
        ldap_unbind($ldap);

        $data['current_user'] = $this->session->userdata('CURRENT_USER_AD_USER');
        $data['current_pwd'] = $this->session->userdata('CURRENT_USER_AD_PWD');
        $data['error'] = '';
        $data['list_ad_user'] = $users;
        $this->load->view('admin/index_before');
        $this->load->view('admin/ajax/ldap_search', $data);
        $this->load->view('admin/index_after');
    }
}