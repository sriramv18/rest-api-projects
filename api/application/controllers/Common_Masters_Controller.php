<?php
/**

 * User: velz
 * This Controller deals with User Management CRUD Operations
 */

defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/libraries/REST_Controller.php';


class Common_Masters_Controller extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('Common_Masters_Model');
        
    }
 
	// /*  Get List Of Mastsers for DropDown  */
	// public function getListOfMasters_get()
	// {
		// $result = $this->Common_Masters_Model->getListOfMasters();
		// if(count($result) > 0)
		// {
			// $data['dataStatus'] = true;
			// $data['status'] = REST_Controller::HTTP_OK;
			// $data['records'] = $result;
			// $this->response($data,REST_Controller::HTTP_OK);
			
		// }
		// else
		// {
			// $data['dataStatus'] = false;
			// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
			// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
		// }
			
	// }
	
	// /* Industry Classification Masters */
	
	
	// public function getListOfIndustryClassifications_get()
	// {
		// $result = $this->Common_Masters_Model->selectRecords('m_industry_classification');
		// if(count($result) > 0)
		// {
			// $data['dataStatus'] = true;
			// $data['status'] = REST_Controller::HTTP_OK;
			// $data['records'] = $result;
			// $this->response($data,REST_Controller::HTTP_OK);
		// }
		// else
		// {
			// $data['dataStatus'] = false;
			// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
			// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
		// }
	// }
	
	// public function saveIndustryClassification_post()
	// {
		// $industryClassifications = $this->post('industryClassifications');
		
		// if($industryClassifications['industry_classification_id'])  //Update Record
		// {
			// $where_condition_array = array('industry_classification_id'=>$industryClassificationData['industry_classification_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($industryClassifications,'m_industry_classification',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record
		// {
			// $result = $this->Common_Masters_Model->saveRecords($industryClassifications,'m_industry_classification');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	// /* End Of Industry Classification Masters */
	
	
	
	
	// /* Producsts Masters */
	
	// public function getListOfProducts_get()
	// {
		// $result = $this->Common_Masters_Model->selectRecords('m_products');
		// if(count($result) > 0)
		// {
			// $data['dataStatus'] = true;
			// $data['status'] = REST_Controller::HTTP_OK;
			// $data['records'] = $result;
			// $this->response($data,REST_Controller::HTTP_OK);
		// }
		// else
		// {
			// $data['dataStatus'] = false;
			// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
			// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
		// }
	// }
	
	// public function saveProducts_post()
	// {
		// $products = $this->post('products');
		
		// if($products['product_id'])  //Update Record
		// {
			// $where_condition_array = array('product_id'=>$products['product_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($products,'m_products',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record
		// {
			// $result = $this->Common_Masters_Model->saveRecords($products,'m_products');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	

	
	// /* End Of Producsts Masters */
	
	
	
	
	// /* Sub - producsts Master */
	
	// public function getListOfSubProducts_get()
	// {
		// $result = $this->Common_Masters_Model->selectRecords('m_subproducts');
		// if(count($result) > 0)
		// {
			// $data['dataStatus'] = true;
			// $data['status'] = REST_Controller::HTTP_OK;
			// $data['records'] = $result;
			// $this->response($data,REST_Controller::HTTP_OK);
		// }
		// else
		// {
			// $data['dataStatus'] = false;
			// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
			// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
		// }
	// }
	
	// public function saveSubProducts_post()
	// {
		// $subproducts = $this->post('subproducts');
		
		// if($subproducts['subproduct_id'])  //Update Record
		// {
			// $where_condition_array = array('subproduct_id'=>$subproducts['subproduct_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($subproducts,'m_subproducts',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record
		// {
			// $result = $this->Common_Masters_Model->saveRecords($subproducts,'m_subproducts');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	
	// /* End Of Sub - producsts Master */
	
	
	
	// /*  UOM Master */
	
	// public function getListOfUOM_get()
		// {
			// $result = $this->Common_Masters_Model->selectRecords('m_uom');
			// if(count($result) > 0)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
				// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
			// }
		// }
	
	// public function saveUOM_post()
	// {
		// $uom = $this->post('uom');
		
		// if($uom['uom_id'])  //Update Record
		// {
			// $where_condition_array = array('uom_id'=>$uom['uom_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($uom,'m_uom',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record	
		// {
			// $result = $this->Common_Masters_Model->saveRecords($uom,'m_uom');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	// /*  End Of  UOM Master */
	
	
	
	// /*  Occupation_non_earning_members  Master */
	
	
	// public function getListOfOccupationNonEarningMembers_get()
		// {
			// $result = $this->Common_Masters_Model->selectRecords('m_occupation_non_earning_members');
			// if(count($result) > 0)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
				// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
			// }
		// }
	
	// public function saveOccupationNonEarningMembers_post()
	// {
		// $occupationnonearningmembers = $this->post('occupationnonearningmembers');
		
		// if($occupationnonearningmembers['occupation_non_earning_member_id'])  //Update Record
		// {
			// $where_condition_array = array('occupation_non_earning_member_id'=>$occupationnonearningmembers['occupation_non_earning_member_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($occupationnonearningmembers,'m_occupation_non_earning_members',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record	
		// {
			// $result = $this->Common_Masters_Model->saveRecords($occupationnonearningmembers,'m_occupation_non_earning_members');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	
	// /*  End Of  Occupation_non_earning_members Master */
	
	
	// /*  Type Of Activity Master */
	
	
	// public function getListOfTypeOfActivities_get()
		// {
			// $result = $this->Common_Masters_Model->selectRecords('m_type_of_activity');
			// if(count($result) > 0)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
				// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
			// }
		// }
	
	// public function saveTypeOfActivity_post()
	// {
		// $typeofactivity = $this->post('typeofactivity');
		
		// if($typeofactivity['type_of_activity_id'])  //Update Record
		// {
			// $where_condition_array = array('type_of_activity_id'=>$typeofactivity['type_of_activity_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($typeofactivity,'m_type_of_activity',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record	
		// {
			// $result = $this->Common_Masters_Model->saveRecords($typeofactivity,'m_type_of_activity');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	
	// /*  End Of  Type Of Activity Master */
	
	
	// /*  Titles Master */
	
	
	// public function getListOfTitles_get()
		// {
			// $result = $this->Common_Masters_Model->selectRecords('m_titles');
			// if(count($result) > 0)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
				// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
			// }
		// }
	
	// public function saveTitle_post()
	// {
		// $title = $this->post('title');
		
		// if($title['title_id'])  //Update Record
		// {
			// $where_condition_array = array('title_id'=>$title['title_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($title,'m_titles',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record	
		// {
			// $result = $this->Common_Masters_Model->saveRecords($title,'m_titles');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	
	// /*  End Of  Titles Master */
	
	
	
	// /*  Relationships Master */
	
	
	// public function getListOfRelationships_get()
		// {
			// $result = $this->Common_Masters_Model->selectRecords('m_relationships');
			// if(count($result) > 0)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
				// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
			// }
		// }
	
	// public function saveRelationship_post()
	// {
		// $relationship = $this->post('relationship');
		
		// if($relationship['relationship_id'])  //Update Record
		// {
			// $where_condition_array = array('relationships'=>$relationship['relationship_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($relationship,'m_relationship',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record	
		// {
			// $result = $this->Common_Masters_Model->saveRecords($relationship,'m_relationship');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	
	// /*  End Of  Relationships Master */
	
	
	
	// /*  Frequency Master */
	
	
	// public function getListOfFrequencies_get()
		// {
			// $result = $this->Common_Masters_Model->selectRecords('m_frequency');
			// if(count($result) > 0)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
				// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
			// }
		// }
	
	// public function saveFrequency_post()
	// {
		// $frequency = $this->post('frequency');
		
		// if($frequency['frequency_id'])  //Update Record
		// {
			// $where_condition_array = array('frequency_id'=>$frequency['frequency_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($frequency,'m_frequency',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record	
		// {
			// $result = $this->Common_Masters_Model->saveRecords($frequency,'m_frequency');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	
	// /*  End Of  Frequency Master */
	
	
	// /*  Customer Behaviour Master */
	
	
	// public function getListOfCustomerBehaviours_get()
		// {
			// $result = $this->Common_Masters_Model->selectRecords('m_customer_behaviour');
			// if(count($result) > 0)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
				// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
			// }
		// }
	
	// public function saveCustomerBehaviour_post()
	// {
		// $customerbehaviour = $this->post('customerbehaviour');
		
		// if($customerbehaviour['customer_behaviour_id'])  //Update Record
		// {
			// $where_condition_array = array('customer_behaviour_id'=>$customerbehaviour['customer_behaviour_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($customerbehaviour,'m_customer_behaviour',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record	
		// {
			// $result = $this->Common_Masters_Model->saveRecords($customerbehaviour,'m_customer_behaviour');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	
	// /*  End Of  Customer Behaviour Master */
	
	
	
	// /*  Zonal/Regional  Master */
	
	
	// public function getListOfRegions_get()
		// {
			// $result = $this->Common_Masters_Model->selectRecords('m_regions');
			// if(count($result) > 0)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
				// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
			// }
		// }
	
	// public function saveRegion_post()
	// {
		// $region = $this->post('region');
		
		// if($region['region_id'])  //Update Record
		// {
			// $where_condition_array = array('region_id'=>$region['region_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($region,'m_regions',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record	
		// {
			// $result = $this->Common_Masters_Model->saveRecords($region,'m_regions');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	
	// /*  End Of  Zonal/Regional Master */
	
	
	
	// /*  States  Master */
	
	
	// public function getListOfStates_get()
		// {
			// $result = $this->Common_Masters_Model->selectRecords('m_states');
			// if(count($result) > 0)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
				// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
			// }
		// }
	
	// public function saveState_post()
	// {
		// $state = $this->post('state');
		
		// if($state['state_id'])  //Update Record
		// {
			// $where_condition_array = array('state_id'=>$state['state_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($state,'m_states',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record	
		// {
			// $result = $this->Common_Masters_Model->saveRecords($state,'m_states');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	
	// /*  End Of  States Master */
	
	
	// /*  City  Master */
	
	
	// public function getListOfCites_get()
		// {
			// $result = $this->Common_Masters_Model->selectRecords('m_city');
			// if(count($result) > 0)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NO_CONTENT;
				// $this->response($data,REST_Controller::HTTP_NO_CONTENT);
			// }
		// }
	
	// public function saveCity_post()
	// {
		// $city = $this->post('city');
		
		// if($city['city_id'])  //Update Record
		// {
			// $where_condition_array = array('city_id'=>$city['city_id']);
			
			// $result = $this->Common_Masters_Model->updateRecords($city,'m_city',$where_condition_array);
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else  
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				// $this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			// }
		// }
		// else 	// Insert Record	
		// {
			// $result = $this->Common_Masters_Model->saveRecords($city,'m_city');
			
			// if($result)
			// {
				// $data['dataStatus'] = true;
				// $data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result;
				// $this->response($data,REST_Controller::HTTP_OK);
			// }
			// else
			// {
				// $data['dataStatus'] = false;
				// $data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				// $this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			// }
		// }
		
	// }
	
	
	
	/*  End Of  City Master */
	
	
	
	/*  For Save,Update and Retrieve all  Master  Tables*/
	
	
	public function getListOfMaster_post()
		{
			
			$table_name = $this->post('master_name');
			//echo $table_name;
			$result = $this->Common_Masters_Model->selectRecords(constant($table_name));
			//print_r($result);
			//die();
			if(count($result) > 0)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else
			{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_NO_CONTENT);
			}
		}
	
	public function saveMaster_post()
	{
		echo 'dfsf';
		$records = $this->post('records');
		$table_name = $this->post('master_name');
		print_r($records);
		//die();
		
		if(false !== array_key_exists(constant($table_name.'ID'),$records))  //Update Record
		{
			
			$where_condition_array = array(constant($table_name.'ID') => $records[constant($table_name.'ID')]);
			
			$result = $this->Common_Masters_Model->updateRecords($records,constant($table_name),$where_condition_array);
			
			if($result)
			{
				
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else  
			{	
				
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				$this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			}
		}
		else 	// Insert Record	
		{
			
			$result = $this->Common_Masters_Model->saveRecords($records,constant($table_name));
			
			if($result)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else
			{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				$this->response($data,REST_Controller::HTTP_SERVICE_UNAVAILABLE);
			}
		}
		
	}
	
	
	
	/*  End Of  Save,Update and Retrieve all  Master  Tables */

	/*  For Branch Listing */
	public function getListOfBranches_get(){
		
	    $columns = array('m_city.name as cityname','BRANCH.*');
		$table = BRANCH.' as BRANCH';
		$joins = array(
			array(
				'table' => 'm_city',
				'condition' => 'BRANCH.fk_city_id = m_city.city_id ',
				'jointype' => 'INNER'
			)
		);
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$print_query = '');
			
			if(count($result) > 0)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else
			{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_OK);
			}

	}
	/*  End Of Branch Master */

	/*  For Company Listing */
	public function getListOfCompany_get(){
	    $columns = array('m_city.name as city_name','m_states.name as state_name','COMPANY.*');
		$table = COMPANY.' as COMPANY';
		$joins = array(
			array(
				'table' => 'm_city',
				'condition' => 'COMPANY.city = m_city.city_id ',
				'jointype' => 'INNER'
			),
			array(
				'table' => 'm_states',
				'condition' => 'COMPANY.state = m_states.state_id',
				'jointype' => 'INNER'
			)
		);
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$print_query = '');
			//print_r($result);
			//die();
			if(count($result) > 0)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else
			{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_OK);
			}

	}
	/*  End of Company Listing */

	/*  For Product Listing */
	public function getListOfSubProduct_get(){
	    $columns = array('m_products.name as product_name','SUBPRODUCTS.*');
		$table = SUBPRODUCTS.' as SUBPRODUCTS';
		$joins = array(
			array(
				'table' => 'm_products',
				'condition' => 'SUBPRODUCTS.fk_product_id = m_products.product_id',
				'jointype' => 'INNER'
			)
		);
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$print_query = '');
			
			if(count($result) > 0)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else
			{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_OK);
			}

	}
	/*  End of Product Listing */

	/*  For State Listing */
	public function getListOfState_get(){
	    $columns = array('m_regions.name as region_name','STATE.*');
		$table = STATE.' as STATE';
		$joins = array(
			array(
				'table' => 'm_regions',
				'condition' => 'STATE.fk_region_id = m_regions.region_id ',
				'jointype' => 'INNER'
			)
		);
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$print_query = '');
			
			if(count($result) > 0)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else
			{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_OK);
			}

	}
	/*  End of State Listing */

	/*  For City Listing */
	public function getListOfCity_get(){
	    $columns = array('m_states.name as state_name','CITY.*');
		$table = CITY.' as CITY';
		$joins = array(
			array(
				'table' => 'm_states',
				'condition' => 'CITY.fk_state_id = m_states.state_id ',
				'jointype' => 'INNER'
			)
		);
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$print_query = '');
			
			if(count($result) > 0)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else
			{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_OK);
			}

	}
	/*  End of City Listing */


}