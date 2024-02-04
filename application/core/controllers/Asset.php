<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asset extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    private $aside = "asset/aside.php";
	 function __construct() {
		parent::__construct();
		
		$this->load->model('auth_model');
		$this->load->model('Common_model');
		
	 }

	private function check_access()
	{
		if(get_global_access()!='1' && get_dept_folder() !="hr" && get_role_dir()!="super") redirect(base_url()."home","refresh");
	} 
	
    public function index()
    {			
		if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = $this->aside;
			$qSql="SELECT p.*,ofc.location as loc,c.name as category,b.name as brand_name,a.name FROM asset_stock as p left join master_asset_category as c on c.id=p.product_category_id left join master_asset_brand as b on b.id=p.brand left join office_location as ofc on ofc.abbr=p.location left join master_asset_products as a on a.id=p.product_id";
			$data['prod_list'] = $this->Common_model->get_query_result_array($qSql);

			$qSqlcat="SELECT * FROM master_asset_category where is_active=1";
			$data['cat_list'] = $this->Common_model->get_query_result_array($qSqlcat);

			$qSqlprod="SELECT * FROM master_asset_products where is_active=1";
			$data['pro_list'] = $this->Common_model->get_query_result_array($qSqlprod);

			$qSqlbrand="SELECT * FROM master_asset_brand where is_active=1";
			$data['brand_list'] = $this->Common_model->get_query_result_array($qSqlbrand);

			$qSqlprocessor="SELECT * FROM master_asset_minimun_processor where is_active=1";
			$data['processor_list'] = $this->Common_model->get_query_result_array($qSqlprocessor);

			$qSqlhdd="SELECT * FROM master_asset_minimun_hard_disk_drive where is_active=1";
			$data['hdd_list'] = $this->Common_model->get_query_result_array($qSqlhdd);

			$qSqlram="SELECT * FROM master_asset_minimun_ram where is_active=1";
			$data['ram_list'] = $this->Common_model->get_query_result_array($qSqlram);

			$qSqldisplay="SELECT * FROM master_asset_system_screen_size where is_active=1";
			$data['display_list'] = $this->Common_model->get_query_result_array($qSqldisplay);

			$data["content_template"] = "asset/add_stock.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 	


			
			$this->load->view('dashboard',$data);
								
        }			
	}


	public function add_stock()
	{
		if(check_logged_in())
		{
			$current_loc = get_user_office_id();
			$name = trim($this->input->post('pro_id'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));
			$ram_id = trim($this->input->post('ram_id'));
			$processor_id = trim($this->input->post('processor_id'));
			$display_id = trim($this->input->post('display_id'));
			$hdd_id = trim($this->input->post('hdd_id'));
			$desc = trim($this->input->post('desc'));
			$quant = trim($this->input->post('quant'));
			$model_no = trim($this->input->post('model_no'));
			$gst_no = trim($this->input->post('gst_no'));
			$receipt_no = trim($this->input->post('receipt_no'));
			$serial_no = trim($this->input->post('serial_no'));
			$hdph_type = trim($this->input->post('hdph_type'));

			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"product_id" => $name,
					"product_category_id" => $cat_id,
					"brand" => $brand_id,
					"ram" => $ram_id,
					"display" => $display_id,
					"hard_disk" => $hdd_id,
					"processor" => $processor_id,
					"description" => $desc,
					"quantity" => $quant,
					"model_number" => $model_no,
					"serial_number" => $serial_no,
					"gst_number" => $gst_no,
					"receipt_number" => $receipt_no,
					"headphone_type" => $hdph_type,
					"location" =>$current_loc,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('asset_stock',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function update_stock()
	{

		// print_r($_POST);
		// exit;
		if(check_logged_in())
		{
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('pro_id'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));
			$ram_id = trim($this->input->post('ram_id'));
			$processor_id = trim($this->input->post('processor_id'));
			$display_id = trim($this->input->post('display_id'));
			$hdd_id = trim($this->input->post('hdd_id'));
			$desc = trim($this->input->post('desc'));
			$quant = trim($this->input->post('quant'));
			$model_no = trim($this->input->post('model_no'));
			$serial_no = trim($this->input->post('serial_no'));
			$gst_no = trim($this->input->post('gst_no'));
			$receipt_no = trim($this->input->post('receipt_no'));
			$hdph_type = trim($this->input->post('hdph_type'));

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"product_id" => $name,
					"product_category_id" => $cat_id,
					"brand" => $brand_id,
					"ram" => $ram_id,
					"display" => $display_id,
					"hard_disk" => $hdd_id,
					"processor" => $processor_id,
					"description" => $desc,
					"quantity" => $quant,
					"model_number" => $model_no,
					"serial_number" => $serial_no,
					"gst_number" => $gst_no,
					"receipt_number" => $receipt_no,
					"headphone_type" => $hdph_type,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('asset_stock', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	

	public function request($id){
		if(check_logged_in())
        {
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_fusion_id();
			$location = get_user_office_id();
			$data["aside_template"] = $this->aside;

			$qSql="SELECT r.*,rit.*,rit.status as stat,ofc.location as loc,c.name as cat,h.size as hdd,mp.processor as pro,mr.size as ram_size,p.name as prod,ms.size as disp FROM asset_request as r left join asset_requested_items as rit on rit.rqst_id = r.id left join master_asset_category as c on c.id = rit.product_category_id left join master_asset_minimun_hard_disk_drive as h on h.id = rit.hard_disk left join master_asset_minimun_processor as mp on mp.id = rit.processor left join master_asset_minimun_ram as mr on mr.id = rit.ram left join master_asset_products as p on p.id = rit.product_id left join master_asset_system_screen_size as ms on ms.id = rit.display left join office_location as ofc on ofc.abbr = r.location";
			if($id!=1)$qSql .= " where requested_by = '".$current_user."'";
			$data['req_list'] = $this->Common_model->get_query_result_array($qSql);

			$qSqlcat="SELECT * FROM master_asset_category where is_active=1";
			$data['cat_list'] = $this->Common_model->get_query_result_array($qSqlcat);

			$qSqlprod="SELECT * FROM master_asset_products where is_active=1";
			$data['pro_list'] = $this->Common_model->get_query_result_array($qSqlprod);

			$qSqlbrand="SELECT * FROM master_asset_brand where is_active=1";
			$data['brand_list'] = $this->Common_model->get_query_result_array($qSqlbrand);

			$qSqlprocessor="SELECT * FROM master_asset_minimun_processor where is_active=1";
			$data['processor_list'] = $this->Common_model->get_query_result_array($qSqlprocessor);

			$qSqlhdd="SELECT * FROM master_asset_minimun_hard_disk_drive where is_active=1";
			$data['hdd_list'] = $this->Common_model->get_query_result_array($qSqlhdd);

			$qSqlram="SELECT * FROM master_asset_minimun_ram where is_active=1";
			$data['ram_list'] = $this->Common_model->get_query_result_array($qSqlram);

			$qSqldisplay="SELECT * FROM master_asset_system_screen_size where is_active=1";
			$data['display_list'] = $this->Common_model->get_query_result_array($qSqldisplay);

			if($id == 1){
				$qSqlit="SELECT *,concat(fname, ' ', lname) as name FROM signin where role_id = 42";
				$data['it_list'] = $this->Common_model->get_query_result_array($qSqlit);

				$data["content_template"] = "asset/req_list.php";
			}else{
				$qSql="Select fusion_id, xpoid, fname,lname, office_id, dept_id, (select shname from department d where d.id=signin.dept_id) as dept_name from signin where status=1 and office_id = '$location' and role_id > 0 ORDER BY fname";
				$data["user_list_ref"] = $this->Common_model->get_query_result_array($qSql);
				$data["content_template"] = "asset/add_request.php";
			}
			
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 	


			
			$this->load->view('dashboard',$data);
								
        }
	}

	public function checkSimilarProducts(){
		$current_loc = get_user_office_id();
		$pid = trim($this->input->post('pro_id'));
		$qSql="SELECT p.*,ofc.location as loc,c.name as category,b.name as brand_name,a.name FROM asset_stock as p left join master_asset_category as c on c.id=p.product_category_id left join master_asset_brand as b on b.id=p.brand left join office_location as ofc on ofc.abbr=p.location left join master_asset_products as a on a.id=p.product_id where abbr = '".$current_loc."' and product_id = $pid";
		$prod_list = $this->Common_model->get_query_result_array($qSql);
		echo json_encode($prod_list);
	}


	public function approve()
	{
		if(check_logged_in())
		{
			$current_user = get_user_fusion_id();
			$rid = trim($this->input->post('ridAprv'));
			$rqid = trim($this->input->post('rqidAprv'));
			$comnt = trim($this->input->post('app_cmnt'));
			$date = date('Y-m-d');
			// echo $rid; exit();	
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"aprvl_comnt" => $comnt,
					"approved_by" => $current_user,
					"approved_date" => $date,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('asset_request', $field_array);


				$field_array = array(
					"status" => 2
				); 
			
				$this->db->where('id', $rqid);
				$this->db->update('asset_requested_items', $field_array);


				$ans = array('status' => "approved");
			}else{
				$ans = array('status' => "something went wrong");
			}
		echo json_encode($ans);


		}
	}

	public function assign_it()
	{
		if(check_logged_in())
		{
			$current_user = get_user_fusion_id();
			$rid = trim($this->input->post('ridIt'));
			$rqid = trim($this->input->post('rqidIt'));
			$it_engnr = trim($this->input->post('it_engnr'));
			$date = date('Y-m-d');

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('asset_request', $field_array);

				$field_array = array(
					"assigned_it_engineer" => $it_engnr,
					"assigned_by" => $current_user,
					"assigned_date" => $date,
					"status" => 4
				); 
			
				$this->db->where('id', $rqid);
				$this->db->update('asset_requested_items', $field_array);

				$ans = array('status' => "approved");
			}else{
				$ans = array('status' => "something went wrong");
			}
		echo json_encode($ans);


		}
	}	

	public function reject()
	{
		if(check_logged_in())
		{
			$current_user = get_user_fusion_id();
			$rid = trim($this->input->post('pid'));
			$status = trim($this->input->post('sid'));
			$date = date('Y-m-d');

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"status" => $status,
					"rejected_by" => $current_user,
					"rejected_date" => $date,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('asset_purchase_request', $field_array);
				$ans = array('status' => "rejected");
			}else{
				$ans = array('status' => "something went wrong");
			}
			echo json_encode($ans);
		}
	}


	public function reject1()
	{
		if(check_logged_in())
		{
			$current_user = get_user_fusion_id();
			$rid = trim($this->input->post('pqid'));
			$status = trim($this->input->post('sid'));
			$date = date('Y-m-d');

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"status" => $status
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('asset_requested_items', $field_array);
				$ans = array('status' => "rejected");
			}else{
				$ans = array('status' => "something went wrong");
			}
			echo json_encode($ans);
		}
	}


	public function add_reqPurchase()
	{
		if(check_logged_in())
		{	
			$current_loc = get_user_office_id();
			$current_user = get_user_fusion_id();
			$date = date('Y-m-d');

			$rid = trim($this->input->post('ridp'));
			$rqid = trim($this->input->post('rqidp'));
			$name = trim($this->input->post('pro_id'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));
			$ram_id = trim($this->input->post('ram_id'));
			$processor_id = trim($this->input->post('processor_id'));
			$display_id = trim($this->input->post('display_id'));
			$hdd_id = trim($this->input->post('hdd_id'));
			$desc = trim($this->input->post('desc'));
			$quant = trim($this->input->post('quant'));

			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"request_type" => 1,
					"product_id" => $name,
					"product_category_id" => $cat_id,
					"ram" => $ram_id,
					"display" => $display_id,
					"hard_disk" => $hdd_id,
					"processor" => $processor_id,
					"product_description" => $desc,
					"requested_by" => $current_user,
					"request_date" => $date,
					"quantity" => $quant,
					"location" => $current_loc,
					"status" => 1,
					"log" => $log
				);
				$rowid= data_inserter('asset_purchase_request',$field_array);
				
				if($rid!= ""){
					$field_array = array(
						"availablity" => 2,
					); 
				
					$this->db->where('id', $rqid);
					$this->db->update('asset_requested_items', $field_array);
				}

				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}


	public function approve_purcashe()
	{
		if(check_logged_in())
		{
			$current_user = get_user_fusion_id();
			$rid = trim($this->input->post('pid'));
			$status = trim($this->input->post('sid'));
			$date = date('Y-m-d');

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"status" => $status,
					"approved_by" => $current_user,
					"approved_date" => $date,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('asset_purchase_request', $field_array);
				$ans = array('status' => "approved");
			}else{
				$ans = array('status' => "something went wrong");
			}
			echo json_encode($ans);
		}
	}



