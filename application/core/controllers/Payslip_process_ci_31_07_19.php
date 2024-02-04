<?php


class Payslip_process_ci extends CI_Controller {
    private $filename;
	private $full_filepath;
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('directory');
		$this->load->database();
    }
    
    public function index(){
        $map = directory_map($this->config->item('PayslipReadPath'), FALSE, FALSE);

		$fusion  = $this->getDirContents($this->config->item('PayslipReadPath'),$fusionid);
		
		$this->get_fusion_id($fusion);
		
		$this->delete_files($fusion);
			//********************START TO DELETE THE UPLOADED FILE FROM THE OLD DIRECTRY********************
			//$this->recursiveRemove($this->config->item('clear_dir'));
			
			/* if (!file_exists($this->config->item('PayslipReadPath'))) {
					mkdir($this->config->item('PayslipReadPath'), 0777, true);
			} */
			//********************END TO DELETE THE UPLOADED FILE FROM THE OLD DIRECTRY********************
		
		
    }
	
	
	/*  public function recursiveRemove($dir) {
		$structure = glob(rtrim($dir, "/").'/*');
		//print_r($structure);
		
		 if (is_array($structure)) {
			foreach($structure as $file) {
				
				if($file != $this->config->item('error_dir')){
					 if (is_dir($file)) $this->recursiveRemove($file);
					elseif (is_file($file)) unlink($file);
				}else{
					
				}
			}
		}
		//rmdir($dir);
	}
	 */
	 
	public function delete_files($fusionid){
		
		for($i=0;$i<count($fusionid);$i++){
			
			$extension = substr($fusionid[$i],-3);
			
			if($extension == 'pdf'){
			 	$this->full_filepath =  $fusionid[$i];
				
				unlink($this->full_filepath);
				
			}
			
		}
	}
	
	
	
	
	public function get_fusion_id($fusionid){
	
		for($i=0;$i<count($fusionid);$i++){
			
			$extension = substr($fusionid[$i],-3);
			
			if($extension == 'pdf'){
				$this->filename =  basename($fusionid[$i]);
				$this->full_filepath =  $fusionid[$i];
				
				$result  =	$this->fetch_fusion_id($this->filename,$this->full_filepath);

				$source_file = $this->config->item('PayslipReadPath');
				$destination_path = $this->config->item('PayslipSavePath');
 
				
				$crack_uri   = explode("/",$this->full_filepath);
				
				$extract_extension =  explode(".",$this->filename);
				
				$rename_file  =  substr($extract_extension[0],0,10);	
				
				if($result != NULL){
					//UNIX TIME STAMP 
					$t_stamp=time();
					
					//copy($this->full_filepath, $destination_path."/".$rename_file."_".date('Y-m-d').".pdf");
					
					if (!file_exists($destination_path.'/'.$rename_file)) {
						mkdir($destination_path.'/'.$rename_file, 0777, true);
						copy($this->full_filepath, $destination_path.'/'.$rename_file."/".$rename_file."_".$t_stamp.".pdf");
					}else{
						copy($this->full_filepath, $destination_path.'/'.$rename_file."/".$rename_file."_".$t_stamp.".pdf");
					}
					
					//$this->create_records($result[0]->id , $rename_file."_".date('Y-m-d').".pdf");
					  $this->create_records($result[0]->id , $rename_file.'/'.$rename_file."_".$t_stamp.".pdf");
				}else{
					  copy($this->full_filepath, $source_file.$crack_uri[3]."/".$crack_uri[4]."/".$extract_extension[0].".error");                 
				}
			}
			
		}
		
	}
	
	
	public function fetch_fusion_id($fid,$full_filepath){
		$file_id = substr($fid,0,10);
		
		$SQLtxt ="SELECT * FROM femsdev.signin where fusion_id='". trim($file_id) ."'";
		$fields  = $this->db->query($SQLtxt);
		
		if($fields->num_rows() > 0){
			return  $fields->result();
		}else{
			return NULL;
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
	 
		
		
		


	public function create_records($fems_id,$file_name){
		
		$SQLtxt ="REPLACE INTO  payslip(user_id,file_name,added_time,log)values(".$fems_id.",'".$file_name."','".date('Y-m-d H:i:s')."','Auto Process')";
        $this->db->query(  $SQLtxt );
		
	}
	
	
	
	
    
}