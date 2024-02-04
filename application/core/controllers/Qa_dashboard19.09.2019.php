<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_dashboard extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');	
	 }
	

	public function index()
	{
		if(check_logged_in()){
			
			$client_id=get_client_ids();
			$process_id=get_process_ids();
		
			$data["aside_template"] = "qa/aside.php";
			if(get_role_dir() == 'agent'){
				$data["content_template"] = "qa_dashboard/agent_dashboard.php";
			}
			else
			{
				$data["content_template"] = "qa_dashboard/dashboard.php";
			}
			$data["content_js"] = "qa_dashboard/manage_dashboard_js.php";
			
			/* $data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign(); */
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			$qSql="Select qa_agent_url as value from process where client_id='$client_id' and id in ($process_id) limit 1";
			$agentUrl= $this->Common_model->get_single_value($qSql);
			$data['agentUrl']=$agentUrl;
			
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function get_dashboard_data()
	{
		if(check_logged_in()){
			
			$date = new DateTime(date('Y-m-d'));
			$date->modify('-7 day');
			$begin = new DateTime($date->format('Y-m-d'));
		
			$end = new DateTime(date('Y-m-d', strtotime('+1 day')));
			$current_user = get_user_id();
			
			if(get_role_dir() == 'tl')
			{
				$client_id = get_client_ids();
				$process_id = get_process_ids();
				if($client_id == 90 && ($process_id == 168 || $process_id == 171 || $process_id == 172 || $process_id == 181))
				{
					$table = 'qa_oyo_inbound_sale_feedback';
				}
				else if($client_id == 90 && $process_id == 153)
				{
					$table = 'qa_oyosig_feedback';
				}
				else if($client_id == 42)
				{
					$table = 'qa_od_feedback';
				}
				else{
					$table = '';
				}
				
				
				$query = $this->db->query("SELECT COUNT(DISTINCT entry_by) AS qa_present_count, CAST(entry_date  AS DATE) as audit_date FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user." GROUP BY  CAST(entry_date  AS DATE) ");
					
				$audit_performed_query = $this->db->query("SELECT COUNT(*) AS audit_performed, CAST(entry_date  AS DATE) as audit_date  FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user."  GROUP BY  CAST(entry_date  AS DATE) ");
				
				$qa_score = $this->db->query("SELECT AVG(overall_score) AS qa_score, CAST(entry_date  AS DATE) as audit_date  FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE overall_score != '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user."  GROUP BY  CAST(entry_date  AS DATE) ");
				$fatal_score = $this->db->query("SELECT count(overall_score) AS fatal_score, CAST(entry_date  AS DATE) as audit_date  FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE overall_score = '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user."  GROUP BY  CAST(entry_date  AS DATE) ");
				
				$date = new DateTime(date('Y-m-d'));
				$date->modify('-90 day');
				$begin = new DateTime($date->format('Y-m-d'));
				
				$query_90 = $this->db->query("SELECT COUNT(DISTINCT entry_by) AS qa_present_count_90 FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user." ");
				
				$audit_performed_query_90 = $this->db->query("SELECT COUNT(*) AS audit_performed_90 FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user." ");
				
				$qa_score_90 = $this->db->query("SELECT AVG(overall_score) AS qa_score_90 FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE overall_score != '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user." ");
				
				$fatal_score_90 = $this->db->query("SELECT count(overall_score) AS fatal_score_90 FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE overall_score = '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user." ");
				
				$date = new DateTime(date('Y-m-d'));
				$date->modify('-365 day');
				$begin = new DateTime($date->format('Y-m-d'));
				$query_365 = $this->db->query("SELECT COUNT(DISTINCT entry_by) AS qa_present_count_365 FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user." ");
				
				$audit_performed_query_365 = $this->db->query("SELECT COUNT(*) AS audit_performed_365 FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id   WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user." ");
				
				$qa_score_365 = $this->db->query("SELECT AVG(overall_score) AS qa_score_365 FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE overall_score != '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user." ");
				
				$fatal_score_365 = $this->db->query("SELECT count(overall_score) AS fatal_score_365 FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE overall_score = '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') AND signin.assigned_to=".$current_user." ");
				
				$first_day_this_month = date('Y-m-01');
				$last_day_this_month  = date('Y-m-t');
				$qa_score_month = $this->db->query("SELECT AVG(overall_score) AS qa_score_month FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE overall_score != '0%' AND  (entry_date BETWEEN '".$first_day_this_month."' AND '".$last_day_this_month."') AND signin.assigned_to=".$current_user." ");
				
				$week_qa_score = $this->db->query("SELECT AVG(overall_score) AS week_qa_score FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id  WHERE overall_score != '0%' AND YEARWEEK(entry_date)=YEARWEEK(NOW()) AND signin.assigned_to=".$current_user." ");
				$month_audit_performed_query = $this->db->query("SELECT COUNT(*) AS audit_performed_month FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id   WHERE (entry_date BETWEEN '".$first_day_this_month."' AND '".$last_day_this_month."') AND signin.assigned_to=".$current_user." ");
				
				$month_agent_covered = $this->db->query("SELECT COUNT(DISTINCT agent_id) AS month_agent_covered FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id   WHERE (entry_date BETWEEN '".$first_day_this_month."' AND '".$last_day_this_month."') AND signin.assigned_to=".$current_user." ");
				
				if($query)
				{
					$response['stat'] = true;
					$response['datas']['qa_present_count'] = $query->result_object();
					$response['datas']['audit_performed'] = $audit_performed_query->result_object();
					$response['datas']['qa_score'] = $qa_score->result_object();
					$response['datas']['fatal_score'] = $fatal_score->result_object();
					
					$response['datas']['qa_present_count_90'] = $query_90->row();
					$response['datas']['audit_performed_90'] = $audit_performed_query_90->row();
					$response['datas']['qa_score_90'] = $qa_score_90->row();
					$response['datas']['fatal_score_90'] = $fatal_score_90->row();
					
					
					$response['datas']['qa_present_count_365'] = $query_365->row();
					$response['datas']['audit_performed_365'] = $audit_performed_query_365->row();
					$response['datas']['qa_score_365'] = $qa_score_365->row();
					$response['datas']['fatal_score_365'] = $fatal_score_365->row();
					
					$response['datas']['qa_score_month'] = $qa_score_month->row();
					$response['datas']['week_qa_score'] = $week_qa_score->row();
					$response['datas']['audit_performed_month'] = $month_audit_performed_query->row();
					$response['datas']['month_agent_covered'] = $month_agent_covered->row();
				}
				else
				{
					$response['stat'] = false;
				}
			}
			else
			{
				$form_data = $this->input->post();
				
				if($form_data['client_id'] == 90 && ($form_data['process_id'] == 168 || $form_data['process_id'] == 171 || $form_data['process_id'] == 172 || $form_data['process_id'] == 181))
				{
					$table = 'qa_oyo_inbound_sale_feedback';
				}
				else if($form_data['client_id'] == 90 && $form_data['process_id'] == 153)
				{
					$table = 'qa_oyosig_feedback';
				}
				else if($form_data['client_id'] == 42)
				{
					$table = 'qa_od_feedback';
				}
				else{
					$table = '';
				}
				if($table != '')
				{
					$query = $this->db->query("SELECT COUNT(DISTINCT entry_by) AS qa_present_count, CAST(entry_date  AS DATE) as audit_date  FROM ".$table." WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') GROUP BY  CAST(entry_date  AS DATE) ");
					
					$audit_performed_query = $this->db->query("SELECT COUNT(*) AS audit_performed, CAST(entry_date  AS DATE) as audit_date  FROM ".$table." WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') GROUP BY  CAST(entry_date  AS DATE) ");
					
					$qa_score = $this->db->query("SELECT AVG(overall_score) AS qa_score, CAST(entry_date  AS DATE) as audit_date  FROM ".$table." WHERE overall_score != '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') GROUP BY  CAST(entry_date  AS DATE) ");
					$fatal_score = $this->db->query("SELECT count(overall_score) AS fatal_score, CAST(entry_date  AS DATE) as audit_date  FROM ".$table." WHERE overall_score = '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."') GROUP BY  CAST(entry_date  AS DATE) ");
					
					$date = new DateTime(date('Y-m-d'));
					$date->modify('-90 day');
					$begin = new DateTime($date->format('Y-m-d'));
					
					$query_90 = $this->db->query("SELECT COUNT(DISTINCT entry_by) AS qa_present_count_90 FROM ".$table." WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."')");
					
					$audit_performed_query_90 = $this->db->query("SELECT COUNT(*) AS audit_performed_90 FROM ".$table." WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."')");
					
					$qa_score_90 = $this->db->query("SELECT AVG(overall_score) AS qa_score_90 FROM ".$table." WHERE overall_score != '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."')");
					
					$fatal_score_90 = $this->db->query("SELECT count(overall_score) AS fatal_score_90 FROM ".$table." WHERE overall_score = '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."')");
					
					$date = new DateTime(date('Y-m-d'));
					$date->modify('-365 day');
					$begin = new DateTime($date->format('Y-m-d'));
					$query_365 = $this->db->query("SELECT COUNT(DISTINCT entry_by) AS qa_present_count_365 FROM ".$table." WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."')");
					
					$audit_performed_query_365 = $this->db->query("SELECT COUNT(*) AS audit_performed_365 FROM ".$table."  WHERE (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."')");
					
					$qa_score_365 = $this->db->query("SELECT AVG(overall_score) AS qa_score_365 FROM ".$table." WHERE overall_score != '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."')");
					
					$fatal_score_365 = $this->db->query("SELECT count(overall_score) AS fatal_score_365 FROM ".$table." WHERE overall_score = '0%' AND  (entry_date BETWEEN '".$begin->format('Y-m-d')."' AND '".$end->format('Y-m-d')."')");
					
					$first_day_this_month = date('Y-m-01');
					$last_day_this_month  = date('Y-m-t');
					$qa_score_month = $this->db->query("SELECT AVG(overall_score) AS qa_score_month FROM ".$table." WHERE overall_score != '0%' AND  (entry_date BETWEEN '".$first_day_this_month."' AND '".$last_day_this_month."')");
					
					$week_qa_score = $this->db->query("SELECT AVG(overall_score) AS week_qa_score FROM ".$table." WHERE overall_score != '0%' AND YEARWEEK(entry_date)=YEARWEEK(NOW())");
					$month_audit_performed_query = $this->db->query("SELECT COUNT(*) AS audit_performed_month FROM ".$table."  WHERE (entry_date BETWEEN '".$first_day_this_month."' AND '".$last_day_this_month."')");
					
					$month_agent_covered = $this->db->query("SELECT COUNT(DISTINCT agent_id) AS month_agent_covered FROM ".$table."  WHERE (entry_date BETWEEN '".$first_day_this_month."' AND '".$last_day_this_month."')");
					
					if($query)
					{
						$response['stat'] = true;
						$response['datas']['qa_present_count'] = $query->result_object();
						$response['datas']['audit_performed'] = $audit_performed_query->result_object();
						$response['datas']['qa_score'] = $qa_score->result_object();
						$response['datas']['fatal_score'] = $fatal_score->result_object();
						
						$response['datas']['qa_present_count_90'] = $query_90->row();
						$response['datas']['audit_performed_90'] = $audit_performed_query_90->row();
						$response['datas']['qa_score_90'] = $qa_score_90->row();
						$response['datas']['fatal_score_90'] = $fatal_score_90->row();
						
						
						$response['datas']['qa_present_count_365'] = $query_365->row();
						$response['datas']['audit_performed_365'] = $audit_performed_query_365->row();
						$response['datas']['qa_score_365'] = $qa_score_365->row();
						$response['datas']['fatal_score_365'] = $fatal_score_365->row();
						
						$response['datas']['qa_score_month'] = $qa_score_month->row();
						$response['datas']['week_qa_score'] = $week_qa_score->row();
						$response['datas']['audit_performed_month'] = $month_audit_performed_query->row();
						$response['datas']['month_agent_covered'] = $month_agent_covered->row();
					}
					else
					{
						$response['stat'] = false;
					}
				}
				else
				{
					$response['stat'] = false;
				}
			}
			
			echo json_encode($response);
		}
	}
	
	
	
}
?>