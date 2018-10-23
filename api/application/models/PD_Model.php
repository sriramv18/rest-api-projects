<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class PD_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
			$this->load->library('AWS_S3');
        }
		
	
		public function listLessPDDetails($page,$limit,$sort,$pdofficerid,$datetype,$fdate,$tdate,$lenderid)// $page represents mysql offset
		{
			$this->db->SELECT('PDTRIGGER.pd_id, PDTRIGGER.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name,PDTRIGGER.fk_entity_billing_id,ENTITYBILLING.billing_name, PDTRIGGER.lender_applicant_id, DATE_FORMAT(PDTRIGGER.pd_date_of_initiation, "%d/%m/%Y") as pd_date_of_initiation, PDTRIGGER.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, PDTRIGGER.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name,SUBPRODUCTS.abbr as subproduct_abbr, PDTRIGGER.fk_pd_type,PDTYPE.type_name as pd_type_name, PDTRIGGER.pd_status,PDSTATUS.pd_status_name, PDTRIGGER.pd_specific_clarification, DATE_FORMAT(PDTRIGGER.createdon,"%d/%m/%Y %H:%i:%s") as createdon, PDTRIGGER.fk_createdby, DATE_FORMAT(PDTRIGGER.updatedon,"%d/%m/%Y %H:%i:%s") as updatedon, PDTRIGGER.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDTRIGGER.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDTRIGGER.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDTRIGGER.fk_pd_template_id,TEMPLATE.template_name, PDTRIGGER.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name,CUSTOMERSEGMENT.abbr as customer_segment_abbr, PDTRIGGER.pd_officier_final_judgement, PDTRIGGER.pd_agency_id,AGENCY.full_name as agency_name, PDTRIGGER.loan_amount,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode,PDTRIGGER.pd_contact_person,PDTRIGGER.pd_contact_mobileno,DATE_FORMAT(PDTRIGGER.scheduled_on,"%d/%m/%Y %h:%i:%s %p") as scheduled_on,DATE_FORMAT(PDTRIGGER.completed_on,"%d/%m/%Y %h:%i:%s %p") as completed_on');
			$this->db->FROM(PDTRIGGER.' as PDTRIGGER');
			$this->db->JOIN(ENTITY.' as ENTITY','PDTRIGGER.fk_lender_id = ENTITY.entity_id','LEFT');
			$this->db->JOIN(ENTITYBILLING.' as ENTITYBILLING','PDTRIGGER.fk_entity_billing_id = ENTITYBILLING.entity_billing_id','LEFT');
			$this->db->JOIN(PRODUCTS.' as PRODUCTS','PDTRIGGER.fk_product_id = PRODUCTS.product_id','LEFT');
			$this->db->JOIN(SUBPRODUCTS.' as SUBPRODUCTS','PDTRIGGER.fk_subproduct_id = SUBPRODUCTS.subproduct_id','LEFT');
			$this->db->JOIN(PDTYPE.' as PDTYPE','PDTRIGGER.fk_pd_type = PDTYPE.pd_type_id','LEFT');
			$this->db->JOIN(PDSTATUS.' as PDSTATUS','PDTRIGGER.pd_status = PDSTATUS.pd_status_id','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE','PDTRIGGER.fk_createdby = USERPROFILE.userid','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE1','PDTRIGGER.fk_updatedby = USERPROFILE1.userid','LEFT');
			$this->db->JOIN(PDALLOCATIONTYPE.' as PDALLOCATIONTYPE','PDTRIGGER.fk_pd_allocation_type = PDALLOCATIONTYPE.pd_allocation_type_id','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE2','PDTRIGGER.fk_pd_allocated_to = USERPROFILE2.userid','LEFT');
			$this->db->JOIN(TEMPLATE.' as TEMPLATE','PDTRIGGER.fk_pd_template_id = TEMPLATE.template_id','LEFT');
			$this->db->JOIN(CUSTOMERSEGMENT.' as CUSTOMERSEGMENT','PDTRIGGER.fk_customer_segment = CUSTOMERSEGMENT.customer_segment_id','LEFT');
			$this->db->JOIN(ENTITY.' as AGENCY','PDTRIGGER.pd_agency_id = AGENCY.entity_id','LEFT');
			$this->db->JOIN(STATE.' as STATE','PDTRIGGER.fk_state = STATE.state_id ','LEFT');
			$this->db->JOIN(CITY.' as CITY','PDTRIGGER.fk_city = CITY.city_id','LEFT');
			
			if($pdofficerid != "" || $pdofficerid != null)
			{
				$this->db->WHERE('PDTRIGGER.fk_pd_allocated_to',$pdofficerid);
			}
			
			if($lenderid != "" || $lenderid != null)
			{
				$this->db->WHERE('PDTRIGGER.fk_lender_id',$lenderid);
			}
			
			if($datetype != "" || $datetype != null)
			{
				if($datetype == 1)
				{
					if($fdate != "" || $fdate != null)
					{	
						$this->db->WHERE('PDTRIGGER.pd_date_of_initiation >=',$fdate);
					}
					if($tdate != "" || $tdate != null)
					{	
						$this->db->WHERE('PDTRIGGER.pd_date_of_initiation <=',$tdate);
					}
				}
				else if($datetype == 2)
				{
					if($fdate != "" || $fdate != null)
					{
						$this->db->WHERE('PDTRIGGER.scheduled_on >=',$fdate);
					}
					if($tdate != "" || $tdate != null)
					{	
						$this->db->WHERE('PDTRIGGER.scheduled_on <=',$tdate);
					}
				}
				
			}
			$this->db->ORDER_BY('PDTRIGGER.pd_id',$sort);
			$this->db->LIMIT($limit,$page);
			$result_array = $this->db->GET()->result_array();
		
			if(count($result_array) != 0)
			{
				foreach($result_array as $key => $result)
				{
					
					$this->db->SELECT('PDAPPLICANTSDETAILS.pd_co_applicant_id, PDAPPLICANTSDETAILS.fk_pd_id, PDAPPLICANTSDETAILS.applicant_name, PDAPPLICANTSDETAILS.applicant_type, PDAPPLICANTSDETAILS.mobile_no, PDAPPLICANTSDETAILS.email, PDAPPLICANTSDETAILS.addressline1, PDAPPLICANTSDETAILS.addressline2, PDAPPLICANTSDETAILS.addressline3, PDAPPLICANTSDETAILS.fk_city, PDAPPLICANTSDETAILS.fk_state, PDAPPLICANTSDETAILS.pincode,PDAPPLICANTSDETAILS.relation,RELATIONSHIPS.name as relation_name');
					$this->db->FROM(PDAPPLICANTSDETAILS.' as PDAPPLICANTSDETAILS');
					$this->db->JOIN(STATE.' as STATE','PDAPPLICANTSDETAILS.fk_state = STATE.state_id','LEFT');
					$this->db->JOIN(CITY.' as CITY','PDAPPLICANTSDETAILS.fk_city = CITY.city_id','LEFT');
					$this->db->JOIN(RELATIONSHIPS.' as RELATIONSHIPS','PDAPPLICANTSDETAILS.relation = RELATIONSHIPS.relationship_id','LEFT');
					$this->db->WHERE('PDAPPLICANTSDETAILS.fk_pd_id ',$result['pd_id']);
					$result_child_array = $this->db->GET()->result_array();
					if(count($result_child_array) != 0)
					{
						 $result_array[$key]['applicat_details'] = $result_child_array;
					}
				}
			}
			
				
				if(count($result_array) > 0 )
			   {
				   $result_data['data_status'] = true;
				   $result_data['data'] = $result_array;
				   return $result_data;
				   
			   }
			   else
			   {
				  $result_data['data_status'] = false;
				  $result_data['data'] =  null;
				  return $result_data;
			   }
			
		}
		
		// get Lender Specific PDOfficers List And Currently Allocated PD Values form PDOFFICIERSDETAILS table
		public function getLenderSpecificPDOfficersListAndAllocatedValues($lender_specific_pdofficers_list)
		{
			$this->db->SELECT('fk_user_id,allocated');
			$this->db->FROM(PDOFFICIERSDETAILS);
			$this->db->WHERE_IN('fk_user_id',$lender_specific_pdofficers_list);
			$result = $this->db->get()->result_array();
		}
		 
		public function updatePDofficersDetail($userid)
		{
			$sql = 'UPDATE '.PDOFFICIERSDETAILS.' SET total = total+1, allocated = allocated+1 WHERE fk_user_id ='.$userid;
			$modified = $this->db->query($sql);
		}
		
		
	/*
	*Get All PD Related Documents as signed and expired URL's from S3  Buckets
	*/
	public function getSignedPDDocsURL($pdid)
	{
		 $document_lists = array();
		if($pdid != '' || $pdid != null)
		{
		
				
				// Get lenderid of this pd by using pid
				$lender_id = $this->selectCustomRecords(array('fk_lender_id'),array('pd_id' => $pdid),PDTRIGGER);
				if(count($lender_id))
				{
				 //Get PD Documenttitle and name from DB
				  $document_lists = $this->selectRecords(PDDOCUMENTS,array('fk_pd_id' => $pdid));
				  if(count($document_lists))
				  {  
					
					$bucket_name = LENDER_BUCKET_NAME_PREFIX.$lender_id[0]['fk_lender_id'];
					
					 foreach($document_lists as $key => $value)
					 {
						 
						$profilepics3path = 'pd'.$pdid.'/'.$value['pd_document_name'];
						$singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI($bucket_name,$profilepics3path,'+30 minutes');
						$document_lists[$key]['doc_url'] = $singed_uri;
					 }
					
				   }
					
				}
		
		}
		
		return $document_lists;
	}
	
	
	/*
	*Get all Applicants details by pdid
	*/
	public function getApplicantsDetails($pdid)
	{
		$this->db->SELECT('PDAPPLICANTSDETAILS.pd_co_applicant_id, PDAPPLICANTSDETAILS.fk_pd_id, PDAPPLICANTSDETAILS.applicant_name, PDAPPLICANTSDETAILS.applicant_type, PDAPPLICANTSDETAILS.mobile_no, PDAPPLICANTSDETAILS.email, PDAPPLICANTSDETAILS.addressline1, PDAPPLICANTSDETAILS.addressline2, PDAPPLICANTSDETAILS.addressline3, PDAPPLICANTSDETAILS.fk_city, PDAPPLICANTSDETAILS.fk_state, PDAPPLICANTSDETAILS.pincode,PDAPPLICANTSDETAILS.relation');
		$this->db->FROM(PDAPPLICANTSDETAILS.' as PDAPPLICANTSDETAILS');
		$this->db->JOIN(STATE.' as STATE','PDAPPLICANTSDETAILS.fk_state = STATE.state_id','LEFT');
		$this->db->JOIN(CITY.' as CITY','PDAPPLICANTSDETAILS.fk_city = CITY.city_id','LEFT');
		$this->db->WHERE('PDAPPLICANTSDETAILS.fk_pd_id ',$pdid);
		$result_child_array = $this->db->GET()->result_array();
		
		if(count($result_child_array) != 0)
		  {
			  return $result_child_array;
		  }
		  else 
		  {
			  return array();
		  }
	}
	
	
	/*
	* GET PD Log Details by pdid
	*/
	public function getPDLogs($pdid)
	{
			$pdid = 63;
			
			$arrayForText = array("fk_lender_id" => "Lender", "fk_entity_billing_id" => "Billing ID", "lender_applicant_id" => "Applicant Ref ID", "pd_date_of_initiation" => "PD Date of Initiation", "fk_product_id" => "Product", "fk_subproduct_id" => "Sub Product","fk_pd_type" => "PD Type", "pd_status" => "PD Status", "pd_specific_clarification"=> "PD Specific Clarification","fk_pd_allocation_type" => "Allocation Type", "fk_pd_allocated_to" => "Allocated Person", "fk_pd_template_id" => "PD Tempale", "fk_customer_segment" => "Customer Segment", "pd_officier_final_judgement" => "PD Officer Finale Judgement", "pd_agency_id" => "PD Agency", "loan_amount" => "Loan Amount", "addressline1" => "Addressline1", "addressline2" => "Addressline1", "addressline3" => "Addressline1", "fk_city" => "City", "fk_state" => "State", "pincode" => "Pincode", "bounce_reason" => "Bounce Reason", "executive_id" => "PD Executive", "pd_contact_person" => "Lender Contact Person", "pd_contact_mobileno" => "Lender Contact Mobile Number", "scheduled_on" => "Scheduled On", "completed_on" => "Completed On");
			
			$this->db->SELECT('COMMONMASTER.log_id, COMMONMASTER.primary_key, COMMONMASTER.table_name, COMMONMASTER.field_name, COMMONMASTER.old_value, COMMONMASTER.new_value, COMMONMASTER.fk_createdby, DATE_FORMAT(COMMONMASTER.createdon,"%d/%m/%Y %h:%i:%s %p") as createdon,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,ENTITYBILLINGOLD.billing_name as old_billing_name,ENTITYBILLINGNEW.billing_name as new_billing_name,ENTITYOLD.full_name as old_entity_name,ENTITYNEW.full_name as new_entity_name,PRODUCTSOLD.abbr as old_product,PRODUCTSNEW.abbr as new_product,SUBPRODUCTSOLD.abbr as old_sub_product,SUBPRODUCTSNEW.abbr as new_sub_product,PDTYPEOLD.type_name as old_type_name,PDTYPENEW.type_name as new_type_name,concat(ALLOCATEDOLD.first_name," ",ALLOCATEDOLD.last_name) as old_allocated_to,concat(ALLOCATEDNEW.first_name," ",ALLOCATEDNEW.last_name) as new_allocated_to,TEMPLATEOLD.template_name as old_template_name,TEMPLATENEW.template_name as new_template_name,CUSTOMERSEGMENTOLD.name as old_cs_name,CUSTOMERSEGMENTNEW.name as new_cs_name,AGENCYOLD.full_name as old_agencyname,AGENCYNEW.full_name as new_agencyname,CITYOLD.name as old_city,CITYNEW.name as new_city,STATEOLD.name as old_state,STATENEW.name as new_state,concat(EXECUTIVEOLD.first_name," ",EXECUTIVEOLD.last_name) as old_executive,concat(EXECUTIVENEW.first_name," ",EXECUTIVENEW.last_name) as new_executive,ALLOCATIONOLD.pd_allocation_type_name as old_allocation_type,ALLOCATIONNEW.pd_allocation_type_name as new_allocation_type');
			$this->db->FROM(COMMONMASTER.' as COMMONMASTER');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE','COMMONMASTER.fk_createdby = USERPROFILE.userid','LEFT');
			$this->db->JOIN(ENTITYBILLING.' as ENTITYBILLINGOLD','COMMONMASTER.old_value = ENTITYBILLINGOLD.entity_billing_id','LEFT');
			$this->db->JOIN(ENTITYBILLING.' as ENTITYBILLINGNEW','COMMONMASTER.new_value = ENTITYBILLINGNEW.entity_billing_id','LEFT');
			$this->db->JOIN(ENTITY.' as ENTITYOLD','COMMONMASTER.old_value = ENTITYOLD.entity_id','LEFT');
			$this->db->JOIN(ENTITY.' as ENTITYNEW','COMMONMASTER.new_value = ENTITYNEW.entity_id','LEFT');
			$this->db->JOIN(PRODUCTS.' as PRODUCTSOLD','COMMONMASTER.old_value = PRODUCTSOLD.product_id','LEFT');
			$this->db->JOIN(PRODUCTS.' as PRODUCTSNEW','COMMONMASTER.new_value = PRODUCTSNEW.product_id','LEFT');
			$this->db->JOIN(SUBPRODUCTS.' as SUBPRODUCTSOLD','COMMONMASTER.old_value = SUBPRODUCTSOLD.subproduct_id','LEFT');
			$this->db->JOIN(SUBPRODUCTS.' as SUBPRODUCTSNEW','COMMONMASTER.new_value = SUBPRODUCTSNEW.subproduct_id','LEFT');
			$this->db->JOIN(PDTYPE.' as PDTYPEOLD','COMMONMASTER.old_value = PDTYPEOLD.pd_type_id','LEFT');
			$this->db->JOIN(PDTYPE.' as PDTYPENEW','COMMONMASTER.new_value = PDTYPENEW.pd_type_id','LEFT');
			$this->db->JOIN(USERPROFILE.' as ALLOCATEDOLD','COMMONMASTER.old_value = ALLOCATEDOLD.userid','LEFT');
			$this->db->JOIN(USERPROFILE.' as ALLOCATEDNEW','COMMONMASTER.new_value = ALLOCATEDNEW.userid','LEFT');
			$this->db->JOIN(TEMPLATE.' as TEMPLATEOLD','COMMONMASTER.old_value = TEMPLATEOLD.template_id','LEFT');
			$this->db->JOIN(TEMPLATE.' as TEMPLATENEW','COMMONMASTER.new_value = TEMPLATENEW.template_id','LEFT');
			$this->db->JOIN(CUSTOMERSEGMENT.' as CUSTOMERSEGMENTOLD','COMMONMASTER.old_value = CUSTOMERSEGMENTOLD.customer_segment_id','LEFT');
			$this->db->JOIN(CUSTOMERSEGMENT.' as CUSTOMERSEGMENTNEW','COMMONMASTER.new_value = CUSTOMERSEGMENTNEW.customer_segment_id','LEFT');
			$this->db->JOIN(ENTITY.' as AGENCYOLD','COMMONMASTER.old_value = AGENCYOLD.entity_id','LEFT');
			$this->db->JOIN(ENTITY.' as AGENCYNEW','COMMONMASTER.new_value = AGENCYNEW.entity_id','LEFT');
			$this->db->JOIN(CITY.' as CITYOLD','COMMONMASTER.old_value = CITYOLD.city_id','LEFT');
			$this->db->JOIN(CITY.' as CITYNEW','COMMONMASTER.new_value = CITYNEW.city_id','LEFT');
			$this->db->JOIN(STATE.' as STATEOLD','COMMONMASTER.old_value = STATEOLD.state_id','LEFT');
			$this->db->JOIN(STATE.' as STATENEW','COMMONMASTER.new_value = STATENEW.state_id','LEFT');
			$this->db->JOIN(USERPROFILE.' as EXECUTIVEOLD','COMMONMASTER.old_value = EXECUTIVEOLD.userid','LEFT');
			$this->db->JOIN(USERPROFILE.' as EXECUTIVENEW','COMMONMASTER.new_value = EXECUTIVENEW.userid','LEFT');
			$this->db->JOIN(PDALLOCATIONTYPE.' as ALLOCATIONOLD','COMMONMASTER.old_value = ALLOCATIONOLD.pd_allocation_type_id','LEFT');
			$this->db->JOIN(PDALLOCATIONTYPE.' as ALLOCATIONNEW','COMMONMASTER.new_value = ALLOCATIONNEW.pd_allocation_type_id','LEFT');
			$this->db->WHERE('COMMONMASTER.table_name="'.PDTRIGGER.'" AND COMMONMASTER.primary_key=',$pdid);
			$logs = $this->db->GET()->result_array();
			//print_r($logs);
			
			//$sql = 'SELECT * FROM '.COMMONMASTER.' WHERE table_name = "'.PDTRIGGER.'" AND primary_key = '.$pdid;
			//$logs = $this->db->query($sql)->result_array();
			$actual_logs = array();
			if(count($logs))
			{
				foreach($logs as $log_key => $log)
				{
					//print_r($log);
					//echo $arrayForText[$log['field_name']].' Changed From "'. $log['old_value'] .'" To "'. $log['new_value'].'"';
					$field_name = $log['field_name'];
					//print_r($field_name);
					switch($field_name){
						case 'fk_entity_billing_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_billing_name'].'" to "'.$log['new_billing_name'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_lender_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_entity_name'].'" to "'.$log['new_entity_name'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_product_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_product'].'" to "'.$log['new_product'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_subproduct_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_sub_product'].'" to "'.$log['new_sub_product'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_pd_type':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_type_name'].'" to "'.$log['new_type_name'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_pd_allocated_to':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_allocated_to'].'" to "'.$log['new_allocated_to'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_pd_template_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_template_name'].'" to "'.$log['new_template_name'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_customer_segment':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_cs_name'].'" to "'.$log['new_cs_name'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'pd_agency_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_agencyname'].'" to "'.$log['new_agencyname'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_city':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_city'].'" to "'.$log['new_city'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$logs[$log_key]['log']  = $log_string;
							
						break;
						case 'fk_state':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_state'].'" to "'.$log['new_state'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_pd_allocation_type':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_state'].'" to "'.$log['new_state'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'executive_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_allocation_type'].'" to "'.$log['new_allocation_type'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						default:
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_value'].'" to "'.$log['new_value'].'" by "'.$log['createdby'].'" on "'.$log['createdon'].'"';
							$actual_logs[]  = $log_string;
						
					}
				}
			}
			
			$result_data['child'] = array('Hi'=>'Welcome');
			$result_data['master'] = $actual_logs;
			
			// Child History Start
			// $this->db->SELECT('PDAPPLICANTSDETAILS.pd_co_applicant_id, PDAPPLICANTSDETAILS.fk_pd_id, PDAPPLICANTSDETAILS.applicant_name, PDAPPLICANTSDETAILS.applicant_type, PDAPPLICANTSDETAILS.mobile_no, PDAPPLICANTSDETAILS.email, PDAPPLICANTSDETAILS.isactive, PDAPPLICANTSDETAILS.relation');
			// $this->db->FROM(PDAPPLICANTSDETAILS.' as PDAPPLICANTSDETAILS');
			// $this->db->JOIN(PDTRIGGER.' as PDTRIGGER');
			// $this->db->WHERE('PDAPPLICANTSDETAILS.table_name="'.PDAPPLICANTSDETAILS.'" AND COMMONMASTER.primary_key=',$pd_co_applicant_id);
			// $this->db->GET('')->result_array();
			
			return $result_data;
			
	}
	
	
	/*
	* GET PD Question Answers Details by pdid
	*/
	public function getPDQuestionAnswers($pdid)
	{
		
	}
	
	/*
	*Get  PD Master Details.
	*/
	public function getPDMasterDetails($pdid)
	{
		$this->db->SELECT('PDTRIGGER.pd_id, PDTRIGGER.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name, PDTRIGGER.fk_entity_billing_id,ENTITYBILLING.billing_name,PDTRIGGER.lender_applicant_id, DATE_FORMAT(PDTRIGGER.pd_date_of_initiation, "%d/%m/%Y") as pd_date_of_initiation, PDTRIGGER.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, PDTRIGGER.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name,SUBPRODUCTS.abbr as subproduct_abbr, PDTRIGGER.fk_pd_type,PDTYPE.type_name as pd_type_name, PDTRIGGER.pd_status,PDSTATUS.pd_status_name, PDTRIGGER.pd_specific_clarification, DATE_FORMAT(PDTRIGGER.createdon,"%d/%m/%Y %H:%i:%s") as createdon, PDTRIGGER.fk_createdby, DATE_FORMAT(PDTRIGGER.updatedon,"%d/%m/%Y %H:%i:%s") as updatedon, PDTRIGGER.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDTRIGGER.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDTRIGGER.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDTRIGGER.fk_pd_template_id,TEMPLATE.template_name, PDTRIGGER.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name,CUSTOMERSEGMENT.abbr as customer_segment_abbr, PDTRIGGER.pd_officier_final_judgement, PDTRIGGER.pd_agency_id,AGENCY.full_name as agency_name, PDTRIGGER.loan_amount,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode,PDTRIGGER.pd_contact_person,PDTRIGGER.pd_contact_mobileno,DATE_FORMAT(PDTRIGGER.scheduled_on,"%d/%m/%Y %h:%i:%s %p") as scheduled_on,DATE_FORMAT(PDTRIGGER.completed_on,"%d/%m/%Y %h:%i:%s %p") as completed_on');
			$this->db->FROM(PDTRIGGER.' as PDTRIGGER');
			$this->db->JOIN(ENTITY.' as ENTITY','PDTRIGGER.fk_lender_id = ENTITY.entity_id ','LEFT');
			$this->db->JOIN(ENTITYBILLING.' as ENTITYBILLING','PDTRIGGER.fk_entity_billing_id = ENTITYBILLING.entity_billing_id','LEFT');
			$this->db->JOIN(PRODUCTS.' as PRODUCTS','PDTRIGGER.fk_product_id = PRODUCTS.product_id','LEFT');
			$this->db->JOIN(SUBPRODUCTS.' as SUBPRODUCTS','PDTRIGGER.fk_subproduct_id = SUBPRODUCTS.subproduct_id','LEFT');
			$this->db->JOIN(PDTYPE.' as PDTYPE','PDTRIGGER.fk_pd_type = PDTYPE.pd_type_id','LEFT');
			$this->db->JOIN(PDSTATUS.' as PDSTATUS','PDTRIGGER.pd_status = PDSTATUS.pd_status_id','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE','PDTRIGGER.fk_createdby = USERPROFILE.userid','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE1','PDTRIGGER.fk_updatedby = USERPROFILE1.userid','LEFT');
			$this->db->JOIN(PDALLOCATIONTYPE.' as PDALLOCATIONTYPE','PDTRIGGER.fk_pd_allocation_type = PDALLOCATIONTYPE.pd_allocation_type_id','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE2','PDTRIGGER.fk_pd_allocated_to = USERPROFILE2.userid','LEFT');
			$this->db->JOIN(TEMPLATE.' as TEMPLATE','PDTRIGGER.fk_pd_template_id = TEMPLATE.template_id','LEFT');
			$this->db->JOIN(CUSTOMERSEGMENT.' as CUSTOMERSEGMENT','PDTRIGGER.fk_customer_segment = CUSTOMERSEGMENT.customer_segment_id','LEFT');
			$this->db->JOIN(ENTITY.' as AGENCY','PDTRIGGER.pd_agency_id = AGENCY.entity_id','LEFT');
			$this->db->JOIN(STATE.' as STATE','PDTRIGGER.fk_state = STATE.state_id ','LEFT');
			$this->db->JOIN(CITY.' as CITY','PDTRIGGER.fk_city = CITY.city_id','LEFT');
			$this->db->WHERE('PDTRIGGER.pd_id',$pdid);
			// $this->db->ORDER_BY('PDTRIGGER.pd_id',$sort);
			// $this->db->LIMIT($limit,$page);
			$result_array = $this->db->GET()->result_array();
			
			return $result_array;
	}
	
	
	
	public function getTemplateForPD($pdid)
	{
		
			 $template_id = "";
			 $categories = "";
			 //Get PD Master Details including Template id @param $pd_id
			 $pd_master_detials = $this->getPDMasterDetails($pdid);
			 $pd_applicants_detials = $this->getApplicantsDetails($pdid);
			//sprint_r($pd_master_detials);
			 $template_id = $pd_master_detials[0]['fk_pd_template_id'];
			 
			 if($template_id != "" || $template_id != null)
			 {
				 
			 //Get Category, QUestions and Answers @param $template_id
			  $this->db->SELECT('QUESTIONCATEGORY.category_name,TEMPLATECATEGORYWEIGHTAGE.template_category_weightage_id, TEMPLATECATEGORYWEIGHTAGE.fk_question_category_id, TEMPLATECATEGORYWEIGHTAGE.fk_template_id, TEMPLATECATEGORYWEIGHTAGE.weightage, DATE_FORMAT(TEMPLATECATEGORYWEIGHTAGE.createdon,"%d/%m/%Y") as createdon, TEMPLATECATEGORYWEIGHTAGE.fk_createdby,  DATE_FORMAT(TEMPLATECATEGORYWEIGHTAGE.updatedon, "%d/%m/%Y") as updatedon, TEMPLATECATEGORYWEIGHTAGE.isactive, TEMPLATECATEGORYWEIGHTAGE.fk_updatedby');
			  $this->db->FROM(TEMPLATECATEGORYWEIGHTAGE .' as TEMPLATECATEGORYWEIGHTAGE');
			  $this->db->JOIN(QUESTIONCATEGORY.' as QUESTIONCATEGORY','TEMPLATECATEGORYWEIGHTAGE.fk_question_category_id = QUESTIONCATEGORY.question_category_id');
			  // $this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATECATEGORYWEIGHTAGE.fk_createdby = USERPROFILE.userid','LEFT');
			  // $this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATECATEGORYWEIGHTAGE.fk_updatedby = USERPROFILE1.userid','LEFT');
			  $this->db->WHERE('TEMPLATECATEGORYWEIGHTAGE.fk_template_id',$template_id);
			  $categories = $this->db->GET()->result_array();
			//print_r( $categories);
		if(count($categories))
		{
				/*
				DATE_FORMAT(TEMPLATEQUESTION.createdon,"%d/%m/%Y") as createdon, TEMPLATEQUESTION.fk_createdby,  DATE_FORMAT(TEMPLATEQUESTION.updatedon,"%d/%m/%Y") as updatedon, TEMPLATEQUESTION.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby
				*/
			  foreach($categories as $category_key => $category)
			  {
				 
				$this->db->SELECT('QUESTIONS.question_id,QUESTIONS.question,TEMPLATEQUESTION.template_question_id, TEMPLATEQUESTION.fk_template_id, TEMPLATEQUESTION.fk_question_id, TEMPLATEQUESTION.question_weightage, TEMPLATEQUESTION.question_answerable_by,TEMPLATEQUESTION.fk_template_question_category_id,  TEMPLATEQUESTION.isactive,QUESTIONS.fk_question_answertype,QUESTIONANSWERTYPE.answer_type_name,PDDETAIL.pd_detail_id');
				//$this->db->FROM(TEMPLATEQUESTION.' as TEMPLATEQUESTION');
				$this->db->FROM(TEMPLATEQUESTION.' as TEMPLATEQUESTION');
				$this->db->JOIN(QUESTIONS.' as QUESTIONS','TEMPLATEQUESTION.fk_question_id = QUESTIONS.question_id');
				$this->db->JOIN(QUESTIONANSWERTYPE.' as QUESTIONANSWERTYPE','QUESTIONS.fk_question_answertype = QUESTIONANSWERTYPE.question_answer_type_id');
				$this->db->JOIN(PDDETAIL.' as PDDETAIL',"QUESTIONS.question_id = PDDETAIL.fk_question_id AND PDDETAIL.fk_pd_id = $pdid",'LEFT');
				// $this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATEQUESTION.fk_createdby = USERPROFILE.userid','LEFT');
				// $this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATEQUESTION.fk_updatedby = USERPROFILE1.userid','LEFT');
				$this->db->WHERE('TEMPLATEQUESTION.fk_template_question_category_id',$category['fk_question_category_id']);
				$this->db->WHERE('TEMPLATEQUESTION.fk_template_id', $template_id);
				//$this->db->WHERE('TEMPLATEQUESTION.fk_template_id',$template_id);
				
				$questions = $this->db->GET()->result_array();
				//print_r($questions);
				$categories[$category_key]['questions_count'] = count($questions);

					if(count($questions))
					{
						//image S3 url attach is pending
						foreach($questions as $answer_key => $question)
						{
						  $this->db->SELECT('QUESTIONANSWERS.question_answer_id,QUESTIONANSWERS.answer,TEMPLATEANSWERWEIGHTAGE.template_answer_weightage_id, TEMPLATEANSWERWEIGHTAGE.fk_template_question_id, TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id, TEMPLATEANSWERWEIGHTAGE.template_answer_weightage,PDDETAIL.pd_detail_id');
						  $this->db->FROM(TEMPLATEANSWERWEIGHTAGE.' as TEMPLATEANSWERWEIGHTAGE');
						  $this->db->JOIN(QUESTIONANSWERS.' as QUESTIONANSWERS','TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id = QUESTIONANSWERS.question_answer_id','LEFT');
						  $this->db->JOIN(PDDETAIL.' as PDDETAIL',"QUESTIONANSWERS.question_answer_id = PDDETAIL.pd_answer_id AND PDDETAIL.fk_pd_id = $pdid",'LEFT');
						 // $this->db->WHERE('QUESTIONANSWERS.fk_question_id',$question['question_id']);
						  $this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_template_question_id',$question['template_question_id']);
						 // $this->db->WHERE('PDDETAIL.fk_pd_id',$pdid);
						  $answers = $this->db->GET()->result_array();
						  $questions[$answer_key]['answers'] = $answers;
						}
					}
				$categories[$category_key]['questions'] = $questions;
			  }
			  
		}
	}

	$result_data['question_answers'] = $categories;   
	$result_data['pdmaster_details'] = $pd_master_detials[0];   
	$result_data['pdapplicants_detials'] = $pd_applicants_detials;   
	$result_data['assessed_income'] = "";   
	return $result_data;
   }
   
   
   public function getAnswersForPD($question_id,$pd_id,$template_id,$category_id)
   {
				$pd_master_detials = $this->getPDMasterDetails($pd_id);
						  $this->db->SELECT('QUESTIONANSWERS.question_answer_id,QUESTIONANSWERS.answer,TEMPLATEANSWERWEIGHTAGE.template_answer_weightage,PDDETAIL.pd_detail_id,PDDETAIL.pd_anwer_image_title,PDDETAIL.pd_answer_image');
						  $this->db->FROM(TEMPLATEANSWERWEIGHTAGE.' as TEMPLATEANSWERWEIGHTAGE');
						  $this->db->JOIN(TEMPLATEQUESTION." as TEMPLATEQUESTION","TEMPLATEANSWERWEIGHTAGE.fk_template_question_id = TEMPLATEQUESTION.template_question_id AND TEMPLATEQUESTION.fk_template_question_category_id = $category_id AND TEMPLATEQUESTION.fk_template_id = $template_id AND TEMPLATEQUESTION.fk_question_id = $question_id");
						  $this->db->JOIN(QUESTIONANSWERS.' as QUESTIONANSWERS','TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id = QUESTIONANSWERS.question_answer_id');
						  $this->db->JOIN(PDDETAIL.' as PDDETAIL',"QUESTIONANSWERS.question_answer_id = PDDETAIL.pd_answer_id AND PDDETAIL.fk_pd_id = $pd_id",'LEFT');
						 // $this->db->WHERE('QUESTIONANSWERS.fk_question_id',$question['question_id']);
						 // $this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_template_question_id',$question_id);
						 //$this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_question_category_id',$category_id);
						  //$this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_template_id',$template_id);
						 // $this->db->WHERE('PDDETAIL.fk_pd_id',$pdid);
						  $answers = $this->db->GET()->result_array();
						 
						 if(count($answers))
						 {
							 	$bucket_name = LENDER_BUCKET_NAME_PREFIX.$pd_master_detials[0]['fk_lender_id'];
							 foreach($answers as $answer_key => $answer)
							 {
								 if($answer['pd_answer_image'] != "" || $answer['pd_answer_image'] != null)
								 {
									 $profilepics3path = 'pd'.$pd_master_detials[0]['pd_id'].'/'.$answer['pd_answer_image'];
									 $singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI($bucket_name,$profilepics3path,'+30 minutes');
									 $answers[$answer_key]['doc_url'] = $singed_uri;
								 }
							 }
							 
						 }
						 return $answers;
						 
   }

   /**
	* Check OTP PDTRIGGER TABLE
	* param OTP AND pd_id
	*sriram
	*/
	
	public function checkotp($pddata)
	{
		$this->db->select('OTP');
		$this->db->where('pd_id',$pddata['pd_id']);
		$result = $this->db->get(PDTRIGGER.' as PDTRIGGER')->first_row();
		
		if(count($result) !='0')
		{
			if($result->OTP == $pddata['OTP'])
			{
				$result = true;
			}else
			{
				$result = false;
			}
		}
		
	return $result;
	}
	
}