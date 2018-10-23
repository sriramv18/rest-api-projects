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
		 * This Function is used to inserting new Data 
		 * argument 1 '$city'    = Which is get from Controller (cityid),
		 * argument 2 '$teamid'  = Which is get From COntroller (teamid), 
		 */
		 public function checkCityData($city,$teamid)
		 {
			$this->db->select('PDTEAMCITY.fk_city_id');
			$this->db->where('PDTEAMCITY.fk_pdteam_id',$teamid);
			$this->db->where('PDTEAMCITY.fk_city_id',$city);
			$result = $this->db->get(PDTEAMCITY.' as PDTEAMCITY')->result();
			if(!empty($result)){}
			else
			{
				$this->db->insert(PDTEAMCITY, array('fk_city_id'=>$city,'fk_pdteam_id'=>$teamid));		
			}
		}

		/**
		 * This Function is used to inserting new Data 
		 * argument 1 '$product'    = Which is get from Controller (productid),
		 * argument 2 '$teamid'  = Which is get From COntroller (teamid), 
		 */
		public function checkProductData($product,$teamid)
		 {
			$this->db->select('PDTEAMPRODUCT.fk_product_id');
			$this->db->where('PDTEAMPRODUCT.fk_pdteam_id',$teamid);
			$this->db->where('PDTEAMPRODUCT.fk_product_id',$product);
			$this->db->where('PDTEAMPRODUCT.isactive',1);
			$result = $this->db->get(PDTEAMPRODUCT.' as PDTEAMPRODUCT')->result();
			if(!empty($result)){}
			else
			{
				$this->db->insert(PDTEAMPRODUCT, array('fk_product_id'=>$product,'fk_pdteam_id'=>$teamid));		
			}
		}

		/**
		 * This Function is used to inserting new Data 
		 * argument 1 '$cs'    = Which is get from Controller (Customersegmentid),
		 * argument 2 '$teamid'  = Which is get From COntroller (teamid), 
		 */
		public function checkCustomerSegmentData($cs,$teamid)
		 {
			$this->db->select('PDTEAMCUSTOMERSEGMENT.fk_cs_id');
			$this->db->where('PDTEAMCUSTOMERSEGMENT.fk_pdteam_id',$teamid);
			$this->db->where('PDTEAMCUSTOMERSEGMENT.fk_cs_id',$cs);
			$this->db->where('PDTEAMCUSTOMERSEGMENT.isactive',1);
			$result = $this->db->get(PDTEAMCUSTOMERSEGMENT.' as PDTEAMCUSTOMERSEGMENT')->result();
			if(!empty($result))
			{}
			else
			{
				$this->db->insert(PDTEAMCUSTOMERSEGMENT, array('fk_cs_id'=>$cs,'fk_pdteam_id'=>$teamid));	
			}
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