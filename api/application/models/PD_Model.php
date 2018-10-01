<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class PD_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
        }
		
	
		public function listLessPDDetails($page,$limit,$sort)// $page represents mysql offset
		{
			$this->db->SELECT('PDTRIGGER.pd_id, PDTRIGGER.fk_lender_id,ENTITY.full_name as lender_full_name,ENTITY.short_name as lender_short_name, PDTRIGGER.lender_applicant_id, PDTRIGGER.pd_date_of_initiation, PDTRIGGER.fk_product_id,PRODUCTS.name as product_name, PDTRIGGER.fk_subproduct_id,SUBPRODUCTS.name as subproduct_name, PDTRIGGER.fk_pd_type,PDTYPE.type_name as pd_type_name, PDTRIGGER.fk_pd_status,PDSTATUS.pd_status_name, PDTRIGGER.pd_specific_clarification, PDTRIGGER.createdon, PDTRIGGER.fk_createdby, PDTRIGGER.updatedon, PDTRIGGER.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, PDTRIGGER.fk_pd_allocation_type,,PDALLOCATIONTYPE.pd_allocation_type_name, PDTRIGGER.fk_pd_allocated_to,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name) as pd_allocated_to,PDTRIGGER.fk_pd_template_id,TEMPLATE.template_name, PDTRIGGER.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name, PDTRIGGER.pd_officier_final_judgement, PDTRIGGER.pd_agency_id,AGENCY.full_name as agency_name, PDTRIGGER.loan_amount,PDTRIGGER.addressline1,PDTRIGGER.addressline2,PDTRIGGER.addressline3,PDTRIGGER.fk_city,CITY.name as city_name,PDTRIGGER.fk_state,STATE.name as state_name,PDTRIGGER.pincode');
			$this->db->FROM(PDTRIGGER.' as PDTRIGGER');
			$this->db->JOIN(ENTITY.' as ENTITY','PDTRIGGER.fk_lender_id = ENTITY.entity_id ');
			$this->db->JOIN(PRODUCTS.' as PRODUCTS','PDTRIGGER.fk_product_id = PRODUCTS.product_id');
			$this->db->JOIN(SUBPRODUCTS.' as SUBPRODUCTS','PDTRIGGER.fk_subproduct_id = SUBPRODUCTS.subproduct_id');
			$this->db->JOIN(PDTYPE.' as PDTYPE','PDTRIGGER.fk_pd_type = PDTYPE.pd_type_id');
			$this->db->JOIN(PDSTATUS.' as PDSTATUS','PDTRIGGER.fk_pd_status = PDSTATUS.pd_status_id');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE','PDTRIGGER.fk_createdby = USERPROFILE.userid');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE1','PDTRIGGER.fk_updatedby = USERPROFILE1.userid','LEFT');
			$this->db->JOIN(PDALLOCATIONTYPE.' as PDALLOCATIONTYPE','PDTRIGGER.fk_pd_allocation_type = PDALLOCATIONTYPE.pd_allocation_type_id');
			$this->db->JOIN(USERPROFILE.' as USERPROFILE2','PDTRIGGER.fk_pd_allocated_to = USERPROFILE2.userid');
			$this->db->JOIN(TEMPLATE.' as TEMPLATE','PDTRIGGER.fk_pd_template_id = TEMPLATE.template_id');
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
					
					$this->db->SELECT('PDAPPLICANTSDETAILS.pd_co_applicant_id, PDAPPLICANTSDETAILS.fk_pd_id, PDAPPLICANTSDETAILS.applicant_name, PDAPPLICANTSDETAILS.applicant_type, PDAPPLICANTSDETAILS.mobile_no, PDAPPLICANTSDETAILS.email, PDAPPLICANTSDETAILS.addressline1, PDAPPLICANTSDETAILS.addressline2, PDAPPLICANTSDETAILS.addressline3, PDAPPLICANTSDETAILS.fk_city, PDAPPLICANTSDETAILS.fk_state, PDAPPLICANTSDETAILS.pincode');
					$this->db->FROM(PDAPPLICANTSDETAILS.' as PDAPPLICANTSDETAILS');
					$this->db->JOIN(STATE.' as STATE','PDAPPLICANTSDETAILS.fk_state = STATE.state_id ');
					$this->db->JOIN(CITY.' as CITY','PDAPPLICANTSDETAILS.fk_city = CITY.city_id');
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
}