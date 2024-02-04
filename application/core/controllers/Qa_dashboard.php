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
			$current_user = get_user_id();
		
			$data["aside_template"] = "qa/aside.php";
			
			/* $qSql="SELECT office_id FROM signin where is_assign_process(id,$process_id) group by office_id";
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql); */
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			if($pValue=="") $pValue = $process_id;
			
			if($process_id=="") $process_id=0;
			
			if(get_dept_folder() == 'qa' || get_global_access() == 1 || get_role_dir() == 'manager' || get_role_dir() == 'admin' || is_access_qa_module()==true )
			{
				//$data["content_template"] = "qa_dashboard/qa_dashboard.php";
				//$data["content_js"] = "qa_dashboard/manage_dashboard_qa_js.php";
				//redirect('Qa_associate_dashboard', 'refresh');
				//redirect('qa_graph/manager_level', 'refresh');
				redirect('qa_graph', 'refresh');
				
			}else if(get_role_dir() == 'tl' && get_dept_folder() != 'qa'){
				
				//$data["content_template"] = "qa_dashboard/tl_dashboard.php";
				//$data["content_js"] = "qa_dashboard/manage_dashboard_tl_js.php";
				//redirect('Qa_associate_dashboard', 'refresh');
				//redirect('qa_graph/tl_level', 'refresh');
				redirect('qa_graph', 'refresh');
				
			}else if(get_role_dir() == 'agent'){
				
				$data["content_template"] = "qa_dashboard/agent_dashboard.php";
				$data["content_js"] = "qa_dashboard/manage_dashboard_agent_js.php";

			}else{
				
				$data["content_template"] = "qa_dashboard/agent_dashboard.php";
				$data["content_js"] = "qa_dashboard/manage_dashboard_agent_js.php";
			}
			
			/* $data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign(); */
			
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
					
			
			$qSql="Select *, TIMESTAMPDIFF(SECOND,getLocalToEst(open_date,user_id),now()) as is_open, xx.id as schedule_id,get_client_names(user_id) as client_name, get_process_names(user_id) as process_name  from (Select * From lt_exam_schedule Where user_id = '$current_user' and module_type='QA' and no_of_question>0 ) xx LEFT JOIN qa_dipcheck ON xx.module_id = qa_dipcheck.id ";
			
			//echo $qSql;
			
			//$qSql="Select *, '5201526' as is_open, xx.id as schedule_id,get_client_names(user_id) as client_name, get_process_names(user_id) as process_name  from (Select * From lt_exam_schedule Where user_id = '$current_user' and module_type='QA' and no_of_question>0 ) xx LEFT JOIN qa_dipcheck ON xx.module_id = qa_dipcheck.id ";
			
			
			///echo $qSql;
			
			$dipcheckArray = $this->Common_model->get_query_result_array($qSql);
			
			$data['dipcheckArray']=$dipcheckArray;
			
			$qSql="Select qa_agent_url as value from process where client_id='$client_id' and id in ($process_id) limit 1";
			
			//echo $qSql;
			
			$agentUrl= $this->Common_model->get_single_value($qSql);
			$data['agentUrl']=$agentUrl;
			$this->session->set_userdata('agentUrl',$agentUrl);
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			$data['client_id'] = get_client_ids();
			$data['process_id'] =get_process_ids();
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	public function get_agent_scores()
	{
		$current_user = get_user_id();
		$form_data = $this->input->post();
		/* if($form_data['client_id'] == 0)
		{ */
			$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names FROM `qa_defect` WHERE FIND_IN_SET(process_id, "'.$form_data['process_id'].'")');
									
			$row = $query->row();
		/* }
		else
		{
			$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names FROM `qa_defect` WHERE client_id IN('.$form_data['client_id'].')');
			$row = $query->row();
		} */
		$response = array();
		
		if( !isset($row->table_name)){
			
			$response['stat'] = false;
			$response['datas']['mtd_process_score'] = "";
			$response['datas']['own_mtd_score'] = "";
			$response['datas']['own_mtd_no_of_audit'] = "";
			$response['datas']['own_wtd_no_of_audit'] = "";
			$response['datas']['own_wtd_score'] = "";
			$response['datas']['own_ytd_no_of_audit'] = "";
			$response['datas']['own_ytd_score'] = "";
			$response['datas']['defects'] = "";
				
		}else{
			$mtd_process_score = $this->get_mtd_process_score($row->table_name);
			
			$own_mtd_score = $this->get_own_mtd_score($row->table_name,$current_user);
			$own_mtd_no_of_audit = $this->get_own_mtd_no_of_audit($row->table_name,$current_user);
			
			$own_wtd_no_of_audit = $this->get_own_wtd_no_of_audit($row->table_name,$current_user);
			$own_wtd_score = $this->get_own_wtd_score($row->table_name,$current_user);
			
			$own_ytd_no_of_audit = $this->get_own_ytd_no_of_audit($row->table_name,$current_user);
			$own_ytd_score = $this->get_own_ytd_score($row->table_name,$current_user);
			
			$defects = $this->get_own_defected($form_data['process_id'],$form_data['client_id'],$form_data['current_user'],false,true);
			
			if($mtd_process_score['stat'] == true)
			{
				$response['stat'] = true;
				$response['datas']['mtd_process_score'] = $mtd_process_score['datas'];
				$response['datas']['own_mtd_score'] = $own_mtd_score['datas'];
				$response['datas']['own_mtd_no_of_audit'] = $own_mtd_no_of_audit['datas'];
				$response['datas']['own_wtd_no_of_audit'] = $own_wtd_no_of_audit['datas'];
				$response['datas']['own_wtd_score'] = $own_wtd_score['datas'];
				$response['datas']['own_ytd_no_of_audit'] = $own_ytd_no_of_audit['datas'];
				$response['datas']['own_ytd_score'] = $own_ytd_score['datas'];
				$response['datas']['defects'] = $defects['datas'];
			}
		}
		echo json_encode($response);
	}
////////VOC////////
	private function get_csat_process_score($table,$process_name,$location)
	{
		
	if($table=="qa_oyo_inbound_sale_feedback"){
		$csat_4_5 = $this->Common_model->get_single_value('Select count(id) as value from '.$table.' where voc in (4,5) and process_name="'.$process_name.'" ');
		$tot_audit = $this->Common_model->get_single_value('Select count(id) as value from '.$table.' where process_name="'.$process_name.'" ');
	}else{
		$csat_4_5 = $this->Common_model->get_single_value('Select count(agent_id) as value, signin.office_id from '.$table.' LEFT JOIN signin ON signin.id=agent_id where office_id="'.$location.'" AND voc in (4,5) ');
		$tot_audit = $this->Common_model->get_single_value('Select count(agent_id) as value, signin.office_id from '.$table.' LEFT JOIN signin ON signin.id=agent_id where office_id="'.$location.'" ');
	}	
		if($tot_audit > 0){
			$csat_scr = ($csat_4_5 / $tot_audit) * 100;
		}else{
			$csat_scr=0;
		}
		
		if($csat_scr > 0){
			$response['datas'] = $csat_scr;
		}else{
			$response['datas'] = 0;
		}
		return $response;
	}
	private function get_nps_process_score($table,$process_name,$location)
	{
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$csat_4_5 = $this->Common_model->get_single_value('Select count(id) as value from '.$table.' where voc in (4,5) and process_name="'.$process_name.'" ');
			$csat_1_2 = $this->Common_model->get_single_value('Select count(id) as value from '.$table.' where voc in (1,2) and process_name="'.$process_name.'" ');
			$tot_audit = $this->Common_model->get_single_value('Select count(id) as value from '.$table.' where process_name="'.$process_name.'" ');
		}else{	
			$csat_4_5 = $this->Common_model->get_single_value('Select count(agent_id) as value, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND voc in (4,5) ');
			$csat_1_2 = $this->Common_model->get_single_value('Select count(agent_id) as value, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND voc in (1,2) ');
			$tot_audit = $this->Common_model->get_single_value('Select count(agent_id) as value, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" ');
		}
		
		if($tot_audit>0){	
			$nps_scr = (($csat_4_5 - $csat_1_2) / $tot_audit) * 100;
		}else{
			$nps_scr=0;
		}
		
		if($nps_scr > 0){
			$response['datas'] = $nps_scr;
		}else{
			$response['datas'] = 0;
		}
		return $response;
	}
