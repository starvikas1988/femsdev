<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentuploadlink extends CI_Controller {


    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    public $file_name;
    public $upload_error;
	 function __construct() {
		parent::__construct();
		$this->load->model('applicationform_model');
		$this->load->model('Dfr_model');
		$this->load->model('Common_model');
		$this->load->helper('cookie');
		
	 }


	public function index()
	{	
		$data["error"] = '';
				//$token = $this->uri->segment(2);
				
				$token = $_SERVER['QUERY_STRING'];
				// echo $token; exit;
				$token = base64_decode(urldecode($token));
								// echo $token; exit;
				if(strlen($token)>15){
					
					//HWH2020003
					$reqcode=substr($token, 0, 10);
					// echo $reqcode; exit;
					$token=substr($token, 10);
					// echo $token; exit;
					$qSql="Select id as value from  dfr_requisition where requisition_id='$reqcode'";
					$reqid = $this->Common_model->get_single_value($qSql);
					
					if($reqid>0){
						
						$qSql="Select  c.*, c.id as cid,requisition_id,location,job_title,job_desc,req_skill,req_qualification,req_exp_range,(select name from role r where r.id=dr.role_id) as role_name from dfr_candidate_details c 
						LEFT JOIN dfr_requisition dr ON dr.id=c.r_id 
						Where r_id='$reqid' and doc_link_token='$token' and is_active_doc_token='Y'";
						
						$crow=$this->Common_model->get_query_row_array($qSql);
						// print_r($crow);
						if(!empty($crow)){

							$dbToken=$crow['doc_link_token'];
							$dbr_id=$crow['r_id'];
							$dbcid=$crow['cid'];
							
							if($dbToken!="" &&  $dbToken==$token && $dbcid>0){
								
								$data['user_office_id']= substr($reqcode, 0,3);
								$location = substr($reqcode, 0,3);
								$c_id = $dbcid;
								$data['c_id'] = $dbcid;
								// $data['location'] = $location;
								$data["captcha"] = $this->captcha();
								$personalSql="Select pan from dfr_candidate_details where id='$c_id'";
								$data["get_personal"] = $this->Common_model->get_query_result_array($personalSql);

								$personalSql="Select * from dfr_candidate_details where id='$c_id'";
								$data["get_person"] = $this->Common_model->get_query_result_array($personalSql);

								$expSql="Select * from dfr_experience_details where candidate_id ='$c_id'";
								$data["get_exp"] = $this->Common_model->get_query_result_array($expSql);
								
								$eduSql="Select * from dfr_qualification_details where candidate_id='$c_id'";
								$data["get_edu"] = $this->Common_model->get_query_result_array($eduSql);

								//qualification master//
								if($location == 'CEB' || $location == 'MAN')
								{
									$qual_quary=$this->db->query("SELECT * FROM `master_qualifications` where location_id='".$location."'");
								}
								else
								{
									$qual_quary=$this->db->query("SELECT * FROM `master_qualifications`  where location_id is null");
								}
								
								$data["qualification_list"] = $qual_quary->result_object();

								if(isIndiaLocation($location)==true) $view_page="documentuploadlink/documents_ind";
								else if(isUSLocation($location)==true) $view_page="documentuploadlink/documents_us";
								else if($location == 'CEB' || $location == 'MAN') $view_page="documentuploadlink/documents_phil";
								else if($location == 'JAM') $view_page="documentuploadlink/documents_jam";
								else if($location == 'ELS') $view_page="documentuploadlink/documents_els";
								else $view_page="documentuploadlink/documents";

								$this->load->view($view_page,$data);

							}
						
						}else{
							echo "Link Expired";
						}
					}else{
						echo "Invalid Link";
					}
				}else{
					
					echo "Link Expired.";
				}
	}
	
	public function process_upload()
	{
		$infos = $this->input->post();
		
		if($infos['captcha'] == $this->session->userdata('cap_word'))
		{
		$c_id = $this->input->post('c_id');
		$company_name = $this->input->post('company_name');
		$exam = $this->input->post('exam');
		$user_office_id = $this->input->post('user_office_id');

		
		// print_r($company_name);
		// exit;
		$health = "";
		$adhar = "";
		$adhar_back = "";
		$pan = "";
		$bank = "";
		$brth = "";
		$nbi = "";
		$exp = "";
		$edu = "";
		$sign = "";
		

		$bank_name="";
		$branch_name="";
		$acc_type="";
		$bank_acc_no="";
		$ifsc_code="";


		$bank_name = $this->input->post('bank_name');
		$branch_name = $this->input->post('branch_name');
		$acc_type = $this->input->post('acc_type');
		$bank_acc_no = $this->input->post('bank_acc_no');
		$ifsc_code = $this->input->post('ifsc_code');

		// $array = array();
		// if(!empty($ifsc_code)) $array['ifsc_code']= $ifsc_code;
		// if(!empty($acc_type)) $array['acc_type']= $acc_type;
		// if(!empty($bank_name)) $array['bank_name']= $bank_name;
		// if(!empty($bank_acc_no)) $array['bank_acc_no']= $bank_acc_no;
		// if(!empty($branch_name)) $array['branch_name']= $branch_name;

		$personalSql="Select id,fname,lname from dfr_candidate_details where id='$c_id'";
		$infos = $this->Common_model->get_query_result_array($personalSql);
		
		$error = "0";
		// print_r($_FILES);
		if(!empty($_FILES['brth']['name'])){
			$brth = $this->upload_birth($infos);
			if($brth==""){
				$error = "1";
			}
		}

		
		
		if(!empty($_FILES['health']['name']) || !empty($_FILES['health_nis']['name'])){
			$health = $this->upload_insurence($infos);
			if($health==""){
				$error = "1";
			}
		}
		
		if(!empty($_FILES['nbi']['name'])){
			$nbi = $this->upload_nbi($infos);
			if($nbi==""){
				$error = "1";
			}
		}
		
		if(!empty($_FILES['pan']['name'])){
			$pan = $this->upload_pan($infos,$user_office_id);
			if($pan==""){
				$error = "1";
			}
		}
		if(!empty($_FILES['attachment_signature']['name'])){
			$sign = $this->upload_signature($infos,$user_office_id);
			if($sign==""){
				$error = "1";
			}
		}
		

		if(!empty($_FILES['bank']['name'])){
			$bank = $this->upload_bank($infos,$user_office_id);
			if($bank==""){
				$error = "1";
			}
		}
		
		if(!empty($_FILES['exp'])){
			$exp = $this->upload_expfile($infos);
		}
		
		if(!empty($_FILES['edu'])){
			$edu = $this->upload_edufile($infos);
		}

		 //print_r($edu); die();
		
		
		if(!empty($_FILES['adhar']['name'])){
			$adhar = $this->upload_adhar($infos,$user_office_id);
			if($adhar==""){
				$error = "1";
			}
		}
		
		if(!empty($_FILES['adhar_back']['name'])){
			$adhar_back = $this->upload_adhar_back($infos,$user_office_id);
			if($adhar_back==""){
				$error = "1";
			}
		}

		if(!empty($_FILES['national_id']['name'])){
			$nid = $this->upload_adhar($infos,$user_office_id);
			if($nid==""){
				$error = "1";
			}
		}

		if(!empty($_FILES['local_background']['name'])){
			$bckgrnd = $this->upload_local_background($infos,$user_office_id);
			if($bckgrnd==""){
				$error = "1";
			}
		}

		if(!empty($_FILES['file_upload']['name'])){
			$resume = $this->upload_file($infos);
			if($resume==""){
			$error = "1";
			}
		}
		
		$photo = $this->upload_photo($infos);

		if($error!=1){

		$this->db->trans_start();

		$link_sub_time = CurrMySqlDate();
		$ip = getClientIP(); // $_SERVER['REMOTE_ADDR'];
		$browser = $_SERVER['HTTP_USER_AGENT'];	
		$link_sub_log = " Date: ".$link_sub_time." RemoteIP: " . $ip ." Browser:".$browser;

		$query = $this->db->query("SELECT * FROM dfr_candidate_details WHERE id = $c_id");
		$data = $query->row();

		if($data){
				$uparray = array(
						"doc_link_sub_time" => $link_sub_time,
						"doc_link_sub_log" => $link_sub_log,
						"is_active_doc_token" => 'N',
					);
				if(!empty($brth)) $uparray['attachment_birth_certificate'] = $brth;
				
				if($user_office_id == "JAM"){ 
					if(!empty($health)) $uparray['attachment_nis'] = $health; 
				}else{
					if(!empty($health)) $uparray['attachment_health_insurence'] = $health;
				} 
				if(!empty($nbi)) $uparray['attachment_nbi_clearence'] = $nbi;
				if(!empty($photo)) $uparray['photo'] = $photo;
				if(!empty($adhar)) $uparray['attachment_adhar'] = $adhar;
				if(!empty($adhar_back)) $uparray['attachment_adhar_back'] = $adhar_back;
				if(!empty($pan)) $uparray['attachment_pan'] = $pan;
				if(!empty($nid)) $uparray['attachment_adhar'] = $nid;
				if(!empty($bckgrnd)) $uparray['attachment_local_background'] = $bckgrnd;
				if(!empty($resume)) $uparray['attachment'] = $resume;
				if(!empty($bank)) $uparray['attachment_bank'] = $bank;
				if(!empty($sign)) $uparray['attachment_signature'] = $sign;

				if(!empty($bank_name)) $uparray['bank_name']= $bank_name;
				if(!empty($branch_name)) $uparray['branch_name']= $branch_name;
				if(!empty($acc_type)) $uparray['acc_type']= $acc_type;
				if(!empty($bank_acc_no)) $uparray['bank_acc_no']= $bank_acc_no;
				if(!empty($ifsc_code)) $uparray['ifsc_code']= $ifsc_code;

				
				$this->db->where('id', $c_id);
				$this->db->update('dfr_candidate_details',$uparray);
		}

		$query = $this->db->query("SELECT * FROM dfr_experience_details WHERE candidate_id = $c_id");
		$data = $query->row();
		if($data)
		{		
			foreach ($company_name as $key => $value) {
				$path       = $_FILES['exp']['name'][$key];
        		$ext        = pathinfo($path, PATHINFO_EXTENSION);
				// $exp = $infos[0]['fname']."_".$infos[0]['lname']."_".$c_id."_experience".$key.".".$ext;
				$this->db->set("experience_doc",$exp[$key]);
				$this->db->where('candidate_id', $c_id);
				$this->db->where('company_name', $value);
				$this->db->update('dfr_experience_details');
			}
		}

		$query = $this->db->query("SELECT * FROM dfr_qualification_details WHERE candidate_id = $c_id");
		$data = $query->row();
		// print_r($data); exit;
		if($data)
		{	
			foreach ($exam as $key => $value) {
				$path       = $_FILES['edu']['name'][$key];
    			$ext        = pathinfo($path, PATHINFO_EXTENSION);
				// $edu = $infos[0]['fname']."_".$infos[0]['lname']."_".$c_id."_education".$key.".".$ext;
				$this->db->set("education_doc",$edu[$key]);
				$this->db->where('candidate_id', $c_id);
				$this->db->where('exam', $value);
				$this->db->update('dfr_qualification_details');
			}
				
		}
		else
		{
			if($_FILES['edu']['name'][0]!=''){
				$path       = $_FILES['edu']['name'][0];
	    		$ext        = pathinfo($path, PATHINFO_EXTENSION);
				// $edu = $infos[0]['fname']."_".$infos[0]['lname']."_".$c_id."_education0.".$ext;
				$inarr = array(
					'candidate_id'=>$c_id,
					'passing_year'=>$this->input->post('passing_year'),
					'grade_cgpa'=>$this->input->post('percentage'),
					'education_doc'=>$edu[0],
					'exam'=>$this->input->post('last_qualification'),
					'added_date'=>date('Y-m-d')
				);
				$this->db->insert('dfr_qualification_details',$inarr);
			}
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
						$response = array('error'=>'false','c_id'=>$c_id);
						echo json_encode($response);
					}
				}else{
					$response = array('error'=>'file_error');
					echo json_encode($response);
				}
		
		}else
		{
			$response = array('error'=>'cap_error');
			echo json_encode($response);
		}

		// print_r($this->db->error());

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
				'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

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

	private function upload_insurence($infos)
	{
		// print_r($infos);
		// exit;
						
		$config['upload_path'] = './uploads/candidate_insurence/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['health']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_health_insurence.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('health'))
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


	private function upload_nbi($infos)
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = './uploads/candidate_nbi_clearence/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['nbi']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_nbi.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('nbi'))
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


	private function upload_birth($infos)
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = './uploads/candidate_birth/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['brth']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_birth_certificate.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('brth'))
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


	private function upload_pan($infos,$user_office_id)
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = './uploads/pan/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['pan']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
				
        if ($user_office_id == "MAN" || $user_office_id == "CEB") {
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_tin_doc.".$ext;
		}elseif($user_office_id == "JAM"){
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_tax_doc.".$ext;
		}elseif(isIndiaLocation($user_office_id)==true){
			$config['file_name']   = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_pan.".$ext;
		}else{
			$config['file_name']   = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_tax_doc.".$ext;
		}
		
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('pan'))
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
	private function upload_signature($infos,$user_office_id)
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = './uploads/candidate_sign/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['attachment_signature']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
				
		$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_sign_doc.".$ext;

        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('attachment_signature'))
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

	private function upload_bank($infos,$user_office_id)
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = './uploads/dfr_bank/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['bank']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
				
        
		$config['file_name']   = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_bank.".$ext;
		
		
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('bank'))
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



	private function upload_photo($infos)
	{
		$config['upload_path'] = './uploads/photo/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$path       = $_FILES['photo']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_photo.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('photo'))
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

	private function upload_adhar($infos,$user_office_id)
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = './uploads/candidate_aadhar/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		
		// if($user_office_id=='ELS'){
		// 	$path       = $_FILES['nid']['name'];
		// }else{
		// 	$path       = $_FILES['adhar']['name'];
		// }
		$path       = $_FILES['adhar']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);

        if(isIndiaLocation($user_office_id)==true) {
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_adhar.".$ext;
		}
		else{
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_sss_doc.".$ext;	
		}
		
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('adhar'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			return "";
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
			return $this->upload->data('file_name');
		}
	}
	private function upload_adhar_back($infos,$user_office_id)
	{
		
		$config['upload_path'] = './uploads/candidate_aadhar_back/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		

		$path       = $_FILES['adhar_back']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);

        if(isIndiaLocation($user_office_id)==true) {
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_adhar_back.".$ext;
		}
		else{
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_sss_adharBack_doc.".$ext;	
		}
		
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('adhar_back'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			return "";
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
			return $this->upload->data('file_name');
		}
	}
	
	private function upload_local_background($infos,$user_office_id)
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = './uploads/candidate_local_background/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['local_background']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);

        // if(isIndiaLocation($user_office_id)==true) {
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_local_background.".$ext;
		// }
		// else{
		// 	$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_sss_doc.".$ext;	
		// }
		
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('local_background'))
		{
			$this->upload_error = array('error' => $this->upload->display_errors());
			return "";
		}
		else
		{
			$this->file_name = $this->upload->data('file_name');
			$this->upload_error = array();
			return $this->upload->data('file_name');
		}
	}

	private function upload_file($infos)
	{
		// print_r($infos);
		// exit;
		$candidate_id = $infos[0]['id'];
		//$BaseRealPath=$this->config->item('BaseRealPath');
		$config['upload_path'] = './uploads/candidate_resume/';
		
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['file_upload']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$candidate_id."_resume.".$ext;
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

	private function upload_expfile($infos)
	{
		
		foreach ($_FILES['exp']['name'] as $key => $value) {

			$config['upload_path'] = './uploads/experience_doc/';
			$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
			$path       = $_FILES['exp']['name'][$key];
	        $ext        = pathinfo($path, PATHINFO_EXTENSION);
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_experience".$key.".".$ext;
	        $config['overwrite']      = 0;
	        $config['max_size']       = 0;
	        $config['max_width']      = 0;
	        $config['max_height']     = 0;
			$this->load->library('upload');
			$this->upload->initialize($config);

			$_FILES['file_new']['name']     = $path;
			$_FILES['file_new']['type']     = $_FILES['exp']['type'][$key];
            $_FILES['file_new']['tmp_name'] = $_FILES['exp']['tmp_name'][$key];
            $_FILES['file_new']['error']    = $_FILES['exp']['error'][$key];
            $_FILES['file_new']['size']     = $_FILES['exp']['size'][$key];
			
			if ( ! $this->upload->do_upload('file_new'))
			{
				$this->upload_error = array('error' => $this->upload->display_errors());
				// $this->file_name = $this->upload->data('file_name');
				$fems_exp = '';
			}
			else
			{
				$fems_exp[] = $this->upload->data('file_name');
				// $this->file_name = $this->upload->data('file_name');
				// $this->upload_error = array();
			}
			
		}
		return $fems_exp;


	}


	private function upload_edufile($infos)
	{
		foreach ($_FILES['edu']['name'] as $key => $value) {

			$config['upload_path'] = './uploads/education_doc/';
			$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
			$path       = $_FILES['edu']['name'][$key];
	        $ext        = pathinfo($path, PATHINFO_EXTENSION);
			$config['file_name']      = $infos[0]['fname']."_".$infos[0]['lname']."_".$infos[0]['id']."_education".$key.".".$ext;
	        $config['overwrite']      = 0;
	        $config['max_size']       = 0;
	        $config['max_width']      = 0;
	        $config['max_height']     = 0;
			$this->load->library('upload');
			$this->upload->initialize($config);

			$_FILES['file_new']['name']     = $path;
			$_FILES['file_new']['type']     = $_FILES["edu"]['type'][$key];
            $_FILES['file_new']['tmp_name'] = $_FILES["edu"]['tmp_name'][$key];
            $_FILES['file_new']['error']    = $_FILES["edu"]['error'][$key];
            $_FILES['file_new']['size']     = $_FILES["edu"]['size'][$key];
			
			if ( ! $this->upload->do_upload('file_new'))
			{
				$this->upload_error = array('error' => $this->upload->display_errors());
				// $this->file_name = $this->upload->data('file_name');
				$fems_edu='';
			}
			else
			{
				$fems_edu[] = $this->upload->data('file_name');
				
				// $this->file_name = $this->upload->data('file_name');
				// $this->upload_error = array();
			}
			
		}
		
		return $fems_edu;

	}


}
