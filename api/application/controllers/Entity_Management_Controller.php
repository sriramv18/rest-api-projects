<?php
/**

 * User: velz
 * This Controller deals with User Management CRUD Operations
 */

defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/libraries/REST_Controller.php';


class Entity_Management_Controller extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('Entity_Management_Model');
		$this->load->library('AWS_S3');
        
    }
   
	public function listAllEntites_get()
	{
		$page = 0;$limit = 0;$sort = 'ASC';$entity_type_id = '';
		
		if($this->get('page')) { $page  = $this->get('page'); }
		if($this->get('limit')){ $limit = $this->get('limit'); }
		if($this->get('sort')) { $sort  = $this->get('sort'); }
		if($this->get('etid')) { $entity_type_id  = $this->get('etid'); }
		
		$result = $this->Entity_Management_Model->$listAllEntities($page,$limit,$sort,$entity_type_id);
		if($result['data_status'])
		{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result['data'];
				$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_OK);
		}
	}

	public function saveNewEntity_post()
	{
		$entity = "";
		$entity_child = "";
		$entity_id = "";
		
		if($this->post('entity')){ $entity = $this->post('entity'); }
		
		if(array_key_exists('entity_child',$entity))
			{
				$entity_child = $entity['entity_child'];
				unset($entity['entity_child']);
			}
			
		
		if($entity != "")
		{
			$entity_id = $this->User_Management_Model->saveRecords($entity,ENTITY);//insert user records and get userid
		}
				
				if($entity_child != "")
				{
					foreach($entity_child as $child)
					{
						$entity_child_array = array('contact_person'=>$child['contact_person'],'contact_email'=>$child['contact_email'],'contact_mobile_no'=>$child['contact_mobile_no'],'fk_entity_id'=>$entity_id,'createdon'=>$entity['createdon'],'fk_createdby'=>$entity['fk_createdby']);
						$this->User_Management_Model->saveRecords($entity_child_array,ENTITYCHILD);
					}
				}
				
				if($entity_id != '' || $entity_id != null)
				{
					 if($entity['fk_entity_type_id'] == 2)// If New Entity is Lender(2) type, then create a S3 bucket for corresponding lender. 
					 {
						  $bucket_name = 'lender'.$entity_id;
						  $bucket_status = $this->aws_s3->createNewBucket($bucket_name);
						 
					 }
				}
				
				if($entity_id != '' || $entity_id != null)
				{
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['record'] = $entity_id;
					$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$this->response($data,REST_Controller::HTTP_OK);
				}
		
		
		
		
		
		
			
	

		
	}
	
	
	
	public function saveExistEntity_post()
	{
		$entity = "";
		$entity_child = "";
		$entity_id = "";
		
		if($this->post('entity')){ $entity = $this->post('entity'); }
		
		if(array_key_exists('entity_child',$entity))
			{
				$entity_child = $entity['entity_child'];
				unset($entity['entity_child']);
			}
		
		if($entity != "")
		{
			$where_condition_array = array('entity_id' => $entity['entity_id'],$where_condition_array);
			$entity_id = $this->User_Management_Model->updateRecords($entity,ENTITY,$where_condition_array);
		}
				
				if($entity_child != "")
				{
					foreach($entity_child as $child)
					{
						$entity_child_array = array('contact_person'=>$child['contact_person'],'contact_email'=>$child['contact_email'],'contact_mobile_no'=>$child['contact_mobile_no'],'fk_entity_id'=>$entity_id,'updatedon'=>$entity['updatedon'],'fk_updatedby'=>$entity['fk_updatedby'],'isactive'=>$child['isactive']);
						$where_condition_array = array('entity_child_id'=>$child['entity_child_id']);
						$this->User_Management_Model->updateRecords($entity_child_array,ENTITYCHILD,$where_condition_array);
					}
				}
				
				
				
				if($entity_id != '' || $entity_id != null)
				{
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['record'] = $entity_id;
					$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$this->response($data,REST_Controller::HTTP_OK);
				}
		
		
		
		
		
		
			
	

		
	}
	
	/*
	* Get Location Hierarchy as Region,state,city, and branch - wrapped as one array 
	*/
	public function getLocationHierarchy_get()
	{
		$fields = array('region_id','name as region_name');
		$where_condition_array = array('isactive' => 1);
		$region_data = $this->Entity_Management_Model->selectCustomRecords($fields,$where_condition_array,REGIONS);
		
		if(count($region_data))
		{
				foreach($region_data as $region_key => $region)
				{			
					$fields = array('state_id','name as state_name','code');
					$where_condition_array = array('isactive' => 1,'fk_region_id'=>$region['region_id']);
					$state_data = $this->Entity_Management_Model->selectCustomRecords($fields,$where_condition_array,STATE);
					
					
					if(count($state_data))
					{
							foreach($state_data as $state_key => $state)
									{
										$fields = array('city_id','name as city_name');
										$where_condition_array = array('isactive' => 1,'fk_state_id' => $state['state_id']);
										$city_data = $this->Entity_Management_Model->selectCustomRecords($fields,$where_condition_array,CITY);
										
										if(count($city_data))
										{
											foreach($city_data as $city_key => $city)
											{
												$fields = array('branch_id','name as branch_name');
												$where_condition_array = array('isactive' => 1,'fk_city_id' => $city['city_id']);
												$branch_data = $this->Entity_Management_Model->selectCustomRecords($fields,$where_condition_array,BRANCH);
												$city_data[$city_key]['branch_data'] = $branch_data;
											}
											$state_data[$state_key]['city_data'] = $city_data;
										}
									}		
									
								$region_data[$region_key]['state_data'] = $state_data;	
					}
				}
		}
		
				if(count($region_data))
				{
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['records'] = $region_data;
					$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$data['msg'] = 'Records Not Found';
					$this->response($data,REST_Controller::HTTP_OK);
				}
	}
	
	
	
}