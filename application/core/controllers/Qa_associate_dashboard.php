<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_associate_dashboard extends CI_Controller {
    
     	
	function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');	
	}
	
/////////////////////////////////////////////////////////
	
	public function index()
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$ses_client_id=get_client_ids();
			$ses_process_id=get_process_ids(); 
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_associate_dashboard/qa_associate_dashboard.php";
			$data["content_js"] = "qa_dashboard_associate/qa_associate_dashboard_js.php";
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$process_id = $this->input->get('process_id');
			$office_id = $this->input->get('office_id');
			$manager_id = $this->input->get('manager_id');
			$tl_id = $this->input->get('tl_id');
			$agent_id = $this->input->get('agent_id');
			$mCond="";
			$tlCond="";
			$agentCond="";
			
			if($process_id==""){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$qSql="Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as m_name, s.office_id, o.abbr, o.office_name as location from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id Left Join office_location o On s.office_id=o.abbr where qd.process_id='$process_id' and s.status=1 group by o.abbr";
				$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
			}
			
			if(get_dept_folder()=="qa" || get_global_access()=='1' || $ses_client_id==0){
				$mCond .="";
				$tlCond .="";
				$agentCond .="";
			}else if(get_role_dir()=='manager'){
				$mCond .=" and s.id='$current_user'";
				$tlCond .=" and s.assigned_to='$current_user'";
				$agentCond .=" and (s.assigned_to='$current_user' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl'){
				$mCond .="";
				$tlCond .=" and s.id='$current_user'";
				$agentCond .=" and s.assigned_to='$current_user'";
			}
			
			if($process_id==""){
				$qSql="Select s.id, s.fusion_id, concat(s.fname, ' ', s.lname) as name from signin s where s.status=1 and s.dept_id=6 and s.role_id in (select id from role where folder='manager') $mCond";
				$data['ops_manager_list'] = $this->Common_model->get_query_result_array($qSql);
			}else{
				$qSql="Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as name, s.fusion_id, s.office_id, s.role_id from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id where qd.process_id='$process_id' and dept_id=6 and s.status=1 and role_id in (select id from role where folder='manager') $mCond";
				$data['ops_manager_list'] = $this->Common_model->get_query_result_array($qSql);
			}
			
			if($process_id=="" && $manager_id==''){
				$qSql="Select s.id, s.fusion_id, concat(s.fname, ' ', s.lname) as name from signin s where s.status=1 and dept_id=6 and s.role_id in (select id from role where folder='tl') $tlCond";
				$data['ops_tl_list'] = $this->Common_model->get_query_result_array($qSql);
			}else if($manager_id==''){
				$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as name, s.fusion_id, s.office_id, s.role_id from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id where qd.process_id='$process_id' and dept_id=6 and s.status=1 and role_id in (select id from role where folder='tl') $tlCond";
				$data['ops_tl_list'] = $this->Common_model->get_query_result_array($qSql);
			}else{
				$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as name, s.fusion_id, s.office_id, s.role_id from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id where qd.process_id='$process_id' and dept_id=6 and s.status=1 and role_id in (select id from role where folder='tl') and s.assigned_to='$manager_id' $tlCond";
				$data['ops_tl_list'] = $this->Common_model->get_query_result_array($qSql);
			}
			
			if($process_id=="" && ($manager_id=='' || $tl_id=='')){
				$qSql="Select s.id, s.fusion_id, concat(s.fname, ' ', s.lname) as name from signin s where s.status=1 and dept_id=6 and s.role_id in (select id from role where folder='agent') $agentCond";
				$data['ops_agent_list'] = $this->Common_model->get_query_result_array($qSql);
			}else if($manager_id!='' && $tl_id==''){
				$qSql="Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as name, s.fusion_id, s.office_id, s.role_id from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id where qd.process_id='$process_id' and dept_id=6 and s.status=1 and role_id in (select id from role where folder='agent') and (s.assigned_to='$manager_id' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$manager_id')) $agentCond";
				$data['ops_agent_list'] = $this->Common_model->get_query_result_array($qSql);
			}else if(($manager_id!='' && $tl_id!='') || ($manager_id=='' && $tl_id!='')){
				$qSql="Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as name, s.fusion_id, s.office_id, s.role_id from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id where qd.process_id='$process_id' and dept_id=6 and s.status=1 and role_id in (select id from role where folder='agent') and s.assigned_to='$tl_id' $agentCond";
				$data['ops_agent_list'] = $this->Common_model->get_query_result_array($qSql);
			}
			
		/////////////////////////////	
			$data['process_list'] = array();
			
			if(is_access_qa_module()==true || $ses_client_id==0){
				$qaCond='';
			}else{
				$qaCond = "WHERE p.client_id in ( $ses_client_id ) AND p.id in ( $ses_process_id )";
			}
			
			$qSql = "SELECT p.id AS pro_id,p.name AS process_name FROM qa_defect AS q
			INNER JOIN process AS p ON p.id=q.process_id $qaCond";
			$process_arr1 = $this->Common_model->get_query_result_array($qSql);

			$NotINnqSql = "( SELECT p.id FROM qa_defect AS q
			INNER JOIN process AS p ON p.id=q.process_id $qaCond )";

			$qSql = "SELECT q.process_id AS pro_id,q.table_name AS process_name from qa_defect AS q
			INNER JOIN process AS p ON p.id = FLOOR(q.process_id) $qaCond and q.process_id not in $NotINnqSql ";
			$process_arr2 = $this->Common_model->get_query_result_array($qSql);

			$marge_array=array_merge($process_arr1,$process_arr2); 
			$data['process_list'] = $marge_array;
		////////////////////////////	
			
			if($from_date=="") $from_date=CurrDate();
			else $from_date = mmddyy2mysql($from_date); 
			
			if($to_date=="") $to_date=CurrDate();
			else $to_date = mmddyy2mysql($to_date);

			
			$data['csat_score'] = array();
			$data['nps_score'] = array();
			$data['mtd_process_score'] = array();
			$data['mtd_process_count'] = array();
			$data['tenure_30'] = array();
			$data['tenure_60'] = array();
			$data['tenure_90'] = array();
			$data['tenure_91'] = array();
			//$data['top_5_error'] = array();
			
			if($this->input->get('btnView')=='View')
			{
				$query = $this->db->query('SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id='.$process_id.' Where FIND_IN_SET('.$process_id.',process_id)');
				$row = $query->row();
			
				$data['csat_score'] = $this->csat_score($row->table_name,$from_date,$to_date,$office_id,$manager_id,$tl_id,$agent_id);
				$data['nps_score'] = $this->nps_score($row->table_name,$from_date,$to_date,$office_id,$manager_id,$tl_id,$agent_id);
				$data['mtd_process_score'] = $this->mtd_process_score($row->table_name,$from_date,$to_date,$office_id,$manager_id,$tl_id,$agent_id);
				$data['mtd_process_count'] = $this->mtd_process_count($row->table_name,$from_date,$to_date,$office_id,$manager_id,$tl_id,$agent_id);
				$data['tenure_30'] = $this->tenure_30($row->table_name,$from_date,$to_date,$office_id,$manager_id,$tl_id,$agent_id);
				$data['tenure_60'] = $this->tenure_60($row->table_name,$from_date,$to_date,$office_id,$manager_id,$tl_id,$agent_id);
				$data['tenure_90'] = $this->tenure_90($row->table_name,$from_date,$to_date,$office_id,$manager_id,$tl_id,$agent_id);
				$data['tenure_91'] = $this->tenure_91($row->table_name,$from_date,$to_date,$office_id,$manager_id,$tl_id,$agent_id);
				//$data['top_5_error'] = $this->top_5_error($row->table_name,$row->params_columns,$from_date,$to_date);
			}
		
			$data["process_id"] = $process_id;
			$data["office_id"] = $office_id;
			$data["manager_id"] = $manager_id;
			$data["tl_id"] = $tl_id;
			$data["agent_id"] = $agent_id;
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}
	
