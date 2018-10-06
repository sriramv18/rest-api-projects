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
//defined('ROUTE_LOGIN')        OR define('ROUTE_LOGIN', '(listLessPDDetails/:any)'); // no errors
defined('ROUTE_LOGIN')        OR define('ROUTE_LOGIN', 'getListPDOfficers'); // no errors

/*********************AWS resources Constants*************************************************/
defined('PROFILE_PICTURE_BUCKET_NAME') OR define('PROFILE_PICTURE_BUCKET_NAME','sineedgedevprofilepic');
defined('LENDER_BUCKET_NAME_PREFIX') OR define('LENDER_BUCKET_NAME_PREFIX','lender');
/*********************END of AWS resources Constants*************************************************/

/*******************Constants PD status*********************************/
defined('TRIGGERED') OR define('TRIGGERED','1'); //First time PD Trigger.
defined('ALLOCATED') OR define('ALLOCATED','2'); //PD Allocated to PD officer
defined('ACCEPTED') OR define('ACCEPTED','3'); // PD Accepted PD officer after Allocation
defined('BOUNCED') OR define('BOUNCED','4'); // PD Not accepted by PD Officer
defined('SCHEDULED') OR define('SCHEDULED','5'); //PD Scheduled by PD Officer
defined('INITIATED') OR define('INITIATED','6'); // PD Initiated or Ready to go a PD
defined('STARTED') OR define('STARTED','7'); // PD started by PD officer
defined('INPROGRESS') OR define('INPROGRESS','8'); // PD inprogress 
defined('COMPLETED') OR define('COMPLETED','9'); // PD Completed
defined('QC_INPROGRESS') OR define('QC_INPROGRESS','10'); // QC_INPROGRESS
defined('QC_COMPLETED') OR define('QC_COMPLETED','11'); // QC_COMPLETED
defined('PD_REPORT_ACCEPTED') OR define('PD_REPORT_ACCEPTED','12'); //PD_REPORT_ACCEPTED by Lender
defined('PD_CHNAGE_REQUEST') OR define('PD_CHNAGE_REQUEST','13'); // From Lender side requesting change of PD report
defined('ALLOCATED_TO_PARTNER') OR define('ALLOCATED_TO_PARTNER','14'); // PD Allocated to PD agency not for PD officer
defined('ARCHIVED') OR define('ARCHIVED','15');
defined('CANCELLED') OR define('CANCELLED','16');
defined('RESCHEDULED') OR define('RESCHEDULED','17');
defined('PLANNEDSCHEDULED') OR define('PLANNEDSCHEDULED','18');

/*******************End Of Constants PD status**************************/


/*******************Define Constants for Table Names and Primarykeys**************************/

defined('INDUSTRYCLASSIFICATION') OR define('INDUSTRYCLASSIFICATION','m_industry_classification');
defined('INDUSTRYCLASSIFICATIONID') OR define('INDUSTRYCLASSIFICATIONID','industry_classification_id');

defined('PRODUCTS') OR define('PRODUCTS','m_products');
defined('PRODUCTSID') OR define('PRODUCTSID','product_id');

defined('UOM') OR define('UOM','m_uom');
defined('UOMID') OR define('UOMID','uom_id');

defined('SUBPRODUCTS') OR define('SUBPRODUCTS','m_subproducts');
defined('SUBPRODUCTSID') OR define('SUBPRODUCTSID','subproduct_id');

defined('OCCUPATIONMEMBERS') OR define('OCCUPATIONMEMBERS','m_occupation_non_earning_members');
defined('OCCUPATIONMEMBERSID') OR define('OCCUPATIONMEMBERSID','occupation_non_earning_member_id');

defined('TYPEOFACTIVITY') OR define('TYPEOFACTIVITY','m_type_of_activity');
defined('TYPEOFACTIVITYID') OR define('TYPEOFACTIVITYID','type_of_activity_id');

defined('TITLES') OR define('TITLES','m_titles');
defined('TITLESID') OR define('TITLESID','title_id');

defined('RELATIONSHIPS') OR define('RELATIONSHIPS','m_relationships');
defined('RELATIONSHIPSID') OR define('RELATIONSHIPSID','relationship_id');

