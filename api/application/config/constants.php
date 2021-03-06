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
//defined('ROUTE_LOGIN')        OR define('ROUTE_LOGIN', '(listAllTemplates/:any)'); // no errors
defined('ROUTE_LOGIN')        OR define('ROUTE_LOGIN', 'getAssessedIncome'); // no errors

/*********************AWS resources Constants*************************************************/
defined('PROFILE_PICTURE_BUCKET_NAME') OR define('PROFILE_PICTURE_BUCKET_NAME','sineedgedevprofilepic');
defined('LENDER_BUCKET_NAME_PREFIX') OR define('LENDER_BUCKET_NAME_PREFIX','lender');
/*********************END of AWS resources Constants*************************************************/

/*******************Constants PD status*********************************/
defined('TRIGGERED') OR define('TRIGGERED','TRIGGERED'); //First time PD Trigger.
defined('ALLOCATED') OR define('ALLOCATED','ALLOCATED'); //PD Allocated to PD officer
defined('ACCEPTED') OR define('ACCEPTED','ACCEPTED'); // PD Accepted PD officer after Allocation
defined('BOUNCED') OR define('BOUNCED','BOUNCED'); // PD Not accepted by PD Officer
defined('SCHEDULED') OR define('SCHEDULED','SCHEDULED'); //PD Scheduled by PD Officer
defined('INITIATED') OR define('INITIATED','INITIATED'); // PD Initiated or Ready to go a PD
defined('STARTED') OR define('STARTED','STARTED'); // PD started by PD officer
defined('INPROGRESS') OR define('INPROGRESS','INPROGRESS'); // PD inprogress 
defined('COMPLETED') OR define('COMPLETED','COMPLETED'); // PD Completed
defined('QC_INPROGRESS') OR define('QC_INPROGRESS','QC_INPROGRESS'); // QC_INPROGRESS
defined('QC_COMPLETED') OR define('QC_COMPLETED','QC_COMPLETED'); // QC_COMPLETED
defined('PD_REPORT_GENERATED') OR define('PD_REPORT_GENERATED','PD_REPORT_GENERATED'); //PD_REPORT_ACCEPTED by Lender
defined('PD_CHNAGE_REQUEST') OR define('PD_CHNAGE_REQUEST','PD_CHNAGE_REQUEST'); // From Lender side requesting change of PD report
defined('ALLOCATED_TO_PARTNER') OR define('ALLOCATED_TO_PARTNER','ALLOCATED_TO_PARTNER'); // PD Allocated to PD agency not for PD officer
defined('ARCHIVED') OR define('ARCHIVED','ARCHIVED');
defined('CANCELLED') OR define('CANCELLED','CANCELLED');
defined('DRAFT') OR define('DRAFT','DRAFT');


/*******************End Of Constants PD status**************************/


/*******************Define Constants for Table Names and Primarykeys**************************/
defined('PDTEAM_CTY_PRODUCT_CS_COMBINATIONS') OR define('PDTEAM_CTY_PRODUCT_CS_COMBINATIONS','PDTEAM_CTY_PRODUCT_CS_COMBINATIONS');

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

defined('ENTITY') OR define('ENTITY','m_entity');
defined('ENTITYID') OR define('ENTITYID','entity_id');

defined('ENTITYBILLING') OR define('ENTITYBILLING','m_entity_billing');
defined('ENTITYBILLINGID') OR define('ENTITYBILLINGID','entity_billing_id');

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
defined('QUESTIONCATEGORYID') OR define('QUESTIONCATEGORYID','question_category_id');

defined('TEMPLATE') OR define('TEMPLATE','m_template');
defined('TEMPLATEID') OR define('TEMPLATEID','template_id');

defined('LENDERTEMPLATE') OR define('LENDERTEMPLATE','m_template_lender_map');
defined('LENDERTEMPLATEID') OR define('LENDERTEMPLATEID','template_lender_map_id');

