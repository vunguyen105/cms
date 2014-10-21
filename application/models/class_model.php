<?php
/**
 * Copyright 2012 - CoverPhoto.us.
 * Created by Huynk on : 7/29/12 - 8:48 AM
 */
class Class_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    function add($objClass)
    {
        return $this->db->insert('classes', $objClass);
    }

    function get($cam_id = '')
    {
        if ($cam_id != '') {
            $this->db->where('cam_id', $cam_id);
        }

        $this->db->order_by('grade', 'asc');
        $this->db->order_by('class_name', 'asc');
        $query = $this->db->get('classes');
        return $query->result();
    }
	
	/*nguyen*/
	function get_class_by_grade($grade = '')
    { //echo $grade;die;
        if ($grade != '') {
		
            $this->db->where('grade', $grade);
        }
		$this->db->select('id');
        $this->db->order_by('grade', 'asc');
        $this->db->order_by('class_name', 'asc');
        $query = $this->db->get('classes');
        return $query->result_array();
    }
	
	function get_grade()
    {
		$this->db->select('grade');
		$this->db->distinct('grade');
        $query = $this->db->get('classes');
        return $query->result();
    }
	
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('classes');
        return $query->result();
    }

    /*
     * Get classes assigned to a specific staff
     */
    public function get_classes_by_staff($sid)
    {
        $this->db->select('classes.id,class_name');
        $this->db->join('staff', 're_class_teacher.sid=staff.id', 'left');
        $this->db->join('classes', 're_class_teacher.cid=classes.id', 'left');
        $this->db->where('sid', $sid);
        $this->db->order_by('class_name', 'asc');

        $query = $this->db->get('re_class_teacher');
        $data = $query->result();
        return $data;
    }
}
