<?php
/**

 * User: velz
 * This Controller deals with User Management CRUD Operations
 */

defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/libraries/REST_Controller.php';


class Common_Masters_Controller extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('Common_Masters_Model');
		$this->load->library('AWS_S3');
        
    }
 	
	
	/*  For Save,Update and Retrieve all  Master  Tables*/
	
	
	public function getListOfMaster_post()
		{
			
			$table_name = $this->post('master_name');
			//echo $table_name;
			$result = $this->Common_Masters_Model->selectRecords(constant($table_name));
			//print_r($result);
			//die();
			if(count($result) > 0)
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
	
	public function saveMaster_post()
	{
		
		$records = $this->post('records');
		$table_name = $this->post('master_name');

		if(false !== array_key_exists(constant($table_name.'ID'),$records))  //Update Record
		{
			
			$where_condition_array = array(constant($table_name.'ID') => $records[constant($table_name.'ID')]);
			
			$result = $this->Common_Masters_Model->updateRecords($records,constant($table_name),$where_condition_array);
			
			if($result)
			{
				
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else  
			{	
				
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				$this->response($data,REST_Controller::HTTP_OK);
			}
		}
		else 	// Insert Record	
		{
			
			$result = $this->Common_Masters_Model->saveRecords($records,constant($table_name));
			
			if($result)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else
			{
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_SERVICE_UNAVAILABLE;
				$this->response($data,REST_Controller::HTTP_OK);
			}
		}
		
	}
	
	
	
	/*  End Of  Save,Update and Retrieve all  Master  Tables */

	/*  For Branch Listing */
	public function getListOfBranches_get(){
		
	    $columns = array('m_city.name as city_name','BRANCH.*');
		$table = BRANCH.' as BRANCH';
		$joins = array(
			array(
				'table' => 'm_city',
				'condition' => 'BRANCH.fk_city_id = m_city.city_id ',
				'jointype' => 'INNER'
			)
		);
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$print_query = '');
			
			if(count($result) > 0)
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
	/*  End Of Branch Master */

	/*  For Company Listing */
	public function getListOfCompany_get(){
	    $columns = array('m_city.name as city_name','m_states.name as state_name','COMPANY.*');
		$table = COMPANY.' as COMPANY';
		$joins = array(
			array(
				'table' => 'm_city',
				'condition' => 'COMPANY.city = m_city.city_id ',
				'jointype' => 'INNER'
			),
			array(
				'table' => 'm_states',
				'condition' => 'COMPANY.state = m_states.state_id',
				'jointype' => 'INNER'
			)
		);
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$print_query = '');
			//print_r($result);
			//die();
			if(count($result) > 0)
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
	/*  End of Company Listing */

	/*  For Product Listing */
	public function getListOfSubProduct_get(){
	    $columns = array('m_products.name as product_name','SUBPRODUCTS.*');
		$table = SUBPRODUCTS.' as SUBPRODUCTS';
		$joins = array(
			array(
				'table' => 'm_products',
				'condition' => 'SUBPRODUCTS.fk_product_id = m_products.product_id',
				'jointype' => 'INNER'
			)
		);
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$print_query = '');
			
			if(count($result) > 0)
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
	/*  End of Product Listing */

	/*  For State Listing */
	public function getListOfState_get(){
	    $columns = array('m_regions.name as region_name','STATE.*');
		$table = STATE.' as STATE';
		$joins = array(
			array(
				'table' => 'm_regions',
				'condition' => 'STATE.fk_region_id = m_regions.region_id ',
				'jointype' => 'INNER'
			)
		);
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$print_query = '');
			
			if(count($result) > 0)
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
	/*  End of State Listing */

	/*  For City Listing */
	public function getListOfCity_get(){
	    $columns = array('m_states.name as state_name','CITY.*');
		$table = CITY.' as CITY';
		$joins = array(
			array(
				'table' => 'm_states',
				'condition' => 'CITY.fk_state_id = m_states.state_id ',
				'jointype' => 'INNER'
			)
		);
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$print_query = '');
			
			if(count($result) > 0)
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
	/*  End of City Listing */

	/* For only update PDAllocationType */
	public function savePDAllocationType_post()
	{
		
		$records = $this->post('records');
		$count = 0;
		
			
		foreach( $records as $record){
				$where_condition_array = array('pd_allocation_type_id' => $record['pd_allocation_type_id']);	
				$result = $this->Common_Masters_Model->updateRecords($record,PDALLOCATIONTYPE,$where_condition_array);
				if($result == 1)
				{
					$count++;
				}
		}

		if($count == count($records))
		{
				
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $result;
				$this->response($data,REST_Controller::HTTP_OK);
		}
		else  
		{		
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	/**End of PD-Allocation-Type  */
	
	
	/* For update PD Notification Table info*/
	
	public function savePDNotifications_post()
	{
		
	}
	
	
	/* For Get List PD Notifications config's */
	
	public function getPDNotificationsList_get()
	{
		$columns = array('PDNOTIFICATION.pdnotification_id', 'PDNOTIFICATION.fk_pd_status_id','PDSTATUS.pd_status_name', 'PDNOTIFICATION.sms_lender', 'PDNOTIFICATION.sms_pdofficer', 'PDNOTIFICATION.sms_pdincharge', 'PDNOTIFICATION.mail_lender','PDNOTIFICATION.mail_pdincharge', 'PDNOTIFICATION.mail_pdofficer',  'PDNOTIFICATION.isactive');
		$table = PDNOTIFICATION." as PDNOTIFICATION";
		$joins = array(
		
				array('table' => PDSTATUS.' as PDSTATUS',
				'condition' => 'PDNOTIFICATION.fk_pd_status_id = PDSTATUS.pd_status_id ',
				'jointype' => 'INNER')
			);
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins);
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
				$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				$this->response($data,REST_Controller::HTTP_OK);
		}
		
		
	}
	
	
	**
 * Company File Upload
 */
	public function saveCompany_post(){
		//echo "function in";
		$records = json_decode($this->post('records'),true);

		if(!empty($_FILES['logo']['tmp_name']))
		{
						
				$logo = $_FILES['logo']['tmp_name'];
				$logoname = $_FILES['logo']['name'];
				$logoname = strtolower($logoname);
				$logos3path = "";
				$logos3path = 'sineedge/'.$logoname;
				$bucketname = PROFILE_PICTURE_BUCKET_NAME;
				$key = $logos3path;
				$sourcefile = $logo;
				
				$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
				$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
				
				if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
				{
					$records['logo'] = $logoname;
				}
				else
				{
					$records['logo'] = null;
				}
				
				
				
				
				
		}

		
			
		$result = $this->Common_Masters_Model->saveRecords($records,'COMPANY');
		
			if(count($result) > 0)
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



}