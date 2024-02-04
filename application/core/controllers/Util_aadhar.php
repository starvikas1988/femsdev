<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Util_aadhar extends CI_Controller {
    
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
        //if(check_logged_in())
        //{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			
            $data["aside_template"] = get_aside_template();
			
            $data["content_template"] = "utils/aadharUpload.php";
			//echo FCPATH ;
			
            $data["error"] = '';  
			$this->load->view('dashboard',$data);			 
			   
		//}
    }
		
	public function upload()
    {
        //if(check_logged_in())
       // {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$ret = array();
			$output_dir = FCPATH."temp_files/aadhar/";
			$error =$_FILES["adhar"]["error"];
			
			$lang = trim($this->input->post('lang'));

				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
			
			
			
			
				if(!empty($_FILES["adhar"]["name"])) //single file
				{
					
					
					$fileName = $this->upload_adhar();
					if($fileName==""){
						$ret["error"]= "image upload error";
						echo json_encode($ret);
					}else{
						$newFilePath = $output_dir.$fileName;					
						$rep = $this->callAdharApi($newFilePath,$lang);
						echo $rep;
					}
					
				}else{
					echo json_encode($ret);
				}
			
		//}
   }
   
   
   private function upload_adhar()
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = './temp_files/aadhar/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$path       = $_FILES['adhar']['name'];
		
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		
		$fileName = str_replace(' ','',$_FILES["adhar"]["name"]);
		$config['file_name']  =  $fileName;
				
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
	
	
	
    private function callAdharApi($FilePath,$lang)
	{
			
		$URL='http://172.23.1.86:5000/aadhaar_upload';
		
		//echo $FilePath;
		
		$curl = curl_init();
		 
		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $URL,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => array('fileUpload'=> new CURLFILE($FilePath),'lang' => $lang),
		));
		 
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}
   
   
	
}

?>