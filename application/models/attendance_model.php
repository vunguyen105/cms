<?php
/**
 * Copyright 2012 - CoverPhoto.us.
 * Created by Huynk on : 7/29/12 - 8:48 AM
 */
class Attendance_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library('Common');
        $this->load->library('Permission');
        $this->load->library('Excel_XML');
    }

    function update_class_daily_attendance($objClassAttendance)
    {
        $this->db->where('date', $objClassAttendance['date']);
        $this->db->where('class_id', $objClassAttendance['class_id']);
        $sql1 = $this->db->get('attendance_classes');
        $query1 = $sql1->result();
        $count = count($query1);

        // Update if existed. Otherwise, do Insert
        if ($count > 0) {
            // Update attendance daily
            $this->db->where('id', $query1[0]->id);
            $this->db->update('attendance_classes', $objClassAttendance);

            // Update Attendance Absent if it does relate
            // delete absent records of students in this class
            if ($objClassAttendance['has_absent'] == 0) {
                $query = "delete attendance_absent.* from attendance_absent
                          join students on attendance_absent.student_id=students.id";
                $query .= " where class_id=? and absent_date=?";
                return $this->db->query($query, array($objClassAttendance['class_id'], $objClassAttendance['date']));
            }

        } else {
            return $this->db->insert('attendance_classes', $objClassAttendance);
        }
    }

    function getClassesForDailyAttendance($date, $cam_id = '')
    {
        $sql = "select classes.id, classes.class_name, date, has_absent, updated_on,staff.id as staff_id, staff.name as updated_by
          from classes
          left join (select * from attendance_classes where date=?) as shit on shit.class_id = classes.id
          left join staff on staff.id = updated_by
          ";
        $param = array($date);

        if ($cam_id != '') {
            $sql .= " where cam_id = ?";
            $param[1] = $cam_id;
        }
        $sql .= " order by grade asc, class_name asc ";
        $query = $this->db->query($sql, $param);
        return $query->result();
    }

    /*
     * Get best staff of the day (staff who submitted first)
     */
    function getClassesForDailyAttendance_OrderBySubmitTime($date, $cam_id = '')
    {
        $date=trim($date);
        $sql = "select staff_id,img,class_name, updated_by, updated_on from (select classes.class_name,updated_on,staff.id as staff_id,staff.img, staff.name as updated_by
          from classes
          left join (select * from attendance_classes where date=?) as shit on shit.class_id = classes.id
          left join staff on staff.id = updated_by
          ";
        $param = array($date);

        if ($cam_id != '') {
            $sql .= " where cam_id = ?";
            $param[1] = $cam_id;
        }
//        $sql .= " where updated_on >= '" . $date." 8:30:00' and updated_on <'".$date." 9:30:00'";
        $sql .= " where updated_on >= '" . $date." 8:30:00' ";
        $sql .= " order by updated_on asc) as tbl group by staff_id order by updated_on limit 3";
        $query = $this->db->query($sql, $param);
//        echo $this->db->last_query();
        return $query->result();
    }

    /*
     * Get WORST staff of the day (staff who submitted late)
     */
    function get_staff_of_last_submitted_classes($date, $cam_id = '')
    {
        $date=trim($date);
        $sql = "select classes.class_name,shit.updated_on,staff.id as staff_id,staff.img, staff.name as updated_by
          from classes
          left join (select * from attendance_classes where date=?) as shit on shit.class_id = classes.id
	      left join re_class_teacher on re_class_teacher.cid = shit.class_id
	      left join staff on staff.id = re_class_teacher.sid ";

        $param = array($date);

        if ($cam_id != '') {
            $sql .= " where cam_id = ?";
            $param[1] = $cam_id;
        }

        $sql .= " where shit.updated_on > '" . $date.' 11:00:00\'';
        $sql .= " group by staff_id order by shit.updated_on desc limit 8  ";
        $query = $this->db->query($sql, $param);
//                echo $this->db->last_query();

        return $query->result();
    }

    /*
     * Get list of staff who are most often the earliest attendance reporter of the week
     */
    function get_best_of_the_week($date, $cam_id = '')
    {
        $from_date = '';
        $to_date = '';
        $total_date = '';
        for ($iDate = 0; $iDate < $total_date; $iDate++) {
            $best_staff_of_date = 'get best staff (date[$iDate])';

            $list_best_in_month[$iDate]['staff'] = $best_staff_of_date;
        }
    }

    /**
     * Get list of students with attendance status
     * Used for attendance submit form
     */
    function get_student_list_with_attendance($class_id, $absent_date)
    {
        $query = "select students.id, name, absent_date, comment from students
        left join (select * from attendance_absent where absent_date=?) as list_absent_today
        on students.id = list_absent_today.student_id
        where class_id = ? and students.status=1 order by absent_date desc, name asc";
        $query = $this->db->query($query, array($absent_date, $class_id));
        return $query->result();
    }

    /**
     * Get absent list for Daily Report
     */
    function get_absent_list($class_id = '', $date_absent = '')
    {
        $query = "  select students.id, students.name, absent_date, comment, updated_by,updated_on,class_name
                    from students join
                    (select attendance_absent.student_id, staff.name as updated_by,updated_on,absent_date,comment
                      from attendance_absent
                      join staff on attendance_absent.updated_by=staff.id";

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

	/*
	ngay 26/9/14
	nguyen
	*/
	 function get_term_report_stats($params)
    {
		if (count($params) <= 1) return;
		if ($params['from'] == '') {
            $params['from'] = '2012-08-20';
        }
        if ($params['to'] == '') {
            $params['to'] = date('Y-m-d');
        }
		$this->db->select(" students.id as sid, classes.class_name, count(attendance_absent.student_id) as count_absent_dates");
		//$this->db->from("students");		
		//$this->db->select_sum('age');
		$this->db->join("attendance_absent", "attendance_absent.student_id = students.id");
		$this->db->join("classes", "classes.id = students.class_id","left");
		//$this->db->join("attendance_classes", "attendance_classes.class_id = classes.id ","left");
		$this->db->where("absent_date >=",$params['from']);
		$this->db->where("absent_date <=",$params['to']);
		//$this->db->where("classes.id",$params['class']);
		$this->db->where("classes.grade",$params['class']);
		$this->db->group_by("sid");
		//$this->db->order_by("classes.grade",'asc');
		//$this->db->order_by("classes.class_name",'asc');
		//$this->db->order_by("students.name",'asc');
		
		$query = $this->db->get("students");
        return $query->result_array();	
		
		
    }		
    function get_term_report($params)
    {	//var_dump($params);die;
        if (count($params) <= 1) return;
        if ($params['from'] == '') {
            $params['from'] = '2012-08-20';
        }
        if ($params['to'] == '') {
            $params['to'] = date('Y-m-d');
        }

        $sql_query = "SELECT students.id as sid, students.name, classes.class_name, count(attendance_absent.student_id) as count_absent_dates";
        $sql_query .= " FROM students";
        $sql_query .= " LEFT JOIN attendance_absent ON students.id=attendance_absent.student_id AND (absent_date>=?) AND (absent_date<=?)";
        $sql_query .= " LEFT JOIN classes ON students.class_id=classes.id";
        $sql_query .= " WHERE students.status=1";

        if ($params['class'] != '') {
            $sql_query .= " AND classes.id=" . $params['class'];
        }

        $sql_query .= " GROUP BY sid";
        $sql_query .= " ORDER BY classes.grade asc, class_name asc, students.name asc";
        $sql_query = $this->db->query($sql_query, array($params['from'], $params['to']));
        return $sql_query;
    }
    
    function get_term_report_export($params){ 
    	if (count($params) <= 1) return;
    	if ($params['from'] == '') {
    		$params['from'] = '2012-08-20';
    	}
    	if ($params['to'] == '') {
    		$params['to'] = date('Y-m-d');
    	}
    	
    	$sql_query = "SELECT students.id as sid, students.name, classes.class_name, classes.id AS cid, b.absent_date";
        $sql_query .= " FROM students";
        $sql_query .= " LEFT JOIN classes ON students.class_id=classes.id";
        $sql_query .= " LEFT JOIN (SELECT a.student_id, a.absent_date FROM attendance_absent AS a WHERE (absent_date>=?) AND (absent_date<=?)) AS b ON b.student_id = students.id";
        $sql_query .= " WHERE students.status=1";
    	
    	if ($params['class'] != '') {
    		$sql_query .= " AND classes.id=" . $params['class'];
    	}
    	
    	$sql_query .= " ORDER BY classes.grade asc, classes.id asc, students.name asc, b.absent_date";
    	$sql_query = $this->db->query($sql_query, array($params['from'], $params['to']));
    	return $sql_query;
    }

    function get_monthly_report_nice($params)
    {
        if (count($params) <= 1) {
            echo 'Error in model; Quited.';
            return;
        }
        ;

//        if ($params['month'] == '') {
//            $params['month'] = date('m');
//        }

        $sql_query = "SELECT students.id as sid, students.name, classes.class_name, MONTH(absent_date) as absent_month, DAYOFMONTH(absent_date) as absent_day
                        FROM students
                        LEFT JOIN attendance_absent ON students.id=attendance_absent.student_id
                        LEFT JOIN classes ON students.class_id=classes.id
                        WHERE students.status=1 AND MONTH(absent_date)=?";

        if ($params['class'] != '') {
            $sql_query .= " AND classes.id=" . $params['class'];
        }

        $sql_query = $this->db->query($sql_query, array($params['month']));
        return $sql_query;
    }

    function get_term_detailed_report($params)
    {
        if (count($params) <= 1) return;
        if ($params['from'] == '') {
            $params['from'] = '2012-08-20';
        }
        if ($params['to'] == '') {
            $params['to'] = date('Y-m-d');
        }

        $sql_query = "SELECT students.id as sid, students.name, classes.name as class_name, absent_date";
        $sql_query .= " FROM attendance";
        $sql_query .= " LEFT JOIN students ON students.id=attendance.student_id AND (absent_date>=?) AND (absent_date<=?)";
        $sql_query .= " LEFT JOIN classes ON students.class_id=classes.id";

        if ($params['class'] != '') {
            $sql_query .= " WHERE classes.id=" . $params['class'];
        }

//        $sql_query .= " GROUP BY attendance.id";
        $sql_query .= " ORDER BY sid";
        $sql_query = $this->db->query($sql_query, array($params['from'], $params['to']));
        return $sql_query;
    }

    function get_student_report($student_id)
    {
        $sql_query = "SELECT students.id as sid, students.name, class_name, absent_date, comment";
        $sql_query .= " FROM attendance_absent";
        $sql_query .= " LEFT JOIN students ON students.id=attendance_absent.student_id";
        $sql_query .= " LEFT JOIN classes ON students.class_id=classes.id";
        $sql_query .= " WHERE students.id=?";
        $sql_query .= " ORDER BY sid";
        $sql_query = $this->db->query($sql_query, array($student_id));
        return $sql_query;
    }
	
	function get_unsubmitted_classes($checkdate)
    {
		$sql_query = "SELECT * 
			FROM (SELECT id,class_name FROM classes WHERE id NOT IN (SELECT class_id FROM `attendance_classes` WHERE `date`=?)) AS fail_classes";
		$sql_query = $this->db->query($sql_query, array($checkdate));
        return $sql_query;
	}
}
