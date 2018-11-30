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
		$this->load->helper('GETPDFORMDETAILS');
        
    }
    
	
	public function base_get()
	{
					$base64_img = "data:image/gif;base64,R0lGODlhPQBEAPeoAJosM//AwO/AwHVYZ/z595kzAP/s7P+goOXMv8+fhw/v739/f+8PD98fH/8mJl+fn/9ZWb8/PzWlwv///6wWGbImAPgTEMImIN9gUFCEm/gDALULDN8PAD6atYdCTX9gUNKlj8wZAKUsAOzZz+UMAOsJAP/Z2ccMDA8PD/95eX5NWvsJCOVNQPtfX/8zM8+QePLl38MGBr8JCP+zs9myn/8GBqwpAP/GxgwJCPny78lzYLgjAJ8vAP9fX/+MjMUcAN8zM/9wcM8ZGcATEL+QePdZWf/29uc/P9cmJu9MTDImIN+/r7+/vz8/P8VNQGNugV8AAF9fX8swMNgTAFlDOICAgPNSUnNWSMQ5MBAQEJE3QPIGAM9AQMqGcG9vb6MhJsEdGM8vLx8fH98AANIWAMuQeL8fABkTEPPQ0OM5OSYdGFl5jo+Pj/+pqcsTE78wMFNGQLYmID4dGPvd3UBAQJmTkP+8vH9QUK+vr8ZWSHpzcJMmILdwcLOGcHRQUHxwcK9PT9DQ0O/v70w5MLypoG8wKOuwsP/g4P/Q0IcwKEswKMl8aJ9fX2xjdOtGRs/Pz+Dg4GImIP8gIH0sKEAwKKmTiKZ8aB/f39Wsl+LFt8dgUE9PT5x5aHBwcP+AgP+WltdgYMyZfyywz78AAAAAAAD///8AAP9mZv///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAKgALAAAAAA9AEQAAAj/AFEJHEiwoMGDCBMqXMiwocAbBww4nEhxoYkUpzJGrMixogkfGUNqlNixJEIDB0SqHGmyJSojM1bKZOmyop0gM3Oe2liTISKMOoPy7GnwY9CjIYcSRYm0aVKSLmE6nfq05QycVLPuhDrxBlCtYJUqNAq2bNWEBj6ZXRuyxZyDRtqwnXvkhACDV+euTeJm1Ki7A73qNWtFiF+/gA95Gly2CJLDhwEHMOUAAuOpLYDEgBxZ4GRTlC1fDnpkM+fOqD6DDj1aZpITp0dtGCDhr+fVuCu3zlg49ijaokTZTo27uG7Gjn2P+hI8+PDPERoUB318bWbfAJ5sUNFcuGRTYUqV/3ogfXp1rWlMc6awJjiAAd2fm4ogXjz56aypOoIde4OE5u/F9x199dlXnnGiHZWEYbGpsAEA3QXYnHwEFliKAgswgJ8LPeiUXGwedCAKABACCN+EA1pYIIYaFlcDhytd51sGAJbo3onOpajiihlO92KHGaUXGwWjUBChjSPiWJuOO/LYIm4v1tXfE6J4gCSJEZ7YgRYUNrkji9P55sF/ogxw5ZkSqIDaZBV6aSGYq/lGZplndkckZ98xoICbTcIJGQAZcNmdmUc210hs35nCyJ58fgmIKX5RQGOZowxaZwYA+JaoKQwswGijBV4C6SiTUmpphMspJx9unX4KaimjDv9aaXOEBteBqmuuxgEHoLX6Kqx+yXqqBANsgCtit4FWQAEkrNbpq7HSOmtwag5w57GrmlJBASEU18ADjUYb3ADTinIttsgSB1oJFfA63bduimuqKB1keqwUhoCSK374wbujvOSu4QG6UvxBRydcpKsav++Ca6G8A6Pr1x2kVMyHwsVxUALDq/krnrhPSOzXG1lUTIoffqGR7Goi2MAxbv6O2kEG56I7CSlRsEFKFVyovDJoIRTg7sugNRDGqCJzJgcKE0ywc0ELm6KBCCJo8DIPFeCWNGcyqNFE06ToAfV0HBRgxsvLThHn1oddQMrXj5DyAQgjEHSAJMWZwS3HPxT/QMbabI/iBCliMLEJKX2EEkomBAUCxRi42VDADxyTYDVogV+wSChqmKxEKCDAYFDFj4OmwbY7bDGdBhtrnTQYOigeChUmc1K3QTnAUfEgGFgAWt88hKA6aCRIXhxnQ1yg3BCayK44EWdkUQcBByEQChFXfCB776aQsG0BIlQgQgE8qO26X1h8cEUep8ngRBnOy74E9QgRgEAC8SvOfQkh7FDBDmS43PmGoIiKUUEGkMEC/PJHgxw0xH74yx/3XnaYRJgMB8obxQW6kL9QYEJ0FIFgByfIL7/IQAlvQwEpnAC7DtLNJCKUoO/w45c44GwCXiAFB/OXAATQryUxdN4LfFiwgjCNYg+kYMIEFkCKDs6PKAIJouyGWMS1FSKJOMRB/BoIxYJIUXFUxNwoIkEKPAgCBZSQHQ1A2EWDfDEUVLyADj5AChSIQW6gu10bE/JG2VnCZGfo4R4d0sdQoBAHhPjhIB94v/wRoRKQWGRHgrhGSQJxCS+0pCZbEhAAOw==";
					
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
			 
			 $where_condition_array = array('fk_lender_id'=>$pd_details['fk_lender_id'] ,'fk_product_id'=> $pd_details['fk_product_id'],'fk_customer_segment'=> $pd_details['fk_customer_segment'],'isactive' => 1);
			 
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
		if($pd_details['pd_status'] == INITIATED)
		{
			$msg = "Dear ".$pd_details['firstName'].", Officer ".$pd_details['officerName']." is on his way to meet you for a personal discussion with regards to your loan application. You can track his realtime location in this link.http://maps.google.com/?q=".$pd_details['link'];
			 $no = (string)$pd_details['mobile_no'];
			unset($pd_details['mobile_no']);
			unset($pd_details['firstName']);
			unset($pd_details['officerName']);
			unset($pd_details['link']);
			$this->aws_sns->sendSMS($msg,$no);
			
		}
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
		
		
		if($pd_details['pd_status'] == TRIGGERED)
		{
			// Template Re assign Functionality
			
			$fields = array('fk_lender_id','fk_product_id','fk_customer_segment','pd_status');
			$where_condition_array = array('pd_id'=>$pd_details['pd_id']);
			$res_array = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDTRIGGER);
			
			/***********************CHOOSE PD TEMPALATE*********************/
			
			if(count($res_array))
			{
					
					if($res_array[0]['pd_status'] == TRIGGERED || $res_array[0]['pd_status'] == DRAFT)
						{
							$fields = array('fk_template_id');
						 
						 $where_condition_array = array('fk_lender_id'=>$res_array[0]['fk_lender_id'] ,'fk_product_id'=> $res_array[0]['fk_product_id'],'fk_customer_segment'=> $res_array[0]['fk_customer_segment'],'isactive' => 1);
						 
						 $table = LENDERTEMPLATE;
						 
						 $choosed_template_id = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,$table);
						 
						 if(count($choosed_template_id))
						 { 
							$pd_details['fk_pd_template_id'] = $choosed_template_id[0]['fk_template_id']; 
						 }
					}
					else
					{
						unset($pd_details['pd_status']);
					}
			}
					
		}
		
			$where_condition_array = array('pd_id' => $pd_details['pd_id']);
			$pd_id_modified = $this->PD_Model->updateRecords($pd_details,PDTRIGGER,$where_condition_array);
			
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
		 
			$pdotpStatus = $this->PD_Model->checkotp($pdotp);
			$updatePd['pd_id'] = $pdotp['pd_id'];
			$updatePd['pd_status'] = INPROGRESS;
			$updatePd['fk_updatedby'] = $pdotp['pd_id'];
			$updatePd['updatedon'] = date('Y-m-d h:m:00');
			
			if($pdotpStatus != 0 || $pdotpStatus != '' &&  count($pdotpStatus) != 0)
			{	
			$where_condition_array = array('pd_id' => $pdotp['pd_id']);
			$pd_id_modified = $this->PD_Model->updateRecords($updatePd,PDTRIGGER,$where_condition_array);
						 
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
		
		//if($records['fk_pd_allocated_to'] != "" || $records['fk_pd_allocated_to'] != null)
		//{
			$records['pd_status'] = ALLOCATED;
		//}
		$where_condition_array = array('pd_id' => $records['pd_id']);
		$pd_id_modified = $this->PD_Model->updateRecords($records,PDTRIGGER,$where_condition_array);
		
		// $where_condition_array = array('fk_user_id' => $records['fk_pd_allocated_to']);
		// $temp_array = array('');
		// $pd_id_modified = $this->PD_Model->updateRecords($records,PDTRIGGER,$where_condition_array);
		
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
				$temp_array = array('pd_status' => SCHEDULED,'fk_updatedby'=>$records['fk_scheduled_by'],'updatedon'=>date('Y-m-d H:m:i'),'scheduled_on'=>$records['schedule_time']);
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
		//print_r($res_array);
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
										$fields = array('fk_user_id','fk_pd_type_id');
										
										$where_condition_array = array('fk_team_id' => $temp_city_id[0]['pdteam_id'],'isactive' => 1);
										
										$list_of_pd_officers = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDOFFICIERSDETAILS);
												
										if(count($list_of_pd_officers))
										{
											foreach($list_of_pd_officers as $key => $pdofficer)
											{
												$this->db->SELECT('USERPROFILE.first_name,USERPROFILE.last_name,USERPROFILE.profilepic,USERPROFILE.mobile_no');
												$this->db->FROM(USERPROFILE.' as USERPROFILE');
												$this->db->WHERE('USERPROFILE.userid',$pdofficer['fk_user_id']);
												$names = $this->db->GET()->result_array();
												if(count($names)){
													
												
												$list_of_pd_officers[$key]['first_name'] = $names[0]['first_name'];
												$list_of_pd_officers[$key]['last_name'] = $names[0]['last_name'];
												$list_of_pd_officers[$key]['mobile_no'] = $names[0]['mobile_no'];
												$list_of_pd_officers[$key]['count'] = 0;
												
												$this->db->SELECT('pd_id,pd_status,fk_pd_type,DATE_FORMAT(PDTRIGGER.scheduled_on,"%d/%m/%Y %H:%i:%s %p") as scheduled_on,PDAPPLICANTSDETAILS.applicant_name,PDTYPE.type_name as pd_type_name,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode');
												$this->db->FROM(PDTRIGGER.' as PDTRIGGER');
												$this->db->JOIN(PDAPPLICANTSDETAILS.' as PDAPPLICANTSDETAILS','PDTRIGGER.pd_id = PDAPPLICANTSDETAILS.fk_pd_id AND PDAPPLICANTSDETAILS.applicant_type = 1');
												$this->db->JOIN(PDTYPE.' as PDTYPE','PDTRIGGER.fk_pd_type = PDTYPE.pd_type_id AND PDTYPE.isactive = 1');
												$this->db->JOIN(STATE.' as STATE','PDTRIGGER.fk_state = STATE.state_id ','LEFT');
												$this->db->JOIN(CITY.' as CITY','PDTRIGGER.fk_city = CITY.city_id','LEFT');
												
												$this->db->OR_GROUP_START();
												$this->db->OR_WHERE('PDTRIGGER.pd_status',SCHEDULED);
												$this->db->OR_WHERE('PDTRIGGER.pd_status',INPROGRESS);
												$this->db->OR_WHERE('PDTRIGGER.pd_status',ALLOCATED);
												$this->db->GROUP_END();
												if($pdofficer['fk_pd_type_id'] == 1)
												{
													$this->db->WHERE('PDTRIGGER.fk_pd_allocated_to',$pdofficer['fk_user_id']);
												}
												else
												{
													$this->db->WHERE('PDTRIGGER.executive_id',$pdofficer['fk_user_id']);
												}
												$pd_count = $this->db->GET()->result_array();
												//print_r($this->db->last_query());
												if(count($pd_count)){ 
												$list_of_pd_officers[$key]['pd_details'] = $pd_count;
												$list_of_pd_officers[$key]['count'] =count($pd_count); }
												
												// Get Profile Pic from S3
												
												$bucket_name = PROFILE_PICTURE_BUCKET_NAME;
												$profilepics3path = 'sineedge/'.$names[0]['profilepic'];
												$singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI($bucket_name,$profilepics3path,'+10 minutes');
												$list_of_pd_officers[$key]['profile_url'] = $singed_uri;
												}
											}
											// Get Central PD Officers List
											$central_pd_officers = array();
											if($res_array[0]['fk_pd_type'] == 2 || $res_array[0]['fk_pd_type'] == 3)
											{
												$this->db->SELECT('USERPROFILE.userid as fk_user_id,USERPROFILE.first_name,USERPROFILE.last_name,USERPROFILE.profilepic,USERPROFILE.mobile_no,USERPROFILEROLES.user_role,ROLES.role_name');
												$this->db->FROM(USERPROFILE.' as USERPROFILE');
												$this->db->JOIN(USERPROFILEROLES.' as USERPROFILEROLES','USERPROFILE.userid = USERPROFILEROLES.fk_userid');
												$this->db->JOIN(ROLES.' as ROLES','USERPROFILEROLES.user_role = ROLES.role_id');
												$this->db->WHERE('ROLES.role_id',2);
												$central_pd_officers = $this->db->GET()->result_array();
												//print_r($central_pd_officers);
											if(count($central_pd_officers))
												{
														foreach($central_pd_officers as $k => $central_pd_officer)
														{
															
															//Get PD Details assigned to Central Officers
																	$this->db->SELECT('pd_id,pd_status,fk_pd_type,DATE_FORMAT(PDTRIGGER.scheduled_on,"%d/%m/%Y %H:%i:%s %p") as scheduled_on,PDAPPLICANTSDETAILS.applicant_name,PDTYPE.type_name as pd_type_name,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode');
														$this->db->FROM(PDTRIGGER.' as PDTRIGGER');
														$this->db->JOIN(PDAPPLICANTSDETAILS.' as PDAPPLICANTSDETAILS','PDTRIGGER.pd_id = PDAPPLICANTSDETAILS.fk_pd_id AND PDAPPLICANTSDETAILS.applicant_type = 1');
														$this->db->JOIN(PDTYPE.' as PDTYPE','PDTRIGGER.fk_pd_type = PDTYPE.pd_type_id AND PDTYPE.isactive = 1');
														$this->db->JOIN(STATE.' as STATE','PDTRIGGER.fk_state = STATE.state_id ','LEFT');
														$this->db->JOIN(CITY.' as CITY','PDTRIGGER.fk_city = CITY.city_id','LEFT');
														
														$this->db->OR_GROUP_START();
														$this->db->OR_WHERE('PDTRIGGER.pd_status',SCHEDULED);
														$this->db->OR_WHERE('PDTRIGGER.pd_status',INPROGRESS);
														$this->db->OR_WHERE('PDTRIGGER.pd_status',ALLOCATED);
														$this->db->GROUP_END();
														$this->db->WHERE('PDTRIGGER.central_pd_officer_id',$central_pd_officer['fk_user_id']);
														$pd_count = $this->db->GET()->result_array();
														//print_r($this->db->last_query());
														$central_pd_officers[$k]['count'] = 0;
														if(count($pd_count)){ 
														$central_pd_officers[$k]['pd_details'] = $pd_count;
														$central_pd_officers[$k]['count'] = count($pd_count); }
															//End Get PD Details assigned to Central Officers
															
															
															$bucket_name = PROFILE_PICTURE_BUCKET_NAME;
															$profilepics3path = 'sineedge/'.$central_pd_officer['profilepic'];
															$singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI($bucket_name,$profilepics3path,'+10 minutes');
															$central_pd_officers[$k]['profile_url'] = $singed_uri;
														}
												}
											}
											
											$data['dataStatus'] = true;
											$data['status'] = REST_Controller::HTTP_OK;
											$data['records'] = array('pdofficers' => $list_of_pd_officers,'centralpdofficers' => $central_pd_officers);
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
					else // Find Officers in General Team 
					{
						
						
										
										//Find General Team ID
										$fields = array('pdteam_id');
										$where_condition_array = array('team_name' => "General");
										$general_team_id = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDTEAM);
										
										if(count($general_team_id))
										{
											
										
										$fields = array('fk_user_id','fk_pd_type_id');
										$where_condition_array = array('fk_team_id' => $general_team_id[0]['pdteam_id'],'isactive' => 1);
										$list_of_pd_officers = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDOFFICIERSDETAILS);
												
										if(count($list_of_pd_officers))
										{
											foreach($list_of_pd_officers as $key => $pdofficer)
											{
												$this->db->SELECT('USERPROFILE.first_name,USERPROFILE.last_name,USERPROFILE.profilepic,USERPROFILE.mobile_no');
												$this->db->FROM(USERPROFILE.' as USERPROFILE');
												$this->db->WHERE('USERPROFILE.userid',$pdofficer['fk_user_id']);
												$names = $this->db->GET()->result_array();
												
												
												if(count($names)){
												$list_of_pd_officers[$key]['first_name'] = $names[0]['first_name'];
												$list_of_pd_officers[$key]['last_name'] = $names[0]['last_name'];
												$list_of_pd_officers[$key]['mobile_no'] = $names[0]['mobile_no'];
												$list_of_pd_officers[$key]['count'] = 0;
												
												$this->db->SELECT('pd_id,pd_status,fk_pd_type,DATE_FORMAT(PDTRIGGER.scheduled_on,"%d/%m/%Y %H:%i:%s %p") as scheduled_on,PDAPPLICANTSDETAILS.applicant_name,PDTYPE.type_name as pd_type_name,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode');
												$this->db->FROM(PDTRIGGER.' as PDTRIGGER');
												$this->db->JOIN(PDAPPLICANTSDETAILS.' as PDAPPLICANTSDETAILS','PDTRIGGER.pd_id = PDAPPLICANTSDETAILS.fk_pd_id AND PDAPPLICANTSDETAILS.applicant_type = 1');
												$this->db->JOIN(PDTYPE.' as PDTYPE','PDTRIGGER.fk_pd_type = PDTYPE.pd_type_id AND PDTYPE.isactive = 1');
												$this->db->JOIN(STATE.' as STATE','PDTRIGGER.fk_state = STATE.state_id ','LEFT');
												$this->db->JOIN(CITY.' as CITY','PDTRIGGER.fk_city = CITY.city_id','LEFT');
												$this->db->OR_GROUP_START();
												$this->db->OR_WHERE('PDTRIGGER.pd_status',SCHEDULED);
												$this->db->OR_WHERE('PDTRIGGER.pd_status',INPROGRESS);
												$this->db->OR_WHERE('PDTRIGGER.pd_status',ALLOCATED);
												$this->db->GROUP_END();
												if($pdofficer['fk_pd_type_id'] == 1)
												{
													$this->db->WHERE('PDTRIGGER.fk_pd_allocated_to',$pdofficer['fk_user_id']);
												}
												else
												{
													$this->db->WHERE('PDTRIGGER.executive_id',$pdofficer['fk_user_id']);
												}
												$pd_count = $this->db->GET()->result_array();
												//print_r($this->db->last_query());
												if(count($pd_count)){ 
												$list_of_pd_officers[$key]['pd_details'] = $pd_count;
												$list_of_pd_officers[$key]['count'] =count($pd_count);
												}
												
												// Get Profile Pic from S3
												
												$bucket_name = PROFILE_PICTURE_BUCKET_NAME;
												$profilepics3path = 'sineedge/'.$names[0]['profilepic'];
												$singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI($bucket_name,$profilepics3path,'+10 minutes');
												$list_of_pd_officers[$key]['profile_url'] = $singed_uri;
												
												
												}
											}
											
											// Get Central PD Officers List
											$central_pd_officers = array();
											if($res_array[0]['fk_pd_type'] == 2 || $res_array[0]['fk_pd_type'] == 3)
											{
												$this->db->SELECT('USERPROFILE.userid as fk_user_id,USERPROFILE.first_name,USERPROFILE.last_name,USERPROFILE.profilepic,USERPROFILE.mobile_no,USERPROFILEROLES.user_role,ROLES.role_name');
												$this->db->FROM(USERPROFILE.' as USERPROFILE');
												$this->db->JOIN(USERPROFILEROLES.' as USERPROFILEROLES','USERPROFILE.userid = USERPROFILEROLES.fk_userid');
												$this->db->JOIN(ROLES.' as ROLES','USERPROFILEROLES.user_role = ROLES.role_id');
												$this->db->WHERE('ROLES.role_id',2);
												$central_pd_officers = $this->db->GET()->result_array();
												
											if(count($central_pd_officers))
												{
														foreach($central_pd_officers as $k => $central_pd_officer)
														{
															
															
															//Get PD Details assigned to Central Officers
																	$this->db->SELECT('pd_id,pd_status,fk_pd_type,DATE_FORMAT(PDTRIGGER.scheduled_on,"%d/%m/%Y %H:%i:%s %p") as scheduled_on,PDAPPLICANTSDETAILS.applicant_name,PDTYPE.type_name as pd_type_name,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode');
														$this->db->FROM(PDTRIGGER.' as PDTRIGGER');
														$this->db->JOIN(PDAPPLICANTSDETAILS.' as PDAPPLICANTSDETAILS','PDTRIGGER.pd_id = PDAPPLICANTSDETAILS.fk_pd_id AND PDAPPLICANTSDETAILS.applicant_type = 1');
														$this->db->JOIN(PDTYPE.' as PDTYPE','PDTRIGGER.fk_pd_type = PDTYPE.pd_type_id AND PDTYPE.isactive = 1');
														$this->db->JOIN(STATE.' as STATE','PDTRIGGER.fk_state = STATE.state_id ','LEFT');
														$this->db->JOIN(CITY.' as CITY','PDTRIGGER.fk_city = CITY.city_id','LEFT');
														
														$this->db->OR_GROUP_START();
														$this->db->OR_WHERE('PDTRIGGER.pd_status',SCHEDULED);
														$this->db->OR_WHERE('PDTRIGGER.pd_status',INPROGRESS);
														$this->db->OR_WHERE('PDTRIGGER.pd_status',ALLOCATED);
														$this->db->GROUP_END();
														$this->db->WHERE('PDTRIGGER.central_pd_officer_id',$central_pd_officer['fk_user_id']);
														$pd_count = $this->db->GET()->result_array();
														//print_r($this->db->last_query());
														$central_pd_officers[$k]['count'] = 0;
														if(count($pd_count)){ 
														$central_pd_officers[$k]['pd_details'] = $pd_count;
														$central_pd_officers[$k]['count'] = count($pd_count); }
															//End Get PD Details assigned to Central Officers
															
															
															$bucket_name = PROFILE_PICTURE_BUCKET_NAME;
															$profilepics3path = 'sineedge/'.$central_pd_officer['profilepic'];
															$singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI($bucket_name,$profilepics3path,'+10 minutes');
															$central_pd_officers[$k]['profile_url'] = $singed_uri;
														}
												}
											}
											$data['dataStatus'] = true;
											$data['status'] = REST_Controller::HTTP_OK;
											$data['records'] = array('pdofficers' => $list_of_pd_officers,'centralpdofficers' => $central_pd_officers);
											$this->response($data,REST_Controller::HTTP_OK);
										}
										else
										{
											$data['dataStatus'] = false;
											$data['status'] = REST_Controller::HTTP_NO_CONTENT;
											$data['msg'] = 'Officers Records Not Found in General Team!';
											$this->response($data,REST_Controller::HTTP_OK);
										}
						}
						else
						{
											$data['dataStatus'] = false;
											$data['status'] = REST_Controller::HTTP_NO_CONTENT;
											$data['msg'] = 'General Team Not Found';
											$this->response($data,REST_Controller::HTTP_OK);
						}
					}
				
			
									
				}
	}
			else
			{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$data['msg'] = 'PD Master Records Not Found!';
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
			$page = 0;$limit = 100;$sort = 'DESC';$pdofficerid = "";$datetype = "";$fdate ="";$tdate ="";
			$lenderid = "";$status="";
			if($this->get('page')) { $page  = $this->get('page'); }
			if($this->get('limit')){ $limit = $this->get('limit'); }
			if($this->get('sort')) { $sort  = $this->get('sort'); }
			if($this->get('pdofficerid')) { $pdofficerid  = $this->get('pdofficerid'); }
			if($this->get('lenderid')) { $lenderid  = $this->get('lenderid'); }
			if($this->get('datetype')) { $datetype = $this->get('datetype'); }
			if($this->get('fdate')) { $fdate = $this->get('fdate'); }
			if($this->get('tdate')) { $tdate = $this->get('tdate'); }
			if($this->get('status')) { $status = $this->get('status'); }
			
			$result_data = $this->PD_Model->listLessPDDetails($page,$limit,$sort,$pdofficerid,$datetype,$fdate,$tdate,$lenderid,$status);
			
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
		$client = "";
		if($this->get('pd_id')) { $pd_id = $this->get('pd_id'); }
		if($this->get('client')) { $client = $this->get('client'); }
		if($pd_id != "" || $pd_id != null)
		{
			
			$template_details = $this->PD_Model->getTemplateForPD($pd_id,$client);
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
		//echo "hi";
		$records = $this->post('records');
		$pd_detail_id = "";
		$pd_detail_answer_id = "";
		$image_count = "";
		$answer_count = "";
		$images_array = array();
		$answers_array = array();
		
		foreach($records as $record_key => $record)
		{ 
			
			if($record['pd_detail_id'] != "" || $record['pd_detail_id'] != null)
			 {
				 
				 if($record['answers'] != "" || $record['answers'] != null)
				 {
					$answers_array = $record['answers'];
					unset($record['answers']);
				 }
				 
				 if($record['images'] != "" || $record['images'] != null)
				 {
					$images_array = $record['images'];
					unset($record['images']);
				 }
				 
				$where_condition_array = array('pd_detail_id' => $record['pd_detail_id']);
				$pd_detail_id = $this->PD_Model->updateRecords($record,PDDETAIL,$where_condition_array);
				
				// ANSWERS SAVE - pd_detail_answer_id, fk_pd_id, fk_pd_detail_id, pd_answer_id, pd_answer, pd_answer_weightage, pd_answer_remark
				if(count($answers_array))
				{
					
					
								//Deactivate Old Answers
								$fields = array('pd_detail_answer_id');
								$where_condition_array = array('fk_pd_id' => $record['fk_pd_id'],'fk_pd_detail_id' => $record['pd_detail_id']);
								$old_answers = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDANSWER);
								foreach($old_answers as $old)
								{
									$where_condition_array = array('pd_detail_answer_id'=>$old['pd_detail_answer_id']);
									$temp_array = array('isactive' => 0);
									$pd_detail_answer_id = $this->PD_Model->updateRecords($temp_array,PDANSWER,$where_condition_array);
								}
								
						foreach($answers_array as $answer_key => $answer)
						{
							if($answer['pd_detail_answer_id'] == "" || $answer['pd_detail_answer_id'] == null)
							{
								
								//INsert New Answers
								$answer['fk_pd_detail_id'] = $record['pd_detail_id'];
								$pd_detail_answer_id = $this->PD_Model->saveRecords($answer,PDANSWER);
								if($pd_detail_answer_id != "" || $pd_detail_answer_id != null){ $answer_count++; }
								
							}
							else
							{
								// Update Current Answer
								$where_condition_array = array('pd_detail_answer_id'=>$answer['pd_detail_answer_id']);
								$answer['isactive'] = 1;
								$pd_detail_answer_id = $this->PD_Model->updateRecords($answer,PDANSWER,$where_condition_array);
								if($pd_detail_answer_id != "" || $pd_detail_answer_id != null){ $answer_count++; }
							}
							
						}
			}
				
				//IMAGES SAVE - pd_document_id, fk_pd_id, fk_pd_detail_id, pd_document_title, pd_document_name, createdon, fk_createdby, updatedon, fk_updatedby
		if(count($images_array))
				{
					foreach($images_array as $image_key => $image)
					{
								
								
								//Get Lender ID 
								$sql = 'SELECT fk_lender_id FROM '. PDTRIGGER .' WHERE pd_id ='.$record["fk_pd_id"];
								$lender_id = $this->db->query($sql)->result_array();
								
								$temp_base64_string = $image['pd_document_name'];
								$title = $image['pd_document_title'];
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
									$image['pd_document_name'] = $tempdocname;
									$image['fk_pd_detail_id'] = $record['pd_detail_id'];
									$image['fk_pd_id'] = $record['fk_pd_id'];
									$pd_document_id = $this->PD_Model->saveRecords($image,PDDOCUMENTS);
									if($pd_document_id != "" || $pd_document_id != null){ $image_count++; }
									
								}
							
					}
				}
				
				if(($pd_detail_id != "" || $pd_detail_id != null) && count($images_array) == $image_count && count($answers_array) == $answer_count)
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
				 
				
				 
				 if($record['answers'] != "" || $record['answers'] != null)
				 {
					$answers_array = $record['answers'];
					unset($record['answers']);
				 }
				 
				 if($record['images'] != "" || $record['images'] != null)
				 {
					$images_array = $record['images'];
					unset($record['images']);
				 }
				 //print_r($record);die();
				$pd_detail_id = $this->PD_Model->saveRecords($record,PDDETAIL);
				
				// ANSWERS SAVE - pd_detail_answer_id, fk_pd_id, fk_pd_detail_id, pd_answer_id, pd_answer, pd_answer_weightage, pd_answer_remark
				if(count($answers_array))
				{
					foreach($answers_array as $answer_key => $answer)
					{
						$answer['fk_pd_detail_id'] = $pd_detail_id;
						$pd_detail_answer_id = $this->PD_Model->saveRecords($answer,PDANSWER);
						if($pd_detail_answer_id != "" || $pd_detail_answer_id != null){ $answer_count++; }
					}
				}
				
				//IMAGES SAVE - pd_document_id, fk_pd_id, fk_pd_detail_id, pd_document_title, pd_document_name, createdon, fk_createdby, updatedon, fk_updatedby
				if(count($images_array))
				{
					foreach($images_array as $image_key => $image)
					{
								
								
								//Get Lender ID 
								$sql = 'SELECT fk_lender_id FROM '. PDTRIGGER .' WHERE pd_id ='.$record["fk_pd_id"];
								$lender_id = $this->db->query($sql)->result_array();
								
								$temp_base64_string = $image['pd_document_name'];
								$title = $image['pd_document_title'];
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
									$image['pd_document_name'] = $tempdocname;
									
									$image['fk_pd_detail_id'] = $record['pd_detail_id'];
									$image['fk_pd_id'] = $record['fk_pd_id'];
									$pd_document_id = $this->PD_Model->saveRecords($image,PDDOCUMENTS);
									if($pd_document_id != "" || $pd_document_id != null){ $image_count++; }
									
								}
							
					}
				}
				
				if(($pd_detail_id != "" || $pd_detail_id != null) && count($images_array) == $image_count && count($answers_array) == $answer_count)
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
	
	
	/********* Get Form Informations @param pd_id and pd_form_id ******/
	public function getPDFormDetails_post()
	{
		$pd_id = $this->post('pd_id');
		$pd_form_id = $this->post('pd_form_id');
		
		//Get Pd masters etails usng PD ID
		$pd_details = $this->PD_Model->getPDMasterDetails($pd_id);
		
		$result_array = $this->PD_Model->getPDFormDetails($pd_id,$pd_form_id);
		
		// *****************************Get Docs from bucket 
		 // Get Alredy stored Images
							$fields = array('pd_document_title', 'pd_document_name');
							 $where_condition_array = array('fk_pd_id' => $pd_id,'fk_form_id' => $pd_form_id);
							 
							 $pd_docs = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDDOCUMENTS);
							 
							  if(count($pd_docs))
							 {
								 $bucket_name = LENDER_BUCKET_NAME_PREFIX.$pd_details[0]['fk_lender_id'];
								 foreach($pd_docs as $doc_key => $doc)
								 {
									 if($doc['pd_document_name'] != "" || $doc['pd_document_name'] != null)
									 {
										 $profilepics3path = 'pd'.$pd_details[0]['pd_id'].'/'.$doc['pd_document_name'];
										 $singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI($bucket_name,$profilepics3path,'+30 minutes');
										 $pd_docs[$doc_key]['pd_document_name'] = $singed_uri;
									 }
								 }
							 }
								
							 
		// *************************End Get Docs from bucket 
		
		$final_array = GETPDFORMDETAILS::getPDFormDetailsStructured($result_array,$pd_id,$pd_form_id);
		
		if($result_array)
		{
							$data['dataStatus'] = true;
							$data['status'] = REST_Controller::HTTP_OK;
							$data['records'] = $final_array;
							$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
							$data['dataStatus'] = false;
							$data['status'] = REST_Controller::HTTP_NO_CONTENT;
							$data['msg'] = "Details Not Available!";
							$this->response($data,REST_Controller::HTTP_OK);
		}
		
	}
	
	
	/********* Save Form Informations @param pd_id and pd_form_id ******/
	public function savePDFormDetails_post()
	{
		$records = $this->post('records');
		
		$pd_id = $records['pdid'];
		
		//Get Pd masters etails usng PD ID
		$pd_details = $this->PD_Model->getPDMasterDetails($pd_id);
		
		
		$pd_form_id = $records['formid'];
		$fk_createdby = $records['fk_createdby'];
		$i = 0;
		$base64images = array();
		//seperate base64 images from records array
		 if(array_key_exists('base64images',$records))	
		 {
			 $base64images = $records['base64images'];
		 }
		//Deactivate Old rec
			$where_condition_array = array('fk_pd_id' => $pd_id,"fk_form_id"=>$pd_form_id);
			$array = array('isactive'=>0);
			$pd_id_modified = $this->PD_Model->updateRecords($array,PDFORMDETAILS,$where_condition_array);
			
		foreach($records as $rec_key => $record)
		{
			$i++;
			
				if($rec_key !='pdid' && $rec_key != 'formid' && $rec_key != 'fk_createdby')
				{
					
					if(!is_array($record))//check key and value pair is not an array
					{
						$temp_array = array('fk_pd_id'=>$pd_id,'fk_form_id'=>$pd_form_id,'column_name'=>$rec_key,'column_value'=>$record,'fk_createdby'=>$fk_createdby);
						$id = $this->PD_Model->saveRecords($temp_array,PDFORMDETAILS);
					}
					else // array of key value pairs
					{
						$iter=0;
						foreach($record as $mkey => $rec)
						{
							//print_r($rec);
							$iter++;
							if(!is_array($rec))
							{	
								
								foreach($rec as $rkey => $r)
								{
									$temp_array = array('');
									if($r != "" && $r != null)
									{
										
										$temp_array = array('fk_pd_id'=>$pd_id,'fk_form_id'=>$pd_form_id,'iter_column_name'=>$rec_key,'column_name'=>$rkey,'column_value'=>$r,'fk_createdby'=>$fk_createdby,'iteration'=>$iter);
										$id = $this->PD_Model->saveRecords($temp_array,PDFORMDETAILS);
									}
									
								}
								
						    }
							else
							{
								foreach($rec as $child_key => $child_data)
								{
									//print_r($child_data);
									// echo "$child_key-\n\n\n";
									if(!is_array($child_data))
									{
										//echo "not array\n\n";
										//print_r($child_data);
										$temp_array = array('fk_pd_id'=>$pd_id,'fk_form_id'=>$pd_form_id,'column_name'=>$child_key,'column_value'=>$child_data,'iter_column_name'=>$rec_key,'fk_createdby'=>$fk_createdby,'iteration'=>$iter);
										//print_r($temp_array);
									$id = $this->PD_Model->saveRecords($temp_array,PDFORMDETAILS);
										
									
									}
									else
									{
										//echo "array";
										//print_r($child_data);
										//echo "$child_key-\n\n\n";
										foreach($child_data as $last_key => $last_data)
										{
											foreach($last_data as $final_key => $final_data)
											{
											$temp_array = array('fk_pd_id'=>$pd_id,'fk_form_id'=>$pd_form_id,'column_name'=>$final_key,'column_value'=>$final_data,'iter_column_name'=>$rec_key,'iter_sub_column_name'=>$child_key,'fk_createdby'=>$fk_createdby,'iteration'=>$iter);
											//print_r($temp_array);
											$id = $this->PD_Model->saveRecords($temp_array,PDFORMDETAILS);
										}
									
										}
										
										
										
									}
								}
							}
							
							
							
						}
					}// end of array of key value pairs
				}
			//}
		   //**************** End of handle  form details logic***************//
			
		}
		
		//*****************************upload base64 images 
		 if(count($base64images))
			{	
				
				foreach($base64images as $iter => $doc)
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
						$record_data = array('fk_pd_id' => $pd_id,'fk_form_id'=>$pd_form_id,'pd_document_title'=>$title,'pd_document_name'=>$tempdocname);
						$this->PD_Model->saveRecords($record_data,PDDOCUMENTS);
					}
					
				}
			}
		//*******************************upload base64 images 
		
							$data['dataStatus'] = true;
							$data['status'] = REST_Controller::HTTP_OK;
							//$data['records'] = $result_array;
							$this->response($data,REST_Controller::HTTP_OK);
		
	}
	
	
	public function getAssessedIncome_post()
	{
		$pd_id = $this->post('pd_id');
		$pd_form_id = $this->post('pd_form_id');
		$result_array = $this->PD_Model->getAssessedIncome($pd_id);
		$result_array['final_data'] = $this->calculateAssessedIncome($pd_id);
		$data['dataStatus'] = true;
		$data['status'] = REST_Controller::HTTP_OK;
	    $data['records'] = $result_array;
		$this->response($data,REST_Controller::HTTP_OK);
	}
		
	public function saveAssessedIncomeSalesDeclaredByCustomer_post()
	{
		$records = $this->post('records');
		$pk = "";
		if($records['sdc_id'] != null || $records['sdc_id'] != "")
		{
			
			$where_condition_array = array('sdc_id'=>$records['sdc_id']);
			$pk = $this->PD_Model->updateRecords($records,SALESDECLAREDBYCUSTOMER,$where_condition_array);
		}
		else
		{
			$pk = $this->PD_Model->saveRecords($records,SALESDECLAREDBYCUSTOMER);
		}
		
		if($pk != "" || $pk != null)
		{
			$data['dataStatus'] = true;
			$data['status'] = REST_Controller::HTTP_OK;
			$data['records'] = $pk;
			$this->response($data,REST_Controller::HTTP_OK);	
		}
		else
		{
			$data['dataStatus'] = false;
			$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
			$data['msg'] = 'Something went wrong! Try Later';
			$this->response($data,REST_Controller::HTTP_OK);
		}
		
	}

	public function saveAssessedIncomeSalesCalculatedByItemwise_post()
	{
		$records = $this->post('records');
		$count = 0;
		foreach($records as $rec_key => $record)
		{	
				if($record['sci_id'] != null || $record['sci_id'] != "")
				{
					$where_condition_array = array('sci_id'=>$record['sci_id']);
					$id = $this->PD_Model->updateRecords($record,SALESCALCULATEDBYITEMWISE,$where_condition_array);
					if($id != "" || $id != null){$count++;}
				}
				else
				{
					$id = $this->PD_Model->saveRecords($record,SALESCALCULATEDBYITEMWISE);
					if($id != "" || $id != null){$count++;}
				}
		}
		if($count == count($records))
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
			$data['msg'] = 'Something went wrong! Try Later';
			$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	public function saveAssessedIncomePurchaseDetails_post()
	{
		$records = $this->post('records');
		$count = 0;
			foreach($records as $rec_key => $record)
			{
				if($record['purchase_id'] != null || $record['purchase_id'] != "")
				{
					$where_condition_array = array('purchase_id'=>$record['purchase_id']);
					$id = $this->PD_Model->updateRecords($record,PDPURCHASEDETAILS,$where_condition_array);
					if($id != "" || $id != null){$count++;}
				}
				else
				{
					$id = $this->PD_Model->saveRecords($record,PDPURCHASEDETAILS);
					if($id != "" || $id != null){$count++;}
				}
			}
		if($count == count($records))
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
			$data['msg'] = 'Something went wrong! Try Later';
			$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	public function saveAssessedIncomeBusinessExpenses_post()
	{
		$records = $this->post('records');
		$count = 0;
			foreach($records as $rec_key => $record)
			{
				if($record['pd_expense_id'] != null || $record['pd_expense_id'] != "")
				{
					$where_condition_array = array('pd_expense_id'=>$record['pd_expense_id']);
					$id = $this->PD_Model->updateRecords($record,PDBUSINESSEXPENSES,$where_condition_array);
					if($id != "" || $id != null){$count++;}
				}
				else
				{
					$id = $this->PD_Model->saveRecords($record,PDBUSINESSEXPENSES);
					if($id != "" || $id != null){$count++;}
				}
			}
		
		if($count == count($records))
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
			$data['msg'] = 'Something went wrong! Try Later';
			$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	public function saveAssessedIncomeHouseholdExpenses_post()
	{
		$records = $this->post('records');
		$count = 0;
			foreach($records as $rec_key => $record)
			{
					if($record['household_expense_id'] != null || $record['household_expense_id'] != "")
					{
						$where_condition_array = array('household_expense_id'=>$record['household_expense_id']);
						$id = $this->PD_Model->updateRecords($record,PDHOUSEHOLDEXPENSES,$where_condition_array);
						if($id != "" || $id != null){$count++;}
					}
					else
					{
						$id = $this->PD_Model->saveRecords($record,PDHOUSEHOLDEXPENSES);
						if($id != "" || $id != null){$count++;}
					}
			}
		
		if($count == count($records))
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
			$data['msg'] = 'Something went wrong! Try Later';
			$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	
	
	public function saveAssessedIncomeMonthwiseItems_post()//SALESITEMMONTHWISECHILD
	{
		$records = $this->post('records');
		$count = 0;
		foreach($records as $key => $record)
		{
		
				$child_data = array();
				if(array_key_exists('child',$record))
				{
					$child_data = $record['child'];
					unset($record['child']);
				}
				$id = "";
				if($record['sim_id'] != null || $record['sim_id'] != "")
				{
					$where_condition_array = array('sim_id'=>$record['sim_id']);
					$id = $this->PD_Model->updateRecords($record,SALESITEMMONTHWISE,$where_condition_array);
					if($id != "" || $id != null)
					{
						$count++;
						foreach($child_data as $ckey => $child)
						{
							if($child['simc_id'] != "" || $child['simc_id'] != null)
							{
								$where_condition_array = array('simc_id'=>$child['simc_id']);
								$child_id = $this->PD_Model->updateRecords($child,SALESITEMMONTHWISECHILD,$where_condition_array);
							}
							else
							{
								$child['fk_sim_id'] = $record['sim_id'];
								$child_id = $this->PD_Model->saveRecords($child,SALESITEMMONTHWISECHILD);
							}
						}
					}
					
				}
				else
				{
					$id = $this->PD_Model->saveRecords($record,SALESITEMMONTHWISE);
					if($id != "" || $id != null)
					{
						$count++;
						foreach($child_data as $ckey => $child)
						{
							$child['fk_sim_id'] = $id;
							$child_id = $this->PD_Model->saveRecords($child,SALESITEMMONTHWISECHILD);
						}
					}
				}
		}
		
		if($count == count($records))
		{
			$data['dataStatus'] = true;
			$data['status'] = REST_Controller::HTTP_OK;
			$data['records'] = $id;
			$this->response($data,REST_Controller::HTTP_OK);	
		}
		else
		{
			$data['dataStatus'] = false;
			$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
			$data['msg'] = 'Something went wrong! Try Later';
			$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	public function getFinalPDReportQuestions_post()
	{
		$pd_id = $this->post('pd_id');
		
		$final_data_to_response = array();
		$final_data_to_response['question_answers']['general_questions'] = "";
		
		$pd_master_details = $this->PD_Model->getPDMasterDetails($pd_id);
		$final_data_to_response = $pd_master_details[0];
		$final_data_to_response['pd_applicant_details'] = $this->PD_Model->getApplicantsDetails($pd_id);
		
		//Get Template id 
		$fields = array('fk_pd_template_id');
		$where_condition_array = array('pd_id' => $pd_id);
		$template_details = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDTRIGGER);
		$template_id = null;
		if(count($template_details))
		{
			$template_id = $template_details[0]['fk_pd_template_id'];
		}
		
		// Get all assigned pd forms associated with this pd from template_forms table
		if($template_id != null)
		{
			$columns = array('TEMPLATEFORMS.form_id','PDFORMS.pd_form_name');
			$table = TEMPLATEFORMS.' as TEMPLATEFORMS';
			$joins = array(array('table' => PDFORMS. ' as PDFORMS',
								  'condition' =>'TEMPLATEFORMS.form_id = PDFORMS.pd_form_id AND TEMPLATEFORMS.isactive = 1',
								   'jointype' => 'INNER'));
			$where_condition_array = array('fk_template_id' => $template_id);
			$template_form_details = $this->PD_Model->getJoinRecords($columns,$table,$joins,$where_condition_array);
			//print_r($template_form_details);
			if(count($template_form_details))
			{
				$temp_array = "";
				foreach($template_form_details as $template_key => $template_form_detail)
				{
					$pd_form_raw_data = $this->PD_Model->getPDFormDetails($pd_id,$template_form_detail['form_id']);
					//print_r($pd_form_raw_data);
					// $pd_form_structured_data = GETPDFORMDETAILS::getPDFormDetailsStructured($pd_form_raw_data,$pd_id,$template_form_detail['form_id']);
					
					// echo "\n\n";
					// echo $template_form_detail['pd_form_name'].'-- details';
					// print_r($pd_form_structured_data);
					// echo "\n\n";
					
					$transformed_data = $this->transformKeyPairToQuestionAnswers($pd_form_raw_data,$template_form_detail['form_id']);
					
					
					$final_data_to_response['question_answers']['form_details'][] = array('name' =>[$template_form_detail['pd_form_name']],'details' => $transformed_data);
					
					//$final_data_to_response['question_answers']['form_details'] = array_merge($final_data_to_response['question_answers']['form_details'],array('name' =>[$template_form_detail['pd_form_name']],'details' => $transformed_data));
					
					
				}
			}
			
		}
		
		$final_data_to_response['question_answers']['general_questions'] = array();
		//$final_data_to_response['question_answers']['form_details'] = array();
		
		$object = new stdClass();
			foreach($final_data_to_response as $key => $value)
			{
			  $object->$key = $value;
			}
		if(count($final_data_to_response))
		{
			$data['dataStatus'] = true;
			$data['status'] = REST_Controller::HTTP_OK;
			$data['records'] = $final_data_to_response;
			$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
			$data['dataStatus'] = false;
			$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
			$data['msg'] = 'Something went wrong! Try Later';
			$this->response($data,REST_Controller::HTTP_OK);
		}
		
		
		
		
	}
	
	
	public function transformKeyPairToQuestionAnswers($pd_form_raw_data,$form_id)
	{
		//field name array holds - field name of each masters table 
		$master_tables_field_names = array('INDUSTRYCLASSIFICATION' => 'name','UOM' => 'name','OCCUPATIONMEMBERS' => 'name','EDUQUALIFICATION' => 'qualification_name', 'TYPEOFACTIVITY' => 'name','RELATIONSHIPS' => 'name','FREQUENCY' => 'name', 'CUSTOMERBEHAVIOUR' => 'description', 'CUSTOMERSEGMENT' => 'name','DESIGNATION' => 'short_name', 'EARNINGMEMBERSSTATUS' => 'earning_member_status','EDUQUALIFICATION' => 'qualification_name','ADDRESSTYPE' => 'address_type','LOCALITY' => 'locality_name','ASSETTYPE' => 'name','PROPERTIES' => 'name','INVESTMENTTYPE' => 'name','INSURANCETYPE' => 'name','PERSONSMET' => 'person_met_name','RESIDENCEOWNERSHIP' => 'name','PAYMENTMODE' => 'name','ACCOUNTTYPE' => 'name','SOURCEOFOTHERINCOME' => 'name','MORTAGEPROPERTYTYPE' => 'name','ENDUSEOFLOAN' => 'name','SOURCEOFBALANCETRANSFER' => 'name', 'STATUSOFCONSTRUCTION' => 'name','BTLENDERLIST'=>'lender_name','MORTAGEPROPERTIES'=>'property_name');
		
		$master_tables_pkid = array('INDUSTRYCLASSIFICATION' => 'industry_classification_id','UOM' => 'uom_id','OCCUPATIONMEMBERS' => 'occupation_non_earning_member_id','EDUQUALIFICATION' => 'qualification_name', 'TYPEOFACTIVITY' => 'type_of_activity_id','RELATIONSHIPS' => 'relationship_id','FREQUENCY' => 'frequency_id', 'CUSTOMERBEHAVIOUR' => 'customer_behaviour_id', 'CUSTOMERSEGMENT' => 'customer_segment_id','DESIGNATION' => 'designation_id', 'EARNINGMEMBERSSTATUS' => 'earning_member_status_id','EDUQUALIFICATION' => 'qualification_id','ADDRESSTYPE' => 'address_type_id','LOCALITY' => 'locality_id','ASSETTYPE' => 'id','PROPERTIES' => 'id','INVESTMENTTYPE' => 'id','INSURANCETYPE' => 'id','PERSONSMET' => 'person_met_id','RESIDENCEOWNERSHIP' => 'id','PAYMENTMODE' => 'id','ACCOUNTTYPE' => 'id','SOURCEOFOTHERINCOME' => 'id','MORTAGEPROPERTYTYPE' => 'id','ENDUSEOFLOAN' => 'id','SOURCEOFBALANCETRANSFER' => 'id', 'STATUSOFCONSTRUCTION' => 'id','MORTAGEPROPERTIES' => 'mortage_property_id','BTLENDERLIST'=>'bt_lender_list_id');
		
		//Get Question Key Mapping masters
		$fields = array('question', 'key', 'ismaster', 'master_name');
		$where_condition_array = array('fk_form_id' => $form_id,'isactive' => 1);
		$question_key_master_data = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,QUESTIONKEYMAPPING);
		//print_r($pd_form_raw_data);
		$current_question_array  = array();
		foreach($pd_form_raw_data as $raw_key => $raw_data)
		{
			$que_key = $raw_data['column_name'];
			if($que_key != null || $que_key != "")
			{
				foreach($question_key_master_data as $master_key => $master)
				{
					if($master['key'] == $que_key)
					{
						if($master['ismaster'] != 1)
						{
							$current_question_array[] = array('question'=>$master['question'],'answer'=>$raw_data['column_value']);
						}
						else
						{
							$table = constant($master['master_name']);
							$temp_fields =  array($master_tables_field_names[$master['master_name']]);
							$where_condition_array = array($master_tables_pkid[$master['master_name']] => $raw_data['column_value']);
							$result_data = $this->PD_Model->selectCustomRecords($temp_fields,$where_condition_array,$table);
							if(count($result_data))
							{
								$current_question_array[] = array('question'=>$master['question'],'answer'=>$result_data[0]['name']);
							}
							// 
						}
					}
				}
			}
		}
		
		return $current_question_array ;
		
		
			
	}
	
	
	public function calculateAssessedIncome($pd_id)
	{
		
		
		$calculated_data = array();
		
		$sales_declared_by_customer = array();
		$sales_declared_by_customer_flag = 0;
		
		$sales_calculated_by_itemwise = array();
		$sales_calculated_by_itemwise_flag = 0;
		
		$sales_by_item_monthwise = array();
		$sales_by_item_monthwise_flag = 0;
		$margin_value_from_monthwise_data = array();
		
		$purchases = array();
		$purchases_flag = 0;
		
		$business_expenses = array();
		$business_expenses_flag = 0;
		
		$household_expenses = array();
		$household_expenses_flag = 0;
		
		$overall_purchase_total = 0;
		$overall_business_total = 0;
		$overall_household_total = 0;
		$net_profit = 0;
		$final_purchase_avg_value = 0;
		
		//Get all Master Details
		$result_array = $this->PD_Model->getAssessedIncome($pd_id);
		//print_r($result_array);
		$sales_declared_by_customer = $result_array['sales_declared_by_customer'];
		$sales_calculated_by_itemwise = $result_array['sales_calculated_by_itemwise'];
		$sales_by_item_monthwise = $result_array['sales_items_by_monthwise'];
		$purchases = $result_array['purchase_details'];
		$business_expenses = $result_array['business_expenses'];
		$household_expenses = $result_array['house_hold_expenses'];
		$gross_profit_calculation_type = $result_array['gross_profit_calculation_type'];
		if(count($sales_declared_by_customer)){$sales_declared_by_customer_flag = 1;}
		if(count($sales_calculated_by_itemwise)){$sales_calculated_by_itemwise_flag = 1;}
		if(count($sales_by_item_monthwise)){$sales_by_item_monthwise_flag = 1;}
		if(count($purchases)){$purchases_flag = 1;}
		if(count($business_expenses)){$business_expenses_flag = 1;}
		if(count($household_expenses)){$household_expenses_flag = 1;}
		
		
		if(($household_expenses_flag == 1 && $business_expenses_flag == 1) && ($sales_declared_by_customer_flag == 1 || $sales_calculated_by_itemwise_flag == 1 || $sales_by_item_monthwise_flag == 1))
		{
			$total_sales_itemwise = 0;
			$sales_monthwise = array();
			
			$total_sales_monthwise = 0;
			$total_sales_declared_by_customer = 0;
			
			if($sales_calculated_by_itemwise_flag == 1)
			{
				foreach($sales_calculated_by_itemwise as $itemwise_key => $item)
				{
					$total_sales_itemwise = $total_sales_itemwise + $item['annual_sale_value'];
				}
				
			}
			
			if($sales_by_item_monthwise_flag == 1)
			{
				
				foreach($sales_by_item_monthwise as $monthwise_key => $sales_by_item_month)
				{
					$month_total = 0;
					$i = 0;
					foreach($sales_by_item_month['items'] as $month_key => $month)
					{
					  $temp = 0;
					  
					  $i++;
					  foreach($month as $key => $m)
					  {
						 $temp = $temp + $m['sales_value'];
					  }
					$month_total = $month_total + $temp; 				
					}
					$sales_monthwise[] = array('total' => $month_total,'no_of_months' => $i);
				}
				
				foreach($sales_monthwise as $sale)
				{
					$annual_multuplier = 12 / $sale['no_of_months'];
					$total_sales_monthwise = $total_sales_monthwise + ($sale['total'] * $annual_multuplier);
				}
				//print_r($total_sales_monthwise);
			}
			
			if($sales_declared_by_customer_flag == 1)
			{
				$total_sales_declared_by_customer = $sales_declared_by_customer[0]['sales_declared_by_customer'];
			}
			//print_r($sales_monthwise);
			//print_r($total_sales_monthwise);
			
			
			foreach($business_expenses as $business_key => $business_expense)
			{
				$overall_business_total = $overall_business_total + $business_expense['annual_expenses_value'];
			}
			
			foreach($household_expenses as $household_key => $household_expense)
			{
				$overall_household_total = $overall_household_total + $household_expense['annual_expense_value'];
			}
			
			if($purchases_flag != 0)
			{
				foreach($purchases as $purchase_key => $purchase)
				{
					 $overall_purchase_total = $overall_purchase_total + $purchase['annual_purchase_value'];
				}
			}
			
			
			
			
			//case 1 - (b:ref doc)  If the difference between the lowest and highest of the 3 revenue (sales) figures arrived at above in step 1, is > 50% of lowest, then the revenue considered would be 125% of the lowest revenue
			
			$temp_array = array();
			
			if($sales_declared_by_customer_flag != 0){ $temp_array = array_merge($temp_array,array($total_sales_declared_by_customer));}
			if($sales_calculated_by_itemwise_flag != 0){ $temp_array = array_merge($temp_array,array($total_sales_itemwise));}
			if($sales_by_item_monthwise_flag != 0){ $temp_array = array_merge($temp_array,array($total_sales_monthwise));}
			$height_value = max($temp_array);
			$lowest_vaule = min($temp_array);
			
			
			if($lowest_vaule != 0 && count($temp_array) > 1)
			{
				$diff = $height_value - $lowest_vaule;
				if($diff > ($lowest_vaule * 0.5))
				{
					$final_purchase_avg_value = $lowest_vaule * 1.25;
				}
				
			}
			else //case 2 - (a) ref doc - Normally Average of the above 3 sales estimates is considered. There may be situations where sales information is available only from a or b or c or any
			{
				$average = array_sum($temp_array)/count($temp_array);
				$final_purchase_avg_value = $average;
				
			}
			
			 //echo "\n\n".$final_purchase_avg_value;
			
			/**************End of Purchase Calculations************************/
			
			/**************************Gross Profit calculation start***************/
			//print_r($gross_profit_calculation_type);
			$estimation_of_gross_profit = 0;
			if($gross_profit_calculation_type[0]['mode']  == 1)
			{
				$estimation_of_gross_profit = $final_purchase_avg_value - $overall_purchase_total;
			}
			else
			{
				if($gross_profit_calculation_type[0]['margin']  == 1)
				{
					if($sales_calculated_by_itemwise_flag != 0)
					{
						foreach($sales_calculated_by_itemwise as $sci_key => $sci)
						{
							$estimation_of_gross_profit =  $estimation_of_gross_profit+$sci['margin_final_value'];
						}
					}
					else if($sales_by_item_monthwise_flag != 0)
					{
						foreach($sales_by_item_monthwise as $sim_key => $sim)
						{
							$estimation_of_gross_profit =  $estimation_of_gross_profit+$sim['margin_value'];
						}
					}
					
					$net_profit = $estimation_of_gross_profit - $overall_business_total;
				}
				else
				{
					if($sales_calculated_by_itemwise_flag != 0)
					{
						foreach($sales_calculated_by_itemwise as $sci_key => $sci)
						{
							$net_profit =  $net_profit+$sci['margin_final_value'];
						}
					}
					else if($sales_by_item_monthwise_flag != 0)
					{
						foreach($sales_by_item_monthwise as $sim_key => $sim)
						{
							$net_profit =  $net_profit+ $sim['margin_value'];
							
						}
						
					}
					
					$overall_purchase_total = $final_purchase_avg_value - ($overall_business_total+$net_profit);
				}
			}
			/**************************Gross Profit calculation end***************/
			$calculated_data['sales_revenue'] = $final_purchase_avg_value;
			$calculated_data['purchase'] = $overall_purchase_total;
			if($gross_profit_calculation_type[0]['mode']  == 1 || $gross_profit_calculation_type[0]['margin']  == 1)
			{
				$calculated_data['gross_profit'] = $estimation_of_gross_profit;
			}
			else
			{
				$calculated_data['gross_profit'] =( $net_profit + $overall_business_total);
			}
			$calculated_data['business_expense'] = $overall_business_total;
			$calculated_data['net_profit_loss'] = $net_profit;
			$calculated_data['net_margin'] = $calculated_data['net_profit_loss'] / $calculated_data['sales_revenue'];
			
			
			
			// $data['dataStatus'] = true;
			// $data['status'] = REST_Controller::HTTP_OK;
			// $data['records'] = $calculated_data;
			// $this->response($data,REST_Controller::HTTP_OK);
			return $calculated_data;
		}
		else
		{
			// $data['dataStatus'] = false;
			// $data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
			// $data['msg'] = 'Not enough Data to Calculate Assessed Income';
			// $this->response($data,REST_Controller::HTTP_OK);
			return $calculated_data;
		}
		
	}
}