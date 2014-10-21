<?php
/**
 * Copyright 2012 - CoverPhoto.us.
 * Created by Huynk on : 7/29/12 - 8:48 AM
 */
class Role_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    function add($objRole)
    {
        return $this->db->insert('campuses', $objRole);
    }

    function get_roles()
    {
        $query = $this->db->get('roles');
        return $query->result();
    }

    public function get_user_by_role($rid)
    {
        $this->db->where('rid', $rid);
        $query = $this->db->get('re_user_role');
        return $query->result();
    }

    public function get_roles_by_user($uid)
    {
        $this->db->where('uid', $uid);
        $query = $this->db->get('re_user_role');
        return $query->result();
    }

    /**
     * Return 1 if user has permission with that role
     */
    public function hasPermission($uid, $rid)
    {
        $this->db->where('uid', $uid);
        $this->db->where('rid', $rid);
        $query = $this->db->get('re_user_role');
        $data = $query->result();
        return count($data);
    }
}
