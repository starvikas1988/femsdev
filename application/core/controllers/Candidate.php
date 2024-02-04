<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate extends CI_Controller {

    private $aside = "reports/aside.php";

	function __construct() {
	    parent::__construct();
		$this->load->helper(array('form', 'url', 'dfr_functions'));
		$this->load->model('Common_model');
		$this->load->model('Candidate_model');
		
    }

    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////

    public function index(){
        if(check_logged_in())
		{
            print_r(candidate_schedule_details(1));


        }
    } 


}