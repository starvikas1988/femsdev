<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_password_reset extends CI_Controller {
    
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
			$role_id= get_role_id();
			$current_user = get_user_id();
			$_fusion_id = get_user_fusion_id();
			$user_office_id = get_user_office_id();
			$user_oth_office = get_user_oth_office();
			
			//echo $current_user;
			
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			
			if( get_role_dir()!="agent") $data["aside_template"] = get_aside_template();
			else $data["aside_template"] = "special/aside.php";
			
			$data["content_template"] = "user/password_reset.php";
					
			$fids="";
			$comments="";
			$msg="";
			$errmsg="";
			$mCond="";
			
			$update_by = $current_user;
			$update_date = CurrMySqlDate();
			$log=get_logs();
			
			if(is_access_reset_password() || get_global_access()==1) {
				
				
				if($this->input->get('runUpdate')=='Reset Password')
				{
					
					
					if(get_global_access()==1 || get_dept_folder()=="it" ) $mCond="";
					else $mCond =" and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
					
					
					
					$fids = $this->input->get('fids');
					$comments = $this->input->get('comments');
					
					if($fids!="" && $comments!="" )
					{
						$fidArray=explode(",",$fids);
						//echo $ldate. " <br> ";
						//print_r($fidArray);
						
						foreach ($fidArray as $fusion_id) {
							
							$fusion_id=trim($fusion_id);
							$qSql="Select id as value from  signin where fusion_id='$fusion_id'";
							$uid = $this->Common_model->get_single_value($qSql);
							
							if($uid!=""){
							$this->db->trans_start();
							////////////////////////////
							
							$uSql="Update signin set passwd = md5(fusion_id), is_update_pswd='N' where id='".$uid."' $mCond ";
							//echo $uSql;
							$this->db->query($uSql);
							
							$_field_array = array(
								"user_id" => $uid,
								"update_date" => $update_date,
								"update_by" => $update_by,
								"log" => $log
							); 
							
							data_inserter('user_reset_psswd_log',$_field_array);
							$this->db->trans_complete();						
							
							//////////////////////////////////
							
							
							}else{
								
								$errmsg .=" Invalid fusion ID ".$fusion_id ." <br>"; 
								
								
							}
							
						}
						
						if($errmsg=="") $msg="All Successfully Done ";
						else $msg= $errmsg ."<br>Others Successfully Done.";
						
						
						
					}else{
						$msg="One or More fields are blank";
					}
					
				}
				
			}else{
				
			}
				
			$data['fids']=$fids;
			$data['comments']=$comments;
			$data['msg']=$msg;
			
			$this->load->view('dashboard',$data);
				
        }
    }
	
	      
      
}

?>