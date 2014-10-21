<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Copyright 2012 - HMS
 * Created by Huynk on : 8/25/12 - 11:39 AM
 */

define('ROLE_SYSTEM', '1');
define('ROLE_CORP_MANAGER', '2');
define('ROLE_CORP_OFFICE', '3');
define('ROLE_SCHOOL_ENROLLMENT', '4');
define('ROLE_SCHOOL_OFFICE', '5');
define('ROLE_TEACHER', '6');
class Permission
{

    public function __construct($params = array())
    {
        $this->CI =& get_instance();

        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->model('role_model');
    }

    /**
     * User must be logged in
     */
    function requireLogin()
    {
        if ($this->CI->session->userdata('CURRENT_USER_ID') == "") {
            redirect(base_url('login'));
        }
    }

    /**
     * Check if a user id has roles or not
     * @param $requiredRoles
     * @return bool
     */
    function hasRoles($requiredRoles)
    {
        $currentUserId = $this->CI->session->userdata('CURRENT_USER_ID');
        $currentRoles = $this->CI->role_model->get_roles_by_user($currentUserId);

        if (count($currentRoles) == 1) {
            if (in_array($currentRoles[0]->rid, $requiredRoles)) {
                return true;
            }
        } else if (count($currentRoles) > 1) {
            foreach ($currentRoles as $userRole) {
                if (in_array($userRole->rid, $requiredRoles)) {
                    return true;
                }
            }
        }

//        redirect(base_url('admin/no_permission'));
        return false;
    }

    function canAccessAdminPanel()
    {
        $acceptedRoles = array(ROLE_SYSTEM, ROLE_CORP_MANAGER, ROLE_CORP_OFFICE, ROLE_SCHOOL_ENROLLMENT, ROLE_SCHOOL_OFFICE);
        if ($this->hasRoles($acceptedRoles)) {
            return true;
        }

        return false;
    }

    /**
     * Check if current logged in user has permission
     * @param $role as defined
     * @return bool i
     * obsolete
     */
    /*function hasPermission($role)
    {
        $currentUser = $this->CI->session->userdata('CURRENT_USER_ID');
        if ($currentUser != '' && $this->CI->role_model->hasPermission($currentUser, $role))
            return true;
        redirect(base_url('admin/no_permission'));
        return false;
    }*/
    /*
    function isSystemUser()
    {
        if ($this->hasPermission(ROLE_SYSTEM))
            return true;
        return false;
    }

    function isCorpManager()
    {
        if ($this->hasPermission(ROLE_CORP_MANAGER))
            return true;
        return false;
    }

    function isCorpOfficeStaff()
    {
        if ($this->hasPermission(ROLE_CORP_OFFICE))
            return true;
        return false;
    }

    function isSchoolEnrollment()
    {
        if ($this->hasPermission(ROLE_SCHOOL_ENROLLMENT))
            return true;
        return false;
    }

    function isSchoolOffice()
    {
        if ($this->hasPermission(ROLE_SCHOOL_OFFICE))
            return true;
        return false;
    }

    function isTeacher()
    {
        if ($this->hasPermission(ROLE_TEACHER))
            return true;
        return false;
    }*/
}
