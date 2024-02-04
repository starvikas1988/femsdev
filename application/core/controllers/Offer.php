<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends CI_Controller {

    private $aside = "offer/aside.php";

    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		
	 }
	 
    public function index()
    {
				
        if(check_logged_in())
        {
						
			$role_id = get_role_id();
			$current_user = get_user_id();
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$is_global_access=get_global_access();
			
			$data["role_dir"]=$role_dir;
			
			$data['policy_list'] =array();
				
				$client_id = "";
				$office_id = "";
				$func_id = "";
				$search_text="";
				
				$dn_link="";
								
				//if($this->input->get('showReports')=='Show')
				//{
										
					//$client_id = $this->input->get('client_id');
					
					$office_id = $this->input->get('office_id');
					if($office_id=="")  $office_id=$user_office_id;
					
					$func_id = $this->input->get('function_id');
					if($func_id=="" && $is_global_access == 0 ){
						
						$qSql="select id as value from policy_function where dept_map ='$ses_dept_id'";
						$func_id=$this->Common_model->get_single_value($qSql);
					}
					
					$search_text = $this->input->get('search_text');
					
					$cond="";
					if ( isUpdatePolicy()== true) $cond=" Where is_active in (1,0) ";
					else  $cond .=" Where is_active in (1) ";
					
					if($office_id <> "ALL"){
						$cond .=" and (office_id = 'ALL' OR office_id = '$office_id' ) ";
					}
					
					
					if($func_id <> "" && $func_id <> "1" && $func_id <> "ALL"){
						if($role_dir == "agent") $cond .=" and (function_id= 1 OR function_id = '$func_id') ";
						else $cond .=" and (function_id= 1 OR function_id = '$func_id') ";
					}
					
					
					if($search_text!="") $cond .= " And (title like '%".$search_text."%' OR description like '%".$search_text."%') ";
					
					
					$qSql= "select *,(select description from policy_function pf where pf.id=pl.function_id ) as  func_name, (select count(id) from policy_acceptance pa where pl.id=pa.policy_id and user_id='$current_user') as is_accepted from policy_list pl $cond";
										
					$data['policy_list'] = $policyArray = $this->Common_model->get_query_result_array($qSql);
					
					$attchArray=array();
					
					foreach($policyArray as $row): 
						$policy_id=$row['id'];
						$qSqlA="select * from policy_attach Where policy_id='$policy_id'  Order By id ";
						$query = $this->db->query($qSqlA);
						$attchArray[$policy_id]=$query->result_array();
					endforeach;
					
					$data['all_policy_attach'] = $attchArray;
					
					
					$Lfull_name=get_username();
					$LOMid=get_user_omuid();
					
					$filterArray = array(
							"office_id" => $office_id,
							"func_id" => $func_id
                     ); 
					 
					$all_params=str_replace('%2F','/',http_build_query($filterArray));
					 
					$LogMSG="View policy with ". $all_params;
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
				//}
				
								
				$data['client_id']=$client_id;
				$data['func_id']=$func_id;
				$data['office_id']=$office_id;
				
				$data['search_text']=$search_text;
				
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "offer/manage.php";
			    
				$data['client_list'] = $this->Common_model->get_client_list();
				
				if(get_role_dir()=="super" || $is_global_access==1){
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				$data['function_list'] = $this->Common_model->get_function_list();	
					
				$this->load->view('dashboard',$data);
			
        }
    }
	
	
		
public function addPolicy()
	{
        if(check_logged_in())
        {
						
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
								
			$is_global_access=get_global_access();
			
			
           $data["aside_template"] = $this->aside;
				
		   $data["content_template"] = "policy/view.php";
				
           $data["error"] = ''; 
           
		   $data['client_list'] = $this->Common_model->get_client_list();
				
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
				
			$data['function_list'] = $this->Common_model->get_function_list();	
			
			$_fname = "";
            $_lname = "";
			
          //  if($this->input->post('submit')=="Add")
          //  {
                  
				$_run = false;  
				
				$log=get_logs();
				
				$office_id = trim($this->input->post('office_id'));
				
				$function_id = trim($this->input->post('function_id'));
				$title = trim($this->input->post('title'));
				
				//$description = trim($this->input->post('description'));
               
				$_status= 1;
				$_disp_id= 1;
                
				
				$field_array = array(
					"office_id" => $office_id,
					"function_id" => $function_id,
					"title" => $title,
			//		"description" => $description,
					"added_by" => $current_user,
					"is_active" => '1'
				);
				
				$rowid= data_inserter('policy_list',$field_array);
				//redirect(base_url()."Policy");
				echo "done";
				
			//}else{
			//}
       }                
   }
   
   
   public function upload()
    {
				
        if(check_logged_in())
        {
						
			$atpid = trim($this->input->post('atpid'));
			
			$ret='done';
			$ret_msg="";
			$log=get_logs();
			$rowid=0;
			$orgFileName="";
			
			if($atpid!=""){
			
				$output_dir = "uploads/policy/";
				
				if(!is_array($_FILES["attach"]["name"])) //single file
					{
						if($_FILES['attach']['size'] > 10485760){
							
							$ret_msg ='File size must be less tham 10 MB';
							$ret="error";
						}else{
							$ext =pathinfo($_FILES["attach"]["name"])['extension'];
							$orgFileName=$_FILES["attach"]["name"];
							
							$field_array = array(
								"policy_id" => $atpid,
								"file_name" => $orgFileName,
								"ext" =>$ext ,
								"log" => $log,
								"status" => '1'
							);
							$rowid=data_inserter('policy_attach',$field_array);
							$fileName = $atpid."-".$rowid.".".$ext;
							move_uploaded_file($_FILES["attach"]["tmp_name"],$output_dir.$fileName);
							
							$ret_msg = $fileName;
							$ret='done';
						}
					}
			}else{
				$ret_msg ='Policy ID not found';
				$ret="error";
			}
			
			$retArr = array();
			$retArr[0]=$ret;
			$retArr[1]=$rowid;
			$retArr[2]=$orgFileName;
			$retArr[3]=$ret_msg;
			echo json_encode($retArr);
			
		}
   }
   
   
   public function deleteAttachment(){
	   
	  	   
		if(check_logged_in()){
			
			$atid = trim($this->input->post('atid'));
			if($atid!="")
			{
				
				$qSql="select policy_id as value from policy_attach where id='$atid'";
				$policy_id=$this->Common_model->get_single_value($qSql);
				
				$qSql="select ext as value from policy_attach where id='$atid'";
				$ext=$this->Common_model->get_single_value($qSql);
				
				$aFile="/uploads/policy/".$policy_id."-".$atid.".".$ext;
				unlink($aFile);
				
				$this->db->where('id', $atid);
				$this->db->delete('policy_attach'); 
				$ans="Done";
			}else $ans="fail";
			echo $ans;
		}
	}
	
	
	public function updatePolicy()
	{
		$current_user = get_user_id();
		
		if(check_logged_in())
		{
			
								
			$pid = trim($this->input->post('pid'));
			$title = trim($this->input->post('title'));
			//$description = trim($this->input->post('description'));
			$office_id = trim($this->input->post('office_id'));
			$function_id = trim($this->input->post('function_id'));
			
			if($pid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"title" => $title,
					"office_id" => $office_id,
					"function_id" => $function_id,
					"log" => $log
				); 
			
				$this->db->where('id', $pid);
				$this->db->update('policy_list', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	
	
	public function pActDeact()
	{
		if(check_logged_in())
		{
						
			$pid = trim($this->input->post('pid'));
			$sid = trim($this->input->post('sid'));
			
			if($pid!=""){
				$this->db->where('id', $pid);
				$this->db->update('policy_list', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
	
   public function accept_policy(){
	   if(check_logged_in()){
			$current_user = get_user_id();
			$adpid = trim($this->input->post('adpid'));
			$added_date = date("Y-m-d h:i:sa");
			$log = get_logs();
			
			if($adpid!=""){
				$field_array = array(
					"policy_id" => $adpid,
					"user_id" => $current_user,
					"accepted_datetime" => $added_date,
					"log" => $log
				);
				
				$rowid= data_inserter('policy_acceptance',$field_array);
				$ans="done";
				
			}else{
				$ans="error";
			}
			//echo $ans;
			redirect("policy");
	   }
   }
   
   
   
	
}

?>