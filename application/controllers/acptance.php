<?
foreach($rowDefect as $defect){

		// 	//if($process_id != 'a'){
		// 	$process = $p_data['process_name'];
		// 	// }else{
		// 	// 	$process = 'All Process';
		// 	// }

			

		// 	$lobwise_sql = "select count(t.id) as total_feedback,t.lob_campaign,
		// 	sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
		// 	sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count,
		// 	sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
		// 	sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
		// 	sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt
		// 	from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
		// 	where date(t.audit_date) between '$from_date' and '$to_date' $off_cond $lob_cond $tl_cond $qa_cond group by t.lob_campaign";

		// 	$lob_wise_data[] = $this->Common_model->get_query_result_array($lobwise_sql);

		// 	$tlwise_sql = "select count(t.id) as total_feedback,t.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = t.tl_id) as tl_name, sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
		// 	sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
		// 	sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
		// 	sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
		// 	where date(t.audit_date) between '$from_date' and '$to_date' $off_cond $lob_cond $tl_cond $qa_cond group by t.tl_id";

		// 	$tl_wise_data[] = $this->Common_model->get_query_result_array($tlwise_sql);

		// 	$qawise_sql = "select count(t.id) as total_feedback,t.entry_by, (select concat(fname,' ',lname) as qa_name FROM signin WHERE signin.id = t.entry_by) as qa_name, (select d.description FROM signin si join department d on si.dept_id = d.id WHERE si.id = t.entry_by) as department,
		// 	sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
		// 	sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
		// 	sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
		// 	sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
		// 	where date(t.audit_date) between '$from_date' and '$to_date' $off_cond $lob_cond $tl_cond $qa_cond group by t.entry_by";

		// 	$qa_wise_data[] = $this->Common_model->get_query_result_array($qawise_sql);

		// 	$agentwise_sql = "select count(t.id) as total_feedback,concat(s.fname,' ',s.lname) as agent_name,s.xpoid,t.tl_id, (select concat(fname,' ',lname) as tl_name FROM signin WHERE signin.id = t.tl_id) as tl_name,
		// 	sum(case when t.audit_status = 1 then 1 else 0 end) as approved_audit,
		// 	sum(case when t.agnt_fd_acpt = 'Accepted' then 1 else 0 end) as accept_count, sum(case when t.agnt_fd_acpt = 'Not Accepted' then 1 else 0 end) as rebuttal_count,
		// 	sum(case when t.agnt_fd_acpt is null and t.audit_status = 1 then 1 else 0 end) as not_accepted_count,
		// 	sum(case when t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.audit_approved_date))/3600) <=24 then 1 else 0 end) as tntfr_hr_acpt from ".$p_data['table_name']." t join signin s on t.agent_id = s.id
		// 	where date(t.audit_date) between '$from_date' and '$to_date' $off_cond $lob_cond $tl_cond $qa_cond group by s.id";

		// 	$agent_wise_data[] = $this->Common_model->get_query_result_array($agentwise_sql);
		// }
		//process_wise
		foreach($overall_data as $pro_data){
			$pros_array[] = $pro_data['process'];
		}
		$pross_list = array_unique($pros_array);
		foreach ($pross_list as $key => $pro) {
			unset($pro_wise_data);
			$pro_wise_data = array();
			foreach($overall_data as $pro_datas){
					if ($pro==$pro_datas['process']) {
						$pro_wise_data['process'] = $pro_datas['process'];
						$pro_wise_data['total_feedback'] += $pro_datas['total_feedback'];
						$pro_wise_data['approved_audit'] += $pro_datas['approved_audit'];
						$pro_wise_data['tntfr_hr_acpt'] += $pro_datas['tntfr_hr_acpt'];
						$pro_wise_data['accept_count'] += $pro_datas['accept_count'];
						$pro_wise_data['rebuttal_count'] += $pro_datas['rebuttal_count'];
						$pro_wise_data['not_accepted_count'] += $pro_datas['not_accepted_count'];
					}
		}
		$new_pro_data[] = $pro_wise_data;
		}
		// echo "<pre>";
		// print_r($new_pro_data);
		// echo "</pre>";die;
		$data['pro_wise_data'] = $new_pro_data;

		//////

		unset($ovrl_data);
		$ovrl_data = array();

			foreach($overall_data as $ov_datas){
					$ovrl_data['process'] = 'Grand Total';
					$ovrl_data['total_feedback'] += $ov_datas['total_feedback'];
					$ovrl_data['approved_audit'] += $ov_datas['approved_audit'];
					$ovrl_data['tntfr_hr_acpt'] += $ov_datas['tntfr_hr_acpt'];
					$ovrl_data['accept_count'] += $ov_datas['accept_count'];
					$ovrl_data['rebuttal_count'] += $ov_datas['rebuttal_count'];
					$ovrl_data['not_accepted_count'] += $ov_datas['not_accepted_count'];
		}
		$data['overall_data'] = $ovrl_data;

		//lob_wise
		foreach($lob_wise_data as $lob_data){
			foreach ($lob_data as $key => $campaign_data) {
			$lob_array[] = $campaign_data['lob_campaign'];
			}
		}
		$lob_list = array_unique($lob_array);
		foreach ($lob_list as $key => $lob) {
			unset($lobwise_data);
			$lobwise_data = array();
			foreach($lob_wise_data as $campaign_datas){
				foreach ($campaign_datas as $key => $lob_datas) {
					if ($lob==$lob_datas['lob_campaign']) {
						$lobwise_data['lob_campaign'] = $lob_datas['lob_campaign'];
						$lobwise_data['total_feedback'] += $lob_datas['total_feedback'];
						$lobwise_data['approved_audit'] += $lob_datas['approved_audit'];
						$lobwise_data['tntfr_hr_acpt'] += $lob_datas['tntfr_hr_acpt'];
						$lobwise_data['accept_count'] += $lob_datas['accept_count'];
						$lobwise_data['rebuttal_count'] += $lob_datas['rebuttal_count'];
						$lobwise_data['not_accepted_count'] += $lob_datas['not_accepted_count'];
					}
			}
		}
		$new_lob_data[] = $lobwise_data;
		}
		$data['lobwise_data'] = $new_lob_data;
		//tl_wise
		foreach($tl_wise_data as $l1_data){
		foreach ($l1_data as $key => $tl_data) {
		$tl_array[] = $tl_data['tl_name'];
		}
		}
		$tl_list = array_unique($tl_array);
		foreach ($tl_list as $key => $tl) {
		unset($tlwise_data);
		$tlwise_data = array();
			foreach($tl_wise_data as $l1_datas){
				foreach ($l1_datas as $key => $tl_datas) {
						if ($tl==$tl_datas['tl_name']) {
						$tlwise_data['tl_name'] = $tl_datas['tl_name'];
						$tlwise_data['total_feedback'] += $tl_datas['total_feedback'];
						$tlwise_data['approved_audit'] += $tl_datas['approved_audit'];
						$tlwise_data['tntfr_hr_acpt'] += $tl_datas['tntfr_hr_acpt'];
						$tlwise_data['accept_count'] += $tl_datas['accept_count'];
						$tlwise_data['rebuttal_count'] += $tl_datas['rebuttal_count'];
						$tlwise_data['not_accepted_count'] += $tl_datas['not_accepted_count'];
					}
				}
			}
			$new_tl_data[] = $tlwise_data;
		}
		$data['tlwise_data'] = $new_tl_data;
		//qa_wise
		foreach($qa_wise_data as $entry_by_data){
			foreach ($entry_by_data as $key => $qa_data) {
			$qa_array[] = $qa_data['qa_name'];
			}
		}
		$qa_list = array_unique($qa_array);
		foreach ($qa_list as $key => $qa) {
		unset($qawise_data);
		$qawise_data = array();
		foreach($qa_wise_data as $entry_by_datas){
			foreach ($entry_by_datas as $key => $qa_datas) {
				if ($qa==$qa_datas['qa_name']) {
					$qawise_data['qa_name'] = $qa_datas['qa_name'];
					$qawise_data['department'] = $qa_datas['department'];
					$qawise_data['total_feedback'] += $qa_datas['total_feedback'];
					$qawise_data['approved_audit'] += $qa_datas['approved_audit'];
					$qawise_data['tntfr_hr_acpt'] += $qa_datas['tntfr_hr_acpt'];
					$qawise_data['accept_count'] += $qa_datas['accept_count'];
					$qawise_data['rebuttal_count'] += $qa_datas['rebuttal_count'];
					$qawise_data['not_accepted_count'] += $qa_datas['not_accepted_count'];
				}
			}
		}
		$new_qa_data[] = $qawise_data;
		}
		$data['qawise_data'] = $new_qa_data;
		//agent_wise
		foreach($agent_wise_data as $agentt_wise_data){
			foreach ($agentt_wise_data as $key => $agent_data) {
			$agent_array[] = $agent_data['agent_name'];
			}
		}
		$agent_list = array_unique($agent_array);
		foreach ($agent_list as $key => $agent) {
		unset($agentwise_data);
		$agentwise_data = array();
			foreach($agent_wise_data as $agentt_wise_datas){
				foreach ($agentt_wise_datas as $key => $agent_datas) {
					if ($agent==$agent_datas['agent_name']) {
							$agentwise_data['xpoid'] = $agent_datas['xpoid'];
							$agentwise_data['agent_name'] = $agent_datas['agent_name'];
							$agentwise_data['tl_name'] = $agent_datas['tl_name'];
							$agentwise_data['total_feedback'] += $agent_datas['total_feedback'];
							$agentwise_data['approved_audit'] += $agent_datas['approved_audit'];
							$agentwise_data['tntfr_hr_acpt'] += $agent_datas['tntfr_hr_acpt'];
							$agentwise_data['accept_count'] += $agent_datas['accept_count'];
							$agentwise_data['rebuttal_count'] += $agent_datas['rebuttal_count'];
							$agentwise_data['not_accepted_count'] += $agent_datas['not_accepted_count'];
						}
					}
				}
			$new_agent_data[] = $agentwise_data;
			}
			$data['agentwise_data'] = $new_agent_data;
		}