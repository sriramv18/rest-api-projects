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
		
	}

	public function saveNewUser_post()
	{
		echo "saveNewUser_post";
		$data = $this->post('data');
		
		//$file = $_FILES['myfile'];
		print_r($data);//print_r($file);
	}
	
	public function updateExistUser_post()
	{
		
	}

		
	 
   
}