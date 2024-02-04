<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Randomizer extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library('excel');
		$this->load->helper('randomizer_db');
		$this->load->model('Common_model');
		$this->load->model('Email_model');
	}
	
	/* public function index(){
		$this->view();
	}
	
	public function view(){
		if(check_logged_in()){
			
			$filter_templates = $this->input->get('function');
			$data["aside_template"] = "randomizer/aside.php";
			
			$SQLtxt = "SELECT *,(select shname from client WHERE client.id =cron_randomizer.client)as client_name,(select name from process WHERE process.id = cron_randomizer.process)as process_name  FROM cron_randomizer";
			$data['randomizer_clients'] = $this->Common_model->get_query_result_array($SQLtxt);
			
			if($filter_templates == 'S'){
				$data["content_template"] = "randomizer/randomizer_settings.php";
				
			}elseif($filter_templates == 'C'){
				
				$data["content_template"] = "randomizer/client_add.php";
				$data['client_list'] = $this->Common_model->get_client_list();
			
				
			}elseif($filter_templates == 'D'){
				$data["content_template"] = "randomizer/dispo_add.php";
				
				$SQLtxt = "SELECT * from cron_randomizer WHERE status = 1";
				$data['randomizer'] = $this->Common_model->get_query_result_array($SQLtxt);
				
			}else{
				$data["content_template"] = "randomizer/randomizer_settings.php";
			}
			
			$this->load->view('dashboard.php',$data);
			
		}
	} */
	
	public function index(){
		if(check_logged_in()){
			
			$data["aside_template"] = "randomizer/aside.php";
			$data["content_template"] = "randomizer/client_add.php";
			$data["content_js"] = "randomizer/randomizer_js.php";
			
			$data['client_list'] = $this->Common_model->get_client_list();	
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			$SQLtxt = "SELECT *, (select concat(fname, ' ', lname) as name from signin s1 where s1.id=created_by) as created_name, (select concat(fname, ' ', lname) as name from signin s2 where s2.id=updated_by) as updated_name, (select shname from client WHERE client.id =cron_randomizer.client)as client_name,(select name from process WHERE process.id = cron_randomizer.process)as process_name  FROM cron_randomizer where status=1";
			$data['randomizer_clients'] = $this->Common_model->get_query_result_array($SQLtxt);
			
			$this->load->view('dashboard.php',$data);
		}
	}
	
	
	public function create_client(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$randomizer_name = $this->input->post('randomizername');
			$r_name = str_replace(" ","_",$randomizer_name);

			if($randomizer_name!=''){
				$field_array =array(
					'randomizer'=>$r_name,
					'client'=>$this->input->post('client_id'),
					'process'=>$this->input->post('process_id'),
					'cnum'=>$this->input->post('cnum'),
					'db_ip'=>$this->input->post('dbip'),
					'db_name'=>$this->input->post('dbhostname'),
					'db_user'=>$this->input->post('dbuser'),
					'db_pass'=>$this->input->post('dbpassword'),
					'db_table'=>$this->input->post('dbtable'),
					//'cron_datetime'=>$this->input->post('dbcrontime'),
					'status'=>1,
					'created_by'=>$current_user,
					'created_date'=>CurrMySqlDate()
				);
				$rowid = data_inserter('cron_randomizer',$field_array);
			}
			redirect('randomizer');
		}
	}
	
	public function edit_client(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$rand_id = $this->input->post('rand_id');
			$randomizer_name = $this->input->post('randomizername');
			$r_name = str_replace(" ","_",$randomizer_name);
			
			if($rand_id!=''){
				$field_array =array(
					'randomizer'=>$r_name,
					'client'=>$this->input->post('client_id'),
					'process'=>$this->input->post('process_id'),
					'cnum'=>$this->input->post('cnum'),
					'db_ip'=>$this->input->post('dbip'),
					'db_name'=>$this->input->post('dbhostname'),
					'db_user'=>$this->input->post('dbuser'),
					'db_pass'=>$this->input->post('dbpassword'),
					'db_table'=>$this->input->post('dbtable'),
					//'cron_datetime'=>$this->input->post('dbcrontime'),
					'status'=>1,
					'updated_by'=>$current_user,
					'updated_date'=>CurrMySqlDate()
				);
				$this->db->where('id', $rand_id);
				$this->db->update('cron_randomizer', $field_array);
			}
			redirect('randomizer');
			
		}
	}
	
	/* public function delete_clients(){
		if(check_logged_in()){
			
			$randomizer_id = $this->input->post('randomizer_id');
			
			$SQLtxt1 = "DELETE from cron_randomizer WHERE cron_id = ". $randomizer_id ."";
			$SQLtxt2 = "DELETE from cron_randomizer_disposition WHERE randomizer_id = ". $randomizer_id ."";

			$this->db->trans_begin();

			$this->db->query($SQLtxt1);
			$this->db->query($SQLtxt2);

			if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					echo json_encode(array('success'=>0));
			}else{
					$this->db->trans_commit();
					echo json_encode(array('success'=>1));
						
			}
			
			
			
		}
	} */
	
	/* public function create_cron_details(){
		if(check_logged_in()){
			
			$randomizer_name = $this->input->post('randomizername');
			$client_id = $this->input->post('client_id');
			$process_id = $this->input->post('process_id');
			$cnum = $this->input->post('cnum');
			$dbip = $this->input->post('dbip');
			$dbhostname = $this->input->post('dbhostname');
			$dbuser = $this->input->post('dbuser');
			$dbpassword = $this->input->post('dbpassword');
			$dbcrontime = $this->input->post('dbcrontime');
			
			$field_array =array('randomizer'=>$randomizer_name,
								'client'=>$client_id,
								'process'=>$process_id,
								'cnum'=>$cnum,
								'db_ip'=>$dbip,
								'db_name'=>$dbhostname,
								'db_user'=>$dbuser,
								'db_pass'=>$dbpassword,
								'cron_datetime'=>$dbcrontime,
								'status'=>1,
							);
			
			$rowid = data_inserter('cron_randomizer',$field_array);
			
		}
	} */
	
	public function disposition(){
		if(check_logged_in()){
			
		}
	}
	
	
	public function create_disposition(){
		if(check_logged_in()){
			
			$randomizer_id    = $this->input->post('randomizer_id');
			$disposition_name = $this->input->post('disposition');
			$disposition_val = $this->input->post('value');
			
			$SQLtxt = "SELECT * FROM cron_randomizer WHERE cron_id = ". $randomizer_id ."";
			$fields = $this->Common_model->get_query_row_array($SQLtxt);
			
			if(!empty($fields)){
				$array_fields = array();
				
				$i=0;
				foreach($disposition_name as $disposition){
						$array_fields[]['randomizer_id'] = $randomizer_id; 
						$array_fields[$i]['dispo_name'] = $disposition;  
						$array_fields[$i]['dispo_value'] = $disposition_val[$i];  
						
						$SQLtxt = "REPLACE INTO cron_randomizer_disposition(randomizer_id,dispo_name,dispo_value) VALUES (". $randomizer_id .",'". $disposition ."',". $disposition_val[$i] .")";
						$this->db->query($SQLtxt);
						
						$i++;
				}
				
				//$data['dispo'] = $this->db->insert_batch('cron_randomizer_disposition',$array_fields);
				
				
			}
				redirect('randomizer?function=D');
		}
	}
	
	public function get_cron_randomizer(){
		if(check_logged_in()){
			
			$r_id = $this->input->post('randomizer');
			
				$SQLtxt ="SELECT *,(select shname from client WHERE client.id =cron_randomizer.client)as client_name,(select name from process WHERE process.id = cron_randomizer.process)as process_name FROM cron_randomizer WHERE cron_id=". $r_id ."";
				$randomizer_list = $this->Common_model->get_query_row_array($SQLtxt);
				
				echo json_encode($randomizer_list);
			 
		}
	}
	
	public function get_disposition_list(){
		if(check_logged_in()){
			
			$r_id = $this->input->post('randomizer');
			
			$SQLtxt ="SELECT * FROM cron_randomizer_disposition WHERE randomizer_id = $r_id ";
			$disposition_list = $this->Common_model->get_query_result_array($SQLtxt);
			
			echo json_encode($disposition_list);
			
		}
	}
	
	public function delete_disposition_list(){
		if(check_logged_in()){
			$r_id = $this->input->post('dispo_id');
			
			$SQLtxt ="DELETE FROM cron_randomizer_disposition WHERE dispo_id = $r_id ";
			$delete_dispo = $this->db->query($SQLtxt);
			
			if($delete_dispo == true){
				echo json_encode(array('success'=>1));
			}else{
				echo json_encode(array('success'=>0));
			}
		}
	}
	
	
	public function getProcessList(){
	if(check_logged_in())
    {
		$cid = trim($this->input->post('cid'));
		
		if(get_login_type()=="client"){
			$clients_client_id=get_clients_client_id();
			$clients_process_id=get_clients_process_id();
			$qSql = "SELECT * from process WHERE id in ( $clients_process_id ) and client_id='$cid' ORDER BY name";
			echo json_encode($this->Common_model->get_query_result($qSql));
			
		}else{
			//echo $this->Common_model->get_process_list($cid);		
			echo json_encode($this->Common_model->get_process_list($cid));
			}
		}
	}
	
	//*****************************************************************************************************//
	// 									CRON RANDOMIZER SECTION 										   //
	//*****************************************************************************************************//
	
	
	public function cron_randomizer(){
		
		$field_rows=array();
        $field_merge=array();
		$i=0;
		
		$SQLtxt = "SELECT *,(select shname from client WHERE client.id =cron_randomizer.client)as client_name,(select name from process WHERE process.id = cron_randomizer.process)as process_name  from cron_randomizer ORDER BY cron_id";
		$clients = $this->Common_model->get_query_result_array($SQLtxt);
		
		echo "<pre>";
		print_r($clients); 
		
		 foreach($clients as $c_name){
			 
			$config_settings = random_db($c_name['db_ip'],$c_name['db_user'],$c_name['db_pass'],$c_name['db_name']);
		 
			$this->load->model('Randomizer_model','',$config_settings);
			$this->Randomizer_model->set_database($config_settings);
			
			 
			 $SQLtxt = "SELECT * from cron_randomizer_disposition WHERE randomizer_id = ". $c_name['cron_id'] ."";
			 $disposition = $this->Common_model->get_query_result_array($SQLtxt); 
			 
			 foreach ($disposition as $value) {
				   $field_rows =  $this->Randomizer_model->get_randome_data($value['cnum'],$value['dispo_name'],$value['process_name'],$value['dispo_value']);
					array_push($field_merge,$field_rows);              
					$i++;
					
			}
			
			echo $c_name['process_name']."</br>";
			$FILE_PATH ='';
			
			$pvDate = date('Y-m-d', strtotime('-1 day'));
				if (!file_exists(FCPATH."temp_files/randomizer_dump/".$c_name['process_name'])) {
					mkdir(FCPATH."temp_files/randomizer_dump/".$c_name['process_name'].'/' . $pvDate . ".xlsx", 0777, true);
					$FILE_PATH = FCPATH."temp_files/randomizer_dump/".$c_name['process_name'].'/' . $pvDate . ".xlsx";
				}else{
					$FILE_PATH = FCPATH."temp_files/randomizer_dump/".$c_name['process_name'].'/' . $pvDate . ".xlsx";
					$ret = $this->generate_xls($field_merge, $FILE_PATH, $c_name['process_name']);
				}
			
			$ebody = '';
			$ebody .= "Please find the attachment for ". $c_name['process_name'] ." on ".$pvDate;
			$ebody .= "<br><br><b>Regards,</b> </br>";
			$ebody .= "<b>Fusion - PHP Development Team.</b>";
			
			$esubject = $c_name['process_name'] ." Randomizer Report on ".$pvDate;
		
			if($ret==true){
				
				echo $c_name['process_name']." Process Done and Email sent on ".$pvDate;
				$is_send=$this->Email_model->send_email_sox('','vivek.prasad@fusionbposervices.com','kunal.bose@fusionbposervices.com',$ebody,$esubject,$FILE_PATH);
				
			}else{
				
				$ebody ="Error to published ". $c_name['process_name'] ." Randomizer on ".$pvDate;
				$esubject ="Error to published OYO UK Randomizer on ".$pvDate;
			
				echo "Error to published ". $c_name['process_name'] ." Randomizer on ".$pvDate;
				$is_send=$this->Email_model->send_email_sox('','vivek.prasad@fusionbposervices.com','vivek.prasad@fusionbposervices.com',$ebody,$esubject,$FILE_PATH);
			} 
					
				 
		 }
	}
		
		/* $ebody = "Hi, <br><br>";
		$ebody .= "Please find the attachment for OYO UK on ".$pvDate;
		$ebody .= "<br><br><b>Regards,</b> </br>";
		$ebody .= "<b>Fusion - PHP Development Team.</b>";
			
		$esubject ="OYO UK Randomizer Report on ".$pvDate;
		
		if($ret==true){
			$this->send_email($ebody,$esubject,$FILE_PATH);
			echo "OYO UK Process Done and Email sent on ".$pvDate;
		}else{
			
			$ebody ="Error to published OYO UK Randomizer on ".$pvDate;
			$esubject ="Error to published OYO UK Randomizer on ".$pvDate;
		
			echo "Error to published OYO UK Randomizer on ".$pvDate;
			$this->send_email($ebody,$esubject,"");
		} */
		
		
		
		public function generate_xls($array_records=array(), $FILE_PATH, $projName=""){
		
		$ret = TRUE;
		try{
			
        $row=3;
        $this->excel->createSheet(0);
        $this->excel->setActiveSheetIndex(0);
        $objWorksheet = $this->excel->getActiveSheet();
        $objWorksheet->setTitle($projName.' CALL DATA');
         
		
        // START GRIDLINES HIDE AND SHOW//
        $objWorksheet->setShowGridlines(true);
        // END GRIDLINES HIDE AND SHOW//
        
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objWorksheet->getColumnDimension('A')->setAutoSize(true);
        $objWorksheet->getColumnDimension('B')->setAutoSize(true);
        $objWorksheet->getColumnDimension('C')->setAutoSize(true);
        $objWorksheet->getColumnDimension('D')->setAutoSize(true);
        $objWorksheet->getColumnDimension('E')->setAutoSize(true);
        $objWorksheet->getColumnDimension('F')->setAutoSize(true);
        $objWorksheet->getColumnDimension('G')->setAutoSize(true);
        $objWorksheet->getColumnDimension('H')->setAutoSize(true);
        $objWorksheet->getColumnDimension('I')->setAutoSize(true);
        $objWorksheet->getColumnDimension('J')->setAutoSize(true);
        $objWorksheet->getColumnDimension('K')->setAutoSize(true);
        $objWorksheet->getColumnDimension('L')->setAutoSize(true);
        $objWorksheet->getColumnDimension('M')->setAutoSize(true);
        $objWorksheet->getColumnDimension('N')->setAutoSize(true);
        $objWorksheet->getColumnDimension('O')->setAutoSize(true);
        $objWorksheet->getColumnDimension('P')->setAutoSize(true);
        $objWorksheet->getColumnDimension('Q')->setAutoSize(true);
        $objWorksheet->getColumnDimension('R')->setAutoSize(true);
        $objWorksheet->getColumnDimension('S')->setAutoSize(true);        
        
        
	
        $this->excel->getActiveSheet()->getStyle('A1:S1'.$this->excel->getActiveSheet()->getHighestRow())
       ->getAlignment()->setWrapText(true);
        /// for border of the cells
  
        
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        
        $objWorksheet->getStyle("A1:S1")->applyFromArray($style);
        unset($style);
        
        // CELL BACKGROUNG COLOR
        $this->excel->getActiveSheet()->getStyle("A1:S1")->getFill()->applyFromArray(
                    array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => "F28A8C"
                        )
                    )
                );
        
        // CELL FONT AND FONT COLOR 
        $styleArray = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 16,
            'name'  => 'Algerian'
        ));
        
        $this->excel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
        $sheet = $this->excel->getActiveSheet();
        $sheet->setCellValueByColumnAndRow(0, 1,  $projName." CALL DISPOSITION");
        $sheet->mergeCells('A1:S1');
         
        
        $styleArray = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );

        $this->excel->getActiveSheet()->getStyle('A2:S2')->applyFromArray($styleArray);
       
        
        // CELL BACKGROUNG COLOR
        $this->excel->getActiveSheet()->getStyle("A2:S2")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => "F28A8C"
                    )
                ));
       
  
         
            // CELL FONT AND FONT COLOR 
        $styleArray = array(
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => '000000'),
                        'size'  => 9,
                        'name'  => 'Calibri'
                    ),
                    'borders' => array(
                           'allborders' => array(
                             'style' => PHPExcel_Style_Border::BORDER_THIN
                           )
                         )
        );
        
        $this->excel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('C2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('D2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('E2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('F2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('G2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('H2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('I2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('J2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('K2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('L2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('M2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('N2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('O2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('P2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('Q2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('R2')->applyFromArray($styleArray); 
        $this->excel->getActiveSheet()->getStyle('S2')->applyFromArray($styleArray); 
        
        $styleArray = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );
 
        
        $objWorksheet->setCellValue('A2', 'Date');
        $objWorksheet->setCellValue('B2', 'Recid');
        $objWorksheet->setCellValue('C2', 'main_disposition');
        $objWorksheet->setCellValue('D2', 'sub_disposition');
        $objWorksheet->setCellValue('E2', 'cnum');
        $objWorksheet->setCellValue('F2', 'tollfree');
        $objWorksheet->setCellValue('G2', 'dnis');
        $objWorksheet->setCellValue('H2', 'rectype');
        $objWorksheet->setCellValue('I2', 'savetime');
        $objWorksheet->setCellValue('J2', 'agentid');
        $objWorksheet->setCellValue('K2', 'recstamp');
        $objWorksheet->setCellValue('L2', 'groupid');
        $objWorksheet->setCellValue('M2', 'ani');
		$objWorksheet->setCellValue('N2', 'duration');				
		$objWorksheet->setCellValue('O2', 'notesdesc');
        $objWorksheet->setCellValue('P2', 'ucid');
        $objWorksheet->setCellValue('Q2', 'project_id');
        $objWorksheet->setCellValue('R2', 'project_name');
        $objWorksheet->setCellValue('S2', 'Desk name');
        
        
        foreach ($array_records as $fields_rows){
            foreach ($fields_rows as $fields){
                
                     // border
                            $styleArray = array(
                                'borders' => array(
                                  'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN
                                  )
                                )
                              );
                            
                                                        
                            $this->excel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('I'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('K'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('L'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('M'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('N'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('O'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('P'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('R'.$row)->applyFromArray($styleArray);
                            $this->excel->getActiveSheet()->getStyle('S'.$row)->applyFromArray($styleArray);
//                            unset($styleArray);
                        
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $fields['DATE']); 
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $fields['recid']); 
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $fields['main_disposition']); 
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $fields['sub_disposition']); 
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $fields['cnum']); 
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $fields['tollfree']); 
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $fields['dnis']); 
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $fields['rectype']); 
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $fields['savetime']); 
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $fields['agentid']); 
                            //$this->excel->getActiveSheet()->getStyleByColumnAndRow(10, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $fields['recstamp']);
                            //$this->excel->getActiveSheet()->getStyleByColumnAndRow(12, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $fields['groupid']);
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $fields['ani']);
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $fields['duration']);
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $fields['notesdesc']);
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $fields['ucid']);
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $fields['project_id']);
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $fields['project_name']);
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $fields['Desk name']);
						$row ++;    
            }
            
            
        }
		
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save($FILE_PATH);
		
		
		}catch(Exception $ex){
			$ret = false;
			echo 'Error type: ' .$ex->getMessage();
			print_r(error_get_last());
		}
		
		return $ret;
		
    }
	
	
	
	
}