///////////////////////////////////////

	private function csat_score($table,$from_date,$to_date,$off_id,$m_id,$tl_id,$agent_id){
		$current_user=get_user_id();
		$offid='';
		$mid='';
		$tlid='';
		$agentid='';
		
		if($off_id=='') $offid .= "";
		else $offid .= " and s.office_id='$off_id'";
		
		if($m_id=='') $mid .= "";
		else $mid .= " and (s.assigned_to='$m_id' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$m_id'))";
		
		if($tl_id=='') $tlid .= "";
		else $tlid .= " and s.assigned_to='$tl_id'";
		
		if($agent_id=='') $agentid .= "";
		else $agentid .= " and agent_id='$agent_id'";
		
		$voc_4_5 = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and voc in (4,5) and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");
		
		$tot_audit = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id  where audit_type in ('CQ Audit', 'BQ Audit') and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");
		
		if($tot_audit!=0){
			return $csat_percent = number_format(($voc_4_5*100)/$tot_audit, 2);
		}else{
			return $csat_percent = 0;
		}	 
	}
	
	private function nps_score($table,$from_date,$to_date,$off_id,$m_id,$tl_id,$agent_id){
		$current_user=get_user_id();
		$offid='';
		$mid='';
		$tlid='';
		$agentid='';
		
		if($off_id=='') $offid .= "";
		else $offid .= " and s.office_id='$off_id'";
		
		if($m_id=='') $mid .= "";
		else $mid .= " and (s.assigned_to='$m_id' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$m_id'))";
		
		if($tl_id=='') $tlid .= "";
		else $tlid .= " and s.assigned_to='$tl_id'";
		
		if($agent_id=='') $agentid .= "";
		else $agentid .= " and agent_id='$agent_id'";
		
		$voc_4_5 = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and voc in (4,5) and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");
		
		$voc_1_2 = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and voc in (1,2) and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");
		
		$tot_audit = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id  where audit_type in ('CQ Audit', 'BQ Audit') and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");
		
		if($tot_audit==0 || $voc_4_5==0 || $voc_1_2==0){
			return $nps_percent = 0;
		}else{
			return $nps_percent = number_format((($voc_4_5/$tot_audit)*100)/($voc_1_2/$tot_audit), 2);
		} 
	}
	
	private function mtd_process_score($table,$from_date,$to_date,$off_id,$m_id,$tl_id,$agent_id){
		$current_user=get_user_id();
		$offid='';
		$mid='';
		$tlid='';
		$agentid='';
		
		if($off_id=='') $offid .= "";
		else $offid .= " and s.office_id='$off_id'";
		
		if($m_id=='') $mid .= "";
		else $mid .= " and (s.assigned_to='$m_id' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$m_id'))";
		
		if($tl_id=='') $tlid .= "";
		else $tlid .= " and s.assigned_to='$tl_id'";
		
		if($agent_id=='') $agentid .= "";
		else $agentid .= " and agent_id='$agent_id'";
		
		return $mtd_score_percentage = $this->Common_model->get_single_value("Select CAST(AVG(overall_score) AS DECIMAL(10,2)) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");	
	}
	
	private function mtd_process_count($table,$from_date,$to_date,$off_id,$m_id,$tl_id,$agent_id){
		$current_user=get_user_id();
		$offid='';
		$mid='';
		$tlid='';
		$agentid='';
		
		if($off_id=='') $offid .= "";
		else $offid .= " and s.office_id='$off_id'";
		
		if($m_id=='') $mid .= "";
		else $mid .= " and (s.assigned_to='$m_id' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$m_id'))";
		
		if($tl_id=='') $tlid .= "";
		else $tlid .= " and s.assigned_to='$tl_id'";
		
		if($agent_id=='') $agentid .= "";
		else $agentid .= " and agent_id='$agent_id'";
		
		return $mtd_process_count = $this->Common_model->get_single_value("Select count(agent_id) as value, s.id, s.office_id, s.assigned_to from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");	
	}
	
	private function tenure_30($table,$from_date,$to_date,$off_id,$m_id,$tl_id,$agent_id){
		$current_user=get_user_id();
		$offid='';
		$mid='';
		$tlid='';
		$agentid='';
		
		if($off_id=='') $offid .= "";
		else $offid .= " and s.office_id='$off_id'";
		
		if($m_id=='') $mid .= "";
		else $mid .= " and (s.assigned_to='$m_id' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$m_id'))";
		
		if($tl_id=='') $tlid .= "";
		else $tlid .= " and s.assigned_to='$tl_id'";
		
		if($agent_id=='') $agentid .= "";
		else $agentid .= " and agent_id='$agent_id'";
		
		return $tenure_30 = $this->Common_model->get_single_value("Select CAST(AVG(overall_score) AS DECIMAL(10,2)) as value, s.id, s.office_id, s.assigned_to, s.doj from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and (DATEDIFF(CURDATE(), s.doj) >= 0 and DATEDIFF(CURDATE(), s.doj) <= 30) and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");	
	}
	
	private function tenure_60($table,$from_date,$to_date,$off_id,$m_id,$tl_id,$agent_id){
		$current_user=get_user_id();
		$offid='';
		$mid='';
		$tlid='';
		$agentid='';
		
		if($off_id=='') $offid .= "";
		else $offid .= " and s.office_id='$off_id'";
		
		if($m_id=='') $mid .= "";
		else $mid .= " and (s.assigned_to='$m_id' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$m_id'))";
		
		if($tl_id=='') $tlid .= "";
		else $tlid .= " and s.assigned_to='$tl_id'";
		
		if($agent_id=='') $agentid .= "";
		else $agentid .= " and agent_id='$agent_id'";
		
		return $tenure_60 = $this->Common_model->get_single_value("Select CAST(AVG(overall_score) AS DECIMAL(10,2)) as value, s.id, s.office_id, s.assigned_to, s.doj from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and (DATEDIFF(CURDATE(), s.doj) >= 31 and DATEDIFF(CURDATE(), s.doj) <= 60) and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");	
	}
	
	private function tenure_90($table,$from_date,$to_date,$off_id,$m_id,$tl_id,$agent_id){
		$current_user=get_user_id();
		$offid='';
		$mid='';
		$tlid='';
		$agentid='';
		
		if($off_id=='') $offid .= "";
		else $offid .= " and s.office_id='$off_id'";
		
		if($m_id=='') $mid .= "";
		else $mid .= " and (s.assigned_to='$m_id' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$m_id'))";
		
		if($tl_id=='') $tlid .= "";
		else $tlid .= " and s.assigned_to='$tl_id'";
		
		if($agent_id=='') $agentid .= "";
		else $agentid .= " and agent_id='$agent_id'";
		
		return $tenure_90 = $this->Common_model->get_single_value("Select CAST(AVG(overall_score) AS DECIMAL(10,2)) as value, s.id, s.office_id, s.assigned_to, s.doj from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and (DATEDIFF(CURDATE(), s.doj) >= 61 and DATEDIFF(CURDATE(), s.doj) <= 90) and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");	
	}
	
	private function tenure_91($table,$from_date,$to_date,$off_id,$m_id,$tl_id,$agent_id){
		$current_user=get_user_id();
		$offid='';
		$mid='';
		$tlid='';
		$agentid='';
		
		if($off_id=='') $offid .= "";
		else $offid .= " and s.office_id='$off_id'";
		
		if($m_id=='') $mid .= "";
		else $mid .= " and (s.assigned_to='$m_id' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$m_id'))";
		
		if($tl_id=='') $tlid .= "";
		else $tlid .= " and s.assigned_to='$tl_id'";
		
		if($agent_id=='') $agentid .= "";
		else $agentid .= " and agent_id='$agent_id'";
		
		return $tenure_91 = $this->Common_model->get_single_value("Select CAST(AVG(overall_score) AS DECIMAL(10,2)) as value, s.id, s.office_id, s.assigned_to, s.doj from ".$table." Left Join signin s On s.id=agent_id where audit_type in ('CQ Audit', 'BQ Audit') and (DATEDIFF(CURDATE(), s.doj) >= 91) and (date(audit_date)>='$from_date' and date(audit_date)<='$to_date') $offid $mid $tlid $agentid");	
	}
	
	
	/* private function top_5_error($table,$parameter,$from_date,$to_date){
		
		$cnd='';
		$cnd1='';
		//echo "test - ".$parameter;
		
		//$i=0;
		$defect_columns = explode(',',$parameter);
		foreach($defect_columns as $value){
			/* if(count($defect_columns) < $i){
				$cnd .= " '$value'='No' or  ";
			}else{
				$cnd .= " '$value'='No' ";
			} */
			
			//echo "parameter-".$value;
		//}
		
		
		/* $query = $this->db->query("SELECT $cnd FROM ".$table." $cnd1");
		$row = $query->result_array();
		
		echo '<pre>';
		print_r($row);
		echo '</pre>'; */
		
	//} */
	
