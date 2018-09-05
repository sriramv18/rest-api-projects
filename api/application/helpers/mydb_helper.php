<?php

class MYDB
{
	

	
	
	public static function saveRecords($record_data = array(),$table_name,$print_query = '')
	{
		$CI =&get_instance();
		$CI->db->insert($table_name,$record_data);
		if($print_query == 1)
		{
			print_r($CI->db->last_query());
		}
		return $CI->db->insert_id();
		//print_r($CI->db);
	}
	
	public static function selectRecords($where_condition_array = array(),$table_name,$print_query = '')
	{
		$CI =&get_instance();
		$data =  $CI->db->get_where($table_name,$where_condition_array)->result_array();//only AND condition
		if($print_query == 1)
		{
			print_r($CI->db->last_query());
		}
		return $data;
	}
	
	public static function updateRecords($record_data = array(),$table_name,$where_condition_array = array(),$print_query = '')
	{
		$CI =&get_instance();
		$data =  $CI->db->update($table_name,$record_data,$where_condition_array)->result_array();
		if($print_query == 1)
		{
			print_r($CI->db->last_query());
		}
		return $data;
	}
	
	public static function selectCustomRecords($fields = '', $where = array(), $or_where_total = array(),$table = '', $limit = '', $order_by_colum_name = '', $order_by = 'ASC', $group_by = '',$print_query = '') {
		
		$CI =&get_instance();
		
        //$data = array();
        if ($fields != '') {
            $CI->db->select($fields);
        }

        if (count($where)) {
            $CI->db->where($where);
        }
		
		if (count($or_where_total)) {
            
			foreach($or_where_total as $or_where)
			{
				$CI->db->or_where($or_where);
			}
        }

        if ($table != '') {
           $CI->table_name = $table;
        }

        if ($limit != '') {
            $CI->db->limit($limit);
        }

        if ($order_by_colum_name != '') {
            $CI->db->order_by($order_by_colum_name,$order_by);
        }

        if ($group_by != '') {
            $CI->db->group_by($group_by);
        }
		
		
         $data = $CI->db->get($CI->table_name)->result_array();
		
		if ($print_query == '1') {
			print_r($CI->db->last_query());
		 }
		 return $data;
        
      
    }
	
	public static function getJoinRecords($columns,$table,$joins,$print_query = '')
		{
			$CI =&get_instance();
			
			$CI->db->select($columns)->from($table);
			if (is_array($joins) && count($joins) > 0)
			{
				foreach($joins as $k => $join)
				{
					$CI->db->join($join['table'], $join['condition'], $join['jointype']);
				}
			}
			
			
			$data  = $CI->db->get()->result_array();
			
			if ($print_query != '') {
				print_r($CI->db->last_query());
			}
			
			return $data;
		}
	

}

?>