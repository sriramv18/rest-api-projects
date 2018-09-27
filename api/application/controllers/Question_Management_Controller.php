<?php
/**

 * User: velz
 * This Controller deals with User Management CRUD Operations
 */

defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/libraries/REST_Controller.php';


class Question_Management_Controller extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('Question_Management_Model');
        
    }
   
	public function listAllQuestions_get()
	{
		$page = 0;$limit = 0;$sort = 'ASC';
		
		if($this->get('page')) { $page  = $this->get('page'); }
		if($this->get('limit')){ $limit = $this->get('limit'); }
		if($this->get('sort')) { $sort  = $this->get('sort'); }
		
		$result = $this->Question_Management_Model->listAllQuestions($page,$limit,$sort);
		if($result['data_status'])
		{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result['data'];
				$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_NO_CONTENT);
		}
	}

	public function saveNewQuestion_post()// Save  single question and it's answers
	{
		
		$records = $this->post('records');
		$count = 0;
		
			$answers = array();
			if(array_key_exists('answers',$records))
			{
				$answers = $records['answers'];
				unset($records['answers']);
			}
			
			
			$question_id = $this->Question_Management_Model->saveRecords($records,QUESTIONS);
			
			if($question_id != '' || $question_id != null)
			{
				//$count++;
				if(count($answers))
				{
						foreach($answers as $answer)
						{
							
							
							$temp_answers = array('fk_question_id' => $question_id, 'answer' =>$answer['answer'] , 'createdon' =>$records['createdon'] , 'fk_createdby' =>$records['fk_createdby']);
							$child_id = $this->Question_Management_Model->saveRecords($temp_answers,QUESTIONANSWERS);
							
						}
				}
			}
			
			
		
		
		if($question_id != '' || $question_id != null)
		{
			        $data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['record'] = $question_id;
					$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$this->response($data,REST_Controller::HTTP_OK);
			
		}
}



	public function saveExistQuestion_post()
	{
		$records = $this->post('records');
		$answers = array();
		
		if(array_key_exists('answers',$records))
			{
				$answers = $records['answers'];
				unset($records['ansewrs']);
			}
			
			$where_condtion_array = array('question_id'=>$records['question_id']);
			$affected_rows = $this->Question_Management_Model->updateRecords($records,QUESTIONS,$where_condtion_array); 
			$affected_rows_child = 0;
			
			if(count($answers))
				{
					foreach($answers as $answer)
					{
						if($answer['question_answer_id'] != null || $answer['question_answer_id'] != '')
						{
							$where_condtion_array = array('question_answer_id'=>$answer['question_answer_id']);
							$answer['updatedon'] =  $records['updatedon'];
							$answer['fk_updatedby'] = $records['fk_updatedby']; 
							$affected_rows_child = $this->Question_Management_Model->updateRecords($answer,QUESTIONANSWERS,$where_condtion_array); 
						}
						else
						{
							$temp_answers = array('fk_question_id' => $records['question_id'], 'answer' =>$answer['answer'] , 'createdon' =>$records['updatedon'] , 'fk_createdby' =>$records['fk_updatedby']);
							$child_id = $this->Question_Management_Model->saveRecords($temp_answers,QUESTIONANSWERS);
						}
					}
				}
			if($affected_rows == 1) //&& (count($answers) == $affected_rows_child))
			{
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['record'] = $affected_rows;
					$this->response($data,REST_Controller::HTTP_OK);
				
			}
			else
			{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$this->response($data,REST_Controller::HTTP_OK);
			
			
			}
	}
	
	/*   ******** For Updated isActive status of ansewrs only ******/
	public function updateAnswerStatus()
	{
		$records = $this->post('records');
		
		$where_condtion_array = array('question_answer_id' => $records['question_answer_id']);
		$affected_rows = $this->Question_Management_Model->updateRecords($records,QUESTIONANSWERS,$where_condtion_array);
			
			if($affected_rows == 1) //&& (count($answers) == $affected_rows_child))
			{
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['record'] = $affected_rows;
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
	
	
	