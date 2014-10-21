<?php
/**
 * Copyright 2012 - CoverPhoto.us.
 * Created by Huynk on : 7/29/12 - 8:48 AM
 */
class Staff_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function add($staff)
    {
        return $this->db->insert('staff', $staff);
    }

    public function update($objStaff)
    {
        $this->db->where('id', $objStaff['id']);
        return $this->db->update('staff', $objStaff);
    }

    /*
     * Should not be used
     */
    public function delete_staff($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('staff');
    }

    public function get($id = '', $status = '')
    {
        if ($id != '') {
            $this->db->where('id', $id);
        }
        if ($status != '') {
            $this->db->where('status', $status);
        }

        $this->db->order_by('department', 'asc');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('staff');
        $data = $query->result();
        return $data;
    }

	/*
     * Find related info in database for login
     */
    function get_user_by_username($username)
    {
        $where_clause = "staff_code = '" . $username . "' OR email = '" . $username . "'";
        $this->db->where($where_clause);
        //$this->db->select('id, cam_id, staff_code, name, email, password');
        $query = $this->db->get('staff');
        return $query->result();
    }
	
    public function get_by_class_for_assign($class_id)
    {
        $sql_query = 'select STAFF.id, name, sid,note
            from STAFF 
			left join (select sid, note from re_class_teacher RCT where cid=?) as STAFF_BY_CLASS
            on STAFF.id = STAFF_BY_CLASS.sid 
			WHERE STAFF.status=1 AND staff.department like "%teacher%"
			order by sid desc, name asc
			';
        $query = $this->db->query($sql_query, array($class_id));
        return $query->result();
    }

    public function get_staff_by_class($cid)
    {
        $this->db->select('staff.name as staff_name, mobile, class_name');
        $this->db->join('staff', 're_class_teacher.sid=staff.id', 'left');
        $this->db->join('classes', 're_class_teacher.cid=classes.id', 'left');
        $this->db->where('cid', $cid);
        $this->db->where('staff.status', '1');
        $this->db->order_by('staff_name', 'asc');

        $query = $this->db->get('re_class_teacher');
        $data = $query->result();
        return $data;
    }

    // Not finished yet..
    public function get_staff_by_department($department = '')
    {
//        $this->db->order_by('name', 'asc');
        $department = trim($department);
        if ($department != '') {
            $this->db->where('department', $department);
        }

        $this->db->where('status', '1');
        $this->db->order_by('job_title', 'asc');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('staff');
        $data = $query->result();
        return $data;
    }

    // Not finished yet..
    public function get_departments()
    {
//        $this->db->order_by('name', 'asc');
        $this->db->select('department');
        $this->db->where('status', '1');
        $this->db->order_by('department', 'asc');
        $this->db->distinct('department');
        $query = $this->db->get('staff');
        $data = $query->result();
        return $data;
    }

}