defined('TEMPLATECATEGORYWEIGHTAGE') OR define('TEMPLATECATEGORYWEIGHTAGE','m_template_category_weightage');
defined('TEMPLATECATEGORYWEIGHTAGEID') OR define('TEMPLATECATEGORYWEIGHTAGEID','template_category_weightage_id');

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

defined('PDTEAMCITY') OR define('PDTEAMCITY','m_pdteam_city');
defined('PDTEAMCITYID') OR define('PDTEAMCITYID','pdteam_city_id');

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

defined('ROLES') OR define('ROLES','m_roles');
defined('ROLESID') OR define('ROLESID','role_id');

defined('PDTEAMPRODUCT') OR define('PDTEAMPRODUCT','m_pdteam_product');
defined('PDTEAMPRODUCTID') OR define('PDTEAMPRODUCTID','pdteam_product_id');

defined('PDTEAMCUSTOMERSEGMENT') OR define('PDTEAMCUSTOMERSEGMENT','m_pdteam_customer_segment');
defined('PDTEAMCUSTOMERSEGMENTID') OR define('PDTEAMCUSTOMERSEGMENTID','pdteam_customer_segment_id');

defined('ENTITYREGION') OR define('ENTITYREGION','m_entity_region_mapping');
defined('ENTITYREGIONID') OR define('ENTITYREGIONID','entity_region_map_id');

defined('ENTITYSTATE') OR define('ENTITYSTATE','m_entity_state');
defined('ENTITYSTATEID') OR define('ENTITYSTATEID','entity_state_id');

defined('ENTITYCITY') OR define('ENTITYCITY','m_entity_city');
defined('ENTITYCITYID') OR define('ENTITYCITYID','entity_city_id');

defined('ENTITYBRANCH') OR define('ENTITYBRANCH','m_entity_branch');
defined('ENTITYBRANCHID') OR define('ENTITYBRANCHID','entity_branch_id');

defined('ENTITYBRANCH') OR define('ENTITYBRANCH','m_entity_branch');
defined('ENTITYBRANCHID') OR define('ENTITYBRANCHID','entity_branch_id');

defined('ENTITYBILLINGCONTACTINFO') OR define('ENTITYBILLINGCONTACTINFO','m_entity_billing_contact_info');
defined('ENTITYBILLINGCONTACTINFOID') OR define('ENTITYBILLINGCONTACTINFOID','entity_billing_contact_id');

defined('ENTITYTAT') OR define('ENTITYTAT','m_entity_tat');
defined('ENTITYTATID') OR define('ENTITYTATID','entity_tat_id');

defined('ENTITYPDPRICEINFO') OR define('ENTITYPDPRICEINFO','m_entity_pdprice_info');
defined('ENTITYPDPRICEINFOID') OR define('ENTITYPDPRICEINFOID','entity_pdprice_id');

defined('VENDORCITYMAP') OR define('VENDORCITYMAP','m_vendor_city_map');
defined('VENDORCITYMAPID') OR define('VENDORCITYMAPID','vendor_city_map_id');

defined('PDCATEGORYWEIGHTAGE') OR define('PDCATEGORYWEIGHTAGE','t_pd_category_weightage');
defined('PDCATEGORYWEIGHTAGEID') OR define('PDCATEGORYWEIGHTAGEID','pd_category_weightage_id');

defined('PDDETAIL') OR define('PDDETAIL','t_pd_details');
defined('PDDETAILID') OR define('PDDETAILID','pd_detail_id');

defined('PDANSWER') OR define('PDANSWER','t_pd_answers');
defined('PDANSWERID') OR define('PDANSWERID','pd_detail_answer_id');

defined('COMMONMASTER') OR define('COMMONMASTER','h_common_masters');
defined('COMMONMASTERID') OR define('COMMONMASTERID','log_id');

