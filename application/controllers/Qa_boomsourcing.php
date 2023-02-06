<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_boomsourcing extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('Common_model');
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		//error_reporting(E_ALL ^ E_WARNING);
		
	 }
	 
	
	public function audit_delete($table)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$curDateTime=CurrMySqlDate();
			$pid = trim($this->input->post('pid'));
			
			if($pid!=""){
				$this->db->query("Delete from ".$table."_feedback where id=$pid");
				$this->db->query("Delete from ".$table."_client_feedback where ss_id=$pid");
			/////////////////
				$delete_array = array(
					"audit_id" => $pid,
					"audit_table" => $table,
					"delete_by" => $current_user,
					"delete_date" => $curDateTime
				);
				$rowid= data_inserter('qa_delete_audit_record_logs',$delete_array);
				
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
	
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "SELECT * from 
			(Select id, assigned_to,(Select CONCAT(fname,' ' ,lname) from signin s where s.id=m.assigned_to) as tl_name, (select office_name from office_location ol where ol.abbr=office_id) as office_name, fusion_id, xpoid, get_process_names(id) as process_name, DATEDIFF(CURDATE(), doj) as tenure FROM signin m where id='$aid' and status='1') xx Left Join 
			(Select user_id, phone from info_personal) yy On (xx.id=yy.user_id)";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	
	
	 public function createPath($path)
	{

		if (!empty($path)) 
		{

	    	if(!file_exists($path))
			{

	    		$mainPath="./";
	    		$checkPath=str_replace($mainPath,'', $path);
	    		$checkPath=explode("/",$checkPath);
	    		$cnt=count($checkPath);
	    		for($i=0;$i<$cnt;$i++)
				{

		    		$mainPath.=$checkPath[$i].'/';
		    		if (!file_exists($mainPath))
					 {
		    			$oldmask = umask(0);
						$mkdir=mkdir($mainPath, 0777);
						umask($oldmask);

						if ($mkdir) 
						{
							return true;
						}else{
							return false;
						}
		    		}

	    		}

    		}else
			{
    			return true;
    		}
    	}


	}


	private function audio_upload_files($files,$path)
    {
    	$result=$this->createPath($path);
    	if($result){
        $config['upload_path'] = $path;
		$config['allowed_types'] = '*';
		//$config['detect_mime'] = FALSE;
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
	
	
	// private function audio_upload_files($files,$path)
 //    {
 //        $config['upload_path'] = $path;
	// 	$config['allowed_types'] = '*';
	// 	$config['max_size'] = '2024000';
	// 	$this->load->library('upload', $config);
	// 	$this->upload->initialize($config);

 //        $images = array();
		
 //        foreach ($files['name'] as $key => $image) {           
	// 		$_FILES['images[]']['name']= $files['name'][$key];
	// 		$_FILES['images[]']['type']= $files['type'][$key];
	// 		$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
	// 		$_FILES['images[]']['error']= $files['error'][$key];
	// 		$_FILES['images[]']['size']= $files['size'][$key];

 //            if ($this->upload->do_upload('images[]')) {
	// 			$info = $this->upload->data();
	// 			$images[] = $info['file_name'];
 //            } else {
 //                return false;
 //            }
 //        }

 //        return $images;
 //    }
	
	
	/* private function netmeds_upload_files($files,$path)
    {
        $config['upload_path'] = $path;
		$config['allowed_types'] = '*';
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
    } */

/*-------------------------------------------------------------------------------------------------------------------*/
/*------------------------------------------------- AUDIT SHEETS ---------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------*/

	
///////////////////////////////////////////////////////////////////////////////////////////	 
/*------------------------------------- BOOMSOURCING ---------------------------------------*/	
///////////////////////////////////////////////////////////////////////////////////////////

	public function boomsourcing(){
		if(check_logged_in())
		{
			//checking if any survey assigned for this user or not, if exist it ill redirect to home page
			$mySurvey = $this->user_model->checkUsersSurvey();
			if(!empty($mySurvey[1])){
				redirect(base_url().'home');
			}
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/qa_boomsourcing_feedback.php";
			$data["content_js"] = "qa_boomsourcing_js.php";
			
			if(((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='operations') || get_dept_folder()=='training'){
				$data["rebuttal"]='';
			}else{
				if(get_global_access()=='1'){
					$rebuttalSql="Select count(id) as value from qa_boomsourcing_feedback where agnt_fd_acpt='Not Accepted'";
				}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
					$rebuttalSql="Select count(id) as value from qa_boomsourcing_feedback where agnt_fd_acpt='Not Accepted' and qa_rebuttal is not Null and qa_mgnt_rebuttal is Null";
				}else if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){
					$rebuttalSql="Select count(id) as value from qa_boomsourcing_feedback where entry_by='$current_user' and agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
				}
				$data["rebuttal"]=$this->Common_model->get_single_value($rebuttalSql);
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, office_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,275) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qaSql="Select entry_by, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name from qa_boomsourcing_feedback group by entry_by";
			$data["qaName"] = $this->Common_model->get_query_result_array($qaSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$qa_id = $this->input->get('qa_id');
			$cond="";
			$atacond="";
			
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
			if($qa_id !="")	$cond .=" and entry_by='$qa_id'";
			
			if(get_global_access()=='1'){
				$ops_cond="where 1";
			}else if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user') or entry_by='$current_user')";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" Where (assigned_to='$current_user' or entry_by='$current_user')";
			}else if(get_role_dir()=='agent' && get_dept_folder()=='qa'){
				$ops_cond=" Where entry_by='$current_user'";
			}else{
				$ops_cond="where 1";
			}
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_boomsourcing_feedback $cond) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				$ops_cond order by audit_date";
			$data["boomsourcing_list"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["qa_id"] = $qa_id;
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_boomsourcing($ss_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/add_edit_boomsourcing.php";
			$data["content_js"] = "qa_boomsourcing_js.php";
			$data['ss_id']=$ss_id;
			
			
			$qSql="Select office_name as value from office_location where abbr='$user_office_id'";
			$data["auditorLocation"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,275) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select office_name from office_location where abbr=(select office_id from signin os where os.id=entry_by)) as auditor_center,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin sqr where sqr.id=qa_rebuttal_by) as qa_rebuttal_name,
				(select concat(fname, ' ', lname) as name from signin sqmr where sqmr.id=qa_mgnt_rebuttal_by) as qa_mgnt_rebuttal_name
				from qa_boomsourcing_feedback where id='$ss_id') xx Left Join 
				(Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure
				 from signin) yy on (xx.agent_id=yy.sid)
				Left Join (select ss_id as ata_audit_id from qa_boomsourcing_client_feedback) zz On (xx.id=zz.ata_audit_id)";
			$data["boomsourcing"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			$b = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ss_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_by']=$current_user;
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$field_array['overall_score']=$this->input->post('overall_score');

					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/Qa_boomsourcing/');
						$field_array['attach_file'] = implode(',',$a);
					}
					
					if($_FILES['attach_img_file']['tmp_name'][0]!=''){
						$b = $this->audio_upload_files($_FILES['attach_img_file'], $path='./qa_files/Qa_boomsourcing/');
						$field_array['attach_img_file'] = implode(',',$b);
					}
					
					$rowid= data_inserter('qa_boomsourcing_feedback',$field_array);
				////////////////////////
					if($this->input->post('overall_score')=='100%'){
						$agnt_acpt_array = array(
							"agnt_fd_acpt" => 'Accepted',
							"agent_rvw_date" => $curDateTime,
							"agent_rvw_note" => 'Auto Accepted because Overall Score is 100'
						);
						$this->db->where('id', $rowid);
						$this->db->update('qa_boomsourcing_feedback',$agnt_acpt_array);
					}
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array1['overall_score']=$this->input->post('overall_score');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/Qa_boomsourcing/');
						$field_array['attach_file'] = implode(',',$a);
					}
					
					$this->db->where('id', $ss_id);
					$this->db->update('qa_boomsourcing_feedback',$field_array1);
				/////////////
					if(get_role_dir()=='agent' && get_dept_folder()=='qa'){
						if($this->input->post('qa_rebuttal')){
							$edit_array = array(
								"qa_rebuttal_by" => $current_user,
								"qa_rebuttal" => $this->input->post('qa_rebuttal'),
								"qa_rebuttal_comment" => $this->input->post('qa_rebuttal_comment'),
								"qa_rebuttal_date" => $curDateTime
							);
						}
					}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
						if($this->input->post('qa_mgnt_rebuttal')){
							$edit_array = array(
								"qa_mgnt_rebuttal_by" => $current_user,
								"qa_mgnt_rebuttal" => $this->input->post('qa_mgnt_rebuttal'),
								"qa_mgnt_rebuttal_comment" => $this->input->post('qa_mgnt_rebuttal_comment'),
								"qa_mgnt_rebuttal_date" => $curDateTime
							);
						}
					}else if(get_dept_folder()!='qa'){
						$edit_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $ss_id);
					$this->db->update('qa_boomsourcing_feedback',$edit_array);
					
				}
				redirect('Qa_boomsourcing/boomsourcing');
			}
			$data["array"] = $a;
			$data["array"] = $b;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_boomsourcing_client($ss_id,$ata_edit){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/add_edit_boomsourcing_client.php";
			$data["content_js"] = "qa_boomsourcing_js.php";
			$data['ss_id']=$ss_id;
			$data['ata_edit']=$ata_edit;
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id, xpoid FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,275) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			if($ata_edit==0){
				$clientSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
					from qa_boomsourcing_feedback where id='$ss_id') xx Left Join 
					(Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure
					from signin) yy on (xx.agent_id=yy.sid)";
				
			}else if($ata_edit==1){
				$clientSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as ata_auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=auditor_id) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=update_by) as update_name
					from qa_boomsourcing_client_feedback where ss_id='$ss_id') xx Left Join 
					(Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			}
			$data["boomsourcing"] = $this->Common_model->get_query_row_array($clientSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ata_edit==0){
					
					$field_array=$this->input->post('data');
					$field_array['ss_id']=$this->input->post('ss_id');
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$field_array['auditor_id']=$this->input->post('auditor_id');
					$field_array['ticket_id']=$this->input->post('ticket_id');
					$field_array['audit_date']=mmddyy2mysql($this->input->post('audit_date'));
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_by']=$current_user;
					$field_array['entry_date']=$curDateTime;
					$rowid= data_inserter('qa_boomsourcing_client_feedback',$field_array);
					//echo $this->db->last_query(); 
					//die;
				///////////
					$ata_array = array("ata_edit" => 1);
					$this->db->where('id', $ss_id);
					$this->db->update('qa_boomsourcing_feedback',$ata_array);
				
				}else if($ata_edit==1){
					
					$field_array1=$this->input->post('data');
					$field_array1['update_by']=$current_user;
					$field_array1['update_date']=$curDateTime;
					$field_array1['update_note']=$this->input->post('note');
					$this->db->where('ss_id', $ss_id);
					$this->db->update('qa_boomsourcing_client_feedback',$field_array1);
					
				}
				redirect('Qa_boomsourcing/boomsourcing');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
