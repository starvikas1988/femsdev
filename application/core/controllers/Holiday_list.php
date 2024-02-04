<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday_list extends CI_Controller {

   
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
				
	 }
	 
    public function index(){	
		if(check_logged_in()){
			$get_office_id=get_user_office_id();
			
			$qSql="Select *, DAYNAME(holiday_date) as day_name from master_holiday_list where is_active=1 and location='$get_office_id'";
			$data["holidaylist"] = $this->Common_model->get_query_result_array($qSql);
			
            $this->load->view('holiday_list/holiday_list.php',$data);
        }
		
    }
	
	//////////////////////////////////////////////////////

	
	
}

?>