<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class PD_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
			$this->load->library('AWS_S3');
        }
		
	
		public function listLessPDDetails($page,$limit,$sort)// $page represents mysql offset
		{
			$this->db->SELECT('PDTRIGGER.pd_id, PDTRIGGER.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name, PDTRIGGER.lender_applicant_id, DATE_FORMAT(PDTRIGGER.pd_date_of_initiation, "%d/%m/%Y") as pd_date_of_initiation, PDTRIGGER.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, PDTRIGGER.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name,SUBPRODUCTS.abbr as subproduct_abbr, PDTRIGGER.fk_pd_type,PDTYPE.type_name as pd_type_name, PDTRIGGER.fk_pd_status,PDSTATUS.pd_status_name, PDTRIGGER.pd_specific_clarification, DATE_FORMAT(PDTRIGGER.createdon,"%d/%m/%Y %H:%i:%s") as createdon, PDTRIGGER.fk_createdby, DATE_FORMAT(PDTRIGGER.updatedon,"%d/%m/%Y %H:%i:%s") as updatedon, PDTRIGGER.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDTRIGGER.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDTRIGGER.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDTRIGGER.fk_pd_template_id,TEMPLATE.template_name, PDTRIGGER.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name,CUSTOMERSEGMENT.abbr as customer_segment_abbr, PDTRIGGER.pd_officier_final_judgement, PDTRIGGER.pd_agency_id,AGENCY.full_name as agency_name, PDTRIGGER.loan_amount,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode');
			$this->db->FROM(PDTRIGGER.' as PDTRIGGER');
			$this->db->JOIN(ENTITY.' as ENTITY','PDTRIGGER.fk_lender_id = ENTITY.entity_id');
			$this->db->JOIN(PRODUCTS.' as PRODUCTS','PDTRIGGER.fk_product_id = PRODUCTS.product_id');
			$this->db->JOIN(SUBPRODUCTS.' as SUBPRODUCTS','PDTRIGGER.fk_subproduct_id = SUBPRODUCTS.subproduct_id');
			$this->db->JOIN(PDTYPE.' as PDTYPE','PDTRIGGER.fk_pd_type = PDTYPE.pd_type_id');
			$this->db->JOIN(PDSTATUS.' as PDSTATUS','PDTRIGGER.fk_pd_status = PDSTATUS.pd_status_id','LEFT');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE','PDTRIGGER.fk_createdby = USERPROFILE.userid');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE1','PDTRIGGER.fk_updatedby = USERPROFILE1.userid','LEFT');
			$this->db->JOIN(PDALLOCATIONTYPE.' as PDALLOCATIONTYPE','PDTRIGGER.fk_pd_allocation_type = PDALLOCATIONTYPE.pd_allocation_type_id');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE2','PDTRIGGER.fk_pd_allocated_to = USERPROFILE2.userid','LEFT');
			$this->db->JOIN(TEMPLATE.' as TEMPLATE','PDTRIGGER.fk_pd_template_id = TEMPLATE.template_id','LEFT');
			$this->db->JOIN(CUSTOMERSEGMENT.' as CUSTOMERSEGMENT','PDTRIGGER.fk_customer_segment = CUSTOMERSEGMENT.customer_segment_id');
			$this->db->JOIN(ENTITY.' as AGENCY','PDTRIGGER.pd_agency_id = AGENCY.entity_id','LEFT');
			$this->db->JOIN(STATE.' as STATE','PDTRIGGER.fk_state = STATE.state_id ');
			$this->db->JOIN(CITY.' as CITY','PDTRIGGER.fk_city = CITY.city_id');
			$this->db->ORDER_BY('PDTRIGGER.pd_id',$sort);
			$this->db->LIMIT($limit,$page);
			$result_array = $this->db->GET()->result_array();
			if(count($result_array) != 0)
			{
				foreach($result_array as $key => $result)
				{
					
					$this->db->SELECT('PDAPPLICANTSDETAILS.pd_co_applicant_id, PDAPPLICANTSDETAILS.fk_pd_id, PDAPPLICANTSDETAILS.applicant_name, PDAPPLICANTSDETAILS.applicant_type, PDAPPLICANTSDETAILS.mobile_no, PDAPPLICANTSDETAILS.email, PDAPPLICANTSDETAILS.addressline1, PDAPPLICANTSDETAILS.addressline2, PDAPPLICANTSDETAILS.addressline3, PDAPPLICANTSDETAILS.fk_city, PDAPPLICANTSDETAILS.fk_state, PDAPPLICANTSDETAILS.pincode,PDAPPLICANTSDETAILS.relation');
					$this->db->FROM(PDAPPLICANTSDETAILS.' as PDAPPLICANTSDETAILS');
					$this->db->JOIN(STATE.' as STATE','PDAPPLICANTSDETAILS.fk_state = STATE.state_id','LEFT');
					$this->db->JOIN(CITY.' as CITY','PDAPPLICANTSDETAILS.fk_city = CITY.city_id','LEFT');
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
		$this->db->SELECT('PDLOGS.pd_id, PDLOGS.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name, PDLOGS.lender_applicant_id, DATE_FORMAT(PDLOGS.pd_date_of_initiation, "%d/%m/%Y") as pd_date_of_initiation, PDLOGS.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, PDLOGS.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name,SUBPRODUCTS.abbr as subproduct_abbr, PDLOGS.fk_pd_type,PDTYPE.type_name as pd_type_name, PDLOGS.fk_pd_status,PDSTATUS.pd_status_name, PDLOGS.pd_specific_clarification, DATE_FORMAT(PDLOGS.createdon,"%d/%m/%Y %H:%i:%s") as createdon, PDLOGS.fk_createdby, DATE_FORMAT(PDLOGS.updatedon,"%d/%m/%Y %H:%i:%s") as updatedon, PDLOGS.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDLOGS.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDLOGS.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDLOGS.fk_pd_template_id,TEMPLATE.template_name, PDLOGS.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name,CUSTOMERSEGMENT.abbr as customer_segment_abbr, PDLOGS.pd_officier_final_judgement, PDLOGS.pd_agency_id,AGENCY.full_name as agency_name, PDLOGS.loan_amount,PDLOGS.addressline1,PDLOGS.addressline2,PDLOGS.addressline3,PDLOGS.fk_city,CITY.name as city_name,PDLOGS.fk_state,STATE.name as state_name,PDLOGS.pincode');
			$this->db->FROM(PDLOGS.' as PDLOGS');
			$this->db->JOIN(ENTITY.' as ENTITY','PDLOGS.fk_lender_id = ENTITY.entity_id ');
			$this->db->JOIN(PRODUCTS.' as PRODUCTS','PDLOGS.fk_product_id = PRODUCTS.product_id');
			$this->db->JOIN(SUBPRODUCTS.' as SUBPRODUCTS','PDLOGS.fk_subproduct_id = SUBPRODUCTS.subproduct_id');
			$this->db->JOIN(PDTYPE.' as PDTYPE','PDLOGS.fk_pd_type = PDTYPE.pd_type_id');
			$this->db->JOIN(PDSTATUS.' as PDSTATUS','PDLOGS.fk_pd_status = PDSTATUS.pd_status_id');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE','PDLOGS.fk_createdby = USERPROFILE.userid');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE1','PDLOGS.fk_updatedby = USERPROFILE1.userid','LEFT');
			$this->db->JOIN(PDALLOCATIONTYPE.' as PDALLOCATIONTYPE','PDLOGS.fk_pd_allocation_type = PDALLOCATIONTYPE.pd_allocation_type_id');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE2','PDLOGS.fk_pd_allocated_to = USERPROFILE2.userid');
			$this->db->JOIN(TEMPLATE.' as TEMPLATE','PDLOGS.fk_pd_template_id = TEMPLATE.template_id');
			$this->db->JOIN(CUSTOMERSEGMENT.' as CUSTOMERSEGMENT','PDLOGS.fk_customer_segment = CUSTOMERSEGMENT.customer_segment_id');
			$this->db->JOIN(ENTITY.' as AGENCY','PDLOGS.pd_agency_id = AGENCY.entity_id','LEFT');
			$this->db->JOIN(STATE.' as STATE','PDLOGS.fk_state = STATE.state_id ');
			$this->db->JOIN(CITY.' as CITY','PDLOGS.fk_city = CITY.city_id');
			$this->db->WHERE('PDLOGS.pd_id ',$pdid);
			//$this->db->ORDER_BY('PDLOGS.pd_id',$sort);
			//$this->db->LIMIT($limit,$page);
			$result_array['pd_master_logs'] = $this->db->GET()->result_array();
			
			
			$this->db->SELECT('PDAPPLICANTSLOGS.pd_co_applicant_id, PDAPPLICANTSLOGS.fk_pd_id, PDAPPLICANTSLOGS.applicant_name, PDAPPLICANTSLOGS.applicant_type, PDAPPLICANTSLOGS.mobile_no, PDAPPLICANTSLOGS.email, PDAPPLICANTSLOGS.addressline1, PDAPPLICANTSLOGS.addressline2, PDAPPLICANTSLOGS.addressline3, PDAPPLICANTSLOGS.fk_city, PDAPPLICANTSLOGS.fk_state, PDAPPLICANTSLOGS.pincode,PDAPPLICANTSLOGS.relation');
			$this->db->FROM(PDAPPLICANTSLOGS.' as PDAPPLICANTSLOGS');
			$this->db->JOIN(STATE.' as STATE','PDAPPLICANTSLOGS.fk_state = STATE.state_id');
			$this->db->JOIN(CITY.' as CITY','PDAPPLICANTSLOGS.fk_city = CITY.city_id');
			$this->db->WHERE('PDAPPLICANTSLOGS.fk_pd_id ',$pdid);
			$result_array['pd_applicants_logs'] = $this->db->GET()->result_array();
			
			return $result_array;
	}
	
	/*
	*Get Completed PD Questions and Answers.
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
		$this->db->SELECT('PDTRIGGER.pd_id, PDTRIGGER.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name, PDTRIGGER.lender_applicant_id, DATE_FORMAT(PDTRIGGER.pd_date_of_initiation, "%d/%m/%Y") as pd_date_of_initiation, PDTRIGGER.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, PDTRIGGER.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name,SUBPRODUCTS.abbr as subproduct_abbr, PDTRIGGER.fk_pd_type,PDTYPE.type_name as pd_type_name, PDTRIGGER.fk_pd_status,PDSTATUS.pd_status_name, PDTRIGGER.pd_specific_clarification, DATE_FORMAT(PDTRIGGER.createdon,"%d/%m/%Y %H:%i:%s") as createdon, PDTRIGGER.fk_createdby, DATE_FORMAT(PDTRIGGER.updatedon,"%d/%m/%Y %H:%i:%s") as updatedon, PDTRIGGER.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDTRIGGER.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDTRIGGER.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDTRIGGER.fk_pd_template_id,TEMPLATE.template_name, PDTRIGGER.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name,CUSTOMERSEGMENT.abbr as customer_segment_abbr, PDTRIGGER.pd_officier_final_judgement, PDTRIGGER.pd_agency_id,AGENCY.full_name as agency_name, PDTRIGGER.loan_amount,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode');
			$this->db->FROM(PDTRIGGER.' as PDTRIGGER');
			$this->db->JOIN(ENTITY.' as ENTITY','PDTRIGGER.fk_lender_id = ENTITY.entity_id ','LEFT');
			$this->db->JOIN(PRODUCTS.' as PRODUCTS','PDTRIGGER.fk_product_id = PRODUCTS.product_id','LEFT');
			$this->db->JOIN(SUBPRODUCTS.' as SUBPRODUCTS','PDTRIGGER.fk_subproduct_id = SUBPRODUCTS.subproduct_id','LEFT');
			$this->db->JOIN(PDTYPE.' as PDTYPE','PDTRIGGER.fk_pd_type = PDTYPE.pd_type_id','LEFT');
			$this->db->JOIN(PDSTATUS.' as PDSTATUS','PDTRIGGER.fk_pd_status = PDSTATUS.pd_status_id','LEFT');
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
}