//////////////////	
	private function get_mtd_process_score($table,$process_name,$location)
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		//$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' WHERE YEAR(entry_date) = "'.$year.'" AND MONTH(entry_date) = "'.$month.'" GROUP BY YEAR(entry_date), MONTH(entry_date)');
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" and process_name="'.$process_name.'" GROUP BY YEAR(audit_date), MONTH(audit_date)');
		}else{	
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" GROUP BY YEAR(audit_date), MONTH(audit_date)');
		}
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	private function get_own_mtd_score($table,$process_name,$current_user)
	{
		
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		//$query = $this->db->query('SELECT AVG(overall_score) AS own_avg_process_score FROM '.$table.' WHERE YEAR(entry_date) = "'.$year.'" AND MONTH(entry_date) = "'.$month.'" AND agent_id='.$current_user.' GROUP BY YEAR(entry_date), MONTH(entry_date)');
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$query = $this->db->query('SELECT AVG(overall_score) AS own_avg_process_score FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND agent_id='.$current_user.' and process_name="'.$process_name.'" GROUP BY YEAR(audit_date), MONTH(audit_date)');
		}else{	
			$query = $this->db->query('SELECT AVG(overall_score) AS own_avg_process_score FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND agent_id='.$current_user.' GROUP BY YEAR(audit_date), MONTH(audit_date)');
		}
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->own_avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_own_mtd_no_of_audit($table,$process_name,$current_user)
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		
		//$query = $this->db->query('SELECT COUNT(*) AS own_mtd_no_of_audit FROM '.$table.' WHERE YEAR(entry_date) = "'.$year.'" AND MONTH(entry_date) = "'.$month.'" AND agent_id='.$current_user.' GROUP BY YEAR(entry_date), MONTH(entry_date)');
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$query = $this->db->query('SELECT COUNT(*) AS own_mtd_no_of_audit FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND agent_id='.$current_user.' and process_name="'.$process_name.'" GROUP BY YEAR(audit_date), MONTH(audit_date)');
		}else{
			$query = $this->db->query('SELECT COUNT(*) AS own_mtd_no_of_audit FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND agent_id='.$current_user.' GROUP BY YEAR(audit_date), MONTH(audit_date)');
		}
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->own_mtd_no_of_audit;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_own_wtd_no_of_audit($table,$process_name,$current_user)
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		//$query = $this->db->query('SELECT COUNT(*) AS own_wtd_no_of_audit FROM '.$table.' WHERE YEAR(entry_date) = "'.$year.'" AND MONTH(entry_date) = "'.$month.'" AND agent_id='.$current_user.' AND WEEK(entry_date,1)="'.$week.'"');
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$query = $this->db->query('SELECT COUNT(*) AS own_wtd_no_of_audit FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND agent_id='.$current_user.' AND WEEK(audit_date,1)="'.$week.'" and process_name="'.$process_name.'"');
		}else{
			$query = $this->db->query('SELECT COUNT(*) AS own_wtd_no_of_audit FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND agent_id='.$current_user.' AND WEEK(audit_date,1)="'.$week.'"');
		}
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->own_wtd_no_of_audit;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_own_wtd_score($table,$process_name,$current_user)
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		//$query = $this->db->query('SELECT AVG(overall_score) AS own_avg_process_score FROM '.$table.' WHERE YEAR(entry_date) = "'.$year.'" AND MONTH(entry_date) = "'.$month.'" AND agent_id='.$current_user.' AND WEEK(entry_date,1)="'.$week.'"');
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$query = $this->db->query('SELECT AVG(overall_score) AS own_avg_process_score FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND agent_id='.$current_user.' AND WEEK(audit_date,1)="'.$week.'" and process_name="'.$process_name.'" ');
		}else{
			$query = $this->db->query('SELECT AVG(overall_score) AS own_avg_process_score FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND agent_id='.$current_user.' AND WEEK(audit_date,1)="'.$week.'"');
		}
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->own_avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_own_ytd_no_of_audit($table,$process_name,$current_user)
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		//$query = $this->db->query('SELECT COUNT(*) AS own_ytd_no_of_audit FROM '.$table.' WHERE YEAR(entry_date) = "'.$year.'" AND agent_id='.$current_user.'');
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$query = $this->db->query('SELECT COUNT(*) AS own_ytd_no_of_audit FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND agent_id='.$current_user.' and process_name="'.$process_name.'" ');
		}else{	
			$query = $this->db->query('SELECT COUNT(*) AS own_ytd_no_of_audit FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND agent_id='.$current_user.'');
		}
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->own_ytd_no_of_audit;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_own_ytd_score($table,$process_name,$current_user)
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$query = $this->db->query('SELECT AVG(overall_score) AS own_avg_process_score FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND agent_id='.$current_user.' and process_name="'.$process_name.'" ');
		}else{
			$query = $this->db->query('SELECT AVG(overall_score) AS own_avg_process_score FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND agent_id='.$current_user.'');
		}
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->own_avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_own_defected($process_id,$client_id,$current_user,$location,$only_process_defect=false,$all_process=false)
	{
		/* if($client_id == 0)
		{ */
			//$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names FROM `qa_defect` WHERE FIND_IN_SET('.$process_id.',process_id)');
			$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names,process.name as process_name FROM `qa_defect` LEFT JOIN process ON process.id='.$process_id.' WHERE FIND_IN_SET(process_id,"'.$process_id.'")');
			$row = $query->row();
		/* }
		else
		{
			$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names FROM `qa_defect` WHERE client_id IN('.$client_id.')');
			$row = $query->row();
		} */
		$response = array();
		if($query)
		{
			$row = $query->row();
			$defect_column_names = explode(',',$row->defect_column_names);
			$defect_columns = explode(',',$row->defect_columns);
			foreach($defect_columns as $key=>$value)
			{
				$response['datas']['defect_column_names'][$value] = $defect_column_names[$key];
			}
			if($only_process_defect == false)
			{
				$defect_query = $this->db->query('SELECT '.$row->defect_columns.' FROM '.$row->table_name.' WHERE agent_id='.$current_user.'');
				$defect_rows = $defect_query->result_object();
				$defect_count = array();
				foreach($defect_rows as $key=>$value)
				{
					foreach($value as $k=>$v)
					{
						if(!isset($defect_count[$k]))
						{
							$defect_count[$k] = 0;
						}
						if($v == 0)
						{
							$defect_count[$k] = $defect_count[$k] + 1;
						}
					}
				}
				arsort($defect_count);
				$output = array_slice($defect_count, 0, 5, true);
				$response['stat'] = true;
				$response['datas']['own_defects'] = $output;
				$response['datas']['own_defects_count'] = $defect_query->num_rows();
			}
			if($all_process == false)
			{
				$defect_query = $this->db->query('SELECT '.$row->defect_columns.' FROM '.$row->table_name.' LEFT JOIN signin ON signin.id='.$row->table_name.'.agent_id WHERE signin.assigned_to='.$current_user.'');
			}
			else
			{
				if($row->table_name=="qa_oyo_inbound_sale_feedback"){
					$defect_query = $this->db->query('SELECT '.$row->defect_columns.' FROM '.$row->table_name.' where process_name="'.$row->process_name.'" ');
				}else{	
					$defect_query = $this->db->query('SELECT '.$row->defect_columns.', signin.office_id FROM '.$row->table_name.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" ');
				}
			}
			
			$defect_rows = $defect_query->result_object();
			$defect_count_all = array();
			$defect_count_all_accuracy = array();
			foreach($defect_rows as $key=>$value)
			{
				foreach($value as $k=>$v)
				{
					if(!isset($defect_count_all[$k]))
					{
						$defect_count_all[$k] = 0;
					}
					if(!isset($defect_count_all_accuracy[$k]))
					{
						$defect_count_all_accuracy[$k] = 0;
					}
					if($v == 0)
					{
						$defect_count_all[$k] = $defect_count_all[$k] + 1;
					}
					if($v != 0)
					{
						$defect_count_all_accuracy[$k] = $defect_count_all_accuracy[$k] + 1;
					}
				}
			}
			arsort($defect_count_all);
			$output = array_slice($defect_count_all, 0, 5, true);
			$response['datas']['defects_all'] = $output;
			$response['datas']['defects_all_count'] = $defect_query->num_rows();
			
			arsort($defect_count_all_accuracy);
			$output = array_slice($defect_count_all_accuracy, 0, 5, true);
			$response['datas']['defects_all_accuracy'] = $output;
			$response['datas']['defects_all_count_accuracy'] = $defect_query->num_rows();
		}
		else
		{
			$response['stat'] = false;
		}
		return $response;
	}
	
	
	public function get_tl_scores()
	{
		$form_data = $this->input->post();
		/* if($form_data['client_id'] == 0)
		{ */
			//$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names FROM `qa_defect` WHERE FIND_IN_SET('.$form_data['process_id'].',process_id)');
			$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names,process.name as process_name FROM `qa_defect` LEFT JOIN process ON process.id='.$form_data['process_id'].' WHERE FIND_IN_SET(process_id,"'.$form_data['process_id'].'")');
			$row = $query->row();
		/* }
		else
		{
			$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names FROM `qa_defect` WHERE client_id IN('.$form_data['client_id'].')');
			$row = $query->row();
		} */
		
		$mtd_process_score = $this->get_mtd_process_score($row->table_name,$row->process_name);
		$mtd_no_of_audit = $this->get_mtd_no_of_audit($row->table_name,$row->process_name);
		$process_mtd_no_of_audit = $this->get_process_mtd_no_of_audit($row->table_name,$row->process_name);
		$mtd_score = $this->get_mtd_score($row->table_name,$row->process_name);
		
		$wtd_no_of_audit = $this->get_wtd_no_of_audit($row->table_name,$row->process_name);
		$wtd_score = $this->get_wtd_score($row->table_name,$row->process_name);

		$wtd_score_30 = $this->get_wtd_score_30($row->table_name,$row->process_name,$form_data['current_user']);
		$mtd_score_30 = $this->get_mtd_score_30($row->table_name,$row->process_name,$form_data['current_user']);
		
		$wtd_score_60 = $this->get_wtd_score_60($row->table_name,$row->process_name,$form_data['current_user']);
		$mtd_score_60 = $this->get_mtd_score_60($row->table_name,$row->process_name,$form_data['current_user']);
		
		$wtd_score_90 = $this->get_wtd_score_90($row->table_name,$row->process_name,$form_data['current_user']);
		$mtd_score_90 = $this->get_mtd_score_90($row->table_name,$row->process_name,$form_data['current_user']);
		
		$wtd_score_above = $this->get_wtd_score_above($row->table_name,$row->process_name,$form_data['current_user']);
		$mtd_score_above = $this->get_mtd_score_above($row->table_name,$row->process_name,$form_data['current_user']);
		
		$defects = $this->get_own_defected($form_data['process_id'],$form_data['client_id'],$form_data['current_user'],true);
		
		
		$response = array();
		if($mtd_process_score['stat'] == true)
		{
			$response['stat'] = true;
			$response['datas']['mtd_process_score'] = $mtd_process_score['datas'];
			$response['datas']['mtd_no_of_audit'] = $mtd_no_of_audit['datas'];
			$response['datas']['process_mtd_no_of_audit'] = $process_mtd_no_of_audit['datas'];
			$response['datas']['mtd_score'] = $mtd_score['datas'];
			$response['datas']['wtd_no_of_audit'] = $wtd_no_of_audit['datas'];
			$response['datas']['wtd_score'] = $wtd_score['datas'];
			
			$response['datas']['wtd_score_30'] = $wtd_score_30['datas'];
			$response['datas']['mtd_score_30'] = $mtd_score_30['datas'];
			
			$response['datas']['wtd_score_60'] = $wtd_score_60['datas'];
			$response['datas']['mtd_score_60'] = $mtd_score_60['datas'];
			
			$response['datas']['wtd_score_90'] = $wtd_score_90['datas'];
			$response['datas']['mtd_score_90'] = $mtd_score_90['datas'];
			
			$response['datas']['wtd_score_above'] = $wtd_score_above['datas'];
			$response['datas']['mtd_score_above'] = $mtd_score_above['datas'];
			
			$query = $this->db->query('SELECT id  FROM signin WHERE assigned_to='.$form_data['current_user'].'');
			$rows = $query->result_object();
			
			foreach($rows as $key=>$current_user)
			{
				$response['datas']['agent_record'][$current_user->id]['agent_name'] = $this->get_agent_name($current_user->id);
				
				$response['datas']['agent_record'][$current_user->id]['own_mtd_score'] = $this->get_own_mtd_score($row->table_name,$current_user->id);
				$response['datas']['agent_record'][$current_user->id]['own_mtd_no_of_audit'] = $this->get_own_mtd_no_of_audit($row->table_name,$current_user->id);
				
				$response['datas']['agent_record'][$current_user->id]['own_wtd_no_of_audit'] = $this->get_own_wtd_no_of_audit($row->table_name,$current_user->id);
				$response['datas']['agent_record'][$current_user->id]['own_wtd_score'] = $this->get_own_wtd_score($row->table_name,$current_user->id);
				
				$response['datas']['agent_record'][$current_user->id]['own_ytd_no_of_audit'] = $this->get_own_ytd_no_of_audit($row->table_name,$current_user->id);
				$response['datas']['agent_record'][$current_user->id]['own_ytd_score'] = $this->get_own_ytd_score($row->table_name,$current_user->id);
				
				
			}
			$response['datas']['defects'] = $defects['datas'];
		}
		echo json_encode($response);
	}
	
	private function get_mtd_no_of_audit($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT COUNT(*) AS mtd_no_of_audit FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id  WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT COUNT(*) AS mtd_no_of_audit FROM '.$table.'  WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" and process_name="'.$process_name.'" ');
			}else{
				$query = $this->db->query('SELECT COUNT(*) AS mtd_no_of_audit, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'"');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->mtd_no_of_audit;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_mtd_score($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id  WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.'  WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" and process_name="'.$process_name.'" ');
			}else{	
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'"');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0 )
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_wtd_no_of_audit($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT COUNT(*) AS wtd_no_of_audit FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id  WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND WEEK(audit_date,1)="'.$week.'" AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT COUNT(*) AS wtd_no_of_audit FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND WEEK(audit_date,1)="'.$week.'" and process_name="'.$process_name.'" ');
			}else{	
				$query = $this->db->query('SELECT COUNT(*) AS wtd_no_of_audit, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND WEEK(audit_date,1)="'.$week.'"');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->wtd_no_of_audit;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_wtd_score($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id  WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND WEEK(audit_date,1)="'.$week.'" AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.'  WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND WEEK(audit_date,1)="'.$week.'" and process_name="'.$process_name.'" ');
			}else{	
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND WEEK(audit_date,1)="'.$week.'"');
			}	
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	
	private function get_wtd_score_30($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 0 AND DATEDIFF(CURDATE(), signin.doj) <= 30)  AND WEEK(audit_date,1)="'.$week.'" AND signin.assigned_to='.$current_user.' AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 0 AND DATEDIFF(CURDATE(), signin.doj) <= 30)  AND WEEK(audit_date,1)="'.$week.'" AND signin.assigned_to='.$current_user.' and process_name="'.$process_name.'"');
			}else{
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE  office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 0 AND DATEDIFF(CURDATE(), signin.doj) <= 30)  AND WEEK(audit_date,1)="'.$week.'" AND signin.assigned_to='.$current_user.'');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0 )
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_mtd_score_30($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 0 AND DATEDIFF(CURDATE(), signin.doj) <= 30) AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 0 AND DATEDIFF(CURDATE(), signin.doj) <= 30) and process_name="'.$process_name.'"');
			}else{
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 0 AND DATEDIFF(CURDATE(), signin.doj) <= 30)');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_wtd_score_60($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 31 AND DATEDIFF(CURDATE(), signin.doj) <= 60)  AND WEEK(audit_date,1)="'.$week.'" AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 31 AND DATEDIFF(CURDATE(), signin.doj) <= 60)  AND WEEK(audit_date,1)="'.$week.'" and process_name="'.$process_name.'"');
			}else{
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 31 AND DATEDIFF(CURDATE(), signin.doj) <= 60)  AND WEEK(audit_date,1)="'.$week.'"');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_mtd_score_60($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 31 AND DATEDIFF(CURDATE(), signin.doj) <= 60) AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 31 AND DATEDIFF(CURDATE(), signin.doj) <= 60) and process_name="'.$process_name.'"');
			}else{
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 31 AND DATEDIFF(CURDATE(), signin.doj) <= 60)');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_wtd_score_90($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 61 AND DATEDIFF(CURDATE(), signin.doj) <= 90)  AND WEEK(audit_date,1)="'.$week.'" AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 61 AND DATEDIFF(CURDATE(), signin.doj) <= 90)  AND WEEK(audit_date,1)="'.$week.'" and process_name="'.$process_name.'"');
			}else{
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 61 AND DATEDIFF(CURDATE(), signin.doj) <= 90)  AND WEEK(audit_date,1)="'.$week.'"');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_mtd_score_90($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 61 AND DATEDIFF(CURDATE(), signin.doj) <= 90) AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 61 AND DATEDIFF(CURDATE(), signin.doj) <= 90) and process_name="'.$process_name.'"');
			}else{
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 61 AND DATEDIFF(CURDATE(), signin.doj) <= 90)');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_wtd_score_above($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 91)  AND WEEK(audit_date,1)="'.$week.'" AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 91)  AND WEEK(audit_date,1)="'.$week.'" and process_name="'.$process_name.'"');
			}else{
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 91)  AND WEEK(audit_date,1)="'.$week.'"');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_mtd_score_above($table,$process_name,$location,$all_process=false)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		if($all_process == false)
		{
			$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 91) AND signin.assigned_to='.$current_user.'');
		}
		else
		{
			if($table=="qa_oyo_inbound_sale_feedback"){
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 91) and process_name="'.$process_name.'"');
			}else{	
				$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND (DATEDIFF(CURDATE(), signin.doj) >= 91)');
			}
		}
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->avg_process_score;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	
	private function get_agent_name($user_id)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		$query = $this->db->query('SELECT CONCAT(fname," ",lname) as agent_name FROM signin WHERE id='.$user_id.'');
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			$response['datas'] = $row->agent_name;
		}
		else
		{
			$response['stat'] = false;
		}
		return $response;
	}
	
	private function get_process_mtd_no_of_audit($table,$process_name,$location)
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		
		if($table=="qa_oyo_inbound_sale_feedback"){
			$qSql='SELECT COUNT(*) AS own_mtd_no_of_audit FROM '.$table.' WHERE YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" and process_name="'.$process_name.'"';
		}else{	
			$qSql='SELECT COUNT(*) AS own_mtd_no_of_audit, signin.office_id FROM '.$table.' LEFT JOIN signin ON signin.id=agent_id WHERE office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'"';
		}
		//echo $qSql;
		
		$query = $this->db->query($qSql);
		
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->own_mtd_no_of_audit;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		if($response['datas'] == null)
		{
			$response['datas'] = 0;
		}
		return $response;
	}
	private function get_agent_fd_acpt($table)
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		//$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' WHERE YEAR(entry_date) = "'.$year.'" AND MONTH(entry_date) = "'.$month.'" GROUP BY YEAR(entry_date), MONTH(entry_date)');
		
		$query = $this->db->query('select COUNT(DISTINCT(inbound_sale_feedback_id)) agentfdacpt from qa_oyo_inbound_sale_agent_review');
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->agentfdacpt;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		return $response;
	}
	private function get_agent_fd_pnd($table)
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		//$query = $this->db->query('SELECT AVG(overall_score) AS avg_process_score FROM '.$table.' WHERE YEAR(entry_date) = "'.$year.'" AND MONTH(entry_date) = "'.$month.'" GROUP BY YEAR(entry_date), MONTH(entry_date)');
		
		$query = $this->db->query('Select count(id) as agentfdpnd FROM qa_oyo_inbound_sale_feedback where id not in (select inbound_sale_feedback_id from qa_oyo_inbound_sale_agent_review group by inbound_sale_feedback_id)');
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = $row->agentfdpnd;
			}
			else
			{
				$response['datas'] = 0;
			}
		}
		return $response;
	}

	private function get_verso_ob($table)
	{
		$current_user = get_user_id();
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$verso_ob = $this->Common_model->get_single_value('SELECT count(id) as value FROM '.$table.' where YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'"');
		
		$verso_ob_cnt1 = $this->Common_model->get_single_value('SELECT count(id) as value FROM qa_verso_ob_fca_feedback where call_status="Approved" and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'"');
		$verso_ob_cnt2 = $this->Common_model->get_single_value('SELECT count(id) as value FROM qa_verso_ob_fca_feedback where call_status="Approved with Error" and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'"');
		$verso_ob_cnt3 = $this->Common_model->get_single_value('SELECT count(id) as value FROM qa_verso_ob_fca_feedback where call_status="Approved with FYI" and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'"');
		$verso_ob_cnt4 = $this->Common_model->get_single_value('SELECT count(id) as value FROM qa_verso_ob_fca_feedback where call_status="Fallout" and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'"');
		
		if($verso_ob > 0){
			$verso_ob_contrib1 = ($verso_ob_cnt1 / $verso_ob) * 100;
			$verso_ob_contrib2 = ($verso_ob_cnt2 / $verso_ob) * 100;
			$verso_ob_contrib3 = ($verso_ob_cnt3 / $verso_ob) * 100;
			$verso_ob_contrib4 = ($verso_ob_cnt4 / $verso_ob) * 100;
		}else{
			$verso_ob_contrib1 = 0;
			$verso_ob_contrib2 = 0;
			$verso_ob_contrib3 = 0;
			$verso_ob_contrib4 = 0;
		}
		

		$response['datas1'] = $verso_ob_cnt1;
		$response['datas2'] = $verso_ob_cnt2;
		$response['datas3'] = $verso_ob_cnt3;
		$response['datas4'] = $verso_ob_cnt4;
		
		$response['datas5'] = $verso_ob_contrib1;
		$response['datas6'] = $verso_ob_contrib2;
		$response['datas7'] = $verso_ob_contrib3;
		$response['datas8'] = $verso_ob_contrib4;
		
		return $response;
	}
	
	
/*-----OYO LIFE--------*/
	private function oyo_life_ib()
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$cq_auditcount = $this->Common_model->get_single_value('Select count(id) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" ');
		$cq_fatal = $this->Common_model->get_single_value('Select count(id) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and overall_score=0 and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" ');
		$cq_per = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" ');
		
		if($cq_auditcount > 0){
			$fatal_per = ($cq_fatal / $cq_auditcount) * 100;
		}else{
			$fatal_per = 0;
		}
		
		if($cq_auditcount > 0){
			$response['datas1'] = $cq_auditcount;
			$response['datas2'] = $cq_fatal;
			$response['datas3'] = $cq_per;
			$response['datas4'] = $fatal_per;
		}else{
			$response['datas1'] = 0;
			$response['datas2'] = 0;
			$response['datas3'] = 0;
			$response['datas4'] = 0;
		}
		return $response;
	}
	
	private function oyo_life_ob()
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$ob_cq_auditcount = $this->Common_model->get_single_value('Select count(id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" ');
		$ob_cq_fatal = $this->Common_model->get_single_value('Select count(id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and overall_score=0 and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" ');
		$ob_cq_per = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" ');
		
		if($ob_cq_auditcount > 0){
			$ob_fatal_per = ($ob_cq_fatal / $ob_cq_auditcount) * 100;
		}else{
			$ob_fatal_per = 0;
		}
		
		
		if($ob_cq_auditcount > 0){
			$response['datas1'] = $ob_cq_auditcount;
			$response['datas2'] = $ob_cq_fatal;
			$response['datas3'] = $ob_cq_per;
			$response['datas4'] = $ob_fatal_per;
		}else{
			$response['datas1'] = 0;
			$response['datas2'] = 0;
			$response['datas3'] = 0;
			$response['datas4'] = 0;
		}
		return $response;
	}
	
	private function oyo_life_fu()
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$fu_cq_auditcount = $this->Common_model->get_single_value('Select count(id) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" ');
		$fu_cq_fatal = $this->Common_model->get_single_value('Select count(id) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" and overall_score=0 and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" ');
		$fu_cq_per = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" and YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" ');
		
		if($fu_cq_auditcount > 0){
			$fu_fatal_per = ($fu_cq_fatal / $fu_cq_auditcount) * 100;
		}else{
			$fu_fatal_per = 0;
		}
		
		
		if($fu_cq_auditcount > 0){
			$response['datas1'] = $fu_cq_auditcount;
			$response['datas2'] = $fu_cq_fatal;
			$response['datas3'] = $fu_cq_per;
			$response['datas4'] = $fu_fatal_per;
		}else{
			$response['datas1'] = 0;
			$response['datas2'] = 0;
			$response['datas3'] = 0;
			$response['datas4'] = 0;
		}
		return $response;
	}

	private function oyo_life_ib_tenure(){
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$cond ="Select count(agent_id) as value from qa_oyolife_ib_ob_feedback left join training_details on training_details.user_id=qa_oyolife_ib_ob_feedback.agent_id left join training_batch on training_details.trn_batch_id=training_batch.id";
		
		$ib_audit_30 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=0 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=30)');
		$ib_fatal_30 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=0 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=30)');
		$cq_30 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=0 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=30)');
		
		if($ib_audit_30 > 0){
			$ib_cq_30 = (($cq_30 / $ib_audit_30) * 100);
			$ib_fatalper_30 = (($ib_fatal_30 / $ib_audit_30) * 100);
		}else{
			$ib_cq_30 = 0;
			$ib_fatalper_30 = 0;
		}
	/////////////////	
		$ib_audit_60 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=31 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=60)');
		$ib_fatal_60 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=31 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=60)');
		$cq_60 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=31 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=60)');
		
		if($ib_audit_60 > 0){
			$ib_cq_60 = (($cq_60 / $ib_audit_60) * 100);
			$ib_fatalper_60 = (($ib_fatal_60 / $ib_audit_60) * 100);
		}else{
			$ib_cq_60 = 0;
			$ib_fatalper_60 = 0;
		}
	////////////////
		$ib_audit_90 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=61 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=90)');
		$ib_fatal_90 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=61 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=90)');
		$cq_90 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=61 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=90)');
		
		if($ib_audit_90 > 0){
			$ib_cq_90 = (($cq_90 / $ib_audit_90) * 100);
			$ib_fatalper_90 = (($ib_fatal_90 / $ib_audit_90) * 100);
		}else{
			$ib_cq_90 = 0;
			$ib_fatalper_90 = 0;
		}
	////////////
		$ib_audit_91 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>90 or DATEDIFF(CURDATE(), training_batch.trn_handover_date) is null)');
		$ib_fatal_91 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>90 or DATEDIFF(CURDATE(), training_batch.trn_handover_date) is null)');
		$cq_91 = $this->Common_model->get_single_value(' '.$cond.' where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>90 or DATEDIFF(CURDATE(), training_batch.trn_handover_date) is null)');
		
		if($ib_audit_91 > 0){
			$ib_cq_91 = (($cq_91 / $ib_audit_91) * 100);
			$ib_fatalper_91 = (($ib_fatal_91 / $ib_audit_91) * 100);
		}else{
			$ib_cq_91 = 0;
			$ib_fatalper_91 = 0;
		}
	
		$response['datas1'] = $ib_audit_30;
		$response['datas2'] = $ib_fatal_30;
		$response['datas3'] = $ib_cq_30;
		$response['datas4'] = $ib_fatalper_30;
		$response['datas5'] = $ib_audit_60;
		$response['datas6'] = $ib_fatal_60;
		$response['datas7'] = $ib_cq_60;
		$response['datas8'] = $ib_fatalper_60;
		$response['datas9'] = $ib_audit_90;
		$response['datas10'] = $ib_fatal_90;
		$response['datas11'] = $ib_cq_90;
		$response['datas12'] = $ib_fatalper_90;
		$response['datas13'] = $ib_audit_91;
		$response['datas14'] = $ib_fatal_91;
		$response['datas15'] = $ib_cq_91;
		$response['datas16'] = $ib_fatalper_91;
		
		return $response;
	}
	
	private function oyo_life_ob_tenure(){
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$cond ="Select count(agent_id) as value from qa_oyolife_ib_ob_feedback left join training_details on training_details.user_id=qa_oyolife_ib_ob_feedback.agent_id left join training_batch on training_details.trn_batch_id=training_batch.id";
		
		
		$ob_audit_30 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=0 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=30)');
		$ob_fatal_30 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=0 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=30)');
		$obcq_30 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=0 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=30)');
		
		if($ob_audit_30 > 0){
			$ob_cq_30 = (($obcq_30 / $ob_audit_30) * 100);
			$ob_fatalper_30 = (($ob_fatal_30 / $ob_audit_30) * 100);
		}else{
			$ob_cq_30 = 0;
			$ob_fatalper_30 = 0;
		}
	/////////////////	
		$ob_audit_60 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=31 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=60)');
		$ob_fatal_60 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=31 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=60)');
		$obcq_60 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=31 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=60)');
		
		if($ob_audit_60 > 0){
			$ob_cq_60 = (($obcq_60 / $ob_audit_60) * 100);
			$ob_fatalper_60 = (($ob_fatal_60 / $ob_audit_60) * 100);
		}else{
			$ob_cq_60 = 0;
			$ob_fatalper_60 = 0;
		}
	////////////////
		$ob_audit_90 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=61 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=90)');
		$ob_fatal_90 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=61 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=90)');
		$obcq_90 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=61 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=90)');
		
		if($ob_audit_90 > 0){
			$ob_cq_90 = (($obcq_90 / $ob_audit_90) * 100);
			$ob_fatalper_90 = (($ob_fatal_90 / $ob_audit_90) * 100);
		}else{
			$ob_cq_90 = 0;
			$ob_fatalper_90 = 0;
		}
	////////////
		$ob_audit_91 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>90 or DATEDIFF(CURDATE(), training_batch.trn_handover_date) is null)');
		$ob_fatal_91 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>90 or DATEDIFF(CURDATE(), training_batch.trn_handover_date) is null)');
		$obcq_91 = $this->Common_model->get_single_value(' '.$cond.' where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>90 or DATEDIFF(CURDATE(), training_batch.trn_handover_date) is null)');
		
		if($ob_audit_91 > 0){
			$ob_cq_91 = (($obcq_91 / $ob_audit_91) * 100);
			$ob_fatalper_91 = (($ob_fatal_91 / $ob_audit_91) * 100);
		}else{
			$ob_cq_91 = 0;
			$ob_fatalper_91 = 0;
		}
	
		$response['datas1'] = $ob_audit_30;
		$response['datas2'] = $ob_fatal_30;
		$response['datas3'] = $ob_cq_30;
		$response['datas4'] = $ob_fatalper_30;
		$response['datas5'] = $ob_audit_60;
		$response['datas6'] = $ob_fatal_60;
		$response['datas7'] = $ob_cq_60;
		$response['datas8'] = $ob_fatalper_60;
		$response['datas9'] = $ob_audit_90;
		$response['datas10'] = $ob_fatal_90;
		$response['datas11'] = $ob_cq_90;
		$response['datas12'] = $ob_fatalper_90;
		$response['datas13'] = $ob_audit_91;
		$response['datas14'] = $ob_fatal_91;
		$response['datas15'] = $ob_cq_91;
		$response['datas16'] = $ob_fatalper_91;
		
		return $response;
	}
	
	private function oyo_life_fu_tenure(){
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$cond ="Select count(agent_id) as value from qa_oyolife_followup_feedback left join training_details on training_details.user_id=qa_oyolife_followup_feedback.agent_id left join training_batch on training_details.trn_batch_id=training_batch.id";
		
		
		$fu_audit_30 = $this->Common_model->get_single_value(' '.$cond.' where year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=0 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=30)');
		$fu_fatal_30 = $this->Common_model->get_single_value(' '.$cond.' where overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=0 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=30)');
		$fucq_30 = $this->Common_model->get_single_value(' '.$cond.' where audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=0 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=30)');
		
		if($fu_audit_30 > 0){
			$fu_cq_30 = (($fucq_30 / $fu_audit_30) * 100);
			$fu_fatalper_30 = (($fu_fatal_30 / $fu_audit_30) * 100);
		}else{
			$fu_cq_30 = 0;
			$fu_fatalper_30 = 0;
		}
	/////////////////	
		$fu_audit_60 = $this->Common_model->get_single_value(' '.$cond.' where year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=31 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=60)');
		$fu_fatal_60 = $this->Common_model->get_single_value(' '.$cond.' where overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=31 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=60)');
		$fucq_60 = $this->Common_model->get_single_value(' '.$cond.' where audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=31 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=60)');
		
		if($fu_audit_60 > 0){
			$fu_cq_60 = (($fucq_60 / $fu_audit_60) * 100);
			$fu_fatalper_60 = (($fu_fatal_60 / $fu_audit_60) * 100);
		}else{
			$fu_cq_60 = 0;
			$fu_fatalper_60 = 0;
		}
	////////////////
		$fu_audit_90 = $this->Common_model->get_single_value(' '.$cond.' where year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=61 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=90)');
		$fu_fatal_90 = $this->Common_model->get_single_value(' '.$cond.' where overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=61 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=90)');
		$fucq_90 = $this->Common_model->get_single_value(' '.$cond.' where audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>=61 and DATEDIFF(CURDATE(), training_batch.trn_handover_date)<=90)');
		
		if($fu_audit_90 > 0){
			$fu_cq_90 = (($fucq_90 / $fu_audit_90) * 100);
			$fu_fatalper_90 = (($fu_fatal_90 / $fu_audit_90) * 100);
		}else{
			$fu_cq_90 = 0;
			$fu_fatalper_90 = 0;
		}
	////////////
		$fu_audit_91 = $this->Common_model->get_single_value(' '.$cond.' where year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>90 or DATEDIFF(CURDATE(), training_batch.trn_handover_date) is null)');
		$fu_fatal_91 = $this->Common_model->get_single_value(' '.$cond.' where overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>90 or DATEDIFF(CURDATE(), training_batch.trn_handover_date) is null)');
		$fucq_91 = $this->Common_model->get_single_value(' '.$cond.' where audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and (DATEDIFF(CURDATE(), training_batch.trn_handover_date)>90 or DATEDIFF(CURDATE(), training_batch.trn_handover_date) is null)');
		
		if($fu_audit_91 > 0){
			$fu_cq_91 = (($fucq_91 / $fu_audit_91) * 100);
			$fu_fatalper_91 = (($fu_fatal_91 / $fu_audit_91) * 100);
		}else{
			$fu_cq_91 = 0;
			$fu_fatalper_91 = 0;
		}
	
		$response['datas1'] = $fu_audit_30;
		$response['datas2'] = $fu_fatal_30;
		$response['datas3'] = $fu_cq_30;
		$response['datas4'] = $fu_fatalper_30;
		$response['datas5'] = $fu_audit_60;
		$response['datas6'] = $fu_fatal_60;
		$response['datas7'] = $fu_cq_60;
		$response['datas8'] = $fu_fatalper_60;
		$response['datas9'] = $fu_audit_90;
		$response['datas10'] = $fu_fatal_90;
		$response['datas11'] = $fu_cq_90;
		$response['datas12'] = $fu_fatalper_90;
		$response['datas13'] = $fu_audit_91;
		$response['datas14'] = $fu_fatal_91;
		$response['datas15'] = $fu_cq_91;
		$response['datas16'] = $fu_fatalper_91;
		
		return $response;
	}
	
	private function oyo_life_ib_weekscore(){
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$wk1_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 1');
		$wk1_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 1');
		$wk1_cqper = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 1');
		
		if($wk1_audit > 0){
			$wk1_fatalper = (($wk1_fatal / $wk1_audit) * 100);
		}else{
			$wk1_fatalper = 0;
		}
	//////////////
		$wk2_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 2');
		$wk2_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 2');
		$wk2_cqper = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 2');
		
		if($wk2_audit > 0){
			$wk2_fatalper = (($wk2_fatal / $wk2_audit) * 100);
		}else{
			$wk2_fatalper = 0;
		}
	//////////////
		$wk3_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 3');
		$wk3_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 3');
		$wk3_cqper = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 3');
		
		if($wk3_audit > 0){
			$wk3_fatalper = (($wk3_fatal / $wk3_audit) * 100);
		}else{
			$wk3_fatalper = 0;
		}
	//////////////
		$wk4_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 4');
		$wk4_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 4');
		$wk4_cqper = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_ib_ob_feedback where lob="Inbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 4');
		
		if($wk4_audit > 0){
			$wk4_fatalper = (($wk4_fatal / $wk4_audit) * 100);
		}else{
			$wk4_fatalper = 0;
		}
		
		$response['datas1'] = $wk1_audit;
		$response['datas2'] = $wk1_fatal;
		$response['datas3'] = $wk1_cqper;
		$response['datas4'] = $wk1_fatalper;
		$response['datas5'] = $wk2_audit;
		$response['datas6'] = $wk2_fatal;
		$response['datas7'] = $wk2_cqper;
		$response['datas8'] = $wk2_fatalper;
		$response['datas9'] = $wk3_audit;
		$response['datas10'] = $wk3_fatal;
		$response['datas11'] = $wk3_cqper;
		$response['datas12'] = $wk3_fatalper;
		$response['datas13'] = $wk4_audit;
		$response['datas14'] = $wk4_fatal;
		$response['datas15'] = $wk4_cqper;
		$response['datas16'] = $wk4_fatalper;
		
		return $response;
	}
	
	private function oyo_life_ob_weekscore(){
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$ob_wk1_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where audit_type="CQ Audit" and lob="Outbound" AND year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 1');
		$ob_wk1_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 1');
		$ob_wk1_cqper = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 1');
		
		if($ob_wk1_audit > 0){
			$ob_wk1_fatalper = (($ob_wk1_fatal / $ob_wk1_audit) * 100);
		}else{
			$ob_wk1_fatalper = 0;
		}
	//////////////
		$ob_wk2_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 2');
		$ob_wk2_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 2');
		$ob_wk2_cqper = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 2');
		
		if($ob_wk2_audit > 0){
			$ob_wk2_fatalper = (($ob_wk2_fatal / $ob_wk2_audit) * 100);
		}else{
			$ob_wk2_fatalper = 0;
		}
	//////////////
		$ob_wk3_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 3');
		$ob_wk3_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 3');
		$ob_wk3_cqper = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 3');
		
		if($ob_wk3_audit > 0){
			$ob_wk3_fatalper = (($ob_wk3_fatal / $ob_wk3_audit) * 100);
		}else{
			$ob_wk3_fatalper = 0;
		}
	//////////////
		$ob_wk4_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 4');
		$ob_wk4_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and overall_score=0 and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 4');
		$ob_wk4_cqper = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_ib_ob_feedback where lob="Outbound" and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 4');
		
		if($ob_wk4_audit > 0){
			$ob_wk4_fatalper = (($ob_wk4_fatal / $ob_wk4_audit) * 100);
		}else{
			$ob_wk4_fatalper = 0;
		}
		
		$response['datas1'] = $ob_wk1_audit;
		$response['datas2'] = $ob_wk1_fatal;
		$response['datas3'] = $ob_wk1_cqper;
		$response['datas4'] = $ob_wk1_fatalper;
		$response['datas5'] = $ob_wk2_audit;
		$response['datas6'] = $ob_wk2_fatal;
		$response['datas7'] = $ob_wk2_cqper;
		$response['datas8'] = $ob_wk2_fatalper;
		$response['datas9'] = $ob_wk3_audit;
		$response['datas10'] = $ob_wk3_fatal;
		$response['datas11'] = $ob_wk3_cqper;
		$response['datas12'] = $ob_wk3_fatalper;
		$response['datas13'] = $ob_wk4_audit;
		$response['datas14'] = $ob_wk4_fatal;
		$response['datas15'] = $ob_wk4_cqper;
		$response['datas16'] = $ob_wk4_fatalper;
		
		return $response;
	}
	
	private function oyo_life_fu_weekscore(){
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$fu_wk1_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" AND year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 1');
		$fu_wk1_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_followup_feedback where overall_score=0 and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 1');
		$fu_wk1_cqper = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 1');
		
		if($fu_wk1_audit>0){
			$fu_wk1_fatalper = (($fu_wk1_fatal / $fu_wk1_audit) * 100);
		}else{
			$fu_wk1_fatalper = 0;
		}
	//////////////
		$fu_wk2_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" AND year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 2');
		$fu_wk2_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_followup_feedback where overall_score=0 and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 2');
		$fu_wk2_cqper = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 2');
		
		if($fu_wk2_audit>0){
			$fu_wk2_fatalper = (($fu_wk2_fatal / $fu_wk2_audit) * 100);
		}else{
			$fu_wk2_fatalper = 0;
		}
	//////////////
		$fu_wk3_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" AND year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 3');
		$fu_wk3_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_followup_feedback where overall_score=0 and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 3');
		$fu_wk3_cqper = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 3');
		
		if($fu_wk3_audit>0){
			$fu_wk3_fatalper = (($fu_wk3_fatal / $fu_wk3_audit) * 100);
		}else{
			$fu_wk3_fatalper = 0;
		}
	//////////////
		$fu_wk4_audit = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" AND year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 4');
		$fu_wk4_fatal = $this->Common_model->get_single_value('Select count(agent_id) as value from qa_oyolife_followup_feedback where overall_score=0 and audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 3');
		$fu_wk4_cqper = $this->Common_model->get_single_value('Select AVG(overall_score) as value from qa_oyolife_followup_feedback where audit_type="CQ Audit" and year(audit_date) = "'.$year.'" and month(audit_date) = "'.$month.'" and FLOOR(((DAY(audit_date) - 1) / 7) + 1) = 4');
		
		if($fu_wk4_audit>0){
			$fu_wk4_fatalper = (($fu_wk4_fatal / $fu_wk4_audit) * 100);
		}else{
			$fu_wk4_fatalper = 0;
		}
		
		
		$response['datas1'] = $fu_wk1_audit;
		$response['datas2'] = $fu_wk1_fatal;
		$response['datas3'] = $fu_wk1_cqper;
		$response['datas4'] = $fu_wk1_fatalper;
		$response['datas5'] = $fu_wk2_audit;
		$response['datas6'] = $fu_wk2_fatal;
		$response['datas7'] = $fu_wk2_cqper;
		$response['datas8'] = $fu_wk2_fatalper;
		$response['datas9'] = $fu_wk3_audit;
		$response['datas10'] = $fu_wk3_fatal;
		$response['datas11'] = $fu_wk3_cqper;
		$response['datas12'] = $fu_wk3_fatalper;
		$response['datas13'] = $fu_wk4_audit;
		$response['datas14'] = $fu_wk4_fatal;
		$response['datas15'] = $fu_wk4_cqper;
		$response['datas16'] = $fu_wk4_fatalper;
		
		return $response;
	}
	
	
	private function oyolife_booking(){
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		
		$query = $this->db->query('SELECT count(id) as audit_count, 
				(select count(overall_score) as tot_scr from qa_oyolife_booking_feedback b where b.id=id and overall_score=0) as fatal, 
				ROUND(AVG(overall_score),2) as cq_score, 
				ROUND(((select count(overall_score) as tot_scr from qa_oyolife_booking_feedback b where b.id=id and overall_score=0)*100/count(id)) , 2) as fatal_per 
				FROM qa_oyolife_booking_feedback WHERE audit_type="CQ Audit" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'"');
		
		$response = array();
		if($query)
		{
			$booking_rows = $query->result_object();
			
			$response['stat'] = true;
			$response['datas'] = $booking_rows;
			
		}else{
			$response['stat'] = false;
		}
		return $response;
	}
	
	
