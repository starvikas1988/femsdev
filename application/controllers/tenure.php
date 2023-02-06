<?php

$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,(select DATEDIFF(CURDATE(), s.doj) as tenure from signin s where s.id=agent_id) as tenure,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_bcci) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
					$fullAray = $this->Common_model->get_query_result_array($qSql);


public function create_qa_hcci_CSV($rr)
	{
		$filename = "./qa_files/qa_reports_data/Report".get_user_id().".csv";
		$currentURL = base_url();
		$controller = "Qa_clio";
		$edit_url = "add_edit_clio_spot";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;
		
		//$main_url = base_url().'qa_files/qa_homeadvisor/homeadvisor_files/';
		$fopen = fopen($filename,"w+");
		$header=array ( "Auditor Name","Tenure","Audit Link","Audit Date","Fusion Id","Agent","TL Name","Call Date/Time","Call Duration","SR NO.","Consumer No.","Call File","AUDIT TYPE","AUDITOR TYPE","VOC","Overall Score","Introduction must include company name","We attempted to overcome all homeowner objections","Kept call simple and brief by not extending the information provided","We educated homeowner on what will happen after their request is submit","Attempt to gather and accurately submit all SR information for the professional","Do you agree to HomeAdvisor's Terms including that HomeAdvisor","HomeAdvisor and our partners may offer discounts and other offers in the future","Note BETTI if homeowner does not agree to 2nd Consent","Suggestive cross sell offered","Offer contact information and a transfer to pro","Compliance Score","Customer Score","Business Score","Call Summary","Feedback","Entry By","Entry Date","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent review note","Agent review date","Client review by","Client review note","Client rvw date");

		$field_name="SHOW FULL COLUMNS FROM qa_hcci_feedback WHERE Comment!=''";
		$field_name=$this->Common_model->get_query_result_array($field_name);
		$fld_cnt=count($field_name);
		for($i=0;$i<$fld_cnt;$i++){
						$val=$field_name[$i]['Field'];
						if($val!=""){
							$field_val[]=$val;
						}
					 }
		array_unshift($field_val ,"audio_link");
		array_unshift($field_val ,"tenure");			 
		array_unshift($field_val ,"auditor_name");
		
		
		$key = array_search ('agent_id', $field_val);
		array_splice($field_val, $key, 0, 'fusion_id');
		$field_val=array_values($field_val);
		// echo"<pre>";
		// print_r($field_val);
		// echo"</pre>";
		//die();
		$count_for_field=count($field_val);

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$row = "";
		//  print_r($rr);
		// die;
		foreach($rr as $user)
		{
			for($z=0;$z<$count_for_field;$z++){
				 $main_urls = $main_url.'/'.$user['id'];
				// echo $field_val[$z]; 
				
				if($field_val[$z]==="auditor_name"){
					$row = '"'.$user['auditor_name'].'",';
				}else if($field_val[$z]==="tenure"){
					$row .= '"'.$user['tenure'].'",';
				}else if($field_val[$z]==="audio_link"){
					$row .= '"'.$main_urls.'",';
				}else if($field_val[$z]==="fusion_id"){
					$row .= '"'.$user['fusion_id'].'",';
				}else if($field_val[$z]==="agent_id"){
					$row .= '"'.$user['fname']." ".$user['lname'].'",';
				}else if($field_val[$z]==="tl_id"){
					$row .= '"'.$user['tl_name'].'",';
				}else if(in_array($field_val[$z], array('call_summary','feedback','agent_rvw_note','mgnt_rvw_note'))) {

    			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user[$field_val[$z]])).'",';

				}else{
					$row .= '"'.$user[$field_val[$z]].'",';
				}

			}
			//die();
			
				fwrite($fopen,$row."\r\n");
				$row = "";
		}

		fclose($fopen);
	}

	$row .= '"'.$user['tenure'].'",';
	$row .= '"'.$main_urls.'",';
	///////////////////////////

	$sqlPhilipines = "SELECT s.office_id,c.id as client_id,i.process_id,c.fullname as 					clientName,p.name as processName
								FROM info_assign_process i 
								LEFT JOIN signin s ON s.id=i.user_id
								LEFT JOIN process p ON p.id=i.process_id
								LEFT JOIN client c ON p.client_id=c.id
								LEFT JOIN info_assign_client ic ON c.id=ic.client_id
								where c.is_active=1 and p.client_id not in (0) and s.office_id in ('CEB','MAN') and c.id not in('4','90','291','312','324','339','342','345','352','355','357') group by p.id order by s.office_id
							 ";
			$resPhilipines = $this->Common_model->get_query_result_array($sqlPhilipines);