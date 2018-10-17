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

		/**
		 * This Function is used to Get The PD Team Related Datas for Listing
		 */
		// public function pdteamlist(){
		 
		// 	$result = $this->db->get(PDTEAM)->result_array();
		
		// 	if(count($result) !=0){
		// 		foreach($result as $key=> $r){
					
		// 			$cities = $this->db->get_where(PDTEAMMAP,array('fk_team_id'=>$r['pdteam_id']))->result_array();
		// 			array_push($result[$key],$cities);
		// 		}
		// 	}

		// 	return $result;
		//  }
		public function pdteamlist(){
		 
			$result = $this->db->get(PDTEAM)->result_array();
		
			if(count($result) !=0){
				foreach($result as $key=> $r){
					
					$cities = $this->db->get_where(PDTEAMCITY,array('fk_pdteam_id'=>$r['pdteam_id']))->result_array();
					array_push($result[$key],$cities);
				}
			}

			return $result;
		 }

		 /**
		 * This Function is used to Delete The Datas 
		 * argument 1 '$record_data'          = Which is get from Controller,Its Have Deleted datas
		 * argument 2 '$table_name'           = Which table have to delete
		 * argument 3 '$where_condition_array'= Delete the Datas Based on condition
		 * argument 4 '$print_query'          = To Display The Queries
		 */
		 public function deleteRecords($record_data = array(),$table_name,$where_condition_array = array(),$print_query = '')
		{		
				$data =  $this->db->delete($table_name,$record_data,$where_condition_array);

				if($print_query == 1)
				{
					print_r($this->db->last_query());
				}

				return $data;
		}


}