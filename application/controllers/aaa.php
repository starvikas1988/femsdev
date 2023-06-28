<?
else if($campaign == 'romtech_inbound'){

				$header = array("Auditor Name", "Audit Date ", "Agent Name ","ACPT", "Fusion ID ", "L1 Supervisor ", "Call Date ", "Audit Type ", "Type of Auditor ","File/Call ID ", "VOC","L1 ","L2","Phone Number", "Earned Score",
					"Possible Score", "Overall Score %",
		 	        "Customer Score","Business Score","Compliance Score",
					"Greeting-Used standard ROMTech greeting message (Hello Thank you for contacting ROMTech customer service department.",
					"Greeting-Used standard ROMTech greeting message (Hello, Thank you for contacting ROMTech customer service department. - Remarks1",
					"Introduction-Did the agent mention his/her name on call and also branded the call.",
					"Introduction-Did the agent mention his/her name on call and also branded the call. - Remarks2",
					"Mandate details-Did the agent confirm the patients first & last name/Physician name/DOB",
					"Mandate details-Did the agent confirm the patients first & last name/Physician name/DOB - Remarks3",
					"Communication - Proper energy proper pacecommunication skill was reflecting on call while speaking to the customer.",
					"Communication - Proper energy proper pacecommunication skill was reflecting on call while speaking to the customer. - Remarks4",
					"Empathy- Agent shown empathy or appology when and where required. Also agent's intonation was proper on call.",
					"Empathy- Agent shown empathy or appology when and where required. Also agent's intonation was proper on call. - Remarks5",
					"Did the agent overlapped or interruped the customer while he/she was speaking?",
					"Did the agent overlapped or interruped the customer while he/she was speaking? - Remarks6",
					"Did the agent showed good listening skills on call ?",
					"Did the agent showed good listening skills on call ? - Remarks7",
					"Professionalism - Agent shown proper professionalism on call. Not being rude on call abusive call disconnection sarcasm Using jargons etc.",
					"Professionalism - Agent shown proper professionalism on call. Not being rude on call abusive call disconnection sarcasm Using jargons etc. - Remarks8",
					"Probing - Did agent probed well to understand patients query and provide right information.",
					"Probing - Did agent probed well to understand patients query and provide right information. - Remarks9",
					"Hold Verbiage - Did the agent asked permission to put the call on hold ? & after resuming agent should thank the patient.",
					"Hold Verbiage - Did the agent asked permission to put the call on hold ? & after resuming agent should thank the patient. - Remarks10",
					"Hold Refresh - Did the agent informed the patient that he/she still looking for information (if hold is more than 2 mins)- If disconnected due to long hold then it leads to infraction.",
					"Hold Refresh - Did the agent informed the patient that he/she still looking for information (if hold is more than 2 mins)- If disconnected due to long hold then it leads to infraction. - Remarks11",
					"Consistent pleasantries used throughout the entire call (Please thank you Excuse me You're Welcome & May I).",
					"Consistent pleasantries used throughout the entire call (Please thank you Excuse me You're Welcome & May I). - Remarks12",
					"All call notes documented in ServiceNow with the correct taxonomy.",
					"All call notes documented in ServiceNow with the correct taxonomy. - Remarks13",
					"The agent followed all company process and policies to resolve the problem.",
					"The agent followed all company process and policies to resolve the problem. - Remarks14",
					"All internal resources (tools & managers) used to resolve the problem.",
					"All internal resources (tools & managers) used to resolve the problem. - Remarks15",
					"Problem was clearly determined and explained due to having ROMTech knowledge .",
					"Problem was clearly determined and explained due to having ROMTech knowledge . - Remarks16",
					"Provide clear follow-up instructions (If applicable).",
					"Provide clear follow-up instructions (If applicable). - Remarks17",
					"Verify if the user had any other questions.",
					"Verify if the user had any other questions. - Remark18",
					"Used standard ROMTech closing message (Thank you for contacting ROMTech customer service department).",
					"Used standard ROMTech closing message (Thank you for contacting ROMTech customer service department). - Remarks19",
					"Audit Start date and  Time ", "Audit End Date and  Time"," Audit Interval in Seconds",  "Call Summary ","Feedback ","Agent Feedback Status ", "Feedback Acceptance","Agent Review Date","Management Review Date ", "Management Review Name ","Management Review Note", "Client Review Name","Client Review Note","Client Review Date " );




 		$row = "";
 		foreach($header as $data) $row .= ''.$data.',';
 		fwrite($fopen,rtrim($row,",")."\r\n");
 		$searches = array("\r", "\n", "\r\n");



 			foreach($rr as $user)
 			{
 				if($user['entry_by']!=''){
 					$auditorName = $user['auditor_name'];
 				}else{
 					$auditorName = $user['client_name'];
 				}

 				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
 					$interval1 = '---';
 				}else{
 					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
 				}

 				$row = '"'.$auditorName.'",';
 				$row .= '"'.$user['audit_date'].'",';
 				$row .= '"'.$user['fname']." ".$user['lname'].'",';
 				$row .= '"'.$user['acpt'].'",';
 				$row .= '"'.$user['fusion_id'].'",';
 				$row .= '"'.$user['tl_name'].'",';
 				$row .= '"'.$user['call_date'].'",';
 				$row .= '"'.$user['audit_type'].'",';
 				$row .= '"'.$user['auditor_type'].'",';
 				$row .= '"'.$user['call_id'].'",';
 				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['L1'].'",';
				$row .= '"'.$user['L2'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['earned_score'].'",';
 				$row .= '"'.$user['possible_score'].'",';
 				$row .= '"'.$user['overall_score'].'"% ,';
				$row .= '"'.$user['customer_overall_score'].'",';
				$row .= '"'.$user['business_overall_score'].'",';
				$row .= '"'.$user['compliance_overall_score'].'",';
				$row .= '"'.$user['appropriate_greeting'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['introduction_on_call'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['mandate_details'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['communication_skill'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['empathy'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['overlapped_customer'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['listening_skills'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['professionalism'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'.$user['probing'].'",';
				$row .= '"'.$user['cmt9'].'",';
				$row .= '"'.$user['hold_verbiage'].'",';
				$row .= '"'.$user['cmt10'].'",';
				$row .= '"'.$user['hold_refresh'].'",';
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'.$user['consistent_pleasantries'].'",';
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'.$user['correct_taxonomy'].'",';
				$row .= '"'.$user['cmt13'].'",';
				$row .= '"'.$user['polices_resolve_problem'].'",';
				$row .= '"'.$user['cmt14'].'",';
				$row .= '"'.$user['internal_resources'].'",';
				$row .= '"'.$user['cmt15'].'",';
				$row .= '"'.$user['ROMTech_knowledge'].'",';
				$row .= '"'.$user['cmt16'].'",';
				$row .= '"'.$user['follow_up'].'",';
				$row .= '"'.$user['cmt17'].'",';
				$row .= '"'.$user['other_questions'].'",';
				$row .= '"'.$user['cmt18'].'",';
				$row .= '"'.$user['closing_message'].'",';
				$row .= '"'.$user['cmt19'].'",';
 				$row .= '"'.$user['audit_start_time'].'",';
 				$row .= '"'.$user['entry_date'].'",';
 				$row .= '"'.$interval1.'",';
 				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
 				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
 				$row .= '"'.$user['agnt_fd_acpt'].'",';

 				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
 				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
 				$row .= '"'.$user['mgnt_rvw_name'].'",';

 				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';

 				$row .= '"'.$user['client_rvw_name'].'",';
 				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';

 				$row .= '"'.$user['client_rvw_date'].'"';

 				fwrite($fopen,$row."\r\n");
 			}
 			fclose($fopen);
 		}