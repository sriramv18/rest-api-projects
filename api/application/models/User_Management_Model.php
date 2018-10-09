<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class User_Management_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
        }
		
		
   public function listAllUsers()
   {

	   $result_data = array();
	   
	   $this->db->select('USERPROFILE.userid, USERPROFILE.aws_name, USERPROFILE.first_name as user_first_name, USERPROFILE.last_name as user_last_name, USERPROFILE.email, USERPROFILE.mobile_no,  USERPROFILE.profilepic, USERPROFILE.createdon, USERPROFILE.fk_createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as created_full_name, USERPROFILE.updatedon, USERPROFILE.fk_updatedby,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name)as update_full_name, USERPROFILE.fk_entity_id,ENTITY.full_name, USERPROFILE.isactive, USERPROFILE.fk_city,CITY.name as city_name, USERPROFILE.fk_state,STATE.name as state_name, PDOFFICIERSDETAILS.fk_pd_type_id,PDOFFICIERSDETAILS.fk_team_id,USERPROFILEROLES.user_role,USERPROFILE.fk_entity_type_id');
	   $this->db->from(USERPROFILE.' as USERPROFILE');
	   $this->db->join(ENTITY.' as ENTITY','USERPROFILE.fk_entity_id = ENTITY.entity_id and ENTITY.isactive = 1','LEFT');
	   $this->db->join(STATE.' as STATE','USERPROFILE.fk_state = STATE.state_id and STATE.isactive = 1','LEFT');
	   $this->db->join(CITY.' as CITY','USERPROFILE.fk_city = CITY.city_id and CITY.isactive = 1','LEFT');
	   $this->db->join(USERPROFILE.' as USERPROFILE1','USERPROFILE.fk_createdby = USERPROFILE1.userid and USERPROFILE1.isactive = 1','LEFT');
	   $this->db->join(USERPROFILE.' as USERPROFILE2','USERPROFILE.fk_updatedby = USERPROFILE2.userid and USERPROFILE2.isactive = 1','LEFT');
	   $this->db->join(USERPROFILEROLES. ' as USERPROFILEROLES','USERPROFILEROLES.fk_userid = USERPROFILE.userid and USERPROFILEROLES.isactive =1');
	   $this->db->join(ENTITYTYPE.' as ENTITYTYPE','ENTITY.fk_entity_type_id = ENTITYTYPE.entity_type_id and ENTITYTYPE.isactive = 1','LEFT');
	   $this->db->join(PDOFFICIERSDETAILS.' as PDOFFICIERSDETAILS','PDOFFICIERSDETAILS.fk_user_id = USERPROFILE.userid and PDOFFICIERSDETAILS.isactive = 1','LEFT');
	   
	   

	   

	   $result = $this->db->get()->result_array();
	  
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

	$this->db->select('USERPROFILE.userid, USERPROFILE.aws_name, USERPROFILE.first_name as user_first_name, USERPROFILE.last_name as user_last_name, USERPROFILE.email, USERPROFILE.mobile_no,  USERPROFILE.profilepic, USERPROFILE.createdon, USERPROFILE.fk_createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as created_full_name, USERPROFILE.updatedon, USERPROFILE.fk_updatedby,concat(USERPROFILE2.first_name," ",USERPROFILE2.last_name)as update_full_name, USERPROFILE.fk_entity_id,ENTITY.full_name, USERPROFILE.isactive, USERPROFILE.fk_city,CITY.name as city_name, USERPROFILE.fk_state,STATE.name as state_name, PDOFFICIERSDETAILS.fk_pd_type_id,PDOFFICIERSDETAILS.fk_team_id,USERPROFILE.fk_entity_type_id,USERPROFILEROLES.user_role');
	   $this->db->from(USERPROFILE.' as USERPROFILE');
	   $this->db->join(ENTITY.' as ENTITY','USERPROFILE.fk_entity_id = ENTITY.entity_id and ENTITY.isactive = 1','LEFT');
	   $this->db->join(STATE.' as STATE','USERPROFILE.fk_state = STATE.state_id and STATE.isactive = 1','LEFT');
	   $this->db->join(CITY.' as CITY','USERPROFILE.fk_city = CITY.city_id and CITY.isactive = 1','LEFT');
	   $this->db->join(USERPROFILE.' as USERPROFILE1','USERPROFILE.fk_createdby = USERPROFILE1.userid and USERPROFILE1.isactive = 1','LEFT');
	   $this->db->join(USERPROFILE.' as USERPROFILE2','USERPROFILE.fk_updatedby = USERPROFILE2.userid and USERPROFILE2.isactive = 1','LEFT');
	   $this->db->join(USERPROFILEROLES. ' as USERPROFILEROLES','USERPROFILEROLES.fk_userid = USERPROFILE.userid and USERPROFILEROLES.isactive =1');
	   $this->db->join(ENTITYTYPE.' as ENTITYTYPE','ENTITY.fk_entity_type_id = ENTITYTYPE.entity_type_id and ENTITYTYPE.isactive = 1','LEFT');
	   $this->db->join(PDOFFICIERSDETAILS.' as PDOFFICIERSDETAILS','PDOFFICIERSDETAILS.fk_user_id = USERPROFILE.userid and PDOFFICIERSDETAILS.isactive = 1','LEFT');
	   
	   

	   $this->db->where('USERPROFILE.userid',$userid);

	   $result = $this->db->get()->result_array();
	  
	   if(count($result) != 0 )
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