defined('QUESTIONGROUP') OR define('QUESTIONGROUP','m_question_group');
defined('QUESTIONGROUPID') OR define('QUESTIONGROUPID','question_group_id');

defined('TEMPLATEGROUP') OR define('TEMPLATEGROUP','m_template_group');
defined('TEMPLATEGROUPID') OR define('TEMPLATEGROUPID','template_group_id');

defined('PDFORMS') OR define('PDFORMS','m_pd_forms');
defined('PDFORMSID') OR define('PDFORMSID','form_id');

defined('PDFORMDETAILS') OR define('PDFORMDETAILS','t_pd_form_details');
defined('PDFORMDETAILSID') OR define('PDFORMDETAILSID','pd_form_detail_id');

defined('TEMPLATEFORMS') OR define('TEMPLATEFORMS','m_template_forms');
defined('TEMPLATEFORMSID') OR define('TEMPLATEFORMSID','template_form_id');


// These master are not available in front end.not able to add front end master
defined('EARNINGMEMBERSSTATUS') OR define('EARNINGMEMBERSSTATUS','m_earning_members_status');
defined('EARNINGMEMBERSSTATUSID') OR define('EARNINGMEMBERSSTATUSID','earning_member_status_id');

defined('EDUQUALIFICATION') OR define('EDUQUALIFICATION','m_edu_qualification');
defined('EDUQUALIFICATIONID') OR define('EDUQUALIFICATIONID','qualification_id');

defined('ADDRESSTYPE') OR define('ADDRESSTYPE','m_address_type');
defined('ADDRESSTYPEID') OR define('ADDRESSTYPEID','address_type_id');

defined('LOCALITY') OR define('LOCALITY','m_locality');
defined('LOCALITYID') OR define('LOCALITYID','locality_id');

defined('ASSETTYPE') OR define('ASSETTYPE','m_asset_type');
//defined('ASSETTYPEID') OR define('ASSETTYPEID','asset_type_id');

defined('PROPERTIES') OR define('PROPERTIES','m_properties');
//defined('PROPERTIESID') OR define('PROPERTIESID','property_id');

defined('INVESTMENTTYPE') OR define('INVESTMENTTYPE','m_investment_type');
//defined('INVESTMENTTYPEID') OR define('INVESTMENTTYPEID','investment_type_id');

defined('INSURANCETYPE') OR define('INSURANCETYPE','m_insurance_type');
//defined('INSURANCETYPEID') OR define('INSURANCETYPEID','insurance_type_id');

defined('PERSONSMET') OR define('PERSONSMET','m_persons_met');
//defined('PERSONSMETID') OR define('PERSONSMETID','person_met_id');

defined('RESIDENCEOWNERSHIP') OR define('RESIDENCEOWNERSHIP','m_residence_ownership');
//defined('PERSONSMETID') OR define('PERSONSMETID','id');

defined('PAYMENTMODE') OR define('PAYMENTMODE','m_payment_mode');
defined('ACCOUNTTYPE') OR define('ACCOUNTTYPE','m_account_type');
defined('SOURCEOFOTHERINCOME') OR define('SOURCEOFOTHERINCOME','m_source_of_other_income');
defined('MORTAGEPROPERTYTYPE') OR define('MORTAGEPROPERTYTYPE','m_mortage_property_type');
defined('ENDUSEOFLOAN') OR define('ENDUSEOFLOAN','m_enduse_of_loan');
defined('SOURCEOFBALANCETRANSFER') OR define('SOURCEOFBALANCETRANSFER','m_source_of_balance_transfer');
defined('STATUSOFCONSTRUCTION') OR define('STATUSOFCONSTRUCTION','m_status_of_construction');


// Assessed Income related Tables 
defined('SALESDECLAREDBYCUSTOMER') OR define('SALESDECLAREDBYCUSTOMER','t_pd_sales_declared_by_customer');
defined('SALESDECLAREDBYCUSTOMERID') OR define('SALESDECLAREDBYCUSTOMERID','sdc_id');

