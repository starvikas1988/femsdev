<?php 

 class Qa_viberides extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
	}
	
	private function mt_upload_files($files,$path){
        $config['upload_path'] = $path;
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
	

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_viberides/qa_viberides_feedback.php";
			$data["content_js"] = "qa_viberides_js.php";

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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_viberides_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["msb_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_viberides_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["viberides"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

//////////////////////ADD Audit//////////////////////////////

	public function add_viberides($stratAuditTime){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_viberides/add_viberides.php";
			$data["content_js"] = "qa_viberides_js.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,122) and is_assign_process (id,239) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			$data["stratAuditTime"]=$stratAuditTime;
			$curDateTime=CurrMySqlDate();
			$a = array();

			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_viberides');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_viberides_feedback',$field_array);
				redirect('Qa_viberides');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
/*------------------------- ADD Feedback (NEW) -----------------------------*/
	public function add_edit_viberides($vibe_id)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_viberides/add_edit_viberides.php";
			$data["content_js"] = "qa_viberides_js.php";
			$data['vibe_id']=$vibe_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,122) and is_assign_process(id,239) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_viberides_new_feedback where id='$vibe_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["viberides"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($vibe_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_viberides');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_viberides_new_feedback',$field_array);
					///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_viberides_new_feedback',$add_array);
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $vibe_id);
					$this->db->update('qa_viberides_new_feedback',$field_array1);
				/////////////
					if(get_login_type()=="client"){
						$edit_array = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $vibe_id);
					$this->db->update('qa_viberides_new_feedback',$edit_array);
				}	
				redirect('qa_viberides');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
/*-------------------*/

///////////////////Manegment review///////////////////////////

	public function mgnt_viberides_rvw($id){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_viberides/mgnt_viberides_rvw.php";
			$data["content_js"] = "qa_viberides_js.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,122) and is_assign_process (id,239) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_viberides_feedback where id='$id') xx Left Join
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
				$this->db->where('id', $pnid);
				$this->db->update('qa_viberides_feedback',$field_array);
				
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
				$this->db->update('qa_viberides_feedback',$field_array1);
			///////////	
				redirect('Qa_viberides');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
// ///////////////////////////////////////////////////////////////////////////////////////////	 
// ////////////////////////////////////// QA REPORT //////////////////////////////////////	
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


	public function qa_viberides_report(){

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
			$data["content_template"] = "qa_viberides/qa_viberides_report.php";
			$data["content_js"] = "qa_viberides_js.php";

			$date_from="";
			$date_to="";
			$office_id="";
			$campaign="";
			$action="";
			$dn_link="";
			$dn_link1="";
			$cond1='';
			
			$campaign = $this->input->get('campaign');
			
			$data["qa_viberides_list"] = array();
			
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
				
				if($campaign=='vibe_old'){
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_viberides_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond1 order by audit_date";
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_viberides_list"] = $fullAray;
					$this->create_qa_viberides_new_CSV($fullAray);	
					$dn_link = base_url()."qa_viberides/download_qa_viberides_new_CSV";
				}else if($campaign=='vibe'){
					$qSql="SELECT * from 
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_rvw_by) as client_rvw_name from qa_viberides_new_feedback) xx Left Join 
					(Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond1 order by audit_date";
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_viberides_list"] = $fullAray;
					$this->create_qa_vibe_new_CSV($fullAray);	
					$dn_link = base_url()."qa_viberides/download_qa_vibe_new_CSV";
				}
				
			}
			
			$data['download_link']=$dn_link;
			$data['download_link1']=$dn_link1;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id'] = $office_id;	
			$data['campaign'] = $campaign;	
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_viberides_new_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Viberides New Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function viberides_headerDetails(){
		return $arrayName = array ("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Call Id","Call Date","Call Duration","Audit Type","Auditor Type","VOC","Call Type","Overall Score","Used Customer's Name in Opening","Thank Customer for Contacting","Took Ownership & Assured Resolution","Restated the Customer's Issue","Provided Step-by-Step Resolution","Use of Proper Verbiage","Resolution Provided is Best Resolution","Uses Please and Thank You in response","If follow up needed set appropriate customer expectations","Took Ownership of Ticket and provided First Contact Resolution","Apologized when necessary","Used appropriate verbiage","Referenced KB article or Terms and Conditions","Reviewed Next Steps","Used Correct Closing","Comprehensive Notes","Verify Profile Picture","Verify email address and phone number","Verify and classify car information and pictures","Verify driver's license front/back picture","Verify Insurance Information","Verify State inspection","Verify Vibe Inspection","Dispositioning Background check","Review note on approved profiles before making changes","Detailed notes once entering a driver profile","Marking tickets as resolved/closed incorrectly","Responding with canned response that does not answer/address questions","Not getting clarity from ticket/question from driver/rider before responding","All drivers must be reviewed","Profanity","Dishonesty","Disconnected Without Reason","Incorrect information in ticket response","Not following updates and instructions","Incorrect/Not Filling Property Box","Incomplete answers for questions","Address driver by his/her name/Vibedriver or Viberider","Approving/Declining driver before verified regarding BGC","Changing/Deleting information without authority or justification e.g. Profile Approvals","Not Including KB Link","Not removing watermark in email","Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8","Comments 9","Comments 10","Comments 11","Comments 12","Comments 13","Comments 14","Comments 15","Comments 16","Comments 17","Comments 18","Comments 19","Comments 20","Comments 21","Comments 22","Comments 23","Comments 24","Comments 25","Comments 26","Comments 27","Comments 28","Comments 29","Comments 30","Comments 31","Comments 32","Comments 33","Comments 34","Comments 35","Comments 36","Comments 37","Comments 38","Comments 39","Comments 40","Comments 41","Comments 42","Call Summary","Feedback","Entry By","Entry Date","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent review note","Agent review date","Client review by","Client review note","Client_rvw_date");
	}

	public function create_qa_viberides_new_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");		
		$header=$this->viberides_headerDetails();
		$field_name="SHOW FULL COLUMNS FROM qa_viberides_feedback WHERE Comment!=''";
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

