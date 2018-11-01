<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/SPARQ_Model.php';
class Dash_Board_Model extends SPARQ_Model {

		public function __construct() {
            parent::__construct();
			$this->load->library('AWS_S3');
        }
		
	
		public function getDetailsOfPDTypeAndPDStatusWithDayWeekMonth()
		{
				$sql_query_current_day = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count FROM t_pd_triggered  where date_format(createdon,'%Y-%m-%d') = date_format(CURDATE(),'%Y-%m-%d') group by fk_pd_type,pd_status;";
				$result_data['current_day'] = $this->db->query($sql_query_current_day)->result_array();
				
				$sql_query_current_week = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count,WEEK(createdon),WEEK(CURDATE()) FROM t_pd_triggered  where WEEK(createdon) = WEEK(CURDATE()) group by fk_pd_type,pd_status;";
				$result_data['current_week'] = $this->db->query($sql_query_current_week)->result_array();
				
				$sql_query_current_month = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count FROM t_pd_triggered  where MONTH(createdon) = MONTH(CURDATE()) group by fk_pd_type,pd_status;";
				$result_data['current_month'] = $this->db->query($sql_query_current_month)->result_array();
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
				
				$sql_query_current_week = "SELECT pd.fk_lender_id,entity.full_name,pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd 
				JOIN m_entity as entity on pd.fk_lender_id = entity.entity_id
				JOIN m_city as city on pd.fk_city = city.city_id
				where WEEK(pd.createdon) = WEEK(CURDATE()) 
				group by pd.fk_lender_id,pd.fk_city,pd.fk_pd_type,pd.pd_status;";
				$result_data['current_week'] = $this->db->query($sql_query_current_week)->result_array();
				
				$sql_query_current_month = "SELECT pd.fk_lender_id,entity.full_name,pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd 
				JOIN m_entity as entity on pd.fk_lender_id = entity.entity_id
				JOIN m_city as city on pd.fk_city = city.city_id
				where MONTH(pd.createdon) = MONTH(CURDATE()) 
				group by pd.fk_lender_id,pd.fk_city,pd.fk_pd_type,pd.pd_status;";
				$result_data['current_month'] = $this->db->query($sql_query_current_month)->result_array();
				return $result_data;
		}
		
		
		public function getDashBoardDetailsOfCitywise()
		{
				$sql_query_current_day = "SELECT pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd
				JOIN m_city as city on pd.fk_city = city.city_id
				where date_format(pd.createdon,'%Y-%m-%d') = date_format('31-10-2018','%Y-%m-%d') 
				group by pd.fk_city,pd.fk_pd_type,pd.pd_status;";
				
				$result_data['current_day'] = $this->db->query($sql_query_current_day)->result_array();
				
				$sql_query_current_week = "SELECT pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd
				JOIN m_city as city on pd.fk_city = city.city_id
				where WEEK(pd.createdon) = WEEK(CURDATE()) 
				group by pd.fk_city,pd.fk_pd_type,pd.pd_status;";
				$result_data['current_week'] = $this->db->query($sql_query_current_week)->result_array();
				
				$sql_query_current_month = "SELECT pd.fk_city,city.name as city_name,if(pd.fk_pd_type = 1,'FULL',if(pd.fk_pd_type = 2,'SMART',if(pd.fk_pd_type = 3,'TELE','OTHERS'))) as PDTYPE,pd.pd_status,count(*) as count FROM t_pd_triggered as pd
				JOIN m_city as city on pd.fk_city = city.city_id
				where MONTH(pd.createdon) = MONTH(CURDATE()) 
				group by pd.fk_city,pd.fk_pd_type,pd.pd_status;";
				$result_data['current_month'] = $this->db->query($sql_query_current_month)->result_array();
				return $result_data;
		}
		
			
}