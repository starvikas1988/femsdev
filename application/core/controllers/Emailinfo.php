<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailinfo extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
     private $aside = "master/aside.php";
	 
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		
	 }
	 
    public function index()
    {
       if(check_logged_in())
		{
			//$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
			$data["content_template"] = "emailinfo/manage.php";
			$data["error"] = ''; 
			
			$data['info_list'] = $this->Common_model->get_notification_list();
			
			$this->load->view('dashboard',$data);
			
		}
			
    }
	
	
	
 public function add()
    {
        if(check_logged_in())
        {
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "emailinfo/add.php";
            $data["error"] = ''; 
            
			$data['client_list'] = $this->Common_model->get_client_list();
			
			
            if($this->input->post('submit')=="Add")
            {
                  
				$_run = false;  
				
				$client_id = trim($this->input->post('client_id'));
                $sch_for = trim($this->input->post('sch_for'));
                $email_id = trim($this->input->post('email_id'));
                $email_body = $this->input->post('email_body');
				$email_subject = $this->input->post('email_subject');
				 
                  
			    if($sch_for!="" && $email_id!="" && $email_body!="")
				{
                        $_field_array = array(
							"client_id" => $client_id,
                            "sch_for" => $sch_for,
							"email_id" => $email_id,
                            "email_body" => $email_body,
							"email_subject" => $email_subject,
                        ); 
						
                        $info_id = data_inserter('notification_info',$_field_array);
                        
                        if($info_id!==false)
                        {
							//////////LOG////////
			
							$Lfull_name=get_username();
							$LOMid=get_user_omuid();
									
							$LogMSG="Added Notification Info of $sch_for ";
							log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
										
							//////////
			
                           $this->session->set_flashdata("error",show_msgbox("Notification Info Added Successfully",false));
						   
                           redirect(base_url()."admin/manage_schedule");
						   						   
                        }else $data['error'] = show_msgbox('Schedule Info Creation Failed',true);
				}
									
		   }
		   
		   //$this->load->view('dashboard_ajax',$data);
		   $this->load->view('dashboard',$data);
		   
		   
      }
                        
   }
 
public function update()
{
	if(check_logged_in())
    {
		$sid = trim($this->input->post('sid'));
		$sch_for = trim($this->input->post('sch_for'));
		$email_id = trim($this->input->post('email_id'));
		$email_subject = trim($this->input->post('email_subject'));
		$email_body = trim($this->input->post('email_body'));
		
		
		$_field_array = array(
			"sch_for" => $sch_for,
			"email_id" => $email_id,
			"email_subject" => $email_subject,
			"email_body" => $email_body,
		); 
				
		
		if($sid!=""){
			$this->db->where('id', $sid);
			$this->db->update('notification_info',$_field_array );
			
			//////////LOG////////
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
					
			$LogMSG="Update Notification Info of $sch_for ";
			log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
			
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}	
} 

   
}

?>