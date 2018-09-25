<?php

class PDALERTS
{
	

	
	
	public static function pdnotification($pdid,$pdstatus)
	{
		if($pdid != "" || $pdid != null || $pdstatus != "" || $pdstatus != null)
		{
			$CI =&get_instance();
			$mobile_nos_to_send_notification = array();
			$email_ids_to_send_notification = array();
			//$CI->db->insert($table_name,$record_data);
			echo "FROM HELPER-PD_ID -" . $pdid;
			//1.Get Notification Configuration by using pd staus idate
			
			//$pd_notification_configs = 
			$CI->db->SELECT("PDNOTIFICATION.pdnotification_id, PDNOTIFICATION.fk_pd_status_id, PDSTATUS.pd_status_name,PDNOTIFICATION.sms_lender, PDNOTIFICATION.sms_pdofficer, PDNOTIFICATION.sms_pdincharge, PDNOTIFICATION.mail_lender, PDNOTIFICATION.mail_pdincharge, PDNOTIFICATION.mail_pdofficer");
			$CI->db->FROM(PDNOTIFICATION." as PDNOTIFICATION");
			$CI->db->JOIN(PDSTATUS." as PDSTATUS","PDNOTIFICATION.fk_pd_status_id = PDSTATUS.pd_status_id AND PDSTATUS.isactive = 1");
			$CI->db->WHERE("PDNOTIFICATION.fk_pd_status_id = $pdstatus");
			$pd_notification_configs = $CI->db->get()->result_array();
			print_r($pd_notification_configs);
		}
		
		
	}
	
	
	
	
	

}

?>