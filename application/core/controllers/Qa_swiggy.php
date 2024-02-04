<?php 

 class Qa_swiggy extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	

///////////////////////////////////////Swiggy OMT//////////////////////////////////////////////
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_swiggy/qa_swiggy_omt_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,110) and is_assign_process (id,201) and status=1  order by name";
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_swiggy_omt_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_swiggy_omt_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_swiggy_omt_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $ops_cond order by audit_date";
			$data["swiggy_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_omt_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_swiggy/add_omt_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,110) and is_assign_process (id,201) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"monitoring_type" => $this->input->post('monitoring_type'),
					"order_id" => $this->input->post('order_id'),
					"call_id" => $this->input->post('call_id'),
					"call_duration" => $this->input->post('call_duration'),
					"disposition" => $this->input->post('disposition'),
					"category" => $this->input->post('category'),
					"call_party" => $this->input->post('call_party'),
					"language" => $this->input->post('language'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"greeting" => $this->input->post('greeting'),
					"greeting_reason" => $this->input->post('greeting_reason'),
					"greeting_www" => $this->input->post('greeting_www'),
					"greeting_wcb" => $this->input->post('greeting_wcb'),
					"identification" => $this->input->post('identification'),
					"identification_reason" => $this->input->post('identification_reason'),
					"identification_www" => $this->input->post('identification_www'),
					"identification_wcb" => $this->input->post('identification_wcb'),
					"callintro" => $this->input->post('callintro'),
					"callintro_reason" => $this->input->post('callintro_reason'),
					"callintro_www" => $this->input->post('callintro_www'),
					"callintro_wcb" => $this->input->post('callintro_wcb'),
					"languageadher" => $this->input->post('languageadher'),
					"languageadher_reason" => $this->input->post('languageadher_reason'),
					"languageadher_www" => $this->input->post('languageadher_www'),
					"languageadher_wcb" => $this->input->post('languageadher_wcb'),
					"confirm" => $this->input->post('confirm'),
					"confirm_reason" => $this->input->post('confirm_reason'),
					"confirm_www" => $this->input->post('confirm_www'),
					"confirm_wcb" => $this->input->post('confirm_wcb'),
					"systemvalid" => $this->input->post('systemvalid'),
					"systemvalid_reason" => $this->input->post('systemvalid_reason'),
					"systemvalid_www" => $this->input->post('systemvalid_www'),
					"systemvalid_wcb" => $this->input->post('systemvalid_wcb'),
					"probing" => $this->input->post('probing'),
					"probing_reason" => $this->input->post('probing_reason'),
					"probing_www" => $this->input->post('probing_www'),
					"probing_wcb" => $this->input->post('probing_wcb'),
					"takingowner" => $this->input->post('takingowner'),
					"takingowner_reason" => $this->input->post('takingowner_reason'),
					"takingowner_www" => $this->input->post('takingowner_www'),
					"takingowner_wcb" => $this->input->post('takingowner_wcb'),
					"infosharing" => $this->input->post('infosharing'),
					"infosharing_reason" => $this->input->post('infosharing_reason'),
					"infosharing_www" => $this->input->post('infosharing_www'),
					"infosharing_wcb" => $this->input->post('infosharing_wcb'),
					"rightaction" => $this->input->post('rightaction'),
					"rightaction_reason" => $this->input->post('rightaction_reason'),
					"rightaction_www" => $this->input->post('rightaction_www'),
					"rightaction_wcb" => $this->input->post('rightaction_wcb'),
					"callcontrol" => $this->input->post('callcontrol'),
					"callcontrol_reason" => $this->input->post('callcontrol_reason'),
					"callcontrol_www" => $this->input->post('callcontrol_www'),
					"callcontrol_wcb" => $this->input->post('callcontrol_wcb'),
					"softskill" => $this->input->post('softskill'),
					"softskill_reason" => $this->input->post('softskill_reason'),
					"softskill_www" => $this->input->post('softskill_www'),
					"softskill_wcb" => $this->input->post('softskill_wcb'),
					"holdprocedure" => $this->input->post('holdprocedure'),
					"holdprocedure_reason" => $this->input->post('holdprocedure_reason'),
					"holdprocedure_www" => $this->input->post('holdprocedure_www'),
					"holdprocedure_wcb" => $this->input->post('holdprocedure_wcb'),
					"languageswitch" => $this->input->post('languageswitch'),
					"languageswitch_reason" => $this->input->post('languageswitch_reason'),
					"languageswitch_www" => $this->input->post('languageswitch_www'),
					"languageswitch_wcb" => $this->input->post('languageswitch_wcb'),
					"activelisten" => $this->input->post('activelisten'),
					"activelisten_reason" => $this->input->post('activelisten_reason'),
					"activelisten_www" => $this->input->post('activelisten_www'),
					"activelisten_wcb" => $this->input->post('activelisten_wcb'),
					"rightfit" => $this->input->post('rightfit'),
					"rightfit_reason" => $this->input->post('rightfit_reason'),
					"rightfit_www" => $this->input->post('rightfit_www'),
					"rightfit_wcb" => $this->input->post('rightfit_wcb'),
					"furtherassist" => $this->input->post('furtherassist'),
					"furtherassist_reason" => $this->input->post('furtherassist_reason'),
					"furtherassist_www" => $this->input->post('furtherassist_www'),
					"furtherassist_wcb" => $this->input->post('furtherassist_wcb'),
					"callclose" => $this->input->post('callclose'),
					"callclose_reason" => $this->input->post('callclose_reason'),
					"callclose_www" => $this->input->post('callclose_www'),
					"callclose_wcb" => $this->input->post('callclose_wcb'),
					"ztp" => $this->input->post('ztp'),
					"ztp_reason" => $this->input->post('ztp_reason'),
					"ztp_www" => $this->input->post('ztp_www'),
					"ztp_wcb" => $this->input->post('ztp_wcb'),
					"greeting_reason2" => $this->input->post('greeting_reason2'),
					"identification_reason2" => $this->input->post('identification_reason2'),
					"callintro_reason2" => $this->input->post('callintro_reason2'),
					"languageadher_reason2" => $this->input->post('languageadher_reason2'),
					"confirm_reason2" => $this->input->post('confirm_reason2'),
					"systemvalid_reason2" => $this->input->post('systemvalid_reason2'),
					"probing_reason2" => $this->input->post('probing_reason2'),
					"takingowner_reason2" => $this->input->post('takingowner_reason2'),
					"infosharing_reason2" => $this->input->post('infosharing_reason2'),
					"rightaction_reason2" => $this->input->post('rightaction_reason2'),
					"callcontrol_reason2" => $this->input->post('callcontrol_reason2'),
					"softskill_reason2" => $this->input->post('softskill_reason2'),
					"holdprocedure_reason2" => $this->input->post('holdprocedure_reason2'),
					"languageswitch_reason2" => $this->input->post('languageswitch_reason2'),
					"activelisten_reason2" => $this->input->post('activelisten_reason2'),
					"rightfit_reason2" => $this->input->post('rightfit_reason2'),
					"furtherassist_reason2" => $this->input->post('furtherassist_reason2'),
					"callclose_reason2" => $this->input->post('callclose_reason2'),
					"ztp_reason2" => $this->input->post('ztp_reason2'),
					"was_agent_resolve" => $this->input->post('was_agent_resolve'),
					"order_acpt" => $this->input->post('order_acpt'),
					"order_rca" => $this->input->post('order_rca'),
					"order_remarks" => $this->input->post('order_remarks'),
					"call_category" => $this->input->post('call_category'),
					"high_background" => $this->input->post('high_background'),
					"aht_reduction" => $this->input->post('aht_reduction'),
					"aht_acpt" => $this->input->post('aht_acpt'),
					"aht_remarks" => $this->input->post('aht_remarks'),
					"will_call_lead" => $this->input->post('will_call_lead'),
					"repeat_call_acpt" => $this->input->post('repeat_call_acpt'),
					"repeat_call_remarks" => $this->input->post('repeat_call_remarks'),
					"ivr_call_transfer" => $this->input->post('ivr_call_transfer'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime					
				);
				
				$a = $this->omt_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_swiggy_omt_feedback',$field_array);
				redirect('Qa_swiggy');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function omt_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_swiggy/swiggy_omt/';
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
	
	
	public function mgnt_swiggy_omt_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_swiggy/mgnt_swiggy_omt_feedback_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,110) and is_assign_process (id,201) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);		
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_swiggy_omt_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process_name, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["swiggy_omt"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["omtid"]=$id;
			
			$qSql="Select * FROM qa_swiggy_omt_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_swiggy_omt_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		///////Edit Part///////	
			if($this->input->post('omtid'))
			{
				$omtid=$this->input->post('omtid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"monitoring_type" => $this->input->post('monitoring_type'),
					"order_id" => $this->input->post('order_id'),
					"call_id" => $this->input->post('call_id'),
					"call_duration" => $this->input->post('call_duration'),
					"disposition" => $this->input->post('disposition'),
					"category" => $this->input->post('category'),
					"call_party" => $this->input->post('call_party'),
					"language" => $this->input->post('language'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"greeting" => $this->input->post('greeting'),
					"greeting_reason" => $this->input->post('greeting_reason'),
					"greeting_www" => $this->input->post('greeting_www'),
					"greeting_wcb" => $this->input->post('greeting_wcb'),
					"identification" => $this->input->post('identification'),
					"identification_reason" => $this->input->post('identification_reason'),
					"identification_www" => $this->input->post('identification_www'),
					"identification_wcb" => $this->input->post('identification_wcb'),
					"callintro" => $this->input->post('callintro'),
					"callintro_reason" => $this->input->post('callintro_reason'),
					"callintro_www" => $this->input->post('callintro_www'),
					"callintro_wcb" => $this->input->post('callintro_wcb'),
					"languageadher" => $this->input->post('languageadher'),
					"languageadher_reason" => $this->input->post('languageadher_reason'),
					"languageadher_www" => $this->input->post('languageadher_www'),
					"languageadher_wcb" => $this->input->post('languageadher_wcb'),
					"confirm" => $this->input->post('confirm'),
					"confirm_reason" => $this->input->post('confirm_reason'),
					"confirm_www" => $this->input->post('confirm_www'),
					"confirm_wcb" => $this->input->post('confirm_wcb'),
					"systemvalid" => $this->input->post('systemvalid'),
					"systemvalid_reason" => $this->input->post('systemvalid_reason'),
					"systemvalid_www" => $this->input->post('systemvalid_www'),
					"systemvalid_wcb" => $this->input->post('systemvalid_wcb'),
					"probing" => $this->input->post('probing'),
					"probing_reason" => $this->input->post('probing_reason'),
					"probing_www" => $this->input->post('probing_www'),
					"probing_wcb" => $this->input->post('probing_wcb'),
					"takingowner" => $this->input->post('takingowner'),
					"takingowner_reason" => $this->input->post('takingowner_reason'),
					"takingowner_www" => $this->input->post('takingowner_www'),
					"takingowner_wcb" => $this->input->post('takingowner_wcb'),
					"infosharing" => $this->input->post('infosharing'),
					"infosharing_reason" => $this->input->post('infosharing_reason'),
					"infosharing_www" => $this->input->post('infosharing_www'),
					"infosharing_wcb" => $this->input->post('infosharing_wcb'),
					"rightaction" => $this->input->post('rightaction'),
					"rightaction_reason" => $this->input->post('rightaction_reason'),
					"rightaction_www" => $this->input->post('rightaction_www'),
					"rightaction_wcb" => $this->input->post('rightaction_wcb'),
					"callcontrol" => $this->input->post('callcontrol'),
					"callcontrol_reason" => $this->input->post('callcontrol_reason'),
					"callcontrol_www" => $this->input->post('callcontrol_www'),
					"callcontrol_wcb" => $this->input->post('callcontrol_wcb'),
					"softskill" => $this->input->post('softskill'),
					"softskill_reason" => $this->input->post('softskill_reason'),
					"softskill_www" => $this->input->post('softskill_www'),
					"softskill_wcb" => $this->input->post('softskill_wcb'),
					"holdprocedure" => $this->input->post('holdprocedure'),
					"holdprocedure_reason" => $this->input->post('holdprocedure_reason'),
					"holdprocedure_www" => $this->input->post('holdprocedure_www'),
					"holdprocedure_wcb" => $this->input->post('holdprocedure_wcb'),
					"languageswitch" => $this->input->post('languageswitch'),
					"languageswitch_reason" => $this->input->post('languageswitch_reason'),
					"languageswitch_www" => $this->input->post('languageswitch_www'),
					"languageswitch_wcb" => $this->input->post('languageswitch_wcb'),
					"activelisten" => $this->input->post('activelisten'),
					"activelisten_reason" => $this->input->post('activelisten_reason'),
					"activelisten_www" => $this->input->post('activelisten_www'),
					"activelisten_wcb" => $this->input->post('activelisten_wcb'),
					"rightfit" => $this->input->post('rightfit'),
					"rightfit_reason" => $this->input->post('rightfit_reason'),
					"rightfit_www" => $this->input->post('rightfit_www'),
					"rightfit_wcb" => $this->input->post('rightfit_wcb'),
					"furtherassist" => $this->input->post('furtherassist'),
					"furtherassist_reason" => $this->input->post('furtherassist_reason'),
					"furtherassist_www" => $this->input->post('furtherassist_www'),
					"furtherassist_wcb" => $this->input->post('furtherassist_wcb'),
					"callclose" => $this->input->post('callclose'),
					"callclose_reason" => $this->input->post('callclose_reason'),
					"callclose_www" => $this->input->post('callclose_www'),
					"callclose_wcb" => $this->input->post('callclose_wcb'),
					"ztp" => $this->input->post('ztp'),
					"ztp_reason" => $this->input->post('ztp_reason'),
					"ztp_www" => $this->input->post('ztp_www'),
					"ztp_wcb" => $this->input->post('ztp_wcb'),
					"greeting_reason2" => $this->input->post('greeting_reason2'),
					"identification_reason2" => $this->input->post('identification_reason2'),
					"callintro_reason2" => $this->input->post('callintro_reason2'),
					"languageadher_reason2" => $this->input->post('languageadher_reason2'),
					"confirm_reason2" => $this->input->post('confirm_reason2'),
					"systemvalid_reason2" => $this->input->post('systemvalid_reason2'),
					"probing_reason2" => $this->input->post('probing_reason2'),
					"takingowner_reason2" => $this->input->post('takingowner_reason2'),
					"infosharing_reason2" => $this->input->post('infosharing_reason2'),
					"rightaction_reason2" => $this->input->post('rightaction_reason2'),
					"callcontrol_reason2" => $this->input->post('callcontrol_reason2'),
					"softskill_reason2" => $this->input->post('softskill_reason2'),
					"holdprocedure_reason2" => $this->input->post('holdprocedure_reason2'),
					"languageswitch_reason2" => $this->input->post('languageswitch_reason2'),
					"activelisten_reason2" => $this->input->post('activelisten_reason2'),
					"rightfit_reason2" => $this->input->post('rightfit_reason2'),
					"furtherassist_reason2" => $this->input->post('furtherassist_reason2'),
					"callclose_reason2" => $this->input->post('callclose_reason2'),
					"ztp_reason2" => $this->input->post('ztp_reason2'),
					"was_agent_resolve" => $this->input->post('was_agent_resolve'),
					"order_acpt" => $this->input->post('order_acpt'),
					"order_rca" => $this->input->post('order_rca'),
					"order_remarks" => $this->input->post('order_remarks'),
					"call_category" => $this->input->post('call_category'),
					"high_background" => $this->input->post('high_background'),
					"aht_reduction" => $this->input->post('aht_reduction'),
					"aht_acpt" => $this->input->post('aht_acpt'),
					"aht_remarks" => $this->input->post('aht_remarks'),
					"will_call_lead" => $this->input->post('will_call_lead'),
					"repeat_call_acpt" => $this->input->post('repeat_call_acpt'),
					"repeat_call_remarks" => $this->input->post('repeat_call_remarks'),
					"ivr_call_transfer" => $this->input->post('ivr_call_transfer'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $omtid);
				$this->db->update('qa_swiggy_omt_feedback',$field_array);
				
			////////////	
				$field_array1=array(
					"fd_id" => $omtid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_swiggy_omt_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $omtid);
					$this->db->update('qa_swiggy_omt_mgnt_rvw',$field_array1);
				}
			///////////	
				redirect('Qa_swiggy');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/////////////////////////Agent part/////////////////////////////////	

	public function agent_swiggy_omt_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_swiggy/agent_swiggy_omt_feedback.php";
			$data["agentUrl"] = "qa_swiggy/agent_swiggy_omt_feedback";
			
			
			$qSql="Select count(id) as value from qa_swiggy_omt_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_swiggy_omt_feedback where id  not in (select fd_id from qa_swiggy_omt_agent_rvw) and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
			$data["yet_to_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_swiggy_omt_feedback $cond and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_swiggy_omt_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_swiggy_omt_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id)";
				$data["agent_omt_review_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_swiggy_omt_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join (Select id as sid, fname, lname, fusion_id , get_process_names(id) as process_name from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_swiggy_omt_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, note as mgnt_note, date(entry_date) as mgnt_rvw_date, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name from qa_swiggy_omt_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) where xx.id not in (select fd_id from qa_swiggy_omt_agent_rvw)";
				$data["agent_omt_review_list"] = $this->Common_model->get_query_result_array($qSql);	
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_swiggy_omt_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_swiggy/agent_swiggy_omt_feedback_rvw.php";
			$data["agentUrl"] = "qa_swiggy/agent_swiggy_omt_feedback";
						
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_swiggy_omt_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as process_name, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["swiggy_omt"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["omtid"]=$id;
			
			$qSql="Select * FROM qa_swiggy_omt_agent_rvw where fd_id='$id'";
			$data["row1"] = $this->Common_model->get_query_row_array($qSql);//AGENT PURPOSE
			
			$qSql="Select * FROM qa_swiggy_omt_mgnt_rvw where fd_id='$id'";
			$data["row2"] = $this->Common_model->get_query_row_array($qSql);//MGNT PURPOSE
			
		
			if($this->input->post('omtid'))
			{
				$omtid=$this->input->post('omtid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $omtid,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_swiggy_omt_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $omtid);
					$this->db->update('qa_swiggy_omt_agent_rvw',$field_array1);
				}	
				redirect('Qa_swiggy/agent_swiggy_omt_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////// Swiggy Report /////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function qa_swiggy_report(){
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
			$data["content_template"] = "qa_swiggy/qa_swiggy_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			
			$data["qa_swiggy_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (date(audit_date) >= '$date_from' and date(audit_date) <= '$date_to' ) ";
		
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_swiggy_omt_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note, date(entry_date) as agent_rvw_date from qa_swiggy_omt_agent_rvw) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_swiggy_omt_mgnt_rvw) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_swiggy_list"] = $fullAray;
				$this->create_qa_swiggy_omt_CSV($fullAray);	
				$dn_link = base_url()."qa_swiggy/download_qa_swiggy_omt_CSV";
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_swiggy_omt_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Swiggy OMT Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_swiggy_omt_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Super", "Call Date", "Monitoring Type", "Order ID", "Call ID", "Call Duration", "Disposition", "Category", "Call Party", "Language", "Audit Type", "VOC", "Greeting", "Greeting Reason If Rated No/Fatal", "Greeting Reason", "Greeting - What went well?", "Greeting - What could have been better?", "Identification", "Identification Reason If Rated No/Fatal", "Identification Reason", "Identification - What went well?", "Identification - What could have been better?", "Call Intro", "Call Intro Reason If Rated No/Fatal", "Call Intro Reason", "Call Intro - What went well?", "Call Intro - What could have been better?", "Language Adher", "Language Adher Reason If Rated No/Fatal", "Language Adher Reason", "Language Adher - What went well?", "Language Adher - What could have been better?", "Confirm", "Confirm Reason If Rated No/Fatal", "Confirm Reason", "Confirm - What went well?", "Confirm - What could have been better?", "System Valid", "System Valid Reason If Rated No/Fatal", "System Valid Reason", "System Valid - What went well?", "System Valid - What could have been better?", "Probing", "Probing Reason If Rated No/Fatal", "Probing Reason", "Probing - What went well?", "Probing - What could have been better?", "Taking Owner", "Taking Owner Reason If Rated No/Fatal", "Taking Owner Reason", "Taking Owner - What went well?", "Taking Owner - What could have been better?", "Information Sharing", "Information Sharing Reason If Rated No/Fatal", "Information Sharing Reason", "Information Sharing - What went well?", "Information Sharing - What could have been better?", "Right Action", "Right Action Reason If Rated No/Fatal", "Right Action Reason", "Right Action - What went well?", "Right Action - What could have been better?", "Call Control", "Call Control Reason If Rated No/Fatal", "Call Control Reason", "Call Control - What went well?", "Call Control - What could have been better?", "Soft Skill", "Soft Skill Reason If Rated No/Fatal", "Soft Skill Reason", "Soft Skill - What went well?", "Soft Skill - What could have been better?", "Hold Procedure", "Hold Procedure Reason If Rated No/Fatal", "Hold Procedure Reason", "Hold Procedure - What went well?", "Hold Procedure - What could have been better?", "Language Switch", "Language Switch Reason If Rated No/Fatal", "Language Switch Reason", "Language Switch - What went well?", "Language Switch - What could have been better?", "Active Listening", "Active Listening Reason If Rated No/Fatal", "Active Listening Reason", "Active Listening - What went well?", "Active Listening - What could have been better?", "Right Fit", "Right Fit Reason If Rated No/Fatal", "Right Fit Reason", "Right Fit - What went well?", "Right Fit - What could have been better?", "Further Assist", "Further Assist Reason If Rated No/Fatal", "Further Assist Reason", "Further Assist - What went well?", "Further Assist - What could have been better?", "Call Close", "Call Close Reason If Rated No/Fatal", "Call Close Reason", "Call Close - What went well?", "Call Close - What could have been better?", "ZTP", "ZTP Reason If Rated No/Fatal", "ZTP Reason", "ZTP - What went well?", "ZTP - What could have been better?", "Overall Score", "Was the Agent able to resolve the breakage in order Life Cycle", "Order Fulfillment - ACPT", "Order Fulfillment - RCA", "Order Fulfillment -  Remarks", "Call Category", "High Background Noice evident in the call", "Opportunity for AHT Reduction", "AHT - ACPT", "AHT - Remarks", "Will this call lead to repeat?", "Repeat Call - ACPT", "Repeat Call - Remarks", "Was the call transferred to IVR?", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['greeting']==3) $greeting='Yes';
			else $greeting='No';
			if($user['identification']==3) $identification='Yes';
			else $identification='No';
			if($user['callintro']==3) $callintro='Yes';
			else $callintro='No';
			if($user['languageadher']==3) $languageadher='Yes';
			else $languageadher='No';
			if($user['confirm']==3) $confirm='Yes';
			else $confirm='No';
			if($user['systemvalid']==6) $systemvalid='Yes';
			else $systemvalid='No';
			if($user['probing']==6) $probing='Yes';
			else $probing='No';
			if($user['takingowner']==8) $takingowner='Yes';
			else if($user['takingowner']==0) $takingowner='No';
			else $takingowner='Fatal';
			if($user['infosharing']==23) $infosharing='Yes';
			else $infosharing='Fatal';
			if($user['rightaction']==12) $rightaction='Yes';
			else if($user['rightaction']==0) $rightaction='No';
			else $rightaction='Fatal';
			if($user['callcontrol']==4) $callcontrol='Yes';
			else $callcontrol='No';
			if($user['softskill']==4) $softskill='Yes';
			else $softskill='No';
			if($user['holdprocedure']==2) $holdprocedure='Yes';
			else $holdprocedure='No';
			if($user['languageswitch']==2) $languageswitch='Yes';
			else $languageswitch='No';
			if($user['activelisten']==4) $activelisten='Yes';
			else $activelisten='No';
			if($user['rightfit']==4) $rightfit='Yes';
			else if($user['rightfit']==0) $rightfit='No';
			else $rightfit='Fatal';
			if($user['furtherassist']==5) $furtherassist='Yes';
			else $furtherassist='No';
			if($user['callclose']==5) $callclose='Yes';
			else $callclose='No';
			
			
			$row = '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['monitoring_type'].'",';
			$row .= '"'.$user['order_id'].'",';
			$row .= '"'.$user['call_id'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['disposition'].'",';
			$row .= '"'.$user['category'].'",';
			$row .= '"'.$user['call_party'].'",';
			$row .= '"'.$user['language'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$greeting.'",';
			$row .= '"'.$user['greeting_reason'].'",';
			$row .= '"'.$user['greeting_reason2'].'",';
			$row .= '"'.$user['greeting_www'].'",';
			$row .= '"'.$user['greeting_wcb'].'",';
			$row .= '"'.$identification.'",';
			$row .= '"'.$user['identification_reason'].'",';
			$row .= '"'.$user['identification_reason2'].'",';
			$row .= '"'.$user['identification_www'].'",';
			$row .= '"'.$user['identification_wcb'].'",';
			$row .= '"'.$callintro.'",';
			$row .= '"'.$user['callintro_reason'].'",';
			$row .= '"'.$user['callintro_reason2'].'",';
			$row .= '"'.$user['callintro_www'].'",';
			$row .= '"'.$user['callintro_wcb'].'",';
			$row .= '"'.$languageadher.'",';
			$row .= '"'.$user['languageadher_reason'].'",';
			$row .= '"'.$user['languageadher_reason2'].'",';
			$row .= '"'.$user['languageadher_www'].'",';
			$row .= '"'.$user['languageadher_wcb'].'",';
			$row .= '"'.$confirm.'",';
			$row .= '"'.$user['confirm_reason'].'",';
			$row .= '"'.$user['confirm_reason2'].'",';
			$row .= '"'.$user['confirm_www'].'",';
			$row .= '"'.$user['confirm_wcb'].'",';
			$row .= '"'.$systemvalid.'",';
			$row .= '"'.$user['systemvalid_reason'].'",';
			$row .= '"'.$user['systemvalid_reason2'].'",';
			$row .= '"'.$user['systemvalid_www'].'",';
			$row .= '"'.$user['systemvalid_wcb'].'",';
			$row .= '"'.$probing.'",';
			$row .= '"'.$user['probing_reason'].'",';
			$row .= '"'.$user['probing_reason2'].'",';
			$row .= '"'.$user['probing_www'].'",';
			$row .= '"'.$user['probing_wcb'].'",';
			$row .= '"'.$takingowner.'",';
			$row .= '"'.$user['takingowner_reason'].'",';
			$row .= '"'.$user['takingowner_reason2'].'",';
			$row .= '"'.$user['takingowner_www'].'",';
			$row .= '"'.$user['takingowner_wcb'].'",';
			$row .= '"'.$infosharing.'",';
			$row .= '"'.$user['infosharing_reason'].'",';
			$row .= '"'.$user['infosharing_reason2'].'",';
			$row .= '"'.$user['infosharing_www'].'",';
			$row .= '"'.$user['infosharing_wcb'].'",';
			$row .= '"'.$rightaction.'",';
			$row .= '"'.$user['rightaction_reason'].'",';
			$row .= '"'.$user['rightaction_reason2'].'",';
			$row .= '"'.$user['rightaction_www'].'",';
			$row .= '"'.$user['rightaction_wcb'].'",';
			$row .= '"'.$callcontrol.'",';
			$row .= '"'.$user['callcontrol_reason'].'",';
			$row .= '"'.$user['callcontrol_reason2'].'",';
			$row .= '"'.$user['callcontrol_www'].'",';
			$row .= '"'.$user['callcontrol_wcb'].'",';
			$row .= '"'.$softskill.'",';
			$row .= '"'.$user['softskill_reason'].'",';
			$row .= '"'.$user['softskill_reason2'].'",';
			$row .= '"'.$user['softskill_www'].'",';
			$row .= '"'.$user['softskill_wcb'].'",';
			$row .= '"'.$holdprocedure.'",';
			$row .= '"'.$user['holdprocedure_reason'].'",';
			$row .= '"'.$user['holdprocedure_reason2'].'",';
			$row .= '"'.$user['holdprocedure_www'].'",';
			$row .= '"'.$user['holdprocedure_wcb'].'",';
			$row .= '"'.$languageswitch.'",';
			$row .= '"'.$user['languageswitch_reason'].'",';
			$row .= '"'.$user['languageswitch_reason2'].'",';
			$row .= '"'.$user['languageswitch_www'].'",';
			$row .= '"'.$user['languageswitch_wcb'].'",';
			$row .= '"'.$activelisten.'",';
			$row .= '"'.$user['activelisten_reason'].'",';
			$row .= '"'.$user['activelisten_reason2'].'",';
			$row .= '"'.$user['activelisten_www'].'",';
			$row .= '"'.$user['activelisten_wcb'].'",';
			$row .= '"'.$rightfit.'",';
			$row .= '"'.$user['rightfit_reason'].'",';
			$row .= '"'.$user['rightfit_reason2'].'",';
			$row .= '"'.$user['rightfit_www'].'",';
			$row .= '"'.$user['rightfit_wcb'].'",';
			$row .= '"'.$furtherassist.'",';
			$row .= '"'.$user['furtherassist_reason'].'",';
			$row .= '"'.$user['furtherassist_reason2'].'",';
			$row .= '"'.$user['furtherassist_www'].'",';
			$row .= '"'.$user['furtherassist_wcb'].'",';
			$row .= '"'.$callclose.'",';
			$row .= '"'.$user['callclose_reason'].'",';
			$row .= '"'.$user['callclose_reason2'].'",';
			$row .= '"'.$user['callclose_www'].'",';
			$row .= '"'.$user['callclose_wcb'].'",';
			$row .= '"'.$user['ztp'].'",';
			$row .= '"'.$user['ztp_reason'].'",';
			$row .= '"'.$user['ztp_reason2'].'",';
			$row .= '"'.$user['ztp_www'].'",';
			$row .= '"'.$user['ztp_wcb'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",'; 
			$row .= '"'.$user['was_agent_resolve'].'",';
			$row .= '"'.$user['order_acpt'].'",';
			$row .= '"'.$user['order_rca'].'",';
			$row .= '"'.$user['order_remarks'].'",';
			$row .= '"'.$user['call_category'].'",';
			$row .= '"'.$user['high_background'].'",';
			$row .= '"'.$user['aht_reduction'].'",';
			$row .= '"'.$user['aht_acpt'].'",';
			$row .= '"'.$user['aht_remarks'].'",';
			$row .= '"'.$user['will_call_lead'].'",';
			$row .= '"'.$user['repeat_call_acpt'].'",';
			$row .= '"'.$user['repeat_call_remarks'].'",';
			$row .= '"'.$user['ivr_call_transfer'].'",';
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
?>