<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_disposition_update extends CI_Controller {

   
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('Common_model');
		
	 }
	 
    public function index()
    {
				
        if(check_logged_in())
        {
			$role_id= get_role_id();
			$current_user = get_user_id();
			$_fusion_id = get_user_fusion_id();
			
			//echo $current_user;
			
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			
			if($this->is_access_reports($_fusion_id)){
			
				$data["aside_template"] = get_aside_template();
				
				$data["content_template"] = "utils/bulk_disp.php";
			    
				
				$ddate="";
				$udate="";
				$fids="";
				$lhrs="";
				$disp_id="";
				$log="";
				$comments="";
				$msg="";
				
				if($this->input->get('runUpdate')=='Update')
				{
					$ddate = $this->input->get('ddate');
					
					$udate = $this->input->get('udate');
					
					$disp_id = $this->input->get('disp_id');
					
					$log = $this->input->get('log');
					if($log=="") $log="As per WFM request";
					
					$comments = $this->input->get('comments');
					if($comments=="")$comments="";
					
					$fids = $this->input->get('fids');
					
					if($fids!="" && $ddate!="" && $udate!="" && $disp_id!="")
					{
						
					
						$ymddate=mmddyy2mysql($ddate);
						
						$uymdDate=mdydt2mysql($udate);
						
						$fidArray=explode(",",$fids);
						//echo $ldate. " <br> ";
						//print_r($fidArray);
						$cur_date=CurrMySqlDate();
					
						foreach ($fidArray as $value) {
							
							
								$value=trim($value);					
							
								$iSql="";
								
								$qSql="select count(user_id) as value from logged_in_details where user_id in (select id  from  signin where fusion_id='$value') and cast(login_time as date) = '".$ymddate."'";
								
								$last_logged_in_cnt=$this->Common_model->get_single_value($qSql);
								
								if($last_logged_in_cnt==0){
									
									$qSql="SELECT count(id) as value FROM event_disposition where user_id in (select id  from  signin where fusion_id='$value') and DATE(start_date)='$ymddate'";
									//echo $qSql ."\r\n\r\n" ;
									
									$event_cnt=$this->Common_model->get_single_value($qSql);
									if($event_cnt==0){

										$iSql="INSERT INTO event_disposition (user_id, event_time, event_by, event_master_id, start_date, end_date, remarks, log) select id,'$uymdDate', '1', '$disp_id', '$ymddate', '$ymddate', '$comments', '$log' from signin where fusion_id='$value'";
										$this->db->query($iSql);
										//echo $iSql ."\r\n\r\n" ;
									}else{
										
										
										$dSql="delete FROM event_disposition where user_id in (select id  from  signin where fusion_id='$value') and DATE(start_date)='$ymddate'";
										$this->db->query($dSql);
										
										$iSql="INSERT INTO event_disposition (user_id, event_time, event_by, event_master_id, start_date, end_date, remarks, log) select id,'$uymdDate', '1', '$disp_id', '$ymddate', '$ymddate','$comments', '$log' from signin where fusion_id='$value'";
										$this->db->query($iSql);
										
										
									}
								
								}
						}
						
						$msg="Update Done on ".$uymdDate;
						
					}else{
						$msg="One or More fields are blank";
					}
					
				}
				
				if($udate=="") $udate="02-18-2019 14:14:14";
				$data['ddate']=$ddate;
				$data['udate']=$udate;
				
				$data['fids']=$fids;
				$data['lhrs']=$lhrs;
				$data['disp_id']=$disp_id;
				$data['log']=$log;
				$data['comments']=$comments;
				$data['msg']=$msg;
				
				$this->load->view('dashboard',$data);
			}
			
        }
    }
	
	
	private function is_access_reports($fusion_id) 
	{
				
		if($fusion_id=="FKOL000007" || $fusion_id=="FKOL000001")
		{
			return true;
		}else{
			return false;
		}
	}
	
	private function redirectors()
	{
		$role = get_role_id();
		if($role==1) return "admin";
		else return "tl";
	}
    
    
    
}

?>