//////////////////////////////////////
	
////////////////// AJAX List Start //////////////////////
	public function getLocation(){
		if(check_logged_in()){
			$pid=$this->input->post('pid');
			
			$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as m_name, s.office_id, o.abbr, o.office_name from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id Left Join office_location o On s.office_id=o.abbr where qd.process_id='$pid' and s.dept_id=6 and s.status=1 group by o.abbr";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	public function getManager(){
		if(check_logged_in()){
			$current_user=get_user_id();
			$pid=$this->input->post('pid');
			
			if(get_role_dir()=='manager' && get_dept_folder()!="qa"){
				$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as m_name, s.fusion_id, s.office_id, s.role_id from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id where qd.process_id='$pid' and dept_id=6 and s.status=1 and role_id in (select id from role where folder='manager') and s.id='$current_user'";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}else{
				$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as m_name, s.fusion_id, s.office_id, s.role_id from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id where qd.process_id='$pid' and dept_id=6 and s.status=1 and role_id in (select id from role where folder='manager')";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}
		}
	}
	
	public function getTl(){
		if(check_logged_in()){
			$mid=$this->input->post('mid');
			$pid=$this->input->post('pid');
			
			$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as tl_name, s.fusion_id, s.office_id, s.role_id from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id where qd.process_id='$pid' and dept_id=6 and s.status=1 and role_id in (select id from role where folder='tl') and s.assigned_to='$mid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	public function getAgentviaManager(){
		if(check_logged_in()){
			$mid=$this->input->post('mid');
			$pid=$this->input->post('pid');
			
			$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as agent_name, s.fusion_id, s.office_id, s.role_id from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id where qd.process_id='$pid' and dept_id=6 and s.status=1 and role_id in (select id from role where folder='agent') and (s.assigned_to='$mid' OR s.assigned_to in (SELECT id FROM signin where assigned_to ='$mid'))";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	
	public function getAgentviaTL(){
		if(check_logged_in()){
			$tlid=$this->input->post('tlid');
			$pid=$this->input->post('pid');
			
			$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as agent_name, s.fusion_id, s.office_id, s.role_id from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id where qd.process_id='$pid' and dept_id=6 and s.status=1 and role_id in (select id from role where folder='agent') and s.assigned_to='$tlid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
//////////////////// AJAX List End /////////////////////////
	
}
?>