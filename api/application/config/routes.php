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
$route['saveBranch'] = 'Common_Masters_Controller/saveBranch'; 

$route['getListOfMaster'] = 'Common_Masters_Controller/getListOfMaster'; 
$route['saveMaster'] = 'Common_Masters_Controller/saveMaster'; 

$route['login'] = 'Branch_Controller/testAWSS3'; 


//USER MANAGEMENT
$route['getListOfUsers'] = 'User_Management_Controller/listAllUsers'; 
$route['saveNewUser'] = 'User_Management_Controller/saveNewUser'; 
$route['updateExistUser'] = 'User_Management_Controller/updateExistUser'; 
$route['getUsersDetails'] = 'User_Management_Controller/getUsersDetails'; 

// TEMPLATE MANAGEMENT
$route['listAllTemplates'] = 'Template_Management_Controller/listAllTemplates'; 
$route['saveNewTemplateName'] = 'Template_Management_Controller/saveNewTemplateName'; 
$route['saveTemplateLenderDetails'] = 'Template_Management_Controller/saveTemplateLenderDetails'; 
$route['saveTemplateCategoryDetails'] = 'Template_Management_Controller/saveTemplateCategoryDetails'; 

//QUESTION MANAGEMENT
$route['(listAllQuestions/:any)'] = 'Question_Management_Controller/listAllQuestions/'; 
$route['saveNewQuestion'] = 'Question_Management_Controller/saveNewQuestion'; 
$route['saveExistQuestion'] = 'Question_Management_Controller/saveExistQuestion'; 

//ENTITY MANAGEMENT
$route['listAllEntites'] = 'Entity_Management_Controller/listAllEntites'; 
$route['saveNewEntity'] = 'Entity_Management_Controller/saveNewEntity'; 
$route['saveExistEntity'] = 'Entity_Management_Controller/saveExistEntity'; 

//PD RELATED
$route['triggerNewPD'] = 'PD_Controller/triggerNewPD'; 
$route['updateExistPD'] = 'PD_Controller/updateExistPD'; 
$route['(listLessPDDetails/:any)'] = 'PD_Controller/listLessPDDetails/'; 

