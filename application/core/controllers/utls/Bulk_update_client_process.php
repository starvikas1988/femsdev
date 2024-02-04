<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_update_client_process extends CI_Controller {
    
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
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			
            $qSql="Select * from signin order by id";
			$user_list = $this->Common_model->get_query_result_array($qSql);
			
			foreach($user_list as $user):
					
				$client_id =	$user['client_id'];
				
				$process_id =	$user['process_id'];
				
				$user_id =	$user['id'];

				if ($client_id <> ""){
					
					$qSql="SELECT count(id) as total FROM info_assign_client  where user_id = '$user_id'";
					
					$iSClient = $this->Common_model->get_total2($qSql);
					
					echo $qSql. " = ". $iSClient ."<br>";
					
					if( $iSClient > 0){
						
						$iClientArr = array(
							"client_id" => $client_id
						); 
					
						print_r ($iClientArr);
						echo "<br>";
						
						$this->db->where('user_id', $user_id);
						$this->db->update('info_assign_client', $iClientArr);	
													
					}else{
						
						$iClientArr = array(
							"user_id" => $user_id,
							"client_id" => $client_id
						); 
						
						print_r ($iClientArr);
						echo "<br>";
						
						$rowid= data_inserter('info_assign_client',$iClientArr);
						
						echo "rowid :: " . $rowid. "<br>";
						
					}
					
				}
				
				
				if ($process_id <> ""){
					
					$qSql="SELECT count(id) as total FROM info_assign_process  where user_id = '$user_id'";
					
					$iSProcess = $this->Common_model->get_total2($qSql);
					
					echo $qSql. " = ". $iSProcess ."<br>";
					
					if( $iSProcess > 0){
						
						$iProcessArr = array(
							"process_id" => $process_id
						); 
					
						print_r ($iProcessArr);
						echo "<br>";
						
						$this->db->where('user_id', $user_id);
						$this->db->update('info_assign_process', $iProcessArr);	
													
					}else{
						
						$iProcessArr = array(
							"user_id" => $user_id,
							"process_id" => $process_id
						); 
						
						print_r ($iProcessArr);
						echo "<br>";
						
						$rowid= data_inserter('info_assign_process',$iProcessArr);
						
						echo "rowid :: " . $rowid. "<br>";
						
					}
				}
				
			endforeach;
			   
		}
    }
	
}

?>