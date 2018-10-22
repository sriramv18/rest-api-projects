<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class Entity_Management_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
        }
		
		
   public function listAllEntities($page,$limit,$sort,$entity_type_id)
   {
	   $result_data = array();
	   
	  $this->db->SELECT('ENTITY.entity_id, ENTITY.full_name, ENTITY.short_name,ENTITY.createdon, ENTITY.fk_createdby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby, ENTITY.updatedon, ENTITY.fk_updatedby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby, ENTITY.isactive,ENTITY.fk_entity_type_id,ENTITYTYPE.name as entity_name');
	  $this->db->FROM(ENTITY.' as ENTITY');	
	  $this->db->JOIN(USERPROFILE.' as USERPROFILE','ENTITY.fk_createdby = USERPROFILE.userid','LEFT');
	  $this->db->JOIN(USERPROFILE.' as USERPROFILE1','ENTITY.fk_updatedby = USERPROFILE1.userid','LEFT');
	  $this->db->JOIN(ENTITYTYPE.' as ENTITYTYPE','ENTITY.fk_entity_type_id = ENTITYTYPE.entity_type_id');
	  if($entity_type_id != null || $entity_type_id != '')
	   {
		    $this->db->WHERE('ENTITY.fk_entity_type_id',$entity_type_id);
	   }
	   $this->db->ORDER_BY('ENTITY.fk_entity_type_id',$sort);
	   $this->db->LIMIT($page,$limit);
	
	    
	   $result = $this->db->get()->result_array();
	   
	   // foreach($result as $key => $r)
	   // {
		   // $this->db->SELECT('ENTITYCHILD.entity_child_id,ENTITYCHILD.contact_person,ENTITYCHILD.contact_email,ENTITYCHILD.contact_mobile_no,ENTITYCHILD.contact_person,ENTITYCHILD.isactive,ENTITYCHILD.createdon,ENTITYCHILD.fk_createdby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,ENTITYCHILD.updatedon,ENTITYCHILD.fk_updatedby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby');
		   // $this->db->FROM(ENTITYCHILD.' as ENTITYCHILD');
		   // $this->db->JOIN(ENTITY.' as ENTITY','ENTITYCHILD.fk_entity_id = ENTITY.entity_id');
		   // $this->db->JOIN(USERPROFILE.' as USERPROFILE','ENTITYCHILD.fk_createdby = USERPROFILE.userid ');
		   // $this->db->JOIN(USERPROFILE.' as USERPROFILE1','ENTITYCHILD.fk_updatedby = USERPROFILE1.userid','LEFT');
		   // $this->db->where('ENTITY.entity_id',$r['entity_id']);
		   
		   // $entity_child_data = $this->db->get()->result_array();
		   
		   // array_push($result[$key],$entity_child_data);
		  
	   // }
	   
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
   
   /******   Get All Entity Billing Info and it's contact info******/
  
   public function getEntityBillingInfo($entity_id)
   {
	    
	   
	  $this->db->SELECT('ENTITYBILLING.entity_billing_id,ENTITYBILLING.fk_entity_id, ENTITYBILLING.billing_name,ENTITYBILLING.isactive,ENTITYBILLING.addressline1,ENTITYBILLING.addressline2,ENTITYBILLING.addressline3,ENTITYBILLING.pincode,ENTITYBILLING.email,ENTITYBILLING.mobileno,ENTITYBILLING.gstno,ENTITYBILLING.gststatecode,ENTITYBILLING.pan');
	  $this->db->FROM(ENTITYBILLING.' as ENTITYBILLING');	
	  $this->db->WHERE('ENTITYBILLING.fk_entity_id',$entity_id); 
	  $result = $this->db->get()->result_array();
	  
	  if(count($result)) 	
	  {
		  foreach($result as $key => $res)
		  {
			$this->db->SELECT('ENTITYBILLINGCONTACTINFO.entity_billing_contact_id,ENTITYBILLINGCONTACTINFO.fk_entity_billing_id, ENTITYBILLINGCONTACTINFO.contact_person, ENTITYBILLINGCONTACTINFO.contact_email, ENTITYBILLINGCONTACTINFO.contact_mobile_no, ENTITYBILLINGCONTACTINFO.isactive') ;
			$this->db->FROM(ENTITYBILLINGCONTACTINFO.' as ENTITYBILLINGCONTACTINFO');
		    $this->db->WHERE('ENTITYBILLINGCONTACTINFO.fk_entity_billing_id',$res['entity_billing_id']);
			$contacts = $this->db->get()->result_array();
			$result[$key]['contacts'] = $contacts;
		  }
	  }
	  return $result;
   }
   
   

}