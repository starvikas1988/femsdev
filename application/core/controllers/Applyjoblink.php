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
				//echo $token;
				
				
				if(strlen($token)>5){
					
					$reqcode=substr($token, 0, 4);
					if($reqcode=="pool"){
						$token=substr($token, 4);
					}else{
						//HWH2020003
						$reqcode=substr($token, 0, 10);
						$token=substr($token, 10);
					}
					
					//echo "xxx". $reqcode;
					//echo "YYYYY". $token;
					
					//$qSql="Select id as value from  dfr_requisition where requisition_id='$reqcode'";
					//$reqid = $this->Common_model->get_single_value($qSql);
						
						$qSql="Select  c.*, c.id as cid,requisition_id,location,job_title,job_desc,req_skill,req_qualification,req_exp_range,(select name from role r where r.id=dr.role_id) as role_name, (select name from role rr where rr.id=c.pool_role_id) as pool_role_name from dfr_candidate_details c 
						LEFT JOIN dfr_requisition dr ON dr.id=c.r_id 
						Where link_token='$token' and is_active_link_token='Y'";
						
						//echo $qSql;
						
						$crow=$this->Common_model->get_query_row_array($qSql);
						
						if(!empty($crow)){
							$dbToken=$crow['link_token'];
							$dbr_id=$crow['r_id'];
							$dbcid=$crow['cid'];
							$role_name=$crow['role_name'];
							$job_title=$crow['job_title'];
							$job_desc=$crow['job_desc'];
							$location=$crow['location'];
							
							if($reqcode=="pool"){
								$location=$crow['pool_location'];
								$role_name=$crow['pool_role_name'];
								$job_title= "Pool Application for ".$role_name;
							}
							
							if($dbToken!="" &&  $dbToken==$token && $dbcid>0){
								

								///
								$data['canrow'] = $crow;
								
								$data['rq_id'] = $reqcode;
								$data['job_title'] = $job_title;
								$data['role_name'] = $role_name;
								$data['r_id'] = $dbr_id;
								$data['cid'] = $dbcid;
																
								$data["captcha"] = $this->captcha();
								
								$qSql="Select fusion_id, xpoid, fname,lname, office_id, dept_id, (select shname from department d where d.id=signin.dept_id) as dept_name from signin where status=1 and office_id = '$location' and role_id > 0 ORDER BY fname";
								$data["user_list_ref"] = $this->Common_model->get_query_result_array($qSql);
								
								$country_pre_Sql="Select * FROM master_countries ORDER BY name ASC";
								$data["get_countries"] = $this->Common_model->get_query_result_array($country_pre_Sql);
								
								if($location == 'CEB' || $location == 'MAN')
								{
									$qual_quary=$this->db->query("SELECT * FROM `master_qualifications` where location_id='".$location."'");
								}
								else
								{
									$qual_quary=$this->db->query("SELECT * FROM `master_qualifications`  where location_id is null");
								}
								
								$data["qualification_list"] = $qual_quary->result_object();
								
								$view_page="applylink/index_def";
								
								if(isIndiaLocation($location)==true) $view_page="applylink/index_ind";
								else if(isUSLocation($location)==true) $view_page="applylink/index_us";
								else if($location == 'CEB' || $location == 'MAN') $view_page="applylink/index_phil";
								else if($location == 'JAM') $view_page="applylink/index_jam";
								else if($location == 'ELS') $view_page="applylink/index_els";
								else $view_page="applylink/index_def";
									
								$this->load->view($view_page,$data);
								
							}
						
						}else{
							echo "Link Expired";
						}
					
				}else{
					
					echo "Link Expired";
				}
				
	}
	
	public function usa(){
		
		
		$data["error"] = '';
		
		
		$qual_quary=$this->db->query("SELECT * FROM `master_qualifications`  where location_id is null");
		$data["qualification_list"] = $qual_quary->result_object();
		
		$country_pre_Sql="Select * FROM master_countries ORDER BY name ASC";
		$data["get_countries"] = $this->Common_model->get_query_result_array($country_pre_Sql);
								
		$qSql="Select  c.*, c.id as cid,requisition_id,location,job_title,job_desc,req_skill,req_qualification,req_exp_range,(select name from role r where r.id=dr.role_id) as role_name, (select name from role rr where rr.id=c.pool_role_id) as pool_role_name from dfr_candidate_details c 
		LEFT JOIN dfr_requisition dr ON dr.id=c.r_id 
		Where c.id=10";
				
		$crow=$this->Common_model->get_query_row_array($qSql);
				
		$data['canrow'] = $crow;
		$data['rq_id'] = "";
		$data['job_title'] = "";
		$data['role_name'] = "agent";
		$data['r_id'] = "1";
		$data['cid'] = "10";
		
		$qual_quary=$this->db->query("SELECT * FROM `master_qualifications`  where location_id is null");
		$data["qualification_list"] = $qual_quary->result_object();
		
		$data['job_title'] =  "Application for Agent";
		$data['role_name'] =  "Agent";
		$data["captcha"] = $this->captcha();
		$view_page="applylink/index_us";								
		$this->load->view($view_page,$data);
	}
	
	public function sample(){
		
		$data["error"] = '';
		$qual_quary=$this->db->query("SELECT * FROM `master_qualifications`  where location_id is null");
		$data["qualification_list"] = $qual_quary->result_object();
		$data['job_title'] =  "Application for Agent";
		$data['role_name'] =  "Agent";
		$data["captcha"] = $this->captcha();
		$view_page="applylink/index_sample";								
		$this->load->view($view_page,$data);
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

		// print_r($infos);
		
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
			
			$adhar = "";
			$file_name2 = "";
			$file_name = "";
			$sign = "";
			$error = "0";
			
			if(!empty($_FILES['sign_file_upload']['name'])){
				$sign = $this->upload_file3($infos);
				if($sign==""){
				$error = "1";
				}
			}

			if(!empty($_FILES['file_upload']['name'])){
				$file_name = $this->upload_file($infos);
				if($file_name==""){
				$error = "1";
				}
			}

			if(!empty($_FILES['adhar_file_upload']['name'])){
				$adhar = $this->upload_file2($infos);
				if($adhar==""){
				$error = "1";
				}
			}
			

			// $path       = $_FILES['file_upload']['name'];
	  //       $ext        = pathinfo($path, PATHINFO_EXTENSION);
	  //       // print_r($this->upload_error);
			// if(empty($this->upload_error)) $file_name = $infos['first_name']."_".$infos['last_name']."_".$candidate_id."_resume.".$ext;

			

			// if(!empty($_FILES['adhar_file_upload']['name'])){
				
			// 	$path       = $_FILES['adhar_file_upload']['name'];
			// 	$ext        = pathinfo($path, PATHINFO_EXTENSION);
				
			// 	if(empty($this->upload_error)) $adhar = $infos['first_name']."_".$infos['last_name']."_ssn_doc.".$ext;
				
		 //    }

			$this->db->trans_start();
			
			$link_token = $infos['link_token'];
			$r_id = $infos['r_id'];
			$link_sub_time = CurrMySqlDate();
			$ip = getClientIP(); // $_SERVER['REMOTE_ADDR'];
			$browser = $_SERVER['HTTP_USER_AGENT'];	
			$link_sub_log = " Date: ".$link_sub_time." RemoteIP: " . $ip ." Browser:".$browser;
		
				if($error!=1){
				
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
						"attachment_adhar" => $adhar,
						"attachment_signature" => $sign,
						"pan" => $infos['pan'],
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
						// "reference_1" => $infos['references_1'],
						// "reference_2" => $infos['references_2'],
						// "reference_3" => $infos['references_3'],
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
						"attachment" => $file_name,
						"added_date" => date("F j, Y, g:i a"),
						"married" => $infos['married'],
					);
					if(!empty($infos['references_1'])) $uparray['reference_1'] = $infos['references_1'];
					if(!empty($infos['references_2'])) $uparray['reference_2'] = $infos['references_2'];
					if(!empty($infos['references_3'])) $uparray['reference_3'] = $infos['references_3'];
					if(!empty($infos['postcode'])) $uparray['postcode'] = $infos['postcode'];
					if(!empty($infos['adhar'])) $uparray['adhar'] = $infos['adhar'];
					if(!empty($infos['caste'])) $uparray['caste'] = $infos['caste'];
					if(!empty($infos['home_town'])) $uparray['home_town'] = $infos['home_town'];
					if(!empty($infos['state'])) $uparray['state'] = $infos['state'];
					if(!empty($infos['city'])) $uparray['city'] = $infos['city'];
					if(!empty($infos['nis'])) $uparray['nis_id'] = $infos['nis'];
					// print_r($uparray);
					// exit;
					
					//"r_id" => $infos['r_id'],
					
					$this->db->where('id', $candidate_id);
					//$this->db->where('r_id', $r_id);
					$this->db->where('link_token', $link_token);
					$this->db->where('is_active_link_token', 'Y');
					$this->db->update('dfr_candidate_details',$uparray);

					// print_r($this->db->error());

					$this->db->query('INSERT INTO `dfr_naps_candidate_details`(`dfr_id`,`nap_stat`) VALUES ("'.$candidate_id.'","0")');

					if(!empty($infos['relation_type'])){
						foreach($infos['relation_type'] as $key=>$value)
						{
							if(!empty($infos['relative_name'][$key]))
							{
								$this->db->query('INSERT INTO `dfr_candidate_family_info`(`candidate_id`, `relation_type`, `name`, `occupation`) VALUES ("'.$candidate_id.'","'.$value.'","'.$infos['relative_name'][$key].'","'.$infos['relative_occupation'][$key].'")');
							}
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
		//$BaseRealPath=$this->config->item('BaseRealPath');
		$config['upload_path'] = './uploads/candidate_resume/';
		
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
			return "";
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
			return $this->upload->data('file_name');
		}
	}


	private function upload_file2($infos)
	{
		// print_r($infos);
		// exit;
		$req_code = $infos['rq_id'];
		
		$candidate_id = $infos['cid'];
		$config['upload_path'] = './uploads/candidate_aadhar/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['adhar_file_upload']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		
		$config['file_name']      = $infos['first_name']."_".$infos['last_name']."_".$candidate_id."_ssn_doc.".$ext;
		        
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
			return "";
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
			return $this->upload->data('file_name');
		}
	}

	private function upload_file3($infos)
	{
		// print_r($infos);
		// exit;
		$req_code = $infos['rq_id'];
		
		$candidate_id = $infos['cid'];
		$config['upload_path'] = './uploads/candidate_sign/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$path       = $_FILES['sign_file_upload']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		
		$config['file_name']      = $infos['first_name']."_".$infos['last_name']."_".$candidate_id."_sign_doc.".$ext;
		        
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sign_file_upload'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			$this->file_name = $this->upload->data('file_name');
			return "";
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
			return $this->upload->data('file_name');
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

		else if($data_type == 'Call By HR'){
			//$sql="select *,concat(fname,' ',lname) as hr_name from signin where dept_id=3 and status=1 and office_id in('KOL', 'HWH', 'BLR', 'CHE', 'NOI','MUM')";
			
			$sql="select *,concat(fname,' ',lname) as hr_name from signin where dept_id=3 and status=1 ";
			$query = $this->db->query($sql);
			
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
		if($data_type == 'Word of Mouth')
		{
			$row['data'] = Array(
			            '0' => array(
			            	'wom' => 'Friends'
			            ),
			            '1' => array(
			            	'wom' => 'Family'
			            ),
			            '2' => array(
			            	'wom' => 'Former Fusion Employee'
			            )   
		   	);
		   	
			$row['stat']  = 1;
		}

		else if($data_type == 'Sourcing Collateral')
		{
			$row['data'] = Array(
			            '0' => array(
			            	'sourcing_colat' => 'Flyer'
			            ),
			            '1' => array(
			            	'sourcing_colat' => 'Banner'
			            ),
			            '2' => array(
			            	'sourcing_colat' => 'Poster'
			            )   
		   	);
		   	
			$row['stat']  = 1;
		}

		
		// print_r($row);
		// exit;
			
		echo json_encode($row);
	}

	public function get_hr_info(){
		/*$sql="select * from signin where dept_id=3 and status=1 and office_id in('KOL', 'HWH', 'BLR', 'CHE', 'NOI','MUM')";
		$hrd = $this->Common_model->get_query_result_array($sql);
		$data="";
		foreach($hrd as $k=>$rows){

		}*/
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