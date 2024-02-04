<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_email_restruc_letter extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Email_model');
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
			
			$data["content_template"] = "utils/email_restruc_letter.php";
					
			$fids="";
			$comments="";
			$msg="";
			$errmsg="";
			$mCond="";
			
			

				if($this->input->get('runUpdate')=='Send Email')
				{
					
					
					
					$fids = $this->input->get('fids');
										
					if($fids!="" )
					{
						$fidArray=explode(",",$fids);
						//echo $ldate. " <br> ";
						//print_r($fidArray);
						
						foreach ($fidArray as $fusion_id) {
							
							$fusion_id=trim($fusion_id);
														
							$qSql="Select id, concat(fname, ' ', lname) as c_name,  (Select email_id_per from info_personal ip  where ip.user_id=b.id) as email_id_per from  signin b where fusion_id='$fusion_id'";
							
							$row = $this->Common_model->get_query_row_array($qSql);
							$uid= $row['id'];
							$c_name= $row['c_name'];
							$email_id_per= $row['email_id_per'];
							
							if($uid!=""){
														
								$pdfFileName = $this->candidate_offer_pdf($uid,'Y','Y');
								$offer_letter = FCPATH."temp_files/offer_letter/".$pdfFileName;
								$this->Email_model->send_email_restruc_letter($current_user,$uid,$c_name,$email_id_per,$offer_letter);
							
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
				
			
				
			$data['fids']=$fids;
			$data['comments']=$comments;
			$data['msg']=$msg;
			$this->load->view('dashboard',$data);
				
        }
    }
	
	


	public function candidate_offer_pdf($user_id,$isLHead='Y',$isSave='N'){ 
			
			if(check_logged_in()){
				
			//load mPDF library
			$this->load->library('m_pdf');
						
			$qSql="SELECT b.id,fusion_id, fname,lname, office_id,role_id,org_role_id, (Select name from role a  where a.id=b.role_id) as role_name, (Select office_name from office_location k  where k.abbr=b.office_id) as office_name, (Select gross_pay from info_payroll ip  where ip.user_id=b.id) as gross_pay from signin b where id=$user_id ";
			
			//echo $qSql;
			
			$data["can_dtl_row"] = $can_dtl_row = $this->Common_model->get_query_row_array($qSql);
			$location= $can_dtl_row['office_id'];
			if($location=="") $location = $can_dtl_row['pool_location'];
			
			$fname= $can_dtl_row['fname'];
			$lname= $can_dtl_row['lname'];
			$pay_type= 1;
			
			$html="";
			
			//$location="HWH";
			
			$footer="";
			$header="";
			
			$html=$this->load->view('utils/candidateoffer_restruct_pdf.php', $data, true);
			
			if($location=="HWH"){
				
				$header="<div><img src='" . APPPATH . "/../assets/images/logohwr.png' height='70px;'></div>";
				$footer = "<p style='text-align:center; font-weight:lighter; '>
					<span style='font-size:14px'>WINDOW TECHNOLOGIES PVT LTD.</span><br>
						<span style='font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
						<span style='font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
						<span style='font-size:11px'>www.fusionbposervices.com</span>
					</p>";
			
			}
			else if($location=="KOL" || $location=="BLR" || $location=="NOI" || $location=="CHE" ){
				
				$header="<div><img src='" . APPPATH . "/../assets/images/logoxt.jpg' height='80px;'></div>";
				
				$footer = "<p style='text-align:center; font-weight:lighter; '><span style='font-size:14px'>XPLORE-TECH SERVICES PRIVATE LIMITED</span><br>
				<span style='font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
				<span style='font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
				<span style='font-size:11px'>www. xplore-tech.com</span><br>
				<span style='font-size:11px'>www.fusionbposervices.com</span></p>";
				
			}else $html="";
			

			if($isLHead=="Y"){
				$this->m_pdf->pdf->SetHTMLHeader($header);
				$this->m_pdf->pdf->SetHTMLFooter($footer);	
			}
			
			
			//this the the PDF filename that user will get to download
			$pdfFileName = $fname."_".$lname."_offer_letter".$c_id.".pdf";
			
			$this->m_pdf->shrink_tables_to_fit;
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
			
			//download it.
			if($isSave=="Y") {
				$file_path =FCPATH."temp_files/offer_letter/".$pdfFileName;
				$this->m_pdf->pdf->Output($file_path, "F");
				return $pdfFileName;
			}
			else $this->m_pdf->pdf->Output($pdfFileName, "D");		
		}
			
	}


	
      
}

?>