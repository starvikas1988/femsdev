<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wfh_assets extends CI_Controller {
   
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
	 private $objPHPExcel;
	 function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();		
	 }
	 
    public function index()
    {
       if(isAccessAssetWFH()==false) redirect(base_url().'home',"refresh");
	   
	    $current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "wfh_assets/wfh_aside.php";
		$data["content_template"] = "wfh_assets/wfh_assets.php";
		
		
		// OFFICE DROPDOWN
		$extra_office_arr = array('BLR','HWH','KOL');
		if(get_role_dir()=="super" || $is_global_access==1){
			$sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh";			
		}else{
			$sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh WHERE location IN ('$user_office_id')";
			if(isADLocation() == true){ $sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh WHERE location = 'Ameridial'"; }
			if(in_array($user_office_id, $extra_office_arr)){ $sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh WHERE location = 'India'"; }
		}
		$data['location_list'] = $this->Common_model->get_query_result_array($sql_office);
		
		
		// OFFICE FILTER
		$extraoffice = ""; $get_office_id = ""; $get_search_name = "";
		$get_office_id = $this->input->get('office_id'); 
		$get_search_name = $this->input->get('search_name');
		if(get_role_dir()!="super" && $is_global_access!=1){  
			if($get_office_id == ""){ $get_office_id = $user_office_id; } 			
			if(isADLocation() == true){ $get_office_id = "Ameridial"; }
			if(in_array($get_office_id, $extra_office_arr)){ $get_office_id = "India"; }
		}
		
		if(($get_office_id != "") && ($get_office_id != "ALL")){
			$extraoffice = " AND f.location = '$get_office_id' "; 
			//if(isADLocation() == true){ $extraoffice = " AND f.location =  = 'Ameridial'"; }
			//if(in_array($user_office_id, $extra_office_arr)){ $extraoffice = " AND f.location = 'India'"; }
		}
		if(($get_search_name != "") && ($get_search_name != "")){ $extraoffice .= " AND (f.emp_name LIKE '%$get_search_name%' OR f.fusion_id LIKE '%$get_search_name%' OR f.site_id LIKE '%$get_search_name%')"; }
		$data['getlocation'] = $get_office_id;
		$data['getsearchname'] = $get_search_name;
		
		
		
		$wfh_list = "SELECT f.*, concat(s.fname,' ',s.lname) as fullname, s.office_id 
		             from asset_allocation_wfh as f 
		             LEFT JOIN signin as s ON s.fusion_id = f.fusion_id
					 WHERE f.id NOT IN (SELECT alloc_id from asset_return_wfh)
					 $extraoffice";
		$data['wfh_list'] = $this->Common_model->get_query_result_array($wfh_list);
		
		
		$wfh_return_list = "SELECT f.*, r.return_office_assets, r.return_office_headset, r.return_office_dongle, concat(s.fname,' ',s.lname) as fullname, s.office_id 
		             from asset_return_wfh as r 
		             LEFT JOIN asset_allocation_wfh as f ON r.alloc_id = f.id
		             LEFT JOIN signin as s ON f.fusion_id = s.fusion_id
					 $extraoffice";
		$data['wfh_return_list'] = $this->Common_model->get_query_result_array($wfh_return_list);
		
		$this->load->view('dashboard',$data);
	   
	}

    public function returnlist()
    {
       
	    $current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "wfh_assets/wfh_aside.php";
		$data["content_template"] = "wfh_assets/wfh_return.php";
		
		// OFFICE DROPDOWN
		$extra_office_arr = array('BLR','HWH','KOL');
		if(get_role_dir()=="super" || $is_global_access==1){
			$sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh";
		}else{
			$sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh WHERE location IN ('$user_office_id')";
			if(isADLocation() == true){ $sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh WHERE location = 'Ameridial'"; }
			if(in_array($user_office_id, $extra_office_arr)){ $sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh WHERE location = 'India'"; }
		}
		$data['location_list'] = $this->Common_model->get_query_result_array($sql_office);
		
		// OFFICE FILTER
		$extraoffice = ""; $get_office_id = ""; $get_search_name = "";
		$get_office_id = $this->input->get('office_id'); 
		$get_search_name = $this->input->get('search_name');
		if(get_role_dir()!="super" && $is_global_access!=1){  
			if($get_office_id == ""){ $get_office_id = $user_office_id; } 			
			if(isADLocation() == true){ $get_office_id = "Ameridial"; }
			if(in_array($get_office_id, $extra_office_arr)){ $get_office_id = "India"; }
		}
		
		if(($get_office_id != "") && ($get_office_id != "ALL")){
			$extraoffice = " AND f.location = '$get_office_id' "; 
			//if(isADLocation() == true){ $extraoffice = " AND f.location =  = 'Ameridial'"; }
			//if(in_array($user_office_id, $extra_office_arr)){ $extraoffice = " AND f.location = 'India'"; }
		}
		if(($get_search_name != "") && ($get_search_name != "")){ $extraoffice .= " AND (f.emp_name LIKE '%$get_search_name%' OR f.fusion_id LIKE '%$get_search_name%' OR f.site_id LIKE '%$get_search_name%')"; }
		$data['getlocation'] = $get_office_id;
		$data['getsearchname'] = $get_search_name;
	
		$wfh_return_list = "SELECT f.*, r.return_office_assets, r.return_office_headset, r.return_office_dongle, r.return_office_sim, r.remarks, concat(s.fname,' ',s.lname) as fullname, s.office_id 
		             from asset_return_wfh as r 
		             INNER JOIN asset_allocation_wfh as f ON r.alloc_id = f.id $extraoffice
		             LEFT JOIN signin as s ON f.fusion_id = s.fusion_id";
		$data['wfh_return_list'] = $this->Common_model->get_query_result_array($wfh_return_list);
		
		$this->load->view('dashboard',$data);
	   
	}
	
	
	
	public function reports()
    {
       
	    $current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['is_role_dir'] = $is_role_dir;
		$data["aside_template"] = "wfh_assets/wfh_aside.php";
		$data["content_template"] = "wfh_assets/wfh_reports.php";
		
		// OFFICE DROPDOWN
		$extra_office_arr = array('BLR','HWH','KOL');
		if(get_role_dir()=="super" || $is_global_access==1){
			$sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh";
		}else{
			$sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh WHERE location IN ('$user_office_id')";
			if(isADLocation() == true){ $sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh WHERE location = 'Ameridial'"; }
			if(in_array($user_office_id, $extra_office_arr)){ $sql_office = "SELECT DISTINCT(location) from asset_allocation_wfh WHERE location = 'India'"; }
		}
		$data['location_list'] = $this->Common_model->get_query_result_array($sql_office);
		
	
		$this->load->view('dashboard',$data);
	   
	}
	
	
	// RETURN SUBMISSION
	
	 public function wfh_return_submit(){
	 
		$alloc_id = $this->input->post('alloc_id');
		
		$current_user = get_user_id();
		$current_date = CurrMySqlDate();
		$logs = get_logs();
		
		
		$assets_returned = $this->input->post('assets_returned'); 
		$assets_headset = $this->input->post('assets_headset');   
		$assets_dongle = $this->input->post('assets_dongle'); 
		$assets_sim = $this->input->post('assets_sim'); 
		$assets_remarks = $this->input->post('assets_remarks'); 
		
		
		if(($alloc_id != "")){
			
			$field_array = array(
			    "alloc_id" => $alloc_id,
				"return_office_assets" => $assets_returned,
				"return_office_headset" => $assets_headset,
				"return_office_dongle" => $assets_dongle,
				"return_office_sim" => $assets_sim,
				"remarks" => $assets_remarks,
				"entry_by" => $current_user,
				"entry_date" => $current_date,
				"log" => $logs
			);
			
			data_inserter('asset_return_wfh', $field_array);
			
			$ans="Done";
			
		} else {
			$ans="Error";
		}
		
		echo $ans;
		
	 }
	

   	public function generate_wfh_assets_xls()
	 {
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();

		
		$extraoffice = "";
		$extra_office_arr = array('BLR','HWH','KOL');
		$get_office_id = $this->uri->segment(3);
		if(($get_office_id != "") && ($get_office_id != "ALL")){
			$extraoffice = " AND f.location = '$get_office_id' "; 
			//if(isADLocation() == true){ $extraoffice = " AND f.location =  = 'Ameridial'"; }
			//if(in_array($user_office_id, $extra_office_arr)){ $extraoffice = " AND f.location = 'India'"; }
		}
				
		$wfh_list_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, CONCAT(ls.fname, ' ', ls.lname) as l1_supervisor,
		                      d.description as department, r.name as designation, s.office_id as office, 
							  get_process_names(s.id) as process_name, get_client_names(s.id) as client_name, f.*, 
							  fr.remarks as return_remarks, fr.entry_by as return_by, fr.return_office_assets, 
							  fr.return_office_dongle, fr.return_office_headset, fr.return_office_sim, fr.entry_date as return_date, CONCAT(rs.fname, ' ', rs.lname) as return_by_name
							  from asset_allocation_wfh as f
				              LEFT JOIN signin as s ON f.fusion_id = s.fusion_id
							  LEFT JOIN signin as ls ON ls.id = s.assigned_to
							  LEFT JOIN department as d on d.id=s.dept_id
							  LEFT JOIN role as r on r.id=s.role_id
							  LEFT JOIN asset_return_wfh as fr on fr.alloc_id=f.id
							  LEFT JOIN signin as rs ON rs.id = fr.entry_by
				              WHERE 1 $extraoffice";
							  
		/*$wfh_list_sql = "SELECT f.*, concat(s.fname,' ',s.lname) as fullname, s.office_id ,d.description,d.shname,c.fullname,p.name as process
		             from asset_allocation_wfh as f 
		             LEFT JOIN signin as s ON s.fusion_id = f.fusion_id
					 INNER JOIN department as d on d.id=s.dept_id
					 INNER JOIN info_assign_client as iac on iac.user_id=s.id
					 INNER JOIN client as c on c.id= iac.client_id
					 INNER JOIN info_assign_process as iap on iap.user_id=s.id
					 INNER JOIN process as p on p.id=iap.process_id
					 WHERE f.id NOT IN (SELECT alloc_id from asset_return_wfh)
					 $extraoffice";*/
					 
		$wfh_list = $this->Common_model->get_query_result_array($wfh_list_sql);
		
		//echo "<pre>".print_r($wfh_list, true)."</pre>";die;
		
		$this->objPHPExcel->createSheet();
		$this->objPHPExcel->setActiveSheetIndex();
		$objWorksheet = $this->objPHPExcel->getActiveSheet();
		$objWorksheet->setTitle('WFH Assets Details');
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:V1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
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
		$objWorksheet->getColumnDimension('T')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('V')->setAutoSize(true);
		
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('K1:O1');
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('P1:V1');
		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,1, "Office Assets Details");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,1, "Return Details");
		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2, "SL");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,2, "Fusion ID");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,2, "Name ");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,2, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,2, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,2, "Location");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,2, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,2, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,2, "L1 Supervisor");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,2, "Is Work Home");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,2, "Desktop/Laptop");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,2, "Headset");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,2, "Dongle");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,2, "Sim");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,2, "Specifications");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,2, "Desktop/Laptop");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,2, "Headset");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,2, "Dongle");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,2, "Sim");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,2, "Remarks");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,2, "Return By");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,2, "Return Date");
		$i = 1;
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:V2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2:V2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		
		foreach($wfh_list as $wk=>$wv)
		{
			// WFH INFO
			$is_work_home = $wv['is_work_home'];
			$office_assets = $wv['office_assets']; 
			$office_headset = $wv['office_headset']; 
			$office_dongle = $wv['office_dongle']; 
			$office_sim = $wv['office_sim']; 
			$specifications = $wv['specifications']; 
			$other_details = $wv['other_details']; 
			$location = $wv['location']; 
			$entry_date = $wv['entry_date']; 
			
			$return_assets = $wv['return_office_assets'];
			$return_headshet = $wv['return_office_headset'];
			$return_dongle = $wv['return_office_dongle'];
			$return_sim = $wv['return_office_sim'];
			$return_remarks = $wv['return_remarks'];
			$return_entry = $wv['return_by_name'];
			$return_date = $wv['return_date'];
			
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+2, $i);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+2, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i+2, $wv["emp_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i+2, $wv["department"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i+2, $wv["designation"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i+2, $wv["location"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i+2, $wv["client_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i+2, $wv["process_name"]);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i+2, $wv["l1_supervisor"]);
			
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i+2, $is_work_home);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i+2, $office_assets);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i+2, $office_headset);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i+2, $office_dongle);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i+2, $office_sim);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i+2, $specifications);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i+2, $return_assets);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$i+2, $return_headshet);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$i+2, $return_dongle);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$i+2, $return_sim);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$i+2, $return_remarks);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$i+2, $return_entry);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$i+2, $return_date);
			$i++;
			
			
			
		}
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="WFH_ASSETS_'.$get_office_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	 }
}
?>