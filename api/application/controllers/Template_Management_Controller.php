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
		
		$result = $this->User_Management_Model->$listAllTemplates();
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

	public function saveNewTemplateName_post()
	{
		$template_name = $this->post('template_name');
		
		if(array_key_exists('template_id',$template_name))
		{
				$template_id = $this->Template_Management_Model->saveRecords($template_name,TEMPLATE);
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
						$this->response($data,REST_Controller::HTTP_NO_CONTENT);
					
				}
		}
		else
		{
			$where_condition_array = array('template_id'=>$template_name['template_id']);
			$modified = $this->db->updateRecords($template_name,TEMPLATE,$where_condition_array);
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
						$data['status'] = REST_Controller::HTTP_NO_CONTENT;
						$this->response($data,REST_Controller::HTTP_NO_CONTENT);
					
				}
			
		}
		
	}
	
	
	public function saveTemplateLenderDetails()
	{
		$template_id = '';
		$count = 0;
		
		if($this->post('template_id'))
		{
			$template_id = $this->post('template_id');
		}
		
		$template_lender_details = $this->post('template_lender_details');
		
		foreach($template_lender_details as $template_lender_detail)
		{
				if(array_key_exists('lender_template_id',$template_lender_detail))
				{
					$where_condition_array = array('lender_template_id'=>$template_lender_detail['lender_template_id']);
					$modified = $this->Template_Management_Model->updateRecords(template_lender_detail,LENDERTEMPLATE,$where_condition_array);
					if($modified != "" || $modified != null){ $count++; } 
				}
				else
				{
					$template_lender_detail['fk_template_id'] = $template_id;
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
						$this->response($data,REST_Controller::HTTP_NO_CONTENT);
					
				}
		
		
	}
	
	public function saveTemplateCategoryDetails()
	{
		$template_id = '';
		$count = 0;
		
		if($this->post('template_id'))
		{
			$template_id = $this->post('template_id');
		}
		
		$template_category_details = $this->post('template_category_details');
		
		foreach($template_category_details as $template_category_detail)
		{
			if(array_key_exists('template_catagory_weightage_id',$template_category_detail))
			{
				$where_condition_array = array('template_catagory_weightage_id'=>$template_category_detail['template_catagory_weightage_id']);
				$modified = $this->Template_Management_Model->updateRecords($template_category_detail,TEMPLATECATAGORYWEIGHTAGE,$where_condition_array);
				if($modified != "" || $modified != null){ $count++; } 
			}
			else
			{
					$template_category_detail['fk_template_id'] = $template_id;
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
						$this->response($data,REST_Controller::HTTP_NO_CONTENT);
					
				}
		
		
	}
	
	
	
}