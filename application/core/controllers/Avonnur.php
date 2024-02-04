<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avonnur extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    private $aside = "avon_nur/aside.php";
	 function __construct() {
		parent::__construct();
		
		$this->load->model('auth_model');
		$this->load->model('Common_model');
		
	 }

	private function check_access()
	{
		if(get_global_access()!='1' && get_dept_folder() !="hr" && get_role_dir()!="super") redirect(base_url()."home","refresh");
	} 
	
    public function index()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/complaint.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}

	public function cycle_count_additions()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/cycle_count_additions.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function eod_holiday()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/eod_holiday.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function product_exchange()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/product_exchange.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
   public function post_receipt_discrepancy_adjustment()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/post_receipt_discrepancy_adjustment.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function request_for_sl_certification()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/request_for_sl_certification.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function request_for_2307()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/request_for_2307.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}

	public function request_for_surety_line()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/request_for_surety_line.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function manual_voiding_of_transaction()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/manual_voiding_of_transaction.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function idf_concern()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/idf_concern.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function request_for_provisional_receipt()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/request_for_provisional_receipt.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function request_for_manual_sales_invoice()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/request_for_manual_sales_invoice.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function request_for_miscellaneous_official_receipt()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/request_for_miscellaneous_official_receipt.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function credit_line_adjustment_due_to_branch_error()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/credit_line_adjustment_due_to_branch_error.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function credit_line_increase_request_category_one()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/credit_line_increase_request_category_one.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function credit_line_decrease_request()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/credit_line_decrease_request.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function delay_deposit()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/delay_deposit.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function delay_deposit_two()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/delay_deposit_two.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function delay_deposit_three()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/delay_deposit_three.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function delay_deposit_four()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/delay_deposit_four.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function payment_plan()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/payment_plan.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function admin_charge_recon()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/admin_charge_recon.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function lift_suspension_of_checking_privilege()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/lift_suspension_of_checking_privilege.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function lift_suspension_of_sl_atp()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/lift_suspension_of_sl_atp.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function additional_credit_line_taho()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/additional_credit_line_taho.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function ar_adjustment()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/ar_adjustment.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function credit_hold_release()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/credit_hold_release.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function sure_orders()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/sure_orders.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function dr_pulling()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/dr_pulling.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function price_adjustment()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/price_adjustment.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function delay_deposit_category_five()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/delay_deposit_category_five.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function credit_line_restoration_of_removed()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/credit_line_restoration_of_removed.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function defective_staging()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/defective_staging.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function defective_return()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/defective_return.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function defective_storage()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/defective_storage.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";         
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function defective_supermarket()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/defective_supermarket.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";           
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function defective_csa()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/defective_csa.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";        
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	public function defective_csa_test()
    {			
		if(check_logged_in())
        {	
        	$this->check_access();

			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "avon_nur/defective_csa_test.php";
            $data["content_js"] = "avon_nur/avon_nur_js.php";
            $data["error"] = ''; 	

			$this->load->view('dashboard',$data);
								
        }			
	}
	//submitting form
	public function complaint_form()
	{  
		$tablename = 'av_sr_complaint';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		$data = $infos;
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully";
				}else{
					$msg='Something went wrong';
				}
    		}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function cycle_count_additions_form()
	{  
		$tablename = 'av_sr_cycle_count_additions';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function eod_holiday_form()
	{  
		$tablename = 'av_sr_eod_holiday';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
	    $file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function product_exchange_form()
	{  
		$tablename = 'av_sr_pro_exchnge';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
	    $file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function post_receipt_discrepancy_adjustment_form()
	{  
		$tablename = 'av_sr_discrepancy_adjustment';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
	    $file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function request_for_sl_certification_of_earnings_sf_form()
	{  
		$tablename = 'av_sr_request_for_sl_certification';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function request_for_2307_form()
	{  
		$tablename = 'av_sr_request_for_2307';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function request_for_surety_line_form()
	{  
		$tablename = 'av_sr_request_for_surety_line';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$surety_allocated_file = $_FILES['surety_allocated_file']['name'];
		$surety_line_report_file = $_FILES['surety_line_report_file']['name'];
		$upline_report_file = $_FILES['upline_report_file']['name'];
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];

		if(check_logged_in()){
			if($surety_allocated_file !=""){
				$data['surety_allocated_file'] = $this->do_upload('surety_allocated_file',$surety_allocated_file);
			}

			if($surety_line_report_file !=""){
				$data['surety_line_report_file'] = $this->do_upload('surety_line_report_file',$surety_line_report_file);
			}

			if($upline_report_file !=""){
				$data['upline_report_file'] = $this->do_upload('upline_report_file',$upline_report_file);
			}

			if($file1 !=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2 !=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != "" && $data['surety_allocated_file'] != "" && $data['surety_line_report_file'] != "" && $data['upline_report_file'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function manual_voiding_of_transaction_form()
	{  
		$tablename = 'av_sr_manual_voiding';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function idf_concern_form()
	{  
		$tablename = 'av_sr_idf_concern';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function request_for_manual_sales_receipt_form()
	{  
		$tablename = 'av_sr_manual_sales_receipt';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function request_for_miscellaneous_official_receipt_form()
	{  
		$tablename = 'av_sr_misc_official_rcpt';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function credit_line_adjustment_due_to_branch_error_form()
	{  
		$tablename = 'av_sr_credit_line_adjstmnt';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function credit_line_increase_request_category_1_form()
	{  
		$tablename = 'av_sr_credit_line_incrse_cat1';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		if(check_logged_in()){
			$msg='';
			$this->db->insert($tablename, $data);
			$insert_id = $this->db->insert_id();
			if (!empty($insert_id)) {
				$msg = "Form Submitted Sucessfully"; 
			}else{
				$msg='Something went wrong';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function credit_line_decrease_request_form()
	{  
		$tablename = 'av_sr_credit_line_decrease_request';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function delay_deposit_form()
	{  
		$tablename = 'av_sr_delay_deposit';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function delay_deposit_two_form()
	{  
		$tablename = 'av_sr_delay_deposit_two';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function delay_deposit_three_form()
	{  
		$tablename = 'av_sr_delay_deposit_three';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function delay_deposit_four_form()
	{  
		$tablename = 'av_sr_delay_deposit_four';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function payment_plan_form()
	{  
		$tablename = 'av_sr_payment_plan';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function admin_charge_recon_form()
	{  
		$tablename = 'av_sr_admin_chrg_recon';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function lift_suspension_of_checking_privilege_form()
	{  
		$tablename = 'av_sr_lift_suspension';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$rqst_file = $_FILES['rqst_file']['name'];
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}

			if($rqst_file!=""){
				$data['rqst_file'] = $this->do_upload('rqst_file',$rqst_file);
			}
			if($data['file1'] != "" && $data['file2'] != "" && $data['rqst_file'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function lift_suspension_of_sl_atp_form()
	{  
		$tablename = 'av_sr_suspension_sl_atp';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$request_file = $_FILES['request_file']['name'];
		$reason_file = $_FILES['reason_file']['name'];
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($request_file!=""){
				$data['request_file'] = $this->do_upload('request_file',$request_file);
			}

			if($reason_file!=""){
				$data['reason_file'] = $this->do_upload('reason_file',$reason_file);
			}
			if($data['file1'] != "" && $data['file2'] != "" && $data['request_file'] != "" && $data['reason_file'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function additional_credit_line_taho_form()
	{  
		$tablename = 'av_sr_additional_credit_line_taho';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function ar_adjustment_form()
	{  
		$tablename = 'av_sr_ar_adjstmnt';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function credit_hold_release_form()
	{  
		$tablename = 'av_sr_credit_hold_release';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
			
		$attach_or = $_FILES['attach_or']['name'];
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($attach_or!=""){
				$data['attach_or'] = $this->do_upload('attach_or',$attach_or);
			}
			if($data['file1'] != "" && $data['file2'] != "" && $data['attach_or'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function dr_pulling_form()
	{  
		$tablename = 'av_sr_dr_pulling';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
					$msg='file upload error';
				}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function price_adjustment_form()
	{  
		$tablename = 'av_sr_price_adjstmnt';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function sure_orders_form()
	{  
		$tablename = 'av_sr_sure_ordrs';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		$data = $infos;
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$msg = "Form Submitted Sucessfully"; 
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    private function list_data_insertion($insert_id,$form_title,$origin_warehouse_array,$fsc_array,$description_array,$nature_of_defect_array,$qty_array){
    	$tablename_list = 'av_sr_defective_list_data';
    	for ($i = 0; $i < count($origin_warehouse_array); $i++) {

					$list_data = array(
						"defective_id" => $insert_id,
						"form_title" => $form_title,
						"origin_warehouse" => $origin_warehouse_array[$i],
						"fsc" => $fsc_array[$i],
						"description" => $description_array[$i],
						"nature_of_defect" => $nature_of_defect_array[$i],
						"qty" => $qty_array[$i]
					);
					$this->db->insert($tablename_list, $list_data);
    	}
    	$msg = "Form Submitted Sucessfully"; 
    	return $msg;

    } 
    public function defective_staging_form()
	{  
		$tablename = 'av_sr_defective_staging';
		$current_user = get_user_id();
		$infos = $this->input->post();
		$data = array(
					"branch" => $infos['branch'],
					"email" => $infos['email'],
					"ph_no" => $infos['ph_no'],
					"rqsted_by" => $infos['rqsted_by'],
					"notes" => $infos['notes'],
					"created_by" => $current_user,
					"created_on" => date('Y-m-d H:i:s')
				);
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$origin_warehouse_array = $infos['origin_warehouse'];
	    			$fsc_array =$infos['fsc'];
	    			$description_array =$infos['description'];
	    			$nature_of_defect_array =$infos['nature_of_defect'];
	    			$qty_array =$infos['qty'];
	    			$form_title =$infos['form_title'];

	    			$msg = $this->list_data_insertion($insert_id,$form_title,$origin_warehouse_array,$fsc_array,$description_array,$nature_of_defect_array,$qty_array);
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function defective_return_form()
	{  
		$tablename = 'av_sr_defective_return';
		$current_user = get_user_id();
		$infos = $this->input->post();
		$data = array(
					"branch" => $infos['branch'],
					"email" => $infos['email'],
					"ph_no" => $infos['ph_no'],
					"rqsted_by" => $infos['rqsted_by'],
					"notes" => $infos['notes'],
					"created_by" => $current_user,
					"created_on" => date('Y-m-d H:i:s')
				);
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$origin_warehouse_array = $infos['origin_warehouse'];
	    			$fsc_array =$infos['fsc'];
	    			$description_array =$infos['description'];
	    			$nature_of_defect_array =$infos['nature_of_defect'];
	    			$qty_array =$infos['qty'];
	    			$form_title =$infos['form_title'];

	    			$msg = $this->list_data_insertion($insert_id,$form_title,$origin_warehouse_array,$fsc_array,$description_array,$nature_of_defect_array,$qty_array);
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function defective_storage_form()
	{  
		$tablename = 'av_sr_defective_storage';
		$current_user = get_user_id();
		$infos = $this->input->post();
		$data = array(
					"branch" => $infos['branch'],
					"email" => $infos['email'],
					"ph_no" => $infos['ph_no'],
					"rqsted_by" => $infos['rqsted_by'],
					"notes" => $infos['notes'],
					"created_by" => $current_user,
					"created_on" => date('Y-m-d H:i:s')
				);
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$origin_warehouse_array = $infos['origin_warehouse'];
	    			$fsc_array =$infos['fsc'];
	    			$description_array =$infos['description'];
	    			$nature_of_defect_array =$infos['nature_of_defect'];
	    			$qty_array =$infos['qty'];
	    			$form_title =$infos['form_title'];

	    			$msg = $this->list_data_insertion($insert_id,$form_title,$origin_warehouse_array,$fsc_array,$description_array,$nature_of_defect_array,$qty_array);
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function defective_supermarket_form()
	{  
		$tablename = 'av_sr_defective_supermarket';
		$current_user = get_user_id();
		$infos = $this->input->post();
		$data = array(
					"branch" => $infos['branch'],
					"email" => $infos['email'],
					"ph_no" => $infos['ph_no'],
					"rqsted_by" => $infos['rqsted_by'],
					"notes" => $infos['notes'],
					"created_by" => $current_user,
					"created_on" => date('Y-m-d H:i:s')
				);
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$origin_warehouse_array = $infos['origin_warehouse'];
	    			$fsc_array =$infos['fsc'];
	    			$description_array =$infos['description'];
	    			$nature_of_defect_array =$infos['nature_of_defect'];
	    			$qty_array =$infos['qty'];
	    			$form_title =$infos['form_title'];

	    			$msg = $this->list_data_insertion($insert_id,$form_title,$origin_warehouse_array,$fsc_array,$description_array,$nature_of_defect_array,$qty_array);
				}else{
					$msg='Something went wrong';
				}
			}else{
					$msg='file upload error';
				}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function defective_csa_form()
	{  
		$tablename = 'av_sr_defective_csa';
		$current_user = get_user_id();
		$infos = $this->input->post();
		$data = array(
					"branch" => $infos['branch'],
					"email" => $infos['email'],
					"ph_no" => $infos['ph_no'],
					"rqsted_by" => $infos['rqsted_by'],
					"notes" => $infos['notes'],
					"created_by" => $current_user,
					"created_on" => date('Y-m-d H:i:s')
				);
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$origin_warehouse_array = $infos['origin_warehouse'];
	    			$fsc_array =$infos['fsc'];
	    			$description_array =$infos['description'];
	    			$nature_of_defect_array =$infos['nature_of_defect'];
	    			$qty_array =$infos['qty'];
	    			$form_title =$infos['form_title'];

	    			$msg = $this->list_data_insertion($insert_id,$form_title,$origin_warehouse_array,$fsc_array,$description_array,$nature_of_defect_array,$qty_array);
				}else{
					$msg='Something went wrong';
				}
			}else{
					$msg='file upload error';
				}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function defective_csa_test_form()
	{  
		$tablename = 'av_sr_defective_csa_test';
		$current_user = get_user_id();
		$infos = $this->input->post();
		$data = array(
					"branch" => $infos['branch'],
					"email" => $infos['email'],
					"ph_no" => $infos['ph_no'],
					"rqsted_by" => $infos['rqsted_by'],
					"notes" => $infos['notes'],
					"created_by" => $current_user,
					"created_on" => date('Y-m-d H:i:s')
				);
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($data['file1'] != "" && $data['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $data);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
					$origin_warehouse_array = $infos['origin_warehouse'];
	    			$fsc_array =$infos['fsc'];
	    			$description_array =$infos['description'];
	    			$nature_of_defect_array =$infos['nature_of_defect'];
	    			$qty_array =$infos['qty'];
	    			$form_title =$infos['form_title'];

	    			$msg = $this->list_data_insertion($insert_id,$form_title,$origin_warehouse_array,$fsc_array,$description_array,$nature_of_defect_array,$qty_array);
				}else{
					$msg='Something went wrong';
				}
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function delay_deposit_category_five_form()
	{  
		$tablename = 'av_sr_delay_deposit_category_five';
		$current_user = get_user_id();
		$infos = $this->input->post();
		
		$file1 = $_FILES['file1']['name'];
		$file2 = $_FILES['file2']['name'];
		if(check_logged_in()){
			if($file1!=""){
				$data['file1'] = $this->do_upload('file1',$file1);
			}
			
			if($file2!=""){
				$data['file2'] = $this->do_upload('file2',$file2);
			}
			if($infos['file1'] != "" && $infos['file2'] != ""){
				$msg='';
				$this->db->insert($tablename, $infos);
				$insert_id = $this->db->insert_id();
				if (!empty($insert_id)) {
	    			$msg='Form Submitted Sucessfully';
				}else{
					$msg='Something went wrong';
				}			
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg));
		}
    }
    public function credit_line_restoration_of_removed_form()
	{  
		if(check_logged_in()){		
			$tablename = 'av_sr_credit_line_restoration_of_removed';
			$current_user = get_user_id();
			$infos = $this->input->post();
			
			$infos['attachment'] = $this->do_upload();
			if($infos['attachment'] != ""){

					$msg='';
					$this->db->insert($tablename, $infos);
					$insert_id = $this->db->insert_id();
					if (!empty($insert_id)) {
						$msg='Form Submitted Sucessfully';
					}else{
						$msg='Something went wrong';
					}
					
			}else{
				$msg='file upload error';
			}
			echo json_encode(array('msg' => $msg, ));
		}
		
    }
    public function do_upload($fileName,$image)
    {
		$config['upload_path']          = "./uploads/avon_image/";
        $config['allowed_types']        = 'gif|jpg|png|jpeg|csv|application/vnd.openxmlformats-officedocument.spreadsheetml.sheet| application/vnd.ms-excel';

        $this->load->library('upload', $config);
 
    	if ( ! $this->upload->do_upload($fileName))
        {
            return "";
        }else{
        	return $this->upload->data('file_name');
        }
        
    }
}
?>