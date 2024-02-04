<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apicanceltermination extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('auth_model');
		
	 }
	
    public function index()
    {
        	
				$_run = false;  
								
				$fid = trim($this->input->post('fid'));
				$usr_id = trim($this->input->post('uid'));
				
				//$dbCnt=$this->Common_model->get_single_value("Select count(id) as value from signin where fusion_id='$fid' and id='$usr_id'");
				$dbCnt=$this->Common_model->get_single_value("Select count(id) as value from signin where fusion_id='$fid'");
				
				if($dbCnt==1)
				{
				
					$tfusion_id = trim($this->input->post('tfusion_id'));
					
					$update_date = trim($this->input->post('update_date'));
					$update_by = trim($this->input->post('update_by'));
															
					$log = trim($this->input->post('log')); 
					$log='Through Api | ' . $log;
					
					
														
					if($tfusion_id!="" )
					{
						
						$tuser_id=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$tfusion_id'");
						
						$this->db->trans_begin();
						
						//$evt_date = CurrMySqlDate();
						
						$Update_array = array(
							"is_term_complete" => 'R',
							"update_date" => $update_date,
							"update_by" => $update_by,
							"log" => $log
						);
							
						$this->db->where('user_id', $tuser_id);
						$this->db->where('is_term_complete', 'Y');
						$this->db->update('terminate_users', $Update_array);

						$Update_array = array(
									"status" => '1',
									"disposition_id" => '1',
									"is_logged_in" => '0'
							);
							
						$this->db->where('id', $tuser_id);
						$this->db->update('signin', $Update_array);
						
						$this->db->delete('event_disposition', array('user_id' => $tuser_id,'event_master_id'=>'7'));

						$this->db->trans_complete();						
						////////////////////////////		
								
						if($this->db->trans_status() === FALSE){
							echo "Failed DB Error Try Again";	
							$this->db->trans_rollback();
							
						}else{
								//////////LOG////////
							$this->db->trans_commit();
							
							$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$tuser_id'";
							$query = $this->db->query($qSql);
							$uRow=$query->row_array();
							
							$omuid=$uRow["omuid"];
							$full_name=$uRow["full_name"];
							
							$LogMSG=" Terminate User $full_name ($omuid) Ticket no: $ticket_no";
							log_message('FEMS', ' Through Api | '.$LogMSG );
							
							echo "DONE";														   
						}
							
				}else echo "Failed Invalid Data";
						
			}else{
					echo "Failed Auth";
			}
   }

   
}

?>