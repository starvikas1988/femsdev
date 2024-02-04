<?php 
 class Qa_entice_energy extends CI_Controller{
	
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
			$data["content_template"] = "qa_entice_energy/qa_entice_energy_feedback.php";
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
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
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where assigned_to='$current_user'";
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_entice_energy_feedback $cond) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["entice_energy_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_entice_energy/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,138) and is_assign_process (id,283) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer_name" => $this->input->post('customer_name'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"week_end_date" => mmddyy2mysql($this->input->post('week_end_date')),
					"call_type" => $this->input->post('call_type'),
					"customer_phone" => $this->input->post('customer_phone'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"agentstatesname" => $this->input->post('agentstatesname'),
					"cofirmspeakingtoDMC" => $this->input->post('cofirmspeakingtoDMC'),
					"goldenaccountdetails" => $this->input->post('goldenaccountdetails'),
					"customerprovide1stline" => $this->input->post('customerprovide1stline'),
					"customertakepartinWHD" => $this->input->post('customertakepartinWHD'),
					"confirmsigleduelFuel" => $this->input->post('confirmsigleduelFuel'),
					"tariffprobed3times" => $this->input->post('tariffprobed3times'),
					"askedsufficientquestion" => $this->input->post('askedsufficientquestion'),
					"customerhaveSmartmeter" => $this->input->post('customerhaveSmartmeter'),
					"economy7checked" => $this->input->post('economy7checked'),
					"customerhasanydebt" => $this->input->post('customerhasanydebt'),
					"agentgavebesttariff" => $this->input->post('agentgavebesttariff'),
					"agentgavefuturespend" => $this->input->post('agentgavefuturespend'),
					"dailystandingcharges_C3a" => $this->input->post('dailystandingcharges_C3a'),
					"VATstatement_C3b" => $this->input->post('VATstatement_C3b'),
					"cancelletionfees_C4a" => $this->input->post('cancelletionfees_C4a'),
					"SPcancelletionfees_C4b" => $this->input->post('SPcancelletionfees_C4b'),
					"verifycustomerbankaccount" => $this->input->post('verifycustomerbankaccount'),
					"reconfirmaccountnumber" => $this->input->post('reconfirmaccountnumber'),
					"receiveconfirmpayment" => $this->input->post('receiveconfirmpayment'),
					"directdebitmandate" => $this->input->post('directdebitmandate'),
					"correctT&Cneed" => $this->input->post('correctT&Cneed'),
					"agentreadcontactnumber" => $this->input->post('agentreadcontactnumber'),
					"signupScriptingread" => $this->input->post('signupScriptingread'),
					"honestwithcustomer" => $this->input->post('honestwithcustomer'),
					"potentialVulnerability_G1a" => $this->input->post('potentialVulnerability_G1a'),
					"priorityVulnerability_G1b" => $this->input->post('priorityVulnerability_G1b'),
					"takeappropriateaction" => $this->input->post('takeappropriateaction'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				$a = $this->mt_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_entice_energy_feedback',$field_array); 
				redirect('Qa_entice_energy');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function mt_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_entice_energy/';
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
	
	
	public function mgnt_entice_energy_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_entice_energy/mgnt_entice_energy_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,138) and is_assign_process (id,283) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_entice_energy_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["enticeEnergy"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"customer_name" => $this->input->post('customer_name'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"week_end_date" => mmddyy2mysql($this->input->post('week_end_date')),
					"call_type" => $this->input->post('call_type'),
					"customer_phone" => $this->input->post('customer_phone'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"agentstatesname" => $this->input->post('agentstatesname'),
					"cofirmspeakingtoDMC" => $this->input->post('cofirmspeakingtoDMC'),
					"goldenaccountdetails" => $this->input->post('goldenaccountdetails'),
					"customerprovide1stline" => $this->input->post('customerprovide1stline'),
					"customertakepartinWHD" => $this->input->post('customertakepartinWHD'),
					"confirmsigleduelFuel" => $this->input->post('confirmsigleduelFuel'),
					"tariffprobed3times" => $this->input->post('tariffprobed3times'),
					"askedsufficientquestion" => $this->input->post('askedsufficientquestion'),
					"customerhaveSmartmeter" => $this->input->post('customerhaveSmartmeter'),
					"economy7checked" => $this->input->post('economy7checked'),
					"customerhasanydebt" => $this->input->post('customerhasanydebt'),
					"agentgavebesttariff" => $this->input->post('agentgavebesttariff'),
					"agentgavefuturespend" => $this->input->post('agentgavefuturespend'),
					"dailystandingcharges_C3a" => $this->input->post('dailystandingcharges_C3a'),
					"VATstatement_C3b" => $this->input->post('VATstatement_C3b'),
					"cancelletionfees_C4a" => $this->input->post('cancelletionfees_C4a'),
					"SPcancelletionfees_C4b" => $this->input->post('SPcancelletionfees_C4b'),
					"verifycustomerbankaccount" => $this->input->post('verifycustomerbankaccount'),
					"reconfirmaccountnumber" => $this->input->post('reconfirmaccountnumber'),
					"receiveconfirmpayment" => $this->input->post('receiveconfirmpayment'),
					"directdebitmandate" => $this->input->post('directdebitmandate'),
					" correctT&Cneed" => $this->input->post(' correctT&Cneed'),
					"agentreadcontactnumber" => $this->input->post('agentreadcontactnumber'),
					"signupScriptingread" => $this->input->post('signupScriptingread'),
					"honestwithcustomer" => $this->input->post('honestwithcustomer'),
					"potentialVulnerability_G1a" => $this->input->post('potentialVulnerability_G1a'),
					"priorityVulnerability_G1b" => $this->input->post('priorityVulnerability_G1b'),
					"takeappropriateaction" => $this->input->post('takeappropriateaction'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
				//////////
					"mgnt_rvw_note" => $this->input->post('note'),
					"mgnt_rvw_by" => $current_user,
					"mgnt_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_entice_energy_feedback',$field_array);
				redirect('Qa_entice_energy');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////Agent part/////////////////////////////////	

	public function agent_entice_energy_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_entice_energy/agent_entice_energy_feedback.php";
			$data["agentUrl"] = "qa_entice_energy/agent_entice_energy_feedback";
			
			
			$qSql="Select count(id) as value from qa_entice_energy_feedback where agent_id='$current_user' And audit_type!='Calibration'";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_entice_energy_feedback Where agent_rvw_date is null And audit_type!='Calibration' And agent_id='$current_user'";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from 
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_entice_energy_feedback $cond and agent_id='$current_user' And audit_type!='Calibration') xx Left Join 
				(Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql = "SELECT * from 
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_entice_energy_feedback Where agent_id='$current_user' And audit_type!='Calibration') xx Left Join 
				(Select id as sid, fname, lname, fusion_id from signin) yy on (xx.agent_id=yy.sid) where xx.agent_rvw_date is null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
				
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_entice_energy_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_entice_energy/agent_entice_energy_rvw.php";
			$data["agentUrl"] = "qa_entice_energy/agent_entice_energy_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_entice_energy_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["enticeEnergy"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_entice_energy_feedback',$field_array1);
				redirect('Qa_entice_energy/agent_entice_energy_feedback');
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////// 
//////////////////////////////// QA Entice Energy REPORT ////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_entice_energy_report(){
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
			$data["content_template"] = "qa_entice_energy/qa_entice_energy_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["entice_energy_list"] = array();
			
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_rvw_by) as client_rvw_name from qa_entice_energy_feedback) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["entice_energy_list"] = $fullAray;
				$this->create_qa_entice_energy_CSV($fullAray);	
				$dn_link = base_url()."qa_entice_energy/download_qa_entice_energy_CSV";
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_entice_energy_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Entice Energy List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_entice_energy_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Agent", "L1 Super", "Call Date", "Customer Name", "Week End Date", "Call Type", "Customer Phone", "Audit Type", "VOC", "Overall Score", "Earned Score", "Possible Score", "Agent states name", "Confirmation that speaking to DMC", "Golden Account details confirmed Customers", "Customer to provide first line", "Did agent ask if customer takes part in the WHD", "Confirm Single/ Duel Fuel", "Tariff probed 3 times", "Have you asked sufficient questions to accurately", "Does the customer have a Smart Meter?", "Economy 7 checked and caller advised correctly?", "Confirm if customer has any debt?", "Did agent give Entice Energy", "Did agent give current and future spends?", "C3a Daily standing charge & unit rates provided in full", "C3b VAT Statement customer advised comparison", "C4a Customer advised if cancellation fees", "C4b Customer advised of SP cancellation fees", "Verify that the customer is the named bank", "Obtained & reconfirmed the account number", "Advised that they will receive confirmation of payments", "Informed that the direct debit mandate", "T&Cs read correctly?", "Did agent read contact number", "Sign up scripting read and clear", "Was the agent open honest and transparent", "G1a Did the agent recognise signs of potential vulnerability", "G1b Did the agent ask the Vulnerability Priority", "Did the agent take appropriate action act accordingly", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review By", "Client Review Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['customer_name'].'",';
			$row .= '"'.$user['week_end_date'].'",';
			$row .= '"'.$user['call_type'].'",';
			$row .= '"'.$user['customer_phone'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['agentstatesname'].'",';
			$row .= '"'.$user['cofirmspeakingtoDMC'].'",';
			$row .= '"'.$user['goldenaccountdetails'].'",';
			$row .= '"'.$user['customerprovide1stline'].'",';
			$row .= '"'.$user['customertakepartinWHD'].'",';
			$row .= '"'.$user['confirmsigleduelFuel'].'",';
			$row .= '"'.$user['tariffprobed3times'].'",';
			$row .= '"'.$user['askedsufficientquestion'].'",';
			$row .= '"'.$user['customerhaveSmartmeter'].'",';
			$row .= '"'.$user['economy7checked'].'",';
			$row .= '"'.$user['customerhasanydebt'].'",';
			$row .= '"'.$user['agentgavebesttariff'].'",';
			$row .= '"'.$user['agentgavefuturespend'].'",';
			$row .= '"'.$user['dailystandingcharges_C3a'].'",';
			$row .= '"'.$user['VATstatement_C3b'].'",';
			$row .= '"'.$user['cancelletionfees_C4a'].'",';
			$row .= '"'.$user['SPcancelletionfees_C4b'].'",';
			$row .= '"'.$user['verifycustomerbankaccount'].'",';
			$row .= '"'.$user['reconfirmaccountnumber'].'",';
			$row .= '"'.$user['receiveconfirmpayment'].'",';
			$row .= '"'.$user['directdebitmandate'].'",';
			$row .= '"'.$user['correctT&Cneed'].'",';
			$row .= '"'.$user['agentreadcontactnumber'].'",';
			$row .= '"'.$user['signupScriptingread'].'",';
			$row .= '"'.$user['honestwithcustomer'].'",';
			$row .= '"'.$user['potentialVulnerability_G1a'].'",';
			$row .= '"'.$user['priorityVulnerability_G1b'].'",';
			$row .= '"'.$user['takeappropriateaction'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
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
	
	
 }
 ?>