<?php
/**
 * Copyright 2012 - CoverPhoto.us.
 * Created by Huynk on : 7/29/12 - 8:48 AM
 */
class Campus_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    function add($objCampus)
    {
        return $this->db->insert('campuses', $objCampus);
    }

    function get()
    {
        $query = $this->db->get('campuses');
        return $query->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('campuses');
        return $query->result();
    }
}
