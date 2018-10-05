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
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins);
			
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
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins);
		
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
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins);
			
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
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins);
			
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
		
		$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins);
			
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
	
	/** For Save Pd-Team-Details */
	public function savePdTeam_post()
	{
		$records = $this->post('records');

		if(false !== array_key_exists(PDTEAMID,$records))  //Update Record
		{
			

			$where_condition_array = array(PDTEAMID => $records[PDTEAMID]);

			$pdTeamMaster = array('team_name'=>$records['team_name'],'updatedon'=>$records['updatedon'],'fk_updatedby'=>$records['fk_updatedby']);
			//pdteam_id, team_name, createdon, fk_createdby, updatedon, fk_updatedby, isactive
			$result = $this->Common_Masters_Model->updateRecords($pdTeamMaster,PDTEAM,$where_condition_array);
			//print_r($pdTeamMaster);

			if($result == true){
				$root_array = $records['temp_array'];
				if(!empty($root_array)){
				foreach($root_array as $key => $value){
								
					$pdTeamChild = array(
						        'fk_city_id'=>$value['cityid']['city_id'],
								'fk_team_id'=>$records['pdteam_id'],
								'team_type' => 1,
								'fk_lender_id' =>$value['lenderid']['entity_id']);

					$this->Common_Masters_Model->saveRecords($pdTeamChild,PDTEAMMAP);
				}}
			
			}
			
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

		$pdTeamMaster = array('team_name'=>$records['team_name'],'fk_createdby'=>$records['fk_createdby'],'createdon'=>$records['createdon']);
		
		$result = $this->Common_Masters_Model->saveRecords($pdTeamMaster,PDTEAM);
		
			if(!empty($result)){
		
				$root_array = $records['temp_array'];

				foreach($root_array as $key => $value){
								
					$pdTeamChild = array(
						        'fk_city_id'=>$value['cityid']['city_id'],
								'fk_team_id'=>$result,
								'team_type' => 1,
								'fk_lender_id' =>$value['lenderid']['entity_id']);

					$this->Common_Masters_Model->saveRecords($pdTeamChild,PDTEAMMAP);
				}
				
			}

			
			if(count($result) !=0 )
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

	/** End Of Save PD-Team-Detail-Function */

	/** For Of Delete PD-Team-Mapping-Detail-Function */
	public function deletePdTeamMapping_post()
	{
		$records = $this->post('records');
	
		
		foreach($records as $key => $value){
			//In Master - Have To The Record ( Updated on and Updated By )
			$where_condition_array1 = array(PDTEAMID => $value['fk_team_id']);

			$pdTeamMaster = array(
				'fk_updatedby'=>$value['fk_updatedby'],
				'updatedon' =>$value['updatedon']);
			
			$result1 = $this->Common_Masters_Model->updateRecords($pdTeamMaster,PDTEAM,$where_condition_array1);
			
			//In child - Have To  Delete The Record
			$where_condition_array2 = array('pdteam_map_id'=>$value['pdteam_map_id']);

			$pdTeamChild = array(
				'pdteam_map_id'=>$value['pdteam_map_id']);
			
			$result2 = $this->Common_Masters_Model->deleteRecords($pdTeamChild,PDTEAMMAP,$where_condition_array2);
		}
		
			if($result1 == 1 && $result2 == 1)
			{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				// $data['records'] = $result1;
				$this->response($data,REST_Controller::HTTP_OK);
			}
			else  
			{				
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
				$this->response($data,REST_Controller::HTTP_OK);
			}
		
	}
	/**End of Delete PD-TEAM-MAPPING  */

	
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
	
	/* For Get PD Team Details (Master Table info)*/
	public function getListOfPDTeam_get()
		{		
			$result = $this->Common_Masters_Model->pdteamlist();
		
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
	/* End Of Get PD Team Details (Master Table info)*/

	/* For Get PD Team Mapping Details (Child Table info)*/
		public function getListOfPDTeamMap_post(){
			
			$PK = $this->post('primary_key');
			
			$columns = array('m_city.name as city_name',
			                 'm_entities.full_name as lender_name',
							 'PDTEAMMAP.pdteam_map_id as pdteam_map_id', 
							 'PDTEAMMAP.fk_city_id as fk_city_id',
							 'PDTEAMMAP.fk_team_id as fk_team_id',
							 'PDTEAMMAP.isactive as isactive',
							 'PDTEAMMAP.team_type as team_type',
							 'PDTEAMMAP.fk_lender_id as fk_lender_id');
			$table = PDTEAMMAP.' as PDTEAMMAP';
			$joins = array(
				array(
					'table' => 'm_city',
					'condition' => 'PDTEAMMAP.fk_city_id = m_city.city_id ',
					'jointype' => 'INNER'
				),
				array(
					'table' => 'm_entities',
					'condition' => 'PDTEAMMAP.fk_lender_id = m_entities.entity_id',
					'jointype' => 'INNER'
				)
			);
			$where_condition_array = array('PDTEAMMAP.fk_team_id'=> $PK);
			
			$result = $this->Common_Masters_Model->getJoinRecords($columns,$table,$joins,$where_condition_array);
				
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
		/* End of Get PD Team Mapping Details (Child Table info)*/

		
	/**
	 * Company File Upload
	 */
	public function saveCompany_post(){
		
		$records = json_decode($this->post('records'),true);
		if(!empty($_FILES['logo']['tmp_name']))
		{
						
				$logo = $_FILES['logo']['tmp_name'];
				$logoname = $_FILES['logo']['name'];
				$logoname = strtolower($logoname);
				//$logos3path = "";
				$logos3path = 'sineedge/'.$logoname;
				$bucketname = PROFILE_PICTURE_BUCKET_NAME;
				$key = $logos3path;
				$sourcefile = $logo;
				
				$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
				$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
				print_r($s3result);
				if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
				{
					$records['logo'] = $logoname;
				}
				else
				{
					$records['logo'] = null;
				}
				
				
				
				
				
		}

		$result = $this->Common_Masters_Model->saveRecords($records,COMPANY);
		
			if($result != "" || $result != null)
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

    /** End Of CompanyDetail */

    /* For Update PD Notification Details*/
	public function savePDNotification_post(){

		$records = $this->post('records');
		//$count = 0;
		
			
		foreach( $records as $record){
				$where_condition_array = array(PDNOTIFICATIONID => $record[PDNOTIFICATIONID]);	
				$result = $this->Common_Masters_Model->updateRecords($record,PDNOTIFICATION,$where_condition_array);
				// if($result == 1)
				// {
				// 	$count++;
				// }
		}
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
		/* End of Update PD Notification Details*/
}