////////////////////////////ram ///////////////////////////////
      
    public function ram()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/ram.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		
            
				$qSql="SELECT * FROM master_asset_minimun_ram";
				$data['ram_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function addRam()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"size" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_minimun_ram',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function updateRam()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"size" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_ram', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function ramActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_ram', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}



////////////////////////////processor ///////////////////////////////
      
    public function processor()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/processor.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		
            
				$qSql="SELECT * FROM master_asset_minimun_processor";
				$data['processor_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function addProcessor()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"processor" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_minimun_processor',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function updateProcessor()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"processor" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_processor', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function processorActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_processor', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}


////////////////////////////hardDisk ///////////////////////////////
      
    public function hard_disk()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/hard_disk.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		
            
				$qSql="SELECT * FROM master_asset_minimun_hard_disk_drive";
				$data['hdd_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function addHardDisk()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"size" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_minimun_hard_disk_drive',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function updateHardDisk()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"size" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_hard_disk_drive', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function hardDiskActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_minimun_hard_disk_drive', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}



////////////////////////////Screen Size ///////////////////////////////
      
    public function screen_size()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/screen_size.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;			
            
				$qSql="SELECT * FROM master_asset_system_screen_size";
				$data['screen_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
public function add_screen_size()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"size" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_system_screen_size',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function update_screen_size()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"size" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_system_screen_size', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function screen_sizeActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_system_screen_size', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}


////////////////////////////category///////////////////////////////
      
    public function category()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/category.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		
            
				$qSql="SELECT * FROM master_asset_category";
				$data['cat_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function add_category()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"name" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_category',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function update_category()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			
			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"name" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_category', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function categoryActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_category', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}	



////////////////////////////product///////////////////////////////
      
    public function product()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/products.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		
            
				$qSql="SELECT p.*,c.name as category,b.name as brand FROM master_asset_products as p left join master_asset_category as c on c.id=p.cat_id left join master_asset_brand as b on b.id=p.brand_id";
				$data['prod_list'] = $this->Common_model->get_query_result_array($qSql);

				$qSqlcat="SELECT * FROM master_asset_category where is_active=1";
				$data['cat_list'] = $this->Common_model->get_query_result_array($qSqlcat);

				$qSqlbrand="SELECT * FROM master_asset_brand where is_active=1";
				$data['brand_list'] = $this->Common_model->get_query_result_array($qSqlbrand);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function add_product()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));

			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"name" => $name,
					"cat_id" => $cat_id,
					"brand_id" => $brand_id,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_products',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function update_product()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));
			$cat_id = trim($this->input->post('cat_id'));
			$brand_id = trim($this->input->post('brand_id'));

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"name" => $name,
					"cat_id" => $cat_id,
					"brand_id" => $brand_id,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_products', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function productActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_products', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

