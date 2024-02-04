<?php 

 class Qa_prodigal_cli extends CI_Controller
 {
		
	 public function __construct()
	 {
	  parent::__construct();
	  $this->load->model('excel_import_model');
	  $this->load->library('excel');
	  $this->load->library('session');
	 }

	 
	 
	 function index(){

	    //	error_reporting(E_ALL);
		// ini_set('display_errors', 1);

	 	$success=0;
	 	$error=0;
	 	$excel_file_directory = $this->config->item('VRSQAFTPPATH');

		if ($handle = opendir(".".$excel_file_directory)) {
		    while ($entry = readdir($handle)) {
		    	if (strpos($entry, 'error') != true){
		        if (strpos($entry, 'xls') !== false){
		            $return_val=$this->import($entry,".".$this->config->item('VRSQAFTPPATH'));
		            if($return_val){
		            	$success++;
		            	$this->logDetailsErrorSucessMsg("Data Inserted Successfully of File Name ".$entry);
		            	if(file_exists(".".$excel_file_directory.$entry)){
		            	//$this->logDetailsErrorSucessMsg("File EXISTS ".$entry." line No: 200.");
		            		if(unlink(".".$excel_file_directory.$entry)){
		            	//$this->logDetailsErrorSucessMsg("File Deleted ".$entry." line No: 202.");
		            		}else{
		            	$this->logDetailsErrorSucessMsg("File Not Deleted ".$entry);
		            		}
		            	}
		            }else{
		            	$error++;
		            	//$this->logDetailsErrorSucessMsg("INPUT FILE ERROR NOT UPLOADED ".$entry." line No: 209.");
		            	if(rename(".".$excel_file_directory.$entry,".".$excel_file_directory."error/".$entry.time()."error")){
		            		//$this->logDetailsErrorSucessMsg("File Name Changed ".$entry);
		            	}
		            }
		        }else{		            	
		        	if(!in_array($entry,array('.','..'))){
		        		$this->logDetailsErrorSucessMsg("File extention error ".$entry);
		        		if(rename(".".$excel_file_directory.$entry,".".$excel_file_directory."error/".$entry.time()."error")){
		            		//$this->logDetailsErrorSucessMsg("File Name Changed ".$entry);
		            	}
		        	}
		        }
		    }
		    }
		    closedir($handle);
		}

		$this->logDetailsErrorSucessMsg("Number Of File Uploaded Successful is: ".$success);
		$this->logDetailsErrorSucessMsg("Number Of File Uploaded Unsuccessful is: ".$error);
		echo "Number Of File Uploaded Successful is: ".$success;
		echo "<br>";
		echo "Number Of File Uploaded Unsuccessful is: ".$error;

	 }
	 

	 function fieldVal(){

	 	$field_val=array("entry_by","audit_date","agent_id","call_date","call_duration","call_id","phone","overall_score","identifynameatbeginning","assurancetsatementverbatim","VRSwithnodeviation","speakingtorightparty","demographicsinformation","minimirandadisclosure","statetheclientname","askforbalancedue","reasonfordelinquency","completeinformationtaken","askforpaymentonphone","askforpostdelaypayment","accountforfollowupcall","promisetopayaccount","splitbalanceinpart","offersumsettlement","paymentplanwithpayment","collectorfollowpropernegotiation","collectortrynegotiatepayment","offergoodfaithpayment","misrepresentidentity","discussoflegalaction","makeanyfalserepresentation","contactcustomerusualtime","communicateconsumeratwork","communicateconsumeranattorney","adheretocellphonepolicy","adhereto3rdpartypolicy","enterstatuscodecorrectly","raiseUDAAPconcerns","communicatefalsecreditinformation","handleconsumerdispute","maketimebarredaccounts","adhereFDCPAlaws","discriminatoryECOApolicy","adherestaterestriction","confirmauthoriseduser","recapthecallverify","properpaymentscript","paymentprocessingfee","obtainpermissionfromconsumer","educatetheconsumer","consumerconfirmationcode","demonstrateactivelistening","representclientandcompany","anticipateovercomeobjection","summarizethecall","provideVRScallbacknumber","setappropiatetimeline","closecallprofessionally","useproperactioncode","useproperresultcode","contextoftheconversation","removeanyphonenumber","updateaddressinformation","changestateofAccount","superviserforhandle","fusion_id","c_name","vsi_account","acpt","acpt_option","audit_type","voc","qa_type","call_summary","feedback","tl_id","openingscore","effortscore","negotiationscore","compliancescore","paymentscriptscore","callcontrolscore","closingscore","documentationscore","auditor_type","attach_file","entry_date","client_entryby","mgnt_rvw_by","mgnt_rvw_note","mgnt_rvw_date","agent_rvw_note","agent_rvw_date","client_rvw_by","client_rvw_note","client_rvw_date","log");

	 	return $field_val;

	 }

	 function excelColumnFieldValue(){
	 	return array ("Auditor Name","Audit Date","Collector Name","Call Date","Call Duration","Call Id","Phone Number","Call Score %","1. Identification","2. QA","3. Company Name","4. RPC","5. Demographics","6. MMD","7. Client Name","8. Balance","1. Delinquency","2. Full Information","3. Payment Request","4. Post Dated Payment","5. Follow Up","6. PTP","1. Split Balance","2. Settlement","3. Payment Plan","4. Negotiation Sequence","5. Negotiation Impact","6. Good Faith Payment","1. Misrepresentation","2. Agent Legal Threat","3. Represent falsely","4. Contact Times","5. Call at Work","6. Legal Representation","7. TCPA","8. Location policy","9. Correct Disposition","10. UDAAP","11. Credit Report Threat","12. Dispute handling","13. Barred Accounts","14. FDCPA Laws","15. VRS ECOA policy","16. State Laws","1. CC Authorized user","2. Verify customer info","3. Payment script","4. Payment fee","5. Payment permission","6. Correspondence","7. Confirmation Code","1. Active Listening","2. Represent Positive ","3. Objection handling","1. Summarize Call","2. VRS Call Back Number","3. Timelines","4. Professional Closing","1. Action Code","2. Result Code","3. Document Context","4. Phone Number Update","5. Address Update","6. Status Update","7. Escalation","1. Fusion ID","3. Client Name","4. VSI Account","5. ACPT","6. ACPT","7. Audit Type","8. VOC Option","9. QA Type","10. Call Summary","11. Feedback","","","","","","","","","","","","","","","","","","","","","","" );
	 }

	 function fatalFieldArray(){
	 	$fatalFieldArr=array("identifynameatbeginning","statetheclientname","misrepresentidentity","adherestaterestriction","paymentprocessingfee","obtainpermissionfromconsumer","useproperactioncode","changestateofAccount");
	 	return $fatalFieldArr;
	 }

	 function FieldArrayVal(){
	 	$fatalFieldArr=array("identifynameatbeginning"=>'1.25',"askforbalancedue"=>'1.25',"reasonfordelinquency"=>'4.17',"promisetopayaccount"=>'4.17',"splitbalanceinpart"=>'4.17',"offergoodfaithpayment"=>'4.17',"misrepresentidentity"=>'0.625',"adherestaterestriction"=>'0.625',"confirmauthoriseduser"=>'1.43',"consumerconfirmationcode"=>'1.43',"demonstrateactivelistening"=>'1.67',"anticipateovercomeobjection"=>'1.67',"summarizethecall"=>'1.25',"closecallprofessionally"=>'1.25',"useproperactioncode"=>'1.43',"superviserforhandle"=>'1.43');
	 	return $fatalFieldArr;	
	 }

	 function scoreFieldArray(){
	 	return array("openingscore","effortscore","negotiationscore","compliancescore","paymentscriptscore","callcontrolscore","closingscore","documentationscore");
	 }

	 function fatalScoreFieldArray(){
	 	$val=$this->scoreFieldArray();
	 	return array($val[0],$val[3],$val[4],$val[7]);
	 }

	 function CreateTable(){
	 	$field_val=$this->fieldVal();
	 	$cnt=count($field_val);
	 	$cond="";
	 	for($i=0;$i<$cnt-1;$i++){
	 		if(in_array($field_val[$i],array("audit_date","call_date","call_duration"))){

	 			$cond.="`".$field_val[$i]."` TIMESTAMP,";
	 		
	 		}else{
	 		
	 			$cond.="`".$field_val[$i]."` varchar(100) null,";
	 		}
	 	} 	
	 	$i+1;
	 	$cond.="`".$field_val[$i]."` varchar(100) null";
	 	$sql="CREATE TABLE IF NOT EXISTS tblProdigal (`id` int auto_increment Primary key,$cond)";
	 	$this->db->query($sql);
	 }

	 function allDataRectification(){
	 	
	 	$TotalField = $this->excel_import_model->allDataRectification();
	 	$rr=$TotalField;
	 	$fieldArrayVal1=$this->FieldArrayVal();
	 	$fieldArrayVal = array_keys($fieldArrayVal1);
	 	$fieldArraynumval = array_values($fieldArrayVal1);

	 	$cnt=count($fieldArrayVal);
	 	
	 	for($i=0;$i<$cnt;$i++){
	 			$key[] = array_search($fieldArrayVal[$i], $rr);
	 		}

	 	if($key[0]!=""){
	 		$kcnt=count($key);	
	 		for($i=0;$i<$kcnt;$i++){
	 			$dataval=$fieldArraynumval[$i];
	 			$j=$i++;
	 			foreach(range($key[$j],$key[$i]) as $num){
	 				$valTotalField[]=$rr[$num];
	 				$val[]=$dataval;			
	 			}
	 			$i+2;
	 		}
	 	}

	 	$AllFieldKeyVal=array_combine($valTotalField,$val);

	 	return $AllFieldKeyVal;

	 	}

	 function agentId($fusion_id){
	 	
	 	$fusion_id=trim($fusion_id);
	 	
	 	if ($fusion_id!="") {
	 		$data = $this->db->query("select id from signin where fusion_id='$fusion_id'")->row();	
	 	}else{
	 		$data->id=0;	
	 	}
	 	
	 	return $data->id;
	 }

	 function get_duplicates( $array ) {
    	return array_unique( array_diff_assoc( $array, array_unique( $array ) ) );
	}

	 function callIdDel($call_id){
	 	
	 	$dval=array_values($this->get_duplicates($call_id));
	 	$cnt=count($dval);
	 		
	 		for ($i=0; $i <$cnt ; $i++) { 
	 			$this->logDetailsErrorSucessMsg("Call Id is Duplicate: ".$dval[$i]);
	 		}

	 		$data = $this->db->query("DELETE t1 FROM qa_vrs_feedback t1 INNER JOIN qa_vrs_feedback t2 WHERE t1.id < t2.id AND t1.call_id = t2.call_id ");	
	 		if($data){
	 			return 1;
	 		}else{
	 			return 0;
	 		}
	 }

	 function tlId($fusion_id){
	 
	 	$fusion_id=trim($fusion_id);
	 	
	 	if ($fusion_id!="") {
	 		$data = $this->db->query("select assigned_to from signin where fusion_id='$fusion_id'")->row();	
	 	}else{
	 		$data->assigned_to=0;	
	 	}
	 	
	 	return $data->assigned_to;
	 }

	 function entryBy($email){
	 	$email=trim($email);
	 	$data = $this->db->query("select user_id from info_personal where email_id_off='$email'")->row();
	 	return $data->user_id;	
	 }

	 function checkingScore($key1,$key2,$fieldArrayVal){
	 	$key1=array_search($key1,$fieldArrayVal);
	 	$key2=array_search($key2,$fieldArrayVal);
	 	$piece=$this->getPiece($key1,$key2,$fieldArrayVal);
	 	return array_slice($fieldArrayVal,$key1,$piece);
	 }

	 function fatalCal(){

	 	$TotalField=$this->fieldVal();
	 	$rr=$TotalField;
	 	$fatalFieldArr=$this->fatalFieldArray();
	 	$cnt=count($fatalFieldArr);
	 	
	 	for($i=0;$i<$cnt;$i++){
	 		$key[] = array_search($fatalFieldArr[$i], $rr);
	 	}
	 	
	 	foreach($key as $keys => $value)          
    		if(empty($value)) 
        		unset($key[$keys]);

        $key=array_values($key);

	 	if($key[0]!=""){
	 		$kcnt=count($key);	
	 		for($i=0;$i<$kcnt;$i++){
	 			$j=$i++;
	 			foreach(range($key[$j],$key[$i]) as $num){
	 				$valFatalField[]=$rr[$num];	 			
	 			}
	 			$i+2;
	 		}
	 	}

	 	$cond="";
	 	$cnt=count($valFatalField);
	 	for($i=0;$i<$cnt-1;$i++){
	 		$cond.="CHANGE `$valFatalField[$i]` `$valFatalField[$i]` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'fatal',";
	 	}
	 	$i+1;
	 	$cond.="CHANGE `$valFatalField[$i]` `$valFatalField[$i]` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'fatal'";

	 	$sql="ALTER TABLE `tblProdigal` $cond;";

	 	$this->db->query($sql);

	 }

	 function logDetailsErrorSucessMsg($msg){
	 	$error_message = $msg; 
  		$log_file = "./vrs-log.log"; 
  		if (file_exists($log_file)) 
	    {
	    	ini_set("log_errors", TRUE);  
			ini_set('error_log', $log_file); 
			error_log($error_message);    
	    }		 
	 }

	 function getPiece($key1,$key2){
	 	foreach (range($key1,$key2) as $value) {
	 		$count[]=$value;
	 	}
	 	return $count=count($count);
	 }

	 

	function import($filename,$path)
	{

		$op_val=0;
		$y=0;
		$j=1;
		$fatl=0;
		
		$this->CreateTable();
		$this->fatalCal();
		
		$field_val=$this->fieldVal();
		$fatal_field_name=$this->excel_import_model->fatalFieldName();		 
		$AllFieldKeyVal=$this->allDataRectification();
		$fieldArrayVal = array_keys($AllFieldKeyVal);
		$scoreFieldArray=$this->scoreFieldArray();
		$calFieldKey=array_keys($this->FieldArrayVal());
		$countCalFieldKey=count($calFieldKey);
		$calFieldKey=array_chunk($calFieldKey, 2);
		$fatalCalFieldKey=array_values($this->fatalFieldArray());
		$countFatalCalFieldKey=count($fatalCalFieldKey);
		$fatalCalFieldKey=array_chunk($fatalCalFieldKey,2);
		$fatalScoreFieldCategory=$this->fatalScoreFieldArray();

		for($i=0;$i<($countCalFieldKey/2);++$i){
			$scoreTotalCategory[]=$this->checkingScore($calFieldKey[$i][0],$calFieldKey[$i][1],$fieldArrayVal);
		}

		for($i=0;$i<($countFatalCalFieldKey/2);++$i){
			$fatalScoreTotalCategory[]=$this->checkingScore($fatalCalFieldKey[$i][0],$fatalCalFieldKey[$i][1],$fieldArrayVal);
		}

		$countScoreTotalCategory=count($scoreTotalCategory);
		$countFatalScoreTotalCategory=count($fatalScoreTotalCategory);

		$cnt=count($field_val);
		if($filename)
		{
		    $path = $path.$filename;
		    $object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
			    $highestRow = $worksheet->getHighestRow();
			    $highestColumn = $worksheet->getHighestColumn();
			    
				if($y==0)
				{
				    for($row=1; $row<=$highestRow; $row++)
				    {
				    	if($row===1)
				    	{
				    		 for($i=0;$i<$cnt;$i++)
						   	{
							  	$excelColumnFieldValue[]=$worksheet->getCellByColumnAndRow($i, $row)->getValue();
							}
							continue;
						}

				        if($cnt!="")
				        {	     	 
						   	for($i=0;$i<$cnt;$i++)
						   	{
							    		
								if(in_array($field_val[$i],array("audit_date","call_date","entry_date")))
								{
							    	if($field_val[$i]=="entry_date")
							    	{
							     				$val[$field_val[$i]]=date('Y-m-d H:i:s');		
							     	}else
							     	{
							     				$val[$field_val[$i]] = date('Y-m-d h:i:s', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow($i, $row)->getValue()));		
							     	}	     		
							    }elseif($field_val[$i]=="call_duration")
							    {
							     			$val[$field_val[$i]] = date('h:i:s', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow($i, $row)->getValue()));
							    }elseif($field_val[$i]=="call_id")
							    {
							     			$val[$field_val[$i]] = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
							     			$val_call_id[]=$val[$field_val[$i]];
							    }elseif(in_array($field_val[$i],$fieldArrayVal))
							    {
							     			$val[$field_val[$i]] = trim($worksheet->getCellByColumnAndRow($i, $row)->getValue());
							     			
							    	if($val[$field_val[$i]]!=="No")
							    	{
							     				$jakiholo[$field_val[$i]]=$AllFieldKeyVal[$field_val[$i]];
							     	}else
							     	{
							     				$jakiholo[$field_val[$i]]=0;
							     	}
							    }elseif($field_val[$i]=='entry_by')
							    {
							     			$val[$field_val[$i]]=$this->entryBy($worksheet->getCellByColumnAndRow($i, $row)->getValue());
							     		
							    }elseif($field_val[$i]=='fusion_id')
							    {
							     			$val[$field_val[$i]] = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
							     			$rastro=$worksheet->getCellByColumnAndRow($i, $row)->getValue();
							    }else
							    {
							     			$val[$field_val[$i]] = $worksheet->getCellByColumnAndRow($i, $row)->getValue();		
							    }
							     	  
					 		}     	     
						}
					    $data[]=$val;
					    $rastroVal[]=$rastro;
					    $valData[]=$jakiholo;
					     	
					}
				
					
					$rascnt=count($rastroVal);
					for($i=0;$i<$rascnt;$i++)
					{
					   		$data[$i]['agent_id']=$this->agentId($rastroVal[$i]);
					   		$data[$i]['tl_id']=$this->tlId($rastroVal[$i]);
					}
				   		
				   	for($i=0;$i<$rascnt;$i++)
				   	{				   			
					   	$forcnt=count($valData[$i]);
					   		for($j=0;$j<$forcnt;$j++)
					   		{

					   			if($scoreTotalCategory!=0)
					   			{

						   			for($x=0;$x<$countScoreTotalCategory;$x++)
						   			{

									   	if(in_array($fieldArrayVal[$j],$scoreTotalCategory[$x]))
									   	{
									   		$data[$i][$scoreFieldArray[$x]][]=$valData[$i][$fieldArrayVal[$j]];
									   	}
								    }
							    }
						   	}

						   	for($x=0;$x<$countScoreTotalCategory;$x++)
						   	{
						   		$data[$i][$scoreFieldArray[$x]]=array_sum($data[$i][$scoreFieldArray[$x]]);
						   		$sum[]=$data[$i][$scoreFieldArray[$x]];
						    }
						    
						   	$data[$i]['overall_score']=array_sum($sum);
						   		$data[$i]['overall_score']=number_format((float)$data[$i]['overall_score'], 2, '.', '');
						   	if($data[$i]['overall_score']>=100)
						   	{
						   		$data[$i]['overall_score']=100;
						   	}

						   	for($j=0;$j<$forcnt;$j++)
						   	{
								
						   		for($x=0;$x<$countFatalScoreTotalCategory;$x++){
									if(in_array($fieldArrayVal[$j],$fatalScoreTotalCategory[$x]))
									{									
										if($valData[$i][$fieldArrayVal[$j]]===0)
										{
											$data[$i][$fatalScoreFieldCategory[$x]]=0;						
										}		   			
								   	}
							   	}
							   	
							   	if(in_array($fieldArrayVal[$j],$fatal_field_name))
							   	{
									if($valData[$i][$fieldArrayVal[$j]]===0)
									{
										$data[$i]['overall_score']=0;						
									}		   			
							   	}
			   				}
				
					}
					
					$columnArrayCount=array_diff($excelColumnFieldValue,$this->excelColumnFieldValue());
					$columnArrayCount=count($columnArrayCount);
					if($columnArrayCount===0){
						if($excelColumnFieldValue==$this->excelColumnFieldValue()){
							$val_in=$this->excel_import_model->insert($data);
							$this->callIdDel($val_call_id);
							return $val_in;

						}else
						{
							$this->logDetailsErrorSucessMsg("Field Format in File name ".$filename." not matched.");
							return false;
						}
					}else
					{
						$this->logDetailsErrorSucessMsg("Excel Column Name String Value in File name ".$filename." not matched.");
						return false;
					}
					
				}else
				{	
					
					if($op_val==0){
					$this->logDetailsErrorSucessMsg("Field Count in File name ".$filename." not matched.");
					}
					$op_val++;
			   		return false;
				}
			}
		}else{
			$this->logDetailsErrorSucessMsg("File name ".$filename." is not exist.");
		}
		   		
		   
		   
	}


}

 ?>