/*-----SIG RCA--------*/
	private function oyo_sig_dsat()
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		
		
		$control_dsat = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where control_uncontrol="Controllable" and YEAR(audit_date_time) = "'.$year.'" AND MONTH(audit_date_time) = "'.$month.'" ');
		
		$uncontrol_dsat = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where control_uncontrol="Uncontrollable" and YEAR(audit_date_time) = "'.$year.'" AND MONTH(audit_date_time) = "'.$month.'" ');
		
		$tot_audit = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca Where YEAR(audit_date_time) = "'.$year.'" AND MONTH(audit_date_time) = "'.$month.'"');
		
		if($tot_audit > 0){
			$control_dsat_per = round( (($control_dsat / $tot_audit) * 100) , 2);
			$uncontrol_dsat_per = round( (($uncontrol_dsat / $tot_audit) * 100) , 2);
			$control_uncontrol_tot = ($tot_audit / $tot_audit) * 100;
		}else{
			$control_dsat_per = 0;
			$uncontrol_dsat_per = 0;
			$control_uncontrol_tot = 0;
		}	
		
		if($control_dsat > 0){
			$response['datas1'] = $control_dsat;
			$response['datas2'] = $control_dsat_per;
			
			$response['datas3'] = $uncontrol_dsat;
			$response['datas4'] = $uncontrol_dsat_per;
			
			$response['datas5'] = $tot_audit;
			$response['datas6'] = $control_uncontrol_tot;
		}else{
			$response['datas1'] = 0;
			$response['datas2'] = 0;
			
			$response['datas3'] = 0;
			$response['datas4'] = 0;
			
			$response['datas5'] = 0;
			$response['datas6'] = 0;
		}
		return $response;
	}
	
	private function oyo_sig_dsat_acpt()
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		
		
		$property_dsat = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Property" and YEAR(audit_date_time) = "'.$year.'" AND MONTH(audit_date_time) = "'.$month.'" ');
		
		$process_dsat = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Process" and YEAR(audit_date_time) = "'.$year.'" AND MONTH(audit_date_time) = "'.$month.'" ');
		
		$agent_dsat = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Agent" and YEAR(audit_date_time) = "'.$year.'" AND MONTH(audit_date_time) = "'.$month.'" ');
		
		$customer_dsat = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Customer" and YEAR(audit_date_time) = "'.$year.'" AND MONTH(audit_date_time) = "'.$month.'" ');
		
		$technology_dsat = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Technology" and YEAR(audit_date_time) = "'.$year.'" AND MONTH(audit_date_time) = "'.$month.'" ');
		
		$tot_dsat = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca Where YEAR(audit_date_time) = "'.$year.'" AND MONTH(audit_date_time) = "'.$month.'"');
		
		if($tot_dsat > 0){
			$property_dsat_per = round( (($property_dsat / $tot_dsat) * 100) , 2);
			$process_dsat_per = round( (($process_dsat / $tot_dsat) * 100) , 2);
			$agent_dsat_per = round( (($agent_dsat / $tot_dsat) * 100) , 2);
			$customer_dsat_per = round( (($customer_dsat / $tot_dsat) * 100) , 2);
			$technology_dsat_per = round( (($technology_dsat / $tot_dsat) * 100) , 2);
			$acpt_tot_per = ($tot_dsat / $tot_dsat) * 100;
		}else{
			$property_dsat_per = 0;
			$process_dsat_per = 0;
			$agent_dsat_per = 0;
			$customer_dsat_per = 0;
			$technology_dsat_per = 0;
			$acpt_tot_per = 0;
		}
		
		if($tot_dsat > 0){
			$response['datas1'] = $property_dsat;
			$response['datas2'] = $property_dsat_per;
			$response['datas3'] = $process_dsat;
			$response['datas4'] = $process_dsat_per;
			$response['datas5'] = $agent_dsat;
			$response['datas6'] = $agent_dsat_per;
			$response['datas7'] = $customer_dsat;
			$response['datas8'] = $customer_dsat_per;
			$response['datas9'] = $technology_dsat;
			$response['datas10'] = $technology_dsat_per;
			$response['datas11'] = $tot_dsat;
			$response['datas12'] = $acpt_tot_per;
		}else{
			$response['datas1'] = 0;
			$response['datas2'] = 0;
			$response['datas3'] = 0;
			$response['datas4'] = 0;
			$response['datas5'] = 0;
			$response['datas6'] = 0;
			$response['datas7'] = 0;
			$response['datas8'] = 0;
			$response['datas9'] = 0;
			$response['datas10'] = 0;
			$response['datas11'] = 0;
			$response['datas12'] = 0;
		}
		return $response;
	}
	
	private function oyo_sigrca_dsat_drivers()
	{
		/* $acpt_agnt1 = array('Agent', 'Improper call handling', 'Force for GSAT on call');
		
		$qSql="select count(id) as value, acpt, why1, why2 from qa_oyosig_rca group by acpt,why1,why2";
		$dsat_driver = $this->Common_model->get_query_result_array($qSql);
		
		
		$result = array();
		foreach ($dsat_driver as $row){
			foreach ($acpt_agnt1 as $k){
				if (!isset($row[$k])) { 
					$acpt_agent1 = $row['value'];
				}
			}
			$result[] = $row; 
		}
		return $result;  */
		
		$acpt_agent1 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Agent" and why1="Improper call handling"');
		$acpt_agent2 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Agent" and why1="Incorrect resolution"');
		$acpt_agent3 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Agent" and why1="Knowledge Gap"');
		$acpt_agent4 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Agent" and why1="Wrong Commitment"');
		$acpt_customer = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Customer" and why1="Rating given for another reason"');
		$acpt_process1 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Process" and why1="Case Resolve by other Centre"');
		$acpt_process2 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Process" and why1="IVR shifting"');
		$acpt_process3 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Process" and why1="Pending amount not adjusted"');
		$acpt_process4 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Process" and why1="Refund not processed"');
		$acpt_process5 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Process" and why1="Refund not received"');
		$acpt_property1 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Property" and why1="Check In Deny"');
		$acpt_property2 = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Property" and why1="Service issue"');
		$acpt_tech = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca where acpt="Technology" and why1="Payment not updated"');
		
		$grn_tot = $this->Common_model->get_single_value('Select count(id) as value from qa_oyosig_rca');
		
		
		if($grn_tot > 0){
			$response['datas1'] = $acpt_agent1;
			$response['datas2'] = $acpt_agent2;
			$response['datas3'] = $acpt_agent3;
			$response['datas4'] = $acpt_agent4;
			$response['datas5'] = $acpt_customer;
			$response['datas6'] = $acpt_process1;
			$response['datas7'] = $acpt_process2;
			$response['datas8'] = $acpt_process3;
			$response['datas9'] = $acpt_process4;
			$response['datas10'] = $acpt_process5;
			$response['datas11'] = $acpt_property1;
			$response['datas12'] = $acpt_property2;
			$response['datas13'] = $acpt_tech;
			$response['datas14'] = $grn_tot;
		}else{
			$response['datas1'] = 0;
			$response['datas2'] = 0;
			$response['datas3'] = 0;
			$response['datas4'] = 0;
			$response['datas5'] = 0;
			$response['datas6'] = 0;
			$response['datas7'] = 0;
			$response['datas8'] = 0;
			$response['datas9'] = 0;
			$response['datas10'] = 0;
			$response['datas11'] = 0;
			$response['datas12'] = 0;
			$response['datas13'] = 0;
			$response['datas14'] = 0;
		}
		return $response;
	}
	
