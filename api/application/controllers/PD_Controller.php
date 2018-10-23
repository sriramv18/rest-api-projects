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
		$this->load->library('AWS_SNS');
        
    }
    
	
	public function base_get()
	{
					$base64_img = "data:image/gif;base64,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";
					
					$output_file = APPPATH."/docs/temp_base64_image.png";
					$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$charactersLength = strlen($characters);
						$randomString = '';
							for ($i = 0; $i < 5; $i++) {
								$randomString .= $characters[rand(0, $charactersLength - 1)];
							}
						$temp_file_name = $randomString.date('Y-m-d-H:m:s');
						
					
					$ifp = fopen( $output_file, 'wb' ); 

					// split the string on commas
					// $data[ 0 ] == "data:image/png;base64"
					// $data[ 1 ] == <actual base64 string>
					$data = explode( ',', $base64_img );
					print_r($data);
					// we could add validation here with ensuring count( $data ) > 1
					fwrite( $ifp, base64_decode( $data[ 1 ] ) );

					// clean up the file resource
					fclose( $ifp ); 

					print_r($output_file); 
					
					$tempdoc = $output_file;
					$tempdocname = $temp_file_name.'.png';
					$bucketname = LENDER_BUCKET_NAME_PREFIX.'1';
					$key = 'pd'.'1'.'/'.$tempdocname ;
					$sourcefile = $tempdoc;
					
					$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
					$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
					print_r($s3result);
					if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
					{
						// $record_data = array('fk_pd_id' => $pd_id,'pd_document_title'=>$title,'pd_document_name'=>$tempdocname);
						// $this->PD_Model->saveRecords($record_data,PDDOCUMENTS);
					}
	}
	/***********************Get get List Of Lenders  Details for PD Trigger Page************************/
	
	public function getListOfLenders_get()
	{
		$fields = array('entity_id','full_name','short_name');
		$where_condition_array = array('isactive' => 1,'fk_entity_type_id' => 2);
		$result_data = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,ENTITY);
		if(count($result_data))
		{
						
						foreach($result_data as $key => $value)
						{
							$fields = array('*');
							$where_condition_array = array('isactive' => 1,'fk_entity_id' => $value['entity_id']);
							$result_data[$key]['billing_address'] = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,ENTITYBILLING);
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
		$fields = array('pd_allocation_type_id','pd_allocation_type_name','pd_allocation_logic','default');
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
	
	public function triggerNewPD_post()
	{
		
		
		$pd_details = json_decode($this->post('pd_details'),true);
		
		$pd_applicant_details = json_decode($this->post('pd_applicant_details'),true);
		$pd_document_titles = "";
		$pd_document_from_mobile = ""; 
		if($this->post('pd_document_titles')){ $pd_document_titles = json_decode($this->post('pd_document_titles'),true); }
		
		if($this->post('pd_document_from_mobile')){ $pd_document_from_mobile = json_decode($this->post('pd_document_from_mobile'),true); }
		
		$pd_documents = array();
		
		$count = 0;
		/***********************CHOOSE PD TEMPALATE*********************/
		if($pd_details['pd_status'] == TRIGGERED)
		{
			 $fields = array('fk_template_id');
			 
			 $where_condition_array = array('fk_lender_id'=>1 ,'fk_product_id'=> 1,'fk_customer_segment'=> 1,'isactive' => 1);
			 
			 $table = LENDERTEMPLATE;
			 
			 $choosed_template_id = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,$table);
			 
			 if(count($choosed_template_id))
			 { 
				$pd_details['fk_pd_template_id'] = $choosed_template_id[0]['fk_template_id']; 
			 }
		}
		
		/***********************PD ALLOCATION TYPE PROCESS **********/
		
		// $pd_details['pd_status'] = TRIGGERED;
		// $pd_details['fk_pd_allocated_to'] = null;
		// $where_condition_array = array('fk_city_id' => $pd_details['fk_city'],'fk_lender_id' => $pd_details['fk_lender_id']);
		// $temp_city_id = $this->PD_Model->selectRecords(PDTEAMMAP,$where_condition_array,$limit=0,$offset=0);
		// //print_r($temp_city_id);
		// if(count($temp_city_id))
		// {
			// if(isset($temp_city_id[0]['team_type']))
			// {
				// if($temp_city_id[0]['team_type'] == 0) // Allocate to Vendor
				// {
					// $pd_details['pd_agency_id'] = $temp_city_id[0]['fk_team_id'];
					// $pd_details['pd_status'] = ALLOCATED_TO_PARTNER;
					// $pd_details['fk_pd_allocated_to'] = null;
				// }
				// else //Allocate to SineEdge Team with allocation logics
				// {
					// //echo "SineEdge TEAm";
						// $local_pd_allocation_type = $pd_details['fk_pd_allocation_type'];
						// if($local_pd_allocation_type == 1)// AUTO - Load Balance Allocation
						// {
							
							// //echo "AUTO LOAD";
								// //select list of pd officers based on pd type, product, customer segment, and team from table (t_pd_officiers_details) and choose minimun allocated one and assign pd Officer and change status form TRIGGERED to ALLOCATED 
								// $fields = array('fk_user_id','allocated');
								
								// $where_condition_array = array('fk_pd_type_id' => $pd_details['fk_pd_type'],'fk_team_id' => $temp_city_id[0]['fk_team_id'],'fk_customer_segment' => $pd_details['fk_customer_segment'],'fk_product_id' => $pd_details['fk_product_id'],'isactive' => 1);
								
								// $list_of_pd_officers = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDOFFICIERSDETAILS);
								// //echo "PD OFF";
								// //print_r($list_of_pd_officers);
								// $allocated_values = array_column($list_of_pd_officers,'allocated');
								
								// $min_allocated = min($allocated_values);
								// $key = array_search($min_allocated,$allocated_values);
								// $final_pd_officer_to_allocate = $list_of_pd_officers[$key]['fk_user_id'];
								
								// //For Random Allocaiton not in use
								// // $key = mt_rand(0, count($list_of_pd_officers) - 1);
								// // $final_pd_officer_to_allocate = isset($list_of_pd_officers[$key])? $list_of_pd_officers[$key]: null;
								
								// $pd_details['fk_pd_allocated_to'] = $final_pd_officer_to_allocate;
								// $pd_details['pd_status'] = ALLOCATED;
								// //echo "final".$final_pd_officer_to_allocate;
							
						// }
						// else if($local_pd_allocation_type == 2) // AUTO - NEAREST Allocation
						// {
							
						// }
						// else // Manual Allocation
						// {
							// //  Do nothing, cause fk_pd_allocated_to value comes from front end.
						// }
					
				// }
			// }//End Of isset
		// }
		
		/***********************END OF PD ALLOCATION TYPE AND PROCESS***********/
		
		$pd_details['pd_date_of_initiation'] = date("Y-m-d H:i:s");
		// if($pd_details['pd_status'] == "" || $pd_details['pd_status'] == null)
		// {
			// $pd_details['pd_status'] = DRAFT;
		// }
		$pd_id = $this->PD_Model->saveRecords($pd_details,PDTRIGGER);
		
		
		/***********************PD DOCUMENTS UPLOAD SECTION  FROM WEB***********/
		if($pd_id != null || $pd_id != '')
		{
		
			if(!empty($_FILES['pddocuments']) && !empty($pd_document_titles))
			{	
				
				foreach($pd_document_titles as $iter => $title)
				{
					
					$tempdoc = $_FILES['pddocuments']['tmp_name'][$iter];
					$tempdocname = $_FILES['pddocuments']['name'][$iter];
					$bucketname = LENDER_BUCKET_NAME_PREFIX.$pd_details['fk_lender_id'];
					$key = 'pd'.$pd_id.'/'.$tempdocname ;
					$sourcefile = $tempdoc;
					
					$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
					$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
					
					if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
					{
						$record_data = array('fk_pd_id' => $pd_id,'pd_document_title'=>$title,'pd_document_name'=>$tempdocname);
						$this->PD_Model->saveRecords($record_data,PDDOCUMENTS);
					}
					
				}
			}
		}
		
		/***********************END OF PD DOCUMENTS UPLOAD SECTION FROM WEB***********/
		if($pd_id != null || $pd_id != '')
		{
			
			foreach($pd_applicant_details as $pd_applicant_detail)
			{
				$pd_applicant_detail['fk_pd_id'] = $pd_id;
				$co_applicant_id = $this->PD_Model->saveRecords($pd_applicant_detail,PDAPPLICANTSDETAILS);
				if($co_applicant_id != null || $co_applicant_id != '')
				{
					$count = $count + 1;
				}
			}
		}
		
		/***********************PD DOCUMENTS(base64 type) UPLOAD SECTION FROM MOBILE***********/
		if($pd_id != null || $pd_id != '')
		{
		
			if(!empty($pd_document_from_mobile))
			{	
				
				foreach($pd_document_from_mobile as $iter => $doc)
				{
					$temp_base64_string = $doc['image'];
					$title = $doc['Name'];
					$output_file = APPPATH."/docs/temp_base64_image.png";
					
					//Generate Random File Name
						$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$charactersLength = strlen($characters);
						$randomString = '';
							for ($i = 0; $i < 5; $i++) {
								$randomString .= $characters[rand(0, $charactersLength - 1)];
							}
						$temp_file_name = $randomString.date('Y-m-d-H:m:s').'.png';
						
						
					$ifp = fopen( $output_file, 'wb' ); 
     				$temp_data = explode( ',', $temp_base64_string );
					fwrite( $ifp, base64_decode( $temp_data[ 1 ] ) );
     				fclose( $ifp ); 
				    $tempdoc = $output_file;
					$tempdocname = $temp_file_name;
					$bucketname = LENDER_BUCKET_NAME_PREFIX.$pd_details['fk_lender_id'];
					$key = 'pd'.$pd_id.'/'.$tempdocname ;
					$sourcefile = $tempdoc;
					
					$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
					$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
					
					if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
					{
						$record_data = array('fk_pd_id' => $pd_id,'pd_document_title'=>$title,'pd_document_name'=>$tempdocname);
						$this->PD_Model->saveRecords($record_data,PDDOCUMENTS);
					}
					
				}
			}
		}
		
		
		/***********************END OF PD DOCUMENTS(base64 type) UPLOAD SECTION FROM MOBILE***********/
		
		
		if($pd_id != null || $pd_id != '' && $count != 0)
		{
			// CALL pdnotification Helper function to send pd alerts @ params pdid,pdstatus
			PDALERTS::pdnotification($pd_id);
			
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $pd_id;
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
		$pd_details = $this->post('records');
		// print_r($pd_details);die;
		//print_r($pd_details);

		// OTP Generate Condition
		if($pd_details['pd_status'] == STARTED)
		{
			$string2 = str_shuffle('1234567890');   
			$OTP = substr($string2,0,6);
			 $msg = "Code for starting your personal discussions with the verification officer is ".$OTP .". Pls share this only when the officer has reached your place in person";
			 $no = (string)$pd_details['mobile_no'];
			unset($pd_details['mobile_no']);
			$pd_details['OTP'] = $OTP; 
			 $this->aws_sns->sendSMS($msg,$no);

		}
		$where_condition_array = array('pd_id' => $pd_details['pd_id']);
		$pd_id_modified = $this->PD_Model->updateRecords($pd_details,PDTRIGGER,$where_condition_array);
		
		if($pd_details['pd_status'] == TRIGGERED)
		{
			// Create entries on `t_pd_category_weightage` table from Template Category weightage 
		}
		

		if($pd_id_modified != null || $pd_id_modified != '' && $count != 0)
		{
						PDALERTS::pdnotification($pd_details['pd_id']);
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
	
	/**
	 * Pd Discussion OTP Checking function 
	 * sriram
	 */

	 public function checkOTP_post()
	 {
		 $pdotp = $this->post('records');

		 $pdotpStatus = $this->PD_Model->checkotp($pdotp);
		 if($pdotpStatus != 0 || $pdotpStatus != '' &&  count($pdotpStatus) != 0)
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
		//print_r($this->post());die();
		foreach($pd_applicant_details as $pd_applicant_detail)
			{
				if($pd_applicant_detail['pd_co_applicant_id'] != null || $pd_applicant_detail['pd_co_applicant_id'] != "")
				{
					//$pd_id = $pd_applicant_detail['fk_pd_id'];
					$where_condition_array = array('pd_co_applicant_id' => $pd_applicant_detail['pd_co_applicant_id']);
					$co_applicant_id = $this->PD_Model->updateRecords($pd_applicant_detail,PDAPPLICANTSDETAILS,$where_condition_array);
					if($co_applicant_id != null || $co_applicant_id != '')
					{
						$count = $count + 1;
					}
				}
				else
				{
					//$pd_applicant_detail['fk_pd_id'] = $pd_id;
					$co_applicant_id = $this->PD_Model->saveRecords($pd_applicant_detail,PDAPPLICANTSDETAILS);
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
	*delete single PD Document - delete form table entry and S3 obj
	*/
	public function deletePDDoc_post()
	{
		$pd_document_details = $this->post('pd_document_details');
		
		if(count($pd_document_details))
		{
		  //Select lender_id userin pdid
			$pdid = $pd_document_details[0]['fk_pd_id'];
			$fields = array('fk_lender_id');
			$where_condition_array = array('pd_id' => $pdid);
			$lender_id = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDTRIGGER);
			
			 $bucketname = LENDER_BUCKET_NAME_PREFIX.$lender_id[0]['fk_lender_id'];
			 $key = 'pd'.$pd_document_details[0]['fk_pd_id'].'/'.$pd_document_details[0]['pd_document_name'];
			 $this->aws_s3->deleteSingleObjFromBucket($bucketname,$key);
			 
			 //delete old entry
			 $modified = $this->db->where('pd_document_id',$pdid)->$this->db->delete(PDDOCUMENTS);
			 if($modified)
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
							$bucketname = LENDER_BUCKET_NAME_PREFIX.$lender_id[0]['fk_lender_id'];
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
						$bucketname = LENDER_BUCKET_NAME_PREFIX.$lender_id;
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
			$records['pd_status'] = ALLOCATED;
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
			//$id = $this->PD_Model->saveRecords($records,PDSCHEDULE);
			
				$where_condition_array = array('pd_id' => $records['fk_pd_id']);
				$temp_array = array('pd_status' => SCHEDULED,'fk_updatedby'=>$records['fk_scheduled_by'],'updatedon'=>$records['createdon'],'scheduled_on'=>$records['schedule_time']);
				$pd_id_modified = $this->PD_Model->updateRecords($temp_array,PDTRIGGER,$where_condition_array);
				
				/******* Code Snippt for Save Template Category Weightage info to PD category Info*/
				$fields = array('fk_pd_template_id');
				$where_condition_array = array('pd_id'=>$records['fk_pd_id']);
				$res_array = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDTRIGGER);
				
				if(count($res_array))
				{
							$fields = array('fk_pd_template_id');
							$where_condition_array = array('pd_id'=>$records['fk_pd_id']);
							$res_array = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDTRIGGER);
						
						if(count($res_array))
						{
							$template_id = $res_array[0]['fk_pd_template_id'];
							
							$fields = array('fk_question_category_id','weightage');
							$where_condition_array = array('fk_template_id'=>$template_id);
							$template_categories = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,TEMPLATECATEGORYWEIGHTAGE);
							
							foreach($template_categories as $key => $category)
							{
								$temp_data = array('fk_pd_id'=>$records['fk_pd_id'],'fk_category_id'=>$category['fk_question_category_id'],'pd_category_weightage'=>$category['weightage']);
								$this->PD_Model->saveRecords($temp_data,PDCATEGORYWEIGHTAGE);
							}
						}
				}
				/******* End of Code Snippt  Save Template Category Weightage info to PD category Info*/
				
				
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
	
	
	/*
	*GET List of PD officers for PD edit/view page for manual allocation
	*@param pd
	*/
	public function getListPDOfficers_post()
	{
		$pdid = $this->post('pdid');
		//1.Get LenderID and CityID  by using pdid
		$fields = array('fk_lender_id','fk_city','fk_pd_type','fk_product_id','fk_customer_segment');
		$where_condition_array = array('pd_id'=>$pdid);
		$res_array = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDTRIGGER);
		
		//2.Get Team ID based on Lender ID
		if(count($res_array))
		{
				$where_condition_array = array('lender_id' => $res_array[0]['fk_lender_id'],'city_id' =>$res_array[0]['fk_city'] ,'cs_id' =>$res_array[0]['fk_customer_segment'] ,'product_id' =>$res_array[0]['fk_product_id']);
				$temp_city_id = $this->PD_Model->selectRecords(PDTEAM_CTY_PRODUCT_CS_COMBINATIONS,$where_condition_array,$limit=0,$offset=0);
				//print_r($temp_city_id);die();
				if(count($temp_city_id))
				{
					if(isset($temp_city_id[0]['team_type']))
					{
						if($temp_city_id[0]['team_type'] == 0) // Allocate to Vendor
						{
							// $pd_details['pd_agency_id'] = $temp_city_id[0]['fk_team_id'];
							// $pd_details['fk_pd_allocated_to'] = ALLOCATED_TO_PARTNER;
							
						}
						else //Allocate to SineEdge Team with allocation logics
						{
							
										//select list of pd officers based on pd type, product, customer segment, and team from table (t_pd_officiers_details) and choose minimun allocated one and assign pd Officer and change status form TRIGGERED to ALLOCATED 
										$fields = array('fk_user_id','fk_pd_type_id','allocated','scheduled','inprogress');
										
										$where_condition_array = array('fk_team_id' => $temp_city_id[0]['pdteam_id'],'isactive' => 1);
										
										$list_of_pd_officers = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDOFFICIERSDETAILS);
												
										if(count($list_of_pd_officers))
										{
											foreach($list_of_pd_officers as $key => $pdofficer)
											{
												$this->db->SELECT('USERPROFILE.first_name,USERPROFILE.last_name');
												$this->db->FROM(USERPROFILE.' as USERPROFILE');
												$this->db->WHERE('USERPROFILE.userid',$pdofficer['fk_user_id']);
												$names = $this->db->GET()->result_array();
												if(count($names)){
												$list_of_pd_officers[$key]['first_name'] = $names[0]['first_name'];
												$list_of_pd_officers[$key]['last_name'] = $names[0]['last_name'];
												}
											}
											
											$data['dataStatus'] = true;
											$data['status'] = REST_Controller::HTTP_OK;
											$data['records'] = $list_of_pd_officers;
											$this->response($data,REST_Controller::HTTP_OK);
										}
										else
										{
											$data['dataStatus'] = false;
											$data['status'] = REST_Controller::HTTP_NO_CONTENT;
											$data['msg'] = 'Officers Records Not Found!';
											$this->response($data,REST_Controller::HTTP_OK);
										}
										
									
									
								
						}
					}
					else
					{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$data['msg'] = 'Team Records Not Found!';
					    $this->response($data,REST_Controller::HTTP_OK);
					}
				
			
									
				}
	}
			else
			{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$data['msg'] = 'Master Records Not Found!';
					    $this->response($data,REST_Controller::HTTP_OK);
			}
	}
	
	/*    PD_Triggerd and PD_Co_Applocants Details only for Listing Page
		@param page/offset
		@param limit
		@param sorting order(ASC/DESC)
		@param cid for category_id for filter question with category wise.
	*/
	public function listLessPDDetails_get()
	{
			$page = 0;$limit = 50;$sort = 'DESC';$pdofficerid = "";$datetype = "";$fdate ="";$tdate ="";
			$lenderid = "";
			if($this->get('page')) { $page  = $this->get('page'); }
			if($this->get('limit')){ $limit = $this->get('limit'); }
			if($this->get('sort')) { $sort  = $this->get('sort'); }
			if($this->get('pdofficerid')) { $pdofficerid  = $this->get('pdofficerid'); }
			if($this->get('lenderid')) { $lenderid  = $this->get('lenderid'); }
			if($this->get('datetype')) { $datetype = $this->get('datetype'); }
			if($this->get('fdate')) { $fdate = $this->get('fdate'); }
			if($this->get('tdate')) { $tdate = $this->get('tdate'); }
			
			$result_data = $this->PD_Model->listLessPDDetails($page,$limit,$sort,$pdofficerid,$datetype,$fdate,$tdate,$lenderid);
			
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
		//print_r($result_data['pd_logs']);die();
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
		
		if(!count($result_data['pd_logs']['master']) || !count($result_data['pd_logs']['child']))
		{
			$pd_logs_msg = 'PD Logs Not Found';
		}
		
			
			$data['dataStatus'] = true;
			$data['status'] = REST_Controller::HTTP_OK;
			$data['records'] = $result_data;
			$data['msg'] = array('applicant_msg'=>$applicant_msg,'pd_docs_msg'=>$pd_docs_msg,'pd_question_answer_msg'=>$pd_question_answer_msg,'pd_logs_msg'=>$pd_logs_msg);
			$this->response($data,REST_Controller::HTTP_OK);
		
		 
	}
	
	/********  for Load Whole PD Template for PD Screen @param template_id***************/
	public function loadFullTemplate_get()
	{
		$pd_id = "";
		if($this->get('pd_id')) { $pd_id = $this->get('pd_id'); }
		if($pd_id != "" || $pd_id != null)
		{
			
			$template_details = $this->PD_Model->getTemplateForPD($pd_id);
			 if(count($template_details))
			 {
				 $data['dataStatus'] = true;
				 $data['status'] = REST_Controller::HTTP_OK;
				 $data['records'] = $template_details;
				 $this->response($data,REST_Controller::HTTP_OK);
			 }
			 else
			 {
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$data['msg'] = 'Template Not for PD ID'.$pd_id;
				$this->response($data,REST_Controller::HTTP_OK); 
			 }
		}
		else
		{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_BAD_REQUEST;
				$data['msg'] = 'No Param Available';
				$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	/******** Save Multiple/Single PD qustions ********/
	public function saveActualPDQuestions_post()
	{
		//$records = json_decode($this->post('records'),true);
		$records = $this->post('records');
		$pd_detail_id = "";
		//print_r($records);
		foreach($records as $record_key => $record)
		{
			if($record['pd_detail_id'] != "" || $record['pd_detail_id'] != null)
			 {
				
				 if(isset($record['pd_answer_image']))
				{
					
					//Get Lender ID 
					$sql = 'SELECT fk_lender_id FROM '. PDTRIGGER .' WHERE pd_id ='.$record["fk_pd_id"];
					$lender_id = $this->db->query($sql)->result_array();
					
					//Get Old File name Delete Old FIle From S3
					$sql = 'SELECT pd_answer_image FROM '. PDDETAIL .' WHERE pd_detail_id ='.$record["pd_detail_id"];
					$old_image = $this->db->query($sql)->result_array();
					
					if(count($old_image))
								{
									 $bucketname = LENDER_BUCKET_NAME_PREFIX.$lender_id[0]['fk_lender_id'];
									 $key = 'pd'.$record['fk_pd_id'].'/'.$old_image[0]['pd_answer_image'];
									 $this->aws_s3->deleteSingleObjFromBucket($bucketname,$key);
								}
					
					
					$temp_base64_string = $record['pd_answer_image'];
					$title = $record['pd_anwer_image_title'];
					$output_file = APPPATH."/docs/temp_base64_image.png";
					
					//Generate Random File Name
						$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$charactersLength = strlen($characters);
						$randomString = '';
							for ($i = 0; $i < 5; $i++) {
								$randomString .= $characters[rand(0, $charactersLength - 1)];
							}
						$temp_file_name = $randomString.date('Y-m-d-H:m:s').'.png';
						
						
					$ifp = fopen( $output_file, 'wb' ); 
     				$temp_data = explode( ',', $temp_base64_string );
					fwrite( $ifp, base64_decode( $temp_data[ 1 ] ) );
     				fclose( $ifp ); 
				    $tempdoc = $output_file;
					$tempdocname = $temp_file_name;
					$bucketname = LENDER_BUCKET_NAME_PREFIX.$lender_id[0]['fk_lender_id'];
					$key = 'pd'.$record['fk_pd_id'].'/'.$tempdocname ;
					$sourcefile = $tempdoc;
					
					$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
					$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
					
					if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
					{
						$record['pd_answer_image'] = $tempdocname;
					}
				}
				
				$where_condition_array = array('pd_detail_id' => $record['pd_detail_id']);
				$pd_detail_id = $this->PD_Model->updateRecords($record,PDDETAIL,$where_condition_array);
				if($pd_detail_id != "" || $pd_detail_id != null)
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
							$data['msg'] = "Something Went Wrong..!Try Later";
							$this->response($data,REST_Controller::HTTP_OK);
					}
				
				
			 }
			 else
			 {
				 
				  if(isset($record['pd_answer_image']))
				{
					
					//Get Lender ID 
					$sql = 'SELECT fk_lender_id FROM '. PDTRIGGER .' WHERE pd_id ='.$record["fk_pd_id"];
					$lender_id = $this->db->query($sql)->result_array();
					
					$temp_base64_string = $record['pd_answer_image'];
					$title = $record['pd_anwer_image_title'];
					$output_file = APPPATH."/docs/temp_base64_image.png";
					
					//Generate Random File Name
						$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$charactersLength = strlen($characters);
						$randomString = '';
							for ($i = 0; $i < 5; $i++) {
								$randomString .= $characters[rand(0, $charactersLength - 1)];
							}
						$temp_file_name = $randomString.date('Y-m-d-H:m:s').'.png';
						
						
					$ifp = fopen( $output_file, 'wb' ); 
     				$temp_data = explode( ',', $temp_base64_string );
					fwrite( $ifp, base64_decode( $temp_data[ 1 ] ) );
     				fclose( $ifp ); 
				    $tempdoc = $output_file;
					$tempdocname = $temp_file_name;
					$bucketname = LENDER_BUCKET_NAME_PREFIX.$lender_id[0]['fk_lender_id'];
					$key = 'pd'.$record['fk_pd_id'].'/'.$tempdocname ;
					$sourcefile = $tempdoc;
					
					$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
					$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
					
					if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
					{
						$record['pd_answer_image'] = $tempdocname;
					}
				}
				
				$pd_detail_id = $this->PD_Model->saveRecords($record,PDDETAIL);
				if($pd_detail_id != "" || $pd_detail_id != null)
					{
						
							$data['dataStatus'] = true;
							$data['status'] = REST_Controller::HTTP_OK;
							$data['records'] = $pd_detail_id;
							$this->response($data,REST_Controller::HTTP_OK);
					}
					else
					{
							$data['dataStatus'] = false;
							$data['status'] = REST_Controller::HTTP_NO_CONTENT;
							$data['msg'] = "Something Went Wrong..!Try Later";
							$this->response($data,REST_Controller::HTTP_OK);
					}
			 }
			 
			 
						 
		}
	
		
		
		
		
	}
	
	/************** Get Answers for PD @params question_id, pd_id, template_id, category_id**************/
	public function getAnswersForPD_post()
	{
			$question_id = $this->post('question_id');
			$pd_id = $this->post('pd_id');
			$template_id = $this->post('template_id');
			$category_id = $this->post('category_id');
			
			$answers = $this->PD_Model->getAnswersForPD($question_id,$pd_id,$template_id,$category_id);
			
			if(count($answers))
					{
						
							$data['dataStatus'] = true;
							$data['status'] = REST_Controller::HTTP_OK;
							$data['records'] = $answers;
							$this->response($data,REST_Controller::HTTP_OK);
					}
					else
					{
							$data['dataStatus'] = false;
							$data['status'] = REST_Controller::HTTP_NO_CONTENT;
							$data['msg'] = "Something Went Wrong..!Try Later";
							$this->response($data,REST_Controller::HTTP_OK);
					}
			
	}
	
	
	
}