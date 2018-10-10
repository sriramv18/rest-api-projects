<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class Template_Management_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
        }
		
		
   public function listAllTemplates($page,$limit,$sort)
   {
	  $templates = $this->selectRecords(TEMPLATE,array(),$limit,$page,$sort);
	  
	  if(count($templates))
	  {
		  
		  foreach($templates as $key => $template)
		  {
			  $this->db->SELECT('LENDERTEMPLATE.template_lender_map_id, LENDERTEMPLATE.fk_template_id, LENDERTEMPLATE.fk_lender_id,ENTITY.full_name,ENTITY.short_name, LENDERTEMPLATE.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, LENDERTEMPLATE.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name, CUSTOMERSEGMENT.abbr as customer_segment_abbr,DATE_FORMAT(LENDERTEMPLATE.createdon, "%d/%m/%Y") as createdon,LENDERTEMPLATE.fk_createdby, DATE_FORMAT(LENDERTEMPLATE.updatedon,"%d/%m/%Y") as updatedon, LENDERTEMPLATE.isactive,LENDERTEMPLATE.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby');
			  $this->db->FROM(LENDERTEMPLATE.' as LENDERTEMPLATE');
			  $this->db->JOIN(ENTITY.' as ENTITY','LENDERTEMPLATE.fk_lender_id = ENTITY.entity_id');
			  $this->db->JOIN(PRODUCTS.' as PRODUCTS','LENDERTEMPLATE.fk_product_id = PRODUCTS.product_id');
			  $this->db->JOIN(CUSTOMERSEGMENT.' as CUSTOMERSEGMENT','LENDERTEMPLATE.fk_customer_segment = CUSTOMERSEGMENT.customer_segment_id');
			  $this->db->JOIN(USERPROFILE.' as USERPROFILE','LENDERTEMPLATE.fk_createdby = USERPROFILE.userid');
			  $this->db->JOIN(USERPROFILE.' as USERPROFILE1','LENDERTEMPLATE.fk_updatedby = USERPROFILE1.userid','LEFT');
			  $this->db->WHERE('LENDERTEMPLATE.fk_template_id',$template['template_id']);
			  $child_data = $this->db->GET()->result_array();	
			  $templates[$key]['lender_details'] = $child_data;
			  
		  }
		  
		   
		   return $templates;
		   
	   
	  }
	  else
	  {		  
	   return array();
	  }
	   
   }

}