//////HA,HCCO,CJPA/////////
	private function agent_score_bracket($table,$location)
	{
		$date = new DateTime(date('Y-m-d'));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$tot_score_below = $this->Common_model->get_single_value('SELECT count(agent_id) as value FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE  office_id="'.$location.'"');
		
		$wtd_score_below_80 = $this->Common_model->get_single_value('SELECT count(agent_id) as value FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE  office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND WEEK(audit_date,1)="'.$week.'" and overall_score < 80');
		$mtd_score_below_80 = $this->Common_model->get_single_value('SELECT count(agent_id) as value FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE  office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" and overall_score < 80');
		
		$wtd_score_below_90 = $this->Common_model->get_single_value('SELECT count(agent_id) as value FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE  office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND WEEK(audit_date,1)="'.$week.'" and (overall_score > 80 and overall_score < 90)');
		$mtd_score_below_90 = $this->Common_model->get_single_value('SELECT count(agent_id) as value FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE  office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" and (overall_score > 80 and overall_score < 90)');
		
		$wtd_score_below_100 = $this->Common_model->get_single_value('SELECT count(agent_id) as value FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE  office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" AND WEEK(audit_date,1)="'.$week.'" and overall_score > 90');
		$wtd_score_below_100 = $this->Common_model->get_single_value('SELECT count(agent_id) as value FROM '.$table.' LEFT JOIN signin ON signin.id='.$table.'.agent_id WHERE  office_id="'.$location.'" AND YEAR(audit_date) = "'.$year.'" AND MONTH(audit_date) = "'.$month.'" and overall_score > 90');
		
		
		if($tot_score_below > 0){
			$response['datas1'] = $wtd_score_below_80;
			$response['datas2'] = $mtd_score_below_80;
			$response['datas3'] = $wtd_score_below_90;
			$response['datas4'] = $mtd_score_below_90;
			$response['datas5'] = $wtd_score_below_100;
			$response['datas6'] = $wtd_score_below_100;
		}else{
			$response['datas1'] = 0;
			$response['datas2'] = 0;
			$response['datas3'] = 0;
			$response['datas4'] = 0;
			$response['datas5'] = 0;
			$response['datas6'] = 0;
		}
		return $response;
	}
	
	