////////////////////////////Brand///////////////////////////////
      
    public function brand()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			
            //$data["aside_template"] = get_aside_template();
			$data["aside_template"] = $this->aside;
			
            $data["content_template"] = "asset/brand.php";
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 
            $data['srole_id']=$srole_id;		

				$qSql="SELECT * FROM master_asset_brand";
				$data['brand_list'] = $this->Common_model->get_query_result_array($qSql);
			
			   $this->load->view('dashboard',$data);
								
            }                  
   }
   
    
	public function add_brand()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$name = trim($this->input->post('name'));
			
			$log=get_logs();
			
			if($name!=""){
				
				$field_array = array(
					"name" => $name,
					"is_active" => '1',
					"log" => $log
				);
				$rowid= data_inserter('master_asset_brand',$field_array);
							
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}
	   
	public function update_brand()
	{
		if(check_logged_in())
		{
			
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$name = trim($this->input->post('name'));

			if($rid!=""){
				
				$log=get_logs();
				
				$field_array = array(
					"name" => $name,
					"log" => $log
				); 
			
				$this->db->where('id', $rid);
				$this->db->update('master_asset_brand', $field_array);
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	   
	public function brandActDeact()
	{
		if(check_logged_in())
		{
			$this->check_access();
			
			$rid = trim($this->input->post('rid'));
			$sid = trim($this->input->post('sid'));
			
			if($rid!=""){
				$this->db->where('id', $rid);
				$this->db->update('master_asset_brand', array('is_active' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}


	public function checkAvailablity(){

		$pro_id = trim($this->input->post('pid'));
		$cat_id = trim($this->input->post('cat_id'));
		$ram_id = trim($this->input->post('ram_id'));
		$processor_id = trim($this->input->post('processor_id'));
		$display_id = trim($this->input->post('display_id'));
		$hdd_id = trim($this->input->post('hdd_id'));
		$quant = trim($this->input->post('quant'));



		$qSql="SELECT * FROM asset_stock where product_category_id=".$cat_id."";
		if(!$quant== "") $qSql.=" and quantity > ".--$quant."";
		if(!$pro_id== "") $qSql.=" and product_id=".$pro_id."";
		if(!$processor_id== "" && !$processor_id== 0) $qSql.=" and processor=".$processor_id."";
		if(!$hdd_id== "" && !$hdd_id== 0) $qSql.=" and hard_disk=".$hdd_id."";
		if(!$display_id== "" && !$display_id== 0) $qSql.=" and display=".$display_id."";
		if(!$ram_id== "" && !$ram_id== 0) $qSql.=" and ram=".$ram_id."";
		// echo $qSql; exit;
		$query = $this->db->query($qSql);
		$data = $query->num_rows();
		if($data > 0){
			$ans = array('status' => "done");
		}else{
			$ans = array('status' => "error");
		}
		echo json_encode($ans);
	}


	public function add_reqGdgt()
	{
		// print_r($_POST);
		// exit;
		if(check_logged_in())
		{
			$current_loc = get_user_office_id();
			$current_user = get_user_fusion_id();
			$date = date('Y-m-d');
			$name = $this->input->post('pro_id');
			$cat_id = $this->input->post('cat_id');
			$ram_id = $this->input->post('ram_id');
			$processor_id = $this->input->post('processor_id');
			$display_id = $this->input->post('display_id');
			$hdd_id = $this->input->post('hdd_id');
			$desc = $this->input->post('desc');
			$quant = $this->input->post('quant');
			$wrk_typ = $this->input->post('wrk_typ');
			$mouse = $this->input->post('mouse');
			$keybrd = $this->input->post('keybrd');
			$headset = $this->input->post('headset');

			$for_whom = trim($this->input->post('whom'));
			if($for_whom == 2){
				$requested_for = trim($this->input->post('comp_employee_name'));
			}else{
				$requested_for = get_user_fusion_id();
			}

			$log=get_logs();

			$field_array = array(
				"wrk_type" => $wrk_typ,
				"requested_by" => $current_user,
				"requested_for" => $requested_for,
				"request_date" => $date,
				"location" => $current_loc,
				"log" => $log
			);
			$rowid= data_inserter('asset_request',$field_array);
			
			if($name!=""){
				foreach ($name as $key => $value) {




					$qSql="SELECT * FROM asset_stock where product_category_id=".$cat_id[$key]."";
					if(isset($quant[$key])){
						if(!$quant[$key]== "") $qSql.=" and quantity > ".--$quant[$key]."";}
					if(isset($name[$key])){
						if(!$name[$key]== "") $qSql.=" and product_id=".$name[$key]."";
					}
					if(isset($processor_id[$key])){
						if(!$processor_id[$key]== "" && !$processor_id[$key]== 0) $qSql.=" and processor=".$processor_id[$key]."";
					}
					if(isset($hdd_id[$key])){
						if(!$hdd_id[$key]== "" && !$hdd_id[$key]== 0) $qSql.=" and hard_disk=".$hdd_id[$key]."";
					}
					if(isset($display_id[$key])){
						if(!$display_id[$key]== "" && !$display_id[$key]== 0) $qSql.=" and display=".$display_id[$key]."";
					}
					if(isset($ram_id[$key])){
						if(!$ram_id[$key]== "" && !$ram_id[$key]== 0) $qSql.=" and ram=".$ram_id[$key]."";
					}
					// echo $qSql; 
					$query = $this->db->query($qSql);
					$data = $query->num_rows();
					if($data > 0){
						$ans = 1;
						if(isset($mouse[$key])){if($mouse[$key]== "Yes") {
								$qSql1 ="SELECT * FROM asset_stock where product_category_id=2 and product_id = 5 and quantity > 0";
								$query = $this->db->query($qSql1);
								$data = $query->num_rows();
								if(!$data > 0){
									$ans = 3;
								}
							}
						}
						if(isset($headset[$key])){if($headset[$key] == "USB" || $headset[$key] == "Analog") {
								$qSql1 ="SELECT * FROM asset_stock where product_category_id=2 and product_id = 2 and quantity > 0";
								$qSql1 .=" and headphone_type='".$headset[$key]."'";
								$query = $this->db->query($qSql1);
								$data = $query->num_rows();
								if(!$data > 0){
									$ans = 5;
								}
							}
						}
						if(isset($headset[$key])){if($keybrd[$key]== "Yes") {
							$qSql2 ="SELECT * FROM asset_stock where product_category_id=2 and product_id = 4 and quantity > 0";
								$query = $this->db->query($qSql2);
								$data1 = $query->num_rows();
								if(!$data1 > 0){
									$ans = 4;
								}
							}
						}
					}else{
						$ans = 0;
					}





					$this->db->set('product_id',$value);
					$this->db->set('product_category_id',$cat_id[$key]);
					$this->db->set('ram',$ram_id[$key]);
					$this->db->set('display',$display_id[$key]);
					$this->db->set('hard_disk',$hdd_id[$key]);
					$this->db->set('processor',$processor_id[$key]);
					$this->db->set('product_description',$desc[$key]);
					$this->db->set('quantity',++$quant[$key]);
					$this->db->set('mouse_required',$mouse[$key]);
					$this->db->set('keyboard_required',$keybrd[$key]);
					$this->db->set('headset_required',$headset[$key]);
					$this->db->set('availablity',$ans);
					$this->db->set('status',1);
					$this->db->set('rqst_id',$rowid);
					$this->db->insert('asset_requested_items');
				}
				// exit;
				$ans="done";
			}else{
				$ans="error";
			}
			
			echo $ans;
		}
	}


	public function purchse_requests($id){
		if(check_logged_in())
        {
			$current_user = get_user_fusion_id();
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$data["aside_template"] = $this->aside;

			$qSql="SELECT r.*,ofc.location as loc,c.name as cat,h.size as hdd,mp.processor as pro,mr.size as ram_size,p.name as prod,ms.size as disp FROM asset_purchase_request as r left join master_asset_category as c on c.id = r.product_category_id  left join master_asset_minimun_hard_disk_drive as h on h.id = r.hard_disk left join master_asset_minimun_processor as mp on mp.id = r.processor left join master_asset_minimun_ram as mr on mr.id = r.ram left join master_asset_products as p on p.id = r.product_id left join master_asset_system_screen_size as ms on ms.id = r.display left join office_location as ofc on ofc.abbr = r.location";
			if($id != 1)$qSql .= " where requested_by = '".$current_user."'";
			$data['req_list'] = $this->Common_model->get_query_result_array($qSql);


			$qSqlcat="SELECT * FROM master_asset_category where is_active=1";
			$data['cat_list'] = $this->Common_model->get_query_result_array($qSqlcat);

			$qSqlprod="SELECT * FROM master_asset_products where is_active=1";
			$data['pro_list'] = $this->Common_model->get_query_result_array($qSqlprod);

			$qSqlbrand="SELECT * FROM master_asset_brand where is_active=1";
			$data['brand_list'] = $this->Common_model->get_query_result_array($qSqlbrand);

			$qSqlprocessor="SELECT * FROM master_asset_minimun_processor where is_active=1";
			$data['processor_list'] = $this->Common_model->get_query_result_array($qSqlprocessor);

			$qSqlhdd="SELECT * FROM master_asset_minimun_hard_disk_drive where is_active=1";
			$data['hdd_list'] = $this->Common_model->get_query_result_array($qSqlhdd);

			$qSqlram="SELECT * FROM master_asset_minimun_ram where is_active=1";
			$data['ram_list'] = $this->Common_model->get_query_result_array($qSqlram);

			$qSqldisplay="SELECT * FROM master_asset_system_screen_size where is_active=1";
			$data['display_list'] = $this->Common_model->get_query_result_array($qSqldisplay);


			if($id == 1){
				$data["content_template"] = "asset/purchse_request.php";
			}else{
				
				$data["content_template"] = "asset/show_purchse_requests.php";
			}
			
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 	


			
			$this->load->view('dashboard',$data);
								
        }
	}


	public function get_vendors(){
		$rqid = $this->input->post('rqst_id');
		$qSqldisplay="SELECT * FROM asset_purchase_requested_vendors where rqst_id=".$rqid."";
		$data= $this->Common_model->get_query_result_array($qSqldisplay);
		echo json_encode($data);
	}

	public function purchase(){
		if(check_logged_in())
        {
			$current_user = get_user_fusion_id();
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$data["aside_template"] = $this->aside;

			$data["content_template"] = "asset/purchase.php";
			
            $data["content_js"] = "asset_js.php";
            $data["error"] = ''; 	


			
			$this->load->view('dashboard',$data);
								
        }
	}


	public function get_cat_id(){

		$id = $this->input->post('pro_id');
		$qSql="SELECT distinct(cat_id) FROM master_asset_products where id=".$id."";
		$data = $this->Common_model->get_query_result_array($qSql);
		// print_r($data);
		// exit;
		$ans = array('status' => $data[0]['cat_id']);

		echo json_encode($ans);
	}


	public function adjust_rqst()
	{
		// print_r($_POST); exit();
		if(check_logged_in())
		{
			
			$rid = $this->input->post('rid');
			$rqid = $this->input->post('rqid');
			$name = $this->input->post('pro_id');
			$cat_id = $this->input->post('cat_id');
			$brand_id = $this->input->post('brand_id');
			$ram_id = $this->input->post('ram_id');
			$processor_id = $this->input->post('processor_id');
			$display_id = $this->input->post('display_id');
			$hdd_id = $this->input->post('hdd_id');
			$desc = $this->input->post('desc');
			$quant = $this->input->post('quant');
			$mouse = $this->input->post('mouse');
			$keybrd = $this->input->post('keybrd');
			$headset = $this->input->post('headset');
			// echo count($name); exit;
			if($name!=""){
				
				if(count($name)>1){
					$this->db->where('id',$rqid);
					$this->db->delete('asset_requested_items');
				}
				foreach ($name as $key => $value) {




					$qSql="SELECT * FROM asset_stock where product_category_id=".$cat_id[$key]."";
					if(!$quant[$key]== "") $qSql.=" and quantity > ".--$quant[$key]."";
					if(!$name[$key]== "") $qSql.=" and product_id=".$name[$key]."";
					if(!$processor_id[$key]== "" && !$processor_id[$key]== 0) $qSql.=" and processor=".$processor_id[$key]."";
					if(!$hdd_id[$key]== "" && !$hdd_id[$key]== 0) $qSql.=" and hard_disk=".$hdd_id[$key]."";
					if(!$display_id[$key]== "" && !$display_id[$key]== 0) $qSql.=" and display=".$display_id[$key]."";
					if(!$ram_id[$key]== "" && !$ram_id[$key]== 0) $qSql.=" and ram=".$ram_id[$key]."";
					// echo $qSql; 
					$query = $this->db->query($qSql);
					$data = $query->num_rows();
					if($data > 0){
						$ans = 1;
						if($mouse[$key]== "Yes") {
							$qSql1 ="SELECT * FROM asset_stock where product_category_id=2 and product_id = 5 and quantity > 0";
							$query = $this->db->query($qSql1);
							$data = $query->num_rows();
							if(!$data > 0){
								$ans = 3;
							}
						}
						if($headset[$key] == "USB" || $headset[$key] == "Analog") {
							$qSql1 ="SELECT * FROM asset_stock where product_category_id=2 and product_id = 2 and quantity > 0";
							$qSql1 .=" and headphone_type='".$headset[$key]."'";
							$query = $this->db->query($qSql1);
							$data = $query->num_rows();
							if(!$data > 0){
								$ans = 5;
							}
						}
						if($keybrd[$key]== "Yes") {
							$qSql2 ="SELECT * FROM asset_stock where product_category_id=2 and product_id = 4 and quantity > 0";
							$query = $this->db->query($qSql2);
							$data1 = $query->num_rows();
							if(!$data1 > 0){
								$ans = 4;
							}
						}
					}else{
						$ans = 0;
					}


					$field_array = array(
						"product_id" => $value,
						"product_category_id" => $cat_id[$key],
						"ram" => $ram_id[$key],
						"display" => $display_id[$key],
						"hard_disk" => $hdd_id[$key],
						"processor" => $processor_id[$key],
						"product_description" => $desc[$key],
						"quantity" => ++$quant[$key],
						"mouse_required" => $mouse[$key],
						"keyboard_required" => $keybrd[$key],
						"headset_required" => $headset[$key],
						"availablity" => $ans,
						"rqst_id" => $rid
					);
					if(count($name)>1){
						data_inserter('asset_requested_items',$field_array);
					}else{
						$this->db->where('id',$rqid);
						$this->db->update('asset_requested_items',$field_array);
					}
					
				}
				// exit;
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

	public function delivered_to_agent(){
		
		$log=get_logs();
		$rid = trim($this->input->post('riddlvr'));
		$rqid = trim($this->input->post('rqiddlvr'));
		$qty = trim($this->input->post('qty'));
		$dlvr_stat = trim($this->input->post('dlvr_stat'));
		$asset_sl_no = trim($this->input->post('asset_sl_no'));
		$mouse_sl_no = trim($this->input->post('mouse_sl_no'));
		$headset_sl_no = trim($this->input->post('headset_sl_no'));
		$keyboard_sl_no = trim($this->input->post('keyboard_sl_no'));
		$destination = trim($this->input->post('destination'));
		$cmnt = trim($this->input->post('cmnt'));
		if($dlvr_stat == ""){
			$dlvr_stat =4;
		}
			$field_array = array(
				"it_enginr_cmnt" => $cmnt,
				"log" => $log
			); 
		
		$this->db->where('id', $rid);
		$this->db->update('asset_request', $field_array);

		$field_array = array(
				"status" => $dlvr_stat
			); 
		
		$this->db->where('id', $rqid);
		$this->db->update('asset_requested_items', $field_array);


		$field_array = array(
			"asset_sl_no_it" => $asset_sl_no,
			"mouse_sl_no_it" => $mouse_sl_no,
			"headset_sl_no_it" => $headset_sl_no,
			"keyboard_sl_no_it" => $keyboard_sl_no,
			"rqsted_items_id" => $rqid
		);
		data_inserter('asset_serial_numbers',$field_array);

		if($this->db->affected_rows()>0){
			$ans = array('status' => "done");
		}else{
			$ans = array('status' => "error");
		}


		if($asset_sl_no != ""){
			$field_array = array(
				"asset_sl_no" => $asset_sl_no,
				"destination" => $destination,
				"rqst_id" => $rid
			);
			data_inserter('asset_destination',$field_array);
		}

		if($mouse_sl_no != ""){
			$field_array = array(
				"asset_sl_no" => $mouse_sl_no,
				"destination" => $destination,
				"rqst_id" => $rid
			);
			data_inserter('asset_destination',$field_array);
		}

		if($headset_sl_no != ""){
			$field_array = array(
				"asset_sl_no" => $headset_sl_no,
				"destination" => $destination,
				"rqst_id" => $rid
			);
			data_inserter('asset_destination',$field_array);
		}

		if($keyboard_sl_no != ""){
			$field_array = array(
				"asset_sl_no" => $keyboard_sl_no,
				"destination" => $destination,
				"rqst_id" => $rid
			);
			data_inserter('asset_destination',$field_array);
		}

		echo json_encode($ans);
	}


		public function conf_dlvry_stat(){
		
		$log=get_logs();
		$rid = trim($this->input->post('ridcnf'));
		$rqid = trim($this->input->post('rqidcnf'));
		$qty = trim($this->input->post('qty'));
		$conf_stat = trim($this->input->post('conf_stat'));
		$asset_sl_no = trim($this->input->post('asset_sl_no'));
		$mouse_sl_no = trim($this->input->post('mouse_sl_no'));
		$headset_sl_no = trim($this->input->post('headset_sl_no'));
		$keyboard_sl_no = trim($this->input->post('keyboard_sl_no'));
		if($conf_stat == 1){
			$field_array = array(
				"asset_sl_no_user" => $asset_sl_no,
				"mouse_sl_no_user" => $mouse_sl_no,
				"headset_sl_no_user" => $headset_sl_no,
				"keyboard_sl_no_user" => $keyboard_sl_no
			); 
		
			$this->db->where('rqsted_items_id', $rqid);
			$this->db->update('asset_serial_numbers', $field_array);


			$this->db->where("rqsted_items_id",$rqid);
			$query = $this->db->get("asset_serial_numbers");
			$data = $query->result_array();


			if($asset_sl_no != ""){
				if($data[0]['asset_sl_no_it'] == $data[0]['asset_sl_no_user'])
				{
					$qSql="UPDATE asset_stock SET quantity = quantity - ".$qty."";
					$qSql.=" WHERE serial_number = '".$asset_sl_no."'";
					$query = $this->db->query($qSql);
					$field_array = array(
						"status" => 13
					); 
			
					$this->db->where('id', $rqid);
					$this->db->update('asset_requested_items', $field_array);
				}else{
					$field_array = array(
						"status" => 12
					); 
			
					$this->db->where('id', $rqid);
					$this->db->update('asset_requested_items', $field_array);
				}
			}

			if($mouse_sl_no != ""){
				if($data[0]['mouse_sl_no_it'] == $data[0]['mouse_sl_no_user'])
				{
					$qSql="UPDATE asset_stock SET quantity = quantity - 1";
					$qSql.=" WHERE serial_number = '".$mouse_sl_no."'";
					$query = $this->db->query($qSql);
					$field_array = array(
						"status" => 13
					); 
			
					$this->db->where('id', $rqid);
					$this->db->update('asset_requested_items', $field_array);
				}else{
					$field_array = array(
						"status" => 12
					); 
			
					$this->db->where('id', $rqid);
					$this->db->update('asset_requested_items', $field_array);
				}
			}
			if($headset_sl_no != ""){
				if($data[0]['headset_sl_no_it'] == $data[0]['headset_sl_no_user'])
				{
					$qSql="UPDATE asset_stock SET quantity = quantity - 1";
					$qSql.=" WHERE serial_number = '".$headset_sl_no."'";
					$query = $this->db->query($qSql);
					$field_array = array(
						"status" => 13
					); 
			
					$this->db->where('id', $rqid);
					$this->db->update('asset_requested_items', $field_array);
				}else{
					$field_array = array(
						"status" => 12
					); 
			
					$this->db->where('id', $rqid);
					$this->db->update('asset_requested_items', $field_array);
				}
			}
			if($keyboard_sl_no != ""){
				if($data[0]['keyboard_sl_no_it'] == $data[0]['keyboard_sl_no_user'])
				{
					$qSql="UPDATE asset_stock SET quantity = quantity - 1";
					$qSql.=" WHERE serial_number = '".$keyboard_sl_no."'";
					$query = $this->db->query($qSql);
					$field_array = array(
						"status" => 13
					); 
			
					$this->db->where('id', $rqid);
					$this->db->update('asset_requested_items', $field_array);
				}else{
					$field_array = array(
						"status" => 12
					); 
			
					$this->db->where('id', $rqid);
					$this->db->update('asset_requested_items', $field_array);
				}
			}

		}
			

		$field_array = array(
				"user_delivery_confirmation" => $conf_stat
			); 
		
		$this->db->where('id', $rqid);
		$this->db->update('asset_requested_items', $field_array);
		if($this->db->affected_rows()>0){
			$ans = array('status' => "done");
		}else{
			$ans = array('status' => "error");
		}


		echo json_encode($ans);
	}


	public function upld_qote(){
		// print_r($_POST); exit;
		$infos = $this->input->post();
		$file_name = $this->upload_files($infos);
		// print_r($file_name);
		$vendor_name = $this->input->post('vendor_name');
		$vendor_price = $this->input->post('vendor_price');
		$rid = $this->input->post('ridq');
		$comment = $this->input->post('comnt');
		$error = 0;
		if(count($file_name)>0){
			$error = 1;
		}
		if($error == 1){
			foreach ($vendor_name as $key => $value) {
				$field_array = array(
					"vendor_name" => $vendor_name[$key],
					"vendor_price" => $vendor_price[$key],
					"file_name" => $file_name[$key],
					"rqst_id" => $rid,
					"comment" => $comment
				);
				data_inserter('asset_purchase_requested_vendors',$field_array);
			}
			$field_array = array(
				"status" => 4
			);

			$this->db->where('id',$rid);
			$this->db->update('asset_purchase_request',$field_array);

			$response = array('error'=>'no_error');
			echo json_encode($response);
		}else{
			$response = array('error'=>'file_error');
			echo json_encode($response);
		}
		
	}

	public function aprv_qote(){
		// print_r($_POST); exit;
		$vendor_name = $this->input->post('vndr');
		$comnt_vndr = $this->input->post('comnt_vndr');
		$rid = $this->input->post('ridq2');
		
			$field_array = array(
				"vendor_id" => $vendor_name,
				"comment" => $comnt_vndr,
				"rqst_id" => $rid
			);
			data_inserter('asset_purchase_approved_vendor',$field_array);

		$field_array = array(
			"status" => 5
		);

		$this->db->where('id',$rid);
		$this->db->update('asset_purchase_request',$field_array);
			
		$response = array('error'=>'no_error');
		echo json_encode($response);
		
		
	}



	public function upld_invoice(){
		// print_r($_POST); exit;
		$infos = $this->input->post();
		$file_name = $this->upload_file();
		// print_r($file_name);
		$rid = $this->input->post('ridInv');
		$error = 0;
		if($file_name!=""){
			$error = 1;
		}
		if($error == 1){
				$field_array = array(
					"invoice" => $file_name
				);
				$this->db->where("rqst_id",$rid);
				$this->db->update('asset_purchase_approved_vendor',$field_array);
		$field_array = array(
			"status" => 6
		);

		$this->db->where('id',$rid);
		$this->db->update('asset_purchase_request',$field_array);
			$response = array('error'=>'no_error');
			echo json_encode($response);
		}else{
			$response = array('error'=>'file_error');
			echo json_encode($response);
		}
		
	}



	private function upload_file()
	{
		// print_r($infos);
		// exit;
		$config['upload_path'] = './uploads/approved_invoice/';
		$config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
		$path       = $_FILES['invoice_file']['name'];
        $ext        = pathinfo($path, PATHINFO_EXTENSION);
		$config['file_name']      = "invoice.".$ext;
        $config['overwrite']      = 0;
        $config['max_size']       = 0;
        $config['max_width']      = 0;
        $config['max_height']     = 0;
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('invoice_file'))
		{
			return "";
		}
		else
		{
			return $this->upload->data('file_name');
		}
	}

	public function upload_files($infos)
    {

    	
        $config = array(
            'upload_path'   => './uploads/quotation/',
            'allowed_types' => 'doc|docx|pdf|jpg|jpeg|png',
            'overwrite'     => 1,                       
        );
        // $config['max_size']       = 0;
        // $config['max_width']      = 0;
        // $config['max_height']     = 0;

        $this->load->library('upload', $config);

        $images = array();

        foreach ($_FILES['vendor_file']['name'] as $key => $image) {
            $_FILES['images[]']['name']= $_FILES['vendor_file']['name'][$key];
            $_FILES['images[]']['type']= $_FILES['vendor_file']['type'][$key];
            $_FILES['images[]']['tmp_name']= $_FILES['vendor_file']['tmp_name'][$key];
            $_FILES['images[]']['error']= $_FILES['vendor_file']['error'][$key];
            $_FILES['images[]']['size']= $_FILES['vendor_file']['size'][$key];

            // $fileName = $title .'_'. $image;
            $path       = $_FILES['vendor_file']['name'][$key];
	        $ext        = pathinfo($path, PATHINFO_EXTENSION);
            $images[] = $infos['vendor_name'][$key]."_quotation.".$ext;

            
			$config['file_name']      = $infos['vendor_name'][$key]."_quotation.".$ext;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $this->upload->data();
            } else {
                return false;
            }
        }

        return $images;
    }

    public function get_invoice(){
    	$rid = $this->input->post('rid');
    	$this->db->where("rqst_id",$rid);
    	$query = $this->db->get('asset_purchase_approved_vendor');
    	$data = $query->result_array();
    	echo json_encode($data);
    }



	
}

?>