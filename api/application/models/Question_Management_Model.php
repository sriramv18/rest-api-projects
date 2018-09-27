<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class Question_Management_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
        }
		
		
   public function listAllQuestions($page,$limit,$sort)
   {
	  
	   	
	   $this->db->SELECT('QUESTIONS.question_id, QUESTIONS.question, QUESTIONS.description, QUESTIONS.fk_question_catagory,QUESTIONCATEGORY.categroy_name, QUESTIONS.fk_question_answertype,QUESTIONANSWERTYPE.answer_type_name,QUESTIONS.isactive, QUESTIONS.createdon, QUESTIONS.fk_createdby, QUESTIONS.updatedon, QUESTIONS.fk_updatedby,concat(USERPROFILE.first_name," " ,USERPROFILE.last_name) as createdby,concat(USERPROFILE1.first_name," ",USERPROFILE1.last_name) as updatedby');
	   $this->db->FROM(QUESTIONS.' as QUESTIONS');
	   $this->db->JOIN(QUESTIONANSWERTYPE.' as QUESTIONANSWERTYPE','QUESTIONS.fk_question_answertype = QUESTIONANSWERTYPE.question_answer_type_id');
	   $this->db->JOIN(QUESTIONCATEGORY.' as QUESTIONCATEGORY','QUESTIONS.fk_question_catagory = QUESTIONCATEGORY.question_categroy_id');
	   $this->db->JOIN(USERPROFILE.' as USERPROFILE','QUESTIONS.fk_createdby = USERPROFILE.userid');
	   $this->db->JOIN(USERPROFILE.' as USERPROFILE1','QUESTIONS.fk_updatedby = USERPROFILE1.userid','LEFT');
	   $this->db->ORDER_BY('QUESTIONS.question_id',$sort);
	   $this->db->LIMIT($page,$limit);
	   
	   $result = $this->db->GET()->result_array();
	  
	   foreach($result as $key => $r)
	   {
		   $this->db->SELECT('QUESTIONANSWERS.question_answer_id, QUESTIONANSWERS.fk_question_id, QUESTIONANSWERS.answer, QUESTIONANSWERS.createdon, QUESTIONANSWERS.fk_createdby, QUESTIONANSWERS.updatedon, QUESTIONANSWERS.fk_updatedby, QUESTIONANSWERS.isactive');
		   $this->db->FROM(QUESTIONANSWERS.' as QUESTIONANSWERS');
		   $this->db->JOIN(QUESTIONS.' as QUESTIONS','QUESTIONANSWERS.fk_question_id = QUESTIONS.question_id');
		   $this->db->JOIN(USERPROFILE.' as USERPROFILE','QUESTIONANSWERS.fk_createdby = USERPROFILE.userid ');
		   $this->db->JOIN(USERPROFILE.' as USERPROFILE1','QUESTIONANSWERS.fk_updatedby = USERPROFILE1.userid','LEFT');
		   $this->db->where('QUESTIONS.question_id',$r['question_id']);
		   $answers_data = $this->db->get()->result_array();
		   //$result[$key]['answers'] = $answers_data;
		   array_push($result[$key],$answers_data);
	   }
	   
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