/*-------------------------------- QA Rebuttal --------------------------------*/
	public function qa_boomsourcing_rebuttal(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/qa_boomsourcing_rebuttal.php";
			$data["content_js"] = "qa_boomsourcing_js.php";
			
			if(get_global_access()=='1'){
				$ops_cond=" where agnt_fd_acpt='Not Accepted'";
			}else if((get_role_dir()=='manager' || get_role_dir()=='tl') && get_dept_folder()=='qa'){
				$ops_cond=" where agnt_fd_acpt='Not Accepted' and qa_rebuttal is not Null and qa_mgnt_rebuttal is Null";
			}else if((get_role_dir()!='manager' || get_role_dir()!='tl') && get_dept_folder()=='qa'){
				$ops_cond=" where entry_by='$current_user' and agnt_fd_acpt='Not Accepted' and qa_rebuttal is Null";
			}
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, 
				(select concat(fname, ' ', lname) as name from signin s where s.id=mgnt_rvw_by) as mgnt_rvw_name from qa_boomsourcing_feedback) xx 
				Left Join (Select id as sid, fname, lname, xpoid, fusion_id, office_id, assigned_to from signin) yy On (xx.agent_id=yy.sid) 
				Left Join (select ss_id as ata_audit_id from qa_boomsourcing_client_feedback) zz On (xx.id=zz.ata_audit_id)
				$ops_cond order by audit_date";
			$data["rebuttal_details"] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////	 
