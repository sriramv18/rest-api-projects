<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class PD_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
			$this->load->library('AWS_S3');
        }
		
	
		public function listLessPDDetails($page,$limit,$sort,$pdofficerid,$datetype,$fdate,$tdate,$lenderid,$status)// $page represents mysql offset
		{
			//echo $status;die();
			$this->db->SELECT('PDTRIGGER.pd_id, PDTRIGGER.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name,PDTRIGGER.fk_entity_billing_id,ENTITYBILLING.billing_name, PDTRIGGER.lender_applicant_id, DATE_FORMAT(PDTRIGGER.pd_date_of_initiation, "%d/%m/%Y") as pd_date_of_initiation, PDTRIGGER.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, PDTRIGGER.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name,SUBPRODUCTS.abbr as subproduct_abbr, PDTRIGGER.fk_pd_type,PDTYPE.type_name as pd_type_name, PDTRIGGER.pd_status,PDTRIGGER.pd_specific_clarification, DATE_FORMAT(PDTRIGGER.createdon,"%d/%m/%Y %H:%i:%s") as createdon, PDTRIGGER.fk_createdby, DATE_FORMAT(PDTRIGGER.updatedon,"%d/%m/%Y %H:%i:%s") as updatedon, PDTRIGGER.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDTRIGGER.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDTRIGGER.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDTRIGGER.executive_id,concat(EXECUTIVE.first_name," ",EXECUTIVE.last_name) as executive_name,PDTRIGGER.central_pd_officer_id,concat(CENTRALOFFICER.first_name," ",CENTRALOFFICER.last_name) as centralofficer,PDTRIGGER.fk_pd_template_id,TEMPLATE.template_name, PDTRIGGER.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name,CUSTOMERSEGMENT.abbr as customer_segment_abbr, PDTRIGGER.pd_officier_final_judgement, PDTRIGGER.pd_agency_id,AGENCY.full_name as agency_name, PDTRIGGER.loan_amount,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode,PDTRIGGER.pd_contact_person,PDTRIGGER.pd_contact_mobileno,DATE_FORMAT(PDTRIGGER.scheduled_on,"%d/%m/%Y %h:%i %p") as scheduled_on,DATE_FORMAT(PDTRIGGER.completed_on,"%d/%m/%Y %h:%i:%s %p") as completed_on,PDTRIGGER.remarks');
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
			$this->db->JOIN(USERPROFILE.' as EXECUTIVE','PDTRIGGER.executive_id = EXECUTIVE.userid','LEFT');
			$this->db->JOIN(USERPROFILE.' as CENTRALOFFICER','PDTRIGGER.central_pd_officer_id = CENTRALOFFICER.userid','LEFT');
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
			
			if($status != "" || $status != null)
			{
				$this->db->WHERE('PDTRIGGER.pd_status',strtoupper($status));
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
		  //  print_r($this->db->last_query());die();
			if(count($result_array) != 0)
			{
				foreach($result_array as $key => $result)
				{
					
					$this->db->SELECT('PDAPPLICANTSDETAILS.pd_co_applicant_id, PDAPPLICANTSDETAILS.fk_pd_id, PDAPPLICANTSDETAILS.applicant_name, PDAPPLICANTSDETAILS.applicant_type, PDAPPLICANTSDETAILS.mobile_no, PDAPPLICANTSDETAILS.email, PDAPPLICANTSDETAILS.addressline1, PDAPPLICANTSDETAILS.addressline2, PDAPPLICANTSDETAILS.addressline3, PDAPPLICANTSDETAILS.fk_city, PDAPPLICANTSDETAILS.fk_state, PDAPPLICANTSDETAILS.pincode,PDAPPLICANTSDETAILS.relation,RELATIONSHIPS.name as relation_name,PDAPPLICANTSDETAILS.landline');
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
		$this->db->SELECT('PDAPPLICANTSDETAILS.pd_co_applicant_id, PDAPPLICANTSDETAILS.fk_pd_id, PDAPPLICANTSDETAILS.applicant_name, PDAPPLICANTSDETAILS.applicant_type, PDAPPLICANTSDETAILS.mobile_no, PDAPPLICANTSDETAILS.email, PDAPPLICANTSDETAILS.addressline1, PDAPPLICANTSDETAILS.addressline2, PDAPPLICANTSDETAILS.addressline3, PDAPPLICANTSDETAILS.fk_city, PDAPPLICANTSDETAILS.fk_state, PDAPPLICANTSDETAILS.pincode,PDAPPLICANTSDETAILS.relation,RELATIONSHIPS.name as relation_name,PDAPPLICANTSDETAILS.landline');
		$this->db->FROM(PDAPPLICANTSDETAILS.' as PDAPPLICANTSDETAILS');
		$this->db->JOIN(STATE.' as STATE','PDAPPLICANTSDETAILS.fk_state = STATE.state_id','LEFT');
		$this->db->JOIN(CITY.' as CITY','PDAPPLICANTSDETAILS.fk_city = CITY.city_id','LEFT');
		$this->db->JOIN(RELATIONSHIPS.' as RELATIONSHIPS','PDAPPLICANTSDETAILS.relation = RELATIONSHIPS.relationship_id','LEFT');
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
			//$pdid = 63;
			//get pd Master Details
			$pd_master_detials = $this->getPDMasterDetails($pdid);
			
			$arrayForText = array("fk_lender_id" => "Lender", "fk_entity_billing_id" => "Billing ID", "lender_applicant_id" => "Applicant Ref ID", "pd_date_of_initiation" => "PD Date of Initiation", "fk_product_id" => "Product", "fk_subproduct_id" => "Sub Product","fk_pd_type" => "PD Type", "pd_status" => "PD Status", "pd_specific_clarification"=> "PD Specific Clarification","fk_pd_allocation_type" => "Allocation Type", "fk_pd_allocated_to" => "Allocated Person", "fk_pd_template_id" => "PD Tempale", "fk_customer_segment" => "Customer Segment", "pd_officier_final_judgement" => "PD Officer Finale Judgement", "pd_agency_id" => "PD Agency", "loan_amount" => "Loan Amount", "addressline1" => "Addressline1", "addressline2" => "Addressline1", "addressline3" => "Addressline1", "fk_city" => "City", "fk_state" => "State", "pincode" => "Pincode", "bounce_reason" => "Bounce Reason", "executive_id" => "PD Executive","central_pd_officer_id"=>"Central PD Officer","pd_contact_person" => "Lender Contact Person", "pd_contact_mobileno" => "Lender Contact Mobile Number", "scheduled_on" => "Scheduled On", "completed_on" => "Completed On");
			
			$this->db->SELECT('COMMONMASTER.log_id, COMMONMASTER.primary_key, COMMONMASTER.table_name, COMMONMASTER.field_name, COMMONMASTER.old_value, COMMONMASTER.new_value, COMMONMASTER.fk_createdby, DATE_FORMAT(COMMONMASTER.createdon,"%dth %b %Y at %h:%i:%s %p") as createdon,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,ENTITYBILLINGOLD.billing_name as old_billing_name,ENTITYBILLINGNEW.billing_name as new_billing_name,ENTITYOLD.full_name as old_entity_name,ENTITYNEW.full_name as new_entity_name,PRODUCTSOLD.abbr as old_product,PRODUCTSNEW.abbr as new_product,SUBPRODUCTSOLD.abbr as old_sub_product,SUBPRODUCTSNEW.abbr as new_sub_product,PDTYPEOLD.type_name as old_type_name,PDTYPENEW.type_name as new_type_name,concat(ALLOCATEDOLD.first_name," ",ALLOCATEDOLD.last_name) as old_allocated_to,concat(ALLOCATEDNEW.first_name," ",ALLOCATEDNEW.last_name) as new_allocated_to,TEMPLATEOLD.template_name as old_template_name,TEMPLATENEW.template_name as new_template_name,CUSTOMERSEGMENTOLD.name as old_cs_name,CUSTOMERSEGMENTNEW.name as new_cs_name,AGENCYOLD.full_name as old_agencyname,AGENCYNEW.full_name as new_agencyname,CITYOLD.name as old_city,CITYNEW.name as new_city,STATEOLD.name as old_state,STATENEW.name as new_state,concat(EXECUTIVEOLD.first_name," ",EXECUTIVEOLD.last_name) as old_executive,concat(EXECUTIVENEW.first_name," ",EXECUTIVENEW.last_name) as new_executive,concat(CENTRALPDOLD.first_name," ",CENTRALPDOLD.last_name) as old_central_pd_officer_id,concat(CENTRALPDNEW.first_name," ",CENTRALPDNEW.last_name) as new_central_pd_officer_id,ALLOCATIONOLD.pd_allocation_type_name as old_allocation_type,ALLOCATIONNEW.pd_allocation_type_name as new_allocation_type,BOUNCEMASTEROLD.bounce_reason_name as old_bounce_reason,BOUNCEMASTERNEW.bounce_reason_name as new_bounce_reason');
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
			$this->db->JOIN(USERPROFILE.' as CENTRALPDOLD','COMMONMASTER.old_value = CENTRALPDOLD.userid','LEFT');
			$this->db->JOIN(USERPROFILE.' as CENTRALPDNEW','COMMONMASTER.new_value = CENTRALPDNEW.userid','LEFT');
			$this->db->JOIN(PDALLOCATIONTYPE.' as ALLOCATIONOLD','COMMONMASTER.old_value = ALLOCATIONOLD.pd_allocation_type_id','LEFT');
			$this->db->JOIN(PDALLOCATIONTYPE.' as ALLOCATIONNEW','COMMONMASTER.new_value = ALLOCATIONNEW.pd_allocation_type_id','LEFT');
			$this->db->WHERE('COMMONMASTER.table_name="'.PDTRIGGER.'" AND COMMONMASTER.primary_key=',$pdid);
			$this->db->JOIN(BOUNCEMASTER.' as BOUNCEMASTEROLD','COMMONMASTER.old_value = BOUNCEMASTEROLD.bounce_id','LEFT');
			$this->db->JOIN(BOUNCEMASTER.' as BOUNCEMASTERNEW','COMMONMASTER.new_value = BOUNCEMASTERNEW.bounce_id','LEFT');
			$logs = $this->db->GET()->result_array();
			//print_r($logs);
			
			//$sql = 'SELECT * FROM '.COMMONMASTER.' WHERE table_name = "'.PDTRIGGER.'" AND primary_key = '.$pdid;
			//$logs = $this->db->query($sql)->result_array();
			$actual_logs = array();
			if(count($logs))
			{
				foreach($logs as $log_key => $log)
				{
					
					if($log_key == 0)
					{
						$log_string = 'PD Ctreated with '.$log['old_value'].'" status "';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['log']  = $log_string;
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
					}
					else
					{
					$field_name = $log['field_name'];
					//print_r($field_name);
					switch($field_name){
						case 'fk_entity_billing_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_billing_name'].'" to "'.$log['new_billing_name'].'"';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['log']  = $log_string;
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
							
						break;
						case 'fk_lender_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_entity_name'].'" to "'.$log['new_entity_name'].'"';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['log']  = $log_string;
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
							
						break;
						case 'fk_product_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_product'].'" to "'.$log['new_product'].'"';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['log']  = $log_string;
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
							
						break;
						case 'fk_subproduct_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_sub_product'].'" to "'.$log['new_sub_product'].'"';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['log']  = $log_string;
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
							
						break;
						case 'fk_pd_type':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_type_name'].'" to "'.$log['new_type_name'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_pd_allocated_to':
							
							if($log['old_allocated_to'] != null || $log['old_allocated_to'] != "" || $log['old_allocated_to'] != 0)
							{
								$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_allocated_to'].'" to "'.$log['new_allocated_to'].'"';
								$user = $log['createdby'];
								$time = $log['createdon'];
								$actual_logs[$log_key]['log']  = $log_string;
								$actual_logs[$log_key]['user']  = $user;
								$actual_logs[$log_key]['time']  = $time;
							}
							// else
							// {
								// $log_string = ' PD Allocated to "'.$log['new_allocated_to'].'"';
								// $user = $log['createdby'];
								// $time = $log['createdon'];
								// $actual_logs[$log_key]['log']  = $log_string;
								// $actual_logs[$log_key]['user']  = $user;
								// $actual_logs[$log_key]['time']  = $time;
							// }
							
						break;
						case 'fk_pd_template_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_template_name'].'" to "'.$log['new_template_name'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_customer_segment':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_cs_name'].'" to "'.$log['new_cs_name'].'"';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['log']  = $log_string;
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
							
						break;
						case 'pd_agency_id':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_agencyname'].'" to "'.$log['new_agencyname'].'"';
							$actual_logs[]  = $log_string;
							
						break;
						case 'fk_city':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_city'].'" to "'.$log['new_city'].'"';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['log']  = $log_string;
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
							
						break;
						case 'fk_state':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_state'].'" to "'.$log['new_state'].'"';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['log']  = $log_string;
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
							
						break;
						case 'fk_pd_allocation_type':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_state'].'" to "'.$log['new_state'].'"';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['log']  = $log_string;
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
							
						break;
						case 'executive_id':
							if($log['old_executive'] != null || $log['old_executive'] != "" || $log['old_executive'] != 0)
							{
								$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_executive'].'" to "'.$log['new_executive'].'"';
								$user = $log['createdby'];
								$time = $log['createdon'];
								$actual_logs[$log_key]['log']  = $log_string;
								$actual_logs[$log_key]['user']  = $user;
								$actual_logs[$log_key]['time']  = $time;
							}
							// else
							// {
								// $log_string = 'PD assigned to Executive Officer "'.$log['new_executive'].'"';
								// $user = $log['createdby'];
								// $time = $log['createdon'];
								// $actual_logs[$log_key]['log']  = $log_string;
								// $actual_logs[$log_key]['user']  = $user;
								// $actual_logs[$log_key]['time']  = $time;
							// }
						break;
						case 'central_pd_officer_id':
							if($log['old_central_pd_officer_id'] != null || $log['old_central_pd_officer_id'] != "" || $log['old_central_pd_officer_id'] != 0)
							{
								$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_central_pd_officer_id'].'" to "'.$log['new_central_pd_officer_id'].'"';
								$user = $log['createdby'];
								$time = $log['createdon'];
								$actual_logs[$log_key]['log']  = $log_string;
								$actual_logs[$log_key]['user']  = $user;
								$actual_logs[$log_key]['time']  = $time;
							}
							// else
							// {
								// $log_string = 'PD assigned to Central PD Officer "'.$log['new_central_pd_officer_id'].'"';
								// $user = $log['createdby'];
								// $time = $log['createdon'];
								// $actual_logs[$log_key]['log']  = $log_string;
								// $actual_logs[$log_key]['user']  = $user;
								// $actual_logs[$log_key]['time']  = $time;
							// }
							
						break;
						case 'pd_status':
							
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_value'].'" to "'.$log['new_value'].'"';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
							$actual_logs[$log_key]['log']  = $log_string;
							if($log['new_value'] == ALLOCATED)
							{
								if($pd_master_detials[0]['fk_pd_type'] == 1)//FULL PD
								{
									$actual_logs[$log_key]['meta_data'][] = array('display_name' => 'Allocated to PD Officer','display_value' => $pd_master_detials[0]['pd_allocated_to']);
								}
								else if($pd_master_detials[0]['fk_pd_type'] == 2)//SMART PD							
								{
									
									$actual_logs[$log_key]['meta_data'][] = array('display_name' => 'Allocated to Central PD Officer','display_value' => $pd_master_detials[0]['centralofficer']);
									$actual_logs[$log_key]['meta_data'][] = array('display_name' => 'Allocated to Executive PD Officer','display_value' => $pd_master_detials[0]['executive_name']);
									
								}
								else //Tele PD
								{
									$actual_logs[$log_key]['meta_data']['Allocated to Central PD Officer'] = $pd_master_detials[0]['centralofficer'];
								}
							}
							else if($log['new_value'] == SCHEDULED)
							{
								$actual_logs[$log_key]['meta_data'][] = array('display_name' => 'Scheduled Date','display_value' => $pd_master_detials[0]['scheduled_date_for_log']);					
								$actual_logs[$log_key]['meta_data'][] = array('display_name' => 'Scheduled Time','display_value' => $pd_master_detials[0]['scheduled_time_for_log']);					
							}
							else if($log['new_value'] == BOUNCED)
							{
							$actual_logs[$log_key]['meta_data'][]  = array('display_name'=>'Rejected Reason','display_value' => $pd_master_detials[0]['bounce_reason_name']);
							 if($pd_master_detials[0]['bounce_reason_others'] != "" || $pd_master_detials[0]['bounce_reason_others'] != null)
							 {
								$actual_logs[$log_key]['meta_data'][]  = array('display_name'=>'Rejected Reason Others','display_value'=> $pd_master_detials[0]['bounce_reason_others']);
							 }
							}
							
							
						break;
						default:
							$log_string = $arrayForText[$log['field_name']].' Changed From "'.$log['old_value'].'" to "'.$log['new_value'].'"';
							$user = $log['createdby'];
							$time = $log['createdon'];
							$actual_logs[$log_key]['log']  = $log_string;
							$actual_logs[$log_key]['user']  = $user;
							$actual_logs[$log_key]['time']  = $time;
						
					}
				  }
				}
			}
			
			$result_data['child'] = array('testkey'=>'testvalue');
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
		return array();
	}
	
	/*
	*Get  PD Master Details.
	*/
	public function getPDMasterDetails($pdid)
	{
		$this->db->SELECT('PDTRIGGER.pd_id, PDTRIGGER.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name, PDTRIGGER.fk_entity_billing_id,ENTITYBILLING.billing_name,PDTRIGGER.lender_applicant_id, DATE_FORMAT(PDTRIGGER.pd_date_of_initiation, "%d/%m/%Y") as pd_date_of_initiation, PDTRIGGER.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, PDTRIGGER.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name,SUBPRODUCTS.abbr as subproduct_abbr, PDTRIGGER.fk_pd_type,PDTYPE.type_name as pd_type_name, PDTRIGGER.pd_status,PDTRIGGER.pd_specific_clarification, DATE_FORMAT(PDTRIGGER.createdon,"%d/%m/%Y %H:%i:%s") as createdon, PDTRIGGER.fk_createdby, DATE_FORMAT(PDTRIGGER.updatedon,"%d/%m/%Y %H:%i:%s") as updatedon, PDTRIGGER.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDTRIGGER.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDTRIGGER.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDTRIGGER.executive_id,concat(EXECUTIVE.first_name," ",EXECUTIVE.last_name) as executive_name,PDTRIGGER.central_pd_officer_id,concat(CENTRALOFFICER.first_name," ",CENTRALOFFICER.last_name) as centralofficer,PDTRIGGER.fk_pd_template_id,TEMPLATE.template_name, PDTRIGGER.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name,CUSTOMERSEGMENT.abbr as customer_segment_abbr, PDTRIGGER.pd_officier_final_judgement, PDTRIGGER.pd_agency_id,AGENCY.full_name as agency_name, PDTRIGGER.loan_amount,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode,PDTRIGGER.pd_contact_person,PDTRIGGER.pd_contact_mobileno,DATE_FORMAT(PDTRIGGER.scheduled_on,"%d/%m/%Y %h:%i %p") as scheduled_on,DATE_FORMAT(PDTRIGGER.scheduled_on,"%dth %b %Y ") as scheduled_date_for_log,DATE_FORMAT(PDTRIGGER.scheduled_on,"%h:%i %p") as scheduled_time_for_log,DATE_FORMAT(PDTRIGGER.completed_on,"%d/%m/%Y %h:%i:%s %p") as completed_on,PDTRIGGER.remarks,PDTRIGGER.bounce_reason,PDTRIGGER.bounce_reason_others,BOUNCEMASTER.bounce_reason_name');
			$this->db->FROM(PDTRIGGER.' as PDTRIGGER');
			$this->db->JOIN(ENTITY.' as ENTITY','PDTRIGGER.fk_lender_id = ENTITY.entity_id ','LEFT');
			$this->db->JOIN(ENTITYBILLING.' as ENTITYBILLING','PDTRIGGER.fk_entity_billing_id = ENTITYBILLING.entity_billing_id','LEFT');
			$this->db->JOIN(PRODUCTS.' as PRODUCTS','PDTRIGGER.fk_product_id = PRODUCTS.product_id','LEFT');
			$this->db->JOIN(SUBPRODUCTS.' as SUBPRODUCTS','PDTRIGGER.fk_subproduct_id = SUBPRODUCTS.subproduct_id','LEFT');
			$this->db->JOIN(PDTYPE.' as PDTYPE','PDTRIGGER.fk_pd_type = PDTYPE.pd_type_id','LEFT');
			//$this->db->JOIN(PDSTATUS.' as PDSTATUS','PDTRIGGER.pd_status = PDSTATUS.pd_status_id','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE','PDTRIGGER.fk_createdby = USERPROFILE.userid','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE1','PDTRIGGER.fk_updatedby = USERPROFILE1.userid','LEFT');
			$this->db->JOIN(PDALLOCATIONTYPE.' as PDALLOCATIONTYPE','PDTRIGGER.fk_pd_allocation_type = PDALLOCATIONTYPE.pd_allocation_type_id','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE2','PDTRIGGER.fk_pd_allocated_to = USERPROFILE2.userid','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE3','PDTRIGGER.executive_id = USERPROFILE3.userid','LEFT');
			$this->db->JOIN(USERPROFILE.' as EXECUTIVE','PDTRIGGER.executive_id = EXECUTIVE.userid','LEFT');
			$this->db->JOIN(USERPROFILE.' as CENTRALOFFICER','PDTRIGGER.central_pd_officer_id = CENTRALOFFICER.userid','LEFT');
			$this->db->JOIN(TEMPLATE.' as TEMPLATE','PDTRIGGER.fk_pd_template_id = TEMPLATE.template_id','LEFT');
			$this->db->JOIN(CUSTOMERSEGMENT.' as CUSTOMERSEGMENT','PDTRIGGER.fk_customer_segment = CUSTOMERSEGMENT.customer_segment_id','LEFT');
			$this->db->JOIN(ENTITY.' as AGENCY','PDTRIGGER.pd_agency_id = AGENCY.entity_id','LEFT');
			$this->db->JOIN(STATE.' as STATE','PDTRIGGER.fk_state = STATE.state_id ','LEFT');
			$this->db->JOIN(CITY.' as CITY','PDTRIGGER.fk_city = CITY.city_id','LEFT');
			$this->db->JOIN(BOUNCEMASTER.' as BOUNCEMASTER','PDTRIGGER.bounce_reason = BOUNCEMASTER.bounce_id','LEFT');
			$this->db->WHERE('PDTRIGGER.pd_id',$pdid);
			// $this->db->ORDER_BY('PDTRIGGER.pd_id',$sort);
			// $this->db->LIMIT($limit,$page);
			$result_array = $this->db->GET()->result_array();
			
			return $result_array;
	}
	
	
	
	public function getTemplateForPD($pdid,$client)
	{
		
		
			 $template_id = "";
			 $categories = "";
			 $overall_answered_count = 0;
			 $overall_question_count = 0;
			 //Get PD Master Details including Template id @param $pd_id
			 $pd_master_detials = $this->getPDMasterDetails($pdid);
			 $pd_applicants_detials = $this->getApplicantsDetails($pdid);
			//print_r($pd_master_detials);die();
			if(count($pd_master_detials)){
			 $template_id = $pd_master_detials[0]['fk_pd_template_id'];
			}
			 
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
				$this->db->ORDER_BY('QUESTIONS.question_id');
				//$this->db->WHERE('TEMPLATEQUESTION.fk_template_id',$template_id);
				
				$questions = $this->db->GET()->result_array();
				$answerd_count = 0;
				$pd_docs = array();
				foreach($questions as $t_key => $question)
				{
					
					if($question['pd_detail_id'] != "" || $question['pd_detail_id'] != null){
						$answerd_count++;
					
					// Get Alredy stored Images
							$fields = array('pd_document_title', 'pd_document_name');
							 $where_condition_array = array('fk_pd_id'=>$pdid,'fk_pd_detail_id'=> $question['pd_detail_id']);
							 
							 $pd_docs = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDDOCUMENTS); 
							// print_r($pd_docs);die();
							 if(count($pd_docs))
							 {
								 $bucket_name = LENDER_BUCKET_NAME_PREFIX.$pd_master_detials[0]['fk_lender_id'];
								 foreach($pd_docs as $doc_key => $doc)
								 {
									 if($doc['pd_document_name'] != "" || $doc['pd_document_name'] != null)
									 {
										 $profilepics3path = 'pd'.$pd_master_detials[0]['pd_id'].'/'.$doc['pd_document_name'];
										 $singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI($bucket_name,$profilepics3path,'+30 minutes');
										 $pd_docs[$doc_key]['pd_document_name'] = $singed_uri;
									 }
								 }
								
							 }
							 $questions[$t_key]['images'] = $pd_docs;
					}
							  
				}
				
				//print_r($questions);die();
				$categories[$category_key]['questions_count'] = count($questions);
				$categories[$category_key]['answerd_count'] = $answerd_count;
				 $overall_answered_count += count($questions);
			     $overall_question_count += $answerd_count;

					if(count($questions))
					{
						//image S3 url attach is pending
						foreach($questions as $answer_key => $question)
						{
							
						  $this->db->SELECT('QUESTIONANSWERS.question_answer_id,QUESTIONANSWERS.answer,PDANSWER.pd_answer,TEMPLATEANSWERWEIGHTAGE.template_answer_weightage_id, TEMPLATEANSWERWEIGHTAGE.fk_template_question_id, TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id, TEMPLATEANSWERWEIGHTAGE.template_answer_weightage,PDANSWER.isactive,PDANSWER.pd_detail_answer_id,PDANSWER.fk_pd_detail_id');
						  $this->db->FROM(TEMPLATEANSWERWEIGHTAGE.' as TEMPLATEANSWERWEIGHTAGE');
						  $this->db->JOIN(QUESTIONANSWERS.' as QUESTIONANSWERS','TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id = QUESTIONANSWERS.question_answer_id','LEFT');
						  $this->db->JOIN(PDANSWER." as PDANSWER","QUESTIONANSWERS.question_answer_id = PDANSWER.pd_answer_id AND TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id = PDANSWER.pd_answer_id AND PDANSWER.isactive = 1 AND PDANSWER.fk_pd_id = $pdid",'LEFT');
						 // $this->db->WHERE('QUESTIONANSWERS.fk_question_id',$question['question_id']);
						  $this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_template_question_id',$question['template_question_id']);
						 // $this->db->WHERE('PDDETAIL.fk_pd_id',$pdid);
						 $this->db->ORDER_BY('QUESTIONANSWERS.question_answer_id');
						  $answers = $this->db->GET()->result_array();
						  $questions[$answer_key]['answers'] = $answers;
						}
					}
				$categories[$category_key]['questions'] = $questions;
			  }
			  
		}
	}

	
	//Get Forms details
			$this->db->SELECT('TEMPLATEFORMS.form_id,PDFORMS.pd_form_name as form_name');
			$this->db->FROM(TEMPLATEFORMS.' as TEMPLATEFORMS');
			$this->db->JOIN(PDFORMS.' as PDFORMS','TEMPLATEFORMS.form_id = PDFORMS.pd_form_id');
			$this->db->WHERE('TEMPLATEFORMS.fk_template_id',$template_id);
			$template_forms = $this->db->GET()->result_array();
			foreach($template_forms as $template_key => $value)
			{
				$this->db->SELECT('count(*) as count');
				$this->db->FROM(PDFORMDETAILS.' as PDFORMDETAILS');
				$this->db->WHERE('PDFORMDETAILS.fk_pd_id',$pdid);
				$this->db->WHERE('PDFORMDETAILS.fk_form_id',$value['form_id']);
				$template_forms_count = 0;
				$template_forms_count = $this->db->GET()->result_array();
				//print_r($template_forms_count);die();
				if(count($template_forms_count) && $template_forms_count[0]['count'] != 0)
				{
					$template_forms[$template_key]['isAnswered'] = true;
				}
				else
				{
					$template_forms[$template_key]['isAnswered'] = false;
				}
				
			}
			
			if($pd_master_detials[0]['fk_pd_type'] == 2 && $client == 1)
			{
			
              //$temp_array = array(3,5,10,13);
			  foreach($template_forms as $key => $form)
			  {
				  if($form['form_id'] != 3 && $form['form_id'] != 5 && $form['form_id'] != 10 && $form['form_id'] != 13)
				  {
					unset($template_forms[$key])  ;
				  }
			  }
			
			
			}
	
	
	
	
	$result_data['question_answers'] = $categories;   
	$result_data['counts'] = array('overall_answered_count'=>$overall_answered_count,'overall_question_count'=>$overall_question_count);
	if(count($pd_master_detials))
	{
		$result_data['pdmaster_details'] = $pd_master_detials[0];   
	}
	$result_data['pdapplicants_detials'] = $pd_applicants_detials;    
	$result_data['template_forms'] = $template_forms;   
	return $result_data;
   }
   
  
   public function getAnswersForPD($question_id,$pd_id,$template_id,$category_id)
   {
				$overalldata =array();
				$pd_master_detials = $this->getPDMasterDetails($pd_id);
						  $this->db->SELECT('QUESTIONANSWERS.question_answer_id,QUESTIONANSWERS.answer,PDANSWER.pd_answer,TEMPLATEANSWERWEIGHTAGE.template_answer_weightage,PDANSWER.pd_detail_answer_id,PDANSWER.isactive,PDANSWER.fk_pd_detail_id');
						  $this->db->FROM(TEMPLATEANSWERWEIGHTAGE.' as TEMPLATEANSWERWEIGHTAGE');
						  $this->db->JOIN(TEMPLATEQUESTION." as TEMPLATEQUESTION","TEMPLATEANSWERWEIGHTAGE.fk_template_question_id = TEMPLATEQUESTION.template_question_id AND TEMPLATEQUESTION.fk_template_question_category_id = $category_id AND TEMPLATEQUESTION.fk_template_id = $template_id AND TEMPLATEQUESTION.fk_question_id = $question_id");
						  $this->db->JOIN(QUESTIONANSWERS.' as QUESTIONANSWERS','TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id = QUESTIONANSWERS.question_answer_id');
						  
						  $this->db->JOIN(PDANSWER.' as PDANSWER',"QUESTIONANSWERS.question_answer_id = PDANSWER.pd_answer_id AND TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id = PDANSWER.pd_answer_id AND PDANSWER.fk_pd_id = $pd_id AND PDANSWER.isactive = 1",'LEFT');
						  $this->db->ORDER_BY('QUESTIONANSWERS.question_answer_id');
						
						// $this->db->WHERE('QUESTIONANSWERS.fk_question_id',$question['question_id']);
						 // $this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_template_question_id',$question_id);
						 //$this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_question_category_id',$category_id);
						  //$this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_template_id',$template_id);
						 // $this->db->WHERE('PDDETAIL.fk_pd_id',$pdid);
						  $answers = $this->db->GET()->result_array();
						  
						  $overalldata['answers'] =  $answers;
						 
						 //Get PD Detail ID From PD DETAILS table using pd_id and question_id
						 
						 $fields = array('pd_detail_id','question_remark','fk_question_id as question_id','pd_question');
						 $where_condition_array = array('fk_pd_id'=>$pd_id,'fk_question_id'=>$question_id);
						 $pd_detail = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDDETAIL);
						// print_r($pd_detail);die();
							$overalldata['question_remark'] =  "";
							 $overalldata['pd_detail_id'] =  "";
							 $overalldata['question_id'] = "";
							 $overalldata['pd_question'] = "";
							  $overalldata['images'] = array();;
						 if(count($pd_detail))
						 {
							 $overalldata['question_remark'] =  $pd_detail[0]['question_remark'];
							 $overalldata['pd_detail_id'] =  $pd_detail[0]['pd_detail_id'];
							 $overalldata['question_id'] = $pd_detail[0]['question_id'];
							 $overalldata['pd_question'] = $pd_detail[0]['pd_question'];
							 $fields = array('pd_document_title', 'pd_document_name');
							 $where_condition_array = array('fk_pd_id'=>$pd_id,'fk_pd_detail_id'=> $pd_detail[0]['pd_detail_id']);
							 
							 $pd_docs = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDDOCUMENTS); 
							// print_r($pd_docs);die();
							 if(count($pd_docs))
							 {
								 $bucket_name = LENDER_BUCKET_NAME_PREFIX.$pd_master_detials[0]['fk_lender_id'];
								 foreach($pd_docs as $doc_key => $doc)
								 {
									 if($doc['pd_document_name'] != "" || $doc['pd_document_name'] != null)
									 {
										 $profilepics3path = 'pd'.$pd_master_detials[0]['pd_id'].'/'.$doc['pd_document_name'];
										 $singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI($bucket_name,$profilepics3path,'+30 minutes');
										 $pd_docs[$doc_key]['pd_document_name'] = $singed_uri;
									 }
								 }
								
							 }
							  $overalldata['images'] = $pd_docs;
						 }
						 $overalldata['counts'] = $this->getOverallAnsweredCount($pd_id);
						 
						 return $overalldata;
						 
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
		//print_r($result);die;
		if($result !='')
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
	
	public function getOverallAnsweredCount($pdid)
	{
		
			 $template_id = "";
			 $categories = "";
			 $overall_answered_count = 0;
			 $overall_question_count = 0;
			  $temp['overall_answered_count'] = 0;
			  $temp['overall_question_count'] = 0;
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
				$answerd_count = 0;
				$pd_docs = array();
				foreach($questions as $t_key => $question)
				{
					
					if($question['pd_detail_id'] != "" || $question['pd_detail_id'] != null){
						$answerd_count++;
					
					// Get Alredy stored Images
							$fields = array('pd_document_title', 'pd_document_name');
							 $where_condition_array = array('fk_pd_id'=>$pdid,'fk_pd_detail_id'=> $question['pd_detail_id']);
							 
							 $pd_docs = $this->PD_Model->selectCustomRecords($fields,$where_condition_array,PDDOCUMENTS); 
							// print_r($pd_docs);die();
							 if(count($pd_docs))
							 {
								 $bucket_name = LENDER_BUCKET_NAME_PREFIX.$pd_master_detials[0]['fk_lender_id'];
								 foreach($pd_docs as $doc_key => $doc)
								 {
									 if($doc['pd_document_name'] != "" || $doc['pd_document_name'] != null)
									 {
										 $profilepics3path = 'pd'.$pd_master_detials[0]['pd_id'].'/'.$doc['pd_document_name'];
										 $singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI($bucket_name,$profilepics3path,'+30 minutes');
										 $pd_docs[$doc_key]['pd_document_name'] = $singed_uri;
									 }
								 }
								
							 }
							 $questions[$t_key]['images'] = $pd_docs;
					}
							  
				}
				
				//print_r($questions);die();
				//$categories[$category_key]['questions_count'] = count($questions);
				//$categories[$category_key]['answerd_count'] = $answerd_count;
				 $temp['overall_answered_count'] += count($questions);
			     $temp['overall_question_count'] += $answerd_count;
		}
		}
			 }
			 
			return $temp;
			// return $categories;
	}
	
      public function getPDFormDetails($pd_id,$pd_form_id)
	  {
		  
		  $this->db->SELECT('PDFORMDETAILS.iter_column_name,PDFORMDETAILS.iter_sub_column_name,PDFORMDETAILS.iteration, PDFORMDETAILS.column_name, PDFORMDETAILS.column_id, PDFORMDETAILS.column_value, PDFORMDETAILS.createdon, PDFORMDETAILS.fk_createdby,USERPROFILE.first_name,USERPROFILE.last_name');
		  $this->db->FROM(PDFORMDETAILS.' as PDFORMDETAILS');
		  $this->db->JOIN(USERPROFILE.' as USERPROFILE','PDFORMDETAILS.fk_createdby = USERPROFILE.userid','LEFT');
		  $this->db->WHERE('PDFORMDETAILS.fk_pd_id',$pd_id);
		  $this->db->WHERE('PDFORMDETAILS.fk_form_id',$pd_form_id);
		  $this->db->WHERE('PDFORMDETAILS.isactive',1);
		  $form_details = $this->db->GET()->result_array();
		  return $form_details;
		  
	  }	

	 public function getAssessedIncome($pdid)
	 {
		/********************************* Assessd Income Sections   *****************************************/
			$assessed_income = array();
				
			//get sales_declared_by_customer details
			$fields = array('sdc_id','sales_declared_by_customer','margin_per','margin_value');	
			$where_condition_array = array('fk_pd_id'=>$pdid,'isactive'=>1);	
			$sales_declared_by_customer = $this->selectCustomRecords($fields,$where_condition_array,SALESDECLAREDBYCUSTOMER);
			//get Gross Profit calculatio Mode details
			$fields = array('calc_type_id','mode','margin');	
			$where_condition_array = array('fk_pd_id'=>$pdid);	
			$gross_profit_calculation_type = $this->selectCustomRecords($fields,$where_condition_array,PDASSESSEDINCOMEESTIMATIONOFGROSSPROFITTYPE);
			
			//get sales_calculated_by_itemwise details
			$fields = array('sci_id','sales_item','sales_qty','UOM.name as uom_name','fk_uom_id','FREQUENCY.name as frequency_name','rate_per_unit','fk_frequency_id','annual_sale_value','margin_final_value','margin_per','margin_per_uom');	
			$table = SALESCALCULATEDBYITEMWISE.' as SALESCALCULATEDBYITEMWISE';
			$where_condition_array = array('fk_pd_id'=>$pdid,'SALESCALCULATEDBYITEMWISE.isactive'=>1);
			$joins = array(
							array('table'=>FREQUENCY.' as FREQUENCY','condition'=>'SALESCALCULATEDBYITEMWISE.fk_frequency_id = FREQUENCY.frequency_id','jointype'=>'INNER JOIN'),
							array('table'=>UOM.' as UOM','condition'=>'SALESCALCULATEDBYITEMWISE.fk_uom_id = UOM.uom_id','jointype'=>'INNER JOIN'));
			$sales_calculated_by_itemwise = $this->getJoinRecords($fields,$table,$joins,$where_condition_array);
			
		   
		   //get sales_items_by_monthwise details 
		   
			$sales_items_by_months = array();
			
			$this->db->SELECT('sim_id,sales_item,margin_value,margin_per');
			$this->db->FROM(SALESITEMMONTHWISE.' as SALESITEMMONTHWISE');
			$this->db->WHERE('SALESITEMMONTHWISE.fk_pd_id',$pdid);
			$this->db->WHERE('SALESITEMMONTHWISE.isactive',1);
			$sales_items_by_monthwise = $this->db->GET()->result_array();
			if(count($sales_items_by_monthwise))
			{
				foreach($sales_items_by_monthwise as $key => $item)
				{
					$this->db->SELECT('month(sales_date) as month,year(sales_date) as year');
					$this->db->FROM(SALESITEMMONTHWISECHILD.' as SALESITEMMONTHWISECHILD');
					$this->db->WHERE('SALESITEMMONTHWISECHILD.fk_sim_id',$item['sim_id']);
					$this->db->WHERE('SALESITEMMONTHWISECHILD.isactive',1);
					$this->db->GROUP_BY('month(SALESITEMMONTHWISECHILD.sales_date)');
					$sales_items_by_month = $this->db->GET()->result_array();
					//print_r($this->db->last_query());
					
					if(count($sales_items_by_month))
					{
						$sales_items_by_months = array();
						foreach($sales_items_by_month as $month_key => $month)
						{
							
						  	$this->db->SELECT('simc_id,sales_date,sales_value');
							$this->db->FROM(SALESITEMMONTHWISECHILD.' as SALESITEMMONTHWISECHILD');
							$this->db->WHERE('SALESITEMMONTHWISECHILD.fk_sim_id',$item['sim_id']);
							$this->db->WHERE('month(SALESITEMMONTHWISECHILD.sales_date)',$month['month']);
							$this->db->WHERE('SALESITEMMONTHWISECHILD.isactive',1);
							//$this->db->GROUP_BY('month(SALESITEMMONTHWISECHILD.sales_date)');
							$sales_items_by_month_child = $this->db->GET()->result_array();
							if(count($sales_items_by_month_child))
							{
								foreach($sales_items_by_month_child as $t_key => $child_item)
								{
									$sales_items_by_month_child[$t_key]['row_index'] = $t_key + 1;
								}
							}
						    $sales_items_by_months[date("M-Y", strtotime($month['year'].'-'.$month['month']))] = $sales_items_by_month_child;
						}
						$sales_items_by_monthwise[$key]['items'] = $sales_items_by_months;
					}
					
					//print_r($sales_items_by_months);
				}
				
			}
			
		  
			
			
			
			//Get purchase_details
			   $fields = array('purchase_id','purchase_item','purchase_qty','UOM.name as uom_name','fk_uom_id','FREQUENCY.name as frequency_name','rate_per_unit','fk_frequency_id','annual_purchase_value');	
			   $table = PDPURCHASEDETAILS.' as PDPURCHASEDETAILS';
			   $where_condition_array = array('fk_pd_id'=>$pdid,'PDPURCHASEDETAILS.isactive'=>1);
			   $joins = array(
							array('table'=>FREQUENCY.' as FREQUENCY','condition'=>'PDPURCHASEDETAILS.fk_frequency_id = FREQUENCY.frequency_id','jointype'=>'INNER JOIN'),
							array('table'=>UOM.' as UOM','condition'=>'PDPURCHASEDETAILS.fk_uom_id = UOM.uom_id','jointype'=>'INNER JOIN'));
			 $purchase_details = $this->getJoinRecords($fields,$table,$joins,$where_condition_array);
			 
			 
			 //Get business_expenses
			   $fields = array('pd_expense_id','PDBUSINESSEXPENSES.expense_item_id','BUSINESSEXPENSES.expense_item','FREQUENCY.name as frequency_name','fk_frequency_id','expense_value','annual_expenses_value');	
			   $table = PDBUSINESSEXPENSES.' as PDBUSINESSEXPENSES';
			   $where_condition_array = array('fk_pd_id'=>$pdid,'PDBUSINESSEXPENSES.isactive'=>1);
			   $joins = array(
							array('table'=>FREQUENCY.' as FREQUENCY','condition'=>'PDBUSINESSEXPENSES.fk_frequency_id = FREQUENCY.frequency_id','jointype'=>'INNER JOIN'),
							array('table'=>BUSINESSEXPENSES.' as BUSINESSEXPENSES','condition'=>'PDBUSINESSEXPENSES.expense_item_id = BUSINESSEXPENSES.expense_item_id','jointype'=>'INNER JOIN'));
			 $business_expenses = $this->getJoinRecords($fields,$table,$joins,$where_condition_array);
			 
			 
			  
			  //Get house_hold_expenses
				$fields = array('household_expense_id','expense_item','FREQUENCY.name as frequency_name','fk_frequency_id','expense_value','annual_expense_value');	
				$table = PDHOUSEHOLDEXPENSES.' as PDHOUSEHOLDEXPENSES';
				$where_condition_array = array('fk_pd_id'=>$pdid,'PDHOUSEHOLDEXPENSES.isactive'=>1);
				$joins = array(
							array('table'=>FREQUENCY.' as FREQUENCY','condition'=>'PDHOUSEHOLDEXPENSES.fk_frequency_id = FREQUENCY.frequency_id','jointype'=>'INNER JOIN'));
			  $house_hold_expenses = $this->getJoinRecords($fields,$table,$joins,$where_condition_array);
			
			/*********************************End of Assessd Income Sections   *****************************************/ 
			
			$assessed_income= array('sales_declared_by_customer'=>$sales_declared_by_customer,'sales_calculated_by_itemwise'=>$sales_calculated_by_itemwise,'sales_items_by_monthwise'=>$sales_items_by_monthwise,'purchase_details'=>$purchase_details,'business_expenses'=>$business_expenses,'house_hold_expenses'=>$house_hold_expenses,'gross_profit_calculation_type' => $gross_profit_calculation_type);
			
			return $assessed_income;
	 }
}