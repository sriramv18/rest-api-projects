<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class User_Management_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
			$this->load->library('AWS_S3');
        }
		
		
   public function listAllUsers()
   {

	   $result_data = array();
	   
	   $this->db->select('USERPROFILE.userid, USERPROFILE.aws_name, USERPROFILE.first_name as user_first_name, USERPROFILE.last_name as user_last_name, USERPROFILE.email, USERPROFILE.alt_email, USERPROFILE.mobile_no, USERPROFILE.alt_mobile_no, USERPROFILE.addressline1, USERPROFILE.addressline2, USERPROFILE.profilepic, USERPROFILE.createdon, USERPROFILE.fk_createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as created_full_name, USERPROFILE.updatedon, USERPROFILE.fk_updatedby,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name)as update_full_name, USERPROFILE.fk_entity_id,ENTITY.full_name, USERPROFILE.isactive, USERPROFILE.fk_designation,DESIGNATION.name, USERPROFILE.addressline3, USERPROFILE.fk_city,CITY.name as city_name, USERPROFILE.fk_state,STATE.name as state_name, USERPROFILE.pincode');
	   $this->db->from(USERPROFILE.' as USERPROFILE');
	   $this->db->join(ENTITY.' as ENTITY','USERPROFILE.fk_entity_id = ENTITY.entity_id and ENTITY.isactive = 1','LEFT');
	   $this->db->join(DESIGNATION.' as DESIGNATION','USERPROFILE.fk_designation = DESIGNATION.designation_id and DESIGNATION.isactive = 1');
	   $this->db->join(STATE.' as STATE','USERPROFILE.fk_state = STATE.state_id and STATE.isactive = 1');
	   $this->db->join(CITY.' as CITY','USERPROFILE.fk_city = CITY.city_id and CITY.isactive = 1');
	   $this->db->join(USERPROFILE.' as USERPROFILE1','USERPROFILE.fk_createdby = USERPROFILE1.userid and USERPROFILE1.isactive = 1','LEFT');
	   $this->db->join(USERPROFILE.' as USERPROFILE2','USERPROFILE.fk_updatedby = USERPROFILE2.userid and USERPROFILE2.isactive = 1','LEFT');
	   $this->db->join(USERPROFILEHIERARCHY.' as USERPROFILEHIERARCHY','USERPROFILE.userid = USERPROFILEHIERARCHY.fk_user_id and USERPROFILEHIERARCHY.isactive = 1','LEFT');
	   $this->db->join(LENDERHIERARCHY.' as LENDERHIERARCHY','USERPROFILEHIERARCHY.user_lender_hierarchy_id = LENDERHIERARCHY.lender_hierarchy_id and LENDERHIERARCHY.isactive = 1','LEFT');
	   
	   $this->db->join(ENTITYTYPE.' as ENTITYTYPE','ENTITY.fk_entity_type_id = ENTITYTYPE.entity_type_id and ENTITYTYPE.isactive = 1','LEFT');
	   //$this->db->where('USERPROFILE.isactive = 1');

	   
	   $result = $this->db->get()->result_array();
	 
	   // foreach($result as $key => $pics)
	   // {
		   // if($pics['profilepic'] != '' ||  $pics['profilepic'] != null)
		   // {
			  // $profilepics3path = '';
							// if($pics['fk_entity_id'] == 1) //1 means sine_edge Profile
							// {
								// $profilepics3path = 'sineedge/'.$pics['profilepic'];
							// }
							// else if($pics['fk_entity_id'] == 2)//1 means lender Profile
							// {
								// $profilepics3path = 'lender/'.$pics['profilepic'];
							// }
							// else // else or 3 means vendor Profile
							// {
								// $profilepics3path = 'vendor/'.$pics['profilepic'];
							// }
							// $singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI(PROFILE_PICTURE_BUCKET_NAME, $profilepics3path,'+5 minutes');
							
							// $result[$key]['profilepic_singed_url'] = $singed_uri;
							
		   // }
	   // }
	   
	   if($result != '' ){
	   	
	   		foreach($result as $key =>$roles){
	   			$role = $this->db->get_where(USERPROFILEROLES.' as USERPROFILEROLES',array('fk_userid'=>$roles['userid'],'isactive'=>1))->result_array();
	   			array_push($result[$key], $role);	
	   		}

	   }
	   // print_r($result);die;
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
   
  

   public function getUserDetails($userid){

   	$this->db->select('USERPROFILE.userid, USERPROFILE.aws_name, concat(USERPROFILE.first_name," ", USERPROFILE.last_name) as user_full_name, USERPROFILE.email, USERPROFILE.alt_email, USERPROFILE.mobile_no, USERPROFILE.alt_mobile_no, USERPROFILE.addressline1, USERPROFILE.addressline2, USERPROFILE.profilepic, USERPROFILE.createdon, USERPROFILE.fk_createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as created_full_name, USERPROFILE.updatedon, USERPROFILE.fk_updatedby,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name)as update_full_name, USERPROFILE.fk_entity_id,ENTITY.full_name, USERPROFILE.isactive, USERPROFILE.fk_designation,DESIGNATION.name, USERPROFILE.addressline3, USERPROFILE.fk_city,CITY.name as city_name, USERPROFILE.fk_state,STATE.name as state_name, USERPROFILE.pincode,USERPROFILEROLES.user_role_id,USERPROFILEROLES.user_role');
	   $this->db->from(USERPROFILE.' as USERPROFILE');
	   $this->db->join(ENTITY.' as ENTITY','USERPROFILE.fk_entity_id = ENTITY.entity_id and ENTITY.isactive = 1','LEFT');
	   $this->db->join(DESIGNATION.' as DESIGNATION','USERPROFILE.fk_designation = DESIGNATION.designation_id and DESIGNATION.isactive = 1');
	   $this->db->join(STATE.' as STATE','USERPROFILE.fk_state = STATE.state_id and STATE.isactive = 1');
	   $this->db->join(CITY.' as CITY','USERPROFILE.fk_city = CITY.city_id and CITY.isactive = 1');
	   $this->db->join(USERPROFILE.' as USERPROFILE1','USERPROFILE.fk_createdby = USERPROFILE1.userid and USERPROFILE1.isactive = 1');
	   $this->db->join(USERPROFILE.' as USERPROFILE2','USERPROFILE.fk_updatedby = USERPROFILE2.userid and USERPROFILE2.isactive = 1','LEFT');
	   $this->db->join(USERPROFILEHIERARCHY.' as USERPROFILEHIERARCHY','USERPROFILE.userid = USERPROFILEHIERARCHY.fk_user_id and USERPROFILEHIERARCHY.isactive = 1','LEFT');
	   $this->db->join(LENDERHIERARCHY.' as LENDERHIERARCHY','USERPROFILEHIERARCHY.user_lender_hierarchy_id = LENDERHIERARCHY.lender_hierarchy_id and LENDERHIERARCHY.isactive = 1','LEFT');
	   $this->db->join(USERPROFILEROLES.' as USERPROFILEROLES','USERPROFILE.userid = USERPROFILEROLES.fk_userid and USERPROFILEROLES.isactive = 1');
	   $this->db->join(ENTITYTYPE.' as ENTITYTYPE','ENTITY.fk_entity_type_id = ENTITYTYPE.entity_type_id and ENTITYTYPE.isactive = 1','LEFT');
	   
	   $this->db->where('USERPROFILE.userid',$userid);

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