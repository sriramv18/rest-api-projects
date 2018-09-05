<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class Common_Masters_Model extends SPARQ_Model {

		public function __construct() 
		{
            parent::__construct();
        }
		
		
		public function getListOfMasters()
		{
				return $this->selectRecords('m_list_of_masters');
		}


}