<?php 

class Encrypter_db extends CI_Controller{
	    
    public function __construct(){
		parent::__construct();
	}	
	
	public function index(){
		
	}
	
	public function encrypt_prof_db(){
		
		//$this->encrypt_decript_full_db("encrypt");
		
	}
	
	public function decrypt_prof_db(){
		
		$this->encrypt_decript_full_db("decript");
	}
	 
	public function encrypt_decript_full_db($type){
	
		
		$dbArray =array("info_personal","info_bank","info_passport","info_visa");
		
		$dbFielsArray =array("phone,phone_emar,city,state,country,social_security_no,father_name,mother_name,address_present,address_permanent,marital_status,spouse_name",
		"bank_name,branch,acc_no,ifsc_code",
		"pno,note",
		"vno,location");
	
		foreach($dbArray as $index => $tbValue){
			
			$enArr = array();
			
			$filed_list= $dbFielsArray[$index];
			
			$filed_list_array = explode(",",$filed_list);
			
			$SQLtxt = "SELECT * FROM " . $tbValue ." Limit 5 ";
			
			echo "Table: ". $tbValue ."<br>";
			echo "filed_list: ". $filed_list ."<br>";
			
			echo "<pre>";
				print_r($filed_list_array);
			echo "</pre>";
			
			
			
			$result = $this->db->query($SQLtxt)->result_array();
			
				foreach($result as $rowKey => $row){ 
				
					foreach($row as $colKey => $colVal){
						if(in_array($colKey,$filed_list_array)){
								if($type=="encrypt") $enArr[$rowKey][$colKey]  =  encode_string($result[$rowKey][$colKey]);	
								else if($type=="decript") $enArr[$rowKey][$colKey]  =  decode_string($result[$rowKey][$colKey]);				
						}else{
							
							$enArr[$rowKey][$colKey]  =  $result[$rowKey][$colKey];
						}
					}
				}
				
				echo "<pre>";
				print_r($enArr);
				echo "</pre>";
				echo "---------------------------------------------------<br>";
				
				$this->update_table($enArr,$tbValue);
				
				echo "**************************************************<br><br><br>";
			
		}
	
	}
	
	
	public function update_table($data = array(),$tbName){
			
			  foreach($data  as $row){ 
					
					echo "<pre>";
					print_r($row);
					echo "</pre>";
					echo ".....................................................<br>";
					
					$this->db->where('user_id', $row['user_id']);
					$this->db->where('id', $row['id']);
					$this->db->update($tbName, $row );
			 }
	}
	  
}