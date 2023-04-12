<?php

 class Qa_acg extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
	}

/////////////////////////// Create Path for Upload Audio Files - Start ///////////////////////////////
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

////////////////////////VIKAS START///////////////////////////

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			//$data["content_template"] = "qa_acg/feedback_acg.php";
			$data["content_template"] = "qa_acg/qa_acg_feedback.php";
			$data["content_js"] = "qa_accs_js.php";
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			$cond1='';

			$qSql_agent="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,380) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql_agent);

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
			if($from_date !="" && $to_date!=="" )  $cond =" where (audit_date >= '$from_date' and audit_date <= '$to_date') ";
			if($agent_id!=""){
				$cond1 ="and agent_id='$agent_id'";
			}

			if(get_user_fusion_id()=='FFLO000546'){
				$ops_cond="";
			}else{
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$ops_cond=" Where assigned_to='$current_user'";
				}else{
					$ops_cond="";
				}
			}

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acg_feedback $cond $cond1) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["qa_acg"] = $this->Common_model->get_query_result_array($qSql);

       $data["from_date"] = $from_date;
       $data["to_date"] = $to_date;
       $data["agent_id"] = $agent_id;

			$this->load->view("dashboard",$data);
		}
	}
////////////////////////VIKAS ENDS///////////////////////////

