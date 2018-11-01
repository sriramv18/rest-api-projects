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
				$sql_query_current_day = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count FROM sine_edge_test.t_pd_triggered  where date_format(createdon,'%Y-%m-%d') = date_format(CURDATE(),'%Y-%m-%d') group by fk_pd_type,pd_status;";
				$result_data['current_day'] = $this->db->query($sql_query_current_day)->result_array();
				
				$sql_query_current_week = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count,WEEK(createdon),WEEK(CURDATE()) FROM sine_edge_test.t_pd_triggered  where WEEK(createdon) = WEEK(CURDATE()) group by fk_pd_type,pd_status;";
				$result_data['current_week'] = $this->db->query($sql_query_current_week)->result_array();
				
				$sql_query_current_month = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count FROM sine_edge_test.t_pd_triggered  where MONTH(createdon) = MONTH(CURDATE()) group by fk_pd_type,pd_status;";
				$result_data['current_month'] = $this->db->query($sql_query_current_month)->result_array();
				return $result_data;
		}
		
		public function getDetailsOfLenderAndCitywise()
		{
				$sql_query_current_day = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count FROM sine_edge_test.t_pd_triggered  where date_format(createdon,'%Y-%m-%d') = date_format(CURDATE(),'%Y-%m-%d') group by fk_pd_type,pd_status;";
				$result_data['current_day'] = $this->db->query($sql_query_current_day)->result_array();
				
				$sql_query_current_week = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count,WEEK(createdon),WEEK(CURDATE()) FROM sine_edge_test.t_pd_triggered  where WEEK(createdon) = WEEK(CURDATE()) group by fk_pd_type,pd_status;";
				$result_data['current_week'] = $this->db->query($sql_query_current_week)->result_array();
				
				$sql_query_current_month = "SELECT if(fk_pd_type = 1,'FULL',if(fk_pd_type = 2,'SMART',if(fk_pd_type = 3,'TELE','NULL'))) as PDTYPE,pd_status,count(*) as count FROM sine_edge_test.t_pd_triggered  where MONTH(createdon) = MONTH(CURDATE()) group by fk_pd_type,pd_status;";
				$result_data['current_month'] = $this->db->query($sql_query_current_month)->result_array();
				return $result_data;
		}
		
			
}