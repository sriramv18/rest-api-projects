<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class Template_Management_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
        }
		
		
   public function listAllTemplates($page,$limit,$sort)
   {
				$this->db->SELECT('TEMPLATE.template_id, TEMPLATE.template_name, DATE_FORMAT(TEMPLATE.createdon,"%d/%m/%Y") as createdon, TEMPLATE.fk_createdby,TEMPLATE.updatedon, TEMPLATE.fk_updatedby, TEMPLATE.isactive,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby');
				$this->db->FROM(TEMPLATE.' as TEMPLATE');
				$this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATE.fk_createdby = USERPROFILE.userid');
				$this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATE.fk_updatedby = USERPROFILE1.userid','LEFT');
				$this->db->ORDER_BY('TEMPLATE.template_id',$sort);
				$this->db->LIMIT($limit,$page);
				$templates = $this->db->GET()->result_array();
	  
	  
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
   
   public function getTemplateMaster($template_id)
   {
				
				$this->db->SELECT('TEMPLATE.template_id, TEMPLATE.template_name, DATE_FORMAT(TEMPLATE.createdon,"%d/%m/%Y") as createdon, TEMPLATE.fk_createdby,TEMPLATE.updatedon, TEMPLATE.fk_updatedby, TEMPLATE.isactive,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby');
				$this->db->FROM(TEMPLATE.' as TEMPLATE');
				$this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATE.fk_createdby = USERPROFILE.userid');
				$this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATE.fk_updatedby = USERPROFILE1.userid','LEFT');
				$this->db->WHERE('TEMPLATE.template_id',$template_id);
				$template = $this->db->GET()->result_array();
				return $template;
   }
   
   public function getTemplateLenders($template_id)
   {
			  $this->db->SELECT('LENDERTEMPLATE.template_lender_map_id, LENDERTEMPLATE.fk_template_id, LENDERTEMPLATE.fk_lender_id,ENTITY.full_name,ENTITY.short_name, LENDERTEMPLATE.fk_product_id,PRODUCTS.name as product_name,PRODUCTS.abbr as product_abbr, LENDERTEMPLATE.fk_customer_segment,CUSTOMERSEGMENT.name as customer_segment_name, CUSTOMERSEGMENT.abbr as customer_segment_abbr,DATE_FORMAT(LENDERTEMPLATE.createdon, "%d/%m/%Y") as createdon,LENDERTEMPLATE.fk_createdby, DATE_FORMAT(LENDERTEMPLATE.updatedon,"%d/%m/%Y") as updatedon, LENDERTEMPLATE.isactive,LENDERTEMPLATE.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby');
			  $this->db->FROM(LENDERTEMPLATE.' as LENDERTEMPLATE');
			  $this->db->JOIN(ENTITY.' as ENTITY','LENDERTEMPLATE.fk_lender_id = ENTITY.entity_id');
			  $this->db->JOIN(PRODUCTS.' as PRODUCTS','LENDERTEMPLATE.fk_product_id = PRODUCTS.product_id');
			  $this->db->JOIN(CUSTOMERSEGMENT.' as CUSTOMERSEGMENT','LENDERTEMPLATE.fk_customer_segment = CUSTOMERSEGMENT.customer_segment_id');
			  $this->db->JOIN(USERPROFILE.' as USERPROFILE','LENDERTEMPLATE.fk_createdby = USERPROFILE.userid');
			  $this->db->JOIN(USERPROFILE.' as USERPROFILE1','LENDERTEMPLATE.fk_updatedby = USERPROFILE1.userid','LEFT');
			  $this->db->WHERE('LENDERTEMPLATE.fk_template_id',$template_id);
			  $data = $this->db->GET()->result_array();	
			  return $data;
   }
   
   public function getTemplateCategories($template_id)
   {
			  $this->db->SELECT('TEMPLATECATAGORYWEIGHTAGE.template_catagory_weightage_id, TEMPLATECATAGORYWEIGHTAGE.fk_question_catagory_id, TEMPLATECATAGORYWEIGHTAGE.fk_template_id, TEMPLATECATAGORYWEIGHTAGE.weigthage, DATE_FORMAT(TEMPLATECATAGORYWEIGHTAGE.createdon,"%d/%m/%Y") as createdon, TEMPLATECATAGORYWEIGHTAGE.fk_createdby,  DATE_FORMAT(TEMPLATECATAGORYWEIGHTAGE.updatedon, "%d/%m/%Y") as updatedon, TEMPLATECATAGORYWEIGHTAGE.isactive, TEMPLATECATAGORYWEIGHTAGE.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby');
			  $this->db->FROM(TEMPLATECATAGORYWEIGHTAGE.' as TEMPLATECATAGORYWEIGHTAGE');
			  $this->db->JOIN(QUESTIONCATEGORY.' as QUESTIONCATEGORY','TEMPLATECATAGORYWEIGHTAGE.template_catagory_weightage_id = QUESTIONCATEGORY.question_categroy_id');
			  $this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATECATAGORYWEIGHTAGE.fk_createdby = USERPROFILE.userid');
			  $this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATECATAGORYWEIGHTAGE.fk_updatedby = USERPROFILE1.userid','LEFT');
			  $this->db->WHERE('TEMPLATECATAGORYWEIGHTAGE.fk_template_id',$template_id);
			  $data = $this->db->GET()->result_array();	
			  return $data;   
   }
   
   // public function getTemplateQuestionAnswers($template_id)
   // {
			 
	// $this->db->SELECT('TEMPLATECATAGORYWEIGHTAGE.template_catagory_weightage_id, TEMPLATECATAGORYWEIGHTAGE.fk_question_catagory_id, TEMPLATECATAGORYWEIGHTAGE.fk_template_id, TEMPLATECATAGORYWEIGHTAGE.weigthage, DATE_FORMAT(TEMPLATECATAGORYWEIGHTAGE.createdon,"%d/%m/%Y") as createdon, TEMPLATECATAGORYWEIGHTAGE.fk_createdby,  DATE_FORMAT(TEMPLATECATAGORYWEIGHTAGE.updatedon, "%d/%m/%Y") as updatedon, TEMPLATECATAGORYWEIGHTAGE.isactive, TEMPLATECATAGORYWEIGHTAGE.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby');
	// $this->db->FROM(TEMPLATECATAGORYWEIGHTAGE.' as TEMPLATECATAGORYWEIGHTAGE');
	// $this->db->JOIN(QUESTIONCATEGORY.' as QUESTIONCATEGORY','TEMPLATECATAGORYWEIGHTAGE.template_catagory_weightage_id = QUESTIONCATEGORY.question_categroy_id');
	// $this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATECATAGORYWEIGHTAGE.fk_createdby = USERPROFILE.userid');
	// $this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATECATAGORYWEIGHTAGE.fk_updatedby = USERPROFILE1.userid','LEFT');
	// $this->db->WHERE('TEMPLATECATAGORYWEIGHTAGE.fk_template_id',$template_id);
	// $categories = $this->db->GET()->result_array();

	// if(count($categories))
	// {

			  // foreach($categories as $key => $category)
			  // {
				// $this->db->SELECT('TEMPLATEQUESTION.template_question_id, TEMPLATEQUESTION.fk_template_id, TEMPLATEQUESTION.fk_question_id, TEMPLATEQUESTION.question_weightage, TEMPLATEQUESTION.question_answerable_by, DATE_FORMAT(TEMPLATEQUESTION.createdon,"%d/%m/%Y") as createdon, TEMPLATEQUESTION.fk_createdby,  DATE_FORMAT(TEMPLATEQUESTION.updatedon,"%d/%m/%Y") as updatedon, TEMPLATEQUESTION.fk_updatedby, TEMPLATEQUESTION.isactive,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby');
				// $this->db->FROM(TEMPLATEQUESTION.' as TEMPLATEQUESTION');
				// $this->db->JOIN(QUESTIONS.' as QUESTIONS','TEMPLATEQUESTION.fk_question_id = QUESTIONS.question_id');
				// $this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATEQUESTION.fk_createdby = USERPROFILE.userid');
				// $this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATEQUESTION.fk_updatedby = USERPROFILE1.userid','LEFT');
				// $this->db->WHERE('TEMPLATEQUESTION.fk_template_id',$template_id);
				// $questions = $this->db->GET()->result_array();

					// if(count($questions))
					// {
						// foreach($questions as $key => $question)
						// {
						
						// }
					// }
			  // }
			  
	// }    
   // }

}