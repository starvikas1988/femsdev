<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process_update extends CI_Controller {

    private $aside = "process_update/aside.php";

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
						
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$get_client_id=get_client_ids();
			$get_process_id=get_process_ids();
			
			
			//echo "get_process_id::". $get_process_id . "<br>";
			
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$is_global_access=get_global_access();
			
			$data["role_dir"]=$role_dir;
			
			$data['process_updates'] =array();
		
				$office_id = "";
				$search_text="";
				//$client_id = "";
				//$process_id = "";
				
				$dn_link="";
								
				//if($this->input->get('showReports')=='Show')
				//{
					
					
					$cValue = trim($this->input->post('client_id'));
					if($cValue=="") $cValue = trim($this->input->get('client_id'));
					
					if($cValue=="") $cValue = $get_client_id;
					
					$pValue = trim($this->input->post('process_id'));
					if($pValue=="") $pValue = trim($this->input->get('process_id'));
					if($pValue=="") $pValue = $get_process_id;
					
					$data['cValue']=$cValue;
					$data['pValue']=$pValue;
					
					$office_id = $this->input->get('office_id');
					if($office_id=="")  $office_id=$user_office_id;
					
					$search_text = $this->input->get('search_text');
					
					
					
					
					$s_cond="";
					//$is_specific_access="";
					
					$cond2="";
					if($office_id <> "ALL"){
						$cond2 .=" and (office_id = 'ALL' OR office_id = '$office_id' ) ";
					}
					if($cValue!="ALL" && $cValue!="" && $cValue!="0") $cond2 .= " And client_id='".$cValue."' ";
					if($pValue!="ALL" && $pValue!="" && $pValue!="0") $cond2 .= " And process_id in ('ALL', '".$pValue."') ";
					
					$cond3 = "";
					if($search_text!="") $cond3 .= " And (title like '%".$search_text."%' OR description like '%".$search_text."%') ";
					
					$cond="";
					$cond4 = "";			
					if ( isUpdatePolicy()== true){
						
						$cond=" Where is_active in (1,0) ";
						$cond4 = " ( is_specific_access = 1  $cond2 ) ";
						
					}else{
						$cond .=" Where is_active in (1) ";
						$cond4 = " ( is_specific_access = 1 and pl.id in (SELECT pu_id FROM process_updates_specific_user where user_id = '$current_user' ) )";
					}
					
					$qSql= "select *, (select shname from client x where x.id=pl.client_id) as clientID, (select name from process y where y.id=pl.process_id) as processID, DATE_FORMAT(added_date,'%m/%d/%Y') as addedDate, (select count(id) from process_updates_acceptance pa where pl.id=pa.pu_id and user_id='$current_user') as is_accepted from process_updates pl $cond $cond3 AND ((is_specific_access = 0 $cond2) OR  $cond4 )   order by pl.added_date desc";
					
					//echo $qSql;
					
					$data['process_updates'] = $policyArray = $this->Common_model->get_query_result_array($qSql);
					
					
						$attchArray=array();
						
						foreach($policyArray as $row): 
							$pu_id=$row['id'];
							$qSqlA="select * from process_updates_attach Where pu_id='$pu_id' Order By id ";
							$query = $this->db->query($qSqlA);
							$attchArray[$pu_id]=$query->result_array();
						endforeach;
						
						$data['all_pu_attach'] = $attchArray;
						
						
						if( $role_dir != "super" && $is_global_access!=1  && (($get_client_id == "0" || $get_client_id == "") and $role_dir =="agent" )){
							$processArray = array();
							$attchArray=array();
							$data['process_updates'] = $processArray;
							$data['all_pu_attach'] = $attchArray;
						}
						
					
					$Lfull_name=get_username();
					$LOMid=get_user_omuid();
					
					$filterArray = array(
							"office_id" => $office_id
                     ); 
					 
					$all_params=str_replace('%2F','/',http_build_query($filterArray));
					 
					$LogMSG="View process updates with ". $all_params;
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
				//}
				
								
				//$data['client_id']=$client_id;
				//$data['process_id']=$process_id;
				$data['office_id']=$office_id;
				
				$data['search_text']=$search_text;
				
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "process_update/manage.php";
			    
				if(get_login_type()=="client"){
					
					$clients_client_id=get_clients_client_id();
					
					$qSQL="SELECT * FROM client where is_active=1 and client.id='".$clients_client_id."' ORDER BY shname";
					$query = $this->db->query($qSQL);
					$data['client_list'] = $query->result();
		
					
				}else{
					$data['client_list'] = $this->Common_model->get_client_list();
				}				
				
				if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
				else $data['process_list'] = $this->Common_model->get_process_list($cValue);
				
				if(get_login_type()=="client"){
					
					$qSql="SELECT * FROM office_location where (select office_id from signin_client where id='$current_user') like CONCAT('%',abbr,'%')  ORDER BY office_name";
					$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
					
					$ses_process_id=get_clients_process_id();
					$qSQL="SELECT id,name FROM process WHERE is_active=1 and id in ($ses_process_id) ORDER BY name";					
					$query = $this->db->query($qSQL);
					$data['process_list'] = $query->result();
					
					
				}else{
					if(get_role_dir()=="super" || $is_global_access==1){
						$data['location_list'] = $this->Common_model->get_office_location_list();
					}else{
						$sCond=" Where id = '$user_site_id'";
						$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
					}
				}
				
				
				$qSql="Select * from signin where status=1 and is_global_access!=1";
				$data["get_access_control"] = $this->Common_model->get_query_result_array($qSql);
				
					
				$this->load->view('dashboard',$data);
			
        }
    }

    public function view_questions(){
    	
    	$pu_id = $this->input->post('pu_id');
    	$qSql="Select q.id,q.title from process_updates_questions q where q.status=1 and q.pu_id=$pu_id";

    	// $qSql="Select q.id q.title,p.text,p.correct_answer from process_updates_questions q left join process_updates_questions_ans_options p on p.ques_id=q.id where q.status=1 and q.pu_id=$pu_id";
		$ret = $this->Common_model->get_query_result_array($qSql);
		// print_r($ret); exit();
    	echo json_encode($ret);
    }


     public function view_questions_options(){
    	
    	$q_id = $this->input->post('q_id');
    	$qSql="Select q.text,q.correct_answer from process_updates_questions_ans_options q where q.status=1 and q.ques_id=$q_id";

    	// $qSql="Select q.id q.title,p.text,p.correct_answer from process_updates_questions q left join process_updates_questions_ans_options p on p.ques_id=q.id where q.status=1 and q.pu_id=$pu_id";
		$ret = $this->Common_model->get_query_result_array($qSql);
		// print_r($ret); exit();
    	echo json_encode($ret);
    }
	
	
		
