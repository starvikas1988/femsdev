<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class User_history extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->library('excel');
		$this->load->model('reports_model');
	}
	
	////////////////////////////////////////////////////////////////////////////
	///////////////////////ADD HISTORY///ADDED BY VIVEK ON 11.30.2018///////////
	////////////////////////////////////////////////////////////////////////////
				
		public function history(){

			
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			
			$_fusion_id = get_user_fusion_id();
			
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			
			$data["aside_template"] = get_aside_template();
			$data["content_template"] = "user_history/add.php";
			
			$agentID="";
			$agentData=array();
			$error="";
			$m_type="";
			$m_message="";
			$migrateDone=false;
			$msg='';
			
			$comments="";
			$m_date="";
			
			$evt_date = CurrMySqlDate();
			$cur_date = CurrDate();
			$log=get_logs();	
			
			$agClient_id="";	
			
			if($this->input->get('submit')=="Search")
			{
				$agentID = $this->input->get('agentID');
					
					if($agentID!="" )
					{
							
					$qSql="SELECT *,(Select shname from department s where s.id=b.dept_id) as dept_name, get_client_ids(b.id) as client_ids, get_client_names(b.id) as client_name, get_process_ids(b.id) as process_ids, get_process_names(b.id) as process_name, (Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role k  where k.id=b.role_id) as role_name FROM signin b where fusion_id = '$agentID' OR omuid='$agentID' ";
							
					$agentData=$this->Common_model->get_query_result_array($qSql);
						
					if(empty($agentData)){
							
							$data["error_msg"] = "Error";
						 
					}else{
						
						
						$agClient_id = $agentData[0]['client_ids'];
						
					}
						
						
				}
					
					
			}else if( $this->input->get('submit')=="Confirm & Save" || $this->input->get('submit')=="Rejoin & Save" ){
				
				
				$uid = $this->input->get('uid');
				$opid = $this->input->get('opid');
				$orid = $this->input->get('orid');
				$deptid = $this->input->get('deptid');
				$oclid = $this->input->get('oclid');
				$ustatus = $this->input->get('ustatus');
				
				
				/// add data from dept id pending for tomorrow

				$m_type = $this->input->get('m_type');
				$role_id = $this->input->get('role_id');
				
				$client_id = $this->input->get('client_id');
				
				$process_id = $this->input->get('process_id');
				$dept_id = $this->input->get('dept_id');
				$m_date = $this->input->get('m_date');
				
				$batch_code = $this->input->get('batch_code').trim();
				$assigned_to = $this->input->get('assigned_to').trim();
				
				
				if($m_date!="")$m_date=mmddyy2mysql($m_date);
				
				
				$comments = $this->input->get('comments');
				
				
				echo $uid . " >> ". $m_type . " >> ". $orid . " >> ". $role_id . " >> ". $m_date . " >> ". $comments;
				
				if($uid !="" && $m_type!="" && $orid!="" &&  $role_id!==''   && $m_date!="" && $comments!=""){
					
					$this->db->trans_begin();
					/////////////////////////////
						
					
					if($ustatus ==0){
												
						$_field_array = array(
							"user_id" => $uid,
							"event_time" => $evt_date,
							"event_by" => $current_user,
							"event_master_id" => '8',
							"start_date" => $m_date,
							"end_date" => $m_date,
							"remarks" => "Migrate",
							"log" => $log
						); 
				
						
						
						$this->db->update("signin",array("status"=>1,"disposition_id" =>1), array("id"=>$uid));
						
						$this->db->update("terminate_users",array("rejon_date"=>$m_date),array("user_id"=>$uid,"rejon_date" =>null));
						
						$event_id = data_inserter('event_disposition',$_field_array);
						
					}
					
					
					if($assigned_to != "") $this->db->update("signin", array("assigned_to" => $assigned_to ), array("id"=>$uid));
					if($batch_code!="") $this->db->update("signin", array("batch_code" => $batch_code ), array("id"=>$uid));
					
					
					if($m_type==1){
						
						if($role_id=="" || $role_id<=1 ){
							$error="Error to Migrate. Invalid Role.";
							
						}else if($role_id == $orid){
							$error="Error to Migrate. Old and New Role Are Same.";
						}else{
																					
							$history_array = array(
								"user_id" => $uid,
								"h_type" => $m_type,
								"from_id" => $orid,
								"to_id" => $role_id,
								"affected_date" => $m_date,
								"comments" => $comments,
								"event_date" => $evt_date,
								"event_by" => $current_user,
								"log" => $log,
							); 
							$up_array = array(
								"role_id" => $role_id,
							);
							
							
							
							$rowid= data_inserter('history_emp_all',$history_array);
							
							
							//$this->db->where('id', $uid);
							//$this->db->where('role_id', $orid);
							//$this->db->update('signin',$up_array );
							
							$SQLtxt = "UPDATE signin set role_id=$role_id where id=$uid";
							$this->db->query($SQLtxt);
							
							
							
							if ($this->db->trans_status() === FALSE)
							{
								$this->db->trans_rollback();
								$migrateDone=false;
							}else{
								$this->db->trans_commit();
								$migrateDone=true;
							}
							
							$m_message=" $m_type| $orid => $role_id";
						}
						
					}else if($m_type==2){
						
						if($process_id=="" || $process_id<=0  || $client_id=="" || $client_id<=0 ){
							$error="Invalid Client OR Process.";
							
						}else if($process_id == $opid){
							$error="Error to Migrate. Old and New Process Are Same.";
							
						}else{
							
														
							$history_CL_array = array(
								"user_id" => $uid,
								"h_type" => '4',
								"from_id" => $oclid,
								"to_id" => $client_id,
								"affected_date" => $m_date,
								"comments" => $comments,
								"event_date" => $evt_date,
								"event_by" => $current_user,
								"log" => $log,
							);
							
							$history_array = array(
								"user_id" => $uid,
								"h_type" => $m_type,
								"from_id" => $opid,
								"to_id" => $process_id,
								"affected_date" => $m_date,
								"comments" => $comments,
								"event_date" => $evt_date,
								"event_by" => $current_user,
								"log" => $log,
							);
							
							$up_CL_array = array(
								"client_id" => $client_id,
							);
							
							$up_array = array(
								"process_id" => $process_id,
							);
							
							
							
							$rowid= data_inserter('history_emp_all',$history_CL_array);
							$rowid= data_inserter('history_emp_all',$history_array);
							
							$this->db->where('user_id', $uid);
							//$this->db->where('client_id', $oclid);
							$this->db->update('info_assign_client',$up_CL_array );
							
							$this->db->where('user_id', $uid);
							//$this->db->where('process_id', $opid);
							$this->db->update('info_assign_process',$up_array );
																
							if ($this->db->trans_status() === FALSE)
							{
								$this->db->trans_rollback();
								$migrateDone=false;
							}else{
								$this->db->trans_commit();
								$migrateDone=true;
							}
							
							$m_message=" $m_type| $opid => $process_id";
							   
						}
						
					}else if($m_type==3){
						
						if($dept_id=="" || $dept_id<=0 ){
						$error="Invalid dept.";
							
						}else if($dept_id == $deptid){
							$error="Error to Migrate. Old and New dept Are Same.";
						}else{
							
														
							$history_array = array(
								"user_id" => $uid,
								"h_type" => $m_type,
								"from_id" => $deptid,
								"to_id" => $dept_id,
								"affected_date" => $m_date,
								"comments" => $comments,
								"event_date" => $evt_date,
								"event_by" => $current_user,
								"log" => $log,
							); 
							
							$up_array = array(
								"process_id" => $process_id,
							);
							 
							$rowid= data_inserter('history_emp_all',$history_array);
							
							//$this->db->where('id', $uid);
							//$this->db->where('process_id', $opid);
							//$this->db->update('signin',$up_array );
							
							$SQLtxt = "UPDATE signin set dept_id=$dept_id where id=$uid";
							$this->db->query($SQLtxt);
							
							
							if ($this->db->trans_status() === FALSE)
							{
								$this->db->trans_rollback();
								$migrateDone=false;
							}else{
								$this->db->trans_commit();
								$migrateDone=true;
							}
						
							$m_message=" $m_type| $opid => $dept_id";
							   
						}
						
					}else{
						$error="Error to Migrate. Invalid Migration Type.";
					}
					
					
					if($migrateDone==true){
							
						//////////LOG////////
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();								
						$LogMSG="Migrate User ID: $uid ($m_message)  ";
						log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						//////////
					    $this->session->set_flashdata("error",show_msgbox("User history Successfully Done",false));
					    redirect(base_url()."user_history/success?uid=$uid");
					}	   
					
					
					
				}else{
					$error="One Or More Fields Are Blank.";
				}
				
				if($error!=""){
					$qSql="SELECT *,(Select shname from department s where s.id=b.dept_id) as dept_name, get_process_ids(b.id) as process_ids, get_process_names(b.id) as process_name ,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role k  where k.id=b.role_id) as role_name FROM signin b where id = '$uid'";
					$agentData=$this->Common_model->get_query_result_array($qSql);
				}			
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
						
			$data['process_list'] = $this->Common_model->get_process_list($agClient_id);
			
			//$cond=" and id in(2,4,3,5,6,7,8,9,12,13,14)";
			$data['roll_list'] = $this->Common_model->get_rolls_for_assignment3();
			
			$data['dept_list'] = $this->Common_model->get_department_list();
			
			
			$qSql="Select id,name from process where is_active=1";
			$data['m_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				//$tl_cnd=" and site_id=".$user_site_id;
				$tl_cnd=" and office_id='$user_office_id' ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				
			}else $data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
						
			
			$data["history_type"] =  $this->Common_model->history_type();
			
			
			$data['m_type']=$m_type;
			$data['agentID']=$agentID;
			$data['agentData']=$agentData;
			$data['m_date']=$m_date;
			$data['comments']=$comments;
			$data['error']=$error;
			
			$this->load->view('dashboard',$data);
			
		}


	public function success()
	{
		if(check_logged_in())
		{
			
			
			$data["aside_template"] = get_aside_template();
			$data["content_template"] = "user_history/success.php";
			
			$uid = $this->input->get('uid');
			$uid=addslashes(trim($uid));
			
			$qSql="SELECT id,fusion_id,omuid,fname,lname,office_id,role_id,(Select office_name from office_location b where b.abbr=a.office_id) as office_name, (Select name from role c where c.id=a.role_id) as role_name, get_process_names(a.id) as process_name,(Select description from department d where d.id=a.dept_id )as dep_name  from signin a WHERE id=\"$uid\"";
			
			$user_info=$this->Common_model->get_query_result_array($qSql);
								
			if(!empty($user_info)){
				
				$data["user_id"] =$uid;
				$data["user_name"] =$user_info[0]['fname']." ".$user_info[0]['lname'];
				
				$data["fusion_id"] =$user_info[0]['fusion_id'];
				$data["office_id"] =$user_info[0]['office_id'];
				$data["office_name"] =$user_info[0]['office_name'];
				$data["role_name"] =$user_info[0]['role_name'];
				$data["process_name"] =$user_info[0]['process_name'];
				$data["dept_name"] =$user_info[0]['dep_name'];
				
				$data["omuid"] =$user_info[0]['omuid'];
							
			}else{
				 redirect(base_url()."user_history");
			}
			
			$this->load->view('dashboard',$data);
			
		}
	
	}
	
}