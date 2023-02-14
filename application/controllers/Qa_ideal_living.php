<?php 

 class Qa_ideal_living extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Common_model');
	}
	
	
	private function il_upload_files($files,$path)
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
	
//////////////////// SALES ///////////////////////////	
//////
	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/qa_il_sales_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$tl_mgnt_cond="";
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,79) and (is_assign_process (id,209) or is_assign_process (id,210)) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond="";
			$ops_cond="";
			
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
			if($agent_id != "") $cond .= " and agent_id='$agent_id'";
			
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ideal_living_sales_feedback $cond) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["sales_data"] = $this->Common_model->get_query_result_array($qSql);

			$qSql2 = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_il_sales_verification_feedback $cond) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["sales_datas"] = $this->Common_model->get_query_result_array($qSql2);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_sales($sales_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/add_edit_sales.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data['sales_id']=$sales_id;
			$tl_mgnt_cond='';
			
			$tl_mgnt_cond=""; 
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,79) and (is_assign_process (id,209) or is_assign_process (id,210)) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ideal_living_sales_feedback where id='$sales_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["sales_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"product" => $this->input->post('product'),
					"call_type" => $this->input->post('call_type'),
					"can_automated" => $this->input->post('can_automated'),
					"qa_type" => $this->input->post('qa_type'),
					"disposition" => $this->input->post('disposition'),
					"recording_id" => $this->input->post('recording_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"correct_disposition" => $this->input->post('correct_disposition'),
					"auto_fail" => $this->input->post('auto_fail'),
					"overall_score" => $this->input->post('overall_score'),
					"greeting" => $this->input->post('greeting'),
					"probing_question" => $this->input->post('probing_question'),
					"product_benefit" => $this->input->post('product_benefit'),
					"rapport" => $this->input->post('rapport'),
					"product_knowledge" => $this->input->post('product_knowledge'),
					"speed_clarity" => $this->input->post('speed_clarity'),
					"professional_ethics" => $this->input->post('professional_ethics'),
					"passion_selling" => $this->input->post('passion_selling'),
					"acknowledge" => $this->input->post('acknowledge'),
					"build_value" => $this->input->post('build_value'),
					"sale_close" => $this->input->post('sale_close'),
					"close_the_sale" => $this->input->post('close_the_sale'),
					"rebuttals" => $this->input->post('rebuttals'),
					"main_offers" => $this->input->post('main_offers'),
					"upsell_compliance" => $this->input->post('upsell_compliance'),
					"prepays_compliance" => $this->input->post('prepays_compliance'),
					"third_party_separation" => $this->input->post('third_party_separation'),
					"legal_terms" => $this->input->post('legal_terms'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($sales_id==0){
					
					$a = $this->il_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ideal_living/sales/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_ideal_living_sales_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_ideal_living_sales_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ideal_living_sales_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $sales_id);
					$this->db->update('qa_ideal_living_sales_feedback',$field_array);
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
					$this->db->where('id', $sales_id);
					$this->db->update('qa_ideal_living_sales_feedback',$field_array1);
					
				}
				
				redirect('qa_ideal_living');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
////////////////////// Sales Verification (saqlan) ///////////////////////////
	public function add_edit_sales_feedback($sales_id=""){
		if(check_logged_in())
		{
			
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/qa_il_sales_feedback_form.php";
			$data["content_js"] = "qa_metropolis_js.php";	
			$data['sales_id']=$sales_id;
			$tl_mgnt_cond='';
			
			$tl_mgnt_cond=""; 
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,79) and (is_assign_process (id,209) or is_assign_process (id,210)) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_il_sales_verification_feedback where id='$sales_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["sales_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"product" => $this->input->post('product'),
					// "call_type" => $this->input->post('call_type'),
					// "qa_type" => $this->input->post('qa_type'),
					"disposition" => $this->input->post('disposition'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"greeting" => $this->input->post('greeting'),
					"wrong_disposition" => $this->input->post('wrong_disposition'),
					"correct_disposition" => $this->input->post('correct_disposition'),

					// "probing_question" => $this->input->post('probing_question'),
					// "product_benefit" => $this->input->post('product_benefit'),
					// "rapport" => $this->input->post('rapport'),
					// "product_knowledge" => $this->input->post('product_knowledge'),
					// "speed_clarity" => $this->input->post('speed_clarity'),
					// "professional_ethics" => $this->input->post('professional_ethics'),
					// "passion_selling" => $this->input->post('passion_selling'),
					// "acknowledge" => $this->input->post('acknowledge'),
					// "build_value" => $this->input->post('build_value'),
					// "sale_close" => $this->input->post('sale_close'),
					// "close_the_sale" => $this->input->post('close_the_sale'),
					// "rebuttals" => $this->input->post('rebuttals'),
					// "main_offers" => $this->input->post('main_offers'),
					// "upsell_compliance" => $this->input->post('upsell_compliance'),
					// "prepays_compliance" => $this->input->post('prepays_compliance'),
					// "third_party_separation" => $this->input->post('third_party_separation'),
					// "legal_terms" => $this->input->post('legal_terms'),
					// "call_summary" => $this->input->post('call_summary'),
					// "feedback" => $this->input->post('feedback')
				);
				
				
				if($sales_id==0){
					// print_r($_POST);
					// exit();
					
					// $a = $this->il_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ideal_living/sales/');
					// $field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_il_sales_verification_feedback',$field_array);
					/////////
					
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_il_sales_verification_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_il_sales_verification_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $sales_id);
					$this->db->update('qa_il_sales_verification_feedback',$field_array);
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
					$this->db->where('id', $sales_id);
					$this->db->update('qa_il_sales_verification_feedback',$field_array1);
					
				}
				
				redirect('qa_ideal_living');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
//////////////////// Customer Service ///////////////////////////	
//////


///////////////////////// MERCY SHIP START ///////////////////////////////
	public function serviceName(){
		return "mercy";
	}

	public function mercy(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/qa_".$this->serviceName()."_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["page"]=$this->serviceName();
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and ((is_assign_client(id,79) and is_assign_process(id,210)) or (is_assign_client(id,134))) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
		////////////////////////	
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				if(get_user_fusion_id()=='FSPI000026' || get_user_fusion_id()=='FMIN000011'){
					$ops_cond="";
				}else{
					$ops_cond=" Where assigned_to='$current_user'";
				}
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$this->serviceName()."_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			//echo $qSql;
			
			$data[$this->serviceName()."_new_data"] = $this->Common_model->get_query_result_array($qSql);
		
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}


	public function process($parm="",$formparam=""){
		if ($parm=="add") {
			$this->add_process($formparam);
		}elseif ($parm=="mgnt_rvw") {
			$this->mgnt_process_rvw($formparam);
		}elseif($parm=="agent"){
			$this->agent_il_sales_feedback();
		}elseif($parm=="agnt_feedback"){
			$this->agent_process_rvw($formparam);
		}
	}


	public function add_process($stratAuditTime){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/add_".$this->serviceName().".php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["page"]=$this->serviceName();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and ((is_assign_client(id,79) and is_assign_process(id,210)) or (is_assign_client(id,134))) and status=1  order by name";
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
				$a = $this->mt_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_'.$this->serviceName().'_feedback',$field_array);
				redirect('Qa_ideal_living/'.$this->serviceName());
				
				//$this->db->insert('qa_'.$this->serviceName().'_feedback',$field_array);
				//print_r($this->db->last_query());
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function mt_upload_files($files){
        $config['upload_path'] = './qa_files/qa_ideal_living/'.$this->serviceName();
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


	public function mgnt_process_rvw($id){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/mgnt_".$this->serviceName()."_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["page"]=$this->serviceName();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and ((is_assign_client(id,79) and is_assign_process(id,210)) or (is_assign_client(id,134))) and status=1  order by name";
			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$this->serviceName()."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data[$this->serviceName()."_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=$this->input->post('data');
				$this->db->where('id', $pnid);
				$this->db->update('qa_'.$this->serviceName().'_feedback',$field_array);
				
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
				$this->db->update('qa_'.$this->serviceName().'_feedback',$field_array1);
			///////////	
				redirect('Qa_ideal_living/'.$this->serviceName());
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_process_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/agent_".$this->serviceName()."_rvw.php";
			$data["agentUrl"] = "qa_ideal_living/agent_process_feedback";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["page"]=$this->serviceName();
						
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_".$this->serviceName()."_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data[$this->serviceName()."_agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_'.$this->serviceName().'_feedback',$field_array);
				
				redirect('qa_ideal_living/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
//////////////// MERCY SHIP END ////////////////////////////////
	
/////////// agent verification review //////////
	public function agent_verification_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/agent_verification_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_ideal_living/agent_verification_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_il_sales_verification_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["sales_data"] = $this->Common_model->get_query_row_array($qSql);

			$data["salesid"]=$id;
		
			if($this->input->post('salesid'))
			{
				$salesid=$this->input->post('salesid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $salesid);
				$this->db->update('qa_il_sales_verification_feedback',$field_array1);	
				redirect('qa_ideal_living/agent_il_sales_feedback');
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	

	public function il_cs(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/qa_il_cs_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$tl_mgnt_cond="";
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,79) and is_assign_process (id,99) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond="";
			$ops_cond="";
			
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
			if($agent_id != "") $cond .= " and agent_id='$agent_id'";
			
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ideal_living_cs_new_feedback $cond) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["sales_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_cs($sales_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/add_edit_cs.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data['sales_id']=$sales_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,79) and is_assign_process (id,99) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ideal_living_cs_new_feedback where id='$sales_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["sales_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"product" => $this->input->post('product'),
					"call_type" => $this->input->post('call_type'),
					"geography" => $this->input->post('geography'),
					"can_automated" => $this->input->post('can_automated'),
					"qa_type" => $this->input->post('qa_type'),
					"disposition" => $this->input->post('disposition'),
					"recording_id" => $this->input->post('recording_id'),
					"order_accnt" => $this->input->post('order_accnt'),
					"correct_disposition" => $this->input->post('correct_disposition'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"autofail" => $this->input->post('autofail'),
					"overall_score" => $this->input->post('overall_score'),
					"agent_greets_the_customer" => $this->input->post('agent_greets_the_customer'),
					"the_agent_verified" => $this->input->post('the_agent_verified'),
					"the_agent_understands" => $this->input->post('the_agent_understands'),
					"agent_is_attentive" => $this->input->post('agent_is_attentive'),
					"agent_ends_the_call" => $this->input->post('agent_ends_the_call'),
					"agent_builds_personal" => $this->input->post('agent_builds_personal'),
					"agent_an_expert" => $this->input->post('agent_an_expert'),
					"agent_speaks_with" => $this->input->post('agent_speaks_with'),
					"agent_always_respects" => $this->input->post('agent_always_respects'),
					"agent_sounds_happy" => $this->input->post('agent_sounds_happy'),
					"agents_chooses_correct" => $this->input->post('agents_chooses_correct'),
					"agent_correctly_performs" => $this->input->post('agent_correctly_performs'),
					"agent_properly_gives" => $this->input->post('agent_properly_gives'),
					"agent_an_expert" => $this->input->post('agent_an_expert'),
					"agent_solved_customer" => $this->input->post('agent_solved_customer'),
					"agent_asks_the_correct" => $this->input->post('agent_asks_the_correct'),
					"agents_explains_product" => $this->input->post('agents_explains_product'),
					"agent_an_expert_processes" => $this->input->post('agent_an_expert_processes'),
					"agents_makes_offers" => $this->input->post('agents_makes_offers'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($sales_id==0){
					
					$a = $this->il_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ideal_living/cs/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_ideal_living_cs_new_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_ideal_living_cs_new_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ideal_living_cs_new_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $sales_id);
					$this->db->update('qa_ideal_living_cs_new_feedback',$field_array);
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
					$this->db->where('id', $sales_id);
					$this->db->update('qa_ideal_living_cs_new_feedback',$field_array1);
					
				}
				
				redirect('qa_ideal_living/il_cs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/////////////////////////Agent part/////////////////////////////////	
	public function agent_il_sales_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/agent_il_sales_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_ideal_living/agent_il_sales_feedback";
			
			
			$qSql="Select count(id) as value from qa_ideal_living_sales_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_mercy_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback_mercy"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_il_sales_verification_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback_verification"] =  $this->Common_model->get_single_value($qSql);
		////////////////
			$qSql="Select count(id) as value from qa_ideal_living_sales_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_mercy_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_rvw_mercy"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_il_sales_verification_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_rvw_verification"] =  $this->Common_model->get_single_value($qSql);
				
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
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ideal_living_sales_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			/////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_il_sales_verification_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list_verification"] = $this->Common_model->get_query_result_array($qSql);
			////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_mercy_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list_mercy"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ideal_living_sales_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			/////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_il_sales_verification_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list_verification"] = $this->Common_model->get_query_result_array($qSql);
			/////////
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_mercy_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list_mercy"] = $this->Common_model->get_query_result_array($qSql);
	
			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_il_sales_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/agent_il_sales_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_ideal_living/agent_il_sales_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_ideal_living_sales_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["sales_data"] = $this->Common_model->get_query_row_array($qSql);

			$data["salesid"]=$id;
		
			if($this->input->post('salesid'))
			{
				$salesid=$this->input->post('salesid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $salesid);
				$this->db->update('qa_ideal_living_sales_feedback',$field_array1);	
				redirect('Qa_ideal_living/agent_il_sales_feedback');
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
//////////////////
	public function agent_il_cs_feedback(){
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/agent_il_cs_feedback.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_ideal_living/agent_il_cs_feedback";
			
			
			$qSql="Select count(id) as value from qa_ideal_living_cs_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_ideal_living_cs_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
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
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ideal_living_cs_new_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ideal_living_cs_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_il_cs_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ideal_living/agent_il_cs_rvw.php";
			$data["content_js"] = "qa_metropolis_js.php";
			$data["agentUrl"] = "qa_ideal_living/agent_il_cs_feedback";
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_ideal_living_cs_new_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["cs_data"] = $this->Common_model->get_query_row_array($qSql);

			$data["csid"]=$id;
		
			if($this->input->post('csid'))
			{
				$csid=$this->input->post('csid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $csid);
				$this->db->update('qa_ideal_living_cs_new_feedback',$field_array1);	
				redirect('Qa_ideal_living/agent_il_cs_feedback');
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////// 
/////////////////////////////// QA Ideal Living REPORT //////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_il_report(){
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
			$data["content_template"] = "qa_ideal_living/qa_il_report.php";
			$data["content_js"] = "qa_metropolis_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$process="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$process = $this->input->get('process');
			
			$data["qa_il_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_ideal_living_".$process."_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_il_list"] = $fullAray;
				$this->create_qa_il_CSV($fullAray,$process);	
				$dn_link = base_url()."qa_ideal_living/download_qa_il_CSV/".$process;
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['process']=$process;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_il_CSV($process)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$process." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_il_CSV($rr,$process)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($process=='sales'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "TL", "Call Date", "Call Duration", "Call Type", "Can be Automated", "Product", "QA Type", "Disposition", "Recording ID", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Auto Fail","Overall Score", "Greeting", "Probing Question", "Product Benefit", "Closing the Sales", "Rebuttals", "Rapport Empathy", "Product Knowledge", "Speed Clarity", "Professional ethics Emotional Intelligence", "Enthusiasm Passion About Selling", "Main Offers Compliance", "Upsells Compliance", "Prepays / Platinum", "Legal Terms Confirmation Compliance", "Third party separation Compliance", "Acknowledge", "Build Value", "Close the Sale", "Call Summary", "Feedback", "Agent Review Date", "Agent Feedback Acceptance", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($process=='cs_new'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "TL", "Call Date", "Call Duration", "Product", "Call Type", "Can be Automated", "QA Type", "Disposition", "Recording ID", "Order/Acct Number", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Auto Fail", "Overall Score","The agent greets the customer with a happy and friendly tone of voice mentions his name the name of the company and offers his help.","The agent verified the customers account using the appropriate information (name and surname address city state and zip code)","The agent understands perfectly the reason for the call. The agent summarized the main points of the client before solving problems or offering a solution listens to the customer issue this is done in a tone of Helpful voice without sounding rude.","Agent is attentive to callers questions or queries and shows understanding of the matter mentioned by caller.","The agent ends the call confirming the final Status of his call. The agent offers further assistance before finalizing the call. The agent thanks the customer for communicating. The agent mentions the companys name. The agent does everything with a good and understandable tone of voice and attitude of service.","Agent builds a personal relationship with the caller like talking to a friend creates interest and trust. And provides and emotional connection by letting the caller know they understand the callers feelings","The agent is an expert with the product knowledge and FAQ. Answers all questions accurately and educates the caller.","The agent speaks with a strong steady speed or pace. Not to Fast and Not to Slow and The agent voice is clear and can be understood throughout the call.","The agent always respects and listens to the caller and does not interrupt the caller. The agent is honest and ethical. Controls their emotions and is not rude to the caller.","The agent sounds happy and excited and has energy when speaking to the caller. It is easy to see they love their job.","Agents chooses correct call disposition.","The agent correctly performs the process of making new orders and/or warranty replacement orders. The agent is NOT too pushy to try to make a sell. The agent makes the properly wrap up for the new order/warranty replacement.","The agent properly gives all the return instructions as they were instructed. The agent properly cancel the acc and saves all the changes on the customer account. The agent confirms the amount to be reimbursed and to which card the reimbursement would be made (last 4 digits) and explains that the time for a refund is between 24 to 48 hours. explains to the client that it is not necessary to contact the bank and if he has any questions and he can contact us back.","The agent is an expert with the processes and the system use and shows knowledge and confidence during the call","The agent solved the customer issue on a timely manner and with a positive attitude and avoiding any unnecessary call back for the same situation. The agent followed the correct procedure and made all proper changes and comments on the customer account.","Agent asks the correct questions to understand callers reasons to cancel or return.","Agents explains product benefits and shows knowledge of use and its features.","Agents makes offers to save the sales accordingly.","Call Summary", "Feedback", "Agent Review Date", "Agent Feedback Acceptance", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($process=='sales'){
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['can_automated'].'",';
				$row .= '"'.$user['product'].'",';
				$row .= '"'.$user['qa_type'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['recording_id'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['auto_fail'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['greeting'].'",';
				$row .= '"'.$user['probing_question'].'",';
				$row .= '"'.$user['product_benefit'].'",';
				$row .= '"'.$user['close_the_sale'].'",';
				$row .= '"'.$user['rebuttals'].'",';
				$row .= '"'.$user['rapport'].'",';
				$row .= '"'.$user['product_knowledge'].'",';
				$row .= '"'.$user['speed_clarity'].'",';
				$row .= '"'.$user['professional_ethics'].'",';
				$row .= '"'.$user['passion_selling'].'",';
				$row .= '"'.$user['main_offers'].'",';
				$row .= '"'.$user['upsell_compliance'].'",';
				$row .= '"'.$user['prepays_compliance'].'",';
				$row .= '"'.$user['legal_terms'].'",';
				$row .= '"'.$user['third_party_separation'].'",';
				$row .= '"'.$user['acknowledge'].'",';
				$row .= '"'.$user['build_value'].'",';
				$row .= '"'.$user['sale_close'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($process=='cs_new'){
			
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['product'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['can_automated'].'",';
				$row .= '"'.$user['qa_type'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['recording_id'].'",';
				$row .= '"'.$user['order_accnt'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['autofail'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agent_greets_the_customer'].'",';
				$row .= '"'.$user['the_agent_verified'].'",';
				$row .= '"'.$user['the_agent_understands'].'",';
				$row .= '"'.$user['agent_is_attentive'].'",';
				$row .= '"'.$user['agent_ends_the_call'].'",';
				$row .= '"'.$user['agent_builds_personal'].'",';
				$row .= '"'.$user['agent_an_expert'].'",';
				$row .= '"'.$user['agent_speaks_with'].'",';
				$row .= '"'.$user['agent_always_respects'].'",';
				$row .= '"'.$user['agent_sounds_happy'].'",';
				$row .= '"'.$user['agents_chooses_correct'].'",';
				$row .= '"'.$user['agent_correctly_performs'].'",';
				$row .= '"'.$user['agent_properly_gives'].'",';
				$row .= '"'.$user['agent_an_expert_processes'].'",';
				$row .= '"'.$user['agent_solved_customer'].'",';
				$row .= '"'.$user['agent_asks_the_correct'].'",';
				$row .= '"'.$user['agents_explains_product'].'",';
				$row .= '"'.$user['agents_makes_offers'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		}
		
	}
	
	
 }