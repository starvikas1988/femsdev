<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*
	Application Config 
*/

define('APP_TITLE', "MindWorkPlace");

//define('APP_TITLE', "Global Fusion Employee Management System");
//define('APP_TITLE', "STI Agent Tracking Tool");

define('EMPLOYEE_ID_CARD', "employee_id_card");
define('SIGNIN', "signin");
define('INFO_PERSONAL', "info_personal");
define('DEPARTMENT', "department");
define('ROLE', "role");
define('ROLE_ORGANIZATION', "role_organization");
define('OFFICE_LOCATION', "office_location");
define('MASTER_COMPANY', "master_company");
define('USER_RESIGN', "user_resign");
define('TERMINATE_USERS', "terminate_users");
define('TERMINATE_USERS_PRE', "terminate_users_pre");    
define('CLIENT', "client");    
define('PROCESS', "process");    

//<---------------------------PMS TABLES----------------------------->

define('PMS_GROUP', "pms_group");
define('PMS_SUB_GROUP', "pms_subgroup");
define('PMS_QUESTION', "pms_question");
define('PMS_DETAILS', "pms_details");
define('PMS_QUESTION_SET', "pms_question_set");
define('PMS_MANAGE_QUESTION', "pms_manage_question");
define('PMS_INDIVIDUAL_EMPLOYEE', "pms_individual_employee");
define('PMS_INDIVIDUAL_QUESTION_SET', "pms_individual_question_set");
define('PMS_INDIVIDUAL_DESCRIPTION', "pms_individual_description");
define('PMS_INDIVIDUAL_QUESTION', "pms_individual_question");
define('PMS_ANSWER_RATING', "pms_answer_rating"); 
define('PMS_REVIEWER_ANSWER_RATING', "pms_reviewer_answer_rating"); 
define('PMS_BRAND', "pms_brand"); 
define('PMS_LOCATION', "pms_location"); 
define('PMS_DEPARTMENT', "pms_department"); 
define('PMS_CONFIG', "pms_config"); 
define('PMS_CONFIGURATION_LOCATION_WISE', "pms_configuration_location_wise"); 
define('PMS_RATING', "pms_rating_master"); 
define('PMS_FLOW_CONFIG', "pms_flow_config"); 
define('PMS_DESIGNATION', "pms_designation"); 
define('PMS_USER_ID', "pms_user_id"); 
define('PMS_WEIGHTAGE', "pms_weightage");
define('PMS_CALCULATOR', "pms_calculator");
define('PMS_CALCULATOR_BREAKAGE', "pms_calculator_breakage");
define('PMS_FINANCIAL_YEAR', "pms_financial_year");
define('PMS_MANAGER_EMPLOYEE_REVIEWER_DETAILS', "pms_manager_employee_reviewer_details");
define('PMS_MANAGER_EMPLOYEE_TRAINING_DETAILS', "pms_manager_employee_training_details");
define('PMS_CLIENT_ID', "pms_client_id");
define('PMS_PROCESS_ID', "pms_process_id");
define('PMS_TRAINING_IDENTIFICATION_DETAILS', "pms_training_identification_details");
define('PMS_TRAINING_IDENTIFICATION_GROUP', "pms_training_identification_group");

