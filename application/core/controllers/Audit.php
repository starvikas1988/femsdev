<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		
	 }
	 
    public function index()
    {
        if(check_logged_in()){
			
			$current_user = get_user_id();
			
			$user_site_id= get_user_site_id();
			$user_role_id= get_role_id();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$is_global_access=get_global_access();
			
			$data["aside_template"] = get_aside_template();
			
			$data["content_template"] = "audit/manage.php";
			$data["error"] = ''; 
			
			$start_date = trim($this->input->post('start_date'));
			if($start_date=="") $start_date = trim($this->input->get('start_date'));
			
			$end_date = trim($this->input->post('end_date'));
			if($end_date=="") $end_date = trim($this->input->get('end_date'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$sValue = trim($this->input->post('site_id'));
			if($sValue=="") $sValue = trim($this->input->get('site_id'));
									
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$spValue = trim($this->input->post('sub_process_id'));
			if($spValue=="") $spValue = trim($this->input->get('sub_process_id'));
			
			$rValue = trim($this->input->post('role_id'));
			if($rValue=="") $rValue = trim($this->input->get('role_id'));
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			$data['sValue']=$sValue;
			$data['pValue']=$pValue;
			$data['spValue']=$spValue;
			$data['rValue']=$rValue;
			
			$condArray = array(
				"start_date" => $start_date,
				"end_date" => $end_date,
				"client_id" => $cValue,
				"site_id" => $sValue,
				"office_id" => $oValue,
				"process_id" => $pValue,
				"sub_process_id" => $spValue,
				"role_id" => $rValue,
				"user_role_id" => $user_role_id,
				"user_site_id" => $user_site_id
			); 
						
			if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
			
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
							
			}else{
				//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
			}
			
			if(get_role_dir()=="super" || $is_global_access==1){		
					$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			}else{
				$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
			}
			
			//$data['site_list'] = $this->Common_model->get_sites_for_assign();
			//$data['location_list'] = $this->Common_model->get_office_location_list();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['department_list'] = $this->Common_model->get_department_list();
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] =  array();//$this->Common_model->get_process_for_assign();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			//$data['audit_list'] = $this->Common_model->get_audit_list($condArray);
			
			if($this->input->get('showReports')=='Show') $data['all_array'] = $this->Common_model->get_audit_coaching_list($condArray);
			else $data['all_array'] =array(array(),array());
			
			/////////////////////////////////////////////////////////////////////////
									
			if($pValue!="" && $pValue!="ALL" && $pValue!="0") $data['sub_process_list'] = $this->Common_model->get_sub_process_list($pValue);
			else $data['sub_process_list']=array();
						
			$this->load->view('dashboard',$data);
			
			
		}
    }
	
	
	public function add()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$is_global_access=get_global_access();
			
            $data["aside_template"] = get_aside_template();
			
            $data["content_template"] = "audit/add.php";
            $data["error"] = ''; 
            
			$data['client_list'] = $this->Common_model->get_client_list();
			
			$data['call_type'] = $this->Common_model->get_query_result_array("select * from master_call_type where is_active=1");
			
			$data['audit_score'] = $this->Common_model->get_query_result_array("select * from master_audit_score where is_active=1");
			
			$data['compliant_score'] = $this->Common_model->get_query_result_array("select * from master_compliant_score where is_active=1");
			
            if($this->input->post('submit')=="Add")
            {
               
				//$log=get_logs();
				
				$client_id = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));				
                $sub_process_id = trim($this->input->post('sub_process_id'));
				
                $agent_fusion_id = trim($this->input->post('agent_fusion_id'));
				
				$qSql="Select id as value from signin Where fusion_id = '$agent_fusion_id'";
				$agent_id = $this->Common_model->get_single_value($qSql);
				
                $call_date = $this->input->post('call_date');
				$call_date=mmddyy2mysql($call_date);
				
                $call_type = $this->input->post('call_type'); 
				$recording_id = trim($this->input->post('recording_id'));
				$aht = trim($this->input->post('aht')); 
				$audit_date = trim($this->input->post('audit_date'));
				$audit_date=mmddyy2mysql($audit_date);
				
				$audit_by = trim($this->input->post('audit_by'));
				$auditor_name = trim($this->input->post('auditor_name'));

				$opening = trim($this->input->post('opening')); 
				$compliance = trim($this->input->post('compliance'));
				$efficiency = trim($this->input->post('efficiency')); 
				$rapport = trim($this->input->post('rapport')); 								
				$sales = trim($this->input->post('sales'));
				$etiquette = trim($this->input->post('etiquette'));
				
				$closing = trim($this->input->post('closing')); 
				$overall_score = trim($this->input->post('overall_score')); 
				$comments = trim($this->input->post('comments')); 
				$compliant_recording = trim($this->input->post('compliant_recording')); 
				
				
                if($client_id!=""  && $agent_fusion_id!="" && $recording_id!="" && $agent_id!="" && $call_date!="" && $call_type!="" && $overall_score!="")
                {
					
					$insert_date = CurrMySqlDate();
					$log=get_logs();
					
                    $_field_array = array(
                            "agent_id" => $agent_id,
							"agent_fusion_id" => $agent_fusion_id,
							"client_id" => $client_id,
                            "process_id" => $process_id,
                            "sub_process_id" => $sub_process_id,
							"call_date" => $call_date,
							"call_type" => $call_type,
							"recording_id" => $recording_id,
							"aht" => $aht,
							"audit_date" => $audit_date,
							"audit_by" => $audit_by,
							"auditor_name" => $auditor_name,
							"insert_date" => $insert_date,
							"log" => $log
                        ); 
												
                        $audit_id = data_inserter('audit_info',$_field_array);
                      						
                        if($audit_id!==false)
                        {
							
							$_field_array = array(
								"audit_id" => $audit_id,
								"agent_id" => $agent_id,
								"opening" => $opening,
								"compliance" => $compliance,
								"efficiency" => $efficiency,
								"rapport" => $rapport,
								"sales" => $sales,
								"etiquette" => $etiquette,
								"closing" => $closing,
								"overall_score" => $overall_score,
								"comments" => $comments,
								"compliant_recording" => $compliant_recording,
								"audit_date" => $audit_date,
								"audit_by" => $audit_by,
								"auditor_name" => $auditor_name,
								"insert_date" => $insert_date,
								"log" => $log
							); 
						
							$score_id = data_inserter('audit_score',$_field_array);
											
						
							//////////LOG////////
							
							$Lfull_name=get_username();
							$LOMid=get_user_omuid();
							
							$LogMSG="Audit Rec id: $recording_id ";
							log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
						   redirect(base_url()."audit/add_success?aid=$audit_id");
						   
                        }else $data['error'] = show_msgbox('Error to save Audit',true);
						
                    }
					
               }
			   
			   //$this->load->view('dashboard_ajax',$data);
			   $this->load->view('dashboard',$data);
								
            }                  
   }
  
  
  
   
