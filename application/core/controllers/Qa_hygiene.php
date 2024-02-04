<?php 

 class Qa_hygiene extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function hygiene_upload_files($files,$path)
    {
        $config['upload_path'] = $path;
		$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
        $images = array();
        foreach ($files['name'] as $key => $image) {           
			$_FILES['uFiles']['name']= $files['name'][$key];
			$_FILES['uFiles']['type']= $files['type'][$key];
			$_FILES['uFiles']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['uFiles']['error']= $files['error'][$key];
			$_FILES['uFiles']['size']= $files['size'][$key];

            if ($this->upload->do_upload('uFiles')) {
				$info = $this->upload->data();
				$ext = $info['file_ext'];
				$file_path = $info['file_path'];
				$full_path = $info['full_path'];
				$file_name = $info['file_name'];
				if(strtolower($ext)== '.wav'){
					
					$file_name = str_replace(".","_",$file_name).".mp3";
					$new_path = $file_path.$file_name;
					$comdFile=FCPATH."assets/script/wavtomp3.sh '$full_path' '$new_path'";
					$output = shell_exec( $comdFile);
					sleep(2);
				}
				$images[] = $file_name;	
            }else{
                return false;
            }
        }
        return $images;
    }
	
	public function getAgent(){
		if(check_logged_in()){
			$pid=$this->input->post('pid');
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process (id,'$pid') and status=1  order by name";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
////////////////////////////////////////////

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_hygiene/qa_hygiene_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hygiene_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["hygiene"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_hygiene($hygiene_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_hygiene/add_edit_hygiene.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data['hygiene_id']=$hygiene_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="Select s.id, s.fusion_id, s.office_id, s.role_id, s.dept_id, s.status, iap.user_id, iap.process_id, p.id as pid, p.name, p.is_active, o.abbr, o.location from signin s left join info_assign_process iap on s.id=iap.user_id left join process p on p.id=iap.process_id left join office_location o on o.abbr=s.office_id where office_id in ('KOL','HWH','BLR','CHE','MUM','NOI') and role_id in (select id from role where folder ='agent') and dept_id=6 and iap.process_id!=0 and p.is_active=1 group by p.name order by p.name";
			$data["process"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and office_id in ('KOL','HWH','BLR','CHE','MUM','NOI') and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_hygiene_feedback where id='$hygiene_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as p_id, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["hygiene"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"week" => $this->input->post('week'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"guest_call_no" => $this->input->post('guest_call_no'),
					"acpt" => $this->input->post('acpt'),
					"authenticity" => $this->input->post('authenticity'),
					"authenticity_reason" => $this->input->post('authenticity_reason'),
					"calling_reason" => $this->input->post('calling_reason'),
					"l1" => $this->input->post('l1'),
					"l2" => $this->input->post('l2'),
					"audit_type" => $this->input->post('audit_type'),
					"observation" => $this->input->post('observation'),
					"ocop_picth" => $this->input->post('ocop_picth'),
					"urgency" => $this->input->post('urgency'),
					"payment_status" => $this->input->post('payment_status'),
					"fcl_pitch" => $this->input->post('fcl_pitch'),
					"agent_dispo" => $this->input->post('agent_dispo'),
					"correct_dispo" => $this->input->post('correct_dispo'),
					"voc" => $this->input->post('voc'),
					"call_complete_by" => $this->input->post('call_complete_by')
				);
				
				
				if($hygiene_id==0){
					
					$a = $this->hygiene_upload_files($_FILES['attach_file'], $path='./qa_files/qa_hygiene/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_hygiene_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_hygiene_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_hygiene_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $hygiene_id);
					$this->db->update('qa_hygiene_feedback',$field_array);
					/////////
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
					$this->db->where('id', $hygiene_id);
					$this->db->update('qa_hygiene_feedback',$field_array1);
					
				}
				
				redirect('qa_hygiene');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////Agent part/////////////////////////////////	

	public function agent_hygiene_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_hygiene/agent_hygiene_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_hygiene/agent_hygiene_feedback";
			
			
			$qSql="Select count(id) as value from qa_hygiene_feedback where agent_id='$current_user' and authenticity='Valid'";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_hygiene_feedback where agent_id='$current_user' and authenticity='Valid' and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hygiene_feedback $cond and agent_id='$current_user' and authenticity='Valid') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hygiene_feedback where agent_id='$current_user' and authenticity='Valid') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_hygiene_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_hygiene/agent_hygiene_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_hygiene/agent_hygiene_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_hygiene_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["hygiene"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_hygiene_feedback',$field_array1);
					
				redirect('Qa_hygiene/agent_hygiene_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////// 
///////////////////////////////// QA Hygiene REPORT ///////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_hygiene_report(){
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
			$data["content_template"] = "qa_hygiene/qa_hygiene_report.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$qSql="Select s.id, s.fusion_id, s.office_id, s.role_id, s.dept_id, s.status, iap.user_id, iap.process_id, p.id as pid, p.name, p.is_active, o.abbr, o.location from signin s left join info_assign_process iap on s.id=iap.user_id left join process p on p.id=iap.process_id left join office_location o on o.abbr=s.office_id where office_id in ('KOL','HWH','BLR','CHE','MUM','NOI') and role_id in (select id from role where folder ='agent') and dept_id=6 and iap.process_id!=0 and p.is_active=1 group by p.name order by p.name";
			$data["process"] = $this->Common_model->get_query_result_array($qSql);
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$process_id="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_hygiene_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$process_id = $this->input->get('process_id');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
				if($process_id=="All") $cond .= "";
				else $cond .=" and process_id='$process_id'";
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}
		
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_hygiene_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_hygiene_list"] = $fullAray;
				$this->create_qa_hygiene_CSV($fullAray);	
				$dn_link = base_url()."qa_hygiene/download_qa_hygiene_CSV";	
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['process_id']=$process_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_hygiene_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Hygiene Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_hygiene_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Fusion ID", "Name", "Team Leader", "QA", "Call Date", "Audit Date", "Guest Calling number", "Audit Type", "VOC", "OCOP Pitching", "Urgency", "Payment Status", "FCL Pitching", "Audit Start Date/Time", "Audit End Date/Time", "Interval (in sec)", "Authenticity", "Reason", "Call Complete By", "Calling Reason", "ACPT", "L1", "L2", "Agent Disposition", "Correct Disposition", "Observation", "Week");
		
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
			
			$row = '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$auditorName.'",'; 
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['guest_call_no'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['ocop_picth'].'",';
			$row .= '"'.$user['urgency'].'",';
			$row .= '"'.$user['payment_status'].'",';
			$row .= '"'.$user['fcl_pitch'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['authenticity'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['authenticity_reason'])).'",';
			$row .= '"'.$user['call_complete_by'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['calling_reason'])).'",';
			$row .= '"'.$user['acpt'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l1'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['l2'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_dispo'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['correct_dispo'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['observation'])).'",';
			$row .= '"'.$user['week'].'",';
			
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);
	}
	
	
	
 }