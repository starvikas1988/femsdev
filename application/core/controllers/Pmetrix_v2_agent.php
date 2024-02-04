<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pmetrix_v2_agent extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
   	
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Pmetrix_model');
		$this->load->library('excel');
		$this->load->helper('pmetrix_helper');
		$this->load->helper('new_pmetrix_helper');
		
	 }
	 
    public function index()
    {
        if(check_logged_in()){
			$data['oValue'] = get_user_office_id();
			$data['cValue'] = get_client_ids();
			$data['pValue'] = get_process_ids();
			$data['rValue'] = get_role_dir();
			$data['tl_id'] = $this->get_tl_id();
			$data['fusion_id'] = get_user_fusion_id();
			$data['user_id'] = get_user_id();
			
			$post_period_query = $this->db->query('SELECT DISTINCT kpi_value FROM `pm_data_v2` WHERE kpi_id=588 ORDER BY kpi_value ASC');
			if($post_period_query)
			{
				$data['post_period'] = $post_period_query->result_object();
			}
			
			$data["aside_template"] = "pmetrix_v2_agent/aside.php"; //get_aside_template();
			
			//$_design = $this->Pmetrix_model->get_available_design($data['cValue'], $data['pValue'], $data['oValue']);
			
			//print($_design);
			
			//$data['table'] = $this->prepare_row();
			$data["content_template"] = "pmetrix_v2_agent/matrix_screen_agent.php";
			$data["content_js"] = "pmetrix_v2_agent/js.php";
			
			$this->load->view('dashboard',$data);
			
		}
	}
	
	public function get_tl_id()
	{
		if(check_logged_in()){
			$current_user = get_user_id();
			$query = $this->db->query('SELECT assigned_to FROM signin WHERE id="'.$current_user.'"');
			if($query)
			{
				$row = $query->row();
				return $row->assigned_to;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function prepare_row($json=false)
	{
		$form_data = $this->input->post();
		
		//print_r($form_data);
		
		if($form_data['process_id'] == 30){
			$month = substr($form_data['post_period'],4);
			$year = substr($form_data['post_period'],0,4);
			
			$start_date = $year.'-'.$month.'-01';
		
			$end_date = date("Y-m-t", strtotime($start_date));
			
			$form_data['performance_for_month'] = $start_date;
			$form_data['performance_for_year'] = $end_date;
		}
		
		$data['start_date'] = $form_data['performance_for_month'];
		$data['end_date'] = $form_data['performance_for_year'];
		
		
		if(isset($form_data['fusion_id'])){
			$query = $this->db->query('SELECT id FROM signin WHERE fusion_id="'.$form_data['fusion_id'].'"');
			$row = $query->row();
			$form_data['user_id'] = $row->id;
		}
		$data['fusion_id'] = get_user_fusion_id();
		
		if(isset($form_data['user_id'])){
			$available_design = $this->get_available_design($form_data['user_id']);
		}
		else{
			$available_design = $this->get_available_design();
		}
		
		if($available_design == false){
			$data['stat'] = false;
		}
		else{
			$data['stat'] = true;
			$data['kpi_design'] = $available_design;
			
						
			foreach($available_design as $key=>$value)
			{
				$data['kpi_col'][$value->design_id] = $this->get_kpi_column($value->design_id);
				$data['kpi_col_new'] = $this->Pmetrix_model->get_kpi_column($value->design_id);	
				
				if(isset($form_data['performance_for_year']))
				{
					$start_date = $form_data['performance_for_month'];
				
					$end_date = $form_data['performance_for_year'];
					$start_date_array = explode('-',$end_date);
					
							
					$data['kpi_data_new'] = $this->Pmetrix_model->get_kpi_data($value->design_id, $start_date,$end_date, $form_data['user_id']);	
					$data['target_new'] = $this->Pmetrix_model->get_target($value->design_id, $start_date_array[1], $start_date_array[0], $form_data['user_id']);
					$data['grade_new'] = $this->Pmetrix_model->get_grade_bucket($value->design_id, $start_date_array[1], $start_date_array[0]);
			
					$data['kpi_data'][$value->design_id] = $this->get_kpi_data($value->design_id,$start_date,$end_date,$form_data['user_id']);
					$data['qa_data'][$value->design_id] = $this->get_qa_value($value->design_id,$start_date,$end_date,$form_data['user_id']);
					//$data['everyone_kpi_data'][$value->design_id] = $this->get_everyone_kpi_data($value->design_id,$start_date,$end_date,$form_data['user_id']);
					$data['grade_bucket'][$value->design_id] = $this->get_grade_bucket($value->design_id,$form_data['user_id'],$start_date_array[0],$start_date_array[1]);
					$data['report_of'] = date('F-Y', strtotime($start_date_array[0]."-".$start_date_array[1]."-01"));
					
					$data['target'][$value->design_id] = $this->get_target($start_date_array[1],$start_date_array[0],$value->design_id,$form_data['user_id']);
					
				}
				else
				{
					$data['kpi_data_new'] = $this->Pmetrix_model->get_kpi_data($value->design_id, date('Y-m-01'),date('Y-m-t'), $form_data['user_id']);	
					$data['target_new'] = $this->Pmetrix_model->get_target(date('m'),date('Y'),$value->design_id,$form_data['user_id']);
					$data['grade_new'] = $this->Pmetrix_model->get_target->get_grade_bucket($value->design_id, date('m'), date('Y'));
					
					$data['report_of'] = date('F-Y');
					$data['kpi_data'][$value->design_id] = $this->get_kpi_data($value->design_id,date('Y-m-01'),date('Y-m-t'),$form_data['user_id']);
					$data['qa_data'][$value->design_id] = $this->get_qa_value($value->design_id,$start_date,$end_date,$form_data['user_id']);
					//$data['everyone_kpi_data'][$value->design_id] = $this->get_everyone_kpi_data($value->design_id,date('Y-m-01'),date('Y-m-t'),$form_data['user_id']);
					$data['target'][$value->design_id] = $this->get_target(date('m'),date('Y'),$value->design_id,$form_data['user_id']);
					$data['grade_bucket'][$value->design_id] = $this->get_grade_bucket($value->design_id,$form_data['user_id'],date('Y'),date('m'));
				}
			}
		}
		if($json == false)
		{
			if($form_data['process_id'] == 30 && $form_data['user_id'] != 0)
			{
				return $this->load->view('pmetrix_v2_agent/view_data_page_vrs',$data,true);
			}
			else
			{
				return $this->load->view('pmetrix_v2_agent/view_data_page',$data,true);
			}
		}
		else
		{
			if(!isset($form_data['process_id']))
			{
				$form_data['process_id'] = get_process_ids();
			}
			
			$class = $this->router->fetch_class();
			if($class == 'Pmetrix_v2_agent' && $form_data['process_id'] == 30)
			{
				echo $this->load->view('pmetrix_v2_agent/view_data_page_vrs',$data,true);
			}
			else if($form_data['process_id'] == 30 && $form_data['user_id'] != 0)
			{
				echo $this->load->view('pmetrix_v2_agent/view_data_page_vrs',$data,true);
			}
			else
			{
				echo $this->load->view('pmetrix_v2_agent/view_data_page',$data,true);
				//echo $this->load->view('pmetrix_v2_agent/more_functions',$data,true);
			}
			
		}
		$current_user = get_user_id();
		log_record($current_user,'pm_agent_view','pm',$form_data);
		pm_log_record($current_user,'pm_agent_view','pm',$form_data);
	}
	
	private function get_available_design($user_id=false)
	{
		$office_id = get_user_office_id();
		if($user_id == false)
		{
			$current_user = get_user_id();
		}
		else
		{
			$current_user = $user_id;
		}
		
		/*
		print 'SELECT pm_design_v2.id AS design_id,pm_design_v2.mp_type FROM `pm_design_v2`
			LEFT JOIN signin ON signin.id='.$current_user.'
			WHERE pm_design_v2.client_id IN (get_client_ids('.$current_user.')) 
			AND pm_design_v2.process_id IN(get_process_ids('.$current_user.')) AND pm_design_v2.office_id=signin.office_id 
			AND pm_design_v2.is_active=1';
		*/
		
		$query = $this->db->query('SELECT pm_design_v2.id AS design_id,pm_design_v2.mp_type FROM `pm_design_v2`
			LEFT JOIN signin ON signin.id='.$current_user.'
			WHERE pm_design_v2.client_id IN (get_client_ids('.$current_user.')) AND pm_design_v2.process_id IN(get_process_ids('.$current_user.')) AND pm_design_v2.office_id=signin.office_id AND pm_design_v2.is_active=1');
			
		
		
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	private function get_kpi_column($design_id)
	{
		$query = $this->db->query('SELECT pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.summ_type,pm_design_kpi_v2.summ_formula,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view FROM `pm_design_kpi_v2` WHERE pm_design_kpi_v2.did="'.$design_id.'"');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	private function get_kpi_data($design_id,$start_date,$end_date,$user_id=false)
	{
		if($user_id == false)
		{
			$current_user = get_user_id();
		}
		else
		{
			$current_user = $user_id;
		}
		$query = 'SELECT signin.fusion_id,tl.fusion_id as tl_fusion_id,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view,pm_design_kpi_v2.management_view, pm_design_kpi_v2.id as kpi_id,pm_design_kpi_v2.kpi_name,pm_data_v2.kpi_value,pm_data_v2.start_date,pm_data_v2.end_date,pm_design_kpi_v2.weightage,pm_design_kpi_v2.summ_formula,DATEDIFF(now(),signin.doj) AS tenure,pm_design_kpi_v2.summ_type,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.weightage_comp,pm_design_kpi_v2.currency FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		LEFT JOIN signin as tl ON tl.id=signin.assigned_to
		WHERE mdid="'.$design_id.'" AND user_id='.$current_user.' AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'" ORDER BY start_date ASC';
		$query = $this->db->query($query);
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	private function get_everyone_kpi_data($design_id,$start_date,$end_date,$user_id=false)
	{
		if($user_id == false)
		{
			$current_user = get_user_id();
		}
		else
		{
			$current_user = $user_id;
		}
		
		/* $query = $this->db->query('SELECT signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.weightage,pm_data_v2.kpi_value,pm_data_v2.start_date FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		WHERE mdid="'.$design_id.'" AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'"'); */
		$query = $this->db->query('SELECT signin.fusion_id,tl.fusion_id as tl_fusion_id,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view,pm_design_kpi_v2.management_view, pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.weightage,pm_data_v2.kpi_value,pm_data_v2.start_date,pm_design_kpi_v2.summ_formula,DATEDIFF(now(),signin.doj) AS tenure,pm_design_kpi_v2.currency FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		LEFT JOIN signin as tl ON tl.id=signin.assigned_to
		WHERE mdid="'.$design_id.'" AND user_id='.$current_user.' AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'"');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	private function get_grade_bucket($design_id,$user_id=false,$year,$month)
	{
		if($user_id == false)
		{
			$current_user = get_user_id();
		}
		else
		{
			$current_user = $user_id;
		}
		
		/* $query = $this->db->query('SELECT signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.weightage,pm_data_v2.kpi_value,pm_data_v2.start_date FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		WHERE mdid="'.$design_id.'" AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'"'); */
		$query = $this->db->query('SELECT * FROM `pm_grade_v2` WHERE did="'.$design_id.'" AND month="'.$month.'" AND year="'.$year.'"');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	private function get_target($month,$year,$did,$user_id=false){
		if($user_id == false) $current_user = get_user_id();
		else $current_user = $user_id;
		
		$query1 = $this->db->query('SELECT DATEDIFF(now(),signin.doj) AS tenure FROM signin WHERE signin.id="'.$current_user.'"');
		$row = $query1->row();
		if($row->tenure){
			$query = $this->db->query('SELECT pm_target_v2.did,pm_target_v2.target,pm_target_v2.year,pm_target_v2.month,pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view,pm_design_kpi_v2.currency FROM `pm_target_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_target_v2.pm_design_kpi_id WHERE month="'.$month.'" AND year="'.$year.'" AND tenure_bucket_start <= '.$row->tenure.' AND tenure_bucket_end >= '.$row->tenure.' AND pm_target_v2.did="'.$did.'"');
		}
		else{
			$query = $this->db->query('SELECT m_target_v2.did,pm_target_v2.target,pm_target_v2.year,pm_target_v2.month,pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view,pm_design_kpi_v2.currency FROM `pm_target_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_target_v2.pm_design_kpi_id WHERE month="'.$month.'" AND year="'.$year.'" AND tenure_bucket_start <= 90 AND tenure_bucket_end >= 180 AND pm_target_v2.did="'.$did.'"');
		}
		if($query){
			$result = $query->result_object();
			return $result;
		}
		else return false;
	}
	
	private function get_qa_value($did,$start_date,$end_date,$user_id=false)
	{
		if($user_id == false)
		{
			$current_user = get_user_id();
		}
		else
		{
			$current_user = $user_id;
		}
		$query = $this->db->query('SELECT signin.fusion_id,v_qa_score.overall_score,DATE(audit_date) AS audit_date FROM `v_qa_score`
		LEFT JOIN signin ON signin.id=v_qa_score.agent_id
		LEFT JOIN pm_design_v2 ON CONCAT(pm_design_v2.client_id,"",pm_design_v2.process_id)=CONCAT(v_qa_score.client_id,"",v_qa_score.process_id)
		WHERE pm_design_v2.id="'.$did.'" AND agent_id="'.$current_user.'" AND audit_date >= "'.$start_date.'" AND audit_date <= "'.$end_date.'" ORDER by audit_date');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	public function check_old_target()
	{
		$year = date('Y');
		$month = date('m');
		
		$last_year = date("Y", strtotime("-1 months"));
		$last_month = date("m", strtotime("-1 months"));
		
		$next_year = date("Y", strtotime("+1 months"));
		$next_month = date("m", strtotime("+1 months"));
		
		$query = $this->db->query('SELECT * FROM `pm_target_v2` WHERE month="'.$month.'" AND year="'.$year.'"');
		if($query)
		{
			if($query->num_rows() == 0)
			{
				$query = $this->db->query('INSERT INTO pm_target_v2(month, year, tenure_bucket_start, tenure_bucket_end,target, pm_design_kpi_id, did) SELECT "'.$month.'","'.$year.'",pm_target_v2.tenure_bucket_start,pm_target_v2.tenure_bucket_end,pm_target_v2.target,pm_target_v2.pm_design_kpi_id,pm_target_v2.did FROM pm_target_v2 WHERE month="'.$last_month.'" AND year="'.$last_year.'"');
			}
		}
	}
	
	public function get_bouns_info()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT * FROM pm_vrs_bonus WHERE pay_period="'.$form_data['pay_period'].'" AND  fems_id="'.$form_data['fusion_id'].'" AND post_period="'.$form_data['post_period'].'"');
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
	public function process_bonus()
	{
		$form_data = $this->input->post();
		
		$query = $this->db->query('UPDATE pm_vrs_bonus SET supervisor_comment="'.$form_data['supervisor_comment'].'", agent_comment="'.$form_data['agent_comment'].'", om_comment="'.$form_data['om_comment'].'", accepted_status="1", accepted_on=now() WHERE pay_period="'.$form_data['pay_period'].'" AND  fems_id="'.$form_data['fusion_id'].'" AND post_period="'.$form_data['post_period'].'"');
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
}