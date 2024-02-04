<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apitermuser extends CI_Controller {
    
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
					$terms_date = trim($this->input->post('terms_date'));
					$request_id = trim($this->input->post('request_id'));
					$ticket_no = trim($this->input->post('ticket_no'));
					$ticket_date = trim($this->input->post('ticket_date'));
					$comments = trim($this->input->post('comments'));
					$terms_by = trim($this->input->post('terms_by'));
					$update_date = trim($this->input->post('update_date'));
					$update_by = trim($this->input->post('update_by'));
					$t_type = trim($this->input->post('t_type'));
					$sub_t_type = trim($this->input->post('sub_t_type'));
					
					if($terms_date!="") $start_date=substr($terms_date,0,10);
					$end_date=$start_date;
					
					$log = trim($this->input->post('log')); 
					$log='Through Api | ' . $log;
					
					$_status= 1;
					$_disp_id= 1;
														
					if($tfusion_id!="" && $terms_date!="" && $terms_by!="" )
					{
						
						$tuser_id=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$tfusion_id'");
						
						$this->db->trans_start();
						
						$evt_date = CurrMySqlDate();
						
						$_field_array = array(
							"user_id" => $tuser_id,
							"terms_date" => $terms_date,
							"t_type" => $t_type,
							"sub_t_type" => $sub_t_type,
							"request_id" => $request_id,
							"ticket_no" => $ticket_no,
							"ticket_date" => $ticket_date,
							"comments" => $comments,
							"terms_by" => $terms_by,
							"evt_date" => $evt_date,
							"is_term_complete" => 'Y',
							"update_date" => $update_date,
							"update_by" => $update_by,
							"log" => $log
						); 
						
						$ret = data_inserter('terminate_users',$_field_array);
						$Update_array = array(
									"status" => '0',
									"disposition_id" => '7',
									"is_logged_in" => '0'
							);
						$this->db->where('id', $tuser_id);
						$this->db->update('signin', $Update_array);
												
						$_field_array = array(
							"user_id" => $tuser_id,
							"event_time" => $evt_date,
							"event_by" => $terms_by,
							"event_master_id" => '7',
							"start_date" => $start_date,
							"end_date" => $end_date,
							"ticket_no" => $ticket_no,
							"remarks" => $comments,
							"log" => $log
						); 
						$ret = data_inserter('event_disposition',$_field_array);					
							
						$this->db->trans_complete();						
						////////////////////////////
								
						if($this->db->trans_status() === FALSE){
							echo "Failed DB Error Try Again";								
						}else{
								//////////LOG////////
							
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