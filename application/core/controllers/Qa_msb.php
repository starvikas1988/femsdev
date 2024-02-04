<?php 

 class Qa_msb extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
	}

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_msb/qa_msb_feedback.php";
						
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$cond='';
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date=CurrDate();
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
			
		////////////////////////	
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else{
				$ops_cond="";
			}
		
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_msb_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["msb_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

//////////////////////MSB ADD Audit//////////////////////////////

		public function add_msb_new(){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_msb/add_msb_new.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,139) and is_assign_process (id,284) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();

			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['audit_start_time']=$this->input->post('audit_start_time');
				$field_array['entry_date']=$curDateTime;
				$a = $this->mt_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_msb_feedback',$field_array);
				redirect('Qa_msb');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function mt_upload_files($files){
        $config['upload_path'] = './qa_files/qa_msb';
		$config['allowed_types'] = 'mp3|avi|mp4|wmv';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
        $images = array();
		
        foreach ($files['name'] as $key => $image) {           
			$_FILES['images[]']['name']= $files['name'][$key];
			$_FILES['images[]']['type']= $files['type'][$key];
			$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['images[]']['error']= $files['error'][$key];
			$_FILES['images[]']['size']= $files['size'][$key];

            if ($this->upload->do_upload('images[]')) {
				$info = $this->upload->data();
				$images[] = $info['file_name'];
            } else {
                return false;
            }
        }
        return $images;
    }
	

///////////////////MSB Manegment review///////////////////////////

	public function mgnt_msb_new($id){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_msb/mgnt_msb_new.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,139) and is_assign_process (id,284) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_msb_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["msb_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=$this->input->post('data');
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$this->db->where('id', $pnid);
				$this->db->update('qa_msb_feedback',$field_array);
				
			////////////	
				if(get_login_type()=="client"){
					$field_array1 = array(
						"client_rvw_by" => $current_user,
						"client_rvw_note" => $this->input->post('note'),
						"client_rvw_date" => $curDateTime
					);
				}else{
					$field_array1 = array(
						"mgnt_rvw_by" => $current_user,
						"mgnt_rvw_note" => $this->input->post('note'),
						"mgnt_rvw_date" => $curDateTime
					);
				}
				$this->db->where('id', $pnid);
				$this->db->update('qa_msb_feedback',$field_array1);
			///////////	
				redirect('Qa_msb');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
// ///////////////////////////////////////////////////////////////////////////////////////////	 
// ////////////////////////////////////// QA MSB REPORT //////////////////////////////////////	
// ///////////////////////////////////////////////////////////////////////////////////////////

	public function getval($arrs, $k) {
    foreach($arrs as $key=>$val) {
        if( $key === $k ) {
            return $val;
        }
        else {
            if(is_array($val)) {
                $ret = $this->getval($val, $k);
                if($ret !== NULL) {
                    return $ret;
                }
            }
        }
    }
    return NULL;
	}


	public function qa_msb_report(){

		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["download_link1"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_msb/qa_msb_report.php";
						
			$date_from="";
			$date_to="";
			$office_id="";
			$action="";
			$dn_link="";
			$dn_link1="";
			$cond1='';
			
			$data["qa_msb_list"] = array();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond1= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
				if($office_id != "") $cond1 .= " and office_id='$office_id'";
				
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_msb_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond1 order by audit_date";
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_msb_list"] = $fullAray;
					// $header_arr=$this->Common_model->get_query_result_array("SELECT column_comment FROM information_schema.COLUMNS WHERE table_name = 'qa_msb_feedback'");
					// $cnt=count($header_arr);

					//  for($i=0;$i<$cnt;$i++){
					// 	$val=$this->getval($header_arr[$i],'column_comment');
					// 	if($val!=""){
					// 		$header[]=$val;
					// 	}		
					//  }
					// array_unshift($header ,"Auditor Name");
					// $key = array_search ('Agent', $header);
					// array_splice($header, $key, 0, 'Fusion Id');
					// print_r($header);
					// die;
					$this->create_qa_msb_new_CSV($fullAray);	
					$dn_link = base_url()."qa_msb/download_qa_msb_new_CSV";
			}
			
			$data['download_link']=$dn_link;
			$data['download_link1']=$dn_link1;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id'] = $office_id;	
			
			$this->load->view('dashboard',$data);
		}
	}	
	 
		
// /////////////////// MSB NEW /////////////////////
	public function download_qa_msb_new_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA MSB New Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_msb_new_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");		
		$header=array ( "Auditor Name ","Audit Date ","Fusion Id ","Agent ","L1 Super ","Phone ","Call Date ","Call Duration ","ACPT ","ACPT Option ","ACPT Others ","QA Type ","Audit Type ","Auditor Type ","VOC ","Client Name ","Overall Score ","Identify himself/herself by first and last name at the beginning of the call? **SQ** ","Provide the Quality Assurance Statement verbatim before any specific account information was discussed?**SQ** ","State 'MSB Financial' with no deviation? **SQ** ","Verify that he/she was speaking to a right party according to the client requirements (First and Last Name) and before providing the disclosures? ","Verify one/two pieces of demographics information on an outbound call ","Provide the Mini Miranda disclosure verbatim ","State the client name and the purpose of the communication? ","Sate/Ask for balance due? ","Opening Score ","Full and Complete information taken? ","Ask for the payment over the phone? ","Ask for a post dated payment (except for the states MA or RI)? ","Followed the previous conversations on the account for the follow-up call ","Able to take a promise to pay on the account? ","Effort Score ","Offer to split the balance in part? ","Offer a one/three/lump sum settlement appropriately? ","Offer a payment plan with significant down payment? ","Did Collector follow proper negotiation sequence to provide settelment options? ","Did Collector try to negotiate effectively to convince the customer for payment? ","Offer a small good faith payment? ","Negotiation Score ","Did not Misrepresent their identity or authorization and status of the consumer's account? ","Did not Discuss or imply that any type of legal actions ","Did not Make any false representations regarding the nature of the communication? ","Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumer's location? ","Did not Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited? ","Did not Communicate with the consumer after learning the consumer is represented by an attorney ","Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell phone email and fax? ","Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer? ","Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place? ","Did not Make any statement that could constitute unfair ","Did not Communicate or threaten to communicate false credit information or information which should be known to be false and utilized the proper CBR script whenever a consumer enquires about that? ","Handle the consumer's dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint ","Did not Make the required statement on time barred accounts ","Adhere to FDCPA laws? ","Did not Make any statement that could be considered discriminatory towards a consumer? ","Did collector stated state compliance disclosures (ex. OOS) ","Did the collectors adhere to the State Restrictions? ","Compliance Score ","Confirm with consumer if he/she is the authorized user of the debit or credit card / checking account? ","Recap the call by verifying consumer's Name ","Stated the proper payment script before processing payment? ","Advise of the payment processing fee before the payment was taken ","Obtain permission from the consumer to initiate electronic credit /debit card transactions or through checking account and get supervisor verification if needed?**SQ** ","Educate the consumer about correspondence being sent (Receipts ","Provide the consumer with the confirmation code? ","Payment Script Score ","Demonstrate Active Listening? ","Represent the company and the client in a positive manner? ","Anticipate and overcome objections? ","Call Control Score ","Summarize the call? ","Provide our Toll free number ","Set appropriate timelines and expectations for follow up? ","Did collector follow proper hold and transfer procedure? ","Close the call Professionally? ","Closing Score ","Use the proper action code? ","Use the proper result code? ","Document thoroughly the context of the conversation? ","Remove any phone numbers known to be incorrect?**SQ** ","Update address information ","Change the status of the account ","Escalate the account to a supervisor for handling if appropriate?/ Escalate the account to a supervisor for handling if appropriate? ","Documentation Score ","Call Summary ","Feedback ","Entry By ","Entry Date ","Client entry by ","Mgnt review by ","Mgnt review note ","Mgnt review date ","Agent review note ","Agent review date ","Client review by ","Client review note ","Client_rvw_date");
		$field_name="SHOW FULL COLUMNS FROM qa_msb_feedback WHERE Comment!=''";
		$field_name=$this->Common_model->get_query_result_array($field_name);
		$fld_cnt=count($field_name);
		for($i=0;$i<$fld_cnt;$i++){
						$val=$field_name[$i]['Field'];
						if($val!=""){
							$field_val[]=$val;
						}		
					 }
		
		array_unshift($field_val ,"auditor_name");
		$key = array_search ('agent_id', $field_val);
		array_splice($field_val, $key, 0, 'fusion_id');
		$field_val=array_values($field_val);

		$count_for_field=count($field_val);

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$row = "";
		// print_r($rr);
		// die;
		foreach($rr as $user)
		{	
			for($z=0;$z<$count_for_field;$z++){
				
				if($field_val[$z]==="auditor_name"){
					$row = '"'.$user['auditor_name'].'",';
				}elseif($field_val[$z]==="fusion_id"){
					$row .= '"'.$user['fusion_id'].'",';
				}elseif($field_val[$z]==="agent_id"){
					$row .= '"'.$user['fname']." ".$user['lname'].'",';
				}elseif($field_val[$z]==="tl_id"){
					$row .= '"'.$user['tl_name'].'",';	
				}elseif(in_array($field_val[$z], array('call_summary','feedback','agent_rvw_note','mgnt_rvw_note'))) {
    			
    			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user[$field_val[$z]])).'",';

				}else{
					$row .= '"'.$user[$field_val[$z]].'",';	
				}
				
			}
				
				fwrite($fopen,$row."\r\n");
				$row = "";
		}
		
		fclose($fopen);
	}	


