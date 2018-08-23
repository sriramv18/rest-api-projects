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
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
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

// define login route name for token verification
defined('ROUTE_LOGIN')        OR define('ROUTE_LOGIN', 'login'); // no errors





//encript database table name
defined('LOGIN') OR define('LOGIN','T_Login');
defined('BRANCH') OR define('BRANCH','T_BranchMaster');
defined('STAFF') OR define('STAFF','T_StaffDetails');
defined('STAFF_BRANCH') OR define('STAFF_BRANCH','T_Staff_BranchAccess');
defined('UNIVERSITY') OR define('UNIVERSITY','T_UniversityMaster');
defined('COURSE') OR define('COURSE','T_CourseMaster');
defined('COURSE_FEES') OR define('COURSE_FEES','T_Course_Fees_Details');
defined('LEAD_DETAILS') OR define('LEAD_DETAILS','T_Lead_Details');
defined('LEAD_TRACKING') OR define('LEAD_TRACKING','T_Lead_Tracking');
defined('LEAD_TRACKING_FOLLOWUP') OR define('LEAD_TRACKING_FOLLOWUP','T_Lead_Tracking_Followup');
defined('PICK_LIST_DETAILS') OR define('PICK_LIST_DETAILS','T_PickListDetails');
defined('BATCH') OR define('BATCH','T_BatchMaster');
defined('STUDENTCOURSE') OR define('STUDENTCOURSE','T_Student_CourseDetails');
defined('STUDENTS') OR define('STUDENTS','T_StudentDetails');
defined('ANNOUNCEMENT') OR define('ANNOUNCEMENT','T_AnnouncementDetails');
defined('ACTIVITY') OR define('ACTIVITY','T_ActivityMaster');
defined('ACTIVITY_STATUS') OR define('ACTIVITY_STATUS','T_Activity_Status');
defined('ANSWER_BOOKLET') OR define('ANSWER_BOOKLET','T_AnswerBookletStatus');
defined('APPLICATION_STATUS') OR define('APPLICATION_STATUS','T_ApplicationStatus');
defined('CERTIFICATION_STATUS') OR define('CERTIFICATION_STATUS','T_CertificationStatus');
defined('STUDENTS_FEES_STATUS') OR define('STUDENTS_FEES_STATUS','T_Students_Fees_Status');
defined('STUDENTS_FEES_PAID') OR define('STUDENTS_FEES_PAID','T_Students_Fees_PaidDetails');
defined('STUDY_MATERIAL_STATUS') OR define('STUDY_MATERIAL_STATUS','T_StudyMaterialStatus');
defined('CERTIFICATION') OR define('CERTIFICATION','T_CertificationMaster');
defined('DEFAULTACTIVITY') OR define('DEFAULTACTIVITY','T_StatusMaster');
defined('CERTIFICATION_MASTER') OR define('CERTIFICATION_MASTER','T_CertificationMaster');
defined('DAYBOOKMASTER') OR define('DAYBOOKMASTER','T_DayBookMaster');
defined('INCOMEOUTCOMEMASTER') OR define('INCOMEOUTCOMEMASTER','T_Income_Outcome_Master');
defined('FEES_INSTALLMENT') OR define('FEES_INSTALLMENT','T_Fees_Installments');
defined('CENTER') OR define('CENTER','T_CenterMaster');
defined('SUBJECTMASTER') OR define('SUBJECTMASTER','T_SubjectMaster');
defined('SESSIONMASTER') OR define('SESSIONMASTER','T_Session_Master');
defined('SESSIONDETAILS') OR define('SESSIONDETAILS','T_SessionDetails');
defined('COURSESUBJECT') OR define('COURSESUBJECT','T_CourseSubject_Details');
defined('SESSIONSCHEDULE') OR define('SESSIONSCHEDULE','T_SessionSchedule_Master');
defined('SESSIONSCHEDULEDETAILS') OR define('SESSIONSCHEDULEDETAILS','T_SessionSchedule_Details');
defined('STUDENTDOCUMENTDETAILS') OR define('STUDENTDOCUMENTDETAILS','T_StudentDocumentsDetails');
defined('STUDENTDOCUMENTTRACKDETAILS') OR define('STUDENTDOCUMENTTRACKDETAILS','T_Student_DocumentTrack_Details');