/*------------------------------------- QA REPORT SECTION  --------------------------------------*/	
///////////////////////////////////////////////////////////////////////////////////////////

	public function qa_boomsourcing_report(){
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
			
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/qa_boomsourcing_report.php";
			$data["content_js"] = "qa_boomsourcing_js.php";
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['pValue']=$pValue;
			
			$locSql="SELECT * FROM office_location WHERE is_active=1 ORDER BY office_name";
			$data['location_list'] = $this->Common_model->get_query_result_array($locSql);
			
			$date_from="";
			$date_to="";
			$a_type="";
			$action="";
			$dn_link="";
			$cond='';
			$cond1='';
			$cond2='';
			$cond3 = '';
			$camp_cond='';
			
			$data["qa_boomsourcing_list"] = array();

			$qSql = "SELECT p.id AS pro_id,p.name AS process_name,q.table_name AS table_name,q.params_columns AS params_columns FROM qa_boomsourcing_defect AS q
				INNER JOIN process AS p ON p.id=q.process_id and q.is_active=1";
			$process_arr1 = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT q.process_id AS pro_id,q.table_name AS process_name,q.table_name AS table_name,q.params_columns AS params_columns from qa_boomsourcing_defect AS q
			INNER JOIN process AS p ON p.id = FLOOR(q.process_id)";
			$process_arr2 = $this->Common_model->get_query_result_array($qSql);
			
			$marge_array=array_unique(array_merge($process_arr1,$process_arr2));
			$data['all_process'] = $marge_array;
			//echo $qSql;
			//print_r($marge_array);
			//die("okk");
			if($this->input->get('show')=='Show')
			{
				 $date_from = mmddyy2mysql($this->input->get('date_from'));
				 $date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$a_type = $this->input->get('a_type');
				
				//$auditDate=getEstToLocal('entry_date',$current_user);
				
				if($date_from !="" && $date_to!=="" ){
					 $cond = " Where (date(getEstToLocal(entry_date,agent_id)) >= '$date_from' and date(getEstToLocal(entry_date,agent_id)) <= '$date_to' ) ";
				}  
					//$cond= " Where (date(audit_date)>='$date_from' and date(audit_date)<='$date_to' ) ";
		
				if($office_id=="All") $cond2 = ""; 
				else $cond2 .=" and office_id='$office_id'";
				
				if($a_type=="All"){
					$cond3="";
				}else{
					$cond3 .=" and audit_type='$a_type'";
				}
					
				
				if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
					$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
				}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
					$cond1 .=" And assigned_to='$current_user'";
				}else{
					$cond1 .="";
				}	
				
				$qSql1 = "SELECT p.id AS pro_id,p.name AS process_name,q.table_name AS table_name,q.params_columns AS params_columns,q.param_coloum_desc AS param_coloum_desc FROM qa_boomsourcing_defect AS q
				INNER JOIN process AS p ON p.id=q.process_id and q.is_active=1 and q.table_name= '".$pValue."' ";
				$process_arr11 = $this->Common_model->get_query_result_array($qSql1);

				$qSql2 = "SELECT q.process_id AS pro_id,q.table_name AS process_name,q.table_name AS table_name,q.params_columns AS params_columns,q.param_coloum_desc AS param_coloum_desc from qa_boomsourcing_defect AS q
				INNER JOIN process AS p ON p.id = FLOOR(q.process_id) and q.table_name= '".$pValue."' ";
				$process_arr22 = $this->Common_model->get_query_result_array($qSql2);
				
				$marge_array_List=array_unique(array_merge($process_arr11,$process_arr22));
				
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select office_name from office_location where abbr=(select office_id from signin os where os.id=entry_by)) as qa_location,
				(select email_id_off from info_personal ip where ip.user_id=entry_by) as auditor_email,
				(select email_id_off from info_personal ips where ips.user_id=agent_id) as agent_email,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from ".$pValue.") xx 
				Left Join (Select id as sid, concat(fname, ' ', lname) as agent_name, xpoid, fusion_id, doj, assigned_to, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 $cond2 $cond3";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_boomsourcing_list"] = $fullAray;
				$this->create_qa_boomsourcing_CSV($fullAray,$marge_array_List,$pValue);	
				$dn_link = base_url()."Qa_boomsourcing/download_qa_boomsourcing_CSV/".$pValue;
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['a_type']=$a_type;
			
			$this->load->view('dashboard',$data);
		}
	}
	

	public function download_qa_boomsourcing_CSV($pid)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Otipy ".$pid." List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_boomsourcing_CSV($rr,$marge_array_List,$pid)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$merger = explode(",",$marge_array_List[0]['params_columns']);

			$header = array();
			$header = explode(",",$marge_array_List[0]['param_coloum_desc']);
			$header_first = array("QA name", "QA Location", "Agent Name", "TL Name", "Tenure", "Earn Score", "Possible Score", "Quality Score", "PreFatal Score", "Fatal Count", "Week", "Audit Date", "Zone","Phone","Link","Reps Name","Center","Disposition", "Call Date", "AHT", "Customer VOC", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)");
			$header_second = explode(",",$marge_array_List[0]['param_coloum_desc']);
			$header_third = array("Call Summary", "Feedback","Agent Review Date", "Agent Feedback Acceptance Status", "Agent Feedback Review By", "Agent Comment", "Management Review By", "Management Review Date", "Management Comment", "Attach Audio File","Attach Image File");
			$header_fourth = array_merge($header_first,$header_second);
			$header = array_merge($header_fourth,$header_third);
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
			foreach($rr as $key => $user){
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval1 = '---';
				}else{
					$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				if(is_available_qa_feedback($user['entry_date'],72) == true){
					$agnt_fd_acpt = $user['agnt_fd_acpt'];
				}else{
					if($user['agent_rvw_date']!=""){
						$agnt_fd_acpt = $user['agnt_fd_acpt'];
					}else{
						$agnt_fd_acpt = "Auto Accepted";
					}
				}
				
				if($user['week']!=""){
					$week=$user['week'];
				}else{
					$week='Week4';
				}
				
				if($user['qa_rebuttal_date']=="" || $user['qa_rebuttal_date']=='0000-00-00 00:00:00'){
					$qa_rebuttal_date='---';
				}else{
					$qa_rebuttal_date=ConvServerToLocal($user['qa_rebuttal_date']);
				}
				
				if($user['qa_mgnt_rebuttal_date']=="" || $user['qa_mgnt_rebuttal_date']=='0000-00-00 00:00:00'){
					$qa_mgnt_rebuttal_date='---';
				}else{
					$qa_mgnt_rebuttal_date=ConvServerToLocal($user['qa_mgnt_rebuttal_date']);
				}
				
				if($user['agent_fd_rvw_by']==$user['agent_id']){
					$agnt_rvw_by='Agent';
				}else{
					$agnt_rvw_by='TL/Manager';
				}
				
				$adtdate=ConvServerToLocal($user['entry_date']);
				$time = strtotime($adtdate);
				$auditDate = date('Y-m-d',$time);
				
				$row = '"'.$user['auditor_name'].'",';  
				$row .= '"'.$user['qa_location'].'",';  
				$row .= '"'.$user['agent_name'].'",'; 
				$row .= '"'.$user['tl_name'].'",'; 
				$row .= '"'.$user['tenure'].' Days'.'",';
				$row .= '"'.$user['earn_score'].'",'; 
				$row .= '"'.$user['possible_score'].'",'; 
				$row .= '"'.$user['overall_score'].'%'.'",'; 
				$row .= '"'.$user['pre_fatal_score'].'",'; 
				$row .= '"'.$user['fatal_count'].'",'; 
				$row .= '"'.$week.'",';
				$row .= '"'.$auditDate.'",';
				$row .= '"'.$user['zone'].'",';
				$row .= '"'.$user['phone'].'",';
				$row .= '"'.$user['link'].'",';
				$row .= '"'.$user['reps_name'].'",';
				$row .= '"'.$user['center'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['customer_voc'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.ConvServerToLocal($user['audit_start_time']).'",';
				$row .= '"'.ConvServerToLocal($user['entry_date']).'",';
				$row .= '"'.$interval1.'",';
				
				foreach($merger as $para){
					$row .= '"'.$user["$para"].'",';
					//echo '"'.$user[$para].'",';
					//echo $para;

				}
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'.$agnt_fd_acpt.'",';
				$row .= '"'.$$agnt_rvw_by.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['attach_file'])).'"';
				fwrite($fopen,$row."\r\n");
			}
			//exit("okk");
			fclose($fopen);
	}
	

