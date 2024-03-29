<?php  if ( ! defined('BASEPATH')) exit('No direct scripts access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['login'] = "home/login";
$route['logout'] = "home/logout";
$route['feedback'] = "home/feedback";
$route[URL_USERGUIDE_HOME] = "home/userguide";
$route[URL_USERGUIDE_HOME.'/(:num)'] = "home/userguide/$1";
$route['change-password'] = "home/change_password";
$route['attendance/absent-list'] = "attendance/report_absent";
$route['attendance/daily-report'] = "attendance/report_daily";
$route['attendance/custom-report'] = "attendance/report_custom_time";
$route['attendance/custom-report-export'] = "attendance/report_custom_time_export";
$route[URL_ATTENDANCE_REPORT_BY_STUDENT.'(:num)'] = "attendance/report_by_student/$1";
$route['author'] = "home/author";
$route['gallery'] = "home/gallery";
$route['staff/(:num)'] = "staff/details/$1";

$route['default_controller'] = "home";
$route['404_override'] = 'home';


/* End of file routes.php */
/* Location: ./application/config/routes.php */