<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_qa_calibration extends CI_Controller {
    
     	
	function __construct() {
		parent::__construct();
	
		$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');	
	}
	
	public function index(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$ses_client_id=get_client_ids();
			$ses_process_id=get_process_ids(); 
			
			$ses_client_id = !empty(get_clients_client_id()) ? get_clients_client_id() : -1;
			$ses_process_id = !empty(get_clients_process_id()) ? get_clients_process_id() : -1;
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_calibration/qa_calibration_dashboard.php";
			$data["content_js"] = "qa_dashboard_productivity/qa_calibration_dashboard_js.php";
			
		//////////////////////	
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
	
		//////////////////	
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$process_id = $this->input->get('process_id');
			$auditType = $this->input->get('auditType');
			$cond="";
			
			if($from_date=="") $from_date=CurrDate();
			else $from_date = mmddyy2mysql($from_date);
			
			if($to_date=="") $to_date=CurrDate();
			else $to_date = mmddyy2mysql($to_date);

			
			$data['master_auditor'] = array();
			$data['regular_auditor'] = array();
			$data['params_columns'] = array();
			$data['parameter_score'] = array();
			
			if($this->input->get('btnView')=='View')
			{
				$query = $this->db->query('SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id='.$process_id.' Where FIND_IN_SET('.$process_id.',process_id) ');
				$row = $query->row();
			
				$data['master_auditor'] = $this->master_auditor($row->table_name,$row->process_name,$from_date,$to_date);
				$data['regular_auditor'] = $this->regular_auditor($row->table_name,$row->process_name,$from_date,$to_date);
				$data['params_columns'] = $row->params_columns;
				$data['parameter_score'] = $this->parameter_score($row->table_name,$row->params_columns,$row->process_name,$from_date,$to_date);
			}
		
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["process_id"] = $process_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
////////////////////////
	public function certificate_mockcall(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$ses_client_id=get_client_ids();
			$ses_process_id=get_process_ids(); 
			
			$ses_client_id = !empty(get_clients_client_id()) ? get_clients_client_id() : -1;
			$ses_process_id = !empty(get_clients_process_id()) ? get_clients_process_id() : -1;
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_calibration/qa_certificate_mockcall_dashboard.php";
			$data["content_js"] = "qa_dashboard_productivity/qa_calibration_dashboard_js.php";
			
		//////////////////////	
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
	
		//////////////////	
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$process_id = $this->input->get('process_id');
			$cond="";
			
			if($from_date=="") $from_date=CurrDate();
			else $from_date = mmddyy2mysql($from_date);
			
			if($to_date=="") $to_date=CurrDate();
			else $to_date = mmddyy2mysql($to_date);

			$data['certificate_mockcall_score'] = array();
			
			if($this->input->get('btnView')=='View')
			{
				$query = $this->db->query('SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id='.$process_id.' Where FIND_IN_SET('.$process_id.',process_id) ');
				$row = $query->row();
			
				$data['certificate_mockcall_score'] = $this->certificate_mockcall_score($row->table_name,$row->process_name,$from_date,$to_date);
			}
		
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["process_id"] = $process_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
///////////////////
	public function certification_audit(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$ses_client_id=get_client_ids();
			$ses_process_id=get_process_ids();

			$ses_client_id = !empty(get_clients_client_id()) ? get_clients_client_id() : -1;
			$ses_process_id = !empty(get_clients_process_id()) ? get_clients_process_id() : -1;			
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_calibration/qa_certification_audit_dashboard.php";
			$data["content_js"] = "qa_dashboard_productivity/qa_calibration_dashboard_js.php";
			
		//////////////////////	
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
	
		//////////////////	
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$process_id = $this->input->get('process_id');
			$cond="";
			
			if($from_date=="") $from_date=CurrDate();
			else $from_date = mmddyy2mysql($from_date);
			
			if($to_date=="") $to_date=CurrDate();
			else $to_date = mmddyy2mysql($to_date);

			$data['certification_audit_score'] = array();
			
			if($this->input->get('btnView')=='View')
			{
				$query = $this->db->query('SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id='.$process_id.' Where FIND_IN_SET('.$process_id.',process_id) ');
				$row = $query->row();
			
				$data['certification_audit_score'] = $this->certification_audit_score($row->table_name,$row->process_name,$from_date,$to_date);
			}
		
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["process_id"] = $process_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
/*----------------------------------------------------*/
/*----------------------------------------------------*/
/*----------------------------------------------------*/
	
	private function master_auditor($table,$process_name,$from_date,$to_date){
		$cond='';
		if($table=='qa_oyo_inbound_sale_feedback'){
			$cond .=' and process_name="'.$process_name.'"';
		}else{
			$cond='';
		}
		
		$qSql='Select entry_by, (select concat(fname, " ", lname) as name from signin s where s.id=entry_by) as entry_name, date(audit_date) as audit_date, overall_score from '.$table.' where (date(audit_date)>="'.$from_date.'" and date(audit_date)<="'.$to_date.'") and audit_type="Calibration" and auditor_type="Master" '.$cond.' group by audit_date, entry_by';
		$query = $this->db->query($qSql);
        return $query->result_array();
	}
	
	private function regular_auditor($table,$process_name,$from_date,$to_date){
		$cond='';
		if($table=='qa_oyo_inbound_sale_feedback'){
			$cond .=' and process_name="'.$process_name.'"';
		}else{
			$cond='';
		}
		
		$qSql='SELECT * FROM (Select entry_by, (select concat(fname, " ", lname) as name from signin s where s.id=entry_by) as entry_name, date(audit_date) as audit_date, overall_score from '.$table.' where (date(audit_date)>="'.$from_date.'" and date(audit_date)<="'.$to_date.'") and audit_type="Calibration" and auditor_type="Regular" '.$cond.') xx Left Join (Select date(audit_date) as auditDate, overall_score as ms_overScr from '.$table.' where (date(audit_date)>="'.$from_date.'" and date(audit_date)<="'.$to_date.'") and audit_type="Calibration" and auditor_type="Master") yy On (xx.audit_date=yy.auditDate) group by entry_by, audit_date order by audit_date';
		$query = $this->db->query($qSql);
        return $query->result_array();
	}
	
	private function parameter_score($table,$params_columns,$process_name,$from_date,$to_date){
		$cond='';
		if($table=='qa_oyo_inbound_sale_feedback'){
			$cond .=' and process_name="'.$process_name.'"';
		}else{
			$cond='';
		}
		
		$qSql='Select (select concat(fname, " ", lname) as name from signin s where s.id=entry_by) as entry_name, date(audit_date) as audit_date, auditor_type, '.$params_columns.', overall_score from '.$table.' where (date(audit_date)>="'.$from_date.'" and date(audit_date)<="'.$to_date.'") and audit_type="Calibration" '.$cond.' order by audit_date';
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	private function certificate_mockcall_score($table,$process_name,$from_date,$to_date){
		$cond='';
		if($table=='qa_oyo_inbound_sale_feedback'){
			$cond .=' and process_name="'.$process_name.'"';
		}else{
			$cond='';
		}
		
		$qSql='Select count(id) as tot_audit, agent_id, (select concat(fname, " ", lname) as name from signin s where s.id=agent_id) as agent_name, AVG(overall_score) as score from '.$table.' where (date(audit_date)>="'.$from_date.'" and date(audit_date)<="'.$to_date.'") and audit_type="Pre-Certification Mock Call" '.$cond.' group by agent_id  order by agent_name ';
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
	private function certification_audit_score($table,$process_name,$from_date,$to_date){
		$cond='';
		if($table=='qa_oyo_inbound_sale_feedback'){
			$cond .=' and process_name="'.$process_name.'"';
		}else{
			$cond='';
		}
		
		$qSql='Select count(id) as tot_audit, agent_id, (select concat(fname, " ", lname) as name from signin s where s.id=agent_id) as agent_name, AVG(overall_score) as score from '.$table.' where (date(audit_date)>="'.$from_date.'" and date(audit_date)<="'.$to_date.'") and audit_type="Certification Audit" '.$cond.' group by agent_id  order by agent_name ';
		$query = $this->db->query($qSql);
		return $query->result_array();
	}
	
}
?>