defined('FREQUENCY') OR define('FREQUENCY','m_frequency');
defined('FREQUENCYID') OR define('FREQUENCYID','frequency_id');

defined('CUSTOMERBEHAVIOUR') OR define('CUSTOMERBEHAVIOUR','m_customer_behaviour');
defined('CUSTOMERBEHAVIOURID') OR define('CUSTOMERBEHAVIOURID','customer_behaviour_id');

defined('CUSTOMERSEGMENT') OR define('CUSTOMERSEGMENT','m_customer_segment');
defined('CUSTOMERSEGMENTID') OR define('CUSTOMERSEGMENTID','customer_segment_id');


defined('REGIONS') OR define('REGIONS','m_regions');
defined('REGIONSID') OR define('REGIONSID','region_id');

defined('STATE') OR define('STATE','m_states');
defined('STATEID') OR define('STATEID','state_id');

defined('CITY') OR define('CITY','m_city');
defined('CITYID') OR define('CITYID','city_id');

defined('BRANCH') OR define('BRANCH','m_branch');
defined('BRANCHID') OR define('BRANCHID','branch_id');

defined('PDALLOCATIONTYPE') OR define('PDALLOCATIONTYPE','c_pd_allocation_type');
defined('PDALLOCATIONTYPEID') OR define('PDALLOCATIONTYPEID','pd_allocation_type_id');

defined('PDLOCATIONAPPROACH') OR define('PDLOCATIONAPPROACH','m_pd_location_approach');
defined('PDLOCATIONAPPROACHID') OR define('PDLOCATIONAPPROACHID','pd_location_approach_id');

defined('PDSTATUS') OR define('PDSTATUS','c_pd_status'); 
defined('PDSTATUSID') OR define('PDSTATUSID','pd_status_id');

defined('PDTYPE') OR define('PDTYPE','m_pd_type');
defined('PDTYPEID') OR define('PDTYPEID','pd_type_id');

defined('LISTOFMASTERS') OR define('LISTOFMASTERS','c_list_of_masters');
defined('LISTOFMASTERSID') OR define('LISTOFMASTERSID','master_id');

defined('COMMENTSONLOCALITY') OR define('COMMENTSONLOCALITY','m_comments_on_locality');
defined('COMMENTSONLOCALITYID') OR define('COMMENTSONLOCALITYID','comments_on_locality_id');

defined('ENTITYTYPE') OR define('ENTITYTYPE','c_entity_type');
defined('ENTITYTYPEID') OR define('ENTITYTYPEID','entity_type_id');

defined('COMPANY') OR define('COMPANY','m_company');
defined('COMPANYID') OR define('COMPANYID','company_id');

defined('DESIGNATION') OR define('DESIGNATION','m_designation');
defined('DESIGNATIONID') OR define('DESIGNATIONID','designation_id');

defined('LENDERHIERARCHY') OR define('LENDERHIERARCHY','m_lender_hierarchy');
defined('LENDERHIERARCHYID') OR define('LENDERHIERARCHYID','lender_hierarchy_id');

defined('USERPROFILE') OR define('USERPROFILE','m_user_profile');
defined('USERPROFILEID') OR define('USERPROFILEID','userid');

defined('ENTITY') OR define('ENTITY','m_entities');
defined('ENTITYID') OR define('ENTITYID','entity_id');

defined('ENTITYCHILD') OR define('ENTITYCHILD','m_entity_child');
defined('ENTITYCHILDID') OR define('ENTITYCHILDID','entity_child_id');

defined('USERPROFILEHIERARCHY') OR define('USERPROFILEHIERARCHY','m_user_lender_hierarchy');
defined('USERPROFILEHIERARCHYID') OR define('USERPROFILEHIERARCHYID','user_lender_hierarchy_id');

defined('USERPROFILEROLES') OR define('USERPROFILEROLES','m_user_roles');
defined('USERPROFILEROLESID') OR define('USERPROFILEROLESID','user_role_id');

defined('QUESTIONS') OR define('QUESTIONS','m_questions');
defined('QUESTIONSID') OR define('QUESTIONSID','question_id');

