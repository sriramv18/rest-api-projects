<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class Template_Management_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
        }
		
		
   public function listAllUsers()
   {
	   $result_data = array();
	   
	   $this->select('USERPROFILE.userid, USERPROFILE.aws_name, USERPROFILE.first_name, USERPROFILE.last_name, USERPROFILE.email, USERPROFILE.alt_email, USERPROFILE.mobile_no, USERPROFILE.alt_mobile_no, USERPROFILE.addressline1, USERPROFILE.addressline2, USERPROFILE.profilepic, USERPROFILE.createdon, USERPROFILE.fk_createdby,USERPROFILE1.first_name,USERPROFILE1.last_name, USERPROFILE.updatedon, USERPROFILE.fk_updatedby,USERPROFILE2.first_name,USERPROFILE2.last_name, USERPROFILE.fk_entity_id,ENTITY.full_name, USERPROFILE.isactive, USERPROFILE.fk_designation,DESIGNATION.name, USERPROFILE.addressline3, USERPROFILE.fk_city,CITY.name, USERPROFILE.fk_state,STATE.name, USERPROFILE.pincode');
	   $this->db->from(USERPROFILE.'as USERPROFILE');
	   $this->db->join(ENTITY.'as ENTITY','USERPROFILE.fk_entity_id = ENTITY.entity_id and ENTITY.isactive = 1');
	   $this->db->join(DESIGNATION.'as DESIGNATION','USERPROFILE.fk_designation = DESIGNATION.designation_id and DESIGNATION.isactive = 1');
	   $this->db->join(STATE.'as STATE','USERPROFILE.fk_state = STATE.state_id and STATE.isactive = 1');
	   $this->db->join(CITY.'as CITY','USERPROFILE.fk_city = CITY.city_id and CITY.isactive = 1');
	   $this->db->join(USERPROFILE.'as USERPROFILE1','USERPROFILE.fk_createdby = USERPROFILE1.userid and USERPROFILE1.isactive = 1');
	   $this->db->join(USERPROFILE.'as USERPROFILE2','USERPROFILE.fk_updatedby = USERPROFILE2.userid and USERPROFILE2.isactive = 1');
	   $this->db->join(USERPROFILEHIERARCHY.'as USERPROFILEHIERARCHY','USERPROFILE.userid = USERPROFILEHIERARCHY.fk_user_id and LENDERHIERARCHY.isactive = 1','LEFT');
	   $this->db->join(LENDERHIERARCHY.'as LENDERHIERARCHY','USERPROFILEHIERARCHY.user_lender_hierarchy_id = LENDERHIERARCHY.lender_hierarchy_id and LENDERHIERARCHY.isactive = 1');
	   $this->db->join(USERPROFILEROLES.'as USERPROFILEROLES','USERPROFILE.userid = USERPROFILEROLES.fk_user_id and USERPROFILEROLES.isactive = 1');
	   //$this->db->where('USERPROFILE.isactive = 1');
	   $result = $this->db->get()->result_array();
	   
	   if(count($result) > 0 )
	   {
		   $result_data['data_status'] = true;
		   $result_data['data'] = $result;
		   return $result_data;
		   
	   }
	   else
	   {
		  $result_data['data_status'] = false;
		  $result_data['data'] =  null;
		  return $result_data;
	   }
	   
   }

}