/*----------------------------------------------------------------------------------------------------------------------------*/
/*------------------------------------------------- QA ACCEPTED ATA Audit ---------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------------------*/
	public function qa_ata_audit(){
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/qa_ata_audit.php";
			$data["content_js"] = "qa_boomsourcing_js.php";
			
			$from_date = '';
			$to_date = '';
			$ata_campaign = '';
			
			$ata_campaign = $this->input->post('ata_campaign');
			
			if($ata_campaign!=""){
			
				$qSql="Select count(id) as value from qa_".$ata_campaign."_client_feedback where auditor_id='$current_user'";
				$data["tot_ata"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_".$ata_campaign."_client_feedback where auditor_id='$current_user' and qa_ata_date is Null";
				$data["yet_ata_rvw"] =  $this->Common_model->get_single_value($qSql);
				
				if($this->input->get('btnView')=='View')
				{
					$from_date = mmddyy2mysql($this->input->get('from_date'));
					$to_date = mmddyy2mysql($this->input->get('to_date'));
						
					if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
					
					$qSql = "SELECT * from
					(Select *, date(entry_date) as ata_date, (select concat(fname, ' ', lname) as name from signin s where s.id=auditor_id) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin sc where sc.id=entry_by) as ata_auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_".$ata_campaign."_client_feedback $cond and auditor_id='$current_user') xx Left Join
					(Select id as sid, fname, lname, fusion_id, xpoid, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["ata_audit_list"] = $this->Common_model->get_query_result_array($qSql);		
				}
				
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["ata_campaign"] = $ata_campaign;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function view_ata_audit($ata_campaign,$ata_audit_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_boomsourcing/view_ata_audit.php";
			$data["content_js"] = "Qa_boomsourcing_js.php";
			$data['ata_campaign']=$ata_campaign;
			$data['ata_audit_id']=$ata_audit_id;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as ata_auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=auditor_id) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=update_by) as update_name
				from qa_".$ata_campaign."_client_feedback where id='$ata_audit_id') xx Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["ata_details"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('ata_audit_id'))
			{
				$ata_audit_id=$this->input->post('ata_audit_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array=array(
					"qa_ata_acpt" => $this->input->post('qa_ata_acpt'),
					"qa_ata_note" => $this->input->post('qa_ata_note'),
					"qa_ata_date" => $curDateTime
				);				
				$this->db->where('id', $ata_audit_id);
				$this->db->update('qa_'.$ata_campaign.'_client_feedback',$field_array);
				redirect('Qa_boomsourcing/qa_ata_audit');
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function view_qa_audit($ata_campaign,$ss_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "Qa_boomsourcing/view_qa_audit.php";
			$data["content_js"] = "Qa_boomsourcing_js.php";
			$data['ss_id']=$ss_id;
			$data['ata_campaign']=$ata_campaign;
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_".$ata_campaign."_feedback where id='$ss_id') xx 
				Left Join (Select id as sid, fname, lname, fusion_id, xpoid, office_id, assigned_to, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid)";
			$data["qa_details"] = $this->Common_model->get_query_row_array($qSql);
			
			$this->load->view('dashboard',$data);
		}
	}
	

