<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['autenticadors'] = 'autenticador/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
| -------------------------------------------------------------------------
| SineEdge REST API Routes
| -------------------------------------------------------------------------
*/
/* Routes regards Common Masters CRUD operations*/

$route['getListOfSubProduct'] = 'Common_Masters_Controller/getListOfSubProduct'; 
$route['getListOfBranches'] = 'Common_Masters_Controller/getListOfBranches'; 
$route['getListOfCompany'] = 'Common_Masters_Controller/getListOfCompany'; 
$route['getListOfState'] = 'Common_Masters_Controller/getListOfState'; 
$route['getListOfCity'] = 'Common_Masters_Controller/getListOfCity'; 
$route['getPDNotificationsList'] = 'Common_Masters_Controller/getPDNotificationsList';
$route['getListOfPDTeam'] = 'Common_Masters_Controller/getListOfPDTeam';
$route['getPdManage'] = 'Common_Masters_Controller/getPdManage';
$route['savePdTeamManage'] = 'Common_Masters_Controller/savePdTeamManage';
$route['getListOfPDTeamCityMapping'] =  'Common_Masters_Controller/getListOfPDTeamCityMapping';
//$route['getListOfPDTeamMap'] = 'Common_Masters_Controller/getListOfPDTeamMap';
$route['getListOfMaster'] = 'Common_Masters_Controller/getListOfMaster'; 
$route['saveMaster'] = 'Common_Masters_Controller/saveMaster';
$route['saveBranch'] = 'Common_Masters_Controller/saveBranch'; 
$route['savePDAllocationType'] = 'Common_Masters_Controller/savePDAllocationType';
$route['savePDNotification'] = 'Common_Masters_Controller/savePDNotification';
$route['saveCompany'] = 'Common_Masters_Controller/saveCompany'; 
$route['savePDTeam'] = 'Common_Masters_Controller/savePdTeam';
$route['deletePdTeamMapping'] = 'Common_Masters_Controller/deletePdTeamMapping';
$route['getLender'] = 'Common_Masters_Controller/getLender';
$route['getProduct'] = 'Common_Masters_Controller/getProduct';
$route['getCustomerSegment'] = 'Common_Masters_Controller/getCustomerSegment';





//USER MANAGEMENT
$route['getListOfUsers'] = 'User_Management_Controller/listAllUsers'; 
$route['saveNewUser'] = 'User_Management_Controller/saveNewUser'; 
$route['updateExistUser'] = 'User_Management_Controller/updateExistUser'; 
$route['getUsersDetails'] = 'User_Management_Controller/getUsersDetails'; 
$route['getSingedProfilePicURL'] = 'User_Management_Controller/getSingedProfilePicURL'; 
$route['checkpin'] = 'User_Management_Controller/checkpin'; 

// TEMPLATE MANAGEMENT
$route['(listAllTemplates/:any)'] = 'Template_Management_Controller/listAllTemplates/'; 
$route['saveNewTemplateName'] = 'Template_Management_Controller/saveNewTemplateName'; 
$route['saveTemplateLenderDetails'] = 'Template_Management_Controller/saveTemplateLenderDetails'; 
$route['saveTemplateCategoryDetails'] = 'Template_Management_Controller/saveTemplateCategoryDetails'; 
$route['saveTemplateQuestionAnswers'] = 'Template_Management_Controller/saveTemplateQuestionAnswers'; 
$route['getTemplateMaster'] = 'Template_Management_Controller/getTemplateMaster'; 
$route['getTemplateLenders'] = 'Template_Management_Controller/getTemplateLenders'; 
$route['getTemplateCategories'] = 'Template_Management_Controller/getTemplateCategories'; 
$route['getTemplateQuestionAnswers'] = 'Template_Management_Controller/getTemplateQuestionAnswers'; 
$route['getListOfCategories'] = 'Template_Management_Controller/getListOfCategories'; 
$route['getQuestionsForTemplateCreation'] = 'Template_Management_Controller/getQuestionsForTemplateCreation'; 

//QUESTION MANAGEMENT
$route['(listAllQuestions/:any)'] = 'Question_Management_Controller/listAllQuestions/'; 
$route['saveNewQuestion'] = 'Question_Management_Controller/saveNewQuestion'; 
$route['saveExistQuestion'] = 'Question_Management_Controller/saveExistQuestion'; 
$route['updateAnswerStatus'] = 'Question_Management_Controller/updateAnswerStatus'; 

//ENTITY MANAGEMENT
$route['(listAllEntites/:any)'] = 'Entity_Management_Controller/listAllEntites/'; 
$route['saveNewEntity'] = 'Entity_Management_Controller/saveNewEntity'; 
$route['saveExistEntity'] = 'Entity_Management_Controller/saveExistEntity'; 
$route['getEntityBillingInfo'] = 'Entity_Management_Controller/getEntityBillingInfo'; 
$route['getLocationHierarchy'] = 'Entity_Management_Controller/getLocationHierarchy'; 
$route['getEntityMasterInfo'] = 'Entity_Management_Controller/getEntityMasterInfo'; 
$route['saveEntityBillingInfo'] = 'Entity_Management_Controller/saveEntityBillingInfo'; 
$route['getCityHierarchy'] = 'Entity_Management_Controller/getCityHierarchy'; 

//PD RELATED
$route['triggerNewPD'] = 'PD_Controller/triggerNewPD'; 
$route['updatePDMaster'] = 'PD_Controller/updatePDMaster'; 
$route['(listLessPDDetails/:any)'] = 'PD_Controller/listLessPDDetails/'; 
$route['getListOfProducts'] = 'PD_Controller/getListOfProducts'; 
$route['getListOfLenders'] = 'PD_Controller/getListOfLenders'; 
$route['getListOfCustomerSegments'] = 'PD_Controller/getListOfCustomerSegments'; 
$route['getListOfPDAllocationTypes'] = 'PD_Controller/getListOfPDAllocationTypes'; 
$route['getListOfStatesAndCities'] = 'PD_Controller/getListOfStatesAndCities'; 
$route['getFullPDDetails'] = 'PD_Controller/getFullPDDetails'; 
$route['updatePDDocs'] = 'PD_Controller/updatePDDocs'; 
$route['updatePDApplicants'] = 'PD_Controller/updatePDApplicants'; 
$route['allocatePD'] = 'PD_Controller/allocatePD'; 
$route['schdulePD'] = 'PD_Controller/schdulePD'; 
$route['getListPDOfficers'] = 'PD_Controller/getListPDOfficers'; 
$route['loadFullTemplate'] = 'PD_Controller/loadFullTemplate'; 
$route['allbase'] = 'PD_Controller/base'; 
$route['savePDQuestions'] = 'PD_Controller/saveActualPDQuestions'; 
$route['getAnswersForPD'] = 'PD_Controller/getAnswersForPD'; 
$route['checkOTP'] = 'PD_Controller/checkOTP'; 


