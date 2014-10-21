<?php  if ( ! defined('BASEPATH')) exit('No direct scripts access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('URL_ATTENDANCE_REPORT_BY_STUDENT', 'attendance/student-report/');
define('URL_ATTENDANCE_REPORT_CUSTOM_TIME', 'attendance/custom-report');
define('URL_ATTENDANCE_REPORT_STATS', 'attendance/attendance_stats');
define('URL_ATTENDANCE_REPORT_ABSENT_LIST', 'attendance/absent-list');
define('URL_ATTENDANCE_REPORT_DAILY', 'attendance/daily-report');
define('URL_ATTENDANCE_REPORT_DAILY_MOBILE', 'm/attendance_daily');
define('URL_ATTENDANCE_SUBMIT', 'attendance/submit');
define('URL_TEACHER_COMMENT', 'attendance/teacher_comments');


define('URL_USERGUIDE_HOME', 'user-guide');
define('URL_ADM_CMS', 'admin/cms/');
define('URL_FEEDBACK', 'feedback');

define('MSG_WARN_MUST_SELECT_FULL_ABSENT','Please select class attendance is: Full/ Absent!\nVui lòng chọn tình trạng: Đủ (Full)/ Vắng (Not full)');
define('MSG_WARN_MUST_SELECT_CLASS','Please select your class!\nVui lòng chọn lớp!');

define('STT_STAFF_ACTIVE','1');
define('STT_STAFF_QUITED','0');
define('STAFF_DEFAULT_PASSWORD','vanphuc');
define('DEADLINE_ATTENDANCE_SUBMIT','12:00:00');

/*
 *  Set current theme
 *  Values: "default" | "metro" | "autumn"
 */
define('CURRENT_THEME','default');
/* End of file constants.php */
/* Location: ./application/config/constants.php */