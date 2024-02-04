<td>KPI-ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[kpi_acpt]" required>
												    <option value="">-Select-</option>
												    <option value="Agent" <?= ($clio['kpi_acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Customer" <?= ($clio['kpi_acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Process" <?= ($clio['kpi_acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Technology" <?= ($clio['kpi_acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA" <?= ($clio['kpi_acpt']=="NA")?"selected":"" ?>>NA</option>
											</select>
											</td>


											<tr>
										<td>Call Analytics:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[call_analytics]" required>
											
											    <option value="">-Select-</option>
											    <option value="Customer Experience" <?= ($clio['call_analytics']=="Customer Experience")?"selected":"" ?>>Customer Experience</option>
												<option value="Csat" <?= ($clio['call_analytics']=="Csat")?"selected":"" ?>>Csat</option>
												<option value="Nps" <?= ($clio['call_analytics']=="Nps")?"selected":"" ?>>Nps</option>
												<option value="Issue resolution" <?= ($clio['call_analytics']=="Issue resolution")?"selected":"" ?>>Issue resolution</option>
												<option value="Repeat Caller" <?= ($clio['call_analytics']=="Repeat Caller")?"selected":"" ?>>Repeat Caller</option>
												<option value="High AHT" <?= ($clio['call_analytics']=="High AHT")?"selected":"" ?>>High AHT</option>
												<option value="Low AHT" <?= ($clio['call_analytics']=="Low AHT")?"selected":"" ?>>Low AHT</option>
										</select>
											</td>

										<td>ACPT Level:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[acpt_level]" required>
											    <option value="">-Select-</option>
											    <option value="Level 1" <?= ($clio['acpt_level']=="Level 1")?"selected":"" ?>>Level 1</option>
												<option value="Level 2" <?= ($clio['acpt_level']=="Level 2")?"selected":"" ?>>Level 2</option>
												<option value="Level 3" <?= ($clio['acpt_level']=="Level 3")?"selected":"" ?>>Level 3</option>
										</select>
											</td>	
									</tr>
									
									<?php

public function create_qa_clio_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./qa_files/qa_reports_data/Report".get_user_id().".csv";
		$currentURL = base_url();
		$controller = "Qa_clio";
		$edit_url = "add_edit_clio";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$fopen = fopen($filename,"w+");

		$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super","Call Date","Call Duration","Call Type","Sampling","reference_id", "Query Type", "Query Sub Type", "Stat / Non-Stat","Auto Fail", "Total Opportunity", "Audit Type", "Auditor Type", "Voc","KPI-ACPT","Audit Link","LOB","Inbound/Outbound","Overall Score", "Possible Score", "Earned Score", "Customer Score","Business Score","Compliance Score", 
		"Did the CSR adhere to all Authentication and Security Policies of the account member?", "Properly verifies the account holder information before providing/discussing any account information", "For account changes and caller should be authorized on the account(ie wife or dependent)", "Did the CSR greets the caller by mentioning the branding in the opening spiel and thank the caller on the closing spiel?", "Did the agent check if the order is STAT?", "Did the agent show empathy and acknowledge patients concern?", "Did the agent utilize all needed information before scheduling an appointment?","Check_list", "Did the agent observe proper Hold Procedure and avoid long silences?", "Did the agent maintain a positive interaction during the call?", "Did the agent asked Covid screening questions?", "Did the agent provide accurate reminders for the patient?", "Did the agent select the correct order status and left account notes?", "Did the agent check if CPT and diagnosis are both correct?", "Did the agent update the patient demographic information?", "Did the agent follow up with necessary documents?(Going above and Beyond)", "Did the agent offer alternatives to the patient?", "Did the agent verify if it needs to be sent to corrections or pre-cert?", "Did the agent make sure to set up the correct Modality for the patient?",
		"Comments 1", "Comments 2", "Comments 3", "Comments 4", "Comments 5", "Comments 6", "Comments 7", "Comments 8", "Comments 9", "Comments 10", "Comments 11", "Comments 12", "Comments 13", "Comments 14", "Comments 15", "Comments 16", "Comments 17", "Comments 18",
		"Call Summary", "Feedback","Call Analytics","ACPT Level","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");


		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");



		foreach($rr as $user){
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
			$main_urls = $main_url.'/'.$user['id'];

			$row = '"'.$auditorName.'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['sampling'].'",';
			$row .= '"'.$user['reference_id'].'",';
			$row .= '"'.$user['query_type'].'",';
			$row .= '"'.$user['query_sub_type'].'",';
			$row .= '"'.$user['stat'].'",';
			$row .= '"'.$user['auto_fail'].'",';
			$row .= '"'.$user['total_opportunity'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['kpi_acpt'].'",';
			$row .= '"'.$main_urls.'",';
			$row .= '"'.$user['lob'].'",';
			$row .= '"'.$user['in_out'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['customer_score'].'",';
			$row .= '"'.$user['business_score'].'",';
			$row .= '"'.$user['compliance_score'].'",';
			
			$row .= '"'.$user['do_csr_adhere'].'",';
			$row .= '"'.$user['properly_verifies_account_holder'].'",';
			$row .= '"'.$user['is_authorized_account'].'",';
			$row .= '"'.$user['closing_spiel'].'",';
			$row .= '"'.$user['do_agent_check'].'",';
			$row .= '"'.$user['do_show_empathy'].'",';
			$row .= '"'.$user['do_agent_utilize_information'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['check_list1'])).'",';
			$row .= '"'.$user['do_proper_hold_procedure'].'",';
			$row .= '"'.$user['do_maintain_positive_interaction'].'",';
			$row .= '"'.$user['do_ask_covid_question'].'",';
			$row .= '"'.$user['do_provide_accurate_reminders'].'",';
			// $row .= '"'.$user['ask_relevant_probing'].'",';
			$row .= '"'.$user['do_select_correct_order_status'].'",';
			$row .= '"'.$user['do_check_cpt_diagnosis'].'",';
			$row .= '"'.$user['do_update_patient_demographic'].'",';
			$row .= '"'.$user['do_check_insurance_auth'].'",';
			$row .= '"'.$user['do_check_demog_prescription'].'",';
			$row .= '"'.$user['do_verify_need_sent_correction'].'",';
			$row .= '"'.$user['do_make_setup_correct_modality'].'",';
			
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
			
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['call_analytics'].'",';
			$row .= '"'.$user['acpt_level'].'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);

	}									