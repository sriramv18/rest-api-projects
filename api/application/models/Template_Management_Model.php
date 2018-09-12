<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class Template_Management_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
        }
		
		
   public function listAllTemplates()
   {
	   $result_data = array();
	   
	  
	   $result = $this->db->get()->result_array();
	   
	   if(count($result) > 0 )
	   {
		   $result_data['data_status'] = true;
		   $result_data['data'] = $result;
		   return $result_data;
		   
	   }
	   else
	   {
		  $result_data['data_status'] = false;
		  $result_data['data'] =  null;
		  return $result_data;
	   }
	   
   }

}