<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Naps extends CI_Controller {

	private $aside = "naps/aside.php";
	function __construct() {
		parent::__construct();
		
		//$this->load->helper(array('form', 'url','dfr_functions'));
		$this->load->model('Common_model');
		$this->load->model('Dfr_model');
		$this->load->model('Dfr_email_model');
		$this->load->model('Candidate_model');
		$this->load->model('Email_model');
		$this->load->model('Profile_model');
		$this->load->model('user_model');
		$this->load->library('excel');

	}
	public function index()
	{
		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$current_user = get_user_id();
		$data["aside_template"] = $this->aside;
		$is_global_access = get_global_access();
		$user_office_id=get_user_office_id();
		$reason =$this->input->get('reason');
		$_filterCond="";
		$start_date="";
		$end_date="";
		$status="";
		$dn_link="";
		$oValue="";


		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['reason'] = $reason;
		
		$sqlcl = "select * from dfr_reject_cause_list where status='A'";
		$data['cause_list'] = $this->Common_model->get_query_result_array($sqlcl);

		$data["content_template"] = "naps/report.php";
        $data["content_js"] = "naps_js.php";
         	
        
		if($this->input->get('btnView')=='View')
		{	
			$status = $this->input->get('stat');
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			if($start_date!="" && $end_date!=""){
				if($_filterCond=="") $_filterCond .= " and contract_date between '".$start_date."' and '".$end_date."'";
				else $_filterCond .= " And contract_date between '".$start_date."' and '".$end_date."'";
			}

			if($status!="")$_filterCond .= " and nap_stat ='".$status."'";
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue=$user_office_id;

			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}

			if($reason!=""){
				$_filterCond .= " And nap.rjct_reason = '".$reason."'";
			}

			$qSql= "Select r.id as rid,(select office_name from office_location where office_location.abbr = r.location ) as off_loc, (select org_role from role  where role.id = r.role_id ) as org_role,(select name from role rl where rl.id=r.role_id) as role_name, r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, (select concat(fname, ' ', lname) as name from signin vb where vb.id=c.doc_verify_by) as doc_verify_name from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id where  r.id=c.r_id and onboarding_type  = 'NAPS'".$_filterCond." ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
			//echo $qSql;
			$data["get_candidate_details"] = $fullAray = $this->Common_model->get_query_result_array($qSql);

			$this->create_Candidate_CSV($fullAray);
			$dn_link = base_url()."naps/downloadCandidateCsv";
			
		}	

		$data["status"] = $status;
		$data['oValue']=$oValue;
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;		
		$data['download_link']=$dn_link;
		
		$this->load->view('dashboard',$data);
	}

	public function new_candidates()
	{
		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$current_user = get_user_id();
		$data["aside_template"] = $this->aside;
		$is_global_access = get_global_access();
		$user_office_id=get_user_office_id();
		$_filterCond="";
		
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}

		$data['oValue']=$oValue;


		$data["content_template"] = "naps/new_candidates.php";
        $data["content_js"] = "naps_js.php";

        $qSql= "Select r.id as rid,(select office_name from office_location where office_location.abbr = r.location ) as off_loc,(select education_doc from dfr_qualification_details where candidate_id =c.id order by id  desc limit 0,1) as last_qualification_file, (select org_role from role  where role.id = r.role_id ) as org_role,(select name from role rl where rl.id=r.role_id) as role_name, r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, (select concat(fname, ' ', lname) as name from signin vb where vb.id=c.doc_verify_by) as doc_verify_name from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id where  r.id=c.r_id and onboarding_type  = 'NAPS' and nap_stat = 0".$_filterCond." ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;die();
		$data["get_candidate_details"] = $fullAray = $this->Common_model->get_query_result_array($qSql);			
		
		$this->load->view('dashboard',$data);
	}

	public function downloadCandidateCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report_naps_".get_user_id().".csv";
		$newfile="naps_report_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Candidate_CSV($rr)
	{
		// print_r($rr); exit;
		$filename = "./assets/reports/Report_naps_".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Requisition ID", "Location", "Position Applied For", "Hiring Source", "Source Name", "Candidate Name", "DOB", "Email", "Gender", "Phone", "Qualification", "Skill", "Total Exp", "Address", "Country", "State", "City", "Postcode", "Resume", "Summary", "Added By", "Candidate Status", "Signature", "Contract Period", "Contract Date", "Enrollment State", "Cotract Copy");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$c_status=$user['nap_stat'];
			//$a_status=$user['approved_status'];
			
			if($c_status=='0') $cstatus="Pending";
			else if($c_status=='1') $cstatus="Approved";
			else if($c_status=='2') $cstatus="Rejected";
			// else if($c_status=='3') $cstatus="Pending";
			// else if($c_status=='4') $cstatus="Add as an Employee";
			// else $cstatus="";
			
										
			$ref_name = $user['ref_name'];
			
			if($user['ref_id'] !="" ) $ref_name = $ref_name .", " . $user['ref_id'];
			
			$row = '"'.$user['requisition_id'].'",';  
			$row .= '"'.$user['off_loc'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['hiring_source'].'",'; 
			$row .= '"'.$ref_name.'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",';
			$row .= '"'.$user['dob'].'",';
			$row .= '"'.$user['email'].'",';
			$row .= '"'.$user['gender'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['last_qualification'].'",';
			$row .= '"'.$user['skill_set'].'",';
			$row .= '"'.$user['total_work_exp'].'",';
			$row .= '"'.$user['address'].'",';
			$row .= '"'.$user['country'].'",';
			$row .= '"'.$user['state'].'",';
			$row .= '"'.$user['city'].'",';
			$row .= '"'.$user['postcode'].'",';
			$row .= '"'.$user['attachment'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['summary'])).'",';
			$row .= '"'.$user['added_name'].'",';
			$row .= '"'.$cstatus.'",';
			$row .= '"'.$user['attachment_signature'].'",';
			$row .= '"'.$user['contract_period'].'",';
			$row .= '"'.$user['contract_date'].'",';
			$row .= '"'.$user['enroll_state'].'",';
			//$row .= '"'.$astatus.'",';
			$row .= '"'.$user['attachment_contract'].'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}

	public function get_dfr_details()
	{
		$can_id = $this->input->post('c_id');
		$qSql="SELECT * FROM dfr_candidate_details where id = $can_id";
		echo json_encode($this->Common_model->get_query_result_array($qSql));
	}

	public function process_aprv()
	{
		$candidate_id = $this->input->post('c_id');
		$contract_period = $this->input->post('contrct_period');
		$contrct_date = $this->input->post('contrct_date');
		$enroll_state = $this->input->post('enroll_state');
		$apprentice_registration_no = $this->input->post('apprentice_registration_no');
		$contract_registration_no 	= $this->input->post('contract_registration_no');
		$sector_name 				= $this->input->post('sector_name');
		$apprentice_type 			= $this->input->post('apprentice_type');

		$file_name = "";
		$error = "0";
		if(!empty($_FILES['contrct_cpy']['name'])){
			$file_name = $this->upload_file($candidate_id);
			if($file_name==""){
			$error = "1";
			}
		}

		if($error!=1){

			$uparray = array(
					"contract_date" => $contrct_date,
					"attachment_contract" => $file_name,
					"contract_period" => $contract_period,					
					"enroll_state" => $enroll_state,
					"apprentice_registration_no"=> $apprentice_registration_no,
					"contract_registration_no" => $contract_registration_no,
					"sector_name" => $sector_name,
					"apprentice_type" => $apprentice_type,
					"nap_stat" => 1
				);

				$this->db->where('dfr_id', $candidate_id);
				$this->db->update('dfr_naps_candidate_details',$uparray);

			$response = array('error'=>'no_error');
			echo json_encode($response);
		}
		else
		{
			$response = array('error'=>'file_error');
			echo json_encode($response);
		}



	}


	public function process_move()
	{
		$candidate_id = $this->input->post('c_id');
		$current_user_id = get_user_id();
		$currDate=date("Y-m-d H:i:s");
		$mv_comment = $this->input->post('comments');
		

		

			$uparray = array(
					"mv_comments" => $mv_comment,
					"move_on" => $currDate,
					"move_by" => $current_user_id,
					"onboarding_type" => "Regular"					
					
				);

				$this->db->where('id', $candidate_id);
				$this->db->update('dfr_candidate_details',$uparray);

			$response = array('error'=>'no_error');
			echo json_encode($response);
		



	}


	public function process_rjct()
	{
		$candidate_id = $this->input->post('rjct_c_id');
		$rjct_reason = $this->input->post('rjct_reason');
		$rjct_cmnt = $this->input->post('rjct_cmnt');
	
		$uparray = array(
				"rjct_cmnt" => $rjct_cmnt,
				"rjct_reason" => $rjct_reason,
				"nap_stat" => 2
			);

			$this->db->where('dfr_id', $candidate_id);
			$this->db->update('dfr_naps_candidate_details',$uparray);
	}


	public function aprv_candidates()
	{
		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";

		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		// $qSql="SELECT p.* FROM dfr_candidate_details as p where onboarding_type  = 'NAPS'";
		// $data['candidates_list'] = $this->Common_model->get_query_result_array($qSql);

		$data["content_template"] = "naps/approve_candidates.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = ''; 	
        $qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, (select concat(fname, ' ', lname) as name from signin vb where vb.id=c.doc_verify_by) as doc_verify_name from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id where  r.id=c.r_id and nap_stat = 1 and onboarding_type  = 'NAPS'".$_filterCond." ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;
		$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);

		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['oValue']=$oValue;
		
		$this->load->view('dashboard',$data);
	}

	public function rjcted_candidates()
	{
		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$current_user = get_user_id();
		$data["aside_template"] = $this->aside;
		$is_global_access = get_global_access();
		$user_office_id=get_user_office_id();
		$_filterCond="";
		$oValue = trim($this->input->get('office_id'));
		$cause = $this->input->get('cause');
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}
		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['oValue']=$oValue;
		// $qSql="SELECT p.* FROM dfr_candidate_details as p where onboarding_type  = 'NAPS'";
		// $data['candidates_list'] = $this->Common_model->get_query_result_array($qSql);
		$sql_c ="select * from dfr_reject_cause_list where status='A'";
		$data['cause_list']=$this->Common_model->get_query_result_array($sql_c);
		$data['cause']= $cause;
		if($cause!=""){
			$_filterCond .= " And nap.rjct_reason='".$cause."'";
		}
		
		$data["content_template"] = "naps/rejected_candidates.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = ''; 	
        $qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, (select concat(fname, ' ', lname) as name from signin vb where vb.id=c.doc_verify_by) as doc_verify_name from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id where  r.id=c.r_id and nap_stat = 2 and onboarding_type  = 'NAPS'".$_filterCond." ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;
		$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);

		
		$this->load->view('dashboard',$data);
	}

	public function upload_bg()
	{
		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";

		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		// $qSql="SELECT p.* FROM dfr_candidate_details as p where onboarding_type  = 'NAPS'";
		// $data['candidates_list'] = $this->Common_model->get_query_result_array($qSql);

		$data["content_template"] = "naps/upload_bg.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = ''; 	
        $qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, (select concat(fname, ' ', lname) as name from signin vb where vb.id=c.doc_verify_by) as doc_verify_name from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id where  r.id=c.r_id and nap_stat = 1 and onboarding_type  = 'NAPS'".$_filterCond." ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;
		$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);

		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$type =$this->input->get('type');
		$data['oValue']=$oValue;
		if($type=='download'){
			//$this->Download_Candidate_Bg_file($oValue);
		}
		
		$this->load->view('dashboard',$data);
	}

	public function get_dfr_naps_details()
	{
		$can_id = $this->input->post('c_id');
		$qSql="SELECT * FROM dfr_naps_candidate_details where dfr_id = $can_id";
		echo json_encode($this->Common_model->get_query_result_array($qSql));
	}
	public function get_dfr_cause_list(){
		$sqll = "select * from dfr_reject_cause_list where status='A'";
		$fc = $this->Common_model->get_query_result_array($sqll);
		foreach($fc as $key=>$rows){
	?>	
		<option value="<?php echo $rows['name'];?>"><?php echo $rows['name'];?></option>
	<?php	
		}
	}

	public function candidate_edit_details(){
		$id = $this->input->get('id');
		$sqldata = "select * from dfr_candidate_details where id= '".$id."'";
		$dt = $this->Common_model->get_query_result_array($sqldata);
		$data=array('phone_no'=>$dt[0]['phone'],'alt_phone'=>$dt[0]['alter_phone'],'aadhar'=>$dt[0]['adhar'],'pan'=>$dt[0]['pan']);
		echo json_encode($data);
	}

	public function process_aprvUpdate()
	{
		$candidate_id 				= $this->input->post('c_id');
		$contrct_date 				= $this->input->post('contrct_date');
		$enroll_state 				= $this->input->post('enroll_state');
		
		$file_name = "";
		$error = "0";
		if(!empty($_FILES['contrct_cpy']['name'])){
			$file_name = $this->upload_file($candidate_id);
			if($file_name==""){
			$error = "1";
			}
		}

		if($error!=1){

			$uparray = array(
					"contract_date" => $contrct_date,
					"attachment_contract" => $file_name,					
					"enroll_state" => $enroll_state
				);

				$this->db->where('dfr_id', $candidate_id);
				$this->db->update('dfr_naps_candidate_details',$uparray);

			$response = array('error'=>'no_error');
			echo json_encode($response);
		}
		else
		{
			$response = array('error'=>'file_error');
			echo json_encode($response);
		}



	}
	public function process_candidateUpdate(){
		$candidate_id 	= $this->input->post('can_id');
		$phone_no 		= $this->input->post('phone_no');
		$alter_phone 	= $this->input->post('alter_phone');
		$aadhar_no 		= $this->input->post('aadhar_no');
		$pan 			= $this->input->post('pan');
		$current_user 	= get_user_id();
		$current_date	= date('Y-m-d H:i:s');

		$uparray = array(
			"phone" => $phone_no,
			"alter_phone" => $alter_phone,					
			"adhar" => $aadhar_no,
			"pan" => $pan,
			"updated_by" =>$current_user,
			"updated_on" => $current_date,
			"candidate_status"=>'P'
		);
		//print_r($uparray);
		$this->db->where('id', $candidate_id);
		$this->db->update('dfr_candidate_details',$uparray);

		$datt =array('nap_stat'=>0);
		$this->db->where('dfr_id', $candidate_id);
		$this->db->update('dfr_naps_candidate_details',$datt);



	}



	private function upload_file($candidate_id)
	{
		// print_r($infos);
		// exit;
		//$BaseRealPath=$this->config->item('BaseRealPath');
		$config['upload_path'] = './uploads/naps_contract_copy/';
		
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['contrct_cpy']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $candidate_id."_contract_copy.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('contrct_cpy'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			$this->file_name = $this->upload->data('file_name');
			return "";
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
			return $this->upload->data('file_name');
		}
	}

	public function Download_declaration_file()
	{
		
		$filename = "Declaration file.xls";
		$title = "Declaration ";
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		

		$this->excel->getActiveSheet()->setCellValue('A2', 'Apprentice Registration No.');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Contract Registration No');
		$this->excel->getActiveSheet()->setCellValue('C2', 'Sector Name');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Apprentice Name.');
		$this->excel->getActiveSheet()->setCellValue('E2', 'Apprentice Type');
		$this->excel->getActiveSheet()->setCellValue('F2', 'BTP');
		$this->excel->getActiveSheet()->setCellValue('G2', 'Duration of Training (Mandatory Program Time,)');
		$this->excel->getActiveSheet()->setCellValue('H2', 'Start date of OJT Training');
		$this->excel->getActiveSheet()->setCellValue('I2', 'End Date of OJT Training');
		$this->excel->getActiveSheet()->setCellValue('J2', 'Contract Stipend');
		$this->excel->getActiveSheet()->setCellValue('K2', 'Prescribed Stipend');
		$this->excel->getActiveSheet()->setCellValue('L2', 'Payment Status');
		$this->excel->getActiveSheet()->setCellValue('M2', 'Amount of stipend to be paid as per norms');
		$this->excel->getActiveSheet()->setCellValue('N2', 'Amount of Stipend actually paid');
		$this->excel->getActiveSheet()->setCellValue('O2', 'Claim Amount ');
		$this->excel->getActiveSheet()->setCellValue('P2', 'Bank Transaction UTR No.');
		//$this->excel->getActiveSheet()->getColumnDimension('A2:P2')->setAutoSize(true);
		$j=3;
		$r=2;
		
		$_filterCond = "";
		//if($office_id!='ALL'){
			//$_filterCond ="AND r.location='".$office_id."'";
		//}

		
		
		$qSql= "Select np.*,c.*,r.location as office_id,x.doj as joining_date  from dfr_naps_candidate_details as np 
				LEFT JOIN dfr_candidate_details as c on c.id =np.dfr_id
				LEFT JOIN dfr_requisition as r on r.id=c.r_id 
				LEFT JOIN signin as x on x.dfr_id=c.id
		 		where nap_stat = 1 and onboarding_type  = 'NAPS' and bank_transaction_utr_no IS NULL ".$_filterCond." ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";					
		//echo $qSql;die();
		$npsdown = $this->Common_model->get_query_result_array($qSql);

		
		
		foreach($npsdown as $k=>$row):
		$r++;
		$sql_cal = "Select * from naps_claim_amount where from_date<='".$row['contract_date']."' and to_date>='".$row['contract_date']."' and status='A'";
		$calarr = $this->Common_model->get_query_result_array($sql_cal);
		$claim_amount = "";
		$amtspnorms ="";
		$amtactpaid="";
		$joining_Date = $row['joining_date'];
		

		if($joining_Date==""){
			$pday = $row['gross_pay']/30;
			$amtspnorms =round((30-date('d',strtotime($row['contract_date'])))*$pday,2);
			$amtactpaid = round((30-date('d',strtotime($row['contract_date'])))*$pday,2);
		}
		else
		{
			$pday = $row['gross_pay']/30;
			$amtspnorms =round((30-date('d',strtotime($joining_Date)))*$pday,2);
			$amtactpaid = round((30-date('d',strtotime($row['contract_date'])))*$pday,2);
		}
		 $sqlpt = "SELECT duration FROM `naps_program_table` 
				WHERE name='".$row['enroll_state']."' and from_date<='".$row['contract_date']."'
				AND to_date>='".$row['contract_date']."'";
		$dcal =	$this->Common_model->get_query_result_array($sqlpt);
			
		$endDate = date('Y-m-d', strtotime($row['contract_date']. ' +'.$dcal[0]['duration'].' days'));
			
		$calamt = ($amtactpaid*$calarr[0]['percentage'])/100;
		$claim_amount = ($calamt<$calarr[0]['max_amount'])?$calamt:$calarr[0]['max_amount'];
		
		$this->excel->getActiveSheet()->setCellValue('A'.$r, $row['apprentice_registration_no']);
		$this->excel->getActiveSheet()->setCellValue('B'.$r, $row['contract_registration_no']);
		$this->excel->getActiveSheet()->setCellValue('C'.$r, $row['sector_name']);
		$this->excel->getActiveSheet()->setCellValue('D'.$r, $row['fname'].' '.$row['lname']);
		$this->excel->getActiveSheet()->setCellValue('E'.$r, $row['apprentice_type']);
		$this->excel->getActiveSheet()->setCellValue('F'.$r, '');
		$this->excel->getActiveSheet()->setCellValue('G'.$r, '');
		$this->excel->getActiveSheet()->setCellValue('H'.$r, $row['contract_date']);
		$this->excel->getActiveSheet()->setCellValue('I'.$r, $endDate);
		$this->excel->getActiveSheet()->setCellValue('J'.$r, $row['gross_pay']);
		$this->excel->getActiveSheet()->setCellValue('K'.$r, '');
		$this->excel->getActiveSheet()->setCellValue('L'.$r, 'Pending');
		$this->excel->getActiveSheet()->setCellValue('M'.$r, $amtspnorms);
		$this->excel->getActiveSheet()->setCellValue('N'.$r, $amtactpaid);
		$this->excel->getActiveSheet()->setCellValue('O'.$r, $claim_amount);
		$this->excel->getActiveSheet()->setCellValue('P'.$r, '');
		//$this->excel->getActiveSheet()->getColumnDimension("A$r:P$r")->setAutoSize(true);
			$j++;
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$title.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
	public function upload_declaration()
	{
		 $user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";

		$data["aside_template"] = $this->aside;

		///content data
		$data["content_template"] = "naps/upload_declaraton.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = '';


		$uploadData = array();
		$this->load->library('upload');
		$uploadData = array();
		if(!empty($this->input->post('upload_file')))
		{		
			$outputFile = FCPATH ."uploads/naps_declaration/";
			$config = [
				'upload_path'   => $outputFile,
				'allowed_types' => 'xls',
				'max_size' => '1024000',
			];
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->overwrite = true;
			if (!$this->upload->do_upload('userfile'))
			{
				redirect($_SERVER['HTTP_REFERER']);
			}			
			$upload_data = $this->upload->data();
			$inputFileName = $outputFile .$upload_data['file_name'];

			//  Read your Excel workbook
			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0); 
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 1; $row <= $highestRow; $row++){ 
				//  Read a row of data into an array
				if($row>2){
					$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
					//  Insert row data array into your database of choice here
					$datas=array(
						'bank_transaction_utr_no'=>$rowData[0][15]
					);
					$this->db->where('apprentice_registration_no',$rowData[0][0]);
					$this->db->update('dfr_naps_candidate_details',$datas);
					//echo'<pre>';print_r($rowData[0][0]);
					$data['last_status']='success';
				}
			}
			redirect(base_url().'naps/declaration_list?m=success');
		}
		$this->load->view('dashboard',$data);	
		
			
	}
	public function upload_Bg_file()
	{
		// print_r($infos);
		// exit;
		//$BaseRealPath=$this->config->item('BaseRealPath');
		$dfr_id = $this->input->post('dfr_id');
		$config['upload_path'] = './uploads/naps_bg_files/';
		
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['bgfile']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $dfr_id."_bgfile.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('bgfile'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			$this->file_name = $this->upload->data('file_name');
			echo "Error On File Uploading";
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
			$datas=array('bgfiles'=>$this->file_name);
			$this->db->where('dfr_id',$dfr_id);
			$this->db->update('dfr_naps_candidate_details',$datas);
			 $this->upload->data('file_name');
			 echo "Successfully File Uploaded";
		}
	}
	public function coverage_report()
	{
		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";
		$stat = $this->input->get('stat');
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		if($stat!=""){
			$data['stat']=$stat;
		}
		if($start_date!=''){
			$data['start_date']=$start_date;
		}
		if($end_date!=''){
			$data['end_date']=$end_date;
		}
		
		$apprentice_registration_no = $this->input->get('apprentice_registration_no');

		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		
			
			if($start_date!="" && $end_date!=""){
				if($_filterCond=="") $_filterCond .= " and contract_date between '".$start_date."' and '".$end_date."'";
				else $_filterCond .= " And contract_date between '".$start_date."' and '".$end_date."'";
			}
			if($apprentice_registration_no!="")$_filterCond .= " and apprentice_registration_no ='".$apprentice_registration_no."'";
			if($status!="")$_filterCond .= " and nap_stat ='".$status."'";
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue=$user_office_id;

			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}

		// $qSql="SELECT p.* FROM dfr_candidate_details as p where onboarding_type  = 'NAPS'";
		// $data['candidates_list'] = $this->Common_model->get_query_result_array($qSql);

		$data["content_template"] = "naps/coverage_report.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = ''; 	
        $qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, 
					   r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, 
					   r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, 
					   DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  
					   (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, 
					   (select id as user_id from signin vb where vb.dfr_id=c.id) as userid,
					   (select released_date from user_resign ur where ur.user_id = userid) as releasedDate,
					   (select status as employee_status from signin xy where xy.dfr_id=c.id) as emp_status
					   from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id 
					   where  r.id=c.r_id and nap_stat = 1 and onboarding_type  = 'NAPS'".$_filterCond." 
					   ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;die();
		$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);

		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['apprentice_registration_no'] = $apprentice_registration_no;
		$type =$this->input->get('type');
		$data['oValue']=$oValue;
		if($type=='download'){
			$this->Download_Candidate_Bg_file($oValue);
		}
		
		$this->load->view('dashboard',$data);
	}

	public function eligible_candidate_report()
	{
		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";

		$stat = $this->input->get('stat');
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		if($start_date!=""){
			$data['start_date']=$start_date;
		}
		if($end_date!=""){
			$data['end_date']=$end_date;
		}
		if($stat!=""){
			$data['stat']=$stat;
		}
		
		$apprentice_registration_no = $this->input->get('apprentice_registration_no');
		$data['apprentice_registration_no'] = $apprentice_registration_no;
		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		if($start_date!="" && $end_date!=""){
			if($_filterCond=="") $_filterCond .= " and contract_date between '".$start_date."' and '".$end_date."'";
			else $_filterCond .= " And contract_date between '".$start_date."' and '".$end_date."'";
		}
		if($apprentice_registration_no!="")$_filterCond .= " and apprentice_registration_no ='".$apprentice_registration_no."'";
		if($status!="")$_filterCond .= " and nap_stat ='".$status."'";

		// $qSql="SELECT p.* FROM dfr_candidate_details as p where onboarding_type  = 'NAPS'";
		// $data['candidates_list'] = $this->Common_model->get_query_result_array($qSql);

		$data["content_template"] = "naps/eligible_candidate_report.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = ''; 	
        $qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, 
					   r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, 
					   r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, 
					   DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  
					   (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, 
					   (select id as user_id from signin vb where vb.dfr_id=c.id) as userid,
					   (select released_date from user_resign ur where ur.user_id = userid) as releasedDate,
					   (select status as employee_status from signin xy where xy.dfr_id=c.id) as emp_status
					   from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id 
					   where  r.id=c.r_id and nap_stat = 1 and onboarding_type  = 'NAPS'".$_filterCond." 
					   ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;
		$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);

		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$type =$this->input->get('type');
		$data['oValue']=$oValue;
		if($type=='download'){
			//$this->Download_Candidate_Bg_file($oValue);
		}
		
		$this->load->view('dashboard',$data);
	}
	public function missed_candidate_report()
	{
		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";

		$stat = $this->input->get('stat');
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		if($start_date!='') $data['start_date']=$start_date;
		if($end_date!='') $data['end_date']=$end_date;
		if($stat!=""){
			$data['stat']=$stat;
		}
		
		$apprentice_registration_no = $this->input->get('apprentice_registration_no');
		$data['apprentice_registration_no'] = $apprentice_registration_no;

		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		if($start_date!="" && $end_date!=""){
			if($_filterCond=="") $_filterCond .= " and contract_date between '".$start_date."' and '".$end_date."'";
			else $_filterCond .= " And contract_date between '".$start_date."' and '".$end_date."'";
		}
		if($apprentice_registration_no!="")$_filterCond .= " and apprentice_registration_no ='".$apprentice_registration_no."'";
		if($status!="")$_filterCond .= " and nap_stat ='".$status."'";

		// $qSql="SELECT p.* FROM dfr_candidate_details as p where onboarding_type  = 'NAPS'";
		// $data['candidates_list'] = $this->Common_model->get_query_result_array($qSql);

		$data["content_template"] = "naps/missed_candidate_report.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = ''; 	
        $qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, 
					   r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, 
					   r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, 
					   DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  
					   (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, 
					   (select id as user_id from signin vb where vb.dfr_id=c.id) as userid,
					   (select released_date from user_resign ur where ur.user_id = userid) as releasedDate,
					   (select status as employee_status from signin xy where xy.dfr_id=c.id) as emp_status
					   from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id 
					   where  r.id=c.r_id and nap_stat = 1 and onboarding_type  = 'NAPS'".$_filterCond." 
					   ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;
		$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);

		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$type =$this->input->get('type');
		$data['oValue']=$oValue;
		if($type=='download'){
			//$this->Download_Candidate_Bg_file($oValue);
		}
		
		$this->load->view('dashboard',$data);
	}
	public function declaration_list()
	{
		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";

		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		// $qSql="SELECT p.* FROM dfr_candidate_details as p where onboarding_type  = 'NAPS'";
		// $data['candidates_list'] = $this->Common_model->get_query_result_array($qSql);

		$data["content_template"] = "naps/declaration_list.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = ''; 
		$claim_amount = "";	
        $qSql= "Select np.*,c.*,r.location as office_id,x.doj as joining_date from dfr_naps_candidate_details as np 
				LEFT JOIN dfr_candidate_details as c on c.id =np.dfr_id
				LEFT JOIN dfr_requisition as r on r.id=c.r_id 
				LEFT JOIN signin as x on x.dfr_id=c.id
		 		where nap_stat = 1 and onboarding_type  = 'NAPS' ".$_filterCond." 
				 ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;

		$declaration_list = $this->Common_model->get_query_result_array($qSql);
		foreach($declaration_list as $k=>$row):
			$r++;
			$sql_cal = "Select * from naps_claim_amount where from_date<='".$row['contract_date']."' and to_date>='".$row['contract_date']."' and status='A'";
			$calarr = $this->Common_model->get_query_result_array($sql_cal);
			$amtspnorms ="";
			$amtactpaid="";
			$joining_Date = "2021-02-05";//$row['joining_date'];
			
			if($joining_Date==""){
				$pday = $row['gross_pay']/30;
				$amtspnorms =round((30-date('d',strtotime($row['contract_date'])))*$pday,2);
				$amtactpaid = round((30-date('d',strtotime($row['contract_date'])))*$pday,2);
			}
			else
			{
				$pday = $row['gross_pay']/30;
				$amtspnorms =round((30-date('d',strtotime($joining_Date)))*$pday,2);
				$amtactpaid = round((30-date('d',strtotime($row['contract_date'])))*$pday,2);
			}

			$calamt = ($amtactpaid*$calarr[0]['percentage'])/100;
			$claim_amount = ($calamt<$calarr[0]['max_amount'])?$calamt:$calarr[0]['max_amount'];

			$data['declaration_list'][$k]['apprentice_registration_no'] = $row['apprentice_registration_no'];
			$data['declaration_list'][$k]['contract_registration_no'] 	= $row['contract_registration_no'];
			$data['declaration_list'][$k]['sector_name'] 				= $row['sector_name'];
			$data['declaration_list'][$k]['name'] 						= $row['fname'].' '.$row['lname'];
			$data['declaration_list'][$k]['apprentice_type'] 			= $row['apprentice_type'];
			$data['declaration_list'][$k]['amtstp'] 					= $amtspnorms;
			$data['declaration_list'][$k]['amtstpapaid'] 				= $amtactpaid;
			$data['declaration_list'][$k]['gross_pay'] 					= $row['gross_pay'];
			$data['declaration_list'][$k]['claim_amount'] 				= $claim_amount;
			$data['declaration_list'][$k]['bank_transaction_utr_no'] 	= $row['bank_transaction_utr_no'];

		endforeach;

		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$type =$this->input->get('type');
		$data['oValue']=$oValue;
		
		$this->load->view('dashboard',$data);
	}
	public function setting_list(){
			// Prediefined
			$user_site_id= get_user_site_id();
		   $srole_id= get_role_id();
		   $is_global_access = get_global_access();
		   $current_user = get_user_id();
		   $user_office_id=get_user_office_id();
		   $_filterCond="";
   
		   $data["aside_template"] = $this->aside;
   
		   ///content data
		   $data["content_template"] = "naps/setting_list.php";
		   $data["content_js"] = "naps_js.php";
		   $data["error"] = '';
		   $sql_r = "Select * from naps_claim_amount where status='A'";
		   $data['setting_list'] = $this->Common_model->get_query_result_array($sql_r);
		   $this->load->view('dashboard',$data);
	}
	public function setting_edit_details(){
		$id = $this->input->get('id');
		$sqldata = "select * from naps_claim_amount where id= '".$id."'";
		$dt = $this->Common_model->get_query_result_array($sqldata);
		$data=array('percentage'=>$dt[0]['percentage'],'max_amount'=>$dt[0]['max_amount'],'from_date'=>$dt[0]['from_date'],'to_date'=>$dt[0]['to_date']);
		echo json_encode($data);
	}
	public function add_setting_claim_amount(){
		$percentage = $this->input->post('percentage');
		$max_amount = $this->input->post('max_amount');
		$from_date  = date('Y-m-d',strtotime($this->input->post('from_date')));
		$to_date    = date('Y-m-d',strtotime($this->input->post('to_date')));
		
		$data = array(
			'percentage'=>$percentage,
			'max_amount'=>$max_amount,
			'from_date'=>$from_date,
			'to_date'=>$to_date
		);
		$this->db->insert('naps_claim_amount',$data);
		$insert_id = $this->db->insert_id();
		if($insert_id>0){
			echo "Data Added Successfully";
		}	
		
	}
	public function edit_setting_claim_amount(){
		$id			= $this->input->post('can_id');
		$percentage = $this->input->post('percentage_edit');
		$max_amount = $this->input->post('max_amount_edit');
		$from_date  = date('Y-m-d',strtotime($this->input->post('from_date_edit')));
		$to_date    = date('Y-m-d',strtotime($this->input->post('to_date_edit')));
		
		$data = array(
			'percentage'=>$percentage,
			'max_amount'=>$max_amount,
			'from_date'=>$from_date,
			'to_date'=>$to_date
		);
		$this->db->trans_start();
		$this->db->where('id',$id);
		$this->db->update('naps_claim_amount',$data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			echo "Sorry Failed to Update Data";
		}
		else{
			echo "Data Updated Successfully";
		}	
		
	}
	public function Delete_setting_claim_amount(){
		$id = $this->input->get('id');
		$data=array('status'=>'D');
		$this->db->where('id',$id);
		$this->db->update('naps_claim_amount',$data);
		echo "Data Deleted Successfully";
	}
	public function program_master_list(){
		// Prediefined
		$user_site_id= get_user_site_id();
	   $srole_id= get_role_id();
	   $is_global_access = get_global_access();
	   $current_user = get_user_id();
	   $user_office_id=get_user_office_id();
	   $_filterCond="";

	   $data["aside_template"] = $this->aside;

	   ///content data
	   $data["content_template"] = "naps/program_master_list.php";
	   $data["content_js"] = "naps_js.php";
	   $data["error"] = '';
	   $sql_r = "Select * from naps_program_table where status='A'";
	   $data['program_list'] = $this->Common_model->get_query_result_array($sql_r);
	   $this->load->view('dashboard',$data);
	}
	public function add_program_master(){
		$name 		= $this->input->post('name');
		$duration 	= $this->input->post('duration');
		$from_date  = date('Y-m-d',strtotime($this->input->post('from_date')));
		$to_date    = date('Y-m-d',strtotime($this->input->post('to_date')));
		
		$data = array(
			'name'=>$name,
			'duration'=>$duration,
			'from_date'=>$from_date,
			'to_date'=>$to_date
		);
		$this->db->insert('naps_program_table',$data);
		$insert_id = $this->db->insert_id();
		if($insert_id>0){
			echo "Data Added Successfully";
		}	
		
	}
	public function edit_program_master(){
		$id			= $this->input->post('can_id');
		$name = $this->input->post('name_edit');
		$duration = $this->input->post('duration_edit');
		$from_date  = date('Y-m-d',strtotime($this->input->post('from_date_edit')));
		$to_date    = date('Y-m-d',strtotime($this->input->post('to_date_edit')));
		
		$data = array(
			'name'=>$name,
			'duration'=>$duration,
			'from_date'=>$from_date,
			'to_date'=>$to_date
		);
		$this->db->trans_start();
		$this->db->where('id',$id);
		$this->db->update('naps_program_table',$data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			echo "Sorry Failed to Update Data";
		}
		else{
			echo "Data Updated Successfully";
		}	
		
	}
	public function Delete_program_master(){
		$id = $this->input->get('id');
		$data=array('status'=>'D');
		$this->db->where('id',$id);
		$this->db->update('naps_program_table',$data);
		echo "Data Deleted Successfully";
	}
	public function program_edit_details(){
		$id = $this->input->get('id');
		$sqldata = "select * from naps_program_table where id= '".$id."'";
		$dt = $this->Common_model->get_query_result_array($sqldata);
		$data=array('name'=>$dt[0]['name'],'duration'=>$dt[0]['duration'],'from_date'=>$dt[0]['from_date'],'to_date'=>$dt[0]['to_date']);
		echo json_encode($data);		
	}
	public function Registration_list(){

		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";
		$aadhar_no = $this->input->get('aadhar_no');
		$phone_no = $this->input->get('phone_no');
		$data['aadhar_no'] = $aadhar_no;
		$data['phone_no'] = $phone_no;
		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$data['start_date'] = $start_date;
		$data['end_date'] =$end_date ;
		if($start_date!="" && $end_date!=""){
			if($_filterCond=="") $_filterCond .= " and c.dob between '".$start_date."' and '".$end_date."'";
			else $_filterCond .= " And c.dob between '".$start_date."' and '".$end_date."'";
		}
		if($aadhar_no!="")$_filterCond .= " and adhar='".$aadhar_no."'";
		if($phone_no!="")$_filterCond .= " and phone='".$phone_no."'";

		$data["content_template"] = "naps/registration_list.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = ''; 	
        $qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role,
		(select name from role  where role.id = r.role_id ) as role_name, 
					   r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, 
					   r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*,edu.*, c.id as can_id, 
					   DATE_FORMAT(c.dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(c.doj,'%m/%d/%Y') as d_o_j,  
					   (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, 
					   (select id as user_id from signin vb where vb.dfr_id=c.id) as userid,
					   (select released_date from user_resign ur where ur.user_id = userid) as releasedDate,
					   (select status as employee_status from signin xy where xy.dfr_id=c.id) as emp_status,
					   x.fusion_id as employee_name
					   from dfr_requisition r, dfr_naps_candidate_details nap 
					   left join dfr_candidate_details c on nap.dfr_id = c.id 
					   Left join signin x on x.dfr_id=c.id
					   LEFT JOIN dfr_qualification_details edu on edu.candidate_id = c.id
					   where  r.id=c.r_id and nap_stat = 1 and onboarding_type  = 'NAPS'".$_filterCond." 
					   ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;die();
		$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);

		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$type =$this->input->get('type');
		$data['oValue']=$oValue;
		if($type=='download'){
			$this->Download_registration_file($data["get_candidate_details"]);
		}
		
		$this->load->view('dashboard',$data);
	}
	public function Download_registration_file($dataDetails){
		$filename = "Registration".date('Ymd')."file.xls";
		$title = "Registration ";
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(25);
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		

		$this->excel->getActiveSheet()->setCellValue('A2', 'Employee Code.');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Apprentice Name');
		$this->excel->getActiveSheet()->setCellValue('C2', 'Aadher_no');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Other_id_prof_type.');
		$this->excel->getActiveSheet()->setCellValue('E2', 'Other_id_prof_number');
		$this->excel->getActiveSheet()->setCellValue('F2', 'Father/Mather/Spouse Name');
		$this->excel->getActiveSheet()->setCellValue('G2', 'Relationship');
		$this->excel->getActiveSheet()->setCellValue('H2', 'Date Of Birth');
		$this->excel->getActiveSheet()->setCellValue('I2', 'Gender');
		$this->excel->getActiveSheet()->setCellValue('J2', 'Email');
		$this->excel->getActiveSheet()->setCellValue('K2', 'Phone Number');
		$this->excel->getActiveSheet()->setCellValue('L2', 'Address');
		$this->excel->getActiveSheet()->setCellValue('M2', 'Pin Code');
		$this->excel->getActiveSheet()->setCellValue('N2', 'State');
		$this->excel->getActiveSheet()->setCellValue('O2', 'District');
		$this->excel->getActiveSheet()->setCellValue('P2', 'Disability');
		$this->excel->getActiveSheet()->setCellValue('Q2', 'Category');
		$this->excel->getActiveSheet()->setCellValue('R2', 'Qualification');
		$this->excel->getActiveSheet()->setCellValue('S2', 'Qualification Type');
		$this->excel->getActiveSheet()->setCellValue('T2', 'Qualification Institute');
		$this->excel->getActiveSheet()->setCellValue('U2', 'Joining Date');
		$this->excel->getActiveSheet()->setCellValue('V2', 'Job Role');
		$this->excel->getActiveSheet()->setCellValue('W2', 'Stipend First');
		
		
		$j=3;
		$r=2;
		
		foreach($dataDetails as $k=>$row):
		$r++;
		
		$this->excel->getActiveSheet()->setCellValue('A'.$r, $row['employee_name']);
		$this->excel->getActiveSheet()->setCellValue('B'.$r, $row['fname'].' '.$row['lname']);
		$this->excel->getActiveSheet()->setCellValue('C'.$r, $row['adhar']);
		$this->excel->getActiveSheet()->setCellValue('D'.$r, "");
		$this->excel->getActiveSheet()->setCellValue('E'.$r, "");
		$this->excel->getActiveSheet()->setCellValue('F'.$r, $row['guardian_name']);
		$this->excel->getActiveSheet()->setCellValue('G'.$r, $row['relation_guardian']);
		$this->excel->getActiveSheet()->setCellValue('H'.$r, $row['dob']);
		$this->excel->getActiveSheet()->setCellValue('I'.$r, $row['gender']);
		$this->excel->getActiveSheet()->setCellValue('J'.$r, $row['email']);
		$this->excel->getActiveSheet()->setCellValue('K'.$r, $row['phone']);
		$this->excel->getActiveSheet()->setCellValue('L'.$r, $row['address']);
		$this->excel->getActiveSheet()->setCellValue('M'.$r, $row['postcode']);
		$this->excel->getActiveSheet()->setCellValue('N'.$r, $row['state']);
		$this->excel->getActiveSheet()->setCellValue('O'.$r, "");
		$this->excel->getActiveSheet()->setCellValue('P'.$r, 'NO');
		$this->excel->getActiveSheet()->setCellValue('Q'.$r, $row['caste']);
		$this->excel->getActiveSheet()->setCellValue('R'.$r, $row['last_qualification']);
		$this->excel->getActiveSheet()->setCellValue('S'.$r, $row['specialization']);
		$this->excel->getActiveSheet()->setCellValue('T'.$r, $row['board_uv']);
		$this->excel->getActiveSheet()->setCellValue('U'.$r, $row['doj']);
		$this->excel->getActiveSheet()->setCellValue('V'.$r, $row['role_name']);
		$this->excel->getActiveSheet()->setCellValue('W'.$r, $row['gross_pay']);
		//$this->excel->getActiveSheet()->getColumnDimension("A$r:P$r")->setAutoSize(true);
			$j++;
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$title.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		
		$objWriter->save('php://output');
	}
	public function download_coverage_report(){
		$filename = "Coverage_report".date('Ymd')."file.xls";
		$title = "Coverage Report ";
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		

		$this->excel->getActiveSheet()->setCellValue('A2', 'SL No');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Apprentice Registration No');
		$this->excel->getActiveSheet()->setCellValue('C2', 'Candidate Name');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Last Qualification');
		$this->excel->getActiveSheet()->setCellValue('E2', 'Gender');
		$this->excel->getActiveSheet()->setCellValue('F2', 'Mobile');
		$this->excel->getActiveSheet()->setCellValue('G2', 'Contract Date');
		$this->excel->getActiveSheet()->setCellValue('H2', 'Quarter Coverage');
		$this->excel->getActiveSheet()->setCellValue('I2', 'No Of Quarter Cover');
		
		/****************************************query erea**************************/

		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";
		$stat = $this->input->get('stat');
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		if($stat!=""){
			$data['stat']=$stat;
		}
		if($start_date!=''){
			$data['start_date']=$start_date;
		}
		if($end_date!=''){
			$data['end_date']=$end_date;
		}
		
		$apprentice_registration_no = $this->input->get('apprentice_registration_no');

		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		
			
			if($start_date!="" && $end_date!=""){
				if($_filterCond=="") $_filterCond .= " and contract_date between '".$start_date."' and '".$end_date."'";
				else $_filterCond .= " And contract_date between '".$start_date."' and '".$end_date."'";
			}
			if($apprentice_registration_no!="")$_filterCond .= " and apprentice_registration_no ='".$apprentice_registration_no."'";
			if($status!="")$_filterCond .= " and nap_stat ='".$status."'";
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue=$user_office_id;

			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}

	
        $qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, 
					   r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, 
					   r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, 
					   DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  
					   (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, 
					   (select id as user_id from signin vb where vb.dfr_id=c.id) as userid,
					   (select released_date from user_resign ur where ur.user_id = userid) as releasedDate,
					   (select status as employee_status from signin xy where xy.dfr_id=c.id) as emp_status
					   from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id 
					   where  r.id=c.r_id and nap_stat = 1 and onboarding_type  = 'NAPS'".$_filterCond." 
					   ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;die();
		$get_candidate_details = $this->Common_model->get_query_result_array($qSql);

		//echo'<pre>';print_r($get_candidate_details);die();
		/****************************************************************************/
		
		$j=3;
		$r=2;
		$p=0;
		foreach($get_candidate_details as $cd): 
		    //echo'<pre>';print_r($cd);
			$r_id=$cd['r_id'];
			$c_id=$cd['can_id'];
			$c_status = $cd['candidate_status'];
			$gross_pay = $cd['gross_pay'];
			
			// if($c_status=='P')	$cstatus="Pending";
			// else if($c_status=='IP')	$cstatus="In Progress";
			// else if($c_status=='SL')	$cstatus="Shortlisted";
			// else if($c_status=='CS')	$cstatus="Selected";
			// else if( $c_status=='E') $cstatus="Selected as Employee";
			// else if($c_status=='R') $cstatus="Rejected";
			// else if($c_status=='D') $cstatus="Dropped";
			
			if($cd['attachment_contract']!='') $viewContract='View Contact Copy';
			else $viewContract='';

			if($cd['attachment']!='') $viewResume='View Resume';
			else $viewResume='';

			if($c_status=='CS'){
				$bold="style='font-weight:bold; color:#041ad3'";
			}else if($c_status=='E'){
				$bold="style='font-weight:bold; color:#013220'";
			}else if($c_status=='R'){
				$bold="style='font-weight:bold; color:red'";
			}else{
				$bold="";
			}
			$qtrcover = "";
			$ctdate ="";
			$qtrcoverdisp = "";
			$quarters = array("1"=>"JFM","2"=>"AMJ","3"=>"JAS","4"=>"OND");
			$qtr  = date('md',strtotime($cd['contract_date']));
			if($qtr>='0101'&& $qtr<='0110'){
				$qtrcover =  "JFM";
				$ctdate = '01-01-'.date('Y',strtotime($cd['contract_date']));
			}
			elseif($qtr>='0111'&& $qtr<='0410'){
				$qtrcover =  "AMJ";
				$ctdate = '01-04-'.date('Y',strtotime($cd['contract_date']));
			}
			elseif($qtr>='0411'&& $qtr<='0710'){
				$qtrcover =  "JAS";
				$ctdate = '01-07-'.date('Y',strtotime($cd['contract_date']));
			}
			elseif($qtr>='0711'&& $qtr<='1010'){
				$qtrcover =  "OND";
				$ctdate = '01-10-'.date('Y',strtotime($cd['contract_date']));
			}
			elseif($qtr>='1011'&& $qtr<='1231'){
				$qtrcover =  "JFM";
			}
			$arr  = array_search($qtrcover,$quarters);
			
			if($cd['emp_status']=="" or $cd['emp_status']==1){

			 $date1 = $ctdate;
			 $date2 = date('Y-m-d');

			$ts1 = strtotime($date1);
			$ts2 = strtotime($date2);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
			$num_cover = floor(($diff/3));
			$num_cover = ($num_cover<0)?0:$num_cover;
			
			}
			if($cd['releasedDate']!=""){
				$date1 = $ctdate;
			 $date2 = $cd['releasedDate'];//date('Y-m-d');

			$ts1 = strtotime($date1);
			$ts2 = strtotime($date2);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
			$num_cover = floor(($diff/3));
			}
			$t=$arr;
				$cnt  =(($num_cover+$arr)-1);
				for($i=$arr;$i<=$cnt;$i++){
					if($qtrcoverdisp==""){
						$qtrcoverdisp = $quarters[$t];
					}
					else
					{
						$qtrcoverdisp = $qtrcoverdisp.','.$quarters[$t];
					}
					$t++;
					if($t>4){
						$t=1;
					}	
				}
				$ch=1;
			if($stat!=""){
				
				 $qtrcov = " ".$qtrcoverdisp;
				 $ch = strpos($qtrcov,$stat);
			}
			if($ch!=""){
				$r++;
				$p++;
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $p);
				$this->excel->getActiveSheet()->setCellValue('B'.$r, $cd['apprentice_registration_no']);
				$this->excel->getActiveSheet()->setCellValue('C'.$r, $cd['fname']." ".$cd['lname']);
				$this->excel->getActiveSheet()->setCellValue('D'.$r, $cd['last_qualification']);
				$this->excel->getActiveSheet()->setCellValue('E'.$r, $cd['gender']);
				$this->excel->getActiveSheet()->setCellValue('F'.$r, $cd['phone']);
				$this->excel->getActiveSheet()->setCellValue('G'.$r, $cd['contract_date']);
				$this->excel->getActiveSheet()->setCellValue('H'.$r, $qtrcoverdisp);
				$this->excel->getActiveSheet()->setCellValue('I'.$r, $num_cover);
				
					$j++;
		}	
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$title.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		
		$objWriter->save('php://output');
	}
	public function download_eligible_candidate_report(){
		$filename = "Eligible_candidate_report".date('Ymd')."file.xls";
		$title = "Eligible Candidate Report ";
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		

		$this->excel->getActiveSheet()->setCellValue('A2', 'SL No');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Apprentice Registration No');
		$this->excel->getActiveSheet()->setCellValue('C2', 'Candidate Name');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Last Qualification');
		$this->excel->getActiveSheet()->setCellValue('E2', 'Gender');
		$this->excel->getActiveSheet()->setCellValue('F2', 'Mobile');
		$this->excel->getActiveSheet()->setCellValue('G2', 'Contract Date');
		$this->excel->getActiveSheet()->setCellValue('H2', 'Quarter Coverage');
		$this->excel->getActiveSheet()->setCellValue('I2', 'No Of Quarter Cover');
		
		/****************************************query erea**************************/

		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";
		$stat = $this->input->get('stat');
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		if($stat!=""){
			$data['stat']=$stat;
		}
		if($start_date!=''){
			$data['start_date']=$start_date;
		}
		if($end_date!=''){
			$data['end_date']=$end_date;
		}
		
		$apprentice_registration_no = $this->input->get('apprentice_registration_no');

		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		
			
			if($start_date!="" && $end_date!=""){
				if($_filterCond=="") $_filterCond .= " and contract_date between '".$start_date."' and '".$end_date."'";
				else $_filterCond .= " And contract_date between '".$start_date."' and '".$end_date."'";
			}
			if($apprentice_registration_no!="")$_filterCond .= " and apprentice_registration_no ='".$apprentice_registration_no."'";
			if($status!="")$_filterCond .= " and nap_stat ='".$status."'";
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue=$user_office_id;

			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}

	
        $qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, 
					   r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, 
					   r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, 
					   DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  
					   (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, 
					   (select id as user_id from signin vb where vb.dfr_id=c.id) as userid,
					   (select released_date from user_resign ur where ur.user_id = userid) as releasedDate,
					   (select status as employee_status from signin xy where xy.dfr_id=c.id) as emp_status
					   from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id 
					   where  r.id=c.r_id and nap_stat = 1 and onboarding_type  = 'NAPS'".$_filterCond." 
					   ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;die();
		$get_candidate_details = $this->Common_model->get_query_result_array($qSql);

		//echo'<pre>';print_r($get_candidate_details);die();
		/****************************************************************************/
		
		$j=3;
		$r=2;
		$p=0;
		foreach($get_candidate_details as $cd): 
			    //echo'<pre>';print_r($cd);
				$r_id=$cd['r_id'];
				$c_id=$cd['can_id'];
				$c_status = $cd['candidate_status'];
				$gross_pay = $cd['gross_pay'];
				
				// if($c_status=='P')	$cstatus="Pending";
				// else if($c_status=='IP')	$cstatus="In Progress";
				// else if($c_status=='SL')	$cstatus="Shortlisted";
				// else if($c_status=='CS')	$cstatus="Selected";
				// else if( $c_status=='E') $cstatus="Selected as Employee";
				// else if($c_status=='R') $cstatus="Rejected";
				// else if($c_status=='D') $cstatus="Dropped";
				
				if($cd['attachment_contract']!='') $viewContract='View Contact Copy';
				else $viewContract='';

				if($cd['attachment']!='') $viewResume='View Resume';
				else $viewResume='';

				if($c_status=='CS'){
					$bold="style='font-weight:bold; color:#041ad3'";
				}else if($c_status=='E'){
					$bold="style='font-weight:bold; color:#013220'";
				}else if($c_status=='R'){
					$bold="style='font-weight:bold; color:red'";
				}else{
					$bold="";
				}
				$qtrcover = "";
				$qtrcoverdisp = "";
				$ctdate ="";
				$quarters = array("1"=>"JFM","2"=>"AMJ","3"=>"JAS","4"=>"OND");
				$qtr  = date('md',strtotime($cd['contract_date']));
				if($qtr>='0101'&& $qtr<='0110'){
					$qtrcover =  "JFM";
					$ctdate = '01-01-'.date('Y',strtotime($cd['contract_date']));
				}
				elseif($qtr>='0111'&& $qtr<='0410'){
					$qtrcover =  "AMJ";
					$ctdate = '01-04-'.date('Y',strtotime($cd['contract_date']));
				}
				elseif($qtr>='0411'&& $qtr<='0710'){
					$qtrcover =  "JAS";
					$ctdate = '01-07-'.date('Y',strtotime($cd['contract_date']));
				}
				elseif($qtr>='0711'&& $qtr<='1010'){
					$qtrcover =  "OND";
					$ctdate = '01-10-'.date('Y',strtotime($cd['contract_date']));
				}
				elseif($qtr>='1011'&& $qtr<='1231'){
					$qtrcover =  "JFM";
				}
				 $arr  = array_search($qtrcover,$quarters);
				
				if($cd['emp_status']=="" or $cd['emp_status']==1){
				 $date1 = $ctdate;
				 $date2 = date('Y-m-d');//"2022-02-22";//

				$ts1 = strtotime($date1);
				$ts2 = strtotime($date2);

				$year1 = date('Y', $ts1);
				$year2 = date('Y', $ts2);

				$month1 = date('m', $ts1);
				$month2 = date('m', $ts2);

				$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
				$num_cover = floor(($diff/3));
				$num_cover = ($num_cover<0)?0:$num_cover;
				
				}
				if($cd['releasedDate']!=""){
					$date1 = $ctdate;
				 $date2 = $cd['releasedDate'];//date('Y-m-d');

				$ts1 = strtotime($date1);
				$ts2 = strtotime($date2);

				$year1 = date('Y', $ts1);
				$year2 = date('Y', $ts2);

				$month1 = date('m', $ts1);
				$month2 = date('m', $ts2);

				$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
				$num_cover = floor(($diff/3));
				}
				if($num_cover>=1){
					$t=$arr;
					$cnt  =(($num_cover+$arr)-1);
					for($i=$arr;$i<=$cnt;$i++){
						if($qtrcoverdisp==""){
							$qtrcoverdisp = $quarters[$t];
						}
						else
						{
							$qtrcoverdisp = $qtrcoverdisp.','.$quarters[$t];
						}
						$t++;
						if($t>4){
							$t=1;
						}	
					}
					$ch=1;
					if($stat!=""){
						
						 $qtrcov = " ".$qtrcoverdisp;
						 $ch = strpos($qtrcov,$stat);
					}
					if($ch!=""){	
					$r++;
					$p++;
					$this->excel->getActiveSheet()->setCellValue('A'.$r, $p);
					$this->excel->getActiveSheet()->setCellValue('B'.$r, $cd['apprentice_registration_no']);
					$this->excel->getActiveSheet()->setCellValue('C'.$r, $cd['fname']." ".$cd['lname']);
					$this->excel->getActiveSheet()->setCellValue('D'.$r, $cd['last_qualification']);
					$this->excel->getActiveSheet()->setCellValue('E'.$r, $cd['gender']);
					$this->excel->getActiveSheet()->setCellValue('F'.$r, $cd['phone']);
					$this->excel->getActiveSheet()->setCellValue('G'.$r, $cd['contract_date']);
					$this->excel->getActiveSheet()->setCellValue('H'.$r, $qtrcoverdisp);
					$this->excel->getActiveSheet()->setCellValue('I'.$r, $num_cover);
					
						$j++;
				}
			}		
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$title.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		
		$objWriter->save('php://output');
	}
	public function download_missed_candidate_report(){
		$filename = "Missed_candidate_report".date('Ymd')."file.xls";
		$title = "Missed Candidate Report ";
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		

		$this->excel->getActiveSheet()->setCellValue('A2', 'SL No');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Apprentice Registration No');
		$this->excel->getActiveSheet()->setCellValue('C2', 'Candidate Name');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Last Qualification');
		$this->excel->getActiveSheet()->setCellValue('E2', 'Gender');
		$this->excel->getActiveSheet()->setCellValue('F2', 'Mobile');
		$this->excel->getActiveSheet()->setCellValue('G2', 'Contract Date');
		$this->excel->getActiveSheet()->setCellValue('H2', 'Quarter Coverage');
		$this->excel->getActiveSheet()->setCellValue('I2', 'No Of Quarter Cover');
		
		/****************************************query erea**************************/

		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";
		$stat = $this->input->get('stat');
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		if($stat!=""){
			$data['stat']=$stat;
		}
		if($start_date!=''){
			$data['start_date']=$start_date;
		}
		if($end_date!=''){
			$data['end_date']=$end_date;
		}
		
		$apprentice_registration_no = $this->input->get('apprentice_registration_no');

		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		
			
			if($start_date!="" && $end_date!=""){
				if($_filterCond=="") $_filterCond .= " and contract_date between '".$start_date."' and '".$end_date."'";
				else $_filterCond .= " And contract_date between '".$start_date."' and '".$end_date."'";
			}
			if($apprentice_registration_no!="")$_filterCond .= " and apprentice_registration_no ='".$apprentice_registration_no."'";
			if($status!="")$_filterCond .= " and nap_stat ='".$status."'";
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue=$user_office_id;

			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
				else $_filterCond .= " And location='".$oValue."'";
			}

	
        $qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, 
					   r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, 
					   r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, 
					   DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  
					   (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, 
					   (select id as user_id from signin vb where vb.dfr_id=c.id) as userid,
					   (select released_date from user_resign ur where ur.user_id = userid) as releasedDate,
					   (select status as employee_status from signin xy where xy.dfr_id=c.id) as emp_status
					   from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id 
					   where  r.id=c.r_id and nap_stat = 1 and onboarding_type  = 'NAPS'".$_filterCond." 
					   ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;die();
		$get_candidate_details = $this->Common_model->get_query_result_array($qSql);

		//echo'<pre>';print_r($get_candidate_details);die();
		/****************************************************************************/
		
		$j=3;
		$r=2;
		$p=0;
		foreach($get_candidate_details as $cd): 
			    //echo'<pre>';print_r($cd);
				$r_id=$cd['r_id'];
				$c_id=$cd['can_id'];
				$c_status = $cd['candidate_status'];
				$gross_pay = $cd['gross_pay'];
				
				// if($c_status=='P')	$cstatus="Pending";
				// else if($c_status=='IP')	$cstatus="In Progress";
				// else if($c_status=='SL')	$cstatus="Shortlisted";
				// else if($c_status=='CS')	$cstatus="Selected";
				// else if( $c_status=='E') $cstatus="Selected as Employee";
				// else if($c_status=='R') $cstatus="Rejected";
				// else if($c_status=='D') $cstatus="Dropped";
				
				if($cd['attachment_contract']!='') $viewContract='View Contact Copy';
				else $viewContract='';

				if($cd['attachment']!='') $viewResume='View Resume';
				else $viewResume='';

				if($c_status=='CS'){
					$bold="style='font-weight:bold; color:#041ad3'";
				}else if($c_status=='E'){
					$bold="style='font-weight:bold; color:#013220'";
				}else if($c_status=='R'){
					$bold="style='font-weight:bold; color:red'";
				}else{
					$bold="";
				}
				$qtrcover = "";
				$qtrcoverdisp = "";
				$ctdate ="";
				$quarters = array("1"=>"JFM","2"=>"AMJ","3"=>"JAS","4"=>"OND");
				$qtr  = date('md',strtotime($cd['contract_date']));
				if($qtr>='0101'&& $qtr<='0110'){
					$qtrcover =  "JFM";
					$ctdate = '01-01-'.date('Y',strtotime($cd['contract_date']));
				}
				elseif($qtr>='0111'&& $qtr<='0410'){
					$qtrcover =  "AMJ";
					$ctdate = '01-04-'.date('Y',strtotime($cd['contract_date']));
				}
				elseif($qtr>='0411'&& $qtr<='0710'){
					$qtrcover =  "JAS";
					$ctdate = '01-07-'.date('Y',strtotime($cd['contract_date']));
				}
				elseif($qtr>='0711'&& $qtr<='1010'){
					$qtrcover =  "OND";
					$ctdate = '01-10-'.date('Y',strtotime($cd['contract_date']));
				}
				elseif($qtr>='1011'&& $qtr<='1231'){
					$qtrcover =  "JFM";
				}
				 $arr  = array_search($qtrcover,$quarters);
				
				if($cd['emp_status']=="" or $cd['emp_status']==1){
				 $date1 = $ctdate;
				 $date2 = date('Y-m-d');//"2022-02-22";//

				$ts1 = strtotime($date1);
				$ts2 = strtotime($date2);

				$year1 = date('Y', $ts1);
				$year2 = date('Y', $ts2);

				$month1 = date('m', $ts1);
				$month2 = date('m', $ts2);

				$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
				$num_cover = floor(($diff/3));
				$num_cover = ($num_cover<0)?0:$num_cover;
				
				}
				if($cd['releasedDate']!=""){
					$date1 = $ctdate;
				 $date2 = $cd['releasedDate'];//date('Y-m-d');

				$ts1 = strtotime($date1);
				$ts2 = strtotime($date2);

				$year1 = date('Y', $ts1);
				$year2 = date('Y', $ts2);

				$month1 = date('m', $ts1);
				$month2 = date('m', $ts2);

				$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
				$num_cover = floor(($diff/3));
				}
				if($num_cover<=0){
					$t=$arr;
					$cnt  =(($num_cover+$arr)-1);
					for($i=$arr;$i<=$cnt;$i++){
						if($qtrcoverdisp==""){
							$qtrcoverdisp = $quarters[$t];
						}
						else
						{
							$qtrcoverdisp = $qtrcoverdisp.','.$quarters[$t];
						}
						$t++;
						if($t>4){
							$t=1;
						}	
					}
					$ch=1;
					if($stat!=""){
						
						 $qtrcov = " ".$qtrcoverdisp;
						 $ch = strpos($qtrcov,$stat);
					}
					if($ch!=""){	
					$r++;
					$p++;
					$this->excel->getActiveSheet()->setCellValue('A'.$r, $p);
					$this->excel->getActiveSheet()->setCellValue('B'.$r, $cd['apprentice_registration_no']);
					$this->excel->getActiveSheet()->setCellValue('C'.$r, $cd['fname']." ".$cd['lname']);
					$this->excel->getActiveSheet()->setCellValue('D'.$r, $cd['last_qualification']);
					$this->excel->getActiveSheet()->setCellValue('E'.$r, $cd['gender']);
					$this->excel->getActiveSheet()->setCellValue('F'.$r, $cd['phone']);
					$this->excel->getActiveSheet()->setCellValue('G'.$r, $cd['contract_date']);
					$this->excel->getActiveSheet()->setCellValue('H'.$r, $qtrcoverdisp);
					$this->excel->getActiveSheet()->setCellValue('I'.$r, $num_cover);
					
						$j++;
				}
			}		
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$title.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		
		$objWriter->save('php://output');
	}
	public function download_attendance(){

		/**************************************Excel Work Start ***************************************/

		$filename = "Attendance_candidate_report".date('Ymd')."file.xls";
		$title = "Attendance Candidate Report ";
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
		
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		

		$this->excel->getActiveSheet()->setCellValue('A2', 'SL No');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Name Of Apprentice');
		$this->excel->getActiveSheet()->setCellValue('C2', 'App Id/SDMS');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Period Of Payment');
		$this->excel->getActiveSheet()->setCellValue('E2', 'Payment Days');
		$this->excel->getActiveSheet()->setCellValue('F2', 'Days Of Attendance as per Portal');
		$this->excel->getActiveSheet()->setCellValue('G2', 'Sector');
		$this->excel->getActiveSheet()->setCellValue('H2', 'Amount Of Stipend Paid');
		$this->excel->getActiveSheet()->setCellValue('I2', 'Establishment');
		$this->excel->getActiveSheet()->setCellValue('J2', 'Apprentice');
		$this->excel->getActiveSheet()->setCellValue('K2', 'UTR/Cheque No');
		/********************************************************************************************/
		$qSql= "Select r.id as rid, (select org_role from role  where role.id = r.role_id ) as org_role, 
					   r.requisition_id, r.req_no_position, r.department_id, r.role_id, r.location, r.job_title, 
					   r.client_id, r.process_id , r.l1_supervisor, c.*,nap.*, c.id as can_id, 
					   DATE_FORMAT(dob,'%m/%d/%Y') as d_o_b, DATE_FORMAT(doj,'%m/%d/%Y') as d_o_j,  
					   (select concat(fname, ' ', lname) as name from signin x where x.id=c.added_by) as added_name, 
					   (select id as user_id from signin vb where vb.dfr_id=c.id) as userid,
					   (select released_date from user_resign ur where ur.user_id = userid) as releasedDate,
					   (select status as employee_status from signin xy where xy.dfr_id=c.id) as emp_status
					   from dfr_requisition r, dfr_naps_candidate_details nap left join dfr_candidate_details c on nap.dfr_id = c.id 
					   where  r.id=c.r_id and nap_stat = 1 and onboarding_type  = 'NAPS'".$_filterCond." 
					   ORDER BY FIELD(c.candidate_status, 'P', 'IP', 'SL', 'CS', 'E', 'R') ";
					
		//echo $qSql;die();
		$get_candidate_details = $this->Common_model->get_query_result_array($qSql);
		$j=3;
		$r=2;
		$p=0;
		foreach($get_candidate_details as $cd):
			$r++;
			$p++;
			$this->excel->getActiveSheet()->setCellValue('A'.$r, $p);
			$this->excel->getActiveSheet()->setCellValue('B'.$r, $cd['fname']." ".$cd['lname']);
			$this->excel->getActiveSheet()->setCellValue('C'.$r, );
			$this->excel->getActiveSheet()->setCellValue('D'.$r, date('F'));
			$this->excel->getActiveSheet()->setCellValue('E'.$r, date('t'));
			$this->excel->getActiveSheet()->setCellValue('F'.$r, );
			$this->excel->getActiveSheet()->setCellValue('G'.$r, $cd['sector_name']);
			$this->excel->getActiveSheet()->setCellValue('H'.$r, '');
			$this->excel->getActiveSheet()->setCellValue('I'.$r,'DCB BANK 02541700000134');
			$this->excel->getActiveSheet()->setCellValue('J'.$r,$cd['bank_name'].' '.$cd['bank_acc_no']);
			$this->excel->getActiveSheet()->setCellValue('K'.$r,$cd['bank_transaction_utr_no']);
		endforeach;	
		header('Content-Disposition: attachment;filename="'.$title.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		
		$objWriter->save('php://output');
	}
	public function upload_attendance(){

		$month_name = $this->input->post('month_name');
		$year = date('Y');
		$sql="select * from naps_attendance where month='$month_name' and year='$year'";
		$rows = $this->Common_model->get_query_result_array($sql);
		$cnt = sizeof($rows);

		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";

		$data["aside_template"] = $this->aside;

		///content data
		$data["content_template"] = "naps/upload_attendance.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = '';


		$uploadData = array();
		$this->load->library('upload');
		$uploadData = array();
		if(!empty($this->input->post('upload_file')))
		{		
			$outputFile = FCPATH ."uploads/naps_attendance/";
			$ext        = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$FileName = date('YmdHis').'.'.$ext;
			$config = [
				'upload_path'   => $outputFile,
				'allowed_types' => 'xls',
				'file_name' =>$FileName,
				'max_size' => '1024000',
			];

			
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->overwrite = true;
			if (!$this->upload->do_upload('userfile'))
			{
				redirect($_SERVER['HTTP_REFERER']);
			}			
			$upload_data = $this->upload->data();
			$inputFileName = $outputFile .$upload_data['file_name'];
			
			//  Read your Excel workbook
			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}


					//  Insert row data array into your database of choice here
					$datas=array(
						'filename'=>$FileName,
						'month'=>$month_name,
						'year'=>$year
					);
					if($cnt==0){
						$this->db->insert('naps_attendance',$datas);
					}
					else
					{
						$this->db->where('month',$month_name);
						$this->db->where('year',$year);
						$this->db->update('naps_attendance',$datas);
					}
					//echo'<pre>';print_r($rowData[0][0]);
					$data['last_status']='success';
				
		}
		$this->load->view('dashboard',$data);	
		
	}
	public function manage_attendance_file(){

		$user_site_id= get_user_site_id();
		$srole_id= get_role_id();
		$is_global_access = get_global_access();
		$current_user = get_user_id();
		$user_office_id=get_user_office_id();
		$_filterCond="";

		$data["aside_template"] = $this->aside;
		$oValue = trim($this->input->get('office_id'));
		if($oValue=="") $oValue=$user_office_id;

		if($oValue!="ALL" && $oValue!=""){
			if($_filterCond=="") $_filterCond .= " and location='".$oValue."'";
			else $_filterCond .= " And location='".$oValue."'";
		}

		// $qSql="SELECT p.* FROM dfr_candidate_details as p where onboarding_type  = 'NAPS'";
		// $data['candidates_list'] = $this->Common_model->get_query_result_array($qSql);

		$data["content_template"] = "naps/manage_attendance_file.php";
        $data["content_js"] = "naps_js.php";
        $data["error"] = ''; 	
        $qSql= "Select * from naps_attendance Where status='A'";
					
		//echo $qSql;
		$data["get_candidate_details"] = $this->Common_model->get_query_result_array($qSql);

		if(get_role_dir()=="super" || $is_global_access==1){
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		$type =$this->input->get('type');
		$data['oValue']=$oValue;
		if($type=='download'){
			//$this->Download_Candidate_Bg_file($oValue);
		}
		
		$this->load->view('dashboard',$data);
	}
}

