<?php
/**

 * User: velz
 * This Controller deals with PD Related CRUD Operations
 */

defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/libraries/REST_Controller.php';


class PD_Controller extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('PD_Model');
        
    }
   
	
	public function triggerNewPD_post()
	{
		$pd_details = $this->post('pd_details');
		$pd_applicant_details = $this->post('pd_applicant_details');
		$count = 0;
		
		$pd_id = $this->PD_Model->saveRecords(PDTRIGGER,$pd_details);
		
		if($pd_id != null || $pd_id != '')
		{
			foreach($pd_applicant_details as $pd_applicant_detail)
			{
				$pd_applicant_detail['fk_pd_id'] = $pd_id;
				$co_applicant_id = $this->PD_Model->saveRecords(PDAPPLICANTSDETAILS,$pd_applicant_detail);
				if($co_applicant_id != null || $co_applicant_id != '')
				{
					$count = $count + 1;
				}
			}
		}
		
		if($pd_id != null || $pd_id != '' && $count != 0)
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
	
	
	
	
	public function updateExistPD_post()
	{
		$pd_details = $this->post('pd_details');
		$pd_applicant_details = $this->post('pd_applicant_details');
		$count = 0;
		
		$where_condition_array = array('pd_id' => $pd_details['pd_id']);
		$pd_id_modified = $this->PD_Model->updateRecords($pd_details,PDTRIGGER,$where_condition_array);
		
		if($pd_id_modified != null || $pd_id_modified != '')
		{
			foreach($pd_applicant_details as $pd_applicant_detail)
			{
				$where_condition_array = array('pd_co_applicant_id' => $pd_applicant_detail['pd_co_applicant_id']);
				$co_applicant_id_modified = $this->PD_Model->updateRecords($pd_applicant_detail,PDAPPLICANTSDETAILS,$where_condition_array);
				if($co_applicant_id_modified != null || $co_applicant_id_modified != '')
				{
					$count = $count + 1;
				}
			}
		}
		
		if($pd_id_modified != null || $pd_id_modified != '' && $count != 0)
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
	
	
	/*    PD_Triggerd and PD_Co_Applocants Details only for Listing Page
		@param page/offset
		@param limit
		@param sorting order(ASC/DESC)
	*/
	public function listLessPDDetails_get()
	{
			$page = 0;$limit = 50;$sort = 'DESC';
			if($this->get('page')) { $page  = $this->get('page'); }
			if($this->get('limit')){ $limit = $this->get('limit'); }
			if($this->get('sort')) { $sort  = $this->get('sort'); }
			
			$result_data = $this->PD_Model->listLessPDDetails($page,$limit,$sort);
			
			if($result_data['data_status'] == true)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result_data['data'];
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else
			{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$this->response($data,REST_Controller::HTTP_OK);
				
			}
			
	}
	
	
	
	
}