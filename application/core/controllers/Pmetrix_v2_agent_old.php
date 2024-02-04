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
		$this->load->library('excel');
		
	 }
	 
    public function index()
    {
        if(check_logged_in()){
			
			
			$data["aside_template"] = "pmetrix_v2_agent/aside.php"; //get_aside_template();
			//echo $current_user = get_user_id();
			
			$data['table'] = $this->prepare_row();
			$data["content_template"] = "pmetrix_v2_agent/matrix_screen_agent.php";
			$data["content_js"] = "pmetrix_v2_agent/js.php";
			
			$this->load->view('dashboard',$data);
			
		}
	}
	
	public function prepare_row($json=false)
	{
		$form_data = $this->input->post();
		$data['fusion_id'] = get_user_fusion_id();
		$available_design = $this->get_available_design();
		if($available_design == false)
		{
			$data['stat'] = false;
		}
		else
		{
			$data['stat'] = true;
			$data['kpi_design'] = $available_design;
			foreach($available_design as $key=>$value)
			{
				$data['kpi_col'][$value->design_id] = $this->get_kpi_column($value->design_id);
				if(isset($form_data['performance_for_year']))
				{
					$start_date = $form_data['performance_for_year'].'-'.$form_data['performance_for_month'].'-01';
					$a_date = $start_date;
					$end_date = date("Y-m-t", strtotime($a_date));
					$data['kpi_data'][$value->design_id] = $this->get_kpi_data($value->design_id,$start_date,$end_date);
					$data['qa_data'][$value->design_id] = $this->get_qa_value($value->design_id,$start_date,$end_date);
					$data['everyone_kpi_data'][$value->design_id] = $this->get_everyone_kpi_data($value->design_id,$start_date,$end_date);
					$data['grade_bucket'][$value->design_id] = $this->get_grade_bucket($value->design_id);
					$data['report_of'] = date('F-Y', strtotime($form_data['performance_for_year']."-".$form_data['performance_for_month']."-01"));
					$data['target'][$value->design_id] = $this->get_target($form_data['performance_for_month'],$form_data['performance_for_year'],$value->design_id);
				}
				else
				{
					$data['report_of'] = date('F-Y');
					$data['kpi_data'][$value->design_id] = $this->get_kpi_data($value->design_id,date('Y-m-01'),date('Y-m-t'));
					$data['qa_data'][$value->design_id] = $this->get_qa_value($value->design_id,$start_date,$end_date);
					$data['everyone_kpi_data'][$value->design_id] = $this->get_everyone_kpi_data($value->design_id,date('Y-m-01'),date('Y-m-t'));
					$data['target'][$value->design_id] = $this->get_target(date('m'),date('Y'),$value->design_id);
					$data['grade_bucket'][$value->design_id] = $this->get_grade_bucket($value->design_id);
				}
			}
		}
		if($json == false)
		{
			return $this->load->view('pmetrix_v2_agent/view_data_page',$data,true);
		}
		else
		{
			echo $this->load->view('pmetrix_v2_agent/view_data_page',$data,true);
		}
		$current_user = get_user_id();
		log_record($current_user,'pm_agent_view','pm',$form_data);
	}
	
	private function get_available_design()
	{
		$current_user = get_user_id();
		$query = $this->db->query('SELECT pm_design_v2.id AS design_id,pm_design_v2.mp_type FROM `pm_design_v2`
		WHERE client_id IN (get_client_ids('.$current_user.')) AND process_id IN(get_process_ids('.$current_user.')) AND is_active=1');
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
	
	private function get_kpi_data($design_id,$start_date,$end_date)
	{
		$current_user = get_user_id();
		$query = $this->db->query('SELECT signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_data_v2.kpi_value,pm_data_v2.start_date,pm_design_kpi_v2.weightage,pm_design_kpi_v2.summ_formula FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
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
	
	private function get_everyone_kpi_data($design_id,$start_date,$end_date)
	{
		$current_user = get_user_id();
		
		/* $query = $this->db->query('SELECT signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.weightage,pm_data_v2.kpi_value,pm_data_v2.start_date FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		WHERE mdid="'.$design_id.'" AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'"'); */
		$query = $this->db->query('SELECT signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.weightage,pm_data_v2.kpi_value,pm_data_v2.start_date,pm_design_kpi_v2.summ_formula FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
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
	
	private function get_grade_bucket($design_id)
	{
		$current_user = get_user_id();
		
		/* $query = $this->db->query('SELECT signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.weightage,pm_data_v2.kpi_value,pm_data_v2.start_date FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		WHERE mdid="'.$design_id.'" AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'"'); */
		$query = $this->db->query('SELECT * FROM `pm_grade_v2` WHERE did="'.$design_id.'"');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	private function get_target($month,$year,$did)
	{
		$current_user = get_user_id();
		$query1 = $this->db->query('SELECT DATEDIFF(now(),signin.doj) AS tenure FROM signin WHERE signin.id="'.$current_user.'"');
		$row = $query1->row();
		
		$query = $this->db->query('SELECT pm_target_v2.target,pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view FROM `pm_target_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_target_v2.pm_design_kpi_id WHERE month="'.$month.'" AND year="'.$year.'" AND tenure_bucket_start <= '.$row->tenure.' AND tenure_bucket_end >= '.$row->tenure.' AND pm_target_v2.did="'.$did.'"');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	private function get_qa_value($did,$start_date,$end_date)
	{
		$current_user = get_user_id();
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
}