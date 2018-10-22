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
			$this->db->SELECT('PDTRIGGER.pd_id, PDTRIGGER.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name,PDTRIGGER.fk_entity_billing_id,ENTITYBILLING.billing_name, PDTRIGGER.lender_applicant_id, DATE_FORMAT(PDTRIGGER.pd_date_of_initiation, "%d/%m/%Y") as pd_date_of_initiation, PDTRIGGER.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, PDTRIGGER.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name,SUBPRODUCTS.abbr as subproduct_abbr, PDTRIGGER.fk_pd_type,PDTYPE.type_name as pd_type_name, PDTRIGGER.pd_status,PDSTATUS.pd_status_name, PDTRIGGER.pd_specific_clarification, DATE_FORMAT(PDTRIGGER.createdon,"%d/%m/%Y %H:%i:%s") as createdon, PDTRIGGER.fk_createdby, DATE_FORMAT(PDTRIGGER.updatedon,"%d/%m/%Y %H:%i:%s") as updatedon, PDTRIGGER.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDTRIGGER.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDTRIGGER.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDTRIGGER.fk_pd_template_id,TEMPLATE.template_name, PDTRIGGER.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name,CUSTOMERSEGMENT.abbr as customer_segment_abbr, PDTRIGGER.pd_officier_final_judgement, PDTRIGGER.pd_agency_id,AGENCY.full_name as agency_name, PDTRIGGER.loan_amount,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode,PDTRIGGER.pd_contact_person,PDTRIGGER.pd_contact_mobileno,DATE_FORMAT(PDTRIGGER.scheduled_on,"%d/%m/%Y ") as scheduled_on,DATE_FORMAT(PDTRIGGER.completed_on,"%d/%m/%Y") as completed_on');
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
		$this->db->SELECT('PDLOGS.pd_id, PDLOGS.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name, PDLOGS.lender_applicant_id, DATE_FORMAT(PDLOGS.pd_date_of_initiation, "%d/%m/%Y") as pd_date_of_initiation, PDLOGS.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, PDLOGS.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name,SUBPRODUCTS.abbr as subproduct_abbr, PDLOGS.fk_pd_type,PDTYPE.type_name as pd_type_name, PDLOGS.pd_status,PDSTATUS.pd_status_name, PDLOGS.pd_specific_clarification, DATE_FORMAT(PDLOGS.createdon,"%d/%m/%Y %H:%i:%s") as createdon, PDLOGS.fk_createdby, DATE_FORMAT(PDLOGS.updatedon,"%d/%m/%Y %H:%i:%s") as updatedon, PDLOGS.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDLOGS.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDLOGS.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDLOGS.fk_pd_template_id,TEMPLATE.template_name, PDLOGS.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name,CUSTOMERSEGMENT.abbr as customer_segment_abbr, PDLOGS.pd_officier_final_judgement, PDLOGS.pd_agency_id,AGENCY.full_name as agency_name, PDLOGS.loan_amount,PDLOGS.addressline1,PDLOGS.addressline2,PDLOGS.addressline3,PDLOGS.fk_city,CITY.name as city_name,PDLOGS.fk_state,STATE.name as state_name,PDLOGS.pincode');
			$this->db->FROM(PDLOGS.' as PDLOGS');
			$this->db->JOIN(ENTITY.' as ENTITY','PDLOGS.fk_lender_id = ENTITY.entity_id ');
			$this->db->JOIN(PRODUCTS.' as PRODUCTS','PDLOGS.fk_product_id = PRODUCTS.product_id');
			$this->db->JOIN(SUBPRODUCTS.' as SUBPRODUCTS','PDLOGS.fk_subproduct_id = SUBPRODUCTS.subproduct_id');
			$this->db->JOIN(PDTYPE.' as PDTYPE','PDLOGS.fk_pd_type = PDTYPE.pd_type_id');
			$this->db->JOIN(PDSTATUS.' as PDSTATUS','PDLOGS.pd_status = PDSTATUS.pd_status_id');
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
		$this->db->SELECT('PDTRIGGER.pd_id, PDTRIGGER.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name, PDTRIGGER.fk_entity_billing_id,ENTITYBILLING.billing_name,PDTRIGGER.lender_applicant_id, DATE_FORMAT(PDTRIGGER.pd_date_of_initiation, "%d/%m/%Y") as pd_date_of_initiation, PDTRIGGER.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, PDTRIGGER.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name,SUBPRODUCTS.abbr as subproduct_abbr, PDTRIGGER.fk_pd_type,PDTYPE.type_name as pd_type_name, PDTRIGGER.pd_status,PDSTATUS.pd_status_name, PDTRIGGER.pd_specific_clarification, DATE_FORMAT(PDTRIGGER.createdon,"%d/%m/%Y %H:%i:%s") as createdon, PDTRIGGER.fk_createdby, DATE_FORMAT(PDTRIGGER.updatedon,"%d/%m/%Y %H:%i:%s") as updatedon, PDTRIGGER.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDTRIGGER.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDTRIGGER.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDTRIGGER.fk_pd_template_id,TEMPLATE.template_name, PDTRIGGER.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name,CUSTOMERSEGMENT.abbr as customer_segment_abbr, PDTRIGGER.pd_officier_final_judgement, PDTRIGGER.pd_agency_id,AGENCY.full_name as agency_name, PDTRIGGER.loan_amount,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode,PDTRIGGER.pd_contact_person,PDTRIGGER.pd_contact_mobileno,DATE_FORMAT(PDTRIGGER.scheduled_on,"%d/%m/%Y") as scheduled_on,DATE_FORMAT(PDTRIGGER.completed_on,"%d/%m/%Y") as completed_on');
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
				$this->db->JOIN(QUESTIONS.' as QUESTIONS','TEMPLATEQUESTION.fk_question_id = QUESTIONS.question_id','LEFT');
				$this->db->JOIN(QUESTIONANSWERTYPE.' as QUESTIONANSWERTYPE','QUESTIONS.fk_question_answertype = QUESTIONANSWERTYPE.question_answer_type_id','LEFT');
				$this->db->JOIN(PDDETAIL.' as PDDETAIL',"QUESTIONS.question_id = PDDETAIL.fk_question_id AND PDDETAIL.fk_pd_id = $pdid",'LEFT');
				// $this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATEQUESTION.fk_createdby = USERPROFILE.userid','LEFT');
				// $this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATEQUESTION.fk_updatedby = USERPROFILE1.userid','LEFT');
				$this->db->WHERE('TEMPLATEQUESTION.fk_template_question_category_id',$category['fk_question_category_id']);
				//$this->db->WHERE('TEMPLATEQUESTION.fk_template_id',$template_id);
				
				$questions = $this->db->GET()->result_array();
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
						  // $this->db->SELECT('QUESTIONANSWERS.question_answer_id,QUESTIONANSWERS.answer,TEMPLATEANSWERWEIGHTAGE.template_answer_weightage_id, TEMPLATEANSWERWEIGHTAGE.fk_template_question_id, TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id, TEMPLATEANSWERWEIGHTAGE.template_answer_weightage,PDDETAIL.pd_detail_id');
						  // $this->db->FROM(TEMPLATEANSWERWEIGHTAGE.' as TEMPLATEANSWERWEIGHTAGE');
						  // $this->db->JOIN(QUESTIONANSWERS.' as QUESTIONANSWERS','TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id = QUESTIONANSWERS.question_answer_id','LEFT');
						  // $this->db->JOIN(PDDETAIL.' as PDDETAIL',"QUESTIONANSWERS.question_answer_id = PDDETAIL.pd_answer_id AND PDDETAIL.fk_pd_id = $pd_id",'LEFT');
						 // // $this->db->WHERE('QUESTIONANSWERS.fk_question_id',$question['question_id']);
						  // $this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_template_question_id',$question_id);
						 // //$this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_question_category_id',$category_id);
						  // //$this->db->WHERE('TEMPLATEANSWERWEIGHTAGE.fk_template_id',$template_id);
						 // // $this->db->WHERE('PDDETAIL.fk_pd_id',$pdid);
						  // $answers = $this->db->GET()->result_array();
						  // print_r($answers);
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