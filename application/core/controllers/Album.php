<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Album extends CI_Controller {

    private $aside = "album/aside.php";
	
	 
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		
	 }

	public function index(){
		if(check_logged_in()){
			
			$data["aside_template"] = $this->aside;
			 
			$data['albums']= $gallery; 
			$data["content_template"] = "album/album_location.php";
			 
			//if(get_role_dir()=="super" || $is_global_access==1){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
 
				 
			
			$this->load->view('dashboard',$data);
		}
	}	
	 
    public function check_location()
    { 	
        if(check_logged_in()){

			$data['perfect_loaction']='';
			$office_location  = $this->input->get('loc');
			$data['abbr_loaction'] = trim(filter_var($office_location,FILTER_SANITIZE_STRING));	
			
			$this->session->unset_userdata('actual_link');
		
			$data['actual_link'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
				
			$this->session->set_userdata('actual_link',$data['actual_link']);

			$role_id = get_role_id();
			$current_user = get_user_id(); 
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();

			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			foreach ($data['location_list'] as $key => $val) {
				if(trim($val['abbr']) == $data['abbr_loaction']){
					$data['perfect_loaction'] = $val['location'];
				}elseif($data['abbr_loaction'] == 'OFF'){
					$data['perfect_loaction'] = 'OFF SITE';
				}
					
			}
		   
 
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$is_global_access=get_global_access();
			
			$fusionid = get_user_fusion_id();
			

			$data["role_dir"]=$role_dir;
					
			$album_array = array();
			$data["aside_template"] = $this->aside;
			$qSql = "Select * from photo_gallery where location='". $data['abbr_loaction'] ."' and is_active = 1";
			$gallery = $this->Common_model->get_query_result_array($qSql);	
					
 
					
			$data['albums']= $gallery;
			$data["content_template"] = "album/manage.php";
			
			$this->session->set_flashdata('message','');	

			
			$this->load->view('dashboard',$data);
			
        }
    }
	
	
	
	
	
	public function selected_album(){
		if(check_logged_in()){
			$data_test = array();
			$role_id = get_role_id();
			$current_user = get_user_id(); 
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			 
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$is_global_access=get_global_access();
			
			$data["role_dir"]=$role_dir;
		
			$fusionid = get_user_fusion_id();
			
			$data['uri'] = $this->input->get('s');
			
			
			$url = explode("&",$data['uri']);
			
			$url_trim = explode('/',$url[0]);
			
			
			$this->session->set_userdata("album_name",$url_trim[1]);
			

			if($url_trim[0] != '' && $url_trim[1] != ''){
				if(!empty($url[0])){
					
					$fusion =	$this->getDirContents($this->config->item('image_gallery')."/".$url[0]);
						
						$data_test = array();
						
						if(!empty($fusion)){
							foreach($fusion as $ert){
							
									$imgfile = explode("/",$ert);
									// print_r($imgfile); exit;
										$data_test[] =  $imgfile[5]."/".$imgfile[6]."/".$imgfile[7]."/".$imgfile[8]."/". $imgfile[9];
									
							}
						}
						
			
						$data['imgfile'] = $data_test;
						$data["aside_template"] = $this->aside;
						$data["content_template"] = "album/album_dashboard.php";
						$data['query_string'] = $this->input->get('s');
						
						
						$this->load->view('dashboard',$data);
						
				}else{
					redirect('album','refresh');	
				}
			}else{
				redirect('album','refresh');
			}
			
        }
	}
	
	
		public	function getDirContents($dir, &$results = array()){
			$files = scandir($dir);
			// print_r($files); exit;
			foreach($files as $key => $value){
				$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
				if(!is_dir($path)) {
					$results[] = $path;
				} else if($value != "." && $value != "..") {
					$this->getDirContents($path, $results);
					$results[] = $path;
				}
			}

			return $results;
		}
	
	
	
	public function get_fusionid($fusionid){
	
	$filetypes = array ('pdf','img','docx','xlxs','png','gif');
	$folder = array();
	$file   = array();
	
		for($i=0;$i<count($fusionid);$i++){
			
			
			if(!is_dir($fusionid[$i])){
					$filename =  basename($fusionid[$i]);
					$file[] = $filename ;
			}else{
				
				echo $filename =  basename($fusionid[$i]);
					 $folder[] = $filename ;
			}
			
			/* if($filetypes == 'pdf'){
				$this->filename =  basename($fusionid[$i]);
				$this->full_filepath =  $fusionid[$i];
				
				$result  =	$this->fetch_fusion_id($this->filename,$this->full_filepath);	
				
				if(!empty($result)){	
					$source_file = $this->config->item('PayslipReadPath');
					$destination_path = $this->config->item('PayslipSavePath1');
					
					$extract_extension =  explode(".",$this->filename);
					  
					$rename_file  =  substr($extract_extension[0],0,10);
					
					//UNIX TIME STAMP 
				    $t=time();
					
					//copy($this->full_filepath, $destination_path."/".$rename_file."_".date('Y-m-d').".pdf");
					copy($this->full_filepath, $destination_path."/".$t.".pdf");
					
					//$this->create_records($result[0]->id , $rename_file."_".date('Y-m-d').".pdf");
					$this->create_records($result[0]->id , $t.".pdf");
				}
			} */
			
		}				 
	}
	
	
		
public function create_album(){
	$filedirectory ='';
		
        if(check_logged_in())
        {
		   $data['error']='';
		   $role_id = get_role_id();
		   $current_user = get_user_id();
	       $role_dir= get_role_dir();
		   $fusionid = get_user_fusion_id();
		   
		   $destination_path = $this->config->item('image_gallery');
		   
           $data["aside_template"] = $this->aside;
		   $data["content_template"] = "album/manage.php";
		   
		   $album_name = $this->input->post('album_name');
		   $location =  $this->input->post('location');
		   
		   //echo htmlspecialchars($album_name);
		   
		   
		   
			$t1 = str_replace("'", '', $album_name);
			$t2 = stripslashes($t1);
		    $album_text = str_replace("/","_",$t2);
 
			
		   
			if($album_name != '' || $album_name != NULL){
			   //$this->input->post('album_userid');
			   $Sqltxt = "SELECT * FROM photo_gallery where album_name='".  trim($album_text) ."'";
			   $fields  = $this->db->query($Sqltxt);

			   
				   if($fields->num_rows() > 0){
						$this->session->set_flashdata('message','Duplicate Gallery Name ! already present');
						
				   }else{
 					 
						   $insert_album = array('album_userid'=> $fusionid,
												 'album_name'=> str_replace("&","and",$album_text),
												 'location'  => $location,	
												 'is_active'=>1
											);
						   
						   
							$this->db->insert('photo_gallery',$insert_album);
							
							
							$filedirectory = $fusionid;
							 
							if (!file_exists($destination_path.'/'.$filedirectory)) {
								mkdir($destination_path.'/'.$filedirectory."/".str_replace("&","and",$album_text), 0777, true);
								//copy($this->full_filepath, $destination_path.'/'.$rename_file."/".$rename_file."_".$t_stamp.".pdf");
							}else{
								mkdir($destination_path.'/'.$filedirectory."/".str_replace("&","and",$album_text), 0777, true);
								//copy($this->full_filepath, $destination_path.'/'.$rename_file."/".$rename_file."_".$t_stamp.".pdf");
							}
							
						$this->session->set_flashdata('message','Album Created sucessfully');	
				   }
				   
			}
			
				redirect($this->session->actual_link);
			 
				//redirect('Album/redirect/'.$location,'refresh');
				
           
		   
       }                
   }
   
   public function redirect($location){
	    if(check_logged_in()){
			
			echo  $location;
			
			$role_id = get_role_id();
			$current_user = get_user_id(); 
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			 
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$is_global_access=get_global_access();
			
			$fusionid = get_user_fusion_id();
 
			$data["role_dir"]=$role_dir;
					
			$album_array = array();
			$data["aside_template"] = $this->aside;
			$qSql = "Select * from photo_gallery where location='". $location ."' and  is_active = 1 ";
			$gallery = $this->Common_model->get_query_result_array($qSql);	
					
			$data['albums']= $gallery;
			$data["content_template"] = "album/manage.php";
		
			
			$this->load->view('dashboard',$data);
			
        }
   }
   
   
   public function upload()
    {
				
        if(check_logged_in())
        {
			// print_r($_FILES); exit;			
			$atpid = trim($this->input->post('atpid'));
			$extract = explode('&',$atpid);
			// print_r($extract); exit;
			$ret='done';
			$ret_msg="";
			$log=get_logs();
			$rowid=0;
			$orgFileName="";
			
			//if($atpid!=""){
			
			 	$output_dir = "pic_gallery/users_gallery/".$extract[0]."/" ;
				
				if(!is_array($_FILES["attach"]["name"])) //single file

					{
						if($_FILES['attach']['size'] > 1173741824){
							
							$ret_msg ='File size must be less tham 999 MB';
							$ret="error";
						}else{
							$ext =pathinfo($_FILES["attach"]["name"])['extension'];
							$orgFileName=$_FILES["attach"]["name"];
							// exit;
							/* $field_array = array(
								"policy_id" => $atpid,
								"file_name" => $orgFileName,
								"ext" =>$ext ,
								"log" => $log,
								"status" => '1'
							);
							$rowid=data_inserter('policy_attach',$field_array); */
							$fusion = $this->getDirContents($this->config->item('image_gallery')."/".$extract[0]);
							
							$fileName = $extract[1]."_".(count($fusion)+1).".".strtolower($ext);
							 // print_r($fusion); 
							 // exit;
							if(!file_exists($output_dir.$fileName)){
								move_uploaded_file($_FILES["attach"]["tmp_name"],$output_dir.$fileName);
							}else{
								move_uploaded_file($_FILES["attach"]["tmp_name"],$output_dir.$fileName."_".rand(10,100));
							}
							$ret_msg = $fileName;
							$ret='done';
						}
					}
			//}else{
			//	$ret_msg ='Policy ID not found';
			//	$ret="error";
			//}
			
			$retArr = array();
			$retArr[0]=$ret;
			$retArr[1]=$rowid;
			$retArr[2]=$orgFileName;
			$retArr[3]=$ret_msg; 
			$retArr[4]=$output_dir;
			
			echo json_encode($retArr);
		}
   }
   
   
   public function deleteAttachment(){
	    
		if(check_logged_in()){
			
			$atid = trim($this->input->post('atid'));
		    $lid = trim($this->input->post('lid'));
			
			if($atid!="")
			{ 
				$aFile=$atid.''.$lid;
				unlink($aFile);
				 
				$ans="Done";
			}else $ans="fail";
			echo $ans;
		}
	}
	
	public function deleteuploads(){
	    
		if(check_logged_in()){
			
			$atid = trim($this->input->post('atid'));
			
			if($atid!="")
			{
				  
				$aFile=$atid;
				unlink($aFile);
				 
				$ans="File deleted successfully";
			}else $ans="fail";
			echo $ans;
		}
	}
	
	public function set_default(){
		if(check_logged_in()){
			$aid = trim($this->input->post('lid'));
			
			$split_file = explode("/",$aid);
			
			//pic_gallery/users_gallery/FKOL000003/test album/24_2.jpg
			
			if($aid != ""){
			
			
			 //$SQL = "Update femsdev.photo_gallery set album_cover='".$aid."' where album_userid='". get_user_fusion_id() ."' and album_name='". urldecode($split_file[3]) ."'";
			 
			 $SQL = "Update photo_gallery set album_cover='".$aid."' where album_name='". urldecode($split_file[3]) ."'";
			 
			 //$SQL = "Update femsdev.photo_gallery set album_cover='".$aid."' where  album_name='". urldecode($split_file[3]) ."'";
			 
				$this->db->query($SQL);
				
				$ans="Cover is set Sucessfully";
			}else $ans="fail";
			echo $ans;
			
		}
	}
	 
}

?>