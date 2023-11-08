public function create_qa_sea_world_CSV($rr,$campaign)
	{

		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		if($campaign=="sea_world"){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "ACPT", "Evaluation Link", "File/Call ID","Reason of the Call","Site", "Call Date", "Call Duration", "Audit Type", "Auditor Type", "VOC","Possible Score", "Earned Score", "Overall Score",
			"1a. Uses Proper Greeting.", "Remarks",
			"1b. Uses Proper Closing.", "Remarks",
			"2a. Agent maintained proper tone pitch volume clarity and pace throughout the call.","Remarks",
			"2b. Agent used courteous words and phrases. Also was friendly polite and professional.", "Remarks",
			"2c.The agent adapted their approach to the customer based on the customers unique needs personality and issues.", "Remarks",
			"2d. Active Listening.", "Remarks",
			"3.1.a. Agent takes ownership of the call and resolves all issues that arise throughout the call.", "Remarks",
			"3.1.b. Agent follows all SOP/Policies as stated in SharePoint.", "Remarks",
			"3.1.c. Agent does not blame parks or other departments for problem guest is calling about.", "Remarks",
			"3.1.d.The agent asked pertinent questions to accurately diagnose the guest's need or problem.", "Remarks",
			"3.1.e. Agent used appropropriate resources to address the issue.", "Remarks",
			"3.2.a. Agent is familiar with our products and provides accurate information.", "Remarks",
			"3.2.b. Agent sounds confident and knowledgeable.", "Remarks",
			"3.2.c. Agent presents a sense of urgency whenever applicable.", "Remarks",
			"3.3.a Agent handles call efficiently through effective navigation and by not going over irrelevant products/information.", "Remarks",
			"3.3.b. Uses proper hold procedure - Agent asks guest permission to place them on hold - Agent checks back in on guest every 2 minutes while on hold - Agent does not place guest on any unnecessary holds.", "Remarks",
			"3.3.c. Agent minimized or eliminated dead air.", "Remarks",
			"Ensures to speak with CC holder/authorized user on all accounts/orders prior to making any changes and/or providing private information", "Remarks",
			"Explains Ezpay Contract / Cxl Policies", "Remarks",
			"Never rude to a guest", "Remarks",
			"Leaves COMPLETE notes in all accounts/orders", "Remarks",
			"Qualifies Park by city/state", "Remarks",
			"Uses the correct disposition codes", "Remarks",
			"Call Summary/Observation", "Feedback", "Audit Start date and  Time ", "Audit End Date and  Time","Interval (in sec)", "Agent Acceptance", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time","Mgnt Review By", "Mgnt Comment","Client Review Name","Client Review Note","Client Review Date and Time");

			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				 if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				 }else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				 }

				$row = '"'.$user['auditor_name'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['evaluation_link'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['call_reason'].'",';
				$row .= '"'.$user['site'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['use_proper_greeting'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'.$user['use_proper_closing'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'.$user['proper_tone'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'.$user['courteous_words'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'.$user['agent_adapted_approach'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'.$user['agent_takes_ownership'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'.$user['follows_all_SOP'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'.$user['blame_parks'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'.$user['asked_pertinent_questions'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'.$user['used_appropropriate_resources'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'.$user['accurate_information'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'.$user['sounds_confident'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'.$user['sense_of_urgency'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'.$user['effective_navigation'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'.$user['proper_hold_procedure'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'.$user['eliminated_dead_air'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';			
				$row .= '"'.$user['use_AMEX'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['use_AMEX_cmt'])).'",';
				$row .= '"'.$user['Cxl_Policies'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['Cxl_Policies_cmt'])).'",';
				$row .= '"'.$user['rude_to_guest'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['rude_to_guest_cmt'])).'",';
				$row .= '"'.$user['leave_complete_notes'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['leave_complete_notes_cmt'])).'",';
				$row .= '"'.$user['qualifies_Park'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qualifies_Park_cmt'])).'",';
				$row .= '"'.$user['correct_disposition_codes'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['correct_disposition_codes_cmt'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_name'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';
	  			$row .= '"'.$user['client_rvw_date'].'",';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);

		}else if($campaign=="sea_world_chat"){
			////////////////////////////////////
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "ACPT", "Evaluation Link", "File/Call ID","Reason of the Call","Site", "Call Date", "Call Duration", "Audit Type", "Auditor Type", "VOC","Possible Score", "Earned Score", "Overall Score",
				"1a. Proper greeting","LEGEND","REMARKS",
				"1b. Proper Closing","LEGEND","REMARKS",
				"2a. Conversation was clearunderstood uses proper spelling as well as grammer.","LEGEND","REMARKS",
				"2b. Ambassador used courteous & professional words and phrases.","LEGEND","REMARKS",
				"2c. The agent adapted their approach to the customer based on the customer’s unique needs personality and issues.","LEGEND","REMARKS",
				"2d. Active Listening.","LEGEND","REMARKS",
				"3.1.a. Agent takes ownership of the Chat and resolves all issues that arise throughout the Chat.","LEGEND","REMARKS",
				"3.1.b. Agent follows all SOP/Policies as stated in SharePoint or provided by Leadership.","LEGEND","REMARKS",
				"3.1.c. Agent does not blame parks or other departments for problem.","LEGEND","REMARKS",
				"3.1.d. The agent asked pertinent questions to accurately diagnose the guest's need or problem.","LEGEND","REMARKS",
				"3.1.e. Agent used appropropriate resources to address the issue.","LEGEND","REMARKS",
				"3.2.a. Agent is familiar with ourproducts and provides accurate information.","LEGEND","REMARKS",
				"3.2.b. Agent presents a sense of urgency whenever applicable","LEGEND","REMARKS",
				"3.3.a. Agent handles chat efficiently through effective navigation and by not going over irrelevant products or information.","LEGEND","REMARKS",
				"3.3.b. Uses Proper Hold Procedures.","LEGEND","REMARKS",
				"3.3.c. Ambassador minimized or eliminated dead time on Chat.","LEGEND","REMARKS",
				"Qualifies park by city/state","REMARKS",
				"Explains EZpay Contract / Explains cancelation policies","REMARKS",
				"Customer focused at all times (Does not use Rude or Offensive langauge )","REMARKS",
				"Uses the correct Disposition Code","REMARKS",
				"Follows all PCI Policies ( Can't Share CC info )","REMARKS",
				"Leaves COMPLETE notes in all accounts/orders - Agent leaves all names of Leadership that they may have gotten direction from for the issue the guest is calling for - Agent leaves all details of the call on the account or order. - Agent should think of being the next agent contacted from the guest about the same issue. Being the next agent you will want to know what why and the solution was of the call.","REMARKS",
			"Call Summary/Observation", "Feedback", "Audit Start date and  Time ", "Audit End Date and  Time","Interval (in sec)", "Agent Acceptance", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time","Mgnt Review By", "Mgnt Comment","Client Review Name","Client Review Note","Client Review Date and Time");

			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				 if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				 }else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				 }

				$row = '"'.$user['auditor_name'].'",';
				$row .= '"'.$user['audit_date'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['evaluation_link'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['call_reason'].'",';
				$row .= '"'.$user['site'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['proper_greeting'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks1'])).'",';
				$row .= '"'.$user['proper_closing'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks2'])).'",';
				$row .= '"'.$user['proper_spelling'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks3'])).'",';
				$row .= '"'.$user['professional_words'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks4'])).'",';
				$row .= '"'.$user['adapted_approach'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks5'])).'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks6'])).'",';
				$row .= '"'.$user['take_ownership'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks7'])).'",';
				$row .= '"'.$user['follows_all_SOP'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks8'])).'",';
				$row .= '"'.$user['blame_parks'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks9'])).'",';
				$row .= '"'.$user['pertinent_questions'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks10'])).'",';
				$row .= '"'.$user['appropropriate_resources'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks11'])).'",';
				$row .= '"'.$user['accurate_information'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks12'])).'",';
				$row .= '"'.$user['sense_urgency'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks13'])).'",';
				$row .= '"'.$user['handles_chat_efficiently'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks14'])).'",';
				$row .= '"'.$user['hold_procedures'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks15'])).'",';
				$row .= '"'.$user['dead_time'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks16'])).'",';
				$row .= '"'.$user['qualifies_park'].'",'; 
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';		
				$row .= '"'.$user['cancelation_policies'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'.$user['customer_focused'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'.$user['correct_disposition'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'.$user['PCI_policies'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
				$row .= '"'.$user['complete_notes'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_name'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';
	  			$row .= '"'.$user['client_rvw_date'].'",';
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);

			///////////////////////////////////
		}
	}