/////////////////MSB Agent part//////////////////////////	

	public function agent_msb_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_msb/agent_msb_feedback.php";
			$data["agentUrl"] = "qa_msb/agent_msb_feedback";
			
			$from_date = '';
			$to_date = '';
			$cond="";
			
				$qSql="Select count(id) as value from qa_msb_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') and qa_type in ('regular')";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_msb_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')  and qa_type in ('regular')";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
				if($this->input->get('btnView')=='View')
				{
				
					$fromdate = $this->input->get('from_date');
					if($fromdate!="") $from_date = mmddyy2mysql($fromdate);
					
					$todate = $this->input->get('to_date');
					if($todate!="") $to_date = mmddyy2mysql($todate);
					
					if($from_date !=="" && $to_date!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') and qa_type in ('regular')";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') and qa_type in ('regular')";
					}
					
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_msb_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					$data["agent_list"] = $this->Common_model->get_query_result_array($qSql);	
				}else{
					$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') and qa_type in ('regular')";
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_msb_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					$data["agent_list"] = $this->Common_model->get_query_result_array($qSql);
				}
			// print_r($data["agent_list"]);

			// die;
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_msb_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_msb/agent_msb_rvw.php";
			$data["agentUrl"] = "qa_msb/agent_msb_feedback";
			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_msb_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_msb_feedback',$field_array);
				
				redirect('Qa_msb/agent_msb_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
 }