public function addProcessUpdate()
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
				
		   $data["content_template"] = "process_update/view.php";
				
           $data["error"] = ''; 
           
		    $data['client_list'] = $this->Common_model->get_client_list();
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			$qSql="Select * from signin where status=1 and is_global_access!=1";
			$data["get_access_control"] = $this->Common_model->get_query_result_array($qSql);
			
				
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
				
			
			$_fname = "";
            $_lname = "";
			
          //  if($this->input->post('submit')=="Add")
          //  {
                  
				$_run = false;  
				
				$log=get_logs();
				
				$office_id = trim($this->input->post('office_id'));
				$client_id = trim($this->input->post('client_id'));
				$process_id = trim($this->input->post('process_id'));
				$title = trim($this->input->post('title'));
				$description = trim($this->input->post('description'));
				$specific_user = trim($this->input->post('specific_user'));
				$added_date = date("Y-m-d h:i:sa");
				$access_control_array = $this->input->post('access_control');
               
				$_status= 1;
				$_disp_id= 1;
				
                
				
				$field_array = array(
					"office_id" => $office_id,
					"client_id" => $client_id,
					"process_id" => $process_id,
					"title" => $title,
					"description" => $description,
					"is_specific_access" => $specific_user,
					"added_by" => $current_user,
					"added_date" => $added_date,
					"is_active" => '1',
					"log" => $log
				);
				
				$pu_rowid = data_inserter('process_updates',$field_array);
				
				if($pu_rowid!==FALSE){
					foreach ($access_control_array as $key => $value){		
						$iAccessControlArr = array(
							"pu_id" => $pu_rowid,
							"user_id" => $value
						);
						
						$rowid = data_inserter('process_updates_specific_user',$iAccessControlArr);
					}
				}
				
				redirect(base_url()."Process_update");
				
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
			
				$output_dir = "uploads/process_updates/";
				
				if(!is_array($_FILES["attach"]["name"])) //single file
					{
						if($_FILES['attach']['size'] > 504857600){
							
							$ret_msg ='File size must be less tham 400 MB';
							$ret="error";
						}else{
							$ext =pathinfo($_FILES["attach"]["name"])['extension'];
							$orgFileName=$_FILES["attach"]["name"];
							
							$field_array = array(
								"pu_id" => $atpid,
								"file_name" => $orgFileName,
								"ext" =>$ext ,
								"log" => $log,
								"status" => '1'
							);
							$rowid=data_inserter('process_updates_attach',$field_array);
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
				
				$qSql="select pu_id as value from process_updates_attach where id='$atid'";
				$processUpdates_id=$this->Common_model->get_single_value($qSql);
				
				$qSql="select ext as value from process_updates_attach where id='$atid'";
				$ext=$this->Common_model->get_single_value($qSql);
				
				$aFile="/uploads/process_updates/".$processUpdates_id."-".$atid.".".$ext;
				unlink($aFile);
				
				$this->db->where('id', $atid);
				$this->db->delete('process_updates_attach'); 
				$ans="Done";
			}else $ans="fail";
			echo $ans;
		}
	}
	
	
	public function editProcessUpdate()
	{
		$current_user = get_user_id();
		
		if(check_logged_in())
		{
								
			$pid = trim($this->input->post('pid'));
			$title = trim($this->input->post('title'));
			$description = trim($this->input->post('description'));
			$office_id = trim($this->input->post('office_id'));
			$client_id = trim($this->input->post('client_id'));
			$process_id = trim($this->input->post('process_id'));
			$added_date = date("Y-m-d h:i:sa");
			$specific_user = trim($this->input->post('specific_user'));
			$access_control_array = $this->input->post('access_control');
			
			if($pid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"title" => $title,
					"description" => $description,
					"office_id" => $office_id,
					"client_id" => $client_id,
					"process_id" => $process_id,
					"is_specific_access" => $specific_user,
					"log" => $log
				); 
			
				$this->db->where('id', $pid);
				$isOK  =  $this->db->update('process_updates', $field_array);
				
				$this->db->delete('process_updates_specific_user', array('pu_id' => $pid));
														
				foreach ($access_control_array as $key => $value){		
					$iAccessControlArr = array(
						"pu_id" => $pid,
						"user_id" => $value
					);
					
					$rowid = data_inserter('process_updates_specific_user',$iAccessControlArr);
				}
				
				$ans="done";
				
			}else{
				$ans="error";
			}
			
			redirect(base_url()."Process_update");
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
				$this->db->update('process_updates', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
	
   public function accept_process_update(){
	   if(check_logged_in()){
			$current_user = get_user_id();
			$adpid = trim($this->input->post('adpid'));
			$added_date = date("Y-m-d h:i:sa");
			$log = get_logs();
			
			if($adpid!=""){
				$field_array = array(
					"pu_id" => $adpid,
					"user_id" => $current_user,
					"accepted_datetime" => $added_date,
					"log" => $log
				);
				
				$rowid= data_inserter('process_updates_acceptance',$field_array);
				$ans="done";
				
			}else{
				$ans="error";
			}
			//echo $ans;
			redirect(base_url()."Process_update");
	   }
   }


   public function add_question(){
   	$pu_id = $this->input->post('puid');
   	$options = $this->input->post('option');
   	$this->db->set('pu_id',$pu_id);
   	$this->db->set('title',$this->input->post('question'));
   	$this->db->set('status',1);
   	$this->db->insert('process_updates_questions');

   	$this->db->select_max('id');
   	$this->db->from('process_updates_questions');
   	$query = $this->db->get();
   	$q_id = $query->row();

   	foreach ($options as $key => $value) {
   		$this->db->set('text',$value);
   		$this->db->set('ques_id',$q_id->id);
   		$this->db->set('correct_answer',0);
   		$this->db->set('status',1);
   		$this->db->insert('process_updates_questions_ans_options');
   	}
   	$this->db->set('correct_answer',1);
   	$this->db->where('text',$this->input->post('crctopt'));
   	$this->db->where('ques_id',$q_id->id);
   	$this->db->update('process_updates_questions_ans_options');

   	redirect($_SERVER['HTTP_REFERER']);
   }
   
   
   
	
}

?>