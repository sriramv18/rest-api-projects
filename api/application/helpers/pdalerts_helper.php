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
		//echo "called";
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
			$CI->db->SELECT("PDTRIGGER.fk_lender_id,PDTRIGGER.lender_applicant_id,PDTRIGGER.pd_status,PDTRIGGER.fk_createdby,CREATED.email as created_mail,CREATED.mobile_no as created_mobile_no,PDTRIGGER.fk_pd_allocated_to,ALLOCATED.email as allocated_email,ALLOCATED.mobile_no as allocated_mobile_no,PDTRIGGER.executive_id,EXECUTIVE.email as executive_email,EXECUTIVE.mobile_no as executive_mobile_no,PDTRIGGER.central_pd_officer_id,CENTRALPDOFFICER.mobile_no as centralpdofficer_mobile_no,CENTRALPDOFFICER.email as centralpdofficer_mail,PDTRIGGER.pd_agency_id,PDTRIGGER.pd_contact_person,PDTRIGGER.pd_contact_mobileno");
			$CI->db->FROM(PDTRIGGER." as PDTRIGGER");
			$CI->db->JOIN(USERPROFILE." as CREATED","PDTRIGGER.fk_createdby = CREATED.userid",'LEFT');
			$CI->db->JOIN(USERPROFILE." as ALLOCATED","PDTRIGGER.fk_pd_allocated_to = ALLOCATED.userid",'LEFT');
			$CI->db->JOIN(USERPROFILE." as EXECUTIVE","PDTRIGGER.executive_id = EXECUTIVE.userid",'LEFT');
			$CI->db->JOIN(USERPROFILE." as CENTRALPDOFFICER","PDTRIGGER.central_pd_officer_id = CENTRALPDOFFICER.userid",'LEFT');
			$CI->db->WHERE("PDTRIGGER.pd_id",$pdid);
			$core_details = $CI->db->GET()->result_array();
			//print_r($core_details);
			
			
			
			if(count($core_details))
			{
			
				//2.Get Notification Configuration by using pd staus idate
				
				
				$CI->db->SELECT("PDNOTIFICATION.pd_status,PDNOTIFICATION.sms_lender, PDNOTIFICATION.sms_pdofficer, PDNOTIFICATION.sms_pdincharge, PDNOTIFICATION.mail_lender, PDNOTIFICATION.mail_pdincharge, PDNOTIFICATION.mail_pdofficer");
				$CI->db->FROM(PDNOTIFICATION." as PDNOTIFICATION");
				$CI->db->WHERE("PDNOTIFICATION.pd_status",$core_details[0]['pd_status']);
				$CI->db->WHERE("PDNOTIFICATION.isactive",1);
				$pd_notification_configs = $CI->db->GET()->result_array();
				//print_r($CI->db->last_query());
				//print_r($pd_notification_configs);
				
					if(count($pd_notification_configs))
					{
				 //sent sms to  lender contacts 
				
					if($pd_notification_configs[0]['sms_lender'] == 1)
					{
						array_push($mobile_nos_to_send_notification,$core_details[0]['pd_contact_mobileno']);
					}
				
				
				//add pd officer no
				if($pd_notification_configs[0]['sms_pdofficer'] == 1)
				{
					array_push($mobile_nos_to_send_notification,$core_details[0]['allocated_mobile_no']);
					
					if($core_details[0]['executive_mobile_no'] != "" || $core_details[0]['executive_mobile_no'] != null)
					{
						array_push($mobile_nos_to_send_notification,$core_details[0]['executive_mobile_no']);
					}
					if($core_details[0]['centralpdofficer_mobile_no'] != "" || $core_details[0]['centralpdofficer_mobile_no'] != null)
					{
						array_push($mobile_nos_to_send_notification,$core_details[0]['centralpdofficer_mobile_no']);
					}
				}
				
				//add pd incharge mobile_no's
				if($pd_notification_configs[0]['sms_pdincharge'] == 1)
				{
						$CI->db->DISTINCT();
						$CI->db->SELECT("mobile_no");
						$CI->db->FROM(USERPROFILE." as USERPROFILE");
						$CI->db->JOIN(USERPROFILEROLES." as USERPROFILEROLES","USERPROFILE.userid = USERPROFILEROLES.fk_userid AND USERPROFILEROLES.isactive = 1 AND USERPROFILE.isactive = 1");
						$CI->db->WHERE("USERPROFILEROLES.user_role",3);
						$inchagre_mobile_nos = $CI->db->GET()->result_array();
						if(count($inchagre_mobile_nos))
						{
							foreach($inchagre_mobile_nos as $mobile)
							{
								array_push($mobile_nos_to_send_notification,$mobile);
							}
						}
				}
				
			}
				$msg = "PD for Lender Applicant ID -:". $core_details[0]['lender_applicant_id'] ."  has been  ". $core_details[0]['pd_status']; // status base configurable
				//print_r($mobile_nos_to_send_notification);
				foreach($mobile_nos_to_send_notification as $no)
				{
					
					
					$no = (string)$no;
					//echo "SNSNO-".$no;
					$CI->aws_sns->sendSMS($msg,$no);
				}
				
			}
				/*
				* **********************************************************************************************************
				* EMAIL FUNCTIONALITY
				************************************************************************************************************
				*/
				
				
				if(count($core_details))
			{
							
				
				if(count($pd_notification_configs))
				{
				//add pd officer email
				if($pd_notification_configs[0]['mail_pdofficer'] == 1)
				{
					array_push($email_ids_to_send_notification,$core_details[0]['allocated_email']);
					if($core_details[0]['executive_email'] != "" || $core_details[0]['executive_email'] != null)
					{
						array_push($email_ids_to_send_notification,$core_details[0]['executive_email']);
					}
					if($core_details[0]['centralpdofficer_mail'] != "" || $core_details[0]['centralpdofficer_mail'] != null)
					{
						array_push($email_ids_to_send_notification,$core_details[0]['centralpdofficer_mail']);
					}
				}
				
				
					
				//add pd incharge emails
				if($pd_notification_configs[0]['mail_pdincharge'] == 1)
				{
						$CI->db->DISTINCT();
						$CI->db->SELECT("email");
						$CI->db->FROM(USERPROFILE." as USERPROFILE");
						$CI->db->JOIN(USERPROFILEROLES." as USERPROFILEROLES","USERPROFILE.userid = USERPROFILEROLES.fk_userid AND USERPROFILEROLES.isactive = 1 AND USERPROFILE.isactive = 1");
						$CI->db->WHERE("USERPROFILEROLES.user_role",3);
						$inchagre_email = $CI->db->GET()->result_array();
						if(count($inchagre_email))
						{
							foreach($inchagre_email as $email)
							{
								array_push($email_ids_to_send_notification,$email);
							}
						}
				}
				
				//$msg = "PD for Lender Applicant ID:".$core_details['lender_applicant_id']."has been".$core_details['pd_status_name']; // status base configurable
				foreach($email_ids_to_send_notification as $email)
				{
					
					//email SES	 have to config
					//$CI->aws_ses->sendMail($email);
				}
				
			}
			}
			
			/*End of Email Functionality*/
		}
		
		
	}
	
	}
	
	
	



?>