private function ajio_upload_files($files,$path)   // this is for file uploaging purpose
  {
    $result=$this->createPath($path);
    if($result){
      $config['upload_path'] = $path;
    $config['allowed_types'] = '*';

 //  $config['allowed_types'] = 'avi|mp4|3gp|mpeg|mpg|mov|mp3|flv|wmv|mkv';
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


////////////////////////VIKAS START///////////////////////////


 public function add_edit_qa_acg( $ajio_id ) {
        if ( check_logged_in() ) {
            $current_user = get_user_id();
            $user_office_id = get_user_office_id();

            $data['aside_template'] = 'qa/aside.php';
            $data["content_template"] = "qa_acg/add_edit_qa_acg.php";
            $data["content_js"] = "qa_accs_js.php";
            $data['ajio_id'] = $ajio_id;
            $tl_mgnt_cond = '';

            if ( get_role_dir() == 'manager' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
            } else if ( get_role_dir() == 'tl' && get_dept_folder() == 'operations' ) {
                $tl_mgnt_cond = " and assigned_to='$current_user'";
            } else {
                $tl_mgnt_cond = '';
            }

            $qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,380) and status=1  order by name";

            $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );


            $qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1 order by fname ASC";
            $data['tlname'] = $this->Common_model->get_query_result_array($qSql);

            $qSql = "SELECT * from
                (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
                (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
                (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
                (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
                from qa_acg_feedback where id='$ajio_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
            $data['qa_acg_curd'] = $this->Common_model->get_query_row_array( $qSql );

            //$currDate = CurrDate();
            $curDateTime = CurrMySqlDate();
            $a = array();

            $field_array['agent_id'] = !empty( $_POST['data']['agent_id'] )?$_POST['data']['agent_id']:'';
            if ( $field_array['agent_id'] ) {

                if ( $ajio_id == 0 ) {

                    $field_array = $this->input->post( 'data' );
                    $field_array['audit_date'] = CurrDate();
                   // $field_array['audit_date'] = CurrDateTimeMDY();
                    $field_array['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );
                    $field_array['entry_date'] = $curDateTime;
                    $field_array['audit_start_time'] = $this->input->post( 'audit_start_time' );
                    if(!file_exists("./qa_files/qa_acg")){
                        mkdir("./qa_files/qa_acg");
                    }
                    $a = $this->ajio_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_acg/' );
                    $field_array['attach_file'] = implode( ',', $a );
                    $rowid = data_inserter( 'qa_acg_feedback', $field_array );
                    ///////////
                    if ( get_login_type() == 'client' ) {
                        $add_array = array( 'client_entryby' => $current_user );
                    } else {
                        $add_array = array( 'entry_by' => $current_user );
                    }
                    $this->db->where( 'id', $rowid );
                    $this->db->update( 'qa_acg_feedback', $add_array );

                } else {

                    $field_array1 = $this->input->post( 'data' );
                    $field_array1['call_date'] = mmddyy2mysql( $this->input->post( 'call_date' ) );

                    // if(isset($_FILES['attach_file'])){
                    // 	if(!file_exists("./qa_files/qa_acg")){
	                   //      mkdir("./qa_files/qa_acg");
	                   //  }
	                   //  $a = $this->ajio_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_acg/' );
	                   //  $field_array1['attach_file'] = implode( ',', $a );
                    // }
                    
                    //print_r($_FILES['attach_file']);
                    // exit();
                    $this->db->where( 'id', $ajio_id );
                    $this->db->update( 'qa_acg_feedback', $field_array1 );
                    /////////////
                    if ( get_login_type() == 'client' ) {
                        $edit_array = array(
                            'client_rvw_by' => $current_user,
                            'client_rvw_note' => $this->input->post( 'note' ),
                            'client_rvw_date' => $curDateTime
                        );
                    } else {
                        $edit_array = array(
                            'mgnt_rvw_by' => $current_user,
                            'mgnt_rvw_note' => $this->input->post( 'note' ),
                            'mgnt_rvw_date' => $curDateTime
                        );
                    }
                    $this->db->where( 'id', $ajio_id );
                    $this->db->update( 'qa_acg_feedback', $edit_array );

                }
                redirect( 'qa_acg' );
            }
            $data['array'] = $a;
            $this->load->view( 'dashboard', $data );
        }
    }

    ////////////////////AGENT PART START//////////////////

 public function agent_acg_feedback()
 {
   if(check_logged_in())
   {
     $user_site_id= get_user_site_id();
     $role_id= get_role_id();
     $current_user = get_user_id();

     $data["aside_template"] = "qa/aside.php";
     $data["content_template"] = "qa_acg/agent_qa_acg_feedback.php";
     //$data["content_template"] = "qa_acg/agent_qa_acgs_feedback.php";
     $data["agentUrl"] = "qa_acg/agent_acg_feedback";

   	$data["content_js"] = "qa_accs_js.php";// js file for this page

    $tot_feedback = 0;
    $yet_rvw = 0;

     $from_date = '';
     $to_date = '';
     $cond="";
     $user="";

     if($this->input->get('btnView')=='View')
     {
     	 // $qSql="Select count(id) as value from qa_acg_feedback where agent_id='$current_user'";
     	 $qSql_acg="Select count(id) as value from qa_acg_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";

	     
	     $tot_feedback =  $this->Common_model->get_single_value($qSql_acg);

	     // $qSql="Select count(id) as value from qa_acg_feedback where agent_id='$current_user' and agent_rvw_date=' '";

	     $qSql="Select count(id) as value from qa_acg_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
	     
	     $yet_rvw =  $this->Common_model->get_single_value($qSql);

       $from_date = mmddyy2mysql($this->input->get('from_date'));
       $to_date = mmddyy2mysql($this->input->get('to_date'));

       if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";

       if(get_role_dir()=='agent'){
         $user .="where id ='$current_user'";
       }


   	 $qSql= "SELECT * from
	 	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	 	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	 	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	 	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acg_feedback  $cond And agent_id='$current_user'  And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit','Certificate Audit')) xx Inner Join
	 (Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

	       $data["qa_acg"] = $this->Common_model->get_query_result_array($qSql);
	     }else{

       // $qSql = "SELECT * from
       // (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
       // (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
       // (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
       // (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acg_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')) xx Inner Join
       // (Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";

       // $data["qa_acg"] = $this->Common_model->get_query_result_array($qSql);
     }
     $data["tot_feedback"] = $tot_feedback;
     $data["yet_rvw"] = $yet_rvw;
     $data["from_date"] = $from_date;
     $data["to_date"] = $to_date;

     $this->load->view('dashboard',$data);
   }
 }


 public function agent_acg_feedback_rvw($id)
 {
	 	if(check_logged_in()){
	 		$current_user=get_user_id();
	 		$user_office_id=get_user_office_id();
	     $data["aside_template"] = "qa/aside.php";
	     $data["content_template"] = "qa_acg/agent_acg_rvw.php";
	     //$data["content_template"] = "qa_acg/agent_accs_rvw.php";
	     $data["content_js"] = "qa_accs_js.php";

	 		//$data["campaign"] = $campaign;
	 		$data["pnid"]=$id;

	 		$qSql="SELECT * from
	 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_acg_feedback where id='$id') xx Left Join
	 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
	 		$data["agent_acg_rvw"] = $this->Common_model->get_query_row_array($qSql);

	 		if($this->input->post('pnid'))
	 		{
	 			$pnid=$this->input->post('pnid');
	 		//	$curDateTime=CurrMySqlDate();

				 $curDateTime = date('Y-m-d H:i');
	 			$log=get_logs();

	 			$field_array1=array(
	 				"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
	 				"agent_rvw_note" => ucwords($this->input->post('note')),
	 				"agent_rvw_date" => $curDateTime
	 			);
	 			$this->db->where('id', $pnid);
	 			$this->db->update("qa_acg_feedback",$field_array1);

	 		  redirect('qa_acg/agent_acg_feedback');

	 		}else{
	 			$this->load->view('dashboard',$data);
	 		}
	 	}
 }

    ////////////////////ENDS AGENT PART//////////////////
 ////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// ACG Audit REPORT//////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

public function qa_acg_report()
{
	if(check_logged_in()){
		$user_office_id=get_user_office_id();
		$current_user = get_user_id();
		$is_global_access=get_global_access();
		$role_dir=get_role_dir();
		$data["show_download"] = false;
		$data["download_link"] = "";
		$data["show_table"] = false;
		$data["show_table"] = false;
		$data["aside_template"] = "reports_qa/aside.php";
		$data["content_template"] = "reports_qa/qa_acg_report.php";
		$data["content_js"] = "qa_accs_js.php";

		$data['location_list'] = $this->Common_model->get_office_location_list();

		$office_id = "";
		$date_from="";
		$date_to="";
		$audit_type="";
		$campaign="";
		$action="";
		$dn_link="";
		$cond="";
		$cond1="";

    $show=$this->input->get('show');
		$data["qa_acg_list"] = array();
		//$from_date = mmddyy2mysql($this->input->get('from_date'));
	 // $to_date   = mmddyy2mysql($this->input->get('to_date'));
		//print_r($_REQUEST);
	  $from_date = $this->input->get('from_date');
		$to_date = $this->input->get('to_date');

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
	
	$office_id = $this->input->get('office_id');

	if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' )";

	if($office_id=="All" || $office_id == '') $cond .= "";
	else $cond .=" and office_id='$office_id'";

	if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
	  $cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
	}else if((get_role_dir()=='tl' && get_user_fusion_id()!='FMAN000616') && get_dept_folder()=='operations'){
	  $cond1 .=" And assigned_to='$current_user'";
	}else{
	  $cond1 .="";
	}


	  $qSql="SELECT * from
	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	(select d.description from department d left join signin sd on d.id=sd.dept_id where sd.id=entry_by) as auditor_dept,
	(select r.name from role r left join signin sr on r.id=sr.role_id where sr.id=entry_by) as auditor_role,
	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
	(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_acg_feedback) xx
	Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

	$fullAray = $this->Common_model->get_query_result_array($qSql);


 	$data["qa_acg_list"]=$fullAray;

  	//print_r($fullAray);
	//  $_session['qa_acc_list']=$fullAray;


  $this->create_qa_acg_CSV($fullAray);
  $dn_link = base_url()."Qa_acg/download_qa_acg_CSV"; //     important link

	$data['download_link']=$dn_link;
	$data["action"] = $action;
	$data['from_date'] = $from_date;
	$data['to_date'] = $to_date;


	$this->load->view('dashboard',$data);
	
	}
}

public  function download_qa_acg_CSV() // testing vikas
{
  $currDate=date("Y-m-d");

  $filename = "./qa_files/qa_acg/Report".get_user_id().".csv";
  $newfile="QA acg  List-'".$currDate."'.csv";
  header('Content-Disposition: attachment;  filename="'.$newfile.'"');
  readfile($filename);
}

public function create_qa_acg_CSV($rr)
{
  $currDate=date("Y-m-d");


  $filename = FCPATH . "qa_files/qa_acg/Report".get_user_id().".csv";
  $fopen = fopen($filename,"w+");


  $header = array("Auditor Name", "Audit Date", "Agent Name", "Employee ID ", "L1 Supervisor ", "Call Date ", "Audit Type ", "Auditor Type","Brand","Call ID ","ACPT","Phone Number","L1","L2", "Earned Score ", "Possible Score ", "Overall Score % ",  "VOC",
     "Did the agent greeted the customer while opening the call?","Did the agent greeted the customer while opening the call? - Remarks", "Did the agent mentioned his name and the brand name on call? ","Did the agent mentioned his name and the brand name on call? - Remarks", "Did the agent mentioned that the customer is on a recorded line?", "Did the agent mentioned that the customer is on a recorded line? - Remarks","Agent had proper rate of speech on call?","Agent had proper rate of speech on call? - Remarks","Agent did not overlapped the customer while speaking?", "Agent did not overlapped the customer while speaking?  - Remarks", "Agent sounded energrtic and confident on call?","Agent sounded energrtic and confident on call? - Remarks ",  "Agent asked permission before putting the call on hold?","Agent asked permission before putting the call on hold? - Remarks ", "Agent mentioned the reason for putting the customer on hold","Agent mentioned the reason for putting the customer on hold - Remarks ", "Agent thanked the customer after resuming the call from hold","Agent thanked the customer after resuming the call from hold - Remarks ","Agent was able to answer all the customer query and handle the objection","Agent was able to answer all the customer query and handle the objection - Remarks", "Did the agent pause the recording when collecting the SSN-DOB-CC?","Did the agent pause the recording when collecting the SSN-DOB-CC? - Remarks ", "Agent created right amount of urgency on call to convert the call into sales","Agent created right amount of urgency on call to convert the call into sales - Remarks "," Did the agent properly mentioned the pricing and tenurity of the plan?  ", "Did the agent properly mentioned the pricing and tenurity of the plan? - Remarks","Did the agent suggested the right plan to the customer?","Did the agent suggested the right plan to the customer? - Remarks","Did the agent explained what the plan would cover and also complete features of the plan?","Did the agent explained what the plan would cover and also complete features of the plan? - Remarks","Did the agent offer at least 1 digital option to the customer prior to offering the Automated Verbal Approval?","Did the agent offer at least 1 digital option to the customer prior to offering the Automated Verbal Approval? - Remarks","Did the agent inform the customer about emailing the order summary and that this is accessible at xfinity.com/MyAccount?","Did the agent inform the customer about emailing the order summary and that this is accessible at xfinity.com/MyAccount? - Remarks","Did the agent inform about Auto IVR reviewing the order summary?","Did the agent inform about Auto IVR reviewing the order summary? - Remarks","Did the agent inform customer to press 1 for approval?","Did the agent inform customer to press 1 for approval? - Remarks","Did the agent inform about staying online with customer?","Did the agent inform about staying online with customer? - Remarks","Did the agent inform about asking questions before providing approval?","Did the agent inform about asking questions before providing approval? - Remarks","Did the agent accurately answer the customer's questions?","Did the agent accurately answer the customer's questions? - Remarks","Did a technical issue occur on the call?","Did a technical issue occur on the call? - Remarks","Did the agent press 1 in the IVR on the customer's behalf?","Did the agent press 1 in the IVR on the customer's behalf? - Remarks","Did the agent read the disclosure verbatim according to the brand?","Did the agent read the disclosure verbatim according to the brand? - Remarks","Did the agent summrized the ordeer before closing?","Did the agent summrized the ordeer before closing? - Remarks","Did the agent closed the call properly by thanking the customer?","Did the agent closed the call properly by thanking the customer? - Remarks",

     "Audit Start date and  Time ", "Audit End Date and  Time"," Call Interval",
      "Call Summary ","Feedback ","Agent Feedback Status ", "Agent Review","Agent Review Date/Time","Management Review Date/Time ", "Management Review Name ","Management Review Note", "Client Review Name","Client Review Note","Client Review Date/Time " );

  $row = "";
  foreach($header as $data) $row .= ''.$data.',';
  fwrite($fopen,rtrim($row,",")."\r\n");
  $searches = array("\r", "\n", "\r\n");



    foreach($rr as $user)
    {
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
  	$row .= '"'.$user['audit_type'].'",';
  	$row .= '"'.$user['auditor_type'].'",';
    $row .= '"'.$user['type_of_audit'].'",';
  	$row .= '"'.$user['call_id'].'",';
  	$row .= '"'.$user['acpt'].'",';
  	$row .= '"'.$user['phone'].'",';
  	$row .= '"'.$user['l1'].'",';
  	$row .= '"'.$user['l2'].'",';
  	$row .= '"'.$user['earned_score'].'",';
  	$row .= '"'.$user['possible_score'].'",';
  	$row .= '"'.$user['overall_score'].'"% ,';
  	$row .= '"'.$user['voc'].'",';
		
	$row .= '"'.$user['opening_call'].'",';
	$row .= '"'.$user['cmt1'].'",';
	$row .= '"'.$user['brand_name'].'",';
	$row .= '"'.$user['cmt2'].'",';
	$row .= '"'.$user['recorded_line'].'",';
	$row .= '"'.$user['cmt3'].'",';
	$row .= '"'.$user['rate_of_speech'].'",';
	$row .= '"'.$user['cmt4'].'",';
	$row .= '"'.$user['overlapped_customer'].'",';
	$row .= '"'.$user['cmt5'].'",';
	$row .= '"'.$user['energrtic'].'",';
	$row .= '"'.$user['cmt6'].'",';
	$row .= '"'.$user['call_on_hold'].'",';
	$row .= '"'.$user['cmt7'].'",';
	$row .= '"'.$user['call_on_hold_reason'].'",';
	$row .= '"'.$user['cmt8'].'",';
	$row .= '"'.$user['call_on_hold_resume'].'",';
	$row .= '"'.$user['cmt9'].'",';
	$row .= '"'.$user['customer_query'].'",';
	$row .= '"'.$user['cmt10'].'",';
	$row .= '"'.$user['pause_recording_ssn'].'",';
	$row .= '"'.$user['cmt11'].'",';
	$row .= '"'.$user['convert_call_sales'].'",';
	$row .= '"'.$user['cmt12'].'",';
	$row .= '"'.$user['pricing_tenurity'].'",';
	$row .= '"'.$user['cmt13'].'",';
	$row .= '"'.$user['right_plan_suggestion'].'",';
	$row .= '"'.$user['cmt14'].'",';
	$row .= '"'.$user['plan_cover'].'",';
	$row .= '"'.$user['cmt15'].'",';
	$row .= '"'.$user['least_one_digital_option'].'",';
	$row .= '"'.$user['cmt16'].'",';
	$row .= '"'.$user['email_order_summary'].'",';
	$row .= '"'.$user['cmt17'].'",';
	$row .= '"'.$user['auto_IVR_reviewing'].'",';
	$row .= '"'.$user['cmt18'].'",';
	$row .= '"'.$user['press_one_approval'].'",';
	$row .= '"'.$user['cmt19'].'",';
	$row .= '"'.$user['staying_online'].'",';
	$row .= '"'.$user['cmt20'].'",';
	$row .= '"'.$user['asking_questions'].'",';
	$row .= '"'.$user['cmt21'].'",';
	$row .= '"'.$user['accurately_answer'].'",';
	$row .= '"'.$user['cmt22'].'",';
	$row .= '"'.$user['technical_issue'].'",';
	$row .= '"'.$user['cmt23'].'",';
	$row .= '"'.$user['customers_behalf_IVR'].'",';
	$row .= '"'.$user['cmt24'].'",';
	$row .= '"'.$user['disclosure_verbatim'].'",';
	$row .= '"'.$user['cmt25'].'",';
	$row .= '"'.$user['summrized_the_order'].'",';
	$row .= '"'.$user['cmt26'].'",';
	$row .= '"'.$user['closed_call_properly'].'",';
	$row .= '"'.$user['cmt27'].'",';

  	$row .= '"'.$user['audit_start_time'].'",';
  	$row .= '"'.$user['entry_date'].'",';
  	$row .= '"'.$interval1.'",';
  	$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
  	$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
  	$row .= '"'.$user['agnt_fd_acpt'].'",';

  	$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
  	$row .= '"'.$user['agent_rvw_date'].'",';
  	$row .= '"'.$user['mgnt_rvw_date'].'",';
  	$row .= '"'.$user['mgnt_rvw_name'].'",';

  	$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
  	$row .= '"'.$user['client_rvw_name'].'",';
    $row .= '"'.$user['client_rvw_note'].'",';
   // $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'",';

  	$row .= '"'.$user['client_rvw_date'].'",';

      fwrite($fopen,$row."\r\n");
    }
    fclose($fopen);
}
 //////////////////////VIKAS ENDS////////////////////////////


// ///////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////////////////////// QA oyo_inb REPORT //////////////////////////////////////
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
}
