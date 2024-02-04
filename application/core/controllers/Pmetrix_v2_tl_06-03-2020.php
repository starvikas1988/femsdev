<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pmetrix_v2_tl extends CI_Controller {
    
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
			
			//FKOL002152//FKOL002543w4et werter
			
			$current_user = get_user_id();
			$data['oValue'] = get_user_office_id();
			$data['cValue'] = get_client_ids();
			$data['pValue'] = get_process_ids();
			$data['rValue'] = get_role_dir();
			$is_global_access=get_global_access();
			
			if(strpos($_SERVER['HTTP_REFERER'], 'Pmetrix_v2_management') !== false)
				$data["aside_template"] = "pmetrix_v2_management/aside.php";
			else 
				$data["aside_template"] = "pmetrix_v2_tl/aside.php";
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			$data['client_list'] =array();
			$data['process_list'] =array();
			$process_ids = get_process_ids();
			
			//$data['table'] = $this->prepare_row();
			$data["content_template"] = "pmetrix_v2_tl/matrix_screen_agent_wise.php";
			$data["content_js"] = "pmetrix_v2_tl/js.php";
			$this->load->view('dashboard',$data);
		}
	}
	
	public function get_process_tl()
	{
		$form_data = $this->input->post();
		
		$qSql='SELECT signin.id,signin.fname,signin.lname FROM `signin` 
				LEFT JOIN role ON role.id=signin.role_id
				WHERE is_assign_process(signin.id,'.$form_data['process_id'].') AND signin.office_id="'.$form_data['office_id'].'" AND role.folder="tl" AND signin.status="1"';
		
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
	
	public function get_agent_list()
	{
		$form_data = $this->input->post();
		$current_user = get_user_id();
		$query_array = array();
		if($form_data['view_type'] == 2)
		{
			$query_array[] = 'signin.assigned_to ="'.$form_data['others_team'].'"';
		}
		else
		{
			$query_array[] = 'signin.assigned_to ="'.$current_user.'"';
		}
		if($form_data['search_type'] == 2)
		{
			$query_array[] = 'signin.fusion_id ="'.$form_data['agent_fusion_id'].'"';
		}
		$qSql = 'SELECT signin.id,signin.fname,signin.lname,signin.fusion_id FROM `signin` LEFT JOIN info_assign_process ON info_assign_process.user_id=signin.id LEFT JOIN role_organization ON role_organization.id=signin.org_role_id WHERE office_id="'.$form_data['office_id'].'" AND info_assign_process.process_id="'.$form_data['process_id'].'" AND role_organization.controller="agent" AND signin.status=1 AND '.implode(' AND ',$query_array).'';
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
	public function indv_prepare_row()
	{
		$form_data = $this->input->post();
		$data['fusion_id'] = $form_data['fusion_id'];
		$query = $this->db->query('SELECT id FROM signin WHERE fusion_id="'.$form_data['fusion_id'].'"');
		$row = $query->row();
		$user_id = $row->id;
		$available_design = $this->get_available_design_user($user_id);
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
				$start_date = $form_data['performance_for_year'].'-'.$form_data['performance_for_month'].'-01';
				$a_date = $start_date;
				$end_date = date("Y-m-t", strtotime($a_date));
				$data['kpi_data'][$value->design_id] = $this->get_kpi_data($value->design_id,$start_date,$end_date,$user_id);
				$data['qa_data'][$value->design_id] = $this->get_qa_value($value->design_id,$start_date,$end_date,$user_id);
				
				
				$data['everyone_kpi_data'][$value->design_id] = $this->get_everyone_kpi_data($value->design_id,$start_date,$end_date,$user_id);
				$data['everyone_qa_data'][$value->design_id] = $this->get_qa_everyone_value($value->design_id,$start_date,$end_date,$user_id);
				
				$data['grade_bucket'][$value->design_id] = $this->get_grade_bucket($value->design_id,$form_data['performance_for_year'],$form_data['performance_for_month']);
				$data['report_of'] = date('F-Y', strtotime($form_data['performance_for_year']."-".$form_data['performance_for_month']."-01"));
				$data['target'][$value->design_id] = $this->get_target($form_data['performance_for_month'],$form_data['performance_for_year'],$value->design_id,$user_id);
				
			}
		}
		//$current_user = get_user_id();
		//log_record($current_user,'pm_agent_view','pm',$form_data);
		echo $this->load->view('pmetrix_v2_tl/view_data_page_agentwise_daily',$data,true);
	}
	public function prepare_row($json=false)
	{
		$form_data = $this->input->post();
		$data['fusion_id'] = $form_data['fusion_id'];
		$user_id = $form_data['user_id'];
		$current_user = get_user_id();
		if($user_id == 0)
		{
			//$available_design = $this->get_available_design(get_user_id(),$form_data['process_id']);
			//$available_design = $this->get_available_design($form_data);
			$available_design = $this->get_available_design($form_data);
			//print_r($available_design);
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
					$start_date = $form_data['performance_for_year'].'-'.$form_data['performance_for_month'].'-01';
					$a_date = $start_date;
					$end_date = date("Y-m-t", strtotime($a_date));
					$data['kpi_col'][$value->design_id] = $this->get_kpi_column($value->design_id);
					$data['kpi_data'][$value->design_id] = $this->get_kpi_data($value->design_id,$start_date,$end_date,$user_id,true);
					$data['qa_data'][$value->design_id] = $this->get_qa_value($value->design_id,$start_date,$end_date,$user_id,true);
					if($form_data['view_type'] == 2)
					{
						$agents = $this->get_available_agent_list($value->design_id,$start_date,$end_date,$form_data['others_team']);
					}
					else
					{
						$agents = $this->get_available_agent_list($value->design_id,$start_date,$end_date,$current_user);
					}
					$data['agents'][$value->design_id] = $agents;
					$data['grade_bucket'][$value->design_id] = $this->get_grade_bucket($value->design_id,$form_data['performance_for_year'],$form_data['performance_for_month']);
					foreach($agents as $ke=>$val)
					{
						$data['target'][$value->design_id][$val->fusion_id] = $this->get_target($form_data['performance_for_month'],$form_data['performance_for_year'],$value->design_id,$val->user_id);
					}
					/* echo '<pre>';
					print_r($data['target'][$value->design_id]);
					echo '</pre>'; */
				}
			}
		}
		else
		{
			//$available_design = $this->get_available_design($user_id);
			$available_design = $this->get_available_design($form_data);
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
					$start_date = $form_data['performance_for_year'].'-'.$form_data['performance_for_month'].'-01';
					$a_date = $start_date;
					$end_date = date("Y-m-t", strtotime($a_date));
					$data['kpi_data'][$value->design_id] = $this->get_kpi_data($value->design_id,$start_date,$end_date,$user_id);
					$data['qa_data'][$value->design_id] = $this->get_qa_value($value->design_id,$start_date,$end_date,$user_id);
					
					$data['everyone_kpi_data'][$value->design_id] = $this->get_everyone_kpi_data($value->design_id,$start_date,$end_date,$user_id);
					$data['everyone_qa_data'][$value->design_id] = $this->get_qa_everyone_value($value->design_id,$start_date,$end_date,$user_id);
					
					$data['grade_bucket'][$value->design_id] = $this->get_grade_bucket($value->design_id,$form_data['performance_for_year'],$form_data['performance_for_month']);
					$data['report_of'] = date('F-Y', strtotime($form_data['performance_for_year']."-".$form_data['performance_for_month']."-01"));
					$data['target'][$value->design_id] = $this->get_target($form_data['performance_for_month'],$form_data['performance_for_year'],$value->design_id,$user_id);
					
				}
			}
		}
		
		
		
		if($json == false)
		{
			return $this->load->view('pmetrix_v2_tl/view_data_page',$data,true);
		}
		else
		{
			if($user_id != 0)
			{
				echo $this->load->view('pmetrix_v2_tl/view_data_page',$data,true);
			}
			else
			{
				echo $this->load->view('pmetrix_v2_tl/view_data_page_agentwise_all_agent',$data,true);
			}
		}
		$current_user = get_user_id();
		log_record($current_user,'pm_tl_agent_view','pm',$form_data);
	}
	
	/* private function get_available_design($current_user,$process_id=false)
	{
		if($process_id == false)
		{
			$query = $this->db->query('SELECT pm_design_v2.id AS design_id,pm_design_v2.mp_type FROM `pm_design_v2`
			WHERE client_id IN (get_client_ids('.$current_user.')) AND process_id IN(get_process_ids('.$current_user.')) AND office_id="'.$office_id.'" AND is_active=1');
		}
		else
		{
			
			$query = $this->db->query('SELECT pm_design_v2.id AS design_id,pm_design_v2.mp_type FROM `pm_design_v2`
			WHERE process_id="'.$process_id.'" AND is_active=1');
		}
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	} */
	private function get_available_design_user($current_user)
	{
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
	private function get_available_design($form_data=false)
	{
		if(!isset($form_data['client_id']))
		{
			$form_data['client_id'] = get_client_ids();
		}
		if(!isset($form_data['office_id']))
		{
			$form_data['office_id'] = get_user_office_id();
		}
		$query = $this->db->query('SELECT pm_design_v2.id AS design_id,pm_design_v2.mp_type FROM `pm_design_v2`
			WHERE process_id="'.$form_data['process_id'].'" AND client_id="'.$form_data['client_id'].'" AND office_id="'.$form_data['office_id'].'" AND is_active=1');
		
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
	private function get_qa_value($did,$start_date,$end_date,$current_user,$all_user=false)
	{
		if($all_user == false)
		{
			$query = $this->db->query('SELECT tl.fusion_id as tl_fusion_id,signin.fusion_id,v_qa_score.overall_score,DATE(audit_date) AS audit_date FROM `v_qa_score`
			LEFT JOIN signin ON signin.id=v_qa_score.agent_id
			LEFT JOIN signin as tl ON tl.id=signin.assigned_to
			LEFT JOIN pm_design_v2 ON CONCAT(pm_design_v2.client_id,"",pm_design_v2.process_id)=CONCAT(v_qa_score.client_id,"",v_qa_score.process_id)
			WHERE pm_design_v2.id="'.$did.'"  AND signin.id='.$current_user.' AND audit_date >= "'.$start_date.'" AND audit_date <= "'.$end_date.'" ORDER by audit_date');
		}
		else
		{
			$query = $this->db->query('SELECT tl.fusion_id as tl_fusion_id,signin.fusion_id,v_qa_score.overall_score,DATE(audit_date) AS audit_date FROM `v_qa_score`
			LEFT JOIN signin ON signin.id=v_qa_score.agent_id
			LEFT JOIN signin as tl ON tl.id=signin.assigned_to
			LEFT JOIN pm_design_v2 ON CONCAT(pm_design_v2.client_id,"",pm_design_v2.process_id)=CONCAT(v_qa_score.client_id,"",v_qa_score.process_id)
			WHERE pm_design_v2.id="'.$did.'"  AND audit_date >= "'.$start_date.'" AND audit_date <= "'.$end_date.'" ORDER by audit_date');
		}
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	private function get_kpi_data($design_id,$start_date,$end_date,$current_user,$all_user=false)
	{
		if($all_user == false)
		{
			$query = $this->db->query('SELECT signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_data_v2.kpi_value,pm_data_v2.start_date,pm_design_kpi_v2.weightage,pm_design_kpi_v2.summ_formula
			
			,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.summ_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view,pm_design_kpi_v2.management_view,pm_design_kpi_v2.weightage_comp,pm_design_kpi_v2.currency
			
			FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		WHERE mdid="'.$design_id.'" AND user_id='.$current_user.' AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'"');
		} 
		else
		{
			$query = $this->db->query('SELECT signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_data_v2.kpi_value,pm_data_v2.start_date,pm_design_kpi_v2.weightage,pm_design_kpi_v2.summ_formula
			
			,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.summ_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view,pm_design_kpi_v2.management_view,pm_design_kpi_v2.weightage_comp,pm_design_kpi_v2.currency
			
			FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		WHERE mdid="'.$design_id.'" AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'"');
		}
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	private function get_everyone_kpi_data($design_id,$start_date,$end_date,$current_user)
	{
		
		/* $query = $this->db->query('SELECT signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.weightage,pm_data_v2.kpi_value,pm_data_v2.start_date FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		WHERE mdid="'.$design_id.'" AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'"'); */
		$query = $this->db->query('SELECT signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.weightage,pm_data_v2.kpi_value,pm_data_v2.start_date,pm_design_kpi_v2.weightage,pm_design_kpi_v2.summ_formula
		
		,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.summ_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view,pm_design_kpi_v2.management_view,pm_design_kpi_v2.weightage_comp
		,pm_design_kpi_v2.currency
		FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
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
	private function get_qa_everyone_value($did,$start_date,$end_date,$current_user)
	{
		$query = $this->db->query('SELECT tl.fusion_id as tl_fusion_id,signin.fusion_id,v_qa_score.overall_score,DATE(audit_date) AS audit_date FROM `v_qa_score`
		LEFT JOIN signin ON signin.id=v_qa_score.agent_id
		LEFT JOIN signin as tl ON tl.id=signin.assigned_to
		LEFT JOIN pm_design_v2 ON CONCAT(pm_design_v2.client_id,"",pm_design_v2.process_id)=CONCAT(v_qa_score.client_id,"",v_qa_score.process_id)
		WHERE pm_design_v2.id="'.$did.'"  AND signin.id='.$current_user.' AND audit_date >= "'.$start_date.'" AND audit_date <= "'.$end_date.'" ORDER by audit_date');
		
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	private function get_grade_bucket($design_id,$year,$month)
	{
		$current_user = get_user_id();
		
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
	
	private function get_target($month,$year,$did,$current_user)
	{
		$query1 = $this->db->query('SELECT DATEDIFF(now(),signin.doj) AS tenure FROM signin WHERE signin.id="'.$current_user.'"');
		$row = $query1->row();
		//echo 'SELECT pm_target_v2.target,pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view FROM `pm_target_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_target_v2.pm_design_kpi_id WHERE month="'.$month.'" AND year="'.$year.'" AND tenure_bucket_start <= '.$row->tenure.' AND tenure_bucket_end >= '.$row->tenure.' AND pm_target_v2.did="'.$did.'"<br>';
		if($row->tenure)
		{
			$query = $this->db->query('SELECT pm_target_v2.target,pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view FROM `pm_target_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_target_v2.pm_design_kpi_id WHERE month="'.$month.'" AND year="'.$year.'" AND tenure_bucket_start <= '.$row->tenure.' AND tenure_bucket_end >= '.$row->tenure.' AND pm_target_v2.did="'.$did.'"');
		}
		else
		{
			$query = $this->db->query('SELECT pm_target_v2.target,pm_design_kpi_v2.kpi_name,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view FROM `pm_target_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_target_v2.pm_design_kpi_id WHERE month="'.$month.'" AND year="'.$year.'" AND tenure_bucket_start <= 90 AND tenure_bucket_end >= 180 AND pm_target_v2.did="'.$did.'"');
		}
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	private function get_available_agent_list($did,$start_date,$end_date,$current_user)
	{
		$query = $this->db->query('SELECT user_id,signin.fusion_id,signin.fname,signin.lname FROM pm_data_v2 LEFT JOIN signin ON signin.id=pm_data_v2.user_id WHERE pm_data_v2.mdid="'.$did.'" AND start_date >= "'.$start_date.'" AND end_date <="'.$end_date.'" and signin.assigned_to="'.$current_user.'" group by user_id');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	
	public function tl()
	{
		if(check_logged_in()){
			
			$is_global_access=get_global_access();
			
			//FKOL002152//FKOL002543
			$current_user = get_user_id();
			$data['oValue'] = get_user_office_id();
			$data['cValue'] = get_client_ids();
			$data['pValue'] = get_process_ids();
			$data['rValue'] = get_role_dir();
			
			if(strpos($_SERVER['HTTP_REFERER'], 'Pmetrix_v2_management') !== false)
				$data["aside_template"] = "pmetrix_v2_management/aside.php";
			else 
				$data["aside_template"] = "pmetrix_v2_tl/aside.php";
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			$data['client_list'] =array();
			$data['process_list'] =array();
			$process_ids = get_process_ids();
			
			//$data['table'] = $this->prepare_row();
			$data["content_template"] = "pmetrix_v2_tl/matrix_screen_tl_wise.php";
			$data["content_js"] = "pmetrix_v2_tl/tl_js.php";
			$this->load->view('dashboard',$data);
		}
	}
	
	public function prepare_tl_row()
	{
		$form_data = $this->input->post();
		$current_user = get_user_id();
		//$available_design = $this->get_available_design(get_user_id(),$form_data['process_id']);
		$available_design = $this->get_available_design($form_data);
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
				$start_date = $form_data['performance_for_month'];
				
				$end_date = $form_data['performance_for_year'];
				$start_date_array = explode('-',$end_date);
				
				
				$data['kpi_col'][$value->design_id] = $this->get_kpi_column($value->design_id);
				$data['tl_kpi_data'][$value->design_id] = $this->get_tl_kpi_data($value->design_id,$start_date,$end_date,$current_user);
				$data['processs_kpi_data'][$value->design_id] = $this->get_kpi_data_same_process($value->design_id,$start_date,$end_date,$current_user);
				
				$data['qa_data'][$value->design_id] = $this->get_tl_qa_value($value->design_id,$start_date,$end_date,$current_user);
				$data['processs_qa_data'][$value->design_id] = $this->get_tl_qa_value_same_process($value->design_id,$start_date,$end_date,$current_user);
				
				$agents = $this->get_available_agent_list_for_tl($value->design_id,$start_date,$end_date,$current_user);
				$data['agents'][$value->design_id] = $agents;
				$data['grade_bucket'][$value->design_id] = $this->get_grade_bucket($value->design_id,$start_date_array[0],$start_date_array[1]);
				foreach($agents as $ke=>$val)
				{
					$data['target'][$value->design_id][$val->fusion_id] = $this->get_target($start_date_array[1],$start_date_array[0],$value->design_id,$val->user_id);
				}
			}
			
		}
		$current_user = get_user_id();
		log_record($current_user,'pm_tl_tl_view','pm',$form_data);
		echo $this->load->view('pmetrix_v2_tl/view_data_page_tl',$data,true);
	}
	
	private function get_tl_kpi_data($design_id,$start_date,$end_date,$tl_id)
	{
		$query = $this->db->query('SELECT tl.fusion_id as tl_fusion_id,tl.fname as tl_fname,tl.lname as tl_lname,signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_data_v2.kpi_value,pm_data_v2.start_date,pm_design_kpi_v2.weightage,pm_design_kpi_v2.summ_formula,signin.fname as agent_fname,signin.lname as agent_lname
		
		,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.summ_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view,pm_design_kpi_v2.management_view,pm_design_kpi_v2.weightage_comp
		,pm_design_kpi_v2.currency
		FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		LEFT JOIN signin as tl ON tl.id=signin.assigned_to
		WHERE mdid="'.$design_id.'" AND signin.assigned_to='.$tl_id.' AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'"');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	private function get_kpi_data_same_process($design_id,$start_date,$end_date,$tl_id)
	{
		$query = $this->db->query('SELECT tl.fusion_id as tl_fusion_id,tl.fname as tl_fname,tl.lname as tl_lname,signin.fusion_id, pm_design_kpi_v2.kpi_name,pm_data_v2.kpi_value,pm_data_v2.start_date,pm_design_kpi_v2.weightage,pm_design_kpi_v2.summ_formula,signin.fname as agent_fname,signin.lname as agent_lname
		
		,pm_design_kpi_v2.kpi_type,pm_design_kpi_v2.summ_type,pm_design_kpi_v2.agent_view,pm_design_kpi_v2.tl_view,pm_design_kpi_v2.management_view,pm_design_kpi_v2.weightage_comp
		,pm_design_kpi_v2.currency
		FROM `pm_data_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_data_v2.kpi_id
		LEFT JOIN signin ON signin.id=pm_data_v2.user_id
		LEFT JOIN signin as tl ON tl.id=signin.assigned_to
		WHERE mdid="'.$design_id.'" AND signin.assigned_to !='.$tl_id.' AND start_date >= "'.$start_date.'" AND end_date <= "'.$end_date.'"');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	private function get_available_agent_list_for_tl($did,$start_date,$end_date,$tl_id)
	{
		$query = $this->db->query('SELECT tl.fusion_id as tl_fusion_id,tl.fname as tl_fname,tl.lname as tl_lname,user_id,signin.fusion_id,signin.fname,signin.lname FROM pm_data_v2 LEFT JOIN signin ON signin.id=pm_data_v2.user_id 
		LEFT JOIN signin as tl ON tl.id=signin.assigned_to
		WHERE pm_data_v2.mdid="'.$did.'" AND start_date >= "'.$start_date.'" AND end_date <="'.$end_date.'" group by user_id');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	private function get_tl_qa_value_same_process($did,$start_date,$end_date,$tl_id)
	{
		$current_user = get_user_id();
		$query = $this->db->query('SELECT tl.fusion_id as tl_fusion_id,signin.fusion_id,v_qa_score.overall_score,DATE(audit_date) AS audit_date FROM `v_qa_score`
		LEFT JOIN signin ON signin.id=v_qa_score.agent_id
		LEFT JOIN signin as tl ON tl.id=signin.assigned_to
		LEFT JOIN pm_design_v2 ON CONCAT(pm_design_v2.client_id,"",pm_design_v2.process_id)=CONCAT(v_qa_score.client_id,"",v_qa_score.process_id)
		WHERE pm_design_v2.id="'.$did.'" AND signin.assigned_to !='.$tl_id.' AND audit_date >= "'.$start_date.'" AND audit_date <= "'.$end_date.'" ORDER by audit_date');
		if($query)
		{
			return $query->result_object();
		}
		else
		{
			return false;
		}
	}
	private function get_tl_qa_value($did,$start_date,$end_date,$tl_id)
	{
		$current_user = get_user_id();
		$query = $this->db->query('SELECT tl.fusion_id as tl_fusion_id,signin.fusion_id,v_qa_score.overall_score,DATE(audit_date) AS audit_date FROM `v_qa_score`
		LEFT JOIN signin ON signin.id=v_qa_score.agent_id
		LEFT JOIN signin as tl ON tl.id=signin.assigned_to
		LEFT JOIN pm_design_v2 ON CONCAT(pm_design_v2.client_id,"",pm_design_v2.process_id)=CONCAT(v_qa_score.client_id,"",v_qa_score.process_id)
		WHERE pm_design_v2.id="'.$did.'"  AND signin.assigned_to='.$tl_id.' AND audit_date >= "'.$start_date.'" AND audit_date <= "'.$end_date.'" ORDER by audit_date');
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
		
		$query = $this->db->query('SELECT * FROM `pm_target_v2` WHERE did=53 and month="'.$month.'" AND year="'.$year.'"');
		if($query)
		{
			if($query->num_rows() == 0)
			{
				echo 'fdf';
				/* $query = $this->db->query('INSERT INTO pm_target_v2(month, year, tenure_bucket_start, tenure_bucket_end,target, pm_design_kpi_id, did) SELECT "'.$month.'","'.$year.'",pm_target_v2.tenure_bucket_start,pm_target_v2.tenure_bucket_end,pm_target_v2.target,pm_target_v2.pm_design_kpi_id,pm_target_v2.did FROM pm_target_v2 WHERE did=53 and month="'.$last_month.'" AND year="'.$last_year.'"');
				if($query)
				{
					echo 'ok';
				} */
			}
		}
	}
}