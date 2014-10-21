<?php
/**
 * Copyright 2012 - CoverPhoto.us.
 * Created by Huynk on : 7/29/12 - 8:48 AM
 */
class Student_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function add($student)
    {
        return $this->db->insert('students', $student);
    }

    public function get_by_class($class_id = '')
    {
        $this->db->where('class_id', $class_id);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('students');
        return $query->result();
    }

	/*
	nguyen
	*/
	
	public function sum_class($class_id)
    {
		$this->db->select('count(id) as sum_student');
        $this->db->where_in('class_id', $class_id);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('students');
        return $query->result();
    }
	
    public function get_students($class_id = '', $name = '', $doe = '')
    {
        if ($name != '') {
            $this->db->like('students.name', $name);
        }
        if ($class_id != '') {
            $this->db->where('class_id', $class_id);
        }
        if ($doe != '') {
            $this->db->where('date_of_enrollment', $doe);
        }

        $this->db->select('students.id, students.name, students.gender,nationality,
        date_of_birth, date_of_enrollment,students.status,classes.name as class_name');
        $this->db->join('classes', 'classes.id = students.class_id');
        $this->db->order_by('classes.grade', 'asc');
        $this->db->order_by('class_name', 'asc');
        $this->db->order_by('students.name', 'asc');
        $query = $this->db->get('students');
        return $query->result();
    }

    public function search($keywords)
    {
        if (isset($keywords['gender']) && $keywords['gender'] != 2) {
            $this->db->where('gender', $keywords['gender']);
        }
        if (isset($keywords['status']) && $keywords['status'] != 2) {
            $this->db->where('students.status', $keywords['status']);
        }

        if ($keywords['name'] != '') {
            $this->db->like('students.name', $keywords['name']);
        }
        if ($keywords['class'] != '') {
            $this->db->where('classes.id', $keywords['class']);
        }
        if ($keywords['dob_from'] != '') {
            $this->db->where('dob >', $keywords['dob_from']);
        }
        if ($keywords['dob_to'] != '') {
            $this->db->where('dob <', $keywords['dob_to']);
        }
        if ($keywords['enroll_from'] != '') {
            $this->db->where('doe >', $keywords['enroll_from']);
        }
        if ($keywords['enroll_to'] != '') {
            $this->db->where('doe <', $keywords['enroll_to']);
        }
        /*if ($keywords['father'] != '') {
            $this->db->like('father_name', $keywords['father']);
        }
        if ($keywords['mother'] != '') {
            $this->db->like('mother_name', $keywords['mother']);
        }
        if ($keywords['street'] != '') {
            $this->db->like('street', $keywords['street']);
//            $this->db->like('home_number', $keywords['street']);
        }
        if ($keywords['district'] != '') {
            $this->db->like('district', $keywords['district']);
        }
        if ($keywords['phone'] != '') {
            $this->db->like('home', $keywords['phone']);
//            $this->db->like('mother_mobile', $keywords['phone']);
//            $this->db->like('father_mobile', $keywords['phone']);
//            $this->db->like('emergency', $keywords['phone']);
        }
        if ($keywords['email'] != '') {
            $this->db->like('mother_email', $keywords['email']);
//            $this->db->like('father_email', $keywords['email']);
        }*/

        /*        if (isset($keywords['bus_t1'])) {$this->db->where('bus_t1', $keywords['bus_t1']);}
  if (isset($keywords['bus_t2'])) {$this->db->where('bus_t2', $keywords['bus_t2']);}
  if (isset($keywords['bus_t3'])) {$this->db->where('bus_t3', $keywords['bus_t3']);}
  if (isset($keywords['bus_t4'])) {$this->db->where('bus_t4', $keywords['bus_t4']);}
  if ($keywords['bus_note'] != '') {$this->db->like('bus_note', $keywords['bus_note']);}

  if (isset($keywords['meal_t1'])) {$this->db->where('meal_t1', $keywords['meal_t1']);}
  if (isset($keywords['meal_t2'])) {$this->db->where('meal_t2', $keywords['meal_t2']);}
  if (isset($keywords['meal_t3'])) {$this->db->where('meal_t3', $keywords['meal_t3']);}
  if (isset($keywords['meal_t4'])) {$this->db->where('meal_t4', $keywords['meal_t4']);}
  if ($keywords['meal_note'] != '') {$this->db->like('meal_note', $keywords['meal_note']);}

  if (isset($keywords['insurance'])) {$this->db->where('insurance', $keywords['insurance']);}
  if ($keywords['insurance_reg_date'] != '') {$this->db->where('insurance_reg_date >', $keywords['insurance_reg_date']);}*/

        $this->db->select('students.id, students.name, students.gender,
        dob, doe,nation,students.status,classes.class_name as class_name,img');
        $this->db->join('classes', 'classes.id = students.class_id','left');
        $this->db->order_by('students.status', 'asc');
        $this->db->order_by('classes.grade', 'asc');
        $this->db->order_by('class_name', 'asc');
        $this->db->order_by('students.name', 'asc');
        $query = $this->db->get('students');

        return $query;
    }

    public function search_simple($keywords)
    {
        /* if (isset($keywords['gender']) && $keywords['gender'] != 2) {
            $this->db->where('gender', $keywords['gender']);
        }
        if (isset($keywords['status']) && $keywords['status'] != 2) {
            $this->db->where('status', $keywords['status']);
        }

        if ($keywords['name'] != '') {
            $this->db->like('students.name', $keywords['name']);
        }
        if ($keywords['class'] != '') {
            $this->db->where('classes.id', $keywords['class']);
        }
        if ($keywords['enroll_from'] != '') {
            $this->db->where('doe >', $keywords['enroll_from']);
        }
        if ($keywords['enroll_to'] != '') {
            $this->db->where('doe <', $keywords['enroll_to']);
        }*/

        $this->db->select('students.id, students.name, students.gender,
        dob, doe,nation,students.status,classes.class_name as class_name,img');
        $this->db->join('classes', 'classes.id = students.class_id');
        $this->db->order_by('students.status', 'asc');
        $this->db->order_by('classes.grade', 'asc');
        $this->db->order_by('class_name', 'asc');
        $this->db->order_by('students.name', 'asc');
        $query = $this->db->get('students');

        return $query->result();
    }

    public function get_by_id($stu_id)
    {
//        $field_list = 'students.id, students.name, class_id, gender,date_of_birth, date_of_enrollment,students.status';
//        $field_list .= ',nationality,emergency,home,remark,education_history';
//        $field_list .= ',home_number,street,district,relationship';
//        $field_list .= ',father_name,father_mobile,father_email,mother_name,mother_mobile,mother_email';
//        $field_list .= ',classes.name as class_name,medical_history,publicity,insurance,bus,meal';
//        $field_list .= '';
        $field_list = ' *,students.id,students.name,students.status,class_name ';
        $this->db->where('students.id', $stu_id);
        $this->db->select($field_list);
        $this->db->join('classes', 'classes.id = students.class_id','left');
        $this->db->order_by('students.name', 'asc');
        $query = $this->db->get('students');
        return $query->result();
    }

    public function update_info($objStudent)
    {
        $this->db->where('id', $objStudent['id']);
        return $this->db->update('students', $objStudent);
    }

    public function update_status($id, $new_status)
    {
        $this->db->where('id', $id);
        $this->db->set('status', $new_status);
        return $this->db->update('students');
    }

    public function get_students_with_attendance($class_id, $absent_date)
    {
        $query = "select students.id, name, absent_date, comment from students
        left join (select * from attendance where absent_date=?) as list_absent_today
        on students.id = list_absent_today.student_id
        where class_id = ? order by absent_date desc, name asc";
        $query = $this->db->query($query, array($absent_date, $class_id));
        return $query->result();
    }

    public function get_absent_list($class_id = '', $date_absent = '')
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

    public function query_absent_list_by_date($date_absent = '', $class_id = '')
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

    public function get_report_grade()
    {
        $query = "select grade, count(students.id) as total_students from students join classes on students.class_id = classes.id";
        $query .= " where students.status = 1 group by grade";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_chart_gender()
    {
        $query = "select gender, count(students.id) as total from students where status = 1 group by gender";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function save($id,$val)
    {
        $data = array(
               'grade' => $val
            );

        $this->db->where('id', $id);
        $this->db->update('students', $data); 
        return true;
    }
}