/*--------------------*/	
	
	public function get_qa_scores()
	{
		$form_data = $this->input->post();
		
		//$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names FROM `qa_defect` WHERE FIND_IN_SET('.$form_data['process_id'].',process_id)');
		
		$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names,process.name as process_name FROM `qa_defect` LEFT JOIN process ON process.id='.$form_data['process_id'].' WHERE FIND_IN_SET(process_id, "'.$form_data['process_id'].'")');
		$row = $query->row();
		
		
		$verso_ob_cnt1 = $this->get_verso_ob($row->table_name);
		$verso_ob_cnt2 = $this->get_verso_ob($row->table_name);
		$verso_ob_cnt3 = $this->get_verso_ob($row->table_name);
		$verso_ob_cnt4 = $this->get_verso_ob($row->table_name);
		$verso_ob_contrib1 = $this->get_verso_ob($row->table_name);
		$verso_ob_contrib2 = $this->get_verso_ob($row->table_name);
		$verso_ob_contrib3 = $this->get_verso_ob($row->table_name);
		$verso_ob_contrib4 = $this->get_verso_ob($row->table_name);
		
		$wtd_score_below_80 = $this->agent_score_bracket($row->table_name,$form_data['office_id']);
		$mtd_score_below_80 = $this->agent_score_bracket($row->table_name,$form_data['office_id']);
		$wtd_score_below_90 = $this->agent_score_bracket($row->table_name,$form_data['office_id']);
		$mtd_score_below_90 = $this->agent_score_bracket($row->table_name,$form_data['office_id']);
		$wtd_score_below_100 = $this->agent_score_bracket($row->table_name,$form_data['office_id']);
		$mtd_score_below_100 = $this->agent_score_bracket($row->table_name,$form_data['office_id']);
		
		$get_agent_fd_acpt = $this->get_agent_fd_acpt($row->table_name,$form_data['office_id']);
		$get_agent_fd_pnd = $this->get_agent_fd_pnd($row->table_name,$form_data['office_id']);
		
		$csat_process_score = $this->get_csat_process_score($row->table_name,$row->process_name,$form_data['office_id']);
		$nps_process_score = $this->get_nps_process_score($row->table_name,$row->process_name,$form_data['office_id']);
		
		$mtd_process_score = $this->get_mtd_process_score($row->table_name,$row->process_name,$form_data['office_id']);
		$process_mtd_no_of_audit = $this->get_process_mtd_no_of_audit($row->table_name,$row->process_name,$form_data['office_id']);
		
		$mtd_no_of_audit = $this->get_mtd_no_of_audit($row->table_name,$row->process_name,$form_data['office_id'],true);
		$mtd_score = $this->get_mtd_score($row->table_name,$row->process_name,$form_data['office_id'],true);
		
		$wtd_no_of_audit = $this->get_wtd_no_of_audit($row->table_name,$row->process_name,$form_data['office_id'],true);
		$wtd_score = $this->get_wtd_score($row->table_name,$row->process_name,$form_data['office_id'],true);
		
		$wtd_score_30 = $this->get_wtd_score_30($row->table_name,$row->process_name,$form_data['current_user'],$form_data['office_id']);
		$mtd_score_30 = $this->get_mtd_score_30($row->table_name,$row->process_name,$form_data['current_user'],$form_data['office_id']);
		
		$wtd_score_60 = $this->get_wtd_score_60($row->table_name,$row->process_name,$form_data['current_user'],$form_data['office_id']);
		$mtd_score_60 = $this->get_mtd_score_60($row->table_name,$row->process_name,$form_data['current_user'],$form_data['office_id']);
		
		$wtd_score_90 = $this->get_wtd_score_90($row->table_name,$row->process_name,$form_data['current_user'],$form_data['office_id']);
		$mtd_score_90 = $this->get_mtd_score_90($row->table_name,$row->process_name,$form_data['current_user'],$form_data['office_id']);
		
		$wtd_score_above = $this->get_wtd_score_above($row->table_name,$row->process_name,$form_data['current_user'],$form_data['office_id']);
		$mtd_score_above = $this->get_mtd_score_above($row->table_name,$row->process_name,$form_data['current_user'],$form_data['office_id']);
		
		$defects = $this->get_own_defected($form_data['process_id'],$form_data['client_id'],$form_data['current_user'],$form_data['office_id'],true,true);
		
		$response = array();
		if($mtd_process_score['stat'] == true)
		{
			$response['stat'] = true;
			
			$response['datas']['verso_ob_cnt1'] = $verso_ob_cnt1['datas1'];
			$response['datas']['verso_ob_cnt2'] = $verso_ob_cnt2['datas2'];
			$response['datas']['verso_ob_cnt3'] = $verso_ob_cnt3['datas3'];
			$response['datas']['verso_ob_cnt4'] = $verso_ob_cnt4['datas4'];
			$response['datas']['verso_ob_contrib1'] = $verso_ob_contrib1['datas5'];
			$response['datas']['verso_ob_contrib2'] = $verso_ob_contrib2['datas6'];
			$response['datas']['verso_ob_contrib3'] = $verso_ob_contrib3['datas7'];
			$response['datas']['verso_ob_contrib4'] = $verso_ob_contrib4['datas8'];
			
			$response['datas']['wtd_score_below_80'] = $wtd_score_below_80['datas1'];
			$response['datas']['mtd_score_below_80'] = $mtd_score_below_80['datas2'];
			$response['datas']['wtd_score_below_90'] = $wtd_score_below_90['datas3'];
			$response['datas']['mtd_score_below_90'] = $mtd_score_below_90['datas4'];
			$response['datas']['wtd_score_below_100'] = $wtd_score_below_100['datas5'];
			$response['datas']['mtd_score_below_100'] = $mtd_score_below_100['datas6'];
			
			$response['datas']['get_agent_fd_acpt'] = $get_agent_fd_acpt['datas'];
			$response['datas']['get_agent_fd_pnd'] = $get_agent_fd_pnd['datas'];
			
			$response['datas']['csat_process_score'] = $csat_process_score['datas'];
			$response['datas']['nps_process_score'] = $nps_process_score['datas'];
			
			$response['datas']['mtd_process_score'] = $mtd_process_score['datas'];
			$response['datas']['process_mtd_no_of_audit'] = $process_mtd_no_of_audit['datas'];
			
			$response['datas']['mtd_no_of_audit'] = $mtd_no_of_audit['datas'];
			$response['datas']['mtd_score'] = $mtd_score['datas'];
			
			$response['datas']['wtd_no_of_audit'] = $wtd_no_of_audit['datas'];
			$response['datas']['wtd_score'] = $wtd_score['datas'];
			
			$response['datas']['wtd_score_30'] = $wtd_score_30['datas'];
			$response['datas']['mtd_score_30'] = $mtd_score_30['datas'];
			
			$response['datas']['wtd_score_60'] = $wtd_score_60['datas'];
			$response['datas']['mtd_score_60'] = $mtd_score_60['datas'];
			
			$response['datas']['wtd_score_90'] = $wtd_score_90['datas'];
			$response['datas']['mtd_score_90'] = $mtd_score_90['datas'];
			
			$response['datas']['wtd_score_above'] = $wtd_score_above['datas'];
			$response['datas']['mtd_score_above'] = $mtd_score_above['datas'];
			
			$response['datas']['defects'] = $defects['datas'];
			
		}
		echo json_encode($response);
	}
	
