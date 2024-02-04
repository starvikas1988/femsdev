<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		
	 }
	 
    public function index()
    {
        if(check_logged_in()){
				
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$omuid=get_user_omuid();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = "evaluation/aside.php";
            $data["content_template"] = "evaluation/job_performance_self.php";
			$data["error"]="";
			
			$qSql="Select a.*,fusion_id,fname,lname,dept_id,office_id,site_id,role_id,process_id,sub_process_id,(Select shname from client c where c.id=b.client_id) as client_name,(Select name from process p where p.id=b.process_id) as process_name,(Select name from sub_process sp where sp.id=b.sub_process_id) as sub_process_name,(Select shname from department d where d.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from site s  where s.id=b.site_id) as site_name,(Select name from role r  where r.id=b.role_id) as role_name from job_performance_evaluation a, signin b where a.user_id=b.id and user_id='$current_user' order by evaluation_date";
						
			$data["perform_list"]=$perform_list =$this->Common_model->get_query_result_array($qSql);
			if (count($perform_list)<=0) redirect(base_url()."evaluation/evaluation_self");
			$this->load->view('dashboard',$data);
			
		}
    }
	
	
	public function evaluate_list()
    {
        if(check_logged_in()){
		
		
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$data["role_dir"]=$role_dir;
			$data["role_id"]=$role_id;
						
			$epValue = trim($this->input->post('evaluation_period'));
			if($epValue=="") $epValue = trim($this->input->get('evaluation_period'));
			
			$sidValue = trim($this->input->post('status_id'));
			if($sidValue=="") $sidValue = trim($this->input->get('status_id'));
			if($sidValue=="") $sidValue=1;
			
			$dValue = trim($this->input->post('dept_id'));
			if($dValue=="") $dValue = trim($this->input->get('dept_id'));
			
			$sdValue = trim($this->input->post('sub_dept_id'));
			if($sdValue=="") $sdValue = trim($this->input->get('sub_dept_id'));
			
			$rValue = trim($this->input->post('role_id'));
			if($rValue=="") $rValue = trim($this->input->get('role_id'));
			
			if($dValue=="") $dValue=$ses_dept_id;
			
			$data['epValue']=$epValue;
			$data['sidValue']=$sidValue;
			$data['dValue']=$dValue;
			$data['sdValue']=$sdValue;
			$data['rValue']=$rValue;
			
			$data['department_list'] = $this->Common_model->get_department_list();
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
			
			if(get_role_dir()=="super" || get_role_dir()=="admin"){
				
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super') ORDER BY name";	
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			
			}else if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
			
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				
			}else{
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			}
			
			$qSql="Select evaluation_period as value,evaluation_period as text from job_performance_evaluation group by evaluation_period order by evaluation_period";
			$data["period_list"]= $this->Common_model->get_query_result_array($qSql);
						
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = "evaluation/aside.php";
            $data["content_template"] = "evaluation/job_performance_list.php";
			$data["error"]="";
			
			$cond="";
			
			if($role_dir=="manager")	$cond=" and office_id='$user_office_id'";
			else if($role_dir=="trainer" || $role_dir=="tl")	$cond=" and assigned_to='$current_user'";
			
			$cond .=" and user_id!='$current_user'";
						
			if($epValue!="ALL" && $epValue!="") $cond .= " And evaluation_period='".$epValue."'";
			if($sidValue!="ALL" && $sidValue!=""){
				
				if($sidValue==1) $cond .= " And evaluated_by is null and review_by is null ";
				else if($sidValue==2) $cond .= " And evaluated_by is not null and review_by is null ";
				else if($sidValue==3) $cond .= " And review_by is not null ";
			}
			
			if($dValue!="ALL" && $dValue!="") $cond .= " And dept_id='".$dValue."'";
			if($sdValue!="ALL" && $sdValue!="") $cond .= " And sub_dept_id='".$sdValue."'";
			if($rValue!="ALL" && $rValue!="") $cond .= " And role_id='".$rValue."'";
			
			
			$qSql="Select a.*,fusion_id,fname,lname,dept_id,office_id,site_id,role_id,process_id,sub_process_id,(Select shname from client c where c.id=b.client_id) as client_name,(Select name from process p where p.id=b.process_id) as process_name,(Select name from sub_process sp where sp.id=b.sub_process_id) as sub_process_name,(Select shname from department d where d.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from site s  where s.id=b.site_id) as site_name,(Select name from role r  where r.id=b.role_id) as role_name from job_performance_evaluation a, signin b where a.user_id=b.id $cond order by evaluation_date";
			
			//echo $qSql;
			
			$data["perform_list"]=$perform_list =$this->Common_model->get_query_result_array($qSql);
						
			$this->load->view('dashboard',$data);
			        
		}
    }
	
