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
defined('ROUTE_LOGIN2')        OR define('ROUTE_LOGIN2', 'login2'); // no errors
defined('ROUTE_LOGIN3')        OR define('ROUTE_LOGIN3', 'login3'); // no errors

//AWS resources Constants
defined('PROFILEPICTUREBUCKETNAME') OR define('PROFILEPICTUREBUCKETNAME','sineedgedevprofilepic');



//Define Constants for Table Names and Primarykeys
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

defined('REGIONS') OR define('REGIONS','m_regions');
defined('REGIONSID') OR define('REGIONSID','region_id');

defined('STATE') OR define('STATE','m_states');
defined('STATEID') OR define('STATEID','state_id');

defined('CITY') OR define('CITY','m_city');
defined('CITYID') OR define('CITYID','city_id');

defined('BRANCH') OR define('BRANCH','m_branch');
defined('BRANCHID') OR define('BRANCHID','branch_id');

defined('PDLOCATIONAPPROACH') OR define('PDLOCATIONAPPROACH','m_pd_location_approach');
defined('PDLOCATIONAPPROACHID') OR define('PDLOCATIONAPPROACHID','pd_location_approach_id');

defined('LISTOFMASTERS') OR define('LISTOFMASTERS','m_list_of_masters');
defined('LISTOFMASTERSID') OR define('LISTOFMASTERSID','master_id');

defined('COMMENTSONLOCALITY') OR define('COMMENTSONLOCALITY','m_comments_on_locality');
defined('COMMENTSONLOCALITYID') OR define('COMMENTSONLOCALITYID','comments_on_locality_id');

defined('ENTITYTYPE') OR define('ENTITYTYPE','m_entity_type');
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

defined('LENDER') OR define('LENDER','m_lender');
defined('LENDERID') OR define('LENDERID','lender_id');


