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
		
		$result = $this->User_Management_Model->$listAllQuestions();
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

	public function saveNewQuestion_post()// Save Array of question and it's answers(Single too)
	{
		
		$records = $this->post('records');
		$count = 0;
		foreach($records as $record)
		{
			$answers = array();
			if(array_key_exists('answers',$record))
			{
				$answers = $record['answers'];
				unset($record['ansewrs']);
			}
			
			$question_id = $this->db->saveRecords($record,QUESTIONS);
			
			if($question_id != '' || $question_id != null)
			{
				$count++;
				foreach($answers as $answer)
				{
					$temp_answers = array('fk_question_id' => $question_id, 'answer' =>$answer , 'createdon' =>$record['createdon'] , 'fk_createdby' =>$record['fk_createdby'] , 'updatedon' =>$record['updatedon'], 'fk_updatedby' =>$record['fk_updatedby']);
					$this->db->saveRecords($temp_answers,QUESTIONANSWERS);
				}
			}
			
			
		}
		
		if($count != 0 && $count == count($records))
		{
			        $data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['record'] = $entity_id;
					$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			
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
			$affected_rows = $this->db->updateRecords($records,QUESTIONS,$where_condtion_array); 
			$affected_rows_child = 0;
			foreach($answers as $answer)
			{
				$where_condtion_array = array('question_answer_id'=>$answer['question_answer_id']);
				$affected_rows_child = $this->db->updateRecords($answer,QUESTIONANSWERS,$where_condtion_array); 
			}
			
			if($affected_rows == 1 && (count($answers) == $affected_rows_child))
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
					$this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
			
			
			}
	}
	
}
	
	
	