/*--------- NEW Viberides Report ----------*/	
	public function download_qa_vibe_new_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Viberides Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_vibe_new_CSV($rr)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date", "Call Type", "Call ID", "Contact Duration", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score", "Used Customers Name in Opening", "Thank Customer for Contacting", "Took Ownership & Assured Resolution", "Follow-up questions to ensure they understood the problem", "Provided Step-by-Step Resolution", "Information provided is correct", "Use of proper verbiage spelling and grammar", "Reviewed Next Steps", "Used Correct Closing", "Comprehensive Notes", "Verify Profile Picture email address and phone number", "Verify and classify vehicle information and documentation", "Verify drivers license", "Verify vehicle pictures", "Verify Background Check", "Detailed notes once entering a driver profile", "Marking tickets as resolved/closed incorrectly", "Review note on approved profiles before making changes", "Profanity", "Dishonesty", "Disconnected Without Reason", "Incorrect information in ticket response", "Not following updates and instructions", "Incorrect/Not Filling Property Box", "Incomplete answers for questions", "Address driver by his/her nickname/Vibedriver or Viberider", "Approving/Declining driver before verified", "Changing/Deleting information without authority or justification", "Not Including KB Link", "Not removing watermark in email", "GREETING Comment 1", "GREETING Comment 2", "GREETING Comment 3", "SOFT SKILL Comment 1", "SOFT SKILL Comment 2", "SOFT SKILL Comment 3", "SOFT SKILL Comment 4", "SOFT SKILL Comment 5", "SOFT SKILL Comment 6", "SOFT SKILL Comment 7", "BACKOFFICE Comment 1", "BACKOFFICE Comment 2", "BACKOFFICE Comment 3", "BACKOFFICE Comment 4", "BACKOFFICE Comment 5", "BACKOFFICE Comment 6", "BACKOFFICE Comment 7", "BACKOFFICE Comment 8", "AUTOFAILS Comment 1", "AUTOFAILS Comment 2", "AUTOFAILS Comment 3", "AUTOFAILS Comment 4", "AUTOFAILS Comment 5", "AUTOFAILS Comment 6", "AUTOFAILS Comment 7", "AUTOFAILS Comment 8", "AUTOFAILS Comment 9", "AUTOFAILS Comment 10", "AUTOFAILS Comment 11", "AUTOFAILS Comment 12", "Call Summary", "Feedback", "Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
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
			
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['use_customer_name'].'",';
			$row .= '"'.$user['customer_contacting'].'",';
			$row .= '"'.$user['took_ownership'].'",';
			$row .= '"'.$user['followup_question'].'",';
			$row .= '"'.$user['provide_resolution'].'",';
			$row .= '"'.$user['correct_information_provide'].'",';
			$row .= '"'.$user['use_proper_verbiage'].'",';
			$row .= '"'.$user['review_next_step'].'",';
			$row .= '"'.$user['use_correct_closing'].'",';
			$row .= '"'.$user['comprehensive_note'].'",';
			$row .= '"'.$user['verify_profile_picture'].'",';
			$row .= '"'.$user['classify_vehicle'].'",';
			$row .= '"'.$user['verify_driver_license'].'",';
			$row .= '"'.$user['verify_vehicle_picture'].'",';
			$row .= '"'.$user['verify_background_check'].'",';
			$row .= '"'.$user['driver_profile_details'].'",';
			$row .= '"'.$user['making_resolved_ticket'].'",';
			$row .= '"'.$user['approve_changes_profile'].'",';
			$row .= '"'.$user['profanity'].'",';
			$row .= '"'.$user['dishonesty'].'",';
			$row .= '"'.$user['disconected_without_reason'].'",';
			$row .= '"'.$user['incorrect_information'].'",';
			$row .= '"'.$user['not_following_update'].'",';
			$row .= '"'.$user['not_filling_property_box'].'",';
			$row .= '"'.$user['incomplete_answer'].'",';
			$row .= '"'.$user['viberider_driver_address'].'",';
			$row .= '"'.$user['driver_verify_approve_decline'].'",';
			$row .= '"'.$user['changing_information_without_authority'].'",';
			$row .= '"'.$user['not_include_KB_link'].'",';
			$row .= '"'.$user['not_remove_email_watermark'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt30'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);
		
	}


