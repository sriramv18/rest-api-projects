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
   
	
	public triggerNewPD_post()
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
	
	
}