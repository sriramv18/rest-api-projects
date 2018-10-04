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
		
		if($this->post('entity_child')){ $entity_child = $this->post('entity_child'); }
		
		if($entity != "")
		{
			$entity_id = $this->User_Management_Model->saveRecords($entity,ENTITY);//insert user records and get userid
		}
				
				if($entity_child != "")
				{
					foreach($entity_child as $child)
					{
						$entity_child_array = array('contact_person'=>$child['contact_person'],'contact_email'=>$child['contact_email'],'contact_mobile_no'=>$child['contact_mobile_no'],'fk_entity_id'=>$entity_id,'createdon'=>$child['createdon'],'fk_createdby'=>$child['fk_createdby']);
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
					$this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
				}
		
		
		
		
		
		
			
	

		
	}
	
	
	
	public function saveExistEntity_post()
	{
		$entity = "";
		$entity_child = "";
		$entity_id = "";
		
		if($this->post('entity')){ $entity = $this->post('entity'); }
		
		if($this->post('entity_child')){ $entity_child = $this->post('entity_child'); }
		
		if($entity != "")
		{
			$where_condition_array = array('entity_id' => $entity['entity_id'],$where_condition_array);
			$entity_id = $this->User_Management_Model->updateRecords($entity,ENTITY,$where_condition_array);
		}
				
				if($entity_child != "")
				{
					foreach($entity_child as $child)
					{
						$entity_child_array = array('contact_person'=>$child['contact_person'],'contact_email'=>$child['contact_email'],'contact_mobile_no'=>$child['contact_mobile_no'],'fk_entity_id'=>$entity_id,'updatedon'=>$child['updatedon'],'fk_updatedby'=>$child['fk_updatedby'],'isactive'=>$child['isactive']);
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
					$this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
				}
		
		
		
		
		
		
			
	

		
	}
	
	
	
}