<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map_l1super extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
	}


	
	public function index(){
			if(check_logged_in())
			{
				$current_user = get_user_id();
				$user_site_id= get_user_site_id();
				$user_office_id= get_user_office_id();
				$user_oth_office=get_user_oth_office();
				$is_global_access=get_global_access();
				$is_role_dir=get_role_dir();
				$get_dept_id=get_dept_id();
				
				$data["department_data"] = $this->Common_model->get_department_list();
				$data["location_data"] = $this->Common_model->get_office_location_list();
				
				$data['client_list'] = $this->Common_model->get_client_list();	
				$data['process_list'] = $this->Common_model->get_process_for_assign();
				
				$location="";
				$dept_id="";
				$client_id="";
				$process_id="";
				$l1Super="";
				$cond="";
				
				$location = $this->input->get('location');
				
				
				$data["aside_template"] = get_aside_template();
				$data["content_template"] = "map_l1super/map_l1super.php";
				
				$is_global_access=get_global_access();
				$user_oth_office=get_user_oth_office();
				$filterCond="";
				
				if($is_global_access ==1 ) $filterCond =" ";
				else $filterCond =" And (office_id='$location' OR office_id = '$user_office_id'  OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
			
				$qSql = "Select id, fusion_id, concat(fname, ' ', lname) as name from signin where status=1 and role_id not in (select id from role where folder='agent') $filterCond order by name asc ";
				
				//echo $qSql;
				
				$data["user_tlmanager"] = $this->Common_model->get_query_result_array($qSql);
				
				
				
				$data["get_user_change_list"] = array();
				
				if($this->input->get('show')=='Show')
				{
					//$location = $this->input->get('location');
					$dept_id = $this->input->get('dept_id');
					$client_id = $this->input->get('client_id');
					$process_id = $this->input->get('process_id');
					$l1Super = $this->input->get('l1Super');
					
					if($location!="") $cond .=" and office_id='$location'";
					if($dept_id!="") $cond .=" and dept_id='$dept_id'";
					
					if($client_id!="ALL" && $client_id!=""){
						if($cond=="") $cond .= " is_assign_client (id,$client_id)";
						else $cond .= " and is_assign_client (id,$client_id)";
					}
					
					if($process_id!="ALL" && $process_id!="" && $process_id!="0"){
						if($cond=="") $cond .= " is_assign_process (id,$process_id)";
						else $cond .= " and is_assign_process (id,$process_id)";
					}
					
					if($l1Super!="") $cond .=" and assigned_to='$l1Super'";
				
					$qSql="Select *, (select name from role r where r.id=role_id) as rolename, get_client_names(id) as client_name, get_process_names(id) as process_name, (select concat(fname, ' ', lname) as name from signin s where s.id=signin.assigned_to) as assigned_name, get_client_ids(id) as clientid, get_process_ids(id) as processid from signin where status=1 $cond order by id asc ";
					$data["get_user_change_list"] = $this->Common_model->get_query_result_array($qSql);
					
				}
				
			////////////////////
				$uid_array = $this->input->post('uid');
				
				$old_assigned_to_array = $this->input->post('old_assigned_to');
				$old_client_id_array = $this->input->post('old_client_id');
				$old_process_id_array = $this->input->post('old_process_id');
				
				$l1_supervisor = $this->input->post('l1_supervisor');
				$client_id = $this->input->post('client_id');
				$process_id = $this->input->post('process_id');
				$currentDate = CurrMySqlDate();
				$i=0;
				
				$logs=get_logs(); 
				
				if($this->input->post('submit')=='Move To'){
					
					foreach ($uid_array as $key => $value){
						
						if($l1_supervisor !=$old_assigned_to_array[$key]){
							$this->db->query("Update signin set assigned_to='$l1_supervisor' where id='$value'");
							$msg=" Old Value: ".$old_assigned_to_array[$key] . "";
							log_record($value,$msg,'Update L1 Supervisor',$this->input->post(),$logs);						
						}
						
						if($client_id !=$old_client_id_array[$key]){
							$this->db->query("Update info_assign_client set client_id='$client_id' where user_id='$value'");
							$msg="Old Value: ".$old_client_id_array[$key] . "";
							log_record($value,$msg,'Update Client',$this->input->post(),$logs);
						}
						
						if($process_id !=$old_process_id_array[$key]){
							$this->db->query("Update info_assign_process set process_id='$process_id' where user_id='$value'");
							$msg="Old Value: ".$old_process_id_array[$key] . "";
						
							log_record($value,$msg,'Update Process',$this->input->post(),$logs);
						}
					 
						$i++;
							
					}
					
					redirect('map_l1super');
				}
			//////////////	
				
				$data['location']=$location;
				$data['dept_id']=$dept_id;
				$data['client_id']=$client_id;
				$data['process_id']=$process_id;
				$data['l1Super']=$l1Super;
				$this->load->view('dashboard',$data);
			}
		}
		
		
		public function getUserDetails()
		{
			if(check_logged_in())
			{
				$location=$this->input->post('location');
				
				$is_global_access=get_global_access();
				$user_oth_office=get_user_oth_office();
				$user_office_id= get_user_office_id();
				$filterCond="";
				
				if($is_global_access ==1 ) $filterCond =" ";
				else $filterCond =" And (office_id='$location' OR office_id = '$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
				
				
				$qSql = "Select id, office_id,  CONCAT(fname,' ' ,lname) as name from signin where role_id in (select id from role where folder <> 'agent') and status=1 $filterCond order by name asc";
				
				//echo $qSql;
				
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}
		}
		
	
}
?>