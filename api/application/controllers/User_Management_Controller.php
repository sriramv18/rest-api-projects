<?php
/**

 * User: velz
 * This Controller deals with User Management CRUD Operations
 */

defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/libraries/REST_Controller.php';


class User_Management_Controller extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('User_Management_Model');
        
    }
   
	public function listAllUsers_get()
	{
		//echo "function";

		$result = $this->User_Management_Model->listAllUsers();
		//echo "result";
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

	public function saveNewUser_post()
	{
		$this->load->library('AWS_S3');
		//print_r($this->post('roles'));die;
		//print_r($this->post());die;
		//print_r($_FILES['profilepic']['name']);die;
		$roles = "";
		$lender_hierarchy = "";
		//print_r($this->post('roles'));die;
		if($this->post('roles')){ $roles = $this->post('roles'); }
		
		if($this->post('lender_hierarchy')){ $lender_hierarchy = json_decode($this->post('lender_hierarchy'),true); }
		
		
		$records = json_decode($this->post('records'),true);

		//print_r($records);die;
		$roles = json_decode($this->post('roles'),true);
		//print_r(json_decode($this->post('lender_hierarchy'),true));die;
		//$lender_hierarchy  = json_decode($this->post('lender_hierarchy'),true);
		//echo $_FILES['profilepic']['name'];die;
		if(!empty($_FILES['profilepic']['tmp_name']))
		{
				
				
				$profilepic = $_FILES['profilepic']['tmp_name'];
				$profilepicname = $_FILES['profilepic']['name'];
				$profilepicname = strtolower($profilepicname);
				$profilepics3path = "";
				
				if(array_key_exists('fk_entity_id',$records))
				{
					$entity_id = $records['fk_entity_id'];
						if($entity_id == 1) //1 means sine_edge Profile
						{
							$profilepics3path = 'sineedge/'.$profilepicname;
						}
						else if($entity_id == 2)//1 means lender Profile
						{
							$profilepics3path = 'lender/'.$profilepicname;
						}
						else // else or 3 means vendor Profile
						{
							$profilepics3path = 'vendor/'.$profilepicname;
						}
				}
				
				$bucketname = PROFILEPICTUREBUCKETNAME;
				$key = $profilepics3path;
				$sourcefile = $profilepic;
				
				$bucket_data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
				$s3result= $this->aws_s3->uploadFileToS3Bucket($bucket_data);
				
				if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
				{
					$records['profilepic'] = $profilepicname;
				}
				else
				{
					$records['profilepic'] = null;
				}
				
				
				
				
				
		}
		
			$user_id = $this->User_Management_Model->saveRecords($records,USERPROFILE);//insert user records and get userid
				
				if($roles != "")
				{
					foreach($roles as $role)
					{
						$role_array = array('user_role'=>$role['user_role'],'fk_userid'=>$user_id);//insert roles againest user
						$this->User_Management_Model->saveRecords($role_array,USERPROFILEROLES);
					}
				}
		//$user_id = 52;
				
				if($lender_hierarchy != "")
				{
					//print_r($lender_hierarchy);die;
					foreach($lender_hierarchy as $hierarchy)
					{	//echo $hierarchy['lender_hierarchy_id'];die;
						$hierarchy = array('fk_hierarchy_id'=>$hierarchy['lender_hierarchy_id'],'fk_user_id'=>$user_id);//insert hierarchy  againest lender type users
						$this->User_Management_Model->saveRecords($hierarchy,USERPROFILEHIERARCHY);
					}
				}
				
				if($user_id != '' || $user_id != null)
				{
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['record'] = $user_id;
					$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
				}
		
	}
	
	
	public function updateExistUser_post()
	{
		$roles = "";
		$lender_hierarchy = "";
		
		if($this->post('roles')){ $roles = $this->post('roles'); }
		
		if($this->post('lender_hierarchy')){ $lender_hierarchy = json_decode($this->post('lender_hierarchy'),true); }
		
		
		$records = json_decode($this->post('records'),true);
		$roles = json_decode($this->post('roles'),true);
		
		// $lender_hierarchy  = json_decode($this->post('lender_hierarchy'),true);
		
		if(!empty($_FILES['profilepic']['tmp_name']))
		{
				
				
				$profilepic = $_FILES['profilepic']['tmp_name'];
				$profilepicname = $_FILES['profilepic']['name'];
				$profilepicname = strtolower($profilepicname);
				$profilepics3path = "";
				
				if(array_key_exists('fk_entity_id',$records))
				{
					$entity_id = $records['fk_entity_id'];
						if($entity_id == 1) //1 means sine_edge Profile
						{
							$profilepics3path = 'sineedge/'.$profilepicname;
						}
						else if($entity_id == 2)//1 means lender Profile
						{
							$profilepics3path = 'lender/'.$profilepicname;
						}
						else // else or 3 means vendor Profile
						{
							$profilepics3path = 'vendor/'.$profilepicname;
						}
				}
				
				$bucketname = PROFILEPICTUREBUCKETNAME;
				$key = $profilepics3path;
				$sourcefile = $profilepic;
				
				$data = array('bucket_name'=>$bucketname,'key'=>$key,'sourcefile'=>$sourcefile);
				$s3result= $this->aws_s3->uploadFileToS3Bucket($data);
				
				if(is_object($s3result) && $s3result['ObjectURL'] != '' && $s3result['@metadata']['statusCode'] == 200)
				{
					$records['profilepic'] = $profilepicname;
				}
				else
				{
					$records['profilepic'] = null;
				}
				
				
				
				
				
		}
			$where_condition_array  = array('userid'=>$records['userid']);
			$modified = $this->User_Management_Model->updateRecords($records,USERPROFILE,$where_condition_array);//insert user records and get userid
				
				if($roles != "")
				{
					foreach($roles as $role)
					{
						
						$this->User_Management_Model->updateRecords(array('isactive'=>0),USERPROFILEROLES,array('fk_userid'=>$records['userid']));
						$role_array = array('user_role'=>$role['user_role'],'fk_userid'=>$records['userid']);
						$this->User_Management_Model->saveRecords($role_array,USERPROFILEROLES);
					}
				}
				
				if($lender_hierarchy != "")
				{
					foreach($lender_hierarchy as $hierarchy)
					{
						
						$this->User_Management_Model->updateRecords(array('isactive'=>0),USERPROFILEHIERARCHY,array('fk_user_id'=>$records['userid']));
						$hierarchy = array('fk_hierarchy_id'=>$hierarchy['lender_hierarchy_id'],'fk_user_id'=>$records['userid']);//insert hierarchy  againest lender type users
						$this->User_Management_Model->saveRecords($hierarchy,USERPROFILEHIERARCHY);
					}
				}
				
				if($modified != '' || $modified != null || $modified != 0)
				{
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['record'] = $modified;
					$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$this->response($data,REST_Controller::HTTP_NOT_MODIFIED);
				}
		
	}
   
   /**
	* sriram get roles function
   */
	public function getUsersDetails_post(){
		
			$userid = $this->post('userid');

			$result = $this->User_Management_Model->getUserDetails($userid);
		//echo "result";
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
}