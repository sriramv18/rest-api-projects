<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class SPARQ_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

        $this->load->database();

	}
	
	public  function saveRecords($record_data = array(),$table_name,$print_query = '')
	{
		
		$this->db->insert($table_name,$record_data);
		if($print_query == 1)
		{
			print_r($this->db->last_query());
		}
		return $this->db->insert_id();
		//print_r($this->db);
	}
	
	public  function selectRecords($where_condition_array = array(),$table_name,$print_query = '')
	{
		
		$data =  $this->db->get_where($table_name,$where_condition_array)->result_array();//only AND condition
		if($print_query == 1)
		{
			print_r($this->db->last_query());
		}
		return $data;
	}
	
	public  function updateRecords($record_data = array(),$table_name,$where_condition_array = array(),$print_query = '')
	{
		
		$data =  $this->db->update($table_name,$record_data,$where_condition_array)->result_array();
		if($print_query == 1)
		{
			print_r($this->db->last_query());
		}
		return $data;
	}
	
	public  function selectCustomRecords($fields = '', $where = array(), $or_where_total = array(),$table = '', $limit = '', $order_by_colum_name = '', $order_by = 'ASC', $group_by = '',$print_query = '') {
		
		
		
        //$data = array();
        if ($fields != '') {
            $this->db->select($fields);
        }

        if (count($where)) {
            $this->db->where($where);
        }
		
		if (count($or_where_total)) {
            
			foreach($or_where_total as $or_where)
			{
				$this->db->or_where($or_where);
			}
        }

        if ($table != '') {
           $this->table_name = $table;
        }

        if ($limit != '') {
            $this->db->limit($limit);
        }

        if ($order_by_colum_name != '') {
            $this->db->order_by($order_by_colum_name,$order_by);
        }

        if ($group_by != '') {
            $this->db->group_by($group_by);
        }
		
		
         $data = $this->db->get($this->table_name)->result_array();
		
		if ($print_query == '1') {
			print_r($this->db->last_query());
		 }
		 return $data;
        
      
    }
	
	public  function getJoinRecords($columns,$table,$joins,$print_query = '')
		{
			
			
			$this->db->select($columns)->from($table);
			if (is_array($joins) && count($joins) > 0)
			{
				foreach($joins as $k => $join)
				{
					$this->db->join($join['table'], $join['condition'], $join['jointype']);
				}
			}
			
			
			$data  = $this->db->get()->result_array();
			
			if ($print_query != '') {
				print_r($this->db->last_query());
			}
			
			return $data;
		}

	
}
