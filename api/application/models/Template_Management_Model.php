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
			  $this->db->SELECT('TEMPLATECATEGORYWEIGHTAGE.template_category_weightage_id, TEMPLATECATEGORYWEIGHTAGE.fk_question_category_id, TEMPLATECATEGORYWEIGHTAGE.fk_template_id, TEMPLATECATEGORYWEIGHTAGE.weightage, DATE_FORMAT(TEMPLATECATEGORYWEIGHTAGE.createdon,"%d/%m/%Y") as createdon, TEMPLATECATEGORYWEIGHTAGE.fk_createdby,  DATE_FORMAT(TEMPLATECATEGORYWEIGHTAGE.updatedon, "%d/%m/%Y") as updatedon, TEMPLATECATEGORYWEIGHTAGE.isactive, TEMPLATECATEGORYWEIGHTAGE.fk_updatedby');
			  $this->db->FROM(TEMPLATECATEGORYWEIGHTAGE .' as TEMPLATECATEGORYWEIGHTAGE');
			 // $this->db->JOIN(TEMPLATECATEGORYWEIGHTAGE.' as TEMPLATECATEGORYWEIGHTAGE',"TEMPLATECATEGORYWEIGHTAGE.template_category_weightage_id = QUESTIONCATEGORY.question_category_id AND TEMPLATECATEGORYWEIGHTAGE.fk_template_id = $template_id");
			//  $this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATECATEGORYWEIGHTAGE.fk_createdby = USERPROFILE.userid','LEFT');
			  //$this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATECATEGORYWEIGHTAGE.fk_updatedby = USERPROFILE1.userid','LEFT');
			 $this->db->WHERE('TEMPLATECATEGORYWEIGHTAGE.fk_template_id',$template_id);
			  $data = $this->db->GET()->result_array();	
			  return $data;   
   }
   
   
   /*
   DATE_FORMAT(TEMPLATECATEGORYWEIGHTAGE.createdon,"%d/%m/%Y") as createdon, TEMPLATECATEGORYWEIGHTAGE.fk_createdby,  DATE_FORMAT(TEMPLATECATEGORYWEIGHTAGE.updatedon, "%d/%m/%Y") as updatedon,TEMPLATECATEGORYWEIGHTAGE.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby
   
   */
   public function getTemplateQuestionAnswers($template_id)
   {
			 
			  $this->db->SELECT('QUESTIONCATEGORY.category_name,TEMPLATECATEGORYWEIGHTAGE.template_category_weightage_id, TEMPLATECATEGORYWEIGHTAGE.fk_question_category_id, TEMPLATECATEGORYWEIGHTAGE.fk_template_id, TEMPLATECATEGORYWEIGHTAGE.weightage, DATE_FORMAT(TEMPLATECATEGORYWEIGHTAGE.createdon,"%d/%m/%Y") as createdon, TEMPLATECATEGORYWEIGHTAGE.fk_createdby,  DATE_FORMAT(TEMPLATECATEGORYWEIGHTAGE.updatedon, "%d/%m/%Y") as updatedon, TEMPLATECATEGORYWEIGHTAGE.isactive, TEMPLATECATEGORYWEIGHTAGE.fk_updatedby');
			  $this->db->FROM(TEMPLATECATEGORYWEIGHTAGE .' as TEMPLATECATEGORYWEIGHTAGE');
			  $this->db->JOIN(QUESTIONCATEGORY.' as QUESTIONCATEGORY','TEMPLATECATEGORYWEIGHTAGE.fk_question_category_id = QUESTIONCATEGORY.question_category_id');
			  // $this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATECATEGORYWEIGHTAGE.fk_createdby = USERPROFILE.userid','LEFT');
			  // $this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATECATEGORYWEIGHTAGE.fk_updatedby = USERPROFILE1.userid','LEFT');
			  $this->db->WHERE('TEMPLATECATEGORYWEIGHTAGE.fk_template_id',$template_id);
			  $categories = $this->db->GET()->result_array();
	
		if(count($categories))
		{
				/*
				DATE_FORMAT(TEMPLATEQUESTION.createdon,"%d/%m/%Y") as createdon, TEMPLATEQUESTION.fk_createdby,  DATE_FORMAT(TEMPLATEQUESTION.updatedon,"%d/%m/%Y") as updatedon, TEMPLATEQUESTION.fk_updatedby,concat(USERPROFILE.first_name," ",USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby
				*/
			  foreach($categories as $category_key => $category)
			  {
				 
				$this->db->SELECT('QUESTIONS.question_id,QUESTIONS.question,TEMPLATEQUESTION.template_question_id, TEMPLATEQUESTION.fk_template_id, TEMPLATEQUESTION.fk_question_id, TEMPLATEQUESTION.question_weightage, TEMPLATEQUESTION.question_answerable_by,TEMPLATEQUESTION.fk_template_question_category_id,  TEMPLATEQUESTION.isactive');
				//$this->db->FROM(TEMPLATEQUESTION.' as TEMPLATEQUESTION');
				$this->db->FROM(TEMPLATEQUESTION.' as TEMPLATEQUESTION');
				$this->db->JOIN(QUESTIONS.' as QUESTIONS','TEMPLATEQUESTION.fk_question_id = QUESTIONS.question_id','LEFT');
				// $this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATEQUESTION.fk_createdby = USERPROFILE.userid','LEFT');
				// $this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATEQUESTION.fk_updatedby = USERPROFILE1.userid','LEFT');
				$this->db->WHERE('TEMPLATEQUESTION.fk_template_question_category_id',$category['fk_question_category_id']);
				$questions = $this->db->GET()->result_array();
				

					if(count($questions))
					{
						
						foreach($questions as $answer_key => $question)
						{
						  $this->db->SELECT('QUESTIONANSWERS.question_answer_id,QUESTIONANSWERS.answer,TEMPLATEANSWERWEIGHTAGE.template_answer_weightage_id, TEMPLATEANSWERWEIGHTAGE.fk_template_question_id, TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id, TEMPLATEANSWERWEIGHTAGE.template_answer_weightage, TEMPLATEANSWERWEIGHTAGE.isactive');
						  $this->db->FROM(TEMPLATEANSWERWEIGHTAGE.' as TEMPLATEANSWERWEIGHTAGE');
						  $this->db->JOIN(QUESTIONANSWERS.' as QUESTIONANSWERS','TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id = QUESTIONANSWERS.question_answer_id','LEFT');
						  $this->db->WHERE('QUESTIONANSWERS.fk_question_id',$question['question_id']);
						  $answers = $this->db->GET()->result_array();
						  $questions[$answer_key]['answers'] = $answers;
						}
					}
				$categories[$category_key]['questions'] = $questions;
			  }
			  
	}

	return  $categories;   
   }
   
   
   public function getListOfQuestions($template_id,$category_id)
   {
	   $questions = array();
	  if(($template_id != "" || $template_id != null) && ($category_id != "" || $category_id != null))  
	  {
		$fields  = array('fk_question_id');
		$where_condition_array = array('fk_template_question_category_id' => $category_id,'fk_template_id' => $template_id);
		$result_data = $this->selectCustomRecords($fields,$where_condition_array,TEMPLATEQUESTION);
		
		if(count($result_data))
		{
			$temp_array = array();
			foreach($result_data as $res)
			{
				array_push($temp_array,$res['fk_question_id']);
			}
			
			// $this->db->SELECT('question_id,question');
			// $this->db->FROM(QUESTIONS);
			// $this->db->WHERE('fk_question_category',$category_id);
			// $this->db->WHERE_NOT_IN('question_id',$temp_array);
			// $questions = $this->db->get()->result_array();
			
			$this->db->SELECT('QUESTIONS.question_id,QUESTIONS.question,TEMPLATEQUESTION.template_question_id, TEMPLATEQUESTION.fk_template_id, TEMPLATEQUESTION.fk_question_id, TEMPLATEQUESTION.question_weightage, TEMPLATEQUESTION.question_answerable_by,TEMPLATEQUESTION.fk_template_question_category_id,  TEMPLATEQUESTION.isactive');
				//$this->db->FROM(TEMPLATEQUESTION.' as TEMPLATEQUESTION');
				$this->db->FROM(QUESTIONS.' as QUESTIONS');
				$this->db->JOIN(TEMPLATEQUESTION.' as TEMPLATEQUESTION','QUESTIONS.question_id = TEMPLATEQUESTION.fk_question_id','LEFT');
				// $this->db->JOIN(USERPROFILE.' as USERPROFILE','TEMPLATEQUESTION.fk_createdby = USERPROFILE.userid','LEFT');
				// $this->db->JOIN(USERPROFILE.' as USERPROFILE1','TEMPLATEQUESTION.fk_updatedby = USERPROFILE1.userid','LEFT');
				$this->db->WHERE('QUESTIONS.fk_question_category',$category_id);
				$this->db->WHERE_NOT_IN('QUESTIONS.question_id',$temp_array);
				$questions = $this->db->GET()->result_array();
				

					if(count($questions))
					{
						
						foreach($questions as $answer_key => $question)
						{
						  $this->db->SELECT('QUESTIONANSWERS.question_answer_id,QUESTIONANSWERS.answer,TEMPLATEANSWERWEIGHTAGE.template_answer_weightage_id, TEMPLATEANSWERWEIGHTAGE.fk_template_question_id, TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id, TEMPLATEANSWERWEIGHTAGE.template_answer_weightage, TEMPLATEANSWERWEIGHTAGE.isactive');
						  $this->db->FROM(QUESTIONANSWERS.' as QUESTIONANSWERS');
						  $this->db->JOIN(TEMPLATEANSWERWEIGHTAGE.' as TEMPLATEANSWERWEIGHTAGE','QUESTIONANSWERS.question_answer_id = TEMPLATEANSWERWEIGHTAGE.fk_question_answer_id','LEFT');
						  $this->db->WHERE('QUESTIONANSWERS.fk_question_id',$question['question_id']);
						  $answers = $this->db->GET()->result_array();
						  $questions[$answer_key]['answers'] = $answers;
						}
					}
				//$questions['answers'] = $questions;
			
		}
		
	  }
	  return $questions;
   }

}