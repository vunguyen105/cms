<?php
/**
 * Copyright 2012 - CoverPhoto.us.
 * Created by Huynk on : 7/29/12 - 8:48 AM
 */
class Cms_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    function add($objContent)
    {
        return $this->db->insert('cms', $objContent);
    }

    function get($type, $id='')
    {
        $this->db->where('type', $type);

        if($id!=''){
            $this->db->where('id', $id);
        }
        $this->db->where('position >=', '0');
        $this->db->order_by('position', 'asc');
        $this->db->order_by('category', 'asc');
        $query = $this->db->get('cms');
        return $query->result();
    }
}