public function evaluate()
{
	if(check_logged_in())
        {
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$omuid=get_user_omuid();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$eid = trim($this->input->get('eid'));
						
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = "evaluation/aside.php";
			
            $data["content_template"] = "evaluation/evaluate.php";
			$data["error"]="";
			
			if($this->input->post('submit')=="Save")
			{
				
				$peid = trim($this->input->post('eid'));
				$user_id = trim($this->input->post('user_id'));
				
				$knowledge_work = trim($this->input->post('knowledge_work'));
				$planning_organizing = trim($this->input->post('planning_organizing'));
				$customer_relations = $this->input->post('customer_relations');
				$quality_work = $this->input->post('quality_work'); 
				$quantity_work = trim($this->input->post('quantity_work'));				
				$dependability = trim($this->input->post('dependability')); 
				
				$responsibility = trim($this->input->post('responsibility'));
				$self_initiative = trim($this->input->post('self_initiative'));
				
				$teamwork = trim($this->input->post('teamwork'));
				
				$safety = trim($this->input->post('safety')); 
				$personal_appearance = trim($this->input->post('personal_appearance'));
				
				$leadership = trim($this->input->post('leadership')); 
				$communication = trim($this->input->post('communication')); 
								
				$problem_solving = trim($this->input->post('problem_solving'));
				
				$employee_strengths = trim($this->input->post('employee_strengths'));
				$improvement_areas = trim($this->input->post('improvement_areas'));
				$improvement_plan = trim($this->input->post('improvement_plan'));
				$job_description_review = trim($this->input->post('job_description_review'));
				$modified_job_desc = trim($this->input->post('modified_job_desc'));
				$evaluator_comments = trim($this->input->post('evaluator_comments'));
				$evaluated_date = CurrMySqlDate();
								
				$_field_array = array(
					"knowledge_work" => $knowledge_work,
					"planning_organizing" => $planning_organizing,
					"customer_relations" => $customer_relations,
					"quality_work" => $quality_work,
					"quantity_work" => $quantity_work,
					"dependability" => $dependability,
					"responsibility" => $responsibility,
					"self_initiative" => $self_initiative,
					"teamwork" => $teamwork,
					"safety" => $safety,
					"personal_appearance" => $personal_appearance,
					"leadership" => $leadership,
					"communication" => $communication,
					"problem_solving" => $problem_solving,
					"employee_strengths" => $employee_strengths,
					"improvement_areas" => $improvement_areas,
					"improvement_plan" => $improvement_plan,
					"job_description_review" => $job_description_review,
					"modified_job_desc" => $modified_job_desc,
					"evaluator_comments" => $evaluator_comments,
					"evaluated_date" => $evaluated_date,
					"evaluated_by" => $current_user
				); 
				
				$where = array('id ' => $peid , 'user_id ' => $user_id);
				$this->db->where($where);
				$this->db->update('job_performance_evaluation',$_field_array );
				
				if($this->db->affected_rows()>0){
				
						$qSql="select fusion_id,CONCAT(fname,' ' ,lname) as full_name from signin where id='$user_id'";
						$query = $this->db->query($qSql);
						$uRow=$query->row_array();
						
						$fusion_id=$uRow["fusion_id"];
						$full_name=$uRow["full_name"];
								
						$Lfull_name=get_username();
						$LOFid=get_user_fusion_id();
						
						$LogMSG="Evaluated The Job Performance of $full_name ($fusion_id) ";
						log_message('FEMS', $LOFid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
				}
			
				//redirect(base_url()."evaluation/view_job_performance?eid=".base64_encode($peid));
				redirect(base_url()."evaluation/evaluate_list");
				
			}
						
			if($eid!=""){
				$eid=base64_decode($eid);
				
					$qSql="Select a.*,fusion_id,fname,lname,dept_id,office_id,site_id,role_id,process_id,sub_process_id,(Select shname from client c where c.id=b.client_id) as client_name,(Select name from process p where p.id=b.process_id) as process_name,(Select name from sub_process sp where sp.id=b.sub_process_id) as sub_process_name,(Select shname from department d where d.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from site s  where s.id=b.site_id) as site_name,(Select name from role r  where r.id=b.role_id) as role_name,(Select CONCAT(fname,' ' ,lname) from signin x where x.id=a.evaluated_by) as evaluated_name,(Select CONCAT(fname,' ' ,lname) from signin y where y.id=a.review_by) as review_name from job_performance_evaluation a, signin b where a.user_id=b.id and a.id='$eid'";
					
					//echo $qSql;
					
					$data["row"]=$this->Common_model->get_query_row_array($qSql);
				
			}else{
				$data["row"]=array();
			}
			
			$this->load->view('dashboard',$data);	
        }
 }
 
 
 
 public function review()
{
	
	if(check_logged_in())
        {
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$omuid=get_user_omuid();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$eid = trim($this->input->get('eid'));
						
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = "evaluation/aside.php";
            $data["content_template"] = "evaluation/review.php";
			$data["error"]="";
			
			if($this->input->post('submit')=="Save")
			{
				
				$peid = trim($this->input->post('eid'));
				$user_id = trim($this->input->post('user_id'));
				
				$reviewer_comments = trim($this->input->post('reviewer_comments'));
				$review_date = CurrMySqlDate();

				$_field_array = array(
					"reviewer_comments" => $reviewer_comments,
					"review_date" => $review_date,
					"review_by" => $current_user
				); 
				
				$where = array('id ' => $peid , 'user_id ' => $user_id);
				$this->db->where($where);
				$this->db->update('job_performance_evaluation',$_field_array );
				
				if($this->db->affected_rows()>0){
				
						$qSql="select fusion_id,CONCAT(fname,' ' ,lname) as full_name from signin where id='$user_id'";
						$query = $this->db->query($qSql);
						$uRow=$query->row_array();
						
						$fusion_id=$uRow["fusion_id"];
						$full_name=$uRow["full_name"];
								
						$Lfull_name=get_username();
						$LOFid=get_user_fusion_id();
						
						$LogMSG="Reviewed The Job Performance of $full_name ($fusion_id) ";
						log_message('FEMS', $LOFid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
				}
				
				//redirect(base_url()."evaluation/view_job_performance?eid=".base64_encode($peid));
				redirect(base_url()."evaluation/evaluate_list");
				
			}
						
			if($eid!=""){
				$eid=base64_decode($eid);
				
					$qSql="Select a.*,fusion_id,fname,lname,dept_id,office_id,site_id,role_id,process_id,sub_process_id,(Select shname from client c where c.id=b.client_id) as client_name,(Select name from process p where p.id=b.process_id) as process_name,(Select name from sub_process sp where sp.id=b.sub_process_id) as sub_process_name,(Select shname from department d where d.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from site s  where s.id=b.site_id) as site_name,(Select name from role r  where r.id=b.role_id) as role_name,(Select CONCAT(fname,' ' ,lname) from signin x where x.id=a.evaluated_by) as evaluated_name,(Select CONCAT(fname,' ' ,lname) from signin y where y.id=a.review_by) as review_name from job_performance_evaluation a, signin b where a.user_id=b.id and a.id='$eid'";
					
					//echo $qSql;
					
					$data["row"]=$this->Common_model->get_query_row_array($qSql);
				
			}else{
				$data["row"]=array();
			}
			
			$this->load->view('dashboard',$data);	
        }
 }
 
	
	
	
 
 public function view_job_performance()
{
	
	if(check_logged_in())
        {
			$current_user = get_user_id();
			
			$user_site_id= get_user_site_id();
			$omuid=get_user_omuid();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();

			$eid = trim($this->input->get('eid'));
					
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = "evaluation/aside.php";
			
            $data["content_template"] = "evaluation/view_job_performance.php";
			$data["error"]="";
			
			if($eid!=""){
			
				$eid=base64_decode($eid);
				
				$qSql="Select a.*,fusion_id,fname,lname,dept_id,office_id,site_id,role_id,process_id,sub_process_id,(Select shname from client c where c.id=b.client_id) as client_name,(Select name from process p where p.id=b.process_id) as process_name,(Select name from sub_process sp where sp.id=b.sub_process_id) as sub_process_name,(Select shname from department d where d.id=b.dept_id) as dept_name,(Select name from sub_department sd where sd.id=b.sub_dept_id) as sub_dept_name,(Select name from site s  where s.id=b.site_id) as site_name,(Select name from role r  where r.id=b.role_id) as role_name,(Select CONCAT(fname,' ' ,lname) from signin x where x.id=a.evaluated_by) as evaluated_name,(Select CONCAT(fname,' ' ,lname) from signin y where y.id=a.review_by) as review_name from job_performance_evaluation a, signin b where a.user_id=b.id and a.id='$eid'";
				
				//echo $qSql;
				
				$data["row"]=$this->Common_model->get_query_row_array($qSql);
			}else{
				$data["row"]=array();
			}
			
			$this->load->view('dashboard',$data);	
        }
 }
 
 
public function evaluation_self()
{
		if(check_logged_in())
        {
			$current_user = get_user_id();
			$user_site_id= get_user_site_id();
			$omuid=get_user_omuid();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = "evaluation/aside.php";
			
            $data["content_template"] = "evaluation/evaluation_self.php";
			$data["error"]="";
			
			if(get_role_dir()=="super") redirect(base_url()."evaluation/evaluate_list");
			
			if($this->input->post('submit')=="Save")
            {
                  
				$_run = false;  
				
				$log=get_logs();
				
				$evaluation_month = trim($this->input->post('evaluation_month'));
				$evaluation_year = trim($this->input->post('evaluation_year'));
				
				$evaluation_period=$evaluation_month." ".$evaluation_year;
				
				$qSql="Select count(id) as value from job_performance_evaluation Where user_id = '$current_user' and evaluation_period='$evaluation_period'";
				$is_period_entry = $this->Common_model->get_single_value($qSql);
				if($is_period_entry==0){
				
						$evaluation_date = mmddyy2mysql(trim($this->input->post('evaluation_date')));
			
						$knowledge_work_self = trim($this->input->post('knowledge_work_self'));
						$planning_organizing_self = trim($this->input->post('planning_organizing_self'));
						$customer_relations_self = $this->input->post('customer_relations_self');
						$quality_work_self = $this->input->post('quality_work_self'); 
						$quantity_work_self = trim($this->input->post('quantity_work_self'));				
						$dependability_self = trim($this->input->post('dependability_self')); 
						
						$responsibility_self = trim($this->input->post('responsibility_self'));
						$self_initiative_self = trim($this->input->post('self_initiative_self'));
						
						$teamwork_self = trim($this->input->post('teamwork_self'));
						
						$safety_self = trim($this->input->post('safety_self')); 
						$personal_appearance_self = trim($this->input->post('personal_appearance_self'));
						
						$leadership_self = trim($this->input->post('leadership_self')); 
						$communication_self = trim($this->input->post('communication_self')); 
										
						$problem_solving_self = trim($this->input->post('problem_solving_self'));
						
						$comments_self = trim($this->input->post('comments_self'));
						
						$inserted_date = CurrMySqlDate();

						$_field_array = array(
							"user_id" => $current_user,
							"evaluation_period" => $evaluation_period,
							"evaluation_date" => $evaluation_date,
							"knowledge_work_self" => $knowledge_work_self,
							"planning_organizing_self" => $planning_organizing_self,
							"customer_relations_self" => $customer_relations_self,
							"quality_work_self" => $quality_work_self,
							"quantity_work_self" => $quantity_work_self,
							"dependability_self" => $dependability_self,
							"responsibility_self" => $responsibility_self,
							"self_initiative_self" => $self_initiative_self,
							"teamwork_self" => $teamwork_self,
							"safety_self" => $safety_self,
							"personal_appearance_self" => $personal_appearance_self,
							"leadership_self" => $leadership_self,
							"communication_self" => $communication_self,
							"problem_solving_self" => $problem_solving_self,
							"comments_self" => $comments_self,
							"inserted_date" => $inserted_date,
							"log" => $log,
							
						); 
										
						$row_id = data_inserter('job_performance_evaluation',$_field_array);
						
						if($row_id!==false)
						{
						
							//////////LOG////////
							
							$Lfull_name=get_username();
							$LOFid=get_user_fusion_id();
							
							$LogMSG="$Lfull_name ($LOFid) added his/her Job Performance Evaluation of $evaluation_period ";
							log_message('FEMS', $LOFid.' - ' . $Lfull_name . ' | '.$LogMSG );
										
							//////////
			
						   //$this->session->set_flashdata("error",show_msgbox("Job Performance Evaluation Added Successfully",false));
						   redirect(base_url()."evaluation");
						   
						}else $data['error'] = show_msgbox('Job Performance Evaluation Failed',true);
				
				}else{
				
						$data['error'] = show_msgbox('You already submited the "Job Performance Evaluation Form" of '.$evaluation_period,true);
						
				
				}
				
			 }
			   
			$this->load->view('dashboard',$data);
        }
	}
	
   
}

?>