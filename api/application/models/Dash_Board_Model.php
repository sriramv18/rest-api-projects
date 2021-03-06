<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class Dash_Board_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
			$this->load->library('AWS_S3');
        }
		
	
		// public function getDetailsOfPDTypeAndPDStatusWithDayWeekMonth()
		// {
		// 		$sql_query_current_day = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count FROM t_pd_triggered  where date_format(createdon,'%Y-%m-%d') = date_format(CURDATE(),'%Y-%m-%d') group by fk_pd_type,pd_status;";
		// 		$result_data['current_day'] = $this->db->query($sql_query_current_day)->result_array();
				
		// 		$sql_query_current_week = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count,WEEK(createdon),WEEK(CURDATE()) FROM t_pd_triggered  where WEEK(createdon) = WEEK(CURDATE()) group by fk_pd_type,pd_status;";
		// 		$result_data['current_week'] = $this->db->query($sql_query_current_week)->result_array();
				
		// 		$sql_query_current_month = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count FROM t_pd_triggered  where MONTH(createdon) = MONTH(CURDATE()) group by fk_pd_type,pd_status;";
		// 		$result_data['current_month'] = $this->db->query($sql_query_current_month)->result_array();
		// 		return $result_data;
		// }

		public function getDetailsOfPDType($fdate,$tdate,$cityarr,$lenderarr)
		{
			if(($lenderarr != "" || $lenderarr != null)&& ($cityarr != "" || $cityarr != null) && ($fdate && $tdate != '')){
				$sql_query = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count FROM t_pd_triggered  where MONTH(createdon) = MONTH(CURDATE()) group by fk_pd_type,pd_status;";
			}
			else{
				$sql_query = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count FROM t_pd_triggered where ";
				
					if($lenderarr != "")
					{
						$lenderarr = implode(",",$lenderarr);
						$sql_query.="fk_lender_id IN (".$lenderarr.") and ";
						
					}
					if($cityarr != "" || $cityarr != null)
					{
						$cityarr = implode(",",$cityarr);
						$sql_query.="fk_city IN (".$cityarr.") and ";
						
					}
					if($fdate != ""){
						
						$from= date("Y-m-d",strtotime($fdate));
						$to=date("Y-m-d",strtotime($tdate));
						$sql_query.="date(t_pd_triggered.createdon) >= '".$from."'
										and date(t_pd_triggered.createdon) <= '".$to."' and ";
						
					}

					$sql_query.= " 1 = 1 group by fk_pd_type,pd_status ;";	
			}
			
			$result_data['current_month'] = $this->db->query($sql_query)->result_array();
			return $result_data;
		}

		public function getDetailsOfLenderAndCitywise()
		{
				$sql_query_current_day = "SELECT pd.fk_lender_id,entity.full_name,pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd 
				JOIN m_entity as entity on pd.fk_lender_id = entity.entity_id
				JOIN m_city as city on pd.fk_city = city.city_id
				where date_format(pd.createdon,'%Y-%m-%d') = date_format(CURDATE(),'%Y-%m-%d') 
				group by pd.fk_lender_id,pd.fk_city,pd.fk_pd_type,pd.pd_status;";
				$result_data['current_day'] = $this->db->query($sql_query_current_day)->result_array();
				$result_data['current_day'] =  $this->groupData($result_data['current_day']);
				
				$sql_query_current_week = "SELECT pd.fk_lender_id,entity.full_name,pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd 
				JOIN m_entity as entity on pd.fk_lender_id = entity.entity_id
				JOIN m_city as city on pd.fk_city = city.city_id
				where WEEK(pd.createdon) = WEEK(CURDATE()) 
				group by pd.fk_lender_id,pd.fk_city,pd.fk_pd_type,pd.pd_status;";
				$result_data['current_week'] = $this->db->query($sql_query_current_week)->result_array();
				$result_data['current_week'] =  $this->groupData($result_data['current_week']);
				
				$sql_query_current_month = "SELECT pd.fk_lender_id,entity.full_name,pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd 
				JOIN m_entity as entity on pd.fk_lender_id = entity.entity_id
				JOIN m_city as city on pd.fk_city = city.city_id
				where MONTH(pd.createdon) = MONTH(CURDATE()) 
				group by pd.fk_lender_id,pd.fk_city,pd.fk_pd_type;";
				$result_data['current_month'] = $this->db->query($sql_query_current_month)->result_array();
				$result_data['current_month'] =  $this->groupData($result_data['current_month']);
				   
				return $result_data;
		}
		
		
		public function getDashBoardDetailsOfCitywise()
		{
			
				$sql_query_current_day = "SELECT pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd
				JOIN m_city as city on pd.fk_city = city.city_id
				where date_format(pd.createdon,'%Y-%m-%d') = date_format('31-10-2018','%Y-%m-%d') 
				group by pd.fk_city,pd.fk_pd_type;";
				
				$result_data['current_day'] = $this->db->query($sql_query_current_day)->result_array();
				$result_data['current_day'] = $this->groupgDashBoardDetailsOfCitywiseData($result_data['current_day']);
				
				
				$sql_query_current_week = "SELECT pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd
				JOIN m_city as city on pd.fk_city = city.city_id
				where WEEK(pd.createdon) = WEEK(CURDATE()) 
				group by pd.fk_city,pd.fk_pd_type;";
				$result_data['current_week'] = $this->db->query($sql_query_current_week)->result_array();
				$result_data['current_week'] = $this->groupgDashBoardDetailsOfCitywiseData($result_data['current_week']);
				
				$sql_query_current_month = "SELECT pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd
				JOIN m_city as city on pd.fk_city = city.city_id
				where MONTH(pd.createdon) = MONTH(CURDATE()) 
				group by pd.fk_city,pd.fk_pd_type;";
				$result_data['current_month'] = $this->db->query($sql_query_current_month)->result_array();
				$result_data['current_month'] = $this->groupgDashBoardDetailsOfCitywiseData($result_data['current_month']);

				
				return $result_data;
		}

		public function getDashBoardDetailsOfAlert(){

			$this->db->select('PDTRIGGER.lender_applicant_id,
							   PDTRIGGER.pd_status,
							   PDTRIGGER.fk_lender_id,
							   PDTRIGGER.pd_id,
							   ENTITY.full_name as entity_name,
							   COAPPLICANTSDETAILS.applicant_name as applicant_name');
			$this->db->from('t_pd_triggered PDTRIGGER');
			$this->db->join('m_entity ENTITY', 'PDTRIGGER.fk_lender_id = ENTITY.entity_id','left');
			$this->db->join('t_pd_co_applicants_details COAPPLICANTSDETAILS', 'PDTRIGGER.pd_id = COAPPLICANTSDETAILS.fk_pd_id and COAPPLICANTSDETAILS.applicant_type = 1','left');
			$this->db->where('PDTRIGGER.pd_status = "TRIGGERED"');
			$this->db->or_where('PDTRIGGER.pd_status = "ALLOCATED"');

			$query = $this->db->get();
			
			return $query->result();
	    }
		
		//for Internal purpose
		public function groupData($arrayOfData)
		{
					
			        $pre_lender = "";
					$pre_city = "";
					$string = "";
					$array  = array();
					$fkey = "";
				foreach($arrayOfData as $key => $d)
				{
					//print_r($d);
					
					if($d['fk_lender_id'] != $pre_lender || $d['fk_city'] != $pre_city)
					{
						//echo "New";
					  	$array[$key] = array('lender'=>$d['full_name'],'city'=>$d['city_name'],$d['PDTYPE'] => $d['count']);
						$pre_lender = $d['fk_lender_id'];
					   $pre_city = $d['fk_city'];
						$fkey = $key;
					}
					else
					{
						//echo "OLd";
						$array[$fkey] = array_merge($array[$fkey],array($d['PDTYPE'] => $d['count']));
						$pre_lender = $d['fk_lender_id'];
					   $pre_city = $d['fk_city'];
					}
				}
				return $array;
		}
		
		//for Internal purpose
		public function groupgDashBoardDetailsOfCitywiseData($arrayOfData)
		{
					
			       
					$pre_city = "";
					$array  = array();
					$fkey = "";
				foreach($arrayOfData as $key => $d)
				{
					//print_r($d);
					
					if($d['fk_city'] != $pre_city)
					{
						//echo "New";
					  	$array[$key] = array('city_name'=>$d['city_name'],$d['PDTYPE'] => $d['count']);
					     $pre_city = $d['fk_city'];
						$fkey = $key;
					}
					else
					{
						//echo "OLd";
						$array[$fkey] = array_merge($array[$fkey],array($d['PDTYPE'] => $d['count']));
						
					   $pre_city = $d['fk_city'];
					}
				}
				return $array;
		}
		
			
}