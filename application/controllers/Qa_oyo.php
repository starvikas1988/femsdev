<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_oyo extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('excel');
		//$this->load->model('reports_model');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Dfr_model');
		
		$this->objPHPExcel = new PHPExcel();
		
	}
	public function index()
	{
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/search_inbound_sales.php";
			$data["agentUrl"] = "qa_oyo"; 
			
			if (get_role_dir() == "agent"){
				
				$query = $this->db->query('SELECT qa_oyo_inbound_sale_feedback.id,qa_oyo_inbound_sale_feedback.agent_id,qa_oyo_inbound_sale_feedback.agent_name,qa_oyo_inbound_sale_feedback.team_leader_id,CONCAT(signin.fname," ",signin.lname) AS team_leader_name,qa_oyo_inbound_sale_feedback.manager_id,CONCAT(a.fname," ",a.lname) AS manager_name,qa_oyo_inbound_sale_feedback.client_name,qa_oyo_inbound_sale_feedback.record_date_time,qa_oyo_inbound_sale_feedback.booking_id,overall_result,overall_score FROM `qa_oyo_inbound_sale_feedback` LEFT JOIN
				signin ON signin.id=qa_oyo_inbound_sale_feedback.team_leader_id
				LEFT JOIN signin AS a
				ON a.id=qa_oyo_inbound_sale_feedback.manager_id
				LEFT JOIN qa_oyo_inbound_sale_agent_review ON qa_oyo_inbound_sale_agent_review.inbound_sale_feedback_id = qa_oyo_inbound_sale_feedback.id
				WHERE agent_id="'.$current_user.'" AND qa_oyo_inbound_sale_agent_review.reviewer_id IS NULL');
				
				$data["inbound_infos"] = $query->result_object();
						
			}
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function inbound_sale_form()
	{
		if(check_logged_in()){
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/inbound_sales.php";
			$this->load->view('dashboard',$data);
		}
	}
	
	public function get_agent_information()
	{
		$fusion_id = $this->input->post('fusion_id');
		$query = $this->db->query('SELECT signin.id AS agent_id, CONCAT(signin.fname," ",signin.lname) AS agent_name,signin.phno as agent_phone,get_client_names(signin.id) AS client_name,get_process_names(signin.id) AS process_name,a.id AS team_leader_id,CONCAT(a.fname," ",a.lname) AS team_leader_name,b.id AS manager_id,CONCAT(b.fname," ",b.lname) AS manager_name FROM signin
			LEFT JOIN signin AS a ON a.id=signin.assigned_to
			LEFT JOIN signin AS b ON b.id=a.assigned_to WHERE signin.fusion_id="'.$fusion_id.'"');
		$response = array();
		if($query->num_rows() > 0)
		{
			$response['stat'] = true;
			$response['datas'] = $query->row();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function get_shift_timing()
	{
		$record_date_time = $this->input->post('record_date_time');
		$agent_id = $this->input->post('agent_id');

		$date = DateTime::createFromFormat('Y-m-d h:i:s', $record_date_time);
		$record_date = $date->format('Y-m-d');
		$day = $date->format('D');
		
		
		$date = new DateTime($record_date);

		$date->modify('+7 day');
		$date->format('Y-m-d');

		
		$query = $this->db->query('SELECT user_shift_schedule.in_time,user_shift_schedule.out_time FROM `user_shift_schedule` WHERE user_id="'.$agent_id.'" AND shdate = "'.$record_date.'"');
		$response = array();
		if($query->num_rows() > 0)
		{
			$response['stat'] = true;
			$response['datas'] = $query->row();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function process_inbound_sales()
	{
		$current_user = get_user_id();
		
		$config['upload_path'] = './qa_files/qa_oyo_inter/';
		$config['allowed_types'] = 'mp3|avi|mp4|wmv';
		$config['max_size']     = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$file_name = '';
		if (!$this->upload->do_upload('attach_file')){
			$error = $this->upload->display_errors();
			$data['message'] = $error;
			//$field_array["attach_file"] = $error;
			//echo $error;
		}else{
			$resume_file = $this->upload->data();
			//print_r($resume_file);
			$file_name = $resume_file['file_name'];
		}
		
		$form_data = $this->input->post();
		$insert_columns = [];
		$insert_values = [];
		
		
		foreach($form_data as $key=>$value)
		{
			$insert_columns[] = $key;
			$insert_values[] = $this->db->escape($value);
		}
		if(isset($_FILES))
		{
			$insert_columns[] = 'attach_file';
			$insert_values[] = $this->db->escape($file_name);
		}
		//print_r($form_data);
		//print_r($_FILES);
		/* INSERT INTO `qa_oyo_inbound_sale_feedback`(agent_id,team_leader_id,manager_id,agent_name,client_name,fusion_id,call_duration,record_date_time,mail_id,booking_id,audit_date,auditor_name,shift_timeing,overall_result,call_type,overall_score,acknowledgement,personalization,verification_process,politeness,empathy,overlapping,relevant_probing,enthusiasm,switch_language,voice_clarity,intonation,grammar,transfer,dead_air,complaint,selling_efforts,rebuttals,usps,payment_confirmation,retention,ownership,disclosure,crs,adherence,summarization,ivr,further_assistance,closing,infraction_stat,reason_type,tier,attempt,equivalent,call_summary,feedback,bod,reason,attach_file,attach_file,added_by,added_date) VALUES ('6467','4','6458','Deb Kumar Dasgupta','Global Support','FKOL001800','08:00:00','2019-09-12 00:00:00','434','4343','2019-09-13','System Administrator','','B','Callback','94.8%','0','0','3','5','5','4','4','5','2','3','3','4','4','2','4','4','5','3','3','3','3','4','3','5','2','2','3','3','No','','','','','','','','','undefined','',"1",now()) */

		$qSql='INSERT INTO `qa_oyo_inbound_sale_feedback`('.implode(",",$insert_columns).',entry_by,entry_date) VALUES ('.implode(",",$insert_values).',"'.$current_user.'",now())';
		
		$this->db->trans_start();
		$this->db->query($qSql);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$response['stat'] = false;
		}
		else
		{
			$response['stat'] = true;
		}
		echo json_encode($response);
	}
	
	public function process_inbound_sales_edit()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		$insert_columns = [];
		$insert_values = [];
		
		foreach($form_data as $key=>$value)
		{
			$insert_columns[] = $key;
			$insert_values[] = $this->db->escape($value);
		}
		
		//$qSql='INSERT INTO `qa_oyo_inbound_sale_feedback`('.implode(",",$insert_columns).',entry_by,entry_date) VALUES ('.implode(",",$insert_values).',"'.$current_user.'",now())';
		
		$qSql='UPDATE qa_oyo_inbound_sale_feedback SET agent_id="'.$form_data['agent_id'].'", team_leader_id="'.$form_data['team_leader_id'].'", manager_id="'.$form_data['manager_id'].'", agent_name="'.$form_data['agent_name'].'", agent_phone="'.$form_data['agent_phone'].'", client_name="'.$form_data['client_name'].'", process_name="'.$form_data['process_name'].'", fusion_id="'.$form_data['fusion_id'].'", call_duration="'.$form_data['call_duration'].'", record_date_time="'.$form_data['record_date_time'].'", mail_id="'.$form_data['mail_id'].'", booking_id="'.$form_data['booking_id'].'", audit_date="'.$form_data['audit_date'].'", auditor_name="'.$form_data['auditor_name'].'", shift_timeing="'.$form_data['shift_timeing'].'", call_type="'.$form_data['call_type'].'", audit_type="'.$form_data['audit_type'].'", voc="'.$form_data['voc'].'", overall_result="'.$form_data['overall_result'].'", overall_score="'.$form_data['overall_score'].'", opening_and_branding="'.$form_data['opening_and_branding'].'", acknowledgement="'.$form_data['acknowledgement'].'", personalization="'.$form_data['personalization'].'", verification_process="'.$form_data['verification_process'].'", politeness="'.$form_data['politeness'].'", empathy="'.$form_data['empathy'].'", overlapping="'.$form_data['overlapping'].'", relevant_probing="'.$form_data['relevant_probing'].'", enthusiasm="'.$form_data['enthusiasm'].'", switch_language="'.$form_data['switch_language'].'", voice_clarity="'.$form_data['voice_clarity'].'", intonation="'.$form_data['intonation'].'", grammar="'.$form_data['grammar'].'", transfer="'.$form_data['transfer'].'", dead_air="'.$form_data['dead_air'].'", complaint="'.$form_data['complaint'].'", selling_efforts="'.$form_data['selling_efforts'].'", rebuttals="'.$form_data['rebuttals'].'", usps="'.$form_data['usps'].'", payment_confirmation="'.$form_data['payment_confirmation'].'", retention="'.$form_data['retention'].'", ownership="'.$form_data['ownership'].'", disclosure="'.$form_data['disclosure'].'", crs="'.$form_data['crs'].'", adherence="'.$form_data['adherence'].'", summarization="'.$form_data['summarization'].'", ivr="'.$form_data['ivr'].'", further_assistance="'.$form_data['further_assistance'].'", closing="'.$form_data['closing'].'", infraction_stat="'.$form_data['infraction_stat'].'", reason_type="'.$form_data['reason_type'].'", tier="'.$form_data['tier'].'", attempt="'.$form_data['attempt'].'", equivalent="'.$form_data['equivalent'].'", call_summary="'.$form_data['call_summary'].'", feedback="'.$form_data['feedback'].'", bod="'.$form_data['bod'].'", reason="'.$form_data['reason'].'"	where id="'.$form_data['int_id'].'" ';
		
		$this->db->trans_start();
		$this->db->query($qSql);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$response['stat'] = false;
		}
		else
		{
			$response['stat'] = true;
		}
		echo json_encode($response);
	}
	
	public function get_inbound_sales()
	{
		if(check_logged_in()){
			$form_data = $this->input->post();
			//echo $todate = date('Y-m-d', strtotime('+1 day', $form_data['to_date']));;
			$datetime = new DateTime($form_data['to_date']);
			$datetime->modify('+1 day');
			$todate = $datetime->format('Y-m-d H:i:s');
			
			if (get_role_dir() == "agent")
			{
				$current_user = get_user_id();
				
					$query = $this->db->query('SELECT qa_oyo_inbound_sale_feedback.id,qa_oyo_inbound_sale_feedback.agent_id,qa_oyo_inbound_sale_feedback.agent_name,qa_oyo_inbound_sale_feedback.team_leader_id,CONCAT(signin.fname," ",signin.lname) AS team_leader_name,qa_oyo_inbound_sale_feedback.manager_id,CONCAT(a.fname," ",a.lname) AS manager_name,qa_oyo_inbound_sale_feedback.client_name,qa_oyo_inbound_sale_feedback.record_date_time,qa_oyo_inbound_sale_feedback.booking_id,qa_oyo_inbound_sale_feedback.attach_file,overall_result,overall_score FROM `qa_oyo_inbound_sale_feedback` LEFT JOIN
					signin ON signin.id=qa_oyo_inbound_sale_feedback.team_leader_id
					LEFT JOIN signin AS a
					ON a.id=qa_oyo_inbound_sale_feedback.manager_id
					LEFT JOIN qa_oyo_inbound_sale_agent_review ON qa_oyo_inbound_sale_agent_review.reviewer_id=qa_oyo_inbound_sale_feedback.agent_id
					WHERE agent_id='.$current_user.' and (entry_date BETWEEN "'.$form_data['from_date'].'" AND "'.$todate.'")');
					
			}
			else
			{
				$query = $this->db->query('SELECT qa_oyo_inbound_sale_feedback.id,qa_oyo_inbound_sale_feedback.agent_id,qa_oyo_inbound_sale_feedback.agent_name,qa_oyo_inbound_sale_feedback.team_leader_id,CONCAT(signin.fname," ",signin.lname) AS team_leader_name,qa_oyo_inbound_sale_feedback.manager_id,CONCAT(a.fname," ",a.lname) AS manager_name,qa_oyo_inbound_sale_feedback.client_name,qa_oyo_inbound_sale_feedback.record_date_time,qa_oyo_inbound_sale_feedback.booking_id,qa_oyo_inbound_sale_feedback.attach_file,overall_result,overall_score FROM `qa_oyo_inbound_sale_feedback` LEFT JOIN
				signin ON signin.id=qa_oyo_inbound_sale_feedback.team_leader_id
				LEFT JOIN signin AS a
				ON a.id=qa_oyo_inbound_sale_feedback.manager_id WHERE (entry_date BETWEEN "'.$form_data['from_date'].'" AND "'.$todate.'")');
				
				echo $query;
			}
		
		
		
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/search_inbound_sales.php";
			$data["from_date"] = $form_data['from_date'];
			$data["to_date"] = $form_data['to_date'];
			$data["inbound_infos"] = $query->result_object();
			$this->load->view('dashboard',$data);
		}
	}
	
	public function inbound_manager_review($id)
	{
		if(check_logged_in()){
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/show_inbound_sales.php";
			$query = $this->db->query('SELECT qa_oyo_inbound_sale_feedback.*,CONCAT(signin.fname," ",signin.lname) AS team_leader_name,CONCAT(a.fname," ",a.lname) AS manager_name FROM `qa_oyo_inbound_sale_feedback` LEFT JOIN
				signin ON signin.id=qa_oyo_inbound_sale_feedback.team_leader_id
				LEFT JOIN signin AS a
				ON a.id=qa_oyo_inbound_sale_feedback.manager_id WHERE qa_oyo_inbound_sale_feedback.id='.$id.'');
				
			$data["get_result"] = $query->row();
			$data["user_type"] = 'tl';
			
			$query1 = $this->db->query('SELECT * FROM `qa_oyo_inbound_sale_agent_review` WHERE inbound_sale_feedback_id='.$id.'');
			$data["agent_reviews"] = $query1->result_object();
			$query2 = $this->db->query('SELECT * FROM `qa_oyo_inbound_sale_mngr_review` WHERE inbound_sale_feedback_id='.$id.'');
			$data["manager_reviews"] = $query2->result_object();
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function inbound_manager_edit($id)
	{
		if(check_logged_in()){
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/inbound_sales_edit.php";
			$query = $this->db->query('SELECT qa_oyo_inbound_sale_feedback.*,CONCAT(signin.fname," ",signin.lname) AS team_leader_name,CONCAT(a.fname," ",a.lname) AS manager_name FROM `qa_oyo_inbound_sale_feedback` LEFT JOIN
				signin ON signin.id=qa_oyo_inbound_sale_feedback.team_leader_id
				LEFT JOIN signin AS a
				ON a.id=qa_oyo_inbound_sale_feedback.manager_id WHERE qa_oyo_inbound_sale_feedback.id='.$id.'');
				
			$data["get_result"] = $query->row();
			$data["user_type"] = 'tl';
			
			$query1 = $this->db->query('SELECT * FROM `qa_oyo_inbound_sale_agent_review` WHERE inbound_sale_feedback_id='.$id.'');
			$data["agent_reviews"] = $query1->result_object();
			$query2 = $this->db->query('SELECT * FROM `qa_oyo_inbound_sale_mngr_review` WHERE inbound_sale_feedback_id='.$id.'');
			$data["manager_reviews"] = $query2->result_object();
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function process_review()
	{
		$form_data = $this->input->post();
		$current_user = get_user_id();
		if($form_data['review_type'] == 'agent')
		{
			$query = $this->db->query('INSERT INTO `qa_oyo_inbound_sale_agent_review`(`inbound_sale_feedback_id`, `reviewer_id`, `review_date`, `review`,`reviewer_type`,`added_by`,`added_date`) VALUES ("'.$form_data['id'].'","'.$form_data['reviewer_id'].'",now(),"'.$form_data['review'].'","agent","'.$current_user.'",now())');
		}
		else if($form_data['review_type'] == 'manager')
		{
			$query = $this->db->query('INSERT INTO `qa_oyo_inbound_sale_mngr_review`(`inbound_sale_feedback_id`, `reviewer_id`, `review_date`, `review`,`reviewer_type`,`coach_name`,`added_by`,`added_date`) VALUES ("'.$form_data['id'].'","'.$form_data['reviewer_id'].'",now(),"'.$form_data['review'].'","manager","'.$form_data['coach_name'].'","'.$current_user.'",now())');
		}
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function inbound_agent_review($id)
	{
		if(check_logged_in()){
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/show_inbound_sales.php";
			$query = $this->db->query('SELECT qa_oyo_inbound_sale_feedback.*,CONCAT(signin.fname," ",signin.lname) AS team_leader_name,CONCAT(a.fname," ",a.lname) AS manager_name FROM `qa_oyo_inbound_sale_feedback` LEFT JOIN
				signin ON signin.id=qa_oyo_inbound_sale_feedback.team_leader_id
				LEFT JOIN signin AS a
				ON a.id=qa_oyo_inbound_sale_feedback.manager_id WHERE qa_oyo_inbound_sale_feedback.id='.$id.'');
			
			$data["get_result"] = $query->row();
			$data["user_type"] = 'agent';
			
			$query1 = $this->db->query('SELECT * FROM `qa_oyo_inbound_sale_agent_review` WHERE inbound_sale_feedback_id='.$id.'');
			$data["agent_reviews"] = $query1->result_object();
			$query2 = $this->db->query('SELECT * FROM `qa_oyo_inbound_sale_mngr_review` WHERE inbound_sale_feedback_id='.$id.'');
			$data["manager_reviews"] = $query2->result_object();
			
			$this->load->view('dashboard',$data);
		}
	}
/*==============================================================================================*/
/*==============================================================================================*/
/*==============================================================================================*/
/////////////////////////////////////// OYO UK US ///////////////////////////////////////////////
/*==============================================================================================*/
	public function oyo_uk_us(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/uk_us/qa_uk_us_feedback.php";
			$data["content_js"] = "qa_oyo/uk_us_js.php";
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and (is_assign_process(id,171) or is_assign_process(id,181)) and status=1 $tl_mgnt_cond order by name";
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyo_uk_us_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["uk_us_data"] = $this->Common_model->get_query_result_array($qSql);
		/////////////////////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyo_uk_us_new_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["uk_us_new_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_uk_us($uk_us_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/uk_us/add_edit_uk_us.php";
			$data["content_js"] = "qa_oyo/uk_us_js.php";
			$data['uk_us_id']=$uk_us_id;
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and (is_assign_process(id,171) or is_assign_process(id,181)) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyo_uk_us_feedback where id='$uk_us_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["oyo_uk_us"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"booking_id" => $this->input->post('booking_id'),
					"call_duration" => $this->input->post('call_duration'),
					"avaya_id" => $this->input->post('avaya_id'),
					"phone" => $this->input->post('phone'),
					"type_audit" => $this->input->post('type_audit'),
					"geography_audit" => $this->input->post('geography_audit'),
					"cancel_sub_audit_type" => $this->input->post('cancel_sub_audit_type'),
					"acpt" => $this->input->post('acpt'),
					"call_type" => $this->input->post('call_type'),
					"can_automated" => $this->input->post('can_automated'),
					"call_sub_type" => $this->input->post('call_sub_type'),
					"agent_call_type" => $this->input->post('agent_call_type'),
					"agent_call_sub_type" => $this->input->post('agent_call_sub_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"prepay_adharance" => $this->input->post('prepay_adharance'),
					"overall_score" => $this->input->post('overall_score'),
					"delayed_opening" => $this->input->post('delayed_opening'),
					"was_opening_correct" => $this->input->post('was_opening_correct'),
					"agent_ask_further_assistance" => $this->input->post('agent_ask_further_assistance'),
					"was_closure_correct" => $this->input->post('was_closure_correct'),
					"grammatical_error" => $this->input->post('grammatical_error'),
					"MTI_observed_call" => $this->input->post('MTI_observed_call'),
					"display_active_listening" => $this->input->post('display_active_listening'),
					"agent_relevant_probing" => $this->input->post('agent_relevant_probing'),
					"agent_provide_correct_tariff" => $this->input->post('agent_provide_correct_tariff'),
					// "start_lowest_discount" => $this->input->post('start_lowest_discount'),
					// "offer_alternate_property" => $this->input->post('offer_alternate_property'),
					"pitch_additional_night" => $this->input->post('pitch_additional_night'),
					"create_call_urgency" => $this->input->post('create_call_urgency'),
					"give_property_details" => $this->input->post('give_property_details'),
					// "agent_check_lifeline" => $this->input->post('agent_check_lifeline'),
					"check_with_PM" => $this->input->post('check_with_PM'),
					"agent_summarize_call" => $this->input->post('agent_summarize_call'),
					"pitch_for_on_call" => $this->input->post('pitch_for_on_call'),
					"was_tagging_correct" => $this->input->post('was_tagging_correct'),
					"agent_adhere_to_SOP" => $this->input->post('agent_adhere_to_SOP'),
					"agent_provide_incorrect_info" => $this->input->post('agent_provide_incorrect_info'),
					"ZTP_call_observe" => $this->input->post('ZTP_call_observe'),
					"capture_correct_information" => $this->input->post('capture_correct_information'),
					"agent_give_mandatory_info" => $this->input->post('agent_give_mandatory_info'),
					"create_correct_booking" => $this->input->post('create_correct_booking'),
					// "acknowlegde_the_concern" => $this->input->post('acknowlegde_the_concern'),
					"agent_polite_on_call" => $this->input->post('agent_polite_on_call'),
					"show_emphaty_when_required" => $this->input->post('show_emphaty_when_required'),
					"take_customer_name_once" => $this->input->post('take_customer_name_once'),
					"any_dead_air_on_call" => $this->input->post('any_dead_air_on_call'),
					"follow_hold_procedure" => $this->input->post('follow_hold_procedure'),
					"energetic_through_call" => $this->input->post('energetic_through_call'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"level1_comment" => $this->input->post('level1_comment'),
					"level2" => $this->input->post('level2')
				);
				
				
				if($uk_us_id==0){
					
					$a = $this->uk_us_upload_files($_FILES['attach_file'], $path='./qa_files/qa_oyo_inter/oyo_uk_us/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_oyo_uk_us_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyo_uk_us_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyo_uk_us_feedback',$field_array1);
					
				}else{
					$field_array1=$this->input->post('data');
					if(!isset($field_array1['auditor_type'])){
						$field_array1['auditor_type'] = "";
					}
					$this->db->where('id', $uk_us_id);
					$this->db->update('qa_oyo_uk_us_feedback',$field_array);
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
					$this->db->where('id', $uk_us_id);
					$this->db->update('qa_oyo_uk_us_feedback',$field_array1);
					
				}
				
				redirect('qa_oyo/oyo_uk_us');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}


	public function add_edit_uk_us_new($uk_us_new_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/uk_us/add_edit_uk_us_new.php";
			$data["content_js"] = "qa_oyo/uk_us_js.php";
			$data['uk_us_new_id']=$uk_us_new_id;
			$tl_mgnt_cond='';
			
			if(is_access_qa_oyo_fd_entry()==true){
				$tl_mgnt_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$tl_mgnt_cond=" and assigned_to='$current_user'";
				}else{
					$tl_mgnt_cond="";
				}
			}
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and (is_assign_process(id,171) or is_assign_process(id,181)) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_oyo_uk_us_new_feedback where id='$uk_us_new_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["oyo_uk_us_new"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mdydt2mysql($this->input->post('call_date')),
					"booking_id" => $this->input->post('booking_id'),
					"call_duration" => $this->input->post('call_duration'),
					"avaya_id" => $this->input->post('avaya_id'),
					"phone" => $this->input->post('phone'),
					"type_audit" => $this->input->post('type_audit'),
					"geography_audit" => $this->input->post('geography_audit'),
					"cancel_sub_audit_type" => $this->input->post('cancel_sub_audit_type'),
					"acpt" => $this->input->post('acpt'),
					"property_code" => $this->input->post('property_code'),
					"agent_disposition" => $this->input->post('agent_disposition'),
					"qa_disposition" => $this->input->post('qa_disposition'),
					"call_type" => $this->input->post('call_type'),
					"can_automated" => $this->input->post('can_automated'),
					"call_sub_type" => $this->input->post('call_sub_type'),
					"agent_call_type" => $this->input->post('agent_call_type'),
					"agent_call_sub_type" => $this->input->post('agent_call_sub_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"prepay_adharance" => $this->input->post('prepay_adharance'),
					"payments_status" => $this->input->post('payments_status'),
					"property_type" => $this->input->post('property_type'),
					"overall_score" => $this->input->post('overall_score'),
					"delayed_opening" => $this->input->post('delayed_opening'),
					"was_opening_correct" => $this->input->post('was_opening_correct'),
					"agent_ask_further_assistance" => $this->input->post('agent_ask_further_assistance'),
					"was_closure_correct" => $this->input->post('was_closure_correct'),
					"grammatical_error" => $this->input->post('grammatical_error'),
					"MTI_observed_call" => $this->input->post('MTI_observed_call'),
					"display_active_listening" => $this->input->post('display_active_listening'),
					"agent_relevant_probing" => $this->input->post('agent_relevant_probing'),
					"agent_provide_correct_tariff" => $this->input->post('agent_provide_correct_tariff'),
					// "start_lowest_discount" => $this->input->post('start_lowest_discount'),
					// "offer_alternate_property" => $this->input->post('offer_alternate_property'),
					"pitch_additional_night" => $this->input->post('pitch_additional_night'),
					"create_call_urgency" => $this->input->post('create_call_urgency'),
					"give_property_details" => $this->input->post('give_property_details'),
					"customer_consent" => $this->input->post('customer_consent'),
					"check_with_PM" => $this->input->post('check_with_PM'),
					"agent_summarize_call" => $this->input->post('agent_summarize_call'),
					"pitch_for_on_call" => $this->input->post('pitch_for_on_call'),
					"was_tagging_correct" => $this->input->post('was_tagging_correct'),
					"ivr_information" => $this->input->post('ivr_information'),
					"payment_tat" => $this->input->post('payment_tat'),
					"agent_provide_incorrect_info" => $this->input->post('agent_provide_incorrect_info'),
					"agent_provide_incomplete_info" => $this->input->post('agent_provide_incomplete_info'),
					"unethical_booking" => $this->input->post('unethical_booking'),
					"wrong_booking" => $this->input->post('wrong_booking'),
					"force_booking" => $this->input->post('force_booking'),
					"duplicate_booking" => $this->input->post('duplicate_booking'),
					"agent_polite_on_call" => $this->input->post('agent_polite_on_call'),
					"show_emphaty_when_required" => $this->input->post('show_emphaty_when_required'),
					"take_customer_name_once" => $this->input->post('take_customer_name_once'),
					"any_dead_air_on_call" => $this->input->post('any_dead_air_on_call'),
					"follow_hold_procedure" => $this->input->post('follow_hold_procedure'),
					//"energetic_through_call" => $this->input->post('energetic_through_call'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"level1_comment" => $this->input->post('level1_comment'),
					"level2" => $this->input->post('level2')
					
				);
				
				
				if($uk_us_new_id==0){
					
					$a = $this->uk_us_upload_files($_FILES['attach_file'], $path='./qa_files/qa_oyo_inter/oyo_uk_us/');
					$field_array["attach_file"] = implode(',',$a);
					 $rowid= data_inserter('qa_oyo_uk_us_new_feedback',$field_array);
					//print_r($field_array);
					//exit;
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyo_uk_us_new_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_oyo_uk_us_new_feedback',$field_array1);
					
				}else{
					$field_array1=$this->input->post('data');
					if(!isset($field_array1['auditor_type'])){
						$field_array1['auditor_type'] = "";
					}
					$this->db->where('id', $uk_us_new_id);
					$this->db->update('qa_oyo_uk_us_new_feedback',$field_array);
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
					$this->db->where('id', $uk_us_new_id);
					$this->db->update('qa_oyo_uk_us_new_feedback',$field_array1);
					
				}
				
				redirect('qa_oyo/oyo_uk_us');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	
	private function uk_us_upload_files($files,$path){
        $config['upload_path'] = $path;
		$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
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
	
	
	public function agent_oyo_uk_us_fd()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/uk_us/agent_oyo_uk_us_fd.php";
			$data["content_js"] = "qa_oyo/uk_us_js.php";
			$data["agentUrl"] = "qa_oyo/agent_oyo_uk_us_fd";

			$from_date = '';
			$to_date = '';
			$campaign="";
			$cond="";
			$cond1="";
			
			$campaign = $this->input->get('campaign');
			
			if($campaign!=""){
				
				$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user' $cond1 And audit_type in ('CQ Audit', 'BQ Audit', 'Pre-Certificate Mock Call', 'Certificate Audit')";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user' $cond1 And audit_type in ('CQ Audit', 'BQ Audit', 'Pre-Certificate Mock Call', 'Certificate Audit')";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
				if($this->input->get('btnView')=='View')
				{
				
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);

					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);

					if($fromDate !="" && $toDate!=="" ){
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit','Calibration', 'Operation Audit', 'Trainer Audit') ";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Calibration','Operation Audit', 'Trainer Audit') ";
					}
					
					
					$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["agent_oyo_list"] = $this->Common_model->get_query_result_array($qSql);
				
				}
				
			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;	
			$data['campaign']=$campaign;		
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_oyo_uk_us_new_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['uk_us_new_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/uk_us/agent_oyo_uk_us_new_rvw.php";
			$data["content_js"] = "qa_oyo/uk_us_js.php";
			$data["agentUrl"] = "qa_oyo/agent_oyo_uk_us_fd";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyo_uk_us_new_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["oyo_uk_us_new"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_oyo_uk_us_new_feedback',$field_array1);
					
				redirect('Qa_oyo/agent_oyo_uk_us_fd');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_oyo_uk_us_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['uk_us_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_oyo/uk_us/agent_oyo_uk_us_rvw.php";
			$data["content_js"] = "qa_oyo/uk_us_js.php";
			$data["agentUrl"] = "qa_oyo/agent_oyo_uk_us_fd";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyo_uk_us_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["oyo_uk_us"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_oyo_uk_us_feedback',$field_array1);
					
				redirect('Qa_oyo/agent_oyo_uk_us_fd');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

/*==============================================================================================*/
/*==============================================================================================*/
/*==============================================================================================*/
/////////////////////////////////////// OYO WALLET RECHARGE ///////////////////////////////////////////////
/*==============================================================================================*/
public function oyo_wallet_recharge(){
	if(check_logged_in())
	{
		$current_user = get_user_id();
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_oyo/wallet_recharge/qa_wallet_recharge_feedback.php";
		$data["content_js"] = "qa_oyo/uk_us_js.php";
		$tl_mgnt_cond='';
		
		if(is_access_qa_oyo_fd_entry()==true){
			$tl_mgnt_cond="";
		}else{
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
		}
		
		$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,651) and status=1 $tl_mgnt_cond order by name";
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
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
		if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$ops_cond=" Where assigned_to='$current_user'";
		}else{
			$ops_cond="";
		}
	
	/////////////////////////
		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_oyo_wallet_recharge_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
		$data["wallet_recharge_data"] = $this->Common_model->get_query_result_array($qSql);
		//print_r($data["wallet_recharge_data"]);
		//exit;
		$data["from_date"] = $from_date;
		$data["to_date"] = $to_date;
		$data["agent_id"] = $agent_id;
		
		$this->load->view("dashboard",$data);
	}
}
public function add_edit_wallet_recharge($wallet_recharge_id){
	if(check_logged_in())
	{
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_oyo/wallet_recharge/add_edit_wallet_recharge.php";
		$data["content_js"] = "qa_oyo/uk_us_js.php";
		$data['wallet_recharge_id']=$wallet_recharge_id;
		$tl_mgnt_cond='';
		
		if(is_access_qa_oyo_fd_entry()==true){
			$tl_mgnt_cond="";
		}else{
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
		}
		$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,651) and status=1 $tl_mgnt_cond order by name";
		$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
		$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_oyo_wallet_recharge_feedback where id='$wallet_recharge_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		$data["wallet_recharge"] = $this->Common_model->get_query_row_array($qSql);
		
		//$currDate=CurrDate();
		$curDateTime=CurrMySqlDate();
		$a = array();
		
		if($this->input->post('agent_id')){
			
			$field_array=array(
				"agent_id" => $this->input->post('agent_id'),
				"tl_id" => $this->input->post('tl_id'),
				"call_date" => mdydt2mysql($this->input->post('call_date')),
				//"booking_id" => $this->input->post('booking_id'),
				"call_duration" => $this->input->post('call_duration'),
				"product" => $this->input->post('product'),
				"phone" => $this->input->post('phone'),
				"campaign" => $this->input->post('campaign'),
				"customer_voc" => $this->input->post('customer_voc'),
				"customer_sub_voc" => $this->input->post('customer_sub_voc'),
				"objection" => $this->input->post('objection'),
				"property_code" => $this->input->post('property_code'),
				"agent_disposition" => $this->input->post('agent_disposition'),
				"qa_disposition" => $this->input->post('qa_disposition'),
				"audit_type" => $this->input->post('audit_type'),
				"auditor_type" => $this->input->post('auditor_type'),
				"voc" => $this->input->post('voc'),
				"possible_score" => $this->input->post('possible_score'),
				"earned_score" => $this->input->post('earned_score'),
				"overall_score" => $this->input->post('overall_score'),
				"call_opening" => $this->input->post('call_opening'),
				"financials_system" => $this->input->post('financials_system'),
				"disposition" => $this->input->post('disposition'),
				"urgency_creation" => $this->input->post('urgency_creation'),
				"app_benefits" => $this->input->post('app_benefits'),
				"call_opening_cmnt" => $this->input->post('call_opening_cmnt'),
				"financials_system_cmnt" => $this->input->post('financials_system_cmnt'),
				"disposition_cmnt" => $this->input->post('disposition_cmnt'),
				"urgency_creation_cmnt" => $this->input->post('urgency_creation_cmnt'),
				"app_benefits_cmnt" => $this->input->post('app_benefits_cmnt'),
				"call_summary" => $this->input->post('call_summary'),
				"feedback" => $this->input->post('feedback'),
			
				
			);
			
			
			if($wallet_recharge_id==0){
				
				$a = $this->uk_us_upload_files($_FILES['attach_file'], $path='./qa_files/qa_oyo_inter/oyo_uk_us/');
				$field_array["attach_file"] = implode(',',$a);
				// print_r($field_array);
				// exit();
				$rowid= data_inserter('qa_oyo_wallet_recharge_feedback',$field_array);
				/////////
				$field_array2 = array(
					"audit_date" => CurrDate(),
					"entry_date" => getEstToLocalCurrUser($curDateTime),
					"audit_start_time" => getEstToLocalCurrUser($this->input->post('audit_start_time'))
				);
				$this->db->where('id', $rowid);
				$this->db->update('qa_oyo_wallet_recharge_feedback',$field_array2);
				///////////
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_oyo_wallet_recharge_feedback',$field_array1);
				
			}else{
				$field_array1=$this->input->post('data');
				if(!isset($field_array1['auditor_type'])){
					$field_array1['auditor_type'] = "";
				}
				$this->db->where('id', $wallet_recharge_id);
				$this->db->update('qa_oyo_wallet_recharge_feedback',$field_array);
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
				$this->db->where('id', $wallet_recharge_id);
				$this->db->update('qa_oyo_wallet_recharge_feedback',$field_array1);
				
			}
			
			redirect('qa_oyo/oyo_wallet_recharge');
		}
		$data["array"] = $a;
		$this->load->view("dashboard",$data);
	}
}

// public function add_edit_wallet_recharge($wallet_recharge_id){ 
// 	if(check_logged_in())
// 	{
// 		$current_user=get_user_id();
// 		$user_office_id=get_user_office_id();
		
// 		$data["aside_template"] = "qa/aside.php";
// 		$data["content_template"] = "qa_oyo/wallet_recharge/add_edit_wallet_recharge.php";
// 		$data["content_js"] = "qa_oyo/uk_us_js.php";
// 		$data['wallet_recharge_id']=$wallet_recharge_id;
// 		$tl_mgnt_cond='';
		
// 		if(is_access_qa_oyo_fd_entry()==true){
// 			$tl_mgnt_cond="";
// 		}else{
// 			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
// 				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
// 			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
// 				$tl_mgnt_cond=" and assigned_to='$current_user'";
// 			}else{
// 				$tl_mgnt_cond="";
// 			}
// 		}
// 		$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,90) and (is_assign_process(id,171) or is_assign_process(id,181)) and status=1 $tl_mgnt_cond order by name";
// 		$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
		
// 		$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
// 		$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
		
// 		echo $qSql = "SELECT * from
// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
// 			from qa_oyo_wallet_recharge_feedback where id='$wallet_recharge_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
// 		$data["oyo_wallet_recharge"] = $this->Common_model->get_query_row_array($qSql);
		
// 		$curDateTime=CurrMySqlDate();
// 		$a = array();
		
// 		if($this->input->post('btnSave') == "SAVE"){
			
// 			if($wallet_recharge_id==0){
				
// 				$field_array=$_POST['data'];
// 				$field_array = $this->input->post( 'data' );
// 				$field_array['audit_date'] = CurrDate();
// 				$field_array['call_date'] = mdydt2mysql($this->input->post('call_date'));
// 				$field_array['entry_date'] = $curDateTime;
// 				$field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );

// 				$a = $this->wallet_recharge_upload_files($_FILES['attach_file'], $path='./qa_files/qa_oyo_inter/oyo_uk_us/');
// 				 $field_array["attach_file"] = implode(',',$a);
				 
// 				 //print_r($field_array);
// 				 //die();
// 				$rowid = data_inserter('qa_oyo_wallet_recharge_feedback',$field_array);
				
// 			/////////
// 				if(get_login_type()=="client"){
// 					$field_array1 = array("client_entryby" => $current_user);
// 				}else{
// 					$field_array1 = array("entry_by" => $current_user);
// 				}
// 				$this->db->where('id', $rowid);
// 				$this->db->update('qa_oyo_wallet_recharge_feedback',$field_array1);
			
// 			}else{
				
// 				$field_array2=$_POST['data'];
// 				$field_array2 = $this->input->post( 'data' );
// 				$field_array2['call_date'] = mdydt2mysql($this->input->post('call_date'));
				
// 				$this->db->where('id', $wallet_recharge_id);
// 				$this->db->update('qa_oyo_wallet_recharge_feedback',$field_array2);
// 			/////////
// 				if(get_login_type()=="client"){
// 					$field_array1 = array(
// 						"client_rvw_by" => $current_user,
// 						"client_rvw_note" => $this->input->post('note'),
// 						"client_rvw_date" => $curDateTime
// 					);
// 				}else{
// 					$field_array1 = array(
// 						"mgnt_rvw_by" => $current_user,
// 						"mgnt_rvw_note" => $this->input->post('note'),
// 						"mgnt_rvw_date" => $curDateTime
// 					);
// 				}
// 				$this->db->where('id', $wallet_recharge_id);
// 				$this->db->update('qa_oyo_wallet_recharge_feedback',$field_array1);
// 			}
// 			redirect('qa_oyo/oyo_wallet_recharge');
// 		}
// 		$data["array"] = $a;
// 		$this->load->view("dashboard",$data);
// 	}
// }


private function wallet_recharge_upload_files($files,$path){
	$config['upload_path'] = $path;
	$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
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


public function agent_oyo_wallet_recharge_fd()
{
	if(check_logged_in())
	{
		$user_site_id= get_user_site_id();
		$role_id= get_role_id();
		$current_user = get_user_id();
		
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_oyo/wallet_recharge/agent_oyo_wallet_recharge_fd.php";
		$data["content_js"] = "qa_oyo/uk_us_js.php";
		$data["agentUrl"] = "qa_oyo/agent_oyo_wallet_recharge_fd";
		
		
		$qSql="Select count(id) as value from qa_oyo_wallet_recharge_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
		$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
		
		$qSql="Select count(id) as value from qa_oyo_wallet_recharge_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
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
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyo_wallet_recharge_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["agent_walletrecharge_list"] = $this->Common_model->get_query_result_array($qSql);
				
		}else{

			$qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyo_wallet_recharge_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
			$data["agent_walletrecharge_list"] = $this->Common_model->get_query_result_array($qSql);	

		}
		//echo'<pre>';print_r($qSql);die();

		$data["from_date"] = $from_date;
		$data["to_date"] = $to_date;			
		$this->load->view('dashboard',$data);
	}
}

public function agent_oyo_wallet_recharge_rvw($id){
	if(check_logged_in()){
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		$data['wallet_recharge_id']=$id;
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_oyo/wallet_recharge/agent_oyo_wallet_recharge_rvw.php";
		$data["content_js"] = "qa_oyo/uk_us_js.php";
		$data["agentUrl"] = "qa_oyo/agent_oyo_wallet_recharge_fd";
		
		$qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyo_wallet_recharge_feedback where id='$id') xx Left Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
		$data["wallet_recharge"] = $this->Common_model->get_query_row_array($qSql);
		
		$data["pnid"]=$id;
		
		if($this->input->post('pnid'))
		{
			$pnid=$this->input->post('pnid');
			$curDateTime=CurrMySqlDate();
			$log=get_logs();
				
			$field_array1=array(
				"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
				"agent_rvw_note" => $this->input->post('note'),
				"agent_rvw_date" => $curDateTime
			);
			$this->db->where('id', $pnid);
			$this->db->update('qa_oyo_wallet_recharge_feedback',$field_array1);
				
			redirect('Qa_oyo/agent_oyo_wallet_recharge_fd');
			
		}else{
			$this->load->view('dashboard',$data);
		}
	}
}
/*==============================================================================================*/
/////////////////////////////////////// OYO ESAL Audit ///////////////////////////////////////////////
/*==============================================================================================*/
public function oyo_esal(){
	if(check_logged_in())
	{
		$current_user = get_user_id();
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_oyo/esal/qa_esal_feedback.php";
		$data["content_js"] = "qa_oyo/uk_us_js.php";
		$tl_mgnt_cond='';
		
		if(is_access_qa_oyo_fd_entry()==true){
			$tl_mgnt_cond="";
		}else{
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
		}
		
		$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,171) and status=1 $tl_mgnt_cond order by name";
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
		
		if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
		if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
		
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$ops_cond=" Where assigned_to='$current_user'";
		}else{
			$ops_cond="";
		}
	
	/////////////////////////
		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_oyo_esal_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
		$data["esal_data"] = $this->Common_model->get_query_result_array($qSql);
		//print_r($data["wallet_recharge_data"]);
		//exit;
		$data["from_date"] = $from_date;
		$data["to_date"] = $to_date;
		$data["agent_id"] = $agent_id;
		
		$this->load->view("dashboard",$data);
	}
}
public function add_edit_esal($esal_id){
	if(check_logged_in())
	{
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_oyo/esal/add_edit_esal.php";
		$data["content_js"] = "qa_oyo/uk_us_js.php";
		$data['esal_id']=$esal_id;
		$tl_mgnt_cond='';
		
		if(is_access_qa_oyo_fd_entry()==true){
			$tl_mgnt_cond="";
		}else{
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
		}
		$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,171) and status=1 $tl_mgnt_cond order by name";
		$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
		$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_oyo_esal_feedback where id='$esal_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		$data["esal"] = $this->Common_model->get_query_row_array($qSql);
		
		//$currDate=CurrDate();
		$curDateTime=CurrMySqlDate();
		$a = array();
		
		if($this->input->post('agent_id')){
			
			$field_array=array(
				"agent_id" => $this->input->post('agent_id'),
				"tl_id" => $this->input->post('tl_id'),
				"call_date" => mdydt2mysql($this->input->post('call_date')),
				"call_duration" => $this->input->post('call_duration'),
				"booking_id" => $this->input->post('booking_id'),
				"phone_no" => $this->input->post('phone_no'),
				"disposition" => $this->input->post('disposition'),
				"correct_dispo" => $this->input->post('correct_dispo'),
				"wrong_dispo" => $this->input->post('wrong_dispo'),
				"audit_type" => $this->input->post('audit_type'),
				"auditor_type" => $this->input->post('auditor_type'),
				"voc" => $this->input->post('voc'),
				"possible_score" => $this->input->post('possible_score'),
				"earned_score" => $this->input->post('earned_score'),
				"overall_score" => $this->input->post('overall_score'),
				"amenities_features" => $this->input->post('amenities_features'),
				"acknowledge" => $this->input->post('acknowledge'),
				"closing_statement" => $this->input->post('closing_statement'),
				"rejection" => $this->input->post('rejection'),
				"rebuttals" => $this->input->post('rebuttals'),
				"alternate_property" => $this->input->post('alternate_property'),
				"pm_required" => $this->input->post('pm_required'),
				"effectively_pitch" => $this->input->post('effectively_pitch'),
				"proactively" => $this->input->post('proactively'),
				"call_payment" => $this->input->post('call_payment'),
				"personalized" => $this->input->post('personalized'),
				"further_assistance" => $this->input->post('further_assistance'),
				"active_listening" => $this->input->post('active_listening'),
				"correct_opening" => $this->input->post('correct_opening'),
				"polite_corteous" => $this->input->post('polite_corteous'),
				"voice_tone" => $this->input->post('voice_tone'),
				"hold_procedure" => $this->input->post('hold_procedure'),
				"acpt" => $this->input->post('acpt'),
				"l1" => $this->input->post('l1'),
				"l2" => $this->input->post('l2'),
				"l3" => $this->input->post('l3'),
				"cmt1" => $this->input->post('cmt1'),
				"cmt2" => $this->input->post('cmt2'),
				"cmt3" => $this->input->post('cmt3'),
				"cmt4" => $this->input->post('cmt4'),
				"cmt5" => $this->input->post('cmt5'),
				"cmt6" => $this->input->post('cmt6'),
				"cmt7" => $this->input->post('cmt7'),
				"cmt8" => $this->input->post('cmt8'),
				"cmt9" => $this->input->post('cmt9'),
				"cmt10" => $this->input->post('cmt10'),
				"cmt11" => $this->input->post('cmt11'),
				"cmt12" => $this->input->post('cmt12'),
				"cmt13" => $this->input->post('cmt13'),
				"cmt14" => $this->input->post('cmt14'),
				"cmt15" => $this->input->post('cmt15'),
				"cmt16" => $this->input->post('cmt16'),
				"cmt17" => $this->input->post('cmt17'),
				"call_summary" => $this->input->post('call_summary'),
				"feedback" => $this->input->post('feedback'),
			
				
			);
			
			
			if($esal_id==0){
				
				$a = $this->esal_upload_files($_FILES['attach_file'], $path='./qa_files/qa_oyo_internal/oyo_esal/');
				$field_array["attach_file"] = implode(',',$a);
				// print_r($field_array);
				// exit();
				$rowid= data_inserter('qa_oyo_esal_feedback',$field_array);
				/////////
				$field_array2 = array(
					"audit_date" => CurrDate(),
					"entry_date" => getEstToLocalCurrUser($curDateTime),
					"audit_start_time" => getEstToLocalCurrUser($this->input->post('audit_start_time'))
				);
				$this->db->where('id', $rowid);
				$this->db->update('qa_oyo_esal_feedback',$field_array2);
				///////////
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_oyo_esal_feedback',$field_array1);
				
			}else{
				$field_array1=$this->input->post('data');
				if(!isset($field_array1['auditor_type'])){
					$field_array1['auditor_type'] = "";
				}
				$this->db->where('id', $esal_id);
				$this->db->update('qa_oyo_esal_feedback',$field_array);
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
				$this->db->where('id', $esal_id);
				$this->db->update('qa_oyo_esal_feedback',$field_array1);
				
			}
			
			redirect('qa_oyo/oyo_esal');
		}
		$data["array"] = $a;
		$this->load->view("dashboard",$data);
	}
}

private function esal_upload_files($files,$path){
	$config['upload_path'] = $path;
	$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav';
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


// public function agent_oyo_esal_fd()
// {
// 	if(check_logged_in())
// 	{
// 		$user_site_id= get_user_site_id();
// 		$role_id= get_role_id();
// 		$current_user = get_user_id();
		
// 		$data["aside_template"] = "qa/aside.php";
// 		$data["content_template"] = "qa_oyo/esal/agent_oyo_esal_fd.php";
// 		$data["content_js"] = "qa_oyo/uk_us_js.php";
// 		$data["agentUrl"] = "qa_oyo/agent_oyo_esal_fd";
		
		
// 		$qSql="Select count(id) as value from qa_oyo_esal_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
// 		$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
		
// 		$qSql="Select count(id) as value from qa_oyo_esal_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit') and agent_rvw_date is Null";
// 		$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
// 		$from_date = '';
// 		$to_date = '';
// 		$cond="";
		
		
// 		if($this->input->get('btnView')=='View')
// 		{
// 			$from_date = mmddyy2mysql($this->input->get('from_date'));
// 			$to_date = mmddyy2mysql($this->input->get('to_date'));
			
// 			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			
// 			$qSql = "SELECT * from
// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyo_esal_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
// 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
// 			$data["agent_esal_list"] = $this->Common_model->get_query_result_array($qSql);
				
// 		}else{

// 			$qSql="SELECT * from
// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyo_esal_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Left Join
// 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
// 			$data["agent_esal_list"] = $this->Common_model->get_query_result_array($qSql);	

// 		}
// 		//echo'<pre>';print_r($qSql);die();

// 		$data["from_date"] = $from_date;
// 		$data["to_date"] = $to_date;			
// 		$this->load->view('dashboard',$data);
// 	}
// }

public function agent_oyo_esal_rvw($id){
	if(check_logged_in()){
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		$data['wallet_recharge_id']=$id;
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_oyo/esal/agent_oyo_esal_rvw.php";
		$data["content_js"] = "qa_oyo/uk_us_js.php";
		$data["agentUrl"] = "qa_oyo/agent_oyo_uk_us_fd";
		
		$qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_oyo_esal_feedback where id='$id') xx Left Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
		$data["esal"] = $this->Common_model->get_query_row_array($qSql);
		
		$data["pnid"]=$id;
		
		if($this->input->post('pnid'))
		{
			$pnid=$this->input->post('pnid');
			$curDateTime=CurrMySqlDate();
			$log=get_logs();
				
			$field_array1=array(
				"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
				"agent_rvw_note" => $this->input->post('note'),
				"agent_rvw_date" => $curDateTime
			);
			$this->db->where('id', $pnid);
			$this->db->update('qa_oyo_esal_feedback',$field_array1);
				
			redirect('Qa_oyo/agent_oyo_uk_us_fd');
			
		}else{
			$this->load->view('dashboard',$data);
		}
	}
}
	
}