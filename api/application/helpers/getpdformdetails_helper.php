<?php

class GETPDFORMDETAILS
{
	

	
	/*
	This function transform Pd Form Details as key value pairs
	@param result_array which is passed from comtroller,
	@param pd_id
	@param pd_form_id
	*/
	public static function getPDFormDetailsStructured($result_array = array(),$pd_id,$pd_form_id)
	{
		$final_data = array();
			
			
			$overall = array();
			$pre_group = "";
			$pre_sub_group = "";
			$pre_iter = "";
			$pre_sub_iter = "";
			$t1 = array();
			$t2 = array();
			$group = array();	
			$sub_group = array();	
			
			/////For handling Rendal form Sub array//////
			$pre_column_name = "name";
			$z = 0;
			$y = 0;
			/////For handling Rendal form Sub array//////
			
			
			/////For handling Asset form Commom Remark Filed//////
			
			$asset_remark = array();
			/////For handling Asset form Commom Remark Filed//////
			
			
			foreach($result_array as $rkey => $result)
			{
			  
			  if($result['iteration'] != "" || $result['iteration'] != null)
			  {
				  if($result['iter_sub_column_name'] == "" || $result['iter_sub_column_name'] == null)
				  {  
					  if($result['iter_column_name'] != $pre_group)// && $result['iteration'] != $pre_iter)
					  {
						
							$t1 = array();
							$group = array();
						   $t1 = array_merge($t1,array($result['column_name']=>$result['column_value']));
						   $group[$result['iter_column_name']][$result['iteration']] = $t1;
						   $pre_group = $result['iter_column_name'];
						   $pre_iter = $result['iteration'];
					  }
					  else
					  {
							 $t1 = array_merge($t1,array($result['column_name']=>$result['column_value']));
							 $group[$result['iter_column_name']][$result['iteration']] = $t1;
							  $pre_group = $result['iter_column_name'];
							  $pre_iter = $result['iteration'];
					   }
				}
				else// Handle child group
				{
					if($pd_form_id != 17)
					{
						if($result['iter_sub_column_name'] != $pre_sub_group || $result['iteration'] != $pre_sub_iter)
						  {
							
								$t2 = array();
							   $t2 = array_merge($t2,array($result['column_name']=>$result['column_value']));
							   $sub_group[$result['iter_sub_column_name']][$result['iteration']] = $t2;
							   $pre_sub_group = $result['iter_sub_column_name'];
							   $pre_sub_iter = $result['iteration'];
						  }
						  else
						  {
							 
							 	 $t2 = array_merge($t2,array($result['column_name']=>$result['column_value']));
								 $sub_group[$result['iter_sub_column_name']][$result['iteration']] = $t2;
								  $pre_sub_group = $result['iter_sub_column_name'];
								  $pre_sub_iter = $result['iteration'];
						   }
					}
					else// handle Rental form Sub group
					{
						if($result['column_name'] == $pre_column_name)
						  {
							  $t2 = array();
							  $z++;
							  $y++;
							  $t2 = array_merge($t2,array($result['column_name']=>$result['column_value']));
							  $sub_group[$result['iter_sub_column_name']][$result['iteration']][$z] = $t2;
							  
						  }
						  else
						  {
								 $t2 = array_merge($t2,array($result['column_name']=>$result['column_value']));
								 $sub_group[$result['iter_sub_column_name']][$result['iteration']][$z] = $t2;
								
						  }
					}						
					   
				}
			  }
			  else// handle single key value
			  {
				  
					if($pd_form_id != 4)
					{  
						$t = array($result['column_name']=>$result['column_value']);
						$final_data = array_merge($final_data,$t);
					}
					else // asset form details commom remark field
					{
						$asset_remark = array($result['column_name']=>$result['column_value']);
					}
			  }
			  
			  
			  
			  $final_data = array_merge($final_data,$group);
			}
			
			
			// Merge subgroup into main group for all forms except rendtal form (id = 17)
			$i = 0;
			if(count($sub_group) && $pd_form_id != 17)
			{
				
				foreach($sub_group as $key => $value)
				{

					foreach($value as $vkey =>$final_value)
					{
						
						$temp_array = array($key=>$final_value);
						
						foreach($final_data as $fkey => $fdata)
						{
							
							$i++;
							
							if($i == $vkey)
							{
								
								$final_data[$fkey][$vkey] = array_merge($final_data[$fkey][$vkey],$temp_array);
								
							}
							
						}
						
					}
				}
				
			}
			
			if($pd_form_id == 4)// to merge assest form commom remarks at end of final data.
			{
				$final_data = array_merge($final_data,$asset_remark);
			}
			
			if($pd_form_id == 17)//merge subgroup of rental verification form with parent group, diff scenario not like other forms  
			{
				if(array_key_exists('rental_home',$final_data))
				{
					
					for($i = 1;$i<=count($final_data['rental_home']);$i++)
					{
						$final_data['rental_home'][$i]['details_tenants'] = $sub_group['details_tenants'][$i];
						
					}
				}
			}
			$result_array = $final_data;
			return $result_array;
	}
	
	
}



?>