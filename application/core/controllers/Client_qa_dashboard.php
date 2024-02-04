<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_qa_dashboard extends CI_Controller {
    
     	
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
			$client_id=get_clients_client_id();
			$process_id=get_clients_process_id();
			$office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_associate_dashboard/qa_associate_dashboard.php";
			$data["content_js"] = "qa_dashboard_associate/qa_associate_dashboard_js.php";
			$data['location_list'] 		= 	array();
			$data['process_list']		=	array();
			$data['manager_list']		=	array();
			$data['l1_super']			=	array();
			$data['agent_list']			=	array();
			
			$data['from_date'] = "";
			$data['to_date'] = "";
			$data['process_list'] = array();
			
			//$qSql="SELECT * FROM office_location where abbr =(select office_id from signin_client where id='$current_user') ORDER BY office_name";
			$qSql="SELECT * FROM office_location where (select office_id from signin_client where id='$current_user') like CONCAT('%',abbr,'%')  ORDER BY office_name";
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql	=	"SELECT p.id AS pro_id,p.name AS process_name FROM qa_defect AS q
						INNER JOIN process AS p ON p.id=q.process_id WHERE p.id in ( $process_id )";
			$process_arr1	=	$this->Common_model->get_query_result_array($qSql);
			
			
			 $NotINnqSql	=	"( SELECT p.id FROM qa_defect AS q
						INNER JOIN process AS p ON p.id=q.process_id WHERE p.id in ( $process_id ) )";
			
			$qSql	=	"SELECT q.process_id AS pro_id,q.table_name AS process_name from qa_defect AS q 
						INNER JOIN process AS p ON p.id = FLOOR(q.process_id) WHERE p.id in ( $process_id ) and q.process_id not in $NotINnqSql ";
			$process_arr2	=	$this->Common_model->get_query_result_array($qSql);
			 
			$marge_array=array_merge($process_arr1,$process_arr2);
			
			$data['process_list']	=	$marge_array;
			 
			$data["current_user"]	=	$current_user;
			$data["client_id"]		=	$client_id;
			//$data["process_id"]		=	$process_id;
			$data["office_id"]		=	$office_id;
			$data["role"]			=	get_role_dir();
			$this->load->view('dashboard',$data);
		}
	}
	public function ajax_get_managers()
	{
		$office_id		=	$this->input->post("office_id");
		$process_id 	= 	$this->input->post("process_id");
		$current_user	=	get_user_id();
		$data['managers'] = array();
		if($office_id != '' && $process_id != '')
		{
			if(get_role_dir() == "agent")
			{
				$managerSql	=	"Select m.id, m.fusion_id, m.fname, m.lname, m.dept_id , p.name AS process_name,d.shname AS dept_name FROM signin AS m
				INNER JOIN signin AS t ON t.assigned_to=m.id
				INNER JOIN signin AS a ON a.assigned_to=t.id
				INNER JOIN role AS r ON r.id=m.role_id
				INNER JOIN info_assign_process AS ap ON ap.user_id=m.id
				INNER JOIN process AS p ON p.id=ap.process_id
				INNER JOIN department AS d ON d.id=m.dept_id
				WHERE a.id='".$current_user."' AND r.folder='agent' And m.status in (1,3,4,5,6,7) ";
			}
			elseif(get_role_dir() == "tl")
			{
				$managerSql	=	"Select m.id, m.fusion_id, m.fname, m.lname, m.dept_id , p.name AS process_name,d.shname AS dept_name FROM signin AS m
				INNER JOIN signin AS t ON t.assigned_to=m.id
				INNER JOIN role AS r ON r.id=m.role_id
				INNER JOIN info_assign_process AS ap ON ap.user_id=m.id
				INNER JOIN process AS p ON p.id=ap.process_id
				INNER JOIN department AS d ON d.id=m.dept_id
				WHERE t.id='".$current_user."' AND r.folder='tl' And m.status in (1,3,4,5,6,7)  ";
			}
			else
			{
				if($office_id == 'ALL')
				{
					$managerSql	=	"SELECT signin.id, fusion_id, fname, lname, dept_id , p.name AS process_name,d.shname AS dept_name FROM signin 
					INNER JOIN role AS r ON r.id=signin.role_id
					INNER JOIN info_assign_process AS ap ON ap.user_id=signin.id
					INNER JOIN process AS p ON p.id=ap.process_id
					INNER JOIN department AS d ON d.id=signin.dept_id
					WHERE r.folder='manager' AND signin.status in (1,3,4,5,6,7)  AND p.id='".floor($process_id)."' ORDER BY signin.fname,signin.lname";
				}
				else
				{
					$managerSql	=	"SELECT signin.id, fusion_id, fname, lname, dept_id , p.name AS process_name,d.shname AS dept_name FROM signin 
					INNER JOIN role AS r ON r.id=signin.role_id
					INNER JOIN info_assign_process AS ap ON ap.user_id=signin.id
					INNER JOIN process AS p ON p.id=ap.process_id
					INNER JOIN department AS d ON d.id=signin.dept_id
					WHERE office_id='".$office_id."' AND r.folder='manager' AND signin.status in (1,3,4,5,6,7) AND p.id='".floor($process_id)."' ORDER BY signin.fname,signin.lname";
				}
			}
			$data['managers'] = $this->Common_model->get_query_result_array($managerSql);
		}
		echo json_encode($data);
	}
	
	public function ajax_get_tl_supervisor()
	{
		$office_id	=	$this->input->post("office_id");
		$process_id	=	$this->input->post("process_id");
		$manager_id	=	$this->input->post("manager_id");
		$current_user	=	get_user_id();
		$data['tl_supers'] = array();
		if($manager_id != '')
		{
			if(get_role_dir() == "agent")
			{
				
			}
			elseif(get_role_dir() == "tl")
			{
				$tlSql	=	"SELECT signin.*, r.name AS roleName FROM signin
				INNER JOIN role AS r ON r.id=signin.role_id
				WHERE signin.id='".$current_user."' AND signin.status in (1,3,4,5,6,7) ";
			}
			elseif($manager_id != "")
			{
				$tlSql	=	"SELECT signin.*, r.name AS roleName FROM signin
				INNER JOIN role AS r ON r.id=signin.role_id
				WHERE assigned_to='".$manager_id."' AND r.folder='tl' AND signin.status in (1,3,4,5,6,7) ORDER BY signin.fname,signin.lname";
			}
		}
		elseif($manager_id == "")
		{
			$tlSql	=	"SELECT signin.*, r.name AS roleName FROM signin
			INNER JOIN role AS r ON r.id=signin.role_id
			INNER JOIN info_assign_process AS ap ON ap.user_id=signin.id
			INNER JOIN process AS p ON p.id=ap.process_id
			WHERE signin.office_id='".$office_id."' AND p.id='".$process_id."' AND r.folder='tl' AND signin.status in (1,3,4,5,6,7) ORDER BY signin.fname,signin.lname";
		}
						
		$data['tl_supers'] = $this->Common_model->get_query_result_array($tlSql);
		echo json_encode($data);
	}
	public function ajax_get_agents()
	{
		$tl_id	=	$this->input->post("tl_id");
		$data['agents'] = array();
		if($tl_id != '')
		{
			$qSql	=	"SELECT * FROM signin WHERE assigned_to='$tl_id' AND signin.status in (1,3,4,5,6,7) ORDER BY signin.fname,signin.lname";
			$data['agents'] = $this->Common_model->get_query_result_array($qSql);
		}
		echo json_encode($data);
	}
	public function ajax_qa_score()
	{
		$form_data		=	$this->input->post();
		$current_user	=	get_user_id();

		$query = $this->db->query('SELECT defect_columns,table_name,defect_column_names,process.name as process_name FROM `qa_defect` LEFT JOIN process ON process.id='.$form_data['process_id'].' WHERE FIND_IN_SET('.$form_data['process_id'].',process_id)');
		$row = $query->row();
		$csat_process_score = $this->get_csat_process_score($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		$nps_process_score = $this->get_nps_process_score($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		$mtd_process_score = $this->get_mtd_process_score($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		$process_mtd_no_of_audit = $this->get_process_mtd_no_of_audit($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		
		$wtd_score_30 = $this->get_wtd_score_30($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		$mtd_score_30 = $this->get_mtd_score_30($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		
		$wtd_score_60 = $this->get_wtd_score_60($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		$mtd_score_60 = $this->get_mtd_score_60($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		
		$wtd_score_90 = $this->get_wtd_score_90($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		$mtd_score_90 = $this->get_mtd_score_90($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		
		$wtd_score_above = $this->get_wtd_score_above($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		$mtd_score_above = $this->get_mtd_score_above($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		
		//$mtd_no_of_audit = $this->get_mtd_no_of_audit($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		//$mtd_score = $this->get_mtd_score($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		
		//$wtd_no_of_audit = $this->get_wtd_no_of_audit($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		//$wtd_score = $this->get_wtd_score($row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		
		$defects = $this->get_own_defected($form_data['process_id'],$row->table_name,$row->process_name,$form_data['office_id'],$form_data['manager_id'],$form_data['tl_id'],$form_data['agent_id']);
		
		$response['datas']['csat_process_score'] 		= $csat_process_score['datas'];
		$response['datas']['nps_process_score'] 		= $nps_process_score['datas'];
		$response['datas']['mtd_process_score'] 		= $mtd_process_score['datas'];
		$response['datas']['process_mtd_no_of_audit'] 	= $process_mtd_no_of_audit['datas'];
		
		$response['datas']['wtd_score_30'] 				= $wtd_score_30['datas'];
		$response['datas']['mtd_score_30'] 				= $mtd_score_30['datas'];
		
		$response['datas']['wtd_score_60'] 				= $wtd_score_60['datas'];
		$response['datas']['mtd_score_60'] 				= $mtd_score_60['datas'];
		
		$response['datas']['wtd_score_90'] 				= $wtd_score_90['datas'];
		$response['datas']['mtd_score_90'] 				= $mtd_score_90['datas'];
		
		$response['datas']['wtd_score_above'] 			= $wtd_score_above['datas'];
		$response['datas']['mtd_score_above'] 			= $mtd_score_above['datas'];
		
		//$response['datas']['mtd_no_of_audit'] 			= $mtd_no_of_audit['datas'];
		//$response['datas']['mtd_score'] 				= $mtd_score['datas'];
		
		//$response['datas']['wtd_no_of_audit'] 			= $wtd_no_of_audit['datas'];
		//$response['datas']['wtd_score'] 				= $wtd_score['datas'];

		$response['datas']['defects'] 					= $defects['datas'];
		echo json_encode($response);
		
	}
	//////////VOC//////////
	private function get_csat_process_score($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$csat_4_5_sql = "";
		$csat_4_5_sql .= "SELECT count(agent_id) as value, signin.office_id from ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$csat_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$csat_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$csat_4_5_sql .= " WHERE voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$csat_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS m ON m.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND m.id='".$manager_id."' AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$csat_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS m ON m.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND m.id='".$manager_id."' AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$csat_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS m ON m.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND m.id='".$manager_id."' AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		if($location != "ALL")
		{
			$csat_4_5_sql .= " AND signin.office_id='".$location."'";
		}
		
		$csat_4_5_arr = $this->Common_model->get_query_result_array($csat_4_5_sql);
		
		$tot_4_5_sql	=	"SELECT count(agent_id) as value from ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$tot_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$tot_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$tot_4_5_sql .=	" WHERE audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$tot_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS m ON m.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND m.id='".$manager_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$tot_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS m ON m.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND m.id='".$manager_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$tot_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS m ON m.id=tl.assigned_to
				WHERE m.id='".$manager_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		if($location != "ALL")
		{
			$tot_4_5_sql .=	" AND signin.office_id='".$location."'";
		}
		$tot_audit_arr = $this->Common_model->get_query_result_array($tot_4_5_sql);
		if(!empty($tot_audit_arr)){
			$tot_audit = 0;
			$csat_4_5 = 0;
			foreach($tot_audit_arr as $tc)
			{
				$tot_audit += $tc["value"];
			}
			foreach($csat_4_5_arr as $cv)
			{
				$csat_4_5 += $cv["value"];
			}
			if($tot_audit>0)
			{
				$csat_scr = ($csat_4_5 / $tot_audit) * 100;
			}
			else
			{
				$csat_scr =	0;
			}
		}else{
			$csat_scr=0;
		}
		
		if($csat_scr > 0){
			$response['datas'] = number_format($csat_scr,2);
		}else{
			$response['datas'] = 0;
		}
		return $response;
	}
	private function get_nps_process_score($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$csat_4_5_sql = "";
		$csat_4_5_sql .= "SELECT count(agent_id) as value, signin.office_id from ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$csat_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
			WHERE tl.id='".$tl_id."'  AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$csat_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
			WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."'  AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$csat_4_5_sql .= " WHERE voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$csat_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$csat_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."'  AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$csat_4_5_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."'  AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		if($location != "ALL")
		{
			$csat_4_5_sql .=  " AND signin.office_id='".$location."'";
		}
		$csat_4_5_arr = $this->Common_model->get_query_result_array($csat_4_5_sql);
		$csat_4_5 = 0;
		if(!empty($csat_4_5_arr)){
			foreach($csat_4_5_arr as $cv)
			{
				$csat_4_5 += $cv["value"];
			}
		}
		
		$csat_1_2_sql = "";
		$csat_1_2_sql .= "SELECT count(agent_id) as value, signin.office_id from ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$csat_1_2_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND voc in (1,2) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$csat_1_2_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND voc in (1,2) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$csat_1_2_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE voc in (1,2) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$csat_1_2_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND voc in (1,2) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$csat_1_2_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND voc in (1,2) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$csat_1_2_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."' AND voc in (1,2) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		if($location != "ALL")
		{
			$csat_1_2_sql	.=	" AND signin.office_id='".$location."'";
		}
		$csat_1_2_arr = $this->Common_model->get_query_result_array($csat_1_2_sql);
		$tot_audit_sql	=	"SELECT count(agent_id) as value FROM ".$table." INNER JOIN signin ON signin.id=agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$tot_audit_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$tot_audit_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$tot_audit_sql .=	" WHERE audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$tot_audit_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$tot_audit_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$tot_audit_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		if($location != "ALL")
		{
			$tot_audit_sql .=	" AND signin.office_id='".$location."'";
		}
		$tot_audit_arr = $this->Common_model->get_query_result_array($tot_audit_sql);
		$nps_scr=0;
		if(!empty($tot_audit_arr)){
			$tot_audit = 0;
			$csat_1_2 = 0;
			foreach($tot_audit_arr as $tc)
			{
				$tot_audit += $tc["value"];
			}
			foreach($csat_1_2_arr as $cv)
			{
				$csat_1_2 += $cv["value"];
			}
			if($tot_audit !=0)
			{
				$nps_scr = (($csat_4_5 - $csat_1_2) / $tot_audit) * 100;
			}
		}
		if($nps_scr != ""){
			$response['datas'] = number_format($nps_scr,2);
		}else{
			$response['datas'] = 0;
		}
		return $response;
	}
	//////////VOC Ends////////////
	/////////Over All Score///////
	private function get_mtd_process_score($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$mtd_sql	=	"SELECT AVG(".$table.".overall_score) AS avg_process_score,signin.office_id FROM ".$table.
		 " INNER JOIN signin ON signin.id=".$table.".agent_id ";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$mtd_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$mtd_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$mtd_sql .=	" WHERE voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$mtd_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."'  AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$mtd_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."'  AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$mtd_sql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."'  AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		if($location != "ALL")
		{
			$mtd_sql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($mtd_sql);
		
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	private function get_process_mtd_no_of_audit($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$qSql="SELECT COUNT(*) AS own_mtd_no_of_audit, signin.office_id FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$qSql	.=	" WHERE voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."'  AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."'  AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
			else
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."'  AND voc in (4,5) AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
			}
		}
		if($location != "ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
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
	private function get_wtd_score_30($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		$qSql	=	"SELECT AVG(overall_score) AS avg_process_score FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)  AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)  AND WEEK(audit_date,1)='".$week."'";
			}
			else
			{
				$qSql	.=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)  AND WEEK(audit_date,1)='".$week."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)  AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)  AND WEEK(audit_date,1)='".$week."'";
			}
			else
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)  AND WEEK(audit_date,1)='".$week."'";
			}

		}
		if($location !="ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0 )
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	private function get_mtd_score_30($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');

		$qSql	="SELECT AVG(overall_score) AS avg_process_score FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)";
			}
			else
			{
				$qSql	.=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)";
			}
			else
			{
				$qSql	.=	" INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 0 AND DATEDIFF('".$from_date."', signin.doj) <= 30)";
			}
		}
		if($location != "ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	private function get_wtd_score_60($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		$qSql	=	"SELECT AVG(overall_score) AS avg_process_score FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)  AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)  AND WEEK(audit_date,1)='".$week."'";
			}
			else
			{
				$qSql	.=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)  AND WEEK(audit_date,1)='".$week."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)  AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)  AND WEEK(audit_date,1)='".$week."'";

			}
			else
			{
				$qSql	.=	" INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)  AND WEEK(audit_date,1)='".$week."'";
			}
		}
		if($location != "ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	
	private function get_mtd_score_60($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		$qSql	=	"SELECT AVG(overall_score) AS avg_process_score FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)";
			}
			else
			{
				$qSql	.=	" WHERE signin.office_id='".$location."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)";
			}
			else
			{
				$qSql	.=	" INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 31 AND DATEDIFF('".$from_date."', signin.doj) <= 60)";
			}
		}
		if($location != "ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	private function get_wtd_score_90($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$qSql	= "SELECT AVG(overall_score) AS avg_process_score FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)  AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)  AND WEEK(audit_date,1)='".$week."'";
			}
			else
			{
				$qSql	.=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)  AND WEEK(audit_date,1)='".$week."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)  AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)  AND WEEK(audit_date,1)='".$week."'";
			}
			else
			{
				$qSql	.=	" INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)  AND WEEK(audit_date,1)='".$week."'";
			}
		}
		if($location != "ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	
	private function get_mtd_score_90($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$qSql = "SELECT AVG(overall_score) AS avg_process_score FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)";
			}
			else
			{
				$qSql	.=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)";
			}
			else
			{
				$qSql	.=	" INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 61 AND DATEDIFF('".$from_date."', signin.doj) <= 90)";
			}
		}
		if($location != "ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	private function get_wtd_score_above($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$qSql	= "SELECT AVG(overall_score) AS avg_process_score FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)  AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)  AND WEEK(audit_date,1)='".$week."'";
			}
			else
			{
				$qSql	.=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)  AND WEEK(audit_date,1)='".$week."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)  AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)  AND WEEK(audit_date,1)='".$week."'";
			}
			else
			{
				$qSql	.=	" INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)  AND WEEK(audit_date,1)='".$week."'";
			}
		}
		if($location != "ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	
	private function get_mtd_score_above($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		$qSql = "SELECT AVG(overall_score) AS avg_process_score FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND signin.office_id='".$location."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND signin.office_id='".$location."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)";
			}
			else
			{
				$qSql	.=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."'  AND signin.office_id='".$location."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."'  AND signin.office_id='".$location."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)";
			}
			else
			{
				$qSql	.=	" INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND (DATEDIFF('".$from_date."', signin.doj) >= 91)";
			}
		}
		if($location != "ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	/*private function get_mtd_score($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$qSql	=	"SELECT AVG(overall_score) AS avg_process_score FROM ".$table." LEFT JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."'";
			}
			else
			{
				$qSql .=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."'";
			}
		}
		if($location !="ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0 )
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	}*/
	/*private function get_mtd_no_of_audit($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		$qSql	=	"SELECT COUNT(*) AS mtd_no_of_audit FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."'";
			}
			else
			{
				$qSql	.=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."'";
			}
		}
		if($location !="ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
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
	}*/
	/*private function get_wtd_score($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		
		$qSql	=	"SELECT AVG(overall_score) AS avg_process_score FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
			}
			else
			{
				$qSql	.=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
			}
		}
		if($location != "ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
		if($query)
		{
			$row = $query->row();
			$response['stat'] = true;
			if($query->num_rows() > 0)
			{
				$response['datas'] = number_format($row->avg_process_score,2);
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
	}*/
	/*private function get_wtd_no_of_audit($table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		$qSql = "SELECT COUNT(*) AS wtd_no_of_audit FROM ".$table." INNER JOIN signin ON signin.id=".$table.".agent_id";
		if($manager_id == "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
			}
			else
			{
				$qSql .=	" WHERE YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
			}
		}
		elseif($manager_id != "")
		{
			if($tl_id != "" && $agent_id == "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
			}
			elseif($tl_id != "" && $agent_id != "")
			{
				$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
				INNER JOIN signin AS manager ON manager.id=tl.assigned_to
				WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
			}
		}
		if($location !="ALL")
		{
			$qSql .=	" AND signin.office_id='".$location."'";
		}
		$query = $this->db->query($qSql);
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
	}*/
	private function get_own_defected($process_id,$table,$process_name,$location,$manager_id,$tl_id,$agent_id)
	{
		$current_user = get_user_id();
		$from_date		=	mmddyy2mysql($this->input->post("from_date"));
		$to_date		=	mmddyy2mysql($this->input->post("to_date"));
		$date = new DateTime(date($from_date));
		$year = $date->format('Y');
		$month = $date->format('m');
		$week = $date->format('W');
		$qSql =	'SELECT defect_columns,table_name,defect_column_names,process.name as process_name FROM `qa_defect` LEFT JOIN process ON process.id='.$process_id.' WHERE FIND_IN_SET('.$process_id.',process_id)';
		$query = $this->db->query($qSql);
		$row = $query->row();
			
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
			$qSql	=	"SELECT ".$row->defect_columns.", signin.office_id FROM ".$row->table_name." INNER JOIN signin ON signin.id=".$table.".agent_id";
			if($manager_id == "")
			{
				if($tl_id != "" && $agent_id == "")
				{
					$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
					INNER JOIN signin AS manager ON manager.id=tl.assigned_to
					WHERE tl.id='".$tl_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
					
					//AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
				}
				elseif($tl_id != "" && $agent_id != "")
				{
					$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
					INNER JOIN signin AS manager ON manager.id=tl.assigned_to
					WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
					//AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
				}
				else
				{
					$qSql	.=	" WHERE audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
							//YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
				}
			}
			elseif($manager_id != "")
			{
				if($tl_id != "" && $agent_id == "")
				{
					$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
					INNER JOIN signin AS manager ON manager.id=tl.assigned_to
					WHERE tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
					//AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
				}
				elseif($tl_id != "" && $agent_id != "")
				{
					$qSql .= " INNER JOIN signin AS tl ON tl.id=signin.assigned_to
					INNER JOIN signin AS manager ON manager.id=tl.assigned_to
					WHERE ".$table.".agent_id='".$agent_id."' AND tl.id='".$tl_id."' AND manager.id='".$manager_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
					//AND YEAR(audit_date) = '".$year."' AND MONTH(audit_date) = '".$month."' AND WEEK(audit_date,1)='".$week."'";
				}
				else
				{
					$qSql	.=	" INNER JOIN signin AS tl ON tl.id=signin.assigned_to
					INNER JOIN signin AS manager ON manager.id=tl.assigned_to
					WHERE manager.id='".$manager_id."' AND audit_date >= '".$from_date."' AND audit_date <= '".$to_date."'";
				}
			}
			if($location != "ALL")
			{
				$qSql .=	" AND signin.office_id='".$location."'";
			}
			$defect_query = $this->db->query($qSql);

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
}
?>