<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_productivity_dashboard extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');	
	 }
	

	public function index()
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$ses_client_id=get_client_ids();
			$ses_process_id=get_process_ids(); 
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_productivity_dashboard/qa_productivity_dashboard.php";
			$data["content_js"] = "qa_dashboard_productivity/qa_productivity_dashboard_js.php";
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$process_id = $this->input->get('process_id');
			$office_id = $this->input->get('office_id');
			
			if($process_id==""){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$qSql="Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as m_name, s.office_id, o.abbr, o.office_name as location from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id Left Join office_location o On s.office_id=o.abbr where qd.process_id='$process_id' and s.status=1 group by o.abbr";
				$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
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

			
			$data['get_product'] = array();
			
			if($this->input->get('btnView')=='View')
			{
				$query = $this->db->query('SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_defect LEFT JOIN process ON process.id='.$process_id.' Where FIND_IN_SET('.$process_id.',process_id)');
				$row = $query->row();
			
				$data['get_product'] = $this->get_product($row->table_name,$office_id,$from_date,$to_date);
			}
		
			$data["process_id"] = $process_id;
			$data["office_id"] = $office_id;
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	private function get_product($table,$office_id,$from_date,$to_date){
		$current_user=get_user_id();
		$cond='';
		
		if($office_id!='') $cond .=' AND office_id="'.$office_id.'"';
		
		$qSql = 'Select (select concat(fname, " ", lname) as name from signin where signin.id=entry_by) as auditor_name, count(entry_by) as audit_no, CAST(AVG(overall_score) AS DECIMAL(10,2)) as cq_score, 
		(select SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(logout_time,login_time)))) AS timediff from logged_in_details where logged_in_details.user_id=entry_by and (date(login_time)>="'.$from_date.'" and date(login_time)<="'.$to_date.'")) as total_login_time, 
		(select count(user_id) as cnt_user from logged_in_details where logged_in_details.user_id=entry_by and (date(login_time)>="'.$from_date.'" and date(login_time)<="'.$to_date.'")) as days_present
		FROM '.$table.' LEFT JOIN signin ON signin.id=entry_by WHERE audit_type="CQ Audit" AND (date(audit_date) >= "'.$from_date.'" and date(audit_date) <= "'.$to_date.'") 
		'.$cond.' group by auditor_name';
		
		$query = $this->db->query($qSql);
        return $query->result_array();
	}
	
///////////////////// AJAX Call ////////////////////////
	public function getLocation(){
		if(check_logged_in()){
			$pid=$this->input->post('pid');
			
			$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as m_name, s.office_id, o.abbr, o.office_name from qa_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id Left Join office_location o On s.office_id=o.abbr where qd.process_id='$pid' and s.dept_id=6 and s.status=1 group by o.abbr";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}


}
?>