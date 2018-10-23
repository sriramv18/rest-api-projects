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
		$page = 0;$limit = 0;$sort = 'ASC';$entity_type_id = '';$entity_id = '';
		
		if($this->get('page')) { $page  = $this->get('page'); }
		if($this->get('limit')){ $limit = $this->get('limit'); }
		if($this->get('sort')) { $sort  = $this->get('sort'); }
		if($this->get('etid')) { $entity_type_id  = $this->get('etid'); }
		
		$result = $this->Entity_Management_Model->listAllEntities($page,$limit,$sort,$entity_type_id,$entity_id);
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
		$records = "";
		$entity_id = "";
		
		if($this->post('records')){ $records = $this->post('records'); }
	
		if(!isset($records['entity_id']))
			{
				$entity_id = $this->Entity_Management_Model->saveRecords($records,ENTITY);//insert user records and get userid

				 if($entity_id != '' || $entity_id != null)
				{
					 
					 // If New Entity is Lender(2) type, then create a S3 bucket for corresponding lender. 
					 if($records['fk_entity_type_id'] == 2)
					 {
						  //echo "LENDER TYPE";
						  $bucket_name = LENDER_BUCKET_NAME_PREFIX.$entity_id;
						  $bucket_status = $this->aws_s3->createNewBucket($bucket_name);
						  //print_r($bucket_status);
						 
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
			else
			{
				$where_condition_array = array('entity_id' => $records['entity_id']);
				$entity_id = $this->Entity_Management_Model->updateRecords($records,ENTITY,$where_condition_array);
				if($entity_id != '' || $entity_id != null)
				{
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['record'] = true;
					$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$this->response($data,REST_Controller::HTTP_OK);
				}
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
	
	
	/******   Get All Entity Billing Info and it's contact info @param entity id******/
	public function getEntityBillingInfo_get()
   {
	   $entity_id = "";
	   if($this->get('eid')) { $entity_id  = $this->get('eid'); }
	   
	   if( $entity_id != "" || $entity_id != null)
	   {
		
		 $result = $this->Entity_Management_Model->getEntityBillingInfo($entity_id);
		if(count($result))
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
	   
	   
   }
   
   public function getEntityMasterInfo_get()
   {
	   $entity_id = "";
	   if($this->get('eid')) { $entity_id  = $this->get('eid'); }
	   
	   if( $entity_id != "" || $entity_id != null)
	   {
		
		 // $columns = array('ENTITY.entity_id, ENTITY.full_name, ENTITY.short_name');
		 // $table = array('');
		 // $joins = array();
		 // $where_condition_array = array();
		 $result = $this->Entity_Management_Model->listAllEntities(0,0,0,0,$entity_id);
		if(count($result))
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
	   
	   
   }
   
   
   //entity_billing_id, fk_entity_id, billing_name, addressline1, addressline2, addressline3, pincode, email, mobileno, gstno, pan, gststatecode, isactive
   public function saveEntityBillingInfo_post()
   {
		$records = "";
		$child_records = "";
		$count = "";
		if($this->post('records')){ $records = $this->post('records'); }
		//print_r($records);
		if($records != "" || $records != null)
		{
			if($records['entity_billing_id'] != "" || $records['entity_billing_id'] != null)
			{
				//UPDATE
				if(isset($records['contacts']))
				{
					$child_records = $records['contacts'];
					unset($records['contacts']);
				}
				
				$where_condition_array = array('entity_billing_id' => $records['entity_billing_id']);
				$entity_billing_id = $this->Entity_Management_Model->updateRecords($records,ENTITYBILLING,$where_condition_array);
				
				if($entity_billing_id != "" || $entity_billing_id != null)
				{
					if($child_records != "" || $child_records != null)
					{
						foreach($child_records as $key => $child)
						{
							//print_r($child['entity_billing_contact_id']);
							if($child['entity_billing_contact_id'] != "" ||$child['entity_billing_contact_id'] != null)
							{
								//echo "UPDATE";
								$where_condition_array = array('entity_billing_contact_id' => $child['entity_billing_contact_id']);
								$entity_billing_contact_id = $this->Entity_Management_Model->updateRecords($child,ENTITYBILLINGCONTACTINFO,$where_condition_array);
								if($entity_billing_contact_id != "" || $entity_billing_contact_id != null){$count++;}
							}
							else
							{
								//echo "INSERT";
								$child['fk_entity_billing_id'] = $records['entity_billing_id'];
								$entity_billing_contact_id = $this->Entity_Management_Model->saveRecords($child,ENTITYBILLINGCONTACTINFO);
								if($entity_billing_contact_id != "" || $entity_billing_contact_id != null){$count++;}
							}
						}
					}
				}
				
				
				if(($entity_billing_id != "" || $entity_billing_id != null) && $count == count($child_records))
					{
							$data['dataStatus'] = true;
							$data['status'] = REST_Controller::HTTP_OK;
							$data['records'] = true;
							$this->response($data,REST_Controller::HTTP_OK);
					}
					else
					{
							$data['dataStatus'] = false;
							$data['status'] = REST_Controller::HTTP_NO_CONTENT;
							$data['msg'] = "Some Thing Went Wrong! Try Later";
							$this->response($data,REST_Controller::HTTP_OK);
					}
				
				
				
			}
			else
			{
				//INSERT
				if(isset($records['contacts']))
				{
					$child_records = $records['contacts'];
					unset($records['contacts']);
				}
				$entity_billing_id = $this->Entity_Management_Model->saveRecords($records,ENTITYBILLING);
				if($entity_billing_id != "" || $entity_billing_id != null)
				{
					if($child_records != "" || $child_records != null)
					{
						foreach($child_records as $key => $child)
						{
							$child['fk_entity_billing_id'] = $entity_billing_id;
							$entity_billing_contact_id = $this->Entity_Management_Model->saveRecords($child,ENTITYBILLINGCONTACTINFO);
							if($entity_billing_contact_id != "" || $entity_billing_contact_id != null){$count++;}
						}
					}
				}
				
					if(($entity_billing_id != "" || $entity_billing_id != null) && $count == count($child_records))
					{
							$data['dataStatus'] = true;
							$data['status'] = REST_Controller::HTTP_OK;
							$data['records'] = $entity_billing_id;
							$this->response($data,REST_Controller::HTTP_OK);
					}
					else
					{
							$data['dataStatus'] = false;
							$data['status'] = REST_Controller::HTTP_NO_CONTENT;
							$data['msg'] = "Some Thing Went Wrong! Try Later";
							$this->response($data,REST_Controller::HTTP_OK);
					}
				
			}
		}
   }
	
	
	
}