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
		
		$id = "";
		$count = 0;
		
		foreach($records as $rec_key => $record)
		{
			$answers = $record['answers'];
			unset($record['answers']);
			unset($record['question_key_mapping_id']);
			unset($record['question']);
			if($record['score_question_id'] != null || $record['score_question_id'] != "")
			{
				$where_condition_array = array('score_question_id' => $record['score_question_id']);
				$id = $this->Template_Management_Model->updateRecords($record,SCORECARDQUESTIONS,$where_condition_array);
				if($id != null || $id != "")
				{
					$count++;
					foreach($answers as $ans_key => $answer)
					{
						unset($answer['id']);
						unset($answer['name']);
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
					    unset($answer['id']);
						unset($answer['name']);
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
		$categoryid = $records['categoryid'];
		//*******************INTERNAL PURPOSE***************************************************
		$master_tables_field_names = array('INDUSTRYCLASSIFICATION' => 'name','UOM' => 'name','OCCUPATIONMEMBERS' => 'name','EDUQUALIFICATION' => 'qualification_name', 'TYPEOFACTIVITY' => 'name','RELATIONSHIPS' => 'name','FREQUENCY' => 'name', 'CUSTOMERBEHAVIOUR' => 'description', 'CUSTOMERSEGMENT' => 'name','DESIGNATION' => 'short_name', 'EARNINGMEMBERSSTATUS' => 'earning_member_status','EDUQUALIFICATION' => 'qualification_name','ADDRESSTYPE' => 'address_type','LOCALITY' => 'locality_name','ASSETTYPE' => 'name','PROPERTIES' => 'name','INVESTMENTTYPE' => 'name','INSURANCETYPE' => 'name','PERSONSMET' => 'person_met_name','RESIDENCEOWNERSHIP' => 'name','PAYMENTMODE' => 'name','ACCOUNTTYPE' => 'name','SOURCEOFOTHERINCOME' => 'name','MORTAGEPROPERTYTYPE' => 'name','ENDUSEOFLOAN' => 'name','SOURCEOFBALANCETRANSFER' => 'name', 'STATUSOFCONSTRUCTION' => 'name','BTLENDERLIST'=>'lender_name','MORTAGEPROPERTIES'=>'property_name');
		
		$master_tables_pkid = array('INDUSTRYCLASSIFICATION' => 'industry_classification_id','UOM' => 'uom_id','OCCUPATIONMEMBERS' => 'occupation_non_earning_member_id','EDUQUALIFICATION' => 'qualification_name', 'TYPEOFACTIVITY' => 'type_of_activity_id','RELATIONSHIPS' => 'relationship_id','FREQUENCY' => 'frequency_id', 'CUSTOMERBEHAVIOUR' => 'customer_behaviour_id', 'CUSTOMERSEGMENT' => 'customer_segment_id','DESIGNATION' => 'designation_id', 'EARNINGMEMBERSSTATUS' => 'earning_member_status_id','EDUQUALIFICATION' => 'qualification_id','ADDRESSTYPE' => 'address_type_id','LOCALITY' => 'locality_id','ASSETTYPE' => 'id','PROPERTIES' => 'id','INVESTMENTTYPE' => 'id','INSURANCETYPE' => 'id','PERSONSMET' => 'person_met_id','RESIDENCEOWNERSHIP' => 'id','PAYMENTMODE' => 'id','ACCOUNTTYPE' => 'id','SOURCEOFOTHERINCOME' => 'id','MORTAGEPROPERTYTYPE' => 'id','ENDUSEOFLOAN' => 'id','SOURCEOFBALANCETRANSFER' => 'id', 'STATUSOFCONSTRUCTION' => 'id','MORTAGEPROPERTIES' => 'mortage_property_id','BTLENDERLIST'=>'bt_lender_list_id');
		//*******************INTERNAL PURPOSE***************************************************
		
		//get Alreday assigned ques and kys from template
		$fields = array('fk_key');
		$where_condition_array = array('fk_template_id' =>$templateid,'isactive' => 1,'fk_form_id' =>$formid );
		$exits_questions = $this->Template_Management_Model->selectCustomRecords($fields,$where_condition_array,SCORECARDQUESTIONS);
		$result_data = array();
		//print_r();
		if(!count($exits_questions))
		{
				
			$fields = array('question_key_mapping_id','fk_form_id','fk_category_id','question','key','ismaster','master_name');
			$where_condition_array = array();
			if($formid != 0)
			{
			 $where_condition_array = array('isactive' => 1,'fk_form_id' => $formid,'fk_category_id' => $categoryid);
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
					
					$result_data[$res_key]['score_question_id'] = null;
					$result_data[$res_key]['fk_template_id'] = null;
					$result_data[$res_key]['fk_key'] = null;
					$result_data[$res_key]['weightage'] = null;
					$result_data[$res_key]['calc_type'] = null;
					if($result['master_name'] != null || $result['master_name'] != "")
					{
						//echo $result['master_name'];
						$fields = array($master_tables_pkid[$result['master_name']].' as id',$master_tables_field_names[$result['master_name']].' as name');
						
						$table = constant($result['master_name']);
						$where_condition_array = array('isactive' => 1);
						$answers = $this->Template_Management_Model->selectCustomRecords($fields,$where_condition_array,$table);
						foreach($answers as $answer_key => $answer)
						{
							$answers[$answer_key]['answer'] = null;
							$answers[$answer_key]['fk_score_question_id'] = null;
							$answers[$answer_key]['score'] = null;
							$answers[$answer_key]['score_answer_id'] = null;
						}
						$result_data[$res_key]['answers'] = $answers;
					}
				}
			}
		}
		else
		{
			
			$temp_array = array();
				foreach($exits_questions as $res)
				{
					array_push($temp_array,$res['fk_key']);
				}
				//print_r($temp_array);
			$this->db->SELECT('QUESTIONKEYMAPPING.question_key_mapping_id,QUESTIONKEYMAPPING.fk_form_id,QUESTIONKEYMAPPING.question,QUESTIONKEYMAPPING.key,QUESTIONKEYMAPPING.master_name,SCORECARDQUESTIONS.score_question_id,SCORECARDQUESTIONS.fk_template_id,SCORECARDQUESTIONS.fk_form_id,SCORECARDQUESTIONS.fk_key,SCORECARDQUESTIONS.weightage,SCORECARDQUESTIONS.calc_type');
			$this->db->FROM(QUESTIONKEYMAPPING.' as QUESTIONKEYMAPPING');
			$this->db->JOIN(SCORECARDQUESTIONS.' as SCORECARDQUESTIONS','QUESTIONKEYMAPPING.fk_form_id = SCORECARDQUESTIONS.fk_form_id AND QUESTIONKEYMAPPING.key = SCORECARDQUESTIONS.fk_key AND SCORECARDQUESTIONS.isactive = 1','LEFT');
			
			if($formid != 0)
			{
			 $this->db->WHERE('QUESTIONKEYMAPPING.fk_form_id',$formid);
			 $this->db->WHERE('QUESTIONKEYMAPPING.fk_category_id',$categoryid);
			}
			$this->db->WHERE_NOT_IN('QUESTIONKEYMAPPING.key',$temp_array);
			$this->db->WHERE('QUESTIONKEYMAPPING.isactive',1);
			//$this->db->WHERE('SCORECARDQUESTIONS.isactive',1);
			
			$result_data = $this->db->GET()->result_array();
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
						foreach($answers as $answer_key => $answer)
						{
							$answers[$answer_key]['answer'] = null;
							$answers[$answer_key]['fk_score_question_id'] = null;
							$answers[$answer_key]['score'] = null;
							$answers[$answer_key]['score_answer_id'] = null;
						}
						$result_data[$res_key]['answers'] = $answers;
					}
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
	
	public function getScorecardDetails_post()
	{
		$templateid = $this->post('templateid');
		
		//Get Categories assigned to this template$template_id = $this->post('template_id');
		 $this->db->SELECT('QUESTIONCATEGORY.category_name,TEMPLATECATEGORYWEIGHTAGE.template_category_weightage_id, TEMPLATECATEGORYWEIGHTAGE.fk_question_category_id, TEMPLATECATEGORYWEIGHTAGE.fk_template_id, TEMPLATECATEGORYWEIGHTAGE.weightage, DATE_FORMAT(TEMPLATECATEGORYWEIGHTAGE.createdon,"%d/%m/%Y") as createdon, TEMPLATECATEGORYWEIGHTAGE.fk_createdby,  DATE_FORMAT(TEMPLATECATEGORYWEIGHTAGE.updatedon, "%d/%m/%Y") as updatedon, TEMPLATECATEGORYWEIGHTAGE.isactive, TEMPLATECATEGORYWEIGHTAGE.fk_updatedby');
			  $this->db->FROM(TEMPLATECATEGORYWEIGHTAGE .' as TEMPLATECATEGORYWEIGHTAGE');
			  $this->db->JOIN(QUESTIONCATEGORY.' as QUESTIONCATEGORY','TEMPLATECATEGORYWEIGHTAGE.fk_question_category_id = QUESTIONCATEGORY.question_category_id');
			 $this->db->WHERE('TEMPLATECATEGORYWEIGHTAGE.fk_template_id',$templateid);
		 $template_categories = $this->db->GET()->result_array();
		//print_r($template_categories);
		foreach($template_categories as $cate_key => $category)
		{
			$this->db->SELECT('QUESTIONKEYMAPPING.question_key_mapping_id,QUESTIONKEYMAPPING.fk_form_id,QUESTIONKEYMAPPING.question,QUESTIONKEYMAPPING.key,QUESTIONKEYMAPPING.master_name,SCORECARDQUESTIONS.score_question_id,SCORECARDQUESTIONS.fk_template_id,SCORECARDQUESTIONS.fk_form_id,SCORECARDQUESTIONS.fk_key,SCORECARDQUESTIONS.weightage,SCORECARDQUESTIONS.calc_type');
			$this->db->FROM(SCORECARDQUESTIONS.' as SCORECARDQUESTIONS');
			$this->db->JOIN(QUESTIONKEYMAPPING.' as QUESTIONKEYMAPPING','SCORECARDQUESTIONS.fk_form_id = QUESTIONKEYMAPPING.fk_form_id AND QUESTIONKEYMAPPING.key = SCORECARDQUESTIONS.fk_key AND SCORECARDQUESTIONS.isactive = 1 AND QUESTIONKEYMAPPING.isactive = 1','LEFT');
			$this->db->WHERE('QUESTIONKEYMAPPING.fk_category_id',$category['fk_question_category_id']);
			$template_categories[$cate_key]['questions'] = $this->db->GET()->result_array();
		}
		
						$data['dataStatus'] = true;
						$data['status'] = REST_Controller::HTTP_OK;
						$data['records'] = $template_categories;
						$this->response($data,REST_Controller::HTTP_OK);
		
	}
	
	
	
}