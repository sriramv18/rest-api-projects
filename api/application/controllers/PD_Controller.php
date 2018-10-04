<?php
/**

 * User: velz
 * This Controller deals with PD Related CRUD Operations
 */

defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/libraries/REST_Controller.php';


class PD_Controller extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('PD_Model');
		$this->load->library('AWS_S3');
		$this->load->library('AWS_SES');
        
    }
    /***********************Get get List Of Lenders  Details for PD Trigger Page************************/
	
	public function getListOfLenders_get()
	{
		$fields = array('entity_id','full_name','short_name');
		$where_condition_array = array('isactive' => 1,'fk_entity_type_id' => 2);
		$result_data = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,ENTITY);
		if(count($result_data))
		{
						
						
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $result_data;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
			
		}
	}
	
	/********************Get get List Of Products and SubProducts Name Details for PD Trigger Page*********/
	
	public function getListOfProducts_get()
	{
		$fields = array('product_id','name as product_name','abbr as product_abbr');
		$where_condition_array = array('isactive' => 1);
		$result_data = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PRODUCTS);
		if(count($result_data))
		{
				foreach($result_data as $key => $product)
						{
							$fields = array('subproduct_id','name as subproduct_name','abbr as subproduct_abbr');
							$where_condition_array = array('isactive' => 1,'fk_product_id' => $product['product_id']);
							$subproducts = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,SUBPRODUCTS);
							//array_push($result_data[$key],$subproducts);
							$result_data[$key]['subproducts'] = $subproducts;
						}		
						
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $result_data;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
			
		}
	}
	
	
	/********************Get get List Of CustomerSegments  Details for PD Trigger Page*********/
	
	public function getListOfCustomerSegments_get()
	{
		$fields = array('customer_segment_id','name as customer_segment','abbr');
		$where_condition_array = array('isactive' => 1);
		$result_data = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,CUSTOMERSEGMENT);
		if(count($result_data))
		{
						
						
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $result_data;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
			
		}
	}
	
	/********************Get get List Of Both PD Allocation Types and PD Types  Details for PD Trigger Page*********/
	
	public function getListOfPDAllocationTypes_get()
	{
		$fields = array('pd_allocation_type_id','pd_allocation_type_name','pd_allocation_type_name','default');
		$where_condition_array = array('isactive' => 1);
		$result_data['pd_allocation_type'] = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDALLOCATIONTYPE);
		
		$fields1 = array('pd_type_id','type_name');
		$where_condition_array1 = array('isactive' => 1);
		$result_data['pd_type'] = $this->PD_Model->selectCustomRecords($fields1,$where_condition_array1,PDTYPE);
		if(count($result_data))
		{
						
						
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $result_data;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
			
		}
	}
	
	
	/********************Get get List Of States and Cities Name Details for PD Trigger Page*********/
	
	public function getListOfStatesAndCities_get()
	{
		$fields = array('state_id','name as state_name','code');
		$where_condition_array = array('isactive' => 1);
		$result_data = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,STATE);
		if(count($result_data))
		{
				foreach($result_data as $key => $state)
						{
							$fields = array('city_id','name as city_name');
							$where_condition_array = array('isactive' => 1,'fk_state_id' => $state['state_id']);
							$cities = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,CITY);
							//array_push($result_data[$key],$cities);
							$result_data[$key]['cities'] = $cities;
						}		
						
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $result_data;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
			
		}
	}
	
	
	
	
	
	/********For Save New PD while Trigger****/
	/*
	sample data
	{
    "pd_details":{ "fk_lender_id": "1", "lender_applicant_id":"12458","fk_product_id":"2","fk_subproduct_id":"1","fk_pd_type":"2", "fk_pd_status":"2","pd_specific_clarification":"nothing","createdon":"2017","fk_createdby":"2","fk_pd_allocation_type":"3","fk_pd_allocated_to":"1","fk_pd_template_id":"2","fk_customer_segment":"1","pd_officier_final_judgement":"54561","pd_agency_id":"1","loan_amount":"1589655","addressline1":"1", "addressline2":"2", "addressline3":"3", "fk_city":"1", "fk_state":"2", "pincode":"966852"}
	}
	*/
	public function triggerNewPD_post()
	{
		$pd_details = json_decode($this->post('pd_details'),true);
		$pd_applicant_details = json_decode($this->post('pd_applicant_details'),true);
		$pd_document_titles = json_decode($this->post('pd_document_titles'),true);
		$pd_documents = array();
		if(!empty($_FILES['pddocuments']))
		{
			
		}
		$count = 0;
		/***********************CHOOSE PD TEMPALATE*********************/
		 $fields = array('fk_template_id');
		 
		 $where_condition_array = array('fk_lender_id'=>1 ,'fk_product_id'=> 1,'fk_customer_segment'=> 1,'isactive' => 1);
		 
		 $table = LENDERTEMPLATE;
		 
		 $choosed_template_id = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,$table);
		 
		 if(count($choosed_template_id))
		 { 
			$pd_details['fk_template_id'] = $choosed_template_id[0]['fk_template_id']; 
		 }
		 
		
		/***********************PD ALLOCATION TYPE PROCESS **********/
		
		
		$where_condition_array = array('fk_city_id' => $pd_details['fk_city'],'fk_lender_id' => $pd_details['fk_lender_id']);
		$temp_city_id = $this->PD_Model->selectRecords(PDTEAMMAP,$where_condition_array,$limit=0,$offset=0);
		if(count($temp_city_id))
		{
			if(isset($temp_city_id[0]['type']))
			{
				if($temp_city_id[0]['type'] == 0) // Allocate to Vendor
				{
					$pd_details['pd_agency_id'] = $temp_city_id[0]['fk_team_id'];
					$pd_details['fk_pd_allocated_to'] = ALLOCATED_TO_PARTNER;
				}
				else //Allocate to SineEdge Team with allocation logics
				{
						$local_pd_allocation_type = $pd_details['fk_pd_allocation_type'];
						if($local_pd_allocation_type == 1)// AUTO - Load Balance Allocation
						{
							
								//select list of pd officers based on pd type, product, customer segment, and team from table (t_pd_officiers_details) and choose minimun allocated one and assign pd Officer and change status form TRIGGERED to ALLOCATED 
								$fields = array('fk_user_id,allocated');
								
								$where_condition_array = array('fk_pd_type_id' => $pd_details['fk_pd_type'],'fk_team_id' => $temp_city_id[0]['fk_team_id'],'fk_customer_segment' => $pd_details['fk_customer_segment'],'fk_product_id' => $pd_details['fk_product_id'],'isactive' => 1);
								
								$list_of_pd_officers = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDOFFICIERSDETAILS);
								
								$allocated_values = array_column($list_of_pd_officers,'allocated');
								
								$min_allocated = min($allocated_values);
								$key = array_search($min_allocated,$allocated_values);
								$final_pd_officer_to_allocate = $list_of_pd_officers[$key]['fk_user_id'];
								
								//For Random Allocaiton not in use
								// $key = mt_rand(0, count($list_of_pd_officers) - 1);
								// $final_pd_officer_to_allocate = isset($list_of_pd_officers[$key])? $list_of_pd_officers[$key]: null;
								
								$pd_details['fk_pd_allocated_to'] = $final_pd_officer_to_allocate;
								$pd_details['fk_pd_status'] = ALLOCATED;
							
							
						}
						else if($local_pd_allocation_type == 2) // AUTO - NEAREST Allocation
						{
							
						}
						else // Manual Allocation
						{
							//  Do nothing, cause fk_pd_allocated_to value comes from front end.
						}
					
				}
			}//End Of isset
		}
		
		
					
		
		/***********************END OF PD ALLOCATION TYPE AND PROCESS***********/
		
		$pd_details['pd_date_of_initiation'] = date("Y-m-d H:i:s");
		$pd_id = $this->PD_Model->saveRecords(PDTRIGGER,$pd_details);
		
		
		/***********************PD DOCUMENTS UPLOAD SECTION  ***********/
		if($pd_id != null || $pd_id != '')
		{
			if(!empty($_FILES['pddocuments']))
			{	
				
				foreach($_FILES['pddocuments'] as $key => $file)
				{
					$tempdoc = $file['pddocuments']['tmp_name'];
					$tempdocname = $file['pddocuments']['name'];
					$bucketname = 'lender'.$pd_details['fk_lender_id'];
					$key = 'pd'.$pd_id.'/'.$tempdocname ;
					$sourcefile = $tempdoc;
				
					$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
					$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
					
					if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
					{
						$record_data = array('fk_pd_id' => $pd_id,'pd_document_title'=>$pd_document_titles[$key],'pd_document_name'=>$tempdocname);
						$this->saveRecords($record_data,PDDOCUMENTS);
					}
					
				}
			}
		}
		/***********************END OF PD DOCUMENTS UPLOAD SECTION ***********/
		if($pd_id != null || $pd_id != '')
		{
			
			foreach($pd_applicant_details as $pd_applicant_detail)
			{
				$pd_applicant_detail['fk_pd_id'] = $pd_id;
				$co_applicant_id = $this->PD_Model->saveRecords(PDAPPLICANTSDETAILS,$pd_applicant_detail);
				if($co_applicant_id != null || $co_applicant_id != '')
				{
					$count = $count + 1;
				}
			}
		}
		
		// update into pd officer details 
		if($pd_details['fk_pd_allocated_to'] != null || $pd_details['fk_pd_allocated_to'] != '')
		{
			$this->PD_Model->updatePDofficersDetail($pd_details['fk_pd_allocated_to']);
		}
		if($pd_id != null || $pd_id != '' && $count != 0)
		{
			// CALL pdnotification Helper function to send pd alerts @ params pdid,pdstatus
			PDALERTS::pdnotification($pd_id);
			
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $template_id;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		
	}
	
	
	
	/*
	*
	*Update PD trigger Master Details(Web app only) from PD trigger Edit/view page
	*/
	public function updatePDMaster_post()
	{
		$pd_details = $this->post('pd_details');
		$where_condition_array = array('pd_id' => $pd_details['pd_id']);
		$pd_id_modified = $this->PD_Model->updateRecords($pd_details,PDTRIGGER,$where_condition_array);
		
		if($pd_id_modified != null || $pd_id_modified != '' && $count != 0)
		{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = true;
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
	*
	*Update PD trigger Applicats Details(Web app only) from PD trigger Edit/view page
	*/
	public function updatePDApplicants_post()
	{
		$pd_applicant_details = $this->post('pd_applicant_details');
		$count = 0;
		$pd_id = 0;
		foreach($pd_applicant_details as $pd_applicant_detail)
			{
				if($pd_applicant_detail['pd_co_applicant_id'] != null || $pd_applicant_detail['pd_co_applicant_id'] != "")
				{
					$pd_id = $pd_applicant_detail['fk_pd_id'];
					$where_condition_array = array('pd_co_applicant_id' => $pd_applicant_detail['pd_co_applicant_id']);
					$co_applicant_id = $this->PD_Model->updateRecords($pd_applicant_detail,PDAPPLICANTSDETAILS,$where_condition_array);
					if($co_applicant_id != null || $co_applicant_id != '')
					{
						$count = $count + 1;
					}
				}
				else
				{
					$pd_applicant_detail['fk_pd_id'] = $pd_id;
					$co_applicant_id = $this->PD_Model->saveRecords(PDAPPLICANTSDETAILS,$pd_applicant_detail);
					if($co_applicant_id != null || $co_applicant_id != '')
					{
						$count = $count + 1;
					}
				}
			}
			
			if($count != 0 && count($pd_applicant_details) == $count)
			{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = true;
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
	*
	*Update PD Documents details from PD Trigger(Web application only) edit/view page 
	*/
	public function updatePDDocs_post()
	{
		
		
		$pd_document_titles = json_decode($this->post('pd_document_titles'),true);
		if(count($pd_document_titles))
		{
			//Get Lender id from PD Master
			$pdid = $pd_document_titles[0]['fk_pd_id'];
			$fields = array('fk_lender_id');
			$where_condition_array = array('pd_id' => $pdid);
			$lender_id = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDTRIGGER);
				foreach($pd_document_titles as $iter => $doc)
				{
					if($doc['pd_document_id'] != null || $doc['pd_document_id'] != '')
					{
							
							$tempdoc = $_FILES['pddocuments']['tmp_name'][$iter];
							$tempdocname = $_FILES['pddocuments']['name'][$iter];
							$bucketname = 'lender'.$lender_id[0]['fk_lender_id'];
							$key = 'pd'.$doc['fk_pd_id'].'/'.$tempdocname ;
							$sourcefile = $tempdoc;
						
							$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
							$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
							
							if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
							{
								
								//delete old doc from s3 bucket_data
								$fields = array('pd_document_name');
								$where_condition_array1 = array('pd_document_id' => $doc['pd_document_id']);
								$old_doc_name = $this->PD_Model->selectCustomRecords($fields,$where_condition_array1,PDDOCUMENTS);
							
								if($old_doc_name != "" || $old_doc_name != null)
								{
									 $key = 'pd'.$doc['fk_pd_id'].'/'.$old_doc_name[0]['pd_document_name'];
									 $this->aws_s3->deleteSingleObjFromBucket($bucketname,$key);
								}
								
								//Update entry in PD Doc table
								$record_data = array('pd_document_name'=>$tempdocname);
								$where_condition_array = array('pd_document_id' => $doc['pd_document_id']);
								$this->PD_Model->updateRecords($record_data,PDDOCUMENTS,$where_condition_array);
							}
							
						
					}
					else
					{
					
						$tempdoc = $_FILES['pddocuments']['tmp_name'][$iter];
						$tempdocname = $_FILES['pddocuments']['name'][$iter];
						$bucketname = 'lender'.$lender_id;
						$key = 'pd'.$doc['fk_pd_id'].'/'.$tempdocname ;
						$sourcefile = $tempdoc;
					
						$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
						$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
						
						if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
						{
							$record_data = array('fk_pd_id' => $pdid,'pd_document_title'=>$doc['pd_document_title'],'pd_document_name'=>$tempdocname);
							$this->PD_Model->saveRecords($record_data,PDDOCUMENTS);
						}
					}
				}
				
				
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = true;
				$this->response($data,REST_Controller::HTTP_OK);
				
		}
	}
	
	
	
	/*
	*Allocate PD to Some PD officer
	*/
	public function allocatePD_post()
	{
		$records = $this->post('records');
		
		if($records['fk_pd_allocated_to'] != "" || $records['fk_pd_allocated_to'] != null)
		{
			$records['fk_pd_status'] = ALLOCATED;
		}
		$where_condition_array = array('pd_id' => $records['pd_id']);
		$pd_id_modified = $this->PD_Model->updateRecords($records,PDTRIGGER,$where_condition_array);
		if($pd_id_modified != "" || $pd_id_modified != null)
				{
					PDALERTS::pdnotification($records['pd_id']);
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['records'] = true;
					$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$data['msg'] = 'Not Updated! Try Later';
					$this->response($data,REST_Controller::HTTP_OK);
				}
		
	}
	
	
	/*
	*Schedule PD by PD officer(only on Manual Schedule)
	*/
	public function schdulePD_post()
	{
		$records = $this->post('records');
		if($records['schedule_time'] != "" || $records['schedule_time'] != null)
		{
			$id = $this->PD_Model->saveRecords($records,PDSCHEDULE);
			if($id != '' || $id != null)
			{
				$where_condition_array = array('pd_id' => $records['fk_pd_id']);
				$temp_array = array('fk_pd_status' => SCHEDULED,'fk_updatedby'=>$records['fk_scheduled_by'],'updatedon'=>$records['createdon']);
				$pd_id_modified = $this->PD_Model->updateRecords($temp_array,PDTRIGGER,$where_condition_array);
				
				if($pd_id_modified != "" || $pd_id_modified != null)
				{
					PDALERTS::pdnotification($records['fk_pd_id']);
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['records'] = true;
					$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$data['msg'] = 'Not Updated! Try Later';
					$this->response($data,REST_Controller::HTTP_OK);
				}
			}
		}
		
		
	}
	
	
	/*
	*GET List of PD officers for PD edit/view page for manual allocation
	*@param pd
	*/
	public function getListPDOfficers_post()
	{
		//select list of pd officers based on pd type, product, customer segment, and team from table (t_pd_officiers_details) and choose minimun allocated one and assign pd Officer and change status form TRIGGERED to ALLOCATED 
								$fields = array('fk_user_id,allocated');
								
								$where_condition_array = array('fk_pd_type_id' => $pd_details['fk_pd_type'],'fk_team_id' => $temp_city_id[0]['fk_team_id'],'fk_customer_segment' => $pd_details['fk_customer_segment'],'fk_product_id' => $pd_details['fk_product_id'],'isactive' => 1);
								
								$list_of_pd_officers = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDOFFICIERSDETAILS);
	}
	
	/*    PD_Triggerd and PD_Co_Applocants Details only for Listing Page
		@param page/offset
		@param limit
		@param sorting order(ASC/DESC)
		@param cid for category_id for filter question with category wise.
	*/
	public function listLessPDDetails_get()
	{
			$page = 0;$limit = 50;$sort = 'DESC';
			if($this->get('page')) { $page  = $this->get('page'); }
			if($this->get('limit')){ $limit = $this->get('limit'); }
			if($this->get('sort')) { $sort  = $this->get('sort'); }
			
			$result_data = $this->PD_Model->listLessPDDetails($page,$limit,$sort);
			
			if($result_data['data_status'] == true)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result_data['data'];
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else
			{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_OK);
				
			}
			
	}
	
	/*
	* Get Full PD Details like all  applicant's details, all PD related documents, PD Template and 
	* answersd questions,PD History details.
	*/
	public function getFullPDDetails_post()
	{
		$pdid = $this->post('pdid');
		
		// Get All PD Masters Details
		$result_data['pd_master_details'] = $this->PD_Model->getPDMasterDetails($pdid);
		
		// Get All Applicant's Details
		$result_data['applicants_details'] = $this->PD_Model->getApplicantsDetails($pdid);
		
		// Get All PD Related Documents
		$result_data['pd_documnets'] = $this->PD_Model->getSignedPDDocsURL($pdid);
	
		//Get All PD Template and It's Question with Answers
		$result_data['pd_question_answer'] = $this->PD_Model->getPDQuestionAnswers($pdid);
		
		//Get All PD Logs
		$result_data['pd_logs'] = $this->PD_Model->getPDLogs($pdid);
		
		$applicant_msg = '';
		$pd_docs_msg = '';
		$pd_question_answer_msg = '';
		$pd_logs_msg = '';
		
		if(!count($result_data['applicants_details']))
		{
			$applicant_msg = 'Applicant Details Not Found';
		}
		
		if(!count($result_data['pd_documnets']))
		{
			$pd_docs_msg = 'Documents Not Found';
		}
		
		if(!count($result_data['pd_question_answer']))
		{
			$pd_question_answer_msg = 'PD Details Not Found';
		}
		
		if(!count($result_data['pd_logs']['pd_master_logs']) && !count($result_data['pd_logs']['pd_applicants_logs']))
		{
			$pd_logs_msg = 'PD Logs Not Found';
		}
		
			
			$data['dataStatus'] = true;
			$data['status'] = REST_Controller::HTTP_OK;
			$data['records'] = $result_data;
			$data['msg'] = array('applicant_msg'=>$applicant_msg,'pd_docs_msg'=>$pd_docs_msg,'pd_question_answer_msg'=>$pd_question_answer_msg,'pd_logs_msg'=>$pd_logs_msg);
			$this->response($data,REST_Controller::HTTP_OK);
		
		 
	}
	
	
	
	
	
}