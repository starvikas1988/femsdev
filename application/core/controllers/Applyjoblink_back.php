<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applyjoblink extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('auth_model');
		$this->load->model('Common_model');
		$this->load->model('applylink_model');
		
	 }
	
    public function index()
    {
				$data["error"] = '';
				//$token = $this->uri->segment(2);
				
				$token = $_SERVER['QUERY_STRING'];
				$token = base64_decode(urldecode($token));
								
				if(strlen($token)>15){
					
					//HWH2020003
					$reqcode=substr($token, 0, 10);
					$token=substr($token, 10);
					
					$qSql="Select id as value from  dfr_requisition where requisition_id='$reqcode'";
					$reqid = $this->Common_model->get_single_value($qSql);
					
					if($reqid>0){
						
						$qSql="Select  c.*, c.id as cid,requisition_id,location,job_title,job_desc,req_skill,req_qualification,req_exp_range,(select name from role r where r.id=dr.role_id) as role_name from dfr_candidate_details c 
						LEFT JOIN dfr_requisition dr ON dr.id=c.r_id 
						Where r_id='$reqid' and link_token='$token' and is_active_link_token='Y'";
						
						$crow=$this->Common_model->get_query_row_array($qSql);
						
						if(!empty($crow)){
							$dbToken=$crow['link_token'];
							$dbr_id=$crow['r_id'];
							$dbcid=$crow['cid'];
							$role_name=$crow['role_name'];
							$job_title=$crow['job_title'];
							$job_desc=$crow['job_desc'];
							$location=$crow['location'];
							
							if($dbToken!="" &&  $dbToken==$token && $dbcid>0){
								

								///
								$data['canrow'] = $crow;
								
								$data['rq_id'] = $reqcode;
								$data['job_title'] = $job_title;
								$data['r_id'] = $dbr_id;
								$data['cid'] = $dbcid;
																
								$data["captcha"] = $this->captcha();
								
								$qSql="Select fusion_id, xpoid, fname,lname, office_id, dept_id, (select shname from department d where d.id=signin.dept_id) as dept_name from signin where status=1 and office_id = '$location' and role_id > 0 ORDER BY fname";
								$data["user_list_ref"] = $this->Common_model->get_query_result_array($qSql);
								
								$country_pre_Sql="Select * FROM master_countries ORDER BY name ASC";
								$data["get_countries"] = $this->Common_model->get_query_result_array($country_pre_Sql);
								
								if($location != 'CEB' && $location != 'MAN')
								{
									$qual_quary=$this->db->query("SELECT * FROM `master_qualifications`  where location_id is null");
								}
								else
								{
									$qual_quary=$this->db->query("SELECT * FROM `master_qualifications` where location_id='".$location."'");
								}
								$data["qualification_list"] = $qual_quary->result_object();	

								$this->load->view('applylink/index',$data);
								
							}
						
						}else{
							echo "Link Expired";
						}
					}else{
						echo "Invalid Link";
					}
				}else{
					
					echo "Link Expired";
				}
				
	}
	
	
	public function captcha($reload='false')
	{
		$this->load->library('session');
		$this->load->helper('captcha');
		$vals = array(
				'img_path'      => './captcha/',
				'img_url'       => base_url('/captcha/'),
				'font_path'     => FCPATH .'/assets/font/Walkway_Oblique.ttf',
				'img_width'     => '250',
				'img_height'    => 45,
				'expiration'    => 7200,
				'word_length'   => 8,
				'font_size'     => 22,
				'img_id'        => 'Imageid',
				'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
				
				//abcdefghijklmnopqrstuvwxyz
				// White background and border, black text and red grid
				'colors'        => array(
						'background' => array(255, 255, 255),
						'border' => array(255, 255, 255),
						'text' => array(0, 0, 0),
						'grid' => array(255, 160, 40)
				)
		);

		$cap = create_captcha($vals);
		$this->session->set_userdata('cap_word', $cap['word']);
		$this->session->set_userdata('filename', $cap['filename']);
		if($reload == 'false')
		{
			return $cap;
		}
		else
		{
			echo json_encode($cap);
		}
	}
	
	
	public function check_mobile_exist()
	{
		$mobile_no = $this->input->post('mobile_no');
		$rq_id = $this->input->post('rq_id');
		$this->applylink_model->check_mobile($mobile_no,$rq_id);
		return false;
	}
	public function check_email_exist()
	{
		$email = $this->input->post('email');
		$rq_id = $this->input->post('rq_id');
		$this->applylink_model->check_email_exist($email,$rq_id);
		return false;
	}
	
	public function process_form()
	{
		$infos = $this->input->post();

		// print_r($_FILES);
		
		if(!isset($infos['comp_employee_name']))
		{
			$infos['comp_employee_name'] = '';
		}

		if(!isset($infos['service_standard']))
		{
			$infos['service_standard'] = '';
		}
		if(!isset($infos['interest']))
		{
			$infos['interest'] = '';
		}
		if(!isset($infos['married']))
		{
			$infos['married'] = '';
		}
		if(!isset($infos['dom']))
		{
			$infos['dom'] = '';
		}
		if(!isset($infos['experience']))
		{
			$infos['experience'] = '';
		}
		
		if(!isset($infos['referal']))
		{
			$infos['referal'] = '';
		}
		
		if(!isset($infos['conveyance']))
		{
			$infos['conveyance'] = '';
		}
		/* echo '<pre>';
		//print_r($infos);
		echo '</pre>';
		if(!empty($this->upload_file())
		{
	
		} */
		/* echo $infos['captcha'];
		echo $this->session->userdata('cap_word'); */
		
		if($infos['captcha'] == $this->session->userdata('cap_word'))
		{
			$candidate_id = $infos['cid'];
			
			$file_name="";
			$file_name2="";

			$this->upload_file($infos);
			if(!empty($_FILES['adhar_file_upload'])){
				$this->upload_file2($infos);
			}
			


			$path       = $_FILES['file_upload']['name'];
	        $ext        = pathinfo($path, PATHINFO_EXTENSION);
	        // print_r($this->upload_error);
			if(empty($this->upload_error)) $file_name = $infos['first_name']."_".$infos['last_name']."_".$candidate_id."_resume.".$ext;

			$adhar = "";
			$file_name2 = "";

			if(!empty($_FILES['adhar_file_upload'])){
			$path       = $_FILES['adhar_file_upload']['name'];
	        $ext        = pathinfo($path, PATHINFO_EXTENSION);
			if ($user_office_id == "MAN" || $user_office_id == "CEB") {
		        if(empty($this->upload_error)) $adhar = $infos[0]['fname']."_".$infos[0]['lname']."_SSS_doc.".$ext;
		        }
		        else{
		        	if(empty($this->upload_error)) $file_name2 = $infos[0]['fname']."_".$infos[0]['lname']."_adhar.".$ext;
		        }
		    }

			$this->db->trans_start();
				
			
			$link_token = $infos['link_token'];
			$r_id = $infos['r_id'];
			$link_sub_time = CurrMySqlDate();
			$ip = getClientIP(); // $_SERVER['REMOTE_ADDR'];
			$browser = $_SERVER['HTTP_USER_AGENT'];	
			$link_sub_log = " Date: ".$link_sub_time." RemoteIP: " . $ip ." Browser:".$browser;
		
				if($candidate_id >0){
				
					//convert it wih update
						
						
					$uparray = array(
						"is_active_link_token" => 'N',
						"link_sub_time" => $link_sub_time,
						"link_sub_log" => $link_sub_log,					
						"fname" => $infos['first_name'],
						"lname" => $infos['last_name'],
						"guardian_name" => $infos['guardian_name'],
						"relation_guardian" => $infos['relation_guardian'],
						"married_date" => $infos['dom'],
						"attachment_adhar" => $file_name2,
						"attachment_sss" => $adhar,
						"pan" => $infos['pan'],
						"adhar" => $infos['adhar'],
						"caste" => $infos['caste'],
						"r_id" => $infos['r_id'],
						"hiring_source" => $infos['referal'],
						"ref_name" => $infos['comp_employee_name'],
						"ref_dept" => $infos['comp_employee_dept'],
						"ref_id" => $infos['comp_employee_id'],
						"dob" => $infos['dob'],
						"email" => $infos['email'],
						"gender" => $infos['gender'],
						"phone" => $infos['mobile_no'],
						"alter_phone" => $infos['alternate_no'],
						"last_qualification" => $infos['last_qualification'],
						"skill_set" => $infos['skills'],
						"total_work_exp" => $infos['total_exp'],
						"address" => $infos['parmanent_address'],
						"correspondence_address" => $infos['correspondence_address'],
						"country" => $infos['country'],
						"state" => $infos['state'],
						"city" => $infos['city'],
						"postcode" => $infos['postcode'],
						"reference_1" => $infos['references_1'],
						"reference_2" => $infos['references_2'],
						"reference_3" => $infos['references_3'],
						"illness" => $infos['madical'],
						"accidents" => $infos['accidents'],
						"legal" => $infos['legal'],
						"job_leav_reason" => $infos['job_leav_reason'],
						"gross" => $infos['gross'],
						"take_home" => $infos['take_home'],
						"expected" => $infos['expected'],
						"24_7_service" => $infos['service_standard'],
						"notice_period" => $infos['notice_period'],
						"past_inter_date" => $infos['past_inter_date'],
						"past_employee" => $infos['past_employee'],
						"conveyance" => $infos['conveyance'],
						"experience" => $infos['experience'],
						"interest" => $infos['interest'],
						"interest_desc" => $infos['interest_desc'],
						"d_licence" => $infos['d_licence'],
						"home_town" => $infos['home_town'],
						"attachment" => $file_name,
						"added_date" => date("F j, Y, g:i a"),
						"married" => $infos['married'],
					);
					
					$this->db->where('id', $candidate_id);
					$this->db->where('r_id', $r_id);
					$this->db->where('link_token', $link_token);
					$this->db->where('is_active_link_token', 'Y');
					$this->db->update('dfr_candidate_details',$uparray);

					// print_r($this->db->error());

					
						
					// $this->db->query('INSERT INTO `dfr_candidate_details`(`guardian_name`,`relation_guardian`,`married_date`,`attachment_adhar`,`pan`,`adhar`,`caste`,`r_id`, `fname`, `lname`, `hiring_source`, `ref_name`, `ref_dept`, `ref_id`, `dob`, `email`, `gender`, `phone`,`alter_phone`, `last_qualification`, `skill_set`, `total_work_exp`, `address`,`correspondence_address`, `country`, `state`, `city`, `postcode`, `reference_1`, `reference_2`, `reference_3`, `illness`, `accidents`, `legal`,job_leav_reason,gross,take_home,expected,24_7_service,notice_period,past_inter_date,past_employee,conveyance,experience,interest,interest_desc,d_licence,home_town,attachment,added_date,married) VALUES ("'.$infos['guardian_name'].'","'.$infos['relation_guardian'].'","'.$infos['dom'].'","'.$file_name2.'","'.$infos['pan'].'","'.$infos['adhar'].'","'.$infos['caste'].'","'.$infos['r_id'].'","'.$infos['first_name'].'","'.$infos['last_name'].'","'.$infos['referal'].'","'.$infos['comp_employee_name'].'","'.$infos['comp_employee_dept'].'","'.$infos['comp_employee_id'].'","'.$infos['dob'].'","'.$infos['email'].'","'.$infos['gender'].'","'.$infos['mobile_no'].'","'.$infos['alternate_no'].'","'.$infos['last_qualification'].'","'.$infos['skills'].'","'.$infos['total_exp'].'","'.$infos['parmanent_address'].'","'.$infos['correspondence_address'].'","'.$infos['country'].'","'.$infos['state'].'","'.$infos['city'].'","'.$infos['postcode'].'","'.$infos['references_1'].'","'.$infos['references_2'].'","'.$infos['references_3'].'","'.$infos['madical'].'","'.$infos['accidents'].'","'.$infos['legal'].'","'.$infos['job_leav_reason'].'","'.$infos['gross'].'","'.$infos['take_home'].'","'.$infos['expected'].'","'.$infos['service_standard'].'","'.$infos['notice_period'].'","'.$infos['past_inter_date'].'","'.$infos['past_employee'].'","'.$infos['conveyance'].'","'.$infos['experience'].'","'.$infos['interest'].'","'.$infos['interest_desc'].'","'.$infos['d_licence'].'","'.$infos['home_town'].'","'.$file_name.'",now(),"'.$infos['married'].'")');
					
					foreach($infos['relation_type'] as $key=>$value)
					{
						if(!empty($infos['relative_name'][$key]))
						{
							$this->db->query('INSERT INTO `dfr_candidate_family_info`(`candidate_id`, `relation_type`, `name`, `occupation`) VALUES ("'.$candidate_id.'","'.$value.'","'.$infos['relative_name'][$key].'","'.$infos['relative_occupation'][$key].'")');
						}
					}
					
					// $org = array_filter($infos['org_name']);
					// foreach($org as $key=>$value)
					// {
					if(!empty($infos['org_name'])){
						$this->db->query('INSERT INTO `dfr_experience_details`(`candidate_id`, `company_name`, `designation`, `work_exp`, `job_desc`,added_date) VALUES ("'.$candidate_id.'","'.$infos['org_name'].'","'.$infos['designation'].'","'.$infos['tenure'].'","'.$infos['references'].'",now())');
					}
					if(!empty($infos['org_name2'])){
						$this->db->query('INSERT INTO `dfr_experience_details`(`candidate_id`, `company_name`, `designation`, `work_exp`, `job_desc`,added_date) VALUES ("'.$candidate_id.'","'.$infos['org_name2'].'","'.$infos['designation2'].'","'.$infos['tenure2'].'","'.$infos['references2'].'",now())');
					}
					if(!empty($infos['org_name3'])){
						$this->db->query('INSERT INTO `dfr_experience_details`(`candidate_id`, `company_name`, `designation`, `work_exp`, `job_desc`,added_date) VALUES ("'.$candidate_id.'","'.$infos['org_name3'].'","'.$infos['designation3'].'","'.$infos['tenure3'].'","'.$infos['references3'].'",now())');
					}
					
					foreach($infos['deg_type'] as $key=>$value)
					{
						$this->db->query('INSERT INTO `dfr_qualification_details`(`candidate_id`, `exam`, `board_uv`, `specialization`, `grade_cgpa`,added_date,school_name,passing_year) VALUES ("'.$candidate_id.'","'.$value.'","'.$infos['board_name'][$key].'","'.$infos['course_name'][$key].'","'.$infos['marks'][$key].'",now(),"'.$infos['school_name'][$key].'","'.$infos['pass_year'][$key].'")');
					}



					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
						$response = array('error'=>'query_error');
						echo json_encode($response);
					}
					else
					{
						$this->db->trans_commit();
						$candidate_id=urlencode(base64_encode($candidate_id));
						$response = array('error'=>'false','c_id'=>$candidate_id);
						echo json_encode($response);
					}
			
				}
				else
				{
					$response = array('error'=>'file_error');
					echo json_encode($response);
				}
		}
		else
		{
			$response = array('error'=>'cap_error');
			echo json_encode($response);
		} 
		}
		
		
	private function upload_file($infos)
	{
		// print_r($infos);
		// exit;
		$candidate_id = $infos['cid'];
		$config['upload_path'] = '../femsdev/uploads/candidate_resume/';
		$config['allowed_types'] = 'doc|docx|pdf';
		$path       = $_FILES['file_upload']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $infos['first_name']."_".$infos['last_name']."_".$candidate_id."_resume.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('file_upload'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			$this->file_name = $this->upload->data('file_name');
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
		}
	}


	private function upload_file2($infos)
	{
		// print_r($infos);
		// exit;
		$req_code = $infos['rq_id'];
		$user_office_id = substr($req_code, 0,3);
		$candidate_id = $infos['cid'];
		$config['upload_path'] = '../femsdev/uploads/candidate_aadhar/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['adhar_file_upload']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		if($user_office_id == "MAN" || $user_office_id == "CEB"){
		$config['file_name']      = $infos['first_name']."_".$infos['last_name']."_".$candidate_id."_SSS_doc.".$ext;
		}
		else{
			$config['file_name']      = $infos['first_name']."_".$infos['last_name']."_".$candidate_id."_adhar.".$ext;
		}
        
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('adhar_file_upload'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			$this->file_name = $this->upload->data('file_name');
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
		}
	}
	
	public function download_pdf($c_id)
	{
		
		$c_id = base64_decode(urldecode($c_id));
		//load mPDF library
		$this->load->library('m_pdf');
		
		$qSql="SELECT * from (Select *, DATE_FORMAT(added_date, '%m/%d/%Y') as addedDate from dfr_candidate_details where id='$c_id') xx Left Join (Select *, (select name from role r where r.id=dfr_requisition.role_id) as position_name from dfr_requisition) yy On (xx.r_id=yy.id)";
		
		$data["candidate_details"] = $this->Common_model->get_query_result_array($qSql);
		$crow = $data["candidate_details"][0];
		// print_r($data["candidate_details"]);
		//  print_r($$crow);
		// exit;
		
		$qSql="SELECT * FROM dfr_qualification_details where candidate_id='$c_id'";
		$data["can_education_details"] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql="SELECT * FROM dfr_experience_details where candidate_id='$c_id'";
		$data["can_experience_details"] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql="SELECT * FROM dfr_candidate_family_info where candidate_id='$c_id'";
		$data["can_family_details"] = $this->Common_model->get_query_result_array($qSql);
		$data['c_id'] = $c_id;  
		$html=$this->load->view('applylink/candidatedetails_pdf', $data, true);

		//this the the PDF filename that user will get to download
		$pdfFilePath = "candidate_".$crow['fname'].".pdf";
		
		$this->m_pdf->shrink_tables_to_fit;
	   //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);
		
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");	
	}
	
	public function get_consultancy_info()
	{
		$data_type = trim($this->input->post('data_type'));
		if($data_type == 'Job Portal')
		{
			$query = $this->db->query('SELECT * from master_job_portal_list WHERE is_active="1"');
		}
		else if($data_type == 'Consultancy')
		{
			$query = $this->db->query('SELECT * from master_consultancy_list WHERE is_active="1"');
		}
		
		if(!isset($query))
		{
			$row['stat'] = false;
		}
		else
		{
			if($query->num_rows() > 0)
			{
				$row['stat'] = true;
				$row['data'] = $query->result_object();
			}
			else 
			{
				$row['stat'] = false;
			}
		}
			
		echo json_encode($row);
	}
	public function stateList()
	{
		$json = array();
		$country	=	$this->input->post("country");
		$stateSql="Select * from master_states where country_id='$country' ORDER BY name ASC";
		$get_states = $this->Common_model->get_query_result_array($stateSql);
		$json = $get_states;
		echo json_encode($json);exit();
	}
	
	public function cityList()
	{
		$json = array();
		$state	=	$this->input->post("state");
		$citySql="Select * from master_cities where state_id='$state' ORDER BY name ASC";
		$get_cities = $this->Common_model->get_query_result_array($citySql);
		$json = $get_cities;
		echo json_encode($json);exit();
	}
	
	///////----- SET COOKIE -------------//////	
	public function set_cookie_search()
	{
		$name  = $this->uri->segment(3);
		$value = $this->uri->segment(4);
		$time  = $this->uri->segment(5);
		
		if(($name != "") && ($value != "") && ($time != ""))
		{
		   $cookie= array(
			   'name'   => $name,
			   'value'  => $value,                            
			   'expire' => $time,                                                                                   
			   'secure' => TRUE
		   );		   
		   $this->input->set_cookie($cookie);
		   //echo "SUCCESS - " .$name ." : " .$this->input->cookie($name);
		} else {
		   //echo "FAILED";
			}
		}

	public function documents()
	{
		$this->load->view('applyjob/documents');
	}
	
	
}

?>