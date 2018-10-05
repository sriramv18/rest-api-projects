<?php

class PDALERTS
{
	

	
	/*
	This function plays role of sending sms/email while PD status changing.
	@param pdid
	get current status, lender, created by, allocated_to by using pdid.
	then get pd notification config's using current pd status.
	based on that pd config's send sms/email to endpoints
	
	*/
	public static function pdnotification($pdid)
	{
		if($pdid != "" || $pdid != null)
		{
			
			$CI =&get_instance();
			$CI->load->library('AWS_SNS'); 
			$pd_notification_configs = array();
			$mobile_nos_to_send_notification = array();
			$email_ids_to_send_notification = array();
			
			//echo "FROM HELPER-PD_ID -" . $pdid;
			
			/*
			* 
			* SMS FUNCTIONALITY
			*/
			
			//1.Get Current Status and createdby , lenders info by pdid
			$CI->db->SELECT("PDTRIGGER.fk_lender_id,PDTRIGGER.lender_applicant_id,PDTRIGGER.fk_pd_status,PDSTATUS.pd_status_name,PDTRIGGER.fk_createdby,USERPROFILE.fk_entity_id as created_entity_type,USERPROFILE.email as created_mail,USERPROFILE.mobile_no as created_mobile_no,PDTRIGGER.fk_pd_allocated_to,ALLOCATED.email as allocated_email,ALLOCATED.mobile_no as allocated_mobile_no,ALLOCATED.fk_entity_id as allocated_entity_type,PDTRIGGER.pd_agency_id");
			$CI->db->FROM(PDTRIGGER." as PDTRIGGER");
			$CI->db->JOIN(USERPROFILE." as USERPROFILE","PDTRIGGER.fk_createdby = USERPROFILE.userid");
			$CI->db->JOIN(USERPROFILE." as ALLOCATED","PDTRIGGER.fk_pd_allocated_to = ALLOCATED.userid");
			$CI->db->JOIN(PDSTATUS." as PDSTATUS","PDTRIGGER.fk_pd_status = PDSTATUS.pd_status_id");
			$CI->db->WHERE("PDTRIGGER.pd_id",$pdid);
			$core_details = $CI->db->GET()->result_array();
			
			if(count($core_details))
			{
			
				//2.Get Notification Configuration by using pd staus idate
				
				
				$CI->db->SELECT("PDNOTIFICATION.pdnotification_id, PDNOTIFICATION.fk_pd_status_id, PDSTATUS.pd_status_name,PDNOTIFICATION.sms_lender, PDNOTIFICATION.sms_pdofficer, PDNOTIFICATION.sms_pdincharge, PDNOTIFICATION.mail_lender, PDNOTIFICATION.mail_pdincharge, PDNOTIFICATION.mail_pdofficer");
				$CI->db->FROM(PDNOTIFICATION." as PDNOTIFICATION");
				$CI->db->JOIN(PDSTATUS." as PDSTATUS","PDNOTIFICATION.fk_pd_status_id = PDSTATUS.pd_status_id AND PDSTATUS.isactive = 1");
				$CI->db->WHERE("PDNOTIFICATION.fk_pd_status_id = $pdstatus");
				$pd_notification_configs = $CI->db->GET()->result_array();
				//print_r($pd_notification_configs);
				
				//pd cretaed entity type is 2 then sent sms only for that mobile no
				if($core_details['created_entity_type'] == 2) // 2 - Lender Type
				{
					if($pd_notification_configs['sms_lender'] == 1)
					{
						array_push($mobile_nos_to_send_notification,$core_details['created_mobile_no']);
					}
				}					
				else //sent sms to all lender contacts associated to lender id
				{
					if($pd_notification_configs['sms_lender'] == 1)
					{
						
						$CI->db->SELECT("contact_mobile_no");
						$CI->db->FROM(ENTITYCHILD);
						$CI->db->WHERE("fk_entity_id",$core_details['fk_lender_id']);
						$lender_mobile_nos = $CI->db->GET()->result_array();
						if(count($lender_mobile_nos))
						{
							foreach($lender_mobile_nos as $mobile)
							{
								array_push($mobile_nos_to_send_notification,$mobile);
							}
						}
					}
				}
				
				//add pd officer no
				if($pd_notification_configs['sms_pdofficer'] == 1)
				{
					array_push($mobile_nos_to_send_notification,$core_details['allocated_mobile_no']);
				}
				
				//add pd incharge mobile_no's
				if($pd_notification_configs['sms_pdincharge'] == 1)
				{
						$CI->db->DISTINCT();
						$CI->db->SELECT("mobile_no");
						$CI->db->FROM(USERPROFILE." as USERPROFILE");
						$CI->db->JOIN(USERPROFILEROLES." as USERPROFILEROLES","USERPROFILE.userid = USERPROFILEROLES.fk_userid AND USERPROFILEROLES.isactive = 1");
						$CI->db->WHERE("USERPROFILEROLES.user_role",'PDINCHAGRE');
						$inchagre_mobile_nos = $CI->db->GET()->result_array();
						if(count($inchagre_mobile_nos))
						{
							foreach($inchagre_mobile_nos as $mobile)
							{
								array_push($mobile_nos_to_send_notification,$mobile);
							}
						}
				}
				
				$msg = "PD for Lender Applicant ID:".$core_details['lender_applicant_id']."has been".$$core_details['pd_status_name']; // status base configurable
				foreach($mobile_nos_to_send_notification as $no)
				{
					
					$CI->aws_s3->sendSMS($msg,$no);
				}
				
				
				/*
				* **********************************************************************************************************
				* EMAIL FUNCTIONALITY
				************************************************************************************************************
				*/
				
				
				// if(count($core_details))
			// {
							
				// //pd cretaed entity type is 2 then sent mail only for that email
				// if($core_details['created_entity_type'] == 2) // 2 - Lender Type
				// {
					// if($pd_notification_configs['mail_lender'] == 1)
					// {
						// array_push($email_ids_to_send_notification,$core_details['created_mail']);
					// }
				// }					
				// else //sent email to all lender contacts associated to lender id
				// {
					// if($pd_notification_configs['mail_lender'] == 1)
					// {
						
						// $CI->db->SELECT("contact_email");
						// $CI->db->FROM(ENTITYCHILD);
						// $CI->db->WHERE("fk_entity_id",$core_details['fk_lender_id']);
						// $lender_emails = $CI->db->GET()->result_array();
						// if(count($lender_mobile_nos))
						// {
							// foreach($lender_emails as $lender_email)
							// {
								// array_push($email_ids_to_send_notification,$lender_email);
							// }
						// }
					// }
				// }
				
				// //add pd officer email
				// if($pd_notification_configs['mail_pdofficer'] == 1)
				// {
					// array_push($email_ids_to_send_notification,$core_details['allocated_email']);
				// }
				
				// //add pd incharge emails
				// if($pd_notification_configs['mail_pdincharge'] == 1)
				// {
						// $CI->db->DISTINCT();
						// $CI->db->SELECT("email");
						// $CI->db->FROM(USERPROFILE." as USERPROFILE");
						// $CI->db->JOIN(USERPROFILEROLES." as USERPROFILEROLES","USERPROFILE.userid = USERPROFILEROLES.fk_userid AND USERPROFILEROLES.isactive = 1");
						// $CI->db->WHERE("USERPROFILEROLES.user_role",'PDINCHAGRE');
						// $inchagre_email = $CI->db->GET()->result_array();
						// if(count($inchagre_email))
						// {
							// foreach($inchagre_email as $email)
							// {
								// array_push($email_ids_to_send_notification,$email);
							// }
						// }
				// }
				
				// //$msg = "PD for Lender Applicant ID:".$core_details['lender_applicant_id']."has been".$core_details['pd_status_name']; // status base configurable
				// foreach($email_ids_to_send_notification as $email)
				// {
					
					// //email SES	 have to config
					// //$CI->aws_ses->sendMail($email);
				// }
				
			
			// }
			
			/*End of Email Functionality*/
		}
		
		
	}
	
	}
	
	
	

}

?>