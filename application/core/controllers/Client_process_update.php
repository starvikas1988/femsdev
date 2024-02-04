<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_process_update extends CI_Controller {

    private $aside = "client_process_update/aside.php";
	private $objPHPExcel;
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->library('excel');
		$this->load->model('reports_model');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->reports_model->set_report_database("report");
		
		$this->objPHPExcel = new PHPExcel();
		
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
			
			$get_client_id=get_clients_client_id();
			$get_process_id=get_clients_process_id();
			
			
			//echo "get_process_id::". $get_process_id . "<br>";
			
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$is_global_access=0;
			
			$data["role_dir"]=$role_dir;
			
			$data['process_updates'] =array();
		
				$office_id = "";
				$search_text="";
				//$client_id = "";
				//$process_id = "";
				
				$dn_link="";
								
				//if($this->input->get('showReports')=='Show')
				//{
					$pValue = trim($this->input->post('process_id'));
					if($pValue=="") $pValue = trim($this->input->get('process_id'));
					if($pValue=="") $pValue = $get_process_id;
					
					$qSql="Select distinct client_id as id from process_updates pu where pu.process_id in (".$pValue.")";
					$cValue= $this->Common_model->get_query_result_array($qSql);
					$cValue= $cValue[0]['id'];
					// print_r($cValue); exit;
					// $cValue = trim($this->input->post('client_id'));
					// if($cValue=="") $cValue = trim($this->input->get('client_id'));
					
					if($cValue=="") $cValue = $get_client_id;
					
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
					// $fields = $this->db->field_data('process_updates');

					// foreach ($fields as $field)
					// {
					//    echo $field->name."<br>";
					// }

					// exit;
					
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
				
				$data["content_template"] = "client_process_update/manage.php";
			    
				
					$clients_client_id=get_clients_client_id();
					
					$qSQL="SELECT * FROM client where is_active=1 and client.id='".$clients_client_id."' ORDER BY shname";
					$query = $this->db->query($qSQL);
					$data['client_list'] = $query->result();
				
					$qSql="SELECT * FROM office_location where (select office_id from signin_client where id='$current_user') like CONCAT('%',abbr,'%')  ORDER BY office_name";
					$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
					
					$ses_process_id=get_clients_process_id();
					$qSql="SELECT id,name FROM process WHERE is_active=1 and id in ($ses_process_id) ORDER BY name";	
					//echo $qSql;
					$data['process_list'] = $this->Common_model->get_query_result_array($qSql);
					
				
								
				
				$qSql="Select * from signin where status=1 and is_global_access!=1";
				$data["get_access_control"] = $this->Common_model->get_query_result_array($qSql);
				
					
				$this->load->view('dashboard',$data);
			
        }
    }

	public function acceptance_report_list(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "client_process_update/acceptance_report.php";
			$data["content_js"] = "client_process_update/reports_js.php";
			
			$process_update_id="";
			$action="";
			$dn_link="";
			$cValue="";
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
						
			
			$data["process_update_acceptance_list"] = array();
			
			$process_update_id = $this->input->get('process_update_id');
			$user_id = $this->input->get('user_id');
			
			$qSql="Select title from process_updates where id='$process_update_id'";
			$data['pu_title'] = $this->Common_model->get_query_result_array($qSql);
			
						
			$qSql="SELECT * FROM office_location where (select office_id from signin_client where id='$current_user') like CONCAT('%',abbr,'%')  ORDER BY office_name";
			$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
			
			
			$clients_client_id=get_clients_client_id();	
			$qSQL="SELECT * FROM client where is_active=1 and client.id='".$clients_client_id."' ORDER BY shname";
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
									
			$ses_process_id=get_clients_process_id();
			$qSql="SELECT id,name as shname FROM process WHERE is_active=1 and id in ($ses_process_id) ORDER BY name";	
					
			$data['process_list'] = $this->Common_model->get_query_result_array($qSql);
			
			
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				
				$field_array = array(
						"office_id" => $office_id,
						"client_id" => $cValue,
						"user_id" => $user_id,
						"process_update_id" => $process_update_id,
					);
			
				$fullAray = $this->reports_model->get_process_update_acceptance_report($field_array);
				$data["process_update_acceptance_list"] = $fullAray;
				
				$this->create_processUpdateAcceptance_CSV($fullAray);
					
				$dn_link = base_url()."reports/downloadprocessUpdateAcceptance";
					
			}
			
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['cValue']=$cValue;
			$data['office_id']=$office_id;
			$data['process_update_id'] = $process_update_id;
			
			$this->load->view('dashboard',$data);
		}
	}


	public function create_processUpdateAcceptance_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Title", "Accepted By", "Fusion ID", "XPOID", "OMUID", "Location", "Client", "Process", "Acceptance Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['pu_titile'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname']. '",';
			$row .= '"'.$user['fusion_id'].'",';  
			$row .= '"'.$user['xpoid'].'",';  
			$row .= '"'.$user['omuid'].'",';  
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['accptdate'].'",'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}


	public function getProcessTitle(){
		if(check_logged_in()){
			$pid=$this->input->post('pid');
			$office_id=$this->input->post('office_id');
			
			if($pid=="") $pid=99999999;
			
			$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select name from process p where p.id=process_updates.process_id) as client from process_updates where office_id='$office_id' and process_id='$pid'";
			//echo $qSql;		
				
			echo json_encode($this->Common_model->get_query_result_array($qSql));
			
			
		}
	}


}