///////////////////////////
	public function get_rca_data()
	{
		$control_dsat = $this->oyo_sig_dsat();
		$control_dsat_per = $this->oyo_sig_dsat();
		$uncontrol_dsat = $this->oyo_sig_dsat();
		$uncontrol_dsat_per = $this->oyo_sig_dsat();
		$tot_audit = $this->oyo_sig_dsat();
		$control_uncontrol_tot = $this->oyo_sig_dsat();
		
		$property_dsat = $this->oyo_sig_dsat_acpt();
		$property_dsat_per = $this->oyo_sig_dsat_acpt();
		$process_dsat = $this->oyo_sig_dsat_acpt();
		$process_dsat_per = $this->oyo_sig_dsat_acpt();
		$agent_dsat = $this->oyo_sig_dsat_acpt();
		$agent_dsat_per = $this->oyo_sig_dsat_acpt();
		$customer_dsat = $this->oyo_sig_dsat_acpt();
		$customer_dsat_per = $this->oyo_sig_dsat_acpt();
		$technology_dsat = $this->oyo_sig_dsat_acpt();
		$technology_dsat_per = $this->oyo_sig_dsat_acpt();
		$tot_dsat = $this->oyo_sig_dsat_acpt();
		$acpt_tot_per = $this->oyo_sig_dsat_acpt();
		
		$acpt_agent1 = $this->oyo_sigrca_dsat_drivers();
		$acpt_agent2 = $this->oyo_sigrca_dsat_drivers();
		$acpt_agent3 = $this->oyo_sigrca_dsat_drivers();
		$acpt_agent4 = $this->oyo_sigrca_dsat_drivers();
		$acpt_customer = $this->oyo_sigrca_dsat_drivers();
		$acpt_process1 = $this->oyo_sigrca_dsat_drivers();
		$acpt_process2 = $this->oyo_sigrca_dsat_drivers();
		$acpt_process3 = $this->oyo_sigrca_dsat_drivers();
		$acpt_process4 = $this->oyo_sigrca_dsat_drivers();
		$acpt_process5 = $this->oyo_sigrca_dsat_drivers();
		$acpt_property1 = $this->oyo_sigrca_dsat_drivers();
		$acpt_property2 = $this->oyo_sigrca_dsat_drivers();
		$acpt_tech = $this->oyo_sigrca_dsat_drivers();
		$grn_tot = $this->oyo_sigrca_dsat_drivers();
		
		$response = array();
		$response['stat'] = true;
		
		$response['datas']['control_dsat'] = $control_dsat['datas1'];
		$response['datas']['control_dsat_per'] = $control_dsat_per['datas2'];
		$response['datas']['uncontrol_dsat'] = $uncontrol_dsat['datas3'];
		$response['datas']['uncontrol_dsat_per'] = $uncontrol_dsat_per['datas4'];
		$response['datas']['tot_audit'] = $tot_audit['datas5'];
		$response['datas']['control_uncontrol_tot'] = $control_uncontrol_tot['datas6'];

		$response['datas']['property_dsat'] = $property_dsat['datas1'];
		$response['datas']['property_dsat_per'] = $property_dsat_per['datas2'];
		$response['datas']['process_dsat'] = $process_dsat['datas3'];
		$response['datas']['process_dsat_per'] = $process_dsat_per['datas4'];
		$response['datas']['agent_dsat'] = $agent_dsat['datas5'];
		$response['datas']['agent_dsat_per'] = $agent_dsat_per['datas6'];
		$response['datas']['customer_dsat'] = $customer_dsat['datas7'];
		$response['datas']['customer_dsat_per'] = $customer_dsat_per['datas8'];
		$response['datas']['technology_dsat'] = $technology_dsat['datas9'];
		$response['datas']['technology_dsat_per'] = $technology_dsat_per['datas10'];
		$response['datas']['tot_dsat'] = $tot_dsat['datas11'];
		$response['datas']['acpt_tot_per'] = $acpt_tot_per['datas12'];
		
		$response['datas']['acpt_agent1'] = $acpt_agent1['datas1'];
		$response['datas']['acpt_agent2'] = $acpt_agent2['datas2'];
		$response['datas']['acpt_agent3'] = $acpt_agent3['datas3'];
		$response['datas']['acpt_agent4'] = $acpt_agent4['datas4'];
		$response['datas']['acpt_customer'] = $acpt_customer['datas5'];
		$response['datas']['acpt_process1'] = $acpt_process1['datas6'];
		$response['datas']['acpt_process2'] = $acpt_process2['datas7'];
		$response['datas']['acpt_process3'] = $acpt_process3['datas8'];
		$response['datas']['acpt_process4'] = $acpt_process4['datas9'];
		$response['datas']['acpt_process5'] = $acpt_process5['datas10'];
		$response['datas']['acpt_property1'] = $acpt_property1['datas11'];
		$response['datas']['acpt_property2'] = $acpt_property2['datas12'];
		$response['datas']['acpt_tech'] = $acpt_tech['datas13'];
		$response['datas']['grn_tot'] = $grn_tot['datas14'];
			
		echo json_encode($response);
	}
	
