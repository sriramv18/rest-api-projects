<?php
/**

 * User: velz
 * This Controller deals with User Management CRUD Operations
 */

defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/libraries/REST_Controller.php';


class Template_Management_Controller extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('Template_Management_Model');
        
    }
   
	public function listAllTemplates_get()
	{
		$page = "";$limit = ""; $sort = "asc";
		$result = $this->Template_Management_Model->listAllTemplates($page,$limit,$sort);
		if(count($result))
		{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_OK);
		}
	}

	public function saveNewTemplateName_post()
	{
		$records = $this->post('records');
		
		if($records['template_id'] == null || $records['template_id'] == "")
		{
				$template_id = $this->Template_Management_Model->saveRecords($records,TEMPLATE);
				if($template_id != "" || $template_id != null)
				{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $template_id;
						$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
					
				}
		}
		else
		{
			$where_condition_array = array('template_id'=>$records['template_id']);
			$modified = $this->db->updateRecords($records,TEMPLATE,$where_condition_array);
			if($template_id != "" || $template_id != null)
				{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $modified;
						$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
						$this->response($data,REST_Controller::HTTP_OK);
					
				}
			
		}
		
	}
	
	
	public function saveTemplateLenderDetails_post()
	{
		
		$count = 0;
		$template_lender_details = $this->post('records');
		
		foreach($template_lender_details as $template_lender_detail)
		{
				if($template_lender_detail['template_lender_map_id'] != null || $template_lender_detail['template_lender_map_id'] != "")
				{
					$where_condition_array = array('fk_template_id'=>$template_lender_detail['fk_template_id']);
					$modified = $this->Template_Management_Model->updateRecords($template_lender_detail,LENDERTEMPLATE,$where_condition_array);
					if($modified != "" || $modified != null){ $count++; } 
				}
				else
				{
					
					$id = $this->Template_Management_Model->saveRecords($template_lender_detail,LENDERTEMPLATE);
					if($id != "" || $id != null){ $count++; }
				}
		}
		
		
		if($count == count($template_lender_details))
				{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = true;
						$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
					
				}
		
		
	}
	
	public function saveTemplateCategoryDetails_post()
	{
	
		$count = 0;	
		$template_category_details = $this->post('records');
		
		foreach($template_category_details as $template_category_detail)
		{
			if($template_category_detail['template_catagory_weightage_id'] != null || $template_category_detail['template_catagory_weightage_id'] != "")
			{
				$where_condition_array = array('template_catagory_weightage_id'=>$template_category_detail['template_catagory_weightage_id']);
				$modified = $this->Template_Management_Model->updateRecords($template_category_detail,TEMPLATECATAGORYWEIGHTAGE,$where_condition_array);
				if($modified != "" || $modified != null){ $count++; } 
			}
			else
			{
					
					$id = $this->Template_Management_Model->saveRecords($template_lender_detail,TEMPLATECATAGORYWEIGHTAGE);
					if($id != "" || $id != null){ $count++; }
			}
		}
		
		if($count == count($template_lender_details))
				{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = true;
						$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
					
				}
		
		
	}
	
	
	public function saveTemplateQuestionAnswers_post()
	{
		$count = 0;	
		$template_question_answers_details = $this->post('records');
		
		foreach($template_question_answers_details as $key => $template_question_answers_detail)
		{
			$answers_array = array();
			if($template_question_answers_detail['template_question_id'] != null || $template_question_answers_detail['template_question_id'] != "")
			{
					if(isset($template_question_answers_detail['answers_details']))
					{
						$answers_array = $template_question_answers_detail['answers_details'];
						unset($template_question_answers_detail['answers_details']);
					}
					
					$where_condition_array = array('template_question_id' => $template_question_answers_detail['template_question_id']);
					$question_modified = $this->Template_Management_Model->updateRecords($template_question_answers_detail,TEMPLATEQUESTION,$where_condition_array);
					
					if(count($answers_array))
					{
						foreach($answers_array as $key => $answer)
						{
							if($answer['template_answer_weightage_id'] != "" || $answer['template_answer_weightage_id'] != null)
							{
								$where_condition_array = array('template_answer_weightage_id' => $answer['template_answer_weightage_id']);
								$answer_modified = $this->Template_Management_Model->updateRecords($answer,TEMPLATEANSWERWEIGHTAGE,$where_condition_array);
								
								if($answer_modified != "" || $answer_modified != null) {$count++;}
							}
							else
							{
								$answer_inserted = $this->Template_Management_Model->saveRecords($answer,TEMPLATEANSWERWEIGHTAGE);
								
								if($answer_inserted != "" || $answer_inserted != null) {$count++;}
							}
						}
					}
					
					if(($question_modified != "" || $question_modified != null) && count($answers_array) == $count)
					{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = true;
						$this->response($data,REST_Controller::HTTP_OK);
					}
					else
					{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
						$this->response($data,REST_Controller::HTTP_OK);
					}
					
			}
			else
			{
				if(isset($template_question_answers_detail['answers_details']))
					{
						$answers_array = $template_question_answers_detail['answers_details'];
						unset($template_question_answers_detail['answers_details']);
					}
					
					$question_id = $this->Template_Management_Model->saveRecords($template_question_answers_detail,TEMPLATEQUESTION);
					
					if(count($answers_array))
					{
						foreach($answers_array as $key => $answer)
						{
							$answer_inserted = $this->Template_Management_Model->saveRecords($answer,TEMPLATEANSWERWEIGHTAGE);
							if($answer_inserted != "" || $answer_inserted != null) {$count++;}
						}
					}
					
					
					if(($question_id != "" || $question_id != null) && count($answers_array) == $count)
					{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $question_id;
						$this->response($data,REST_Controller::HTTP_OK);
					}
					else
					{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
						$this->response($data,REST_Controller::HTTP_OK);
					}
					
					
			}
		}
	}
	
	
	
}