defined('SALESCALCULATEDBYITEMWISE') OR define('SALESCALCULATEDBYITEMWISE','t_pd_sales_calculated_by_itemwise');
defined('SALESCALCULATEDBYITEMWISEID') OR define('SALESCALCULATEDBYITEMWISEID','sci_id');

defined('SALESITEMMONTHWISE') OR define('SALESITEMMONTHWISE','t_pd_sales_item_monthwise');
defined('SALESITEMMONTHWISEID') OR define('SALESITEMMONTHWISEID','sim_id');

defined('SALESITEMMONTHWISECHILD') OR define('SALESITEMMONTHWISECHILD','t_pd_sales_item_monthwise_child');
defined('SALESITEMMONTHWISECHILDID') OR define('SALESITEMMONTHWISECHILDID','simc_id');

defined('PDPURCHASEDETAILS') OR define('PDPURCHASEDETAILS','t_pd_purchase_details');
defined('PDPURCHASEDETAILSID') OR define('PDPURCHASEDETAILSID','purchase_id');

defined('BUSINESSEXPENSES') OR define('BUSINESSEXPENSES','m_business_expenses');
defined('BUSINESSEXPENSESID') OR define('BUSINESSEXPENSESID','expense_id');

defined('PDBUSINESSEXPENSES') OR define('PDBUSINESSEXPENSES','t_pd_business_expenses');
defined('PDBUSINESSEXPENSESID') OR define('PDBUSINESSEXPENSESID','pd_expense_id');

defined('PDHOUSEHOLDEXPENSES') OR define('PDHOUSEHOLDEXPENSES','t_pd_household_expense');
defined('PDHOUSEHOLDEXPENSESID') OR define('PDHOUSEHOLDEXPENSESID','household_expense_id');

defined('QUESTIONKEYMAPPING') OR define('QUESTIONKEYMAPPING','m_question_key_mapping');
defined('QUESTIONKEYMAPPINGID') OR define('QUESTIONKEYMAPPINGID','question_key_mapping_id');

defined('SCORECARDANSWERS') OR define('SCORECARDANSWERS','m_scorecard_answers');
defined('SCORECARDANSWERSID') OR define('SCORECARDANSWERSID','score_answer_id');

defined('SCORECARDQUESTIONS') OR define('SCORECARDQUESTIONS','m_scorecard_questions');
defined('SCORECARDQUESTIONSID') OR define('SCORECARDQUESTIONSID','score_question_id');

defined('PDASSESSEDINCOMEESTIMATIONOFGROSSPROFITTYPE') OR define('PDASSESSEDINCOMEESTIMATIONOFGROSSPROFITTYPE','t_pd_assessed_income_estimation_of_gross_profit_type');
defined('PDASSESSEDINCOMEESTIMATIONOFGROSSPROFITTYPEID') OR define('PDASSESSEDINCOMEESTIMATIONOFGROSSPROFITTYPEID','calc_type_id');

defined('BTLENDERLIST') OR define('BTLENDERLIST','m_bt_lender_list');
defined('BTLENDERLISTID') OR define('BTLENDERLISTID','bt_lender_list_id');

defined('MORTAGEPROPERTIES') OR define('MORTAGEPROPERTIES','m_mortage_properties');
defined('MORTAGEPROPERTIESID') OR define('MORTAGEPROPERTIESID','mortage_property_id');

defined('BOUNCEMASTER') OR define('BOUNCEMASTER','m_bounce_reasaon');
defined('BOUNCEMASTERID') OR define('BOUNCEMASTERID','bounce_id');

defined('EXISTINGLOANTYPES') OR define('EXISTINGLOANTYPES','m_existing_loan_types');
defined('EXISTINGLOANTYPESID') OR define('EXISTINGLOANTYPESID','existing_loan_type_id');





