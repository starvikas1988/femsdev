<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Training extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('Profile_model');
		$this->load->model('Email_model');
		$this->load->library('excel');
	}
	
/////////////////////////
		
		public function index(){
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				
				if($oValue!="ALL" ){
						$filterCond = " and (location='$oValue' OR batch_office_id = '$oValue') ";
						$filterCond2 = " and (location_id='$oValue' OR batch_office_id = '$oValue') ";
				}
				
				
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training")){
					
					$qSql = "Select tb.id, trainer_id, tb.client_id, c.shname as client_name, tb.process_id,  p.name as process_name, location, trn_start_date, trn_batch_status from training_batch tb 
					left join process p on p.id= tb.process_id
					left join client c on c.id= tb.client_id
					LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id
					where trn_type=2 $filterCond4 $filterCond $filterCond3			
					group by location, client_id, tb.process_id";
					
					$data["process_batch"] = $process_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					
					$qSql = "Select tb.id, trainer_id, tb.client_id, c.shname as client_name, tb.process_id,  p.name as process_name, location, job_title, trn_start_date, trn_batch_status from training_batch tb
					left join process p on p.id= tb.process_id
					left join client c on c.id= tb.client_id
					LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id
					where trainer_id='$current_user' and trn_type=2 $filterCond4 $filterCond3
					group by location, client_id, tb.process_id";
					
					$data["process_batch"] = $process_batch = $this->Common_model->get_query_result_array($qSql);
					
				}
				
				
				
				$AllBatchArray = array();
				
				foreach($process_batch as $row){
					
					$client_id= $row['client_id'];
					$process_id= $row['process_id'];
					$location= $row['location'];
					
					$key = $location."-".$client_id."-".$process_id;
					
					
						/*$qSql = "Select tb.id, trn_batch_status, trainer_id, tb.client_id, tb.process_id, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location, job_title, trn_start_date, headcount, totattr, hrattr, avgscore from training_batch tb 
						LEFT JOIN signin ON  signin.id=tb.trainer_id
						LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id
						LEFT JOIN (
						SELECT trn_batch_id, count(trn_batch_id) as headcount, (select count(trn_batch_id) from v_training_details v where status in (0,2) and v.trn_batch_id=vtr.trn_batch_id ) as totattr, (select count(trn_batch_id) from v_training_details v where status in (0,2) and termDays<=3 and v.trn_batch_id=vtr.trn_batch_id ) as hrattr, round(avg(avgscore),2)as avgscore FROM `v_training_details` vtr group by trn_batch_id
						) tbCount ON tbCount.trn_batch_id = tb.id
						where trn_type=2 $filterCond4 and location='$location' and tb.client_id = '$client_id' and 	tb.process_id = '$process_id' ";*/
						
					$qSql = "Select tb.id, trn_batch_status, trainer_id, tb.client_id, tb.process_id, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location, job_title, trn_start_date, headcount, totattr, hrattr, avgscore from training_batch tb 
						LEFT JOIN signin ON  signin.id=tb.trainer_id
						LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id
						LEFT JOIN (
						SELECT trn_batch_id, count(trn_batch_id) as headcount, (select count(trn_batch_id) from v_training_details v where status in (0,2) and v.trn_batch_id=vtr.trn_batch_id ) as totattr, (select count(trn_batch_id) from v_training_details v where status in (0,2) and termDays<=3 and v.trn_batch_id=vtr.trn_batch_id ) as hrattr, 
						CASE WHEN round(avg(avgscore),2) >= 1 THEN round(avg(avgscore),2) ELSE round(avg(avgscore),2)*100 END
						as avgscore 
						FROM `v_training_details` vtr group by trn_batch_id
						) tbCount ON tbCount.trn_batch_id = tb.id
						where trn_type=2 $filterCond4 and location='$location' and tb.client_id = '$client_id' and 	tb.process_id = '$process_id' ";
					
					
					//echo $qSql."<br>";
					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$batch_id= $row['id'];
					
					// GET CERTIFICATION SCORE				
					$sqlpercent = "SELECT (COUNT(*) / SUM(CASE WHEN trn_batch_id='$batch_id' THEN 1 ELSE 0 END)) * 100 AS value FROM training_details
								   WHERE is_certify = '1' AND trn_batch_id = '$batch_id'";
					$querypercent = $this->Common_model->get_single_value($sqlpercent);					
					$data['batch_percent'][$batch_id] = $querypercent;
					
					
					
				}
				
				$data["AllBatchArray"] = $AllBatchArray;
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/crt_summary.php";
				
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
		public function crt_batch(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				 
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/training.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and (location='$oValue' OR batch_office_id = '$oValue')";
						$filterCond2 = " and (location_id='$oValue' OR batch_office_id = '$oValue')";
				}
				
				
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
							
				$qSql="Select id,name from master_term_type where is_active=1";
				$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="Select id,name from master_sub_term_type where is_active=1";
				$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="Select id,description from master_resign_reason where is_active=1";
				$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
			
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
										
					//$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, (Select CONCAT(fname,' ' ,lname) from signin s where s.id=tb.trainer_id) as trainer_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' order by tb.id desc";
					
					$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type=2 $filterCond4 $filterCond $filterCond3 order by tb.id desc";
					
					//echo $qSql;
					
					$data["get_assigned_batch"] = $get_assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}else{
					$myteamIDs = $this->get_team_id($current_user);
					$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where (trainer_id='$current_user' OR trainer_id IN ($myteamIDs)) and trn_type=2 $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["get_assigned_batch"] = $get_assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$j=0;
				foreach($get_assigned_batch as $rowtoken)
				{
					$batch_id = $rowtoken['id'];
					
					$sqltname = "SELECT trainer_id2 as value from training_batch WHERE id = '$batch_id'";
					$trainer2name = $this->Common_model->get_single_value($sqltname);
					if(!empty($trainer2name)){ $tarray = explode(',',$trainer2name); }
					$countt=0;
					foreach($tarray as $tokent)
					{
						$countt++;
						$sqltname = "SELECT concat(fname, ' ', lname) as value from signin WHERE id = '$tokent'";
						$trainer2eachname = $this->Common_model->get_single_value($sqltname);
						$data["batch_trainer"][$batch_id]['names'][] =  $trainer2eachname;
					}
					
					$data["batch_trainer"][$batch_id]['count'] = $countt;
					$qSqlcertify = "Select count(*) as value from training_details where trn_batch_id='$batch_id' and is_certify=0";
					$querycertify = $data['certify'][$batch_id] = $this->Common_model->get_single_value($qSqlcertify);
					
					$qSqltotal = "Select count(*) as value from training_details where trn_batch_id='$batch_id'";
					$querytotal = $data['certify']['total'][$batch_id] = $this->Common_model->get_single_value($qSqltotal);
					
					$qSqlb_test="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type=2 $filterCond4 AND tb.id = '$batch_id'";
					$pm_batch_rowb_test = $this->Common_model->get_query_row_array($qSqlb_test);
					
					$getpmid_test = "SELECT * from training_rag_design WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb_rag = $this->Common_model->get_query_row_array($getpmid_test);
					
					// CHECK USING PROCESS CLIENT
					if(empty($pm_batch_rowb_rag)){
						$getpmid = "SELECT id as value from training_rag_design WHERE client_id = '".$pm_batch_rowb_test['client_id']."' AND process_id = '" .$pm_batch_rowb_test['process_id'] ."' AND office_id = '" .$pm_batch_rowb_test['office_id']."' AND (trn_batch_id IS NULL OR trn_batch_id = '')"; 
						$pm_batch_rowb_rag2 = $this->Common_model->get_single_value($getpmid);
					}
										
					$getcid_test = "SELECT * from training_cert_design WHERE trn_batch_id = '$batch_id'"; 					
					$pm_batch_rowcid_test = $this->Common_model->get_query_row_array($getcid_test);
					
					// CHECK USING PROCESS CLIENT
					if(empty($pm_batch_rowcid_test)){
						$getpmid = "SELECT id as value from training_cert_design WHERE client_id = '".$pm_batch_rowb_test['client_id']."' AND process_id = '" .$pm_batch_rowb_test['process_id'] ."' AND office_id = '" .$pm_batch_rowb_test['office_id']."' AND (trn_batch_id IS NULL OR trn_batch_id = '')"; 
						$pm_batch_rowcid_test2 = $this->Common_model->get_single_value($getpmid);
					}
					
					//$data['candidate_details'][$batch_id] = candidate_details($batch_id);
					
					$pmdid = $pm_batch_rowb_rag['id'];
					$crtdid = $pm_batch_rowcid_test['id'];
					$get_assigned_batch[$j]['designid'] = $pmdid;
					$get_assigned_batch[$j]['designid2'] = $pm_batch_rowb_rag2;
					$get_assigned_batch[$j]['certid'] = $crtdid;
					$get_assigned_batch[$j]['certid2'] = $pm_batch_rowcid_test2;
					$j++;
				}
				
				$data["get_assigned_batch"] = $get_assigned_batch;
				//echo "<pre>" .print_r($get_assigned_batch, true) ."</pre>";die();
				
				
				$qSql="Select id,title,location,(select min(id) from lt_question_set qs where qs.exam_id =ex.id ) as SetID, (select count(id) from lt_question_set qs where qs.exam_id =ex.id ) as totSet , (select count(id) from lt_questions ques where ques.set_id =SetID ) as totQues  FROM lt_examination ex  Where type = 'TR' and status=1";
				
				$data["exam_list"] = $this->Common_model->get_query_result_array($qSql);
				
				if($is_global_access==1) $tl_cnd="";
				else $tl_cnd=" and ( office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
				
			/////////////	
				$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name, office_id from signin where status=1 and ( role_id not in (select id from role where folder='agent') OR dept_id=11) $tl_cnd order by name asc ";
				$data["assigned_l1super"] = $this->Common_model->get_query_result_array($qSql);
			//////////////
				
				if($is_global_access==1) $tl_cnd="";
				else $tl_cnd=" and ( s.office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%', s.office_id,'%') ) ";
				
				$qSqlt = "SELECT s.id, s.fusion_id, d.shname as department, r.name as designation, concat(s.fname, ' ', s.lname) as name, s.office_id from signin s LEFT JOIN department d ON s.dept_id = d.id LEFT JOIN role r on r.id = s.role_id WHERE s.status=1 and (s.role_id not in (select id from role where folder='agent') OR s.dept_id=11) $tl_cnd ORDER BY name ASC ";
				$data["assigned_trainerlist"]  = $this->Common_model->get_query_result_array($qSqlt);
			
			
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
				
				$data['e_client_list'] = $this->Common_model->get_client_list();
				$data['e_process_list'] = $this->Common_model->get_process_for_assign();

				
							
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
		public function crt_batch_details()
		{
			$batch_id = $data['batch_id'] = $this->input->post('batchid');
			
			$data['candidate_details'][$batch_id] = $candidatedata = candidate_details($batch_id);
			
			foreach($candidatedata as $crow)
			{
				$user_id = $crow['user_id'];
				
				// GET CERTIFICATION SCORE
				$sqlcertification = "SELECT t.is_certify, t.is_recertify FROM training_details as t WHERE t.trn_batch_id = '$batch_id' AND t.user_id = '$user_id'";
				$querycertification = $this->Common_model->get_query_row_array($sqlcertification);
				$is_certify = 0; $is_recertify = 0;
				if(!empty($querycertification['is_certify'])){ $is_certify = $querycertification['is_certify']; }
				if(!empty($querycertification['is_recertify'])){ $is_recertify = $querycertification['is_recertify']; }
				
				// GET RAG SCORE
				$sqlrag = "SELECT kpi_value as value FROM training_rag_data WHERE trn_batch_id = '$batch_id' AND user_id = '$user_id' AND kpi_value IN ('red','amber','green') order by id DESC LIMIT 1";
				$queryrag = $this->Common_model->get_single_value($sqlrag);
				
				$data['candidate_result'][$batch_id]['certification'][$user_id] = $is_certify;
				$data['candidate_result'][$batch_id]['recertification'][$user_id] = $is_recertify;
				$data['candidate_result'][$batch_id]['rag'][$user_id] = $queryrag;

	        }
			
			$this->load->view('training/training_ajax',$data);
			
		}




//=======================================================================================================	
//   BATCH RAG DESIGN
//=======================================================================================================


	   public function get_clients_training()
	   {
			$office_id = $this->input->post('office_id');
			if($office_id != 'ALL')
			{
				$qSql="SELECT DISTINCT client.id, client.shname FROM training_batch
				LEFT JOIN client ON client.id=training_batch.client_id
				LEFT JOIN dfr_requisition ON dfr_requisition.id=training_batch.ref_id WHERE dfr_requisition.location='".$office_id."'";
			}
			else
			{
				$qSql="SELECT DISTINCT client.id,client.shname FROM training_batch
				LEFT JOIN client ON client.id=training_batch.client_id
				LEFT JOIN dfr_requisition ON dfr_requisition.id=training_batch.ref_id";
			}
			echo json_encode($this->Common_model->get_query_result_array($qSql));
	   }
	   
	
		public function batch_rag_design(){
			
			if(check_logged_in())
			{
				$current_user     = get_user_id();
				$user_site_id     = get_user_site_id();
				$user_office_id   = get_user_office_id();
				$user_oth_office  = get_user_oth_office();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$role_dir         = get_role_dir();
				$role_id          = get_role_id();
				$get_dept_id      = get_dept_id();
				
				$data["aside_template"]   = "training/aside.php";
				$data["content_template"] = "training/training_batch_rag_design.php";
				
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$bValue = trim($this->input->post('batch_id'));
				if($bValue=="") $bValue = trim($this->input->get('batchid'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
				$data['bValue']=$bValue;
										
				$_filterCond="";
				
				if($oValue!="ALL" && $bValue!="")  $_filterCond  = " AND trn_batch_id='".$bValue."'";
				//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") $qSql="SELECT DISTINCT client_id,client.shname FROM training_rag_design LEFT JOIN client ON client.id=training_rag_design.client_id WHERE office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1'";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
								
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" WHERE id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				// FORM URL DATA
				$data['hide_normal'] = "off";
				$data['url_batch_id'] = "";
				$url_batch_id = $this->uri->segment(3);
				if($url_batch_id != ""){
					
					$data['url_batch_id'] = $url_batch_id;
					
					$sql = "Select b.id as batch_id,batch_office_id,client_id ,process_id, b.batch_name, 
						(SELECT name from process y where y.id = b.process_id) as process_name,
						(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
						(SELECT shname from client c where c.id = b.client_id) as client_name, sb.office_id as trn_office_id 
						from training_batch as b 
						LEFT JOIN (SELECT office_id, id from signin) as sb ON sb.id = b.trainer_id
						WHERE b.id = '$url_batch_id'";
					$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
					$cc_office_id = $querybatch['batch_office_id'];
					if(empty($querybatch['batch_office_id'])){ $cc_office_id = $querybatch['trn_office_id']; }
					
					// CHECK ANY PREVIOUS DESIGN
					$sqldd = "SELECT id as value from training_rag_design WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' AND  office_id = '".$cc_office_id."' ORDER BY ID DESC LIMIT 1";
					$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
					if($pv_rag != ""){
						$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from training_rag_kpi kp where did = $pv_rag";
						$data['pv_rag_desgin'] = $this->Common_model->get_query_result_array($qSql);
					}
				}
				
				if($this->input->get('batchid') != ""){
					
				$qSql = "Select mp.id as mp_id,office_id,client_id ,process_id, is_active, description, 
						(SELECT batch_name from training_batch b where b.id = mp.trn_batch_id) as batch_name,
						(SELECT name from process y where y.id = mp.process_id) as process_name,
						(SELECT office_name from office_location k  where k.abbr = mp.office_id) as office_name,
						(SELECT shname from client c where c.id = mp.client_id) as client_name 
						from training_rag_design mp Where is_active=1 $_filterCond";
				$data["rag_design"] = $rag_design = $this->Common_model->get_query_result_array($qSql);
				
				// CHECK PROCESS CLIENT
				if(empty($rag_design)){
					
					$row_batch="SELECT tb.*, c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, 
							office_id, location from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id 
							LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id 
							where trn_batch_status = '1' and trn_type=2 AND tb.id = '$bValue'";
					$query_row_batch = $this->Common_model->get_query_row_array($qSqlb);				
					if(!empty($query_row_batch)){
						$qSql = "Select mp.id as mp_id,office_id,client_id ,process_id, is_active, description, 
							(SELECT batch_name from training_batch b where b.id = mp.trn_batch_id) as batch_name,
							(SELECT name from process y where y.id = mp.process_id) as process_name,
							(SELECT office_name from office_location k  where k.abbr = mp.office_id) as office_name,
							(SELECT shname from client c where c.id = mp.client_id) as client_name 
							from training_rag_design mp Where is_active=1 AND client_id = '".$query_row_batch['client_id']."' AND process_id = '" .$query_row_batch['process_id'] ."' AND office_id = '" .$query_row_batch['office_id']."' AND (trn_batch_id IS NULL OR trn_batch_id = '')"; 
						$data["rag_design"] = $rag_design = $this->Common_model->get_query_result_array($qSql);
					}
				}
				
				$pmkpiarray = array();
				foreach($rag_design as $row):
					$mp_id=$row['mp_id'];
					$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from training_rag_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
			
				$data['rag_designkpi'] = $pmkpiarray;
				
				}
				//loading training javascript
				//$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
				
			}
		}
		
		
	
	   public function addBatchRagDesign()
		{
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				$_run = false;  
				
				$log = get_logs();
				
				$office_id    = trim($this->input->post('office_id'));
				$client_id    = trim($this->input->post('client_id'));
				$process_id   = trim($this->input->post('process_id'));
				$description  = trim($this->input->post('description'));
				$trn_batch_id  = trim($this->input->post('trn_batch_id'));
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				
				$qSqlcheck      = "SELECT id as value from training_rag_design 
								   WHERE trn_batch_id = '$trn_batch_id'";
				$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				if($uploadcheck != "")
				{
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/batch_rag_design?batchid=".$trn_batch_id."&office_id=".$office_id."&client_id=".$client_id."&process_id=".$process_id."&showReports=Show&exist=yes");
					
				} else {
							
				$field_array = array(
					"office_id"    => $office_id,
					"client_id"    => $client_id,
					"process_id"   => $process_id,
					"trn_batch_id" => $trn_batch_id,
					"description"  => $description,
					"added_by"     => $current_user,
					"is_active"    => '1',
					"added_date"   => $curDateTime,
					"uplog"        => $log
				);
				
				$did = data_inserter('training_rag_design',$field_array);
				
				foreach($kpi_name_arr as $index => $kpi_name){
					
					if($kpi_name<>""){
						
						$field_array = array(
							"did" => $did,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => $curDateTime,
					        "uplog"       => $log
						);
						
						data_inserter('training_rag_kpi',$field_array);
						
					}
					
				}
				
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/batch_rag_design?batchid=".$trn_batch_id."&showReports=Show&added=yes");
				}
				
		   }        
	   }



		public function getTrainingRagDesignForm(){
		
			if(check_logged_in())
			{
				$mdid = trim($this->input->post('mdid'));
				$mdid=addslashes($mdid);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
					
				//$qSql="select * from pm_design where id = $mdid";
				//$design_row=$this->Common_model->get_query_row_array($qSql);
				
				$qSql="SELECT * from training_rag_kpi where did = $mdid";
				$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
				
				/////////
				$html = "";
				
				$TotRow = count($design_kpi_arr);
				
				$cnt = 1; $countr = 0; $countrag = count($design_kpi_arr);
				foreach($design_kpi_arr as $kpiRow) {
					$countr++;
					if($countr < $countrag || $countr == 1){
				
					$html .= "<div class='col-md-12 kpi_input_row'>";
					
					$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";
					
					$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
					
					$html .= "<div class='col-md-5'><select class='form-control' name='kpi_type[]' > ";
					
					foreach($kpi_type_list as $kpimas){
						$sCss="";
						if($kpimas['id']==$kpiRow['kpi_type']){ $sCss="selected"; }
						$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
						//}
					}
									
					$html .= "</select></div>";
							
					$html .= "<div class='col-md-2'>";
						
						if( $cnt++<$TotRow-1){
							
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
						}else{
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
						}
									
					$html .= "</div>";
					$html .= "</div>";
				
					}
				
				}	
						
				echo $html;
			}
		}

	
	   public function updateTrainingRagDesign()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				$_run = false;  
				
				$log = get_logs();
				$mdid = trim($this->input->post('mdid'));
				
				$office_id  = trim($this->input->post('office_id'));
				$client_id  = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$description = trim($this->input->post('description'));
				
				$kpi_id_arr   = $this->input->post('kpi_id');
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				
				$field_array = array(
					"office_id"   => $office_id,
					"client_id"   => $client_id,
					"process_id"  => $process_id,
					"description" => $description,
					"added_by"    => $current_user,
					"is_active"   => '1',
					"added_date"  => $curDateTime,
					"uplog"       => $log
				);
				
				$this->db->where('id', $mdid);
				$this->db->update('training_rag_design',$field_array);
				
				$TotID = count($kpi_id_arr);
				
				// DELETE RAG
				$sql = "DELETE from training_rag_kpi WHERE did = '$mdid'";
				$query = $this->db->query($sql);
				
				
				foreach($kpi_name_arr as $index => $kpi_name)
				{
					if($kpi_name<>"")
					{
						
						$field_array = array(
							"did"         => $mdid,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => $curDateTime,
					        "uplog"       => $log
						);
						
						data_inserter('training_rag_kpi',$field_array);
						
					}
				}
				
				/*
				foreach($kpi_name_arr as $index => $kpi_name){
					
					//echo $TotID . " >> ". $index . "<br>";
					//$kpiid="";
					//if($TotID < $index) 
					
					$kpiid = $kpi_id_arr[$index];
					
					if($kpiid == ""){
						
						$field_array = array(
							"did"            => $mdid,
							"kpi_name"       => $kpi_name,
							"kpi_type"       => $kpi_type_arr[$index],
							"added_by"       => $current_user,
							"isdel"          => '0',
							"added_date"     => $curDateTime,
					        "uplog"          => $log
						);
						data_inserter('training_rag_kpi',$field_array);
						
					} else {
										
						$field_array = array(
							"kpi_name"       => $kpi_name,
							"kpi_type"       => $kpi_type_arr[$index],
							"added_by"       => $current_user,
							"isdel"          => '0',
							"added_date"     => $curDateTime,
					        "uplog"          => $log
							
						);
						
						$this->db->where('id', $kpiid);
						$this->db->update('training_rag_kpi',$field_array );
						
					}
					
				}
				*/
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
	   }
	
	
	
	public function getFormatDesignIDRag()
	{
		$batchid = trim($this->input->get('batchid'));
		$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' and trn_type=2 AND tb.id = '$batchid'";
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		
		// CHECK USING TRN BATCH ID
		$getpmid = "SELECT * from training_rag_design WHERE trn_batch_id = '$batchid'"; 
		$pm_batch_rowb_design = $this->Common_model->get_query_row_array($getpmid);
		
		// CHECK USING PROCESS CLIENT
		if(empty($pm_batch_rowb_design)){
			$getpmid = "SELECT * from training_rag_design WHERE client_id = '".$pm_batch_rowb['client_id']."' AND process_id = '" .$pm_batch_rowb['process_id'] ."' AND office_id = '" .$pm_batch_rowb['office_id']."' AND (trn_batch_id IS NULL OR trn_batch_id = '')"; 
			$pm_batch_rowb_design = $this->Common_model->get_query_row_array($getpmid);
		}
		
		$pmdid = $pm_batch_rowb_design['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}
		
	
		
	public function getFormatDesignCertificateRag()
	{
		$batchid = trim($this->input->get('batchid'));
		$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' and trn_type=2 AND tb.id = '$batchid'";
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		
		// CHECK USING TRN BATCH ID
		$getpmid = "SELECT * from training_cert_design WHERE trn_batch_id = '$batchid'"; 
		$pm_batch_rowb_design = $this->Common_model->get_query_row_array($getpmid);
		
		// CHECK USING PROCESS CLIENT
		if(empty($pm_batch_rowb_design)){
			$getpmid = "SELECT * from training_cert_design WHERE client_id = '".$pm_batch_rowb['client_id']."' AND process_id = '" .$pm_batch_rowb['process_id'] ."' AND office_id = '" .$pm_batch_rowb['office_id']."' AND (trn_batch_id IS NULL OR trn_batch_id = '')"; 
			$pm_batch_rowb_design = $this->Common_model->get_query_row_array($getpmid);
		}
		
		$pmdid = $pm_batch_rowb_design['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}
		



//=======================================================================================================	
//   CERTFICATE
//=======================================================================================================
		
		
		public function certificate(){
			
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/certificate_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and (location='$oValue' OR batch_office_id = '$oValue') ";
						$filterCond2 = " and (location_id='$oValue' OR batch_office_id = '$oValue') ";
				}
				
				
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				if(global_access_training_module()==true)$is_global_access="1";
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
					
					$qSql="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type=2 $filterCond $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="Select tb.*, c.shname as client_name , p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trainer_id='$current_user' and trn_type=2 $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type=2 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					// CHECK USING TRN BATCH ID
					$getpmid = "SELECT * from training_cert_design WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb_design = $this->Common_model->get_query_row_array($getpmid);
					
					// CHECK USING PROCESS CLIENT
					if(empty($pm_batch_rowb_design)){
						$getpmid = "SELECT * from training_cert_design WHERE client_id = '".$pm_batch_rowb['client_id']."' AND process_id = '" .$pm_batch_rowb['process_id'] ."' AND office_id = '" .$pm_batch_rowb['office_id']."' AND (trn_batch_id IS NULL OR trn_batch_id = '')"; 
						//$pm_batch_rowb_design = $this->Common_model->get_query_row_array($getpmid);
					}
					
					$pmdid = $pm_batch_rowb_design['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from training_cert_design WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from training_cert_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
				
					$data['checkupload'][$batch_id] = "0";
					
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from training_cert_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY crtdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from training_cert_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND crtdid = '$ragdid' AND kpi_id = '$kpiid' ORDER by ID DESC LIMIT 1";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							
							if($querym > 1){
							$sqlkpiv = "SELECT kpi_value from training_cert_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND crtdid = '$ragdid' AND kpi_id = '$kpiid' ORDER by ID DESC";
							$querykpiv = $this->Common_model->get_query_result_array($sqlkpiv);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_allvalue'] = $querykpiv;
							}
							
							$jcheck++;
							
						}
						
					}
					
					
					$i++;
				}
				
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
				
				
				
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}

			
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}
		
		
		
		public function rag(){
			
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";

				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/rag_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
			
				if($oValue!="ALL" ){
						$filterCond = " and (location='$oValue' OR batch_office_id = '$oValue') ";
						$filterCond2 = " and (location_id='$oValue' OR batch_office_id = '$oValue')";
				}
				
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
					
					$qSql="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type=2 $filterCond $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="Select tb.*, c.shname as client_name , p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trainer_id='$current_user' and trn_type=2 $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where  trn_type=2 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					// CHECK USING TRN BATCH ID
					$getpmid = "SELECT * from training_rag_design WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb_design = $this->Common_model->get_query_row_array($getpmid);
					
					// CHECK USING PROCESS CLIENT
					if(empty($pm_batch_rowb)){
						$getpmid = "SELECT * from training_rag_design WHERE client_id = '".$pm_batch_rowb['client_id']."' AND process_id = '" .$pm_batch_rowb['process_id'] ."' AND office_id = '" .$pm_batch_rowb['office_id']."' AND (trn_batch_id IS NULL OR trn_batch_id = '')"; 
						//$pm_batch_rowb_design = $this->Common_model->get_query_row_array($getpmid);
					}
					
					$pmdid = $pm_batch_rowb_design['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from training_rag_design WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from training_rag_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$data['checkupload'][$batch_id] = '0';
					$maxNumber = 0;
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from training_rag_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ragdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from training_rag_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ragdid = '$ragdid' AND kpi_id = '$kpiid'";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							if($kpivalue > $maxNumber && !ctype_alpha($kpivalue) && $kpivalue!="")
							{ 
								$maxNumber = $kpivalue; 
							}
							$jcheck++;
						}
					}
					
					
					$uptoRag = 1;
					if($maxNumber <= 10){ $uptoRag = 10; }		
					if($maxNumber <= 1){ $uptoRag = 100; }
					$data['maxRag'][$batch_id] = $maxNumber;
					$data['uptoRag'][$batch_id] = $uptoRag;
					
					
					$i++;
				}
				
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
				
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
			
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}
		
		
		
				
		public function assmnt_batch(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				 
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/assmnt_batch.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and (location='$oValue' OR batch_office_id = '$oValue')";
						$filterCond2 = " and (location_id='$oValue' OR batch_office_id = '$oValue') ";
				}
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				// GET BATCH TYPE
				$batch_type = $this->uri->segment(3);
				$as_trn_type = "2"; $as_trn_name = ""; 
				if($batch_type=='recursive'){ $as_trn_type = "4"; $as_trn_name = "recursive"; }
				if($batch_type=='upskill'){ $as_trn_type = "5"; $as_trn_name = "upskill"; }
				if($batch_type=='nesting'){ $as_trn_type = "3"; $as_trn_name = "nesting"; }
				$data['batch_type'] = $as_trn_type;
				$data['batch_type_name'] = $as_trn_name;
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
							
				$qSql="Select id,name from master_term_type where is_active=1";
				$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="Select id,name from master_sub_term_type where is_active=1";
				$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="Select id,description from master_resign_reason where is_active=1";
				$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
										
					//$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, (Select CONCAT(fname,' ' ,lname) from signin s where s.id=tb.trainer_id) as trainer_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' order by tb.id desc";
					
					$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type='$as_trn_type' $filterCond $filterCond4 $filterCond3 order by tb.id desc";
					// var_dump($qSql);
					// echo $qSql;
					// die();
					
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trainer_id='$current_user' and trn_type='$as_trn_type' $filterCond4 $filterCond3 order by tb.id desc";
					// echo $qSql;
					// die();
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}
				
				
				$j=0;
				foreach($data["get_assigned_batch"] as $rowtoken)
				{
					$batch_id= $rowtoken['id'];
					
					$qSqlb_test="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type='$as_trn_type' AND tb.id = '$batch_id' $filterCond4";
					// echo $qSqlb_test;
					// die();
					$pm_batch_rowb_test = $this->Common_model->get_query_row_array($qSqlb_test);
					
					$getpmid_test = "SELECT * from training_cert_design WHERE client_id = '".$pm_batch_rowb_test['client_id']."' AND process_id = '" .$pm_batch_rowb_test['process_id'] ."' AND office_id = '" .$pm_batch_rowb_test['office_id']."'"; 
					$pm_batch_rowb_test = $this->Common_model->get_query_row_array($getpmid_test);
					
					//$data['training_assessment_name'][$batch_id] = get_training_assmnt_names($batch_id);
					//$data['candidate_details'][$batch_id] = candidate_details($batch_id);
					/*foreach($data['candidate_details'][$batch_id] as $crow)
					{
						 $user_id= $crow['user_id'];
						 $data['get_assessment_details'][$user_id][$batch_id] = get_assmnt_details($user_id,$batch_id);
					}*/					
					
					$pmdid = $pm_batch_rowb_test['id'];
					
					$data["get_assigned_batch"][$j]['designid'] = $pmdid;
					$j++;
				}
								
				
				
				$qSql="Select id,title,location,(select min(id) from lt_question_set qs where qs.exam_id =ex.id ) as SetID, (select count(id) from lt_question_set qs where qs.exam_id =ex.id ) as totSet , (select count(id) from lt_questions ques where ques.set_id =SetID ) as totQues  FROM lt_examination ex  Where type = 'TR' and status=1";
				// echo $qSql;
				// die();
				$data["exam_list"] = $this->Common_model->get_query_result_array($qSql);
			
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
							
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
		public function assmnt_batch_details()
		{
			$batch_id = $data['batch_id'] = $this->input->post('batchid');
			
			$data['training_assessment_name'][$batch_id] = get_training_assmnt_names($batch_id);
			$data['candidate_details'][$batch_id] = $candidatedata = candidate_details($batch_id);
			
			foreach($candidatedata as $crow)
			{
				$user_id = $crow['user_id'];
				$data['get_assessment_details'][$user_id][$batch_id] = get_assmnt_details($user_id,$batch_id);

	        }
			
			$this->load->view('training/assmnt_ajax',$data);
			
		}
		
		
		public function agent(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				
				$uri_user = $this->uri->segment(3);
				
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/dashboard_agent.php";
				
				$qSql="Select *, xx.id as schedule_id,exam_start_time, ass.assmnt_id,ass.tot_corr_ans, ass.score, 
				(Select CONCAT(fname,' ' ,lname) from signin s where s.id=tb.trainer_id) as trainer_name  from 
				(Select * From lt_exam_schedule Where user_id = '$current_user' and module_type='TR') xx 
				LEFT JOIN training_assessment ta ON xx.module_id = ta.id 
				LEFT JOIN (Select * from training_assessment_score where user_id = '$current_user') ass ON ass.assmnt_id=ta.id 
				LEFT JOIN training_batch tb ON tb.id=ta.trn_batch_id";
							
				//echo $qSql;
			
				$ExamArray = $this->Common_model->get_query_result_array($qSql);
				$data["ExamArray"] = $ExamArray;
				
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
		
		public function view_result(){
			if(check_logged_in())
			{
				//$qSql = 'SELECT id as value  FROM lt_question_set WHERE exam_id="'.$exam_id.'" and status=1 ORDER BY RAND() LIMIT 1';
				//$set_id=$this->Common_model->get_single_value($qSql);
				
				$current_user = get_user_id();
				$exam_schedule_id = $data['scheduleid'] = $this->uri->segment(3); 
				$exam_assessment_id = $data['assessmentid'] = $this->uri->segment(4);
				$exam_user_id = $data['euserid'] = $this->uri->segment(5);				
				
				if($exam_user_id != ""){
					$current_user = $exam_user_id;
				}
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/view_result.php";
				
				
				$qSql = "SELECT * FROM lt_questions as q 
				LEFT JOIN lt_user_exam_answer as a ON a.ques_id = q.id 
				LEFT JOIN (SELECT id as aid, text as toption from lt_questions_ans_options) as o ON a.ans_id = o.aid
				LEFT JOIN (SELECT text as correct_option, ques_id as quid, id as cans_id from lt_questions_ans_options WHERE correct_answer = '1') as f on f.quid = q.id 
				WHERE a.exam_schedule_id = '$exam_schedule_id'";			
				$ExamArray = $this->Common_model->get_query_result_array($qSql);
				$data["ExamArray"] = $ExamArray;
				
				$qSqlt = "SELECT score,tot_corr_ans FROM training_assessment_score WHERE assmnt_id = '$exam_assessment_id' AND user_id = '$current_user'";			
				$AssArray = $this->Common_model->get_query_result_array($qSqlt);
				$data["AssArray"] = $AssArray;
				
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
		public function view_result_modal(){
			if(check_logged_in())
			{
				//$qSql = 'SELECT id as value  FROM lt_question_set WHERE exam_id="'.$exam_id.'" and status=1 ORDER BY RAND() LIMIT 1';
				//$set_id=$this->Common_model->get_single_value($qSql);
				
				$current_user = get_user_id();
				$exam_schedule_id = $data['scheduleid'] = $this->uri->segment(3); 
				$exam_assessment_id = $data['assessmentid'] = $this->uri->segment(4);
				$exam_user_id = $data['euserid'] = $this->uri->segment(5);				
				
				if($exam_user_id != ""){
					$current_user = $exam_user_id;
				}
				
				//$data["aside_template"] = "training/aside.php";
				//$data["content_template"] = "training/view_result_modal_check.php";
				
				
				$qSql = "SELECT * FROM lt_questions as q 
				LEFT JOIN lt_user_exam_answer as a ON a.ques_id = q.id 
				LEFT JOIN (SELECT id as aid, text as toption from lt_questions_ans_options) as o ON a.ans_id = o.aid
				LEFT JOIN (SELECT text as correct_option, ques_id as quid, id as cans_id from lt_questions_ans_options WHERE correct_answer = '1') as f on f.quid = q.id 
				WHERE a.exam_schedule_id = '$exam_schedule_id'";		
				$ExamArray = $this->Common_model->get_query_result_array($qSql);
				$data["ExamArray"] = $ExamArray;
				
				$qSqlt = "SELECT score,tot_corr_ans FROM training_assessment_score WHERE assmnt_id = '$exam_assessment_id' AND user_id = '$current_user'";			
				$AssArray = $this->Common_model->get_query_result_array($qSqlt);
				$data["AssArray"] = $AssArray;
				
				$this->load->view('training/view_result_modal_check.php',$data);
				
			}
		}
		
		
		public function assmnt_production_agents(){
			if(check_logged_in())
			{
				//$qSql = 'SELECT id as value  FROM lt_question_set WHERE exam_id="'.$exam_id.'" and status=1 ORDER BY RAND() LIMIT 1';
				//$set_id=$this->Common_model->get_single_value($qSql);
				
				$current_user = get_user_id();
				$exam_assessment_id = $data['assessmentid'] = $this->uri->segment(3);				
				$exam_batch_id = $data['batchid'] = $this->uri->segment(4);				
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/assmnt_production_agents.php";
				
				
				$qSqlexam = "SELECT module_id, 
				(Select asmnt_name from training_assessment ta where ta.id =es.module_id)as asmnt_name , exam_id, 
				(Select title from lt_examination lte where lte.id =es.exam_id  )as exam_title, allotted_set_id, exam_status, no_of_question 
				FROM lt_exam_schedule es 
				Where module_id = '$exam_assessment_id' AND module_type = 'TR' 
				group by module_id, module_type,exam_id,allotted_set_id";
				$ExamArray = $this->Common_model->get_query_result_array($qSqlexam);
				$data["ExamArray"] = $ExamArray;
			
				$asmnt_name = $data['aname'] = $ExamArray[0]['asmnt_name'];
				$exam_title = $data['ename'] = $ExamArray[0]['exam_title'];
				$exam_id = $data['eexamid'] = $ExamArray[0]['exam_id'];
				$set_id  = $data['esetid'] = $ExamArray[0]['allotted_set_id'];
				
				
				$SQLtxt = "SELECT * FROM lt_exam_schedule as l 
				INNER JOIN (SELECT id as signinid, CONCAT(fname,' ',lname) as fusion_name, fusion_id from signin) as s on s.signinid = l.user_id
                LEFT JOIN (SELECT user_id as score_user_id, assmnt_id as asid, tot_corr_ans as totalcorrect, score as myscore from training_assessment_score WHERE assmnt_id = '$exam_assessment_id') as a on a.score_user_id = l.user_id
				WHERE l.module_id = '$exam_assessment_id'";
				
			    $finalarray = $data['earray'] = $this->Common_model->get_query_result_array($SQLtxt);
				
				
				
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
		public function assmnt_agents(){
			if(check_logged_in())
			{
				//$qSql = 'SELECT id as value  FROM lt_question_set WHERE exam_id="'.$exam_id.'" and status=1 ORDER BY RAND() LIMIT 1';
				//$set_id=$this->Common_model->get_single_value($qSql);
				
				$current_user = get_user_id();
				$exam_assessment_id = $data['assessmentid'] = $this->uri->segment(3);				
				$exam_batch_id = $data['batchid'] = $this->uri->segment(4);				
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/assmnt_agents.php";
				
				
				$qSqlexam = "SELECT module_id, 
				(Select asmnt_name from training_assessment ta where ta.id =es.module_id)as asmnt_name , exam_id, 
				(Select title from lt_examination lte where lte.id =es.exam_id  )as exam_title, allotted_set_id, exam_status, no_of_question 
				FROM lt_exam_schedule es 
				Where module_id = '$exam_assessment_id' AND module_type = 'TR' 
				group by module_id, module_type,exam_id,allotted_set_id";
				$ExamArray = $this->Common_model->get_query_result_array($qSqlexam);
				$data["ExamArray"] = $ExamArray;
			
				$asmnt_name = $data['aname'] = $ExamArray[0]['asmnt_name'];
				$exam_title = $data['ename'] = $ExamArray[0]['exam_title'];
				$exam_id = $data['eexamid'] = $ExamArray[0]['exam_id'];
				$set_id  = $data['esetid'] = $ExamArray[0]['allotted_set_id'];
				
				
				
				$SQLtxt="Select fusion_id,fname,lname,(Select CONCAT(fname,' ' ,lname) from signin where signin.id=s.assigned_to) as asign_tl, user_id,set_id,exam_id,exam_schedule_id, ua.ques_id, no_of_question, ans_id, QA_O.text AS User_answer, QA_O.correct_answer from lt_exam_schedule x 
						inner JOIN lt_questions y on y.set_id = x.allotted_set_id
						inner JOIN lt_user_exam_answer ua on ua.exam_schedule_id = x.id and ua.ques_id = y.id
						LEFT JOIN lt_questions_ans_options QA_O ON QA_O.id=ua.ans_id
						left JOIN signin s on s.id = x.user_id
						where exam_id =". $exam_id ." and allotted_set_id = ". $set_id ."
						 group by fusion_id order by user_id,ques_id";
			    $finalarray = $data['earray'] = $this->Common_model->get_query_result_array($SQLtxt);
				
				
				foreach($finalarray as $etoken){
					$uid = $etoken['fusion_id'];
					$qSqlt = "SELECT score,tot_corr_ans FROM training_assessment_score WHERE assmnt_id = '$exam_assessment_id' AND user_id IN (SELECT id from signin WHERE fusion_id = '$uid')";			
					$AssArray = $this->Common_model->get_query_result_array($qSqlt);
					foreach($AssArray as $tokenarray){ 
						$data['score'][$uid]['scoring'] = $tokenarray['score'];
						$data['score'][$uid]['correct'] = $tokenarray['tot_corr_ans'];
					}
				}
				
				
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
		public function new_assmnt_agents(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				 
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/assmnt_agents_new.php";
				
				$exam_assessment_id = $data['assessmentid'] = $this->uri->segment(3);				
				$exam_batch_id = $data['batchid'] = $this->uri->segment(4);	
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
							
				$qSql="Select id,name from master_term_type where is_active=1";
				$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="Select id,name from master_sub_term_type where is_active=1";
				$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="Select id,description from master_resign_reason where is_active=1";
				$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
		
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training")){
										
					//$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, (Select CONCAT(fname,' ' ,lname) from signin s where s.id=tb.trainer_id) as trainer_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' order by tb.id desc";
					
					$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where tb.id = '$exam_batch_id' $filterCond $filterCond4 $filterCond3 order by tb.id desc";
					
					//echo $qSql;
					
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					// and trn_type=2 
					$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where tb.id = '$exam_batch_id'  AND trainer_id='$current_user' $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
				}
				
				
				foreach($data["get_assigned_batch"] as $rowtoken)
				{
					$batch_id= $rowtoken['id'];
					
					
					$data['get_training_assmnt_names'][$batch_id] = get_training_assmnt_names($batch_id);
					$data['candidate_details'][$batch_id] = candidate_details($batch_id);
					foreach($data['candidate_details'][$batch_id] as $crow)
					{
						$user_id= $crow['user_id'];
						$data['get_assmnt_details'][$user_id][$batch_id] = get_assmnt_details($user_id,$batch_id);
					}
						
				}
								
				
				
				$qSql="Select id,title,location,(select min(id) from lt_question_set qs where qs.exam_id =ex.id ) as SetID, (select count(id) from lt_question_set qs where qs.exam_id =ex.id ) as totSet , (select count(id) from lt_questions ques where ques.set_id =SetID ) as totQues  FROM lt_examination ex  Where type = 'TR' and status=1";
				
				$data["exam_list"] = $this->Common_model->get_query_result_array($qSql);
			
				
				if($is_global_access==1) $data['location_list'] = $this->Common_model->get_office_location_list();
				else $data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
							
				$this->load->view('dashboard',$data);
				
			}
				
		}
		
		
		
		public function downloadResultExcel()
		{
			
			$current_user = get_user_id();
			$exam_schedule_id = $this->uri->segment(3); 
			$exam_assessment_id = $this->uri->segment(4);
			$exam_user_id = $data['euserid'] = $this->uri->segment(5);				
				
			if($exam_user_id != ""){
				$current_user = $exam_user_id;
			}
				
			$qSql = "SELECT * FROM lt_questions as q 
			INNER JOIN lt_user_exam_answer as a ON a.ques_id = q.id 
			INNER JOIN (SELECT id as aid, text as toption from lt_questions_ans_options) as o ON a.ans_id = o.aid
			INNER JOIN (SELECT text as correct_option, ques_id as quid, id as cans_id from lt_questions_ans_options WHERE correct_answer = '1') as f on f.quid = q.id 
			WHERE a.exam_schedule_id = '$exam_schedule_id'";			
			$ExamArray = $this->Common_model->get_query_result_array($qSql);
			$data["ExamArray"] = $ExamArray;
			
			$qSqlt = "SELECT score,tot_corr_ans FROM training_assessment_score WHERE assmnt_id = '$exam_assessment_id' AND user_id = '$current_user'";			
			$AssArray = $this->Common_model->get_query_result_array($qSqlt);
			$data["AssArray"] = $AssArray;
			
			foreach($AssArray as $tokenarray){ 
				$got_score = $tokenarray['score'];
				$got_correct = $tokenarray['tot_corr_ans'];
			}
			
			$fn=$current_user. "-".$exam_schedule_id."-".$exam_assessment_id;
			$fn = str_replace("/","_",$fn);
			$sht_title= $fn;
			if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
			$title = $fn;
		
			$adata = "You have answered ".$got_correct ." questions correct and scored ".$got_score."%";
			$adata = "";
			
			//activate worksheet number 1
			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle($sht_title);
			//set cell A1 content with some text
		
			$this->excel->getActiveSheet()->setCellValue('A1', $adata);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(11);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
			$this->excel->getActiveSheet()->setCellValue('B2', 'QUESTIONS');
			$this->excel->getActiveSheet()->setCellValue('C2', 'ANSWERED');
			$this->excel->getActiveSheet()->setCellValue('D2', 'CORRECT ANSWER');
			$this->excel->getActiveSheet()->setCellValue('E2', 'RESULT');
			
			$j=3;
			$r=2;
			$sl = "0";
			
			foreach($ExamArray as $examtoken){
				$sl++;
			    $r++;
				$correctflag = "0";
				if($examtoken['aid'] == $examtoken['cans_id']){ $correctflag = "1"; }
				if($correctflag == "1"){ $correctn = "Correct"; } if($correctflag == "0"){ $correctn = "Incorrect"; }
				
				$this->excel->getActiveSheet()->setCellValue("A".$r, $sl);
				$this->excel->getActiveSheet()->setCellValue("B".$r, $examtoken['title']);
				$this->excel->getActiveSheet()->setCellValue("C".$r, $examtoken['toption']);
				$this->excel->getActiveSheet()->setCellValue("D".$r, $examtoken['correct_option']);
				$this->excel->getActiveSheet()->setCellValue("E".$r, $correctn);
				
				if($correctflag == "1"){
				//$this->excel->getActiveSheet()->getStyle("E".$r)->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle("E".$r)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle("C".$r)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle("D".$r)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
				
			}
			
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
						 
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
			ob_end_clean();
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
			
			
		}
	
		
		
		public function production(){
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and assmnt_status = '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/assmnt_production.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ) $filterCond = " and location_id='$oValue'";
				
				if($oValue!="ALL" ){
						$filterCond = " and location_id='$oValue' ";
						$filterCond2 = " and location_id='$oValue' ";
				}
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND asmnt_date >= '$startdate_range' AND asmnt_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				
				$data['client_list'] = $this->Common_model->get_client_list();	
				//$data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				$qSql="Select assmnt.*, c.shname, p.name from training_assessment assmnt LEFT JOIN client c ON  c.id=assmnt.client_id LEFT JOIN process p ON  p.id=assmnt.process_id where assmnt_for='3' $filterCond $filterCond3 group by client_id, process_id, location_id";
				
				$data["get_process_list"] = $this->Common_model->get_query_result_array($qSql);
				
				foreach($data["get_process_list"] as $rowp)
				{
					$client_id= $rowp['client_id'];
					$process_id= $rowp['process_id'];
					$location_id = $rowp['location_id'];
					$lcp = $location_id ."-" .$client_id ."-" .$process_id;
					$data['assessment_details_prod'][$lcp] = assessment_details_prod($location_id,$client_id,$process_id); 
				}
				
				
				
				
				$qSql="Select id,title,location,(select min(id) from lt_question_set qs where qs.exam_id =ex.id ) as SetID, (select count(id) from lt_question_set qs where qs.exam_id =ex.id ) as totSet , (select count(id) from lt_questions ques where ques.set_id =SetID ) as totQues  FROM lt_examination ex  Where type = 'TR' and status=1";
				
				$data["exam_list"] = $this->Common_model->get_query_result_array($qSql);
				
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
		public function assmnt_summary(){
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = $user_office_id;
				$data['oValue'] = $oValue;
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				if($oValue!="ALL" ){
						$filterCond = " and (location='$oValue' OR batch_office_id = '$oValue')";
						$filterCond2 = " and (location_id='$oValue') ";
				}
				
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}

				// GET BATCH TYPE
				$batch_type = $this->uri->segment(3);
				$as_trn_type = "2"; $as_trn_name = ""; 
				if($batch_type=='recursive'){ $as_trn_type = "4"; $as_trn_name = "recursive"; }
				if($batch_type=='upskill'){ $as_trn_type = "5"; $as_trn_name = "upskill"; }
				if($batch_type=='nesting'){ $as_trn_type = "3"; $as_trn_name = "nesting"; }
				if($batch_type=='production'){ $as_trn_type = "1"; $as_trn_name = "production"; }
				$data['batch_type'] = $as_trn_type;
				$data['batch_type_name'] = $as_trn_name;
				
				if($as_trn_type > 1){
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training")){
					
					$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title,  CONCAT(fname,' ' ,lname) as trainer_name, office_id, location, trn_batch_status from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type='$as_trn_type' $filterCond4 $filterCond $filterCond3	 order by tb.id desc";
					
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
					
					/*$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location, trn_batch_status from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type=3 $filterCond4 $filterCond $filterCond3	order by tb.id desc";
					$data["get_assigned_nest_batch"] = $this->Common_model->get_query_result_array($qSql);*/
					
				}else{
					
					$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location, trn_batch_status from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trainer_id='$current_user' and trn_type='$as_trn_type' $filterCond4 $filterCond $filterCond3	order by tb.id desc";
					// echo $qSql;
					// die;
					$data["get_assigned_batch"] = $this->Common_model->get_query_result_array($qSql);
					
					/*$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location, trn_batch_status from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trainer_id='$current_user' and trn_type=3 $filterCond4 $filterCond $filterCond3	order by tb.id desc";
					$data["get_assigned_nest_batch"] = $this->Common_model->get_query_result_array($qSql);*/
					
				}
				
				
				foreach($data["get_assigned_batch"] as $rowb)
				{
					$batch_id= $rowb['id'];
					$assmnt_for= 1;
					$data['assessment_details_batch'][$batch_id][$assmnt_for] = assessment_details_batch($batch_id,$assmnt_for);
				}
				
				}
				
				if($as_trn_type == 1){
				$qSql="Select assmnt.*, c.shname, p.name from training_assessment assmnt LEFT JOIN client c ON  c.id=assmnt.client_id LEFT JOIN process p ON  p.id=assmnt.process_id where assmnt_for='3' $filterCond2 group by client_id, process_id, location_id";
				
				$data["get_prod_process_list"] = $this->Common_model->get_query_result_array($qSql);
				
				foreach($data["get_prod_process_list"] as $rowp)
				{
					$client_id = $rowp['client_id'];
					$process_id = $rowp['process_id'];
					$location_id = $rowp['location_id'];
					$lcp = $location_id."-".$client_id."-".$process_id;
					$data['assessment_details_prod'][$lcp] = assessment_details_prod($location_id,$client_id,$process_id);
				}
				}
				
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/assmnt_summary.php";
				
				
				
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
		public function showAssmntCandList(){
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$batch_id= trim($this->input->post('batch_id'));
				$asmnt_id= trim($this->input->post('asmnt_id'));
				
				$qSql="Select  esh.user_id, module_id, esh.exam_status, ass.assmnt_id, ass.tot_corr_ans, ass.score, fname,lname,fusion_id,(Select name from role where role.id=signin.role_id) as role_name  from (select * from  lt_exam_schedule where module_id = '$asmnt_id' and module_type = 'TR' ) esh LEFT JOIN  signin ON esh.user_id = signin.id LEFT JOIN training_assessment_score ass ON ass.assmnt_id = esh.module_id and ass.user_id = esh.user_id Order by role_name";
				
				echo json_encode($this->Common_model->get_query_result_array($qSql));
				
			}
		}
		
		
		public function dashboard(){
			if(check_logged_in())
			{
				$data_values1= array();
				$data_values = array();
				
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/dashboard.php";
				
				/* $SQLtxt= "select *,c.shname from training_batch tb left join client c on c.id= tb.client_id where trn_batch_status = 1 group by tb.client_id";
				$data["client_details"] = $this->Common_model->get_query_result_array($SQLtxt);
				 */
				 
				 
				 $SQLtxt= "select *,c.shname from training_batch tb left join client c on c.id= tb.client_id  group by tb.client_id";
				 
				 $fields1 = $this->db->query($SQLtxt);
				 $data_values = $fields1->result_array();
				 
				  
					foreach($data_values as $clientid){
					  
						$SQLtxt = "select tb.client_id, tb.process_id, p.name from training_batch tb left join
						process p on p.id= tb.process_id where tb.client_id ='". $clientid['client_id'] . "' group by tb.process_id";
						
						$fields = $this->db->query($SQLtxt);
							
						$data_values1[$clientid['shname']] =  $fields->result_array();
						$data_values3 =  $fields->result_array();
						
					} 
				 
				 $process = $this->text();
				 
				$data['client_details'] =  $data_values1;
				$data['process_details'] = $process;
				
				$this->load->view('dashboard',$data);
				
				
			}
			
		} 
		
			public function text(){
				
				
				$SQLtxt = "select tb.client_id, tb.process_id, p.name from training_batch tb left join
						process p on p.id= tb.process_id group by tb.process_id"; 
				
				$fields = $this->db->query($SQLtxt);
			    $data_values2 =  $fields->result_array();
				
				foreach($data_values2 as $val){
					 
				 $SQLtxt = "select tb.client_id, tb.process_id, p.name,

									(SELECT count(user_id)as total_batch FROM training_batch  INNER JOIN training_details ON 
										training_batch.id = training_details.trn_batch_id where client_id =tb.client_id and process_id= tb.process_id )as HandOverHeadCount,
										  
									(SELECT count(user_id)as total_batch FROM training_batch  INNER JOIN training_details ON 
										training_batch.id = training_details.trn_batch_id  where client_id =tb.client_id and process_id= tb.process_id and  date(training_batch.trn_start_date) <> date(training_batch.hr_handover_date))as HandOverHeadCount_difference,	
										
									(SELECT count(user_id)as total_batch FROM training_batch  INNER JOIN training_details ON 
										training_batch.id = training_details.trn_batch_id where client_id =tb.client_id and process_id= tb.process_id )as StartHeadCount,
																							
									(SELECT count(user_id)as total_batch FROM training_batch tb  INNER JOIN training_details td ON 
										tb.id = td.trn_batch_id  inner join signin on td.user_id = signin.id
										
										where signin.id =td.user_id and tb.client_id = '". $val['client_id'] . "' and tb.process_id = '". $val['process_id'] . "'   and signin.status in(1,4))as BatchCount,	 
										 									
									(select count(*) as refer_to_hr from 
												(select  datediff(date(terminate_users.terms_date),doj) as no_of_Days, tb.process_id, tb.client_id
									from training_details td INNER JOIN training_batch tb on td.trn_batch_id = tb.id inner 
									join signin on td.user_id = signin.id INNER JOIN   terminate_users ON signin.id = terminate_users.user_id   where  tb.client_id='". $val['client_id'] . "'  and signin.status in(1,4) AND datediff(date(terminate_users.terms_date),doj) <=3 )as s) as refer_to_hr 
										
									from training_batch tb left join process p on p.id= tb.process_id  
									 
									  group by tb.process_id";
						
							$fields = $this->db->query($SQLtxt);
							
							 
				}
				
					return  $data_values2 =  $fields->result_array();
					 echo "<pre>";
					 print_r($data_values2);
					
			}
			
				
		public function createAssmnt(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				
				$trn_batch_id= trim($this->input->post('trn_batch_id'));
				$client_id= trim($this->input->post('client_id'));
				$process_id= trim($this->input->post('process_id'));
				
				
				$location_id= $this->input->post('location_id');
				$multipleLocationId = implode(',',$location_id);
				
				
				$asmnt_name= trim($this->input->post('asmnt_name'));
				$asmnt_date= trim($this->input->post('asmnt_date'));
				if($asmnt_date!="") $asmnt_date = mmddyy2mysql($asmnt_date);
				
				$assmnt_type=trim($this->input->post('assmnt_type'));
				
				if ($trn_batch_id !="" && $asmnt_name !="" && $assmnt_type !="" && $asmnt_date !=""){
					
					$_field_array = array(
						"asmnt_name" => $asmnt_name,
						"assmnt_type" => $assmnt_type,
						"asmnt_date" => $asmnt_date,
						"added_by" => $current_user,
						"added_date" => $evt_date
					);
					
					if($trn_batch_id=="prod"){
						$_field_array["location_id"]=$location_id;
						$_field_array["client_id"]=$client_id;
						$_field_array["process_id"]=$process_id;
						$_field_array["assmnt_for"]='3';
					}else{
						$_field_array["trn_batch_id"]=$trn_batch_id;
						$_field_array["assmnt_for"]='1';
					}
					
					$row_id = data_inserter('training_assessment',$_field_array);
					echo "Done";
					
				}else{
					
					echo "Error";
				}				
			}
		}
		
		
		public function saveScheduleAssmnt(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
								
				$batch_id= trim($this->input->post('sabatch_id'));
				$assmnt_id= trim($this->input->post('saassmnt_id'));
				$exam_id= trim($this->input->post('exam_id'));
				$selectAllCheckBox= trim($this->input->post('selectAllCheckBox'));
				$exam_start_time= trim($this->input->post('exam_start_time'));
								
				if($exam_start_time!="") $exam_start_time = mdydt2mysql($exam_start_time);
				
				$allotted_time= trim($this->input->post('allotted_time'));
				$no_of_question= trim($this->input->post('no_of_question'));
				
				$agentCheckBox= $this->input->post('agentCheckBox');
				
				$qSql = 'SELECT id as value  FROM lt_question_set WHERE exam_id="'.$exam_id.'" and status=1 ORDER BY RAND() LIMIT 1';
				$set_id=$this->Common_model->get_single_value($qSql);
				
				if($selectAllCheckBox==1){
					$this->db->query("UPDATE training_assessment SET assmnt_status='2' WHERE id='$assmnt_id'");
				}
				
				//echo "selectAllCheckBox : " . $selectAllCheckBox ."<br>";
				foreach($agentCheckBox as $key=>$value){
				
					$iSql= "INSERT INTO lt_exam_schedule(module_id,module_type,user_id, exam_id, allotted_time, allotted_set_id, exam_start_time, added_by, added_date, exam_status,no_of_question) VALUES ('$assmnt_id','TR','$value','$exam_id','$allotted_time','$set_id','$exam_start_time','$current_user',now(),0,'$no_of_question')";
					
					//echo "iSql : " . $iSql ."<br>";
					
					$query = $this->db->query($iSql);
				}
				
				if($batch_id=="prod"){
															
					$qSql="Select client_id, process_id from training_assessment where id='$assmnt_id'";
					$row = $this->Common_model->get_query_row_array($qSql);
					$client_id = $row['client_id'];
					$process_id = $row['process_id'];
					
					$qSql= "Select count(id) as value from signin where status in (1,4) AND is_assign_client(id,$client_id) and is_assign_process(id,$process_id) and dept_id=6 AND id NOT IN(SELECT user_id FROM lt_exam_schedule WHERE module_id='$assmnt_id' AND module_type='TR')";
					
					
				}else{
					$qSql= "Select count(td.id) as value from training_details td LEFT JOIN signin s on td.user_id = s.id where trn_batch_id = '$batch_id' and s.status in (1,4) AND user_id NOT IN(SELECT user_id FROM lt_exam_schedule WHERE module_id='$assmnt_id' AND module_type='TR')";
				}
				
				$total_sch_left=$this->Common_model->get_single_value($qSql);
				
				if($total_sch_left==0){
					$this->db->query("UPDATE training_assessment SET assmnt_status='2' WHERE id='$assmnt_id'");
				}
				
				if($batch_id=="prod") redirect(base_url()."training/production","refresh");
				//else redirect(base_url()."training","refresh");
				else redirect($_SERVER['HTTP_REFERER']);
			}
		}
		
		public function fetchActiveAgent(){
			
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
								
				$loc_id= trim($this->input->post('loc_id'));
				$batch_id= trim($this->input->post('batch_id'));
				$asmnt_id= trim($this->input->post('asmnt_id'));
				
				if($batch_id=="prod"){
					
					$cond="";
					if($loc_id!="") $cond = " AND office_id = '$loc_id' ";
					
					$qSql="Select client_id, process_id from training_assessment where id='$asmnt_id'";
					$row = $this->Common_model->get_query_row_array($qSql);
					$client_id = $row['client_id'];
					$process_id = $row['process_id'];
					
					$qSql= "Select *, id as user_id, (Select name from role where role.id=signin.role_id) as role_name,(Select shname from department d where d.id=signin.dept_id) as dept_name from signin where status in (1,4) AND is_assign_client(id,$client_id) and is_assign_process(id,$process_id) and dept_id in (6,5) $cond AND id NOT IN(SELECT user_id FROM lt_exam_schedule WHERE module_id='$asmnt_id' AND module_type='TR') Order by role_name";
					
				}else{
					$qSql= "Select user_id,fusion_id,s.fname,s.lname,s.status, (Select name from role where role.id=s.role_id) as role_name, (Select shname from department d where d.id=s.dept_id) as dept_name from training_details td LEFT JOIN signin s on td.user_id = s.id where trn_batch_id = '$batch_id' and s.status in (1,4) AND user_id NOT IN(SELECT user_id FROM lt_exam_schedule WHERE module_id='$asmnt_id' AND module_type='TR') Order by role_name";
				}
				
				//echo $qSql;
				
				echo json_encode($this->Common_model->get_query_result_array($qSql));
				
			}
		}
		
		public function fetchScheduleTimes(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
								
				$batch_id= trim($this->input->post('batch_id'));
				$asmnt_id= trim($this->input->post('asmnt_id'));
				
				$qSql="SELECT id,exam_start_time FROM lt_exam_schedule WHERE exam_status = 0 and module_id='$asmnt_id' AND module_type='TR' GROUP BY exam_start_time ";
				
				echo json_encode($this->Common_model->get_query_result_array($qSql));
		
				
			}
		}
		
		
		public function getScheduledCandidates()
		{
			$form_data = $this->input->post();
			
			$qSql='SELECT lt_exam_schedule.id,lt_exam_schedule.user_id, CONCAT(signin.fname," ",signin.lname) AS candidate_name, signin.fusion_id , (Select name from role where role.id=signin.role_id) as role_name FROM `lt_exam_schedule` LEFT JOIN signin ON signin.id=lt_exam_schedule.user_id WHERE module_id="'.$form_data['assmnt_id'].'" AND exam_start_time="'.$form_data['scheduled_exam_time'].'" AND exam_status=0 AND module_type="TR" Order by role_name';
			
			//echo $qSql;
			
			$query = $this->db->query($qSql);
			if($query)
			{
				$response['stat'] = true;
				$response['datas'] = $query->result_object();
			}
			else
			{
				$response['stat'] = false;
			}
			echo json_encode($response);
		}
		
		public function startExam(){
		
			$form_data = $this->input->post();
			
			foreach($form_data['agentCheckBox'] as $key=>$value)
			{
			$query = $this->db->query('UPDATE lt_exam_schedule SET exam_status="2" WHERE module_id="'.$form_data['assmnt_id'].'" AND user_id="'.$value.'" AND module_type="TR" ');
			}
			
			if($form_data['batch_id'] =="prod") redirect(base_url()."training/production","refresh");
			//else redirect(base_url()."training","refresh");
			else redirect($_SERVER['HTTP_REFERER']);
			
		}
			
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////------------------- OFFLINE RESULT START
		
		public function downloadOfflineResultHeader()
		{
			
			$batchid = trim($this->input->get('bid'));
			$assessmentid = trim($this->input->get('aid'));
			
			// GET NAME
			$sqln = "SELECT * from training_batch as t 
					LEFT JOIN (SELECT id as cid, shname as client_name from client) as c ON t.client_id = c.cid
					LEFT JOIN (SELECT id as pid, client_id as pcid, name as process_name from process) as p ON t.process_id = p.pid 
					WHERE t.id = '$batchid'";
			$detailsrow = $this->Common_model->get_query_row_array($sqln);
			
			$client_name = $detailsrow['client_name'];
			$process_name = $detailsrow['process_name'];
			
		    if($assessmentid != ""){
				
			$qSql = "SELECT * FROM training_details as t 
				    LEFT JOIN (SELECT id as uid, fusion_id, concat(fname,' ',lname) as fusion_name from signin) as s ON s.uid = t.user_id
                    WHERE t.trn_batch_id = '$batchid'";
			$offlinerow = $this->Common_model->get_query_result_array($qSql);
			
			$fn = $client_name ."_" .$process_name;
			$fn = str_replace("/","_",$fn);
			$sht_title= $fn;
			if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
			$title = $fn;
			
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle($sht_title);
			$this->excel->getActiveSheet()->setCellValue('A1', $title);
			$this->excel->getActiveSheet()->mergeCells('A1:D1');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
			$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
			$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
			$this->excel->getActiveSheet()->setCellValue('D2', 'SCORE(%)');
			
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
			
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
			
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("30");
			
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('D')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("15");
			
			$sl = "0";
			$cellid = "2";
			foreach($offlinerow as $token):
				$sl++;
				$cellid++;				
				$this->excel->getActiveSheet()->setCellValue("A".$cellid, $sl);
				$this->excel->getActiveSheet()->setCellValue("B".$cellid, $token['fusion_id']);
				$this->excel->getActiveSheet()->setCellValue("C".$cellid, $token['fusion_name']);		
			endforeach;
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
			ob_end_clean();
			$objWriter->save('php://output');
			
			} else {
				redirect($_SERVER['HTTP_REFERER']);
			}
			
			
		}
		
		
		
		
		public function uploadAssmntResult(){
			
			/*if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				$role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/dashboard.php";
				$this->load->view('dashboard',$data);
			}*/
			
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				$role_id= get_role_id();
				
				$batch_id = trim($this->input->post('batch_id'));
				$asmnt_id = trim($this->input->post('asmnt_id'));
							 
				$ret = array();
				
				if(($batch_id!="") && ($asmnt_id!="")){
				
					$output_dir = "uploads/training_offline_result/";
								
					$error =$_FILES["asktfile"]["error"];
					if(!is_array($_FILES["asktfile"]["name"])) //single file
					{
						$fileName = time().str_replace(' ','',$_FILES["asktfile"]["name"]);
						move_uploaded_file($_FILES["asktfile"]["tmp_name"],$output_dir.$fileName);
						$ret[]= $this->Import_Assessment_file($fileName,$batch_id,$asmnt_id);
					}
					else  //Multiple files, file[]
					{
					  $fileCount = count($_FILES["asktfile"]["name"]);
					  for($i=0; $i < $fileCount; $i++)
					  {
						$fileName = time().str_replace(' ','',$_FILES["asktfile"]["name"][$i]);
						move_uploaded_file($_FILES["asktfile"]["tmp_name"][$i],$output_dir.$fileName);
						$ret[]= $this->Import_Assessment_file($fileName,$batch_id,$asmnt_id);
						
					  }
					
					}
					
				} else {
					$ret[]="error";
				}
							
				echo json_encode($ret);
				
			}
			
		}
		
	
	private function Import_Assessment_file($file_name,$batch_id,$asmnt_id)
	{
		$current_user = get_user_id();
		$file_path = 'uploads/training_offline_result/'.$file_name;
				
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		
		$qSql = "SELECT * FROM training_details as t 
				 LEFT JOIN (SELECT id as uid, fusion_id, concat(fname,' ',lname) as fusion_name from signin) as s ON s.uid = t.user_id
                 WHERE t.trn_batch_id = '$batch_id'";
		$offlinerow = $this->Common_model->get_query_result_array($qSql);
		
		$totaldata = count($offlinerow);
		
		$sl = "0";
		$cellid = "2";
		
		if(($totaldata+2) == $highestRow){
		
		// DATA INSERTION START
		$this->db->trans_begin();
		foreach($offlinerow as $token):
			$sl++;
			$cellid++;
			$userid = $token['user_id'];
			$getvalue = $objWorksheet->getCell("D".$cellid)->getValue();
			$totalcorrect = "";
			
			if(($getvalue != "") && ($userid != ""))
			{
				$qSqlcheck   = "select id as value from training_assessment_score where assmnt_id ='$asmnt_id' AND user_id = '$userid'";
			    $uploadcheck = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"assmnt_id"     => $asmnt_id,
							"user_id" 		=> $userid,
							"tot_corr_ans"  => $totalcorrect,
							"score"     	=> $getvalue,
							"added_by"  	=> $current_user,
							"added_date" 	=> $curDateTime
						);
						
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update('training_assessment_score',$field_array);
					
					
				} else {
					
					data_inserter('training_assessment_score',$field_array);
				
				}
				
				
			}
		endforeach;
		
	
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
	}
		

		

////////------------------- OFFLINE RESULT END	-----------------------------------
		
/////////////////////////////////////////////-- OLD ---//////////////////////////////////////////////////////

	
		public function cert_design(){
			
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$role_dir=get_role_dir();
				$role_id= get_role_id();
				$get_dept_id=get_dept_id();
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/cert_design.php";
								
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$bValue = trim($this->input->post('batch_id'));
				if($bValue=="") $bValue = trim($this->input->get('batchid'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
				$data['bValue']=$bValue;
										
				$_filterCond="";
				
				if($oValue!="ALL" && $bValue!="")  $_filterCond  = " AND trn_batch_id='".$bValue."'";
				//if($oValue!="ALL" && $oValue!="") $_filterCond = " And office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="") $_filterCond .= " And client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " And process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") $qSql="SELECT DISTINCT client_id,client.shname FROM training_cert_design LEFT JOIN client ON client.id=training_cert_design.client_id WHERE office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1' ";	
				
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
								
				$qSql=" Select * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql=" Select * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				
				
				// FORM URL DATA
				$data['hide_normal'] = "off";
				$data['url_batch_id'] = "";
				$url_batch_id = $this->uri->segment(3);
				if($url_batch_id != ""){
					
					$data['url_batch_id'] = $url_batch_id;
					
					$sql = "Select b.id as batch_id,batch_office_id,client_id ,process_id, b.batch_name, 
						(SELECT name from process y where y.id = b.process_id) as process_name,
						(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
						(SELECT shname from client c where c.id = b.client_id) as client_name, sb.office_id as trn_office_id 
						from training_batch as b 
						LEFT JOIN (SELECT office_id, id from signin) as sb ON sb.id = b.trainer_id
						WHERE b.id = '$url_batch_id'";
					$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
					$cc_office_id = $querybatch['batch_office_id'];
					if(empty($querybatch['batch_office_id'])){ $cc_office_id = $querybatch['trn_office_id']; }
					
					// CHECK ANY PREVIOUS DESIGN
					$sqldd = "SELECT id as value from training_cert_design WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' AND office_id = '".$cc_office_id."' ORDER BY ID DESC LIMIT 1";
					$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
					if($pv_rag != ""){
						$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from training_cert_kpi kp where did = $pv_rag";
						$data['pv_rag_desgin'] = $this->Common_model->get_query_result_array($qSql);
					}
				}
				
				if($this->input->get('batchid') != ""){
				
				$qSql = "Select mp.id as mp_id, mp.passing_percentile, office_id,client_id ,process_id, is_active, description, 
						(SELECT batch_name from training_batch b where b.id = mp.trn_batch_id) as batch_name,
						(SELECT name from process y where y.id = mp.process_id) as process_name,
						(SELECT office_name from office_location k  where k.abbr = mp.office_id) as office_name,
						(SELECT shname from client c where c.id = mp.client_id) as client_name 
						from training_cert_design mp Where is_active=1 $_filterCond";
				
				//$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from training_cert_design mp Where is_active=1 $_filterCond";
			
				//echo $qSql;
				
				$data["crt_design"] = $crt_design = $this->Common_model->get_query_result_array($qSql);
				
							
				// CHECK PROCESS CLIENT
				if(empty($crt_design)){
					
					$row_batch="SELECT tb.*, c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, 
							office_id, location from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id 
							LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id 
							where trn_batch_status = '1' and trn_type=2 AND tb.id = '$bValue'";
					$query_row_batch = $this->Common_model->get_query_row_array($qSqlb);				
					if(!empty($query_row_batch)){
						$qSql = "Select mp.id as mp_id,office_id,client_id ,process_id, is_active, description, 
							(SELECT batch_name from training_batch b where b.id = mp.trn_batch_id) as batch_name,
							(SELECT name from process y where y.id = mp.process_id) as process_name,
							(SELECT office_name from office_location k  where k.abbr = mp.office_id) as office_name,
							(SELECT shname from client c where c.id = mp.client_id) as client_name 
							from training_cert_design mp Where is_active=1 AND client_id = '".$query_row_batch['client_id']."' AND process_id = '" .$query_row_batch['process_id'] ."' AND office_id = '" .$query_row_batch['office_id']."' AND (trn_batch_id IS NULL OR trn_batch_id = '')"; 
						$data["crt_design"] = $crt_design = $this->Common_model->get_query_result_array($qSql);
					}
				}
				
				$pmkpiarray=array();
				foreach($crt_design as $row):
					$mp_id=$row['mp_id'];
					$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from training_cert_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
				
				$data['crt_designkpi']=$pmkpiarray;
				
				}				
				
				
				//loading training javascript
				$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
				
			}
		}
		
		
	
   public function addCertDesign()
	{
        if(check_logged_in())
        {
						
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$_run = false;  
			
			$log=get_logs();
			
			$office_id = trim($this->input->post('office_id'));
			$client_id = trim($this->input->post('client_id'));
			$process_id = trim($this->input->post('process_id'));
			$trn_batch_id  = trim($this->input->post('trn_batch_id'));
			$description = trim($this->input->post('description'));
			$passing_percetnage = trim($this->input->post('new_passing_percetnage'));
			
			$kpi_name_arr = $this->input->post('kpi_name');
			$kpi_type_arr = $this->input->post('kpi_type');
			$kpi_weightage_arr = $this->input->post('kpi_weightage');

			
			$qSqlcheck      = "SELECT id as value from training_cert_design WHERE trn_batch_id = '$trn_batch_id'";
			$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
			if($uploadcheck != "")
			{
				//redirect($_SERVER['HTTP_REFERER']);
				redirect(base_url()."training/cert_design?batchid=".$trn_batch_id."&office_id=".$office_id."&client_id=".$client_id."&process_id=".$process_id."&showReports=Show&exist=yes");
				
			} else {
			
			
			
			$field_array = array(
				"office_id" => $office_id,
				"client_id" => $client_id,
				"process_id" => $process_id,
				"trn_batch_id" => $trn_batch_id,
				"description" => $description,
				"passing_percentile" => $passing_percetnage,
				"added_by" => $current_user,
				"is_active" => '1',
				"uplog"        => $log
			);
			
			$did = data_inserter('training_cert_design',$field_array);
			
			foreach($kpi_name_arr as $index => $kpi_name){
				
				if($kpi_name<>""){
					
					$field_array = array(
						"did" => $did,
						"kpi_name" => $kpi_name,
						"kpi_type" => $kpi_type_arr[$index],
						"kpi_weightage" => $kpi_weightage_arr[$index],
						"added_by" => $current_user,
						"uplog"       => $log
					);
					
					data_inserter('training_cert_kpi',$field_array);
					
				}
				
			}
			
				//redirect($_SERVER['HTTP_REFERER']);
				redirect(base_url()."training/cert_design?batchid=".$trn_batch_id."&showReports=Show&added=yes");
			}
			
       }        
   }
   
	public function getDesignForm(){
		
	if(check_logged_in())
    {
		
		$mdid = trim($this->input->post('mdid'));
		$mdid=addslashes($mdid);
		
		$qSql=" Select * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
		$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
		
		$qSql=" Select * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
		$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
			
		//$qSql="select * from pm_design where id = $mdid";
		//$design_row=$this->Common_model->get_query_row_array($qSql);
		
		$qSql="select * from training_cert_kpi where did = $mdid";
		$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
		
		
		
		/////////
		$html ="";
		
		$TotRow=count($design_kpi_arr);
		
		$cnt=1; $countr = 0; $countrag = count($design_kpi_arr);
		foreach($design_kpi_arr as $kpiRow) {
		$countr++;
		if($countr < $countrag || $countr == 1){
		
		$html .= "<div class='col-md-12 kpi_input_row'>";
			
			$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";
			
			$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
			
			$html .= "<div class='col-md-3'><select class='form-control' name='kpi_type[]' > ";
			
			foreach($kpi_type_list as $kpimas){
				
				$sCss="";
				if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
				$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
				
			}
							
			$html .= "</select></div>";
			
			$html .= "<div class='col-md-2'><input type='text' value='". $kpiRow['kpi_weightage'] ."' onkeyup=\"this.value=this.value.replace(/[^\d]/,'')\" class='form-control' name='kpi_weightage[]'></div>";
					
			$html .= "<div class='col-md-2'>";
				
				if( $cnt++<$TotRow-1){
					
					$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
					$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
				}else{
					$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
					$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
				}
							
			$html .= "</div>";
			$html .= "</div>";
		}
		}	
				
		echo $html;
		}
	}

	
	
   public function updateCertDesign()
   {
		if(check_logged_in())
        {
						
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$curDateTime      = CurrMySqlDate();

			$_run = false;  
			
			$log=get_logs();
			
			$mdid = trim($this->input->post('mdid'));
			
			$office_id = trim($this->input->post('office_id'));
			$client_id = trim($this->input->post('client_id'));
			$process_id = trim($this->input->post('process_id'));
			$mp_type = trim($this->input->post('mp_type'));
			$description = trim($this->input->post('description'));
			
			$kpi_id_arr = $this->input->post('kpi_id');
			$kpi_name_arr = $this->input->post('kpi_name');
			$kpi_type_arr = $this->input->post('kpi_type');
			$kpi_weightage_arr = $this->input->post('kpi_weightage');
			$target_arr = $this->input->post('target');
			$weightage_arr = $this->input->post('weightage');
			
			$kpi_summ_type_arr = $this->input->post('summ_type');
			$kpi_summ_formula_arr = $this->input->post('summ_formula');
			$weightage_comp_arr = $this->input->post('weightage_comp');
			
			//echo "<pre>";
			//echo print_r($kpi_id_arr);
			//echo "</pre>";
			
			//echo "<pre>";
			//echo print_r($kpi_name_arr);
			//echo "</pre>";
			
			$field_array = array(
				"office_id" => $office_id,
				"client_id" => $client_id,
				"process_id" => $process_id,
				"description" => $description,
				"added_by" => $current_user,
				"is_active" => '1'
			);
			
			$this->db->where('id', $mdid);
			$this->db->update('training_cert_design',$field_array);
			
			$TotID=count($kpi_id_arr);
			
			// DELETE CERTIFICATE
			$sql = "DELETE from training_cert_kpi WHERE did = '$mdid'";
			$query = $this->db->query($sql);
			
			foreach($kpi_name_arr as $index => $kpi_name)
			{
				if($kpi_name<>"")
				{
					
					$field_array = array(
						"did"         => $mdid,
						"kpi_name"    => $kpi_name,
						"kpi_type"    => $kpi_type_arr[$index],
						"kpi_weightage"   => $kpi_weightage_arr[$index],
						"isdel"       => '0',
						"added_by"    => $current_user,
						"added_date"  => curDateTime,
						"uplog"       => $log
					);
					
					data_inserter('training_cert_kpi',$field_array);
					
				}
			}
			
			/*
			foreach($kpi_name_arr as $index => $kpi_name){
				
				//echo $TotID . " >> ". $index . "<br>";
				//$kpiid="";
				//if($TotID < $index) 
				
				$kpiid = $kpi_id_arr[$index];
				
				if($kpiid == ""){
					
					$field_array = array(
						"did" => $mdid,
						"kpi_name" => $kpi_name,
						"kpi_type" => $kpi_type_arr[$index],
						"target" => $target_arr[$index],
						"weightage" => $weightage_arr[$index],
						"summ_type" => $kpi_summ_type_arr[$index],
						"summ_formula" => $kpi_summ_formula_arr[$index],
						"weightage_comp" => $weightage_comp_arr[$index],
						"added_by" => $current_user
					);
					
					data_inserter('training_cert_kpi',$field_array);
				}else{
									
					$field_array = array(
						"kpi_name" => $kpi_name,
						"kpi_type" => $kpi_type_arr[$index],
						"target" => $target_arr[$index],
						"weightage" => $weightage_arr[$index],
						"summ_type" => $kpi_summ_type_arr[$index],
						"summ_formula" => $kpi_summ_formula_arr[$index],
						"weightage_comp" => $weightage_comp_arr[$index],
						"added_by" => $current_user
					);
					
					$this->db->where('id', $kpiid);
					$this->db->update('training_cert_kpi',$field_array );
					
				}
				
			}*/
			
			redirect($_SERVER['HTTP_REFERER']);
			
		}
   }
   
	
	public function updateCertPassingMarks()
	{
		if(check_logged_in())
		{
						
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$curDateTime      = CurrMySqlDate();

			$_run = false;  
			
			$log=get_logs();
			
			$mdid = trim($this->input->post('mdid'));
			$passing_marks = trim($this->input->post('passing_marks'));
			
			$field_array = array(
				"passing_percentile" => $passing_marks
			);
			
			$this->db->where('id', $mdid);
			$this->db->update('training_cert_design',$field_array);
			
			
			redirect($_SERVER['HTTP_REFERER']);
			
		}
	}
   
		
		
	public function downloadCertHeader()
    {
		
		
		$pmdid = trim($this->input->get('pmdid'));
					
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, mp_type,is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from training_cert_design mp Where is_active=1 and id=$pmdid";
			
		//echo $qSql;
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from training_cert_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$cell=$letters[$j++].$r;
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name'] .'('.$row['kpi_weightage'] .'%)'); 
			
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		
	}
	
		
///////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////// RAG RESULT /////////////////////////////////////////////////
	
	
	   		
	public function downloadTrainingRAGHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' and trn_type=2 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from training_rag_design WHERE trn_batch_id = '$batchid'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,trn_batch_id, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from training_rag_design mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		$batchid = $pm_design_row['trn_batch_id'];
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		if(!empty($batchid)){
			$slNo = 0; $r=2;
			$qSql = "Select s.*, d.user_id, CONCAT(s.fname, ' ', s.lname) as fullname from training_details as d INNER JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batchid'";
			$querySql=$this->Common_model->get_query_result_array($qSql);
			foreach($querySql as $rowD):
				$slNo++; $r++; $j=0; 
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fullname']);			
			endforeach;
		}
		
		$currentcellvalue = ord('C');
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from training_rag_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
		    $currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'];
			if($getkpiname == "Status"){ 
			$getkpiname = "Status (Red/Amber/Green)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);
			
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	public function uploadRagResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/rag/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_rag_file($fileName,$batch_id);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_rag_file($fileName,$batch_id);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	private function Import_rag_file($file_name,$batch_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/rag/'.$file_name;
				
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
				
		// GET RAG DID FROM BATCH
		$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' and trn_type=2 AND tb.id = '$batch_id'";
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		
		$getpmid = "SELECT * from training_rag_design WHERE trn_batch_id = '$batch_id'"; 
		$pm_batch_rowb_design = $this->Common_model->get_query_row_array($getpmid);
		
		// CHECK PROCESS CLIENT
		if(empty($pm_batch_rowb_design)){
			$qSql = "Select * from training_rag_design WHERE client_id = '".$pm_batch_rowb['client_id']."' AND process_id = '" .$pm_batch_rowb['process_id'] ."' AND office_id = '" .$pm_batch_rowb['office_id']."' AND (trn_batch_id IS NULL OR trn_batch_id = '')"; 
			//$pm_batch_rowb_design = $this->Common_model->get_query_result_array($qSql);			
		}
		$pmdid = $pm_batch_rowb_design['id'];
		
		
		// GET KPI DETAILS
		$qSql = "Select * from training_rag_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		
	    if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET RAG DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}

		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "select id as value from training_rag_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ragdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"ragdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update('training_rag_data',$field_array);
					
					
				} else {
					
					data_inserter('training_rag_data',$field_array);
				
				}
				
				//print_r($field_array);die();$_run = false;					
				
				
			}
			}			
			
		}
		
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		/*
		foreach($rag_data['fusion_id'] as $key=>$value)
		{
			$fusion_id=$rag_data['fusion_id'][$key];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			if($fusion_id!=""){
									
				$qSql="select id as value from signin where fusion_id ='$fusion_id'";
				$user_id=$this->Common_model->get_single_value($qSql);
				if($user_id!=""){
					
				$iSql = "REPLACE INTO training_rag_score (batch_id, user_id, communication, listening, behavioral, experience,remarks,final_score,added_by,added_date) VALUES ('".$batch_id."','".$user_id."','".$rag_data['communication'][$key]."','".$rag_data['listening'][$key]."','".$rag_data['behavioral'][$key]."','".$rag_data['experience'][$key]."','".$rag_data['remarks'][$key]."','".$rag_data['final_score'][$key]."','".$current_user."',now()) ";				
				$this->db->query($iSql);				
				}
			}
		}*/
		
	}
	
	
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////// CERTIFICATE RESULT /////////////////////////////////////////////////
	
	
	   		
	public function downloadTrainingCertificateHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' and trn_type=2 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from training_cert_design WHERE client_id = '".$pm_batch_rowb['client_id']."' AND process_id = '" .$pm_batch_rowb['process_id'] ."' AND office_id = '" .$pm_batch_rowb['office_id']."'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, trn_batch_id, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from training_cert_design mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		$batchid = $pm_design_row['trn_batch_id'];
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		
		
		
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		if(!empty($batchid)){
		$slNo = 0; $r=2;
		$qSql = "Select s.*, d.user_id, CONCAT(s.fname, ' ', s.lname) as fullname from training_details as d INNER JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batchid'";
		$querySql=$this->Common_model->get_query_result_array($qSql);
		foreach($querySql as $rowD):
			$slNo++; $r++; $j=0; 
			$cell= $letters[$j++].$r;
			$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
			
			$cell= $letters[$j++].$r;
			$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
			
			$cell= $letters[$j++].$r;
			$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fullname']);			
		endforeach;
		}
		
		$currentcellvalue = ord('C');	
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from training_cert_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'] .' ('.$row['kpi_weightage'] .'%)';
			if($row['kpi_name'] == "Status"){ 
			$getkpiname = "Status (Pass/Fail)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);
			
		endforeach;
		
		
		
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	/// DOWNLOAD CERIFICATE RESULT
	   		
	public function downloadTrainingCertificateResult()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' and trn_type=2 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from training_cert_design WHERE trn_batch_id = '$batchid'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from training_cert_design mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from training_cert_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$cell=$letters[$j++].$r;
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
			
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	
	
	
	
	public function uploadCertificateResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
			$recertification = trim($this->input->post('recertification'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/training_certificate/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_Certificate_file($fileName,$batch_id, $recertification);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_Certificate_file($fileName,$batch_id, $recertification);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	private function Import_Certificate_file($file_name,$batch_id, $recertification)
	{
		$current_user = get_user_id();
		$file_path = './uploads/training_certificate/'.$file_name;
				
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
				
		// GET RAG DID FROM BATCH
		$qSqlb="SELECT tb.*,
				c.shname as client_name, 
				p.name as process_name, 
				dfr.requisition_id, dfr.job_title, 
				CONCAT(fname,' ' ,lname) as trainer_name, 
				office_id, location from training_batch tb 
				LEFT JOIN client c ON  c.id=tb.client_id 
				LEFT JOIN process p ON  p.id=tb.process_id 
				LEFT JOIN signin ON  signin.id=tb.trainer_id 
				LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id 
				where trn_batch_status = '1' and trn_type=2 AND tb.id = '$batch_id'";
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		
		$getpmid = "SELECT * from training_cert_design WHERE trn_batch_id = '$batch_id'"; 
		$pm_batch_rowb_design = $this->Common_model->get_query_row_array($getpmid);
		
		// CHECK PROCESS CLIENT
		if(empty($pm_batch_rowb_design)){
			$qSql = "Select * from training_cert_design WHERE client_id = '".$pm_batch_rowb['client_id']."' AND process_id = '" .$pm_batch_rowb['process_id'] ."' AND office_id = '" .$pm_batch_rowb['office_id']."' AND (trn_batch_id IS NULL OR trn_batch_id = '')"; 
			//$pm_batch_rowb_design = $this->Common_model->get_query_result_array($qSql);			
		}
		$pmdid = $pm_batch_rowb_design['id'];
			
		
		// GET KPI DETAILS
		$qSql = "Select * from training_cert_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET  DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}
		
		//echo "hi";
		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = trim($rag_data['fusion_id'][$starti]['fid']);
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			
			//echo $qSql. "||".$user_id ."<br>";
			
			
			if($user_id != ""){
			
			$reinsert = "no";
			if($recertification == '1'){
			$qSql_cstatus   = "SELECT is_certify as value from training_details where trn_batch_id ='$batch_id' AND user_id = '$user_id'";
			$querystatus    = $this->Common_model->get_single_value($qSql_cstatus);
			if($querystatus == '2'){ $reinsert = "yes"; }
			}
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "SELECT id as value from training_cert_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND crtdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'  ORDER by ID DESC LIMIT 1";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$kpivalue = $rag_data['fusion_id'][$starti][$j];
				if($j == $countkpi){ $kpivalue = ucwords($kpivalue); }
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"crtdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $kpivalue,
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($reinsert == "yes")
				{
					data_inserter('training_cert_data',$field_array);
					
					//echo "1:<pre>" .print_r($field_array, true) ."</pre>";
					
				} else {
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update('training_cert_data',$field_array);
					
					
					//echo "2:<pre>" .print_r($field_array, true) ."</pre>";
					
				} else {
					
					data_inserter('training_cert_data',$field_array);
					
					//echo "3: <pre>" .print_r($field_array, true) ."</pre>";
					
				}
				
				}
				
				
				// CHECK PASS/FAIL
				if(strtolower(trim($rag_data['fusion_id'][$starti][$j])) == 'pass')
				{
					$update_array = array("is_certify" => '1');
					$this->db->where('trn_batch_id', $batch_id);
					$this->db->where('user_id', $user_id);
					$this->db->update('training_details',$update_array);
				}

				if(strtolower(trim($rag_data['fusion_id'][$starti][$j])) == 'fail')
				{
					$update_array = array("is_certify" => '2');
					$this->db->where('trn_batch_id', $batch_id);
					$this->db->where('user_id', $user_id);
					$this->db->update('training_details',$update_array);
				}
				
				/*
				// AUTO CERTIFICATION
				$myCurrentScore = 0;
				$myPassingScore = !empty($pm_batch_rowb_design['passing_percentile']) ? $pm_batch_rowb_design['passing_percentile'] : "80";
								
				$sqlData = "SELECT c.*, kpi_weightage, kpi_name FROM training_cert_data as c LEFT JOIN training_cert_kpi as k ON k.id = c.kpi_id
				            WHERE user_id ='$user_id' AND trn_batch_id = '$batch_id' AND crtdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
				$queryData = $this->Common_model->get_query_result_array($sqlData);
				foreach($queryData as $token)
				{
					$gotName = $queryData['kpi_name'];
					$gotScore = $queryData['kpi_value'];
					$gotWeightage = $queryData['kpi_weightage'];
					if(strtolower(trim($gotName)) != "status")
					{
						if($gotScore <= 1){ $gotScore = $gotScore * 100; }
						$myCurrentScore = $myCurrentScore + (($gotScore * $gotWeightage)/100); 
					}
				}
				
				$is_certify = 1;
				if($myCurrentScore >= $myPassingScore){ $is_certify = 2; }				
				$update_array = array("is_certify" => $is_certify);
				$this->db->where('trn_batch_id', $batch_id);
				$this->db->where('user_id', $user_id);
				$this->db->update('training_details',$update_array);
				*/
			
				//print_r($field_array);die();$_run = false;					
				
			}	
			}		
			
		}
		
		// die();
		 
		 
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		
	}
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// CERTIFICATE ENDS /////////////////////////////////////////////////
	
   
   public function get_clients()
   {
		$office_id = $this->input->post('office_id');
		if($office_id != 'ALL')
		{
			$qSql="SELECT DISTINCT client_id,client.shname FROM `training_cert_design` LEFT JOIN client ON client.id=training_cert_design.client_id WHERE office_id='".$office_id."'";
		}
		else
		{
			$qSql="SELECT DISTINCT client_id,client.shname FROM `training_cert_design` LEFT JOIN client ON client.id=training_cert_design.client_id";
		}
		echo json_encode($this->Common_model->get_query_result_array($qSql));
   }
		
		
		
		
	public function handover()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();
			
			$data["aside_template"] = "training/aside.php";
			$data["content_template"] = "training/handover.php";
			
			$this->load->view('dashboard',$data);
			
			
		}
	}
		
		
///////////////////////////////////////////////////////////////////////////
	
	
	
	
	public function exam_panel()
	{
		if(check_logged_in())
		{
				
			$form_data = $this->input->post();
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$user_site_id= get_user_site_id();
			
			$data["is_global_access"] = $is_global_access;
			
			$data["is_role_dir"] = get_role_dir();
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic(get_user_fusion_id());
			
			$data["exam_schedule_id"] = $form_data['lt_exam_schedule_id'];
			
			$query_scheduled_exam = $this->db->query('SELECT * FROM `lt_exam_schedule` WHERE id='.$form_data['lt_exam_schedule_id'].'');
			
			//print_r($form_data);
			
			
			$row = $query_scheduled_exam->row();
					
			$data["questions"] = $this->generate_question($row);
			
			$query_scheduled_exam = $this->db->query('SELECT * FROM `lt_exam_schedule` WHERE id='.$form_data['lt_exam_schedule_id'].'');
			$row = $query_scheduled_exam->row();
			$data["exam_info"] = $row;
						
			$data["content_template"] = "training/exam_panel.php";
			$data["content_js"] = "training/exam_panel_js.php";
			
			$this->load->view('dashboard_single_col',$data);
		}
	}
	
	private function generate_question($row)
	{
		$current_user = get_user_id();
		
		$question_info = array();
		
		//print_r($row);
		// || $row->exam_status == 0
		
		if($row->exam_status == 2)
		{
						
			$query = $this->db->query('SELECT id FROM lt_questions WHERE set_id= "'.$row->allotted_set_id.'" ORDER BY RAND() LIMIT '.$row->no_of_question .'' );
									
			$rows = $query->result_object();
			$allotted_question_ids = array();
			$question_info = array();
			foreach($rows as $key=>$value)
			{
				$allotted_question_ids[] = $value->id;
				$question_info['question_id'][] = $value->id;
				$question_info['question_status'][] = 0;
				
				$this->db->query('REPLACE INTO lt_user_exam_answer (`exam_schedule_id`, `ques_id`, `status`, `added_time`) VALUES ("'.$row->id.'","'.$value->id.'","0",now())');
			}
			
			$this->db->query('UPDATE lt_exam_schedule SET exam_status="3",exam_start_time="'.ConvServerToLocal(date('Y-m-d H:i:s')).'" WHERE id='.$row->id.'');
		}
		else if($row->exam_status == 3)
		{
			$minutes_to_add = $row->allotted_time;
			$time = new DateTime($row->exam_start_time);
			$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

			$end_time = $time->format('Y-m-d H:i:s');
			if(strtotime($end_time) < ConvServerToLocal(date('Y-m-d H:i:s')))
			{
				$this->db->query('UPDATE lt_exam_schedule SET exam_status="1" WHERE id='.$row->id.'');
				$this->updateAssmntScore($row->id);
				
				redirect('training/agent', 'refresh');
			}
			
			$qSql = 'SELECT lt_questions.id,lt_user_exam_answer.status FROM lt_questions INNER JOIN lt_user_exam_answer ON lt_user_exam_answer.ques_id=lt_questions.id WHERE set_id= "'.$row->allotted_set_id.'" and exam_schedule_id = "'. $row->id .'" ';
			
			//echo $qSql;
			
			$query = $this->db->query($qSql);
			
			$rows = $query->result_object();
			$allotted_question_ids = array();
			$question_info = array();
			foreach($rows as $key=>$value)
			{
				$allotted_question_ids[] = $value->id;
				$question_info['question_id'][] = $value->id;
				$question_info['question_status'][] = $value->status;
			}
		}
		
		//print_r ($question_info);
		
		return $question_info;
		
	}
	
	public function get_first_question()
	{
		$form_data = $this->input->post();
		
		$qSql = 'SELECT lt_questions.id,lt_questions.title,lt_questions_ans_options.id AS option_id,lt_questions_ans_options.text,lt_questions_ans_options.correct_answer,lt_user_exam_answer.status,lt_user_exam_answer.ans_id FROM lt_questions LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id
			LEFT JOIN lt_user_exam_answer ON lt_user_exam_answer.ques_id=lt_questions.id
			WHERE lt_questions.id="'.$form_data['question_id'].'" AND exam_schedule_id="'.$form_data['exam_schedule_id'].'"';
		
		//echo $qSql;
		
		$query = $this->db->query($qSql);
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function submit_question()
	{
		$form_data = $this->input->post();
		$query = false;
		if($form_data['option_id'] != 0)
		{
			$qSql='UPDATE lt_user_exam_answer SET ans_id="'.$form_data['option_id'].'",status="1"  WHERE exam_schedule_id="'.$form_data['exam_schedule_id'].'" AND ques_id="'.$form_data['question_id'].'"';
			
			$query = $this->db->query($qSql);
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
	
	public function get_question()
	{
		$form_data = $this->input->post();
		
		$qSql='SELECT lt_questions.id,lt_questions.title,lt_questions_ans_options.id AS option_id,lt_questions_ans_options.text,lt_questions_ans_options.correct_answer,lt_user_exam_answer.status,lt_user_exam_answer.ans_id FROM lt_questions LEFT JOIN lt_questions_ans_options ON lt_questions_ans_options.ques_id=lt_questions.id
		LEFT JOIN lt_user_exam_answer ON lt_user_exam_answer.ques_id=lt_questions.id
		WHERE lt_questions.id="'.$form_data['question_id'].'" AND exam_schedule_id="'.$form_data['exam_schedule_id'].'"';
		
		$query = $this->db->query($qSql);
			
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function submit_exam()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();
		
		$form_data = $this->input->post();
		//$query = false;
		
		$uSql='UPDATE lt_exam_schedule SET exam_status="1"  WHERE id="'.$form_data['exam_schedule_id'].'"';
		$query=$this->db->query($uSql);
		
		$this->updateAssmntScore($form_data['exam_schedule_id']);
		
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
	
	
	private function updateAssmntScore($exam_schedule_id)
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();
		
		$qSql="Select module_id,module_type,user_id,no_of_question, uea.ans_id, sum(qao.correct_answer) as tot_corr_ans from lt_exam_schedule esh LEFT JOIN lt_user_exam_answer uea ON esh.id=uea.exam_schedule_id LEFT JOIN lt_questions_ans_options qao ON  qao.id=uea.ans_id WHERE esh.id = '".$exam_schedule_id."' and esh.user_id = '$current_user' group by user_id";
		
		$row = $this->Common_model->get_query_row_array($qSql);
		
		$module_id = $row['module_id'];
		$tot_corr_ans= 	$row['tot_corr_ans'];
		
		$totQuestion = $row['no_of_question'];
		$marks_per= round(($tot_corr_ans/$totQuestion)*100,2);
		
		$rSql="REPLACE INTO training_assessment_score (assmnt_id,user_id,tot_corr_ans,score, added_by, added_date) Values('$module_id', '$current_user','$tot_corr_ans', '$marks_per', '$current_user', '$evt_date')";
		
		$query=$this->db->query($rSql);
		
		return true;
				
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// Trainer Handover (12/12/2019)      //////////////////////////////////////
	
	//----------- FOR TRAINING ------------------//
	public function trn_handover_training(){
		if(check_logged_in()){
			
			$current_user=get_user_id();
			$batch_id = $this->input->post('batch_id_trn_tr');
			$trn_handover_phase = $this->input->post('trn_handover_phase_tr');
			$trn_handover_l1super = $this->input->post('trn_handover_l1super_tr');
			
			$curDateTime=CurrMySqlDate();
			
			if($this->input->post('submit')=='Handover'){
				
				//, phase = '$trn_handover_phase', status = 1 
				
				$this->db->query("UPDATE signin SET assigned_to = '$trn_handover_l1super' WHERE id IN (SELECT user_id from training_details WHERE trn_batch_id='$batch_id')");
				
				// GET CURRENT TRAINER ID
				$sql_trainer = "SELECT trainer_id as value from training_batch WHERE id = '$batch_id'";
				$trainer_name = $this->Common_model->get_single_value($sql_trainer);
				
				// GET CURRENT TRAINER2 ID
				$sql_trainer2 = "SELECT trainer_id2 as value from training_batch WHERE id = '$batch_id'";
				$trainer2_name = $this->Common_model->get_single_value($sql_trainer2);
				if(empty($trainer2_name))
				{
					$this->db->query("UPDATE training_batch SET trainer_id2 = '' WHERE id = '$batch_id'");
					$this->db->query("UPDATE training_batch SET trainer_id2 = CONCAT(trainer_id2, '$trainer_name') WHERE id = '$batch_id'");
				} else {
					$this->db->query("UPDATE training_batch SET trainer_id2 = CONCAT(trainer_id2, ',$trainer_name') WHERE id = '$batch_id'");
				}
				
				$this->db->query("UPDATE training_batch SET trainer_id = '$trn_handover_l1super' WHERE id = '$batch_id'");
				
				
			}
			redirect('Training/crt_batch');	
		}
	}
	
	
	
	//----------- FOR PRODUCTION & NESTING ------------------//
	public function trn_handover(){
		if(check_logged_in()){
			$current_user=get_user_id();
			$batch_id = $this->input->post('batch_id');
			$trn_handover_phase = $this->input->post('trn_handover_phase');
			$trn_handover_l1super = $this->input->post('trn_handover_l1super');
			$trn_handover_comment = $this->input->post('trn_handover_comment');
			$trn_certifi_fail = $this->input->post('trn_certifi_fail');
			$curDateTime=CurrMySqlDate();
			
			if($this->input->post('submit')=='Handover'){
				
				if($trn_handover_phase == "4")
				{
					$this->db->query("UPDATE signin set assigned_to='$trn_handover_l1super', phase='$trn_handover_phase', status=1 where status in (1,4) and id in (Select user_id from training_details where trn_batch_id='$batch_id' and is_certify=1)");
					
					$this->db->query("UPDATE signin set assigned_to='$trn_handover_l1super', phase='$trn_certifi_fail' where status in (1,4) and id in (Select user_id from training_details where trn_batch_id='$batch_id' and is_certify=2)");
					
					$this->db->query("UPDATE training_details set trn_status='$trn_handover_phase' where trn_batch_id='$batch_id' and is_certify in (1,2)");
					
					$this->db->query("UPDATE training_batch set trn_handover_l1super='$trn_handover_l1super', trn_handover_phase='$trn_handover_phase', trn_handover_by='$current_user', trn_handover_date='$curDateTime', trn_comment='$trn_handover_comment', trn_batch_status='2' where id='$batch_id'");
					
					$this->trn_handover_production($batch_id, $trn_handover_phase, $trn_handover_l1super, $trn_handover_comment, $trn_certifi_fail);
				}
				
				if($trn_handover_phase == "3")
				{
					
					$this->db->query("UPDATE training_batch set trn_handover_l1super='$trn_handover_l1super', trn_handover_phase='$trn_handover_phase', trn_handover_by='$current_user', trn_handover_date='$curDateTime', trn_comment='$trn_handover_comment', trn_batch_status='2' where id='$batch_id'");
					
					$this->db->query("UPDATE signin set assigned_to='$trn_handover_l1super', phase='$trn_handover_phase', status=1 where status in (1,4) and id in (Select user_id from training_details where trn_batch_id='$batch_id' and is_certify=1)");
					
					$this->db->query("UPDATE signin set assigned_to='$trn_handover_l1super', phase='$trn_certifi_fail' where status in (1,4) and id in (Select user_id from training_details where trn_batch_id='$batch_id' and is_certify=2)");
					
					$this->db->query("UPDATE training_details set trn_status='$trn_handover_phase' where trn_batch_id='$batch_id' and is_certify in (1,2)");
					
					
					$this->trn_handover_nesting($batch_id, $trn_handover_phase, $trn_handover_l1super, $trn_handover_comment, $trn_certifi_fail);
				}
				
				
			}
			redirect('Training/crt_batch');	
		}
	}
	
	//-------------------------------------------------------------------------
	// NESTING HANDOVER - FUNCTION CALL
	//-------------------------------------------------------------------------
	private function trn_handover_nesting($batch_id, $trn_handover_phase, $trn_handover_l1super, $trn_handover_comment, $trn_certifi_fail){
		
		if(check_logged_in()){
				
			$curDateTime   = CurrMySqlDate();
			$log = get_logs();	
			
			//COPY DATA FROM BATCH TO NEW BATCH ID
			$sqlnesting_handover = 	"INSERT into training_batch (trainer_id, trn_start_date, trn_type, ref_type, ref_id, client_id, process_id, trn_batch, trn_comment, trn_batch_status, hr_handover_by, hr_handover_date, batch_name, batch_office_id, log)
			SELECT '".$trn_handover_l1super."', trn_start_date, '3', 'T', '".$batch_id."', client_id, process_id, trn_batch, trn_comment, '1', hr_handover_by, hr_handover_date, batch_name, batch_office_id, log from training_batch
			where id = '$batch_id'";
			$this->db->query($sqlnesting_handover);
			$lastinsert_id = $this->db->insert_id();
		
			$sqlnesting_handover_d = "INSERT into training_details (trn_batch_id, user_id, trn_status, trn_note, transfer_from_batch_id, transfer_comments, is_certify, log)
			SELECT '".$lastinsert_id."', user_id, '3', trn_note, transfer_from_batch_id, transfer_comments, is_certify, log from training_details
			WHERE trn_batch_id = '$batch_id'";
			$this->db->query($sqlnesting_handover_d);
			
			//---- NEW BATCH
			// UPDATE PASS -- Train Status - 3
			$sqlpass = "UPDATE training_details SET trn_status = '3', is_certify = '0' WHERE trn_batch_id IN ('$lastinsert_id') AND is_certify = '1'";
			$querypass = $this->db->query($sqlpass);
			
			// UPDATE FAIL -- Train Status - 6
			if($trn_certifi_fail == "6"){
				
				$sqlpass = "UPDATE training_details SET trn_status = '6' WHERE trn_batch_id IN ('$lastinsert_id','$batch_id') AND is_certify = '2'";
				$querypass = $this->db->query($sqlpass);
				
				// UPDATE USERS TO STATUS 6
				$sqlupdate = "UPDATE signin SET status = '6', disposition_id = '6' WHERE id IN (SELECT user_id from training_details WHERE trn_status = '6' AND trn_batch_id IN ('$lastinsert_id') AND is_certify = '2')";
				$this->db->query($sqlupdate);
				
				
				$sqlcc = "SELECT user_id from training_details where is_certify = '2' AND trn_batch_id = '$batch_id'";
				$querycc = $this->Common_model->get_query_result_array($sqlcc);
				foreach($querycc as $tokencc)
				{
					$user_id = $tokencc['user_id'];
					$qSql  =  "select a.status, a.office_id, max(login_time_local) as last_login_time, max(logout_time_local) as last_logout_time from signin a left join logged_in_details b on a.id=b.user_id where a.id='$user_id'";
					$query             =  $this->db->query($qSql);
					$uRow              =  $query->row_array();
					$office_id         =  $uRow["office_id"];
					$last_login_time   =  $uRow["last_login_time"];
					$last_logout_time  =  $uRow["last_logout_time"];
					
					$status = $uRow["status"];
					if($status == 1 || $status==4 ){
						
						$event_by = get_user_id();
						$evt_date = CurrMySqlDate();
						$start_date=GetLocalDate();
						$log = get_logs();
						
						$comments = "Cerification Failure";
						
						$expiry_date = date('Y-m-d',strtotime('+30 days',strtotime($start_date)));
						
						$_field_array = array(
									"user_id" => $user_id,
									"bench_date" => $curDateTime,
									"bench_type" => $trn_certifi_fail,
									"lwd" => $last_login_time,
									"comments" => $comments,
									"evt_by" => $event_by,
									"evt_date" => $evt_date,
									"expiry_date" => $expiry_date,
									"is_on_bench" => 'Y',
									"log" => $log
								);
						data_inserter('user_bench',$_field_array);
						
						
						
						$_field_array = array(
							"user_id" => $user_id,
							"event_time" => $evt_date,
							"event_by" => $event_by,
							"event_master_id" => "6",
							"start_date" => $start_date,
							"end_date" => $expiry_date,
							"ticket_no" => "",
							"remarks" => $comments,
							"log" => $log
						); 
						
						$event_id = data_inserter('event_disposition',$_field_array);
					}
				}
				
			}
			
			// UPDATE FAIL -- Terms
			if($trn_certifi_fail == "7"){
				
				$sqlcc = "SELECT user_id from training_details where is_certify = '2' AND trn_batch_id = '$batch_id'";
				$querycc = $this->Common_model->get_query_result_array($sqlcc);
				foreach($querycc as $tokencc)
				{
					$user_id = $tokencc['user_id'];
					$qSql  =  "select a.status, a.office_id, max(login_time_local) as last_login_time, max(logout_time_local) as last_logout_time from signin a left join logged_in_details b on a.id=b.user_id where a.id='$user_id'";
					$query             =  $this->db->query($qSql);
					$uRow              =  $query->row_array();
					$office_id         =  $uRow["office_id"];
					$last_login_time   =  $uRow["last_login_time"];
					$last_logout_time  =  $uRow["last_logout_time"];
					
					$status = $uRow["status"];
					if($status == 1 || $status==4 ){
					
						$event_by = get_user_id();
						$evt_date = CurrMySqlDate();
						$start_date=GetLocalDate();
						$log = get_logs();
						
						$this->db->where('id', $user_id);
						$this->db->update('signin', array('status' =>'2'));
						
						$comments = "Cerification Failure";
						
						$_field_array = array(
									"user_id" => $user_id,
									"terms_date" => $curDateTime,
									"comments" => $comments,
									"t_type" => '12',
									"sub_t_type" => '2',
									"terms_by" => $event_by,
									"is_term_complete" => "N",
									"evt_date" => $evt_date,
									"lwd" => $last_login_time
								);
						data_inserter('terminate_users',$_field_array);
						
						
						$remarks = "Cerification Failure";
						$this->Email_model->send_email_submit_ticket($user_id,$terms_date,$remarks);
					}
					
				}	
				
			}
			
			
		}
	}
	
	
	//-------------------------------------------------------------------------
	// PRODUCTION HANDOVER - FUNCTION CALL
	//-------------------------------------------------------------------------
	private function trn_handover_production($batch_id, $trn_handover_phase, $trn_handover_l1super, $trn_handover_comment, $trn_certifi_fail){
		
		if(check_logged_in()){
				
			$curDateTime   = CurrMySqlDate();
			$log = get_logs();	
			
			// UPDATE FAIL -- Train Status - 6
			if($trn_certifi_fail == "6"){
				$sqlpass = "UPDATE training_details SET trn_status = '6' WHERE trn_batch_id IN ('$batch_id') AND is_certify = '2'";
				$querypass = $this->db->query($sqlpass);
				
				// UPDATE USERS TO STATUS 6
				$sqlupdate = "UPDATE signin SET status = '6', , disposition_id = '6'  WHERE id IN (SELECT user_id from training_details WHERE trn_status = '6' AND trn_batch_id IN ('$batch_id') AND is_certify = '2')";
				$this->db->query($sqlupdate);
				
				$sqlcc = "SELECT user_id from training_details where is_certify = '2' AND trn_batch_id = '$batch_id'";
				$querycc = $this->Common_model->get_query_result_array($sqlcc);
				foreach($querycc as $tokencc)
				{
					$user_id = $tokencc['user_id'];
					$qSql  =  "select a.status, a.office_id, max(login_time) as last_login_time, max(logout_time) as last_logout_time from signin a left join logged_in_details b on a.id=b.user_id where a.id='$user_id'";
					$query             =  $this->db->query($qSql);
					$uRow              =  $query->row_array();
					$office_id         =  $uRow["office_id"];
					$last_login_time   =  $uRow["last_login_time"];
					$last_logout_time  =  $uRow["last_logout_time"];
					
					if($last_login_time=="") $lgt = "";
					else $lgt = ConvServerToLocalAny($last_login_time,$office_id);
					
					$status = $uRow["status"];
					if($status == 1 || $status==4 ){
						
						$event_by = get_user_id();
						$evt_date = CurrMySqlDate();
						$log = get_logs();
						
						$comments = "Cerification Failure";
						$expiry_date = date('Y-m-d',strtotime('+30 days',strtotime($start_date)));
						
						$_field_array = array(
									"user_id" => $user_id,
									"bench_date" => $curDateTime,
									"bench_type" => $trn_certifi_fail,
									"lwd" => $lgt,
									"comments" => $comments,
									"evt_by" => $event_by,
									"evt_date" => $evt_date,
									"expiry_date" => $expiry_date,
									"is_on_bench" => 'Y',
									"log" => $log
								);
						data_inserter('user_bench',$_field_array);
						
						$_field_array = array(
							"user_id" => $user_id,
							"event_time" => $evt_date,
							"event_by" => $event_by,
							"event_master_id" => "6",
							"start_date" => $start_date,
							"end_date" => $expiry_date,
							"ticket_no" => "",
							"remarks" => $comments,
							"log" => $log
						); 
						
						$event_id = data_inserter('event_disposition',$_field_array);
					}
				}
				
			}
						
			// UPDATE FAIL -- Terms
			if($trn_certifi_fail == "7"){
				
				$sqlcc = "SELECT user_id from training_details where is_certify = '2' AND trn_batch_id = '$batch_id'";
				$querycc = $this->Common_model->get_query_result_array($sqlcc);
				foreach($querycc as $tokencc)
				{
					$user_id = $tokencc['user_id'];
					$qSql  =  "select  a.status, a.office_id, max(login_time) as last_login_time, max(logout_time) as last_logout_time from signin a left join logged_in_details b on a.id=b.user_id where a.id='$user_id'";
					$query             =  $this->db->query($qSql);
					$uRow              =  $query->row_array();
					$office_id         =  $uRow["office_id"];
					$last_login_time   =  $uRow["last_login_time"];
					$last_logout_time  =  $uRow["last_logout_time"];
					if($last_login_time=="") $lgt = "";
					else $lgt = ConvServerToLocalAny($last_login_time,$office_id);
					
					$status = $uRow["status"];
					if($status == 1 || $status==4 ){
						
						$event_by = get_user_id();
						$evt_date = CurrMySqlDate();
						$log = get_logs();
						
						$this->db->where('id', $user_id);
						$this->db->update('signin', array('status' =>'2'));
						
						$comments = "Cerification Failure";
						
						$_field_array = array(
									"user_id" => $user_id,
									"terms_date" => $curDateTime,
									"comments" => $comments,
									"t_type" => '12',
									"sub_t_type" => '2',
									"terms_by" => $event_by,
									"is_term_complete" => "N",
									"evt_date" => $evt_date,
									"lwd" => $lgt
								);
						data_inserter('terminate_users',$_field_array);
						
						$remarks = "Cerification Failure";
						$this->Email_model->send_email_submit_ticket($user_id,$terms_date,$remarks);
					
					}
					
				}		
				
			}
			
			
		}
	}
	
	
	
	
	
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////   TRAINER BATCH RAG ////////////////////////////

	
	
	
////////////////////////////////////////////////////////////////////////////////////////////////////
//-------------------- SUMMARY RESULT DOWNLOAD ----------------------------//

		
		//========== ASSESSMENT RESULT SCORE REPORT ___OLD___  ======================================//
		
		public function downloadAssessmentResultScore_old()
		{
			//$this->db->debug = true;
			//ini_set('display_errors', '1');
			$current_user  = get_user_id();
			$batch_id      = $this->uri->segment(4); 
			$assessment_id = $this->uri->segment(3);		
			
			// GET EXAM DETAILS
			$qexam   = "select * from training_assessment where id ='$assessment_id' AND trn_batch_id = '$batch_id'";
			$gexam = $this->Common_model->get_query_row_array($qexam);
			
			// GET NAME
			$sqln = "SELECT * from training_batch as t 
					LEFT JOIN (SELECT id as cid, shname as client_name from client) as c ON t.client_id = c.cid
					LEFT JOIN (SELECT id as pid, client_id as pcid, name as process_name from process) as p ON t.process_id = p.pid 
					WHERE t.id = '$batch_id'";
			$detailsrow = $this->Common_model->get_query_row_array($sqln);
			
			$client_name  = $detailsrow['client_name'];
			$process_name = $detailsrow['process_name'];
			
		    if($assessment_id != ""){
				
			$qSql = "SELECT * FROM training_details as t 
				    LEFT JOIN (SELECT id as uid, fusion_id, concat(fname,' ',lname) as fusion_name from signin) as s ON s.uid = t.user_id
                    WHERE t.trn_batch_id = '$batch_id'";
			$offlinerow = $this->Common_model->get_query_result_array($qSql);
			
			$fn = $gexam['asmnt_name']." (".$client_name ."-" .$process_name .")";
			$sht_title= str_replace("/","_",$fn);
			if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
			$title = $fn;
			
			
			
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle($sht_title);
			$this->excel->getActiveSheet()->setCellValue('A1', $title);
			$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->mergeCells('A1:D1');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
			$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
			$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
			$this->excel->getActiveSheet()->setCellValue('D2', 'SCORE (%)');
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("25");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('D')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
			
			$this->excel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bcdbe7');
			
			$sl = "0";
			$cellid = "2";
			foreach($offlinerow as $token):
				$sl++;
				$cellid++;	
				$userid = $token['user_id'];
				$this->excel->getActiveSheet()->setCellValue("A".$cellid, $sl);
				$this->excel->getActiveSheet()->setCellValue("B".$cellid, $token['fusion_id']);
				$this->excel->getActiveSheet()->setCellValue("C".$cellid, $token['fusion_name']);	
				
				// EXAM STATUS & SCORE
				//$qSqlcheckStatus   = "select * from lt_exam_schedule where module_id ='$assessment_id' AND module_type = 'TR' AND user_id = '$userid'";
			    // $getresultStatus = $this->Common_model->get_query_row_array($qSqlcheckStatus);
				
				$qSqlcheck   = "select * from training_assessment_score where assmnt_id ='$assessment_id' AND user_id = '$userid'";
			    $getresult = $this->Common_model->get_query_row_array($qSqlcheck);
				
				$this->excel->getActiveSheet()->setCellValue("D".$cellid, $getresult['score']);
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("D".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				
			endforeach;
			
			
			if($gexam['assmnt_type'] == "1"){ 
			
			
			
			//----------------------------- GET QUESTIONS
			
			//---- SET EXAM NAME
			$qSqlE = "SELECT ls.exam_id as my_exam_id, e.title as exam_name, ls.allotted_set_id, ls.id as schedule_id FROM lt_exam_schedule as ls  
					 LEFT JOIN (SELECT id as eid, title from lt_examination) as e ON e.eid = ls.exam_id
					 WHERE ls.module_id = '$assessment_id' AND ls.module_type = 'TR' GROUP BY ls.exam_id, ls.allotted_set_id";			
			$ExamArrayE = $this->Common_model->get_query_result_array($qSqlE);
			foreach($ExamArrayE as $tokenE){
			
				$get_exam_id = 	$tokenE['my_exam_id'];	
				$get_exam_name = 	$tokenE['exam_name'];	
				$get_set_id = 	$tokenE['allotted_set_id'];	
				$get_schedule_id = 	$tokenE['schedule_id'];	
				
				$cellid = $cellid + 3;
				$this->excel->getActiveSheet()->setCellValue("A".$cellid, "Exam Name : ".$get_exam_name);
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getFont()->setSize(14);
				$this->excel->getActiveSheet()->mergeCells('A'.$cellid.':D'.$cellid);
				$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4be9f');
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				
				$cellid = $cellid + 1;
				
				//--- SET COLUMNE NAMES
				$this->excel->getActiveSheet()->setCellValue('A'.$cellid, 'SLNo');
				$this->excel->getActiveSheet()->setCellValue('B'.$cellid, 'FUSIONID');
				$this->excel->getActiveSheet()->setCellValue('C'.$cellid, 'NAME');
				$this->excel->getActiveSheet()->setCellValue('D'.$cellid, 'SCORE (%)');
				
				
				//---- SET QUESTION COLUMN
				$sqlq = "SELECT * from lt_questions as q 
                         LEFT JOIN (SELECT id as correctid, ques_id, text as correct_answer from lt_questions_ans_options WHERE correct_answer = '1') as lqa ON q.id = lqa.ques_id WHERE q.set_id = '$get_set_id'";
				$queryp = $this->Common_model->get_query_result_array($sqlq);
				$sqlno = 0;
				$startcell = ord('E');
				foreach($queryp as $tokenQ){
					$currentcell = chr($startcell++); 
					$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokenQ['title']);
					$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
					$this->excel->getActiveSheet()->getColumnDimensionByColumn($currentcell)->setAutoSize(false);
					$this->excel->getActiveSheet()->getColumnDimension($currentcell)->setWidth("20");		
				}
				
				//$this->excel->getActiveSheet()->getStyle('A'.$cellid.':'.$currentcell.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e8e8e8');
				
				
				//--- SET USERS LOOP
				$sl = "1";
				$sqlu = "SELECT ls.user_id, s.fusion_id, s.fusion_name, ls.id as schedule_id, ls.exam_id, ls.allotted_set_id  from lt_exam_schedule as ls INNER JOIN (SELECT fusion_id, concat(fname,' ',lname) as fusion_name, id as uid from signin) as s ON ls.user_id = s.uid WHERE ls.module_id = '$assessment_id' AND ls.module_type = 'TR' AND ls.allotted_set_id = '$get_set_id'";
				$queryu = $this->Common_model->get_query_result_array($sqlu);
				foreach($queryu as $tokenu){
					
					$get_my_schedule_id = $tokenu['schedule_id'];
					$cellid = $cellid + 1;
					$userid = $tokenu['user_id'];
					$this->excel->getActiveSheet()->setCellValue("A".$cellid, $sl++);
					$this->excel->getActiveSheet()->setCellValue("B".$cellid, $tokenu['fusion_id']);
					$this->excel->getActiveSheet()->setCellValue("C".$cellid, $tokenu['fusion_name']);	
					
					//--- GET SCORE
					$qSqlcheck   = "select * from training_assessment_score where assmnt_id ='$assessment_id' AND user_id = '$userid'";
					$getresult = $this->Common_model->get_query_row_array($qSqlcheck);
					$this->excel->getActiveSheet()->setCellValue("D".$cellid, $getresult['score']);
					$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
					 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
					);
					$this->excel->getActiveSheet()->getStyle("D".$cellid)->getAlignment()->applyFromArray(
					 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
					);
					
					//--- GET ANSWERS
					$sqlanswer = "SELECT exam_schedule_id, ques_id, ans_id, atext, cid, ctext, iscorrect FROM lt_user_exam_answer as ua
									LEFT JOIN (SELECT id as aid, ques_id as aqid, text as atext, correct_answer as iscorrect from lt_questions_ans_options) as la ON la.aid = ua.ans_id
									LEFT JOIN (SELECT id as cid, ques_id as cqid, text as ctext from lt_questions_ans_options WHERE correct_answer = '1') as lqa ON la.aqid = lqa.cqid 
									WHERE ua.exam_schedule_id = '$get_my_schedule_id'";
					$queryanswer = $this->Common_model->get_query_result_array($sqlanswer);
					$startcell = ord('E');
					foreach($queryanswer as $tokenanswer){
						$currentcell = chr($startcell++); 
						$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokenanswer['atext']);
						$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
						
						$styleArray = array(
						'font'  => array(
							'color' => array('rgb' => 'FF0000'),
							'bold'  => true,
							//'size'  => 15,
							//'name'  => 'Verdana'
						));
						if($tokenanswer['iscorrect'] != "1"){
							$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->applyFromArray($styleArray);
						}
					}
				}
				

				//-- SET CORRECT ANSWER
				$cellid = $cellid + 1;
				$startcell = ord('E');
				foreach($queryp as $tokena){
					$currentcell = chr($startcell++); 
					$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokena['correct_answer']);
					$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
				}
				
				$this->excel->getActiveSheet()->getStyle('E'.$cellid.':'.$currentcell.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('d4fce5');
				
				
					
			}
			
			
			}
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
			ob_end_clean();
			$objWriter->save('php://output');
			
			} else {
				redirect($_SERVER['HTTP_REFERER']);
			}
			
			
			
		}
		
		
		public function downloadProductResultScore_old()
		{
			
			$current_user  = get_user_id();
			$batch_id      = $this->uri->segment(4); 
			$assessment_id = $this->uri->segment(3);		
			
			// GET EXAM DETAILS
			$qexam   = "select * from training_assessment where id ='$assessment_id'";
			$gexam = $this->Common_model->get_query_row_array($qexam);
			
			// GET NAME
			$sqln = "SELECT * from training_assessment as t 
					LEFT JOIN (SELECT id as cid, shname as client_name from client) as c ON t.client_id = c.cid
					LEFT JOIN (SELECT id as pid, client_id as pcid, name as process_name from process) as p ON t.process_id = p.pid 
					WHERE t.id = '$assessment_id'";
			$detailsrow = $this->Common_model->get_query_row_array($sqln);
			
			$client_name  = $detailsrow['client_name'];
			$process_name = $detailsrow['process_name'];
			
		    if($assessment_id != ""){
				
			$qSql = "SELECT * FROM lt_exam_schedule as l 
				    LEFT JOIN (SELECT id as uid, fusion_id, concat(fname,' ',lname) as fusion_name from signin) as s ON s.uid = l.user_id
                    WHERE l.module_id = '$assessment_id' AND l.module_type = 'TR'";
			$offlinerow = $this->Common_model->get_query_result_array($qSql);
			
			$fn = $gexam['location_id']." (".$client_name ."-" .$process_name .")";
			$sht_title= str_replace("/","_",$fn);
			if(strlen($sht_title)>29) $sht_title =  substr($sht_title,0,29);
			$title = $fn;
			
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle($sht_title);
			$this->excel->getActiveSheet()->setCellValue('A1', $title);
			$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->mergeCells('A1:D1');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
			$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
			$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
			$this->excel->getActiveSheet()->setCellValue('D2', 'SCORE (%)');
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("25");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('D')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
			
			$this->excel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bcdbe7');
			
			$sl = "0";
			$cellid = "2";
			foreach($offlinerow as $token):
				$sl++;
				$cellid++;	
				$userid = $token['user_id'];
				$this->excel->getActiveSheet()->setCellValue("A".$cellid, $sl);
				$this->excel->getActiveSheet()->setCellValue("B".$cellid, $token['fusion_id']);
				$this->excel->getActiveSheet()->setCellValue("C".$cellid, $token['fusion_name']);	

				$qSqlcheck   = "select * from training_assessment_score where assmnt_id ='$assessment_id' AND user_id = '$userid'";
			    $getresult = $this->Common_model->get_query_row_array($qSqlcheck);
				$this->excel->getActiveSheet()->setCellValue("D".$cellid, $getresult['score']);
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("D".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				
			endforeach;
			
			
			if($gexam['assmnt_type'] == "1"){ 
			
			
			
			//----------------------------- GET QUESTIONS
			
			//---- SET EXAM NAME
			$qSqlE = "SELECT ls.exam_id as my_exam_id, e.title as exam_name, ls.allotted_set_id, ls.id as schedule_id FROM lt_exam_schedule as ls  
					 LEFT JOIN (SELECT id as eid, title from lt_examination) as e ON e.eid = ls.exam_id
					 WHERE ls.module_id = '$assessment_id' AND ls.module_type = 'TR' GROUP BY ls.exam_id, ls.allotted_set_id";			
			$ExamArrayE = $this->Common_model->get_query_result_array($qSqlE);
			foreach($ExamArrayE as $tokenE){
			
				$get_exam_id = 	$tokenE['my_exam_id'];	
				$get_exam_name = 	$tokenE['exam_name'];	
				$get_set_id = 	$tokenE['allotted_set_id'];	
				$get_schedule_id = 	$tokenE['schedule_id'];	
				
				$cellid = $cellid + 3;
				$this->excel->getActiveSheet()->setCellValue("A".$cellid, "Exam Name : ".$get_exam_name);
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getFont()->setSize(14);
				$this->excel->getActiveSheet()->mergeCells('A'.$cellid.':D'.$cellid);
				$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4be9f');
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				
				$cellid = $cellid + 1;
				
				//--- SET COLUMNE NAMES
				$this->excel->getActiveSheet()->setCellValue('A'.$cellid, 'SLNo');
				$this->excel->getActiveSheet()->setCellValue('B'.$cellid, 'FUSIONID');
				$this->excel->getActiveSheet()->setCellValue('C'.$cellid, 'NAME');
				$this->excel->getActiveSheet()->setCellValue('D'.$cellid, 'SCORE (%)');
				
				
				//---- SET QUESTION COLUMN
				$sqlq = "SELECT * from lt_questions as q 
                         LEFT JOIN (SELECT id as correctid, ques_id, text as correct_answer from lt_questions_ans_options WHERE correct_answer = '1') as lqa ON q.id = lqa.ques_id WHERE q.set_id = '$get_set_id'";
				$queryp = $this->Common_model->get_query_result_array($sqlq);
				$sqlno = 0;
				$startcell = ord('E');
				foreach($queryp as $tokenQ){
					$currentcell = chr($startcell++); 
					$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokenQ['title']);
					$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
					$this->excel->getActiveSheet()->getColumnDimensionByColumn($currentcell)->setAutoSize(false);
					$this->excel->getActiveSheet()->getColumnDimension($currentcell)->setWidth("20");		
				}
				
				//$this->excel->getActiveSheet()->getStyle('A'.$cellid.':'.$currentcell.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e8e8e8');
				
				
				//--- SET USERS LOOP
				$sl = "1";
				$sqlu = "SELECT ls.user_id, s.fusion_id, s.fusion_name, ls.id as schedule_id, ls.exam_id, ls.allotted_set_id  from lt_exam_schedule as ls INNER JOIN (SELECT fusion_id, concat(fname,' ',lname) as fusion_name, id as uid from signin) as s ON ls.user_id = s.uid WHERE ls.module_id = '$assessment_id' AND ls.module_type = 'TR' AND ls.allotted_set_id = '$get_set_id'";
				$queryu = $this->Common_model->get_query_result_array($sqlu);
				foreach($queryu as $tokenu){
					
					$get_my_schedule_id = $tokenu['schedule_id'];
					$cellid = $cellid + 1;
					$userid = $tokenu['user_id'];
					$this->excel->getActiveSheet()->setCellValue("A".$cellid, $sl++);
					$this->excel->getActiveSheet()->setCellValue("B".$cellid, $tokenu['fusion_id']);
					$this->excel->getActiveSheet()->setCellValue("C".$cellid, $tokenu['fusion_name']);	
					
					//--- GET SCORE
					$qSqlcheck   = "select * from training_assessment_score where assmnt_id ='$assessment_id' AND user_id = '$userid'";
					$getresult = $this->Common_model->get_query_row_array($qSqlcheck);
					$this->excel->getActiveSheet()->setCellValue("D".$cellid, $getresult['score']);
					$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
					 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
					);
					$this->excel->getActiveSheet()->getStyle("D".$cellid)->getAlignment()->applyFromArray(
					 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
					);
					
					//--- GET ANSWERS
					$sqlanswer = "SELECT exam_schedule_id, ques_id, ans_id, atext, cid, ctext, iscorrect FROM lt_user_exam_answer as ua
									LEFT JOIN (SELECT id as aid, ques_id as aqid, text as atext, correct_answer as iscorrect from lt_questions_ans_options) as la ON la.aid = ua.ans_id
									LEFT JOIN (SELECT id as cid, ques_id as cqid, text as ctext from lt_questions_ans_options WHERE correct_answer = '1') as lqa ON la.aqid = lqa.cqid 
									WHERE ua.exam_schedule_id = '$get_my_schedule_id'";
					$queryanswer = $this->Common_model->get_query_result_array($sqlanswer);
					$startcell = ord('E');
					foreach($queryanswer as $tokenanswer){
						$currentcell = chr($startcell++); 
						$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokenanswer['atext']);
						$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
						
						$styleArray = array(
						'font'  => array(
							'color' => array('rgb' => 'FF0000'),
							'bold'  => true,
							//'size'  => 15,
							//'name'  => 'Verdana'
						));
						if($tokenanswer['iscorrect'] != "1"){
							$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->applyFromArray($styleArray);
						}
					}
				}
				

				//-- SET CORRECT ANSWER
				$cellid = $cellid + 1;
				$startcell = ord('E');
				foreach($queryp as $tokena){
					$currentcell = chr($startcell++); 
					$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokena['correct_answer']);
					$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
				}
				
				$this->excel->getActiveSheet()->getStyle('E'.$cellid.':'.$currentcell.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('d4fce5');
				
				
					
			}
			
			
			}
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
			ob_end_clean();
			$objWriter->save('php://output');
			
			} else {
				redirect($_SERVER['HTTP_REFERER']);
			}
			
			
			
		}
		
		
		//========== ASSESSMENT RESULT SCORE REPORT NEW  ======================================//
		
		public function downloadAssessmentResultScore()
		{
			//$this->db->debug = true;
			//ini_set('display_errors', '1');
			$current_user  = get_user_id();
			$batch_id      = $this->uri->segment(4); 
			$assessment_id = $this->uri->segment(3);		
			
			// GET EXAM DETAILS
			$qexam   = "select * from training_assessment where id ='$assessment_id' AND trn_batch_id = '$batch_id'";
			$gexam = $this->Common_model->get_query_row_array($qexam);
			
			// GET NAME
			$sqln = "SELECT * from training_batch as t 
					LEFT JOIN (SELECT id as cid, shname as client_name from client) as c ON t.client_id = c.cid
					LEFT JOIN (SELECT id as pid, client_id as pcid, name as process_name from process) as p ON t.process_id = p.pid 
					WHERE t.id = '$batch_id'";
			$detailsrow = $this->Common_model->get_query_row_array($sqln);
			
			$client_name  = $detailsrow['client_name'];
			$process_name = $detailsrow['process_name'];
			
		    if($assessment_id != ""){
				
			$qSql = "SELECT * FROM training_details as t 
				    LEFT JOIN (SELECT id as uid, fusion_id, concat(fname,' ',lname) as fusion_name from signin) as s ON s.uid = t.user_id
                    WHERE t.trn_batch_id = '$batch_id'";
			$offlinerow = $this->Common_model->get_query_result_array($qSql);
			
			$fn = $gexam['asmnt_name']." (".$client_name ."-" .$process_name .")";
			$sht_title= str_replace("/","_",$fn);
			if(strlen($sht_title)>29) $sht_title =  substr($sht_title,0,29);
			$title = $fn;
			
			
			
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle($sht_title);
			$this->excel->getActiveSheet()->setCellValue('A1', $title);
			$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->mergeCells('A1:F1');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
			$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
			$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
			$this->excel->getActiveSheet()->setCellValue('D2', 'SCORE (%)');
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("25");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('D')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
			
			$this->excel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bcdbe7');
			
			$sl = "0";
			$cellid = "2";
			foreach($offlinerow as $token):
				$sl++;
				$cellid++;	
				$userid = $token['user_id'];
				$this->excel->getActiveSheet()->setCellValue("A".$cellid, $sl);
				$this->excel->getActiveSheet()->setCellValue("B".$cellid, $token['fusion_id']);
				$this->excel->getActiveSheet()->setCellValue("C".$cellid, $token['fusion_name']);	
				
				// EXAM STATUS & SCORE
				//$qSqlcheckStatus   = "select * from lt_exam_schedule where module_id ='$assessment_id' AND module_type = 'TR' AND user_id = '$userid'";
			    // $getresultStatus = $this->Common_model->get_query_row_array($qSqlcheckStatus);
				
				$qSqlcheck   = "select * from training_assessment_score where assmnt_id ='$assessment_id' AND user_id = '$userid'";
			    $getresult = $this->Common_model->get_query_row_array($qSqlcheck);
				
				$this->excel->getActiveSheet()->setCellValue("D".$cellid, $getresult['score']);
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("D".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				
			endforeach;
			
			
			if($gexam['assmnt_type'] == "1"){ 
			
			
			
			//----------------------------- GET QUESTIONS
			
			//---- SET EXAM NAME
			$qSqlE = "SELECT ls.exam_id as my_exam_id, e.title as exam_name, ls.allotted_set_id, ls.id as schedule_id FROM lt_exam_schedule as ls  
					 LEFT JOIN (SELECT id as eid, title from lt_examination) as e ON e.eid = ls.exam_id
					 WHERE ls.module_id = '$assessment_id' AND ls.module_type = 'TR' GROUP BY ls.exam_id, ls.allotted_set_id";			
			$ExamArrayE = $this->Common_model->get_query_result_array($qSqlE);
			foreach($ExamArrayE as $tokenE){
			
				$get_exam_id = 	$tokenE['my_exam_id'];	
				$get_exam_name = 	$tokenE['exam_name'];	
				$get_set_id = 	$tokenE['allotted_set_id'];	
				$get_schedule_id = 	$tokenE['schedule_id'];	
				
				$cellid = $cellid + 3;
				$this->excel->getActiveSheet()->setCellValue("A".$cellid, "Exam Name : ".$get_exam_name);
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getFont()->setSize(14);
				$this->excel->getActiveSheet()->mergeCells('A'.$cellid.':F'.$cellid);
				$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4be9f');
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				
				$cellid = $cellid + 1;
				
				//--- SET COLUMNE NAMES
				$this->excel->getActiveSheet()->setCellValue('A'.$cellid, 'SLNo');
				$this->excel->getActiveSheet()->setCellValue('B'.$cellid, 'FUSIONID');
				$this->excel->getActiveSheet()->setCellValue('C'.$cellid, 'NAME');
				$this->excel->getActiveSheet()->setCellValue('D'.$cellid, 'SCORE (%)');
				
				
				//---- SET QUESTION COLUMN
				$sqlq = "SELECT * from lt_questions as q 
                         LEFT JOIN (SELECT id as correctid, ques_id, text as correct_answer from lt_questions_ans_options WHERE correct_answer = '1') as lqa ON q.id = lqa.ques_id WHERE q.set_id = '$get_set_id'";
				$queryp = $this->Common_model->get_query_result_array($sqlq);
				$sqlno = 0;
				$startcell = ord('E');
				
				$questionCounts = array();
				$questionOrder = array(); 
				
				$orderSl = 0;
				$orderByAddClause = "";
				foreach($queryp as $tokenQ){
					$orderSl++;
					$questionOrder[] = $tokenQ['id'];
					$questionCounts[$tokenQ['id']]['correct'] = 0;
					$questionCounts[$tokenQ['id']]['wrong'] = 0;
					$questionCounts[$tokenQ['id']]['unknown'] = 0;
					$questionID = $tokenQ['id'];
					$orderByAddClause .= " WHEN " .$questionID ." THEN " .$orderSl;
					$currentcell = chr($startcell++); 
					$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokenQ['title']);
					$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
					$this->excel->getActiveSheet()->getColumnDimensionByColumn($currentcell)->setAutoSize(false);
					$this->excel->getActiveSheet()->getColumnDimension($currentcell)->setWidth("20");		
				}
				
				$orderByClause = "";
				if(!empty($orderByAddClause)){
					$orderByClause .= " ORDER BY CASE ques_id ";
					$orderByClause .= $orderByAddClause;
					$orderByClause .= " ELSE 1000 END ASC ";
				}
				$questionIDs = implode(',', $questionOrder);
				//$this->excel->getActiveSheet()->getStyle('A'.$cellid.':'.$currentcell.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e8e8e8');				
				
				
				//--- SET USERS LOOP
				$sl = "1";
				$sqlu = "SELECT ls.user_id, s.fusion_id, s.fusion_name, ls.id as schedule_id, ls.exam_id, ls.allotted_set_id  from lt_exam_schedule as ls INNER JOIN (SELECT fusion_id, concat(fname,' ',lname) as fusion_name, id as uid from signin) as s ON ls.user_id = s.uid WHERE ls.module_id = '$assessment_id' AND ls.module_type = 'TR' AND ls.allotted_set_id = '$get_set_id'";
				$queryu = $this->Common_model->get_query_result_array($sqlu);
				foreach($queryu as $tokenu){
					
					$get_my_schedule_id = $tokenu['schedule_id'];
					$cellid = $cellid + 1;
					$userid = $tokenu['user_id'];
					$this->excel->getActiveSheet()->setCellValue("A".$cellid, $sl++);
					$this->excel->getActiveSheet()->setCellValue("B".$cellid, $tokenu['fusion_id']);
					$this->excel->getActiveSheet()->setCellValue("C".$cellid, $tokenu['fusion_name']);	
					
					//--- GET SCORE
					$qSqlcheck   = "select * from training_assessment_score where assmnt_id ='$assessment_id' AND user_id = '$userid'";
					$getresult = $this->Common_model->get_query_row_array($qSqlcheck);
					$this->excel->getActiveSheet()->setCellValue("D".$cellid, $getresult['score']);
					$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
					 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
					);
					$this->excel->getActiveSheet()->getStyle("D".$cellid)->getAlignment()->applyFromArray(
					 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
					);
					
					//--- GET ANSWERS
					$sqlanswer = "SELECT exam_schedule_id, ques_id, ans_id, atext, cid, ctext, iscorrect FROM lt_user_exam_answer as ua
									LEFT JOIN (SELECT id as aid, ques_id as aqid, text as atext, correct_answer as iscorrect from lt_questions_ans_options) as la ON la.aid = ua.ans_id
									LEFT JOIN (SELECT id as cid, ques_id as cqid, text as ctext from lt_questions_ans_options WHERE correct_answer = '1') as lqa ON la.aqid = lqa.cqid 
									WHERE ua.exam_schedule_id = '$get_my_schedule_id' $orderByClause";
					$queryanswer = $this->Common_model->get_query_result_array($sqlanswer);
					$startcell = ord('E');
					foreach($queryanswer as $tokenanswer){
						
						$currentcell = chr($startcell++); 
						$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokenanswer['atext']);
						$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
						
						$styleArray = array(
						'font'  => array(
							'color' => array('rgb' => 'FF0000'),
							'bold'  => true,
							//'size'  => 15,
							//'name'  => 'Verdana'
						));						
						if($tokenanswer['iscorrect'] != "1"){
							$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->applyFromArray($styleArray);
						}
						
						// CORRECT COUNTS						
						if(!empty($tokenanswer['ans_id'])){
							if($tokenanswer['iscorrect'] != "1"){
								$questionCounts[$tokenanswer['ques_id']]['wrong'] = $questionCounts[$tokenanswer['ques_id']]['wrong'] + 1;
							} else {
								$questionCounts[$tokenanswer['ques_id']]['correct'] = $questionCounts[$tokenanswer['ques_id']]['correct'] + 1;
							}
						} else {
							$questionCounts[$tokenanswer['ques_id']]['unknown'] = $questionCounts[$tokenanswer['ques_id']]['unknown'] + 1;
						}
						
					}
				}	

				//-- SET CORRECT ANSWER
				$cellid = $cellid + 1;
				$startcell = ord('E');
				foreach($queryp as $tokena){
					$currentcell = chr($startcell++); 
					$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokena['correct_answer']);
					$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
				}
				
				$this->excel->getActiveSheet()->getStyle('E'.$cellid.':'.$currentcell.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('d4fce5');			
					
			}		
			
			// QUESTION ANALYTICS
			$cellid = $cellid + 3;
			$this->excel->getActiveSheet()->setCellValue("A".$cellid, "QUESTION ANALYTICS : ".$get_exam_name);
			$this->excel->getActiveSheet()->getStyle("A".$cellid)->getFont()->setSize(14);
			$this->excel->getActiveSheet()->mergeCells('A'.$cellid.':I'.$cellid);
			$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4be9f');
			$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			
			$cellid = $cellid + 2;			
			//--- SET COLUMNE NAMES
			$this->excel->getActiveSheet()->setCellValue('A'.$cellid, 'Sl No');
			$this->excel->getActiveSheet()->setCellValue('B'.$cellid, 'Question');
			$this->excel->getActiveSheet()->mergeCells('B'.$cellid.':F'.$cellid);
			$this->excel->getActiveSheet()->setCellValue('G'.$cellid, 'Correct');
			$this->excel->getActiveSheet()->setCellValue('H'.$cellid, 'Wrong');
			$this->excel->getActiveSheet()->setCellValue('I'.$cellid, 'Not Answered');
			$this->excel->getActiveSheet()->getStyle('A'.$cellid.':I'.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
			$styleBGArray = array( 'font'  => array( 'color' => array('rgb' => 'FFFFFF'),'bold'  => true, ));
			$this->excel->getActiveSheet()->getStyle('A'.$cellid.':I'.$cellid)->applyFromArray($styleBGArray);
			
			//-- SET CORRECT ANSWER
			$slQtype = 0;
			foreach($queryp as $tokenQtype){
				$slQtype++;				
				$cellid = $cellid + 1;
				$this->excel->getActiveSheet()->setCellValue('A'.$cellid, $slQtype);
				$this->excel->getActiveSheet()->setCellValue('B'.$cellid, $tokenQtype['title']);
				$this->excel->getActiveSheet()->mergeCells('B'.$cellid.':F'.$cellid);
				$this->excel->getActiveSheet()->setCellValue('G'.$cellid, $questionCounts[$tokenQtype['id']]['correct']);
				$this->excel->getActiveSheet()->setCellValue('H'.$cellid, $questionCounts[$tokenQtype['id']]['wrong']);
				$this->excel->getActiveSheet()->setCellValue('I'.$cellid, $questionCounts[$tokenQtype['id']]['unknown']);
			}
			
			}
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
			ob_end_clean();
			$objWriter->save('php://output');
			
			} else {
				redirect($_SERVER['HTTP_REFERER']);
			}
			
			
			
		}
		
		
		
		public function downloadProductResultScore()
		{
			
			$current_user  = get_user_id();
			$batch_id      = $this->uri->segment(4); 
			$assessment_id = $this->uri->segment(3);		
			
			// GET EXAM DETAILS
			$qexam   = "select * from training_assessment where id ='$assessment_id'";
			$gexam = $this->Common_model->get_query_row_array($qexam);
			
			// GET NAME
			$sqln = "SELECT * from training_assessment as t 
					LEFT JOIN (SELECT id as cid, shname as client_name from client) as c ON t.client_id = c.cid
					LEFT JOIN (SELECT id as pid, client_id as pcid, name as process_name from process) as p ON t.process_id = p.pid 
					WHERE t.id = '$assessment_id'";
			$detailsrow = $this->Common_model->get_query_row_array($sqln);
			
			$client_name  = $detailsrow['client_name'];
			$process_name = $detailsrow['process_name'];
			
		    if($assessment_id != ""){
				
			$qSql = "SELECT * FROM lt_exam_schedule as l 
				    LEFT JOIN (SELECT id as uid, fusion_id, concat(fname,' ',lname) as fusion_name from signin) as s ON s.uid = l.user_id
                    WHERE l.module_id = '$assessment_id' AND l.module_type = 'TR'";
			$offlinerow = $this->Common_model->get_query_result_array($qSql);
			
			$fn = $gexam['location_id']." (".$client_name ."-" .$process_name .")";
			$sht_title= str_replace("/","_",$fn);
			if(strlen($sht_title)>29) $sht_title =  substr($sht_title,0,29);
			$title = $fn;
			
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle($sht_title);
			$this->excel->getActiveSheet()->setCellValue('A1', $title);
			$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			$this->excel->getActiveSheet()->mergeCells('A1:F1');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
			$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
			$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
			$this->excel->getActiveSheet()->setCellValue('D2', 'SCORE (%)');
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("25");
			$this->excel->getActiveSheet()->getColumnDimensionByColumn('D')->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
			
			$this->excel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bcdbe7');
			
			$sl = "0";
			$cellid = "2";
			foreach($offlinerow as $token):
				$sl++;
				$cellid++;	
				$userid = $token['user_id'];
				$this->excel->getActiveSheet()->setCellValue("A".$cellid, $sl);
				$this->excel->getActiveSheet()->setCellValue("B".$cellid, $token['fusion_id']);
				$this->excel->getActiveSheet()->setCellValue("C".$cellid, $token['fusion_name']);	

				$qSqlcheck   = "select * from training_assessment_score where assmnt_id ='$assessment_id' AND user_id = '$userid'";
			    $getresult = $this->Common_model->get_query_row_array($qSqlcheck);
				$this->excel->getActiveSheet()->setCellValue("D".$cellid, $getresult['score']);
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				$this->excel->getActiveSheet()->getStyle("D".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				
			endforeach;
			
			
			if($gexam['assmnt_type'] == "1"){ 
			
			//----------------------------- GET QUESTIONS
			
			//---- SET EXAM NAME
			$qSqlE = "SELECT ls.exam_id as my_exam_id, e.title as exam_name, ls.allotted_set_id, ls.id as schedule_id FROM lt_exam_schedule as ls  
					 LEFT JOIN (SELECT id as eid, title from lt_examination) as e ON e.eid = ls.exam_id
					 WHERE ls.module_id = '$assessment_id' AND ls.module_type = 'TR' GROUP BY ls.exam_id, ls.allotted_set_id";			
			$ExamArrayE = $this->Common_model->get_query_result_array($qSqlE);
			foreach($ExamArrayE as $tokenE){
			
				$get_exam_id = 	$tokenE['my_exam_id'];	
				$get_exam_name = 	$tokenE['exam_name'];	
				$get_set_id = 	$tokenE['allotted_set_id'];	
				$get_schedule_id = 	$tokenE['schedule_id'];	
				
				$cellid = $cellid + 3;
				$this->excel->getActiveSheet()->setCellValue("A".$cellid, "Exam Name : ".$get_exam_name);
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getFont()->setSize(14);
				$this->excel->getActiveSheet()->mergeCells('A'.$cellid.':F'.$cellid);
				$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4be9f');
				$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
				 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				);
				
				$cellid = $cellid + 1;
				
				//--- SET COLUMNE NAMES
				$this->excel->getActiveSheet()->setCellValue('A'.$cellid, 'SLNo');
				$this->excel->getActiveSheet()->setCellValue('B'.$cellid, 'FUSIONID');
				$this->excel->getActiveSheet()->setCellValue('C'.$cellid, 'NAME');
				$this->excel->getActiveSheet()->setCellValue('D'.$cellid, 'SCORE (%)');
				
				
				//---- SET QUESTION COLUMN
				$sqlq = "SELECT * from lt_questions as q 
                         LEFT JOIN (SELECT id as correctid, ques_id, text as correct_answer from lt_questions_ans_options WHERE correct_answer = '1') as lqa ON q.id = lqa.ques_id WHERE q.set_id = '$get_set_id'";
				$queryp = $this->Common_model->get_query_result_array($sqlq);
				$sqlno = 0;
				$startcell = ord('E');
				
				$questionCounts = array();
				$questionOrder = array(); 
				
				$orderSl = 0;
				$orderByAddClause = "";
				foreach($queryp as $tokenQ){
					$orderSl++;
					$questionOrder[] = $tokenQ['id'];
					$questionCounts[$tokenQ['id']]['correct'] = 0;
					$questionCounts[$tokenQ['id']]['wrong'] = 0;
					$questionCounts[$tokenQ['id']]['unknown'] = 0;
					$questionID = $tokenQ['id'];
					$orderByAddClause .= " WHEN " .$questionID ." THEN " .$orderSl;
					$currentcell = chr($startcell++); 
					$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokenQ['title']);
					$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
					$this->excel->getActiveSheet()->getColumnDimensionByColumn($currentcell)->setAutoSize(false);
					$this->excel->getActiveSheet()->getColumnDimension($currentcell)->setWidth("20");		
				}
				
				$orderByClause = "";
				if(!empty($orderByAddClause)){
					$orderByClause .= " ORDER BY CASE ques_id ";
					$orderByClause .= $orderByAddClause;
					$orderByClause .= " ELSE 1000 END ASC ";
				}
				$questionIDs = implode(',', $questionOrder);
				//$this->excel->getActiveSheet()->getStyle('A'.$cellid.':'.$currentcell.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('e8e8e8');				
				
				
				//--- SET USERS LOOP
				$sl = "1";
				$sqlu = "SELECT ls.user_id, s.fusion_id, s.fusion_name, ls.id as schedule_id, ls.exam_id, ls.allotted_set_id  from lt_exam_schedule as ls INNER JOIN (SELECT fusion_id, concat(fname,' ',lname) as fusion_name, id as uid from signin) as s ON ls.user_id = s.uid WHERE ls.module_id = '$assessment_id' AND ls.module_type = 'TR' AND ls.allotted_set_id = '$get_set_id'";
				$queryu = $this->Common_model->get_query_result_array($sqlu);
				foreach($queryu as $tokenu){
					
					$get_my_schedule_id = $tokenu['schedule_id'];
					$cellid = $cellid + 1;
					$userid = $tokenu['user_id'];
					$this->excel->getActiveSheet()->setCellValue("A".$cellid, $sl++);
					$this->excel->getActiveSheet()->setCellValue("B".$cellid, $tokenu['fusion_id']);
					$this->excel->getActiveSheet()->setCellValue("C".$cellid, $tokenu['fusion_name']);	
					
					//--- GET SCORE
					$qSqlcheck   = "select * from training_assessment_score where assmnt_id ='$assessment_id' AND user_id = '$userid'";
					$getresult = $this->Common_model->get_query_row_array($qSqlcheck);
					$this->excel->getActiveSheet()->setCellValue("D".$cellid, $getresult['score']);
					$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
					 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
					);
					$this->excel->getActiveSheet()->getStyle("D".$cellid)->getAlignment()->applyFromArray(
					 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
					);
					
					//--- GET ANSWERS
					$sqlanswer = "SELECT exam_schedule_id, ques_id, ans_id, atext, cid, ctext, iscorrect FROM lt_user_exam_answer as ua
									LEFT JOIN (SELECT id as aid, ques_id as aqid, text as atext, correct_answer as iscorrect from lt_questions_ans_options) as la ON la.aid = ua.ans_id
									LEFT JOIN (SELECT id as cid, ques_id as cqid, text as ctext from lt_questions_ans_options WHERE correct_answer = '1') as lqa ON la.aqid = lqa.cqid 
									WHERE ua.exam_schedule_id = '$get_my_schedule_id' $orderByClause";
					$queryanswer = $this->Common_model->get_query_result_array($sqlanswer);
					$startcell = ord('E');
					foreach($queryanswer as $tokenanswer){
						
						$currentcell = chr($startcell++); 
						$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokenanswer['atext']);
						$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
						
						$styleArray = array(
						'font'  => array(
							'color' => array('rgb' => 'FF0000'),
							'bold'  => true,
							//'size'  => 15,
							//'name'  => 'Verdana'
						));						
						if($tokenanswer['iscorrect'] != "1"){
							$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->applyFromArray($styleArray);
						}
						
						// CORRECT COUNTS						
						if(!empty($tokenanswer['ans_id'])){
							if($tokenanswer['iscorrect'] != "1"){
								$questionCounts[$tokenanswer['ques_id']]['wrong'] = $questionCounts[$tokenanswer['ques_id']]['wrong'] + 1;
							} else {
								$questionCounts[$tokenanswer['ques_id']]['correct'] = $questionCounts[$tokenanswer['ques_id']]['correct'] + 1;
							}
						} else {
							$questionCounts[$tokenanswer['ques_id']]['unknown'] = $questionCounts[$tokenanswer['ques_id']]['unknown'] + 1;
						}
						
					}
				}	

				//-- SET CORRECT ANSWER
				$cellid = $cellid + 1;
				$startcell = ord('E');
				foreach($queryp as $tokena){
					$currentcell = chr($startcell++); 
					$this->excel->getActiveSheet()->setCellValue($currentcell.$cellid, $tokena['correct_answer']);
					$this->excel->getActiveSheet()->getStyle($currentcell.$cellid)->getAlignment()->setWrapText(true);
				}
				
				$this->excel->getActiveSheet()->getStyle('E'.$cellid.':'.$currentcell.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('d4fce5');			
					
			}		
			
			// QUESTION ANALYTICS
			$cellid = $cellid + 3;
			$this->excel->getActiveSheet()->setCellValue("A".$cellid, "QUESTION ANALYTICS : ".$get_exam_name);
			$this->excel->getActiveSheet()->getStyle("A".$cellid)->getFont()->setSize(14);
			$this->excel->getActiveSheet()->mergeCells('A'.$cellid.':I'.$cellid);
			$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A'.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4be9f');
			$this->excel->getActiveSheet()->getStyle("A".$cellid)->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			);
			
			$cellid = $cellid + 2;			
			//--- SET COLUMNE NAMES
			$this->excel->getActiveSheet()->setCellValue('A'.$cellid, 'Sl No');
			$this->excel->getActiveSheet()->setCellValue('B'.$cellid, 'Question');
			$this->excel->getActiveSheet()->mergeCells('B'.$cellid.':F'.$cellid);
			$this->excel->getActiveSheet()->setCellValue('G'.$cellid, 'Correct');
			$this->excel->getActiveSheet()->setCellValue('H'.$cellid, 'Wrong');
			$this->excel->getActiveSheet()->setCellValue('I'.$cellid, 'Not Answered');
			$this->excel->getActiveSheet()->getStyle('A'.$cellid.':I'.$cellid)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
			$styleBGArray = array( 'font'  => array( 'color' => array('rgb' => 'FFFFFF'),'bold'  => true, ));
			$this->excel->getActiveSheet()->getStyle('A'.$cellid.':I'.$cellid)->applyFromArray($styleBGArray);
			
			//-- SET CORRECT ANSWER
			$slQtype = 0;
			foreach($queryp as $tokenQtype){
				$slQtype++;				
				$cellid = $cellid + 1;
				$this->excel->getActiveSheet()->setCellValue('A'.$cellid, $slQtype);
				$this->excel->getActiveSheet()->setCellValue('B'.$cellid, $tokenQtype['title']);
				$this->excel->getActiveSheet()->mergeCells('B'.$cellid.':F'.$cellid);
				$this->excel->getActiveSheet()->setCellValue('G'.$cellid, $questionCounts[$tokenQtype['id']]['correct']);
				$this->excel->getActiveSheet()->setCellValue('H'.$cellid, $questionCounts[$tokenQtype['id']]['wrong']);
				$this->excel->getActiveSheet()->setCellValue('I'.$cellid, $questionCounts[$tokenQtype['id']]['unknown']);
			}
			
			
			}
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
			ob_end_clean();
			$objWriter->save('php://output');
			
			} else {
				redirect($_SERVER['HTTP_REFERER']);
			}
			
			
			
		}
		
		

	




/////######################################################################################################
////////-------------------------- NESTING DESIGN -----------------------------//
		
		
		public function nesting_summary(){
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/nesting_summary.php";
				
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = $user_office_id;
				$data['oValue'] = $oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and location='$oValue' ";
						$filterCond2 = " and office_id='$oValue' ";
				}
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}
								
				// GET NESTING PERFORMANCE
				$sqlnestingp = "SELECT DISTINCT(kpi_name) as kpi_name from training_nesting_kpi WHERE did IN (SELECT id from training_nesting_design WHERE CONCAT(client_id, process_id) IN (SELECT CONCAT(client_id, process_id) from training_batch WHERE trainer_id IN (SELECT id from signin WHERE 1 $filterCond2) $filterCond3))";
				$data['nesting_kpi'] = $nestingkpi = $this->Common_model->get_query_result_array($sqlnestingp);
				
				// COUNT AVERAGE SCORE
				foreach($nestingkpi as $tokenm)
				{
					$kname = $tokenm['kpi_name'];
					$batchcounter = "0";
					
					$nesting_process  = "SELECT d.*, p.name as process_name,
					(SELECT avg(kpi_value) as value from training_nesting_data WHERE ntdid IN (SELECT id from training_nesting_design WHERE process_id = d.process_id) AND kpi_id IN (SELECT id from training_nesting_kpi WHERE kpi_name = '$kname') $filterCond2) as kpi_average
					FROM training_nesting_design as d
					LEFT JOIN process as p ON d.process_id = p.id
					WHERE d.id IN (SELECT did from training_nesting_kpi WHERE kpi_name = '$kname')";
					$data['nesting_process'][$kname] = $queryprocess = $this->Common_model->get_query_result_array($nesting_process);
					/*foreach($queryprocess as $avgtoken)
					{
						$gpid = $avgtoken['process_id'];
						$sqlaverage = "SELECT avg(kpi_value) as value from training_nesting_data WHERE ntdid IN (SELECT id from training_nesting_design WHERE process_id = '$gpid') AND kpi_id IN (SELECT id from training_nesting_kpi WHERE kpi_name = '$kname')";
						$data['avg_score'][$kname][$gpid] = $this->Common_model->get_single_value($sqlaverage);
					}*/					
				}
				
				
				// GET AUDIT PERFORMANCE
				$sqlauditp = "SELECT b.*, concat(s.fname, ' ', s.lname) as tname, c.shname as client_name, p.name as process_name 
				                from training_batch as b 
				                LEFT JOIN client as c ON b.client_id = c.id
								LEFT JOIN process as p ON b.process_id = p.id
								LEFT JOIN signin as s ON b.trainer_id = s.id
								WHERE b.trn_type = '3' AND 
								b.trainer_id IN (SELECT id from signin WHERE 1 $filterCond2) $filterCond3
								GROUP BY b.client_id, b.process_id";
				$data['audit_process'] = $auditprocess = $this->Common_model->get_query_result_array($sqlauditp);
				
				// COUNT AUDIT SCORE
				foreach($auditprocess as $tokena)
				{
					//$kname = $tokena['id'];
					$kclient = $tokena['client_id'];
					$kprocess = $tokena['process_id'];
					$batchcounter = "0";
					
					$audit_kpi_sql  = "SELECT k.*, 
					(SELECT avg(kpi_value) as value from training_audit_data WHERE ntdid IN (SELECT id from training_audit_design WHERE client_id = '$kclient' AND process_id = '$kprocess' $filterCond2) AND  kpi_id = k.id) as kpi_average
					from training_audit_kpi as k
					WHERE did IN (SELECT id from training_audit_design WHERE client_id = '$kclient' AND process_id = '$kprocess')";
					$data['audit_kpi'][$kclient][$kprocess] = $auditkpi = $this->Common_model->get_query_result_array($audit_kpi_sql);
					/*foreach($queryprocess as $avgtoken)
					{
						$gpid = $avgtoken['process_id'];
						$sqlaverage = "SELECT avg(kpi_value) as value from training_nesting_data WHERE ntdid IN (SELECT id from training_nesting_design WHERE process_id = '$gpid') AND kpi_id IN (SELECT id from training_nesting_kpi WHERE kpi_name = '$kname')";
						$data['avg_score'][$kname][$gpid] = $this->Common_model->get_single_value($sqlaverage);
					}*/					
				}
				
				
				
				if($is_global_access==1) $data['location_list'] = $this->Common_model->get_office_location_list();
				else $data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
	   public function get_clients_training_nesting()
	   {
			$office_id = $this->input->post('office_id');
			if($office_id != 'ALL')
			{
				$qSql="SELECT DISTINCT c.id, c.shname FROM training_batch as b
				LEFT JOIN client as c ON c.id=b.client_id
				LEFT JOIN signin as s on b.trainer_id = s.id 
				WHERE s.office_id = '".$office_id."' AND b.trn_type = '3'";
			}
			else
			{
				$qSql="SELECT DISTINCT c.id, c.shname FROM training_batch as b
				LEFT JOIN client as c ON c.id=b.client_id
				LEFT JOIN signin as s on b.trainer_id = s.id 
				WHERE b.trn_type = '3'";
			}
			echo json_encode($this->Common_model->get_query_result_array($qSql));
	   }
		
		
		public function nesting_kpi_details(){
			if(check_logged_in())
			{
				$t_batch_id = $this->input->get('kid');
				
				$sqltrainingdetails = "SELECT * from training_details as t 
				LEFT JOIN 
				(SELECT concat(fname, ' ', lname) as tusername, id as sid, fusion_id from signin) as s ON s.sid = t.user_id
				LEFT JOIN 
				(SELECT avg(kpi_value) as records, user_id from training_nesting_data WHERE ntdid IN (SELECT id from training_nesting_design WHERE trn_batch_id = '$t_batch_id') GROUP BY user_id) as d ON d.user_id = t.user_id
				WHERE t.trn_batch_id = '$t_batch_id'";
				$nestingresult = $this->Common_model->get_query_result_array($sqltrainingdetails);
				echo "<div class='row'><div class='col-md-12'><table style='width:100%' class='table2 skt-table'><thead><tr class='bg-primary'><th>#</th><th>Fusion ID</th><th>Fusion Name</th><th>Avg Score</th></tr></thead><tbody>";
				foreach($nestingresult as $nesti)
				{
					echo "<tr><td>".++$sl."</td><td class='text-left'>".$nesti['fusion_id']."</td><td>".$nesti['tusername']."</td><td>".$nesti['records']."</td>";
				}
				echo "</tbody></table></div></div>";
			}
		}
		
		
		
		public function nesting_kpi_details_2(){
			if(check_logged_in())
			{
				$kipiid = $this->input->get('kid');
				
				$sqlnest = "SELECT k.*, m.name as kpiname from training_nesting_kpi as k 
				            LEFT JOIN pm_kpi_type_mas as m ON k.kpi_type = m.id 
				            WHERE k.did IN (SELECT id from training_nesting_design WHERE process_id = '$kipiid')";
				$nestingresult = $this->Common_model->get_query_result_array($sqlnest);
				echo "<div class='row'><div class='col-md-12'><table style='width:100%' class='table2 skt-table'><thead><tr class='bg-primary'><th>#</th><th>KPI Name</th><th>Average</th></tr></thead><tbody>";
				foreach($nestingresult as $nesti)
				{
					$kpi_c_id = $nesti['id'];
					$sqlavgscores = "SELECT avg(records) as value from (SELECT avg(kpi_value) as records from training_nesting_data 
					WHERE ntdid IN (SELECT id from training_nesting_design WHERE process_id = '$kipiid')
					AND kpi_id IN ('$kpi_c_id')
					GROUP BY user_id) as dataset";
					$queryscores = $this->Common_model->get_single_value($sqlavgscores);
					echo "<tr><td>".++$sl."</td><td class='text-left'>".$nesti['kpi_name']."</td><td>".$queryscores."</td>";
				}
				echo "</tbody></table></div></div>";
			}
		}
		
		
		public function nesting(){
			if(check_logged_in())
			{
				$todayDate=CurrDate();
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_design";
				$data['design']['name'] = $design_name = "Nesting";
				$data['design']['kpi'] = $design_kpi = "training_nesting_kpi";
				$data['design']['data'] = $design_data = "training_nesting_data";
				$data['design']['url']['design'] = $url_design = "nesting_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingDesign";
				
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				 
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/nesting_alignment.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = $user_office_id;
				$data['oValue'] = $oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and batch_office_id = '$oValue'";
						$filterCond2 = " and (location_id='$oValue' OR batch_office_id = '$oValue') ";
				}
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
							
				$qSql="Select id,name from master_term_type where is_active=1";
				$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="Select id,name from master_sub_term_type where is_active=1";
				$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="Select id,description from master_resign_reason where is_active=1";
				$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
				
				//$qSql="SELECT id, concat(fname, ' ', lname) as fullname from signin WHERE dept_id IN (11)";
				$qSql="SELECT id, concat(fname, ' ', lname) as fullname from signin WHERE dept_id IN (11)";
				$data['t_traineelist'] = $this->Common_model->get_query_result_array($qSql);
			
			
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
											
					$qSql="Select tb.*,c.shname, p.name, CONCAT(fname,' ' ,lname) as trainer_name, office_id from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id 
							WHERE trn_type=3 $filterCond4 $filterCond $filterCond3 order by tb.id desc";
					
					//echo $qSql;
					
					$data["get_assigned_batch"] = $get_assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				} else {
					$myteamIDs = $this->get_team_id($current_user);
					$qSql="Select tb.*,c.shname, p.name, CONCAT(fname,' ' ,lname) as trainer_name, office_id from training_batch tb 
					       LEFT JOIN client c ON  c.id=tb.client_id 
						   LEFT JOIN process p ON  p.id=tb.process_id 
						   LEFT JOIN signin ON  signin.id=tb.trainer_id 
						   WHERE (trainer_id='$current_user' OR trainer_id IN ($myteamIDs)) and trn_type=3 $filterCond4 $filterCond3 order by tb.id desc";					
					$data["get_assigned_batch"] = $get_assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$j=0;
				foreach($get_assigned_batch as $rowtoken)
				{
					$batch_id= $rowtoken['id'];
					$t_cid = $rowtoken['client_id'];
					$t_pid = $rowtoken['process_id'];
					$t_oid = $rowtoken['batch_office_id'];
					
					$qSql="SELECT id, concat(fname, ' ', lname) as fullname from signin WHERE dept_id IN (11,6) AND client_id = '$t_cid' AND process_id = '$t_pid'";
					$data['t_traineelist_new'][$batch_id] = $this->Common_model->get_query_result_array($qSql);
										
					$getpmid_test = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb_test = $this->Common_model->get_query_row_array($getpmid_test);
					$pmdid = $pm_batch_rowb_test['id'];
					
					$getpmid_test_data = "SELECT * from $design_data WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb_test_data = $this->Common_model->get_query_row_array($getpmid_test_data);
					$datamdid = $pm_batch_rowb_test_data['id'];
					
					$getamid_test = "SELECT * from training_audit_design WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb_testa = $this->Common_model->get_query_row_array($getamid_test);
					$amdid = $pm_batch_rowb_testa['id'];
					
					$sqlcc = "Select *,(Select name from event_master e where e.id=s.disposition_id) as disp_name 
					from training_details td 
					LEFT JOIN signin s on td.user_id = s.id
					LEFT JOIN 
					(select user_id as luid, sum(TIME_TO_SEC(timediff(logout_time,login_time))) as tLtime from logged_in_details where cast(login_time as date) = '".$todayDate."' and cast(logout_time as date) >= '".$todayDate."' group by user_id) yy on (td.user_id=yy.luid)
					LEFT JOIN 
					(select start_date,end_date,user_id as duid from event_disposition where start_date <= '".$todayDate."' and end_date >= '".$todayDate."' group by duid ) d on (td.user_id=d.duid)
					Left Join (select user_id as tuid, is_term_complete, max(terms_date) as terms_date from terminate_users where is_term_complete='Y' group by user_id ) trm ON (td.user_id=trm.tuid) where trn_batch_id = '$batch_id' AND trn_status = '3' order by fname";
					$data['candidate_details'][$batch_id] = $cdetails = $this->Common_model->get_query_result_array($sqlcc);
					
					// GET CANDIDATE DEAILS
					foreach($cdetails as $crow)
					{
						 $user_id= $crow['user_id'];
						 
						 // GET TRAINER DETAILS
						 $sqltrainerd = "SELECT concat(q.fname, ' ', q.lname) as fullname, q.id as userid from signin as q 
						 LEFT JOIN signin as s ON q.id = s.assigned_to WHERE s.id = '$user_id'";
						 $ctraineename = $this->Common_model->get_query_row_array($sqltrainerd);
						 $data['candidate_info'][$batch_id]['trainee'][$user_id]['id'] = $ctraineename['userid'];
						 $data['candidate_info'][$batch_id]['trainee'][$user_id]['name'] = $ctraineename['fullname'];
						 
					}
					
					$get_assigned_batch[$j]['designid'] = $pmdid;
					$get_assigned_batch[$j]['auditdesignid'] = $amdid;
					$get_assigned_batch[$j]['designdata'] = $datamdid;
					$j++;
				}
				
				$data["get_assigned_batch"] = $get_assigned_batch;
				//echo "<pre>" .print_r($get_assigned_batch, true) ."</pre>";die();
				
				
				$qSql="Select id,title,location,(select min(id) from lt_question_set qs where qs.exam_id =ex.id ) as SetID, (select count(id) from lt_question_set qs where qs.exam_id =ex.id ) as totSet , (select count(id) from lt_questions ques where ques.set_id =SetID ) as totQues  FROM lt_examination ex  Where type = 'TR' and status=1";
				
				$data["exam_list"] = $this->Common_model->get_query_result_array($qSql);
				
				/////////////	
				$otherOffice = get_user_oth_office();
				$extraOfficeFilterOth = "";
				if(!empty($otherOffice)){
					$otherOfficeCheck = implode("','",explode(',', $otherOffice));
					$extraOfficeFilterOth = " OR s.office_id IN ('$otherOfficeCheck')";
				}
				
				
				$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name, office_id from signin s where status=1 and ( role_id not in (select id from role where folder='agent') OR dept_id=11) and (office_id='$user_office_id' $extraOfficeFilterOth) order by name asc ";
				
				//echo "assigned_l1super:: ".$qSql;
				
				$data["assigned_l1super"] = $this->Common_model->get_query_result_array($qSql);
				//////////////
				
				$qSqlt = "SELECT s.id, s.fusion_id, d.shname as department, r.name as designation, concat(s.fname, ' ', s.lname) as name, s.office_id from signin s LEFT JOIN department d ON s.dept_id = d.id LEFT JOIN role r on r.id = s.role_id WHERE s.status=1 and (s.role_id not in (select id from role where folder='agent') OR s.dept_id=11) and (s.office_id='$user_office_id'  $extraOfficeFilterOth) ORDER BY name ASC ";
				$data["assigned_trainerlist"]  = $this->Common_model->get_query_result_array($qSqlt);
			
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
								
				$data['e_client_list'] = $this->Common_model->get_client_list();
				$data['e_process_list'] = $this->Common_model->get_process_for_assign();
							
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
		public function get_trainee_change_nesting()
		{
			if(check_logged_in())
			{
				$user_office_id= get_user_office_id();
				$i_cid = $this->input->get('cid');
				$i_pid = $this->input->get('pid');
				
				//$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name, office_id from signin where status=1 and ( role_id not in (select id from role where folder='agent') OR dept_id=11) and office_id='$user_office_id' order by name asc";
				
				//$qSql="SELECT id, concat(fname, ' ', lname) as name from signin WHERE dept_id IN (11,6) AND is_assign_client(id,'$i_cid') AND is_assign_process(id, '$i_pid') ORDER by name";
				
				$qSql = "SELECT s.id, s.fusion_id, d.shname as department, r.name as designation, concat(s.fname, ' ', s.lname) as name, s.office_id from signin s LEFT JOIN department d ON s.dept_id = d.id LEFT JOIN role r on r.id = s.role_id WHERE s.status=1 and (s.role_id not in (select id from role where folder='agent') OR s.dept_id=11) and s.office_id='$user_office_id' ORDER BY name ASC ";
				$tlist = $this->Common_model->get_query_result_array($qSql);
				foreach($tlist as $tokenlist)
				{
					echo "<option value='".$tokenlist['id']."'>".$tokenlist['name'] ." - " .$tokenlist['department'] ." - (" .$tokenlist['designation'].") - " .$tokenlist['fusion_id'] ."</option>";
				}
				
			}
		}
		
		
		public function change_trainee_nesting()
		{
			if(check_logged_in())
			{
				$i_userid = trim($this->input->post('t_userid'));
				$i_choosetrainee = trim($this->input->post('t_choosetrainee'));
				
				$field_array = array(
					"assigned_to" => $i_choosetrainee
				); 
				$this->db->where('id', $i_userid);
			    $this->db->update('signin', $field_array);
				
				redirect(base_url()."training/nesting");
			}
		}
		
		
		
	    public function nesting_performance(){
			
			if(check_logged_in())
			{
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_design";
				$data['design']['name'] = $design_name = "Nesting";
				$data['design']['kpi'] = $design_kpi = "training_nesting_kpi";
				$data['design']['data'] = $design_data = "training_nesting_data";
				$data['design']['url']['design'] = $url_design = "nesting_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingDesign";
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/nesting_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and (batch_office_id = '$oValue') ";
						$filterCond2 = " and (location_id='$oValue') ";
				}
				
				
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
					
					$qSql="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_type=3 $filterCond $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="Select tb.*, c.shname as client_name , p.name as process_name, batch_office_id, batch_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trainer_id='$current_user' and trn_type=3 $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_type=3 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$data['checkupload'][$batch_id] = '0';
					
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ntdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ntdid = '$ragdid' AND kpi_id = '$kpiid'";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							$jcheck++;
						}
					}
					
					
					$i++;
				}
				
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
				
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
							
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}


//============================= NESTING DESIGN =========================================================//
		
		
		public function nesting_design(){
			
			if(check_logged_in())
			{
				$current_user     = get_user_id();
				$user_site_id     = get_user_site_id();
				$user_office_id   = get_user_office_id();
				$user_oth_office  = get_user_oth_office();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$role_dir         = get_role_dir();
				$role_id          = get_role_id();
				$get_dept_id      = get_dept_id();
				
				$data["aside_template"]   = "training/aside.php";
				$data["content_template"] = "training/training_nesting_design.php";
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_design";
				$data['design']['name'] = $design_name = "Nesting";
				$data['design']['kpi'] = $design_kpi = "training_nesting_kpi";
				$data['design']['data'] = $design_data = "training_nesting_data";
				$data['design']['url']['design'] = $url_design = "nesting_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingDesignForm";
				
				//=========== OFFICE > CLIENT > PROCESS FILTER
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
										
				$_filterCond="";
				//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") 
				$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
				LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1'";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSqlall="Select id as client_id, shname from client where is_active='1'";	
				$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
								
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" WHERE id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				//============ FORM URL DATA
				$data['hide_normal'] = "off";
				$url_batch_id = "";
				$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
				if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
				$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
				if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
				$data['url_batch_id'] = $url_batch_id;
				
					
				$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
					(SELECT name from process y where y.id = b.process_id) as process_name,
					(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
					(SELECT shname from client c where c.id = b.client_id) as client_name 
					from training_batch as b WHERE b.id = '$url_batch_id'";
				$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
				// CHECK ANY PREVIOUS DESIGN
				$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
				$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
				if($pv_rag != ""){
					$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
					$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
				}
				
				// GET DESIGN DATA
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp WHERE is_active=1 AND trn_batch_id = '$url_batch_id' $_filterCond";
				$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
				
				$pmkpiarray=array();
				foreach($design_row as $row):
					$mp_id= $row['mp_id'];
					$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
				
				$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
				
				//loading training javascript
				//$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
			}
			
		}
	
	
	   public function addBatchNestingDesign()
		{
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_design";
				$data['design']['name'] = $design_name = "Nesting";
				$data['design']['kpi'] = $design_kpi = "training_nesting_kpi";
				$data['design']['data'] = $design_data = "training_nesting_data";
				$data['design']['url']['design'] = $url_design = "nesting_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingDesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				
				$batch_id    = trim($this->input->post('trn_batch_id'));
				$office_id    = trim($this->input->post('office_id'));
				$client_id    = trim($this->input->post('client_id'));
				$process_id   = trim($this->input->post('process_id'));
				$description  = trim($this->input->post('description'));
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
				$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				if($uploadcheck != "")
				{
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
					
				} else {
					
					$field_array = array(
						"trn_batch_id" => $batch_id,
						"office_id"    => $office_id,
						"client_id"    => $client_id,
						"process_id"   => $process_id,
						"description"  => $description,
						"added_by"     => $current_user,
						"is_active"    => '1',
						"added_date"   => $curDateTime,
						"uplog"        => $log
					);
					
					$did = data_inserter($design_table,$field_array);
					
					foreach($kpi_name_arr as $index => $kpi_name){
						if($kpi_name<>""){
							$field_array = array(
								"did" => $did,
								"kpi_name"    => $kpi_name,
								"kpi_type"    => $kpi_type_arr[$index],
								"kpi_weightage" => $kpi_weightage_arr[$index],
								"isdel"       => '0',
								"added_by"    => $current_user,
								"added_date"  => $curDateTime,
								"uplog"       => $log
							);
							data_inserter($design_kpi,$field_array);
						}
					}
				
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
				}
				
		   }        
	   }
		
		
		public function getTrainingNestingDesignForm(){
		
			if(check_logged_in())
			{				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_design";
				$data['design']['name'] = $design_name = "Nesting";
				$data['design']['kpi'] = $design_kpi = "training_nesting_kpi";
				$data['design']['data'] = $design_data = "training_nesting_data";
				$data['design']['url']['design'] = $url_design = "nesting_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingDesignForm";
				
				$mdid = trim($this->input->post('mdid'));
				$mdid=addslashes($mdid);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
					
				//$qSql="select * from pm_design where id = $mdid";
				//$design_row=$this->Common_model->get_query_row_array($qSql);
				
				$qSql="SELECT * from $design_kpi where did = $mdid";
				$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
				
				/////////
				$html = "";
				
				$TotRow = count($design_kpi_arr);
				
				$cnt = 1;
				foreach($design_kpi_arr as $kpiRow) {
				
					$html .= "<div class='col-md-12 kpi_input_row'>";					
					$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
					$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
     				$html .= "<div class='col-md-3'><select class='form-control' name='kpi_type[]' > ";
					
					foreach($kpi_type_list as $kpimas){						
						$sCss="";
						if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
						$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
					}
									
					$html .= "</select></div>";
					
					$html .= "<div class='col-md-2'><input type='text' value='". $kpiRow['kpi_weightage'] ."' onkeyup=\"this.value=this.value.replace(/[^\d]/,'')\" class='form-control' name='kpi_weightage[]'></div>";
					
					$html .= "<div class='col-md-2'>";						
						if( $cnt++<$TotRow-1){							
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
						}else{
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
						}
									
					$html .= "</div>";
				    $html .= "</div>";
				
				}	
						
				echo $html;
			}
		}

	
	   public function updateTrainingNestingDesign()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_design";
				$data['design']['name'] = $design_name = "Nesting";
				$data['design']['kpi'] = $design_kpi = "training_nesting_kpi";
				$data['design']['data'] = $design_data = "training_nesting_data";
				$data['design']['url']['design'] = $url_design = "nesting_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingDesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				$mdid = trim($this->input->post('mdid'));
				
				$batch_id  = trim($this->input->post('batch_id'));
				$office_id  = trim($this->input->post('office_id'));
				$client_id  = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$description = trim($this->input->post('description'));
				
				$kpi_id_arr   = $this->input->post('kpi_id');
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$field_array = array(
					"office_id"   => $office_id,
					"client_id"   => $client_id,
					"process_id"  => $process_id,
					"description" => $description,
					"added_by"    => $current_user,
					"is_active"   => '1',
					"added_date"  => $curDateTime,
					"uplog"       => $log
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				$TotID = count($kpi_id_arr);
				
				// DELETE DESIGN
				$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
				$query = $this->db->query($sql);
				
				foreach($kpi_name_arr as $index => $kpi_name)
				{
					if($kpi_name != "")
					{						
						$field_array = array(
							"did"         => $mdid,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"kpi_weightage"  => $kpi_weightage_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => curDateTime,
							"uplog"       => $log
						);
						
						data_inserter($design_kpi, $field_array);						
					}
				}
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
	   }


	
/////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////// NESTING RESULT /////////////////////////////////////////////////
	
	
	   		
	public function downloadTrainingNestingHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_nesting_design";
		$data['design']['name'] = $design_name = "Nesting";
		$data['design']['kpi'] = $design_kpi = "training_nesting_kpi";
		$data['design']['data'] = $design_data = "training_nesting_data";
		$data['design']['url']['design'] = $url_design = "nesting_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingDesignForm";
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id from training_batch tb 
			        LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_batch_status = '1' and trn_type=3 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$pm_batch_rowb['id']."'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, trn_batch_id, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		$batchid = $pm_design_row['trn_batch_id'];
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		
		if(!empty($batchid)){
		$slNo = 0; $r=2;
		$qSql = "Select s.*, d.user_id, CONCAT(s.fname, ' ', s.lname) as fullname from training_details as d INNER JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batchid'";
		$querySql=$this->Common_model->get_query_result_array($qSql);
		foreach($querySql as $rowD):
			$slNo++; $r++; $j=0; 
			$cell= $letters[$j++].$r;
			$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
			
			$cell= $letters[$j++].$r;
			$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
			
			$cell= $letters[$j++].$r;
			$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fullname']);			
		endforeach;
		}
		
		$currentcellvalue = ord('C');
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'] .' ('.$row['kpi_weightage'] .'%)';
			if($row['kpi_name'] == "Status"){ 
			$getkpiname = "Status (Pass/Fail)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);
			
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	/// DOWNLOAD NESTING RESULT
	   		
	public function downloadTrainingNestingResult()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_nesting_design";
		$data['design']['name'] = $design_name = "Nesting";
		$data['design']['kpi'] = $design_kpi = "training_nesting_kpi";
		$data['design']['data'] = $design_data = "training_nesting_data";
		$data['design']['url']['design'] = $url_design = "nesting_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingDesignForm";
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id from training_batch tb 
			        LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
				    WHERE trn_batch_status = '1' and trn_type=3 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$pm_batch_rowb['id']."'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$cell=$letters[$j++].$r;
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
			
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	
	
	
	
	public function uploadNestingResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/training_nesting/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_Nesting_file($fileName,$batch_id);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_Nesting_file($fileName,$batch_id);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	private function Import_Nesting_file($file_name,$batch_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/training_nesting/'.$file_name;
		
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_nesting_design";
		$data['design']['name'] = $design_name = "Nesting";
		$data['design']['kpi'] = $design_kpi = "training_nesting_kpi";
		$data['design']['data'] = $design_data = "training_nesting_data";
		$data['design']['url']['design'] = $url_design = "nesting_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingDesignForm";
		
		
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
				
		// GET RAG DID FROM BATCH
		$qSqlb="SELECT tb.*,
				c.shname as client_name, 
				p.name as process_name, 
				CONCAT(fname,' ' ,lname) as trainer_name, 
				office_id, batch_office_id from training_batch tb 
				LEFT JOIN client c ON  c.id=tb.client_id 
				LEFT JOIN process p ON  p.id=tb.process_id 
				LEFT JOIN signin ON  signin.id=tb.trainer_id  
				where trn_batch_status = '1' and trn_type=3 AND tb.id = '$batch_id'";
		
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$batch_id."'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		$pmdid = $pm_batch_rowb['id'];
			
		
		// GET KPI DETAILS
		$qSql = "Select * from $design_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET RAG DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}
		
		//echo "hi";
		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ntdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"ntdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update($design_data,$field_array);
					
					
				} else {
					
					data_inserter($design_data,$field_array);
				
				}
			
				//print_r($field_array);die();$_run = false;					
				
			}	
			}		
			
		}
		
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		
	}
	
		
	public function getFormatDesignNestingRag()
	{
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_nesting_design";
		$data['design']['name'] = $design_name = "Nesting";
		$data['design']['kpi'] = $design_kpi = "training_nesting_kpi";
		$data['design']['data'] = $design_data = "training_nesting_data";
		$data['design']['url']['design'] = $url_design = "nesting_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingDesignForm";
		
		$batchid = trim($this->input->get('batchid'));
		
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$batchid."'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		
		$pmdid = $pm_batch_rowb['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////// NESTING RESULT  ENDS /////////////////////////////////////////////////	
	
#####===================================== NESTING RAG ====================================###############	
	
	public function nesting_rag(){
			
			if(check_logged_in())
			{
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_rag_design";
				$data['design']['name'] = $design_name = "Nesting Rag";
				$data['design']['kpi'] = $design_kpi = "training_nesting_rag_kpi";
				$data['design']['data'] = $design_data = "training_nesting_rag_data";
				$data['design']['url']['design'] = $url_design = "nesting_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingRagDesignForm";
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/nesting_rag_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and (batch_office_id = '$oValue') ";
						$filterCond2 = " and (location_id='$oValue') ";
				}
				
				
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
					
					$qSql="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_type=3 $filterCond $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="Select tb.*, c.shname as client_name , p.name as process_name, batch_office_id, batch_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trainer_id='$current_user' and trn_type=3 $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_type=3 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$data['checkupload'][$batch_id] = '0';
					
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ntdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ntdid = '$ragdid' AND kpi_id = '$kpiid'";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							$jcheck++;
						}
					}
					
					
					$i++;
				}
				
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
								
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
							
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}

		public function nesting_rag_design(){
			
			if(check_logged_in())
			{
				$current_user     = get_user_id();
				$user_site_id     = get_user_site_id();
				$user_office_id   = get_user_office_id();
				$user_oth_office  = get_user_oth_office();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$role_dir         = get_role_dir();
				$role_id          = get_role_id();
				$get_dept_id      = get_dept_id();
				
				$data["aside_template"]   = "training/aside.php";
				$data["content_template"] = "training/training_nesting_rag_design.php";
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_rag_design";
				$data['design']['name'] = $design_name = "Nesting Rag";
				$data['design']['kpi'] = $design_kpi = "training_nesting_rag_kpi";
				$data['design']['data'] = $design_data = "training_nesting_rag_data";
				$data['design']['url']['design'] = $url_design = "nesting_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingRagDesignForm";
				
				//=========== OFFICE > CLIENT > PROCESS FILTER
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
										
				$_filterCond="";
				//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") 
				$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
				LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1'";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSqlall="Select id as client_id, shname from client where is_active='1'";	
				$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
								
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" WHERE id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				//============ FORM URL DATA
				$data['hide_normal'] = "off";
				$url_batch_id = "";
				$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
				if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
				$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
				if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
				$data['url_batch_id'] = $url_batch_id;
				
					
				$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
					(SELECT name from process y where y.id = b.process_id) as process_name,
					(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
					(SELECT shname from client c where c.id = b.client_id) as client_name 
					from training_batch as b WHERE b.id = '$url_batch_id'";
				$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
				// CHECK ANY PREVIOUS DESIGN
				$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
				$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
				if($pv_rag != ""){
					$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
					$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
				}
				
				// GET DESIGN DATA
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp WHERE is_active=1 AND trn_batch_id = '$url_batch_id' $_filterCond";
				$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
				
				$pmkpiarray=array();
				foreach($design_row as $row):
					$mp_id= $row['mp_id'];
					$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
				
				$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
				
				//loading training javascript
				//$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
			}
			
		}
	
	
	   public function addBatchNestingRagDesign()
		{
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_rag_design";
				$data['design']['name'] = $design_name = "Nesting Rag";
				$data['design']['kpi'] = $design_kpi = "training_nesting_rag_kpi";
				$data['design']['data'] = $design_data = "training_nesting_rag_data";
				$data['design']['url']['design'] = $url_design = "nesting_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingRagDesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				
				$batch_id    = trim($this->input->post('trn_batch_id'));
				$office_id    = trim($this->input->post('office_id'));
				$client_id    = trim($this->input->post('client_id'));
				$process_id   = trim($this->input->post('process_id'));
				$description  = trim($this->input->post('description'));
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
				$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				if($uploadcheck != "")
				{
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
					
				} else {
					
					$field_array = array(
						"trn_batch_id" => $batch_id,
						"office_id"    => $office_id,
						"client_id"    => $client_id,
						"process_id"   => $process_id,
						"description"  => $description,
						"added_by"     => $current_user,
						"is_active"    => '1',
						"added_date"   => $curDateTime,
						"uplog"        => $log
					);
					
					$did = data_inserter($design_table,$field_array);
					
					foreach($kpi_name_arr as $index => $kpi_name){
						if($kpi_name<>""){
							$field_array = array(
								"did" => $did,
								"kpi_name"    => $kpi_name,
								"kpi_type"    => $kpi_type_arr[$index],
								"kpi_weightage" => $kpi_weightage_arr[$index],
								"isdel"       => '0',
								"added_by"    => $current_user,
								"added_date"  => $curDateTime,
								"uplog"       => $log
							);
							data_inserter($design_kpi,$field_array);
						}
					}
				
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
				}
				
		   }        
	   }
		
		
		public function getTrainingNestingRagDesignForm(){
		
			if(check_logged_in())
			{				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_rag_design";
				$data['design']['name'] = $design_name = "Nesting Rag";
				$data['design']['kpi'] = $design_kpi = "training_nesting_rag_kpi";
				$data['design']['data'] = $design_data = "training_nesting_rag_data";
				$data['design']['url']['design'] = $url_design = "nesting_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingRagDesignForm";
				
				$mdid = trim($this->input->post('mdid'));
				$mdid=addslashes($mdid);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
					
				//$qSql="select * from pm_design where id = $mdid";
				//$design_row=$this->Common_model->get_query_row_array($qSql);
				
				$qSql="SELECT * from $design_kpi where did = $mdid";
				$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
				
				/////////
				$html = "";
				
				$TotRow = count($design_kpi_arr);
				$cnt=1; $countr = 0; $countrag = count($design_kpi_arr);
				
				foreach($design_kpi_arr as $kpiRow) {
				$countr++;
				if($countr < $countrag){
			
					$html .= "<div class='col-md-12 kpi_input_row'>";					
					$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
					$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
     				$html .= "<div class='col-md-3'><select class='form-control' name='kpi_type[]' > ";
					
					foreach($kpi_type_list as $kpimas){						
						$sCss="";
						if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
						$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
					}
									
					$html .= "</select></div>";
					
					$html .= "<div class='col-md-2'><input type='text' value='". $kpiRow['kpi_weightage'] ."' onkeyup=\"this.value=this.value.replace(/[^\d]/,'')\" class='form-control' name='kpi_weightage[]'></div>";
					
					$html .= "<div class='col-md-2'>";						
						if( $cnt++<$TotRow-1){							
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
						}else{
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
						}
									
					$html .= "</div>";
				    $html .= "</div>";
				}
				}	
						
				echo $html;
			}
		}

	
	   public function updateTrainingNestingRagDesign()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_nesting_rag_design";
				$data['design']['name'] = $design_name = "Nesting Rag";
				$data['design']['kpi'] = $design_kpi = "training_nesting_rag_kpi";
				$data['design']['data'] = $design_data = "training_nesting_rag_data";
				$data['design']['url']['design'] = $url_design = "nesting_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingRagDesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				$mdid = trim($this->input->post('mdid'));
				
				$batch_id  = trim($this->input->post('batch_id'));
				$office_id  = trim($this->input->post('office_id'));
				$client_id  = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$description = trim($this->input->post('description'));
				
				$kpi_id_arr   = $this->input->post('kpi_id');
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$field_array = array(
					"office_id"   => $office_id,
					"client_id"   => $client_id,
					"process_id"  => $process_id,
					"description" => $description,
					"added_by"    => $current_user,
					"is_active"   => '1',
					"added_date"  => $curDateTime,
					"uplog"       => $log
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				$TotID = count($kpi_id_arr);
				
				// DELETE DESIGN
				$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
				$query = $this->db->query($sql);
				
				foreach($kpi_name_arr as $index => $kpi_name)
				{
					if($kpi_name != "")
					{						
						$field_array = array(
							"did"         => $mdid,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"kpi_weightage"  => $kpi_weightage_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => curDateTime,
							"uplog"       => $log
						);
						
						data_inserter($design_kpi, $field_array);						
					}
				}
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
	   }

	   		
	public function downloadTrainingNestingRagHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_nesting_rag_design";
		$data['design']['name'] = $design_name = "Nesting Rag";
		$data['design']['kpi'] = $design_kpi = "training_nesting_rag_kpi";
		$data['design']['data'] = $design_data = "training_nesting_rag_data";
		$data['design']['url']['design'] = $url_design = "nesting_rag_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingRagDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingRagDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingRagDesignForm";
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id from training_batch tb 
			        LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_batch_status = '1' and trn_type=3 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$pm_batch_rowb['id']."'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
 		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,trn_batch_id, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		$batchid = $pm_design_row['trn_batch_id'];
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		$letters = array(); 
		$k=0;
		for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle($sht_title);
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		if(!empty($batchid)){
			$slNo = 0; $r=2;
			$qSql = "Select s.*, d.user_id, CONCAT(s.fname, ' ', s.lname) as fullname from training_details as d INNER JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batchid'";
			$querySql=$this->Common_model->get_query_result_array($qSql);
			foreach($querySql as $rowD):
				$slNo++; $r++; $j=0; 
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fullname']);			
			endforeach;
		}
		
		$j=3; $r=2; $currentcellvalue = ord('C');
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
			$currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'] .' ('.$row['kpi_weightage'] .'%)';
			if(strtolower(trim($row['kpi_name'])) == "status"){
			$getkpiname = "Status (Red/Amber/Green)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		$objWriter->save('php://output');
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	public function uploadNestingRagResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/training_nesting/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_Nesting_Rag_file($fileName,$batch_id);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_Nesting_Rag_file($fileName,$batch_id);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	private function Import_Nesting_Rag_file($file_name,$batch_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/training_nesting/'.$file_name;
		
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_nesting_rag_design";
		$data['design']['name'] = $design_name = "Nesting Rag";
		$data['design']['kpi'] = $design_kpi = "training_nesting_rag_kpi";
		$data['design']['data'] = $design_data = "training_nesting_rag_data";
		$data['design']['url']['design'] = $url_design = "nesting_rag_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingRagDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingRagDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingRagDesignForm";
		
		
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
				
		// GET RAG DID FROM BATCH
		$qSqlb="SELECT tb.*,
				c.shname as client_name, 
				p.name as process_name, 
				CONCAT(fname,' ' ,lname) as trainer_name, 
				office_id, batch_office_id from training_batch tb 
				LEFT JOIN client c ON  c.id=tb.client_id 
				LEFT JOIN process p ON  p.id=tb.process_id 
				LEFT JOIN signin ON  signin.id=tb.trainer_id  
				where trn_batch_status = '1' and trn_type=3 AND tb.id = '$batch_id'";
		
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$batch_id."'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		$pmdid = $pm_batch_rowb['id'];
			
		
		// GET KPI DETAILS
		$qSql = "Select * from $design_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET RAG DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}
		
		//echo "hi";
		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ntdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"ntdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update($design_data,$field_array);
					
					
				} else {
					
					data_inserter($design_data,$field_array);
				
				}
			
				//print_r($field_array);die();$_run = false;					
				
			}	
			}		
			
		}
		
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		
	}
	
		
	public function getFormatDesignNesting_Rag()
	{
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_nesting_rag_design";
		$data['design']['name'] = $design_name = "Nesting Rag";
		$data['design']['kpi'] = $design_kpi = "training_nesting_rag_kpi";
		$data['design']['data'] = $design_data = "training_nesting_rag_data";
		$data['design']['url']['design'] = $url_design = "nesting_rag_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchNestingRagDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingNestingRagDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingNestingRagDesignForm";
		
		$batchid = trim($this->input->get('batchid'));
		
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$batchid."'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		
		$pmdid = $pm_batch_rowb['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}
	
	

#####===================================== Recursive RAG ====================================###############	
	
	public function recursive_rag(){
			
			if(check_logged_in())
			{
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_rag_design";
				$data['design']['name'] = $design_name = "Recursive Rag";
				$data['design']['kpi'] = $design_kpi = "training_recursive_rag_kpi";
				$data['design']['data'] = $design_data = "training_recursive_rag_data";
				$data['design']['url']['design'] = $url_design = "recursive_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchRecursiveRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingRecursiveRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingRecursiveRagDesignForm";
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' and is_incubation <> '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/recursive_rag_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and (batch_office_id = '$oValue') ";
						$filterCond2 = " and (location_id='$oValue') ";
				}
				
				
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				
				
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
					
					$qSql="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_type=4 $filterCond $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="Select tb.*, c.shname as client_name , p.name as process_name, batch_office_id, batch_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trainer_id='$current_user' and trn_type=4 $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_type=4 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$data['checkupload'][$batch_id] = '0';
					
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ntdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ntdid = '$ragdid' AND kpi_id = '$kpiid'";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							$jcheck++;
						}
					}
					
					
					$i++;
				}
				
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
				
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}

			
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}

		public function recursive_rag_design(){
			
			if(check_logged_in())
			{
				$current_user     = get_user_id();
				$user_site_id     = get_user_site_id();
				$user_office_id   = get_user_office_id();
				$user_oth_office  = get_user_oth_office();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$role_dir         = get_role_dir();
				$role_id          = get_role_id();
				$get_dept_id      = get_dept_id();
				
				$data["aside_template"]   = "training/aside.php";
				$data["content_template"] = "training/recursive_rag_design.php";
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_rag_design";
				$data['design']['name'] = $design_name = "Recursive Rag";
				$data['design']['kpi'] = $design_kpi = "training_recursive_rag_kpi";
				$data['design']['data'] = $design_data = "training_recursive_rag_data";
				$data['design']['url']['design'] = $url_design = "recursive_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchRecursiveRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingRecursiveRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingRecursiveRagDesignForm";
				
				//=========== OFFICE > CLIENT > PROCESS FILTER
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
										
				$_filterCond="";
				//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") 
				$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
				LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1'";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSqlall="Select id as client_id, shname from client where is_active='1'";	
				$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
								
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" WHERE id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				//============ FORM URL DATA
				$data['hide_normal'] = "off";
				$url_batch_id = "";
				$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
				if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
				$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
				if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
				$data['url_batch_id'] = $url_batch_id;
				
					
				$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
					(SELECT name from process y where y.id = b.process_id) as process_name,
					(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
					(SELECT shname from client c where c.id = b.client_id) as client_name 
					from training_batch as b WHERE b.id = '$url_batch_id'";
				$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
				// CHECK ANY PREVIOUS DESIGN
				$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
				$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
				if($pv_rag != ""){
					$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
					$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
				}
				
				// GET DESIGN DATA
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp WHERE is_active=1 AND trn_batch_id = '$url_batch_id' $_filterCond";
				$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
				
				$pmkpiarray=array();
				foreach($design_row as $row):
					$mp_id= $row['mp_id'];
					$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
				
				$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
				
				//loading training javascript
				//$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
			}
			
		}
	
	
	   public function addBatchRecursiveRagDesign()
		{
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_rag_design";
				$data['design']['name'] = $design_name = "Recursive Rag";
				$data['design']['kpi'] = $design_kpi = "training_recursive_rag_kpi";
				$data['design']['data'] = $design_data = "training_recursive_rag_data";
				$data['design']['url']['design'] = $url_design = "recursive_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchRecursiveRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingRecursiveRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingRecursiveRagDesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				
				$batch_id    = trim($this->input->post('trn_batch_id'));
				$office_id    = trim($this->input->post('office_id'));
				$client_id    = trim($this->input->post('client_id'));
				$process_id   = trim($this->input->post('process_id'));
				$description  = trim($this->input->post('description'));
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
				$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				if($uploadcheck != "")
				{
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
					
				} else {
					
					$field_array = array(
						"trn_batch_id" => $batch_id,
						"office_id"    => $office_id,
						"client_id"    => $client_id,
						"process_id"   => $process_id,
						"description"  => $description,
						"added_by"     => $current_user,
						"is_active"    => '1',
						"added_date"   => $curDateTime,
						"uplog"        => $log
					);
					
					$did = data_inserter($design_table,$field_array);
					
					foreach($kpi_name_arr as $index => $kpi_name){
						if($kpi_name<>""){
							$field_array = array(
								"did" => $did,
								"kpi_name"    => $kpi_name,
								"kpi_type"    => $kpi_type_arr[$index],
								"kpi_weightage" => $kpi_weightage_arr[$index],
								"isdel"       => '0',
								"added_by"    => $current_user,
								"added_date"  => $curDateTime,
								"uplog"       => $log
							);
							data_inserter($design_kpi,$field_array);
						}
					}
				
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
				}
				
		   }        
	   }
		
		
		public function getTrainingRecursiveRagDesignForm(){
		
			if(check_logged_in())
			{				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_rag_design";
				$data['design']['name'] = $design_name = "Recursive Rag";
				$data['design']['kpi'] = $design_kpi = "training_recursive_rag_kpi";
				$data['design']['data'] = $design_data = "training_recursive_rag_data";
				$data['design']['url']['design'] = $url_design = "recursive_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchRecursiveRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingRecursiveRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingRecursiveRagDesignForm";
				
				$mdid = trim($this->input->post('mdid'));
				$mdid=addslashes($mdid);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
					
				//$qSql="select * from pm_design where id = $mdid";
				//$design_row=$this->Common_model->get_query_row_array($qSql);
				
				$qSql="SELECT * from $design_kpi where did = $mdid";
				$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
				
				/////////
				$html = "";
				
				$TotRow = count($design_kpi_arr);
				$cnt=1; $countr = 0; $countrag = count($design_kpi_arr);
				
				foreach($design_kpi_arr as $kpiRow) {
				$countr++;
				if($countr < $countrag){
			
					$html .= "<div class='col-md-12 kpi_input_row'>";					
					$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
					$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
     				$html .= "<div class='col-md-3'><select class='form-control' name='kpi_type[]' > ";
					
					foreach($kpi_type_list as $kpimas){						
						$sCss="";
						if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
						$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
					}
									
					$html .= "</select></div>";
					
					$html .= "<div class='col-md-2'><input type='text' value='". $kpiRow['kpi_weightage'] ."' onkeyup=\"this.value=this.value.replace(/[^\d]/,'')\" class='form-control' name='kpi_weightage[]'></div>";
					
					$html .= "<div class='col-md-2'>";						
						if( $cnt++<$TotRow-1){							
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
						}else{
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
						}
									
					$html .= "</div>";
				    $html .= "</div>";
				}
				}	
						
				echo $html;
			}
		}

	
	   public function updateTrainingRecursiveRagDesign()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_rag_design";
				$data['design']['name'] = $design_name = "Recursive Rag";
				$data['design']['kpi'] = $design_kpi = "training_recursive_rag_kpi";
				$data['design']['data'] = $design_data = "training_recursive_rag_data";
				$data['design']['url']['design'] = $url_design = "recursive_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchRecursiveRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingRecursiveRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingRecursiveRagDesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				$mdid = trim($this->input->post('mdid'));
				
				$batch_id  = trim($this->input->post('batch_id'));
				$office_id  = trim($this->input->post('office_id'));
				$client_id  = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$description = trim($this->input->post('description'));
				
				$kpi_id_arr   = $this->input->post('kpi_id');
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$field_array = array(
					"office_id"   => $office_id,
					"client_id"   => $client_id,
					"process_id"  => $process_id,
					"description" => $description,
					"added_by"    => $current_user,
					"is_active"   => '1',
					"added_date"  => $curDateTime,
					"uplog"       => $log
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				$TotID = count($kpi_id_arr);
				
				// DELETE DESIGN
				$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
				$query = $this->db->query($sql);
				
				foreach($kpi_name_arr as $index => $kpi_name)
				{
					if($kpi_name != "")
					{						
						$field_array = array(
							"did"         => $mdid,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"kpi_weightage"  => $kpi_weightage_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => curDateTime,
							"uplog"       => $log
						);
						
						data_inserter($design_kpi, $field_array);						
					}
				}
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
	   }

	   		
	public function downloadTrainingRecursiveRagHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_rag_design";
		$data['design']['name'] = $design_name = "Recursive Rag";
		$data['design']['kpi'] = $design_kpi = "training_recursive_rag_kpi";
		$data['design']['data'] = $design_data = "training_recursive_rag_data";
		$data['design']['url']['design'] = $url_design = "recursive_rag_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchRecursiveRagDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingRecursiveRagDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingRecursiveRagDesignForm";
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id from training_batch tb 
			        LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$pm_batch_rowb['id']."'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
 		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,trn_batch_id, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		$batchid = $pm_design_row['trn_batch_id'];
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		$letters = array(); 
		$k=0;
		for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle($sht_title);
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		if(!empty($batchid)){
			$slNo = 0; $r=2;
			$qSql = "Select s.*, d.user_id, CONCAT(s.fname, ' ', s.lname) as fullname from training_details as d INNER JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batchid'";
			$querySql=$this->Common_model->get_query_result_array($qSql);
			foreach($querySql as $rowD):
				$slNo++; $r++; $j=0; 
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fullname']);			
			endforeach;
		}
		
		$j=3; $r=2; $currentcellvalue = ord('C');
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
			$currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'] .' ('.$row['kpi_weightage'] .'%)';
			if(strtolower(trim($row['kpi_name'])) == "status"){
			$getkpiname = "Status (Red/Amber/Green)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		$objWriter->save('php://output');
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	public function uploadRecursiveRagResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/training_nesting/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_Recursive_Rag_file($fileName,$batch_id);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_Recursive_Rag_file($fileName,$batch_id);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	private function Import_Recursive_Rag_file($file_name,$batch_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/training_nesting/'.$file_name;
		
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_rag_design";
		$data['design']['name'] = $design_name = "Recursive Rag";
		$data['design']['kpi'] = $design_kpi = "training_recursive_rag_kpi";
		$data['design']['data'] = $design_data = "training_recursive_rag_data";
		$data['design']['url']['design'] = $url_design = "recursive_rag_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchRecursiveRagDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingRecursiveRagDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingRecursiveRagDesignForm";
		
		
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
				
		// GET RAG DID FROM BATCH
		$qSqlb="SELECT tb.*,
				c.shname as client_name, 
				p.name as process_name, 
				CONCAT(fname,' ' ,lname) as trainer_name, 
				office_id, batch_office_id from training_batch tb 
				LEFT JOIN client c ON  c.id=tb.client_id 
				LEFT JOIN process p ON  p.id=tb.process_id 
				LEFT JOIN signin ON  signin.id=tb.trainer_id  
				where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batch_id'";
		
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$batch_id."'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		$pmdid = $pm_batch_rowb['id'];
			
		
		// GET KPI DETAILS
		$qSql = "Select * from $design_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET RAG DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}
		
		//echo "hi";
		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ntdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"ntdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update($design_data,$field_array);
					
					
				} else {
					
					data_inserter($design_data,$field_array);
				
				}
			
				//print_r($field_array);die();$_run = false;					
				
			}	
			}		
			
		}
		
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		
	}
	
		
	public function getFormatDesignRecursive_Rag()
	{
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_rag_design";
		$data['design']['name'] = $design_name = "Recursive Rag";
		$data['design']['kpi'] = $design_kpi = "training_recursive_rag_kpi";
		$data['design']['data'] = $design_data = "training_recursive_rag_data";
		$data['design']['url']['design'] = $url_design = "recursive_rag_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchRecursiveRagDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingRecursiveRagDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingRecursiveRagDesignForm";
		
		$batchid = trim($this->input->get('batchid'));
		
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$batchid."'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		
		$pmdid = $pm_batch_rowb['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}
	
	
		
	
	
	

#####===================================== Upskill RAG ====================================###############	
	
	public function upskill_rag(){
			
			if(check_logged_in())
			{
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_rag_design";
				$data['design']['name'] = $design_name = "Upskill Rag";
				$data['design']['kpi'] = $design_kpi = "training_upskill_rag_kpi";
				$data['design']['data'] = $design_data = "training_upskill_rag_data";
				$data['design']['url']['design'] = $url_design = "upskill_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchUpskillRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingUpskillRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingUpskillRagDesignForm";
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' and is_incubation <> '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/upskill_rag_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and (batch_office_id = '$oValue') ";
						$filterCond2 = " and (location_id='$oValue') ";
				}
				
				
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
					
					$qSql="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_type=5 $filterCond $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="Select tb.*, c.shname as client_name , p.name as process_name, batch_office_id, batch_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trainer_id='$current_user' and trn_type=5 $filterCond4 $filterCond3 order by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_type=5 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$data['checkupload'][$batch_id] = '0';
					
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ntdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ntdid = '$ragdid' AND kpi_id = '$kpiid'";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							$jcheck++;
						}
					}
					
					
					$i++;
				}
				
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
				
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}

		public function upskill_rag_design(){
			
			if(check_logged_in())
			{
				$current_user     = get_user_id();
				$user_site_id     = get_user_site_id();
				$user_office_id   = get_user_office_id();
				$user_oth_office  = get_user_oth_office();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$role_dir         = get_role_dir();
				$role_id          = get_role_id();
				$get_dept_id      = get_dept_id();
				
				$data["aside_template"]   = "training/aside.php";
				$data["content_template"] = "training/upskill_rag_design.php";
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_rag_design";
				$data['design']['name'] = $design_name = "Upskill Rag";
				$data['design']['kpi'] = $design_kpi = "training_upskill_rag_kpi";
				$data['design']['data'] = $design_data = "training_upskill_rag_data";
				$data['design']['url']['design'] = $url_design = "upskill_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchUpskillRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingUpskillRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingUpskillRagDesignForm";
				
				//=========== OFFICE > CLIENT > PROCESS FILTER
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
										
				$_filterCond="";
				//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") 
				$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
				LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1'";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSqlall="Select id as client_id, shname from client where is_active='1'";	
				$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
								
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" WHERE id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				//============ FORM URL DATA
				$data['hide_normal'] = "off";
				$url_batch_id = "";
				$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
				if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
				$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
				if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
				$data['url_batch_id'] = $url_batch_id;
				
					
				$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
					(SELECT name from process y where y.id = b.process_id) as process_name,
					(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
					(SELECT shname from client c where c.id = b.client_id) as client_name 
					from training_batch as b WHERE b.id = '$url_batch_id'";
				$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
				// CHECK ANY PREVIOUS DESIGN
				$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
				$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
				if($pv_rag != ""){
					$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
					$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
				}
				
				// GET DESIGN DATA
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp WHERE is_active=1 AND trn_batch_id = '$url_batch_id' $_filterCond";
				$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
				
				$pmkpiarray=array();
				foreach($design_row as $row):
					$mp_id= $row['mp_id'];
					$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
				
				$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
				
				//loading training javascript
				//$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
			}
			
		}
	
	
	   public function addBatchUpskillRagDesign()
		{
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_rag_design";
				$data['design']['name'] = $design_name = "Upskill Rag";
				$data['design']['kpi'] = $design_kpi = "training_upskill_rag_kpi";
				$data['design']['data'] = $design_data = "training_upskill_rag_data";
				$data['design']['url']['design'] = $url_design = "upskill_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchUpskillRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingUpskillRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingUpskillRagDesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				
				$batch_id    = trim($this->input->post('trn_batch_id'));
				$office_id    = trim($this->input->post('office_id'));
				$client_id    = trim($this->input->post('client_id'));
				$process_id   = trim($this->input->post('process_id'));
				$description  = trim($this->input->post('description'));
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
				$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				if($uploadcheck != "")
				{
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
					
				} else {
					
					$field_array = array(
						"trn_batch_id" => $batch_id,
						"office_id"    => $office_id,
						"client_id"    => $client_id,
						"process_id"   => $process_id,
						"description"  => $description,
						"added_by"     => $current_user,
						"is_active"    => '1',
						"added_date"   => $curDateTime,
						"uplog"        => $log
					);
					
					$did = data_inserter($design_table,$field_array);
					
					foreach($kpi_name_arr as $index => $kpi_name){
						if($kpi_name<>""){
							$field_array = array(
								"did" => $did,
								"kpi_name"    => $kpi_name,
								"kpi_type"    => $kpi_type_arr[$index],
								"kpi_weightage" => $kpi_weightage_arr[$index],
								"isdel"       => '0',
								"added_by"    => $current_user,
								"added_date"  => $curDateTime,
								"uplog"       => $log
							);
							data_inserter($design_kpi,$field_array);
						}
					}
				
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
				}
				
		   }        
	   }
		
		
		public function getTrainingUpskillRagDesignForm(){
		
			if(check_logged_in())
			{				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_rag_design";
				$data['design']['name'] = $design_name = "Upskill Rag";
				$data['design']['kpi'] = $design_kpi = "training_upskill_rag_kpi";
				$data['design']['data'] = $design_data = "training_upskill_rag_data";
				$data['design']['url']['design'] = $url_design = "upskill_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchUpskillRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingUpskillRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingUpskillRagDesignForm";
				
				$mdid = trim($this->input->post('mdid'));
				$mdid=addslashes($mdid);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
					
				//$qSql="select * from pm_design where id = $mdid";
				//$design_row=$this->Common_model->get_query_row_array($qSql);
				
				$qSql="SELECT * from $design_kpi where did = $mdid";
				$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
				
				/////////
				$html = "";
				
				$TotRow = count($design_kpi_arr);
				$cnt=1; $countr = 0; $countrag = count($design_kpi_arr);
				
				foreach($design_kpi_arr as $kpiRow) {
				$countr++;
				if($countr < $countrag){
			
					$html .= "<div class='col-md-12 kpi_input_row'>";					
					$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
					$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
     				$html .= "<div class='col-md-3'><select class='form-control' name='kpi_type[]' > ";
					
					foreach($kpi_type_list as $kpimas){						
						$sCss="";
						if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
						$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
					}
									
					$html .= "</select></div>";
					
					$html .= "<div class='col-md-2'><input type='text' value='". $kpiRow['kpi_weightage'] ."' onkeyup=\"this.value=this.value.replace(/[^\d]/,'')\" class='form-control' name='kpi_weightage[]'></div>";
					
					$html .= "<div class='col-md-2'>";						
						if( $cnt++<$TotRow-1){							
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
						}else{
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
						}
									
					$html .= "</div>";
				    $html .= "</div>";
				}
				}	
						
				echo $html;
			}
		}

	
	   public function updateTrainingUpskillRagDesign()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_rag_design";
				$data['design']['name'] = $design_name = "Upskill Rag";
				$data['design']['kpi'] = $design_kpi = "training_upskill_rag_kpi";
				$data['design']['data'] = $design_data = "training_upskill_rag_data";
				$data['design']['url']['design'] = $url_design = "upskill_rag_design";
				$data['design']['url']['add_design'] = $url_add_design = "addBatchUpskillRagDesign";
				$data['design']['url']['update_design'] = $url_update_design = "updateTrainingUpskillRagDesign";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingUpskillRagDesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				$mdid = trim($this->input->post('mdid'));
				
				$batch_id  = trim($this->input->post('batch_id'));
				$office_id  = trim($this->input->post('office_id'));
				$client_id  = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$description = trim($this->input->post('description'));
				
				$kpi_id_arr   = $this->input->post('kpi_id');
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$field_array = array(
					"office_id"   => $office_id,
					"client_id"   => $client_id,
					"process_id"  => $process_id,
					"description" => $description,
					"added_by"    => $current_user,
					"is_active"   => '1',
					"added_date"  => $curDateTime,
					"uplog"       => $log
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				$TotID = count($kpi_id_arr);
				
				// DELETE DESIGN
				$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
				$query = $this->db->query($sql);
				
				foreach($kpi_name_arr as $index => $kpi_name)
				{
					if($kpi_name != "")
					{						
						$field_array = array(
							"did"         => $mdid,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"kpi_weightage"  => $kpi_weightage_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => curDateTime,
							"uplog"       => $log
						);
						
						data_inserter($design_kpi, $field_array);						
					}
				}
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
	   }

	   		
	public function downloadTrainingUpskillRagHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_rag_design";
		$data['design']['name'] = $design_name = "Upskill Rag";
		$data['design']['kpi'] = $design_kpi = "training_upskill_rag_kpi";
		$data['design']['data'] = $design_data = "training_upskill_rag_data";
		$data['design']['url']['design'] = $url_design = "upskill_rag_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchUpskillRagDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingUpskillRagDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingUpskillRagDesignForm";
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id from training_batch tb 
			        LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$pm_batch_rowb['id']."'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
 		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, trn_batch_id, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		$batchid = $pm_design_row['trn_batch_id'];
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		$letters = array(); 
		$k=0;
		for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle($sht_title);
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		if(!empty($batchid)){
			$slNo = 0; $r=2;
			$qSql = "Select s.*, d.user_id, CONCAT(s.fname, ' ', s.lname) as fullname from training_details as d INNER JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batchid'";
			$querySql=$this->Common_model->get_query_result_array($qSql);
			foreach($querySql as $rowD):
				$slNo++; $r++; $j=0; 
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fullname']);			
			endforeach;
		}
		
		$j=3; $r=2; $currentcellvalue = ord('C');
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
			$currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'] .' ('.$row['kpi_weightage'] .'%)';
			if(strtolower(trim($row['kpi_name'])) == "status"){
			$getkpiname = "Status (Red/Amber/Green)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		$objWriter->save('php://output');
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	public function uploadUpskillRagResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/training_nesting/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_Upskill_Rag_file($fileName,$batch_id);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_Upskill_Rag_file($fileName,$batch_id);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	private function Import_Upskill_Rag_file($file_name,$batch_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/training_nesting/'.$file_name;
		
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_rag_design";
		$data['design']['name'] = $design_name = "Upskill Rag";
		$data['design']['kpi'] = $design_kpi = "training_upskill_rag_kpi";
		$data['design']['data'] = $design_data = "training_upskill_rag_data";
		$data['design']['url']['design'] = $url_design = "upskill_rag_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchUpskillRagDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingUpskillRagDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingUpskillRagDesignForm";
		
		
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
				
		// GET RAG DID FROM BATCH
		$qSqlb="SELECT tb.*,
				c.shname as client_name, 
				p.name as process_name, 
				CONCAT(fname,' ' ,lname) as trainer_name, 
				office_id, batch_office_id from training_batch tb 
				LEFT JOIN client c ON  c.id=tb.client_id 
				LEFT JOIN process p ON  p.id=tb.process_id 
				LEFT JOIN signin ON  signin.id=tb.trainer_id  
				where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batch_id'";
		
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$batch_id."'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		$pmdid = $pm_batch_rowb['id'];
			
		
		// GET KPI DETAILS
		$qSql = "Select * from $design_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET RAG DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}
		
		//echo "hi";
		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ntdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"ntdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update($design_data,$field_array);
					
					
				} else {
					
					data_inserter($design_data,$field_array);
				
				}
			
				//print_r($field_array);die();$_run = false;					
				
			}	
			}		
			
		}
		
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		
	}
	
		
	public function getFormatDesignUpskill_Rag()
	{
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_rag_design";
		$data['design']['name'] = $design_name = "Upskill Rag";
		$data['design']['kpi'] = $design_kpi = "training_upskill_rag_kpi";
		$data['design']['data'] = $design_data = "training_upskill_rag_data";
		$data['design']['url']['design'] = $url_design = "upskill_rag_design";
		$data['design']['url']['add_design'] = $url_add_design = "addBatchUpskillRagDesign";
		$data['design']['url']['update_design'] = $url_update_design = "updateTrainingUpskillRagDesign";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "getTrainingUpskillRagDesignForm";
		
		$batchid = trim($this->input->get('batchid'));
		
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '".$batchid."'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		
		$pmdid = $pm_batch_rowb['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	



//////////////////////////// EXTRA TRAINING STARTS /////////////////////////////////////////////////	

	function move_batch_user()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$initial_batch_id = trim($this->input->post('initial_batch_id'));
			$move_to_batch_id = trim($this->input->post('move_to_batch_id'));
			$userCheckBox = $this->input->post('userCheckBox');
			$countcheckbox = count($userCheckBox);
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $userCheckBox[$i];
				$sqlq = "UPDATE training_details SET trn_batch_id = '$move_to_batch_id' WHERE user_id = '$getuserid' AND trn_batch_id = '$initial_batch_id'";
				$queryq = $this->db->query($sqlq);
			}
			redirect(base_url()."training/crt_batch","refresh");
		}		
	}
	
	
	function split_batch_user()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$curDateTime   = CurrMySqlDate();
			$log = get_logs();
		
			$split_initial_batch_id = trim($this->input->post('split_initial_batch_id'));
			$split_select_trainer_id = trim($this->input->post('split_select_trainer_id'));
			$split_initial_batch_name = trim($this->input->post('split_initial_batch_name'));
			$userSplitCheckBox = $this->input->post('userSplitCheckBox');
			$countcheckbox = count($userSplitCheckBox);
			
			if($countcheckbox > 0){
				
			//COPY DATA FROM BATCH TO NEW BATCH ID
			$sqlbatchcopy = "INSERT into training_batch (trainer_id, trn_start_date, trn_type, ref_type, ref_id, client_id, process_id, trn_batch, trn_comment, trn_batch_status, batch_name, batch_office_id, hr_handover_by, hr_handover_date, log)
			SELECT '".$split_select_trainer_id."', trn_start_date, trn_type, ref_type, ref_id, client_id, process_id, trn_batch, trn_comment, trn_batch_status, '".$split_initial_batch_name."', batch_office_id, hr_handover_by, hr_handover_date, log from training_batch
			where id = '$split_initial_batch_id'";
			$this->db->query($sqlbatchcopy);
			$lastinsert_id = $this->db->insert_id();
						
			}
			
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $userSplitCheckBox[$i];
				$sqlq = "UPDATE training_details SET trn_batch_id = '$lastinsert_id' WHERE user_id = '$getuserid' AND trn_batch_id = '$split_initial_batch_id'";
				$queryq = $this->db->query($sqlq);
			}
			
			redirect(base_url()."training/crt_batch","refresh");
		}		
	}
	
	
		
	
	/*======================== ADD NEW TRAINEE ================================*/
	public function addnewtraineebatch(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			$log = get_logs();
			
			$batch_id = $this->input->post('add_trainee_batch_id');
			$checkUser = $this->input->post('traineeNewCheckBox');
			$countcheckbox = count($checkUser);
			
			$sqlc = "SELECT trainer_id, process_id, client_id from training_batch WHERE id = '$batch_id'";
			$queryc = $this->Common_model->get_query_row_array($sqlc);
			
			$t_process_id = $queryc['process_id'];
			$t_client_id = $queryc['client_id'];
			$t_trainer_id = $queryc['trainer_id'];
			
			
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $checkUser[$i];
				
				//-- ADD TO TRAINING DETAILS
				$insert_array = array(
									"trn_batch_id" => $batch_id,
									"user_id" => $getuserid,
									"trn_note" => 'Manually Added',
									"trn_status" => '2',
									"is_certify" => '0',
									"log" => $log
								);
				data_inserter('training_details', $insert_array);
				
				//-- UPDATE SIGNIN
				$update_array = array(
									"phase" => '2',
									"assigned_to" => $t_trainer_id
								);
				$this->db->where('id', $getuserid);
				$this->db->update('signin', $update_array);
				
				//-- GET PREVIOUS LOGS
				$qSql = "SELECT log from signin WHERE id = '$getuserid'";
				$prevLog = getDBPrevLogs($qSql);
				$log = "Update Trainign Batch :: ". get_logs($prevLog);
				
				//-- UPDATE CLIENT
				$this->db->query('DELETE FROM info_assign_client WHERE user_id = "'.$getuserid.'"');	
				$field_array2 = array(
					"user_id" => $getuserid,
					"client_id" => $t_client_id,
					"log" => $log
				);
				$rowid= data_inserter('info_assign_client',$field_array2);
				
				//-- UPDATE PROCESS
				$this->db->query('DELETE FROM info_assign_process WHERE user_id = "'.$getuserid.'"');
				$field_array3 = array(
					"user_id" => $getuserid,
					"process_id" => $t_process_id,
					"log" => $log
				);
				$rowid= data_inserter('info_assign_process',$field_array3);
				
			}
			
			redirect(base_url()."training/crt_batch","refresh");
			
		}
	}
	
	
	
	public function fetchBatchlist(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$qSql = "Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type=2 order by tb.id desc";
			$querySql = $this->Common_model->get_query_result_array($qSql);
			echo json_encode($querySql);
			
		}
	}


	public function fetchBatchUsers(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$batch_id= trim($this->input->post('batchid'));
			if($batch_id != ""){
				$candidatedata = candidate_details($batch_id);
			}
			echo json_encode($candidatedata);
			
		}
	}

	
	public function fetchBatchTraineeList(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$batch_id= trim($this->input->post('batchid'));
			
			$otherOffice = get_user_oth_office();
			$extraOfficeFilterOth = "";
			if(!empty($otherOffice)){
				$otherOfficeCheck = implode("','",explode(',', $otherOffice));
				$extraOfficeFilterOth = " OR s.office_id IN ('$otherOfficeCheck')";
			}
			
			if($batch_id != ""){
			$qSql = "SELECT CONCAT(s.fname,' ' ,s.lname) as trainee_name, s.office_id, s.fusion_id, s.id as user_id from signin as s 
			         WHERE s.id NOT IN (SELECT user_id from training_details WHERE trn_batch_id = '$batch_id') AND s.status IN (1,4) AND (s.office_id = '$user_office_id' $extraOfficeFilterOth) AND s.role_id IN (SELECT id from role WHERE folder = 'agent') ORDER by trainee_name";
			$querySql = $this->Common_model->get_query_result_array($qSql);
			}
			echo json_encode($querySql);
			
		}
	}




//////////////////////// TRAINING AUDIT DESIGN /////////////////////////////////////////


		public function audit_design()
		{
			if(check_logged_in())
			{
				$current_user     = get_user_id();
				$user_site_id     = get_user_site_id();
				$user_office_id   = get_user_office_id();
				$user_oth_office  = get_user_oth_office();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$role_dir         = get_role_dir();
				$role_id          = get_role_id();
				$get_dept_id      = get_dept_id();
				
				$data["aside_template"]   = "training/aside.php";
				$data["content_template"] = "training/training_audit_design.php";
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_audit_design";
				$data['design']['name'] = $design_name = "Audit";
				$data['design']['kpi'] = $design_kpi = "training_audit_kpi";
				$data['design']['data'] = $design_data = "training_audit_data";
				$data['design']['url']['design'] = $url_design = "audit_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_Audit_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_Audit_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_Audit_DesignForm";
				
				//=========== OFFICE > CLIENT > PROCESS FILTER
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
										
				$_filterCond="";
				//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") 
				$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
				LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1'";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSqlall="Select id as client_id, shname from client where is_active='1'";	
				$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
								
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" WHERE id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				//============ FORM URL DATA
				$data['hide_normal'] = "off";
				$url_batch_id = "";
				$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
				if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
				$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
				if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
				$data['url_batch_id'] = $url_batch_id;
				
					
				$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
					(SELECT name from process y where y.id = b.process_id) as process_name,
					(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
					(SELECT shname from client c where c.id = b.client_id) as client_name 
					from training_batch as b WHERE b.id = '$url_batch_id'";
				$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
				// CHECK ANY PREVIOUS DESIGN
				$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
				$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
				if($pv_rag != ""){
					$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
					$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
				}
				
				// GET DESIGN DATA
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp WHERE is_active=1 AND trn_batch_id = '$url_batch_id' $_filterCond";
				$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
				
				$pmkpiarray=array();
				foreach($design_row as $row):
					$mp_id= $row['mp_id'];
					$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
				
				$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
				
				//loading training javascript
				//$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
	
	   public function add_Audit_Design()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_audit_design";
				$data['design']['name'] = $design_name = "Audit";
				$data['design']['kpi'] = $design_kpi = "training_audit_kpi";
				$data['design']['data'] = $design_data = "training_audit_data";
				$data['design']['url']['design'] = $url_design = "audit_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_Audit_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_Audit_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_Audit_DesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				
				$batch_id    = trim($this->input->post('trn_batch_id'));
				$office_id    = trim($this->input->post('office_id'));
				$client_id    = trim($this->input->post('client_id'));
				$process_id   = trim($this->input->post('process_id'));
				$description  = trim($this->input->post('description'));
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				
				
				$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
				$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				if($uploadcheck != "")
				{
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
					
				} else {
					
					$field_array = array(
						"trn_batch_id" => $batch_id,
						"office_id"    => $office_id,
						"client_id"    => $client_id,
						"process_id"   => $process_id,
						"description"  => $description,
						"added_by"     => $current_user,
						"is_active"    => '1',
						"added_date"   => $curDateTime,
						"uplog"        => $log
					);
					
					$did = data_inserter($design_table,$field_array);
					
					foreach($kpi_name_arr as $index => $kpi_name){
						if($kpi_name<>""){
							$field_array = array(
								"did" => $did,
								"kpi_name"    => $kpi_name,
								"kpi_type"    => $kpi_type_arr[$index],
								"isdel"       => '0',
								"added_by"    => $current_user,
								"added_date"  => $curDateTime,
								"uplog"       => $log
							);
							data_inserter($design_kpi,$field_array);
						}
					}
				
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
				}
				
		   }         
	   }
		
		
		public function get_Audit_DesignForm()
		{
			if(check_logged_in())
			{				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_audit_design";
				$data['design']['name'] = $design_name = "Audit";
				$data['design']['kpi'] = $design_kpi = "training_audit_kpi";
				$data['design']['data'] = $design_data = "training_audit_data";
				$data['design']['url']['design'] = $url_design = "audit_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_Audit_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_Audit_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_Audit_DesignForm";
				
				$mdid = trim($this->input->post('mdid'));
				$mdid=addslashes($mdid);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
					
				//$qSql="select * from pm_design where id = $mdid";
				//$design_row=$this->Common_model->get_query_row_array($qSql);
				
				$qSql="SELECT * from $design_kpi where did = $mdid";
				$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
				
				/////////
				$html = "";
				
				$TotRow = count($design_kpi_arr);
				
				$cnt = 1;
				foreach($design_kpi_arr as $kpiRow) {
				
					$html .= "<div class='col-md-12 kpi_input_row'>";					
					$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
					$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
     				$html .= "<div class='col-md-5'><select class='form-control' name='kpi_type[]' > ";
					
					foreach($kpi_type_list as $kpimas){						
						$sCss="";
						if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
						$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
					}
									
					$html .= "</select></div>";							
					$html .= "<div class='col-md-2'>";						
						if( $cnt++<$TotRow){							
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
						}else{
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
						}
									
					$html .= "</div>";
				    $html .= "</div>";
				
				}	
						
				echo $html;
			}
		}

	
	   public function update_Audit_Design()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_audit_design";
				$data['design']['name'] = $design_name = "Audit";
				$data['design']['kpi'] = $design_kpi = "training_audit_kpi";
				$data['design']['data'] = $design_data = "training_audit_data";
				$data['design']['url']['design'] = $url_design = "audit_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_Audit_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_Audit_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_Audit_DesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				$mdid = trim($this->input->post('mdid'));
				
				$batch_id  = trim($this->input->post('batch_id'));
				$office_id  = trim($this->input->post('office_id'));
				$client_id  = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$description = trim($this->input->post('description'));
				
				$kpi_id_arr   = $this->input->post('kpi_id');
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				
				$field_array = array(
					"office_id"   => $office_id,
					"client_id"   => $client_id,
					"process_id"  => $process_id,
					"description" => $description,
					"added_by"    => $current_user,
					"is_active"   => '1',
					"added_date"  => $curDateTime,
					"uplog"       => $log
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				$TotID = count($kpi_id_arr);
				
				// DELETE DESIGN
				$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
				$query = $this->db->query($sql);
				
				foreach($kpi_name_arr as $index => $kpi_name)
				{
					if($kpi_name != "")
					{						
						$field_array = array(
							"did"         => $mdid,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => curDateTime,
							"uplog"       => $log
						);
						
						data_inserter($design_kpi, $field_array);						
					}
				}
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
	   }




		public function audit_performance()
		{
			
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_audit_design";
				$data['design']['name'] = $design_name = "Audit";
				$data['design']['kpi'] = $design_kpi = "training_audit_kpi";
				$data['design']['data'] = $design_data = "training_audit_data";
				$data['design']['url']['design'] = $url_design = "audit_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_Audit_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_Audit_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_Audit_DesignForm";
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/audit_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and batch_office_id='$oValue' ";
						$filterCond2 = " and location_id='$oValue' ";
				}
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training")){
					
					$qSql="SELECT tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_type=3 $filterCond $filterCond4 $filterCond3 ORDER by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="SELECT tb.*, c.shname as client_name , p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id
					WHERE trainer_id='$current_user' and trn_type=3 $filterCond4 $filterCond3 ORDER by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_type=3 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$data['checkupload'][$batch_id] = '0';
					
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ntdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ntdid = '$ragdid' AND kpi_id = '$kpiid'";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							$jcheck++;
						}
					}
					
					
					$i++;
				}
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
				
				if($is_global_access==1) $data['location_list'] = $this->Common_model->get_office_location_list();
				else $data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
							
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}

	   		
	public function downloadTrainingAuditHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' and trn_type=3 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from training_audit_design WHERE client_id = '".$pm_batch_rowb['client_id']."' AND process_id = '" .$pm_batch_rowb['process_id'] ."' AND office_id = '" .$pm_batch_rowb['office_id']."'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from training_audit_design mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from training_audit_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$cell=$letters[$j++].$r;
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
			
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	
	
	/// DOWNLOAD NESTING RESULT
	   		
	public function downloadTrainingAuditResult()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' and trn_type=3 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from training_audit_design WHERE client_id = '".$pm_batch_rowb['client_id']."' AND process_id = '" .$pm_batch_rowb['process_id'] ."' AND office_id = '" .$pm_batch_rowb['office_id']."'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from training_audit_design mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from training_audit_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$cell=$letters[$j++].$r;
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
			
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	public function uploadAuditResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/training_nesting/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_Audit_file($fileName,$batch_id);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_Audit_file($fileName,$batch_id);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	
	
	
	private function Import_Audit_file($file_name,$batch_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/training_nesting/'.$file_name;
				
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
				
		// GET RAG DID FROM BATCH
		$qSqlb="SELECT tb.*,
				c.shname as client_name, 
				p.name as process_name, 
				dfr.requisition_id, dfr.job_title, 
				CONCAT(fname,' ' ,lname) as trainer_name, 
				office_id, location from training_batch tb 
				LEFT JOIN client c ON  c.id=tb.client_id 
				LEFT JOIN process p ON  p.id=tb.process_id 
				LEFT JOIN signin ON  signin.id=tb.trainer_id 
				LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id 
				where trn_batch_status = '1' and trn_type=3 AND tb.id = '$batch_id'";
		
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		$getpmid = "SELECT * from training_audit_design WHERE trn_batch_id = '$batch_id'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		$pmdid = $pm_batch_rowb['id'];
			
		
		// GET KPI DETAILS
		$qSql = "Select * from training_audit_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET RAG DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}
		
		//echo "hi";
		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "select id as value from training_audit_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ntdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"ntdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update('training_audit_data',$field_array);
					
					
				} else {
					
					data_inserter('training_audit_data',$field_array);
				
				}
			
				//print_r($field_array);die();$_run = false;					
				
			}	
			}		
			
		}
		
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		
	}
	
	
	
	
	public function getFormatDesignAuditRag()
	{
		$batchid = trim($this->input->get('batchid'));
		$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' and trn_type=3 AND tb.id = '$batchid'";
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		
		$getpmid = "SELECT * from training_audit_design WHERE client_id = '".$pm_batch_rowb['client_id']."' AND process_id = '" .$pm_batch_rowb['process_id'] ."' AND office_id = '" .$pm_batch_rowb['office_id']."'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		
		$pmdid = $pm_batch_rowb['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}
	
	
	
	
	
	
	
	
	/****------------------ RECURSIVE SUMMARY --------------------****/
	
		public function recursive_summary(){
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				$current_scope = 1;
				$current_scope_get = $this->input->get('scope');
				if($current_scope_get != ""){ $current_scope  =  $current_scope_get; }
				$data['current_scope'] = $current_scope;
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/recursive_summary.php";
				
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = $user_office_id;
				$data['oValue'] = $oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and location='$oValue' ";
						$filterCond2 = " and office_id='$oValue' ";
				}
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}
				
				
				if($current_scope == 1)
				{
					
					$sqltni_refreher = "SELECT r.*, c.shname as client_name, p.name as process_name 
										from training_tni_refresher_design r 
										LEFT JOIN client c ON  c.id = r.client_id 
										LEFT JOIN process p ON  p.id = r.process_id 
										WHERE 1 $filterCond2 order by r.client_id desc";
					$data['design_tni'] =  $tniprocess = $this->Common_model->get_query_result_array($sqltni_refreher);
					foreach($tniprocess as $tokendata)
					{
						$myp = $tokendata['process_id'];
						$myc = $tokendata['client_id'];
						$myo = $tokendata['office_id'];
						$sqlprocessdata = "SELECT avg(d.kpi_value) as myvalue, k.kpi_name  from training_tni_refresher_data as d
											LEFT JOIN training_tni_refresher_kpi as k ON d.kpi_id = k.id 
											WHERE d.ntdid IN (SELECT id from training_tni_refresher_design WHERE process_id = '$myp' AND client_id = '$myc') 
											GROUP BY d.kpi_id";
					   $data['process_data'][$myo."-".$myc."-".$myp] =  $queryprocssdata = $this->Common_model->get_query_result_array($sqlprocessdata);
					}
					
					
				
				}
				
				
				
				if($current_scope == 2)
				{
					
					$sqltni_refreher = "SELECT r.*, c.shname as client_name, p.name as process_name 
										from training_bqm_refresher_design r 
										LEFT JOIN client c ON  c.id = r.client_id 
										LEFT JOIN process p ON  p.id = r.process_id 
										WHERE 1 $filterCond2 order by r.client_id desc";
					$data['design_tni'] =  $tniprocess = $this->Common_model->get_query_result_array($sqltni_refreher);
					foreach($tniprocess as $tokendata)
					{
						$myp = $tokendata['process_id'];
						$myc = $tokendata['client_id'];
						$myo = $tokendata['office_id'];
						$sqlprocessdata = "SELECT avg(d.kpi_value) as myvalue, k.kpi_name  from training_bqm_refresher_data as d
											LEFT JOIN training_bqm_refresher_kpi as k ON d.kpi_id = k.id 
											WHERE d.ntdid IN (SELECT id from training_bqm_refresher_design WHERE process_id = '$myp' AND client_id = '$myc') 
											GROUP BY d.kpi_id";
					   $data['process_data'][$myo."-".$myc."-".$myp] =  $queryprocssdata = $this->Common_model->get_query_result_array($sqlprocessdata);
					}
					
					
				
				}
				
				if($current_scope == 3)
				{
					
					$sqltni_refreher = "SELECT r.*, c.shname as client_name, p.name as process_name 
										from training_soft_skills_design r 
										LEFT JOIN client c ON  c.id = r.client_id 
										LEFT JOIN process p ON  p.id = r.process_id 
										WHERE 1 $filterCond2 order by r.client_id desc";
					$data['design_tni'] =  $tniprocess = $this->Common_model->get_query_result_array($sqltni_refreher);
					foreach($tniprocess as $tokendata)
					{
						$myp = $tokendata['process_id'];
						$myc = $tokendata['client_id'];
						$myo = $tokendata['office_id'];
						$sqlprocessdata = "SELECT avg(d.kpi_value) as myvalue, k.kpi_name  from training_soft_skills_data as d
											LEFT JOIN training_soft_skills_kpi as k ON d.kpi_id = k.id 
											WHERE d.ntdid IN (SELECT id from training_soft_skills_design WHERE process_id = '$myp' AND client_id = '$myc') 
											GROUP BY d.kpi_id";
					   $data['process_data'][$myo."-".$myc."-".$myp] =  $queryprocssdata = $this->Common_model->get_query_result_array($sqlprocessdata);
					}
					
					
				
				}
				
				
				
				
				
				
				
				
				
				if($is_global_access==1) $data['location_list'] = $this->Common_model->get_office_location_list();
				else $data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				
				$this->load->view('dashboard',$data);
				
			}
		}




		/*------------------------------- RECURSIVE --------------------------------*/
		//////////////////////// TNI Refresher DESIGN /////////////////////////////////////////


				public function refresher_tni_design()
				{
					if(check_logged_in())
					{
						$current_user     = get_user_id();
						$user_site_id     = get_user_site_id();
						$user_office_id   = get_user_office_id();
						$user_oth_office  = get_user_oth_office();
						$is_global_access = get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$role_dir         = get_role_dir();
						$role_id          = get_role_id();
						$get_dept_id      = get_dept_id();
						
						$data["aside_template"]   = "training/aside.php";
						$data["content_template"] = "training/refresher_tni_design.php";
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_tni_refresher_design";
						$data['design']['name'] = $design_name = "Refresher TNI";
						$data['design']['kpi'] = $design_kpi = "training_tni_refresher_kpi";
						$data['design']['data'] = $design_data = "training_tni_refresher_data";
						$data['design']['url']['design'] = $url_design = "refresher_tni_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_tni_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_tni_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_tni_DesignForm";
						
						//=========== OFFICE > CLIENT > PROCESS FILTER
						$oValue = trim($this->input->post('office_id'));
						if($oValue=="") $oValue = trim($this->input->get('office_id'));
						
						$cValue = trim($this->input->post('client_id'));
						if($cValue=="") $cValue = trim($this->input->get('client_id'));
						if($cValue=="") $cValue="0";
						
						$pValue = trim($this->input->post('process_id'));
						if($pValue=="") $pValue = trim($this->input->get('process_id'));
						
						$data['oValue']=$oValue;
						$data['cValue']=$cValue;
						$data['pValue']=$pValue;
												
						$_filterCond="";
						//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
						//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
						//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
						
						if($oValue!="ALL" && $oValue!="") 
						$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
						LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
						else $qSql=" Select id as client_id, shname from client where is_active='1'";	
						$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
						
						$qSqlall="Select id as client_id, shname from client where is_active='1'";	
						$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
										
						$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
						$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
						
						$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
						$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
						
						if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
						else $data['process_list'] = $this->Common_model->get_process_for_assign();
						
						if($is_global_access==1){
							$data['location_list'] = $this->Common_model->get_office_location_list();
						}else{
							$sCond=" WHERE id = '$user_site_id'";
							$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
						}
						
						//============ FORM URL DATA
						$data['hide_normal'] = "off";
						$url_batch_id = "";
						$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
						if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
						$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
						if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
						$data['url_batch_id'] = $url_batch_id;
						
							
						$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
							(SELECT name from process y where y.id = b.process_id) as process_name,
							(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
							(SELECT shname from client c where c.id = b.client_id) as client_name 
							from training_batch as b WHERE b.id = '$url_batch_id'";
						$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
							
						// CHECK ANY PREVIOUS DESIGN
						$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
						$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
						if($pv_rag != ""){
							$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
							$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
						}
						
						// GET DESIGN DATA
						$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp WHERE is_active=1 AND trn_batch_id = '$url_batch_id' $_filterCond";
						$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
						
						$pmkpiarray=array();
						foreach($design_row as $row):
							$mp_id= $row['mp_id'];
							$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
							$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
						endforeach;
						
						$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
						
						//loading training javascript
						//$data["content_js"] = "training/cert_design_js.php";
					
						$this->load->view('dashboard',$data);
						
					}
				}
				
				
			
			   public function add_refresher_tni_Design()
			   {
					if(check_logged_in())
					{
									
						$user_site_id  = get_user_site_id();
						$srole_id      = get_role_id();
						$current_user  = get_user_id();
						$ses_dept_id   = get_dept_id();
						
						$user_office_id   = get_user_office_id();
						$is_global_access = get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$curDateTime      = CurrMySqlDate();
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_tni_refresher_design";
						$data['design']['name'] = $design_name = "Refresher TNI";
						$data['design']['kpi'] = $design_kpi = "training_tni_refresher_kpi";
						$data['design']['data'] = $design_data = "training_tni_refresher_data";
						$data['design']['url']['design'] = $url_design = "refresher_tni_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_tni_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_tni_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_tni_DesignForm";
						
						$_run = false;  
						
						$log = get_logs();
						
						$batch_id    = trim($this->input->post('trn_batch_id'));
						$office_id    = trim($this->input->post('office_id'));
						$client_id    = trim($this->input->post('client_id'));
						$process_id   = trim($this->input->post('process_id'));
						$description  = trim($this->input->post('description'));
						$kpi_name_arr = $this->input->post('kpi_name');
						$kpi_type_arr = $this->input->post('kpi_type');
						
						
						$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
						$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
						if($uploadcheck != "")
						{
							//redirect($_SERVER['HTTP_REFERER']);
							redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
							
						} else {
							
							$field_array = array(
								"trn_batch_id" => $batch_id,
								"office_id"    => $office_id,
								"client_id"    => $client_id,
								"process_id"   => $process_id,
								"description"  => $description,
								"added_by"     => $current_user,
								"is_active"    => '1',
								"added_date"   => $curDateTime,
								"uplog"        => $log
							);
							
							$did = data_inserter($design_table,$field_array);
							
							foreach($kpi_name_arr as $index => $kpi_name){
								if($kpi_name<>""){
									$field_array = array(
										"did" => $did,
										"kpi_name"    => $kpi_name,
										"kpi_type"    => $kpi_type_arr[$index],
										"isdel"       => '0',
										"added_by"    => $current_user,
										"added_date"  => $curDateTime,
										"uplog"       => $log
									);
									data_inserter($design_kpi,$field_array);
								}
							}
						
							redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
						}
				   }        
			   }
				
				
				public function get_refresher_tni_DesignForm()
				{
					if(check_logged_in())
					{
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_tni_refresher_design";
						$data['design']['name'] = $design_name = "Refresher TNI";
						$data['design']['kpi'] = $design_kpi = "training_tni_refresher_kpi";
						$data['design']['data'] = $design_data = "training_tni_refresher_data";
						$data['design']['url']['design'] = $url_design = "refresher_tni_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_tni_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_tni_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_tni_DesignForm";
						
						$mdid = trim($this->input->post('mdid'));
						$mdid=addslashes($mdid);
						
						$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
						$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
						
						$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
						$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
							
						//$qSql="select * from pm_design where id = $mdid";
						//$design_row=$this->Common_model->get_query_row_array($qSql);
						
						$qSql="SELECT * from $design_kpi where did = $mdid";
						$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
						
						/////////
						$html = "";
						
						$TotRow = count($design_kpi_arr);
						
						$cnt = 1;
						foreach($design_kpi_arr as $kpiRow) {
						
							$html .= "<div class='col-md-12 kpi_input_row'>";					
							$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
							$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
							$html .= "<div class='col-md-5'><select class='form-control' name='kpi_type[]' > ";
							
							foreach($kpi_type_list as $kpimas){						
								$sCss="";
								if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
								$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
							}
											
							$html .= "</select></div>";							
							$html .= "<div class='col-md-2'>";						
								if( $cnt++<$TotRow){							
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
								}else{
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
								}
											
							$html .= "</div>";
							$html .= "</div>";
						
						}	
								
						echo $html;
					}
				}

			
			   public function update_refresher_tni_Design()
			   {
					if(check_logged_in())
					{
									
						$user_site_id  = get_user_site_id();
						$srole_id      = get_role_id();
						$current_user  = get_user_id();
						$ses_dept_id   = get_dept_id();
						
						$user_office_id   = get_user_office_id();
						$is_global_access = get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$curDateTime      = CurrMySqlDate();
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_tni_refresher_design";
						$data['design']['name'] = $design_name = "Refresher TNI";
						$data['design']['kpi'] = $design_kpi = "training_tni_refresher_kpi";
						$data['design']['data'] = $design_data = "training_tni_refresher_data";
						$data['design']['url']['design'] = $url_design = "refresher_tni_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_tni_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_tni_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_tni_DesignForm";
						
						$_run = false;  
						
						$log = get_logs();
						$mdid = trim($this->input->post('mdid'));
						
						$batch_id  = trim($this->input->post('batch_id'));
						$office_id  = trim($this->input->post('office_id'));
						$client_id  = trim($this->input->post('client_id'));
						$process_id = trim($this->input->post('process_id'));
						$description = trim($this->input->post('description'));
						
						$kpi_id_arr   = $this->input->post('kpi_id');
						$kpi_name_arr = $this->input->post('kpi_name');
						$kpi_type_arr = $this->input->post('kpi_type');
						
						$field_array = array(
							"office_id"   => $office_id,
							"client_id"   => $client_id,
							"process_id"  => $process_id,
							"description" => $description,
							"added_by"    => $current_user,
							"is_active"   => '1',
							"added_date"  => $curDateTime,
							"uplog"       => $log
						);
						
						$this->db->where('id', $mdid);
						$this->db->update($design_table,$field_array);
						
						$TotID = count($kpi_id_arr);
						
						// DELETE DESIGN
						$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
						$query = $this->db->query($sql);
						
						foreach($kpi_name_arr as $index => $kpi_name)
						{
							if($kpi_name != "")
							{						
								$field_array = array(
									"did"         => $mdid,
									"kpi_name"    => $kpi_name,
									"kpi_type"    => $kpi_type_arr[$index],
									"isdel"       => '0',
									"added_by"    => $current_user,
									"added_date"  => curDateTime,
									"uplog"       => $log
								);
								
								data_inserter($design_kpi, $field_array);						
							}
						}
						
						
						redirect($_SERVER['HTTP_REFERER']);
						
					}
			   }




				public function refresher_tni_summary(){
					
					if(check_logged_in())
					{
						
						$current_user = get_user_id();
						$evt_date = CurrMySqlDate();

						$user_site_id= get_user_site_id();
						$user_office_id= get_user_office_id();
						
						//echo $user_office_id;
						
						$user_oth_office=get_user_oth_office();
						$is_global_access=get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$is_role_dir=get_role_dir();
						$get_dept_id=get_dept_id();
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_tni_refresher_design";
						$data['design']['name'] = $design_name = "Refresher TNI";
						$data['design']['kpi'] = $design_kpi = "training_tni_refresher_kpi";
						$data['design']['data'] = $design_data = "training_tni_refresher_data";
						$data['design']['url']['design'] = $url_design = "refresher_tni_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_tni_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_tni_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_tni_DesignForm";
						
						$batch="";
						$cond="";
						$filterCond="";
						$filterCond2="";
						$filterCond3 = "";
						$filterCond4 = " and trn_batch_status = '1' ";
						
						$data["aside_template"] = "training/aside.php";
						$data["content_template"] = "training/refresher_tni_details.php";
						
						$oValue = trim($this->input->get('office_id'));
						if($oValue=="") $oValue = trim($this->input->get('office_id'));
						if($oValue=="" ) $oValue=$user_office_id;
						$data['oValue']=$oValue;
						
						if($oValue!="ALL" ){
								$filterCond = " and batch_office_id='$oValue' ";
								$filterCond2 = " and location_id='$oValue' ";
						}
						
						if($this->input->get('searchtraining'))
						{
							$daterange_full = $this->input->get('daterange');
							$daterange_explode = explode('-',$daterange_full);
							$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
							$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
							$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
							$filterCond4 = "";
							
						}	
						
						//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
						
						if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training")){
							
							$qSql="SELECT tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id
							from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id 
							WHERE trn_type=4 $filterCond $filterCond4 $filterCond3 ORDER by tb.id desc";
							
							$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
							
						}else{
							$qSql="SELECT tb.*, c.shname as client_name , p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
							from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id
							WHERE trainer_id='$current_user' and trn_type=4 $filterCond4 $filterCond3 ORDER by tb.id desc";
							
							$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
						}
						
						$i = 0;
						$AllBatchArray = array();
						foreach($assigned_batch as $token)
						{
							
							$batch_id= $token['id'];
							$location= $token['location'];
							$key = $location."-".$batch_id;
							
							$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
							from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id 
							WHERE trn_type=4 AND tb.id = '$batch_id' $filterCond4";
							$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
							
							$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
							$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
							
							$pmdid = $pm_batch_rowb['id'];
							$assigned_batch[$i]['batchid'] = $pmdid;
							
							$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
							$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
							
							$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
							$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
							
							$assigned_batch[$i]['batchid_rag'] = $querydesign;
							$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
							
							$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
							$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
							
							$data['checkupload'][$batch_id] = '0';
							
							foreach($AllBatchArray[$key] as $tokenuser)
							{
								$userget_id = $tokenuser['user_id'];
								$jcheck = 0;
								
								// GET MULTIPLE VALUE CHECK
								$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ntdid, kpi_id ORDER by ID DESC LIMIT 1";
								$querym = $this->Common_model->get_single_value($sqlm);
								$assigned_batch[$i]['checksum'][$userget_id] = $querym;
								
								if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
								if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
								
								foreach($querydesignkpi as $tokenarray)
								{
									$ragdid = $tokenarray['did'];
									$kpiid = $tokenarray['id'];
									$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ntdid = '$ragdid' AND kpi_id = '$kpiid'";
									$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
									$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
									$jcheck++;
								}
							}
							
							
							$i++;
						}
						
						$data["assigned_batch"] = $assigned_batch;
						$data["AllBatchArray"] = $AllBatchArray;
						
						// GET KPI DETAILS
						//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
						
						if($is_global_access==1) $data['location_list'] = $this->Common_model->get_office_location_list();
						else $data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
									
						$this->load->view('dashboard',$data);
						
						
					}
					
						
				}

					
			public function download_refresher_tni_Header()
			{
				
				$batchid = "";
				$pmdid = trim($this->input->get('pmdid'));
				$batchid = trim($this->input->get('batchid'));
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_tni_refresher_design";
				$data['design']['name'] = $design_name = "Refresher TNI";
				$data['design']['kpi'] = $design_kpi = "training_tni_refresher_kpi";
				$data['design']['data'] = $design_data = "training_tni_refresher_data";
				$data['design']['url']['design'] = $url_design = "refresher_tni_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_tni_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_tni_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_tni_DesignForm";
				
					
				if($batchid != "")
				{
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					$pmdid = $pm_batch_rowb['id'];
					
				}
				
				
				if($pmdid != ""){
					
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
					
				$pm_design_row = $this->Common_model->get_query_row_array($qSql);
				
				$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
				$fn = str_replace("/","_",$fn);
				$sht_title= $fn;
				 
				if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
				$filename = "./assets/reports/".$fn.".xls";
				$title = $fn;
				
				
				$letters = array(); 
				$k=0;
				 for ($i = 'A'; $i !== 'ZZ'; $i++){
					$letters[$k++]=$i;
				}
				
				
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle($sht_title);
				//set cell A1 content with some text
			
				$this->excel->getActiveSheet()->setCellValue('A1', $title);
			
				//change the font size
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				//make the font become bold
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				
				$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
				$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
				$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
				
				$j=3;
				$r=2;
				
				$mp_id=$pm_design_row['mp_id'];
				
				$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
				$kpiarray=$this->Common_model->get_query_result_array($qSql);
				
				foreach($kpiarray as $row):
				
					$cell=$letters[$j++].$r;
					//echo $cell .">>";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
					
				endforeach;
				
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
				ob_end_clean();
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
				} else {
					redirect($_SERVER['HTTP_REFERER']);
				}
				
				
			}
			
			
			
			
			
			/// DOWNLOAD NESTING RESULT
					
			public function download_refresher_tni_Result()
			{
				
				$batchid = "";
				$pmdid = trim($this->input->get('pmdid'));
				$batchid = trim($this->input->get('batchid'));
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_tni_refresher_design";
				$data['design']['name'] = $design_name = "Refresher TNI";
				$data['design']['kpi'] = $design_kpi = "training_tni_refresher_kpi";
				$data['design']['data'] = $design_data = "training_tni_refresher_data";
				$data['design']['url']['design'] = $url_design = "refresher_tni_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_tni_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_tni_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_tni_DesignForm";
				
					
				if($batchid != "")
				{
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					
				}
				
				
				if($pmdid != ""){
					
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
					
				$pm_design_row = $this->Common_model->get_query_row_array($qSql);
				
				$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
				$fn = str_replace("/","_",$fn);
				$sht_title= $fn;
				 
				if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
				$filename = "./assets/reports/".$fn.".xls";
				$title = $fn;
				
				
				$letters = array(); 
				$k=0;
				 for ($i = 'A'; $i !== 'ZZ'; $i++){
					$letters[$k++]=$i;
				}
				
				
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle($sht_title);
				//set cell A1 content with some text
			
				$this->excel->getActiveSheet()->setCellValue('A1', $title);
			
				//change the font size
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				//make the font become bold
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				
				$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
				$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
				$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
				
				$j=3;
				$r=2;
				
				$mp_id=$pm_design_row['mp_id'];
				
				$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
				$kpiarray=$this->Common_model->get_query_result_array($qSql);
				
				foreach($kpiarray as $row):
				
					$cell=$letters[$j++].$r;
					//echo $cell .">>";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
					
				endforeach;
				
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
				ob_end_clean();
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
				} else {
					redirect($_SERVER['HTTP_REFERER']);
				}
				
				
			}
			
			
			
			public function upload_refresher_tni_Result()
			{
				
				if(check_logged_in())
				{
					$user_site_id= get_user_site_id();
					$role_id= get_role_id();
					$current_user = get_user_id();
					
					$batch_id = trim($this->input->post('batch_id'));
								 
					$ret = array();
					
					if($batch_id!=""){
					
						$output_dir = "uploads/training_nesting/";
									
						$error =$_FILES["sktfile"]["error"];
						//You need to handle  both cases
						//If Any browser does not support serializing of multiple files using FormData() 
						if(!is_array($_FILES["sktfile"]["name"])) //single file
						{
							//$fileName = time().$_FILES["sktfile"]["name"];
							$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
							
							move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
							
							$ret[]= $this->Import_refresher_tni_file($fileName,$batch_id);
							
							
						}
						else  //Multiple files, file[]
						{
						  $fileCount = count($_FILES["sktfile"]["name"]);
						  for($i=0; $i < $fileCount; $i++)
						  {
							//$fileName = time().$_FILES["sktfile"]["name"][$i];
							$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
							
							move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
							
							$ret[]= $this->Import_refresher_tni_file($fileName,$batch_id);
							
						  }
						
						}
					}else{
							$ret[]="error";
							
					}
					
					echo json_encode($ret);
					
				}
				
				
			}
			
			
			
			
			private function Import_refresher_tni_file($file_name,$batch_id)
			{
				$current_user = get_user_id();
				$file_path = './uploads/training_nesting/'.$file_name;
						
				$curDateTime   = CurrMySqlDate();
				$log = get_logs();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_tni_refresher_design";
				$data['design']['name'] = $design_name = "Refresher TNI";
				$data['design']['kpi'] = $design_kpi = "training_tni_refresher_kpi";
				$data['design']['data'] = $design_data = "training_tni_refresher_data";
				$data['design']['url']['design'] = $url_design = "refresher_tni_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_tni_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_tni_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_tni_DesignForm";
						
						
				// GET RAG DID FROM BATCH
				$qSqlb="SELECT tb.*,
						c.shname as client_name, 
						p.name as process_name, 
						batch_name, batch_office_id, 
						CONCAT(fname,' ' ,lname) as trainer_name, 
						office_id, batch_office_id, batch_name from training_batch tb 
						LEFT JOIN client c ON  c.id=tb.client_id 
						LEFT JOIN process p ON  p.id=tb.process_id 
						LEFT JOIN signin ON  signin.id=tb.trainer_id
						where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batch_id'";
				
				$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
				$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
				$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
				$pmdid = $pm_batch_rowb['id'];
					
				
				// GET KPI DETAILS
				$qSql = "Select * from $design_kpi kp where did = $pmdid";
				$kpiarray=$this->Common_model->get_query_result_array($qSql);
				foreach($kpiarray as $tokeni)
				{
					$countkpi++;
					//$kpiid = $tokeni['id'];
					$kpidata[$countkpi] = $tokeni['id'];
				}
				
				//$this->load->library('excel');
				$inputFileType = PHPExcel_IOFactory::identify($file_path);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load($file_path);
				
				/* $i = 0;
				while ($objPHPExcel->setActiveSheetIndex($i)){
				echo $i; */
				$objPHPExcel->setActiveSheetIndex(0);
				$objWorksheet = $objPHPExcel->getActiveSheet();

				//now do whatever you want with the active sheet
				$highestRow = $objWorksheet->getHighestRow();
				$highestColumn = $objWorksheet->getHighestColumn();
				$worksheetTitle = $objWorksheet->getTitle();
				
				if((ord($highestColumn) - ord('C')) == $countkpi){
				
				$startcol = ord('D');
				$lastCol  = ord($highestColumn);
				
				// GET RAG DATA ARRAY
				$rag_data = array();
				for($row = 3; $row <= $highestRow; $row++)
				{
					$totaluser++;
					$startcol = ord('D');
					for($j=1; $j<=$countkpi; $j++)
					{
					  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
					  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
					  $startcol++;
					}
				}
				
				//echo "hi";
				//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
			
				// DATA INSERTION START
				$this->db->trans_begin();
				for($starti=3; $starti <= $totaluser+2; $starti++)
				{
					$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
					$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
					
					$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
					$user_id   = $this->Common_model->get_single_value($qSql);
					if($user_id != ""){
					for($j=1; $j<=$countkpi; $j++)
					{   

						$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ntdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
						$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
						
						$field_array = array(
									"user_id"    => $user_id,
									"trn_batch_id" => $batch_id,
									"ntdid"     => $pmdid,
									"kpi_id"     => $kpidata[$j],
									"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
									"added_by"   => $current_user,
									"added_date" => $curDateTime,
									"uplog"      => $log
								);
						
						if($uploadcheck != ""){
							
							$this->db->where('id', $uploadcheck);
							$this->db->update($design_data,$field_array);
							
							
						} else {
							
							data_inserter($design_data,$field_array);
						
						}
					
						//print_r($field_array);die();$_run = false;					
						
					}	
					}		
					
				}
				
				//return "done";
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					return "error";
				}
				else
				{
					$this->db->trans_commit();
					return "done";
				}
				
				} else {
					return "error";
				}
				
				
			}
			
			public function getFormatDesign_refresher_tni()
			{
				$data['design']['table'] = $design_table = "training_tni_refresher_design";
				$data['design']['name'] = $design_name = "Refresher TNI";
				$data['design']['kpi'] = $design_kpi = "training_tni_refresher_kpi";
				$data['design']['data'] = $design_data = "training_tni_refresher_data";
				$data['design']['url']['design'] = $url_design = "refresher_tni_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_tni_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_tni_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_tni_DesignForm";
				
				$batchid = trim($this->input->get('batchid'));
				$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
				$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
				
				$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
				$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
				
				$pmdid = $pm_batch_rowb['id'];
				if($pmdid != ""){
					echo $pmdid;
				} else { echo "0"; }
			}
			
			
		   public function get_clients_refresher_tni()
		   {
			    $data['design']['table'] = $design_table = "training_tni_refresher_design";
				$data['design']['name'] = $design_name = "Refresher TNI";
				$data['design']['kpi'] = $design_kpi = "training_tni_refresher_kpi";
				$data['design']['data'] = $design_data = "training_tni_refresher_data";
				$data['design']['url']['design'] = $url_design = "refresher_tni_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_tni_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_tni_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_tni_DesignForm";
				
				$office_id = $this->input->post('office_id');
				if($office_id != 'ALL')
				{
					$qSql="SELECT DISTINCT c.id, c.shname FROM $design_table as d
					LEFT JOIN client as c ON c.id=d.client_id
					WHERE d.office_id = '".$office_id."'";
				}
				else
				{
					$qSql="SELECT DISTINCT c.id, c.shname FROM $design_table as d
					LEFT JOIN client as c ON c.id=d.client_id";
				}
				echo json_encode($this->Common_model->get_query_result_array($qSql));
		   }
		
		
		
		
		
		/*------------------------------- RECURSIVE --------------------------------*/
		//////////////////////// BQM Refresher DESIGN /////////////////////////////////////////


				public function refresher_bqm_design()
				{
					if(check_logged_in())
					{
						$current_user     = get_user_id();
						$user_site_id     = get_user_site_id();
						$user_office_id   = get_user_office_id();
						$user_oth_office  = get_user_oth_office();
						$is_global_access = get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$role_dir         = get_role_dir();
						$role_id          = get_role_id();
						$get_dept_id      = get_dept_id();
						
						$data["aside_template"]   = "training/aside.php";
						$data["content_template"] = "training/refresher_bqm_design.php";
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_bqm_refresher_design";
						$data['design']['name'] = $design_name = "Refresher BQM";
						$data['design']['kpi'] = $design_kpi = "training_bqm_refresher_kpi";
						$data['design']['data'] = $design_data = "training_bqm_refresher_data";
						$data['design']['url']['design'] = $url_design = "refresher_bqm_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_bqm_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_bqm_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_bqm_DesignForm";
						
						//=========== OFFICE > CLIENT > PROCESS FILTER
						$oValue = trim($this->input->post('office_id'));
						if($oValue=="") $oValue = trim($this->input->get('office_id'));
						
						$cValue = trim($this->input->post('client_id'));
						if($cValue=="") $cValue = trim($this->input->get('client_id'));
						if($cValue=="") $cValue="0";
						
						$pValue = trim($this->input->post('process_id'));
						if($pValue=="") $pValue = trim($this->input->get('process_id'));
						
						$data['oValue']=$oValue;
						$data['cValue']=$cValue;
						$data['pValue']=$pValue;
												
						$_filterCond="";
						//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
						//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
						//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
						
						if($oValue!="ALL" && $oValue!="") 
						$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
						LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
						else $qSql=" Select id as client_id, shname from client where is_active='1'";	
						$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
						
						$qSqlall="Select id as client_id, shname from client where is_active='1'";	
						$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
										
						$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
						$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
						
						$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
						$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
						
						if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
						else $data['process_list'] = $this->Common_model->get_process_for_assign();
						
						if($is_global_access==1){
							$data['location_list'] = $this->Common_model->get_office_location_list();
						}else{
							$sCond=" WHERE id = '$user_site_id'";
							$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
						}
						
						//============ FORM URL DATA
						$data['hide_normal'] = "off";
						$url_batch_id = "";
						$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
						if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
						$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
						if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
						$data['url_batch_id'] = $url_batch_id;
						
							
						$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
							(SELECT name from process y where y.id = b.process_id) as process_name,
							(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
							(SELECT shname from client c where c.id = b.client_id) as client_name 
							from training_batch as b WHERE b.id = '$url_batch_id'";
						$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
							
						// CHECK ANY PREVIOUS DESIGN
						$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
						$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
						if($pv_rag != ""){
							$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
							$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
						}
						
						// GET DESIGN DATA
						$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp WHERE is_active=1 AND trn_batch_id = '$url_batch_id' $_filterCond";
						$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
						
						$pmkpiarray=array();
						foreach($design_row as $row):
							$mp_id= $row['mp_id'];
							$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
							$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
						endforeach;
						
						$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
						
						//loading training javascript
						//$data["content_js"] = "training/cert_design_js.php";
					
						$this->load->view('dashboard',$data);
						
						
					}
				}
				
				
			
			   public function add_refresher_bqm_Design()
			   {
					if(check_logged_in())
					{
									
						$user_site_id  = get_user_site_id();
						$srole_id      = get_role_id();
						$current_user  = get_user_id();
						$ses_dept_id   = get_dept_id();
						
						$user_office_id   = get_user_office_id();
						$is_global_access = get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$curDateTime      = CurrMySqlDate();
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_bqm_refresher_design";
						$data['design']['name'] = $design_name = "Refresher BQM";
						$data['design']['kpi'] = $design_kpi = "training_bqm_refresher_kpi";
						$data['design']['data'] = $design_data = "training_bqm_refresher_data";
						$data['design']['url']['design'] = $url_design = "refresher_bqm_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_bqm_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_bqm_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_bqm_DesignForm";
						
						$_run = false;  
						
						$log = get_logs();
						
						$batch_id    = trim($this->input->post('trn_batch_id'));
						$office_id    = trim($this->input->post('office_id'));
						$client_id    = trim($this->input->post('client_id'));
						$process_id   = trim($this->input->post('process_id'));
						$description  = trim($this->input->post('description'));
						$kpi_name_arr = $this->input->post('kpi_name');
						$kpi_type_arr = $this->input->post('kpi_type');
						
						
						$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
						$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
						if($uploadcheck != "")
						{
							//redirect($_SERVER['HTTP_REFERER']);
							redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
							
						} else {
							
							$field_array = array(
								"trn_batch_id" => $batch_id,
								"office_id"    => $office_id,
								"client_id"    => $client_id,
								"process_id"   => $process_id,
								"description"  => $description,
								"added_by"     => $current_user,
								"is_active"    => '1',
								"added_date"   => $curDateTime,
								"uplog"        => $log
							);
							
							$did = data_inserter($design_table,$field_array);
							
							foreach($kpi_name_arr as $index => $kpi_name){
								if($kpi_name<>""){
									$field_array = array(
										"did" => $did,
										"kpi_name"    => $kpi_name,
										"kpi_type"    => $kpi_type_arr[$index],
										"isdel"       => '0',
										"added_by"    => $current_user,
										"added_date"  => $curDateTime,
										"uplog"       => $log
									);
									data_inserter($design_kpi,$field_array);
								}
							}
						
							redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
						}
						
				   }        
			   }
				
				
				public function get_refresher_bqm_DesignForm()
				{
					if(check_logged_in())
					{
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_bqm_refresher_design";
						$data['design']['name'] = $design_name = "Refresher BQM";
						$data['design']['kpi'] = $design_kpi = "training_bqm_refresher_kpi";
						$data['design']['data'] = $design_data = "training_bqm_refresher_data";
						$data['design']['url']['design'] = $url_design = "refresher_bqm_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_bqm_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_bqm_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_bqm_DesignForm";
						
						$mdid = trim($this->input->post('mdid'));
						$mdid=addslashes($mdid);
						
						$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
						$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
						
						$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
						$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
							
						//$qSql="select * from pm_design where id = $mdid";
						//$design_row=$this->Common_model->get_query_row_array($qSql);
						
						$qSql="SELECT * from $design_kpi where did = $mdid";
						$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
						
						/////////
						$html = "";
						
						$TotRow = count($design_kpi_arr);
						
						$cnt = 1;
						foreach($design_kpi_arr as $kpiRow) {
						
							$html .= "<div class='col-md-12 kpi_input_row'>";					
							$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
							$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
							$html .= "<div class='col-md-5'><select class='form-control' name='kpi_type[]' > ";
							
							foreach($kpi_type_list as $kpimas){						
								$sCss="";
								if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
								$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
							}
											
							$html .= "</select></div>";							
							$html .= "<div class='col-md-2'>";						
								if( $cnt++<$TotRow){							
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
								}else{
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
								}
											
							$html .= "</div>";
							$html .= "</div>";
						
						}	
								
						echo $html;
					}
				}

			
			   public function update_refresher_bqm_Design()
			   {
					if(check_logged_in())
					{
									
						$user_site_id  = get_user_site_id();
						$srole_id      = get_role_id();
						$current_user  = get_user_id();
						$ses_dept_id   = get_dept_id();
						
						$user_office_id   = get_user_office_id();
						$is_global_access = get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$curDateTime      = CurrMySqlDate();
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_bqm_refresher_design";
						$data['design']['name'] = $design_name = "Refresher BQM";
						$data['design']['kpi'] = $design_kpi = "training_bqm_refresher_kpi";
						$data['design']['data'] = $design_data = "training_bqm_refresher_data";
						$data['design']['url']['design'] = $url_design = "refresher_bqm_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_bqm_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_bqm_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_bqm_DesignForm";
						
						$_run = false;  
						
						$log = get_logs();
						$mdid = trim($this->input->post('mdid'));
						
						$batch_id  = trim($this->input->post('batch_id'));
						$office_id  = trim($this->input->post('office_id'));
						$client_id  = trim($this->input->post('client_id'));
						$process_id = trim($this->input->post('process_id'));
						$description = trim($this->input->post('description'));
						
						$kpi_id_arr   = $this->input->post('kpi_id');
						$kpi_name_arr = $this->input->post('kpi_name');
						$kpi_type_arr = $this->input->post('kpi_type');
						
						$field_array = array(
							"office_id"   => $office_id,
							"client_id"   => $client_id,
							"process_id"  => $process_id,
							"description" => $description,
							"added_by"    => $current_user,
							"is_active"   => '1',
							"added_date"  => $curDateTime,
							"uplog"       => $log
						);
						
						$this->db->where('id', $mdid);
						$this->db->update($design_table,$field_array);
						
						$TotID = count($kpi_id_arr);
						
						// DELETE DESIGN
						$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
						$query = $this->db->query($sql);
						
						foreach($kpi_name_arr as $index => $kpi_name)
						{
							if($kpi_name != "")
							{						
								$field_array = array(
									"did"         => $mdid,
									"kpi_name"    => $kpi_name,
									"kpi_type"    => $kpi_type_arr[$index],
									"isdel"       => '0',
									"added_by"    => $current_user,
									"added_date"  => curDateTime,
									"uplog"       => $log
								);
								
								data_inserter($design_kpi, $field_array);						
							}
						}
						
						
						redirect($_SERVER['HTTP_REFERER']);
						
					}
			   }




				public function refresher_bqm_summary(){
					
					if(check_logged_in())
					{
						
						$current_user = get_user_id();
						$evt_date = CurrMySqlDate();

						$user_site_id= get_user_site_id();
						$user_office_id= get_user_office_id();
						
						//echo $user_office_id;
						
						$user_oth_office=get_user_oth_office();
						$is_global_access=get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$is_role_dir=get_role_dir();
						$get_dept_id=get_dept_id();
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_bqm_refresher_design";
						$data['design']['name'] = $design_name = "Refresher BQM";
						$data['design']['kpi'] = $design_kpi = "training_bqm_refresher_kpi";
						$data['design']['data'] = $design_data = "training_bqm_refresher_data";
						$data['design']['url']['design'] = $url_design = "refresher_bqm_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_bqm_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_bqm_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_bqm_DesignForm";
						
						$batch="";
						$cond="";
						$filterCond="";
						$filterCond2="";
						$filterCond3 = "";
						$filterCond4 = " and trn_batch_status = '1' ";
						
						$data["aside_template"] = "training/aside.php";
						$data["content_template"] = "training/refresher_bqm_details.php";
						
						$oValue = trim($this->input->get('office_id'));
						if($oValue=="") $oValue = trim($this->input->get('office_id'));
						if($oValue=="" ) $oValue=$user_office_id;
						$data['oValue']=$oValue;
						
						if($oValue!="ALL" ){
								$filterCond = " and batch_office_id='$oValue' ";
								$filterCond2 = " and location_id='$oValue' ";
						}
						
						if($this->input->get('searchtraining'))
						{
							$daterange_full = $this->input->get('daterange');
							$daterange_explode = explode('-',$daterange_full);
							$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
							$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
							$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
							$filterCond4 = "";
							
						}	
						
						//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
						
						if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training")){
							
							$qSql="SELECT tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id
							from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id 
							WHERE trn_type=4 $filterCond $filterCond4 $filterCond3 ORDER by tb.id desc";
							
							$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
							
						}else{
							$qSql="SELECT tb.*, c.shname as client_name , p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
							from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id
							WHERE trainer_id='$current_user' and trn_type=4 $filterCond4 $filterCond3 ORDER by tb.id desc";
							
							$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
						}
						
						$i = 0;
						$AllBatchArray = array();
						foreach($assigned_batch as $token)
						{
							
							$batch_id= $token['id'];
							$location= $token['location'];
							$key = $location."-".$batch_id;
							
							$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
							from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id 
							WHERE trn_type=4 AND tb.id = '$batch_id' $filterCond4";
							$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
							
							$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
							$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
							
							$pmdid = $pm_batch_rowb['id'];
							$assigned_batch[$i]['batchid'] = $pmdid;
							
							$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
							$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
							
							$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
							$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
							
							$assigned_batch[$i]['batchid_rag'] = $querydesign;
							$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
							
							$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
							$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
							
							$data['checkupload'][$batch_id] = '0';
							
							foreach($AllBatchArray[$key] as $tokenuser)
							{
								$userget_id = $tokenuser['user_id'];
								$jcheck = 0;
								
								// GET MULTIPLE VALUE CHECK
								$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ntdid, kpi_id ORDER by ID DESC LIMIT 1";
								$querym = $this->Common_model->get_single_value($sqlm);
								$assigned_batch[$i]['checksum'][$userget_id] = $querym;
								
								if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
								if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
								
								foreach($querydesignkpi as $tokenarray)
								{
									$ragdid = $tokenarray['did'];
									$kpiid = $tokenarray['id'];
									$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ntdid = '$ragdid' AND kpi_id = '$kpiid'";
									$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
									$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
									$jcheck++;
								}
							}
							
							
							$i++;
						}
						
						$data["assigned_batch"] = $assigned_batch;
						$data["AllBatchArray"] = $AllBatchArray;
						
						// GET KPI DETAILS
						//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
						
						if($is_global_access==1) $data['location_list'] = $this->Common_model->get_office_location_list();
						else $data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
									
						$this->load->view('dashboard',$data);
						
						
					}
					
						
				}

					
			public function download_refresher_bqm_Header()
			{
				
				$batchid = "";
				$pmdid = trim($this->input->get('pmdid'));
				$batchid = trim($this->input->get('batchid'));
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_bqm_refresher_design";
				$data['design']['name'] = $design_name = "Refresher BQM";
				$data['design']['kpi'] = $design_kpi = "training_bqm_refresher_kpi";
				$data['design']['data'] = $design_data = "training_bqm_refresher_data";
				$data['design']['url']['design'] = $url_design = "refresher_bqm_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_bqm_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_bqm_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_bqm_DesignForm";
				
					
				if($batchid != "")
				{
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					$pmdid = $pm_batch_rowb['id'];
					
				}
				
				
				if($pmdid != ""){
					
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
					
				$pm_design_row = $this->Common_model->get_query_row_array($qSql);
				
				$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
				$fn = str_replace("/","_",$fn);
				$sht_title= $fn;
				 
				if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
				$filename = "./assets/reports/".$fn.".xls";
				$title = $fn;
				
				
				$letters = array(); 
				$k=0;
				 for ($i = 'A'; $i !== 'ZZ'; $i++){
					$letters[$k++]=$i;
				}
				
				
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle($sht_title);
				//set cell A1 content with some text
			
				$this->excel->getActiveSheet()->setCellValue('A1', $title);
			
				//change the font size
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				//make the font become bold
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				
				$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
				$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
				$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
				
				$j=3;
				$r=2;
				
				$mp_id=$pm_design_row['mp_id'];
				
				$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
				$kpiarray=$this->Common_model->get_query_result_array($qSql);
				
				foreach($kpiarray as $row):
				
					$cell=$letters[$j++].$r;
					//echo $cell .">>";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
					
				endforeach;
				
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
				ob_end_clean();
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
				} else {
					redirect($_SERVER['HTTP_REFERER']);
				}
				
				
			}
			
			
			
			
			
			/// DOWNLOAD NESTING RESULT
					
			public function download_refresher_bqm_Result()
			{
				
				$batchid = "";
				$pmdid = trim($this->input->get('pmdid'));
				$batchid = trim($this->input->get('batchid'));
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_bqm_refresher_design";
				$data['design']['name'] = $design_name = "Refresher BQM";
				$data['design']['kpi'] = $design_kpi = "training_bqm_refresher_kpi";
				$data['design']['data'] = $design_data = "training_bqm_refresher_data";
				$data['design']['url']['design'] = $url_design = "refresher_bqm_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_bqm_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_bqm_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_bqm_DesignForm";
				
					
				if($batchid != "")
				{
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					
				}
				
				
				if($pmdid != ""){
					
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
					
				$pm_design_row = $this->Common_model->get_query_row_array($qSql);
				
				$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
				$fn = str_replace("/","_",$fn);
				$sht_title= $fn;
				 
				if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
				$filename = "./assets/reports/".$fn.".xls";
				$title = $fn;
				
				
				$letters = array(); 
				$k=0;
				 for ($i = 'A'; $i !== 'ZZ'; $i++){
					$letters[$k++]=$i;
				}
				
				
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle($sht_title);
				//set cell A1 content with some text
			
				$this->excel->getActiveSheet()->setCellValue('A1', $title);
			
				//change the font size
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				//make the font become bold
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				
				$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
				$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
				$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
				
				$j=3;
				$r=2;
				
				$mp_id=$pm_design_row['mp_id'];
				
				$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
				$kpiarray=$this->Common_model->get_query_result_array($qSql);
				
				foreach($kpiarray as $row):
				
					$cell=$letters[$j++].$r;
					//echo $cell .">>";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
					
				endforeach;
				
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
				ob_end_clean();
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
				} else {
					redirect($_SERVER['HTTP_REFERER']);
				}
				
				
			}
			
			
			
			public function upload_refresher_bqm_Result()
			{
				
				if(check_logged_in())
				{
					$user_site_id= get_user_site_id();
					$role_id= get_role_id();
					$current_user = get_user_id();
					
					$batch_id = trim($this->input->post('batch_id'));
								 
					$ret = array();
					
					if($batch_id!=""){
					
						$output_dir = "uploads/training_nesting/";
									
						$error =$_FILES["sktfile"]["error"];
						//You need to handle  both cases
						//If Any browser does not support serializing of multiple files using FormData() 
						if(!is_array($_FILES["sktfile"]["name"])) //single file
						{
							//$fileName = time().$_FILES["sktfile"]["name"];
							$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
							
							move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
							
							$ret[]= $this->Import_refresher_bqm_file($fileName,$batch_id);
							
							
						}
						else  //Multiple files, file[]
						{
						  $fileCount = count($_FILES["sktfile"]["name"]);
						  for($i=0; $i < $fileCount; $i++)
						  {
							//$fileName = time().$_FILES["sktfile"]["name"][$i];
							$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
							
							move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
							
							$ret[]= $this->Import_refresher_bqm_file($fileName,$batch_id);
							
						  }
						
						}
					}else{
							$ret[]="error";
							
					}
					
					echo json_encode($ret);
					
				}
				
				
			}
			
			
			
			
			private function Import_refresher_bqm_file($file_name,$batch_id)
			{
				$current_user = get_user_id();
				$file_path = './uploads/training_nesting/'.$file_name;
						
				$curDateTime   = CurrMySqlDate();
				$log = get_logs();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_bqm_refresher_design";
				$data['design']['name'] = $design_name = "Refresher BQM";
				$data['design']['kpi'] = $design_kpi = "training_bqm_refresher_kpi";
				$data['design']['data'] = $design_data = "training_bqm_refresher_data";
				$data['design']['url']['design'] = $url_design = "refresher_bqm_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_bqm_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_bqm_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_bqm_DesignForm";
						
						
				// GET RAG DID FROM BATCH
				$qSqlb="SELECT tb.*,
						c.shname as client_name, 
						p.name as process_name, 
						batch_name, batch_office_id, 
						CONCAT(fname,' ' ,lname) as trainer_name, 
						office_id, batch_office_id, batch_name from training_batch tb 
						LEFT JOIN client c ON  c.id=tb.client_id 
						LEFT JOIN process p ON  p.id=tb.process_id 
						LEFT JOIN signin ON  signin.id=tb.trainer_id
						where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batch_id'";
				
				$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
				$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
				$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
				$pmdid = $pm_batch_rowb['id'];
					
				
				// GET KPI DETAILS
				$qSql = "Select * from $design_kpi kp where did = $pmdid";
				$kpiarray=$this->Common_model->get_query_result_array($qSql);
				foreach($kpiarray as $tokeni)
				{
					$countkpi++;
					//$kpiid = $tokeni['id'];
					$kpidata[$countkpi] = $tokeni['id'];
				}
				
				//$this->load->library('excel');
				$inputFileType = PHPExcel_IOFactory::identify($file_path);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load($file_path);
				
				/* $i = 0;
				while ($objPHPExcel->setActiveSheetIndex($i)){
				echo $i; */
				$objPHPExcel->setActiveSheetIndex(0);
				$objWorksheet = $objPHPExcel->getActiveSheet();

				//now do whatever you want with the active sheet
				$highestRow = $objWorksheet->getHighestRow();
				$highestColumn = $objWorksheet->getHighestColumn();
				$worksheetTitle = $objWorksheet->getTitle();
				
				if((ord($highestColumn) - ord('C')) == $countkpi){
				
				$startcol = ord('D');
				$lastCol  = ord($highestColumn);
				
				// GET RAG DATA ARRAY
				$rag_data = array();
				for($row = 3; $row <= $highestRow; $row++)
				{
					$totaluser++;
					$startcol = ord('D');
					for($j=1; $j<=$countkpi; $j++)
					{
					  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
					  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
					  $startcol++;
					}
				}
				
				//echo "hi";
				//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
			
				// DATA INSERTION START
				$this->db->trans_begin();
				for($starti=3; $starti <= $totaluser+2; $starti++)
				{
					$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
					$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
					
					$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
					$user_id   = $this->Common_model->get_single_value($qSql);
					if($user_id != ""){
					for($j=1; $j<=$countkpi; $j++)
					{   

						$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ntdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
						$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
						
						$field_array = array(
									"user_id"    => $user_id,
									"trn_batch_id" => $batch_id,
									"ntdid"     => $pmdid,
									"kpi_id"     => $kpidata[$j],
									"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
									"added_by"   => $current_user,
									"added_date" => $curDateTime,
									"uplog"      => $log
								);
						
						if($uploadcheck != ""){
							
							$this->db->where('id', $uploadcheck);
							$this->db->update($design_data,$field_array);
							
							
						} else {
							
							data_inserter($design_data,$field_array);
						
						}
					
						//print_r($field_array);die();$_run = false;					
						
					}	
					}		
					
				}
				
				//return "done";
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					return "error";
				}
				else
				{
					$this->db->trans_commit();
					return "done";
				}
				
				} else {
					return "error";
				}
				
				
			}
			
			public function getFormatDesign_refresher_bqm()
			{
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_bqm_refresher_design";
				$data['design']['name'] = $design_name = "Refresher BQM";
				$data['design']['kpi'] = $design_kpi = "training_bqm_refresher_kpi";
				$data['design']['data'] = $design_data = "training_bqm_refresher_data";
				$data['design']['url']['design'] = $url_design = "refresher_bqm_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_bqm_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_bqm_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_bqm_DesignForm";
				
				$batchid = trim($this->input->get('batchid'));
				$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
				$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
				
				$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
				$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
				
				$pmdid = $pm_batch_rowb['id'];
				if($pmdid != ""){
					echo $pmdid;
				} else { echo "0"; }
			}
			
			
		   public function get_clients_refresher_bqm()
		   {
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_bqm_refresher_design";
				$data['design']['name'] = $design_name = "Refresher BQM";
				$data['design']['kpi'] = $design_kpi = "training_bqm_refresher_kpi";
				$data['design']['data'] = $design_data = "training_bqm_refresher_data";
				$data['design']['url']['design'] = $url_design = "refresher_bqm_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_bqm_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_bqm_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_bqm_DesignForm";
				
				$office_id = $this->input->post('office_id');
				if($office_id != 'ALL')
				{
					$qSql="SELECT DISTINCT c.id, c.shname FROM $design_table as d
					LEFT JOIN client as c ON c.id=d.client_id
					WHERE d.office_id = '".$office_id."'";
				}
				else
				{
					$qSql="SELECT DISTINCT c.id, c.shname FROM $design_table as d
					LEFT JOIN client as c ON c.id=d.client_id";
				}
				echo json_encode($this->Common_model->get_query_result_array($qSql));
		   }
		
		
		
		
			/*------------------------------- RECURSIVE --------------------------------*/
		//////////////////////// SOFT SKILLS DESIGN /////////////////////////////////////////


				public function refresher_soft_design()
				{
					if(check_logged_in())
					{
						$current_user     = get_user_id();
						$user_site_id     = get_user_site_id();
						$user_office_id   = get_user_office_id();
						$user_oth_office  = get_user_oth_office();
						$is_global_access = get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$role_dir         = get_role_dir();
						$role_id          = get_role_id();
						$get_dept_id      = get_dept_id();
						
						$data["aside_template"]   = "training/aside.php";
						$data["content_template"] = "training/refresher_soft_design.php";
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_soft_skills_design";
						$data['design']['name'] = $design_name = "Refresher Soft";
						$data['design']['kpi'] = $design_kpi = "training_soft_skills_kpi";
						$data['design']['data'] = $design_data = "training_soft_skills_data";
						$data['design']['url']['design'] = $url_design = "refresher_soft_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_soft_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_soft_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_soft_DesignForm";
						
						//=========== OFFICE > CLIENT > PROCESS FILTER
						$oValue = trim($this->input->post('office_id'));
						if($oValue=="") $oValue = trim($this->input->get('office_id'));
						
						$cValue = trim($this->input->post('client_id'));
						if($cValue=="") $cValue = trim($this->input->get('client_id'));
						if($cValue=="") $cValue="0";
						
						$pValue = trim($this->input->post('process_id'));
						if($pValue=="") $pValue = trim($this->input->get('process_id'));
						
						$data['oValue']=$oValue;
						$data['cValue']=$cValue;
						$data['pValue']=$pValue;
												
						$_filterCond="";
						//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
						//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
						//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
						
						if($oValue!="ALL" && $oValue!="") 
						$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
						LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
						else $qSql=" Select id as client_id, shname from client where is_active='1'";	
						$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
						
						$qSqlall="Select id as client_id, shname from client where is_active='1'";	
						$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
										
						$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
						$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
						
						$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
						$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
						
						if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
						else $data['process_list'] = $this->Common_model->get_process_for_assign();
						
						if($is_global_access==1){
							$data['location_list'] = $this->Common_model->get_office_location_list();
						}else{
							$sCond=" WHERE id = '$user_site_id'";
							$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
						}
						
						//============ FORM URL DATA
						$data['hide_normal'] = "off";
						$url_batch_id = "";
						$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
						if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
						$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
						if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
						$data['url_batch_id'] = $url_batch_id;
						
							
						$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
							(SELECT name from process y where y.id = b.process_id) as process_name,
							(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
							(SELECT shname from client c where c.id = b.client_id) as client_name 
							from training_batch as b WHERE b.id = '$url_batch_id'";
						$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
							
						// CHECK ANY PREVIOUS DESIGN
						$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
						$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
						if($pv_rag != ""){
							$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
							$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
						}
						
						// GET DESIGN DATA
						$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp WHERE is_active=1 AND trn_batch_id = '$url_batch_id' $_filterCond";
						$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
						
						$pmkpiarray=array();
						foreach($design_row as $row):
							$mp_id= $row['mp_id'];
							$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
							$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
						endforeach;
						
						$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
						
						//loading training javascript
						//$data["content_js"] = "training/cert_design_js.php";
					
						$this->load->view('dashboard',$data);
						
					}
				}
				
				
			
			   public function add_refresher_soft_Design()
			   {
					if(check_logged_in())
					{
									
						$user_site_id  = get_user_site_id();
						$srole_id      = get_role_id();
						$current_user  = get_user_id();
						$ses_dept_id   = get_dept_id();
						
						$user_office_id   = get_user_office_id();
						$is_global_access = get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$curDateTime      = CurrMySqlDate();
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_soft_skills_design";
						$data['design']['name'] = $design_name = "Refresher Soft";
						$data['design']['kpi'] = $design_kpi = "training_soft_skills_kpi";
						$data['design']['data'] = $design_data = "training_soft_skills_data";
						$data['design']['url']['design'] = $url_design = "refresher_soft_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_soft_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_soft_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_soft_DesignForm";
						
						$_run = false;  
						
						$log = get_logs();
						
						$batch_id    = trim($this->input->post('trn_batch_id'));
						$office_id    = trim($this->input->post('office_id'));
						$client_id    = trim($this->input->post('client_id'));
						$process_id   = trim($this->input->post('process_id'));
						$description  = trim($this->input->post('description'));
						$kpi_name_arr = $this->input->post('kpi_name');
						$kpi_type_arr = $this->input->post('kpi_type');
						
						
						$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
						$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
						if($uploadcheck != "")
						{
							//redirect($_SERVER['HTTP_REFERER']);
							redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
							
						} else {
							
							$field_array = array(
								"trn_batch_id" => $batch_id,
								"office_id"    => $office_id,
								"client_id"    => $client_id,
								"process_id"   => $process_id,
								"description"  => $description,
								"added_by"     => $current_user,
								"is_active"    => '1',
								"added_date"   => $curDateTime,
								"uplog"        => $log
							);
							
							$did = data_inserter($design_table,$field_array);
							
							foreach($kpi_name_arr as $index => $kpi_name){
								if($kpi_name<>""){
									$field_array = array(
										"did" => $did,
										"kpi_name"    => $kpi_name,
										"kpi_type"    => $kpi_type_arr[$index],
										"isdel"       => '0',
										"added_by"    => $current_user,
										"added_date"  => $curDateTime,
										"uplog"       => $log
									);
									data_inserter($design_kpi,$field_array);
								}
							}
						
							redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
						}
				   }        
			   }
				
				
				public function get_refresher_soft_DesignForm()
				{
					if(check_logged_in())
					{
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_soft_skills_design";
						$data['design']['name'] = $design_name = "Refresher Soft";
						$data['design']['kpi'] = $design_kpi = "training_soft_skills_kpi";
						$data['design']['data'] = $design_data = "training_soft_skills_data";
						$data['design']['url']['design'] = $url_design = "refresher_soft_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_soft_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_soft_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_soft_DesignForm";
						
						$mdid = trim($this->input->post('mdid'));
						$mdid=addslashes($mdid);
						
						$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
						$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
						
						$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
						$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
							
						//$qSql="select * from pm_design where id = $mdid";
						//$design_row=$this->Common_model->get_query_row_array($qSql);
						
						$qSql="SELECT * from $design_kpi where did = $mdid";
						$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
						
						/////////
						$html = "";
						
						$TotRow = count($design_kpi_arr);
						
						$cnt = 1;
						foreach($design_kpi_arr as $kpiRow) {
						
							$html .= "<div class='col-md-12 kpi_input_row'>";					
							$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
							$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
							$html .= "<div class='col-md-5'><select class='form-control' name='kpi_type[]' > ";
							
							foreach($kpi_type_list as $kpimas){						
								$sCss="";
								if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
								$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
							}
											
							$html .= "</select></div>";							
							$html .= "<div class='col-md-2'>";						
								if( $cnt++<$TotRow){							
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
								}else{
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
									$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
								}
											
							$html .= "</div>";
							$html .= "</div>";
						
						}	
								
						echo $html;
					}
				}

			
			   public function update_refresher_soft_Design()
			   {
					if(check_logged_in())
					{
									
						$user_site_id  = get_user_site_id();
						$srole_id      = get_role_id();
						$current_user  = get_user_id();
						$ses_dept_id   = get_dept_id();
						
						$user_office_id   = get_user_office_id();
						$is_global_access = get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$curDateTime      = CurrMySqlDate();
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_soft_skills_design";
						$data['design']['name'] = $design_name = "Refresher Soft";
						$data['design']['kpi'] = $design_kpi = "training_soft_skills_kpi";
						$data['design']['data'] = $design_data = "training_soft_skills_data";
						$data['design']['url']['design'] = $url_design = "refresher_soft_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_soft_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_soft_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_soft_DesignForm";
						
						$_run = false;  
						
						$log = get_logs();
						$mdid = trim($this->input->post('mdid'));
						
						$batch_id  = trim($this->input->post('batch_id'));
						$office_id  = trim($this->input->post('office_id'));
						$client_id  = trim($this->input->post('client_id'));
						$process_id = trim($this->input->post('process_id'));
						$description = trim($this->input->post('description'));
						
						$kpi_id_arr   = $this->input->post('kpi_id');
						$kpi_name_arr = $this->input->post('kpi_name');
						$kpi_type_arr = $this->input->post('kpi_type');
						
						$field_array = array(
							"office_id"   => $office_id,
							"client_id"   => $client_id,
							"process_id"  => $process_id,
							"description" => $description,
							"added_by"    => $current_user,
							"is_active"   => '1',
							"added_date"  => $curDateTime,
							"uplog"       => $log
						);
						
						$this->db->where('id', $mdid);
						$this->db->update($design_table,$field_array);
						
						$TotID = count($kpi_id_arr);
						
						// DELETE DESIGN
						$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
						$query = $this->db->query($sql);
						
						foreach($kpi_name_arr as $index => $kpi_name)
						{
							if($kpi_name != "")
							{						
								$field_array = array(
									"did"         => $mdid,
									"kpi_name"    => $kpi_name,
									"kpi_type"    => $kpi_type_arr[$index],
									"isdel"       => '0',
									"added_by"    => $current_user,
									"added_date"  => curDateTime,
									"uplog"       => $log
								);
								
								data_inserter($design_kpi, $field_array);						
							}
						}
						
						
						redirect($_SERVER['HTTP_REFERER']);
						
					}
			   }




				public function refresher_soft_summary(){
					
					if(check_logged_in())
					{
						
						$current_user = get_user_id();
						$evt_date = CurrMySqlDate();

						$user_site_id= get_user_site_id();
						$user_office_id= get_user_office_id();
						
						//echo $user_office_id;
						
						$user_oth_office=get_user_oth_office();
						$is_global_access=get_global_access();
						if(global_access_training_module()==true)$is_global_access="1";
						$is_role_dir=get_role_dir();
						$get_dept_id=get_dept_id();
						
						//=========== SET TABLES AND NAME
						$data['design']['table'] = $design_table = "training_soft_skills_design";
						$data['design']['name'] = $design_name = "Refresher Soft";
						$data['design']['kpi'] = $design_kpi = "training_soft_skills_kpi";
						$data['design']['data'] = $design_data = "training_soft_skills_data";
						$data['design']['url']['design'] = $url_design = "refresher_soft_design";
						$data['design']['url']['add_design'] = $url_add_design = "add_refresher_soft_Design";
						$data['design']['url']['update_design'] = $url_update_design = "update_refresher_soft_Design";
						$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_soft_DesignForm";
						
						$batch="";
						$cond="";
						$filterCond="";
						$filterCond2="";
						$filterCond3 = "";
						$filterCond4 = " and trn_batch_status = '1' ";
						
						$data["aside_template"] = "training/aside.php";
						$data["content_template"] = "training/refresher_soft_details.php";
						
						$oValue = trim($this->input->get('office_id'));
						if($oValue=="") $oValue = trim($this->input->get('office_id'));
						if($oValue=="" ) $oValue=$user_office_id;
						$data['oValue']=$oValue;
						
						if($oValue!="ALL" ){
								$filterCond = " and batch_office_id='$oValue' ";
								$filterCond2 = " and location_id='$oValue' ";
						}
						
						if($this->input->get('searchtraining'))
						{
							$daterange_full = $this->input->get('daterange');
							$daterange_explode = explode('-',$daterange_full);
							$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
							$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
							$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
							$filterCond4 = "";
							
						}	
						
						//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
						
						if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training")){
							
							$qSql="SELECT tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id
							from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id 
							WHERE trn_type=5 $filterCond $filterCond4 $filterCond3 ORDER by tb.id desc";
							
							$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
							
						}else{
							$qSql="SELECT tb.*, c.shname as client_name , p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
							from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id
							WHERE trainer_id='$current_user' and trn_type=5 $filterCond4 $filterCond3 ORDER by tb.id desc";
							
							$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
						}
						
						$i = 0;
						$AllBatchArray = array();
						foreach($assigned_batch as $token)
						{
							
							$batch_id= $token['id'];
							$location= $token['location'];
							$key = $location."-".$batch_id;
							
							$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
							from training_batch tb 
							LEFT JOIN client c ON  c.id=tb.client_id 
							LEFT JOIN process p ON  p.id=tb.process_id 
							LEFT JOIN signin ON  signin.id=tb.trainer_id 
							WHERE trn_type=5 AND tb.id = '$batch_id' $filterCond4";
							$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
							
							$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
							$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
							
							$pmdid = $pm_batch_rowb['id'];
							$assigned_batch[$i]['batchid'] = $pmdid;
							
							$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
							$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
							
							$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
							$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
							
							$assigned_batch[$i]['batchid_rag'] = $querydesign;
							$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
							
							$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
							$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
							
							$data['checkupload'][$batch_id] = '0';
							
							foreach($AllBatchArray[$key] as $tokenuser)
							{
								$userget_id = $tokenuser['user_id'];
								$jcheck = 0;
								
								// GET MULTIPLE VALUE CHECK
								$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ntdid, kpi_id ORDER by ID DESC LIMIT 1";
								$querym = $this->Common_model->get_single_value($sqlm);
								$assigned_batch[$i]['checksum'][$userget_id] = $querym;
								
								if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
								if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
								
								foreach($querydesignkpi as $tokenarray)
								{
									$ragdid = $tokenarray['did'];
									$kpiid = $tokenarray['id'];
									$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ntdid = '$ragdid' AND kpi_id = '$kpiid'";
									$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
									$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
									$jcheck++;
								}
							}
							
							
							$i++;
						}
						
						$data["assigned_batch"] = $assigned_batch;
						$data["AllBatchArray"] = $AllBatchArray;
						
						// GET KPI DETAILS
						//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
						
						if($is_global_access==1) $data['location_list'] = $this->Common_model->get_office_location_list();
						else $data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
									
						$this->load->view('dashboard',$data);
						
						
					}
					
						
				}

					
			public function download_refresher_soft_Header()
			{
				
				$batchid = "";
				$pmdid = trim($this->input->get('pmdid'));
				$batchid = trim($this->input->get('batchid'));
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_soft_skills_design";
				$data['design']['name'] = $design_name = "Refresher Soft";
				$data['design']['kpi'] = $design_kpi = "training_soft_skills_kpi";
				$data['design']['data'] = $design_data = "training_soft_skills_data";
				$data['design']['url']['design'] = $url_design = "refresher_soft_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_soft_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_soft_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_soft_DesignForm";
				
					
				if($batchid != "")
				{
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batchid'";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					$pmdid = $pm_batch_rowb['id'];
					
				}
				
				
				if($pmdid != ""){
					
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
					
				$pm_design_row = $this->Common_model->get_query_row_array($qSql);
				
				$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
				$fn = str_replace("/","_",$fn);
				$sht_title= $fn;
				 
				if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
				$filename = "./assets/reports/".$fn.".xls";
				$title = $fn;
				
				
				$letters = array(); 
				$k=0;
				 for ($i = 'A'; $i !== 'ZZ'; $i++){
					$letters[$k++]=$i;
				}
				
				
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle($sht_title);
				//set cell A1 content with some text
			
				$this->excel->getActiveSheet()->setCellValue('A1', $title);
			
				//change the font size
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				//make the font become bold
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				
				$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
				$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
				$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
				
				$j=3;
				$r=2;
				
				$mp_id=$pm_design_row['mp_id'];
				
				$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
				$kpiarray=$this->Common_model->get_query_result_array($qSql);
				
				foreach($kpiarray as $row):
				
					$cell=$letters[$j++].$r;
					//echo $cell .">>";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
					
				endforeach;
				
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
				ob_end_clean();
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
				} else {
					redirect($_SERVER['HTTP_REFERER']);
				}
				
				
			}
			
			
			
			
			
			/// DOWNLOAD NESTING RESULT
					
			public function download_refresher_soft_Result()
			{
				
				$batchid = "";
				$pmdid = trim($this->input->get('pmdid'));
				$batchid = trim($this->input->get('batchid'));
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_soft_skills_design";
				$data['design']['name'] = $design_name = "Refresher Soft";
				$data['design']['kpi'] = $design_kpi = "training_soft_skills_kpi";
				$data['design']['data'] = $design_data = "training_soft_skills_data";
				$data['design']['url']['design'] = $url_design = "refresher_soft_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_soft_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_soft_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_soft_DesignForm";
				
					
				if($batchid != "")
				{
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batchid'";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					
				}
				
				
				if($pmdid != ""){
					
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
					
				$pm_design_row = $this->Common_model->get_query_row_array($qSql);
				
				$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
				$fn = str_replace("/","_",$fn);
				$sht_title= $fn;
				 
				if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
				$filename = "./assets/reports/".$fn.".xls";
				$title = $fn;
				
				
				$letters = array(); 
				$k=0;
				 for ($i = 'A'; $i !== 'ZZ'; $i++){
					$letters[$k++]=$i;
				}
				
				
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle($sht_title);
				//set cell A1 content with some text
			
				$this->excel->getActiveSheet()->setCellValue('A1', $title);
			
				//change the font size
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				//make the font become bold
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				
				$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
				$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
				$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
				
				$j=3;
				$r=2;
				
				$mp_id=$pm_design_row['mp_id'];
				
				$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
				$kpiarray=$this->Common_model->get_query_result_array($qSql);
				
				foreach($kpiarray as $row):
				
					$cell=$letters[$j++].$r;
					//echo $cell .">>";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
					
				endforeach;
				
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
				ob_end_clean();
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
				} else {
					redirect($_SERVER['HTTP_REFERER']);
				}
				
				
			}
			
			
			
			public function upload_refresher_soft_Result()
			{
				
				if(check_logged_in())
				{
					$user_site_id= get_user_site_id();
					$role_id= get_role_id();
					$current_user = get_user_id();
					
					$batch_id = trim($this->input->post('batch_id'));
								 
					$ret = array();
					
					if($batch_id!=""){
					
						$output_dir = "uploads/training_nesting/";
									
						$error =$_FILES["sktfile"]["error"];
						//You need to handle  both cases
						//If Any browser does not support serializing of multiple files using FormData() 
						if(!is_array($_FILES["sktfile"]["name"])) //single file
						{
							//$fileName = time().$_FILES["sktfile"]["name"];
							$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
							
							move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
							
							$ret[]= $this->Import_refresher_soft_file($fileName,$batch_id);
							
							
						}
						else  //Multiple files, file[]
						{
						  $fileCount = count($_FILES["sktfile"]["name"]);
						  for($i=0; $i < $fileCount; $i++)
						  {
							//$fileName = time().$_FILES["sktfile"]["name"][$i];
							$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
							
							move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
							
							$ret[]= $this->Import_refresher_soft_file($fileName,$batch_id);
							
						  }
						
						}
					}else{
							$ret[]="error";
							
					}
					
					echo json_encode($ret);
					
				}
				
				
			}
			
			
			
			
			private function Import_refresher_soft_file($file_name,$batch_id)
			{
				$current_user = get_user_id();
				$file_path = './uploads/training_nesting/'.$file_name;
						
				$curDateTime   = CurrMySqlDate();
				$log = get_logs();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_soft_skills_design";
				$data['design']['name'] = $design_name = "Refresher Soft";
				$data['design']['kpi'] = $design_kpi = "training_soft_skills_kpi";
				$data['design']['data'] = $design_data = "training_soft_skills_data";
				$data['design']['url']['design'] = $url_design = "refresher_soft_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_soft_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_soft_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_soft_DesignForm";
						
						
				// GET RAG DID FROM BATCH
				$qSqlb="SELECT tb.*,
						c.shname as client_name, 
						p.name as process_name, 
						batch_name, batch_office_id, 
						CONCAT(fname,' ' ,lname) as trainer_name, 
						office_id, batch_office_id, batch_name from training_batch tb 
						LEFT JOIN client c ON  c.id=tb.client_id 
						LEFT JOIN process p ON  p.id=tb.process_id 
						LEFT JOIN signin ON  signin.id=tb.trainer_id
						where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batch_id'";
				
				$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
				$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
				$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
				$pmdid = $pm_batch_rowb['id'];
					
				
				// GET KPI DETAILS
				$qSql = "Select * from $design_kpi kp where did = $pmdid";
				$kpiarray=$this->Common_model->get_query_result_array($qSql);
				foreach($kpiarray as $tokeni)
				{
					$countkpi++;
					//$kpiid = $tokeni['id'];
					$kpidata[$countkpi] = $tokeni['id'];
				}
				
				//$this->load->library('excel');
				$inputFileType = PHPExcel_IOFactory::identify($file_path);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load($file_path);
				
				/* $i = 0;
				while ($objPHPExcel->setActiveSheetIndex($i)){
				echo $i; */
				$objPHPExcel->setActiveSheetIndex(0);
				$objWorksheet = $objPHPExcel->getActiveSheet();

				//now do whatever you want with the active sheet
				$highestRow = $objWorksheet->getHighestRow();
				$highestColumn = $objWorksheet->getHighestColumn();
				$worksheetTitle = $objWorksheet->getTitle();
				
				if((ord($highestColumn) - ord('C')) == $countkpi){
				
				$startcol = ord('D');
				$lastCol  = ord($highestColumn);
				
				// GET RAG DATA ARRAY
				$rag_data = array();
				for($row = 3; $row <= $highestRow; $row++)
				{
					$totaluser++;
					$startcol = ord('D');
					for($j=1; $j<=$countkpi; $j++)
					{
					  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
					  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
					  $startcol++;
					}
				}
				
				//echo "hi";
				//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
			
				// DATA INSERTION START
				$this->db->trans_begin();
				for($starti=3; $starti <= $totaluser+2; $starti++)
				{
					$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
					$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
					
					$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
					$user_id   = $this->Common_model->get_single_value($qSql);
					if($user_id != ""){
					for($j=1; $j<=$countkpi; $j++)
					{   

						$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ntdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
						$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
						
						$field_array = array(
									"user_id"    => $user_id,
									"trn_batch_id" => $batch_id,
									"ntdid"     => $pmdid,
									"kpi_id"     => $kpidata[$j],
									"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
									"added_by"   => $current_user,
									"added_date" => $curDateTime,
									"uplog"      => $log
								);
						
						if($uploadcheck != ""){
							
							$this->db->where('id', $uploadcheck);
							$this->db->update($design_data,$field_array);
							
							
						} else {
							
							data_inserter($design_data,$field_array);
						
						}
					
						//print_r($field_array);die();$_run = false;					
						
					}	
					}		
					
				}
				
				//return "done";
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					return "error";
				}
				else
				{
					$this->db->trans_commit();
					return "done";
				}
				
				} else {
					return "error";
				}
				
				
			}
			
			public function getFormatDesign_refresher_soft()
			{
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_soft_skills_design";
				$data['design']['name'] = $design_name = "Refresher Soft";
				$data['design']['kpi'] = $design_kpi = "training_soft_skills_kpi";
				$data['design']['data'] = $design_data = "training_soft_skills_data";
				$data['design']['url']['design'] = $url_design = "refresher_soft_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_soft_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_soft_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_soft_DesignForm";
				
				$batchid = trim($this->input->get('batchid'));
				$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batchid'";
				$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
				
				$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
				$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
				
				$pmdid = $pm_batch_rowb['id'];
				if($pmdid != ""){
					echo $pmdid;
				} else { echo "0"; }
			}
			
			
		   public function get_clients_refresher_soft()
		   {
			    //=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_soft_skills_design";
				$data['design']['name'] = $design_name = "Refresher Soft";
				$data['design']['kpi'] = $design_kpi = "training_soft_skills_kpi";
				$data['design']['data'] = $design_data = "training_soft_skills_data";
				$data['design']['url']['design'] = $url_design = "refresher_soft_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_refresher_soft_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_refresher_soft_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_refresher_soft_DesignForm";
				
				$office_id = $this->input->post('office_id');
				if($office_id != 'ALL')
				{
					$qSql="SELECT DISTINCT c.id, c.shname FROM $design_table as d
					LEFT JOIN client as c ON c.id=d.client_id
					WHERE d.office_id = '".$office_id."'";
				}
				else
				{
					$qSql="SELECT DISTINCT c.id, c.shname FROM $design_table as d
					LEFT JOIN client as c ON c.id=d.client_id";
				}
				echo json_encode($this->Common_model->get_query_result_array($qSql));
		   }
		
		
		
		//================= PROBATION COMPLETE MAIL ========================================//

		public function get_probation_complete_users()
		{
			$current_date = date('Y-m-d');
			$next_date = date('Y-m-d', strtotime($current_date . " + 1 day"));
			
			$to_name = 'L1 Supervisor';
			$ecc[] = "sachin.paswan@fusionbposervices.com";
			
			$root_app_path = ""; //FCPATH
			$file_location = $root_app_path ."assets/docs_master/confirmation_form.xlsx";
			
			$sqlp = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as employee_name, d.description as department_name,
					o.prov_period_day as probation_period, s.doj as date_of_joining, 
					DATE_ADD(DATE(s.doj), INTERVAL o.prov_period_day DAY) as date_of_probation,
					s.assigned_to, concat(sg.fname, ' ', sg.lname) as assigned_to_name, sg.email_id as assigned_to_email
					from signin as s
				    LEFT JOIN signin as sg ON sg.id = s.assigned_to
					LEFT JOIN department as d ON s.dept_id = d.id
					LEFT JOIN office_location as o ON o.abbr = s.office_id 
					WHERE (s.doj IS NOT NULL OR s.doj <> '' OR s.doj <> '0000-00-00') 
					AND (s.assigned_to IS NOT NULL OR s.assigned_to <> '') AND (sg.email_id IS NOT NULL AND sg.email_id <> '')
					AND (DATE_ADD(DATE(s.doj), INTERVAL o.prov_period_day DAY) = '$current_date')";
			$queryp = $this->Common_model->get_query_result_array($sqlp);
			
			echo $sqlp ."<br/>Total Users - " .count($queryp) ."<br/><hr/><br/>";
			
			foreach($queryp as $token)
			{
				$user_id            = $token['user_id'];
				$fusion_id          = $token['fusion_id'];
				$employee_name      = $token['employee_name'];
				$employee_department = $token['department_name'];
				$probation_period   = $token['probation_period'];
				$employee_probation = $token['date_of_probation'];
				$employee_joining   = $token['date_of_joining'];
				
				$email_subject = "Employee Confirmation " .$fusion_id.", " .$employee_name;
				$to_email = "sachin.paswan@fusionbposervices.com";
				
				$attach_file = "";
				$attach_file = $root_app_path ."assets/docs_master/".$fusion_id."_confirmation_form.xlsx";
				copy($file_location, $attach_file);
				
				$nbody   = 'Dear <b>'.$to_name.'</b>,</br></br>
							This is to notify you that below mentioned employee has completed '.round($probation_period/30).' months from your team. Kindly fill up the attached assessment sheet and score him on basis of their last '.round($probation_period/30).' months performance.
							Submit the file to ER/HR Team to get the confirmation status.		
							</br></br>';
				
				$nbody   .=	'Employee ID : ' .$fusion_id .'<br/>
							 Employee Name : ' .$employee_name .'<br/>
							 Department : ' .$employee_department .'<br/>
							 Date Of Joining : ' .$employee_joining .'<br/>
							 Probation Period : ' .round($probation_period/30) .' Months <br/>
							 Probation Ends : ' .$employee_probation .'<br/><br/>';
							
				$nbody   .=	'Regards, </br>
							<b>Fusion - Global HR Shared Services</b></br>';
							
				echo  $nbody ."<br/><hr/><br/>";
				
				//$this->Email_model->send_email_sox($user_id,$to_email,implode(',',$ecc),$nbody,$email_subject, $attach_file, $from_email="noreply.fems@fusionbposervices.com",$from_name="Fusion FEMS", $isBcc="N");
				
				unlink($attach_file);
						
			}			
			
		}
		
		
		
/*------------------------------- RECURSIVE --------------------------------*/
//////////////////////// HANDOVER DESIGN /////////////////////////////////////////
		
		
		
		public function fetchHandoverBatchUsers(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$batch_id= trim($this->input->post('batchid'));
			if($batch_id != ""){
				
				$candidatesql = "SELECT * from training_details as d 
				                  LEFT JOIN training_batch as b ON b.id = d.trn_batch_id
								  LEFT JOIN signin as s ON s.id = d.user_id
								  WHERE  d.trn_batch_id = '$batch_id' AND d.trn_status = '3'";
				$candidatedata = $this->Common_model->get_query_result_array($candidatesql);
				//$candidatedata = candidate_details($batch_id);
				
			}
			echo json_encode($candidatedata);
			
		}
		}
		
		
		
		public function nesting_handover_check()
		{
			
			$batch_id             = $this->input->post('h_initial_batch_id');
			$trn_handover_phase   = $this->input->post('h_trn_handover_phase');
			$trn_handover_l1super = $this->input->post('h_trn_handover_l1super');
			$trn_handover_comment = $this->input->post('h_trn_handover_comment');
			//$trn_certifi_fail     = $this->input->post('h_trn_certifi_fail');
			$h_userSplitCheckBox  = $this->input->post('h_userSplitCheckBox');
			$curDateTime=CurrMySqlDate();
			$log = get_logs();
			
			// BATCH DETAILS
			//$sqlb = "SELECT * from training_batch WHERE id = '$batch_id'";
			//$trow = $this->Common_model->get_query_row_array($sqlb);
			
			
			foreach($h_userSplitCheckBox as $token)
			{
				
			$this->db->query("UPDATE signin set assigned_to='$trn_handover_l1super', phase='$trn_handover_phase', status=1 WHERE status in (1,4) and id = '$token'");
			$this->db->query("UPDATE training_details SET trn_status='$trn_handover_phase' WHERE trn_batch_id='$batch_id' AND user_id = '$token'");
			$this->db->query("UPDATE training_batch SET trn_handover_l1super='$trn_handover_l1super', trn_handover_phase='$trn_handover_phase', trn_handover_by='$current_user', trn_handover_date='$curDateTime', trn_comment='$trn_handover_comment', trn_batch_status='2'  WHERE id='$batch_id'");
				
				
			// FOR RECURSIVE HANDOVER
			if($trn_handover_phase == "7")
			{
				//$sqlpass = "INSERT INTO training_recursive_defaulters SET trn_batch_id = '$batch_id', user_id = '$token', trn_status = '7', trn_ref_type = 'N', trn_ref_id = '$batch_id', log = '$log', trn_remarks = '$trn_handover_comment', trainer_id = '$trn_handover_l1super'";
				//$querypass = $this->db->query($sqlpass);
			}				
				
			// FOR PRODUCTION HANDOVER
			if($trn_handover_phase == "4")
			{
				//$sqlpass = "UPDATE training_details SET trn_status = '6' WHERE user_id = '$token'";
				//$querypass = $this->db->query($sqlpass);
			}					
			}
			
			// CHECK BATCH STATUS
			//$sqlnesting_batch = "SELECT count(*) as value from training_details WHERE trn_status = '3' AND trn_batch_id = '$batch_id'";
			//$querynesting_batch = $this->Common_model->get_single_value($sqlnesting_batch);
			//if($querynesting_batch == 0)
			//{
				//$update_batch = "UPDATE training_batch SET trn_batch_status = '2' WHERE id = '$batch_id'";
				//$query = $this->db->query($update_batch);
			//}
			
			if($trn_handover_phase == "7")
			{
			$this->trn_handover_recursive($batch_id, $trn_handover_phase, $trn_handover_l1super, $trn_handover_comment, $h_userSplitCheckBox);
			}
			
			redirect($_SERVER['HTTP_REFERER']);
			
		}
		
		
		
		//-------------------------------------------------------------------------
		// RECURSIVE HANDOVER - FUNCTION CALL
		//-------------------------------------------------------------------------
		private function trn_handover_recursive($batch_id, $trn_handover_phase, $trn_handover_l1super, $trn_handover_comment, $batchUsers)
		{			
			if(check_logged_in()){
					
				$curDateTime   = CurrMySqlDate();
				$log = get_logs();	
				
				//COPY DATA FROM BATCH TO NEW BATCH ID
				$sqlnesting_handover = 	"INSERT into training_batch (trainer_id, trn_start_date, trn_type, ref_type, ref_id, client_id, process_id, trn_batch, trn_comment, trn_batch_status, hr_handover_by, hr_handover_date, batch_name, batch_office_id, log)
				SELECT '".$trn_handover_l1super."', trn_start_date, '4', 'T', '".$batch_id."', client_id, process_id, trn_batch, trn_comment, '1', hr_handover_by, hr_handover_date, batch_name, batch_office_id, log from training_batch
				where id = '$batch_id'";
				$this->db->query($sqlnesting_handover);
				$lastinsert_id = $this->db->insert_id();				
				
				foreach($batchUsers as $tokenu)
				{
					$sqlnesting_handover_d = "INSERT into training_details (trn_batch_id, user_id, trn_status, trn_note, transfer_from_batch_id, transfer_comments, trn_attrition, is_certify, log)
					SELECT '".$lastinsert_id."', user_id, '4', trn_note, '".$batch_id."', '".$trn_handover_comment."', trn_attrition, '0', log from training_details
					WHERE trn_batch_id = '$batch_id' AND user_id = '$tokenu'";
					$this->db->query($sqlnesting_handover_d);
				}			
				
			}
		}
		
		
		
		/****------------------ RECURSIVE DEFAULTERS --------------------****/
	
		public function recursive_defaulters()
		{
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				$current_scope = 1;
				$current_scope_get = $this->input->get('scope');
				if($current_scope_get != ""){ $current_scope  =  $current_scope_get; }
				$data['current_scope'] = $current_scope;
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/recursive_defaulters.php";
				
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = $user_office_id;
				$data['oValue'] = $oValue;
				
				if($oValue!="ALL")
				{
						$filterCond = " and location='$oValue' ";
						$filterCond2 = " and s.office_id='$oValue' ";
						$filterCond3 = " and sp.office_id='$oValue' ";
				}
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}
				
				
				if($current_scope == 1)
				{
					
					$sql_defaulters = "SELECT r.*, concat(s.fname, ' ', s.lname) as fullname, t.client_id, t.process_id, s.office_id, c.shname as client_name, p.name as process_name 
										from training_recursive_defaulters r 
										LEFT JOIN training_batch t ON t.id = r.trn_batch_id
										LEFT JOIN client c ON  c.id = t.client_id 
										LEFT JOIN process p ON  p.id = t.process_id 
										LEFT JOIN signin s ON s.id = t.trainer_id
										WHERE 1 $filterCond2 GROUP BY t.id ORDER BY t.client_id desc";
					$data['dafaulters'] =  $recursive_default = $this->Common_model->get_query_result_array($sql_defaulters);
					foreach($recursive_default as $tokendata)
					{
						$myt = $tokendata['trn_batch_id'];
						$sqlprocessdata = "SELECT r.*,s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, concat(sp.fname, ' ', sp.lname) as trainername, t.client_id, t.process_id, s.office_id, c.shname as client_name, p.name as process_name 
										from training_recursive_defaulters as r 
										LEFT JOIN training_batch as t ON t.id = r.trn_batch_id
										LEFT JOIN client as c ON  c.id = t.client_id 
										LEFT JOIN process as p ON  p.id = t.process_id 
										LEFT JOIN signin as s ON s.id = r.user_id
										LEFT JOIN signin as sp ON sp.id = r.trainer_id
										WHERE 1 $filterCond3 AND r.trn_batch_id = '$myt' ORDER BY t.client_id desc";
					   $data['process_data'][$myt] =  $queryprocssdata = $this->Common_model->get_query_result_array($sqlprocessdata);
					}
					
				
				}
				
							
				
				if($is_global_access==1) $data['location_list'] = $this->Common_model->get_office_location_list();
				else $data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				
				$this->load->view('dashboard',$data);
				
			}
		}
	
	
//=======================================================================================================	
//   CREATE NEW BATCH 
//=======================================================================================================

	public function create_batch()
	{
		if(check_logged_in())
		{
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$data["aside_template"] = "training/aside.php";
			$data["content_template"] = "training/create_batch.php";
			
			$data['batch_type'] = '2';
			$data['batch_list'] = 'training/crt_batch';
			
			// GET BATCH TYPE
			$batch_type = $this->uri->segment(3);
			if($batch_type == 'training')
			{
				$data['batch_type'] = '2';
				$data['batch_list'] = 'training/crt_batch';
			}
			
			if($batch_type == 'nesting')
			{
				$data['batch_type'] = '3';
				$data['batch_list'] = 'training/nesting';
			}
			
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			if($cValue=="") $cValue="0";
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['oValue']=$oValue;
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
									
			$_filterCond="";
			
			if($oValue!="ALL" && $oValue!="") $_filterCond = " And office_id='".$oValue."'";
			if($cValue!="ALL" && $cValue!="") $_filterCond .= " And client_id='".$cValue."'";
			if($pValue!="ALL" && $pValue!="") $_filterCond .= " And process_id='".$pValue."'";
			
			if($oValue!="ALL" && $oValue!="") $qSql="SELECT DISTINCT(id) as client_id,client.shname FROM client";
			else $qSql=" Select id as client_id, shname from client where is_active='1' ";	
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
			
			if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
			else $data['process_list'] = $this->Common_model->get_process_for_assign();
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			

			// SELECT TRAINER
			///$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name, office_id from signin where status=1 and (role_id not in (select id from role where folder='agent') OR dept_id=11) and office_id='$user_office_id' order by name asc ";
			//$data["assigned_l1super"] = $this->Common_model->get_query_result_array($qSql);
			
			
			if($is_global_access==1) $tr_cnd="";
			else $tr_cnd=" and ( s.office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',s.office_id,'%') ) ";
				
				
			$qSqlt = "SELECT s.id, s.fusion_id, d.shname as department, r.name as designation, concat(s.fname, ' ', s.lname) as name, s.office_id from signin s LEFT JOIN department d ON s.dept_id = d.id LEFT JOIN role r on r.id = s.role_id WHERE s.status=1 and (s.role_id not in (select id from role where folder='agent') OR s.dept_id=11) $tr_cnd ORDER BY name ASC ";			
			$data["select_trainer"]  = $this->Common_model->get_query_result_array($qSqlt);
						
			$qSql = "SELECT CONCAT(s.fname,' ' ,s.lname) as trainee_name, s.office_id, s.fusion_id, s.id as user_id from signin as s 
			         WHERE s.status IN (1,4) $tr_cnd 
					 AND s.role_id IN (SELECT id from role WHERE folder = 'agent') ORDER by trainee_name";
			$data["select_trainee"] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
			
			
		}
	
	}
	
	
	
	
	public function add_batch_form()
	{
		if(check_logged_in())
		{
						
			$user_site_id  = get_user_site_id();
			$srole_id      = get_role_id();
			$current_user  = get_user_id();
			$ses_dept_id   = get_dept_id();
			
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$curDateTime      = CurrMySqlDate();
			
			$log = get_logs();
			$batch_type = trim($this->input->post('training_type'));
						
			$office_id  = trim($this->input->post('office_id'));
			$client_id  = trim($this->input->post('client_id'));
			$process_id = trim($this->input->post('process_id'));
			$batch_name = trim($this->input->post('batch_name'));
			
			$training_type   = $this->input->post('training_type');
			$trainer_id   = $this->input->post('trainer_id');
			$trainee_id = $this->input->post('trainee_id_select');
			$unique_trainee_list = array_unique($trainee_id);
			$total_id = count($unique_trainee_list);
			$trn_start_date = CurrDate();			
			
			if($total_id > 0){
				
			$field_array = array(
				"trainer_id"   => $trainer_id,
				"trn_type"   => $training_type,
				"trn_start_date" => $trn_start_date,
				"ref_type"  => 'M',
				"client_id" => $client_id,
				"process_id" => $process_id,
				"batch_name" => $batch_name,
				"batch_office_id" => $office_id,
				"trn_batch_status" => '1',
				"log"       => $log
			);
			$insert_train = data_inserter('training_batch',$field_array);
			
			foreach($unique_trainee_list as $token_trainee){
								
				$field_array = array(
					"trn_batch_id" => $insert_train,
					"user_id"    => $token_trainee,
					"trn_status" => $training_type,
					"trn_note"   => 'Manually Added',
					"log"        => $log
				);
				data_inserter('training_details',$field_array);
					
			}
			
			}
			
			//2 = Training (New Hire)
			//3 = Nesting
			//4 = Recursive
			//5 = Upskill
			
			if($training_type==2) redirect(base_url()."training/crt_batch","refresh");
			else if($training_type==3) redirect(base_url()."training/nesting","refresh");
			else if($training_type==4) redirect(base_url()."training/recursive_batch","refresh");
			else if($training_type==5) redirect(base_url()."training/upskill_batch","refresh");
			else redirect($_SERVER['HTTP_REFERER']);
		
		}
	
	}
	
	




//////////////////////////// NESTING EXTRA TRAINING STARTS /////////////////////////////////////////////////	

	function move_batch_user_nesting()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$initial_batch_id = trim($this->input->post('initial_batch_id'));
			$move_to_batch_id = trim($this->input->post('move_to_batch_id'));
			$userCheckBox = $this->input->post('userCheckBox');
			$countcheckbox = count($userCheckBox);
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $userCheckBox[$i];
				$sqlq = "UPDATE training_details SET trn_batch_id = '$move_to_batch_id' WHERE user_id = '$getuserid' AND trn_batch_id = '$initial_batch_id'";
				$queryq = $this->db->query($sqlq);
			}
			redirect(base_url()."training/nesting","refresh");
		}		
	}
	
	
	function split_batch_user_nesting()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$curDateTime   = CurrMySqlDate();
			$log = get_logs();
		
			$split_initial_batch_id = trim($this->input->post('split_initial_batch_id'));
			$split_select_trainer_id = trim($this->input->post('split_select_trainer_id'));
			$split_initial_batch_name = trim($this->input->post('split_initial_batch_name'));
			$userSplitCheckBox = $this->input->post('userSplitCheckBox');
			$countcheckbox = count($userSplitCheckBox);
			
			if($countcheckbox > 0){
				
			//COPY DATA FROM BATCH TO NEW BATCH ID
			$sqlbatchcopy = "INSERT into training_batch (trainer_id, trn_start_date, trn_type, ref_type, ref_id, client_id, process_id, trn_batch, trn_comment, trn_batch_status, batch_name, batch_office_id, hr_handover_by, hr_handover_date, log)
			SELECT '".$split_select_trainer_id."', trn_start_date, trn_type, ref_type, ref_id, client_id, process_id, trn_batch, trn_comment, trn_batch_status, '".$split_initial_batch_name."', batch_office_id, hr_handover_by, hr_handover_date, log from training_batch
			where id = '$split_initial_batch_id'";
			$this->db->query($sqlbatchcopy);
			$lastinsert_id = $this->db->insert_id();
						
			}
			
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $userSplitCheckBox[$i];
				$sqlq = "UPDATE training_details SET trn_batch_id = '$lastinsert_id' WHERE user_id = '$getuserid' AND trn_batch_id = '$split_initial_batch_id'";
				$queryq = $this->db->query($sqlq);
			}
			
			redirect(base_url()."training/nesting","refresh");
		}		
	}
	
	
		
	
	/*======================== ADD NEW TRAINEE ================================*/
	public function addnewtraineebatch_nesting(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			$log = get_logs();
			
			$batch_id = $this->input->post('add_trainee_batch_id');
			$checkUser = $this->input->post('traineeNewCheckBox');
			$countcheckbox = count($checkUser);
			
			$sqlc = "SELECT trainer_id, process_id, client_id from training_batch WHERE id = '$batch_id'";
			$queryc = $this->Common_model->get_query_row_array($sqlc);
			
			$t_process_id = $queryc['process_id'];
			$t_client_id = $queryc['client_id'];
			$t_trainer_id = $queryc['trainer_id'];
			
			
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $checkUser[$i];
				
				//-- ADD TO TRAINING DETAILS
				$insert_array = array(
									"trn_batch_id" => $batch_id,
									"user_id" => $getuserid,
									"trn_note" => 'Manually Added',
									"trn_status" => '3',
									"is_certify" => '0',
									"log" => $log
								);
				data_inserter('training_details', $insert_array);
				
				//-- UPDATE SIGNIN
				$update_array = array(
									"phase" => '2',
									"assigned_to" => $t_trainer_id
								);
				$this->db->where('id', $getuserid);
				$this->db->update('signin', $update_array);
				
				//-- GET PREVIOUS LOGS
				$qSql = "SELECT log from signin WHERE id = '$getuserid'";
				$prevLog = getDBPrevLogs($qSql);
				$log = "Update Trainign Batch :: ". get_logs($prevLog);
				
				//-- UPDATE CLIENT
				$this->db->query('DELETE FROM info_assign_client WHERE user_id = "'.$getuserid.'"');	
				$field_array2 = array(
					"user_id" => $getuserid,
					"client_id" => $t_client_id,
					"log" => $log
				);
				$rowid= data_inserter('info_assign_client',$field_array2);
				
				//-- UPDATE PROCESS
				$this->db->query('DELETE FROM info_assign_process WHERE user_id = "'.$getuserid.'"');
				$field_array3 = array(
					"user_id" => $getuserid,
					"process_id" => $t_process_id,
					"log" => $log
				);
				$rowid= data_inserter('info_assign_process',$field_array3);
				
			}
			
			redirect(base_url()."training/nesting","refresh");
			
		}
	}
	
	
	
	public function fetchBatchlist_nesting(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$qSql = "Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type=3 order by tb.id desc";
			$querySql = $this->Common_model->get_query_result_array($qSql);
			echo json_encode($querySql);
			
		}
	}


	public function fetchBatchUsers_nesting(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$batch_id= trim($this->input->post('batchid'));
			if($batch_id != ""){
				$sqldata = "Select td.*, s.fname, s.lname, s.fusion_id, b.batch_name, b.batch_office_id from training_details as td
                            LEFT JOIN training_batch as b on b.id = td.trn_batch_id	
				            LEFT JOIN signin as s ON td.user_id = s.id where td.trn_batch_id = '$batch_id' AND trn_status = '3' order by fname";
				$candidatedata = $this->Common_model->get_query_result_array($sqldata);
			}
			echo json_encode($candidatedata);
			
		}
	}

	
	public function fetchBatchTraineeList_nesting(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$batch_id= trim($this->input->post('batchid'));
			
			if($batch_id != ""){
			$qSql = "SELECT CONCAT(s.fname,' ' ,s.lname) as trainee_name, s.office_id, s.fusion_id, s.id as user_id from signin as s 
			         WHERE s.id NOT IN (SELECT user_id from training_details WHERE trn_batch_id = '$batch_id') AND s.status IN (1,4) AND s.office_id = '$user_office_id'
					 AND s.role_id IN (SELECT id from role WHERE folder = 'agent') ORDER by trainee_name";
			$querySql = $this->Common_model->get_query_result_array($qSql);
			}
			echo json_encode($querySql);
			
		}
	}

//================================================================================================================================
//       RECURSIVE BATCH
//================================================================================================================================

	public function recursive_batch()
	{
		if(check_logged_in())
		{
			//=========== SET TABLES AND NAME
			$data['design']['table'] = $design_table = "training_recursive_design";
			$data['design']['name'] = $design_name = "Recursive";
			$data['design']['kpi'] = $design_kpi = "training_recursive_kpi";
			$data['design']['data'] = $design_data = "training_recursive_data";
			$data['design']['url']['design'] = $url_design = "recursive_design";
			$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Design";
			$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Design";
			$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_DesignForm";
				
			$todayDate=CurrDate();
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();

			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			
			//echo $user_office_id;
			
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();
			
			$batch="";
			$cond="";
			$filterCond="";
			$filterCond2="";
			$filterCond3 = "";
			$filterCond4 = " and trn_batch_status = '1' and is_incubation <> '1'";
			 
			$data["aside_template"] = "training/aside.php";
			$data["content_template"] = "training/recursive_batch.php";
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = $user_office_id;
			$data['oValue'] = $oValue;
			
			if($oValue!="ALL" ){
					$filterCond = " AND batch_office_id = '$oValue'";
					$filterCond2 = " and (location_id='$oValue') ";
			}
			
			
			
			if($this->input->get('searchtraining'))
			{
				$daterange_full = $this->input->get('daterange');
				$daterange_explode = explode('-',$daterange_full);
				$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
				$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
				$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
				//$filterCond4 = "";
				
			}	
			
			//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
						
			$qSql="Select id,name from master_term_type where is_active=1";
			$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,name from master_sub_term_type where is_active=1";
			$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,description from master_resign_reason where is_active=1";
			$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
			
			//$qSql="SELECT id, concat(fname, ' ', lname) as fullname from signin WHERE dept_id IN (11)";
			$qSql="SELECT id, concat(fname, ' ', lname) as fullname from signin WHERE dept_id IN (11)";
			$data['t_traineelist'] = $this->Common_model->get_query_result_array($qSql);
						
			if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
									
				//$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, (Select CONCAT(fname,' ' ,lname) from signin s where s.id=tb.trainer_id) as trainer_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' order by tb.id desc";
				
				$qSql="SELECT tb.*,c.shname, p.name, CONCAT(fname,' ' ,lname) as trainer_name, batch_office_id, batch_name from training_batch tb 
				       LEFT JOIN client c ON  c.id=tb.client_id 
					   LEFT JOIN process p ON  p.id=tb.process_id 
					   LEFT JOIN signin ON  signin.id=tb.trainer_id 
					   WHERE trn_type=4 $filterCond4 $filterCond3 $filterCond
					   ORDER by tb.id desc";
								
				$data["get_assigned_batch"] = $get_assigned_batch = $this->Common_model->get_query_result_array($qSql);
				
			} else {
				
				$myteamIDs = $this->get_team_id($current_user);
				$qSql="SELECT tb.*,c.shname, p.name, CONCAT(fname,' ' ,lname) as trainer_name, batch_office_id, batch_name from training_batch tb 
				       LEFT JOIN client c ON  c.id=tb.client_id 
					   LEFT JOIN process p ON  p.id=tb.process_id 
					   LEFT JOIN signin ON  signin.id=tb.trainer_id 
					   WHERE (trainer_id='$current_user' OR trainer_id IN ($myteamIDs)) and trn_type=4 $filterCond4 $filterCond3 
					   ORDER by tb.id desc";
				
				$data["get_assigned_batch"] = $get_assigned_batch = $this->Common_model->get_query_result_array($qSql);
			}
			
			$j=0;
			foreach($get_assigned_batch as $rowtoken)
			{
				$batch_id= $rowtoken['id'];
				$t_cid = $rowtoken['client_id'];
				$t_pid = $rowtoken['process_id'];
				
				$qSql="SELECT id, concat(fname, ' ', lname) as fullname from signin WHERE dept_id IN (11,6) AND client_id = '$t_cid' AND process_id = '$t_pid'";
				$data['t_traineelist_new'][$batch_id] = $this->Common_model->get_query_result_array($qSql);
								
				$getpmid_test = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
				$pm_batch_rowb_test = $this->Common_model->get_query_row_array($getpmid_test);
				$pmdid = $pm_batch_rowb_test['id'];
				
				$getpmid_test_rag = "SELECT id as value from training_recursive_rag_design WHERE trn_batch_id = '$batch_id'"; 
				$pmdidrag = $this->Common_model->get_single_value($getpmid_test_rag);
				
			
				$sqlcc = "Select td.*, s.*, yy.*, d.*, trm.*, ts.avg_rating_score, ts.trainee_id as survey_id, (Select name from event_master e where e.id=s.disposition_id) as disp_name 
				from training_details td
				LEFT JOIN training_post_classroom_survey ts on ts.trainee_id = td.user_id AND ts.training_batch = td.trn_batch_id				
				LEFT JOIN signin s on td.user_id = s.id
				LEFT JOIN 
				(select user_id as luid, sum(TIME_TO_SEC(timediff(logout_time,login_time))) as tLtime from logged_in_details where cast(login_time as date) = '".$todayDate."' and cast(logout_time as date) >= '".$todayDate."' group by user_id) yy on (td.user_id=yy.luid)
				LEFT JOIN 
				(select start_date,end_date,user_id as duid from event_disposition where start_date <= '".$todayDate."' and end_date >= '".$todayDate."' group by duid ) d on (td.user_id=d.duid)
				Left Join (select user_id as tuid, is_term_complete, max(terms_date) as terms_date from terminate_users where is_term_complete='Y' group by user_id ) trm ON (td.user_id=trm.tuid) where trn_batch_id = '$batch_id' AND trn_status = '4' order by fname";
				$data['candidate_details'][$batch_id] = $cdetails = $this->Common_model->get_query_result_array($sqlcc);
				
				
				// GET CANDIDATE DEAILS
				foreach($cdetails as $crow)
				{
					 $user_id= $crow['user_id'];
					 
					 // GET TRAINER DETAILS
					 $sqltrainerd = "SELECT concat(q.fname, ' ', q.lname) as fullname, q.id as userid from signin as q 
					 LEFT JOIN signin as s ON q.id = s.assigned_to WHERE s.id = '$user_id'";
					 $ctraineename = $this->Common_model->get_query_row_array($sqltrainerd);
					 $data['candidate_info'][$batch_id]['trainee'][$user_id]['id'] = $ctraineename['userid'];
					 $data['candidate_info'][$batch_id]['trainee'][$user_id]['name'] = $ctraineename['fullname'];
					 
				}
				
				$get_assigned_batch[$j]['designid'] = $pmdid;
				$get_assigned_batch[$j]['ragdesignid'] = $pmdidrag;
				$j++;
			}
			
			$data["get_assigned_batch"] = $get_assigned_batch;
			//echo "<pre>" .print_r($get_assigned_batch, true) ."</pre>";die();
			
			
			/////////////	
			$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name, office_id from signin where status=1 and ( role_id not in (select id from role where folder='agent') OR dept_id=11) and office_id='$user_office_id' order by name asc ";
			$data["assigned_l1super"] = $this->Common_model->get_query_result_array($qSql);
			//////////////
			
			$qSqlt = "SELECT s.id, s.fusion_id, d.shname as department, r.name as designation, concat(s.fname, ' ', s.lname) as name, s.office_id from signin s LEFT JOIN department d ON s.dept_id = d.id LEFT JOIN role r on r.id = s.role_id WHERE s.status=1 and (s.role_id not in (select id from role where folder='agent') OR s.dept_id=11) and s.office_id='$user_office_id' ORDER BY name ASC ";
			$data["assigned_trainerlist"]  = $this->Common_model->get_query_result_array($qSqlt);
		
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				if($this->check_all_training_access())
				{
					$access_office_ids = $this->check_all_training_access('office');
					$extra_access_office = implode("','", $access_office_ids);
					$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
					$query = $this->db->query($sql_office);
					$data['location_list'] = $query->result_array();
				}
			}
			
			$data['e_client_list'] = $this->Common_model->get_client_list();
			$data['e_process_list'] = $this->Common_model->get_process_for_assign();
				
			$this->load->view('dashboard',$data);
			
		}
	}
	
	
	function move_batch_user_recursive()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$initial_batch_id = trim($this->input->post('initial_batch_id'));
			$move_to_batch_id = trim($this->input->post('move_to_batch_id'));
			$userCheckBox = $this->input->post('userCheckBox');
			$countcheckbox = count($userCheckBox);
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $userCheckBox[$i];
				$sqlq = "UPDATE training_details SET trn_batch_id = '$move_to_batch_id' WHERE user_id = '$getuserid' AND trn_batch_id = '$initial_batch_id'";
				$queryq = $this->db->query($sqlq);
			}
			redirect(base_url()."training/recursive_batch","refresh");
		}		
	}
	
	
	function split_batch_user_recursive()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$curDateTime   = CurrMySqlDate();
			$log = get_logs();
		
			$split_initial_batch_id = trim($this->input->post('split_initial_batch_id'));
			$split_select_trainer_id = trim($this->input->post('split_select_trainer_id'));
			$split_initial_batch_name = trim($this->input->post('split_initial_batch_name'));
			$userSplitCheckBox = $this->input->post('userSplitCheckBox');
			$countcheckbox = count($userSplitCheckBox);
			
			if($countcheckbox > 0){
				
			//COPY DATA FROM BATCH TO NEW BATCH ID
			$sqlbatchcopy = "INSERT into training_batch (trainer_id, trn_start_date, trn_type, ref_type, ref_id, client_id, process_id, trn_batch, trn_comment, trn_batch_status, batch_name, batch_office_id, hr_handover_by, hr_handover_date, log)
			SELECT '".$split_select_trainer_id."', trn_start_date, trn_type, ref_type, ref_id, client_id, process_id, trn_batch, trn_comment, trn_batch_status, '".$split_initial_batch_name."', batch_office_id, hr_handover_by, hr_handover_date, log from training_batch
			where id = '$split_initial_batch_id'";
			$this->db->query($sqlbatchcopy);
			$lastinsert_id = $this->db->insert_id();
						
			}
			
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $userSplitCheckBox[$i];
				$sqlq = "UPDATE training_details SET trn_batch_id = '$lastinsert_id' WHERE user_id = '$getuserid' AND trn_batch_id = '$split_initial_batch_id'";
				$queryq = $this->db->query($sqlq);
			}
			
			redirect(base_url()."training/recursive_batch","refresh");
		}		
	}
	
	public function addnewtraineebatch_recursive(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			$log = get_logs();
			
			$batch_id = $this->input->post('add_trainee_batch_id');
			$checkUser = $this->input->post('traineeNewCheckBox');
			$countcheckbox = count($checkUser);
			
			$sqlc = "SELECT trainer_id, process_id, client_id from training_batch WHERE id = '$batch_id'";
			$queryc = $this->Common_model->get_query_row_array($sqlc);
			
			$t_process_id = $queryc['process_id'];
			$t_client_id = $queryc['client_id'];
			$t_trainer_id = $queryc['trainer_id'];
			
			
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $checkUser[$i];
				
				//-- ADD TO TRAINING DETAILS
				$insert_array = array(
									"trn_batch_id" => $batch_id,
									"user_id" => $getuserid,
									"trn_note" => 'Manually Added',
									"trn_status" => '4',
									"is_certify" => '0',
									"log" => $log
								);
				data_inserter('training_details', $insert_array);
				
				//-- UPDATE SIGNIN
				$update_array = array(
									"phase" => '2',
									"assigned_to" => $t_trainer_id
								);
				$this->db->where('id', $getuserid);
				$this->db->update('signin', $update_array);
				
				//-- GET PREVIOUS LOGS
				$qSql = "SELECT log from signin WHERE id = '$getuserid'";
				$prevLog = getDBPrevLogs($qSql);
				$log = "Update Trainign Batch :: ". get_logs($prevLog);
				
				//-- UPDATE CLIENT
				$this->db->query('DELETE FROM info_assign_client WHERE user_id = "'.$getuserid.'"');	
				$field_array2 = array(
					"user_id" => $getuserid,
					"client_id" => $t_client_id,
					"log" => $log
				);
				$rowid= data_inserter('info_assign_client',$field_array2);
				
				//-- UPDATE PROCESS
				$this->db->query('DELETE FROM info_assign_process WHERE user_id = "'.$getuserid.'"');
				$field_array3 = array(
					"user_id" => $getuserid,
					"process_id" => $t_process_id,
					"log" => $log
				);
				$rowid= data_inserter('info_assign_process',$field_array3);
				
			}
			
			redirect(base_url()."training/recursive_batch","refresh");
			
		}
	}
	
	
	
	public function fetchBatchlist_recursive(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$qSql = "Select tb.*,c.shname, p.name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_type=4 order by tb.id desc";
			$querySql = $this->Common_model->get_query_result_array($qSql);
			echo json_encode($querySql);
			
		}
	}


	public function fetchBatchUsers_recursive(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$batch_id= trim($this->input->post('batchid'));
			if($batch_id != ""){
				$sqldata = "Select td.*, s.fname, s.lname, s.fusion_id, b.batch_name, b.batch_office_id from training_details as td
                            LEFT JOIN training_batch as b on b.id = td.trn_batch_id	
				            LEFT JOIN signin as s ON td.user_id = s.id where td.trn_batch_id = '$batch_id' AND trn_status = '4' order by fname";
				$candidatedata = $this->Common_model->get_query_result_array($sqldata);
			}
			echo json_encode($candidatedata);
			
		}
	}

	
	public function fetchBatchTraineeList_recursive(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$batch_id= trim($this->input->post('batchid'));
			
			if($batch_id != ""){
			$qSql = "SELECT CONCAT(s.fname,' ' ,s.lname) as trainee_name, s.office_id, s.fusion_id, s.id as user_id from signin as s 
			         WHERE s.id NOT IN (SELECT user_id from training_details WHERE trn_batch_id = '$batch_id') AND s.status IN (1,4) AND s.office_id = '$user_office_id'
					 AND s.role_id IN (SELECT id from role WHERE folder = 'agent') ORDER by trainee_name";
			$querySql = $this->Common_model->get_query_result_array($qSql);
			}
			echo json_encode($querySql);
			
		}
	}

	public function recursive_design()
		{
			if(check_logged_in())
			{
				$current_user     = get_user_id();
				$user_site_id     = get_user_site_id();
				$user_office_id   = get_user_office_id();
				$user_oth_office  = get_user_oth_office();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$role_dir         = get_role_dir();
				$role_id          = get_role_id();
				$get_dept_id      = get_dept_id();
				
				$data["aside_template"]   = "training/aside.php";
				$data["content_template"] = "training/recursive_design.php";
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_design";
				$data['design']['name'] = $design_name = "Recursive";
				$data['design']['kpi'] = $design_kpi = "training_recursive_kpi";
				$data['design']['data'] = $design_data = "training_recursive_data";
				$data['design']['url']['design'] = $url_design = "recursive_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_DesignForm";
				
				//=========== OFFICE > CLIENT > PROCESS FILTER
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
										
				$_filterCond="";
				//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") 
				$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
				LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1'";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSqlall="Select id as client_id, shname from client where is_active='1'";	
				$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
								
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" WHERE id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				//============ FORM URL DATA
				$data['hide_normal'] = "off";
				$url_batch_id = "";
				$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
				if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
				$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
				if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
				$data['url_batch_id'] = $url_batch_id;
				
					
				$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
					(SELECT name from process y where y.id = b.process_id) as process_name,
					(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
					(SELECT shname from client c where c.id = b.client_id) as client_name 
					from training_batch as b WHERE b.id = '$url_batch_id'";
				$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
				// CHECK ANY PREVIOUS DESIGN
				$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
				$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
				if($pv_rag != ""){
					$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
					$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
				}
				
				// GET DESIGN DATA
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp WHERE is_active=1 AND trn_batch_id = '$url_batch_id' $_filterCond";
				$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
				
				$pmkpiarray=array();
				foreach($design_row as $row):
					$mp_id= $row['mp_id'];
					$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
				
				$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
				
				//loading training javascript
				//$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
	
	   public function add_recursive_Design()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_design";
				$data['design']['name'] = $design_name = "Recursive";
				$data['design']['kpi'] = $design_kpi = "training_recursive_kpi";
				$data['design']['data'] = $design_data = "training_recursive_data";
				$data['design']['url']['design'] = $url_design = "recursive_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_DesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				
				$batch_id    = trim($this->input->post('trn_batch_id'));
				$office_id    = trim($this->input->post('office_id'));
				$client_id    = trim($this->input->post('client_id'));
				$process_id   = trim($this->input->post('process_id'));
				$description  = trim($this->input->post('description'));
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
				$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				if($uploadcheck != "")
				{
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
					
				} else {
					
					$field_array = array(
						"trn_batch_id" => $batch_id,
						"office_id"    => $office_id,
						"client_id"    => $client_id,
						"process_id"   => $process_id,
						"description"  => $description,
						"added_by"     => $current_user,
						"is_active"    => '1',
						"added_date"   => $curDateTime,
						"uplog"        => $log
					);
					
					$did = data_inserter($design_table,$field_array);
					
					foreach($kpi_name_arr as $index => $kpi_name){
						if($kpi_name<>""){
							$field_array = array(
								"did" => $did,
								"kpi_name"    => $kpi_name,
								"kpi_type"    => $kpi_type_arr[$index],
								"kpi_weightage" => $kpi_weightage_arr[$index],
								"isdel"       => '0',
								"added_by"    => $current_user,
								"added_date"  => $curDateTime,
								"uplog"       => $log
							);
							data_inserter($design_kpi,$field_array);
						}
					}
				
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
				}
				
		   }         
	   }
		
		
		public function get_recursive_DesignForm()
		{
			if(check_logged_in())
			{				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_design";
				$data['design']['name'] = $design_name = "Recursive";
				$data['design']['kpi'] = $design_kpi = "training_recursive_kpi";
				$data['design']['data'] = $design_data = "training_recursive_data";
				$data['design']['url']['design'] = $url_design = "recursive_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_DesignForm";
				
				$mdid = trim($this->input->post('mdid'));
				$mdid=addslashes($mdid);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
					
				//$qSql="select * from pm_design where id = $mdid";
				//$design_row=$this->Common_model->get_query_row_array($qSql);
				
				$qSql="SELECT * from $design_kpi where did = $mdid";
				$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
				
				/////////
				$html = "";
				
				$TotRow = count($design_kpi_arr);
				
				$cnt = 1;
				foreach($design_kpi_arr as $kpiRow) {
				
					$html .= "<div class='col-md-12 kpi_input_row'>";					
					$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
					$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
     				$html .= "<div class='col-md-3'><select class='form-control' name='kpi_type[]' > ";
					
					foreach($kpi_type_list as $kpimas){						
						$sCss="";
						if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
						$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
					}
									
					$html .= "</select></div>";
					
					$html .= "<div class='col-md-2'><input type='text' value='". $kpiRow['kpi_weightage'] ."' onkeyup=\"this.value=this.value.replace(/[^\d]/,'')\" class='form-control' name='kpi_weightage[]'></div>";
					
					$html .= "<div class='col-md-2'>";						
						if( $cnt++<$TotRow-1){							
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
						}else{
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
						}
									
					$html .= "</div>";
				    $html .= "</div>";
				
				}	
						
				echo $html;
			}
		}

	
	   public function update_recursive_Design()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_design";
				$data['design']['name'] = $design_name = "Recursive";
				$data['design']['kpi'] = $design_kpi = "training_recursive_kpi";
				$data['design']['data'] = $design_data = "training_recursive_data";
				$data['design']['url']['design'] = $url_design = "recursive_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_DesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				$mdid = trim($this->input->post('mdid'));
				
				$batch_id  = trim($this->input->post('batch_id'));
				$office_id  = trim($this->input->post('office_id'));
				$client_id  = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$description = trim($this->input->post('description'));
				
				$kpi_id_arr   = $this->input->post('kpi_id');
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$field_array = array(
					"office_id"   => $office_id,
					"client_id"   => $client_id,
					"process_id"  => $process_id,
					"description" => $description,
					"added_by"    => $current_user,
					"is_active"   => '1',
					"added_date"  => $curDateTime,
					"uplog"       => $log
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				$TotID = count($kpi_id_arr);
				
				// DELETE DESIGN
				$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
				$query = $this->db->query($sql);
				
				foreach($kpi_name_arr as $index => $kpi_name)
				{
					if($kpi_name != "")
					{						
						$field_array = array(
							"did"         => $mdid,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"kpi_weightage"   => $kpi_weightage_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => curDateTime,
							"uplog"       => $log
						);
						
						data_inserter($design_kpi, $field_array);						
					}
				}
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
	   }




		public function recursive_performance()
		{
			
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true)$is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_design";
				$data['design']['name'] = $design_name = "Recursive";
				$data['design']['kpi'] = $design_kpi = "training_recursive_kpi";
				$data['design']['data'] = $design_data = "training_recursive_data";
				$data['design']['url']['design'] = $url_design = "recursive_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_DesignForm";
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' and is_incubation <> '1' ";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/recursive_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and batch_office_id='$oValue' ";
						$filterCond2 = " and location_id='$oValue' ";
				}
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
					
					$qSql="SELECT tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_type=4 $filterCond $filterCond4 $filterCond3 ORDER by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="SELECT tb.*, c.shname as client_name , p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id
					WHERE trainer_id='$current_user' and trn_type=4 $filterCond4 $filterCond3 ORDER by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_type=4 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$data['checkupload'][$batch_id] = '0';
					
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ntdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ntdid = '$ragdid' AND kpi_id = '$kpiid'";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							$jcheck++;
						}
					}
					
					
					$i++;
				}
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
							
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}

	   		
	public function downloadTrainingRecurisveHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_design";
		$data['design']['name'] = $design_name = "Recursive";
		$data['design']['kpi'] = $design_kpi = "training_recursive_kpi";
		$data['design']['data'] = $design_data = "training_recursive_data";
		$data['design']['url']['design'] = $url_design = "recursive_design";
		$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Design";
		$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Design";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_DesignForm";
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, trn_batch_id, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		$batchid = $pm_design_row['trn_batch_id'];
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		
		if(!empty($batchid)){
			$slNo = 0; $r=2;
			$qSql = "Select s.*, d.user_id, CONCAT(s.fname, ' ', s.lname) as fullname from training_details as d INNER JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batchid'";
			$querySql=$this->Common_model->get_query_result_array($qSql);
			foreach($querySql as $rowD):
				$slNo++; $r++; $j=0; 
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fullname']);			
			endforeach;
		}


		$currentcellvalue = ord('C');
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'] .' ('.$row['kpi_weightage'] .'%)';
			if($row['kpi_name'] == "Status"){ 
			$getkpiname = "Status (Pass/Fail)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);
			
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	
	
	/// DOWNLOAD NESTING RESULT
	   		
	public function downloadTrainingRecursiveResult()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_design";
		$data['design']['name'] = $design_name = "Recursive";
		$data['design']['kpi'] = $design_kpi = "training_recursive_kpi";
		$data['design']['data'] = $design_data = "training_recursive_data";
		$data['design']['url']['design'] = $url_design = "recursive_design";
		$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Design";
		$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Design";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_DesignForm";
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$cell=$letters[$j++].$r;
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
			
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	public function uploadRecursiveResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/training_nesting/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_Recursive_file($fileName,$batch_id);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_Recursive_file($fileName,$batch_id);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	
	
	
	private function Import_Recursive_file($file_name,$batch_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/training_nesting/'.$file_name;
				
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
		
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_design";
		$data['design']['name'] = $design_name = "Recursive";
		$data['design']['kpi'] = $design_kpi = "training_recursive_kpi";
		$data['design']['data'] = $design_data = "training_recursive_data";
		$data['design']['url']['design'] = $url_design = "recursive_design";
		$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Design";
		$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Design";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_DesignForm";
				
		// GET RAG DID FROM BATCH
		$qSqlb="SELECT tb.*,
				c.shname as client_name, 
				p.name as process_name, 
				batch_name, batch_office_id, 
				CONCAT(fname,' ' ,lname) as trainer_name, 
				office_id, batch_office_id, batch_name from training_batch tb 
				LEFT JOIN client c ON  c.id=tb.client_id 
				LEFT JOIN process p ON  p.id=tb.process_id 
				LEFT JOIN signin ON  signin.id=tb.trainer_id
				where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batch_id'";
		
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		$pmdid = $pm_batch_rowb['id'];
			
		
		// GET KPI DETAILS
		$qSql = "Select * from $design_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET RAG DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}
		
		//echo "hi";
		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ntdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"ntdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update($design_data,$field_array);
					
					
				} else {
					
					data_inserter($design_data,$field_array);
				
				}
			
				//print_r($field_array);die();$_run = false;					
				
			}	
			}		
			
		}
		
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		
	}
	
	
	
	
	public function getFormatDesignRecursive()
	{
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_design";
		$data['design']['name'] = $design_name = "Recursive";
		$data['design']['kpi'] = $design_kpi = "training_recursive_kpi";
		$data['design']['data'] = $design_data = "training_recursive_data";
		$data['design']['url']['design'] = $url_design = "recursive_design";
		$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Design";
		$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Design";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_DesignForm";
		
		$batchid = trim($this->input->get('batchid'));
		$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		
		$pmdid = $pm_batch_rowb['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}
	
	
	
	



	
	
	
	
	public function upskill_batch()
	{
		if(check_logged_in())
		{
			//=========== SET TABLES AND NAME
			$data['design']['table'] = $design_table = "training_upskill_design";
			$data['design']['name'] = $design_name = "Upskill";
			$data['design']['kpi'] = $design_kpi = "training_upskill_kpi";
			$data['design']['data'] = $design_data = "training_upskill_data";
			$data['design']['url']['design'] = $url_design = "upskill_design";
			$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Design";
			$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Design";
			$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_DesignForm";
				
			$todayDate=CurrDate();
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();

			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			
			//echo $user_office_id;
			
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();
			
			$batch="";
			$cond="";
			$filterCond="";
			$filterCond2="";
			$filterCond3 = "";
			$filterCond4 = " and trn_batch_status = '1' and is_incubation <> '1'";
			 
			$data["aside_template"] = "training/aside.php";
			$data["content_template"] = "training/upskill_batch.php";
			
			$oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			if($oValue=="") $oValue = $user_office_id;
			$data['oValue'] = $oValue;
			
			if($oValue!="ALL" ){
					$filterCond = " AND batch_office_id = '$oValue'";
					$filterCond2 = " and (location_id='$oValue') ";
			}
			
			
			
			if($this->input->get('searchtraining'))
			{
				$daterange_full = $this->input->get('daterange');
				$daterange_explode = explode('-',$daterange_full);
				$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
				$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
				$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
				//$filterCond4 = "";
				
			}	
			
			//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
						
			$qSql="Select id,name from master_term_type where is_active=1";
			$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,name from master_sub_term_type where is_active=1";
			$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,description from master_resign_reason where is_active=1";
			$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
			
			//$qSql="SELECT id, concat(fname, ' ', lname) as fullname from signin WHERE dept_id IN (11)";
			$qSql="SELECT id, concat(fname, ' ', lname) as fullname from signin WHERE dept_id IN (11)";
			$data['t_traineelist'] = $this->Common_model->get_query_result_array($qSql);
			
						
			
			if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
									
				//$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, (Select CONCAT(fname,' ' ,lname) from signin s where s.id=tb.trainer_id) as trainer_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_batch_status = '1' order by tb.id desc";
				
				$qSql="SELECT tb.*,c.shname, p.name, CONCAT(fname,' ' ,lname) as trainer_name, batch_office_id, batch_name from training_batch tb 
				       LEFT JOIN client c ON  c.id=tb.client_id 
					   LEFT JOIN process p ON  p.id=tb.process_id 
					   LEFT JOIN signin ON  signin.id=tb.trainer_id 
					   WHERE trn_type=5 $filterCond4 $filterCond3 $filterCond
					   ORDER by tb.id desc";
								
				$data["get_assigned_batch"] = $get_assigned_batch = $this->Common_model->get_query_result_array($qSql);
				
			} else {
				$myteamIDs = $this->get_team_id($current_user);
				$qSql="SELECT tb.*,c.shname, p.name, CONCAT(fname,' ' ,lname) as trainer_name, batch_office_id, batch_name from training_batch tb 
				       LEFT JOIN client c ON  c.id=tb.client_id 
					   LEFT JOIN process p ON  p.id=tb.process_id 
					   LEFT JOIN signin ON  signin.id=tb.trainer_id 
					   WHERE (trainer_id='$current_user' OR trainer_id IN ($myteamIDs)) and trn_type=5 $filterCond4 $filterCond3 
					   ORDER by tb.id desc";
				
				$data["get_assigned_batch"] = $get_assigned_batch = $this->Common_model->get_query_result_array($qSql);
			}
			
			$j=0;
			foreach($get_assigned_batch as $rowtoken)
			{
				$batch_id= $rowtoken['id'];
				$t_cid = $rowtoken['client_id'];
				$t_pid = $rowtoken['process_id'];
				
				$qSql="SELECT id, concat(fname, ' ', lname) as fullname from signin WHERE dept_id IN (11,6) AND client_id = '$t_cid' AND process_id = '$t_pid'";
				$data['t_traineelist_new'][$batch_id] = $this->Common_model->get_query_result_array($qSql);
								
				$getpmid_test = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
				$pm_batch_rowb_test = $this->Common_model->get_query_row_array($getpmid_test);				
				$pmdid = $pm_batch_rowb_test['id'];
				
				$getpmid_test_rag = "SELECT id as value from training_upskill_rag_design WHERE trn_batch_id = '$batch_id'"; 
				$pmdid_rag = $this->Common_model->get_single_value($getpmid_test_rag);
				
			
				$sqlcc = "Select td.*, s.*, yy.*, d.*, trm.*, ts.avg_rating_score, ts.trainee_id as survey_id, (Select name from event_master e where e.id=s.disposition_id) as disp_name 
				from training_details td 
				LEFT JOIN signin s on td.user_id = s.id
				LEFT JOIN training_post_classroom_survey ts on ts.trainee_id = td.user_id AND ts.training_batch = td.trn_batch_id
				LEFT JOIN 
				(select user_id as luid, sum(TIME_TO_SEC(timediff(logout_time,login_time))) as tLtime from logged_in_details where cast(login_time as date) = '".$todayDate."' and cast(logout_time as date) >= '".$todayDate."' group by user_id) yy on (td.user_id=yy.luid)
				LEFT JOIN 
				(select start_date,end_date,user_id as duid from event_disposition where start_date <= '".$todayDate."' and end_date >= '".$todayDate."' group by duid ) d on (td.user_id=d.duid)
				Left Join (select user_id as tuid, is_term_complete, max(terms_date) as terms_date from terminate_users where is_term_complete='Y' group by user_id ) trm ON (td.user_id=trm.tuid) where trn_batch_id = '$batch_id' AND trn_status = '5' order by fname";
				$data['candidate_details'][$batch_id] = $cdetails = $this->Common_model->get_query_result_array($sqlcc);
				
				
				// GET CANDIDATE DEAILS
				foreach($cdetails as $crow)
				{
					 $user_id= $crow['user_id'];
					 
					 // GET TRAINER DETAILS
					 $sqltrainerd = "SELECT concat(q.fname, ' ', q.lname) as fullname, q.id as userid from signin as q 
					 LEFT JOIN signin as s ON q.id = s.assigned_to WHERE s.id = '$user_id'";
					 $ctraineename = $this->Common_model->get_query_row_array($sqltrainerd);
					 $data['candidate_info'][$batch_id]['trainee'][$user_id]['id'] = $ctraineename['userid'];
					 $data['candidate_info'][$batch_id]['trainee'][$user_id]['name'] = $ctraineename['fullname'];
					 
				}
				
				$get_assigned_batch[$j]['designid'] = $pmdid;
				$get_assigned_batch[$j]['ragdesignid'] = $pmdid_rag;
				$j++;
			}
			
			$data["get_assigned_batch"] = $get_assigned_batch;
			//echo "<pre>" .print_r($get_assigned_batch, true) ."</pre>";die();
			
			
			/////////////	
			$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name, office_id from signin where status=1 and ( role_id not in (select id from role where folder='agent') OR dept_id=11) and office_id='$user_office_id' order by name asc ";
			$data["assigned_l1super"] = $this->Common_model->get_query_result_array($qSql);
			//////////////
			
			$qSqlt = "SELECT s.id, s.fusion_id, d.shname as department, r.name as designation, concat(s.fname, ' ', s.lname) as name, s.office_id from signin s LEFT JOIN department d ON s.dept_id = d.id LEFT JOIN role r on r.id = s.role_id WHERE s.status=1 and (s.role_id not in (select id from role where folder='agent') OR s.dept_id=11) and s.office_id='$user_office_id' ORDER BY name ASC ";
			$data["assigned_trainerlist"]  = $this->Common_model->get_query_result_array($qSqlt);
		
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			} else {
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				if($this->check_all_training_access())
				{
					$access_office_ids = $this->check_all_training_access('office');
					$extra_access_office = implode("','", $access_office_ids);
					$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
					$query = $this->db->query($sql_office);
					$data['location_list'] = $query->result_array();
				}
			}
			
			$data['e_client_list'] = $this->Common_model->get_client_list();
			$data['e_process_list'] = $this->Common_model->get_process_for_assign();
				
			$this->load->view('dashboard',$data);
			
		}
	}
	
	
	
	
	function move_batch_user_upskill()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true) $is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$initial_batch_id = trim($this->input->post('initial_batch_id'));
			$move_to_batch_id = trim($this->input->post('move_to_batch_id'));
			$userCheckBox = $this->input->post('userCheckBox');
			$countcheckbox = count($userCheckBox);
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $userCheckBox[$i];
				$sqlq = "UPDATE training_details SET trn_batch_id = '$move_to_batch_id' WHERE user_id = '$getuserid' AND trn_batch_id = '$initial_batch_id'";
				$queryq = $this->db->query($sqlq);
			}
			redirect(base_url()."training/upskill_batch","refresh");
		}		
	}
	
	
	function split_batch_user_upskill()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true) $is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$curDateTime   = CurrMySqlDate();
			$log = get_logs();
		
			$split_initial_batch_id = trim($this->input->post('split_initial_batch_id'));
			$split_select_trainer_id = trim($this->input->post('split_select_trainer_id'));
			$split_initial_batch_name = trim($this->input->post('split_initial_batch_name'));
			$userSplitCheckBox = $this->input->post('userSplitCheckBox');
			$countcheckbox = count($userSplitCheckBox);
			
			if($countcheckbox > 0){
				
			//COPY DATA FROM BATCH TO NEW BATCH ID
			$sqlbatchcopy = "INSERT into training_batch (trainer_id, trn_start_date, trn_type, ref_type, ref_id, client_id, process_id, trn_batch, trn_comment, trn_batch_status, batch_name, batch_office_id, hr_handover_by, hr_handover_date, log)
			SELECT '".$split_select_trainer_id."', trn_start_date, trn_type, ref_type, ref_id, client_id, process_id, trn_batch, trn_comment, trn_batch_status, '".$split_initial_batch_name."', batch_office_id, hr_handover_by, hr_handover_date, log from training_batch
			where id = '$split_initial_batch_id'";
			$this->db->query($sqlbatchcopy);
			$lastinsert_id = $this->db->insert_id();
						
			}
			
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $userSplitCheckBox[$i];
				$sqlq = "UPDATE training_details SET trn_batch_id = '$lastinsert_id' WHERE user_id = '$getuserid' AND trn_batch_id = '$split_initial_batch_id'";
				$queryq = $this->db->query($sqlq);
			}
			
			redirect(base_url()."training/upskill_batch","refresh");
		}		
	}
	
	public function addnewtraineebatch_upskill(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true) $is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			$log = get_logs();
			
			$batch_id = $this->input->post('add_trainee_batch_id');
			$checkUser = $this->input->post('traineeNewCheckBox');
			$countcheckbox = count($checkUser);
			
			$sqlc = "SELECT trainer_id, process_id, client_id from training_batch WHERE id = '$batch_id'";
			$queryc = $this->Common_model->get_query_row_array($sqlc);
			
			$t_process_id = $queryc['process_id'];
			$t_client_id = $queryc['client_id'];
			$t_trainer_id = $queryc['trainer_id'];
			
			
			for($i=0;$i<$countcheckbox;$i++)
			{
				$getuserid = $checkUser[$i];
				
				//-- ADD TO TRAINING DETAILS
				$insert_array = array(
									"trn_batch_id" => $batch_id,
									"user_id" => $getuserid,
									"trn_note" => 'Manually Added',
									"trn_status" => '5',
									"is_certify" => '0',
									"log" => $log
								);
				data_inserter('training_details', $insert_array);
				
				//-- UPDATE SIGNIN
				$update_array = array(
									"phase" => '2',
									"assigned_to" => $t_trainer_id
								);
				$this->db->where('id', $getuserid);
				$this->db->update('signin', $update_array);
				
				//-- GET PREVIOUS LOGS
				$qSql = "SELECT log from signin WHERE id = '$getuserid'";
				$prevLog = getDBPrevLogs($qSql);
				$log = "Update Trainign Batch :: ". get_logs($prevLog);
				
				//-- UPDATE CLIENT
				$this->db->query('DELETE FROM info_assign_client WHERE user_id = "'.$getuserid.'"');	
				$field_array2 = array(
					"user_id" => $getuserid,
					"client_id" => $t_client_id,
					"log" => $log
				);
				$rowid= data_inserter('info_assign_client',$field_array2);
				
				//-- UPDATE PROCESS
				$this->db->query('DELETE FROM info_assign_process WHERE user_id = "'.$getuserid.'"');
				$field_array3 = array(
					"user_id" => $getuserid,
					"process_id" => $t_process_id,
					"log" => $log
				);
				$rowid= data_inserter('info_assign_process',$field_array3);
				
			}
			
			redirect(base_url()."training/upskill_batch","refresh");
			
		}
	}
	
	
	
	public function fetchBatchlist_upskill(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true) $is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$qSql = "Select tb.*,c.shname, p.name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_type=5 order by tb.id desc";
			$querySql = $this->Common_model->get_query_result_array($qSql);
			echo json_encode($querySql);
			
		}
	}


	public function fetchBatchUsers_upskill(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true) $is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$batch_id= trim($this->input->post('batchid'));
			if($batch_id != ""){
				$sqldata = "Select td.*, s.fname, s.lname, s.fusion_id, b.batch_name, b.batch_office_id from training_details as td
                            LEFT JOIN training_batch as b on b.id = td.trn_batch_id	
				            LEFT JOIN signin as s ON td.user_id = s.id where td.trn_batch_id = '$batch_id' AND trn_status = '5' order by fname";
				$candidatedata = $this->Common_model->get_query_result_array($sqldata);
			}
			echo json_encode($candidatedata);
			
		}
	}

	
	public function fetchBatchTraineeList_upskill()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true) $is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$batch_id= trim($this->input->post('batchid'));
			
			if($batch_id != ""){
			$qSql = "SELECT CONCAT(s.fname,' ' ,s.lname) as trainee_name, s.office_id, s.fusion_id, s.id as user_id from signin as s 
			         WHERE s.id NOT IN (SELECT user_id from training_details WHERE trn_batch_id = '$batch_id') AND s.status IN (1,4) AND s.office_id = '$user_office_id'
					 AND s.role_id IN (SELECT id from role WHERE folder = 'agent') ORDER by trainee_name";
			$querySql = $this->Common_model->get_query_result_array($qSql);
			}
			echo json_encode($querySql);
			
		}
	}

	public function upskill_design()
		{
			if(check_logged_in())
			{
				$current_user     = get_user_id();
				$user_site_id     = get_user_site_id();
				$user_office_id   = get_user_office_id();
				$user_oth_office  = get_user_oth_office();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$role_dir         = get_role_dir();
				$role_id          = get_role_id();
				$get_dept_id      = get_dept_id();
				
				$data["aside_template"]   = "training/aside.php";
				$data["content_template"] = "training/upskill_design.php";
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_design";
				$data['design']['name'] = $design_name = "Upskill";
				$data['design']['kpi'] = $design_kpi = "training_upskill_kpi";
				$data['design']['data'] = $design_data = "training_upskill_data";
				$data['design']['url']['design'] = $url_design = "upskill_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_DesignForm";
				
				//=========== OFFICE > CLIENT > PROCESS FILTER
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
										
				$_filterCond="";
				//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") 
				$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
				LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1'";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSqlall="Select id as client_id, shname from client where is_active='1'";	
				$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
								
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" WHERE id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				//============ FORM URL DATA
				$data['hide_normal'] = "off";
				$url_batch_id = "";
				$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
				if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
				$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
				if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
				$data['url_batch_id'] = $url_batch_id;
				
					
				$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
					(SELECT name from process y where y.id = b.process_id) as process_name,
					(SELECT office_name from office_location k  where k.abbr = b.batch_office_id) as office_name,
					(SELECT shname from client c where c.id = b.client_id) as client_name 
					from training_batch as b WHERE b.id = '$url_batch_id'";
				$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
				// CHECK ANY PREVIOUS DESIGN
				$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
				$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
				if($pv_rag != ""){
					$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
					$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
				}
				
				// GET DESIGN DATA
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp WHERE is_active=1 AND trn_batch_id = '$url_batch_id' $_filterCond";
				$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
				
				$pmkpiarray=array();
				foreach($design_row as $row):
					$mp_id= $row['mp_id'];
					$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
				
				$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
				
				//loading training javascript
				//$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
	
	   public function add_upskill_Design()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_design";
				$data['design']['name'] = $design_name = "Upskill";
				$data['design']['kpi'] = $design_kpi = "training_upskill_kpi";
				$data['design']['data'] = $design_data = "training_upskill_data";
				$data['design']['url']['design'] = $url_design = "upskill_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_DesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				
				$batch_id    = trim($this->input->post('trn_batch_id'));
				$office_id    = trim($this->input->post('office_id'));
				$client_id    = trim($this->input->post('client_id'));
				$process_id   = trim($this->input->post('process_id'));
				$description  = trim($this->input->post('description'));
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				
				$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
				$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				if($uploadcheck != "")
				{
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
					
				} else {
					
					$field_array = array(
						"trn_batch_id" => $batch_id,
						"office_id"    => $office_id,
						"client_id"    => $client_id,
						"process_id"   => $process_id,
						"description"  => $description,
						"added_by"     => $current_user,
						"is_active"    => '1',
						"added_date"   => $curDateTime,
						"uplog"        => $log
					);
					
					$did = data_inserter($design_table,$field_array);
					
					foreach($kpi_name_arr as $index => $kpi_name){
						if($kpi_name<>""){
							$field_array = array(
								"did" => $did,
								"kpi_name"    => $kpi_name,
								"kpi_type"    => $kpi_type_arr[$index],
								"kpi_weightage" => $kpi_weightage_arr[$index],
								"isdel"       => '0',
								"added_by"    => $current_user,
								"added_date"  => $curDateTime,
								"uplog"       => $log
							);
							data_inserter($design_kpi,$field_array);
						}
					}
				
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
				}
				
		   }         
	   }
		
		
		public function get_upskill_DesignForm()
		{
			if(check_logged_in())
			{				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_design";
				$data['design']['name'] = $design_name = "Upskill";
				$data['design']['kpi'] = $design_kpi = "training_upskill_kpi";
				$data['design']['data'] = $design_data = "training_upskill_data";
				$data['design']['url']['design'] = $url_design = "upskill_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_DesignForm";
				
				$mdid = trim($this->input->post('mdid'));
				$mdid=addslashes($mdid);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
					
				//$qSql="select * from pm_design where id = $mdid";
				//$design_row=$this->Common_model->get_query_row_array($qSql);
				
				$qSql="SELECT * from $design_kpi where did = $mdid";
				$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
				
				/////////
				$html = "";
				
				$TotRow = count($design_kpi_arr);
				
				$cnt = 1;
				foreach($design_kpi_arr as $kpiRow) {
				
					$html .= "<div class='col-md-12 kpi_input_row'>";					
					$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
					$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
     				$html .= "<div class='col-md-3'><select class='form-control' name='kpi_type[]' > ";
					
					foreach($kpi_type_list as $kpimas){						
						$sCss="";
						if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
						$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
					}
									
					$html .= "</select></div>";
					
					$html .= "<div class='col-md-2'><input type='text' value='". $kpiRow['kpi_weightage'] ."' onkeyup=\"this.value=this.value.replace(/[^\d]/,'')\" class='form-control' name='kpi_weightage[]'></div>";
					
					
					$html .= "<div class='col-md-2'>";						
						if( $cnt++<$TotRow-1){							
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
						}else{
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
						}
									
					$html .= "</div>";
				    $html .= "</div>";
				
				}	
						
				echo $html;
			}
		}

	
	   public function update_upskill_Design()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_design";
				$data['design']['name'] = $design_name = "Upskill";
				$data['design']['kpi'] = $design_kpi = "training_upskill_kpi";
				$data['design']['data'] = $design_data = "training_upskill_data";
				$data['design']['url']['design'] = $url_design = "upskill_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_DesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				$mdid = trim($this->input->post('mdid'));
				
				$batch_id  = trim($this->input->post('batch_id'));
				$office_id  = trim($this->input->post('office_id'));
				$client_id  = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$description = trim($this->input->post('description'));
				
				$kpi_id_arr   = $this->input->post('kpi_id');
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$field_array = array(
					"office_id"   => $office_id,
					"client_id"   => $client_id,
					"process_id"  => $process_id,
					"description" => $description,
					"added_by"    => $current_user,
					"is_active"   => '1',
					"added_date"  => $curDateTime,
					"uplog"       => $log
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				$TotID = count($kpi_id_arr);
				
				// DELETE DESIGN
				$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
				$query = $this->db->query($sql);
				
				foreach($kpi_name_arr as $index => $kpi_name)
				{
					if($kpi_name != "")
					{						
						$field_array = array(
							"did"         => $mdid,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"kpi_weightage"   => $kpi_weightage_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => curDateTime,
							"uplog"       => $log
						);
						
						data_inserter($design_kpi, $field_array);						
					}
				}
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
	   }




		public function upskill_performance()
		{
			
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_design";
				$data['design']['name'] = $design_name = "Upskill";
				$data['design']['kpi'] = $design_kpi = "training_upskill_kpi";
				$data['design']['data'] = $design_data = "training_upskill_data";
				$data['design']['url']['design'] = $url_design = "upskill_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_DesignForm";
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' and is_incubation <> '1'";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/upskill_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and batch_office_id='$oValue' ";
						$filterCond2 = " and location_id='$oValue' ";
				}
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
					
					$qSql="SELECT tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_type=5 $filterCond $filterCond4 $filterCond3 ORDER by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="SELECT tb.*, c.shname as client_name , p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id
					WHERE trainer_id='$current_user' and trn_type=5 $filterCond4 $filterCond3 ORDER by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_type=5 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$data['checkupload'][$batch_id] = '0';
					
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY ntdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND ntdid = '$ragdid' AND kpi_id = '$kpiid'";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							$jcheck++;
						}
					}
					
					
					$i++;
				}
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
							
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}

	   		
	public function downloadTrainingUpskillHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_design";
		$data['design']['name'] = $design_name = "Upskill";
		$data['design']['kpi'] = $design_kpi = "training_upskill_kpi";
		$data['design']['data'] = $design_data = "training_upskill_data";
		$data['design']['url']['design'] = $url_design = "upskill_design";
		$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Design";
		$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Design";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_DesignForm";
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,trn_batch_id, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		$batchid = $pm_design_row['trn_batch_id'];
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		if(!empty($batchid)){
			$slNo = 0; $r=2;
			$qSql = "Select s.*, d.user_id, CONCAT(s.fname, ' ', s.lname) as fullname from training_details as d INNER JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batchid'";
			$querySql=$this->Common_model->get_query_result_array($qSql);
			foreach($querySql as $rowD):
				$slNo++; $r++; $j=0; 
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fullname']);			
			endforeach;
		}
		
		$currentcellvalue = ord('C');
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'] .' ('.$row['kpi_weightage'] .'%)';
			if($row['kpi_name'] == "Status"){ 
			$getkpiname = "Status (Pass/Fail)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);
			
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	
	
	/// DOWNLOAD NESTING RESULT
	   		
	public function downloadTrainingUpskillResult()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_design";
		$data['design']['name'] = $design_name = "Upskill";
		$data['design']['kpi'] = $design_kpi = "training_upskill_kpi";
		$data['design']['data'] = $design_data = "training_upskill_data";
		$data['design']['url']['design'] = $url_design = "upskill_design";
		$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Design";
		$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Design";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_DesignForm";
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$cell=$letters[$j++].$r;
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
			
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	public function uploadUpskillResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/training_nesting/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_Upskill_file($fileName,$batch_id);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_Upskill_file($fileName,$batch_id);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	
	
	
	private function Import_Upskill_file($file_name,$batch_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/training_nesting/'.$file_name;
				
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
		
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_design";
		$data['design']['name'] = $design_name = "Upskill";
		$data['design']['kpi'] = $design_kpi = "training_upskill_kpi";
		$data['design']['data'] = $design_data = "training_upskill_data";
		$data['design']['url']['design'] = $url_design = "upskill_design";
		$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Design";
		$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Design";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_DesignForm";
				
		// GET RAG DID FROM BATCH
		$qSqlb="SELECT tb.*,
				c.shname as client_name, 
				p.name as process_name, 
				batch_name, batch_office_id, 
				CONCAT(fname,' ' ,lname) as trainer_name, 
				office_id, batch_office_id, batch_name from training_batch tb 
				LEFT JOIN client c ON  c.id=tb.client_id 
				LEFT JOIN process p ON  p.id=tb.process_id 
				LEFT JOIN signin ON  signin.id=tb.trainer_id
				where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batch_id'";
		
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		$pmdid = $pm_batch_rowb['id'];
			
		
		// GET KPI DETAILS
		$qSql = "Select * from $design_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET RAG DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}
		
		//echo "hi";
		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND ntdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"ntdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update($design_data,$field_array);
					
					
				} else {
					
					data_inserter($design_data,$field_array);
				
				}
			
				//print_r($field_array);die();$_run = false;					
				
			}	
			}		
			
		}
		
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		
	}
	
	
	
	
	public function getFormatDesignUpskill()
	{
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_design";
		$data['design']['name'] = $design_name = "Upskill";
		$data['design']['kpi'] = $design_kpi = "training_upskill_kpi";
		$data['design']['data'] = $design_data = "training_upskill_data";
		$data['design']['url']['design'] = $url_design = "upskill_design";
		$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Design";
		$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Design";
		$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_DesignForm";
		
		$batchid = trim($this->input->get('batchid'));
		$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batchid'";
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		
		$pmdid = $pm_batch_rowb['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}
	
//=========================================================================================	
//                  TRAINING UPSKILL INCUBATION                        
//=========================================================================================	

public function upskill_incub_design()
		{
			if(check_logged_in())
			{ 
				$current_user     = get_user_id();
				$user_site_id     = get_user_site_id();
				$user_office_id   = get_user_office_id();
				$user_oth_office  = get_user_oth_office();
				$is_global_access = get_global_access();
				
				if(global_access_training_module()==true) $is_global_access="1";
				
				$role_dir         = get_role_dir();
				$role_id          = get_role_id();
				$get_dept_id      = get_dept_id();
				
				$data["aside_template"]   = "training/aside.php";
				$data["content_template"] = "training/upskill_incub_design.php";
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_incub_design";
				$data['design']['name'] = $design_name = "Upskill Incubation";
				$data['design']['kpi'] = $design_kpi = "training_upskill_incub_kpi";
				$data['design']['data'] = $design_data = "training_upskill_incub_data";
				$data['design']['url']['design'] = $url_design = "upskill_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_Incubation_DesignForm";
				
				//=========== OFFICE > CLIENT > PROCESS FILTER
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
										
				$_filterCond="";
				//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") 
				$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
				LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1'";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSqlall="Select id as client_id, shname from client where is_active='1'";	
				$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
								
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" WHERE id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				//============ FORM URL DATA
				$data['hide_normal'] = "off";
				$url_batch_id = "";
				$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
				if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
				$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
				if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
				$data['url_batch_id'] = $url_batch_id;
				
					
				$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
					y.name as process_name, k.office_name  as office_name, c.shname as client_name 
					from training_batch as b 
					LEFT JOIN process as y ON y.id = b.process_id
					LEFT JOIN office_location k  ON k.abbr = b.batch_office_id
					LEFT JOIN client c ON c.id = b.client_id
					WHERE b.id = '$url_batch_id'";
				$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
				// CHECK ANY PREVIOUS DESIGN
				$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
				$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
				if($pv_rag != ""){
					$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
					$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
				}
				
				// GET DESIGN DATA
				$qSql="Select mp.id as mp_id,mp.office_id,mp.client_id,mp.process_id, mp.is_active, mp.description, mp.passing_percentile, y.name as process_name, k.office_name  as office_name, c.shname as client_name 
				from $design_table mp
				LEFT JOIN process as y ON y.id = mp.process_id
					LEFT JOIN office_location k  ON k.abbr = mp.office_id
					LEFT JOIN client c ON c.id = mp.client_id
				WHERE mp.is_active=1 AND mp.trn_batch_id = '$url_batch_id' $_filterCond";
				$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
				
				$pmkpiarray=array();
				foreach($design_row as $row):
					$mp_id= $row['mp_id'];
					$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
				
				$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
				
				//loading training javascript
				//$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
	
	   public function add_upskill_Incubation_Design()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_incub_design";
				$data['design']['name'] = $design_name = "Upskill Incubation";
				$data['design']['kpi'] = $design_kpi = "training_upskill_incub_kpi";
				$data['design']['data'] = $design_data = "training_upskill_incub_data";
				$data['design']['url']['design'] = $url_design = "upskill_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_Incubation_DesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				
				$batch_id    = trim($this->input->post('trn_batch_id'));
				$office_id    = trim($this->input->post('office_id'));
				$client_id    = trim($this->input->post('client_id'));
				$process_id   = trim($this->input->post('process_id'));
				$description  = trim($this->input->post('description'));
				$passing_percetnage = trim($this->input->post('new_passing_percetnage'));
				
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
				$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				if($uploadcheck != "")
				{
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
					
				} else {
					
					$field_array = array(
						"trn_batch_id" => $batch_id,
						"office_id"    => $office_id,
						"client_id"    => $client_id,
						"process_id"   => $process_id,
						"description"  => $description,
						"passing_percentile" => $passing_percetnage,
						"added_by"     => $current_user,
						"is_active"    => '1',
						"added_date"   => $curDateTime,
						"uplog"        => $log
					);
					
					$did = data_inserter($design_table,$field_array);
					
					foreach($kpi_name_arr as $index => $kpi_name){
						if($kpi_name<>""){
							$field_array = array(
								"did" => $did,
								"kpi_name"    => $kpi_name,
								"kpi_type"    => $kpi_type_arr[$index],
								"kpi_weightage" => $kpi_weightage_arr[$index],
								"isdel"       => '0',
								"added_by"    => $current_user,
								"added_date"  => $curDateTime,
								"uplog"       => $log
							);
							data_inserter($design_kpi,$field_array);
						}
					}
				
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
				}
				
		   }         
	   }
		
		
		public function get_upskill_Incubation_DesignForm()
		{
			if(check_logged_in())
			{				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_incub_design";
				$data['design']['name'] = $design_name = "Upskill Incubation";
				$data['design']['kpi'] = $design_kpi = "training_upskill_incub_kpi";
				$data['design']['data'] = $design_data = "training_upskill_incub_data";
				$data['design']['url']['design'] = $url_design = "upskill_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_Incubation_DesignForm";
				
				$mdid = trim($this->input->post('mdid'));
				$mdid=addslashes($mdid);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
					
				//$qSql="select * from pm_design where id = $mdid";
				//$design_row=$this->Common_model->get_query_row_array($qSql);
				
				$qSql="SELECT * from $design_kpi where did = $mdid";
				$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
				
				/////////
				$html = "";
				
				$TotRow = count($design_kpi_arr);
				
				$cnt = 1;
				foreach($design_kpi_arr as $kpiRow) {
				
					$html .= "<div class='col-md-12 kpi_input_row'>";					
					$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
					$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
     				$html .= "<div class='col-md-3'><select class='form-control' name='kpi_type[]' > ";
					
					foreach($kpi_type_list as $kpimas){						
						$sCss="";
						if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
						$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
					}
									
					$html .= "</select></div>";
					
					$html .= "<div class='col-md-2'><input type='text' value='". $kpiRow['kpi_weightage'] ."' onkeyup=\"this.value=this.value.replace(/[^\d]/,'')\" class='form-control' name='kpi_weightage[]'></div>";
					
					$html .= "<div class='col-md-2'>";						
						if( $cnt++<$TotRow-1){							
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
						}else{
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
						}
									
					$html .= "</div>";
				    $html .= "</div>";
				
				}	
						
				echo $html;
			}
		}

	
	   public function update_upskill_Incubation_Design()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_incub_design";
				$data['design']['name'] = $design_name = "Upskill Incubation";
				$data['design']['kpi'] = $design_kpi = "training_upskill_incub_kpi";
				$data['design']['data'] = $design_data = "training_upskill_incub_data";
				$data['design']['url']['design'] = $url_design = "upskill_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_Incubation_DesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				$mdid = trim($this->input->post('mdid'));
				
				$batch_id  = trim($this->input->post('batch_id'));
				$office_id  = trim($this->input->post('office_id'));
				$client_id  = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$description = trim($this->input->post('description'));
				
				$kpi_id_arr   = $this->input->post('kpi_id');
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$field_array = array(
					"office_id"   => $office_id,
					"client_id"   => $client_id,
					"process_id"  => $process_id,
					"description" => $description,
					"added_by"    => $current_user,
					"is_active"   => '1',
					"uplog"       => $log
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				$TotID = count($kpi_id_arr);
				
				// DELETE DESIGN
				$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
				$query = $this->db->query($sql);
				
				foreach($kpi_name_arr as $index => $kpi_name)
				{
					if($kpi_name != "")
					{						
						$field_array = array(
							"did"         => $mdid,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"kpi_weightage"   => $kpi_weightage_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => curDateTime,
							"uplog"       => $log
						);
						
						data_inserter($design_kpi, $field_array);						
					}
				}
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
	   }

		
		public function updatUpskillIncubPassingMarks()
		{
			if(check_logged_in())
			{
							
				$user_site_id= get_user_site_id();
				$srole_id= get_role_id();
				$current_user = get_user_id();
				$ses_dept_id=get_dept_id();
				
				$user_office_id=get_user_office_id();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_incub_design";
				$data['design']['name'] = $design_name = "Upskill Incubation";
				$data['design']['kpi'] = $design_kpi = "training_upskill_incub_kpi";
				$data['design']['data'] = $design_data = "training_upskill_incub_data";
				$data['design']['url']['design'] = $url_design = "upskill_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_Incubation_DesignForm";
				
				$_run = false;  
				
				$log=get_logs();
				
				$mdid = trim($this->input->post('mdid'));
				$passing_marks = trim($this->input->post('passing_marks'));
				
				$field_array = array(
					"passing_percentile" => $passing_marks
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
		}


		public function upskill_incubation()
		{
			
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_upskill_incub_design";
				$data['design']['name'] = $design_name = "Upskill Incubation";
				$data['design']['kpi'] = $design_kpi = "training_upskill_incub_kpi";
				$data['design']['data'] = $design_data = "training_upskill_incub_data";
				$data['design']['url']['design'] = $url_design = "upskill_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_Incubation_DesignForm";
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' and is_incubation = '1'";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/upskill_incub_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and batch_office_id='$oValue' ";
						$filterCond2 = " and location_id='$oValue' ";
				}
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
					
					$qSql="SELECT tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_type=5 $filterCond $filterCond4 $filterCond3 ORDER by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="SELECT tb.*, c.shname as client_name , p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id
					WHERE trainer_id='$current_user' and trn_type=5 $filterCond4 $filterCond3 ORDER by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_type=5 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$data['checkupload'][$batch_id] = '0';
					
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY crtdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND crtdid = '$ragdid' AND kpi_id = '$kpiid'";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							$jcheck++;
						}
					}
					
					
					$i++;
				}
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
							
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}

	   		
	public function downloadTrainingUpskillIncubationHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_incub_design";
				$data['design']['name'] = $design_name = "Upskill Incubation";
				$data['design']['kpi'] = $design_kpi = "training_upskill_incub_kpi";
				$data['design']['data'] = $design_data = "training_upskill_incub_data";
				$data['design']['url']['design'] = $url_design = "upskill_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_Incubation_DesignForm";
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active,trn_batch_id, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		$batchid = $pm_design_row['trn_batch_id'];
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		
		if(!empty($batchid)){
			$slNo = 0; $r=2;
			$qSql = "Select s.*, d.user_id, CONCAT(s.fname, ' ', s.lname) as fullname from training_details as d INNER JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batchid'";
			$querySql=$this->Common_model->get_query_result_array($qSql);
			foreach($querySql as $rowD):
				$slNo++; $r++; $j=0; 
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fullname']);			
			endforeach;
		}
		
		
		$currentcellvalue = ord('C');
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
		
			$currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'] .' ('.$row['kpi_weightage'] .'%)';
			if($row['kpi_name'] == "Status"){ 
			$getkpiname = "Status (Pass/Fail)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);
			
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	
	
	/// DOWNLOAD NESTING RESULT
	   		
	public function downloadTrainingUpskillIncubationResult()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_incub_design";
				$data['design']['name'] = $design_name = "Upskill Incubation";
				$data['design']['kpi'] = $design_kpi = "training_upskill_incub_kpi";
				$data['design']['data'] = $design_data = "training_upskill_incub_data";
				$data['design']['url']['design'] = $url_design = "upskill_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_Incubation_DesignForm";
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$cell=$letters[$j++].$r;
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
			
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	public function uploadUpskillIncubationResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/training_nesting/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_Upskill_Incubation_file($fileName,$batch_id);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_Upskill_Incubation_file($fileName,$batch_id);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	
	
	
	private function Import_Upskill_Incubation_file($file_name,$batch_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/training_nesting/'.$file_name;
				
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
		
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_incub_design";
				$data['design']['name'] = $design_name = "Upskill Incubation";
				$data['design']['kpi'] = $design_kpi = "training_upskill_incub_kpi";
				$data['design']['data'] = $design_data = "training_upskill_incub_data";
				$data['design']['url']['design'] = $url_design = "upskill_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_Incubation_DesignForm";
				
		// GET RAG DID FROM BATCH
		$qSqlb="SELECT tb.*,
				c.shname as client_name, 
				p.name as process_name, 
				batch_name, batch_office_id, 
				CONCAT(fname,' ' ,lname) as trainer_name, 
				office_id, batch_office_id, batch_name from training_batch tb 
				LEFT JOIN client c ON  c.id=tb.client_id 
				LEFT JOIN process p ON  p.id=tb.process_id 
				LEFT JOIN signin ON  signin.id=tb.trainer_id
				where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batch_id'";
		
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		$pmdid = $pm_batch_rowb['id'];
			
		
		// GET KPI DETAILS
		$qSql = "Select * from $design_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET RAG DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}
		
		//echo "hi";
		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND crtdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"crtdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update($design_data,$field_array);
					
					
				} else {
					
					data_inserter($design_data,$field_array);
				
				}
			
				//print_r($field_array);die();$_run = false;					
				
			}	
			}		
			
		}
		
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		
	}
	
	
	
	
	public function getFormatDesignUpskillIncubation()
	{
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_upskill_incub_design";
				$data['design']['name'] = $design_name = "Upskill Incubation";
				$data['design']['kpi'] = $design_kpi = "training_upskill_incub_kpi";
				$data['design']['data'] = $design_data = "training_upskill_incub_data";
				$data['design']['url']['design'] = $url_design = "upskill_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_upskill_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_upskill_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_upskill_Incubation_DesignForm";
		
		$batchid = trim($this->input->get('batchid'));
		$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=5 AND tb.id = '$batchid'";
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		
		$pmdid = $pm_batch_rowb['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}
	
	
//=========================================================================================	
//                  TRAINING RECURSIVE INCUBATION                        
//=========================================================================================	

public function recursive_incub_design()
		{
			if(check_logged_in())
			{ 
				$current_user     = get_user_id();
				$user_site_id     = get_user_site_id();
				$user_office_id   = get_user_office_id();
				$user_oth_office  = get_user_oth_office();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$role_dir         = get_role_dir();
				$role_id          = get_role_id();
				$get_dept_id      = get_dept_id();
				
				$data["aside_template"]   = "training/aside.php";
				$data["content_template"] = "training/recursive_incub_design.php";
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_incub_design";
				$data['design']['name'] = $design_name = "Recursive Incubation";
				$data['design']['kpi'] = $design_kpi = "training_recursive_incub_kpi";
				$data['design']['data'] = $design_data = "training_recursive_incub_data";
				$data['design']['url']['design'] = $url_design = "recursive_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_Incubation_DesignForm";
				
				//=========== OFFICE > CLIENT > PROCESS FILTER
				$oValue = trim($this->input->post('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				
				$cValue = trim($this->input->post('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue="0";
				
				$pValue = trim($this->input->post('process_id'));
				if($pValue=="") $pValue = trim($this->input->get('process_id'));
				
				$data['oValue']=$oValue;
				$data['cValue']=$cValue;
				$data['pValue']=$pValue;
										
				$_filterCond="";
				//if($oValue!="ALL" && $oValue!="")  $_filterCond  = " AND office_id='".$oValue."'";
				//if($cValue!="ALL" && $cValue!="")  $_filterCond .= " AND client_id='".$cValue."'";
				//if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " AND process_id='".$pValue."'";
				
				if($oValue!="ALL" && $oValue!="") 
				$qSql="SELECT DISTINCT d.client_id,c.shname FROM $design_table as d 
				LEFT JOIN client as c ON c.id=d.client_id WHERE d.office_id='".$oValue."'";
				else $qSql=" Select id as client_id, shname from client where is_active='1'";	
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSqlall="Select id as client_id, shname from client where is_active='1'";	
				$data['client_list_all'] = $this->Common_model->get_query_result_array($qSqlall);
								
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype=1";
				$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql="SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype=1";
				$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
				
				if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
				else $data['process_list'] = $this->Common_model->get_process_for_assign();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" WHERE id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				//============ FORM URL DATA
				$data['hide_normal'] = "off";
				$url_batch_id = "";
				$data['set_batch_id'] = $set_batch_id = $this->uri->segment(3);
				if($set_batch_id != ""){ $url_batch_id = $set_batch_id;	}
				$data['get_batch_id'] = $get_batch_id = $this->input->get('batchid');
				if($get_batch_id != ""){ $url_batch_id = $get_batch_id; }
				$data['url_batch_id'] = $url_batch_id;
				
					
				$sql = "Select b.id as batch_id, b.batch_office_id, b.client_id, b.process_id, b.batch_name, 
					y.name as process_name, k.office_name  as office_name, c.shname as client_name 
					from training_batch as b 
					LEFT JOIN process as y ON y.id = b.process_id
					LEFT JOIN office_location k  ON k.abbr = b.batch_office_id
					LEFT JOIN client c ON c.id = b.client_id
					WHERE b.id = '$url_batch_id'";
				$data['batchd'] = $querybatch = $this->Common_model->get_query_row_array($sql);
					
				// CHECK ANY PREVIOUS DESIGN
				$sqldd = "SELECT id as value from $design_table WHERE process_id = '".$querybatch['process_id']."' AND client_id = '".$querybatch['client_id']."' ORDER BY ID DESC LIMIT 1";
				$data["previous_design"] = $pv_rag = $this->Common_model->get_single_value($sqldd);
				if($pv_rag != ""){
					$qSql = "SELECT *,(SELECT name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $pv_rag";
					$data['pv_desgin'] = $this->Common_model->get_query_result_array($qSql);
				}
				
				// GET DESIGN DATA
				$qSql="Select mp.id as mp_id,mp.office_id,mp.client_id,mp.process_id, mp.is_active, mp.description, mp.passing_percentile, y.name as process_name, k.office_name  as office_name, c.shname as client_name 
				from $design_table mp
				LEFT JOIN process as y ON y.id = mp.process_id
					LEFT JOIN office_location k  ON k.abbr = mp.office_id
					LEFT JOIN client c ON c.id = mp.client_id
				WHERE mp.is_active=1 AND mp.trn_batch_id = '$url_batch_id' $_filterCond";
				$data["design_table"] = $design_row = $this->Common_model->get_query_result_array($qSql);
				
				$pmkpiarray=array();
				foreach($design_row as $row):
					$mp_id= $row['mp_id'];
					$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as kpi_type_name from $design_kpi kp where did = $mp_id";
					$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
				endforeach;
				
				$data['design_kpi'] = $design_row_kpi = $pmkpiarray;
				
				//loading training javascript
				//$data["content_js"] = "training/cert_design_js.php";
			
				$this->load->view('dashboard',$data);
				
			}
		}
		
		
	
	   public function add_recursive_Incubation_Design()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_incub_design";
				$data['design']['name'] = $design_name = "Recursive Incubation";
				$data['design']['kpi'] = $design_kpi = "training_recursive_incub_kpi";
				$data['design']['data'] = $design_data = "training_recursive_incub_data";
				$data['design']['url']['design'] = $url_design = "recursive_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_Incubation_DesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				
				$batch_id    = trim($this->input->post('trn_batch_id'));
				$office_id    = trim($this->input->post('office_id'));
				$client_id    = trim($this->input->post('client_id'));
				$process_id   = trim($this->input->post('process_id'));
				$description  = trim($this->input->post('description'));
				$passing_percetnage = trim($this->input->post('new_passing_percetnage'));
				
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$qSqlcheck      = "SELECT id as value from $design_table WHERE trn_batch_id = '$batch_id'";
				$uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				if($uploadcheck != "")
				{
					//redirect($_SERVER['HTTP_REFERER']);
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show&exist=yes");
					
				} else {
					
					$field_array = array(
						"trn_batch_id" => $batch_id,
						"office_id"    => $office_id,
						"client_id"    => $client_id,
						"process_id"   => $process_id,
						"description"  => $description,
						"passing_percentile" => $passing_percetnage,
						"added_by"     => $current_user,
						"is_active"    => '1',
						"added_date"   => $curDateTime,
						"uplog"        => $log
					);
					
					$did = data_inserter($design_table,$field_array);
					
					foreach($kpi_name_arr as $index => $kpi_name){
						if($kpi_name<>""){
							$field_array = array(
								"did" => $did,
								"kpi_name"    => $kpi_name,
								"kpi_type"    => $kpi_type_arr[$index],
								"kpi_weightage" => $kpi_weightage_arr[$index],
								"isdel"       => '0',
								"added_by"    => $current_user,
								"added_date"  => $curDateTime,
								"uplog"       => $log
							);
							data_inserter($design_kpi,$field_array);
						}
					}
				
					redirect(base_url()."training/".$url_design ."?batchid=".$batch_id."&showReports=Show");
				}
				
		   }         
	   }
		
		
		public function get_recursive_Incubation_DesignForm()
		{
			if(check_logged_in())
			{				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_incub_design";
				$data['design']['name'] = $design_name = "Recursive Incubation";
				$data['design']['kpi'] = $design_kpi = "training_recursive_incub_kpi";
				$data['design']['data'] = $design_data = "training_recursive_incub_data";
				$data['design']['url']['design'] = $url_design = "recursive_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_Incubation_DesignForm";
				
				$mdid = trim($this->input->post('mdid'));
				$mdid=addslashes($mdid);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
				$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "SELECT * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
				$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
					
				//$qSql="select * from pm_design where id = $mdid";
				//$design_row=$this->Common_model->get_query_row_array($qSql);
				
				$qSql="SELECT * from $design_kpi where did = $mdid";
				$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
				
				/////////
				$html = "";
				
				$TotRow = count($design_kpi_arr);
				
				$cnt = 1;
				foreach($design_kpi_arr as $kpiRow) {
				
					$html .= "<div class='col-md-12 kpi_input_row'>";					
					$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";					
					$html .= "<div class='col-md-5'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
     				$html .= "<div class='col-md-3'><select class='form-control' name='kpi_type[]' > ";
					
					foreach($kpi_type_list as $kpimas){						
						$sCss="";
						if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
						$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
					}
									
					$html .= "</select></div>";
					
					$html .= "<div class='col-md-2'><input type='text' value='". $kpiRow['kpi_weightage'] ."' onkeyup=\"this.value=this.value.replace(/[^\d]/,'')\" class='form-control' name='kpi_weightage[]'></div>";
					
					$html .= "<div class='col-md-2'>";						
						if( $cnt++<$TotRow-1){							
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
						}else{
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
							$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove hide'>Remove</button>";
						}
									
					$html .= "</div>";
				    $html .= "</div>";
				
				}	
						
				echo $html;
			}
		}

	
	   public function update_recursive_Incubation_Design()
	   {
			if(check_logged_in())
			{
							
				$user_site_id  = get_user_site_id();
				$srole_id      = get_role_id();
				$current_user  = get_user_id();
				$ses_dept_id   = get_dept_id();
				
				$user_office_id   = get_user_office_id();
				$is_global_access = get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_incub_design";
				$data['design']['name'] = $design_name = "Recursive Incubation";
				$data['design']['kpi'] = $design_kpi = "training_recursive_incub_kpi";
				$data['design']['data'] = $design_data = "training_recursive_incub_data";
				$data['design']['url']['design'] = $url_design = "recursive_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_Incubation_DesignForm";
				
				$_run = false;  
				
				$log = get_logs();
				$mdid = trim($this->input->post('mdid'));
				
				$batch_id  = trim($this->input->post('batch_id'));
				$office_id  = trim($this->input->post('office_id'));
				$client_id  = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$description = trim($this->input->post('description'));
				
				$kpi_id_arr   = $this->input->post('kpi_id');
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_type_arr = $this->input->post('kpi_type');
				$kpi_weightage_arr = $this->input->post('kpi_weightage');
				
				$field_array = array(
					"office_id"   => $office_id,
					"client_id"   => $client_id,
					"process_id"  => $process_id,
					"description" => $description,
					"added_by"    => $current_user,
					"is_active"   => '1',
					"uplog"       => $log
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				$TotID = count($kpi_id_arr);
				
				// DELETE DESIGN
				$sql = "DELETE from $design_kpi WHERE did = '$mdid'";
				$query = $this->db->query($sql);
				
				foreach($kpi_name_arr as $index => $kpi_name)
				{
					if($kpi_name != "")
					{						
						$field_array = array(
							"did"         => $mdid,
							"kpi_name"    => $kpi_name,
							"kpi_type"    => $kpi_type_arr[$index],
							"kpi_weightage"   => $kpi_weightage_arr[$index],
							"isdel"       => '0',
							"added_by"    => $current_user,
							"added_date"  => curDateTime,
							"uplog"       => $log
						);
						
						data_inserter($design_kpi, $field_array);						
					}
				}
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
	   }

		
		public function updatRecursiveIncubPassingMarks()
		{
			if(check_logged_in())
			{
							
				$user_site_id= get_user_site_id();
				$srole_id= get_role_id();
				$current_user = get_user_id();
				$ses_dept_id=get_dept_id();
				
				$user_office_id=get_user_office_id();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$curDateTime      = CurrMySqlDate();
				
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_incub_design";
				$data['design']['name'] = $design_name = "Recursive Incubation";
				$data['design']['kpi'] = $design_kpi = "training_recursive_incub_kpi";
				$data['design']['data'] = $design_data = "training_recursive_incub_data";
				$data['design']['url']['design'] = $url_design = "recursive_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_Incubation_DesignForm";
				
				$_run = false;  
				
				$log=get_logs();
				
				$mdid = trim($this->input->post('mdid'));
				$passing_marks = trim($this->input->post('passing_marks'));
				
				$field_array = array(
					"passing_percentile" => $passing_marks
				);
				
				$this->db->where('id', $mdid);
				$this->db->update($design_table,$field_array);
				
				
				redirect($_SERVER['HTTP_REFERER']);
				
			}
		}


		public function recursive_incubation()
		{
			
			if(check_logged_in())
			{
				
				$current_user = get_user_id();
				$evt_date = CurrMySqlDate();

				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				
				//echo $user_office_id;
				
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				if(global_access_training_module()==true) $is_global_access="1";
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				//=========== SET TABLES AND NAME
				$data['design']['table'] = $design_table = "training_recursive_incub_design";
				$data['design']['name'] = $design_name = "Recursive Incubation";
				$data['design']['kpi'] = $design_kpi = "training_recursive_incub_kpi";
				$data['design']['data'] = $design_data = "training_recursive_incub_data";
				$data['design']['url']['design'] = $url_design = "recursive_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_Incubation_DesignForm";
				
				$batch="";
				$cond="";
				$filterCond="";
				$filterCond2="";
				$filterCond3 = "";
				$filterCond4 = " and trn_batch_status = '1' and is_incubation = '1'";
				
				$data["aside_template"] = "training/aside.php";
				$data["content_template"] = "training/recursive_incub_details.php";
				
				$oValue = trim($this->input->get('office_id'));
				if($oValue=="") $oValue = trim($this->input->get('office_id'));
				if($oValue=="" ) $oValue=$user_office_id;
				$data['oValue']=$oValue;
				
				if($oValue!="ALL" ){
						$filterCond = " and batch_office_id='$oValue' ";
						$filterCond2 = " and location_id='$oValue' ";
				}
				
				if($this->input->get('searchtraining'))
				{
					$daterange_full = $this->input->get('daterange');
					$daterange_explode = explode('-',$daterange_full);
					$startdate_range   = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[0]))));
					$enddate_range     = date('Y-m-d', strtotime(str_replace("/", "-", trim($daterange_explode[1]))));
					$filterCond3 = " AND trn_start_date >= '$startdate_range' AND trn_start_date <= '$enddate_range'";
					$filterCond4 = "";
					
				}	
				
				//if( $is_global_access!=1) $filterCond =" and (location='$user_office_id' OR '$user_oth_office' like CONCAT('%',location,'%') )";
				
				if($is_global_access=="1" || (get_role_dir()=="manager" && get_dept_folder()=="training") || $this->check_all_training_access()){
					
					$qSql="SELECT tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_type=4 $filterCond $filterCond4 $filterCond3 ORDER by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
					
				}else{
					$qSql="SELECT tb.*, c.shname as client_name , p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id
					WHERE trainer_id='$current_user' and trn_type=4 $filterCond4 $filterCond3 ORDER by tb.id desc";
					
					$data["assigned_batch"] = $assigned_batch = $this->Common_model->get_query_result_array($qSql);
				}
				
				$i = 0;
				$AllBatchArray = array();
				foreach($assigned_batch as $token)
				{
					
					$batch_id= $token['id'];
					$location= $token['location'];
					$key = $location."-".$batch_id;
					
					$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id 
					from training_batch tb 
					LEFT JOIN client c ON  c.id=tb.client_id 
					LEFT JOIN process p ON  p.id=tb.process_id 
					LEFT JOIN signin ON  signin.id=tb.trainer_id 
					WHERE trn_type=4 AND tb.id = '$batch_id' $filterCond4";
					$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
					
					$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
					$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
					
					$pmdid = $pm_batch_rowb['id'];
					$assigned_batch[$i]['batchid'] = $pmdid;
					
					$sqldesign = "SELECT * from $design_table WHERE id = '$pmdid'";
					$querydesign  = $this->Common_model->get_query_row_array($sqldesign);
					
					$sqldesignkpi = "SELECT * from $design_kpi WHERE did = '$pmdid'";
					$querydesignkpi  = $this->Common_model->get_query_result_array($sqldesignkpi);
					
					$assigned_batch[$i]['batchid_rag'] = $querydesign;
					$assigned_batch[$i]['batchid_kpi'] = $querydesignkpi;
					
					$qSql= "SELECT  td.*, fusion_id, fname, lname, status from training_details td LEFT JOIN signin s on td.user_id = s.id Where td.trn_batch_id = '$batch_id' order by fname ";					
					$AllBatchArray[$key] = $this->Common_model->get_query_result_array($qSql);
					
					$data['checkupload'][$batch_id] = '0';
					
					foreach($AllBatchArray[$key] as $tokenuser)
				    {
						$userget_id = $tokenuser['user_id'];
						$jcheck = 0;
						
						// GET MULTIPLE VALUE CHECK
						$sqlm = "SELECT count(*) as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' GROUP BY crtdid, kpi_id ORDER by ID DESC LIMIT 1";
						$querym = $this->Common_model->get_single_value($sqlm);
						$assigned_batch[$i]['checksum'][$userget_id] = $querym;
						
						if($querym > 0){ $data['checkupload'][$batch_id] = '1'; }
						if($querym < 0){ $data['checkupload'][$batch_id] = '0'; }
						
						foreach($querydesignkpi as $tokenarray)
						{
							$ragdid = $tokenarray['did'];
							$kpiid = $tokenarray['id'];
							$qsqlvalue = "SELECT kpi_value as value from $design_data WHERE user_id = '$userget_id' AND trn_batch_id = '$batch_id' AND crtdid = '$ragdid' AND kpi_id = '$kpiid'";
							$kpivalue = $this->Common_model->get_single_value($qsqlvalue);
							$assigned_batch[$i]['batchid_kpi'][$jcheck][$userget_id]['kpi_value'] = $kpivalue;
							$jcheck++;
						}
					}
					
					
					$i++;
				}
				
				$data["assigned_batch"] = $assigned_batch;
				$data["AllBatchArray"] = $AllBatchArray;
				
				// GET KPI DETAILS
				//echo "<pre>" .print_r($assigned_batch, true) ."</pre>";die();
				
				if($is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				} else {
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					if($this->check_all_training_access())
					{
						$access_office_ids = $this->check_all_training_access('office');
						$extra_access_office = implode("','", $access_office_ids);
						$sql_office = "SELECT * from office_location WHERE abbr IN ('$extra_access_office')";
						$query = $this->db->query($sql_office);
						$data['location_list'] = $query->result_array();
					}
				}
							
				$this->load->view('dashboard',$data);
				
				
			}
			
				
		}

	   		
	public function downloadTrainingRecursiveIncubationHeader()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_incub_design";
				$data['design']['name'] = $design_name = "Recursive Incubation";
				$data['design']['kpi'] = $design_kpi = "training_recursive_incub_kpi";
				$data['design']['data'] = $design_data = "training_recursive_incub_data";
				$data['design']['url']['design'] = $url_design = "recursive_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_Incubation_DesignForm";
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, trn_batch_id, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		$batchid = $pm_design_row['trn_batch_id'];
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('6');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
		
		if(!empty($batchid)){
			$slNo = 0; $r=2;
			$qSql = "Select s.*, d.user_id, CONCAT(s.fname, ' ', s.lname) as fullname from training_details as d INNER JOIN signin as s ON s.id = d.user_id WHERE d.trn_batch_id = '$batchid'";
			$querySql=$this->Common_model->get_query_result_array($qSql);
			foreach($querySql as $rowD):
				$slNo++; $r++; $j=0; 
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $slNo);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fusion_id']);
				
				$cell= $letters[$j++].$r;
				$this->excel->getActiveSheet()->setCellValue($cell, $rowD['fullname']);			
			endforeach;
		}
		
		$currentcellvalue = ord('C');
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
		
			$currentcellvalue++;
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('20');
			
			$cell=$letters[$j++].$r;
			$getkpiname = $row['kpi_name'] .' ('.$row['kpi_weightage'] .'%)';
			if($row['kpi_name'] == "Status"){ 
			$getkpiname = "Status (Pass/Fail)"; 
			$this->excel->getActiveSheet()->getColumnDimension(chr($currentcellvalue))->setWidth('30'); 
			}
			$this->excel->getActiveSheet()->setCellValue($cell, $getkpiname);
			
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.chr($currentcellvalue).'1');
		$this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->applyFromArray(
			 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:'.chr($currentcellvalue).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('cccccc');
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	
	
	/// DOWNLOAD NESTING RESULT
	   		
	public function downloadTrainingRecursiveIncubationResult()
    {
		
		$batchid = "";
		$pmdid = trim($this->input->get('pmdid'));
		$batchid = trim($this->input->get('batchid'));
	    
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_incub_design";
				$data['design']['name'] = $design_name = "Recursive Incubation";
				$data['design']['kpi'] = $design_kpi = "training_recursive_incub_kpi";
				$data['design']['data'] = $design_data = "training_recursive_incub_data";
				$data['design']['url']['design'] = $url_design = "recursive_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_Incubation_DesignForm";
		
			
		if($batchid != "")
		{
			$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_office_id, batch_name from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
			$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
			$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
			$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
			
			$pmdid = $pm_batch_rowb['id'];
			
		}
        
		
		if($pmdid != ""){
			
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from $design_table mp Where is_active=1 and id=$pmdid";
			
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
		$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
		
		$j=3;
		$r=2;
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from $design_kpi kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$cell=$letters[$j++].$r;
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
			
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
	}
	
	
	
	public function uploadRecursiveIncubationResult()
	{
		
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$batch_id = trim($this->input->post('batch_id'));
						 
			$ret = array();
			
			if($batch_id!=""){
			
				$output_dir = "uploads/training_nesting/";
							
				$error =$_FILES["sktfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["sktfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["sktfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_Recursive_Incubation_file($fileName,$batch_id);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["sktfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["sktfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["sktfile"]["name"]);
					
					move_uploaded_file($_FILES["sktfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_Recursive_Incubation_file($fileName,$batch_id);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
		
		
	}
	
	
	
	
	private function Import_Recursive_Incubation_file($file_name,$batch_id)
	{
		$current_user = get_user_id();
		$file_path = './uploads/training_nesting/'.$file_name;
				
		$curDateTime   = CurrMySqlDate();
	    $log = get_logs();
		
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_incub_design";
				$data['design']['name'] = $design_name = "Recursive Incubation";
				$data['design']['kpi'] = $design_kpi = "training_recursive_incub_kpi";
				$data['design']['data'] = $design_data = "training_recursive_incub_data";
				$data['design']['url']['design'] = $url_design = "recursive_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_Incubation_DesignForm";
				
		// GET RAG DID FROM BATCH
		$qSqlb="SELECT tb.*,
				c.shname as client_name, 
				p.name as process_name, 
				batch_name, batch_office_id, 
				CONCAT(fname,' ' ,lname) as trainer_name, 
				office_id, batch_office_id, batch_name from training_batch tb 
				LEFT JOIN client c ON  c.id=tb.client_id 
				LEFT JOIN process p ON  p.id=tb.process_id 
				LEFT JOIN signin ON  signin.id=tb.trainer_id
				where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batch_id'";
		
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batch_id'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		$pmdid = $pm_batch_rowb['id'];
			
		
		// GET KPI DETAILS
		$qSql = "Select * from $design_kpi kp where did = $pmdid";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		foreach($kpiarray as $tokeni)
		{
			$countkpi++;
			//$kpiid = $tokeni['id'];
			$kpidata[$countkpi] = $tokeni['id'];
		}
		
		//$this->load->library('excel');
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file_path);
		
		/* $i = 0;
		while ($objPHPExcel->setActiveSheetIndex($i)){
		echo $i; */
		$objPHPExcel->setActiveSheetIndex(0);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		//now do whatever you want with the active sheet
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$worksheetTitle = $objWorksheet->getTitle();
		
		if((ord($highestColumn) - ord('C')) == $countkpi){
		
		$startcol = ord('D');
		$lastCol  = ord($highestColumn);
		
        // GET RAG DATA ARRAY
		$rag_data = array();
		for($row = 3; $row <= $highestRow; $row++)
		{
			$totaluser++;
			$startcol = ord('D');
			for($j=1; $j<=$countkpi; $j++)
			{
			  $rag_data['fusion_id'][$row][$j] = $objWorksheet->getCell(chr($startcol).$row)->getValue();
			  $rag_data['fusion_id'][$row]['fid'] = $objWorksheet->getCell('B'.$row)->getValue();
			  $startcol++;
			}
		}
		
		//echo "hi";
		//echo "<pre>" .print_r($rag_data, true) ."</pre>"; die();
	
		// DATA INSERTION START
		$this->db->trans_begin();
		for($starti=3; $starti <= $totaluser+2; $starti++)
		{
			$fusion_id = $rag_data['fusion_id'][$starti]['fid'];
			$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
			
			$qSql      = "select id as value from signin where fusion_id ='$fusion_id'";
			$user_id   = $this->Common_model->get_single_value($qSql);
			if($user_id != ""){
			for($j=1; $j<=$countkpi; $j++)
			{   

				$qSqlcheck      = "select id as value from $design_data where user_id ='$user_id' AND trn_batch_id = '$batch_id' AND crtdid = '$pmdid' AND kpi_id = '".$kpidata[$j]."'";
			    $uploadcheck    = $this->Common_model->get_single_value($qSqlcheck);
				
				$field_array = array(
							"user_id"    => $user_id,
							"trn_batch_id" => $batch_id,
							"crtdid"     => $pmdid,
							"kpi_id"     => $kpidata[$j],
							"kpi_value"  => $rag_data['fusion_id'][$starti][$j],
							"added_by"   => $current_user,
							"added_date" => $curDateTime,
							"uplog"      => $log
						);
				
				if($uploadcheck != ""){
					
					$this->db->where('id', $uploadcheck);
					$this->db->update($design_data,$field_array);
					
					
				} else {
					
					data_inserter($design_data,$field_array);
				
				}
			
				//print_r($field_array);die();$_run = false;					
				
			}	
			}		
			
		}
		
		//return "done";
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return "error";
		}
		else
		{
			$this->db->trans_commit();
			return "done";
		}
		
		} else {
			return "error";
		}
		
		
	}
	
	
	
	
	public function getFormatDesignRecursiveIncubation()
	{
		//=========== SET TABLES AND NAME
		$data['design']['table'] = $design_table = "training_recursive_incub_design";
				$data['design']['name'] = $design_name = "Recursive Incubation";
				$data['design']['kpi'] = $design_kpi = "training_recursive_incub_kpi";
				$data['design']['data'] = $design_data = "training_recursive_incub_data";
				$data['design']['url']['design'] = $url_design = "recursive_incub_design";
				$data['design']['url']['add_design'] = $url_add_design = "add_recursive_Incubation_Design";
				$data['design']['url']['update_design'] = $url_update_design = "update_recursive_Incubation_Design";
				$data['design']['url']['get_form_design'] = $url_get_form_design = "get_recursive_Incubation_DesignForm";
		
		$batchid = trim($this->input->get('batchid'));
		$qSqlb="Select tb.*,c.shname as client_name, p.name as process_name, CONCAT(fname,' ' ,lname) as trainer_name, office_id, batch_name, batch_office_id from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id where trn_batch_status = '1' and trn_type=4 AND tb.id = '$batchid'";
		$pm_batch_rowb = $this->Common_model->get_query_row_array($qSqlb);
		
		$getpmid = "SELECT * from $design_table WHERE trn_batch_id = '$batchid'"; 
		$pm_batch_rowb = $this->Common_model->get_query_row_array($getpmid);
		
		$pmdid = $pm_batch_rowb['id'];
		if($pmdid != ""){
			echo $pmdid;
		} else { echo "0"; }
	}














//================= TRAINING SURVEY =======================================//
	
	public function	training_survey()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$feedback_array = array(
			"U" => "Unsatisfied",
			"F" => "Fairly Unsatisfied",
			"A" => "Average",
			"G" => "Good",
			"O" => "Outstanding",
		);
		
		$url_batch = $this->uri->segment(3);
		if(!empty($url_batch))
		{
			// CHECK FEEDBACK
			$sqlcheck = "SELECT count(*) as value from training_post_classroom_survey WHERE trainee_id = '$current_user' AND training_batch = '$url_batch'";
			$data['feedbackCheck'] =  $feedbackCheck = $this->Common_model->get_single_value($sqlcheck);
			
			// SELECT TRAINEE
			$qSqlt = "SELECT s.id, s.fusion_id, concat(s.fname, ' ', s.lname) as name from signin as s WHERE s.id = '$current_user'";
			$data["select_trainee"]  = $this->Common_model->get_query_row_array($qSqlt);
			
			// SELECT TRAINER
			$qSqlt = "SELECT s.id, s.fusion_id, d.shname as department, r.name as designation, concat(s.fname, ' ', s.lname) as name, s.office_id from signin s LEFT JOIN department d ON s.dept_id = d.id LEFT JOIN role r on r.id = s.role_id WHERE s.status=1 and (s.role_id not in (select id from role where folder='agent') OR s.dept_id=11) and s.office_id='$user_office_id' ORDER BY name ASC ";
			$data["select_trainer"]  = $this->Common_model->get_query_result_array($qSqlt);
			
			// SELECT BATCH
			$qSqlt = "SELECT t.*, c.shname as client_name, p.name as process_name, CONCAT(fname, ' ', lname) as trainer_name, CONCAT(dfr.job_title, '-', dfr.requisition_id) as dfr_batch_name
			          from training_batch as t
			          LEFT JOIN client as c ON t.client_id = c.id
					  LEFT JOIN process as p ON t.process_id = p.id
					  LEFT JOIN signin as s ON t.trainer_id = s.id
					  LEFT JOIN dfr_requisition dfr ON  dfr.id = t.ref_id 
					  WHERE t.id = '$url_batch'";
			$data["training_batch"]  = $this->Common_model->get_query_row_array($qSqlt);
			
			
			$qSql="Select tb.*,c.shname, p.name, dfr.requisition_id, dfr.job_title, CONCAT(fname,' ' ,lname) as trainer_name, office_id, location from training_batch tb LEFT JOIN client c ON  c.id=tb.client_id LEFT JOIN process p ON  p.id=tb.process_id LEFT JOIN signin ON  signin.id=tb.trainer_id LEFT JOIN dfr_requisition dfr ON  dfr.id=tb.ref_id where trn_type=2 $filterCond4 $filterCond $filterCond3 order by tb.id desc";
					
			
			// TRAINER DETAILS
			$qSqlt = "SELECT s.id, s.fusion_id, d.shname as department, r.name as designation, concat(s.fname, ' ', s.lname) as name, s.office_id from signin s 
			          LEFT JOIN department d ON s.dept_id = d.id 
					  LEFT JOIN role r on r.id = s.role_id 
					  WHERE s.id = '".$data["training_batch"]['trainer_id']."'
					  ORDER BY name ASC ";
			$data["batch_trainer"]  = $this->Common_model->get_query_result_array($qSqlt);
		}
		
		
		$data["aside_template"] = "training/aside.php";
		$data["content_template"] = "training/training_survey.php";
		
		$this->load->view('dashboard',$data);
		
	}
	
	
	public function	training_agent_survey()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		
		$sql_train = "SELECT b.*, d.user_id, d.trn_status, d.is_certify, c.shname as client_name, p.name as process_name, CONCAT(fname, ' ', lname) as trainer_name, CONCAT(dfr.job_title, '-', dfr.requisition_id) as dfr_batch_name, st.id as survey_id 
		from training_details as d
		INNER JOIN training_batch as b ON b.id = d.trn_batch_id
		LEFT JOIN client as c ON b.client_id = c.id
		LEFT JOIN process as p ON b.process_id = p.id
		LEFT JOIN signin as s ON b.trainer_id = s.id
		LEFT JOIN dfr_requisition dfr ON  dfr.id = b.ref_id 
		LEFT JOIN training_post_classroom_survey st ON  st.training_batch = b.id AND st.trainee_id = d.user_id
		WHERE d.user_id = '$current_user' AND b.trn_survey_status = '1'";
		$data['my_training_batch'] = $this->Common_model->get_query_result_array($sql_train);
		
		$data["aside_template"] = "training/aside.php";
		$data["content_template"] = "training/training_agent_survey.php";
		
		$this->load->view('dashboard',$data);
		
	}
	
	
	public function	submit_training_survey()
	{
		$current_user = get_user_id();
		$trainee_id = $this->input->post('trainee_id');
		$training_program = $this->input->post('batch_id');
		$training_start = $this->input->post('training_start');
		$trainer_id = $this->input->post('trainer_id');
		
		// CALCULATE FEEDBACK POINTS
		$feedback_array_points = array(
			"U" => 1,
			"F" => 2,
			"A" => 3,
			"G" => 4,
			"O" => 5,
		);
		$total_score = 0;
		for($i=1;$i<=10;$i++){			
			$total_score += $feedback_array_points[$this->input->post('survey_'.$i)];
			//echo $i ." - " .$this->input->post('survey_'.$i) ." - " .$feedback_array_points[$this->input->post('survey_'.$i)] ." - " .$total_score ."<br/>";
		}
		$avg_rating_score = $total_score/10;
		
		$data_array = array(
			"trainee_id" => $trainee_id,
			"training_batch" => $training_program,
			"training_start" => $training_start,
			"trainer_id" => $trainer_id,
			"survey_1" => $this->input->post('survey_1'),
			"survey_2" => $this->input->post('survey_2'),
			"survey_3" => $this->input->post('survey_3'),
			"survey_4" => $this->input->post('survey_4'),
			"survey_5" => $this->input->post('survey_5'),
			"survey_6" => $this->input->post('survey_6'),
			"survey_7" => $this->input->post('survey_7'),
			"survey_8" => $this->input->post('survey_8'),
			"survey_9" => $this->input->post('survey_9'),
			"survey_10" => $this->input->post('survey_10'),
			"rating_score" => $total_score,
			"avg_rating_score" => $avg_rating_score,
			"added_by" => $current_user,
			"date_added" => CurrMySqlDate(),
			"logs" => get_logs()
		);
		
		data_inserter('training_post_classroom_survey', $data_array);
		
		// CHECK SURVEY
		$sql_survey = "SELECT count(*) as value from training_details as d 
					   INNER JOIN training_batch as b ON d.trn_batch_id = b.id
					   INNER JOIN signin as s ON d.user_id = s.id
					   LEFT JOIN training_post_classroom_survey as st ON  st.training_batch = b.id 
		               WHERE d.trn_batch_id = '$training_program' AND st.id <> ''";
		//$query_survey = $this->Common_model->get_single_value($sql_survey);
		
		redirect(base_url()."training/training_agent_survey");
		
	}
	
	
	public function	takeSurvey()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$batch_id = $this->input->post('survey_batch_id');
		$survey_status = $this->input->post('survey_status');
		$data_array = array( "trn_survey_status" => $survey_status );
		$this->db->where('id', $batch_id);
		$this->db->update('training_batch', $data_array);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
		
	
	//========================== TRAINING SURVEY REPORTS ================================================//
	
	public function training_survey_reports()
	{
		if(check_logged_in())
		{
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			if(global_access_training_module()==true) $is_global_access="1";
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$data["aside_template"] = "training/aside.php";
			$data["content_template"] = "training/training_agent_survey_reports.php";
			
			$trn_type = trim($this->input->post('training_type'));
			if($trn_type=="") $trn_type = trim($this->input->get('training_type'));
			if($trn_type=="") $trn_type=2;
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			if($cValue=="") $cValue="0";
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['oValue']=$oValue;
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			$data['batch_type'] = $trn_type;
			$data['batch_list'] = 'training/crt_batch';
			
			if($oValue!="ALL" && $oValue!="")
			{
				//$qSql="SELECT DISTINCT(id) as client_id,client.shname FROM client"; 
			    $qSql="SELECT client_id, c.shname FROM training_batch as b LEFT JOIN client as c ON c.id = b.client_id GROUP BY b.client_id";
			} else { 
			    $qSql="SELECT client_id, c.shname FROM training_batch as b LEFT JOIN client as c ON c.id = b.client_id GROUP BY b.client_id";
			    //$qSql=" Select id as client_id, shname from client where is_active='1' ";
			}
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
			
			if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
			else $data['process_list'] = $this->Common_model->get_process_for_assign();
			
			if($is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$showreport = $this->input->get('showReports');
			if($showreport == "Download Excel"){
				$this->generate_training_agent_survey_excel_reports($oValue, $cValue, $pValue, $trn_type);
				die();
			} else {
				$this->load->view('dashboard',$data);
			}			
			
		}
	
	}
	
	public function generate_training_agent_survey_excel_reports($office_id, $client_id, $process_id, $training_type = '2')
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$_filterCond="";			
		if($office_id!="ALL" && $office_id!="") $_filterCond = " AND (tb.batch_office_id = '".$office_id."' OR dfr.location = '".$office_id."')";
		if($client_id!="ALL" && $client_id!="") $_filterCond .= " AND tb.client_id='".$client_id."'";
		if($process_id!="ALL" && $process_id!="" && $process_id != "0") $_filterCond .= " AND tb.process_id='".$process_id."'";
		
		$sql_training_batch = "SELECT tb.id, tb.batch_office_id, tb.trn_start_date, tb.batch_name, 
		                       c.shname as client_name, p.name as process_name, dfr.location, tb.batch_name, dfr.job_title, dfr.requisition_id,
							   CONCAT(s.fname,' ' ,s.lname) as trainer_name, s.office_id, d.total_trainees, sv.avg_rating
		                       from training_batch as tb 
							   LEFT JOIN process p on p.id = tb.process_id
							   LEFT JOIN client c on c.id = tb.client_id
							   LEFT JOIN signin as s ON s.id=tb.trainer_id
							   LEFT JOIN (SELECT count(td.id) as total_trainees, td.trn_batch_id from training_details as td GROUP BY td.trn_batch_id) as d ON d.trn_batch_id = tb.id
							   LEFT JOIN (SELECT avg(avg_rating_score) as avg_rating, training_batch from training_post_classroom_survey GROUP BY training_batch) as sv ON sv.training_batch = tb.id
							   LEFT JOIN dfr_requisition dfr ON dfr.id = tb.ref_id
		                       WHERE trn_type = '$training_type' $_filterCond ORDER BY tb.id ASC";
		$training_batches = $this->Common_model->get_query_result_array($sql_training_batch);
		
		$title = "Training Batch Survey";
		
		$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:AE1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$startColumn = 'A';
		for($move=0;$move<=18;$move++)
		{
			$objWorksheet->getColumnDimension($startColumn)->setAutoSize(true);
			$startColumn++;
		}
		
		//$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:J1'); 
		//$this->objPHPExcel->getActiveSheet()->setCellValue('G1', "IT Checklist");
		
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		if(count($training_batches) > 0)
		{
			$office_location = $training_batches[0]['batch_office_id'];
			if(empty($office_location)){ $office_location = $training_batches[0]['location']; }
			$client_name = $training_batches[0]['client_name'];
			$process_name = $training_batches[0]['client_name'];
			
			$col = 0; $row = 2;	$columnName = 'A';	
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Sl");
			$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Office");
			$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Client");
			$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Process");
			
			$col=0;	$row++;	$columnName = 'A';
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, 1);
			$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $office_location);
			$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $client_name);
			$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $process_name);
			
			// TRAINING BATCH COLOUR
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 10
			));
			
			$col=1;	$row++;	$columnName = 'B'; $batch_count = 0;
			foreach($training_batches as $token)
			{
				$batch_count++;
				$batch_id = $token['id'];
				$batch_office = $token['batch_office_id'];
				if(empty($batch_office)){ $batch_office = $token['location']; }
				$batch_name = $token['batch_name'];
				if(empty($batch_name)){ $batch_name = $token['job_title']."_".$token['requisition_id']; }
			
				$col=1;	$row++; $columnName = 'B';				
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Sl");
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Training Start Date");
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Batch Name");
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Trainer Name");
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Trainees");
				//$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Office");
				//$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Client");
				//$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Process");
				
				$this->objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$columnName.$row)->applyFromArray($styleArray);
				$this->objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$columnName.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffc680');
		
				$col=1;	$row++; $columnName = 'B';				
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $batch_count);
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $token['trn_start_date']);
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $batch_name);
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $token['trainer_name']);
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $token['total_trainees']);
				//$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $batch_office);
				//$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $token['client_name']);
				//$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $token['process_name']);
				
				
				$col=0;	$row++;	$columnName = 'A';
				$sql_batch = "SELECT d.*, CONCAT(s.fname,' ' ,s.lname) as agent_name, s.fusion_id as agent_id from training_details as d LEFT JOIN signin as s ON s.id = d.user_id WHERE trn_batch_id = '$batch_id'";
				$batch_details = $this->Common_model->get_query_result_array($sql_batch);
				
				$sql_survey = "SELECT * from training_post_classroom_survey WHERE training_batch = '$batch_id'";
				$survey_details = $this->Common_model->get_query_result_array($sql_survey);				
				
				//echo "<pre>".print_r($survey_details,1)."</pre>";
				//echo "<pre>".print_r($batch_details,1)."</pre>";
				
				$array_questions = array(
					"The goals of the training were clearly defined.",
					"The course content was simple and understandable.",
					"The training experience will be useful in my work.",
					"The presentation of the material was clear and logical.",
					"Course length and pace were appropriate to the topic.",
					"The trainer was knowledgeable of the topic.",
					"The trainer provided good examples.",
					"The trainer treated the trainees with respect.",
					"The trainer was easy to reach out for questions.",
					"The training room was well-ventilated and favorable to learning."	
				);
				
				$array_answers = array(
					"O" => "Outstanding",
					"G" => "Good",
					"A" => "Average",
					"F" => "Fairly Unsatisfactory",
					"U" => "Unsatisfied",
				);
				
				$array_answers_alt = array(
					"O" => "5",
					"G" => "4",
					"A" => "3",
					"F" => "2",
					"U" => "1",
				);
				
				$col=2;	$row++; $columnName = 'C';				
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Sl");
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Agent ID");
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Agent Name");
				$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, "Survey Rating");
				
				foreach($array_questions as $tokenq)
				{
					$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $tokenq);
				}
				$this->objPHPExcel->getActiveSheet()->getStyle('C'.$row.':'.$columnName.$row)->applyFromArray($styleArray);
				$this->objPHPExcel->getActiveSheet()->getStyle('C'.$row.':'.$columnName.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d5e8f7');
				
				$slCount=0;
				foreach($batch_details as $tokend)
				{
					$col=2;	$row++; $columnName = 'C'; $slCount++;
					
					$survey_index = array_search($tokend['user_id'], array_column($survey_details, 'trainee_id'));
					//echo "Checking - " .$tokend['user_id'] ." -- " .$survey_index ."<br/>";
					//if($survey_index !== FALSE){ echo "<pre>".print_r($survey_details[$survey_index],1)."</pre>"; }
					
					$columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $slCount);
					$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $tokend['agent_id']);
					$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $tokend['agent_name']);					
					
					if($survey_index !== FALSE){ $qStart = 0;
					$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $survey_details[$survey_index]['avg_rating_score']);
					foreach($array_questions as $tokenQ)
					{
						$col++; $columnName++; $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $array_answers_alt[$survey_details[$survey_index]['survey_'.++$qStart]]);
					}
					}
				}
				
				$col=1;	$row++;	$columnName = 'B';
				$col=1;	$row++;	$columnName = 'B';
				//die();
				
			}
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Training_Batch_Survey.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	
	
	
	//========================== TRAINING SURVEY ATTRITION THOUGHPUT ================================================//
	
	public function	updateAttritionTerm()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$batch_id = $this->input->post('bid');
		$user_id = $this->input->post('uid');
		$trnattrition = $this->input->post('trnattrition');
		$attrType = $this->input->post('type');
		
		//echo $batch_id ." - " .$user_id ." - " .$trnattrition ."<br/>";
		//echo "<pre>".print_r($_POST, 1)."</pre>";die();
		if($batch_id != "" && $user_id != "" && $trnattrition != "")
		{
			$arrritionType = '';
			if($trnattrition == 'T'){
			if($attrType == 12){ $arrritionType = 1; }
			if($attrType >= 1 && $attrType <= 11){ $arrritionType = 2; }
			}
			
			$data_array = [ "trn_attrition" => $trnattrition, "attrition_type" =>  $arrritionType ];
			$this->db->where('trn_batch_id', $batch_id);
			$this->db->where('user_id', $user_id);
			$this->db->update('training_details', $data_array);
		}		
		
		echo "SUCCESS";
		
	}
	
	//========================== TRAINING CLOSE BATCH ================================================//
	
	public function	trainingCloseBatch()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$batch_id = $this->input->post('close_batch_id');		
		$close_status = '2';
		if($batch_id != "")
		{
			$data_array = [ "trn_batch_status" => $close_status ];			
			$this->db->where('id', $batch_id);
			$this->db->update('training_batch', $data_array);
		}		
		
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	
	public function	trainingBackIncubationBatch()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$batch_id = $this->input->post('incub_batch_id');		
		$close_status = '2';
		if($batch_id != "")
		{
			$data_array = [ 
				"trn_batch_status" => 1, 
				"is_incubation" => 0, 
			];			
			$this->db->where('id', $batch_id);
			$this->db->update('training_batch', $data_array);
		}		
		
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	
	public function	trainingIncubationBatch()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();
		$curr_date = CurrDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$batch_id = $this->input->post('incub_batch_id');
		$incub_comment = $this->input->post('incub_comment');
		$sql_batch = "SELECT * from training_batch WHERE id = '$batch_id'";
		$batch_details = $this->Common_model->get_query_row_array($sql_batch);
		
		$is_incubation = '1';
		$incubation_date = date('Y-m-d', strtotime("+30 days", strtotime($curr_date)));
		if($batch_id != "")
		{
			$data_array = [ "is_incubation" => $is_incubation ];
			$data_array += [ "incubation_date" => $incubation_date ];
			$data_array += [ "trn_handover_date" => $evt_date ];
			$data_array += [ "trn_handover_by" => $current_user ];	
			
			$this->db->where('id', $batch_id);
			$this->db->update('training_batch', $data_array);
		}		
		
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	//========================== REMOVE TRAINING USER DETAILS BATCH ================================================//
	
	public function	removeUserBatch()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$batch_id = $this->input->post('rm_batch_id');
		$user_id = $this->input->post('rm_user_id');
		$trn_status = $this->input->post('rm_trn_type');
		// $trn_did = $this->input->post('rm_trn_did');
		// var_dump($batch_id, $user_id, $trn_status);die;
		if($batch_id != "" && $user_id != "" && $trn_status != "")
		{
			$this->db->where('trn_status', $trn_status);
			$this->db->where('user_id', $user_id);
			$this->db->where('trn_batch_id', $batch_id);
			$this->db->delete('training_details');
		}		
		redirect($_SERVER['HTTP_REFERER']);	

	}
	
	
	
	public function	updateBatchDetails()
	{
		$current_user = get_user_id();
		$evt_date = CurrMySqlDate();

		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		if(global_access_training_module()==true) $is_global_access="1";
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$batch_id = $this->input->post('batch_id');
		$client_id = $this->input->post('client_id');
		$process_id = $this->input->post('process_id');
		
		if($batch_id != "" && $client_id != "" && $process_id != "")
		{
			$data = [ 'client_id' => $client_id, 'process_id' => $process_id ];
			$this->db->where('id', $batch_id);
			$this->db->update('training_batch', $data);
		}		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	public function	get_incubation_user_request()
	{
		$current_date = CurrDate();
		$current_date = GetLocalDate();
		$sqlCheck = "SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, p.email_id_off, p.email_id_per 
		             from training_batch as b
		             LEFT JOIN signin as s ON s.id = b.trainer_id
		             LEFT JOIN info_personal as p ON p.user_id = s.id
					 WHERE incubation_date = '$current_date' AND (b.id NOT IN (SELECT trn_batch_id from training_recursive_incub_data) OR b.id NOT IN (SELECT trn_batch_id from training_upskill_incub_data))";
		$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
		foreach($queryCheck as $token)
		{
			$batch_name = $token['batch_name'];
			$batch_type = "Training Batch";
			if($token['trn_type'] == 4){ $batch_type = "Recursive Batch"; }
			if($token['trn_type'] == 5){ $batch_type = "Upskill Batch"; }
			$email_subject = "Incubation Score Upload Pending | ".$batch_name." | ".$batch_type;
			//$eto = $token['email_id_off'];
			$eto = 'sachin.paswan@fusionbposervices.com';
			$ecc = '';
			$from_email="noreply.fems@fusionbposervices.com";
			$from_name="Fusion FEMS";
						
			$nbody='Hi, '. $token['trainer_name'] .',<br/>
					<h4> INCUBATION SCORE UPLOAD PENDING</h4>
					
					Batch Name <b>: '.$batch_name .'</b><br/>
					Batch Type <b>: '.$batch_type .'</b><br/>
					Trainer <b>: '.$token['trainer_name'] .'</b><br/><br/>
					
					It is to inform that, its already been <b>30 days</b> as on <u>"'.$token['incubation_date'].'"</u>, the Incubation score for the above batch as mentioned is not yet uploaded. Kindly please upload the same accordingly.</b><br/><br/>
					
					<hr/>This is an <b>Automated Reminder Notification</b>. Please do not reply, ignore if it is already done.</br><hr/>';					
			$nbody .= '</br><b>Regards, </br>
					   Fusion - FEMS	</b></br>
				      ';
			
			echo $nbody;
			//$this->Email_model->send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, "",$from_email,$from_name,'N');	
		}
		
	}
		
	
	public function certify_batch_user(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$user_office_id= get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access=get_global_access();
			if(global_access_training_module()==true)$is_global_access="1";
			$is_role_dir=get_role_dir();
			$get_dept_id=get_dept_id();	
			
			$curDateTime   = CurrMySqlDate();
			$log = get_logs();
		
			$certify_batch_id = trim($this->input->post('certify_batch_id'));
			$certify_batch_status = trim($this->input->post('certify_batch_status'));
			$certify_batch_name = trim($this->input->post('certify_batch_name'));
			$userCertifyCheckBox = $this->input->post('userCertifyCheckBox');
			$countcheckbox = count($userCertifyCheckBox);
						
			for($i=0;$i<$countcheckbox;$i++)
			{
				if($certify_batch_status == 1){
					$dataArray = [ "is_certify" => 1, "is_recertify" => 0 ];
				}
				if($certify_batch_status == 2){
					$dataArray = [ "is_recertify" => 1, "is_certify" => 1 ];
				}
				if($certify_batch_status == 0){
					$dataArray = [ "is_certify" => 2, "is_recertify" => 0 ];
				}
				$getuserid = $userCertifyCheckBox[$i];
				
				if(!empty($getuserid) && !empty($certify_batch_id))
				{	
					$this->db->where('user_id', $getuserid);
					$this->db->where('trn_batch_id', $certify_batch_id);
					$this->db->update('training_details', $dataArray);
				}
			}
			
			redirect($_SERVER['HTTP_REFERER']);
		}		
	}
	
	
	
	//============================ CRON NOTIFY INCUBATION 30 DAYS ==========================================//	
	
	public function	get_incubation_month_notify()
	{
		$current_date = CurrDate();
		$current_date = GetLocalDate();
		$sqlCheck = "SELECT b.*, CONCAT(s.fname, ' ', s.lname) as trainer_name, p.email_id_off, p.email_id_per 
		             from training_batch as b
		             LEFT JOIN signin as s ON s.id = b.trainer_id
		             LEFT JOIN info_personal as p ON p.user_id = s.id
					 WHERE is_incubation = '1' AND incubation_date <= '$current_date' AND (incubation_notify IS NULL OR incubation_notify = '') AND trn_batch_status = '1'";
		$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
		foreach($queryCheck as $token)
		{
			$batch_id = $token['id'];
			$batch_name = $token['batch_name'];
			$batch_type = "Training Batch";
			if($token['trn_type'] == 4){ $batch_type = "Recursive Batch"; }
			if($token['trn_type'] == 5){ $batch_type = "Upskill Batch"; }
			$email_subject = "Incubation Batch | 30 Days Completed | ".$batch_name." | ".$batch_type;
			$eto = $token['email_id_off'];
			//$eto = 'sachin.paswan@fusionbposervices.com';
			$ecc = '';
			$from_email="noreply.fems@fusionbposervices.com";
			$from_name="Fusion FEMS";
						
			$nbody='Hi, '. $token['trainer_name'] .',<br/>
					<h4> INCUBATION BATCH COMPLETED 30 DAYS</h4>
					
					Batch Name <b>: '.$batch_name .'</b><br/>
					Batch Type <b>: '.$batch_type .'</b><br/>
					Trainer <b>: '.$token['trainer_name'] .'</b><br/><br/>
					
					It is to inform that, this batch has completed <b>30 days</b> as on <u>"'.$token['incubation_date'].'"</u>, Kindly please check on it, do the required accordingly.</b><br/><br/>
					
					<hr/>This is an <b>Automated Reminder Notification</b>. Please do not reply, ignore if it is already done.</br><hr/>';					
			$nbody .= '</br><b>Regards, </br>
					   Fusion - FEMS	</b></br>
				      ';
			
			$sqlUpdate = "UPDATE training_batch SET incubation_notify = '$current_date' WHERE id = '$batch_id'";
			$queryUpdate = $this->db->query($sqlUpdate);
			
			//echo $nbody;
			$this->Email_model->send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, "",$from_email,$from_name,'Y');	
		}
		
	}
	
	
	
	//==============================================================================
	//  TRAINING ACCESS MANAGER LEVEL
	//==============================================================================
	
	  public function check_all_training_access($type = 'access')
	   {
		   $ses_fusion_id = get_user_fusion_id();
		   $result_access = false;
		   if($this->cebu_training_access())
		   {
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $this->cebu_training_access('office'); }
		   }
		   if($this->jamaica_training_access())
		   {
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $this->jamaica_training_access('office'); }
		   }
		   if($this->only_cebu_training_access())
		   {
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $this->only_cebu_training_access('office'); }
		   }
		   return $result_access;
	   }
	   
	   public function only_cebu_training_access($type = 'access')
	   {
		   $access_ids = "FCEB000029";		  
		   $office_access = "CEB";
		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   
		   $ses_fusion_id = get_user_fusion_id();
		   if(in_array($ses_fusion_id, $access_array))
		   {
			   $office_array = explode(',', $office_access);
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $office_array; }
		   }
		   return $result_access;
	   }
	
	  public function cebu_training_access($type = 'access')
	   {
		   $access_ids = "FCEB000079,FCEB000076,FCEB000078,FMAN000410";		  
		   $office_access = "CEB,MAN";
		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   
		   $ses_fusion_id = get_user_fusion_id();
		   if(in_array($ses_fusion_id, $access_array))
		   {
			   $office_array = explode(',', $office_access);
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $office_array; }
		   }
		   return $result_access;
	   }
	   
	   public function jamaica_training_access($type = 'access')
	   {
		   $access_ids = "FJAM004945,FJAM004129,FCEB000001";
		   $office_access = "JAM,ELS";
		   
		   $access_array = explode(',', $access_ids);		   
		   $result_access = false;
		   
		   $ses_fusion_id = get_user_fusion_id();
		   if(in_array($ses_fusion_id, $access_array))
		   {
			   $office_array = explode(',', $office_access);
			   if($type == 'access'){ $result_access = true; }
			   if($type == 'office'){ $result_access = $office_array; }
		   }
		   return $result_access;
	   }
	   
	   
	   
	   public function get_team_id($user){
		   $sql = "SELECT * from signin WHERE assigned_to = '$user'";
		   $query = $this->Common_model->get_query_result_array($sql);
		   $resultIDs = "0";
		   if(!empty($query)){
				$result_col = array_column($query, 'id');
				$resultIDs = implode(',', $result_col);
		   }
		   return $resultIDs;
	   }
	
		
}
?>	