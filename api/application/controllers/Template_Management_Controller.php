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

	
	/******** Save and Update  Template Name  ********/
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
			$modified = $this->Template_Management_Model->updateRecords($records,TEMPLATE,$where_condition_array);
			if($modified != "" || $modified != null)
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
	
	/******** save and Edit Template Lender,Product, and Customer Segments  ********/
	public function saveTemplateLenderDetails_post()
	{
		
		$count = 0;
		$template_lender_details = $this->post('records');
		//print_r($template_lender_details);die();
		foreach($template_lender_details as $template_lender_detail)
		{
				if($template_lender_detail['template_lender_map_id'] != null || $template_lender_detail['template_lender_map_id'] != "")
				{
					$where_condition_array = array('template_lender_map_id'=>$template_lender_detail['template_lender_map_id']);
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
	
	
	/******** Save and Update Template Categories  ********/
	public function saveTemplateCategoryDetails_post()
	{
	
		$count = 0;	
		$template_category_details = $this->post('records');
		//print_r($template_category_details);die();
		foreach($template_category_details as $template_category_detail)
		{
			if($template_category_detail['template_category_weightage_id'] != null || $template_category_detail['template_category_weightage_id'] != "")
			{
				//$groups = $template_category_detail['groups'];
				//unset($template_category_detail['groups']);
				
				$where_condition_array = array('template_category_weightage_id'=>$template_category_detail['template_category_weightage_id']);
				$modified = $this->Template_Management_Model->updateRecords($template_category_detail,TEMPLATECATEGORYWEIGHTAGE,$where_condition_array);
				if($modified != "" || $modified != null){ $count++; } 
				
				//Groups insert/update
				// foreach($groups as $group_key => $group)
				// {
					// if($group['template_group_id'] != null || $group['template_group_id'] != "")
					// {
						// $where_condition_array = array('template_group_id'=>$group['template_group_id']);
						// $modified = $this->Template_Management_Model->updateRecords($group,TEMPLATEGROUP,$where_condition_array);
					// }
					// else
					// {
						// $template_group_id = $this->Template_Management_Model->saveRecords($group,TEMPLATEGROUP);
					// }
				// }
			}
			//Insert Categories
			else
			{
					// $groups = $template_category_detail['groups'];
					// unset($template_category_detail['groups']);
					$id = $this->Template_Management_Model->saveRecords($template_category_detail,TEMPLATECATEGORYWEIGHTAGE);
					if($id != "" || $id != null){ $count++; }
					//Groups insert
						// foreach($groups as $group_key => $group)
						// {
							
						 // $template_group_id = $this->Template_Management_Model->saveRecords($group,TEMPLATEGROUP);
							
						// }
			}
		}
		
		if($count == count($template_category_details))
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
	
	/******** Save/update Template Question and Answers  ********/
	public function saveTemplateQuestionAnswers_post()
	{
		$question_count = 0;
		$count = 0;
		$template_question_answers_details = $this->post('records');
		//print_r($template_question_answers_details);
		foreach($template_question_answers_details as $key => $template_question_answers_detail)
		{
			//echo "FOr".$key;
			$answers_array = array();
			if($template_question_answers_detail['template_question_id'] != null || $template_question_answers_detail['template_question_id'] != "")
			{
					if(isset($template_question_answers_detail['answers']))
					{
						$answers_array = $template_question_answers_detail['answers'];
						unset($template_question_answers_detail['answers']);
					}
					
					$where_condition_array = array('template_question_id' => $template_question_answers_detail['template_question_id']);
					unset($template_question_answers_detail['question_id']);
					unset($template_question_answers_detail['question']);
					$question_modified = $this->Template_Management_Model->updateRecords($template_question_answers_detail,TEMPLATEQUESTION,$where_condition_array);
					if($question_modified){$question_count++;}
					if(count($answers_array))
					{
						foreach($answers_array as $key => $answer)
						{
							if($answer['template_answer_weightage_id'] != "" || $answer['template_answer_weightage_id'] != null)
							{
								$where_condition_array = array('template_answer_weightage_id' => $answer['template_answer_weightage_id']);
								unset($answer['answer']);
					
								$answer_modified = $this->Template_Management_Model->updateRecords($answer,TEMPLATEANSWERWEIGHTAGE,$where_condition_array);
								
								if($answer_modified != "" || $answer_modified != null) {$count++;}
							}
							else
							{
								unset($answer['answer']);
								$answer_inserted = $this->Template_Management_Model->saveRecords($answer,TEMPLATEANSWERWEIGHTAGE);
								
								//if($answer_inserted != "" || $answer_inserted != null) {$count++;}
							}
						}
					}
					
									
			}
			else
			{
				if(isset($template_question_answers_detail['answers']))
					{
						$answers_array = $template_question_answers_detail['answers'];
						unset($template_question_answers_detail['answers']);
					}
					
					unset($template_question_answers_detail['question_id']);
					unset($template_question_answers_detail['question']);
					$question_id = $this->Template_Management_Model->saveRecords($template_question_answers_detail,TEMPLATEQUESTION);
					if($question_id){$question_count++;}
					if(count($answers_array))
					{
						foreach($answers_array as $key => $answer)
						{
							$answer['fk_template_question_id'] = $question_id;
							unset($answer['answer']);
							$answer_inserted = $this->Template_Management_Model->saveRecords($answer,TEMPLATEANSWERWEIGHTAGE);
							//if($answer_inserted != "" || $answer_inserted != null) {$count++;}
						}
					}		
			}
		}
		
		if(($question_count != "" || $question_id != null) )
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
	
	
	
	
	/******** Load Existed Template Master Details for Edit page @param template id ********/
	public function getTemplateMaster_post()
	{
		$template_id = $this->post('template_id');
		$template_master = $this->Template_Management_Model->getTemplateMaster($template_id);
		if(count($template_master))
		{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $template_master;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	
	/******** Load Existed Template Lender Mapping for Edit page @param template id ********/
	public function getTemplateLenders_post()
	{
		$template_id = $this->post('template_id');
		$template_lenders = $this->Template_Management_Model->getTemplateLenders($template_id);
		if(count($template_lenders))
		{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $template_lenders;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	
	/******** Load Existed Template Categories for Edit page @param template id ********/
	public function getTemplateCategories_post()
	{
		$template_id = $this->post('template_id');
		$template_categories = $this->Template_Management_Model->getTemplateCategories($template_id);
		if(count($template_categories))
		{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $template_categories;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	
	/******** Load Existed Template Question and Answers for Edit page @param template id ********/
	public function getTemplateQuestionAnswers_post()
	{
		$template_id = $this->post('template_id');
		$template_questionanswers = $this->Template_Management_Model->getTemplateQuestionAnswers($template_id);
		if(count($template_questionanswers))
		{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $template_questionanswers;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	/************** Get List of Categories to Template Add/Edit Page DropDown ***************/
	public function getListOfCategories_get()
	{
		$fields = array('question_category_id','category_name');
		$where_condition_array = array('isactive' => 1);
		$result_data = $this->Template_Management_Model->selectCustomRecords($fields,$where_condition_array,QUESTIONCATEGORY);
		if(count($result_data))
		{
						
						
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $result_data;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
			
		}
	}
	
	public function getQuestionsForTemplateCreation_post()
	{
		$template_id = "";$category_id = "";
		
		if($this->post('template_id')){ $template_id = $this->post('template_id'); }
		if($this->post('category_id')){ $category_id = $this->post('category_id'); }
		
		$questions = $this->Template_Management_Model->getListOfQuestions($template_id,$category_id);
		if(count($questions))
		{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $questions;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_OK);
			
		}
	}
	
	//Get Categories and questions group compinations
	public function getCategoryGroupCombinations_get()
	{
		$fields = array('question_category_id','category_name');
		$where_condition_array = array('isactive' => 1);
		$result_data = $this->Template_Management_Model->selectCustomRecords($fields,$where_condition_array,QUESTIONCATEGORY);
		
		if(count($result_data))
		{
			foreach($result_data as $key => $result)
			{
				$groups = $this->Template_Management_Model->getCategoryGroupCombinations($result['question_category_id']);
				$result_data[$key]['gropus'] = $groups;
			}
			
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $result_data;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$data['msg'] = "No Categories Found!";
						$this->response($data,REST_Controller::HTTP_OK);
		}
		
		
	}
	
	
	public function saveScoreCardQuestions_post()
	{
		$records = $this->post('records');
		$answers = $records['answers'];
		unset($records['answers']);
		$id = "";
		$count = 0;
		
		foreach($records as $rec_key => $record)
		{
			if($record['score_question_id'] != null || $record['score_question_id'] != "")
			{
				$where_condition_array = array('score_question_id' => $record['score_question_id']);
				$id = $this->Template_Management_Model->updateRecords($record,SCORECARDQUESTIONS,$where_condition_array);
				if($id != null || $id != "")
				{
					$count++;
					foreach($answers as $ans_key => $answer)
					{
					  if($answer['score_answer_id'] != null || $answer['score_answer_id'] != "")
					  {
						 $where_condition_array = array('score_answer_id' => $answer['score_answer_id']);
						 $ans_id = $this->Template_Management_Model->updateRecords($answer,SCORECARDANSWERS,$where_condition_array); 
					  }
					  else
					  {
						$answer['fk_score_question_id'] = $record['score_question_id'];
						$ans_id = $this->Template_Management_Model->saveRecords($answer,SCORECARDANSWERS);	
					  }
					}
				}
			}
			else
			{
				$id = $this->Template_Management_Model->saveRecords($record,SCORECARDQUESTIONS);
				
				if($id != null || $id != "")
				{
					$count++;
					foreach($answers as $ans_key => $answer)
					{
					  $answer['fk_score_question_id'] = $id;
					  $ans_id = $this->Template_Management_Model->saveRecords($answer,SCORECARDANSWERS);	
					}
				}
			}
		}
		
		if($count == count($records))
		{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $id;
						$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$data['msg'] = "Something Went Wrong!";
						$this->response($data,REST_Controller::HTTP_OK);
		}
		
	}
	
	
	
	public function getFormAndQuestionKeys_post()
	{
		$records = $this->post('records');
		$formid = 0;
		$templateid = $records['templateid'];
		$formid = $records['formid'];
		//*******************INTERNAL PURPOSE***************************************************
		$master_tables_field_names = array('INDUSTRYCLASSIFICATION' => 'name','UOM' => 'name','OCCUPATIONMEMBERS' => 'name','EDUQUALIFICATION' => 'qualification_name', 'TYPEOFACTIVITY' => 'name','RELATIONSHIPS' => 'name','FREQUENCY' => 'name', 'CUSTOMERBEHAVIOUR' => 'description', 'CUSTOMERSEGMENT' => 'name','DESIGNATION' => 'short_name', 'EARNINGMEMBERSSTATUS' => 'earning_member_status','EDUQUALIFICATION' => 'qualification_name','ADDRESSTYPE' => 'address_type','LOCALITY' => 'locality_name','ASSETTYPE' => 'name','PROPERTIES' => 'name','INVESTMENTTYPE' => 'name','INSURANCETYPE' => 'name','PERSONSMET' => 'person_met_name','RESIDENCEOWNERSHIP' => 'name','PAYMENTMODE' => 'name','ACCOUNTTYPE' => 'name','SOURCEOFOTHERINCOME' => 'name','MORTAGEPROPERTYTYPE' => 'name','ENDUSEOFLOAN' => 'name','SOURCEOFBALANCETRANSFER' => 'name', 'STATUSOFCONSTRUCTION' => 'name');
		
		$master_tables_pkid = array('INDUSTRYCLASSIFICATION' => 'industry_classification_id','UOM' => 'uom_id','OCCUPATIONMEMBERS' => 'occupation_non_earning_member_id','EDUQUALIFICATION' => 'qualification_name', 'TYPEOFACTIVITY' => 'type_of_activity_id','RELATIONSHIPS' => 'relationship_id','FREQUENCY' => 'frequency_id', 'CUSTOMERBEHAVIOUR' => 'customer_behaviour_id', 'CUSTOMERSEGMENT' => 'customer_segment_id','DESIGNATION' => 'designation_id', 'EARNINGMEMBERSSTATUS' => 'earning_member_status_id','EDUQUALIFICATION' => 'qualification_id','ADDRESSTYPE' => 'address_type_id','LOCALITY' => 'locality_id','ASSETTYPE' => 'id','PROPERTIES' => 'id','INVESTMENTTYPE' => 'id','INSURANCETYPE' => 'id','PERSONSMET' => 'person_met_id','RESIDENCEOWNERSHIP' => 'id','PAYMENTMODE' => 'id','ACCOUNTTYPE' => 'id','SOURCEOFOTHERINCOME' => 'id','MORTAGEPROPERTYTYPE' => 'id','ENDUSEOFLOAN' => 'id','SOURCEOFBALANCETRANSFER' => 'id', 'STATUSOFCONSTRUCTION' => 'id');
		//*******************INTERNAL PURPOSE***************************************************
		
		$fields = array('fk_form_id','question','key','ismaster','master_name');
		$where_condition_array = array();
		if($formid != "")
		{
		 $where_condition_array = array('isactive' => 1,'fk_form_id' => $formid);
		}
		else
		{
		 $where_condition_array = array('isactive' => 1);
		}
		$result_data = $this->Template_Management_Model->selectCustomRecords($fields,$where_condition_array,QUESTIONKEYMAPPING);
		
		if(count($result_data))
		{
			foreach($result_data as $res_key => $result)
			{
				if($result['master_name'] != null || $result['master_name'] != "")
				{
					//echo $result['master_name'];
					$fields = array($master_tables_pkid[$result['master_name']].' as id',$master_tables_field_names[$result['master_name']].' as name');
					
					$table = constant($result['master_name']);
					$where_condition_array = array('isactive' => 1);
					$answers = $this->Template_Management_Model->selectCustomRecords($fields,$where_condition_array,$table);
					$result_data[$res_key]['answers'] = $answers;
				}
			}
		}
		if(count($result_data))
		{
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $result_data;
						$this->response($data,REST_Controller::HTTP_OK);	
		}
		else
		{
						$data['dataStatus'] = false;
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$data['msg'] = "No Data Found!";
						$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	
	
}