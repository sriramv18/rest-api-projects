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

$route['getListOfMasters'] = 'Common_Masters_Controller/getListOfMasters'; 

$route['getListOfIndustryClassifications'] = 'Common_Masters_Controller/getListOfIndustryClassifications'; 
$route['saveIndustryClassification'] = 'Common_Masters_Controller/saveIndustryClassification'; 

$route['getListOfProducts'] = 'Common_Masters_Controller/getListOfProducts'; 
$route['saveProducts'] = 'Common_Masters_Controller/saveProducts'; 

$route['getListOfSubProducts'] = 'Common_Masters_Controller/getListOfSubProducts'; 
$route['saveSubProducts'] = 'Common_Masters_Controller/saveSubProducts'; 

$route['getListOfUOM'] = 'Common_Masters_Controller/getListOfUOM'; 
$route['saveUOM'] = 'Common_Masters_Controller/saveUOM'; 

$route['getListOfOccupationNonEarningMembers'] = 'Common_Masters_Controller/getListOfOccupationNonEarningMembers'; 
$route['saveOccupationNonEarningMembers'] = 'Common_Masters_Controller/saveOccupationNonEarningMembers'; 

$route['getListOfTypeOfActivities'] = 'Common_Masters_Controller/getListOfTypeOfActivities'; 
$route['saveTypeOfActivity'] = 'Common_Masters_Controller/saveTypeOfActivity'; 

$route['getListOfTitles'] = 'Common_Masters_Controller/getListOfTitles'; 
$route['saveTitle'] = 'Common_Masters_Controller/saveTitle'; 

$route['getListOfRelationships'] = 'Common_Masters_Controller/getListOfRelationships'; 
$route['saveRelationship'] = 'Common_Masters_Controller/saveRelationship';

$route['getListOfFrequencies'] = 'Common_Masters_Controller/getListOfFrequencies'; 
$route['saveFrequency'] = 'Common_Masters_Controller/saveFrequency';

$route['getListOfCustomerBehaviours'] = 'Common_Masters_Controller/getListOfCustomerBehaviours'; 
$route['saveCustomerBehaviour'] = 'Common_Masters_Controller/saveCustomerBehaviour';

$route['getListOfRegions'] = 'Common_Masters_Controller/getListOfRegions'; 
$route['saveRegion'] = 'Common_Masters_Controller/saveRegion';

 $route['getListOfCites'] = 'Common_Masters_Controller/getListOfCites'; 
$route['saveCity'] = 'Common_Masters_Controller/saveCity'; 

// $route['getListOfCites'] = 'Common_Masters_Controller/getListOfCites'; 
// $route['saveCity'] = 'Common_Masters_Controller/saveCity'; 

$route['getListOfBranches'] = 'Common_Masters_Controller/getListOfBranches'; 
$route['saveBranch'] = 'Common_Masters_Controller/saveBranch'; 

$route['getListOfMaster'] = 'Common_Masters_Controller/getListOfMaster'; 
$route['saveMaster'] = 'Common_Masters_Controller/saveMaster'; 

//$route['login'] = 'User_Management_Controller/saveNewUser';

