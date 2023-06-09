<?php

 class Qa_park_west extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}


	private function edu_upload_files($files,$path)
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


            } else {
                return false;
            }
        }
        return $images;
    }
	/////////////////////////////////////////////////

   public function createPath($path)
	{

		if (!empty($path))
		{

	    	if(!file_exists($path)){

	    		$mainPath="./";
	    		$checkPath=str_replace($mainPath,'', $path);
	    		$checkPath=explode("/",$checkPath);
	    		$cnt=count($checkPath);
	    		for($i=0;$i<$cnt;$i++){

		    		$mainPath.=$checkPath[$i].'/';
		    		if (!file_exists($mainPath)) {
		    			$oldmask = umask(0);
						$mkdir=mkdir($mainPath, 0777);
						umask($oldmask);

						if ($mkdir) {
							return true;
						}else{
							return false;
						}
		    		}

	    		}

    		}else{
    			return true;
    		}
    	}
	}

  private function park_west_upload_files($files,$path)   // this is for file uploaging purpose
  {
    $result=$this->createPath($path);
    if($result){
    $config['upload_path'] = $path;
    $config['allowed_types'] = '*';

	  $config['allowed_types'] = 'm4a|mp4|mp3|wav';
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
  }

/////////////////Home Craftjack vikas//////////////////

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_park_west/qa_park_west_feedback.php";
			$data["content_js"] = "qa_avon_js.php";

			// $qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,19) and is_assign_process (id,31) and status=1  order by name";
			// $data["agentName"] = $this->Common_model->get_query_result_array($qSql);

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,374) and is_assign_process (id,818) and status=1  order by name";
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_park_west_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["park_west_data"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}

	///////////////////vikas/////////////////////////////

	public function add_edit_park_west($park_west_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_park_west/add_edit_park_west.php";
			$data["content_js"] = "qa_avon_js.php";
			//$data["content_js"] = "qa_clio_js.php";
			$data['park_west_id']=$park_west_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}

			

			 // $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,19) and is_assign_process(id,31) and status=1  order by name";
	          //  $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,382) and is_assign_process(id,833) and status=1  order by name";
	          $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_park_west_feedback where id='$park_west_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["park_west_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($park_west_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->park_west_upload_files($_FILES['attach_file'], $path='./qa_files/park_west/qa_audio_files/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_park_west_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_park_west_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/park_west/qa_audio_files/")){
							mkdir("./qa_files/park_west/qa_audio_files/");
						}
						$a = $this->park_west_upload_files( $_FILES['attach_file'], $path = './qa_files/park_west/qa_audio_files/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $park_west_id);
					$this->db->update('qa_park_west_feedback',$field_array1);
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
					$this->db->where('id', $park_west_id);
					$this->db->update('qa_park_west_feedback',$edit_array);

				}

				redirect('Qa_park_west');
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}



  /////////////////Norther Agent part//////////////////////////

	public function agent_park_west_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_park_west/agent_park_west_feedback.php";
			$data["content_js"] = "qa_avon_js.php";
			$data["agentUrl"] = "qa_park_west/agent_park_west_feedback";


			$qSql="Select count(id) as value from qa_park_west_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_park_west_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";

			$data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);


			$from_date = '';
			$to_date = '';
			$cond="";
			$user="";

			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));

				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date')";

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_park_west_feedback $cond and agent_id ='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);

			}else{
				
				

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_park_west_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_list"] = $this->Common_model->get_query_result_array($qSql);
				
			}

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;

			$this->load->view('dashboard',$data);
		}
	}
	
	//////////////////////vikas starts////////////////////////////

	public function agent_park_west_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_park_west/agent_park_west_rvw.php";
			$data["agentUrl"] = "qa_park_west/agent_park_west_feedback";
			$data["content_js"] = "qa_avon_js.php";
			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_park_west_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["park_west_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["park_west_id"]=$id;			
			
			if($this->input->post('park_west_id'))
			{
				$park_west_id=$this->input->post('park_west_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $park_west_id);
				$this->db->update('qa_park_west_feedback',$field_array);
				
				redirect('Qa_park_west/agent_park_west_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	//////////////////////vikas ends///////////////////////
	

//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// QA Norther REPORT ////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_park_west_report(){
		if(check_logged_in()){

			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;

			$data["aside_template"] = "reports_qa/aside.php";
			$data["content_template"] = "qa_park_west/qa_park_west_report.php";
			$data["content_js"] = "qa_avon_js.php";

			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$cond2="";
			$audit_type="";

			$date_from = ($this->input->get('from_date'));
			$date_to = ($this->input->get('to_date'));

			if($date_from==""){
					$date_from=CurrDate();
				}else{
					$date_from = mmddyy2mysql($date_from);
				}

				if($date_to==""){
					$date_to=CurrDate();
				}else{
					$date_to = mmddyy2mysql($date_to);
			}

			$data["qa_park_west_list"] = array();
			//if($this->input->get('show')=='Show') {
			   // $campaign = $this->input->get('campaign');
				
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');

				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";

				if($audit_type=="All" || $audit_type=="") $cond2 .= "";
				else $cond2 .=" and audit_type='$audit_type'";

				

				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";

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
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_park_west_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 $cond2 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_park_west_list"] = $fullAray;
			 

				$this->create_Qa_park_west_CSV($fullAray);

				$dn_link = base_url()."Qa_park_west/download_Qa_park_west_CSV";


			//}
			$data['location_list'] = $this->Common_model->get_office_location_list();

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['from_date'] = $date_from;
			$data['to_date'] = $date_to;
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;

			$this->load->view('dashboard',$data);
		}
	}

   ////////////Norther ///////////////////////////////
	public function download_Qa_park_west_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Park West Audit List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_Qa_park_west_CSV($rr)
	{

		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
	
		 $header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent Name", "L1 Supervisor", "ACPT","Phone Number","Customer Name", "Call Date", "Call Duration", "Audit Type", "Auditor Type", "VOC","Possible Score", "Earned Score", "Overall Score",
	"Identify himself/herself by first and last name at the beginning of the call? **SQ**",
    "Provide the Quality Assurance Statement verbatim before any specific account information was discussed?**SQ**",
	"State My Quick Wallet with no deviation? **SQ**",
	"Verify that he/she was speaking to a right party according to the client requirements (First and Last Name) and before providing the disclosures?",
	"Verify two pieces of demographics information on an outbound call? Any two of: (1) Full Name (2) Date of Birth (3) Last four digits of SSN (4)Email Address ",
	"State/Ask for balance due? (If required also inform the breakdown of principal finance fees & NSF Fees.)","Ask for intention to resolve the account?","Ask for the payment to the account?",
	"Followed the previous conversations on the account for the follow-up call",
	"Able to take a promise to pay on the account?",
	"Did the collector elaborate the consiquences of not clearing the bills and benefits of paying off?",
	"Did the collector provide applicable settelment options?",
	"Could the collector manage to create urgency for payment?",
	"Did Collector try to negotiate effectively to convince the customer for payment with all possible options?",
	"Did not  Misrepresent their identity or authorization and status of the consumers account?",
	"Did not Discuss or imply that any type of legal actions - will be taken or property repossessed also on time barred accounts amd Did not Threaten to take actions that the client cannot legally take?",
	"Did not Make any false representations regarding the nature of the communication?",
	"Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumers location?",
	"Did not Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited?",
	"Did not Communicate with the consumer after learning the consumer is represented by an attorney filed for bankruptcy unless a permissible reason exists?",
	"Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell phone email and fax?",
	"Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer?",
	"Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place?",
	"Did not Make any statement that could constitute unfair deceptive or abusive acts or practices that may raise UDAAP concerns?",
	"Did not Communicate or threaten to communicate false credit information or information which should be known to be false and utilized the proper CBR script whenever a consumer enquires about that?",
	"Handle the consumers dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint or offer to escalate the call?",
	"Did not Make the required statement on time barred accounts indicating that the consumer cannot be pursued with legal action?",
	"Adhere to FDCPA  laws?",
	"Did not Make any statement that could be considered discriminatory towards a consumer or a violation ECOA policy?",
	"Did the collectors adhere to the State Restrictions?",
	"Confirm with consumer if he/she is the authorized user of the debit or credit card / checking account?",
	"Recap the call by verifying consumers Name Address CC/AP information?",
	"Stated the proper payment script before processing payment?",
	"Obtain permission from the consumer to initiate electronic credit /debit card transactions or through checking account and get supervisor verification if needed?**SQ**",
	"Educate the consumer about correspondence being sent (Receipts PIF SIF Confirmations etc)?",
	"In case of PDCs did the Collector asks for permission to call the Consumer back if it is declined or there is an issue with the payment? ",
	"Demonstrate Active Listening?",
	"Represent the company and the client in a positive manner?",
	"Anticipate and overcome objections?",
	"Transfer call to My Quick Wallets support appropriately (if applicable)?",
	"Summarize the call?",
	"Provided My Quick Wallet's support number incase its required (if applicable)?",
	"Set appropriate timelines and expectations for follow up?",
	"Close the call Professionally?",
	"Use the proper action code?",
	"Use the proper result code?",
	"Document thoroughly the context of the conversation?",
	"Did the rep document the callback permission on the account as per Reg F policy?",
	"Remove any phone numbers known to be incorrect?**SQ**",
	"Update address information if appropriate?**SQ**",
	"Change the status of the account if appropriate?**SQ**",
	"Escalate the account to a supervisor for handling if appropriate?",
	"Identify himself/herself by first and last name at the beginning of the call? **SQ** - Remarks", 
	"Provide the Quality Assurance Statement verbatim before any specific account information was discussed?**SQ** -Remarks", 
	"State My Quick Wallet with no deviation? **SQ**- Remarks",
	"Verify that he/she was speaking to a right party according to the client requirements (First and Last Name) and before providing the disclosures? - Remarks",
	"Verify two pieces of demographics information on an outbound call? Any two of: (1) Full Name (2) Date of Birth (3) Last four digits of SSN (4)Email Address - Remarks",
	"Provide the Mini Miranda disclosure verbatim before any specific account information was discussed? **SQ** - Remarks",
	"Did the rep ask for callback permission as per Reg F policy? - Remarks",
	"State/Ask for balance due? (If required also inform the breakdown of principal finance fees & NSF Fees.)- Remarks",
	"Ask for intention to resolve the account? - Remarks",
	"Ask for the payment to the account? - Remarks",
	"Followed the previous conversations on the account for the follow-up call - Remarks",
	"Able to take a promise to pay on the account? - Remarks",
	"Did the collector elaborate the consiquences of not clearing the bills and benefits of paying off? - Remarks",
	"Did the collector provide applicable settelment options? - Remarks",
	"Could the collector manage to create urgency for payment? - Remarks",
	"Did Collector try to negotiate effectively to convince the customer for payment with all possible options? - Remarks",
	"Did not  Misrepresent their identity or authorization and status of the consumers account? - Remarks",
	"Did not Discuss or imply that any type of legal actions - will be taken or property repossessed also on time barred accounts amd Did not Threaten to take actions that the client cannot legally take? - Remarks",
	"Did not Make any false representations regarding the nature of the communication? - Remarks",
	"Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumers location? - Remarks",
	"Did not Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited? - Remarks",
	"Did not Communicate with the consumer after learning the consumer is represented by an attorney filed for bankruptcy unless a permissible reason exists? - Remarks",
	"Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell phone email and fax? - Remarks",
	"Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer? - Remarks",
	"Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place? - Remarks",
	"Did not Make any statement that could constitute unfair deceptive or abusive acts or practices that may raise UDAAP concerns? - Remarks",
	"Did not Communicate or threaten to communicate false credit information or information which should be known to be false and utilized the proper CBR script whenever a consumer enquires about that? - Remarks",
	"Handle the consumers dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint or offer to escalate the call? - Remarks",
	"Did not Make the required statement on time barred accounts indicating that the consumer cannot be pursued with legal action? - Remarks",
	"Adhere to FDCPA  laws? - Remarks",
	"Did not Make any statement that could be considered discriminatory towards a consumer or a violation ECOA policy? - Remarks",
	"Did the collectors adhere to the State Restrictions? - Remarks",
	"Confirm with consumer if he/she is the authorized user of the debit or credit card / checking account? - Remarks",
	"Recap the call by verifying consumers Name Address CC/AP information? - Remarks",
	"Stated the proper payment script before processing payment?   - Remarks",
	"Obtain permission from the consumer to initiate electronic credit /debit card transactions or through checking account and get supervisor verification if needed?**SQ** - Remarks",
	"Educate the consumer about correspondence being sent (Receipts PIF SIF Confirmations etc)? - Remarks",
	"In case of PDCs did the Collector asks for permission to call the Consumer back if it is declined or there is an issue with the payment?  - Remarks",
	"Demonstrate Active Listening? - Remarks",
	"Represent the company and the client in a positive manner? - Remarks",
	"Anticipate and overcome objections? - Remarks",
	"Transfer call to My Quick Wallet's support appropriately (if applicable)? - Remarks",
	"Summarize the call? - Remarks",
	"Provided My Quick Wallet's support number incase its required (if applicable)? - Remarks",
	"Set appropriate timelines and expectations for follow up? - Remarks",
	"Close the call Professionally? - Remarks",
	"Use the proper action code? - Remarks",
	"Use the proper result code? - Remarks",
	"Document thoroughly the context of the conversation? - Remarks",
	"Did the rep document the callback permission on the account as per Reg F policy? - Remarks",
	"Remove any phone numbers known to be incorrect?**SQ** - Remarks",
	"Update address information if appropriate?**SQ** - Remarks",
	"Change the status of the account if appropriate?**SQ** - Remarks",
	"Escalate the account to a supervisor for handling if appropriate? - Remarks",
    "Call Summary/Observation","Audit Start date and  Time ", "Audit End Date and  Time","Interval (in sec)",  "Feedback", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time","Mgnt Review By", "Mgnt Comment","Client Review Name","Client Review Note","Client Review Date and Time");

		

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

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
				$row .= '"'.$user['AHT_RCA'].'",';
				$row .= '"'.$user['customer_phone'].'",';
				$row .= '"'.$user['customer_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['identify_himself'].'",';
				$row .= '"'.$user['provide_quality_assurance'].'",';
				$row .= '"'.$user['state_my_quick_wallet'].'",';
				$row .= '"'.$user['speaking_right_party'].'",';
				$row .= '"'.$user['demographics_information'].'",';
				$row .= '"'.$user['callback_permission'].'",';
				$row .= '"'.$user['balance_due'].'",';
				$row .= '"'.$user['resolve_account'].'",';
				$row .= '"'.$user['payment_account'].'",';
				$row .= '"'.$user['follow_up_call'].'",';
				$row .= '"'.$user['promise_pay'].'",';
				$row .= '"'.$user['elaborate_consiquences'].'",';
				$row .= '"'.$user['settelment_options'].'",';
				$row .= '"'.$user['urgency_for_payment'].'",';
				$row .= '"'.$user['negotiate_effectively'].'",';
				$row .= '"'.$user['misrepresent_their_identity'].'",';
				$row .= '"'.$user['imply_leagal_actions'].'",';
				$row .= '"'.$user['nature_of_communication'].'",';
				$row .= '"'.$user['contact_customer'].'",';
				$row .= '"'.$user['communicate_customer_work'].'",';
				$row .= '"'.$user['communicate_customer_learning'].'",';
				$row .= '"'.$user['phone_policy'].'",';
				$row .= '"'.$user['adhere_policy'].'",';
				$row .= '"'.$user['status_code'].'",';
				$row .= '"'.$user['abusive_acts'].'",';
				$row .= '"'.$user['false_credit_information'].'",';
				$row .= '"'.$user['take_appropriate_action'].'",';
				$row .= '"'.$user['pursue_leagal_action'].'",';
				$row .= '"'.$user['adhere_FDCPA'].'",';
				$row .= '"'.$user['violation_ECOA_policy'].'",';
				$row .= '"'.$user['adhere_state_restrictions'].'",';
				$row .= '"'.$user['authorized_user'].'",';
				$row .= '"'.$user['recap_call'].'",';
				$row .= '"'.$user['proper_payment_script'].'",';
				$row .= '"'.$user['permission_from_customer'].'",';
				$row .= '"'.$user['educate_customer'].'",';
				$row .= '"'.$user['consumer_callback'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['positive_manner'].'",';
				$row .= '"'.$user['overcome_objections'].'",';
				$row .= '"'.$user['transfer_call'].'",';
				$row .= '"'.$user['summarize_call'].'",';
				$row .= '"'.$user['support_wallet'].'",';
				$row .= '"'.$user['follow_up'].'",';
				$row .= '"'.$user['close_call_professionally'].'",';
				$row .= '"'.$user['proper_action_code'].'",';
				$row .= '"'.$user['proper_result_code'].'",';
				$row .= '"'.$user['document_thoroughly'].'",';
				$row .= '"'.$user['document_callback'].'",';
				$row .= '"'.$user['remove_phone_no'].'",';
				$row .= '"'.$user['update_address_information'].'",';
				$row .= '"'.$user['change_status'].'",';
				$row .= '"'.$user['escalate_account'].'",';
        $row .= '"'.$user['cmt1'].'",';
        $row .= '"'.$user['cmt2'].'",';
        $row .= '"'.$user['cmt3'].'",';
        $row .= '"'.$user['cmt4'].'",';
        $row .= '"'.$user['cmt5'].'",';
        $row .= '"'.$user['cmt6'].'",';
        $row .= '"'.$user['cmt7'].'",';
        $row .= '"'.$user['cmt8'].'",';
        $row .= '"'.$user['cmt9'].'",';
        $row .= '"'.$user['cmt10'].'",';
        $row .= '"'.$user['cmt11'].'",';
        $row .= '"'.$user['cmt12'].'",';
        $row .= '"'.$user['cmt13'].'",';
        $row .= '"'.$user['cmt14'].'",';
        $row .= '"'.$user['cmt15'].'",';
        $row .= '"'.$user['cmt16'].'",';
        $row .= '"'.$user['cmt17'].'",';
        $row .= '"'.$user['cmt18'].'",';
        $row .= '"'.$user['cmt19'].'",';
        $row .= '"'.$user['cmt20'].'",';
        $row .= '"'.$user['cmt21'].'",';
        $row .= '"'.$user['cmt22'].'",';
        $row .= '"'.$user['cmt23'].'",';
        $row .= '"'.$user['cmt24'].'",';
        $row .= '"'.$user['cmt25'].'",';
        $row .= '"'.$user['cmt26'].'",';
        $row .= '"'.$user['cmt27'].'",';
        $row .= '"'.$user['cmt28'].'",';
        $row .= '"'.$user['cmt29'].'",';
        $row .= '"'.$user['cmt30'].'",';
        $row .= '"'.$user['cmt31'].'",';
        $row .= '"'.$user['cmt32'].'",';
        $row .= '"'.$user['cmt33'].'",';
        $row .= '"'.$user['cmt34'].'",';
        $row .= '"'.$user['cmt35'].'",';
        $row .= '"'.$user['cmt36'].'",';
        $row .= '"'.$user['cmt37'].'",';
        $row .= '"'.$user['cmt38'].'",';
        $row .= '"'.$user['cmt39'].'",';
        $row .= '"'.$user['cmt40'].'",';
        $row .= '"'.$user['cmt41'].'",';
        $row .= '"'.$user['cmt42'].'",';
        $row .= '"'.$user['cmt43'].'",';
        $row .= '"'.$user['cmt44'].'",';
        $row .= '"'.$user['cmt45'].'",';
        $row .= '"'.$user['cmt46'].'",';
        $row .= '"'.$user['cmt47'].'",';
        $row .= '"'.$user['cmt48'].'",';
        $row .= '"'.$user['cmt49'].'",';
        $row .= '"'.$user['cmt50'].'",';
        $row .= '"'.$user['cmt51'].'",';
        $row .= '"'.$user['cmt52'].'",';
        $row .= '"'.$user['cmt53'].'",';
        $row .= '"'.$user['cmt54'].'",';

				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'.$user['audit_start_time'].'",';
	      $row .= '"'.$user['entry_date'].'",';
	      $row .= '"'.$interval1.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_name'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';

  			$row .= '"'.$user['client_rvw_date'].'",';

				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
	}
}
