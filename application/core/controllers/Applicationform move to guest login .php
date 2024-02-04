<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applicationform extends CI_Controller {


    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->model('applicationform_model');
		$this->load->model('Dfr_model');
		
	 }
	
	public function index()
    {	
		$_filterCond = '';
		$data["get_requisition"] = $this->Dfr_model->get_requisition_data($_filterCond);
		$data["content_template"] = "applicationform/confirmed_requisitions.php";
		
		$this->load->view('applicationform/confirmed_requisitions',$data);
    }
	
    public function fill($rq_id,$job_title,$r_id)
    {	
		$data['rq_id'] = $rq_id;
		$data['job_title'] = $job_title;
		$data['r_id'] = $r_id;
		$data["content_template"] = "applicationform/applicationform_view.php";
		
		$this->load->view('applicationform/applicationform_view',$data);
    }
	
	public function check_mobile_exist()
	{
		$mobile_no = $this->input->post('mobile_no');
		$rq_id = $this->input->post('rq_id');
		echo $this->applicationform_model->check_mobile($mobile_no,$rq_id);
	}
	public function check_email_exist()
	{
		$email = $this->input->post('email');
		$rq_id = $this->input->post('rq_id');
		
		echo $this->applicationform_model->check_email_exist($email,$rq_id);
	}
	
	public function process_form()
	{
		$infos = $this->input->post();
		if(!isset($infos['referal']))
		{
			$infos['referal'] = '';
		}
		if(!isset($infos['conveyance']))
		{
			$infos['conveyance'] = '';
		}
		echo '<pre>';
		print_r($infos);
		echo '</pre>';
		
		
		
		$this->db->query('INSERT INTO `dfr_candidate_details`(`r_id`, `requisition_id`, `fname`, `lname`, `hiring_source`, `ref_name`, `ref_dept`, `ref_id`, `dob`, `email`, `gender`, `phone`,`alter_phone`, `last_qualification`, `skill_set`, `total_work_exp`, `address`,`correspondence_address`, `country`, `state`, `city`, `postcode`, `reference_1`, `reference_2`, `reference_3`, `illness`, `accidents`, `legal`, `form_submission_date`,job_leav_reason,gross,take_home,expected,24_7_service,notice_period,past_inter_date,past_employee,conveyance,experience,interest,interest_desc,d_licence,home_town) VALUES ("'.$infos['r_id'].'","'.$infos['rq_id'].'","'.$infos['first_name'].'","'.$infos['last_name'].'","'.$infos['referal'].'","'.$infos['comp_employee_name'].'","'.$infos['comp_employee_dept'].'","'.$infos['comp_employee_id'].'","'.$infos['dob'].'","'.$infos['email'].'","'.$infos['gender'].'","'.$infos['mobile_no'].'","'.$infos['alternate_no'].'","'.$infos['last_qualification'].'","'.$infos['skills'].'","'.$infos['total_exp'].'","'.$infos['parmanent_address'].'","'.$infos['correspondence_address'].'","'.$infos['country'].'","'.$infos['state'].'","'.$infos['city'].'","'.$infos['postcode'].'","'.$infos['references'][0].'","'.$infos['references'][1].'","'.$infos['references'][2].'","'.$infos['madical'].'","'.$infos['accidents'].'","'.$infos['legal'].'",now(),"'.$infos['job_leav_reason'].'","'.$infos['gross'].'","'.$infos['take_home'].'","'.$infos['expected'].'","'.$infos['service_standard'].'","'.$infos['notice_period'].'","'.$infos['past_inter_date'].'","'.$infos['past_employee'].'","'.$infos['conveyance'].'","'.$infos['experience'].'","'.$infos['interest'].'","'.$infos['interest_desc'].'","'.$infos['d_licence'].'","'.$infos['home_town'].'")');
		
		$candidate_id = $this->db->insert_id();
		
		foreach($infos['relation_type'] as $key=>$value)
		{
			if(!empty($infos['relative_name'][$key]))
			{
				$this->db->query('INSERT INTO `dfr_candidate_family_info`(`candidate_id`, `relation_type`, `name`, `occupation`) VALUES ("'.$candidate_id.'","'.$value.'","'.$infos['relative_name'][$key].'","'.$infos['relative_occupation'][$key].'")');
			}
		}
		
		$org = array_filter($infos['org_name']);
		foreach($org as $key=>$value)
		{
			$this->db->query('INSERT INTO `dfr_experience_details`(`candidate_id`, `company_name`, `designation`, `work_exp`, `job_desc`) VALUES ("'.$candidate_id.'","'.$value.'","'.$infos['designation'][$key].'","'.$infos['tenure'][$key].'","'.$infos['references'][$key].'")');
		}
		
		foreach($infos['deg_type'] as $key=>$value)
		{
			$this->db->query('INSERT INTO `dfr_qualification_details`(`candidate_id`, `exam`, `board_uv`, `specialization`, `grade_cgpa`) VALUES ("'.$candidate_id.'","'.$value.'","'.$infos['board_name'][$key].'","'.$infos['course_name'][$key].'","'.$infos['marks'][$key].'")');
		}
	}
}

?>