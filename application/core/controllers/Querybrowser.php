<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Querybrowser extends CI_Controller {
    
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
        if(check_logged_in()){
		
			$user_site_id= get_user_site_id();
			$user_role_id= get_role_id();
			
			$data["aside_template"] = get_aside_template();
			
			$data["content_template"] = "querybrowser/dba.php";
			$qSql = trim($this->input->post('qSql'));
			$qSql=str_replace("\\", "", $qSql);
			$data["error"] = ''; 
			$data["qSql"] = $qSql;
			$data['list'] = array();
			$data["download_link"] = "";
						
			if ($qSql!=""){
				
				 //////////LOG////////
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
				$LogMSG="Run SQL : ".$qSql;
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
					
								
				if (!$this->string_begins_with(strtolower($qSql), "select") || $this->has_insert_update_delete($qSql)==true){
					$data["error"] = "INSERT / DELETE / UPDATE / OTHERS SQLs are not allowed here...";
				}else{
					 $fullArr= $this->Common_model->get_query_result_array($qSql);
					 $data['list']=$fullArr;
					 if(!empty($fullArr)){

							$data["download_link"] = base_url()."querybrowser/downloadCsv";
							$this->create_CSV($fullArr);
					 }	
					 
				}
			}
						
			$this->load->view('dashboard',$data);
		}
   }
   
   
   public function downloadCsv()
	{		
		$filename = "./temp_files/dba/SqlResult-".get_user_id().".csv";		
		$newfile="SqlResult-".get_user_id().".csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
   
   
   public function create_CSV($list)
	{
				
		$filename = "./temp_files/dba/SqlResult-".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$row=$list[0];
		$row_str = "SL";
		foreach($row as $key=>$val){
			$row_str .= ','.$key;
		}
		
		fwrite($fopen,rtrim($row_str,",")."\r\n");
		$cnt=1;
		foreach($list as $row)
		{	
			$row_str= '"'.$cnt.'"'; 
			foreach($row as $key=>$val){
				$row_str .= ',"'.$val.'"'; 
			}
			fwrite($fopen,$row_str."\r\n");
			$cnt++;
		}
		fclose($fopen);
	}
	
	
   function has_insert_update_delete($string)
    {
			
			$string=" ".strtoupper($string);
			if(strpos($string,"INSERT")!== false) return true;
			else if(strpos($string,"DELETE")!== false) return true;
			else if(strpos($string,"UPDATE")!== false) return true;
			else return false;
			
    }
	
   
   function string_begins_with($string, $search)
    {
        if( strncmp($string, $search, strlen($search)) == 0) return true;
		else  return false;
		 
    }
	
   
}

?>