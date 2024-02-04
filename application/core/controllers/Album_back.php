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
	 
    public function index()
    {
				
        if(check_logged_in()){
						
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
					
			$album_array = array();
			
			//var_dump( $get_value); 
			
			$set_off = 0;		
			
			$data["aside_template"] = $this->aside;
			
			/*
			if($set_off == 0 && $get_value== true){
				//Get fusion ID  FKOL00001/
				$this->fusionid = $this->fetch_fusion_id($current_user);
				
				$gallery = $this->fetch_data("*","photo_gallery",$this->fusionid[0]->fusion_id);
				 
				for($a=0;$a< count($gallery);$a++){
						$this->album_array[] = $gallery[$a]->album_userid."/".$gallery[$a]->album_name."&".$gallery[$a]->id; 
				}

				$data['albums']= $this->album_array;
				
				$data["content_template"] = "album/manage.php";
				
			}else{
			*/
				
				$qSql = "Select * from photo_gallery where is_active = 1 ";
				
				$gallery = $this->Common_model->get_query_result_array($qSql);				
								 
				
				foreach($gallery as $row){
						$album_array[] = $row['album_userid']."/".$row['album_name']."&". $row['id']; 
				}

				$data['albums']= $album_array;
				$data["content_template"] = "album/manage.php";
				
				
				
				
				//$get_files = $this->getDirContents($this->config->item('image_gallery'));
				/* 				
					echo "<pre>";
					print_r($get_files);
				 */
				
				/*
					foreach($get_files as $file){
						if(!is_dir($file)){
							$file_extract[] =$file;
							$imgfile = explode("/",$file);
							$data_test[] =  $imgfile[5]."/".$imgfile[6]."/".$imgfile[7]."/".$imgfile[8]."/".$imgfile[9];
						}
					}
					
					$data['imgfile'] = $data_test;
					$data["content_template"] = "album/album_dashboard.php";
				*/
			//}
			
			
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
		
			$this->fusionid = $this->fetch_fusion_id($current_user);
			
			$data['uri'] = $this->input->get('s');
			 
			//$fusion = $this->getDirContents($this->config->item('image_gallery')."/".$data['uri']);
			//$fusion =	$this->getDirContents($this->config->item('image_gallery')."/".$gallery[$a]->album_userid."/".$gallery[$a]->album_name);
			$url = explode("&",$data['uri']);
			
			
			if(!empty($url[0])){
				
				$fusion =	$this->getDirContents($this->config->item('image_gallery')."/".$url[0]);
				
				
					if(!empty($fusion)){
						foreach($fusion as $ert){
						
								$imgfile = explode("/",$ert);
								
								$data_test[] =  $imgfile[5]."/".$imgfile[6]."/".$imgfile[7]."/".$imgfile[8]."/".$imgfile[9];
								
						}
							
						
						$data['imgfile'] = $data_test;
					
						$data["aside_template"] = $this->aside;
						$data["content_template"] = "album/album_dashboard.php";
							
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
		   $role_id = get_role_id();
		   $current_user = get_user_id();
	       $role_dir= get_role_dir();
		   $this->fusionid = $this->fetch_fusion_id($current_user);
		   
		   $destination_path = $this->config->item('image_gallery');
		   
		   
			
           $data["aside_template"] = $this->aside;
		   $data["content_template"] = "album/view.php";
		   
		   ///$this->input->post('album_userid');
		   $album_name = $this->input->post('album_name');
		   
		  
		   
		   $insert_album = array('album_userid'=> $this->fusionid[0]->fusion_id,
							     'album_name'=> $album_name , 	
							     'is_active'=>1 ,
								 'album_cover'=> 0
							);
		   
		   
			$this->db->insert('photo_gallery',$insert_album);
			
			$filedirectory = $this->fusionid[0]->fusion_id;
		     
			if (!file_exists($destination_path.'/'.$filedirectory)) {
				mkdir($destination_path.'/'.$filedirectory."/".$album_name, 0777, true);
				//copy($this->full_filepath, $destination_path.'/'.$rename_file."/".$rename_file."_".$t_stamp.".pdf");
			}else{
				mkdir($destination_path.'/'.$filedirectory."/".$album_name, 0777, true);
				//copy($this->full_filepath, $destination_path.'/'.$rename_file."/".$rename_file."_".$t_stamp.".pdf");
			}
		   
		   
		   redirect('Album','refresh');
			
           
		   
       }                
   }
   
   
   public function upload()
    {
				
        if(check_logged_in())
        {
						
			$atpid = trim($this->input->post('atpid'));
			$extract = explode('&',$atpid);
			
			
			
			$ret='done';
			$ret_msg="";
			$log=get_logs();
			$rowid=0;
			$orgFileName="";
			
			//if($atpid!=""){
			
			 	$output_dir = "pic_gallery/users_gallery/".$extract[0]."/" ;
				
				if(!is_array($_FILES["attach"]["name"])) //single file
					{
						if($_FILES['attach']['size'] > 10485760){
							
							$ret_msg ='File size must be less tham 10 MB';
							$ret="error";
						}else{
							$ext =pathinfo($_FILES["attach"]["name"])['extension'];
							$orgFileName=$_FILES["attach"]["name"];
							
							/* $field_array = array(
								"policy_id" => $atpid,
								"file_name" => $orgFileName,
								"ext" =>$ext ,
								"log" => $log,
								"status" => '1'
							);
							$rowid=data_inserter('policy_attach',$field_array); */
							$fusion = $this->getDirContents($this->config->item('image_gallery')."/".$extract[0]);
							
							$fileName = $extract[1]."_".(count($fusion)+1).".".$ext;
							
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
	
	
	public function fetch_fusion_id($id){
		$sqltTXT='';
		
		$sqltTXT ="select * from signin where id=".$id."";
		$fields = $this->db->query($sqltTXT);
		
		
		if($fields->num_rows()>0){
			return $fields->result();
			 
		}elsE{
			return NULL;	
		}
		
	}
	
	
	public function fetch_data($fields,$tables,$id){
		$sqltTXT='';
		
		$sqltTXT ="select ". $fields ." from ". $tables ." where album_userid='".$id."'";
		$fields = $this->db->query($sqltTXT);

		if($fields->num_rows()>0){
			return $fields->result();
		}elsE{
			return NULL;	
		}
	}
	

	
	   
   
   
	
}

?>