/////////////////Agent part//////////////////////////	

	public function agent_viberides_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_viberides/agent_viberides_feedback.php";
			$data["agentUrl"] = "qa_viberides/agent_viberides_feedback";
			$data["content_js"] = "qa_viberides_js.php";
			
			$from_date = '';
			$to_date = '';
			$cond="";
			
			$qSql="Select count(id) as value from qa_viberides_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_viberides_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') ";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			///////////
			$vibeSql1="Select count(id) as value from qa_viberides_new_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_vibe_fd"] =  $this->Common_model->get_single_value($vibeSql1);
			
			$vibeSql2="Select count(id) as value from qa_viberides_new_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') ";
			$data["yet_vibe_rvw"] =  $this->Common_model->get_single_value($vibeSql2);
			
			if($this->input->get('btnView')=='View')
			{
			
				$fromdate = $this->input->get('from_date');
				if($fromdate!="") $from_date = mmddyy2mysql($fromdate);
				
				$todate = $this->input->get('to_date');
				if($todate!="") $to_date = mmddyy2mysql($todate);
				
				if($from_date !=="" && $to_date!=="" ){ 
					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
				}else{
					$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				}
				
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_viberides_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_list"] = $this->Common_model->get_query_result_array($qSql);
				//////////
				$qSql1 = "SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_viberides_new_feedback $cond) xx Left Join
						(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["vibe_agent_fd"] = $this->Common_model->get_query_result_array($qSql1);
			
			}else{
				
				$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_viberides_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_list"] = $this->Common_model->get_query_result_array($qSql);
				////////
				$qSql1="SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_viberides_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
						(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["vibe_agent_fd"] = $this->Common_model->get_query_result_array($qSql1);
			
			}
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_viberides_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_viberides/agent_viberides_rvw.php";
			$data["agentUrl"] = "qa_viberides/agent_viberides_feedback";
			$data["content_js"] = "qa_viberides_js.php";
			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_viberides_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
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
				$this->db->update('qa_viberides_feedback',$field_array);
				
				redirect('Qa_viberides/agent_viberides_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_vibe_new_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_viberides/agent_vibe_new_rvw.php";
			$data["agentUrl"] = "qa_viberides/agent_viberides_feedback";
			$data["content_js"] = "qa_viberides_js.php";
			
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_viberides_new_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["viberides"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_viberides_new_feedback',$field_array);
				
				redirect('Qa_viberides/agent_viberides_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	
 }