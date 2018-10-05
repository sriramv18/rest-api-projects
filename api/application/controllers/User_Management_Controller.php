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
        $this->load->library('AWS_S3');
		$this->load->library('AWS_SES');
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
				$this->response($data,REST_Controller::HTTP_OK);
		}
	}

	public function saveNewUser_post()
	{
		
		$roles = "";
		$lender_hierarchy = "";
		$pdofficer = "";
		if($this->post('roles')){ $roles = json_decode($this->post('roles'),true); }
		if($this->post('pdofficer')){ $pdofficer = json_decode($this->post('pdofficer'),true);}
		if($this->post('lender_hierarchy')){ $lender_hierarchy = json_decode($this->post('lender_hierarchy'),true); }
		
		
		$records = json_decode($this->post('records'),true);

		
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
				
				$bucketname = PROFILE_PICTURE_BUCKET_NAME;
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
		
				
				if($lender_hierarchy != "")
				{
					
					foreach($lender_hierarchy as $hierarchy)
					{	
						$hierarchy = array('fk_hierarchy_id'=>$hierarchy['lender_hierarchy_id'],'fk_user_id'=>$user_id);
						$this->User_Management_Model->saveRecords($hierarchy,USERPROFILEHIERARCHY);
					}
				}

				if($pdofficer != ""){
					$pdofficer['fk_user_id'] = $user_id;
					//print_r($pdofficer);
					$this->User_Management_Model->saveRecords($pdofficer,PDOFFICIERSDETAILS);
				}
				if($user_id != '' || $user_id != null)
				{
					
					// send a verification mail for registered user to get PD alert informations
					// They have to clik a verification link from sent mail
					$this->aws_ses->verifyEmailIdentity($records['email']);
					$data['dataStatus'] = true;
					$data['status'] = REST_Controller::HTTP_OK;
					$data['record'] = $user_id;
					$this->response($data,REST_Controller::HTTP_OK);
				}
				else
				{
					$data['dataStatus'] = false;
					$data['status'] = REST_Controller::HTTP_NOT_MODIFIED;
					$this->response($data,REST_Controller::HTTP_OK);
				}
		
	}
	
	
	public function updateExistUser_post()
	{
		$roles = "";
		$lender_hierarchy = "";
		
		if($this->post('roles')){ $roles = $this->post('roles'); }
		if($this->post('pdofficer')){ $pdofficer = json_decode($this->post('pdofficer'),true);}		
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
				
				$bucketname = PROFILE_PICTURE_BUCKET_NAME;
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
						
						
					}
					foreach($roles as $role)
					{
						
						
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
						
					}

					foreach($lender_hierarchy as $hierarchy)
					{
						
						//insert hierarchy  againest lender type users
						$this->User_Management_Model->saveRecords($hierarchy,USERPROFILEHIERARCHY);
					}
				}

				if($pdofficer != ""){
					$this->User_Management_Model->updateRecords($pdofficer,PDOFFICIERSDETAILS,$pdofficer['fk_user_id']);
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
					$this->response($data,REST_Controller::HTTP_OK);
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
				$this->response($data,REST_Controller::HTTP_OK);
		}
	}
	
	/* Get Signed URL for profile picture 
	@params userid , entity id, profilepic name 
	 URL expires 5 min
	*/
	public function getSingedProfilePicURL_post()
	{
		$userid = $this->post('userid');
		$entityid = $this->post('entityid');
		$profilepic = $this->post('profilepic');
		
		$profilepics3path = '';
							if($entityid == 1) //1 means sine_edge Profile
							{
								$profilepics3path = 'sineedge/'.$profilepic;
							}
							else if($entityid == 2)//1 means lender Profile
							{
								$profilepics3path = 'lender/'.$profilepic;
							}
							else // else or 3 means vendor Profile
							{
								$profilepics3path = 'vendor/'.$profilepic;
							}
							$singed_uri = $this->aws_s3->getSingleObjectInaBucketAsSignedURI(PROFILE_PICTURE_BUCKET_NAME, $profilepics3path,'+5 minutes');
		
		if($singed_uri != null || $singed_uri != '')
		{
				$data['dataStatus'] = true;
				$data['status'] = REST_Controller::HTTP_OK;
				$data['records'] = $singed_uri;
				$this->response($data,REST_Controller::HTTP_OK);
		}
		else
		{		
				$data['dataStatus'] = false;
				$data['status'] = REST_Controller::HTTP_NO_CONTENT;
				$data['msg'] = 'No Profile URL Available';
				$this->response($data,REST_Controller::HTTP_OK);
			
		}
							
							
	}
}