/*----------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------- AGENT FEEDBACK -------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------------------*/	
	public function agent_boomsourcing_feedback()
	{
		if(check_logged_in())
		{
			//checking if any survey assigned for this user or not, if exist it ill redirect to home page
			$mySurvey = $this->user_model->checkUsersSurvey();
			if(!empty($mySurvey[1])){
				redirect(base_url().'home');
			}
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/agent_boomsourcing_feedback.php";
			$data["content_js"] = "qa_boomsourcing_js.php";
			$data["agentUrl"] = "qa_boomsourcing/agent_boomsourcing_feedback";
				
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			
			$campaign = $this->input->get('campaign');
			
			if($campaign!=''){
				
				$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
					
				$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null ";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
				if($this->input->get('btnView')=='View')
				{
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
					
					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					if($fromDate !="" && $toDate!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user'  ";
					}else{
						$cond= " Where agent_id='$current_user' ";
					}
					
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback $cond and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);	
				}
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_boomsourcing_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/agent_boomsourcing_rvw.php";
			$data["content_js"] = "qa_boomsourcing_js.php";
			$data["agentUrl"] = "qa_boomsourcing/agent_boomsourcing_feedback";
			$data["campaign"]=$campaign;
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sqr where sqr.id=qa_rebuttal_by) as qa_rebuttal_name,
				(select concat(fname, ' ', lname) as name from signin sqmr where sqmr.id=qa_mgnt_rebuttal_by) as qa_mgnt_rebuttal_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["boomsourcing_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('agent_rvw_note'),
					"agent_rvw_date" => $curDateTime
				);				
				$this->db->where('id', $pnid);
				$this->db->update('qa_'.$campaign.'_feedback',$field_array1);
				
				redirect('Qa_boomsourcing/agent_boomsourcing_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
/*-------------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------- ATA REPORT SECTION -------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------------*/
	public function qa_boomsourcing_ata_report(){
        if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();

			$ses_client_id=get_client_ids();
			$ses_process_id=get_process_ids();

			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;

			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/qa_boomsourcing_ata_report.php";
			$data["content_js"] = "qa_boomsourcing_js.php";

			$data['location_list'] = $this->Common_model->get_office_location_list();

			//$process_name_sql="SELECT p.name, qd.process_id FROM process p INNER JOIN qa_defect qd ON p.id = CAST(qd.process_id as UNSIGNED) WHERE qd.is_active=1";
			$data['process_list'] = array();

			if(is_access_qa_module()==true || $ses_client_id==0){
				$qaCond='';
			}else{
				$qaCond = "WHERE p.client_id in ( $ses_client_id ) AND p.id in ( $ses_process_id )";
			}

			$qSql = "SELECT p.id AS pro_id,p.name AS process_name FROM qa_boomsourcing_defect AS q
			INNER JOIN process AS p ON p.id=q.process_id $qaCond";
			$process_arr1 = $this->Common_model->get_query_result_array($qSql);

			$NotINnqSql = "( SELECT p.id FROM qa_boomsourcing_defect AS q
			INNER JOIN process AS p ON p.id=q.process_id $qaCond )";

			$qSql = "SELECT q.process_id AS pro_id, q.table_name AS process_name from qa_boomsourcing_defect AS q
			INNER JOIN process AS p ON p.id = FLOOR(q.process_id) $qaCond and q.process_id not in $NotINnqSql ";
			$process_arr2 = $this->Common_model->get_query_result_array($qSql);

			$marge_array=array_unique(array_merge($process_arr1,$process_arr2));
			$data['process_list'] = $marge_array;
			//$data['process_names']=$this->db->query($process_name_sql)->result_array();

			$cond1="";
			$date_from="";
			$date_to="";
			$office_id="";
			$action="";
			$dn_link="";

			$campaign = $this->input->get('campaign');

			$data["qa_boomsourcing_ata_list"] = array();

			if($this->input->get('show')=='Show'){
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');

				//if($date_from !="" && $date_to!=="" )  $cond1 =" Where (date(ssc.audit_date)>='$date_from' and date(ssc.audit_date)<='$date_to') ";

				$cond1 .=" and S.office_id IN ('".implode("','", $office_id)."')";

				$qSql="SELECT params_columns, table_name, ata_table_name FROM qa_boomsourcing_defect WHERE process_id='$campaign'";
				$result_data=$this->db->query($qSql)->row();
				$params=explode(",", $result_data->params_columns);
				$table_name=$result_data->table_name;
				$ata_table_name=$result_data->ata_table_name;

				//Add Prefix Function
				function addSSCPrefix($column){
					return "ssc.".$column." as ata_".$column;
				}
				function addSSPrefix($column){
					return "ss.".$column." as qa_".$column;
				}
				$ssc_query_params = implode(",", array_map('addSSCPrefix', $params));
				$ss_query_params = implode(",", array_map('addSSPrefix', $params));

				$querySql="SELECT ssc.ss_id, ssc.auditor_id, ssc.audit_date, ssc.agent_id, ssc.tl_id, ssc.entry_by, ssc.entry_date as ata_end_time, ssc.audit_start_time,
				ssc.ticket_id, ssc.call_date, ssc.overall_score, $ssc_query_params, date(ssc.entry_date) as ata_entry_date, ssc.qa_ata_acpt, ssc.qa_ata_note, date(ssc.qa_ata_date) as ata_acpt_date,
				ss.id, ss.ticket_id as qa_ticket, ss.call_date as qa_calldate, ss.overall_score as qa_score, $ss_query_params,
				S.fusion_id, S.xpoid, concat(S.fname, ' ', S.lname) as agent_name, S.office_id, concat(SE.fname, ' ', SE.lname) as ata_auditor_name,
				concat(SA.fname, ' ', SA.lname) as auditor_name, concat(SAS.fname, ' ', SAS.lname) as tl_name
				FROM $ata_table_name ssc
				LEFT JOIN $table_name ss ON ssc.ss_id = ss.id
				LEFT JOIN signin S ON S.id = ssc.agent_id
				LEFT JOIN signin SE ON SE.id = ssc.entry_by
				LEFT JOIN signin SA ON SA.id = ssc.auditor_id
				LEFT JOIN signin SAS ON SAS.id = ssc.tl_id
				WHERE (date(ssc.audit_date) >= '$date_from' AND date(ssc.audit_date) <= '$date_to') $cond1
				ORDER BY ssc.audit_date";

				$fullAray = $this->Common_model->get_query_result_array($querySql);
				$data["qa_boomsourcing_ata_list"] = $fullAray;
				$this->create_qa_boomsourcing_ata_CSV($fullAray,$campaign);
				$dn_link = base_url()."Qa_boomsourcing/download_qa_boomsourcing_ata_CSV/".$campaign;

			}

			$data['download_link'] = $dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;
			$data['office_id'] = $office_id;
			$data['campaign'] = $campaign;
			$this->load->view('dashboard',$data);
		}
    }



    public function download_qa_boomsourcing_ata_CSV($campaign){
		$process_name=$this->db->query("SELECT p.name FROM process p LEFT JOIN qa_boomsourcing_defect qd ON p.id=(CAST(qd.process_id as UNSIGNED)) WHERE qd.process_id='$campaign'")->row();
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Boomsourcing ".$process_name->name." ATA List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	//New CSV Function
	public function create_qa_boomsourcing_ata_CSV($rr, $campaign){
		$header=array("QA Name", "ATA Name", "Agent Name", "Employee ID", "TL Name", "Call Date", "Ticket ID", "QA Overall Score", "ATA Overall Score", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)");
		$qSql="SELECT params_columns, table_name, ata_table_name FROM qa_boomsourcing_defect WHERE process_id='$campaign'";
		$result_data=$this->db->query($qSql)->row();
		$params=explode(",", $result_data->params_columns);
		$table_name=$result_data->table_name;
		$ata_table_name=$result_data->ata_table_name;

		//Add Prefix Function
		function SSCPrefix($column){
			return "ATA ".ucwords($column);
		}
		function SSPrefix($column){
			return "QA ".ucwords($column);
		}
		$ssc_query_params = array_map('SSCPrefix', $params);
		$ss_query_params = array_map('SSPrefix', $params);
		$header=array_merge($header, $ssc_query_params, $ss_query_params, array("ATA Variance(out of ".count($params)." parameters)", "ATA Variance Percentage", "ATA Feedback Acceptance Status", "Acceptance Date", "Acceptance Feedback"));

		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		foreach($rr as $user){
			if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
				$interval1 = '---';
			}else{
				$interval1 = strtotime($user['ata_end_time']) - strtotime($user['audit_start_time']);
			}

			$ata_varience = 0;
			foreach ($params as $param) {
				if($user['ata_'.$param] == $user['qa_'.$param]){
					$ata_varience += 0;
				}else{
					$ata_varience += 1;
				}
			}
			$ata_varience_percentage = round(((($ata_varience)/count($params))*100),2);

			$row = '"'.$user['auditor_name'].'",';
			$row .= '"'.$user['ata_auditor_name'].'",';
			$row .= '"'.$user['agent_name'].'",';
			$row .= '"'.$user['xpoid'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['ticket_id'].'",';
			$row .= '"'.$user['qa_score'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['ata_end_time'].'",';
			$row .= '"'.$interval1.'",';

			foreach ($params as $param) {
				$row .= '"'.$user['ata_'.$param].'",';
			}
			foreach ($params as $param) {
				$row .= '"'.$user['qa_'.$param].'",';
			}
			$row .= '"'.$ata_varience.'",';
			$row .= '"'.$ata_varience_percentage.'%'.'",';

			$row .= '"'.$user['qa_ata_acpt'].'",';
			$row .= '"'.$user['ata_acpt_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['qa_ata_note'])).'"';

			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);
	}
	
	
/*--------------------------------------------------------------------------------------------------*/
///////////////////////////////////////// QA Create Audio File //////////////////////////////////////
	public function record_audio($ss_id){
		if(check_logged_in()){
			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/record_audio.php";
			//$data["js"] = "qa_meesho/record_audio_js.php";
			if ($_SESSION['nonce'] === $_POST['nonce'] && !empty($_FILES['payload'])) {
        		$info = pathinfo($_FILES['payload']['name']);
        		echo $fname = $_FILES['payload']['tmp_name'];die;
        // new file must be less than 10mb
        		if (filesize($fname) < 10 * pow(1024, 2))
            		move_uploaded_file($fname, "./audio.wav");
        			$_SESSION['nonce'] = '';
    }


			$this->load->view('dashboard',$data);
		}
	}
	

}
?>	 