<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pmetrix_Blended extends CI_Controller {

    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
   	
    function __construct() {
        parent::__construct();
        
        $this->load->model('Common_model');
        $this->load->model('user_model');
		$this->load->model('PM_Blended_model');
        $this->load->library('excel');
		$this->load->helper('pmetrix_helper');
		$this->load->helper('new_pmetrix_helper');
		$this->load->helper('pmetrix_blended_helper');
    }
	
	//
	//
	//
	public function get_client_process_dropdown(){
		if(check_logged_in()){
			$_client_id = $this->input->post("client_id");
			
			if(is_array($_client_id)) $_client_id = implode(",", $_client_id);
						
			$_processes = $this->PM_Blended_model->get_blended_process_list($_client_id);
			
			$_html = "";
			foreach($_processes as $_pid){
				$_html .= "<option value='".$_pid["id"]."'>".$_pid["process_name"]."</option>";
			}
			
			print $_html;
		}
	}
	
	public function get_client_process_view($_client_id){
		if(check_logged_in()){
			if(is_array($_client_id)) $_client_id = implode(",", $_client_id);
						
			$_processes = $this->PM_Blended_model->get_blended_process_list($_client_id);
			
			return $_processes;
		}
	}
	
	//
	//
	//
	
	public function get_blended_kpi_list(){
		if(check_logged_in())
        {
			$office_id = $this->input->post("office_id");
			$mp_type = $this->input->post("mp_type");
			
			print $this->PM_Blended_model->get_blended_kpi_list($office_id, $metrix_type);
		}
	}
	
	//
	// INDEX
	//

	public function index(){
		
		if(check_logged_in())
        {
			
			if(get_role_dir() == "super" || get_role_dir() == "admin" || 
				get_role_dir() == "manager" || get_role_dir() == "trainer" || get_global_access()=='1' || 
				is_access_ba_design() == true || is_access_ba_mgntview()==true  || is_access_ba_upload() == true){
					$rr = "";
			}else redirect(base_url()."Pmetrix_Blended/agent");	
			
			
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir=get_role_dir();
			
			$ses_dept_id=get_dept_id();
						
			$is_global_access=get_global_access();
			
			$data["user_site_id"]=$user_site_id;
			$data["user_role_id"]=$role_id;
				
			$data['kpi_summtype_list'] = $this->PM_Blended_model->kpi_summtype_list();
			$data['get_blended_master_kpis'] = $this->PM_Blended_model->get_blended_master_kpis();
			$data['get_blended_client_list'] = $this->PM_Blended_model->get_blended_client_list();
			$data["blended_design_list"] = $this->PM_Blended_model->get_blended_design();	
						
            $data["aside_template"] = "pmetrix_blended/aside.php"; //get_aside_template();			
			$data["content_template"] = "pmetrix_blended/blended_metrix_show.php";
			
			$data["error"] = '';  
			$data["view"] = FALSE;
			
			if($this->input->post("submit")){
				$data["view"] = TRUE;
				
				$_design_id = $this->input->post("design_id");
				
				$data["design_id"] = $_design_id;
				
				$data["result"] = FALSE;
				
				if($_design_id!=""){
					$data["design"] = $this->PM_Blended_model->get_blended_design_detail($_design_id);
					$_res = $this->PM_Blended_model->get_kpi_details_on_design($_design_id);
					
					$data["result"] = $_res;
				}
			}
			
			$this->load->view('dashboard',$data);	
		}
	}


    //
    // DESIGN 
    //

    public function design(){
        if(check_logged_in()){		
			
			$data['kpi_summtype_list'] = $this->PM_Blended_model->kpi_summtype_list();
			$data['get_blended_master_kpis'] = $this->PM_Blended_model->get_blended_master_kpis();
			$data['get_blended_client_list'] = $this->PM_Blended_model->get_blended_client_list();
			
            $data["aside_template"] = "pmetrix_blended/aside.php"; //get_aside_template();
            $data["content_template"] = "pmetrix_blended/blended_kpi_design.php";
			
            $data["error"] = '';  
			$this->load->view('dashboard',$data);	
		}
    }
	
	//
	// ADD DESIGN
	//
	
	public function addDesign(){
		if(check_logged_in()){
			$description = trim($this->input->post('description'));
			
			$_client_id = $this->input->post("client_id");
			$_client_process = $this->input->post("client_process");
			
			$kpi_name_arr = $this->input->post("kpi_name");
			$target_arr = $this->input->post("target");
			$weightage_arr = $this->input->post('weightage');
			$kpi_summ_type_arr = $this->input->post('summ_type');
			$kpi_summ_formula_arr = $this->input->post('summ_formula');
			$weightage_comp_arr = $this->input->post('weightage_comp');
			$agent_view_arr = $this->input->post('agent_view');
			$tl_view_arr = $this->input->post('tl_view');
			$management_view_arr = $this->input->post('management_view');
			$currency_arr = $this->input->post('currency');
			
			$_current_user = get_user_id();
						
			
			$field_array = array(
				"description" => $description,
				"added_by" => get_user_id(),
				"is_active" => '1',
				"client_id" => implode(",",$_client_id),
				"process_id" => implode(",",$_client_process),
			);
			
			$_design_id = data_inserter('pm_design_blended',$field_array);
			
			//
			//
			//
			
			foreach($_client_id as $_cid){
				
				$_pids = array_intersect($this->PM_Blended_model->get_blended_process_list_array($_cid),$_client_process);
				
				$field_array = array(
					"design_id" => $_design_id,
					"client_id" => $_cid,
					"process_id" => implode(",",$_pids),
				);
				
				foreach($kpi_name_arr as $index => $kpi_id){
			
					if($kpi_id<>""){
						
						$field_array["kpi_id"] = $kpi_id;
						$field_array["summ_type"] = $kpi_summ_type_arr[$index];
						$field_array["summ_formula"] = $kpi_summ_formula_arr[$index];
						$field_array["weightage_comp"] = $weightage_comp_arr[$index];
						$field_array["target"] = $target_arr[$index];
						$field_array["weightage"] = $weightage_arr[$index];
						$field_array["agent_view"] = $agent_view_arr[$index];
						$field_array["tl_view"] = $tl_view_arr[$index];
						$field_array["management_view"] = $management_view_arr[$index];
						$field_array["currency"] = $currency_arr[$index];
						$field_array["added_by"] = $_current_user;
						
						data_inserter('pm_design_kpi_blended',$field_array);					
					}				
				}
			}
			
			//
			//
			//
			
			redirect($_SERVER['HTTP_REFERER']);	
		}
	}
	
	
	//
	// EDIT DESIGN
	//
	
	public function edit_design(){
        if(check_logged_in()){
			
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir=get_role_dir();
			
			$ses_dept_id=get_dept_id();
						
			$is_global_access=get_global_access();
			
			$data["user_site_id"]=$user_site_id;
			$data["user_role_id"]=$role_id;
			
			$data["design_id"] = $this->input->get("design");
			
			$data['kpi_type_list'] = $this->PM_Blended_model->kpi_type_list();	
			$data['kpi_summtype_list'] = $this->PM_Blended_model->kpi_summtype_list();
			$data['get_blended_master_kpis'] = $this->PM_Blended_model->get_blended_master_kpis();
			
			$data['master_kpis_dropdown'] = "";
			
			foreach($data['get_blended_master_kpis'] as $_kpi_name){
				$data['master_kpis_dropdown'] .= "<option value='".$_kpi_name['id']."'>".$_kpi_name['master_kpi_name']."</option>";
			}
			
			if($data["design_id"]!=""){
				$_res = $this->PM_Blended_model->get_kpi_details_on_design($data["design_id"]);				
				$data["result"] = $_res;			
			}
			
			$data["aside_template"] = "pmetrix_blended/aside.php"; //get_aside_template();
            $data["content_template"] = "pmetrix_blended/blended_edit_kpi_design.php";
			
            $data["error"] = '';  
			$this->load->view('dashboard',$data);		
		}
	}
	
	//
	// EDIT SAVE
	//
	
	public function edit_save(){
		if(check_logged_in()){
			// POST DATA
			$current_user = get_user_id();
						
			if($this->input->post('save') == 'Save'){
								
				$_design_id = $this->input->post('design_id');
				
				$this->PM_Blended_model->delete_design_kpi_for_edit($_design_id);				
				
				$weightage_arr = $this->input->post('weightage');	
				$target_arr = $this->input->post("target");
				$kpi_name_arr = $this->input->post('kpi_name');
				$kpi_summ_type_arr = $this->input->post('summ_type');
				$kpi_summ_formula_arr = $this->input->post('summ_formula');
				$weightage_comp_arr = $this->input->post('weightage_comp');
				$agent_view_arr = $this->input->post('agent_view');
				$tl_view_arr = $this->input->post('tl_view');
				$management_view_arr = $this->input->post('management_view');
				$currency_arr = $this->input->post('currency');
								
				foreach($kpi_name_arr as $index => $kpi_name){				
					if($kpi_name<>""){					
						$field_array = array(
							"design_id" => $_design_id,
							"kpi_id" => $kpi_name,
							"target" => $target_arr[$index],
							"summ_type" => $kpi_summ_type_arr[$index],
							"summ_formula" => $kpi_summ_formula_arr[$index],
							"weightage_comp" => $weightage_comp_arr[$index],
							"weightage" => $weightage_arr[$index],
							"agent_view" => $agent_view_arr[$index],
							"tl_view" => $tl_view_arr[$index],
							"management_view" => $management_view_arr[$index],
							"currency" => $currency_arr[$index],
							"added_by" => $current_user
						);
						
						data_inserter('pm_design_kpi_blended',$field_array);	
						
					}				
				}	
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}
	
	
	//
	// UPLOAD METRIX
	//
	
	public function uploadMetrix(){
        if(check_logged_in()){
			
			$headerDownloadUrl = "pmetrix_blended/downloadMetrixHeader?";
			$data["headerDownloadUrl"] = $headerDownloadUrl;
			
            $data["aside_template"] = "pmetrix_blended/aside.php"; //get_aside_template();
			
			$data["date_range"] = $this->input->post('date_range');
			
            $data["content_template"] = "pmetrix_blended/upload.php";
			
            $data["error"] = '';  
			$this->load->view('dashboard',$data);	
		}
	}
	
	//
	// UPLOAD
	//
	
	public function upload(){
        if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$sdate = trim($this->input->post('sdate'));
			$edate = trim($this->input->post('edate'));
			
			$ret = array();
			
			$output_dir = "uploads/";
						
			if($sdate!="" && $edate!=""){
				$error =$_FILES["myfile"]["error"];
				if(!is_array($_FILES["myfile"]["name"]))
				{
					$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);					
					move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
					$ret[]= $this->Import_excel_file($fileName,'','',$mpid, $mptype,$override);
				}
			}else{
				$error =$_FILES["myfile"]["error"];
				
				if(!is_array($_FILES["myfile"]["name"]))
				{
					$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);					
					move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
					$ret[]= $this->Import_excel_file($fileName,'','',$mpid, $mptype,$override);
				}					
			}
			
			echo json_encode($ret);			
		}
    }
	
	public function upload_tester()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$sdate = "2020-10-01"; 
			$edate = "2020-10-31";
			
			$ret = array();
						
			if($sdate!="" && $edate!=""){
			
				$dir = "uploads/";
				$fileName = "1604943325Blended_APR_AMD_DR_Account_FEMS_Upload_10272020_1.xlsx";
							
				$ret[] = $this->Import_excel_file($fileName,'','',0, 1,1);
				
			}
			
			echo json_encode($ret);			
		}
    }
	
	//
	// IMPORT EXCEL
	//
	
	public function Import_excel_file_v2($fn,$sdate,$edate, $mpid, $mptype,$override){
		
		if(check_logged_in()){
			
			$retval="";
					
			$current_user = get_user_id();
										
			$kpiArry = array();
			
			$kpiarray = $this->Common_model->get_query_result_array("Select * from blended_master_kpis");
						
			foreach($kpiarray as $row){
				$kpiArry[] = array(
					'kpi_id' => $row['id'], 
					'kpi_name' => $row['master_kpi_name'], 
					'kpi_type' => $row['master_kpi_type'], 
					'col_index' => ''
				);
			}
			
			
			$file_name = "./uploads/".$fn;
			
			$inputFileType = PHPExcel_IOFactory::identify($file_name);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			
			$objPHPExcel = $objReader->load($file_name);
			
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){

				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow(); 				
				$highestColumn      = $worksheet->getHighestColumn(); 				
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				
				$sheetData = $worksheet->toArray(null,true,true,true);
				
				$fusion_index = False;			
				
				//
				//
				for($col = 0; $col <= $highestColumnIndex; $col++){
				
					$cell = $worksheet->getCellByColumnAndRow($col, 1);
					$val = $cell->getValue();
					$val=trim($val);
					
					foreach($kpiArry as $key => $value){
						
						if($value["kpi_name"] == $val){
							$kpiArry[$key]["col_index"] = $col;								
						} 
						if(strtoupper($val)=="FUSION ID" || strtoupper($val)=="FUSIONID" || strtoupper($val)=="FUSION_ID" 
							|| strtoupper($val)=="FEMSID" || strtoupper($val) == "FEMS_ID"){
							$fusion_index = $col;						
						}
					}
				}
				
				//
				for($row = 1; $row <= $highestRow; $row++){
					$col = 0;
					$user_id = "";
					$start_date = "";
					$end_date = "";
					$dataArr = array();	
					
					foreach($kpiArry as $key => $value){
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						$val = $cell->getValue();
						$val = trim($val);
												
						if($val !=""){
							if($fusion_index == $col){
								$qSql="select id as value from signin where fusion_id ='".$val."'";
								$user_id=$this->Common_model->get_single_value($qSql);	
							}
							
							if($kpiArry[$key]["kpi_type"] == 10){
								
								$cell = $worksheet->getCellByColumnAndRow($col, $row);
								$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'yyyy-mm-dd');
								
								$start_date = $val;
								$end_date = $val;
							}
							$col += 1;
						}
					}
					
					$col_2 = 0;
					
					foreach($kpiArry as $key => $value){
						
						$cell = $worksheet->getCellByColumnAndRow($col_2, $row);
						$val = $cell->getValue();
						$val = trim($val);
												
						if($val !=""){
							$iSql="INSERT INTO pm_blended_data (user_id,added_by,added_date,start_date,end_date,mdid,kpi_id, kpi_value ) 
									Values('".$user_id."','".$current_user."', now() ,'".$start_date."', '".$end_date."', 0, '".$kpiArry[$key]["kpi_id"]."','".addslashes($val)."')";
							
							$this->db->query($iSql);
						}
						
						$col_2 += 1;
					}	
				}					
			}				
		}
	}
	
	/**/
	
	public function Import_excel_file($fn,$sdate="",$edate="", $mpid="0", $mptype="", $override=""){
		/*$sdate = ""; 
		$edate =""; 
		$mpid = $mpid; 
		$mptype = $mptype; 
		$override = $override;*/
		
		$current_user = get_user_id();
		
		$ff = fopen('./uploads/test_query/q.sql','a');
		
		
			if($sdate != ''){
				$sdate=mmddyy2mysql($sdate);
				$edate=mmddyy2mysql($edate);
			}
			
			$qSql = $this->db->query("select id, master_kpi_name as kpi_name from blended_master_kpis");
						
			$kpiarray = $qSql->result_array();
						
			foreach($kpiarray as $row){
				$kpiArry[$row['id']] = $row['kpi_name'];
			}
			
			//print_r($kpiArry);
			
			$file_name = "./uploads/".$fn;
			
			
			$inputFileType = PHPExcel_IOFactory::identify($file_name);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			
			$objPHPExcel = $objReader->load($file_name);
			$html ="";
			
			$ii=1;
			
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){

				$worksheetTitle = $worksheet->getTitle();
				$highestRow = $worksheet->getHighestRow(); // 
				
				$highestColumn = $worksheet->getHighestColumn(); // 
				
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				
				$text = $ii++. " The worksheet ".$worksheetTitle." has ";
				$text .= $highestColumnIndex . ' columns (A-' . $highestColumn . ') ' ;
				$text .= ' and ' . $highestRow . ' row.';
												
				$sheetData = $worksheet->toArray(null,true,true,true);
				
				$row = 1;
				$wc_index=0;
				$fusion_index=0;
				$kpiIDArry = array();
				
				$kpi_check = True;
				
				$headers = array();
				
				//
				// Check Column Headers Against KPIs 
				//
				
				for ($col = 0; $col <= $highestColumnIndex; $col++){			
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val = trim($cell->getValue());
					$_headers[] = $val;
										
					if(strtoupper($val) =="FUSION ID" || strtoupper($val) =="FUSIONID" || strtoupper($val) =="FUSION_ID" || strtoupper($val) =="FEMS_ID"){
						$fusion_index = $col;
					}	
				}	

				//
				// GET KPI IDS AGAINST COLS
				//
				
				
				foreach($kpiArry as $kpi){
					
					if(in_array($kpi,$_headers)){
						$kpiID = array_search($kpi,$kpiArry);
					}else{
						$kpi_temp = str_replace(" ","",$kpi);
											
						if(in_array($kpi_temp,$_headers)){
							$kpiID = array_search($kpi,$kpiArry);						
						}else $kpiID = FALSE;
					}	
					
					if($kpiID != FALSE ){
						$kpiIDArry[array_search($kpi, $_headers)] = $kpiID;
					}
				}
				
				//print_r($kpiIDArry);
				
				//
				// GENERATE FUSION IDS 
				//
				
				
				
				$row += 1;
				
				foreach($kpiIDArry as $key=>$kpi_id){
					
					$_sql = "INSERT INTO pm_blended_data (user_id,added_by,added_date,start_date,end_date,mdid,kpi_id, kpi_value ) values "; 
					
					for($i = $row; $i <= $highestRow; $i++){
						$cell = $worksheet->getCellByColumnAndRow(0, $i);
						$dates = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'yyyy-mm-dd');
												
						if($sdate == ''){						
							$cell = $worksheet->getCellByColumnAndRow(0, $i);
							$dates = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'yyyy-mm-dd');						
							$start_date = $dates;
							$end_date = $dates;
						}
						else{
							$start_date = $sdate;
							$end_date = $edate;
						}
						
						//
						// FUSIONID - > USER_ID
						//
						
						$user_id = FALSE;
						$cell = $worksheet->getCellByColumnAndRow($fusion_index, $i);
						$fusion_id = trim($cell->getValue());
						
						$user_id = $this->Common_model->get_single_value("select id as value from signin where fusion_id = '".$fusion_id."'");
						
						//
						// KPI VALUE
						//
						$cell = $worksheet->getCellByColumnAndRow($key, $i);
						$kpi_val = $cell->getFormattedValue();
						
						
						if($user_id!=""){
							$_sql .= "($user_id,'$current_user', now() ,'$start_date', '$end_date', $mpid, $kpi_id,'".addslashes($kpi_val)."'),";
						}				
					}
					
					$_sql = rtrim($_sql, ",");
					$this->db->query($_sql);
				}
			}
			$retval= $fn."=>done";			
		
		return $retval;
	}
	
	
	
	
		
	/*
	*
	*/	
	public function agent(){
		if(check_logged_in())
        {
			$_user_site_id = get_user_site_id();
			$_user_office_id = get_user_office_id();
			
			$_role_id = get_role_id();
			$_current_user = get_user_id();
			$_role_dir = get_role_dir();
			
			$_ses_dept_id = get_dept_id();
						
			$_is_global_access = get_global_access();
			
			$data["aside_template"] = "pmetrix_blended/aside.php"; 
            $data["content_template"] = "pmetrix_blended/pm_blended_agent_view.php";
			
			$data["error"] = '';  
			$data["view"] = FALSE;
			
			$sess = $this->session->userdata('logged_in');
			
			$data["name"] = $sess["name"];
			$data["clients_list"] = $this->PM_Blended_model->get_agent_clients_list();
			
			if($this->input->post("submit_but")){
				$data["view"] = TRUE;
				
				$_process_id = $this->input->post("process_id");
				$_start_date = $this->input->post("from_date");
				$_end_date = $this->input->post("to_date");
				$_client_id = $this->input->post("client_id");
				$_design_id = $this->input->post("design_id");
				$data["period_id"] = $this->input->post("period_id");
				
				$data["start_date"] = $_start_date;
				$data["end_date"] = $_end_date;
				$data["client_id"] = $_client_id;
				$data["process_ids"] = $_process_id;
				$data["design_id"] = $_design_id;
				
				$data["main_process_list"] = $this->get_client_process_view($_client_id);
				
				$data["kpi_col_list"] = $this->PM_Blended_model->get_kpi_details($_design_id);
				
				$data["get_periods"] = $this->PM_Blended_model->get_periods_dropdown($_start_date, $_end_date);
				
				$target_cols = array();
				$data["target_list"] = array();
				
				foreach($data["kpi_col_list"] as $i => $k_col){
					
					$data["target_list"][$k_col["kpi_id"]] = $k_col["target_id"];
					
					if($k_col["target_id"]!=""){
						$target_cols[] = $k_col["target_id"];
					}
				}	
				
				$target_ids = implode(",", $target_cols);
				
				$data["target_list_values"] = $this->PM_Blended_model->target_values($target_ids, $_current_user);							
								
				$data["kpi_data"] = $this->PM_Blended_model->get_custom_data($_design_id, $_client_id, $_start_date, $_end_date, $_current_user);
				$data["process_names"] = $this->PM_Blended_model->get_process_name($_process_id);
			}
			
			$this->load->view('dashboard',$data);	
		}
	}	
	
	
	//
	//
	//
	public function design_client_process(){
		if(check_logged_in()){
			if($this->input->post()){
				
				$_client_id = $this->input->post("client_id");
				$_process_id = $this->input->post("process_id");
				
				$_designs = $this->PM_Blended_model->get_available_blended_designs();
			
				$_found_designs = "";
							
				foreach($_designs as $_row){
					$_c_arr = explode(",", $_row["client_id"]);
					$_p_arr = explode(",", $_row["process_id"]);
					
					if(in_array($_client_id, $_c_arr)){
						if(count(array_intersect($_p_arr,$_process_id)) > 0){
							$_found_designs .= "<option value='".$_row["id"]."'>".$_row["description"]."</option>";
						}
					}
				}
				
				print $_found_designs;
			}
		}
	}
	
	//
	//
	//
	public function get_periods_dropdown(){
		if(check_logged_in()){
			if($this->input->post()){
				
				$_start_date = $this->input->post("start_date");
				$_end_date = $this->input->post("end_date");
				
				$html = "<option value=''>--select--</option>";
				
				$res = $this->PM_Blended_model->get_periods_dropdown($_start_date, $_end_date);
				
				foreach($res as $_row){
					$html .= "<option value='".$_row["kpi_value"]."'>".$_row["kpi_value"]."</option>";
				}
				
				print $html;
			}
		}
	}
	
		
   
}