///////////OYO LIFE////////////////
	public function oyo_life_ibobfollow()
	{	
		$cq_auditcount = $this->oyo_life_ib();
		$cq_fatal = $this->oyo_life_ib();
		$cq_per = $this->oyo_life_ib();
		$fatal_per = $this->oyo_life_ib();
		
		$ob_cq_auditcount = $this->oyo_life_ob();
		$ob_cq_fatal = $this->oyo_life_ob();
		$ob_cq_per = $this->oyo_life_ob();
		$ob_fatal_per = $this->oyo_life_ob();
		
		$fu_cq_auditcount = $this->oyo_life_fu();
		$fu_cq_fatal = $this->oyo_life_fu();
		$fu_cq_per = $this->oyo_life_fu();
		$fu_fatal_per = $this->oyo_life_fu();
		
		$ib_audit_30 = $this->oyo_life_ib_tenure();
		$ib_fatal_30 = $this->oyo_life_ib_tenure();
		$ib_cq_30 = $this->oyo_life_ib_tenure();
		$ib_fatalper_30 = $this->oyo_life_ib_tenure();
		$ib_audit_60 = $this->oyo_life_ib_tenure();
		$ib_fatal_60 = $this->oyo_life_ib_tenure();
		$ib_cq_60 = $this->oyo_life_ib_tenure();
		$ib_fatalper_60 = $this->oyo_life_ib_tenure();
		$ib_audit_90 = $this->oyo_life_ib_tenure();
		$ib_fatal_90 = $this->oyo_life_ib_tenure();
		$ib_cq_90 = $this->oyo_life_ib_tenure();
		$ib_fatalper_90 = $this->oyo_life_ib_tenure();
		$ib_audit_91 = $this->oyo_life_ib_tenure();
		$ib_fatal_91 = $this->oyo_life_ib_tenure();
		$ib_cq_91 = $this->oyo_life_ib_tenure();
		$ib_fatalper_91 = $this->oyo_life_ib_tenure();
		
		$ob_audit_30 = $this->oyo_life_ob_tenure();
		$ob_fatal_30 = $this->oyo_life_ob_tenure();
		$ob_cq_30 = $this->oyo_life_ob_tenure();
		$ob_fatalper_30 = $this->oyo_life_ob_tenure();
		$ob_audit_60 = $this->oyo_life_ob_tenure();
		$ob_fatal_60 = $this->oyo_life_ob_tenure();
		$ob_cq_60 = $this->oyo_life_ob_tenure();
		$ob_fatalper_60 = $this->oyo_life_ob_tenure();
		$ob_audit_90 = $this->oyo_life_ob_tenure();
		$ob_fatal_90 = $this->oyo_life_ob_tenure();
		$ob_cq_90 = $this->oyo_life_ob_tenure();
		$ob_fatalper_90 = $this->oyo_life_ob_tenure();
		$ob_audit_91 = $this->oyo_life_ob_tenure();
		$ob_fatal_91 = $this->oyo_life_ob_tenure();
		$ob_cq_91 = $this->oyo_life_ob_tenure();
		$ob_fatalper_91 = $this->oyo_life_ob_tenure();
		
		$fu_audit_30 = $this->oyo_life_fu_tenure();
		$fu_fatal_30 = $this->oyo_life_fu_tenure();
		$fu_cq_30 = $this->oyo_life_fu_tenure();
		$fu_fatalper_30 = $this->oyo_life_fu_tenure();
		$fu_audit_60 = $this->oyo_life_fu_tenure();
		$fu_fatal_60 = $this->oyo_life_fu_tenure();
		$fu_cq_60 = $this->oyo_life_fu_tenure();
		$fu_fatalper_60 = $this->oyo_life_fu_tenure();
		$fu_audit_90 = $this->oyo_life_fu_tenure();
		$fu_fatal_90 = $this->oyo_life_fu_tenure();
		$fu_cq_90 = $this->oyo_life_fu_tenure();
		$fu_fatalper_90 = $this->oyo_life_fu_tenure();
		$fu_audit_91 = $this->oyo_life_fu_tenure();
		$fu_fatal_91 = $this->oyo_life_fu_tenure();
		$fu_cq_91 = $this->oyo_life_fu_tenure();
		$fu_fatalper_91 = $this->oyo_life_fu_tenure();
		
		$wk1_audit = $this->oyo_life_ib_weekscore();
		$wk1_fatal = $this->oyo_life_ib_weekscore();
		$wk1_cqper = $this->oyo_life_ib_weekscore();
		$wk1_fatalper = $this->oyo_life_ib_weekscore();
		$wk2_audit = $this->oyo_life_ib_weekscore();
		$wk2_fatal = $this->oyo_life_ib_weekscore();
		$wk2_cqper = $this->oyo_life_ib_weekscore();
		$wk2_fatalper = $this->oyo_life_ib_weekscore();
		$wk3_audit = $this->oyo_life_ib_weekscore();
		$wk3_fatal = $this->oyo_life_ib_weekscore();
		$wk3_cqper = $this->oyo_life_ib_weekscore();
		$wk3_fatalper = $this->oyo_life_ib_weekscore();
		$wk4_audit = $this->oyo_life_ib_weekscore();
		$wk4_fatal = $this->oyo_life_ib_weekscore();
		$wk4_cqper = $this->oyo_life_ib_weekscore();
		$wk4_fatalper = $this->oyo_life_ib_weekscore();
		
		$ob_wk1_audit = $this->oyo_life_ob_weekscore();
		$ob_wk1_fatal = $this->oyo_life_ob_weekscore();
		$ob_wk1_cqper = $this->oyo_life_ob_weekscore();
		$ob_wk1_fatalper = $this->oyo_life_ob_weekscore();
		$ob_wk2_audit = $this->oyo_life_ob_weekscore();
		$ob_wk2_fatal = $this->oyo_life_ob_weekscore();
		$ob_wk2_cqper = $this->oyo_life_ob_weekscore();
		$ob_wk2_fatalper = $this->oyo_life_ob_weekscore();
		$ob_wk3_audit = $this->oyo_life_ob_weekscore();
		$ob_wk3_fatal = $this->oyo_life_ob_weekscore();
		$ob_wk3_cqper = $this->oyo_life_ob_weekscore();
		$ob_wk3_fatalper = $this->oyo_life_ob_weekscore();
		$ob_wk4_audit = $this->oyo_life_ob_weekscore();
		$ob_wk4_fatal = $this->oyo_life_ob_weekscore();
		$ob_wk4_cqper = $this->oyo_life_ob_weekscore();
		$ob_wk4_fatalper = $this->oyo_life_ob_weekscore();
		
		$fu_wk1_audit = $this->oyo_life_fu_weekscore();
		$fu_wk1_fatal = $this->oyo_life_fu_weekscore();
		$fu_wk1_cqper = $this->oyo_life_fu_weekscore();
		$fu_wk1_fatalper = $this->oyo_life_fu_weekscore();
		$fu_wk2_audit = $this->oyo_life_fu_weekscore();
		$fu_wk2_fatal = $this->oyo_life_fu_weekscore();
		$fu_wk2_cqper = $this->oyo_life_fu_weekscore();
		$fu_wk2_fatalper = $this->oyo_life_fu_weekscore();
		$fu_wk3_audit = $this->oyo_life_fu_weekscore();
		$fu_wk3_fatal = $this->oyo_life_fu_weekscore();
		$fu_wk3_cqper = $this->oyo_life_fu_weekscore();
		$fu_wk3_fatalper = $this->oyo_life_fu_weekscore();
		$fu_wk4_audit = $this->oyo_life_fu_weekscore();
		$fu_wk4_fatal = $this->oyo_life_fu_weekscore();
		$fu_wk4_cqper = $this->oyo_life_fu_weekscore();
		$fu_wk4_fatalper = $this->oyo_life_fu_weekscore();
		
		$oyo_life_booking = $this->oyolife_booking();
		
		$response = array();
		$response['stat'] = true;
		
		$response['datas']['cq_auditcount'] = $cq_auditcount['datas1'];
		$response['datas']['cq_fatal'] = $cq_fatal['datas2'];
		$response['datas']['cq_per'] = $cq_fatal['datas3'];
		$response['datas']['fatal_per'] = $cq_fatal['datas4'];
		
		$response['datas']['ob_cq_auditcount'] = $ob_cq_auditcount['datas1'];
		$response['datas']['ob_cq_fatal'] = $ob_cq_fatal['datas2'];
		$response['datas']['ob_cq_per'] = $ob_cq_fatal['datas3'];
		$response['datas']['ob_fatal_per'] = $ob_cq_fatal['datas4'];
		
		$response['datas']['fu_cq_auditcount'] = $fu_cq_auditcount['datas1'];
		$response['datas']['fu_cq_fatal'] = $fu_cq_fatal['datas2'];
		$response['datas']['fu_cq_per'] = $fu_cq_fatal['datas3'];
		$response['datas']['fu_fatal_per'] = $fu_cq_fatal['datas4'];
		
		$response['datas']['ib_audit_30'] = $ib_audit_30['datas1'];
		$response['datas']['ib_fatal_30'] = $ib_fatal_30['datas2'];
		$response['datas']['ib_cq_30'] = $ib_cq_30['datas3'];
		$response['datas']['ib_fatalper_30'] = $ib_fatalper_30['datas4'];
		$response['datas']['ib_audit_60'] = $ib_audit_60['datas5'];
		$response['datas']['ib_fatal_60'] = $ib_fatal_60['datas6'];
		$response['datas']['ib_cq_60'] = $ib_cq_60['datas7'];
		$response['datas']['ib_fatalper_60'] = $ib_fatalper_60['datas8'];
		$response['datas']['ib_audit_90'] = $ib_audit_90['datas9'];
		$response['datas']['ib_fatal_90'] = $ib_fatal_90['datas10'];
		$response['datas']['ib_cq_90'] = $ib_cq_90['datas11'];
		$response['datas']['ib_fatalper_90'] = $ib_fatalper_90['datas12'];
		$response['datas']['ib_audit_91'] = $ib_audit_91['datas13'];
		$response['datas']['ib_fatal_91'] = $ib_fatal_91['datas14'];
		$response['datas']['ib_cq_91'] = $ib_cq_91['datas15'];
		$response['datas']['ib_fatalper_91'] = $ib_fatalper_91['datas16'];
		
		$response['datas']['ob_audit_30'] = $ob_audit_30['datas1'];
		$response['datas']['ob_fatal_30'] = $ob_fatal_30['datas2'];
		$response['datas']['ob_cq_30'] = $ob_cq_30['datas3'];
		$response['datas']['ob_fatalper_30'] = $ob_fatalper_30['datas4'];
		$response['datas']['ob_audit_60'] = $ob_audit_60['datas5'];
		$response['datas']['ob_fatal_60'] = $ob_fatal_60['datas6'];
		$response['datas']['ob_cq_60'] = $ob_cq_60['datas7'];
		$response['datas']['ob_fatalper_60'] = $ob_fatalper_60['datas8'];
		$response['datas']['ob_audit_90'] = $ob_audit_90['datas9'];
		$response['datas']['ob_fatal_90'] = $ob_fatal_90['datas10'];
		$response['datas']['ob_cq_90'] = $ob_cq_90['datas11'];
		$response['datas']['ob_fatalper_90'] = $ob_fatalper_90['datas12'];
		$response['datas']['ob_audit_91'] = $ob_audit_91['datas13'];
		$response['datas']['ob_fatal_91'] = $ob_fatal_91['datas14'];
		$response['datas']['ob_cq_91'] = $ob_cq_91['datas15'];
		$response['datas']['ob_fatalper_91'] = $ob_fatalper_91['datas16'];
		
		$response['datas']['fu_audit_30'] = $fu_audit_30['datas1'];
		$response['datas']['fu_fatal_30'] = $fu_fatal_30['datas2'];
		$response['datas']['fu_cq_30'] = $fu_cq_30['datas3'];
		$response['datas']['fu_fatalper_30'] = $fu_fatalper_30['datas4'];
		$response['datas']['fu_audit_60'] = $fu_audit_60['datas5'];
		$response['datas']['fu_fatal_60'] = $fu_fatal_60['datas6'];
		$response['datas']['fu_cq_60'] = $fu_cq_60['datas7'];
		$response['datas']['fu_fatalper_60'] = $fu_fatalper_60['datas8'];
		$response['datas']['fu_audit_90'] = $fu_audit_90['datas9'];
		$response['datas']['fu_fatal_90'] = $fu_fatal_90['datas10'];
		$response['datas']['fu_cq_90'] = $fu_cq_90['datas11'];
		$response['datas']['fu_fatalper_90'] = $fu_fatalper_90['datas12'];
		$response['datas']['fu_audit_91'] = $fu_audit_91['datas13'];
		$response['datas']['fu_fatal_91'] = $fu_fatal_91['datas14'];
		$response['datas']['fu_cq_91'] = $fu_cq_91['datas15'];
		$response['datas']['fu_fatalper_91'] = $fu_fatalper_91['datas16'];
		
		$response['datas']['wk1_audit'] = $wk1_audit['datas1'];
		$response['datas']['wk1_fatal'] = $wk1_fatal['datas2'];
		$response['datas']['wk1_cqper'] = $wk1_cqper['datas3'];
		$response['datas']['wk1_fatalper'] = $wk1_fatalper['datas4'];
		$response['datas']['wk2_audit'] = $wk2_audit['datas5'];
		$response['datas']['wk2_fatal'] = $wk2_fatal['datas6'];
		$response['datas']['wk2_cqper'] = $wk2_cqper['datas7'];
		$response['datas']['wk2_fatalper'] = $wk2_fatalper['datas8'];
		$response['datas']['wk3_audit'] = $wk3_audit['datas9'];
		$response['datas']['wk3_fatal'] = $wk3_fatal['datas10'];
		$response['datas']['wk3_cqper'] = $wk3_cqper['datas11'];
		$response['datas']['wk3_fatalper'] = $wk3_fatalper['datas12'];
		$response['datas']['wk4_audit'] = $wk4_audit['datas13'];
		$response['datas']['wk4_fatal'] = $wk4_fatal['datas14'];
		$response['datas']['wk4_cqper'] = $wk4_cqper['datas15'];
		$response['datas']['wk4_fatalper'] = $wk4_fatalper['datas16'];
		
		$response['datas']['ob_wk1_audit'] = $ob_wk1_audit['datas1'];
		$response['datas']['ob_wk1_fatal'] = $ob_wk1_fatal['datas2'];
		$response['datas']['ob_wk1_cqper'] = $ob_wk1_cqper['datas3'];
		$response['datas']['ob_wk1_fatalper'] = $ob_wk1_fatalper['datas4'];
		$response['datas']['ob_wk2_audit'] = $ob_wk2_audit['datas5'];
		$response['datas']['ob_wk2_fatal'] = $ob_wk2_fatal['datas6'];
		$response['datas']['ob_wk2_cqper'] = $ob_wk2_cqper['datas7'];
		$response['datas']['ob_wk2_fatalper'] = $ob_wk2_fatalper['datas8'];
		$response['datas']['ob_wk3_audit'] = $ob_wk3_audit['datas9'];
		$response['datas']['ob_wk3_fatal'] = $ob_wk3_fatal['datas10'];
		$response['datas']['ob_wk3_cqper'] = $ob_wk3_cqper['datas11'];
		$response['datas']['ob_wk3_fatalper'] = $ob_wk3_fatalper['datas12'];
		$response['datas']['ob_wk4_audit'] = $ob_wk4_audit['datas13'];
		$response['datas']['ob_wk4_fatal'] = $ob_wk4_fatal['datas14'];
		$response['datas']['ob_wk4_cqper'] = $ob_wk4_cqper['datas15'];
		$response['datas']['ob_wk4_fatalper'] = $ob_wk4_fatalper['datas16'];
		
		$response['datas']['fu_wk1_audit'] = $fu_wk1_audit['datas1'];
		$response['datas']['fu_wk1_fatal'] = $fu_wk1_fatal['datas2'];
		$response['datas']['fu_wk1_cqper'] = $fu_wk1_cqper['datas3'];
		$response['datas']['fu_wk1_fatalper'] = $fu_wk1_fatalper['datas4'];
		$response['datas']['fu_wk2_audit'] = $fu_wk2_audit['datas5'];
		$response['datas']['fu_wk2_fatal'] = $fu_wk2_fatal['datas6'];
		$response['datas']['fu_wk2_cqper'] = $fu_wk2_cqper['datas7'];
		$response['datas']['fu_wk2_fatalper'] = $fu_wk2_fatalper['datas8'];
		$response['datas']['fu_wk3_audit'] = $fu_wk3_audit['datas9'];
		$response['datas']['fu_wk3_fatal'] = $fu_wk3_fatal['datas10'];
		$response['datas']['fu_wk3_cqper'] = $fu_wk3_cqper['datas11'];
		$response['datas']['fu_wk3_fatalper'] = $fu_wk3_fatalper['datas12'];
		$response['datas']['fu_wk4_audit'] = $fu_wk4_audit['datas13'];
		$response['datas']['fu_wk4_fatal'] = $fu_wk4_fatal['datas14'];
		$response['datas']['fu_wk4_cqper'] = $fu_wk4_cqper['datas15'];
		$response['datas']['fu_wk4_fatalper'] = $fu_wk4_fatalper['datas16'];
		
		$response['datas']['oyo_life_booking'] = $oyo_life_booking['datas'];
			
		echo json_encode($response);
	}
	
}
?>