public function add_success()
{
	if(check_logged_in())
    {
		
		$user_site_id= get_user_site_id();
		$role_id= get_role_id();
		$data["aside_template"] = get_aside_template();
						   
        $data["error"] = '';
		$audit_id = $this->input->get('aid');
		$audit_id=addslashes(trim($audit_id));
		$data["audit_id"] =$audit_id;
		
		$data["content_template"] = "audit/success.php";
		$this->load->view('dashboard',$data);
		
		
	}
	
} 

public function getAssignList()
{
	if(check_logged_in())
    {
		$oid = trim($this->input->post('oid'));
		
		//echo $this->Common_model->get_process_list($cid);
		echo json_encode($this->Common_model->get_assign_list($oid));
	}
}

 
 
public function getProcessList()
{
	if(check_logged_in())
    {
		$cid = trim($this->input->post('cid'));
		
		//echo $this->Common_model->get_process_list($cid);
		
		echo json_encode($this->Common_model->get_process_list($cid));
	}
}


public function getSubProcessList()
{
	if(check_logged_in())
    {
		$pid = trim($this->input->post('pid'));
		
		//echo $this->Common_model->get_process_list($cid);
		
		echo json_encode($this->Common_model->get_sub_process_list($pid));
	}
}


public function rawdata()
	{
        
		if(check_logged_in())
    {
		$user_site_id= get_user_site_id();
		$role_id= get_role_id();
		$user_office_id=get_user_office_id();
		$ses_dept_id=get_dept_id();
		$is_global_access=get_global_access();
		$current_user = get_user_id();
		
			$data["aside_template"] = get_aside_template();
			$data["content_template"] = "audit/rawdata.php";
			
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			
			$fagent_id = trim($this->input->post('fagent_id'));
			if($fagent_id=="") $fagent_id = trim($this->input->get('fagent_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$sValue = trim($this->input->post('site_id'));
			if($sValue=="") $sValue = trim($this->input->get('site_id'));
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			/*
			$spValue = trim($this->input->post('sub_process_id'));
			if($spValue=="") $spValue = trim($this->input->get('sub_process_id'));
			*/
			
			$aValue = trim($this->input->post('assigned_to'));
			if($aValue=="") $aValue = trim($this->input->get('assigned_to'));
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			$data['fagent_id']=$fagent_id;
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			$data['sValue']=$sValue;
			$data['pValue']=$pValue;
			$data['aValue']=$aValue;
			//$data['spValue']=$spValue;
				
			
			$Cond1="";
			$Cond2="";
			
			
			if($start_date!="" && $end_date!=""){
			
				$st_date = mmddyy2mysql($start_date);
				$en_date = mmddyy2mysql($end_date);
				
				$Cond1 = " audit_date >= '".$st_date."' and audit_date <= '".$en_date."' ";
				
			}
			
			
			if($cValue!="ALL" && $cValue!=""){
				if($Cond1=="") $Cond1 .= " client_id='".$cValue."'";
				else $Cond1 .= " And client_id='".$cValue."'";
				
			}
			
			if($pValue!="ALL" && $pValue!="" && $pValue!="0"){
					if($Cond1=="") $Cond1 .= " process_id='".$pValue."'";
					else $Cond1 .= " And process_id='".$pValue."'";
			}
			
			/*
			if($spValue!="ALL" && $spValue!=""){
				if($Cond1=="") $Cond1 .= " sub_process_id='".$spValue."'";
				else $Cond1 .= " And sub_process_id='".$spValue."'";
			}
			*/
			
			
			if($sValue!="ALL" && $sValue!=""){
				if($Cond2=="") $Cond2 .= " site_id='".$sValue."'";
				else $Cond2 .= " And site_id='".$sValue."'";
			}
				
			if($oValue!="ALL" && $oValue!=""){
				if($Cond2=="") $Cond2 .= " office_id='".$oValue."'";
				else $Cond2 .= " And office_id='".$oValue."'";
			}
			
			if($aValue!="ALL" && $aValue!=""){
				if($Cond2=="") $Cond2 .= " assigned_to='".$aValue."'";
				else $Cond2 .= " And assigned_to='".$aValue."'";
			}
			
			/*
			if($user_role_id>'1' && $user_role_id<'6'){
				if($Cond2=="") $Cond2 .= " site_id=".$user_site_id;	
				else $Cond2 .= " And site_id=".$user_site_id;	
			}
			*/
			
			if($Cond1!="") $Cond1 =" WHERE ".$Cond1;
			if($Cond2!="") $Cond2 =" WHERE ".$Cond2;
				
			$data['disp_list'] = $this->Common_model->get_event_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
					$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			}else{
				$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
			}
			
			//$data['site_list'] = $this->Common_model->get_sites_for_assign();
			//$data['location_list'] = $this->Common_model->get_office_location_list();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] =  array();//$this->Common_model->get_process_for_assign();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			$qSql="select * from (((Select b.*,(Select shname from department s where s.id=b.dept_id) as dept_name,(Select name from site z  where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select name from role a  where a.id=b.role_id) as role_name, (Select office_name from office_location k  where k.abbr=b.office_id) as office_name from signin b ".$Cond2 .") xx INNER JOIN (select d.*,audit_id as auditrowid, (Select shname from client m where m.id=d.client_id) as client_name, (Select name from process k where k.id=d.process_id) as process_name from audit_info d $Cond1 ) yy on xx.id=yy.agent_id) LEFT JOIN audit_score zz on yy.audit_id=zz.audit_id) Order By yy.audit_id ";
			
							
			if($this->input->get('showReports')=='Export As CSV' && $start_date!="" && $end_date!="" ){
			
				$audit_list = $this->Common_model->get_query_result_array($qSql);
												
				if(!empty($audit_list)){
					$data['audit_list']=$audit_list;
					$this->create_CSV($audit_list,$data);
				}else{
					$data['audit_list']=array();
					$this->load->view('dashboard',$data);
				}
				
			}else $this->load->view('dashboard',$data);
		}
    }
		
	public function create_CSV($rr,$data)
	{
			
		$start_date=$data["start_date"];
		$end_date=$data["end_date"];
		$st_date = mmddyy2mysql($start_date);
		$en_date = mmddyy2mysql($end_date);
				
		$filename = "./assets/reports/audit-".$st_date." - ".$en_date.".csv";
		
		$fopen = fopen($filename,"w+");
			
		$header = array("SL","Fusion ID", "Name", "Office", "Client", "Process", "Call Date", "Call type", "Recording ID","AHT","Audit Date", "Audit By", "Auditor Name" , "Opening", "Compliance" , "Efficiency", "Rapport" , "Sales", "Etiquette" , "Closing", "Overall Score" , "Comments", "Compliant Recording");
		
		$row = "";
		$cnt=1;
		
		foreach($header as $data) $row .= ''.$data.',';
		
		fwrite($fopen,rtrim($row,",")."\r\n");

		foreach($rr as $user)
		{	
						
			$row = '"'.$cnt++.'",';
			
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",'; 
			$row .= '"'.$user['office_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['call_date'].'",'; 
			$row .= '"'.$user['call_type'].'",'; 
			$row .= '"'.$user['recording_id'].'",'; 
			$row .= '"'.$user['aht'].'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			
			$row .= '"'.$user['audit_by'].'",'; 
			$row .= '"'.$user['auditor_name'].'",'; 
			$row .= '"'.$user['opening'].'",'; 
			$row .= '"'.$user['compliance'].'",'; 
			$row .= '"'.$user['efficiency'].'",'; 
			$row .= '"'.$user['rapport'].'",'; 
			
			$row .= '"'.$user['sales'].'",'; 
			$row .= '"'.$user['etiquette'].'",'; 
			$row .= '"'.$user['closing'].'",'; 
			$row .= '"'.$user['overall_score'].'",'; 
			$row .= '"'.$user['comments'].'",'; 
			$row .= '"'.$user['compliant_recording'].'"'; 
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);
		$newfile = "audit-".$st_date." - ".$en_date.".csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
}

?>