defined('QUESTIONANSWERTYPE') OR define('QUESTIONANSWERTYPE','m_question_answer_type');
defined('QUESTIONANSWERTYPEID') OR define('QUESTIONANSWERTYPEID','question_answer_type_id');

defined('QUESTIONANSWERS') OR define('QUESTIONANSWERS','m_question_answers');
defined('QUESTIONANSWERSID') OR define('QUESTIONANSWERSID','question_answer_id');

defined('QUESTIONCATEGORY') OR define('QUESTIONCATEGORY','m_question_category');
defined('QUESTIONCATEGORYID') OR define('QUESTIONCATEGORYID','question_categroy_id');

defined('TEMPLATE') OR define('TEMPLATE','m_template');
defined('TEMPLATEID') OR define('TEMPLATEID','template_id');

defined('LENDERTEMPLATE') OR define('LENDERTEMPLATE','m_template_lender_map');
defined('LENDERTEMPLATEID') OR define('LENDERTEMPLATEID','template_lender_map_id');

defined('TEMPLATECATAGORYWEIGHTAGE') OR define('TEMPLATECATAGORYWEIGHTAGE','m_template_catagory_weightage');
defined('TEMPLATECATAGORYWEIGHTAGEID') OR define('TEMPLATECATAGORYWEIGHTAGEID','template_catagory_weightage_id');

defined('TEMPLATEQUESTION') OR define('TEMPLATEQUESTION','m_template_question');
defined('TEMPLATEQUESTIONID') OR define('TEMPLATEQUESTIONID','template_question_id');

defined('TEMPLATEANSWERWEIGHTAGE') OR define('TEMPLATEANSWERWEIGHTAGE','m_template_answer_weightage');
defined('TEMPLATEANSWERWEIGHTAGEID') OR define('TEMPLATEANSWERWEIGHTAGEID','template_answer_weightage_id');

defined('PDTRIGGER') OR define('PDTRIGGER','t_pd_triggered');
defined('PDTRIGGERID') OR define('PDTRIGGERID','pd_id');

defined('PDAPPLICANTSDETAILS') OR define('PDAPPLICANTSDETAILS','t_pd_co_applicants_details');
defined('PDAPPLICANTSDETAILSID') OR define('PDAPPLICANTSDETAILSID','pd_co_applicant_id');

defined('PDSTATUS') OR define('PDSTATUS','c_pd_status');
defined('PDSTATUSID') OR define('PDSTATUSID','pd_status_id');

defined('PDTEAM') OR define('PDTEAM','m_pdteam');
defined('PDTEAMID') OR define('PDTEAMID','pdteam_id');

defined('PDTEAMMAP') OR define('PDTEAMMAP','m_pdteam_map');
defined('PDTEAMMAPID') OR define('PDTEAMMAPID','pdteam_map_id');

defined('PDOFFICIERSDETAILS') OR define('PDOFFICIERSDETAILS','m_pd_officiers_details');
defined('PDOFFICIERSDETAILSID') OR define('PDOFFICIERSDETAILSID','pd_officier_id');

defined('PDNOTIFICATION') OR define('PDNOTIFICATION','m_pdnotification');
defined('PDNOTIFICATIONID') OR define('PDNOTIFICATIONID','pdnotification_id');

defined('PDDOCUMENTS') OR define('PDDOCUMENTS','t_pd_documents');
defined('PDDOCUMENTSID') OR define('PDDOCUMENTSID','pd_document_id');

defined('PDLOGS') OR define('PDLOGS','h_pd_triggered');
defined('PDLOGSID') OR define('PDLOGSID','pd_trigger_id');

defined('PDAPPLICANTSLOGS') OR define('PDAPPLICANTSLOGS','h_pd_co_applicants_details');
defined('PDAPPLICANTSLOGSID') OR define('PDAPPLICANTSLOGSID','pd_co_applicant_trigger_id');

defined('PDSCHEDULE') OR define('PDSCHEDULE','t_pd_schedule');
defined('PDSCHEDULEID') OR define('PDSCHEDULEID','pd_schedule_id');



