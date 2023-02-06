<?php 

 class Qa_metropolis extends CI_Controller{
	
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
			$data["content_template"] = "qa_metropolis/qa_metropolis_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,111) and is_assign_process (id,199) and status=1  order by name";
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_metropolis_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_metropolis_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_metropolis_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["qa_metropolis_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_metropolis/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,111) and is_assign_process (id,199) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from qa_metropolis_disposition where is_active=1";
			$data['metropolis_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				if($this->input->post('call_date_time')==''){
					$call_date_time = CurrMySqlDate();
				}else{
					$call_date_time = mdydt2mysql($this->input->post('call_date_time'));
				}
				
				$field_array=array(
					"audit_date" => CurrDate(),
					"call_date_time" => $call_date_time,
					"call_duration" => $this->input->post('call_duration'),
					"phone" => $this->input->post('phone'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"agent_dispo" => $this->input->post('agent_dispo'),
					"actual_dispo" => $this->input->post('actual_dispo'),
					"customer_voice" => $this->input->post('customer_voice'),
					"overall_score" => $this->input->post('overall_score'),
					"welcome_customer" => $this->input->post('welcome_customer'),
					"welcome_customer_comment" => $this->input->post('welcome_customer_comment'),
					"know_customer" => $this->input->post('know_customer'),
					"know_customer_comment" => $this->input->post('know_customer_comment'),
					"effective_communication" => $this->input->post('effective_communication'),
					"effective_communi_comment" => $this->input->post('effective_communi_comment'),
					"building_rapport" => $this->input->post('building_rapport'),
					"building_rapport_comment" => $this->input->post('building_rapport_comment'),
					"maintain_courtesy" => $this->input->post('maintain_courtesy'),
					"maintain_curtsey_comment" => $this->input->post('maintain_curtsey_comment'),
					"probing_assistance" => $this->input->post('probing_assistance'),
					"probing_assistance_comment" => $this->input->post('probing_assistance_comment'),
					"significance_info" => $this->input->post('significance_info'),
					"significance_info_comment" => $this->input->post('significance_info_comment'),
					"action_solution" => $this->input->post('action_solution'),
					"action_solution_comment" => $this->input->post('action_solution_comment'),
					"proper_docu" => $this->input->post('proper_docu'),
					"proper_docu_comment" => $this->input->post('proper_docu_comment'),
					"zero_tolerance" => $this->input->post('zero_tolerance'),
					"zero_tolerance_comment" => $this->input->post('zero_tolerance_comment'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->mt_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_metropolis_feedback',$field_array);
				redirect('Qa_metropolis');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function mt_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_metropolis/';
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
	
	
	public function mgnt_metropolis_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_metropolis/mgnt_metropolis_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,111) and is_assign_process (id,199) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);	

			$qSql="Select * from qa_metropolis_disposition where is_active=1";
			$data['metropolis_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select disposition from qa_metropolis_disposition as agntdisp where agntdisp.id=agent_dispo) as agentDispo, (select disposition from qa_metropolis_disposition as actldisp where actldisp.id=actual_dispo) as actualDispo from qa_metropolis_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["metropolis_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["mpid"]=$id;
			
			$qSql="Select * FROM qa_metropolis_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_metropolis_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('mp_id'))
			{
				$mp_id=$this->input->post('mp_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"call_date_time" => mdydt2mysql($this->input->post('call_date_time')),
					"call_duration" => $this->input->post('call_duration'),
					"phone" => $this->input->post('phone'),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"agent_dispo" => $this->input->post('agent_dispo'),
					"actual_dispo" => $this->input->post('actual_dispo'),
					"customer_voice" => $this->input->post('customer_voice'),
					"overall_score" => $this->input->post('overall_score'),
					"welcome_customer" => $this->input->post('welcome_customer'),
					"welcome_customer_comment" => $this->input->post('welcome_customer_comment'),
					"know_customer" => $this->input->post('know_customer'),
					"know_customer_comment" => $this->input->post('know_customer_comment'),
					"effective_communication" => $this->input->post('effective_communication'),
					"effective_communi_comment" => $this->input->post('effective_communi_comment'),
					"building_rapport" => $this->input->post('building_rapport'),
					"building_rapport_comment" => $this->input->post('building_rapport_comment'),
					"maintain_courtesy" => $this->input->post('maintain_courtesy'),
					"maintain_curtsey_comment" => $this->input->post('maintain_curtsey_comment'),
					"probing_assistance" => $this->input->post('probing_assistance'),
					"probing_assistance_comment" => $this->input->post('probing_assistance_comment'),
					"significance_info" => $this->input->post('significance_info'),
					"significance_info_comment" => $this->input->post('significance_info_comment'),
					"action_solution" => $this->input->post('action_solution'),
					"action_solution_comment" => $this->input->post('action_solution_comment'),
					"proper_docu" => $this->input->post('proper_docu'),
					"proper_docu_comment" => $this->input->post('proper_docu_comment'),
					"zero_tolerance" => $this->input->post('zero_tolerance'),
					"zero_tolerance_comment" => $this->input->post('zero_tolerance_comment'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $mp_id);
				$this->db->update('qa_metropolis_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $mp_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_metropolis_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $mp_id);
					$this->db->update('qa_metropolis_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_metropolis');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////Agent part/////////////////////////////////	

	public function agent_metropolis_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_metropolis/agent_metropolis_feedback.php";
			$data["agentUrl"] = "qa_metropolis/agent_metropolis_feedback";
			
			
			$qSql="Select count(id) as value from qa_metropolis_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_metropolis_feedback where id not in (select fd_id from qa_metropolis_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_metropolis_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_metropolis_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_metropolis_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_metropolis_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_metropolis_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_metropolis_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_metropolis_agent_rvw)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_metropolis_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_metropolis/agent_metropolis_rvw.php";
			$data["agentUrl"] = "qa_metropolis/agent_metropolis_feedback";
			
			$qSql="Select * from qa_metropolis_disposition where is_active=1";
			$data['metropolis_dispo'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select disposition from qa_metropolis_disposition as agntdisp where agntdisp.id=agent_dispo) as agentDispo, (select disposition from qa_metropolis_disposition as actldisp where actldisp.id=actual_dispo) as actualDispo from qa_metropolis_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["metropolis_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["mpid"]=$id;
			
			$qSql="Select * FROM qa_metropolis_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_metropolis_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
			if($this->input->post('mp_id'))
			{
				$mp_id=$this->input->post('mp_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $mp_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_metropolis_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $pa_id);
					$this->db->update('qa_metropolis_agent_rvw',$field_array1);
				}	
				redirect('Qa_metropolis/agent_metropolis_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id,get_process_ids(id)as process_id, get_process_names(id) as process_name, office_id, DATEDIFF(CURDATE(), doj) as tenure FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////	 
////////////////////////////////////// QA Metropolis REPORT //////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_metropolis_report(){
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
			$data["content_template"] = "qa_metropolis/qa_metropolis_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_metropolis_list"] = array();
			
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select disposition from qa_metropolis_disposition as agntdisp where agntdisp.id=agent_dispo) as agentDispo, (select disposition from qa_metropolis_disposition as actldisp where actldisp.id=actual_dispo) as actualDispo from qa_metropolis_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_metropolis_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_metropolis_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_metropolis_list"] = $fullAray;
				$this->create_qa_metropolis_CSV($fullAray);	
				$dn_link = base_url()."qa_metropolis/download_qa_metropolis_CSV";
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_metropolis_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Metropolis Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_metropolis_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Call Date/Time", "Call Duration", "Phone", "Campaign", "Audit Type", "VOC", "Agent Disposition", "Actual Disposition", "Customer Voice", "Welcome the Customer", "Know the Customer", "Effective Communication", "Building Rapport", "Maintain Courtesy", "Probing Assistance", "Significance of Information", "Action for Solution", "Proper Documentation", "ZTP", "Welcome the Customer Comment", "Know the Customer Comment", "Effective Communication Comment", "Building Rapport Comment", "Maintain Courtesy Comment", "Probing Assistance Comment", "Significance of Information Comment", "Action for Solution Comment", "Proper Documentation Comment", "ZTP Comment", "Overall Score", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['welcome_customer']==5) $welcome_customer='100%';
			else $welcome_customer='0%';
			
			if($user['know_customer']==5) $know_customer='100%';
			else $know_customer='0%';
			
			if($user['effective_communication']==10) $effective_communication='100%';
			else $effective_communication='0%';
			
			if($user['building_rapport']==15) $building_rapport='100%';
			else $building_rapport='0%';
			
			if($user['maintain_courtesy']==10) $maintain_courtesy='100%';
			else $maintain_courtesy='0%';
			
			if($user['probing_assistance']==10) $probing_assistance='100%';
			else $probing_assistance='0%';
			
			if($user['significance_info']==20) $significance_info='100%';
			else $significance_info='0%';
			
			if($user['action_solution']==15) $action_solution='100%';
			else $action_solution='0%';
			
			if($user['proper_docu']==10) $proper_docu='100%';
			else $proper_docu='0%';
			
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",'; 
			$row .= '"'.$user['call_date_time'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['campaign'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['agentDispo'].'",';
			$row .= '"'.$user['actualDispo'].'",';
			$row .= '"'.$user['customer_voice'].'",';
			$row .= '"'.$welcome_customer.'",'; 
			$row .= '"'.$know_customer.'",'; 
			$row .= '"'.$effective_communication.'",'; 
			$row .= '"'.$building_rapport.'",'; 
			$row .= '"'.$maintain_courtesy.'",'; 
			$row .= '"'.$probing_assistance.'",'; 
			$row .= '"'.$significance_info.'",'; 
			$row .= '"'.$action_solution.'",'; 
			$row .= '"'.$proper_docu.'",'; 
			$row .= '"'.$user['zero_tolerance'].'",';
			$row .= '"'.$user['welcome_customer_comment'].'",';
			$row .= '"'.$user['know_customer_comment'].'",';
			$row .= '"'.$user['effective_communi_comment'].'",';
			$row .= '"'.$user['building_rapport_comment'].'",';
			$row .= '"'.$user['maintain_curtsey_comment'].'",';
			$row .= '"'.$user['probing_assistance_comment'].'",';
			$row .= '"'.$user['significance_info_comment'].'",';
			$row .= '"'.$user['action_solution_comment'].'",';
			$row .= '"'.$user['proper_docu_comment'].'",';
			$row .= '"'.$user['zero_tolerance_comment'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",'; 
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
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