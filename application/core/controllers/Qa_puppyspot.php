<?php 

 class Qa_puppyspot extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	 
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_puppyspot/qa_puppyspot_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,99) and is_assign_process (id,177) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond="";
			
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_puppyspot_pa_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_puppyspot_pa_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_puppyspot_pa_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["qa_puppyspot_pa_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

//////////////////////PuppySpot PA//////////////////////////////
	
	public function add_pa_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_puppyspot/add_pa_feedback.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,99) and is_assign_process (id,177) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('auditor_name')){
				$field_array=array(
					"auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer_id" => $this->input->post('customer_id'),
					"call_id" => $this->input->post('call_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					"correct_greeting" => $this->input->post('correct_greeting'),
					"customer_greeting" => $this->input->post('customer_greeting'),
					"rapport_greeting" => $this->input->post('rapport_greeting'),
					"website_greeting" => $this->input->post('website_greeting'),
					"puppy_greeting" => $this->input->post('puppy_greeting'),
					"excitement_sale" => $this->input->post('excitement_sale'),
					"objection_sale" => $this->input->post('objection_sale'),
					"silence_sale" => $this->input->post('silence_sale'),
					"professional_sale" => $this->input->post('professional_sale'),
					"sound_sale" => $this->input->post('sound_sale'),
					"listening_sale" => $this->input->post('listening_sale'),
					"transfer_closing" => $this->input->post('transfer_closing'),
					"cost_closing" => $this->input->post('cost_closing'),
					"sales_closing" => $this->input->post('sales_closing'),
					"travel_closing" => $this->input->post('travel_closing'),
					"screening_closing" => $this->input->post('screening_closing'),
					"step_closing" => $this->input->post('step_closing'),
					"contact_notation" => $this->input->post('contact_notation'),
					"call_summary" => $this->input->post('call_summary'),
					"opportunity" => $this->input->post('opportunity'),
					"violation_explain" => $this->input->post('violation_explain'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->pa_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_puppyspot_pa_feedback',$field_array);
				redirect('Qa_puppyspot');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function pa_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_puppyspot/puppyspot_pa/';
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
	
	
	public function mgnt_puppysopt_pa_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_puppyspot/mgnt_puppyspot_pa_feedback_rvw.php";
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
			$data['curr_user'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,99) and is_assign_process (id,177) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_puppyspot_pa_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["pa_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["paid"]=$id;
			
			$qSql="Select * FROM qa_puppyspot_pa_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_puppyspot_pa_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('pa_id'))
			{
				$pa_id=$this->input->post('pa_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"auditor_name" => $this->input->post('auditor_name'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer_id" => $this->input->post('customer_id'),
					"call_id" => $this->input->post('call_id'),
					"phone" => $this->input->post('phone'),
					"campaign" => $this->input->post('campaign'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('total_score'),
					"correct_greeting" => $this->input->post('correct_greeting'),
					"customer_greeting" => $this->input->post('customer_greeting'),
					"rapport_greeting" => $this->input->post('rapport_greeting'),
					"website_greeting" => $this->input->post('website_greeting'),
					"puppy_greeting" => $this->input->post('puppy_greeting'),
					"excitement_sale" => $this->input->post('excitement_sale'),
					"objection_sale" => $this->input->post('objection_sale'),
					"silence_sale" => $this->input->post('silence_sale'),
					"professional_sale" => $this->input->post('professional_sale'),
					"sound_sale" => $this->input->post('sound_sale'),
					"listening_sale" => $this->input->post('listening_sale'),
					"transfer_closing" => $this->input->post('transfer_closing'),
					"cost_closing" => $this->input->post('cost_closing'),
					"sales_closing" => $this->input->post('sales_closing'),
					"travel_closing" => $this->input->post('travel_closing'),
					"screening_closing" => $this->input->post('screening_closing'),
					"step_closing" => $this->input->post('step_closing'),
					"contact_notation" => $this->input->post('contact_notation'),
					"call_summary" => $this->input->post('call_summary'),
					"opportunity" => $this->input->post('opportunity'),
					"violation_explain" => $this->input->post('violation_explain'),
					"feedback" => $this->input->post('feedback'),
					"updated_by" => $current_user,
					"updated_date" => $curDateTime
				);
				$this->db->where('id', $pa_id);
				$this->db->update('qa_puppyspot_pa_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $pa_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_puppyspot_pa_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pa_id);
					$this->db->update('qa_puppyspot_pa_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_puppyspot');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////Puppyspot Agent part/////////////////////////////////	

	public function agent_puppyspot_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_puppyspot/agent_puppyspot_feedback.php";
			$data["agentUrl"] = "qa_puppyspot/agent_puppyspot_feedback";
			
			
			$qSql="Select count(id) as value from qa_puppyspot_pa_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_pa_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_puppyspot_pa_feedback where id  not in (select fd_id from qa_puppyspot_pa_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_agent_pa_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_puppyspot_pa_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_puppyspot_pa_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_puppyspot_pa_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
				$data["agent_pa_review_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_puppyspot_pa_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_puppyspot_pa_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_puppyspot_pa_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_puppyspot_pa_agent_rvw)";
				$data["agent_pa_review_list"] = $this->Common_model->get_query_result_array($qSql);	
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_puppysopt_pa_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_puppyspot/agent_puppyspot_pa_feedback_rvw.php";
			$data["agentUrl"] = "qa_puppyspot/agent_puppyspot_feedback";
						
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_puppyspot_pa_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["pa_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["paid"]=$id;
			
			$qSql="Select * FROM qa_puppyspot_pa_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_puppyspot_pa_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
			if($this->input->post('pa_id'))
			{
				$pa_id=$this->input->post('pa_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $pa_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_puppyspot_pa_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pa_id);
					$this->db->update('qa_puppyspot_pa_agent_rvw',$field_array1);
				}	
				redirect('Qa_puppyspot/agent_puppyspot_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////	 
////////////////////////////////////// QA PuppySpot REPORT ////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_puppyspot_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_puppyspot/qa_puppyspot_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_puppyspot_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}
		
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_puppyspot_pa_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_puppyspot_pa_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_puppyspot_pa_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_puppyspot_list"] = $fullAray;
				$this->create_qa_puppyspot_pa_CSV($fullAray);	
				$dn_link = base_url()."qa_puppyspot/download_qa_puppyspot_pa_CSV";
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 
	
//////////////////PuppySpot PA///////////////////
	public function download_qa_puppyspot_pa_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA PuppySpot Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_puppyspot_pa_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Customer ID", "Call Date", "Call ID", "Phone", "Campaign", "Audit Type", "VOC", "Did the PA use correct greeting?", "Did the PA ask the customer for their name?", "Did the PA establish rapport by asking questions?", "Did the PA ask the customer to visit our website?", "Did the PA ask for the puppy of choice and/or recommend a puppy?", "Did the PA build excitement?", "Did the PA offer overcome customers objection?", "Did the PA avoid long silences during the call?", "Did the PA display a professional manner throughout the call?", "Did the PA sounded clear and confident throughout the call?", "Did the PA demonstrate active listening?", "Did the PA set an appointment? Did the PA transferred the call?", "Did the PA confirm the final cost?", "Did the PA complete the Sales recap?", "Did the PA set proper Travel expectations?", "Did the PA ask all screening questions?", "If no sale did the PA define the next steps?", "Did the PA effectively notate the contact?", "Overall Score", "Call Summary", "Opportunities", "Were there any violations in the call?If yes please explain", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			if($user['correct_greeting']==2.1) $correct_greeting='N/A';
			else $correct_greeting=$user['correct_greeting'];
			
			if($user['customer_greeting']==3.1) $customer_greeting='N/A';
			else $customer_greeting=$user['customer_greeting'];
			
			if($user['rapport_greeting']==10.1) $rapport_greeting='N/A';
			else $rapport_greeting=$user['rapport_greeting'];
			
			if($user['website_greeting']==10.1) $website_greeting='N/A';
			else $website_greeting=$user['website_greeting'];
			
			if($user['puppy_greeting']==10.1) $puppy_greeting='N/A';
			else $puppy_greeting=$user['puppy_greeting'];
			
			if($user['excitement_sale']==3.1) $excitement_sale='N/A';
			else $excitement_sale=$user['excitement_sale'];
			
			if($user['objection_sale']==7.1) $objection_sale='N/A';
			else $objection_sale=$user['objection_sale'];
			
			if($user['silence_sale']==3.1) $silence_sale='N/A';
			else $silence_sale=$user['silence_sale'];
			
			if($user['professional_sale']==3.1) $professional_sale='N/A';
			else $professional_sale=$user['professional_sale'];
			
			if($user['sound_sale']==3.1) $sound_sale='N/A';
			else $sound_sale=$user['sound_sale'];
			
			if($user['listening_sale']==5.1) $listening_sale='N/A';
			else $listening_sale=$user['listening_sale'];
			
			if($user['transfer_closing']==10.1) $transfer_closing='N/A';
			else $transfer_closing=$user['transfer_closing'];
			
			if($user['cost_closing']==3.1) $cost_closing='N/A';
			else $cost_closing=$user['cost_closing'];
			
			if($user['sales_closing']==3.1) $sales_closing='N/A';
			else $sales_closing=$user['sales_closing'];
			
			if($user['travel_closing']==5.1) $travel_closing='N/A';
			else $travel_closing=$user['travel_closing'];
			
			if($user['screening_closing']==5.1) $screening_closing='N/A';
			else $screening_closing=$user['screening_closing'];
			
			if($user['step_closing']==5.1) $step_closing='N/A';
			else $step_closing=$user['step_closing'];
			
			if($user['contact_notation']==10.1) $contact_notation='N/A';
			else $contact_notation=$user['contact_notation'];
			
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$correct_greeting.'",'; 
			$row .= '"'.$customer_greeting.'",';
			$row .= '"'.$rapport_greeting.'",';
			$row .= '"'.$website_greeting.'",';
			$row .= '"'.$puppy_greeting.'",';
			$row .= '"'.$excitement_sale.'",';
			$row .= '"'.$objection_sale.'",';
			$row .= '"'.$silence_sale.'",';
			$row .= '"'.$professional_sale.'",';
			$row .= '"'.$sound_sale.'",';
			$row .= '"'.$listening_sale.'",';
			$row .= '"'.$transfer_closing.'",';
			$row .= '"'.$cost_closing.'",';
			$row .= '"'.$sales_closing.'",';
			$row .= '"'.$travel_closing.'",';
			$row .= '"'.$screening_closing.'",';
			$row .= '"'.$step_closing.'",';
			$row .= '"'.$contact_notation.'",';
			$row .= '"'.$user['overall_score'].'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['opportunity'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['violation_explain'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
 }