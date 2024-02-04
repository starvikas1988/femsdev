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
		//echo $this->config->item('PayslipReadPath');
		//print_r($map);

		$dir_array  = $this->getDirContents($this->config->item('PayslipReadPath'));
		
		//echo "<pre>";
		//print_r($dir_array);
		
		$this->get_fusion_id($dir_array);
		$this->delete_files($dir_array);
		
		echo "\n".date("Y-m-d H:i:s")." >> process Done.";
		
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
	 
	public function delete_files($dirArray){
		
		for($i=0;$i<count($dirArray);$i++){
			
			$extension = substr($dirArray[$i],-3);
			
			if($extension == 'pdf' || $extension == 'PDF'){
			 	$this->full_filepath =  $dirArray[$i];
				
				unlink($this->full_filepath);
				
			}
			
		}
	}
	
	
	
	
	public function get_fusion_id($dirArray){
	
		for($i=0;$i<count($dirArray);$i++){
			
			$extension = substr($dirArray[$i],-3);
			
			if($extension == 'pdf' || $extension == 'PDF'){
				
				$this->filename =  basename($dirArray[$i]);
				
				$this->full_filepath =  $dirArray[$i];
				
				$result  =	$this->fetch_fusion_id($this->filename,$this->full_filepath);

				$source_file = $this->config->item('PayslipReadPath');
				
				$destination_path = $this->config->item('PayslipSavePath');
 
				
				$crack_uri   = explode("/",$this->full_filepath);
				
				$extract_extension =  explode(".",$this->filename);
				
				if($result != NULL){
					
					//print_r($result);
					//echo $result[0]->fusion_id . " " . $result[0]->xpoid . " " .$result[0]->fname . " " .$result[0]->lname ."<br>"; 
					
					$fusion_id  =  $result[0]->fusion_id;
					$office_id  =  $result[0]->office_id;
					$pay_desc =	get_payslip_desc($office_id);
					
					//UNIX TIME STAMP 
					$t_stamp = round(microtime(true) * 1000); //time();
					
					//copy($this->full_filepath, $destination_path."/".$fusion_id."_".date('Y-m-d').".pdf");
					
					if (file_exists($this->full_filepath)) {
						
						if (!file_exists($destination_path.'/'.$fusion_id)) {
							
							mkdir($destination_path.'/'.$fusion_id, 0777, true);
							
							copy($this->full_filepath, $destination_path.'/'.$fusion_id."/".$fusion_id."_".$t_stamp.".pdf");
						}else{
							copy($this->full_filepath, $destination_path.'/'.$fusion_id."/".$fusion_id."_".$t_stamp.".pdf");
						}
						
						//$this->create_records($result[0]->id , $fusion_id."_".date('Y-m-d').".pdf");
						  $this->create_records($result[0]->id , $fusion_id.'/'.$fusion_id."_".$t_stamp.".pdf", $pay_desc );
						  
						  unlink($this->full_filepath);
						  
					}else{
						copy($this->full_filepath, $source_file.$crack_uri[3]."/".$crack_uri[4]."/".$extract_extension[0].".errorp"); 
					}
				}else{
					  copy($this->full_filepath, $source_file.$crack_uri[3]."/".$crack_uri[4]."/".$extract_extension[0].".error");                 
				}
			}
			
		}
		
	}
	
	
	public function fetch_fusion_id($fid,$full_filepath){
		
		//echo $fid . "<br>";
		//echo $full_filepath . "<br>";
		
		if(stripos($full_filepath, "Kol1/Kol1") === false){
			$file_id = substr($fid,0,10);
			$SQLtxt ="SELECT * FROM  signin where fusion_id='". trim($file_id) ."' and status in (1,4) ";
			
			$res  = $this->db->query($SQLtxt);					
			if($res->num_rows() <= 0){
				$fnArray=explode("_",$fid);
				$file_id = $fnArray[1];
				$SQLtxt ="SELECT * FROM  signin where fusion_id='". trim($file_id) ."' and status in (1,4) ";
			}
			
			 
		}else{
			
			$file_id = substr( $fid, stripos($fid, "(")+1 , (stripos($fid, ")") - stripos($fid, "("))-1);
			$SQLtxt ="SELECT * FROM  signin where xpoid='". trim($file_id) ."' and status in (1,4) ";
			$res  = $this->db->query($SQLtxt);
			
			//echo $file_id . " num_rows :: " . $res->num_rows();
						
			if($res->num_rows() <= 0) $SQLtxt ="SELECT * FROM  signin where fusion_id='". trim($file_id) ."' and status in (1,4) ";
			
			//echo " <br>". $SQLtxt . "<br>";
						
		}
		
		$fields  = $this->db->query($SQLtxt);
		if($fields->num_rows() > 0){
			return  $fields->result();
		}else{
			return NULL;
		}
		
	}
	 
	
  	public function getDirContents($dir, &$results = array()){
		$files = scandir($dir);
		
		//print $files;
		
		foreach($files as $key => $value){
			$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
			
			//print $path;
			
			if(!is_dir($path)) {
				$results[] = $path;
			} else if($value != "." && $value != "..") {
				$this->getDirContents($path, $results);
				$results[] = $path;
			}
		}

		return $results;
	}
	 
	 
	public function create_records($fems_id,$file_name, $pay_desc){
		
		
		$SQLtxt ="REPLACE INTO  payslip(user_id,file_name,pay_desc,added_time,log)values(".$fems_id.",'".$file_name."','". $pay_desc ."','".date('Y-m-d H:i:s')."','Auto Process')";
		//echo $SQLtxt;
        $this->db->query(  $SQLtxt );
		
	}
	
	
	
	
    
}